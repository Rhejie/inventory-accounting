<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <el-form-item label="Bank Holder Name" prop="holder_name">
                                <el-input v-model="form.holder_name" placeholder="Bank Holder Name..."></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-md-6">
                            <el-form-item label="Bank Name" prop="bank_name">
                                <el-input  v-model="form.bank_name" placeholder="Bank Name..."></el-input>
                            </el-form-item>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <el-form-item label="Account Number" prop="account_number">
                                <el-input @keypress.native="isNumber($event)" v-model="form.account_number" placeholder="Account Number..."></el-input>
                            </el-form-item>
                        </div>
                        <div class="col-md-6">
                            <el-form-item label="Opening Balance" prop="opening_balance">
                                <el-input type="number" min="0" v-model="form.opening_balance" placeholder="Opening Balance..."></el-input>
                            </el-form-item>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <el-form-item label="Contact Number" prop="contact_number">
                                <el-input v-model="form.contact_number" @keypress.native="isNumber($event)" placeholder="Contact Number..."></el-input>
                            </el-form-item>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <el-form-item label="Bank Address" prop="bank_address">
                                <el-input type="textarea" v-model="form.bank_address" placeholder="Bank Address..."></el-input>
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
                        <el-button type="primary" :disabled="disabledButton" @click="submitForm('form')">Save</el-button>
                        <el-button :disabled="disabledButton" v-if="mode != 'update'" @click="resetForm('form')">Reset</el-button>
                    </el-form-item>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'BankAccountForm',
    props: {
        mode: null,
        model: {}
    },
    data() {
        return {
            form: {
                holder_name: '',
                bank_name: '',
                account_number: '',
                opening_balance: '',
                contact_number: '',
                bank_address: '',
                file: ''
            },
            rules:{
                holder_name: [
                    {required: true, message: 'Please input Bank Holder Name', trigger: 'blur'}
                ],
                bank_name: [
                    {required: true, message: 'Please input Bank Name', trigger: 'blur'}
                ],
                account_number: [
                    {required: true, message: 'Please input Account Number', trigger: 'blur'}
                ],
                opening_balance: [
                    {required: true, message: 'Please input Opening Balance', trigger: 'blur'}
                ],
                contact_number: [
                    {required: true, message: 'Please input Contact Number', trigger: 'blur'}
                ],
                bank_address: [
                    {required: true, message: 'Please input Bank Address', trigger: 'blur'}
                ],
            },
            disabledButton: false,
            fileList: [],
            isInsufficient: false,
        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_ACCOUNT', data => {
            this.resetForm('form')
        })

        if(this.model && this.model.id) {
            let file = null
            if(this.model.attachable) {
                this.fileList = [{name: this.model.attachable.file_name, url: `${this.model.attachable.path}${this.model.attachable.file}`}]
                file = this.model.attachable.file
            }
            else {
                this.fileList = []
            }
            this.form = {
                holder_name: this.model.holder_name,
                bank_name: this.model.bank_name,
                account_number: this.model.account_number,
                opening_balance: this.model.opening_balance,
                contact_number: this.model.contact_number,
                bank_address: this.model.bank_address,
                file,
            }

        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateAccount();
                    return
                }
                this.storeAccount();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
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
        async storeAccount() {
            try {
                this.disabledButton = true
                let formData = new FormData()
                if(this.form.holder_name)formData.append('holder_name', this.form.holder_name)
                if(this.form.bank_name)formData.append('bank_name', this.form.bank_name)
                if(this.form.account_number)formData.append('account_number', this.form.account_number)
                if(this.form.opening_balance)formData.append('opening_balance', this.form.opening_balance)
                if(this.form.contact_number)formData.append('contact_number', this.form.contact_number)
                if(this.form.bank_address)formData.append('bank_address', this.form.bank_address)
                if(this.form.file)formData.append('file', this.form.file)
                if(this.form.file_name)formData.append('file_name', this.form.file_name)
                const res = await this.$API.Bank.storeAccount(formData)
                this.disabledButton = false
                this.$EventDispatcher.fire('NEW_ACCOUNT', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added!',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        async updateAccount() {
            try {
                this.disabledButton = true
                let formData = new FormData()
                if(this.form.holder_name)formData.append('holder_name', this.form.holder_name)
                if(this.form.bank_name)formData.append('bank_name', this.form.bank_name)
                if(this.form.account_number)formData.append('account_number', this.form.account_number)
                if(this.form.opening_balance)formData.append('opening_balance', this.form.opening_balance)
                if(this.form.contact_number)formData.append('contact_number', this.form.contact_number)
                if(this.form.bank_address)formData.append('bank_address', this.form.bank_address)
                if(this.form.file)formData.append('file', this.form.file)
                if(this.form.file_name)formData.append('file_name', this.form.file_name)
                if(this.form.remove_file)formData.append('remove_file', this.form.remove_file)
                const res = await this.$API.Bank.updateAccount(this.model.id, formData)
                this.disabledButton = false
                this.$EventDispatcher.fire('UPDATE_ACCOUNT', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated!',
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
            this.form.remove_file = true
            console.log(file, fileList);
        },
        fileChange(file, fileList) {
            this.form.file = file.raw
            this.form.file_name = file.name
        },
    },
    watch: {
        mode(val) {
            if(val && val == 'create') {
                this.form = {
                    holder_name: '',
                    bank_name: '',
                    account_number: '',
                    opening_balance: '',
                    contact_number: '',
                    bank_address: '',
                }
                this.fileList = []
            }
        },
        model(newVal , oldVal) {
            if(newVal != oldVal) {
                let file = ''
                if(newVal.attachable) {
                    this.fileList = [{name: newVal.attachable.file_name, url: `${newVal.attachable.path}${newVal.attachable.file}`}]
                    file = newVal.attachable.file
                }
                else {
                    this.fileList = []
                }
                this.form = {
                    holder_name: newVal.holder_name,
                    bank_name: newVal.bank_name,
                    account_number: newVal.account_number,
                    opening_balance: newVal.opening_balance,
                    contact_number: newVal.contact_number,
                    bank_address: newVal.bank_address,
                    file,
                }
            }
        }
    }
}
</script>
