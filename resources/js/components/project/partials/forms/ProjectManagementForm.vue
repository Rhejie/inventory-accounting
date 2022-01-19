<template>
    <div>
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="top" label-width="120px" class="demo-ruleForm">
            <el-row>
                <el-col :span="18">
                    <el-form-item label="Title / Name" prop="name">
                        <el-input v-model="ruleForm.name"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="1"> &nbsp;</el-col>
                <el-col :span="5">
                    <el-form-item label="Color" prop="color">
                        <el-color-picker v-model="ruleForm.color" style="width: 100%"></el-color-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>
                <el-form-item label="Include Note" prop="desc">
                    <el-input type="textarea" v-model="ruleForm.desc"></el-input>
                </el-form-item>
            </el-row>
            <el-row>
                <el-col :span="11">
                    <el-form-item label="Start Date" prop="date1">
                        <el-date-picker type="date" placeholder="Pick a date" v-model="ruleForm.date1" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="2">&nbsp;</el-col>
                <el-col :span="11">
                    <el-form-item label="Select Start Time" prop="date2">
                        <el-time-picker placeholder="Pick a time" format="hh:mm A" value-format="hh:mm A" v-model="ruleForm.date2" style="width: 100%;"></el-time-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-row>
                <el-col :span="11">
                    <el-form-item label="End Date" prop="date1">
                        <el-date-picker type="date" placeholder="Pick a date" v-model="ruleForm.date1" style="width: 100%;"></el-date-picker>
                    </el-form-item>
                </el-col>
                <el-col :span="2">&nbsp;</el-col>
                <el-col :span="11">
                    <el-form-item label="Select End Time" prop="date2">
                        <el-time-picker placeholder="Pick a time" format="hh:mm A" value-format="hh:mm A" v-model="ruleForm.date2" style="width: 100%;"></el-time-picker>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="Select a Person.." prop="name">
                <el-input v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-checkbox label="Show Progress Indicator" v-model="isShow"></el-checkbox>
            <el-row>
                <el-col :span="6">
                    <el-form-item prop="progress">
                        <el-input-number v-model="ruleForm.progress" @change="progressChange" :min="1" :max="100"></el-input-number>
                    </el-form-item>
                </el-col>
                <el-col :span="1"></el-col>
                <el-col :span="17" v-if="isShow">
                    <el-progress :text-inside="true" :stroke-width="24" :percentage="ruleForm.progress" :status="status_bar"></el-progress>
                </el-col>
            </el-row>
            <el-form-item >
                <div style="float: right">
                    <el-button type="primary" @click="submitForm('ruleForm')">Create</el-button>
                    <el-button @click="resetForm('ruleForm')">Reset</el-button>
                </div>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'ProjectManagementForm',
    props: {
        editData: {}
    },
    data () {
        return {
            isShow: true,
            ruleForm: {
                name: '',
                region: '',
                date1: '',
                date2: '',
                delivery: false,
                type: [],
                resource: '',
                desc: '',
                progress: 0
                },
                rules: {
                name: [
                    { required: true, message: 'Please input Activity name', trigger: 'blur' },
                    { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' }
                ],
                region: [
                    { required: true, message: 'Please select Activity zone', trigger: 'change' }
                ],
                date1: [
                    { type: 'date', required: true, message: 'Please pick a date', trigger: 'change' }
                ],
                date2: [
                    { type: 'date', required: true, message: 'Please pick a time', trigger: 'change' }
                ],
                type: [
                    { type: 'array', required: true, message: 'Please select at least one activity type', trigger: 'change' }
                ],
                resource: [
                    { required: true, message: 'Please select activity resource', trigger: 'change' }
                ],
                desc: [
                    { required: true, message: 'Please input activity form', trigger: 'blur' }
                ]
                },
                status_bar: 'exception'
        }
    },
    created(){

    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                alert('submit!');
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        progressChange(data) {
            if(data == 100) {
                this.status_bar = 'success'
            }
            if(data == 80 ) {
                this.status_bar = 'warning'
            }
            if(data == 70) {
                this.status_bar = ''
            }
            if(data < 70) {
                this.status_bar = 'exception'
            }
        }
    }
}
</script>
<style lang="scss">
    .span {
        margin-right: 10px;
    }
</style>
