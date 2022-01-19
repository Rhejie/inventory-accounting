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
                                    <el-form-item label="Supplier" prop="supplier_id" v-if="!isSelectBill">
                                        <el-select
                                            v-model="form.supplier_id"
                                            style="width: 100%"
                                            filterable
                                            remote
                                            reserve-keyword
                                            @change="changeSupplierID"
                                            placeholder="Please enter a keyword"
                                            :remote-method="remoteMethodSupplier"
                                            :loading="loadingSupplier">
                                                <el-option
                                                    v-for="item in suppliers"
                                                    :key="item.id"
                                                    :label="item.name"
                                                    :value="item.id">
                                                </el-option>
                                        </el-select>
                                    </el-form-item>
                                    <div class="row" v-if="isSelectBill" v-loading="loadingSupplier">
                                        <div class="col-lg-12">
                                            <h3>Supplier Information</h3>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <el-button size="mini" @click="removeSupplier" style="float:right" type="danger">Remove</el-button>
                                                </div>
                                                <div class="col-md-12 supplier">
                                                    <p>Name: {{supplier.name}}</p>
                                                    <p>Email: {{supplier.email}}</p>
                                                    <p>Contact: {{supplier.contact_no}}</p>
                                                    <p>Contact Person: {{supplier.contact_person}}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4>Bill To</h4>
                                                    <el-descriptions class="margin-top" :column="1">
                                                        <el-descriptions-item label="Name">{{supplier.billing_name}}</el-descriptions-item>
                                                        <el-descriptions-item label="Phone">{{supplier.billing_phone}}</el-descriptions-item>
                                                        <el-descriptions-item label="Country">{{supplier.billing_country}}</el-descriptions-item>
                                                        <el-descriptions-item label="State">{{supplier.billing_state}}</el-descriptions-item>
                                                        <el-descriptions-item label="City">{{supplier.billing_city}}</el-descriptions-item>
                                                        <el-descriptions-item label="Zip">{{supplier.billing_zip}}</el-descriptions-item>
                                                    </el-descriptions>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4>Ship To</h4>
                                                    <el-descriptions class="margin-top" :column="1">
                                                        <el-descriptions-item label="Name">{{supplier.shipping_name}}</el-descriptions-item>
                                                        <el-descriptions-item label="Phone">{{supplier.shipping_phone}}</el-descriptions-item>
                                                        <el-descriptions-item label="Country">{{supplier.shipping_country}}</el-descriptions-item>
                                                        <el-descriptions-item label="State">{{supplier.shipping_state}}</el-descriptions-item>
                                                        <el-descriptions-item label="City">{{supplier.shipping_city}}</el-descriptions-item>
                                                        <el-descriptions-item label="Zip">{{supplier.shipping_zip}}</el-descriptions-item>
                                                    </el-descriptions>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <h2>Purchase Order List</h2>
                                        <button type="button" v-if="form.supplier_id && this.id == null" class="btn btn-icon btn-success btn-sm" style="float:right" @click="handleRefresh">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                        <table class="table table-responsize">
                                            <thead>
                                                <th>NO.</th>
                                                <th>REF. NO</th>
                                                <th>PROJECT</th>
                                                <th>SUBTOTAL</th>
                                                <th>VAT</th>
                                                <th>DISCOUNT</th>
                                                <th>SUBTOTAL NET</th>
                                                <th>OTHERS</th>
                                                <th>AMOUNT</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(order, index) in form.orders" :key="order.id" class="service_list">
                                                    <td>{{index + 1}}</td>
                                                    <td>{{order.purchase_order_reference_no}}</td>
                                                    <td>{{order.project.name}}</td>
                                                    <td>{{order.subtotal | addComma}}</td>
                                                    <td>{{order.vat}}% ({{order | taxRate}})</td>
                                                    <td>{{order.discount | addComma}}</td>
                                                    <td>{{order.subtotal_net | addComma}}</td>
                                                    <td>{{order.others | addComma}}</td>
                                                    <td>{{order.total_net | addComma}}</td>
                                                    <td >
                                                        <el-button type="text" @click="removePO(index, order.id)" size="mini"><i class="fas fa-trash"></i></el-button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="9" style="padding:10px">
                                                        <el-select
                                                            v-model="purchase_order"
                                                            filterable
                                                            remote
                                                            reserve-keyword
                                                            @change="changePOFormID"
                                                            placeholder="Please enter a keyword"
                                                            :remote-method="remoteMethodPOForms"
                                                            :loading="loadingForm">
                                                                <el-option
                                                                    v-for="item in purchaseOrderForms"
                                                                    :key="item.id"
                                                                    :label="`${item.purchase_order_reference_no}`"
                                                                    :value="item.id">
                                                                </el-option>
                                                        </el-select>
                                                    </td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Subtotal</td>
                                                    <td colspan="8">{{subtotal | addComma}}</td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Discount</td>
                                                    <td colspan="8">{{discount | addComma}}</td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Tax</td>
                                                    <td colspan="8">{{tax | addComma}}</td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Subtotal Net</td>
                                                    <td colspan="8">{{subtotal_net | addComma}}</td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Others</td>
                                                    <td colspan="8">{{others | addComma}}</td>
                                                </tr>
                                                <tr class="proposal_total">
                                                    <td>Total Amount</td>
                                                    <td colspan="8">{{total | addComma}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                customer_id: '',
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
            purchase_order: '',
            purchaseOrderForms: [],
            loadingForm: false,
            loadingProjects: false,
            projects: [],
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
            this.isSelectBill = true;
            this.form = {
                supplier_id: this.model.supplier_id,
                bill_number: this.model.bill_number,
                bill_date: this.model.bill_date,
                due_date: this.model.due_date,
                project_id: project_name,
                customer_id: customer_name,
                customer_id_id: this.model.customer_id,
                project_id_id: this.model.project_id,
                orders: this.model.bill_item.map(order => {
                    order.purchase_order_reference_no = order.purchase_order_number
                    order.total_net = order.amount
                })
            }
            this.getPurchaseOrdersUpdate();
            this.supplier = this.model.supplier
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
                    console.log('subtotal', order.subtotal);
                    total += order.subtotal
                })
                return parseFloat(total).toFixed(2)
            }
        },
        discount() {
            if(this.loadingPurchaseOrder) return
            if(this.form.orders) {
                let total = 0
                this.form.orders.forEach(order => {
                    total += order.discount
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
                        if(order.vat == 0 || !order.vat) return
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
        async storeBill() {
            try {
                this.form.bill_date = this.$df.formatDate(this.form.bill_date, "YYYY-MM-DD")
                this.form.due_date = this.$df.formatDate(this.form.due_date, "YYYY-MM-DD")
                this.form.remove_items = this.removeItems;
                this.form.type = 'po'
                this.disableButton = true
                const res = await this.$API.Bill.storeBill(this.form);
                this.disableButton = false
                this.$router.push({name: 'Bill View', params: {id: this.id, model: res.data} })
                this.$router.push({name: 'Bill List'})
                this.resetForm('form');
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
                this.disableButton = true
                const res = await this.$API.Bill.updateBill(this.id, this.form)
                this.disableButton = false
                this.$router.push({name: 'Bill View', params: {id: this.id, model: res.data} })
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
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
        changeProjectId(value) {
            this.form.project_id_id = null;
            this.form.project_id = value;
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
        async remoteMethodSupplier(query) {
            if (query !== '') {
                this.loadingSuppliers = true;
                try {
                    const res = await this.$API.PurchaseOrder.getSuppliers(query);
                    this.suppliers = res.data
                    this.loadingSuppliers = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.suppliers = [];
            }
        },
        async remoteMethodPOForms(query) {
            if (query !== '') {
                this.loadingForm = true;
                try {
                    const res = await this.$API.PurchaseOrder.getPurchaseOrderFormsToBill(query);
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
            let po = this.purchaseOrderForms.find(p => p.id == value);
            po.status = 'new'
            this.form.orders.push(po)
            this.purchase_order = ''
            this.purchaseOrderForms = []
        },
        changeSupplierID(value) {
            let supplier = this.suppliers.find(supplier => supplier.id == value);
            this.supplier = supplier;
            this.isSelectBill = true;
            this.getPurchaseOrders();
        },
        removeSupplier() {
            this.form.supplier_id =  ''
            this.supplier = {}
            this.isSelectBill = false
            this.form.orders = []
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
        async getPurchaseOrders() {
            try {
                this.loadingPurchaseOrder = true
                const res = await this.$API.PurchaseOrder.getPurchaseOrdersBySupplier(this.form.supplier_id)
                this.form.orders = res.data
                this.loadingPurchaseOrder = false
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
                    order.purchase_order_reference_no = order.purchase_order_number
                    order.total_net = order.amount
                })
                this.loadingPurchaseOrder = false
            } catch (error) {
                console.log(error);
            }
        },
        async getBillInfo() {
            try {
                this.loadingBill = true
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
                    supplier_id : res.data.supplier_id,
                    bill_number : res.data.bill_number,
                    bill_date: res.data.bill_date,
                    due_date: res.data.due_date,
                    project_id: project_name,
                    customer_id: customer_name,
                    customer_id_id: res.data.customer_id,
                    project_id_id: res.data.project_id,
                    orders: res.data.bill_item.map(order => {
                        order.purchase_order_reference_no = order.purchase_order_number
                        order.total_net = order.amount
                    })
                }
                this.supplier = res.data.supplier
                this.isSelectBill = true;
                this.loadingBill = false
                await this.getPurchaseOrdersUpdate();
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
