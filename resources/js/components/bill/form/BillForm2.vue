<template>
    <div>
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Create Bill </h5>
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
                    <div class="text item" v-loading="loadingBill">
                        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
                            <div class="row">
                                <div class="col-md-5">
                                    <el-form-item label="Title" prop="title" >
                                        <el-input v-model="form.title" placeholder="Title...."></el-input>
                                    </el-form-item>
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <el-form-item label="Bill Date" prop="bill_date">
                                                <el-date-picker
                                                    v-model="form.bill_date"
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
                                            <el-form-item label="Bill Number" prop="bill_number">
                                                <el-input v-loading="loadingNumber" disabled v-model="form.bill_number">
                                                    <template slot="prepend"><i class="fas fa-file"></i></template>
                                                </el-input>
                                            </el-form-item>
                                            <el-form-item label="Project" prop="project_id">
                                                <el-select
                                                    v-model="form.project_id"
                                                    style="width: 100%"
                                                    filterable
                                                    remote
                                                    clearable
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
                                        <div class="col-md-6">
                                            <el-form-item label="Customer" prop="customer_id">
                                                <el-select
                                                    v-model="form.customer_id"
                                                    filterable
                                                    @change="customerChange"
                                                    remote
                                                    clearable
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
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="po_list" v-loading="loadingPurchaseOrder">
                                        <h2>Expenses</h2>
                                        <button type="button" class="btn btn-primary btn-sm" style="float:right" @click="addItem">
                                            Add Item
                                        </button>
                                        <div class="table-responsive">
                                            <table class="table table-head-custom table-vertical-center">
                                                <thead class="text-uppercase">
                                                    <th  class="pl-0">NO.</th>
                                                    <th  class="pl-0">NAME</th>
                                                    <th  class="pl-0">COMPANY</th>
                                                    <th  class="pl-0">EXPENSE FEE</th>
                                                    <th  class="pl-0">VAT</th>
                                                    <th  class="pl-0">DISCOUNT</th>
                                                    <th  class="pl-0">SUBTOTAL NET</th>
                                                    <th  class="pl-0">OTHERS</th>
                                                    <th  class="pl-0">AMOUNT</th>
                                                    <th  class="pl-0"></th>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(order, index) in form.orders" :key="order.id" class="service_list">
                                                        <td>{{index + 1}}</td>
                                                        <td>
                                                            <el-input v-model="order.name" placeholder="Name...."></el-input>
                                                        </td>
                                                        <td>
                                                            <el-input v-model="order.company_name" placeholder="Company...."></el-input>
                                                        </td>
                                                        <td>
                                                            <el-input v-model="order.subtotal" @change="changeSubtotal($event, order)" type="number" min="0" placeholder="Expense Fee...."></el-input>
                                                        </td>
                                                        <td>
                                                            <el-input v-model="order.vat" @change="changeVat($event, order)" type="number" min="0" placeholder="Vat...."></el-input>
                                                        </td>
                                                        <td>
                                                            <el-input v-model="order.discount" @change="changeDiscount($event, order)" type="number" min="0" placeholder="Discount...."></el-input>
                                                        </td>
                                                        <td>
                                                            <el-input v-model="order.subtotal_net" disabled type="number" min="0" placeholder="Subtotal Net...."></el-input>
                                                        </td>
                                                        <td>
                                                            <el-input v-model="order.others" @change="changeOrder($event, order)" type="number" min="0" placeholder="Other...."></el-input>
                                                        </td>
                                                        <td>
                                                            <el-input v-model="order.total_net" disabled type="number" min="0" placeholder="Amount...."></el-input>
                                                        </td>
                                                        <td >
                                                            <el-button type="text" @click="removePO(index, order.id)" size="mini"><i class="fas fa-trash"></i></el-button>
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
                                                        <td>Total Amount</td>
                                                        <td colspan="9">{{total | addComma}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
import ConsumableSupplyListVue from '../../consumable_supply/partails/ConsumableSupplyList.vue';
export default {
    name: 'BillForm',
    props: {
        id: null,
        model: {},
        mode: null
    },
    data() {
        return {
            form: {
                bill_number: '',
                orders: [],
                supplier_id: '',
                bill_date: '',
                due_date: '',
                project_id: '',
                customer_id: ''
            },
            rules: {
                supplier_id: [
                    {required: true, message: 'Please select Supplier', trigger: 'blur'}
                ],
                bill_date: [
                    {required: true, message: 'Please input Bill Date', trigger: 'blur'}
                ],
                due_date: [
                    {required: true, message: 'Please input Due Date', trigger: 'blur'}
                ],
                title: [
                    {required: true, message: 'Please input Title', trigger: 'blur'}
                ],
            },
            isSelectBill: false,
            loadingSuppliers: false,
            suppliers: [],
            supplier: {},
            loadingSupplier: false,
            loadingNumber: false,
            purchaseOrders: [],
            loadingPurchaseOrder: false,
            removeItems: [],
            disableButton: false,
            loadingBill: false,
            loadingProjects: false,
            projects: [],
            is_insufficient: false,
            loadingCustomers: false,
            customers: [],
        }
    },
    created() {
        if(this.model && this.model.id) {
            let project_name = ''
            if(!this.model.project) {
                project_name = ''
            }
            else {
                project_name = this.model.project.name
            }

            let customer_name = ''
            if(!this.model.customer) {
                customer_name = ''
            }
            else {
                customer_name = this.model.customer.name
            }
            this.form = {
                title: this.model.title,
                bill_number: this.model.bill_number,
                bill_date: this.model.bill_date,
                project_id: project_name,
                customer_id: customer_name,
                customer_id_id: this.model.customer_id,
                project_id_id: this.model.project_id,
                due_date: this.model.due_date,
                orders: this.model.bill_item.map(order => {
                        order.total_net = order.amount
                        return order
                    }),
            }
        }
        else if(this.id) {
            this.getBillInfo()
        }
        else {
            this.getBillNumber()
        }
    },
    filters: {
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
            if(this.loadingPurchaseOrder) return
            if(this.form.orders) {
                let total = 0
                this.form.orders.forEach(order => {
                    total = parseFloat(parseFloat(total)) + parseFloat(parseFloat(order.subtotal).toFixed(2))
                })
                return parseFloat(total).toFixed(2)
            }
        },
        discount() {
            if(this.loadingPurchaseOrder) return
            if(this.form.orders) {
                let total = 0
                this.form.orders.forEach(order => {
                    total += parseFloat(order.discount).toFixed(2)
                })

                return parseFloat(total).toFixed(2)
            }
        },
        tax() {
            let total = 0
            if(this.loadingPurchaseOrder) return
            if(this.form.orders) {
                this.form.orders.forEach(order => {
                    let tax = 0
                    let subtotal = 0
                    let total_tax = 0;
                    if(order.subtotal) {
                        tax = parseFloat(order.vat) / 100
                        subtotal = parseFloat(order.subtotal) * tax
                        total_tax += subtotal
                    }

                    total += total_tax;
                })
            }

            return parseFloat(total).toFixed(2)
        },
        others() {
            if(this.loadingPurchaseOrder) return
            if(this.form.orders) {
                let total = 0
                this.form.orders.forEach(order => {
                    total += order.others
                })

                return parseFloat(total).toFixed(2)
            }
        },
        subtotal_net() {
            if(this.loadingPurchaseOrder) return
            if(this.form.orders) {
                let total = 0
                this.form.orders.forEach(order => {
                    total += order.subtotal_net
                })

                return parseFloat(total).toFixed(2)
            }
        },
        total() {
            if(this.loadingPurchaseOrder) return
            if(this.form.orders) {
                let total = 0
                this.form.orders.forEach(order => {
                    total += order.total_net
                    total += order.others
                })

                return parseFloat(total).toFixed(2)
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update' || this.id) {
                    this.updateBill();
                    return
                }
                this.storeBill();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.getBillNumber()
            this.$refs[formName].resetFields();
        },
        cancel() {
            this.$router.push({name: 'Bill List'})
        },
        changeFile(file, order, index) {
            // console.log(order.file);
            const fileInput = document.getElementById(`file${index}`);
            const selectedFile = fileInput.files[0];
            console.log(selectedFile);
            order.file = selectedFile;
        },
        addItem() {
            this.form.orders.push({
                id: '',
                name: '',
                company_name: '',
                subtotal: 0,
                vat: 0,
                discount: 0,
                subtotal_net: 0,
                others: 0,
                total_net: 0,
            })
        },
        changeSubtotal(e, order) {
            let s = e ? e : 0 ;
            let subtotal = parseFloat(s).toFixed(2)
            let v = order.vat ? order.vat : 0
            let vat = parseFloat(v).toFixed(2) / 100
            let d = order.discount ? order.discount : 0;
            let discount = parseFloat(d).toFixed(2)
            let tax = subtotal * vat
            subtotal = parseFloat(subtotal).toFixed(2)
            tax = parseFloat(tax).toFixed(2)

            let total = parseFloat(subtotal) + parseFloat(tax);
            total = parseFloat(total)
            discount = parseFloat(discount)
            if(total < discount) {
                this.$message.error('To much discount');
                order.discount = null
                return;
            }
            order.subtotal_net = ( parseFloat(subtotal) + parseFloat(tax) ) - parseFloat(discount)
            order.subtotal_net = parseFloat(order.subtotal_net).toFixed(2)
            order.total_net = parseFloat(parseFloat(order.subtotal_net).toFixed(2)) + parseFloat(parseFloat(order.others).toFixed(2))
            order.total_net = parseFloat(order.total_net).toFixed(2)
        },
        changeVat(e, order) {
            let v = e ? e : 0;
            order.vat = v
            let s = order.subtotal ? order.subtotal : 0;
            let d = order.discount ? order.discount : 0;
            let vat = parseFloat(v).toFixed(2) / 100
            let subtotal = parseFloat(s).toFixed(2)
            let discount = parseFloat(d).toFixed(2)
            let tax = parseFloat(subtotal).toFixed(2) * parseFloat(vat).toFixed(2)

            let total = parseFloat(subtotal) + parseFloat(tax);

            total = parseFloat(total)

            discount = parseFloat(discount)
            if(total < discount) {
                this.$message.error('To much discount');
                this.is_insufficient = true
                order.discount = null
                order.subtotal_net = ( parseFloat(subtotal) + parseFloat(tax) )
                return;
            }
            order.subtotal_net = ( parseFloat(subtotal) + parseFloat(tax) ) - parseFloat(discount)
            order.subtotal_net = parseFloat(order.subtotal_net).toFixed(2)
            order.total_net = parseFloat(parseFloat(order.subtotal_net).toFixed(2)) + parseFloat(parseFloat(order.others).toFixed(2))
            order.total_net = parseFloat(order.total_net).toFixed(2)

        },
        changeDiscount(e, order) {
            let d = e ? e : 0;
            let s = order.subtotal ? order.subtotal : 0;
            let v = order.vat ? order.vat : 0;
            let vat = parseFloat(v).toFixed(2) / 100
            let subtotal = parseFloat(s).toFixed(2)
            let discount = parseFloat(d).toFixed(2)
            let tax = parseFloat(subtotal).toFixed(2) * parseFloat(vat).toFixed(2)

            let total = parseFloat(subtotal) + parseFloat(tax);
            total = parseFloat(total)
            discount = parseFloat(discount)
            if(total < discount) {
                this.$message.error('To much discount');
                this.is_insufficient = true
                order.discount = null
                return;
            }
            order.subtotal_net = ( parseFloat(subtotal) + parseFloat(tax) ) - parseFloat(discount)
            order.subtotal_net = parseFloat(order.subtotal_net).toFixed(2)
            order.total_net = parseFloat(parseFloat(order.subtotal_net).toFixed(2)) + parseFloat(parseFloat(order.others).toFixed(2))
            order.total_net = parseFloat(order.total_net).toFixed(2)
        },
        changeOrder(e, order) {
            let o = e ? e : 0;
            let other = parseFloat(o).toFixed(2)
            order.others = other
            let subtotal_net = parseFloat(order.subtotal_net).toFixed(2)
            const total =  parseFloat(parseFloat(subtotal_net).toFixed(2)) + parseFloat(parseFloat(other).toFixed(2))
            console.log(total);
            order.total_net = parseFloat(total).toFixed(2)
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
        customerChange(value) {
            this.form.customer_id_id = null;
            this.form.customer_id = value;
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
        changeProjectId(value) {
            this.form.project_id_id = null;
            this.form.project_id = value
        },
        async storeBill() {
            try {
                this.form.bill_date = this.$df.formatDate(this.form.bill_date, "YYYY-MM-DD")
                this.form.due_date = this.$df.formatDate(this.form.due_date, "YYYY-MM-DD")
                this.form.remove_items = this.removeItems;
                this.form.type = 'company'
                if(this.is_insufficient) {
                    this.is_insufficient = false;
                    this.disableButton = false
                    return
                }
                this.disableButton = true
                const res = await this.$API.Bill.storeBill(this.form);
                this.disableButton = false
                this.$router.push({name: 'Bill View 2', params: {id: res.data.id, model: res.data} })
                // this.$router.push({name: 'Bill List'})
                // this.resetForm('form');
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        async updateBill() {
            try {
                this.form.bill_date = this.$df.formatDate(this.form.bill_date, "YYYY-MM-DD")
                this.form.due_date = this.$df.formatDate(this.form.due_date, "YYYY-MM-DD")
                this.form.remove_items = this.removeItems;
                if(this.is_insufficient) {
                    this.is_insufficient = false;
                    this.disableButton = false
                    return
                }
                this.disableButton = true;
                const res = await this.$API.Bill.updateBill(this.id, this.form)
                this.disableButton = false;
                this.$router.push({name: 'Bill View 2', params: {id: this.id, model: res.data} })
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        async getPurchaseOrdersUpdate() {
            try {
                this.loadingPurchaseOrder = true
                const res = await this.$API.Bill.getPurchaseOrdersByBillUpdate(this.id)
                this.form.orders = res.data
                this.form.orders.map(order => {
                    order.total_net = order.amount
                })
                this.loadingPurchaseOrder = false
            } catch (error) {
                console.log(error);
            }
        },
        async getBillNumber() {
            try {
                this.loadingNumber = true;
                const res = await this.$API.Bill.getNumber();
                this.form.bill_number = res.data
                this.loadingNumber = false
            } catch (error) {
                console.log(error);
            }
        },
        async getBillInfo() {
            try {
                this.loadingBill = true
                // await this.getPurchaseOrdersUpdate();
                const res = await this.$API.Bill.viewBill(this.id);
                let project_name = ''
                if(!res.data.project) {
                    project_name = ''
                }
                else {
                    project_name = res.data.project.name
                }
                let customer_name = ''
                if(!res.data.customer) {
                    customer_name = ''
                }
                else {
                    customer_name = res.data.customer.name
                }
                this.form = {
                    title : res.data.title,
                    bill_number : res.data.bill_number,
                    bill_date: res.data.bill_date,
                    due_date: res.data.due_date,
                    orders: res.data.bill_item.map(order => {
                        order.total_net = order.amount
                        return order
                    }),
                    project_id: project_name,
                    customer_id: customer_name,
                    customer_id_id: res.data.customer_id,
                    project_id_id: res.data.project_id,
                }
                this.loadingBill = false
            } catch (error) {
                console.log(error);
            }
        },
        removePO(index, id) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.delete(index, id);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                })
        },
        delete(index, id) {
            console.log('delete', index, id);
            this.removeItems.push(id);
            this.form.orders.splice(index, 1)
        },
        handleRefresh() {
            this.getPurchaseOrders();
        }
    },
}
</script>
<style lang="scss">
    .supplier {
        line-height: 0.8
    }
    .po_list {
        margin-top: 20px;
    }
</style>
