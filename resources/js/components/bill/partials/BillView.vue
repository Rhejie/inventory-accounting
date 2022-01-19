<template>
    <div v-loading="loadingBill">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{bill.bill_number}}</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->


                </div>
                <!--end::Details-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Button-->
                    <a href="" class=""></a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <!--end::Button-->
                    <!--begin::Dropdown-->

                    <!--end::Dropdown-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Profile 2-->
                <div class="d-flex flex-row">
                    <!--begin::Aside-->
                    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
                        <!--begin::Card-->
                        <div class="card card-custom" v-loading="loadingBill">
                            <!--begin::Body-->
                            <div class="card-body pt-15">
                                <!--begin::User-->
                                <div class="text-center mb-10">
                                    <div class="symbol symbol-60 symbol-circle symbol-xl-90">
                                        <div class="symbol-label" style="background-image:url('/img/user_customer.png')"></div>
                                        <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                                    </div>
                                    <h4 class="font-weight-bold my-2">{{bill.supplier.name}}</h4>
                                    <div class="text-muted mb-2">Supplier</div>
                                </div>
                                <!--end::User-->
                                <!--begin::Contact-->
                                <div class="mb-10 text-center">
                                    <p>{{bill.supplier.email}}</p>
                                    <p>{{bill.supplier.contact_no}}</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <el-descriptions class="margin-top" title="Bill To" :column="1">
                                            <el-descriptions-item label="Name">{{bill.supplier.billing_name}}</el-descriptions-item>
                                            <el-descriptions-item label="Phone">{{bill.supplier.billing_phone}}</el-descriptions-item>
                                            <el-descriptions-item label="Country">{{bill.supplier.billing_country}}</el-descriptions-item>
                                            <el-descriptions-item label="State">{{bill.supplier.billing_state}}</el-descriptions-item>
                                            <el-descriptions-item label="City">{{bill.supplier.billing_city}}</el-descriptions-item>
                                            <el-descriptions-item label="Zip">{{bill.supplier.billing_zip}}</el-descriptions-item>
                                        </el-descriptions>
                                    </div>
                                    <div class="col-md-12">
                                        <el-descriptions class="margin-top" title="Ship To" :column="1">
                                            <el-descriptions-item label="Name">{{bill.supplier.shipping_name}}</el-descriptions-item>
                                            <el-descriptions-item label="Phone">{{bill.supplier.shipping_phone}}</el-descriptions-item>
                                            <el-descriptions-item label="Country">{{bill.supplier.shipping_country}}</el-descriptions-item>
                                            <el-descriptions-item label="State">{{bill.supplier.shipping_state}}</el-descriptions-item>
                                            <el-descriptions-item label="City">{{bill.supplier.shipping_city}}</el-descriptions-item>
                                            <el-descriptions-item label="Zip">{{bill.supplier.shipping_zip}}</el-descriptions-item>
                                        </el-descriptions>
                                    </div>
                                    <div class="col-md-12">
                                        <attachment-file-list :id="id" :type="'bill'"></attachment-file-list>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>


                        <!--end::Card-->
                    </div>
                    <div class="flex-row-fluid ml-lg-8" v-loading="loadingBill">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::List Widget 10-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0">
                                        <h3 class="card-title font-weight-bolder text-dark">BILL DETAILS</h3>
                                        <div class="card-toolbar">
                                            <el-button type="success" class="float:right" @click="edit" size="mini">Edit</el-button>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="timeline timeline-5">
                                                    <div class="timeline-items">
                                                        <!--begin::Item-->
                                                        <div class="timeline-item">
                                                            <!--begin::Icon-->
                                                            <div class="timeline-media bg-light-primary">
                                                                <i class="far fa-calendar-alt"></i>
                                                            </div>
                                                            <!--end::Icon-->

                                                            <!--begin::Info-->
                                                            <div class="timeline-desc timeline-desc-light-primary">
                                                                <span class="font-weight-bolder text-primary">Create Bill</span>
                                                                <p class="font-weight-normal text-dark-50 pb-2">
                                                                    <i class="far fa-clock"></i> Created on {{bill.created_at}}
                                                                </p>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Item-->

                                                        <!--begin::Item-->
                                                        <!--<div class="timeline-item">
                                                            <div class="timeline-media bg-light-warning">
                                                                <i class="far fa-envelope"></i>
                                                            </div>
                                                            <div class="timeline-desc timeline-desc-light-warning">
                                                                <span class="font-weight-bolder text-warning">Send Bill</span>
                                                                <p class="font-weight-normal text-dark-50 pt-1 pb-2">
                                                                    <i class="far fa-clock"></i> Sent on {{bill.send_date | sendDate}}
                                                                </p>
                                                                <button v-if="bill.send_date ? false : true"  @click="sendBill" :disabled="isSending" style="float:right; margin-top: -40px" class="btn btn-text-dark-50 btn-icon-primary">
                                                                    <i class="far fa-paper-plane"></i>
                                                                </button>
                                                            </div>
                                                        </div> -->
                                                        <!--end::Item-->

                                                        <!--begin::Item-->
                                                        <div class="timeline-item">
                                                            <!--begin::Icon-->
                                                            <div class="timeline-media bg-light-success">
                                                                <i class="fas fa-money-bill-alt"></i>
                                                            </div>
                                                            <!--end::Icon-->

                                                            <!--begin::Info-->
                                                            <div class="timeline-desc timeline-desc-light-success">
                                                                <span class="font-weight-bolder text-success">Get Paid</span>
                                                                <p class="font-weight-normal text-dark-50 pt-1 pb-2" v-if="bill.status == 'Paid'">
                                                                    Paid
                                                                </p>
                                                                <p class="font-weight-normal text-dark-50 pt-1 pb-2" v-else>
                                                                    Awaiting Payment
                                                                </p>
                                                                <button v-if="bill.status != 'Paid'"  @click="addReceipt" style="float:right; margin-top: -40px" class="btn btn-primary font-weight-bold btn-pill btn-sm">
                                                                    <i class="fas fa-plus"></i> Add Payment
                                                                </button>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Item-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end: Item-->
                                    </div>
                                    <!--end: Card Body-->
                                </div>
                                <!--end: Card-->
                                <!--end: List Widget 10-->
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-12">
                                <div class="invoice_actions">
                                    <button class="btn btn-primary font-weight-bold btn-pill btn-sm" @click="addNote">Add Debit Note</button>
                                    <!--<button class="btn btn-info font-weight-bold btn-pill btn-sm" :disabled="isSending" @click="sendBill">Resend Bill</button> -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::List Widget 10-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0">
                                        <h3 class="card-title font-weight-bolder text-dark">BILL</h3>

                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <el-descriptions class="margin-top" :column="4">
                                                    <el-descriptions-item label="Bill Date">{{bill.bill_date}}</el-descriptions-item>
                                                    <el-descriptions-item label="Due Date">{{bill.due_date}}</el-descriptions-item>
                                                    <el-descriptions-item label="Bill Number">{{bill.bill_number}}</el-descriptions-item>
                                                    <el-descriptions-item label="Project">{{bill.project_name}}</el-descriptions-item>
                                                    <el-descriptions-item label="Customer">{{bill.customer_name}}</el-descriptions-item>
                                                    <el-descriptions-item label="Status">
                                                        <el-tag effect="dark" v-if="bill.status == 'Sent'" type="warning">{{bill.status}}</el-tag>
                                                        <el-tag effect="dark" v-if="bill.status == 'Draft'" type="info">{{bill.status}}</el-tag>
                                                        <el-tag effect="dark" v-if="bill.status == 'Paid'" type="success">{{bill.status}}</el-tag>
                                                        <el-tag effect="dark" v-if="bill.status == 'Partaily Paid'" type="primary">{{bill.status}}</el-tag>
                                                        <el-tag effect="dark" v-if="bill.status == 'Due'" type="danger">{{bill.status}}</el-tag>
                                                    </el-descriptions-item>
                                                </el-descriptions>
                                            </div>
                                        </div>
                                        <!--end: Item-->
                                    </div>
                                    <!--end: Card Body-->
                                </div>
                                <!--end: Card-->
                                <!--end: List Widget 10-->
                            </div>
                        </div>

                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">PURCHASE ORDER LIST</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-0">
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center " id="kt_advance_table_widget_2" v-loading="loadingPurchaseOrder">
                                        <thead class="text-uppercase">
                                            <th class="pl-0">NO.</th>
                                            <th class="pl-0">REF. NO</th>
                                            <th class="pl-0">PROJECT</th>
                                            <th class="pl-0">SUBTOTAL</th>
                                            <th class="pl-0">VAT</th>
                                            <th class="pl-0">DISCOUNT</th>
                                            <th class="pl-0">SUBTOTAL NET</th>
                                            <th class="pl-0">OTHERS</th>
                                            <th class="pl-0">AMOUNT</th>
                                            <th class="pl-0">ATTACHMENT</th>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(order, index) in bill_items" :key="index" class="service_list">
                                                <td>{{index + 1}}</td>
                                                <td>{{order.purchase_order_number}}</td>
                                                <td>{{order.project.name}}</td>
                                                <td>{{order.subtotal | addComma}}</td>
                                                <td>{{order.vat}}% ({{order | taxRate}})</td>
                                                <td>{{order.discount | addComma}}</td>
                                                <td>{{order.subtotal_net | addComma}}</td>
                                                <td>{{order.others | addComma}}</td>
                                                <td>{{order.amount | addComma}}</td>
                                                <td>
                                                    <el-button slot="trigger" size="small" type="primary" @click="addFile(order)">Add Attachment</el-button>
                                                    <el-button slot="trigger" size="small" type="success" @click="viewAttachment(order)">View</el-button>
                                                </td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Subtotal</td>
                                                <td colspan="9">{{subtotal | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Discount</td>
                                                <td colspan="9">{{discount | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Tax</td>
                                                <td colspan="9">{{tax | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Subtotal Net</td>
                                                <td colspan="9">{{subtotal_net | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Others</td>
                                                <td colspan="9">{{others | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Paid</td>
                                                <td colspan="9">{{paid | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Debit Note</td>
                                                <td colspan="9">{{debit_note | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Due</td>
                                                <td colspan="9">{{total | addComma}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Body-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">PAYMENT SUMMARY</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <bill-payment-summary :id="id"></bill-payment-summary>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Body-->
            </div>

            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">DEBIT NOTE SUMMARY</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <bill-debit-note-list :id="id"></bill-debit-note-list>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Body-->
            </div>
        </div>
        <el-dialog title="Add Debit Note" width="45%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <debit-note-form :mode="mode" :formBill="true" :due-amount="total" :bill="bill"></debit-note-form>
        </el-dialog>

        <el-dialog title="Add Bill Payment" width="45%" :visible.sync="dialogFormVisiblePayment" :before-close="handleClosePayment">
            <bill-payment-form :mode="mode" :id="id"></bill-payment-form>
        </el-dialog>


        <el-dialog title="Add Attachment" width="40%" :visible.sync="dialogFormVisibleAttachment" :before-close="handeCloseAttachment">
            <attachment-form :attachment-id="bill_item_id" :type="type"></attachment-form>
        </el-dialog>

        <el-dialog title="Attachments" width="65%" :visible.sync="dialogFormVisibleAttachmentList" :before-close="handeCloseAttachment">
            <attachment-list :attachment-id="bill_item_id" :type="type"></attachment-list>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'BillView',
    props: {
        id: null,
        model: {}
    },
    data() {
        return {
            bill: {},
            loadingBill : false,
            bill_items: [],
            loadingPurchaseOrder: false,
            dialogFormVisible: false,
            mode: '',
            dialogFormVisiblePayment: false,
            dialogFormVisibleAttachment: false,
            dialogFormVisibleAttachmentList: false,
            bill_item_id: '',
            type: '',
            model_table: '',
            isSending:false,
        }
    },
    created() {
        if(this.model && this.model.id) {
            if(!this.model.project) {
                this.model.project_name = ' - '
            }
            else {
                this.model.project_name = this.model.project.name
            }
            if(!this.model.customer) {
                this.model.customer_name = ' - '
            }
            else {
                this.model.customer_name = this.model.customer.name
            }
            this.bill = this.model
            this.getBillItems();
        }
        else {

            this.getBillById();

        }

        this.$EventDispatcher.listen('NEW_NOTE', data => {
            this.bill.total_debit += data.amount;
            this.dialogFormVisible = false
        })

        this.$EventDispatcher.listen('NEW_DEBIT_NOTE_AMOUNT', data => {
            this.bill.total_debit -= data.prevAmount;
            this.bill.total_debit += data.newAmount;
            this.dialogFormVisible = false
        })

        this.$EventDispatcher.listen('DELETE_NOTE' , data => {
            this.bill.total_debit -= data.data.amount
        })
        this.$EventDispatcher.listen('NEW_PAYMENT', data => {
            this.dialogFormVisiblePayment = false
            this.bill.total_paid += data.amount
        })

        this.$EventDispatcher.listen('DELETE_PAYMENT', data => {
            this.bill.total_paid -= data
        })
        this.$EventDispatcher.listen('NEW_ATTACHMENT', data => {
            this.dialogFormVisibleAttachment = false
        })
    },
    filters: {
        sendDate(value) {
            if(!value) return 'Not Yet'
            return value
        },
        addComma(value) {
            if(value) {
                return 'P '+ value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            return '0.00'
        },
        taxRate(value) {
            if(value) {
                let tax = value.vat / 100
                let rate = value.subtotal * tax
                return 'P ' + rate.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
    },
    computed: {
        subtotal() {
            if(this.bill_items) {
                let total = 0
                this.bill_items.forEach(order => {
                    total += order.subtotal
                })

                return parseFloat(total).toFixed(2)
            }
        },
        discount() {
            if(this.bill_items) {
                let total = 0
                this.bill_items.forEach(order => {
                    total += order.discount
                })

                return parseFloat(total).toFixed(2)
            }
        },
        tax() {
            let taxes = [] = this.bill_items.map(order => {
                let total = 0
                let subtotal = 0
                let tax = 0
                if(order.subtotal) {
                    tax = parseFloat(order.vat) / 100
                    subtotal = parseFloat(order.subtotal) * tax
                    total+=subtotal
                }
                return total
            })

            let total = 0
            if(taxes.length > 0) {
                taxes.forEach(tax => {
                    if(tax) {
                        total+=parseFloat(tax)
                    }
                })
            }

            return parseFloat(total).toFixed(2)
        },
        others() {
            if(this.bill_items) {
                let total = 0
                this.bill_items.forEach(order => {
                    total += order.others
                })

                return parseFloat(total).toFixed(2)
            }
        },
        subtotal_net() {
            if(this.bill_items) {
                let total = 0
                this.bill_items.forEach(order => {
                    total += order.subtotal_net
                })

                return parseFloat(total).toFixed(2)
            }
        },
        paid: {
            get() {
                return parseFloat(this.bill.total_paid).toFixed(2)
            }
        },
        debit_note: {
            get() {
                return parseFloat(this.bill.total_debit).toFixed(2)
            }
            // if(this.bill) {
            //     return parseFloat(this.bill.total_debit).toFixed(2)
            // }
        },
        total() {
            if(this.bill_items) {
                let total = 0
                this.bill_items.forEach(order => {
                    total += order.amount
                })

                total -= this.debit_note
                total -= this.paid

                return parseFloat(total).toFixed(2)
            }
        }
    },
    methods: {
        async getBillById() {
            try {
                this.loadingBill = true;
                const res = await this.$API.Bill.viewBill(this.id)
                if(!res.data.project) {
                    res.data.project_name = ' - '
                }
                else {
                    res.data.project_name = res.data.project.name
                }
                if(!res.data.customer) {
                    res.data.customer_name = ' - '
                }
                else {
                    res.data.customer_name = res.data.customer.name
                }
                this.bill = res.data
                this.getBillItems();
                this.loadingBill = false
            } catch (error) {
                console.log(error);
            }
        },
        async getBillItems() {
            try {
                this.loadingPurchaseOrder = true;
                const res = await this.$API.Bill.getBillItems(this.id);
                this.bill_items = res.data
                this.loadingPurchaseOrder = false
            } catch (error) {
                console.log(error);
            }
        },
        edit() {
            this.$router.push({name: 'Bill Update', params: {id: this.id, mode: 'update', model: this.bill } });
        },
        async sendBill() {
            try {
                this.isSending = true;
                const res = await this.$API.Bill.sendBill(this.id)
                this.isSending = false;
                this.bill.send_date = res.data
                this.$notify({
                    title: 'Success',
                    message: 'Send Successfully',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        addFile(order) {
            this.dialogFormVisibleAttachment = true
            console.log(order);
            this.bill_item_id = order.id
            this.type = 'bill_item'
        },
        viewAttachment(order) {
            this.dialogFormVisibleAttachmentList = true
            this.type = 'bill_item'
            this.bill_item_id = order.id
        },
        handeCloseAttachment(done) {
            this.$EventDispatcher.fire('CLOSE_ATTACHMENT_FORM')
            done();
        },
        addNote() {
            this.dialogFormVisible = true;
            this.mode = 'create'
        },
        handleClose(done) {
            this.mode = '';
            this.$EventDispatcher.fire('CLOSE_DEBIT_NOTE');
            done();
        },
        handleClosePayment(done) {
            this.mode = '';
            this.$EventDispatcher.fire('CLOSE_BILL_PAYMENT');
            done();
        },
        addReceipt() {
            this.dialogFormVisiblePayment = true;
            this.mode = 'create'
        }
    },
}
</script>
