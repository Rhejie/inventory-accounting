<template>
    <div>
         <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Type" prop="type">
                <el-input v-model="form.type"></el-input>
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
    name: 'JobOrderType',
    props: {
        model: {},
        mode: null
    },
    data() {
        return {
            form: {
                type: null,
            },
            rules: {
                type: [
                    {required: true, message: 'Please input Type', trigger: 'blur'}
                ],
            },
            disableButton: false,
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.form = {
                type: this.model.type,
            }
        }
        this.$EventDispatcher.listen('handleCloseJOType', data => {
            this.resetForm('form')
        })
    },
    methods: {
        async storeType() {
            this.disableButton = true
            try {
                const res = await this.$API.JobOrderType.store(this.form);

                this.$EventDispatcher.fire('NEW_JOB_ORDER_TYPE', res.data);
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

                const res = await this.$API.JobOrderType.update(this.model.id, this.form);

                this.$EventDispatcher.fire('UPDATE_JOB_ORDER_TYPE', res.data);
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
                }
            }
            else {

                this.form = {
                    type: this.model.type,
                }
            }
        }
    }
}
</script>
