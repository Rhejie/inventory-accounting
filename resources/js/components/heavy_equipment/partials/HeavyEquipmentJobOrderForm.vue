<template>
    <div>
        <el-form :model="ruleForm" label-position="top" :rules="rules" ref="ruleForm" class="demo-ruleForm">
            <el-form-item label="Job Order Type" prop="job_order_type_id">
                <el-select v-model="ruleForm.job_order_type_id" @change="jobOrderTypeChange" style="width:100%" v-loading="loadingTypes" clearable placeholder="Select">
                    <el-option
                        v-for="item in jobOrderTypes"
                        :key="item.id"
                        :label="item.type"
                        :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Date" prop="date_created">
                <el-date-picker
                    v-model="ruleForm.date_created"
                    type="date"
                    style="width:100%"
                    placeholder="Pick a day">
                </el-date-picker>
            </el-form-item>
            <el-form-item label="Assignee" prop="assignee">
                <el-input v-model="ruleForm.assignee"></el-input>
            </el-form-item>
            <el-form-item label="Status" prop="status">
                <el-select v-model="ruleForm.status" :disabled="mode != 'update'" style="width:100%" clearable placeholder="Select">
                    <el-option
                        label="Pending"
                        value="Pending">
                    </el-option>
                    <el-option
                        label="On Going"
                        value="On Going">
                    </el-option>
                    <el-option
                        label="Cancelled"
                        value="Cancelled">
                    </el-option>
                    <el-option
                        label="Done"
                        value="Done">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <div style="float:right">
                    <el-button type="primary" :disabled="disableButton"  @click="submitForm('ruleForm')">Save</el-button>
                    <el-button :disabled="disableButton"  v-if="mode != 'update'" @click="resetForm('ruleForm')">Reset</el-button>
                </div>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'HeavyEquipmentJobOrderForm',
    props: {
        id: null,
        mode: null,
        model: {}
    },
    data() {
        return {
            ruleForm : {
                heavy_equipment_id: this.id,
                job_order_type_id: '',
                date_created: '',
                assignee: '',
                status: ''
            },
            rules: {
                job_order_type_id: [
                    { required: true, message: 'Please select Job Order Type', trigger: 'blur' }
                ],
                date_created: [
                    { required: true, message: 'Please pick a Date', trigger: 'blur' }
                ],
                assignee: [
                    { required: true, message: 'Please input Assignee', trigger: 'blur' }
                ],
                status: [
                    { required: true, message: 'Please select Status', trigger: 'blur' }
                ],
            },
            jobOrderTypes: [],
            loadingTypes: false,
            disableButton: false,
        }
    },
    created() {
        this.getJobOrderType();
        if(this.model && this.model.id && this.mode == 'update') {
            this.ruleForm = {
                heavy_equipment_id : this.id,
                job_order_type_id : this.model.job_ordertype.type,
                job_order_type_id_id : this.model.job_order_type_id,
                assignee : this.model.assignee,
                status : this.model.status,
                date_created : this.model.date_created
            }
        }
        else if (this.mode == 'create') {

            this.ruleForm.status = 'Pending'
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
        },
        async storeJob() {
            try {
                this.disableButton = true
                this.ruleForm.date_created = this.$df.formatDate(this.ruleForm.date_created, "YYYY-MM-DD")
                const res = await this.$API.HeavyEquipmentJobOrder.storeJobOrder(this.ruleForm)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added!',
                    type: 'success'
                });
                this.resetForm('ruleForm');

                this.$EventDispatcher.fire('ADD_NEW_HEAVY_JOB_ORDER', res.data);
                this.disableButton = false;
            } catch (error) {
                console.log(error);
                this.disableButton = false;
            }
        },
        async updateJob() {
            try {
                this.disableButton = true;
                this.ruleForm.date_created = this.$df.formatDate(this.ruleForm.date_created, "YYYY-MM-DD")
                const res = await this.$API.HeavyEquipmentJobOrder.updateJobOrder(this.model.id, this.ruleForm);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated!',
                    type: 'success'
                });
                this.$EventDispatcher.fire('UPDATED_HEAVY_JOB_ORDER', res.data);
                this.disableButton = false
            } catch (error) {
                console.log(error);
                this.disableButton = false
            }
        },
        jobOrderTypeChange(value) {
            this.ruleForm.job_order_type_id_id = null;
            return value;
        },
        async getJobOrderType() {
            try {
                this.loadingTypes = true
                const res = await this.$API.HeavyEquipmentJobOrder.getJobOrderType();
                this.jobOrderTypes = res.data
                this.loadingTypes = false
            } catch (error) {
                console.log(error);
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal & this.mode == 'update') {
                this.ruleForm = {
                    heavy_equipment_id : this.id,
                    job_order_type_id : newVal.job_ordertype.type,
                    job_order_type_id_id : newVal.job_order_type_id,
                    assignee : newVal.assignee,
                    status : newVal.status,
                    date_created : newVal.date_created
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.ruleForm = {
                    heavy_equipment_id: this.id,
                    job_order_type_id: '',
                    date_created: '',
                    assignee: '',
                    status: ''
                }

                this.ruleForm.status = 'Pending'
            }
        }
    }
}
</script>
