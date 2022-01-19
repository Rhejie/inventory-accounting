<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <el-form-item label="Date" prop="date">
                                <el-date-picker
                                    v-model="form.date"
                                    type="date"
                                    style="width:100%"
                                    placeholder="Pick a day">
                                </el-date-picker>
                            </el-form-item>
                        </div>
                        <div class="col-md-6">
                            <el-form-item label="Account" prop="account_id">
                                <el-select
                                    v-model="form.account_id"
                                    filterable
                                    @change="accountChange"
                                    remote
                                    :disabled="mode == 'update' ? true : false"
                                    reserve-keyword
                                    style="width:100%"
                                    placeholder="Please enter a keyword"
                                    :remote-method="remoteMethodAccounts"
                                    :loading="loadingAccounts">
                                        <el-option
                                            v-for="item in accounts"
                                            :key="item.id"
                                            :label="`${item.bank_name} - ${item.holder_name}`"
                                            :value="item.id">
                                        </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <el-form-item label="Amount" prop="amount">
                                <el-input type="number"  v-model="form.amount" placeholder="Amount..."></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-md-6">
                            <el-form-item label="Supplier" prop="supplier_id" >
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
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
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
                        <div class="col-md-6">
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
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <el-form-item label="Description" prop="description">
                                <el-input type="textarea" v-model="form.description" placeholder="Description..."></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-md-6">
                            <el-form-item label="Reference" prop="reference">
                                <el-input v-model="form.reference" placeholder="Reference..."></el-input>
                            </el-form-item>
                            <el-form-item label="File" prop="file">
                                <el-upload
                                    class="upload-demo"
                                    action=""
                                    ref="uploadDocument"
                                    name="projectDocument"
                                    :on-preview="handlePreview"
                                    :on-remove="handleRemove"
                                    :on-change="fileChange"
                                    :file-list="fileList"
                                    :auto-upload="false"
                                    :limit="1">
                                    <el-button size="small" type="primary">Click to upload File</el-button>
                                </el-upload>
                            </el-form-item>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <el-form-item style="float:right">
                        <el-button :disabled="disableButton" type="primary"  @click="submitForm('form')">Save</el-button>
                        <el-button :disabled="disableButton" @click="resetForm('form')"  v-if="mode != 'update'">Reset</el-button>
                    </el-form-item>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'PaymentForm',
    props : {
        model: {},
        mode: null,
    },
    data() {
        var amount = (rule, value, callback) => {
            if (value === '' || value === null) {
                callback(new Error('Please input Amount'));
            }
            else {
                if(this.mode == 'create') {
                    if(this.form.account_id) {
                        let account = this.accounts.find(acc => acc.id == this.form.account_id);
                        let amount = parseFloat(account.opening_balance)
                        if(amount < value) {
                            let due = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            callback(new Error('Insufficient funds (P'+due+')'));
                        }
                        else {
                            callback();
                        }
                    }
                    else if (this.form.account_id === '') {
                        callback(new Error('Please input Account'));
                    }
                    else {
                        callback();
                    }
                }
                else {
                    if(this.form.account_id_id) {
                        let account = this.model.account.opening_balance
                        let amount = parseFloat(account);
                        if(amount < value) {
                            let due = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            callback(new Error('Insufficient funds (P'+due+')'));
                        }
                        else {
                            callback();
                        }
                    }
                    else {
                        if(this.form.account_id) {
                            let account = this.accounts.find(acc => acc.id == this.form.account_id);
                            let amount = parseFloat(account.opening_balance)
                            if(amount < value) {
                                let due = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                callback(new Error('Insufficient funds (P'+due+')'));
                            }
                            else {
                                callback();
                            }
                        }
                        else {
                            callback(new Error('Please input Account'));
                        }
                    }
                }
            }
        };
        return {
            form: {
                date: '',
                amount: '',
                account_id: '',
                account_id_id: '',
                supplier_id: '',
                reference: '',
                description: '',
                file: '',
                customer_id: '',
                project_id: ''
            },
            rules:{
                date: [
                    {required: true, message: 'Please input Date', trigger: 'blur'}
                ],
                amount: [
                    { validator: amount, trigger: 'blur' }
                ],
                account_id: [
                    {required: true, message: 'Please select Account', trigger: 'blur'}
                ],
                reference: [
                    {required: true, message: 'Please input Reference', trigger: 'blur'}
                ],
                description: [
                    {required: true, message: 'Please input Description', trigger: 'blur'}
                ],
            },
            loadingAccounts: false,
            accounts: [],
            suppliers: [],
            loadingSupplier: false,
            fileList: [],
            disableButton:false,
            loadingCustomers: false,
            customers: [],
            loadingProjects: false,
            projects: []
        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_PAYMENT', data => {
            this.resetForm('form');
        })

        if(this.model && this.model.id && this.mode == 'update') {
            let file = ''
            if(this.model.attachable) {
                this.fileList = [{name: this.model.attachable.file_name, url: `${this.model.attachable.path}${this.model.attachable.file}`}]
                file = this.model.attachable.file
            }
            else {
                this.fileList = []
            }
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


            let supplier_name = ''
            if(!this.model.supplier) {
                supplier_name = ''
            }
            else {
                supplier_name = this.model.supplier.name
            }
            this.form = {
                supplier_id : supplier_name,
                supplier_id_id : this.model.supplier_id,
                account_id : `${this.model.account.bank_name} - ${this.model.account.holder_name}`,
                account_id_id : this.model.account_id,
                date: this.model.date,
                reference: this.model.reference,
                description: this.model.description,
                amount: this.model.amount,
                file,
                customer_id: customer_name,
                customer_id_id: this.model.customer_id,
                project_id: project_name,
                project_id_id: this.model.project_id,
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updatePayment();
                    return
                }
                this.storePayment();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.fileList = []
            this.$refs[formName].resetFields();
        },
        async storePayment() {
            try {
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                let formData = new FormData();
                if(this.form.date)formData.append('date', this.form.date);
                if(this.form.account_id)formData.append('account_id', this.form.account_id);
                if(this.form.supplier_id)formData.append('supplier_id', this.form.supplier_id);
                if(this.form.amount)formData.append('amount', this.form.amount);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.reference)formData.append('reference', this.form.reference);
                if(this.form.file)formData.append('file', this.form.file);
                if(this.form.file_name)formData.append('file_name', this.form.file_name);
                if(this.form.customer_id)formData.append('customer_id', this.form.customer_id);
                if(this.form.project_id)formData.append('project_id', this.form.project_id);
                this.disableButton = true
                const res = await this.$API.Payment.storePayment(formData);
                this.disableButton = false
                this.$EventDispatcher.fire('NEW_PAYMENT', res.data)
                this.resetForm('form')
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Store',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        async updatePayment() {
            try {
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                let formData = new FormData();
                if(this.form.date)formData.append('date', this.form.date);
                if(this.form.account_id)formData.append('account_id', this.form.account_id);
                if(this.form.account_id_id)formData.append('account_id_id', this.form.account_id_id);
                if(this.form.supplier_id)formData.append('supplier_id', this.form.supplier_id);
                if(this.form.supplier_id_id)formData.append('supplier_id_id', this.form.supplier_id_id);
                if(this.form.amount)formData.append('amount', this.form.amount);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.reference)formData.append('reference', this.form.reference);
                if(this.form.file)formData.append('file', this.form.file);
                if(this.form.file_name)formData.append('file_name', this.form.file_name);
                if(this.form.remove_file)formData.append('remove_file', this.form.remove_file);
                if(this.form.customer_id)formData.append('customer_id', this.form.customer_id);
                if(this.form.customer_id_id)formData.append('customer_id_id', this.form.customer_id_id);
                if(this.form.project_id)formData.append('project_id', this.form.project_id);
                if(this.form.project_id_id)formData.append('project_id_id', this.form.project_id_id);
                this.disableButton = true
                const res = await this.$API.Payment.updatePayment(this.model.id, formData)
                this.disableButton = false
                this.$EventDispatcher.fire('UPDATE_PAYMENT', res.data)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
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
            this.form.project_id = value;
        },
        async remoteMethodAccounts(query) {
            try {
                if (query !== '') {
                    this.loadingAccounts = true;
                    const res = await this.$API.Bank.searchAccount(query);
                    this.accounts = res.data
                    this.loadingAccounts = false;
                } else {
                    this.accounts = [];
                }
            } catch (error) {
                console.log(error);
            }
        },
        accountChange(value) {
            this.form.account_id_id = null,
            this.form.account_id = value
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
        changeSupplierID(value) {
            this.form.supplier_id_id = null;
            this.form.supplier_id = value;
        },
        isNumber(evt) {
            evt = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        handlePreview(file) {
            console.log(file);
        },
        handleRemove(file, fileList) {
            this.form.remove_file = true
            this.form.file = null
            this.form.file_name = null
            console.log(file, fileList);
        },
        fileChange(file, fileList) {
            this.form.file = file.raw
            this.form.file_name = file.name
        },
    },
    watch: {
        mode(val) {
            if(val && this.mode == 'create') {
                this.form = {
                    account_id : '',
                    supplier_id : '',
                    date: '',
                    amount: '',
                    description: '',
                    reference: '',
                }

                this.fileList = []
            }
        },
        model(newVal, oldVal) {
            if(newVal != oldVal && this.mode == 'update') {
                let file = ''
                if(this.model.attachable) {
                    this.fileList = [{name: newVal.attachable.file_name, url: `${newVal.attachable.path}${newVal.attachable.file}`}]
                    file = newVal.attachable.file
                }
                else {
                    this.fileList = []
                }
                let project_name = ''
                if(!newVal.project) {
                    project_name = ''
                }
                else {
                    project_name = newVal.project.name
                }

                let customer_name = ''
                if(!newVal.customer) {
                    customer_name = ''
                }
                else {
                    customer_name = newVal.customer.name
                }
                let supplier_name = ''
                if(!newVal.supplier) {
                    supplier_name = ''
                }
                else {
                    supplier_name = this.model.supplier.name
                }
                this.form = {
                    supplier_id : supplier_name,
                    supplier_id_id : newVal.supplier_id,
                    account_id : `${newVal.account.bank_name} - ${newVal.account.holder_name}`,
                    account_id_id : newVal.account_id,
                    date: newVal.date,
                    reference: newVal.reference,
                    description: newVal.description,
                    amount: newVal.amount,
                    file,
                    customer_id: customer_name,
                    customer_id_id: newVal.customer_id,
                    project_id: project_name,
                    project_id_id: newVal.project_id,
                }
            }
        }
    }
}
</script>
