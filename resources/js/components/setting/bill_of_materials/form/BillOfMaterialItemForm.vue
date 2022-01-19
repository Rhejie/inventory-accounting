<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="Description" prop="description">
                <el-input v-model="form.description"></el-input>
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
                    description: null
                },
                rules: {
                    name: [
                        {required: true, message: 'Please input Name', trigger: 'blur'}
                    ],
                    description: [
                        {required: true, message: 'Please input Description', trigger: 'blur'}
                    ]
                },
                disableButton: false,
            }
        },
        created() {
            if(this.model && this.model.id) {
                this.form = {
                    name: this.model.name,
                    description : this.model.description
                }
            }
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                if (valid) {
                    if(this.mode == 'update') {
                        this.updateItem();
                        return
                    }
                    this.storeItem();
                } else {
                    console.log('error submit!!');
                    return false;
                }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            async storeItem() {
                try {
                    const res = await this.$API.BillOfMaterial.storeItem(this.form)
                    this.$EventDispatcher.fire('NEW_BILL_ITEM', res.data);
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Added',
                        type: 'success'
                    });
                } catch(error) {
                    console.log(error)
                }
            },
            async updateItem() {
                try {
                    const res = await this.$API.BillOfMaterial.updateItem(this.model.id, this.form)
                    this.$EventDispatcher.fire('UPDATED_ITEM', res.data);
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
                            description: ''
                        }
                    }
                }
            },
            model(newVal, oldVal) {
                if(newVal != oldVal) {
                    this.form = {
                        name: newVal.name,
                        description: newVal.description,
                    }
                }
            }
        }
    }
</script>