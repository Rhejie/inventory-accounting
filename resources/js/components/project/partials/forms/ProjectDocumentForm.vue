<template>
    <div>
        <el-form :model="fileForm" :rules="rules" ref="fileForm" label-width="120px" class="demo-ruleForm">
            <el-form-item label="Remarks" prop="remarks">
                <el-input v-model="fileForm.remarks" placeholder="Input Remarks"></el-input>
            </el-form-item>
            <el-form-item label="Type" prop="type">
                <el-select v-model="fileForm.type"  style="width:100%" placeholder="Select Type">
                <el-option label="Quotation" value="Quotation"></el-option>
                <el-option label="Contracts" value="Contracts"></el-option>
                <el-option label="Others" value="Others"></el-option>
                </el-select>
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
                    <el-button size="small" type="primary">Click to upload</el-button>
                </el-upload>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('fileForm')">Save</el-button>
                <el-button :disabled="disableButton" v-if="mode != 'update'" @click="resetForm('fileForm')">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: "ProjectDocumentForm",
    props: {
        id: null,
        editData: {},
        mode: {
            default: null
        }
    },
    data() {
        return {
            fileList: [],
            list_type: 'picture',
            fileForm: {
                remarks: null,
                type: null,
                file: null,
                file_name: null,
            },
            rules: {
                remarks: [
                    { required: true, message: 'Please input Remarks', trigger: 'blur' },
                ],
                type: [
                    { required: true, message: 'Please select Type', trigger: 'blur' }
                ],
            },
            disableButton: false
        }
    },
    created() {
        if(this.editData.id && this.editData) {
            this.fileForm = {
                id: this.editData.id,
                remarks: this.editData.remarks,
                type: this.editData.type,
            }
            this.fileList = [{name: this.editData.file_name, url: `/storage/project/documents/${this.editData.file}`}]
        }
        else {
            this.fileForm = {
                id: null,
                remarks: null,
                type: null,
            }
        }
        this.$EventDispatcher.listen('handleCloseProjectDoc', data => {
            this.resetForm('fileForm')
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    if(this.mode == 'update') {
                        this.updateDocument()
                        return
                    }
                    this.saveProjectDocument();
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
        handleRemove(file, fileList) {
            console.log(file, fileList);
        },
        handlePreview(file) {
            console.log(file);
        },
        fileChange(file, fileList) {
            this.fileForm.file = file.raw
            this.fileForm.file_name = file.name
        },
        addFile() {
            this.fileForm.file = this.$refs.file.files[0]
        },
        async saveProjectDocument(){
            this.disableButton = true;
            try {
                let formData = new FormData();
                formData.append('remarks', this.fileForm.remarks);
                formData.append('type', this.fileForm.type);
                formData.append('file', this.fileForm.file);
                formData.append('file_name', this.fileForm.file_name);
                const response = await this.$API.Project.storeProjectDocument(formData, this.id)
                // console.log(response);
                this.$emit('addNewDocument', response.data);
                this.resetForm('fileForm')
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async updateDocument() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                formData.append('remarks', this.fileForm.remarks);
                formData.append('type', this.fileForm.type);
                formData.append('file', this.fileForm.file);
                formData.append('file_name', this.fileForm.file_name);
                const response = await this.$API.Project.updateProjectDocument(formData, this.editData.id)
                // console.log(response);
                this.$EventDispatcher.fire('UPDATED_PROJECT_DOCUMENT', response.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        }
    },
    watch: {
        editData(newVal, oldVal) {
            if(newVal != oldVal) {
                this.fileForm = {
                    id: newVal.id,
                    remarks: newVal.remarks,
                    type: newVal.type,
                }
                this.fileList = [{name: newVal.file_name, url: `/storage/project/documents/${newVal.file}`}]
            }
        },
        mode(val) {
            if(val == 'create') {
                this.fileForm = {
                    remarks: null,
                    type: null,
                    file: null,
                    file_name: null,
                }

                this.fileList.splice(1,1)
            }
        }
    }
}
</script>
