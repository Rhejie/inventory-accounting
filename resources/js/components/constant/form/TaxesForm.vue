<template>
    <div>
        <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="form.name" placeholder="Name..."></el-input>
            </el-form-item>
            <el-form-item label="Rate" prop="rate">
                <el-input type="number" v-model="form.rate" placeholder="12%..."></el-input>
            </el-form-item>
            <el-form-item>
                <el-button :disabled="disabledButton" type="primary"  @click="submitForm('form')">Save</el-button>
                <el-button :disabled="disabledButton" @click="resetForm('form')"  v-if="mode != 'update'">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
    </div>
</template>
<script>
export default {
    name: 'TaxesForm',
    props: {
        mode: null,
        model: {}
    },
    data() {
        return {
            form: {
                name: '',
                rate: '',
            },
            rules:{
                name: [
                    {required: true, message: 'Please input Name', trigger: 'blur'}
                ],
                rate: [
                    {required: true, message: 'Please input Rate', trigger: 'blur'}
                ],
            },
            disabledButton: false
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.form = {
                name: this.model.name,
                rate: this.model.rate
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateTax();
                    return
                }
                this.storeTax();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async storeTax() {
            try {
                this.disabledButton = true
                const res = await this.$API.Constant.storeTax(this.form)
                this.disabledButton = false
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.$EventDispatcher.fire('NEW_TAX', res.data);
                this.resetForm('form');
            } catch (error) {
                console.log(error);
            }
        },
        async updateTax() {
            try {
                this.disabledButton = true
                const res = await this.$API.Constant.updateTax(this.model.id, this.form)
                this.disabledButton = false
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.$EventDispatcher.fire('UPDATE_TAX', res.data);
            } catch (error) {
                console.log(error);
            }
        }
    },
    watch: {
        mode(val) {
            if(val && val == 'create') {
                this.form = {
                    name: '',
                    rate: ''
                }
            }
        },
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    name: newVal.name,
                    rate: newVal.rate,
                }
            }
        }
    }
}
</script>
