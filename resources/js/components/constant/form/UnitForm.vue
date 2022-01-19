<template>
    <div>
        <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="form.name" placeholder="Name..."></el-input>
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
            },
            rules:{
                name: [
                    {required: true, message: 'Please input Name', trigger: 'blur'}
                ],
            },
            disabledButton : false
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
                    this.updateUnit();
                    return
                }
                this.storeUnit();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async storeUnit() {
            try {
                this.disabledButton = true
                const res = await this.$API.Constant.storeUnit(this.form)
                this.disabledButton = false;
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.$EventDispatcher.fire('NEW_UNIT', res.data);
                this.resetForm('form');
            } catch (error) {
                console.log(error);
            }
        },
        async updateUnit() {
            try {
                this.disabledButton = true
                const res = await this.$API.Constant.updateUnit(this.model.id, this.form)
                this.disabledButton = false
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.$EventDispatcher.fire('UPDATE_UNIT', res.data);
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
