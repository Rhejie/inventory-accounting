<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <el-form-item label="From Account" prop="from_account">
                                <el-select
                                    v-model="form.from_account"
                                    filterable
                                    @change="accountFromChange"
                                    remote
                                    reserve-keyword
                                    style="width:100%"
                                    placeholder="Please enter a keyword"
                                    :remote-method="remoteMethodFromAccounts"
                                    :loading="loadingFromAccounts">
                                        <el-option
                                            v-for="item in accountsFrom"
                                            :key="item.id"
                                            :label="`${item.bank_name} - ${item.holder_name}`"
                                            :value="item.id">
                                        </el-option>
                                </el-select>
                            </el-form-item>
                        </div>
                        <div class="col-md-6">
                            <el-form-item label="To Account" prop="to_account">
                                <el-select
                                    v-model="form.to_account"
                                    filterable
                                    @change="accountToChange"
                                    remote
                                    reserve-keyword
                                    style="width:100%"
                                    placeholder="Please enter a keyword"
                                    :remote-method="remoteMethodToAccounts"
                                    :loading="loadingToAccounts">
                                        <el-option
                                            v-for="item in accountsTo"
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
                                <el-input type="number" min="0" v-model="form.amount" placeholder="Amount..."></el-input>
                            </el-form-item>
                        </div>
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
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
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
                        <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                        <el-button :disabled="disableButton" v-if="mode != 'update'" @click="resetForm('form')">Reset</el-button>
                    </el-form-item>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'BankTransferForm',
    props: {
        mode: null,
        model: {}
    },
    data() {
        var validatePass2 = (rule, value, callback) => {
            if (value === '') {
                callback(new Error('Please input Amount'));
            }
            else {
                if(this.mode == 'create') {
                    if(this.form.from_account) {
                        let fromAccount = this.accountsFrom.find(acc => acc.id == this.form.from_account);
                        // value = this.$IF.removeComma(value);
                        value = parseFloat(value)
                        if(fromAccount.opening_balance < value & this.mode == 'create') {
                            callback(new Error('Insufficient funds.'));
                            this.isInsufficient = true
                            return
                        }
                        callback();
                        this.isInsufficient = false
                    }
                }
                else {
                    let from_id = null
                    if(this.form.from_account_id) {
                        from_id = this.form.from_account_id
                        let account_amount = this.model.from_account.opening_balance
                        account_amount = parseFloat(account_amount)
                        let from = account_amount + parseFloat(this.model.amount)
                        // value = this.$IF.removeComma(value);
                        value = parseFloat(value)

                        if(from < value) {
                            callback(new Error('Insufficient funds (P'+from+')'));
                            this.form.amount = this.model.amount
                            return
                        }
                        callback();
                        return
                    }
                    else {
                        from_id = this.form.from_account
                    }

                    console.log(from_id);

                    let fromAccount = this.accountsFrom.find(acc => acc.id == from_id);

                    // value = this.$IF.removeComma(value);
                    value = parseFloat(value)

                    console.log(fromAccount);

                    let from = fromAccount.opening_balance + this.model.amount

                    if(from < value) {
                        callback(new Error('Insufficient funds.'));
                        return
                    }

                    callback();
                }
            }
        };
        return {
            form: {
                from_account: '',
                to_account: '',
                amount: '',
                date: '',
                reference: '',
                from_account_id: '',
                description: '',
                file: ''
            },

            rules:{
                from_account: [
                    {required: true, message: 'Please select Account', trigger: 'blur'}
                ],
                to_account: [
                    {required: true, message: 'Please select Account', trigger: 'blur'}
                ],
                file: [
                    {required: true, message: 'Please select File', trigger: 'blur'}
                ],
                amount: [
                    { validator: validatePass2, trigger: 'blur' }
                ],
                date: [
                    {required: true, message: 'Please input Date', trigger: 'blur'}
                ],
                reference: [
                    {required: true, message: 'Please input Reference', trigger: 'blur'}
                ],
                description: [
                    {required: true, message: 'Please input Description', trigger: 'blur'}
                ],
            },
            loadingFromAccounts: false,
            loadingToAccounts: false,
            accountsFrom: [],
            accountsTo: [],
            disableAccount: false,
            disableButton: false,
            fileList: [],
            isInsufficient: false,
        }
    },
    created() {

        if(this.model && this.model.id) { let file = null
            if(this.model.attachable) {
                this.fileList = [{name: this.model.attachable.file_name, url: `${this.model.attachable.path}${this.model.attachable.file}`}]
                file = this.model.attachable.file
            }
            else {
                this.fileList = []
            }
            this.form = {
                from_account: `${this.model.from_account.bank_name} - ${this.model.from_account.holder_name}`,
                from_account_id: this.model.from_account.id,
                to_account: `${this.model.to_account.bank_name} - ${this.model.to_account.holder_name}`,
                to_account_id: this.model.to_account.id,
                amount: this.model.amount,
                date: this.model.date,
                reference: this.model.reference,
                description: this.model.description,
                file,
            }
        }

        this.$EventDispatcher.listen('CLOSE_TRANSFER', data => this.resetForm('form'))
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateTransfer();
                    return
                }
                this.storeTransfer();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        checkBalanceValidation(rule, value, callback) {
            if(this.mode == 'create') {
                if(this.form.from_account) {
                    let fromAccount = this.accountsFrom.find(acc => acc.id == this.form.from_account);
                    // value = this.$IF.removeComma(value);
                    value = parseFloat(value)
                    if(fromAccount.opening_balance < value & this.mode == 'create') {
                        this.$message.error('Insufficient funds.');
                        callback(new Error('Insufficient funds.'));
                        this.form.amount = ''
                        this.isInsufficient = true
                        return
                    }
                    callback();
                    this.isInsufficient = false
                }
            }

            else {
                let from_id = null
                if(this.form.from_account_id) {
                    from_id = this.form.from_account_id
                    let account_amount = this.model.from_account.opening_balance
                    account_amount = parseFloat(account_amount)
                    let from = account_amount + parseFloat(this.model.amount)
                    // value = this.$IF.removeComma(value);
                    value = parseFloat(value)

                    if(from < value) {
                        this.$message.error('Insufficient funds.');
                        callback(new Error('Insufficient funds.'));
                        this.form.amount = this.model.amount
                        return
                    }
                    callback();
                    return
                }
                else {
                    from_id = this.form.from_account
                }

                console.log(from_id);

                let fromAccount = this.accountsFrom.find(acc => acc.id == from_id);

                // value = this.$IF.removeComma(value);
                value = parseFloat(value)

                console.log(fromAccount);

                let from = fromAccount.opening_balance + this.model.amount

                if(from < value) {
                    this.$message.error('Insufficient funds.');
                    callback(new Error('Insufficient funds.'));
                    this.form.amount = ''
                    return
                }

                callback();

            }
        },
        isGreaterFromAccount(val) {
            if(this.form.from_account && this.mode == 'create') {
                let fromAccount = this.accountsFrom.find(acc => acc.id == this.form.from_account);
                val = this.$IF.removeComma(val);
                val = parseFloat(val)
                if(fromAccount.opening_balance < val & this.mode == 'create') {
                    this.$message.error('Insufficient funds.');

                    this.form.amount = ''
                    this.isInsufficient = true
                    return
                }

                this.isInsufficient = false

            }
            else {
                let from_id = null
                if(this.form.from_account_id) {
                    from_id = this.form.from_account_id
                    let account_amount = this.model.from_account.opening_balance
                    account_amount = parseFloat(account_amount)
                    let from = account_amount + parseFloat(this.model.amount)
                    val = this.$IF.removeComma(val);
                    val = parseFloat(val)

                    if(from < val) {
                        this.$message.error('Insufficient funds.');

                        this.form.amount = this.model.amount
                        return
                    }

                    return
                }
                else {
                    from_id = this.form.from_account
                }

                console.log(from_id);

                let fromAccount = this.accountsFrom.find(acc => acc.id == from_id);

                val = this.$IF.removeComma(val);
                val = parseFloat(val)

                console.log(fromAccount);

                let from = fromAccount.opening_balance + this.model.amount

                if(from < val) {
                    this.$message.error('Insufficient funds.');

                    this.form.amount = ''
                    return
                }
            }
        },
        async storeTransfer() {
            try {

                if(this.isInsufficient) {
                    return
                }
                this.disableButton = true
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                let formData = new FormData()
                if(this.form.from_account)formData.append('from_account', this.form.from_account)
                if(this.form.to_account)formData.append('to_account', this.form.to_account)
                if(this.form.amount)formData.append('amount', this.form.amount)
                if(this.form.date)formData.append('date', this.form.date)
                if(this.form.reference)formData.append('reference', this.form.reference)
                if(this.form.description)formData.append('description', this.form.description)
                if(this.form.file)formData.append('file', this.form.file)
                if(this.form.file_name)formData.append('file_name', this.form.file_name)
                const res = await this.$API.Bank.storeTransfer(formData)
                this.disableButton = false
                this.$EventDispatcher.fire('NEW_TRANSFER', res.data)
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
        async updateTransfer() {
            try {
                if(this.isInsufficient) {
                    return
                }
                this.disableButton = true
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                let formData = new FormData()
                if(this.form.from_account)formData.append('from_account', this.form.from_account)
                if(this.form.from_account_id)formData.append('from_account_id', this.form.from_account_id)
                if(this.form.to_account)formData.append('to_account', this.form.to_account)
                if(this.form.to_account_id)formData.append('to_account_id', this.form.to_account_id)
                if(this.form.amount)formData.append('amount', this.form.amount)
                if(this.form.date)formData.append('date', this.form.date)
                if(this.form.reference)formData.append('reference', this.form.reference)
                if(this.form.description)formData.append('description', this.form.description)
                if(this.form.file)formData.append('file', this.form.file)
                if(this.form.file_name)formData.append('file_name', this.form.file_name)
                const res = await this.$API.Bank.updateTransfer(this.model.id, formData);
                this.disableButton = false
                this.$EventDispatcher.fire('UPDATE_TRANSFER', res.data)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        async remoteMethodFromAccounts(query) {
            try {
                if (query !== '') {
                    this.loadingFromAccounts = true;
                    const res = await this.$API.Bank.searchAccount(query);
                    this.accountsFrom = res.data.filter(acc => acc.id != this.form.to_account)
                    this.loadingFromAccounts = false;
                } else {
                    this.accountsFrom = [];
                }
            } catch (error) {
                console.log(error);
            }
        },
        accountFromChange(value) {
            if(this.model && this.model.id && this.mode =='update') {
                this.form.from_account_id = null;
                return value
            }
        },
        async remoteMethodToAccounts(query) {
            try {
                if (query !== '') {
                    this.loadingToAccounts = true;
                    const res = await this.$API.Bank.searchAccount(query);
                    this.accountsTo = res.data.filter(acc => acc.id != this.form.from_account)

                    this.loadingToAccounts = false;
                } else {
                    this.accountsTo = [];
                }
            } catch (error) {
                console.log(error);
            }
        },
        accountToChange(value) {
            if(this.model && this.model.id && this.mode =='update') {
                this.form.to_account_id = null;
                return value
            }
        },
        handlePreview(file) {
            console.log(file);
        },
        handleRemove(file, fileList) {
            this.form.remove_file = true;
            this.form.file = ''
            console.log(file, fileList);
        },
        fileChange(file, fileList) {
            this.form.file = file.raw
            this.form.file_name = file.name
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
    },
    watch: {
        // 'form.amount'(val) {
        //     if(val) {
        //         this.form.amount = val.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     }
        // },
        'form.from_account'(val) {
            if(val) {
                this.disableAccount = false;
            }

            this.disableAccount = true;
        },
        mode(val) {
            if(val) {
                this.form = {
                    from_account: '',
                    to_account: '',
                    amount: '',
                    date: '',
                    reference: '',
                    description: '',
                }
                this.fileList = []
            }
        },
        model(newVal, oldVal) {
            if(newVal != oldVal&& this.mode == 'update' ) {

                let file = ''
                if(newVal.attachable) {
                    this.fileList = [{name: newVal.attachable.file_name, url: `${newVal.attachable.path}${newVal.attachable.file}`}]
                    file = newVal.attachable.file
                }
                else {
                    this.fileList = []
                }
                this.form = {
                    from_account: `${newVal.from_account.bank_name} - ${newVal.from_account.holder_name}`,
                    from_account_id: newVal.from_account.id,
                    to_account: `${newVal.to_account.bank_name} - ${newVal.to_account.holder_name}`,
                    to_account_id: newVal.to_account.id,
                    amount: newVal.amount,
                    date: newVal.date,
                    reference: newVal.reference,
                    description: newVal.description,
                    file,
                }
            }
        }
    }
}
</script>
