<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Date Received" prop="date_received">
                <el-date-picker type="date" placeholder="Pick a Received Date" v-model="form.date_received"></el-date-picker>
            </el-form-item>
            <el-form-item label="Purchase Order Form" prop="purchase_order_form_id">
                <el-select
                    v-model="form.purchase_order_form_id"
                    style="width: 50%"
                    filterable
                    remote
                    reserve-keyword
                    :disabled="disableFormId"
                    clearable
                    @change="changePOFormID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethodPOForms"
                    :loading="loadingForm">
                        <el-option
                            v-for="item in purchaseOrderForms"
                            :key="item.id"
                            :label="`${item.purchase_order_reference_no}`"
                            :value="item.id">
                        </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Purchase Order Item" >
                <el-table
                    :data="purchaseReceivedItems"
                    border
                    v-loading="loadingItems"
                    style="width: 100%">
                        <el-table-column
                            prop="consumable_item.item"
                            label="Item"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="consumable_item.unit"
                            label="Unit"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="quantity"
                            label="Request Quantity"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="received_quantity_data"
                            width="200"
                            label="Previous Received"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.received_quantity_data | filterReceived}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Quantity to Received"
                            :sortable="true">
                                <template slot-scope="scope">
                                    <el-input :disabled="scope.row.received_quantity_data == scope.row.quantity ? true : false" :max="scope.row.quantity" :min="0" v-model="scope.row.received_quantity" type="number" @change="receivedQuantity($event, scope.row, scope.$index)" placeholder="Received Quantity..."></el-input>
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Remaining Quantity"
                            :sortable="true">
                                <template slot-scope="scope">
                                    <el-input disabled v-model="scope.row.remaining_quantity_to_receive" type="number" v-loading="loadingRemaining && index == scope.$index" placeholder="Remaining Quantity Received..."></el-input>
                                </template>
                        </el-table-column>
                        <el-table-column
                            width="180"
                            fixed="right"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="danger"
                                @click="handleRemove(scope.$index, scope.row)">Remove</el-button>
                            </template>
                        </el-table-column>
                </el-table>
            </el-form-item>
            <el-form-item>
                <div style="float:right">
                    <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                    <el-button @click="resetForm('form')" v-if="mode != 'addItem'" :disabled="disableButton">Reset</el-button>
                </div>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'PurchaseReceivedMultipleForm',
    props: {
        details: {},
        mode: null
    },
    data() {
        return {
            loadingForm: false,
            purchaseOrderForms: [],
            disableButton: false,
            purchaseReceivedItems: [],
            loadingItems: false,
            loadingItem: false,
            purchaseOrderItems: [],
            form: {
                purchase_order_form_id: '',
                date_received: '',
                receivedItems: []
            },
            rules: {
                purchase_order_form_id: [
                    {required: true, message: 'Please select Purchase Order', trigger: 'blur'}
                ],
                date_received: [
                    {required: true, message: 'Please select date', trigger: 'blur'}
                ],
            },
            disableFormId: false,
            loadingRemaining: false,
            index: null
        }
    },
    created() {
        if(this.details && this.details.purchase_order_form_id && this.mode == 'addItem') {
            this.disableFormId = true;
            this.form = {
                purchase_order_form_id : `${this.details.purchase_order_form.purchase_order_reference_no}`,
                purchase_order_form_id_id : this.details.purchase_order_form_id
            }
        }
        this.changePOFormID(this.details.purchase_order_form_id);

        this.$EventDispatcher.listen('handleClosePR', data => {
            this.purchaseReceivedItems = []
        });
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'addItem') {
                    this.storeItem();
                    return
                }
                this.storePurchaseRecieved();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        async storePurchaseRecieved() {
            this.disableButton = true;
            try {
                this.form.date_received = this.$df.formatDate(this.form.date_received, "YYYY-MM-DD")
                this.purchaseReceivedItems.forEach(item => {
                    let resultQuantity = 'received_quantity' in item
                    let resultRemaining = 'remaining_quantity_to_receive' in item
                    let prevQuantity = item.received_quantity_data ? item.received_quantity_data : 0
                    if(!resultQuantity) {
                        item.received_quantity = null
                    }
                    if(!resultRemaining) {
                        if(item.received_quantity != null) {
                            item.remaining_quantity_to_receive = item.quantity - (parseInt(prevQuantity) + parseInt(item.received_quantity))
                        }
                        else {
                            item.remaining_quantity_to_receive = null
                        }
                    }
                });
                this.form.receivedItems = this.purchaseReceivedItems;



                const res = await this.$API.PurchaseReceived.storePurchaseRecieved(this.form);
                this.$EventDispatcher.fire('ADD_NEW_PURCHASE_RECEIVED', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.disableButton = false;
                this.purchaseOrderForms = []
                this.purchaseOrderItems = []

                this.$router.push({
                    name: 'Purchase Received View',
                    params: {id : res.data.purchase_order_form_id, data : res.data}
                })
            } catch (error) {
                console.log(error);
            }
        },
        async storeItem() {
            this.disableButton = true;
            try {
                this.form.date_received = this.$df.formatDate(this.form.date_received, "YYYY-MM-DD")
                this.purchaseReceivedItems.forEach(item => {
                    let resultQuantity = 'received_quantity' in item
                    let resultRemaining = 'remaining_quantity_to_receive' in item
                    let prevQuantity = item.received_quantity_data ? item.received_quantity_data : 0

                    if(!resultQuantity) {
                        item.received_quantity = null
                    }
                    if(!resultRemaining) {
                        if(item.received_quantity != null) {
                            item.remaining_quantity_to_receive = item.quantity - (parseInt(prevQuantity) + parseInt(item.received_quantity))
                        }
                        else {
                            item.remaining_quantity_to_receive = null
                        }
                    }
                });
                this.form.receivedItems = this.purchaseReceivedItems;
                this.form.purchase_order_form_id = this.form.purchase_order_form_id_id

                const res = await this.$API.PurchaseReceived.storeItem(this.form);
                this.$EventDispatcher.fire('ADD_NEW_ITEM_PURCHASE_RECEIVED', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.disableButton = false;
                this.purchaseOrderForms = []
                this.purchaseOrderItems = []

            } catch (error) {
                console.log(error);
            }
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.form.receivedItems = []
            this.purchaseReceivedItems = []
        },
        async changePOFormID(value) {
            let data = {
                id: value
            }
            this.loadingItems = true
            let receivedItem = await this.getItemReceivedQuantity(data);
            try {
                const res = await this.$API.PurchaseOrder.getOrderItems(value);
                this.purchaseReceivedItems = res.data;
                this.purchaseReceivedItems.forEach(item => {
                    receivedItem.forEach(r_item => {
                        if(item.id == r_item.purchase_order_form_item_id) {
                            item.received_quantity_data = r_item.received_quantity
                        }
                    });
                });
                this.loadingItems = false

            } catch (error) {
                console.log(error);
            }

        },
        async changePOItemID(value) {
            let data = {
                id: value
            }
            let receivedItem = await this.getItemReceivedQuantity(data);

            let item = this.purchaseOrderItems.filter(item => item.id == value);
            item[0].received_quantity_data = receivedItem.received_quantity
            this.purchaseReceivedItems.push(item[0])
            this.form.purchase_order_form_item_id = null
            this.purchaseOrderItems = []
        },
        handleRemove(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.purchaseReceivedItems.splice(index, 1);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async receivedQuantity(e, data, index) {
            if(!e) {
                this.purchaseReceivedItems[index].remaining_quantity_to_receive = '';
                return

            }

            this.loadingRemaining = true;
            this.index = index;

            let checkReceievdQuantity = await this.getItemReceivedQuantityItem(data);
            console.log(checkReceievdQuantity);


            if(checkReceievdQuantity.received_quantity) {

                let remaining = data.quantity - (parseInt(data.received_quantity) + parseInt(checkReceievdQuantity.received_quantity));
                if(remaining < 0) {
                    this.$message.error('Oops, received quantity is bigger than request quantity.');
                    this.loadingRemaining = false;
                    data.received_quantity = null
                    this.purchaseReceivedItems[index].remaining_quantity_to_receive = null;
                    return
                }
                this.purchaseReceivedItems[index].remaining_quantity_to_receive = remaining;
                this.loadingRemaining = false;

                return;

            }

            let remaining = data.quantity - data.received_quantity;
            if(remaining < 0) {
                this.$message.error('Oops, received quantity is bigger than request quantity.');
                this.loadingRemaining = false;
                data.received_quantity = null
                this.purchaseReceivedItems[index].remaining_quantity_to_receive = null;
                return
            }

            this.purchaseReceivedItems[index].remaining_quantity_to_receive = remaining;
            this.loadingRemaining = false;


        },
        async getItemReceivedQuantity(data) {
            try {
                const res = await this.$API.PurchaseReceived.getItemReceivedQuantity(data.id);
                return res.data;
            } catch (error) {
                console.log(error);
            }
        },
        async getItemReceivedQuantityItem(data) {
            try {
                const res = await this.$API.PurchaseReceived.getItemReceivedQuantityItem(data.id);
                return res.data;
            } catch (error) {
                console.log(error);
            }
        },
        async remoteMethodPOForms(query) {
            if (query !== '') {
                this.loadingForm = true;
                try {
                    const res = await this.$API.PurchaseReceived.getPurchaseOrderForms(query);
                    this.purchaseOrderForms = res.data
                    this.loadingForm = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.purchaseOrderForms = [];
            }
        },
        async remoteMethodPOItems(query) {
            let po_id = null
            if(this.form.purchase_order_form_id_id) {
                po_id = this.form.purchase_order_form_id_id
            } else {
                po_id = this.form.purchase_order_form_id
            }
            if (query !== '') {
                this.loadingItem = true;
                try {
                    const res = await this.$API.PurchaseReceived.getPurchaseOrderFormItem(po_id, query);
                    this.purchaseOrderItems = res.data
                    this.loadingItem = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.purchaseOrderItems = [];
            }
        },
    },
    filters: {
        filterReceived(value) {
            if(!value) {
                return 0;
            }
            return value
        }
    },
    watch: {
        mode(val) {
            if(val != 'addItem') {
                this.form = {
                    purchase_order_form_id : '',
                    date_received: '',
                    receivedItems: []
                }
                this.changePOFormID(this.details.purchase_order_form_id);
            }
            else {
                this.form = {
                    purchase_order_form_id : `${this.details.purchase_order_form.purchase_order_reference_no}`,
                    purchase_order_form_id_id : this.details.purchase_order_form_id
                }
                this.changePOFormID(this.details.purchase_order_form_id);
            }

        },
        details(newVal, oldVal) {
            if(this.mode == 'addItem') {
                if(newVal != oldVal) {
                    this.form = {
                        purchase_order_form_id : `${newVal.purchase_order_form.purchase_order_reference_no} / ${newVal.purchase_order_form.material_reference_no} / ${newVal.purchase_order_form.quote_reference_no}`,
                        purchase_order_form_id_id : newVal.purchase_order_form_id
                    }
                    this.changePOFormID(this.details.purchase_order_form_id);
                }
                else {
                    this.form = {
                        purchase_order_form_id : `${this.details.purchase_order_form.purchase_order_reference_no} / ${this.details.purchase_order_form.material_reference_no} / ${this.details.purchase_order_form.quote_reference_no}`,
                        purchase_order_form_id_id : this.details.purchase_order_form_id
                    }
                    this.changePOFormID(this.details.purchase_order_form_id);
                }
            }
        }
    }
}
</script>
