<template>
	<div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Request Material Code" prop="request_material_code">
                <el-input v-model="form.request_material_code" v-loading="loadingCode" disabled placeholder="Name..."></el-input>
            </el-form-item>
            <el-form-item label="Project" prop="project_id">
                <el-select
                    v-model="form.project_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    @change="changeProjectId"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethod"
                    :loading="loading">
                    <el-option
                    v-for="item in projects"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Request By" prop="requested_by">
                <el-input v-model="form.requested_by" placeholder="Name..."></el-input>
            </el-form-item>
            <el-form-item label="Approved By" prop="approved_by">
                <el-input v-model="form.approved_by" placeholder="Name..."></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                <el-button @click="resetForm('form')" :disabled="disableButton" v-if="mode != 'update'">Reset</el-button>
            </el-form-item>
        </el-form>
	</div>
</template>

<script>
export default {
    name: 'RequestMaterialForm',
    props: {
        pageData: {},
        model: {},
        mode: null
    },
    data() {
        return {
            form: {
                requested_by: '',
                project_id: '',
                approved_by: '',
                request_material_code: ''
            },
            rules:{
                project_id: [
                    {required: true, message: 'Please select Project', trigger: 'blur'}
                ],
                request_material_code: [
                    {required: true, message: 'Please input Request Material Code', trigger: 'blur'}
                ],
                requested_by: [
                    {required: true, message: 'Please input Request by', trigger: 'blur'}
                ],
            },
            projects: [],
            loading: false,
            disableButton: false,
            loadingCode: false,
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.form = {
                project_id : this.model.project.name,
                project_project_id: this.model.project.id,
                requested_by : this.model.requested_by,
                approved_by: this.model.approved_by,
                request_material_code: this.model.request_material_code
            }
        }
        else {
            this.getCode()
        }

        this.$EventDispatcher.listen('handCloseRequestMaterial', data => {
            this.resetForm('form')
        })


    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateRequest();
                    return
                }
                this.storeRequest();
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
                const res = await this.$API.RequestMaterial.getNumber();
                this.form.request_material_code = res.data
                this.loadingCode = false;
            } catch (error) {
                console.log(error);
            }
        },
        async remoteMethod(query) {
            if (query !== '') {
                this.loading = true;
                try {
                    const res = await this.$API.RequestMaterial.getProjects(query);
                    this.projects = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.projects = [];
            }
        },
        async storeRequest() {
            this.disableButton = true
            try {
                let formData = new FormData();
                if(this.form.project_id)formData.append('project_id', this.form.project_id);
                if(this.form.requested_by)formData.append('requested_by', this.form.requested_by);
                if(this.form.request_material_code)formData.append('request_material_code', this.form.request_material_code);
                if(this.form.approved_by)formData.append('approved_by', this.form.approved_by);

                const res = await this.$API.RequestMaterial.storeRequest(formData);

                this.$EventDispatcher.fire('NEW_REQUEST_MATERIAL', res.data);

                this.$router.push({
                    name: 'Request Material Details',
                    params: {id: res.data.id, data: res.data}
                });

                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.resetForm('form');
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async updateRequest() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.form.project_id)formData.append('project_id', this.form.project_id);
                if(this.form.requested_by)formData.append('requested_by', this.form.requested_by);
                if(this.form.approved_by)formData.append('approved_by', this.form.approved_by);
                if(this.form.request_material_code)formData.append('request_material_code', this.form.request_material_code);
                if(this.form.project_project_id)formData.append('project_project_id', this.form.project_project_id)

                const res = await this.$API.RequestMaterial.updateRequest(this.model.id, formData);

                this.$EventDispatcher.fire('UPDATE_REQUEST_MATERIAL', res.data);
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
        changeProjectId(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.project_project_id = null
                return value;
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    project_project_id: newVal.project.id,
                    project_id : newVal.project.name,
                    requested_by: newVal.requested_by,
                    approved_by: newVal.approved_by,
                    request_material_code: newVal.request_material_code
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    requested_by: '',
                    project_id: ''
                }
                this.getCode()
            }
        }
    }
}
</script>
