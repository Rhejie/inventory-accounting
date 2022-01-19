<template>
    <div>
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{invoice.ref_number}} </h5>
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
                        <div class="card card-custom" v-loading="loadingCustomer">
                            <!--begin::Body-->
                            <div class="card-body pt-15">
                                <!--begin::User-->
                                <div class="text-center mb-10">
                                    <div class="symbol symbol-60 symbol-circle symbol-xl-90">
                                        <div class="symbol-label" style="background-image:url('/img/user_customer.png')"></div>
                                        <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                                    </div>
                                    <h4 class="font-weight-bold my-2">{{customer.name}}</h4>
                                    <div class="text-muted mb-2">Customer</div>
                                </div>
                                <!--end::User-->
                                <!--begin::Contact-->
                                <div class="mb-10 text-center">
                                    <p>{{customer.email}}</p>
                                    <p>{{customer.contact}}</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <el-descriptions class="margin-top" title="Bill To" :column="1">
                                            <el-descriptions-item label="Name">{{customer.billing_name}}</el-descriptions-item>
                                            <el-descriptions-item label="Phone">{{customer.billing_phone}}</el-descriptions-item>
                                            <el-descriptions-item label="Country">{{customer.billing_country}}</el-descriptions-item>
                                            <el-descriptions-item label="State">{{customer.billing_state}}</el-descriptions-item>
                                            <el-descriptions-item label="City">{{customer.billing_city}}</el-descriptions-item>
                                            <el-descriptions-item label="Zip">{{customer.billing_zip}}</el-descriptions-item>
                                        </el-descriptions>
                                    </div>
                                    <div class="col-md-12">
                                        <el-descriptions class="margin-top" title="Ship To" :column="1">
                                            <el-descriptions-item label="Name">{{customer.shipping_name}}</el-descriptions-item>
                                            <el-descriptions-item label="Phone">{{customer.shipping_phone}}</el-descriptions-item>
                                            <el-descriptions-item label="Country">{{customer.shipping_country}}</el-descriptions-item>
                                            <el-descriptions-item label="State">{{customer.shipping_state}}</el-descriptions-item>
                                            <el-descriptions-item label="City">{{customer.shipping_city}}</el-descriptions-item>
                                            <el-descriptions-item label="Zip">{{customer.shipping_zip}}</el-descriptions-item>
                                        </el-descriptions>
                                    </div>
                                    <div class="col-md-12">
                                        <attachment-file-list :id="id" :type="'invoice'"></attachment-file-list>
                                    </div>
                                </div>
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid ml-lg-8" v-loading="loadingProposal">
                        <!--begin::Row-->
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::List Widget 10-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0">
                                        <h3 class="card-title font-weight-bolder text-dark">INVOICE DETAILS</h3>
                                        <div class="card-toolbar">
                                            <el-button  class="float:right" @click="edit" size="mini">Edit</el-button>
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
                                                                <span class="font-weight-bolder text-primary">Create Invoice</span>
                                                                <p class="font-weight-normal text-dark-50 pb-2">
                                                                    <i class="far fa-clock"></i> Created on {{invoice.created_at}}
                                                                </p>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
                                                        <!--end::Item-->

                                                        <!--begin::Item-->
                                                        <div class="timeline-item">
                                                            <!--begin::Icon-->
                                                            <div class="timeline-media bg-light-warning">
                                                                <i class="far fa-envelope"></i>
                                                            </div>
                                                            <!--end::Icon-->

                                                            <!--begin::Info-->
                                                            <div class="timeline-desc timeline-desc-light-warning">
                                                                <span class="font-weight-bolder text-warning">Send Invoice</span>
                                                                <p class="font-weight-normal text-dark-50 pt-1 pb-2">
                                                                    <i class="far fa-clock"></i> Sent on {{invoice.send_date | sendDate}}
                                                                </p>
                                                                <el-button v-if="invoice.send_date ? false : true" :disabled="isSending"  @click="sendInvoice" style="float:right; margin-top: -40px">
                                                                    Send
                                                                </el-button>
                                                            </div>
                                                            <!--end::Info-->
                                                        </div>
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
                                                                <p class="font-weight-normal text-dark-50 pt-1 pb-2" v-if="invoice.status == 'Paid'">
                                                                    Paid
                                                                </p>
                                                                <p class="font-weight-normal text-dark-50 pt-1 pb-2" v-else>
                                                                    Awaiting Payment
                                                                </p>
                                                                <el-button v-if="invoice.send_date && invoice.status != 'Paid'" @click="addReceipt" style="float:right; margin-top: -40px">
                                                                    <i class="fas fa-plus"></i> Add Receipt
                                                                </el-button>
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
                                    <el-button v-if="invoice.send_date ? true : false" @click="addNote">Add Credit Note</el-button>
                                    <el-button :loading="isSending" v-if="invoice.send_date ? true : false" :disabled="isSending" @click="sendInvoice">Resend Invoice</el-button>
                                    <a type="button" class="el-button el-button--default el-button--small" :href="`/invoice/download-invoice/${id}`" target="_blank">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::List Widget 10-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0">
                                        <h3 class="card-title font-weight-bolder text-dark">INVOICE</h3>

                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <el-descriptions class="margin-top" :column="4">
                                                    <el-descriptions-item label="Issue Date">{{invoice.issue_date}}</el-descriptions-item>
                                                    <el-descriptions-item label="Due Date">{{invoice.due_date}}</el-descriptions-item>
                                                    <el-descriptions-item label="Project">{{invoice.project_id}}</el-descriptions-item>
                                                    <el-descriptions-item label="Invoice Number">{{invoice.ref_number}}</el-descriptions-item>
                                                    <el-descriptions-item label="Status">
                                                        <el-tag effect="dark" v-if="invoice.status == 'Sent'" type="warning">{{invoice.status}}</el-tag>
                                                        <el-tag effect="dark" v-if="invoice.status == 'Draft'" type="info">{{invoice.status}}</el-tag>
                                                        <el-tag effect="dark" v-if="invoice.status == 'Paid'" type="success">{{invoice.status}}</el-tag>
                                                        <el-tag effect="dark" v-if="invoice.status == 'Partaily Paid'" type="primary">{{invoice.status}}</el-tag>
                                                        <el-tag effect="dark" v-if="invoice.status == 'Due'" type="danger">{{invoice.status}}</el-tag>
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


                        <!--end::Row-->
                        <!--begin::Advance Table Widget 5-->
                        <div class="card card-custom gutter-b">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label font-weight-bolder text-dark">SERVICES</span>
                                </h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body py-0">
                                <!--begin::Table-->
                                <div class="table-responsive">
                                    <table class="table table-head-custom table-vertical-center" id="kt_advance_table_widget_2">
                                        <thead>
                                            <tr class="text-uppercase">
                                                <th class="pl-0" style="width: 40px">
                                                    No.
                                                </th>
                                                <th>Service</th>
                                                <th>Service Fee</th>
                                                <th>Quantity</th>
                                                <th>Tax</th>
                                                <th>Unit</th>
                                                <th>Discount</th>
                                                <th>Amount</th>
                                                <th>Attachment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(service, index) in invoice.services" :key="service.id">
                                                <td class="pl-0 py-6">
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{index + 1}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{service.name}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{service.service_fee | addComma}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{service.quantity}}</span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        <template v-if="service.tax">
                                                            {{service.tax}}%  ( {{service | taxRate}} )
                                                        </template>
                                                        <template v-else>
                                                            -
                                                        </template>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        <template v-if="service.unit">
                                                            {{service.unit}}
                                                        </template>
                                                        <template v-else>
                                                            -
                                                        </template>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">
                                                        <template v-if="service.discount">
                                                            {{service.discount | addComma}}
                                                        </template>
                                                        <template v-else>
                                                            -
                                                        </template>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-dark-75 font-weight-bolder d-block font-size-lg">{{service.amount | addComma}}</span>
                                                </td>
                                                <td>
                                                    <el-button slot="trigger" type="text" size="small" @click="addFile(service)">Add</el-button>
                                                    <el-button slot="trigger" type="text" size="small" @click="viewAttachment(service)">View</el-button>
                                                </td>
                                            </tr>
                                            <tr class="proposal_total" v-loading="loadingSubtotal">
                                                <td colspan="6"></td>
                                                <td style="text-align:right" class="text-dark-75 font-weight-bolder d-block font-size-lg">Subtotal</td>
                                                <td colspan="2" style="text-align:left">{{subtotal() | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td colspan="6"></td>
                                                <td style="text-align:right" class="text-dark-75 font-weight-bolder d-block font-size-lg">Discount</td>
                                                <td colspan="2" style="text-align:left">{{discount() | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td colspan="6"></td>
                                                <td style="text-align:right" class="text-dark-75 font-weight-bolder d-block font-size-lg">Total Tax</td>
                                                <td colspan="2" style="text-align:left">{{tax() | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td colspan="6"></td>
                                                <td style="text-align:right" class="text-dark-75 font-weight-bolder d-block font-size-lg">Total</td>
                                                <td colspan="2" style="text-align:left">{{total() | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td colspan="6"></td>
                                                <td style="text-align:right" class="text-dark-75 font-weight-bolder d-block font-size-lg">Paid</td>
                                                <td colspan="2" style="text-align:left">{{invoice.total_paid | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td colspan="6"></td>
                                                <td style="text-align:right" class="text-dark-75 font-weight-bolder d-block font-size-lg">Credit Note</td>
                                                <td colspan="2" style="text-align:left">{{invoice.total_credit | addComma}}</td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td colspan="6"></td>
                                                <td style="text-align:right" class="text-dark-75 font-weight-bolder d-block font-size-lg">Due</td>
                                                <td colspan="2" style="text-align:left">{{due() | addComma}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--end::Table-->
                            </div>
                            <!--end::Body-->
                        </div>


                        <!--end::Advance Table Widget 5-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Profile 2-->
            </div>
            <!--end::Container-->
        </div>
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">RECEIPT SUMMARY</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <invoice-payment-list :id="id"></invoice-payment-list>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Body-->
            </div>

            <div class="card card-custom gutter-b">
                <!--begin::Header-->
                <div class="card-header border-0 py-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label font-weight-bolder text-dark">CREDIT NOTE SUMMARY</span>
                    </h3>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body py-0">
                    <!--begin::Table-->
                    <div class="table-responsive">
                        <invoice-credit-note-summary :id="id" ></invoice-credit-note-summary>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Body-->
            </div>
        </div>
        <el-dialog title="Add Credit Note" width="45%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <credit-note-form :mode="mode" :invoice-data="invoice" :formInvoice="true" :due-amount="due()"></credit-note-form>
        </el-dialog>

        <el-dialog title="Add Receipt" width="45%" :visible.sync="dialogFormVisibleInvoicePayment" :before-close="handleClosePayment">
            <invoice-payment-form :model="mode" :due-amount="this.due()" :id="id"></invoice-payment-form>
        </el-dialog>



        <el-dialog title="Add Attachment" width="40%" :visible.sync="dialogFormVisibleAttachment" :before-close="handeCloseAttachment">
            <attachment-form :attachment-id="invoice_item_id" :type="type"></attachment-form>
        </el-dialog>

        <el-dialog title="Attachments" width="65%" :visible.sync="dialogFormVisibleAttachmentList" :before-close="handeCloseAttachment">
            <attachment-list :attachment-id="invoice_item_id" :type="type"></attachment-list>
        </el-dialog>

        <el-dialog title="Send Invoice" width="35%" :visible.sync="dialogFormVisibleSendInvoice" :before-close="handeCloseAttachment">
            <input type="file" @change="fileChange($event)" />
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'InvoiceView',
    props: {
        id: null,
        model: {}
    },
    data() {
        return {
            invoice : {},
            loadingProposal: false,
            loadingCustomer: false,
            customer: {},
            data: {},
            loadingSubtotal: false,
            mode: '',
            dialogFormVisible: false,
            dialogFormVisibleInvoicePayment: false,
            invoice_item_id: '',
            type: '',
            dialogFormVisibleAttachment: false,
            dialogFormVisibleAttachmentList: false,
            isSending:false,
            dialogFormVisibleSendInvoice: false,
            fileList: []
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.data = this.model
            this.invoice = {
                id : this.model.id,
                customer_id : this.model.customer_id,
                customer: this.model.customer,
                issue_date: this.model.issue_date,
                due_date: this.model.due_date,
                project_id: this.model.project.name,
                project_id_id: this.model.project.id,
                ref_number: this.model.ref_number,
                status: this.model.status,
                send_date: this.$df.formatDate(this.model.send_date, "YYYY-MM-DD"),
                total_credit: this.model.total_credit,
                total_paid: this.model.total_paid,
                created_at: this.$df.formatDate(this.model.created_at, "YYYY-MM-DD"),
                services: this.model.items.map(service => {
                    return {
                        amount: service.price,
                        service_fee : service.service_fee,
                        id: service.id,
                        tax: service.tax_rate,
                        unit: service.unit,
                        discount: service.discount,
                        description: service.description,
                        name: service.name,
                        quantity: service.quantity,
                    }
                })
            }

            this.findCustomer();
        } else if (this.id) {
            this.findInvoice();
        }

        this.$EventDispatcher.listen('NEW_CREDIT_NOTE_AMOUNT', data => {
            let total = parseFloat(this.invoice.total_credit) - parseFloat(data.prevAmount)
            if(data.prevAmount > data.newAmount) {
                total= parseFloat(total) + parseFloat(data.newAmount)
                this.invoice.total_credit = total
            }
            else {
                total = parseFloat(total) + parseFloat(data.newAmount)
                this.invoice.total_credit = total.toFixed(2)
            }
            this.due()

        })

        this.$EventDispatcher.listen('NEW_CREDIT', data => {
            this.invoice.total_credit += parseFloat(data.amount)
            this.dialogFormVisible = false
            console.log('runnng2');
            this.due()
        })

        this.$EventDispatcher.listen('DELETE_CREDIT', data => {
            this.invoice.total_credit -= parseFloat(data)
            this.due()
        })
        this.$EventDispatcher.listen('NEW_PAYMENT', data => {
            this.dialogFormVisibleInvoicePayment = false
            this.invoice.total_paid += data.amount
            this.mode = ''
            this.due()
        })

        this.$EventDispatcher.listen('DELETE_PAYMENT', data => {
            this.invoice.total_paid -= data
            this.due()
        })

        this.$EventDispatcher.listen('NEW_ATTACHMENT', data => {
            this.dialogFormVisibleAttachment = false
        })
    },
    filters: {
        addComma(value) {
            if(value) {
                return 'P ' +value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            return '0.00'
        },
        taxRate(value) {
            if(value) {
                let tax = value.tax / 100
                let rate = value.amount * tax
                return 'P ' + rate.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
        sendDate(value) {
            if(!value) return 'Not Yet'
            return value
        }
    },
    methods: {
        edit() {
            this.$router.push({name: 'Update Invoice', params: {id: this.id, model: this.data, mode: 'update'} })
        },
        async findCustomer() {
            try {
                this.loadingCustomer = true
                const res = await this.$API.Customer.findCustomer(this.invoice.customer_id);
                this.customer = res.data
                this.isSelectCustomer = true
                this.loadingCustomer = false
            } catch (error) {
                console.log(error);
            }
        },
        download() {
            this.$router.push({name: 'Invoice Download', params: {id: this.id, model: this.data} })
        },
        async sendInvoice() {
            // this.dialogFormVisibleSendInvoice = true;
            try {
                this.isSending = true;
                const res = await this.$API.Invoice.sendInvoice(this.id)
                this.isSending = false;
                this.invoice.send_date = res.data
                this.$notify({
                    title: 'Success',
                    message: 'Send Successfully',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        handlePreview(file) {
            console.log(file);
        },
        handleRemove(file, fileList) {
            console.log(file, fileList);
        },
        fileChange(event) {
            var tmppath = URL.createObjectURL(event.target.files[0]);
            console.log(tmppath);
        },
        addReceipt() {
            this.dialogFormVisibleInvoicePayment = true;
            this.mode = 'create'
        },
        addNote() {
            this.dialogFormVisible = true;
            this.mode = 'create'
        },
        handleClose(done) {
            this.mode = ''
            done();
        },
        handleClosePayment(done) {
            this.mode = ''
            this.$EventDispatcher.fire('CLOSE_RECEIPT')
            done();
        },
        addFile(service) {
            this.dialogFormVisibleAttachment = true
            console.log(service);
            this.invoice_item_id = service.id
            this.type = 'invoice_item'
        },
        viewAttachment(service) {
            this.dialogFormVisibleAttachmentList = true
            this.type = 'invoice_item'
            this.invoice_item_id = service.id
        },
        handeCloseAttachment(done) {
            this.$EventDispatcher.fire('CLOSE_ATTACHMENT_FORM')
            done();
        },
        async findInvoice() {
            try {
                this.loadingProposal = true

                const res = await this.$API.Invoice.findInvoice(this.id);
                this.data = res.data
                let proposal = res.data
                console.log(proposal);
                this.invoice = {
                    id: res.data.id,
                    customer_id : res.data.customer_id,
                    customer : res.data.customer,
                    issue_date: res.data.issue_date,
                    due_date: res.data.due_date,
                    project_id: res.data.project.name,
                    project_id_id: res.data.project.id,
                    ref_number: res.data.ref_number,
                    status: res.data.status,
                    send_date: this.$df.formatDate(res.data.send_date, "YYYY-MMM-DD"),
                    created_at: this.$df.formatDate(res.data.created_at, "YYYY-MMM-DD"),
                    total_credit: res.data.total_credit,
                    total_paid: res.data.total_paid,
                    services: res.data.items.map(service => {
                        return {
                            amount: service.price,
                            service_fee : service.service_fee,
                            product_id: service.product_id,
                            id: service.id,
                            tax: service.tax_rate,
                            unit: service.unit,
                            discount: service.discount,
                            description: service.description,
                            name: service.name,
                            quantity: service.quantity,
                        }
                    })
                }

                 await this.findCustomer();

                this.loadingProposal = false
            } catch (error) {
                console.log(error);
            }
        },
        subtotal() {
            if(this.loadingProposal) {
                return
            }
            let amounts = [] = this.invoice.services.map(service => {
                let total = 0
                total+=parseFloat(service.amount)
                return total
            })

            let total = 0
            if(amounts.length > 0) {
                amounts.forEach(amount => {
                    if(amount) {
                        total+=parseFloat(amount)
                    }
                })
            }
            return parseFloat(total).toFixed(2)
        },
        discount() {
            if(this.loadingProposal) {
                return
            }
            let discounts = [] = this.invoice.services.map(service => {
                let total = 0
                total+=parseFloat(service.discount)
                return total
            })

            let total = 0
            if(discounts.length > 0) {
                discounts.forEach(discount => {
                    if(discount) {
                        total+=parseFloat(discount)
                    }
                })
            }
            return parseFloat(total).toFixed(2)
        },
        tax() {
            if(this.loadingProposal) {
                return
            }
            let taxes = [] = this.invoice.services.map(service => {
                let total = 0.0
                let subtotal = 0.0
                let tax = 0.0
                if(service.tax) {
                    if(service.amount) {
                        tax = parseFloat(service.tax) / 100
                        subtotal = parseFloat(service.amount) * tax
                        total+=subtotal
                    }
                }
                return total
            })

            let total = 0.0
            if(taxes.length > 0) {
                taxes.forEach(tax => {
                    if(tax) {
                        total+=parseFloat(tax)
                    }
                })
            }

            return parseFloat(total).toFixed(2)
        },
        total() {
            if(this.loadingProposal) {
                return
            }
            return (parseFloat(this.subtotal()) + parseFloat(this.tax())).toFixed(2);
        },
        due() {
            if(this.loadingProposal) {
                return
            }
            let due =  (parseFloat(this.subtotal()) + parseFloat(this.tax() - parseFloat(this.discount())) ).toFixed(2);
            let subtotal = parseFloat(due).toFixed(2) - parseFloat(this.invoice.total_credit).toFixed(2)
            subtotal -= parseFloat(this.invoice.total_paid).toFixed(2)
            return subtotal.toFixed(2);
        },
    },
}
</script>
<style lang="scss">
    .invoice_actions {
        padding: 10px;
        float: right;
        margin-top: -20px;

        button {
            margin-right: 10px;
        }
    }
</style>
