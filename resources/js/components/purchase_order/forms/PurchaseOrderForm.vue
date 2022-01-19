<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Purchase Order Reference No" prop="purchase_order_reference_no">
                <el-input v-model="form.purchase_order_reference_no" disabled v-loading="loadingCode" placeholder="Purchase Order Refernece No..."></el-input>
            </el-form-item>
            <el-form-item label="Push Order Date" prop="push_order_date">
                <el-date-picker type="date" placeholder="Pick a Starting Date" v-model="form.push_order_date" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item label="Supplier" prop="supplier_id">
                <el-select
                    v-model="form.supplier_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    @change="changeSupplierID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethod"
                    :loading="loading">
                    <el-option
                    v-for="item in suppliers"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Project" prop="project_id">
                <el-select
                    v-model="form.project_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    @change="changeProjectID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteProjectMethod"
                    :loading="loadingProjects">
                    <el-option
                    v-for="item in projects"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <div style="">
                <el-form-item>
                    <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                    <el-button @click="resetForm('form')" :disabled="disableButton" v-if="mode != 'update'">Reset</el-button>
                </el-form-item>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'PurchaseOrderForm',
    props: {
        mode: null,
        model: {}
    },
    data() {
        return {
            suppliers: [],
            loading: false,
            loadingProjects: false,
            projects: [],
            form: {
                supplier_id: '',
                push_order_date: '',
                purchase_order_reference_no	: '',
                project_id: '',
                location: '',
                address: '',
                contact_person: ''
            },
            rules: {
                supplier_id: [
                    {required: true, message: 'Please select Supplier', trigger: 'blur'}
                ],
                push_order_date: [
                    {required: true, message: 'Please inpute Push Order Date', trigger: 'blur'}
                ],
                purchase_order_reference_no: [
                    {required: true, message: 'Please input Purchase Order Reference No', trigger: 'blur'}
                ],
                project_id: [
                    {required: true, message: 'Please input Project', trigger: 'blur'}
                ],
            },
            disableButton: false,
            loadingCode: false
        }
    },
    created() {
        if(this.model && this.model.id && this.mode == 'update') {
            this.form = {
                suppiler_id_value: this.model.supplier_id,
                project_id_project: this.model.project_id,
                supplier_id: this.model.supplier.name,
                push_order_date: this.model.push_order_date,
                purchase_order_reference_no	: this.model.purchase_order_reference_no,
                project_id: this.model.project.name,
            }
        }
        else {
            this.getCode()
        }

        this.$EventDispatcher.listen('handleClosePO', data => {
            this.resetForm('form')
        })
    },
    methods : {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updatePurchaseOrder();
                    return
                }
                this.storePurchaseOrder();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async getCode() {
            try {
                this.loadingCode = true;
                const res = await this.$API.PurchaseOrder.getNumber();
                this.form.purchase_order_reference_no = res.data
                this.loadingCode = false;
            } catch (error) {
                console.log(error);
            }
        },
        async storePurchaseOrder() {
            this.disableButton = true;
            try {
                this.form.push_order_date = this.$df.formatDate(this.form.push_order_date, "YYYY-MM-DD");

                const res = await this.$API.PurchaseOrder.storeOrder(this.form);
                this.$EventDispatcher.fire('NEW_PUCHASE_ORDER', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.resetForm('form');
                this.$router.push({
                    name: 'Purchase Order View',
                    params: {id : res.data.id, data: res.data}
                })
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async updatePurchaseOrder() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.form.supplier_id)formData.append('supplier_id', this.form.supplier_id);
                if(this.form.suppiler_id_value)formData.append('suppiler_id_value', this.form.suppiler_id_value);
                if(this.form.project_id_project)formData.append('project_id_project', this.form.project_id_project);
                if(this.form.address)formData.append('address', this.form.address);
                if(this.form.purchase_order_reference_no)formData.append('purchase_order_reference_no', this.form.purchase_order_reference_no);
                if(this.form.push_order_date)formData.append('push_order_date', this.$df.formatDate(this.form.push_order_date, "YYYY-MM-DD"));
                if(this.form.project_id)formData.append('project_id', this.form.project_id);
                if(this.form.location)formData.append('location', this.form.location);

                const res = await this.$API.PurchaseOrder.updateOrder(this.model.id, formData);
                this.$EventDispatcher.fire('UPDATE_PURCHASE_ORDER', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async remoteMethod(query) {
            if (query !== '') {
                this.loading = true;
                try {
                    const res = await this.$API.PurchaseOrder.getSuppliers(query);
                    this.suppliers = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.suppliers = [];
            }
        },
        async remoteProjectMethod(query) {
            if (query !== '') {
                this.loadingProjects = true;
                try {
                    const res = await this.$API.Project.getPorjectsData(query);
                    this.projects = res.data
                    this.loadingProjects = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.projects = [];
            }
        },
        changeSupplierID(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.suppiler_id_value = null
                return value;
            }
            let supplierAddress = this.suppliers.filter(supp => value == supp.id);

            this.form.address = supplierAddress[0].address
            this.form.contact_person = supplierAddress[0].contact_person
        },
        changeProjectID(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.project_id_project = null
                return value;
            }
            let project = this.projects.filter((project) => project.id == value);
            this.form.location = project[0].location
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    supplier_id: newVal.supplier.name,
                    suppiler_id_value: newVal.supplier_id,
                    push_order_date: newVal.push_order_date,
                    purchase_order_reference_no	: newVal.purchase_order_reference_no,
                    project_id: newVal.project.name,
                    project_id_project: newVal.project_id,
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    supplier_id: '',
                    push_order_date: '',
                    purchase_order_reference_no	: '',
                    project_id: '',
                    project_id_project: '',
                }
                this.getCode()
            }
        },
    }
}
</script>
