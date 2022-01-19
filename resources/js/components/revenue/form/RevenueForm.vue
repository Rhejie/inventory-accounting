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
                            <el-form-item label="Amount" prop="amount">
                                <el-input @keypress.native="isNumber($event)"  v-model="form.amount" placeholder="Amount..."></el-input>
                            </el-form-item>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
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
                        <div class="col-md-6">
                            <el-form-item label="Customer" prop="customer_id" >
                                <el-select
                                    v-model="form.customer_id"
                                    filterable
                                    clearable
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
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <el-form-item label="Project" prop="project_id">
                                <el-select
                                    v-model="form.project_id"
                                    style="width: 100%"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
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
    name: 'RevenueForm',
    props: {
        mode: null,
        model: {},
        id: null
    },
    data() {
        return {
            form: {
                date: '',
                amount: '',
                account_id: '',
                customer_id: '',
                reference: '',
                description: '',
                project_id: '',
                file: '',
            },
            rules:{
                date: [
                    {required: true, message: 'Please input Date', trigger: 'blur'}
                ],
                amount: [
                    {required: true, message: 'Please input Amount', trigger: 'blur'}
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
            customers: [],
            loadingCustomers: false,
            fileList: [],
            disableButton: false,
            loadingProjects: false,
            projects: []
        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_REVENUE', data => {
            this.resetForm('form')
        })
        if(this.model && this.model.id) {
            let file = ''
            if(this.model.attachable) {
                this.fileList = [{name: this.model.attachable.file_name, url: `${this.model.attachable.path}${this.model.attachable.file}`}]
                file = this.model.attachable.file
            }
            else {
                this.fileList = []
            }
            let customer_id = null
            let customer_id_id = null
            let project_id = null
            let project_id_id = null
            if(this.model.customer) {
                customer_id = this.model.customer.name
                customer_id_id = this.model.customer.id
            }
            if(this.model.project) {
                project_id = this.model.project.name
                project_id_id = this.model.project.id
            }
            this.form = {
                date: this.model.date,
                amount: this.model.amount,
                account_id: `${this.model.account.bank_name} - ${this.model.account.holder_name}`,
                customer_id,
                account_id_id : this.model.account_id,
                customer_id_id,
                reference: this.model.reference,
                description: this.model.description,
                file,
                project_id,
                project_id_id
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateRevenue();
                    return
                }
                this.storeRevenue();
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
        async storeRevenue() {
            try {
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                this.form.amount = this.$IF.removeComma(this.form.amount);
                let formData = new FormData()
                if(this.form.date) formData.append('date', this.form.date)
                if(this.form.amount) formData.append('amount', this.form.amount)
                if(this.form.description) formData.append('description', this.form.description)
                if(this.form.reference) formData.append('reference', this.form.reference)
                if(this.form.customer_id) formData.append('customer_id', this.form.customer_id)
                if(this.form.account_id) formData.append('account_id', this.form.account_id)
                if(this.form.file) formData.append('file', this.form.file)
                if(this.form.project_id) formData.append('project_id', this.form.project_id)
                if(this.form.file_name) formData.append('file_name', this.form.file_name)
                this.disableButton = true
                const res = await this.$API.Revenue.storeRevenue(formData)
                this.disableButton = false
                this.$EventDispatcher.fire('NEW_REVENUE', res.data)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.resetForm('form')
            } catch (error) {
                console.log(error);
            }
        },
        async updateRevenue() {
            try {
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                // this.form.amount = this.$IF.removeComma(this.form.amount);
                let formData = new FormData()
                if(this.form.date) formData.append('date', this.form.date)
                if(this.form.amount) formData.append('amount', this.form.amount)
                if(this.form.description) formData.append('description', this.form.description)
                if(this.form.reference) formData.append('reference', this.form.reference)
                if(this.form.customer_id) formData.append('customer_id', this.form.customer_id)
                if(this.form.customer_id_id) formData.append('customer_id_id', this.form.customer_id_id)
                if(this.form.account_id) formData.append('account_id', this.form.account_id)
                if(this.form.account_id_id) formData.append('account_id_id', this.form.account_id_id)
                if(this.form.file) formData.append('file', this.form.file)
                if(this.form.project_id) formData.append('project_id', this.form.project_id)
                if(this.form.project_id_id) formData.append('project_id_id', this.form.project_id_id)
                if(this.form.file_name) formData.append('file_name', this.form.file_name)
                if(this.form.remove_file) formData.append('remove_file', this.form.remove_file)
                this.disableButton = true
                const res = await this.$API.Revenue.updateRevenue(this.model.id, formData)
                this.disableButton = false
                this.$EventDispatcher.fire('UPDATE_REVENUE', res.data)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
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
        changeProjectId(value) {
            this.form.project_id_id = null;
            this.form.project_id = value
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
        accountChange(value) {

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
            let customer = this.customers.find(customer => customer.id == value)
            this.customer = customer
            this.isSelectCustomer = true
            this.form.customer_id_id = null
            this.form.customer_id = value
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
        mode(value) {
            if(value && value == 'create') {
                this.form = {
                    date: '',
                    amount: '',
                    account_id: '',
                    customer_id: '',
                    reference: '',
                    description: '',
                }

                this.fileList = []
            }
        },
        model(newVal, oldVal) {
            if(newVal != oldVal&& this.mode == 'update') {
                let file = ''
                if(newVal.attachable) {
                    this.fileList = [{name: newVal.attachable.file_name, url: `${newVal.attachable.path}${newVal.attachable.file}`}]
                    file = newVal.attachable.file
                }
                else {
                    this.fileList = []
                }
                let customer_id = null
                let customer_id_id = null
                let project_id = null
                let project_id_id = null
                if(newVal.customer) {
                    customer_id = newVal.customer.name
                    customer_id_id = newVal.customer.id
                }
                if(newVal.project) {
                    project_id = newVal.project.name
                    project_id_id = newVal.project.id
                }
                this.form = {
                    date: newVal.date,
                    amount: newVal.amount,
                    account_id: `${newVal.account.bank_name} - ${newVal.account.holder_name}`,
                    customer_id,
                    account_id_id : newVal.account_id,
                    customer_id_id,
                    reference: newVal.reference,
                    description: newVal.description,
                    file: file,
                    project_id,
                    project_id_id
                }
                if(newVal.attachable) {
                    this.fileList = [{name: newVal.attachable.file_name, url: `${newVal.attachable.path}${newVal.attachable.file}`}]
                }
            }
        }
    }
}
</script>
