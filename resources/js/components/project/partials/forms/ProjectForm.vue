<template>
    <div>
        <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="150px" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="ruleForm.name"></el-input>
            </el-form-item>
            <el-form-item label="Location" prop="location">
                <el-input type="textarea" v-model="ruleForm.location"></el-input>
            </el-form-item>
            <el-form-item label="Date">
                <el-col :span="11">
                <el-form-item prop="date_start">
                    <el-date-picker type="date" placeholder="Pick a Starting Date" v-model="ruleForm.date_start" style="width: 100%;"></el-date-picker>
                </el-form-item>
                </el-col>
                <el-col class="line" :span="2"> &nbsp; </el-col>
                <el-col :span="11">
                <el-form-item prop="date_end">
                    <el-date-picker type="date" placeholder="Pick a Ending Date" v-model="ruleForm.date_end" style="width: 100%;"></el-date-picker>
                </el-form-item>
                </el-col>
            </el-form-item>
            <el-form-item label="Budget" prop="budget">
                <el-input-number style="width: 80%" v-model="ruleForm.budget" controls-position="right" :min="0" ></el-input-number>
            </el-form-item>
            <el-form-item label="Status" prop="status_id">
                <el-select v-model="ruleForm.status_id" placeholder="Select Status">
                    <el-option v-for="(status, index) in pageData" :key="index" :label="status.name" :value="status.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Photo" prop="photo">
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
                    :limit="1"
                    accept="image/png, image/gif, image/jpeg, image/jpg"
                    list-type="picture">
                    <el-button size="small" type="primary">Click to upload Photo</el-button>
                </el-upload>
            </el-form-item>
            <el-form-item label="Description form" prop="description">
                <el-input type="textarea" v-model="ruleForm.description"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('ruleForm')" :disabled="disableButton">Save</el-button>
                <el-button @click="resetForm('ruleForm')" :disabled='disableButton' v-if="mode == 'create'">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'ProjectForm',
    props: {
        pageData: {},
        project: {},
        mode: null
    },
    data() {
        return {
            fileList: [],
            list_type: 'picture',
            ruleForm: {
                name: '',
                location: '',
                description: '',
                date_start: '',
                status_id: '',
                date_end: '',
                budget: '',
                percentage: null,
            },
            disableButton: false,
            rules: {
                name: [
                    { required: true, message: 'Please input Name', trigger: 'blur' }
                ],
                location: [
                    { required: true, message: 'Please input Location', trigger: 'blur' }
                ],
                status_id: [
                    { required: true, message: 'Please select Status', trigger: 'change' }
                ],
            }
        }
    },
    created() {
        if(this.project && this.project.id) {
            this.ruleForm = {
                name: this.project.name,
                location: this.project.location,
                description: this.project.description,
                date_start: this.project.date_start,
                status_id: this.project.status_id,
                date_end: this.project.date_end,
                budget: this.project.budget,
                percentage: this.project.percentage,
            };

            if(this.project.photo) {
                this.fileList = [{name: this.project.photo, url: `/storage/project/photo/${this.project.photo}`}]
            }
        }

        this.$EventDispatcher.listen('handleCloseProject', data => {
            this.ruleForm = {
                name: data.name,
                location: data.location,
                description: data.description,
                date_start: data.date_start,
                status_id: data.status_id,
                date_end: data.date_end,
                budget: data.budget,
                percentage: data.percentage,
            };

            if(data.photo) {
                this.fileList = [{name: data.photo, url: `/storage/project/photo/${this.project.photo}`}]
            }
            else {
                this.fileList.splice(1,1)
            }
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.update();
                }else {
                    this.store();
                }
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.fileList.splice(1,1)
        },
        handlePreview(file) {
            this.fileList.splice(1,1);
            console.log(file);
        },
        handleRemove(file, fileList) {
            console.log(file, fileList);
        },
        fileChange(file, fileList) {
            this.ruleForm.photo = file.raw
        },
        async store() {
            this.disableButton = true
            try {
                let formData = new FormData();
                if(this.ruleForm.name)formData.append('name', this.ruleForm.name);
                if(this.ruleForm.location)formData.append('location', this.ruleForm.location);
                if(this.ruleForm.date_start)formData.append('date_start', this.$df.formatDate(this.ruleForm.date_start, "YYYY-MM-DD"));
                if(this.ruleForm.date_end)formData.append('date_end', this.$df.formatDate(this.ruleForm.date_end, "YYYY-MM-DD"));
                if(this.ruleForm.budget)formData.append('budget', this.ruleForm.budget);
                if(this.ruleForm.status_id)formData.append('status_id', this.ruleForm.status_id);
                if(this.ruleForm.percentage)formData.append('percentage', this.ruleForm.percentage);
                if(this.ruleForm.description)formData.append('description', this.ruleForm.description);
                if(this.ruleForm.photo)formData.append('photo', this.ruleForm.photo);

                const res = await this.$API.Project.storeProject(formData);
                this.resetForm('ruleForm');
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.$EventDispatcher.fire("NEW_PROJECT", res.data);
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async update(){
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.ruleForm.name)formData.append('name', this.ruleForm.name);
                if(this.ruleForm.location)formData.append('location', this.ruleForm.location);
                if(this.ruleForm.date_start)formData.append('date_start', this.$df.formatDate(this.ruleForm.date_start, "YYYY-MM-DD"));
                if(this.ruleForm.date_end)formData.append('date_end', this.$df.formatDate(this.ruleForm.date_end, "YYYY-MM-DD"));
                if(this.ruleForm.budget)formData.append('budget', this.ruleForm.budget);
                if(this.ruleForm.status_id)formData.append('status_id', this.ruleForm.status_id);
                if(this.ruleForm.percentage)formData.append('percentage', this.ruleForm.percentage);
                if(this.ruleForm.description)formData.append('description', this.ruleForm.description);
                if(this.ruleForm.photo)formData.append('photo', this.ruleForm.photo);

                const res = await this.$API.Project.updateProject(this.project.id, formData);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });

                this.$EventDispatcher.fire('UPDATED_PROJECT', res.data);
                this.rul
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        }
    },
    watch: {
        mode(val) {
            if(val == 'create') {
                this.resetForm('ruleForm')
            }
        }
    }
}
</script>
