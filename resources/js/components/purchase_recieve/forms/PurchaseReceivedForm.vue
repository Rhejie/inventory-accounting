<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Purchase Order Form" prop="purchase_order_form_id">
                <el-select
                    v-model="form.purchase_order_form_id"
                    style="width: 100%"
                    filterable
                    remote
                    disabled
                    reserve-keyword
                    @change="changePOFormID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethodPOForms"
                    :loading="loadingForm">
                        <el-option
                            v-for="item in purchaseOrderForms"
                            :key="item.id"
                            :label="`${item.quote_reference_no} / ${item.material_reference_no} / ${item.purchase_order_reference_no}`"
                            :value="item.id">
                        </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Purchase Order Item" prop="purchase_order_form_item_id">
                <el-select
                    v-model="form.purchase_order_form_item_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    disabled
                    @change="changePOItemID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethodPOItems"
                    :loading="loadingItem">
                        <el-option
                            v-for="item in purchaseOrderItems"
                            :key="item.id"
                            :label="`${item.consumable_item.item} / ${item.unit} / ${item.unit_price}`"
                            :value="item.id">
                        </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Date Received" prop="date_received">
                <el-date-picker type="date" placeholder="Pick a Starting Date" v-model="form.date_received" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item label="Requested Quantity" >
                <el-input type="number" disabled placeholder="Received Quantity" v-model="form.quantity" style="width: 100%;"></el-input>
            </el-form-item>
            <el-form-item label="Received Quantity" prop="received_quantity">
                <el-input type="number" placeholder="Received Quantity" @change="receievdQuantity" v-model="form.received_quantity" style="width: 100%;"></el-input>
            </el-form-item>
            <el-form-item label="Remaining Quantity to Receive" prop="remaining_quantity_to_receive">
                <el-input type="number" v-loading="loadingRemaining" disabled placeholder="Remaining quantity to receive.." v-model="form.remaining_quantity_to_receive" style="width: 100%;"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                <el-button @click="resetForm('form')" :disabled="disableButton" v-if="mode != 'update'">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'PurchaseReceivedForm',
    props: {
        model: {},
        mode: null
    },
    data() {
        return {
            form: {
                purchase_order_form_id : '',
                purchase_order_form_item_id: '',
                date_received: '',
                received_quantity: '',
                remaining_quantity_to_receive: ''
            },
            rules: {
                purchase_order_form_id: [
                    {required: true, message: 'Please select Purchase Order', trigger: 'blur'}
                ],
                purchase_order_form_item_id: [
                    {required: true, message: 'Please select Purchase Item', trigger: 'blur'}
                ],
                date_received: [
                    {required: true, message: 'Please select date', trigger: 'blur'}
                ],
                received_quantity: [
                    {required: true, message: 'Please input Quantity', trigger: 'blur'}
                ],
                remaining_quantity_to_receive: [
                    {required: true, message: 'Please input Quantity to Received', trigger: 'blur'}
                ],
            },
            purchaseOrderForms: [],
            purchaseOrderItems: [],
            loadingForm: false,
            loadingItem: false,
            disableButton: false,
            hasSupplyData: {},
            receivedQuantity: {},
            loadingRemaining: false
        }
    },
    mounted() {
        this.hasSupplyData = {}
    },
    async created() {
        if(this.model && this.model.id) {
            this.form = {
                purchase_order_form_id : `${this.model.purchase_order_form.quote_reference_no} / ${this.model.purchase_order_form.material_reference_no} / ${this.model.purchase_order_form.purchase_order_reference_no}`,
                purchase_order_form_id_id : this.model.purchase_order_form_id,
                purchase_order_form_item_id : `${this.model.purchase_order_item.consumable_item.item} / ${this.model.purchase_order_item.unit} / ${this.model.purchase_order_item.unit_price}`,
                purchase_order_form_item_id_id : this.model.purchase_order_form_item_id,
                date_received : this.model.date_received,
                received_quantity: this.model.received_quantity,
                remaining_quantity_to_receive : this.model.remaining_quantity_to_receive,
                quantity : this.model.purchase_order_item.quantity,
                previous_received: this.model.received_quantity,
                project_id: this.model.purchase_order_form.project_id,
                item_name: this.model.purchase_order_item.consumable_item.item
            }
        }
        this.$EventDispatcher.listen('handleClosePR', data => {
            this.resetForm('form')
        })

        this.receivedQuantity = await this.getItemReceivedQuantity(this.model.purchase_order_form_item_id)
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updatePurchaseRecieved();
                    return
                }
                this.storePurchaseRecieved();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async storePurchaseRecieved() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.form.purchase_order_form_id)formData.append('purchase_order_form_id', this.form.purchase_order_form_id);
                if(this.form.purchase_order_form_item_id)formData.append('purchase_order_form_item_id', this.form.purchase_order_form_item_id);
                if(this.form.date_received)formData.append('date_received', this.$df.formatDate(this.form.date_received, "YYYY-MM-DD"));
                if(this.form.received_quantity)formData.append('received_quantity', this.form.received_quantity);
                if(this.form.remaining_quantity_to_receive)formData.append('remaining_quantity_to_receive', this.form.remaining_quantity_to_receive);

                const res = await this.$API.PurchaseReceived.storePurchaseRecieved(formData);
                this.$EventDispatcher.fire('ADD_NEW_PURCHASE_RECEIVED', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.resetForm('form');
                this.disableButton = false;
                this.purchaseOrderForms = []
                this.purchaseOrderItems = []
            } catch (error) {
                console.log(error);
            }
        },
        async getItemReceivedQuantity(id) {
            try {
                const res = await this.$API.PurchaseReceived.getItemReceivedQuantity(id);
                return res.data;
            } catch (error) {
                console.log(error);
            }
        },
        async updatePurchaseRecieved() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.form.purchase_order_form_id)formData.append('purchase_order_form_id', this.form.purchase_order_form_id);
                if(this.form.purchase_order_form_id_id)formData.append('purchase_order_form_id_id', this.form.purchase_order_form_id_id);
                if(this.form.purchase_order_form_item_id)formData.append('purchase_order_form_item_id', this.form.purchase_order_form_item_id);
                if(this.form.purchase_order_form_item_id_id)formData.append('purchase_order_form_item_id_id', this.form.purchase_order_form_item_id_id);
                if(this.form.date_received)formData.append('date_received', this.$df.formatDate(this.form.date_received, "YYYY-MM-DD"));
                if(this.form.received_quantity)formData.append('received_quantity', this.form.received_quantity);
                if(this.form.remaining_quantity_to_receive)formData.append('remaining_quantity_to_receive', this.form.remaining_quantity_to_receive);
                if(this.form.previous_received)formData.append('previous_received', this.form.previous_received);
                if(this.form.project_id)formData.append('project_id', this.form.project_id);
                if(this.form.item_name)formData.append('item_name', this.form.item_name);

                const res = await this.$API.PurchaseReceived.updatePurchaseReceived(this.model.id, formData);
                this.$EventDispatcher.fire('UPDATE_PURCHASE_RECEIVED', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.disableButton = false;
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
        changePOFormID(value) {
            if(this.model && this.model.id) {
                this.form.purchase_order_form_id_id = ''
                this.form.purchase_order_form_id = value
                this.form.purchase_order_form_item_id = null
                return;
            }
        },
        async remoteMethodPOItems(query) {
            if (query !== '') {
                this.loadingItem = true;
                try {
                    const res = await this.$API.PurchaseReceived.getPurchaseOrderFormItem(this.form.purchase_order_form_id, query);
                    this.purchaseOrderItems = res.data
                    this.loadingItem = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.purchaseOrderItems = [];
            }
        },
        changePOItemID(value) {
            if(this.model && this.model.id) {
                this.form.purchase_order_form_item_id_id = ''
                this.form.purchase_order_form_item_id = value
                return;
            }
        },
        async getPurchaseOrderItemsData(po_form_id, po_item_id) {
            try {
                const res = await this.$API.PurchaseReceived.getPurchaseItems(po_form_id,po_item_id);
                return res.data;
            } catch (error) {
                console.log(error);
            }
        },
        async getPurchaseOrderData(id) {
            try {
                const res = await this.$API.PurchaseReceived.gtePurchaseOrder(id);
                return res.data
            } catch (error) {
                console.log(error);
            }
        },
        async getHasSupply(project_id, comsumable_item) {
            try {
                const res = await this.$API.PurchaseReceived.getHasSupply(project_id, comsumable_item);
                this.hasSupplyData = res.data;
                return res.data
            } catch (error) {
                console.log(error);
            }
        },
        async receievdQuantity(value) {

            this.loadingRemaining = true;

            let checkReceievdQuantity = await this.getItemReceivedQuantityItem();

            if(checkReceievdQuantity.received_quantity) {
                let remaining = value;
                let quantity = parseInt(checkReceievdQuantity.received_quantity) - parseInt(this.form.previous_received);
                let totalRemaining = parseInt(this.form.quantity) - (parseInt(quantity) + parseInt(remaining));
                if(totalRemaining < 0) {
                    this.$message.error('Oops, received quantity is bigger than request quantity.');
                    this.loadingRemaining = false;
                    this.form.received_quantity = null
                    this.form.remaining_quantity_to_receive = null;
                    return
                }
                this.form.remaining_quantity_to_receive = totalRemaining;
                this.loadingRemaining = false;
                return
            }
        },
        async getItemReceivedQuantityItem() {
            try {
                const res = await this.$API.PurchaseReceived.getItemReceivedQuantityItem(this.form.purchase_order_form_item_id_id);
                return res.data;
            } catch (error) {
                console.log(error);
            }
        },
    },
    watch: {
        model(newVal, oldVal) {
            if(this.mode == 'update') {
                if(newVal != oldVal) {
                    this.form = {
                        purchase_order_form_id : `${newVal.purchase_order_form.quote_reference_no} / ${newVal.purchase_order_form.material_reference_no} / ${newVal.purchase_order_form.purchase_order_reference_no}`,
                        purchase_order_form_id_id : newVal.purchase_order_form_id,
                        purchase_order_form_item_id : `${newVal.purchase_order_item.consumable_item.item} / ${newVal.purchase_order_item.unit} / ${newVal.purchase_order_item.unit_price}`,
                        purchase_order_form_item_id_id : newVal.purchase_order_form_item_id,
                        date_received : newVal.date_received,
                        received_quantity: newVal.received_quantity,
                        remaining_quantity_to_receive : newVal.remaining_quantity_to_receive,
                        quantity : newVal.purchase_order_item.quantity,
                        previous_received: newVal.received_quantity,
                        project_id: newVal.purchase_order_form.project_id,
                        item_name: newVal.purchase_order_item.consumable_item.item
                    }
                }
            }
        },
        mode(val) {
            if(val != 'update') {
                this.form = {
                    purchase_order_form_id: '',
                    purchase_order_form_item_id: '',
                    date_received: '',
                    remaining_quantity_to_receive: '',
                    received_quantity: ''
                }
            }
        },
        // 'form.received_quantity'(newVal) {
        //     if(this.mode != 'update') {
        //         if(newVal ) {


        //             let order = []

        //             let item = this.purchaseOrderItems.filter(item => item.id == this.form.purchase_order_form_item_id)
        //             // order = this.purchaseOrderForms.filter(order => order.id == this.form.purchase_order_form_id);

        //             // if(order.length > 0) {
        //             //     this.getHasSupply(order[0].project_id, item[0].consumable_item.item);
        //             // }

        //             // if(this.hasSupplyData.id) {
        //             //     this.form.remaining_quantity_to_receive = item[0].quantity - this.hasSupplyData.stock_on_hand + newVal
        //             // }
        //             // else {
        //             //     this.form.remaining_quantity_to_receive = item[0].quantity - newVal
        //             // }
        //             this.form.remaining_quantity_to_receive = item[0].quantity - newVal
        //         }
        //     }
        //     else {
        //         if(newVal) {

        //         }
        //     }
        // },
        // 'form.purchase_order_form_item_id'(value) {
        //     if(value) {
        //         let item = this.purchaseOrderItems.filter(item => item.id == value)
        //         this.form.remaining_quantity_to_receive = item[0].quantity - this.form

        //     }
        // }
    }
}
</script>
