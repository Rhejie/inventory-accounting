<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Invoice Number" prop="invoice_id">
                <el-select
                    v-model="form.invoice_id"
                    style="width: 100%"
                    filterable
                    remote
                    :disabled="formInvoice"
                    reserve-keyword
                    @change="changeInvoiceID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteInvoiceMethod"
                    :loading="loadingInvoices">
                    <el-option
                    v-for="item in invoices"
                    :key="item.id"
                    :label="item.ref_number"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Amount" prop="amount">
                <el-input @change="isGreaterThaDueAmount($event)" type="number" placeholder="Amount.." v-model="form.amount"></el-input>
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

            <div class="row">
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
    name: 'CreditNoteForm',
    props: {
        mode: null,
        model: {},
        formInvoice: null,
        invoiceData : {},
        dueAmount: null,
    },
    data() {
        return {
            form: {
                invoice_id: null,
                amount: null,
                date: null,
                description: null,
                file: null,
                remove_file: false,
            },
            rules: {
                amount: [
                    {required: true, message: 'Please input Amount', trigger: 'blur'}
                ],
                description: [
                    {required: true, message: 'Please input Description', trigger: 'blur'}
                ],
                date: [
                    {required: true, message: 'Please input Date', trigger: 'blur'}
                ],
                invoice_id: [
                    {required: true, message: 'Please select Invoice', trigger: 'blur'}
                ],
                // customer_id: [
                //     {required: true, message: 'Please select Unit', trigger: 'blur'}
                // ]
            },
            invoices: [],
            loadingInvoices: false,
            loadingCustomers: false,
            customers: [],
            disableButton: false,
            fileList: []
        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_CREDIT', data => {
            this.resetForm('form')
            this.invoices = []
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
            this.form = {
                invoice_id: this.model.invoice.ref_number,
                invoice_id_id: this.model.invoice.id,
                amount: this.model.amount,
                date: this.model.date,
                description: this.model.description,
            }
        }
        if(this.invoiceData && this.invoiceData.id) {
            this.form = {
                invoice_id : this.invoiceData.ref_number,
                invoice_id_id : this.invoiceData.id,
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateCredit();
                    return
                }
                this.storeCredit();
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
        isGreaterThaDueAmount(amount) {
            let value =  this.$IF.removeComma(amount);
            value = parseFloat(value);
            let dueAmountTotal = parseFloat(this.dueAmount);
            if(this.formInvoice) {
                if(dueAmountTotal < value) {
                    this.$message.error('Value is greater than due amount');
                    this.form.amount = ''
                    return
                }
            }
            else if(this.form.invoice_id) {
                let invoice = this.invoices.find(inv => inv.id == this.form.invoice_id);
                let due_amount = parseFloat(invoice.total_due);
                if(due_amount < value) {
                    this.$message.error('Value is greater than due amount');
                    this.form.amount = ''
                    return
                }
            }
        },
        async storeCredit() {
            try {
                if(this.formInvoice) {
                    this.form.invoice_id = this.invoiceData.id
                }
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                this.form.amount = this.$IF.removeComma(this.form.amount);

                let formData = new FormData();
                if(this.form.date)formData.append('date', this.form.date);
                if(this.form.invoice_id)formData.append('invoice_id', this.form.invoice_id);
                if(this.form.amount)formData.append('amount', this.form.amount);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.file)formData.append('file', this.form.file);
                if(this.form.file_name)formData.append('file_name', this.form.file_name);
                this.disableButton = true;
                const res = await this.$API.CreditNote.storeCredit(formData)
                this.disableButton = false
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.$EventDispatcher.fire('NEW_CREDIT', res.data)
                this.$emit('newCreateInvoice', res.data)
                this.resetForm('form')
            } catch (error) {
                console.log(error);
            }
        },
        async updateCredit() {
            try {
                this.form.date = this.$df.formatDate(this.form.date, "YYYY-MM-DD")
                let formData = new FormData()
                if(this.form.date)formData.append('date', this.form.date);
                if(this.form.invoice_id)formData.append('invoice_id', this.form.invoice_id);
                if(this.form.invoice_id_id)formData.append('invoice_id_id', this.form.invoice_id_id);
                if(this.form.amount)formData.append('amount', this.form.amount);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.file)formData.append('file', this.form.file);
                if(this.form.file_name)formData.append('file_name', this.form.file_name);
                if(this.form.remove_file)formData.append('remove_file', this.form.remove_file);
                this.disableButton = true
                const res = await this.$API.CreditNote.updateCredit(this.model.id, formData)
                this.disableButton = false
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.$EventDispatcher.fire('UPDATE_CREDIT', res.data)
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
        changeCustomerID(value) {

        },
        async remoteInvoiceMethod(query) {
            try {
                if (query !== '') {
                    this.loadingInvoices = true;
                    const res = await this.$API.Invoice.searchInvoice(query);
                    this.invoices = res.data
                    this.loadingInvoices = false;
                } else {
                    this.invoices = [];
                }
            } catch (error) {
                console.log(error);
            }
        },
        changeInvoiceID(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.invoice_id_id = null
                this.invoices = []
                return value;
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
    watch : {
        mode(val) {
            if(val && val == 'create') {
                this.form = {
                    invoice_id: null,
                    amount: '',
                    date: '',
                    description: '',
                }
                if(this.invoiceData && this.invoiceData.id) {
                    this.form = {
                        invoice_id : this.invoiceData.ref_number,
                        invoice_id_id : this.invoiceData.id,
                    }
                }
            }
        },
        model(newVal, oldVal) {
            if(newVal != oldVal &&  this.mode == 'update') {
                let file = ''
                if(this.model.attachable) {
                    this.fileList = [{name: newVal.attachable.file_name, url: `${newVal.attachable.path}${newVal.attachable.file}`}]
                    file = newVal.attachable.file
                }
                else {
                    this.fileList = []
                }
                this.form = {
                    invoice_id: newVal.invoice.ref_number,
                    invoice_id_id: newVal.invoice.id,
                    amount: newVal.amount,
                    date: newVal.date,
                    description: newVal.description,
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
