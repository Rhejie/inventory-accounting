<template>
    <div>
        <el-form :model="form" label-position="top" :rules="rules" ref="form" class="demo-ruleForm">
            <a class="btn btn-warning font-weight-bold btn-sm" style="margin:10px" :href="`/proposal/generate-pdf/${id}`" target="_blank">Download Proposal</a>
            <el-form-item label="Attach the file after download" prop="fileData">
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
                    <el-button size="small" type="primary">Select File</el-button>
                </el-upload>
            </el-form-item>
            <div class="row">
                <div class="col-md-12">
                    <el-form-item style="float: right">
                        <el-button :disabled="disabled" type="primary" @click="submitForm('form')">Send</el-button>
                        <el-button :disabled="disabled" @click="resetForm('form')">Reset</el-button>
                    </el-form-item>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'SendProposalForm',
    props: {
        id: null
    },
    data() {
        return {
            fileList: [],
            fileData: '',
            form: {
                fileData: ''
            },
            rules: {
                fileData: [
                    { required: true, message: 'Please select File', trigger: 'change' }
                ],
            },
            disabled: false
        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_ATTACHMENT_FORM', data => {
            this.resetForm('form');
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                this.sendProposal();

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
        async sendProposal() {
            try {
                this.disabled = true
                let formData = new FormData();
                if(this.form.fileData)formData.append('fileData', this.form.fileData)
                const res = await this.$API.Proposal.sendProposal(this.id, formData);
                this.disabled = false
                this.$EventDispatcher.fire('SEND_PROPOSAL', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Send Successfully',
                    type: 'success'
                });
                this.resetForm('form')
            } catch(error) {
                console.log(error)
            }
        },
        handlePreview(file) {
            console.log(file);
        },
        handleRemove(file, fileList) {
            console.log(file, fileList);
        },
        fileChange(file, fileList) {
            this.form.fileData = file.raw
        },
    }
}
</script>
