<template>
    <div>
         <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                <el-button :disabled="disableButton" v-if="mode != 'update'" @click="resetForm('form')">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'ProjectStatusForm',
    props: {
        model: {},
        mode: null
    },
    data() {
        return {
            form: {
                name: null,
            },
            rules: {
                name: [
                    {required: true, message: 'Please input Name', trigger: 'blur'}
                ],
            },
            disableButton: false,
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.form = {
                name: this.model.name,
                resource_type: this.model.resource_type
            }
        }
        this.$EventDispatcher.listen('handleCloseProjectStatus', data => {
            this.resetForm('form')
        })
    },
    methods: {
        async storeType() {
            this.disableButton = true
            try {
                const res = await this.$API.ProjectStatus.store(this.form);

                this.$EventDispatcher.fire('NEW_PROJECT_STATUS', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.disableButton = false;
                this.resetForm('form');
            } catch (error) {
                console.log(error);
            }
        },
        async updateType() {
            this.disableButton = true;
            try {

                const res = await this.$API.ProjectStatus.update(this.model.id, this.form);

                this.$EventDispatcher.fire('UPDATE_PROJECT_STATUS', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.disableButton = false
            } catch (error) {
                console.log(error);
            }
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateType();
                    return
                }
                this.storeType();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    name: newVal.name,
                    resource_type: newVal.resource_type
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    name: '',
                    resource_type: '',
                }
            }
            else {

                this.form = {
                    name: this.model.name,
                    resource_type: this.model.resource_type
                }
            }
        }
    }
}
</script>
