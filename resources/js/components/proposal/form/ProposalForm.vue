<template>
    <div>
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{title}}</h5>
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
                                            <el-form-item label="Proposal Number" prop="proposal_number">
                                                <el-input v-loading="loadingNumber" disabled v-model="form.proposal_number">
                                                    <template slot="prepend"><i class="fas fa-file"></i></template>
                                                </el-input>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-6">
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
                                                    <el-input type="number" v-model="service.service_fee" @change="changeServiceFee($event, service, index)" placeholder="Servicee Fee.."></el-input>
                                                    <div class="invalid-feedback_item" v-if="error.length > 0 && index == error[0].index">
                                                        {{error[0].service_fee}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <el-input type="number" min="0" v-model="service.quantity"  placeholder="Quantity.." @change="changeQuantity($event, service, index)"></el-input>
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
                                                    <el-input v-model="service.discount"  @change="changeDiscount($event, service, index)" type="number" min="0" placeholder="Discount"></el-input>
                                                </td>
                                                <td>
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
                                                <td>{{subtotal() | addComma}}</td>
                                                <td colspan="6"></td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Discount</td>
                                                <td> {{discount() | addComma}}</td>
                                                <td colspan="6"></td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Tax</td>
                                                <td> {{tax() | addComma}}</td>
                                                <td colspan="6"></td>
                                            </tr>
                                            <tr class="proposal_total">
                                                <td>Total Amount</td>
                                                <td> {{total() | addComma}}</td>
                                                <td colspan="6"></td>
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
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProposalForm',
    props: {
        mode: null,
        model: {},
        id: 0
    },
    data() {
        return {
            form: {
                customer_id: null,
                issue_date: null,
                project_id: null,
                proposal_number: null,
                services: []
            },
            rules: {
                customer_id: [
                    {required: true, message: 'Please select Customer', trigger: 'blur'}
                ],
                issue_date: [
                    {required: true, message: 'Please input Issue Date', trigger: 'blur'}
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
                project_id: this.model.project.name,
                project_id_id: this.model.project.id,
                proposal_number: this.model.proposal_number,
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
            this.title = 'Update Proposal'
            this.findCustomer();
        } else if (this.id) {

            this.title = 'Update Proposal'
            this.findProposal()

        } else {
            this.title = 'Create Proposal'
            this.getProposalNumber();
        }
    },
    filters: {
        addComma(value) {
            if(value) {
                return 'P '+ value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
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
                    this.updateProposal();
                    return
                }
                this.storeProposal();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.form.services = []
            this.getProposalNumber();
        },
        async storeProposal() {
            try {
                this.form.issue_date = this.$df.formatDate(this.form.issue_date, "YYYY-MM-DD")
                this.form.services.forEach((service, index) => {
                    let fee = service.hasOwnProperty('service_fee')
                    if(!fee) {
                        this.error.push({service_fee: 'Please Input Service Fee', index})
                        return;
                    }
                    else {
                        if(service.service_fee == '') {
                            this.error.push({service_fee: 'Please Input Service Fee', index})
                            return
                        }
                    }

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

                if(this.is_insufficient) {
                    this.disableButton = false
                    this.is_insufficient = false
                    return
                }

                this.form.services.forEach((service, index) => {
                    let discount = service.hasOwnProperty('discount')
                    if(!discount) {
                        service.discount = ''
                        return
                    }
                })

                // this.form.services.forEach((service, index) => {
                //     let quantity = service.hasOwnProperty('quantity')
                //     if(!quantity) {
                //         this.error.push({message: 'Please Input Quantity', index})
                //         return
                //     }
                // })
                this.disableButton = true
                const res = await this.$API.Proposal.storeProposal(this.form);
                this.disableButton = false
                this.resetForm('form');
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.$router.push({name: 'Proposals'})
            } catch (error) {
                console.log(error);
            }
        },
        async updateProposal() {
            try {
                this.form.issue_date = this.$df.formatDate(this.form.issue_date, "YYYY-MM-DD")
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

                if(this.is_insufficient) {
                    this.disableButton = false
                    this.is_insufficient = false
                    return
                }

                this.form.services.forEach((service, index) => {
                    let discount = service.hasOwnProperty('discount')
                    if(!discount) {
                        service.discount = ''
                        return
                    }
                })
                this.disableButton = true
                const res = await this.$API.Proposal.updateProposal(this.id, this.form)
                this.disableButton = false
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.$router.push({name: 'Proposal View', params: {id : this.id} })
            } catch (error) {
                console.log(error);
            }
        },
        async getProposalNumber() {
            try {
                this.loadingNumber = true;
                const res = await this.$API.Proposal.getProposalNumber();
                this.form.proposal_number = res.data
                this.loadingNumber = false
            } catch (error) {
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
                console.log('running');
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
            this.form.project_id_id = null;
            this.form.project_id = value
        },
        changeQuantity(e, service, index) {
            this.loadingAmount = true
            this.indexAmount = index
            let tax = 0
            if(service.tax) {
                // tax = parseInt(service.tax.rate) / 100;
            }

            let checkTotal = (parseFloat(e) * parseFloat(service.service_fee))
            let checkDiscount = parseFloat(service.discount)
            console.log(checkTotal, checkDiscount);
            if(checkTotal < checkDiscount) {

                this.$message.error('To much discount');
                this.is_insufficient = true
                service.discount = null
                service.amount = checkTotal
                setTimeout(() => {
                    this.loadingAmount = false
                    this.indexAmount = ''
                }, 100)
                return;
            }

            let totalTax = (parseInt(e) * service.service_fee) * tax

            service.amount = parseInt(e) * service.service_fee
            setTimeout(() => {
                this.loadingAmount = false
                this.indexAmount = ''
            }, 100)
        },
        changeServiceFee(e, service, index) {
            let service_fee = parseFloat(e);
            let tax= 0
            if(service.tax) {
                tax = parseFloat(service.tax.rate) / 100;
            }

            service.amount = (service_fee * service.quantity)
        },
        changeDiscount(e, service, index) {
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
        async findProposal() {
            try {
                this.loadingProposal = true

                const res = await this.$API.Proposal.findProposal(this.id);
                let proposal = res.data
                console.log(proposal);
                this.form = {
                    customer_id : res.data.customer_id,
                    issue_date: res.data.issue_date,
                    project_id: res.data.project.name,
                    project_id_id: res.data.project.id,
                    proposal_number: res.data.proposal_number,
                    services: res.data.items.map(service => {
                        return {
                            amount: service.price,
                            service_fee : service.service_fee,
                            id: service.id,
                            tax: service.tax_rate,
                            unit: service.unit,
                            discount: service.discount,
                            product_id: service.product_id,
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
            return total.toFixed(2)
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
            return total.toFixed(2)
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

            return total.toFixed(2)
        },
        total() {

            return (parseFloat(this.subtotal()) + parseFloat(this.tax()) - parseFloat(this.discount())).toFixed(2);
        },
        cancel() {
            this.$router.push({name: 'Proposals'})
        }

    },
    watch: {
        'form.services'(newVal, oldVal) {
            if(newVal != oldVal) {
                this.subtotal()
            }
        },
    }
}
</script>
<style lang="scss">
    .proposal_total td {
        padding: 10px;
    }

    .service_list td {
        padding: 10px;
    }

    .invalid-feedback_item {
        color: #EC3434;
        font-size: 11px;
    }
</style>
