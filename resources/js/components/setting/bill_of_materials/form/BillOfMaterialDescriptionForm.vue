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
        name: 'BillOfMaterialItemForm',
        props: {
            mode: '',
            model: {}
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
                }
            }
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                if (valid) {
                    if(this.mode == 'update') {
                        this.updateDescription();
                        return
                    }
                    this.storeDescription();
                } else {
                    console.log('error submit!!');
                    return false;
                }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            async storeDescription() {
                try {
                    const res = await this.$API.BillOfMaterial.storeDescription(this.form)
                    this.$EventDispatcher.fire('NEW_BILL_DESCRIPTION', res.data);
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Added',
                        type: 'success'
                    });
                } catch(error) {
                    console.log(error)
                }
            },
            async updateDescription() {
                try {
                    const res = await this.$API.BillOfMaterial.updateDescription(this.model.id, this.form)
                    this.$EventDispatcher.fire('UPDATED_DESCRIPTION', res.data);
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Updated',
                        type: 'success'
                    });
                }catch(error) {
                    console.log(error)
                }
            }
        },
        watch: {
            mode(val) {
                if(val) {
                    if(val == 'create') {
                        this.form = {
                            name: '',
                        }
                    }
                }
            },
            model(newVal, oldVal) {
                if(newVal != oldVal) {
                    this.form = {
                        name: newVal.name,
                    }
                }
            }
        }
    }
</script>