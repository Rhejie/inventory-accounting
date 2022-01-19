<template>
    <div v-loading="loading">
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                    <el-card class="box-card purchase_order_wrapper" shadow="never" id="printMe">
                        <div class="text item">
                            <div class="buttonsPO">
                                <a @click="Edit" v-if="doneEdit" :disabled="loading" class="btn btn-success btn-sm buttonPrint">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a @click="cancelButton" v-show="!doneEdit"  class="btn btn-danger btn-sm buttonPrint">
                                    <i class="far fa-times-circle"></i> Cancel
                                </a>
                                <a @click="SavePurchaseOrder" v-show="!doneEdit"  class="btn btn-primary btn-sm buttonPrint">
                                    <i class="far fa-save"></i> Save
                                </a>
                                <a @click="print" v-if="doneEdit" class="btn btn-secondary btn-sm buttonPrint">
                                    <i class="fas fa-print"></i> Print
                                </a>
                                <a @click="viewTransactions" v-if="doneEdit" class="btn btn-secondary btn-sm buttonPrint">
                                    <i class="far fa-list-alt"></i> Transactions
                                </a>
                            </div>
                            <div class="po_header">
                                <img :src="`/img/logo.png`" class="po_logo_img" alt="">
                                <div style="float:right; padding:10px" class="po_company_info">
                                    <p class="po_company_name">ASDEC BUILDERS CORPORATION</p>
                                    <p class="po_company_address">225 BANLAT ROAD TANDANG SORA, QUEZON CITY</p>
                                    <p class="po_company_contact">TEL NO. 3455-5115 * TELEFAX NO. 7000-9800 * CEL NOS. (Sun) 0925-864-5310 (Globe) 09661430147</p>
                                    <p >EMAIL ADD: <span class="po_company_email">asdec_mae@yahoo.com</span> * <span class="po_company_email">asdecbuilders@yahoo.com</span></p>
                                </div>
                            </div>
                            <span class="PO_TITLE">PURCHASE ORDER</span>
                            <el-descriptions :column="2" >
                                <el-descriptions-item label="SUPPLIER"  label-class-name="my-label">
                                    {{purchaseOrder.supplier.name}}
                                </el-descriptions-item>
                                <el-descriptions-item  label="ADDRESS" label-class-name="my-label">
                                    {{purchaseOrder.address}}
                                </el-descriptions-item>
                                <el-descriptions-item label="CONTACT PERSON" label-class-name="my-label">
                                    {{purchaseOrder.contact_person}}
                                </el-descriptions-item>
                                <el-descriptions-item label="QUOTE REF NO" label-class-name="my-label">
                                    <template v-if="doneEdit">
                                        {{purchaseOrder.quote_reference_no}}
                                    </template>
                                    <template v-else>
                                        <el-input v-model="purchaseOrder.quote_reference_no" placeholder="Quote Reference No..." type="text" size="mini"></el-input>
                                        <div class="invalid-feedback_item buttonPrint" v-if="errors.quote_reference_no">
                                            {{errors.quote_reference_no[0]}}
                                        </div>
                                    </template>
                                </el-descriptions-item>
                                <el-descriptions-item label="MRS REF NO" label-class-name="my-label">
                                    <template v-if=" doneEdit">
                                        {{purchaseOrder.material_reference_no}}
                                    </template>
                                    <template v-else>
                                        <el-input v-model="purchaseOrder.material_reference_no" type="text" placeholder="Material Reference No..." size="mini"></el-input>
                                        <div class="invalid-feedback_item buttonPrint" v-if="errors.material_reference_no">
                                            {{errors.material_reference_no[0]}}
                                        </div>
                                    </template>
                                </el-descriptions-item>
                                <el-descriptions-item label="DATE NEEDED" label-class-name="my-label">
                                    <template v-if="doneEdit">
                                        {{purchaseOrder.date_needed}}
                                    </template>
                                    <template v-else>
                                        <el-date-picker type="date" placeholder="Pick a Starting Date" v-model="purchaseOrder.date_needed" style="width: 100%;"></el-date-picker>
                                        <div class="invalid-feedback_item buttonPrint" v-if="errors.date_needed">
                                            {{errors.date_needed[0]}}
                                        </div>
                                    </template>
                                </el-descriptions-item>
                                <el-descriptions-item label="PO REFERENCE NO" label-class-name="my-label">{{purchaseOrder.purchase_order_reference_no}}</el-descriptions-item>
                                <el-descriptions-item  label="PO DATE" label-class-name="my-label">
                                    {{purchaseOrder.push_order_date}}
                                </el-descriptions-item>
                                <el-descriptions-item label="PROJECT" label-class-name="my-label">{{purchaseOrder.project.name}}</el-descriptions-item>
                                <el-descriptions-item label="LOCATION" label-class-name="my-label">
                                    {{purchaseOrder.location}}
                                </el-descriptions-item>
                                <el-descriptions-item  label="REQUESTED BY" label-class-name="my-label">
                                    <template v-if="doneEdit">
                                        {{purchaseOrder.requested_by}}
                                    </template>
                                    <template v-else>
                                        <el-input v-model="purchaseOrder.requested_by" type="text" placeholder="Requested By..." size="mini"></el-input>
                                        <div class="invalid-feedback_item buttonPrint" v-if="errors.requested_by">
                                            {{errors.requested_by[0]}}
                                        </div>
                                    </template>
                                </el-descriptions-item>
                                <el-descriptions-item  label="SIGNATURE/DATE" label-class-name="my-label">

                                </el-descriptions-item>
                                <!--el-descriptions-item  label="Date Created" label-class-name="my-label">
                                    {{purchaseOrder.date_created}}
                                </!--el-descriptions-item -->
                            </el-descriptions>
                        </div>

                        <div class="po_item">
                            <purchase-order-item-list :id="id" :errors_purchase_order="errors" :doneEdit="doneEdit" :supplier_id="purchaseOrder.supplier_id" :purchase-order="purchaseOrder"></purchase-order-item-list>
                        </div>
                    </el-card>
                        <div class="buttonsPOFooter">
                            <a @click="Edit" :class="doneEdit ? 'btn btn-success btn-sm buttonPrint' : 'btn btn-danger btn-sm buttonPrint'">
                                <i class="fas fa-edit"></i> {{doneEdit | isCancel}}
                            </a>
                            <a @click="SavePurchaseOrder" v-show="!doneEdit"  class="btn btn-primary btn-sm buttonPrint">
                                <i class="fas fa-print"></i> Save
                            </a>
                            <a @click="print" v-if="doneEdit" class="btn btn-secondary btn-sm buttonPrint">
                                <i class="fas fa-print"></i> Print
                            </a>
                        </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <el-dialog title="Add Order Item" width="35%" :visible.sync="dialogFormVisible">
            <purchase-order-item-form :mode="mode" :id="id" :supplier_id="supplier_id"></purchase-order-item-form>
        </el-dialog>
        <el-dialog title="Transactions"  :visible.sync="dialogTableVisibleTransactions">
            <purchase-order-transactions :purchaseOrder="purchaseOrder"></purchase-order-transactions>
        </el-dialog>
    </div>
</template>
<script>

export default {
    name: 'PurchaseOrderView',
    props: {
        id: null,
        data: {},
        supplier_id: null
    },
    data() {
        return{
            purchaseOrder: {},
            loading: true,
            dialogFormVisible: false,
            mode: '',
            doneEdit: true,
            clonedPO: {},
            errors: [],
            status: '',
            dialogTableVisibleTransactions: false,
        }
    },
    created() {
        this.getPurchaseOrder()
        if(!this.data) {
            this.getPurchaseOrder()
        }
        else {
            this.purchaseOrder = this.data
            this.loading = false
        }

        this.$EventDispatcher.listen('NEW_ORDER_ITEM', data => {
            this.dialogFormVisible = false;
            this.mode = ''
        });
    },
    methods: {
        async getPurchaseOrder() {
            try {
                this.loading = true
                const res = await this.$API.PurchaseOrder.getPurchaseOrderData(this.id);
                this.purchaseOrder = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        async SavePurchaseOrder() {
            try {
                this.purchaseOrder.push_order_date = this.$df.formatDate(this.purchaseOrder.push_order_date, "YYYY-MM-DD");
                this.purchaseOrder.date_needed = this.$df.formatDate(this.purchaseOrder.date_needed, 'YYYY-MM-DD')
                const res = await this.$API.PurchaseOrder.updateOrderInView(this.purchaseOrder.id, this.purchaseOrder)
                this.purchaseOrder = res.data;
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.doneEdit = !this.doneEdit;
                this.$EventDispatcher.fire('doneEdit');
                this.errors = []
                this.status = 'save'
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;

                    default:
                        alert('Contact the administrator')
                        break;
                }
            }
        },
        getAttributeIsEmpty(){
            let order = !Object.values(this.purchaseOrder).some(item => item == null || item == '');
            this.doneEdit = order
        },
        addItem() {
            this.mode = 'create',
            this.dialogFormVisible = true;

        },
        async print() {
            // Pass the element id here
            await this.$htmlToPaper('printMe');
        },
        viewTransactions() {
            this.dialogTableVisibleTransactions = !this.dialogTableVisibleTransactions
        },
        async Edit() {
            this.clonedPO = {...this.purchaseOrder}
            this.doneEdit  = !this.doneEdit;
            this.errors = []
        },
        cancelButton() {
            this.loading = true;
            this.purchaseOrder = this.clonedPO
            this.$message('You Canceled Update .');
            this.$EventDispatcher.fire('doneEdit', this.clonedPO);
            this.doneEdit  = !this.doneEdit;
            this.status = 'cancel'
            // this.getPurchaseOrder()
            this.loading = false;
        }
    },
    filters: {
        isCancel(value) {
            if(value) {
                return 'Edit'
            }
            return 'Cancel'
        }
    },
    watch: {
        purchaseOrder(newVal, oldVal) {
            if(newVal != oldVal) {
                if(this.status == 'cancel') {
                    this.purchaseOrder = newVal;
                    return
                }
            }
        }
    }
}
</script>
<style lang="scss" scoped>
    .my-label {
        font-weight: 600 !important;
    }
    .PO_TITLE {
        font-weight: 600;
        font-size: 37px;
    }
    .purchase_order_wrapper{
        padding: 30px;
    }

    .po_logo_img{

        width:350px;
        height:100%

    }

    .po_company_info{
        text-align: right;
        line-height: 0.8;

        .po_company_name {
            font-weight: 700;
            font-size: 30px;
        }

        .po_company_address {
            font-size: 15px;
        }

        .po_company_email {
            color: blue;
        }
    }

    .buttonsPO{
        width: 100%;
        height: 40px;
        justify-content: right;

        .buttonPOList{
            float: right
        }
    }
    .buttonsPOFooter{
        width: 100%;
        height: 40px;
        margin-top: 10px;

        .buttonPOList{
            float: right
        }

    }

    .invalid-feedback_item{
        display: inline !important;
        color: red;
        font-size: 10px;
    }
</style>
