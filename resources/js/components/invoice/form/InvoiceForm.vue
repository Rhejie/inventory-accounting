<template>
    <div>
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{title}} </h5>
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
                <!--begin::Row-->
                    <el-card class="box-card">
                        <div class="text item" v-loading="loadingProposal">
                            <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
                                <div class="row">
                                    <div class="col-md-5">
                                        <el-form-item label="Customer" prop="customer_id" v-if="!isSelectCustomer">
                                            <el-select
                                                v-model="form.customer_id"
                                                filterable
                                                @change="customerChange"
                                                remote
                                                reserve-keyword
                                                style="width:100%"
                                                placeholder="Please enter a keyword"
                                                :remote-method="remoteMethodCustomers"
                                                :loading="loadingCustomers">
                                                    <el-option
                                                        v-for="item in customers"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                    </el-option>
                                            </el-select>
                                        </el-form-item>

                                        <div class="row" v-if="isSelectCustomer" v-loading="loadingCustomer">
                                            <div class="col-lg-12">
                                                <h3>Customer Information</h3>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <el-button size="mini" @click="removeCustomer" style="float:right" type="danger">Remove</el-button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p>Name: {{customer.name}}</p>
                                                        <p>Email: {{customer.email}}</p>
                                                        <p>Contact: {{customer.contact}}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Bill To</h4>
                                                        <el-descriptions class="margin-top" :column="1">
                                                            <el-descriptions-item label="Name">{{customer.billing_name}}</el-descriptions-item>
                                                            <el-descriptions-item label="Phone">{{customer.billing_phone}}</el-descriptions-item>
                                                            <el-descriptions-item label="Country">{{customer.billing_country}}</el-descriptions-item>
                                                            <el-descriptions-item label="State">{{customer.billing_state}}</el-descriptions-item>
                                                            <el-descriptions-item label="City">{{customer.billing_city}}</el-descriptions-item>
                                                            <el-descriptions-item label="Zip">{{customer.billing_zip}}</el-descriptions-item>
                                                        </el-descriptions>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h4>Ship To</h4>
                                                        <el-descriptions class="margin-top" :column="1">
                                                            <el-descriptions-item label="Name">{{customer.shipping_name}}</el-descriptions-item>
                                                            <el-descriptions-item label="Phone">{{customer.shipping_phone}}</el-descriptions-item>
                                                            <el-descriptions-item label="Country">{{customer.shipping_country}}</el-descriptions-item>
                                                            <el-descriptions-item label="State">{{customer.shipping_state}}</el-descriptions-item>
                                                            <el-descriptions-item label="City">{{customer.shipping_city}}</el-descriptions-item>
                                                            <el-descriptions-item label="Zip">{{customer.shipping_zip}}</el-descriptions-item>
                                                        </el-descriptions>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <el-form-item label="Issue Date" prop="issue_date">
                                                    <el-date-picker
                                                        v-model="form.issue_date"
                                                        style="width:100%"
                                                        type="date"
                                                        placeholder="Pick a day">
                                                    </el-date-picker>
                                                </el-form-item>
                                                <el-form-item label="Due Date" prop="due_date">
                                                    <el-date-picker
                                                        v-model="form.due_date"
                                                        style="width:100%"
                                                        type="date"
                                                        placeholder="Pick a day">
                                                    </el-date-picker>
                                                </el-form-item>
                                            </div>
                                            <div class="col-md-6">
                                                <el-form-item label="Invoice Number" prop="ref_number">
                                                    <el-input v-loading="loadingNumber" disabled v-model="form.ref_number">
                                                        <template slot="prepend"><i class="fas fa-file"></i></template>
                                                    </el-input>
                                                </el-form-item>
                                                <el-form-item label="Project" prop="project_id">
                                                    <el-select
                                                        v-model="form.project_id"
                                                        style="width: 100%"
                                                        filterable
                                                        remote
                                                        reserve-keyword
                                                        @change="changeProjectId"
                                                        placeholder="Please enter a keyword"
                                                        :remote-method="remoteMethodProjects"
                                                        :loading="loadingProjects">
                                                        <el-option
                                                        v-for="item in projects"
                                                        :key="item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <div class="row" style="margin-top: 10px; margin-bottom: 10px">
                                    <div class="col-md-12">
                                        <h2>Services</h2>
                                        <hr/>
                                        <table class="table table-responsize">
                                            <thead>
                                                <th>ITEM</th>
                                                <th>SERVICE FEE</th>
                                                <th>QUANTITY</th>
                                                <th>TAX</th>
                                                <th>UNIT</th>
                                                <th>AMOUNT</th>
                                                <th>DISCOUNT</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(service, index) in form.services" :key="index+1" class="service_list">
                                                    <td>{{service.name}}</td>
                                                    <td>
                                                        <el-input v-model="service.service_fee" @change="changeServiceFee($event, service, index)" placeholder="Service Fee..." type="number"></el-input>
                                                    </td>
                                                    <td>
                                                        <el-input v-model="service.quantity" min="0" placeholder="Quantity..." @change="changeQuantity($event, service, index)" type="number"></el-input>
                                                        <div class="invalid-feedback_item" v-if="error.length > 0 && index == error[0].index">
                                                            {{error[0].message}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <template v-if="service.tax">
                                                            {{service.tax | checkValueTax}}%
                                                        </template>
                                                        <template v-else>
                                                            -
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <template v-if="service.unit">
                                                            {{service.unit | checkValueUnit}}
                                                        </template>
                                                        <template v-else>
                                                            -
                                                        </template>
                                                    </td>
                                                    <td>
                                                        <el-input v-model="service.amount" disabled v-loading="loadingAmount & indexAmount == index" type="number" min="0" placeholder="Amount"></el-input>
                                                    </td>
                                                    <td>
                                                        <el-input v-model="service.discount" @change="changeDiscount($event, service, index)" type="number" min="0" placeholder="Discount"></el-input>
                                                    </td>
                                                    <td >
                                                        <el-button type="text" @click="removeService(index, service.id)" style="margin:10px" size="mini"><i class="fas fa-trash"></i></el-button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8" style="padding: 10px">
                                                        <el-select
                                                            v-model="service"
                                                            filterable
                                                            @change="serviceChange"
                                                            remote
                                                            reserve-keyword
                                                            style="width:100%"
                                                            placeholder="Please enter a keyword"
                                                            :remote-method="remoteMethodServices"
                                                            :loading="loadingServices">
                                                                <el-option
                                                                    v-for="item in services"
                                                                    :key="item.id"
                                                                    :label="item.name"
                                                                    :value="item.id">
                                                                </el-option>
                                                        </el-select>
                                                    </td>
                                                </tr>
                                                <tr class="proposal_total" v-loading="loadingSubtotal">
                                                    <td>Subtotal</td>
                                                    <td colspan="7">{{subtotal() | addComma}}</td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Discount</td>
                                                    <td colspan="7">{{discount() | addComma}}</td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Tax</td>
                                                    <td colspan="7">{{tax() | addComma}}</td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Total Amount</td>
                                                    <td colspan="7">{{total() | addComma}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <el-form-item style="float: right">
                                            <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                                            <el-button :disabled="disableButton" v-if="mode != 'update' && !this.id" @click="resetForm('form')">Reset</el-button>
                                            <el-button :disabled="disableButton"  @click="cancel('form')" type="danger">Cancel</el-button>
                                        </el-form-item>
                                    </div>
                                </div>
                            </el-form>
                        </div>
                    </el-card>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
    </div>
</template>
<script>
export default {
    name: 'InvoiceForm',
    props: {
        id: 0,
        model: {},
        mode: null
    },
    data() {
        return {
            form: {
                customer_id: null,
                issue_date: null,
                project_id: null,
                ref_number: null,
                due_date: null,
                services: []
            },
            rules: {
                customer_id: [
                    {required: true, message: 'Please select Customer', trigger: 'blur'}
                ],
                issue_date: [
                    {required: true, message: 'Please input Issue Date', trigger: 'blur'}
                ],
                due_date: [
                    {required: true, message: 'Please input Due Date', trigger: 'blur'}
                ],
                project_id: [
                    {required: true, message: 'Please select Project', trigger: 'blur'}
                ]
            },
            customers: [],
            loadingCustomers: false,
            loadingProjects: false,
            loadingNumber: false,
            projects: [],
            disableButton: false,
            customer: {},
            isSelectCustomer : false,
            service: null,
            services: [],
            loadingServices: false,
            loadingAmount: false,
            indexAmount: '',
            loadingSubtotal: false,
            loadingCustomer: false,
            loadingProposal: false,
            title: '',
            removeItems: [],
            error: [],
            is_insufficient: false,
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.form = {
                customer_id : this.model.customer_id,
                issue_date: this.model.issue_date,
                due_date: this.model.due_date,
                project_id: this.model.project.name,
                project_id_id: this.model.project.id,
                ref_number: this.model.ref_number,
                services: this.model.items.map(service => {
                    return {
                        amount: service.price,
                        service_fee : service.service_fee,
                        id: service.id,
                        product_id: service.product_id,
                        tax: service.tax_rate,
                        unit: service.unit,
                        discount: service.discount,
                        description: service.description,
                        name: service.name,
                        quantity: service.quantity,
                    }
                })
            }
            this.title = 'Update Invoice'
            this.findCustomer();
        }  else if (this.id) {

            this.title = 'Update Invoice'
            this.findInvoice()

        } else {

            this.title = 'Create Invoice'
            this.getInvoiceNumber();
        }
    },
    filters: {
        addComma(value) {
            if(value) {
                return 'P '+ value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            return '0.00'
        },
        checkValueTax(value) {
            if(value && typeof value === 'object' && value.constructor === Object) {
                return value.rate
            }
            else {
                return value
            }
        },
        checkValueUnit(value) {
            if(value && typeof value === 'object' && value.constructor === Object) {
                return value.name
            }
            else {
                return value
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update' || this.id) {
                    this.updateInvoice();

                    return
                }
                this.storeInvoice();

            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.getInvoiceNumber();
            this.$refs[formName].resetFields();
        },
        async storeInvoice() {
            try {
                this.form.issue_date = this.$df.formatDate(this.form.issue_date, "YYYY-MM-DD")
                this.form.due_date = this.$df.formatDate(this.form.due_date, "YYYY-MM-DD")
                this.form.services.forEach((service, index) => {
                    let quantity = service.hasOwnProperty('quantity')
                    if(!quantity) {
                        this.error.push({message: 'Please Input Quantity', index})
                        return
                    }
                    else {
                        if(service.quantity == '') {
                            this.error.push({message: 'Please Input Quantity', index})
                            return
                        }
                    }

                    this.error = []
                })

                if(this.error.length > 0) {
                    return
                }

                this.form.services.forEach((service, index) => {
                    let discount = service.hasOwnProperty('discount')
                    if(!discount) {
                        service.discount = 0
                        return
                    }
                })
                this.disableButton = true
                if(this.is_insufficient) {
                    this.disableButton = false
                    this.is_insufficient = false
                    return
                }
                const res = await this.$API.Invoice.storeInvoice(this.form);
                this.disableButton = false
                this.resetForm('form');
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.$router.push({name: 'Invoices'})
            } catch (error) {
                if(this.is_insufficient) {
                    this.disableButton = false;
                }
                console.log(error);
            }
        },
        async updateInvoice() {
            try {
                this.form.issue_date = this.$df.formatDate(this.form.issue_date, "YYYY-MM-DD")
                this.form.due_date = this.$df.formatDate(this.form.due_date, "YYYY-MM-DD")
                this.form.remove_items = this.removeItems
                this.form.services.forEach((service, index) => {
                    let quantity = service.hasOwnProperty('quantity')
                    if(!quantity) {
                        this.error.push({message: 'Please Input Quantity', index})
                        return
                    }
                    else {
                        if(service.quantity == '') {
                            this.error.push({message: 'Please Input Quantity', index})
                            return
                        }
                    }

                    this.error = []
                })

                if(this.error.length > 0) {
                    return
                }

                this.form.services.forEach((service, index) => {
                    let discount = service.hasOwnProperty('discount')
                    if(!discount) {
                        service.discount = 0
                        return
                    }
                })
                this.disableButton = true
                if(this.is_insufficient) {
                    this.disableButton = false
                    this.is_insufficient = false
                    return
                }
                const res = await this.$API.Invoice.updateInvoice(this.id, this.form)
                this.disableButton = false
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.$router.push({name: 'Invoice View', params: {id : this.id} })
            } catch (error) {
                if(this.is_insufficient) {
                    this.disableButton = false;
                }
                console.log(error);
            }
        },
        async remoteMethodCustomers(query) {
            try {
                if (query !== '') {
                    this.loadingCustomers = true;
                    const res = await this.$API.Customer.getCustomersQuery(query);
                    this.customers = res.data
                    this.loadingCustomers = false;
                } else {
                    this.customers = [];
                }
            } catch (error) {
                console.log(error);
            }
        },
        async remoteMethodProjects(query) {
            if (query !== '') {
                this.loadingProjects = true;
                try {
                    const res = await this.$API.RequestMaterial.getProjects(query);
                    this.projects = res.data
                    this.loadingProjects = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.projects = [];
            }
        },
        async remoteMethodServices(query) {
            try {
                if(query !== '') {
                    this.loadingServices = true
                    const res = await this.$API.Service.searchService(query)
                    this.services = res.data
                    this.loadingServices = false
                }
            } catch (error) {
                console.log(error);
            }
        },
        serviceChange(value) {
            if(this.id != 0 || this.model || this.model.id) {
                let service = this.services.find(service => service.id == value)
                service.product_id = service.id
                service.id = '',
                this.form.services.push(service)
                this.service = null;
                return
            }
            let service = this.services.find(service => service.id == value)
            this.form.services.push(service)
            this.service = null;
            this.services = []
            this.error = []
        },
        changeServiceFee(e, service, index) {
            let service_fee = parseFloat(e);
            let tax= 0
            if(service.tax) {
                tax = parseFloat(service.tax.rate) / 100;
            }

            service.amount = (service_fee * service.quantity)
        },
        removeService(index, id){
            this.removeItems.push(id);
            this.form.services.splice(index, 1)
        },
        removeCustomer() {
            this.form.customer_id = null;
            this.customer = {};
            this.isSelectCustomer = false;
        },
        changeProjectId(value) {
            this.form.project_id = value;
            this.form.project_id_id = null
        },
        changeQuantity(e, service, index) {
            this.loadingAmount = true
            this.indexAmount = index

            let checkTotal = (parseFloat(e) * parseFloat(service.service_fee))
            let checkDiscount = parseFloat(service.discount)
            console.log(checkTotal, checkDiscount);
            this.is_insufficient = false;
            if(checkTotal < checkDiscount) {
                this.is_insufficient = true;
                this.$message.error('To much discount');
                service.discount = null
                service.amount = checkTotal
                setTimeout(() => {
                    this.loadingAmount = false
                    this.indexAmount = ''
                }, 100)
                return;
            }
            service.amount = checkTotal
            setTimeout(() => {
                this.loadingAmount = false
                this.indexAmount = ''
            }, 100)
        },
        changeDiscount(e, service, index) {
            this.is_insufficient = false
            this.loadingAmount = true
            this.indexAmount = index
            if(service.quantity) {
                let service_fee = parseFloat(service.service_fee) * parseFloat(service.quantity)
                service_fee = parseFloat(service_fee)
                if(service_fee < parseFloat(e)) {
                    this.$message.error('To much discount');
                    service.discount = null
                    service.amount = service_fee
                    this.is_insufficient = true
                    setTimeout(() => {
                        this.loadingAmount = false
                        this.indexAmount = ''
                    }, 100)
                    return
                }
                let amount = service.amount
                service.amount = amount
                setTimeout(() => {
                    this.loadingAmount = false
                    this.indexAmount = ''
                }, 100)

                return
            }

            setTimeout(() => {
                this.loadingAmount = false
                this.indexAmount = ''
            }, 100)
            return service.discount = null;
        },
        customerChange(value) {
            let customer = this.customers.find(customer => customer.id == value)
            this.customer = customer
            this.isSelectCustomer = true
        },
        async getInvoiceNumber() {
            try {
                this.loadingNumber = true;
                const res = await this.$API.Invoice.getInvoiceNumber();
                this.form.ref_number = res.data
                this.loadingNumber = false
            } catch (error) {
                console.log(error);
            }
        },
        async findInvoice() {
            try {
                this.loadingProposal = true

                const res = await this.$API.Invoice.findInvoice(this.id);
                let proposal = res.data
                console.log(proposal);
                this.form = {
                    customer_id : res.data.customer_id,
                    issue_date: res.data.issue_date,
                    due_date: res.data.due_date,
                    project_id: res.data.project.name,
                    project_id_id: res.data.project.id,
                    ref_number: res.data.ref_number,
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
        async findCustomer() {
            try {
                this.loadingCustomer = true
                const res = await this.$API.Customer.findCustomer(this.form.customer_id);
                this.customer = res.data
                this.isSelectCustomer = true
                this.loadingCustomer = false
            } catch (error) {
                console.log(error);
            }
        },
        subtotal() {
            let amounts = [] = this.form.services.map(service => {
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
            let discounts = [] = this.form.services.map(service => {
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

            let taxes = [] = this.form.services.map(service => {
                let total = 0
                let subtotal = 0
                let tax = 0
                if(service.tax && typeof service.tax === 'object' && service.tax.constructor === Object) {
                    if(service.amount) {
                        tax = parseFloat(service.tax.rate) / 100
                        console.log(service.amount, 'amount');
                        subtotal = parseFloat(service.amount) * tax
                        console.log(subtotal, 'subtotal');
                        total+=subtotal
                    }
                }
                else if(service.tax) {
                    if(service.amount) {
                        tax = parseFloat(service.tax) / 100
                        console.log(service.amount, 'amount');
                        subtotal = parseFloat(service.amount) * tax
                        console.log(subtotal, 'subtotal');
                        total+=subtotal
                    }
                }
                return total
            })

            console.log(taxes, 'taxes');

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
        total() {
            return (parseFloat(this.subtotal()) + parseFloat(this.tax()) - parseFloat(this.discount())).toFixed(2);
        },
        cancel() {
            this.$router.push({name: 'Invoices'})
        }
    },
}
</script>
