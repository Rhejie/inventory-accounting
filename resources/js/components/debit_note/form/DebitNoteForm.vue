<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Bill Number" prop="bill_id">
                <el-select
                    v-model="form.bill_id"
                    style="width: 100%"
                    filterable
                    remote
                    :disabled="formBill"
                    reserve-keyword
                    @change="changeBillID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteBillMethod"
                    :loading="loadingBills">
                    <el-option
                    v-for="item in bills"
                    :key="item.id"
                    :label="item.bill_number"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Amount" prop="amount">
                <el-input type="number" placeholder="Amount.." min="0" v-model="form.amount"></el-input>
            </el-form-item>
            <el-form-item label="Date" prop="date">
                <el-date-picker
                    v-model="form.date"
                    style="width:100%"
                    type="date"
                    placeholder="Pick a day">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="Description" prop="description">
                <el-input type="textarea" v-model="form.description"></el-input>
            </el-form-item>
            <el-form-item label="Attachment" prop="file">
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
            <div class="row">
                <div class="col-md-12">
                    <el-form-item style="float: right;">
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
    name: 'DebitNoteForm',
    props : {
        formBill: {
            type: Boolean,
            default: false
        },
        mode: null,
        model: {},
        bill: {},
        dueAmount: null
    },
    data() {
        var validateAmount = (rule, value, callback) => {
            if (value === '' || value === null) {
                callback(new Error('Please input Amount'));
            }
            else  {
                if(this.mode == 'create') {
                    if(this.formBill) {
                        let amount = parseFloat(this.dueAmount)
                        if(amount < value) {
                            let due = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            callback(new Error('Amount is greater than due amount (P'+due+')'));
                        }
                        else {
                            callback();
                        }
                    }
                    else if(this.form.bill_id !== '') {
                        let bill = this.bills.find(bill => bill.id == this.form.bill_id);
                        let due_amount = parseFloat(bill.total_due);
                        if(due_amount < value) {
                            let due = due_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            callback(new Error('Amount is greater than due amount (P'+due+')'));
                        }
                        else {
                            callback();
                        }
                    }
                    else if(this.form.bill_id === '') {
                        console.log('nisulod');
                        callback(new Error('Please input Bill'));
                    }
                    else if(this.form.bill_id === null) {
                        console.log('nisulod');
                        callback(new Error('Please input Bill'));
                    }
                    else {
                        callback();
                    }
                }
                else if(this.mode == 'update') {
                    if(this.form.bill_id_id !== '') {
                        let bill = parseFloat(this.model.bill.total_due);
                        if(bill < value) {
                            let due = bill.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            callback(new Error('Amount is greater than due amount (P'+due+')'));
                        }
                        else {
                            callback();
                        }
                    }
                    else if (this.form.bill_id_id === '') {
                        if(this.form.bill_id !== '') {
                            let bill = this.bills.find(bill => bill.id == this.form.bill_id);
                            let due_amount = parseFloat(bill.total_due);
                            console.log(bill, due_amount);
                            if(due_amount < value) {
                                let due = due_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                callback(new Error('Amount is greater than due amount (P'+due+')'));
                            }
                            else {
                                callback();
                            }
                        }
                    }
                    else {
                        callback();
                    }
                }
                else {
                    callback();
                }
            }
        };
        return {
            form: {
                bill_id: '',
                bill_id_id: '',
                amount: '',
                date: '',
                description: '',
            },
            rules: {
                description: [
                    {required: true, message: 'Please input Description', trigger: 'blur'}
                ],
                amount: [
                    { validator: validateAmount, trigger: 'blur' }
                ],
                date: [
                    {required: true, message: 'Please input Date', trigger: 'blur'}
                ],
                bill_id: [
                    {required: true, message: 'Please select Bill', trigger: 'blur'}
                ],
                // customer_id: [
                //     {required: true, message: 'Please select Unit', trigger: 'blur'}
                // ]
            },
            bills: [],
            loadingBills: false,
            loadingCustomers: false,
            customers: [],
            disableButton: false,
            fileList: []
        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_DEBIT_NOTE', data => {
            this.resetForm('form')
        })

        if(this.bill && this.bill.id) {
            this.form = {
                bill_id : this.bill.bill_number,
                bill_id_id : this.bill.id,
                supplier_id : this.bill.supplier_id,
                amount: null,
                date: null,
                description: null,
                file: ''
            }

            this.fileList = []
        }

        if(this.model && this.model.id && this.mode == 'update') {
            let file = ''
            if(this.model.attachable) {
                this.fileList = [{name: this.model.attachable.file_name, url: `${this.model.attachable.path}${this.model.attachable.file}`}]
                file = this.model.attachable.file
            }
            else {
                this.fileList = []
            }
            this.form = {
                bill_id : this.model.bill.bill_number,
                bill_id_id : this.model.bill_id,
                supplier_id : this.model.supplier_id,
                date: this.model.date,
                amount: this.model.amount,
                description: this.model.description
            }
        }
    },
    filters: {

        addComma(value) {
            if(value) {
                value = parseFloat(value).toFixed(2)
                return 'P ' +value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        },
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateNote();
                    return
                }
                this.storeNote();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.fileList = [];
            this.bills = []
            this.$refs[formName].resetFields();
        },
        async storeNote() {
            try {
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                this.form.amount = this.$IF.removeComma(this.form.amount);
                this.form.type = 'debit'
                let formData = new FormData();
                if(this.form.amount)formData.append('amount', this.form.amount);
                if(this.form.date)formData.append('date', this.form.date);
                if(this.form.type)formData.append('type', this.form.type);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.file)formData.append('file', this.form.file);
                if(this.form.file_name)formData.append('file_name', this.form.file_name);
                if(this.form.supplier_id)formData.append('supplier_id', this.form.supplier_id);
                if(this.form.bill_id)formData.append('bill_id', this.form.bill_id);
                if(this.form.bill_id_id)formData.append('bill_id_id', this.form.bill_id_id);
                this.disableButton = true
                const res = await this.$API.DebitNote.storeNote(formData);
                this.disableButton = false
                this.$EventDispatcher.fire('NEW_NOTE', res.data);
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
        async updateNote() {
            try {
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                this.form.type = 'debit'
                let formData = new FormData();
                if(this.form.amount)formData.append('amount', this.form.amount);
                if(this.form.date)formData.append('date', this.form.date);
                if(this.form.type)formData.append('type', this.form.type);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.file)formData.append('file', this.form.file);
                if(this.form.file_name)formData.append('file_name', this.form.file_name);
                if(this.form.supplier_id)formData.append('supplier_id', this.form.supplier_id);
                if(this.form.bill_id)formData.append('bill_id', this.form.bill_id);
                if(this.form.bill_id_id)formData.append('bill_id_id', this.form.bill_id_id);
                if(this.form.remove_file)formData.append('remove_file', this.form.remove_file);
                this.disableButton = true
                const res = await this.$API.DebitNote.updateNote(this.model.id, formData);
                this.disableButton = false
                this.$EventDispatcher.fire('UPDATE_NOTE', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
            } catch (error) {
                console.log(error);
            }
        },
        async remoteBillMethod(query) {
            try {
                if (query !== '') {
                    this.loadingBills = true;
                    const res = await this.$API.Bill.searchBill(query);
                    this.bills = res.data
                    this.loadingBills = false;
                } else {
                    this.bills = [];
                }
            } catch (error) {
                console.log(error);
            }
        },
        changeBillID(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.bill_id_id = ''
                return value;
            }
            let bill = this.bills.find(bill => bill.id == value)
            this.form.supplier_id = bill.supplier_id
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
                this.form = {
                    bill_id : newVal.bill.bill_number,
                    bill_id_id : newVal.bill.id,
                    supplier_id : newVal.supplier_id,
                    amount: newVal.amount,
                    date: newVal.date,
                    description: newVal.description,
                }
            }
        },
        mode(val) {
            if(val && this.mode == 'create') {
                this.form = {
                    bill_id: null,
                    bill_id_id: null,
                    amount: null,
                    date: null,
                    description: null,
                }
                this.fileList = []
            }
        }
    }
}
</script>
