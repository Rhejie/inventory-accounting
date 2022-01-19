<template>
    <div>
        <el-form :model="fileForm" :rules="rules" ref="fileForm" label-position="top" class="demo-ruleForm">
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
                    <el-button size="small" type="primary">Click to upload Document</el-button>
                </el-upload>
            </el-form-item>
            <el-form-item label="Document Type" prop="file_type">
                <el-select v-model="fileForm.file_type"  style="width:100%" placeholder="Select Type">
                <el-option label="Insurance" value="Insurance"></el-option>
                <el-option label="LTO registration" value="LTO registration"></el-option>
                <el-option label="Emissions" value="Emissions"></el-option>
                <el-option label="Third Party Certificate" value="Third Party Certificate"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('fileForm')">Save</el-button>
                <el-button :disabled="disableButton" v-if="mode == 'create'" @click="resetForm('fileForm')">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'OtherInventoryDocumentForm',
    props: {
        id: null,
        model: {},
        mode: null
    },
    data() {
        return {
            fileList: [],
            fileForm: {
                file_type: '',
                atteched_file: '',
                file_name: ''
            },
            rules: {
                file_type: [
                    { required: true, message: 'Please select Type', trigger: 'blur' }
                ],
            },
            disableButton: false,
        }
    },
    created() {
        this.initialize();
        if(this.model && this.model.id) {
            this.fileForm = {
                file_type: this.model.file_type,
                atteched_file: this.model.atteched_file,
                file_name: this.model.file_name
            }
            this.fileList = [{name: this.model.file_name, url: `/storage/truck_vehicle/photo/${this.model.attached_file}`}]
        }

        this.$EventDispatcher.listen('handleCLoseODOC', data => {
            this.resetForm("fileForm")
        })
    },
    methods: {
        initialize() {
            this.fileList.splice(1,1);
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    if(this.mode == 'update') {
                        this.updateDocument()
                        return ;
                    }
                    this.storeOtherDocument()
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
            this.fileForm.atteched_file = file.raw,
            this.fileForm.file_name = file.name
        },

        async storeOtherDocument() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                formData.append('attached_file', this.fileForm.atteched_file);
                formData.append('file_type', this.fileForm.file_type);
                formData.append('file_name', this.fileForm.file_name);

                const res = await this.$API.OtherInventory.storeDocument(this.id, formData)

                this.$EventDispatcher.fire('ADD_NEW_OTHER_INVENTORY_DOCUMENt', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.disableButton = false
                this.resetForm('fileForm')
            } catch (error) {
                console.log(error);
            }
        },
        async updateDocument() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                formData.append('attached_file', this.fileForm.atteched_file);
                formData.append('file_type', this.fileForm.file_type);
                formData.append('file_name', this.fileForm.file_name);

                const res = await this.$API.OtherInventory.updateDocument(this.model.id, formData)

                this.$EventDispatcher.fire('UPDATED_OTHER_INVENTORY_DOCUMENt', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.disableButton = false
            } catch (error) {
                console.log(error);
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.fileForm = {
                    file_type: newVal.file_type,
                    atteched_file: newVal.atteched_file,
                    file_name: newVal.file_name
                }
                this.fileList = [{name: newVal.file_name, url: `/storage/truck_vehicle/photo/${newVal.attached_file}`}]
            }
        },
        mode(val) {
            if(val == 'create') {
                this.fileForm = {
                    file_type: '',
                    atteched_file: '',
                    file_name: ''
                }
                this.fileList = []
            }
            else {
                this.fileForm = {
                    file_type: this.model.file_type,
                    atteched_file: this.model.atteched_file,
                    file_name: this.model.file_name
                }
                this.fileList = [{name: this.model.file_name, url: `/storage/truck_vehicle/photo/${this.model.attached_file}`}]
            }
        }
    }
}
</script>
