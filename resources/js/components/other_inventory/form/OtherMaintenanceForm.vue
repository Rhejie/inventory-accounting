<template>
    <div>
        <el-form :model="ruleForm" label-position="top" :rules="rules" ref="ruleForm" class="demo-ruleForm">
            <el-form-item label="Maintenance Type" prop="maintenance_type_id">
                <el-select v-model="ruleForm.maintenance_type_id" @change="maintenanceTypeChange" style="width:100%" v-loading="loadingTypes" clearable placeholder="Select">
                    <el-option
                        v-for="item in jobOrderTypes"
                        :key="item.id"
                        :label="item.type"
                        :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Maintenance Date" prop="date">
                <el-date-picker
                    v-model="ruleForm.date"
                    type="date"
                    style="width:100%"
                    placeholder="Pick a day">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="Amount" prop="amount">
                <el-input type="number" min="0" v-model="ruleForm.amount"></el-input>
            </el-form-item>
            <el-form-item label="Assigned" prop="assigned">
                <el-input v-model="ruleForm.assigned"></el-input>
            </el-form-item>
            <el-form-item prop="file">
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
                    <el-button size="small" type="primary">Attach File</el-button>
                </el-upload>
            </el-form-item>
            <el-form-item>
                <div style="float:right">
                    <el-button type="primary" :disabled="disabledButton" @click="submitForm('ruleForm')">Save</el-button>
                    <el-button :disabled="disabledButton" v-if="mode != 'update'" @click="resetForm('ruleForm')">Reset</el-button>
                </div>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'OtherMaintenanceForm',
    props: {
        id: null,
        mode: null,
        model : {}
    },
    data() {
        return {
            ruleForm : {
                other_id: this.id,
                maintenance_type_id: '',
                date: '',
                assigned: '',
                amount: '',
                file: ''
            },
            rules: {
                maintenance_type_id: [
                    { required: true, message: 'Please select Job Order Type', trigger: 'blur' }
                ],
                date: [
                    { required: true, message: 'Please pick a Date', trigger: 'blur' }
                ],
                assigned: [
                    { required: true, message: 'Please input Assignee', trigger: 'blur' }
                ],
                amount: [
                    { required: true, message: 'Please select Status', trigger: 'blur' }
                ],
            },
            jobOrderTypes: [],
            loadingTypes: false,
            fileList: [],
            disabledButton: false,
        }
    },
    created() {
        this.getMaintenanceType();
        if(this.model && this.model.id && this.mode == 'update') {
            this.ruleForm = {
                other_id : this.id,
                maintenance_type_id : this.model.maintenance_type.type,
                maintenance_type_id_id : this.model.maintenance_type_id,
                assigned : this.model.assigned,
                amount : this.model.amount,
                date : this.model.date,
                file : this.model.file
            }
            if(this.model.file) {
                this.fileList = [{name: this.model.file_name, url: `/storage/other_inventory/maintenance_attachment/${this.model.file}`}]
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateJob();
                    return
                }
                this.storeJob();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.fileList = []
        },
        async storeJob() {
            try {
                this.disabledButton = true
                this.ruleForm.date = this.$df.formatDate(this.ruleForm.date, "YYYY-MM-DD")
                let formData = new FormData()
                if(this.ruleForm.other_id)formData.append('other_id', this.ruleForm.other_id)
                if(this.ruleForm.maintenance_type_id)formData.append('maintenance_type_id', this.ruleForm.maintenance_type_id)
                if(this.ruleForm.date)formData.append('date', this.ruleForm.date)
                if(this.ruleForm.amount)formData.append('amount', this.ruleForm.amount)
                if(this.ruleForm.file)formData.append('file', this.ruleForm.file)
                if(this.ruleForm.assigned)formData.append('assigned', this.ruleForm.assigned)
                if(this.ruleForm.file_name)formData.append('file_name', this.ruleForm.file_name)
                const res = await this.$API.OtherMaintenance.storeMaintenance(formData)
                this.disabledButton = false
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added!',
                    type: 'success'
                });
                this.resetForm('ruleForm');

                this.$EventDispatcher.fire('ADD_NEW_OTHER_MAINTENANCE', res.data);
            } catch (error) {
                console.log(error);
                this.disabledButton = false;
            }
        },
        async updateJob() {
            try {
                this.disabledButton = true;
                this.ruleForm.date = this.$df.formatDate(this.ruleForm.date, "YYYY-MM-DD")
                let formData = new FormData()
                if(this.ruleForm.other_id)formData.append('other_id', this.ruleForm.other_id)
                if(this.ruleForm.maintenance_type_id)formData.append('maintenance_type_id', this.ruleForm.maintenance_type_id)
                if(this.ruleForm.maintenance_type_id_id)formData.append('maintenance_type_id_id', this.ruleForm.maintenance_type_id_id)
                if(this.ruleForm.date)formData.append('date', this.ruleForm.date)
                if(this.ruleForm.amount)formData.append('amount', this.ruleForm.amount)
                if(this.ruleForm.file)formData.append('file', this.ruleForm.file)
                if(this.ruleForm.assigned)formData.append('assigned', this.ruleForm.assigned)
                if(this.ruleForm.file_name)formData.append('file_name', this.ruleForm.file_name)
                const res = await this.$API.OtherMaintenance.updateMaintenance(this.model.id, formData);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated!',
                    type: 'success'
                });
                this.$EventDispatcher.fire('UPDATED_OTHER_MAINTENANCE', res.data);
                this.disabledButton = false;
            } catch (error) {
                console.log(error);
                this.disabledButton = false
            }
        },
        maintenanceTypeChange(value) {
            this.ruleForm.maintenance_type_id_id = null;
            return value;
        },
        async getMaintenanceType() {
            try {
                this.loadingTypes = true
                const res = await this.$API.OtherMaintenance.getMaintenanceType();
                this.jobOrderTypes = res.data
                this.loadingTypes = false
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
            this.ruleForm.file = file.raw
            this.ruleForm.file_name = file.name
        },
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal & this.mode == 'update') {
                this.ruleForm = {
                    other_id : this.id,
                    maintenance_type_id : newVal.maintenance_type.type,
                    maintenance_type_id_id : newVal.maintenance_type_id,
                    assigned : newVal.assigned,
                    amount : newVal.amount,
                    date : newVal.date,
                    file : newVal.file,
                }
                if(newVal.file) {
                    this.fileList = [{name: newVal.file_name, url: `/storage/other_inventory/maintenance_attachment/${newVal.file}`}]
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.ruleForm = {
                    other_id: this.id,
                    maintenance_type_id: '',
                    date: '',
                    assigned: '',
                    amount: '',
                    file: ''
                }

                this.ruleForm.amount = 'Pending'
                this.fileList = []
            }
        }
    }
}
</script>
