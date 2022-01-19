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
                                <el-input type="number"  v-model="form.amount" placeholder="Amount..."></el-input>
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
                            <el-form-item label="Reference" prop="reference">
                                <el-input v-model="form.reference" placeholder="Reference..."></el-input>
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
                        <el-button :disabled="disabledButton" type="primary"  @click="submitForm('form')">Save</el-button>
                        <el-button :disabled="disabledButton" @click="resetForm('form')"  v-if="mode != 'update'">Reset</el-button>
                    </el-form-item>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'InvoicePaymentForm',
    props: {
        mode: null,
        model: {},
        id: null,
        dueAmount: null,
    },
    data() {
        var validatePass2 = (rule, value, callback) => {
            value = parseFloat(value)
            if (value === '') {
                callback(new Error('Please input Amount'));
            }
            else if(value > this.dueAmount) {
                callback(new Error('The Amount is greater than due amount'));
            }
            else {
                callback();
            }
        }
        return {
            form: {
                date: '',
                amount: '',
                account_id: '',
                reference: '',
                description: '',
                file: ''
            },
            rules:{
                date: [
                    {required: true, message: 'Please input Date', trigger: 'blur'}
                ],
                amount: [
                    { validator: validatePass2, trigger: 'blur' }
                ],
                account_id: [
                    {required: true, message: 'Please select Account', trigger: 'blur'}
                ],
                file: [
                    {required: true, message: 'Please select File', trigger: 'blur'}
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
            fileList: [],
            disabledButton: false,
        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_RECEIPT', data => {
            this.resetForm('form')
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateReceipt();
                    return
                }
                this.storeReceipt();
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

        },
        isNumber($event) {
            // console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);

            // only allow number and one dot
            if ((keyCode < 48 || keyCode > 57) && (keyCode !== 46 || this.form.amount.indexOf('.') != -1)) { // 46 is dot

                $event.preventDefault();
            }

            // restrict to 2 decimal places
            if(this.form.amount!=null && this.form.amount.indexOf(".")>-1 && (this.form.amount.split('.')[1].length > 1)){

                $event.preventDefault();
            }
        },
        async storeReceipt() {
            try {
                this.form.invoice_id = this.id
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                this.form.amount = this.$IF.removeComma(this.form.amount);
                let formData = new FormData()
                if(this.form.invoice_id)formData.append('invoice_id', this.form.invoice_id)
                if(this.form.amount)formData.append('amount', this.form.amount)
                if(this.form.date)formData.append('date', this.form.date)
                if(this.form.description)formData.append('description', this.form.description)
                if(this.form.account_id)formData.append('account_id', this.form.account_id)
                if(this.form.reference)formData.append('reference', this.form.reference)
                if(this.form.file)formData.append('file', this.form.file)
                if(this.form.file_name)formData.append('file_name', this.form.file_name)
                this.disabledButton = true
                const res = await this.$API.InvoicePayment.storePayment(formData)
                this.disabledButton = false
                this.$EventDispatcher.fire('NEW_PAYMENT', res.data)
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
        handlePreview(file) {
            console.log(file);
        },
        handleRemove(file, fileList) {
            console.log(file, fileList);
        },
        fileChange(file, fileList) {
            this.form.file = file.raw
            this.form.file_name = file.name
        },
    },
    watch : {
        mode(val) {
            if(val && val == 'create') {
                this.form = {
                    date: '',
                    amount: '',
                    account_id: '',
                    reference: '',
                    description: '',
                }
            }
        },
        // 'form.amount'(val) {
        //     if(val) {
        //         this.form.amount = val.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     }
        // }
    }
}
</script>
