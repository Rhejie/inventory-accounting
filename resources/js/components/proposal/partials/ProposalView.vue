<template>
    <div>
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{proposal.proposal_number}} </h5>
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
                                        <attachment-file-list :id="id" :type="'proposal'"></attachment-file-list>
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
                                        <h3 class="card-title font-weight-bolder text-dark">PROPOSAL DETAILS</h3>
                                        <div class="card-toolbar">
                                            <el-button class="" @click="edit" size="mini">Edit</el-button>
                                            <el-button class="" size="mini" @click="convertToInvoice">Convert to Invoice</el-button>
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
                                                                <span class="font-weight-bolder text-primary">Create Proposal</span>
                                                                <p class="font-weight-normal text-dark-50 pb-2">
                                                                    <i class="far fa-clock"></i> Created on {{proposal.created_at}}
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
                                                                <span class="font-weight-bolder text-warning">Send Proposal</span>
                                                                <p class="font-weight-normal text-dark-50 pt-1 pb-2">
                                                                    <i class="far fa-clock"></i> Sent on {{proposal.send_date | sendDate}}
                                                                </p>
                                                                <el-button :loading="isSending" v-if="proposal.send_date ? false : true" :disabled="isSending" @click="sendProposal" style="float:right; margin-top: -40px" >
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
                                                                <span class="font-weight-bolder text-success">Proposal Status</span>
                                                                <br>
                                                                <el-tag effect="dark" v-if="proposal.status == 0" type="info">Draft</el-tag>
                                                                <el-tag effect="dark" v-if="proposal.status == 1" type="success">Open</el-tag>
                                                                <el-tag effect="dark" v-if="proposal.status == 2" type="success">Accepted</el-tag>
                                                                <el-tag effect="dark" v-if="proposal.status == 3" type="danger">Declined</el-tag>
                                                                <el-tag effect="dark" v-if="proposal.status == 4" type="warning">Close</el-tag>

                                                                <el-select v-model="proposal.status" @change="statusChange" style="float:right; width: 120px" >
                                                                    <el-option
                                                                        v-for="(item, index) in status"
                                                                        :key="index"
                                                                        :label="item"
                                                                        :value="index">
                                                                    </el-option>
                                                                </el-select>
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
                                    <el-button :loading="isSending"  v-if="proposal.send_date ? true : false" :disabled="isSending" @click="sendProposal">Resend Proposal</el-button>
                                    <a class="el-button el-button--default el-button--small" :href="`/proposal/download-proposal/${id}`" target="_blank">Download</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!--begin::List Widget 10-->
                                <div class="card card-custom card-stretch gutter-b">
                                    <!--begin::Header-->
                                    <div class="card-header border-0">
                                        <h3 class="card-title font-weight-bolder text-dark">PROPOSAL</h3>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <el-descriptions class="margin-top" :column="2">
                                                    <el-descriptions-item label="Issue Date">{{proposal.issue_date}}</el-descriptions-item>
                                                    <el-descriptions-item label="Project">{{proposal.project_id}}</el-descriptions-item>
                                                    <el-descriptions-item label="Proposal Number">{{proposal.proposal_number}}</el-descriptions-item>
                                                    <el-descriptions-item label="Status">
                                                        <el-tag effect="dark" v-if="proposal.status == 0" type="info">Draft</el-tag>
                                                        <el-tag effect="dark" v-if="proposal.status == 1" type="success">Open</el-tag>
                                                        <el-tag effect="dark" v-if="proposal.status == 2" type="success">Accepted</el-tag>
                                                        <el-tag effect="dark" v-if="proposal.status == 3" type="danger">Declined</el-tag>
                                                        <el-tag effect="dark" v-if="proposal.status == 4" type="warning">Close</el-tag>
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
                                                <th class="pl-0">Service</th>
                                                <th class="pl-0">Service Fee</th>
                                                <th>Quantity</th>
                                                <th>Tax</th>
                                                <th>Unit</th>
                                                <th>Discount</th>
                                                <th>Amount</th>
                                                <th>Attachment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(service, index) in proposal.services" :key="service.id">
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
                                                            {{service.tax}}% ( {{service | taxRate}} )
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
                                                    <el-button slot="trigger" size="small" type="text" @click="addFile(service)">Add</el-button>
                                                    <el-button slot="trigger" size="small" type="text" @click="viewAttachment(service)">View</el-button>
                                                </td>
                                            </tr>
                                            <tr class="proposal_total" v-loading="loadingSubtotal">
                                                <td class="text-dark-75 font-weight-bolder d-block font-size-lg">Subtotal</td>
                                                <td>{{subtotal() | addComma}}</td>
                                                <td colspan="7"></td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td class="text-dark-75 font-weight-bolder d-block font-size-lg">Discount</td>
                                                <td>{{discount() | addComma}}</td>
                                                <td colspan="7"></td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td class="text-dark-75 font-weight-bolder d-block font-size-lg">Tax</td>
                                                <td>{{tax() | addComma}}</td>
                                                <td colspan="7"></td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td class="text-dark-75 font-weight-bolder d-block font-size-lg">Total Amount</td>
                                                <td>{{total() | addComma}}</td>
                                                <td colspan="7"></td>
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

        <el-dialog title="Add Attachment" width="40%" :visible.sync="dialogFormVisibleAttachment" :before-close="handeCloseAttachment">
            <attachment-form :attachment-id="proposal_item_id" :type="type"></attachment-form>
        </el-dialog>

        <el-dialog title="Attachments" width="65%" :visible.sync="dialogFormVisibleAttachmentList" :before-close="handeCloseAttachment">
            <attachment-list :attachment-id="proposal_item_id" :type="type"></attachment-list>
        </el-dialog>

        <el-dialog title="Send Proposal" width="35%" :visible.sync="dialogFormVisibleSendInvoice" :before-close="handeCloseAttachment">
            <send-proposal-form :id="id"></send-proposal-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'ProposalView',
    props: {
        id: null,
        model: {},
        pageData: {}
    },
    data() {
        return {
            proposal : {},
            loadingProposal: false,
            loadingCustomer: false,
            customer: {},
            data: {},
            loadingSubtotal: false,
            status: [],
            dialogFormVisibleAttachment: false,
            dialogFormVisibleAttachmentList: false,
            proposal_item_id: null,
            type: '',
            isSending:false,
            dialogFormVisibleSendInvoice: false,
            fileList: []
        }
    },
    created() {
        this.status = this.pageData.status

        if(this.model && this.model.id) {
            this.data = this.model
            this.proposal = {
                id: this.model.id,
                customer_id : this.model.customer_id,
                issue_date: this.model.issue_date,
                project_id: this.model.project.name,
                project_id_id: this.model.project.id,
                proposal_number: this.model.proposal_number,
                created_at: this.$df.formatDate(this.model.created_at, "YYYY-MM-DD"),
                send_date: this.$df.formatDate(this.model.send_date, "YYYY-MM-DD"),
                invoice: this.model.invoice,
                status: this.model.status,
                services: this.model.items.map(service => {
                    return {
                        amount: service.price,
                        service_fee : service.service_fee,
                        product_id: service.service.id,
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
            this.findProposal();
        }

        this.$EventDispatcher.listen('NEW_ATTACHMENT', data => {
            this.dialogFormVisibleAttachment = false
        })

        this.$EventDispatcher.listen('SEND_PROPOSAL', data => {
            this.statusChange(1)
            this.proposal.status = 1
            this.proposal.send_date = data
            this.dialogFormVisibleSendInvoice = false
        })
    },
    filters: {
        addComma(value) {
            if(value) {
                value = parseFloat(value).toFixed(2)
                return 'P '+value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
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

        async findCustomer() {
            try {
                this.loadingCustomer = true
                const res = await this.$API.Customer.findCustomer(this.proposal.customer_id);
                this.customer = res.data
                this.loadingCustomer = false
            } catch (error) {
                console.log(error);
            }
        },
        async findProposal() {
            try {
                this.loadingProposal = true

                const res = await this.$API.Proposal.findProposal(this.id);
                this.data = res.data
                let proposal = res.data
                console.log(proposal);
                this.proposal = {
                    id: res.data.id,
                    customer_id : res.data.customer_id,
                    issue_date: res.data.issue_date,
                    project_id: res.data.project.name,
                    project_id_id: res.data.project.id,
                    proposal_number: res.data.proposal_number,
                    send_date: this.$df.formatDate(res.data.send_date, "YYYY-MMM-DD"),
                    created_at: this.$df.formatDate(res.data.created_at, "YYYY-MMM-DD"),
                    invoice: res.data.invoice,
                    status: res.data.status,
                    services: res.data.items.map(service => {
                        return {
                            amount: service.price,
                            service_fee : service.service_fee,
                            product_id: service.service.id,
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
        edit() {
            this.$router.push({name: 'Update Proposal', params: {id: this.id, model: this.data, mode: 'update'} })
        },
        async sendProposal() {
            // this.dialogFormVisibleSendInvoice = true;
            try {
                this.isSending = true
                const res = await this.$API.Proposal.sendProposal(this.id)
                await this.statusChange(1)
                this.isSending = false
                this.proposal.status = 1
                this.proposal.send_date = res.data
                this.$notify({
                    title: 'Success',
                    message: 'Send Successfully',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        async statusChange(value) {
            try {

                const res = await this.$API.Proposal.changeStatus(this.id, value);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Status Change',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        convertToInvoice() {
            if(this.proposal.invoice && this.proposal.invoice.id) {
                this.$message({
                    type: 'success',
                    message: 'Already Converted into Invoice'
                });
                return
            }
            this.$confirm('Convert into Invoice?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.convertInvoice();
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Canceled'
                    });
                });
        },
        async convertInvoice() {
            try {
                const res = await this.$API.Proposal.convertToInvoice(this.proposal.id)
                if(res.data == 'converted') {
                    this.$message({
                        type: 'success',
                        message: 'Already Converted into Invoice'
                    });
                    return
                }
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Converted',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        addFile(service) {
            this.dialogFormVisibleAttachment = true
            this.proposal_item_id = service.id
            this.type = 'proposal_item'
        },
        viewAttachment(service) {
            this.dialogFormVisibleAttachmentList = true
            this.type = 'proposal_item'
            this.proposal_item_id = service.id
        },
        handeCloseAttachment(done) {
            this.$EventDispatcher.fire('CLOSE_ATTACHMENT_FORM')
            done();
        },
        subtotal() {
            if(this.loadingProposal) {
                return
            }
            let amounts = [] = this.proposal.services.map(service => {
                let total = 0.0
                total+=parseFloat(service.amount)
                return total
            })

            let total = 0.0
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
            let discounts = [] = this.proposal.services.map(service => {
                let total = 0.0
                total+=parseFloat(service.discount)
                return total
            })

            let total = 0.0
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
            let taxes = [] = this.proposal.services.map(service => {
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
            return (parseFloat(this.subtotal()) + parseFloat(this.tax()) - parseFloat(this.discount())).toFixed(2);
        },
    }
}
</script>
<style lang="scss">
    .customer_info {
        line-height: 0.8
    }
</style>
