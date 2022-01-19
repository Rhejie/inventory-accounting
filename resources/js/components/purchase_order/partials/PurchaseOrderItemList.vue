<template>
    <div>
        <table class="table tabel-sm table-bordered" >
            <thead class="po_item_header_items">
                <th class="item_no_po">ITEM NO.</th>
                <th colspan="2">ITEM / SERVICE DESCRIPTION</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Unit Price</th>
                <th>Amount</th>
                <th style="width:140px; action_th" class="buttonPrint"></th>
            </thead>
            <tbody class="tbody_po" v-loading="loading">
                <tr class="po_item_data_item" v-for="(item, index) in poItemData" :key="index">
                    <td class="item_no_items">
                        {{index + 1}}
                    </td>
                    <td colspan="2">
                        <div v-if="!isEdit || index !== indexClickEdit">
                            {{item.consumable_item.item}}
                        </div>
                        <div v-if="indexClickEdit == index && isEdit">
                            <el-select
                                v-model="form.item_id"
                                style="width: 100%"
                                filterable
                                remote
                                reserve-keyword
                                @change="changeEditItemsID"
                                placeholder="Please enter a keyword"
                                :remote-method="remoteProjectMethod"
                                :loading="loadingItems">
                                <el-option
                                v-for="item in items"
                                :key="item.id"
                                :label="item.item"
                                :value="item.id">
                                </el-option>
                            </el-select>
                            <div class="invalid-feedback_item buttonPrint" v-if="errors.item_id  && indexClickEdit == index && isEdit">
                                The Item field is required
                            </div>
                        </div>
                    </td>
                    <td class="item_center_items">
                        <div v-if="!isEdit || index !== indexClickEdit">
                            {{item.quantity}}
                        </div>
                        <div v-if="indexClickEdit == index && isEdit">
                            <el-input type="number"  v-model="form.quantity" placeholder="Quantity..."></el-input>
                        </div>
                        <div class="invalid-feedback_item buttonPrint" v-if="errors.quantity && indexClickEdit == index && isEdit">
                            {{errors.quantity[0]}}
                        </div>
                    </td>
                    <td class="item_center_items">
                        <div v-if="!isEdit || index !== indexClickEdit">
                            {{item.unit}}
                        </div>
                        <div v-if="indexClickEdit == index && isEdit">
                            <el-input disabled v-model="form.unit" placeholder="Unit..."></el-input>
                        </div>
                    </td>
                    <td class="item_center_items">
                        <div v-if="!isEdit || index !== indexClickEdit">
                            {{item.unit_price}}
                        </div>
                        <div v-if="indexClickEdit == index && isEdit">
                            <el-input type="number" disabled  v-model="form.unit_price" placeholder="Unit Price..."></el-input>
                        </div>
                    </td>
                    <td class="item_center_items">
                        <div v-if="!isEdit || index !== indexClickEdit">
                            {{item.amount}}
                        </div>
                        <div v-if="indexClickEdit == index && isEdit">
                            <el-input type="number" v-model="form.amount" disabled placeholder="Amount..."></el-input>
                        </div>
                    </td>
                    <td class="button_center_item buttonPrint">
                        <div v-if="!isEdit">
                            <el-button size="mini" type="text" @click="handleEdit(index, item)"> Edit</el-button>
                            <el-button size="mini" type="text" @click="askToDelete(index, item)"> Delete</el-button>
                        </div>
                        <div v-if="indexClickEdit == index && isEdit">
                            <el-button size="mini" type="text" @click="handleUpdate()"> Save</el-button>
                            <el-button size="mini" type="text" @click="handleCancel"> Cancel</el-button>
                        </div>
                    </td>
                </tr>
                <tr class="fomr_table_po_item buttonPrint" v-show="!isEdit">
                    <td colspan="3">
                        <el-select
                            v-model="form.item_id"
                            style="width: 100%"
                            filterable
                            remote
                            reserve-keyword
                            @change="changeItemsID"
                            placeholder="Please enter a keyword"
                            :remote-method="remoteProjectMethod"
                            :loading="loadingItems">
                                <el-button size="mini" style="margin-left: 10px" icon="el-icon-plus" @click="addNewItem">Add New</el-button>
                                <el-option
                                    v-for="item in items"
                                    :key="item.id"
                                    :label="item.item"
                                    :value="item.id">
                                </el-option>
                            <template slot="empty">
                                <el-button  size="mini" style="margin:10px" icon="el-icon-plus" @click="addNewItem">Add New</el-button>
                            </template>
                        </el-select>
                        <div class="invalid-feedback_item buttonPrint" v-if="errors.item_id">
                            The Item field is required
                        </div>
                    </td>
                    <td>
                        <el-input type="number" :disabled="form.item_id ? false : true" v-model="form.quantity" placeholder="Quantity..."></el-input>
                        <div class="invalid-feedback_item buttonPrint" v-if="errors.quantity">
                            {{errors.quantity[0]}}
                        </div>
                    </td>
                    <td>
                        <el-input v-model="form.unit" :disabled="disableInput" placeholder="Unit..."></el-input>
                        <div class="invalid-feedback_item buttonPrint" v-if="errors.unit">
                            {{errors.unit[0]}}
                        </div>
                    </td>
                    <td>
                        <el-input type="number" v-model="form.unit_price" :disabled="disableInput" placeholder="Unit Price..."></el-input>
                        <div class="invalid-feedback_item buttonPrint" v-if="errors.unit_price">
                            {{errors.unit_price[0]}}
                        </div>
                    </td>
                    <td>
                        <el-input type="number" v-model="form.amount" disabled placeholder="Amount..."></el-input>
                        <div class="invalid-feedback_item buttonPrint" v-if="errors.amount">
                            {{errors.amount[0]}}
                        </div>
                    </td>
                    <td class="button_center_item">
                        <el-button type="primary" @click="addPOItem" class="buttonSubmit" :disabled="addProcess" size="mini">Add</el-button>
                        <el-button v-if="form.item_id" type="danger" class="buttonSubmit" @click="cancelSaveItem" :disabled="addProcess" icon="el-icon-close" size="mini"></el-button>
                    </td>
                </tr>
                <tr class="po_footer_items">
                    <td>
                        TERMS OF PAYMENT:
                    </td>
                    <td colspan="3">
                        <template v-if="doneEdit">
                            {{purchaseOrder.terms_of_payment}}
                        </template>
                        <template v-else>
                            <el-input v-model="purchaseOrder.terms_of_payment" type="text" placeholder="Terms of Payment..." size="mini"></el-input>
                            <div class="invalid-feedback_item buttonPrint" v-if="errors_purchase_order.terms_of_payment">
                                {{errors_purchase_order.terms_of_payment[0]}}
                            </div>
                        </template>
                    </td>
                    <td colspan="2">
                        SUB TOTAL
                    </td>
                    <td>
                        {{purchaseOrder.subtotal}}
                    </td>
                </tr>
                <tr class="po_footer_items">
                    <td>
                        MODE OF PAYMENT:
                    </td>
                    <td colspan="3">
                        <template v-if="doneEdit">
                            {{purchaseOrder.mode_of_payment}}
                        </template>
                        <template v-else>
                            <el-input v-model="purchaseOrder.mode_of_payment" type="text" placeholder="Mode of Payment..." size="mini"></el-input>
                            <div class="invalid-feedback_item buttonPrint" v-if="errors_purchase_order.mode_of_payment">
                                {{errors_purchase_order.mode_of_payment[0]}}
                            </div>
                        </template>
                    </td>
                    <td colspan="2">
                        VAT
                    </td>
                    <td @click="vat">
                        <el-popover
                            placement="top"
                            width="160"
                            v-model="visible">
                            <div style=" margin: 0">
                                <el-input type="number" @change="addVat" @keyup.enter.native="addVat" v-model="vatAmount"  placeholder="Vat..."></el-input>
                            </div>
                            <el-button type="text" slot="reference">{{purchaseOrder.vat | vatFilter}} ({{ vatTotal(purchaseOrder.vat) }})</el-button>
                        </el-popover>
                </td>
                </tr>
                <tr class="po_footer_items">
                    <td rowspan="3">
                        NOTES AND REMARKS:
                    </td>
                    <td rowspan="2" colspan="3">
                        <template v-if="doneEdit">
                            {{purchaseOrder.remarks}}
                        </template>
                        <template v-else>
                            <el-input type="textarea" v-model="purchaseOrder.remarks" placeholder="Notes and Remarks..." size="mini"></el-input>
                            <div class="invalid-feedback_item buttonPrint" v-if="errors_purchase_order.remarks">
                                {{errors_purchase_order.remarks[0]}}
                            </div>
                        </template>
                    </td>
                    <td colspan="2">
                        DISCOUNT
                    </td>
                    <td>
                        <el-popover
                            placement="top"
                            width="160"
                            v-model="visibleDiscount">
                            <div style=" margin: 0">
                                <el-input type="number" @change="addDiscount" @keyup.enter.native="addDiscount" v-model="discountAmount"  placeholder="Discount..."></el-input>
                            </div>
                            <el-button type="text" slot="reference">{{purchaseOrder.discount | discountFilter}}</el-button>
                        </el-popover>
                    </td>
                </tr>
                <tr class="po_footer_items">
                    <td colspan="2">SUBTOTAL NET</td>
                    <td>
                        {{purchaseOrder.subtotal_net | subtotal_netFilter}}
                    </td>
                </tr>
                <tr class="po_footer_items">
                    <td colspan="3"></td>
                    <td colspan="2">OTHERS</td>
                    <td>
                        <el-popover
                            placement="top"
                            width="160"
                            v-model="visibleOthers">
                            <div style=" margin: 0">
                                <el-input type="number" @change="addOthers" @keyup.enter.native="addOthers" v-model="othersAmount"  placeholder="Others..."></el-input>
                            </div>
                            <el-button type="text" slot="reference">{{purchaseOrder.others | othersFilter}}</el-button>
                        </el-popover>
                    </td>
                </tr>
                <tr class="po_footer_items">
                    <td colspan="4"></td>
                    <td colspan="3">
                        TOTAL NET
                        <div style="float:right">
                            <span>{{purchaseOrder.total_net}}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="po_footer_names_item">
            <div class="po_footer_left">
                <p class="po_footer_title">Prepared By:</p>
                <br/>
                <div class="po_footer_name">
                    <template v-if="doneEdit">
                        <p>{{purchaseOrder.prepared_by}}</p>
                    </template>
                    <template v-else>
                        <el-input type="text" style="margin-bottom: 10px" v-model="purchaseOrder.prepared_by" placeholder="Purchasing/Admin Staff..." size="mini"></el-input>
                        <div class="invalid-feedback_item buttonPrint" style="margin-bottom: 10px" v-if="errors_purchase_order.prepared_by">
                            {{errors_purchase_order.prepared_by[0]}}
                        </div>
                    </template>
                    <p>Purchasing/Admin Staff</p>
                </div>
                <br/>
                <p class="po_footer_title">Checked by By:</p>
                <br/>
                <div class="po_footer_name">

                    <template v-if="doneEdit">
                        <p>{{purchaseOrder.checked_by}}</p>
                    </template>
                    <template v-else>
                        <el-input type="text" style="margin-bottom: 10px" v-model="purchaseOrder.checked_by" placeholder="Accounting Staff..." size="mini"></el-input>
                        <div class="invalid-feedback_item buttonPrint" style="margin-bottom: 10px" v-if="errors_purchase_order.checked_by">
                            {{errors_purchase_order.checked_by[0]}}
                        </div>
                    </template>
                    <p>Accounting Staff</p>
                </div>
            </div>
            <div class="po_footer_right">
                <p class="po_footer_title">Noted By:</p>
                <br/>
                <div class="po_footer_name">

                    <template v-if="doneEdit">
                        <p>{{purchaseOrder.noted_by}}</p>
                    </template>
                    <template v-else>
                        <el-input type="text" style="margin-bottom: 10px" v-model="purchaseOrder.noted_by" placeholder="Finance/Admin Manager..." size="mini"></el-input>
                        <div class="invalid-feedback_item buttonPrint" style="margin-bottom: 10px" v-if="errors_purchase_order.noted_by">
                            {{errors_purchase_order.noted_by[0]}}
                        </div>
                    </template>
                    <p>Finance/Admin Manager</p>
                </div>
                <br/>

                <p class="po_footer_title">Approved by By:</p>
                <br/>
                <div class="po_footer_name">

                    <template v-if="doneEdit">
                        <p>{{purchaseOrder.approved_by}}</p>
                    </template>
                    <template v-else>
                        <el-input type="text" style="margin-bottom: 10px" v-model="purchaseOrder.approved_by" placeholder="General Manager..." size="mini"></el-input>
                        <div class="invalid-feedback_item buttonPrint" style="margin-bottom: 10px" v-if="errors_purchase_order.approved_by">
                            {{errors_purchase_order.approved_by[0]}}
                        </div>
                    </template>
                    <p>General Manager</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'PurchaseOrderItemList',
    mixins: [paginate],
    props: {
        id: null,
        supplierId: null,
        purchaseOrder: {},
        supplier_id: null,
        errors_purchase_order: [],
        doneEdit: true
    },
    data() {
        return {
            poItemData: [],
            items: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            dialogFormVisible: false,
            loadingItems: false,
            visible: false,
            visibleDiscount: false,
            visibleOthers: false,
            model: {},
            mode: '',
            form : {
                item_id: '',
                description: '',
                quantity: '',
                unit: '',
                unit_price: '',
                amount: '',
            },
            disableInput: true,
            addProcess: false,
            editData: {},
            isEdit: false,
            showVat: true,
            vatAmount: null,
            discountAmount: null,
            othersAmount: null,
            indexClickEdit: '',
            errors: [],
            allowToCreate: false,
            newItem: ''
        }
    },
    created() {
        this.getPurchaseOrderItems();

        this.$EventDispatcher.listen('NEW_ORDER_ITEM', data => {
            this.poItemData.unshift(data)
        });

        this.$EventDispatcher.listen('UPDATE_ORDER_ITEM', data => {
            this.poItemData.forEach(item => {
                if(item.id == data.id) {
                    for(let key in data) {
                        item[key] = data[key]
                    }
                }
            });
            this.dialogFormVisible = false
            this.mode = ''
        });

        // this.$EventDispatcher.listen('doneEdit', data => {
        //     this.doneEdit = !this.doneEdit
        // })
    },
    methods: {
        async getPurchaseOrderItems() {
            this.loading = true;
            try {
                const res = await this.$API.PurchaseOrder.getOrderItems(this.id);
                this.poItemData = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        async addPOItem() {
            this.addProcess = true
            try {
                // let formData = new FormData();
                // if(this.form.item_id)formData.append('item_id', this.form.item_id);
                // if(this.form.description)formData.append('description', this.form.description);
                // if(this.form.quantity)formData.append('quantity', this.form.quantity);
                // if(this.form.unit)formData.append('unit', this.form.unit);
                // if(this.form.unit_price)formData.append('unit_price', this.form.unit_price);
                // if(this.form.amount)formData.append('amount', this.form.amount);

                const res = await this.$API.PurchaseOrder.storeOrderItem(this.id, this.supplier_id, this.form);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });

                this.disableInput = true

                this.poItemData.push(res.data.po_item)
                this.purchaseOrder.vat = res.data.vat;
                this.purchaseOrder.subtotal = res.data.subtotal;
                this.purchaseOrder.subtotal_net = res.data.subtotal_net;
                this.purchaseOrder.discount = res.data.discount;
                this.purchaseOrder.total_net = res.data.total_net;
                this.purchaseOrder.others = res.data.others;


                this.form = {
                    id: null,
                    item_id: null,
                    description: null,
                    quantity: null,
                    unit: null,
                    unit_price: null,
                    amount: null,
                }
                this.addProcess = false
                this.errors = []
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;

                    default:
                        alert('Contact the administrator')
                        break;
                }
                this.addProcess = false;
            }
        },
        cancelSaveItem() {
            this.form = {
                id: null,
                item_id: null,
                description: null,
                quantity: null,
                unit: null,
                unit_price: null,
                amount: null,
            }
            this.addProcess = false
            this.errors = []
        },
        handleEdit(index, data) {
            this.disableInput = true
            this.form = {
                id: data.id,
                item_id : data.consumable_item.item,
                item_id_id : data.item_id,
                quantity : data.quantity,
                unit: data.unit,
                unit_price : data.unit_price,
                amount: data.amount,
            }
            this.isEdit = !this.isEdit
            this.indexClickEdit = index
        },
        vat() {

        },
        addNewItem() {
            if(this.newItem) {
                this.form = {
                    amount: '',
                    description: '',
                    item_id: this.newItem,
                    quantity: '',
                    unit: '',
                    unit_price: '',
                }
            }
        },
        async addVat() {
            try {
                const res = await this.$API.PurchaseOrder.addVat(this.id, this.vatAmount);
                console.log(res.data);
                this.purchaseOrder.vat = res.data.vat;
                this.purchaseOrder.subtotal = res.data.subtotal;
                this.purchaseOrder.subtotal_net = res.data.subtotal_net;
                this.purchaseOrder.discount = res.data.discount;
                this.purchaseOrder.total_net = res.data.total_net;
                this.purchaseOrder.others = res.data.others;
                this.visible = !this.visible
            } catch (error) {
                console.log(error);
            }
        },
        async addDiscount() {
            try {
                const res = await this.$API.PurchaseOrder.addDiscount(this.id, this.discountAmount);
                this.purchaseOrder.vat = res.data.vat;
                this.purchaseOrder.subtotal = res.data.subtotal;
                this.purchaseOrder.subtotal_net = res.data.subtotal_net;
                this.purchaseOrder.discount = res.data.discount;
                this.purchaseOrder.total_net = res.data.total_net;
                this.purchaseOrder.others = res.data.others;
                this.visibleDiscount = !this.visibleDiscount
            } catch (error) {
                console.log(error);
            }
        },
        async addOthers() {
            try {
                const res = await this.$API.PurchaseOrder.addOthers(this.id, this.othersAmount);
                this.purchaseOrder.vat = res.data.vat;
                this.purchaseOrder.subtotal = res.data.subtotal;
                this.purchaseOrder.subtotal_net = res.data.subtotal_net;
                this.purchaseOrder.discount = res.data.discount;
                this.purchaseOrder.total_net = res.data.total_net;
                this.purchaseOrder.others = res.data.others;
                this.visibleOthers = !this.visibleOthers
            } catch (error) {
                console.log(error);
            }
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteOrderItem(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteOrderItem(index, data) {
            try {
                const res = await this.$API.PurchaseOrder.deleteOrderItem(data.id, this.id);
                this.purchaseOrder.vat = res.data.vat;
                this.purchaseOrder.subtotal = res.data.subtotal;
                this.purchaseOrder.subtotal_net = res.data.subtotal_net;
                this.purchaseOrder.discount = res.data.discount;
                this.purchaseOrder.total_net = res.data.total_net;
                this.purchaseOrder.others = res.data.others;
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.poItemData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        async handleUpdate() {
            try {
                const res = await this.$API.PurchaseOrder.updateOrderItem(this.form.id, this.form);

                this.purchaseOrder.vat = res.data.vat;
                this.purchaseOrder.subtotal = res.data.subtotal;
                this.purchaseOrder.subtotal_net = res.data.subtotal_net;
                this.purchaseOrder.discount = res.data.discount;
                this.purchaseOrder.total_net = res.data.total_net;
                this.purchaseOrder.others = res.data.others;
                this.poItemData.forEach((item) => {
                    if(item.id == res.data.po_item.id) {
                        for(let key in res.data.po_item) {
                            item[key] = res.data.po_item[key]
                        }
                    }
                })
                this.isEdit = !this.isEdit
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });

                this.form = {
                    id: null,
                    item_id: null,
                    description: null,
                    quantity: null,
                    unit: null,
                    unit_price: null,
                    amount: null,
                }
                this.errors = []

            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;

                    default:
                        alert('Contact the administrator')
                        break;
                }
                this.addProcess = false;
            }
        },
        handleCancel() {
            this.isEdit = !this.isEdit;
            this.form.item_id = null
            this.form.id = null
            this.form_item_id_id = null
            this.form.quantity = null
            this.form.unit_price = null
            this.form.unit = null
            this.form.amount = null
        },
        async remoteProjectMethod(query) {
            this.newItem = query
            if (query !== '') {
                try {
                    const res = await this.$API.PurchaseOrder.getSupplierItems(this.supplier_id, query);
                    this.items = res.data
                    this.loadingItems = false
                } catch (error) {
                    console.log(error);
                }
            } else {

                this.projects = [];
            }
        },
        vatTotal(value) {
            if(value) {
                return (value / 100) * this.purchaseOrder.subtotal;
            }
            return 0;
        },
        changeItemsID(value) {

        },
        changeEditItemsID(value) {
            if(this.form.id) {
                this.disableInput = true;
                this.form.item_id_id = null;
                return value
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getPurchaseOrderItems();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getPurchaseOrderItems();
        },
        applySearch() {
            this.getPurchaseOrderItems();
        },
    },
    computed: {
        // amount() {
        //     let quantity = this.form.quantity ? this.form.quantity : 0;
        //     this.form.amount = quantity * this.form.unit_price;
        // }
    },
    filters: {
        vatFilter(value) {
            if(!value){
                return "0"
            }
            return value + "%"
        },
        discountFilter(value) {
            if(!value) return "0"
            return value;
        },
        subtotal_netFilter(value) {
            if(!value) return "0"
            return value;
        },
        othersFilter(value) {
            if(!value) return "0"
            return value;
        }
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getPurchaseOrderItems();
            }
        },
        items(val) {
            if(val.length == 0) {
                this.allowToCreate = true;
            }
        },
        'form.item_id'(value) {
            if(typeof value == 'number') {
                let item = this.items.filter((item) => item.id == value);
                this.form.unit = item[0].unit
                this.form.unit_price = item[0].unit_price
                this.disableInput = true
            }
            else {
                this.disableInput = false;
            }
        },
        'form.quantity'(val) {
            if(typeof val != 'undefined' ) {
                this.form.amount = val * this.form.unit_price
            }
            else {
                this.form.amount = 0 * form.unit_price
            }
        },
        'form.unit_price'(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form.amount = this.form.quantity * newVal
            }
        }
    }
}
</script>
<style lang="scss" scoped>
    .fomr_table_po_item td {
        padding: 10px
    }
    .po_item_header_items th {
        text-align: center;
    }
    .po_footer_items  td {
        padding: 5px
    }
    .item_no_items{
        text-align: center;
    }
    .po_item_data_item td{
        padding: 2px
    }
    .item_center_items {
        text-align: center;
    }
    .po_item_header_items th {
        border-style: solid;
        border-color: #000;
        border-width: 2px;
    }
    .tbody_po {
        border-style: solid;
        border-color: #000;
        border-width: 2px;
    }
    .po_item_data_item td {
        border-style: solid;
        border-color: #000;
        border-width: 1px;
    }
    .button_center_item{
        text-align: center;
    }

    .invalid-feedback_item{
        display: inline !important;
        color: red;
        font-size: 10px;
    }

    .po_footer_names_item {

        .po_footer_left {
            float: left;
            text-align: left;

            .po_footer_title {
                font-weight: 600;
            }
        }

        .po_footer_right {
            float: right;

            .po_footer_title {
                font-weight: 600;
            }
        }

        .po_footer_name {
            border-top-style: solid;
            padding-top: 5px;
            border-top-width: 1px;
            border-top-color: #000;
        }
        .buttonSubmit{
            padding: 0 !important;
        }
    }
</style>
