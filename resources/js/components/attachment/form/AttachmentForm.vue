<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
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
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                <el-button :disabled="disableButton"  @click="resetForm('form')">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'AttachmentForm',
    props: {
        attachmentId: null,
        type: null
    },
    data() {
        return {
            form: {
                file: '',
                file_name: ''
            },
            rules: {
                file: [
                    {required: true, message: 'Please select File', trigger: 'blur'}
                ],
            },
            disableButton: false,
            fileList: [],
        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_ATTACHMENT_FORM', data => {
            this.fileList = []
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateType();
                    return
                }
                this.storeAttachment();
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
        async storeAttachment() {
            try {
                const formData = new FormData();
                formData.append('file_name', this.form.file_name)
                formData.append('file', this.form.file)
                formData.append('type', this.type)
                formData.append('attachment_id', this.attachmentId)
                this.disableButton = true
                const res = await this.$API.Attachment.storeAttachment(formData)
                this.disableButton = false
                if(this.type == 'bill' || this.type == 'invoice' || this.type == 'proposal') {
                    this.$EventDispatcher.fire('NEW_ATTACHMENT_BILL', res.data)
                }
                this.fileList = []
                this.$EventDispatcher.fire('NEW_ATTACHMENT', res.data)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
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
            this.form.file = file.raw
            this.form.file_name = file.name
        },
    },
}
</script>
