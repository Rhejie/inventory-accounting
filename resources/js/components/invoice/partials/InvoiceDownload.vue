<template>
    <div>
        <vue-html2pdf
            :show-layout="false"
            :float-layout="true"
            :enable-download="true"
            :preview-modal="true"
            :paginate-elements-by-height="1400"
            filename="hee hee"
            :pdf-quality="2"
            :manual-pagination="false"
            pdf-format="a4"
            pdf-orientation="landscape"
            pdf-content-width="800px"

            @progress="onProgress($event)"
            @hasStartedGeneration="hasStartedGeneration()"
            @hasGenerated="hasGenerated($event)"
            ref="html2Pdf">
            <section slot="pdf-content">
                <h2>asdasds</h2>
            </section>
        </vue-html2pdf>
        <div class="d-flex flex-column-fluid" id="printMe" ref="content">
							<!--begin::Container-->
            <div class="container">
                <!-- begin::Card-->
                <div class="card card-custom overflow-hidden">
                    <div class="card-body p-0">
                        <!-- begin: Invoice-->
                        <!-- begin: Invoice header-->
                        <div class="row justify-content-center invoice_1" style="padding-top:70px">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                    <h1 class="display-4 font-weight-boldest mb-10">INVOICE</h1>
                                    <div class="d-flex flex-column align-items-md-end px-0"  id="print">
                                        <!--begin::Logo-->
                                        <a href="#" class="mb-5">
                                            <img :src="`/img/logo.png`" class="invoice_logo_img" alt="">
                                        </a>
                                        <!--end::Logo-->
                                        <span class="d-flex flex-column align-items-md-end opacity-70">
                                            <span>ASDEC BUILDERS CORPORATION</span>
                                            <span>225 BANLAT ROAD TANDANG SORA, QUEZON CITY</span>
                                            <span>TEL NO. 3455-5115 * TELEFAX NO. 7000-9800 * CEL NOS. (Sun) 0925-864-5310 (Globe) 09661430147</span>
                                            <span>EMAIL ADD: <span class="invoice_company_email">asdec_mae@yahoo.com</span> * <span class="invoice_company_email">asdecbuilders@yahoo.com</span></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="border-bottom w-100"></div>
                                <div class="d-flex justify-content-between pt-6">
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">INVOICE NO.</span>
                                        <span class="opacity-70">{{invoice.ref_number}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">ISSUE DATE</span>
                                        <span class="opacity-70">{{invoice.issue_date}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">DUE DATE</span>
                                        <span class="opacity-70">{{invoice.due_date}}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">Project</span>
                                        <span class="opacity-70">{{invoice.project_id}}</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between pt-6">
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">INVOICE TO.</span>
                                        <span class="opacity-70">{{invoice.customer.name}}
                                        <br /><span class="invoice_company_email">{{invoice.customer.email}}</span>
                                        <br/>{{invoice.customer.contact}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice header-->
                        <!-- begin: Invoice body-->
                        <div class="row justify-content-center invoice_1 py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="pl-0 font-weight-bold text-muted text-uppercase">Service</th>
                                                <th class="text-center font-weight-bold text-muted text-uppercase">Fee</th>
                                                <th class="text-center font-weight-bold text-muted text-uppercase">Quantity</th>
                                                <th class="text-center font-weight-bold text-muted text-uppercase">Tax</th>
                                                <th class="text-center pr-0 font-weight-bold text-muted text-uppercase">Unit</th>
                                                <th class="text-center pr-0 font-weight-bold text-muted text-uppercase">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="font-weight-boldest" v-for="(service, index) in invoice.services" :key="index">
                                                <td class="pl-0 pt-7">{{service.name}}</td>
                                                <td class="text-center pt-7">{{service.service_fee | addComma}}</td>
                                                <td class="text-center pt-7">{{service.quantity}}</td>
                                                <td class="text-center pt-7">
                                                    <template v-if="service.tax">
                                                        {{service.tax}}%  ( {{service | taxRate}} )
                                                    </template>
                                                    <template v-else>
                                                        -
                                                    </template>
                                                </td>
                                                <td class="text-center pt-7">
                                                    <template v-if="service.unit">
                                                        {{service.unit}}
                                                    </template>
                                                    <template v-else>
                                                        -
                                                    </template>
                                                </td>
                                                <td class="text-danger pr-0 pt-7 text-center">{{service.amount | addComma}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice body-->
                        <!-- begin: Invoice footer-->
                        <div class="row justify-content-center invoice_1 bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="font-weight-bold text-muted text-uppercase">Subtotal</th>
                                                <th class="font-weight-bold text-muted text-uppercase">Discount</th>
                                                <th class="font-weight-bold text-muted text-uppercase">TOTAL TAX</th>
                                                <th class="font-weight-bold text-muted text-uppercase">TOTAL AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="font-weight-bolder">
                                                <td>{{subtotal() | addComma}}</td>
                                                <td>{{discount() | addComma}}</td>
                                                <td>{{tax() | addComma}}</td>
                                                <td class="text-danger ">{{total() | addComma}} <br> <span class="text-muted font-weight-bold mb-16">Taxes Included</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice footer-->
                        <!-- begin: Invoice action-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0" ref="asdsd">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="buttonPrint btn btn-light-primary font-weight-bold " @click='generate'>Download Invoice</button>
                                    <button type="button" class="buttonPrint btn btn-primary font-weight-bold " @click="print">Print Invoice</button>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice action-->
                        <!-- end: Invoice-->
                    </div>
                </div>
                <!-- end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
</template>
<script>
import VueHtml2pdf from 'vue-html2pdf'
import jsPDF from 'jspdf'
import html2canvas from "html2canvas"
import domtoimage from "dom-to-image";
export default {
    name: 'InvoiceDownload',
    props: {
        id: null,
        model : {
            type: Object,
            default: null
        }
    },
    components: {
        VueHtml2pdf
    },
    data() {
        return {
            invoice: {},
            loadingProposal: false,
        }
    },
    created() {
        if(this.model && this.model.id) {
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
        }
        else {
            this.findInvoice()
        }
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
    },
    methods: {
        generate() {
            // const doc = new jsPDF({
            //     orientation: 'p',
            //     unit: 'px',
            //     format: 'a4',
            //     hotfixes: ['px_scaling'],
            // });
            // html2canvas(this.$refs.asdsd, {
            //     width: doc.internal.pageSize.getWidth(),
            //     height: doc.internal.pageSize.getHeight()
            // }).then((canvas) => {
            //     const img = canvas.toDataURL("image/png");

            //     doc.addImage(img, "PNG", 140, 10, doc.internal.pageSize.getWidth(), doc.internal.pageSize.getHeight());
            //     doc.save("psadad.pdf");
            // })

            var options = {
        quality: 0.95
    };

    domtoimage.toJpeg(this.$refs.content, options).then(function (dataUrl)
    {
        var doc = new jsPDF();
        doc.addImage(dataUrl, 'JPEG', -25, 15, 240, 134.12);
        doc.save('Test.pdf');
    });
            // html2canvas(this.$refs.content, {
            //     width: this.$refs.content.clientWidth,
            //     height: this.$refs.content.clientWidth,
            //      allowTaint : true
            // }).then((canvas) => {
            //     const img = canvas.toDataURL("image/png");

            //     doc.addImage(img, "PNG", 140, 10, doc.internal.pageSize.getWidth(), doc.internal.pageSize.getHeight());
            //     doc.save("p&lstatement.pdf");
            // })
        },
        async findInvoice() {
            try {
                this.loadingProposal = true

                const res = await this.$API.Invoice.findInvoice(this.id);
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
                            tax: service.service.tax,
                            unit: service.service.unit,
                            discount: service.discount,
                            description: service.description,
                            name: service.name,
                            quantity: service.quantity,
                        }
                    })
                }

                this.loadingProposal = false
            } catch (error) {
                console.log(error);
            }
        },
        async print() {
            // Pass the element id here
            await this.$htmlToPaper('printMe');
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
    .invoice_logo_img {
        width: 150px
    }
    .invoice_company_email {
        color: blue;
    }
</style>
