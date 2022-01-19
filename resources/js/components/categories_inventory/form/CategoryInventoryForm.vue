<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="Type" prop="type_id">
                <el-select v-model="form.type_id" placeholder="Select type" v-loading="loading_types">
                    <el-option v-for="(type, index) in types" :key="index" :label="type.name" :value="type.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                <el-button @click="resetForm('form')" :disabled="disableButton" v-if="mode == 'create'">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'CategoryInventoryForm',
    props: {
        mode: null,
        model: {}
    },
    data() {
        return {
            types: [],
            form: {
                name: null,
                type_id: null
            },
            rules: {
                name: [
                    {required: true, message: 'Please input Name', trigger: 'blur'}
                ],
                type_id: [
                    {required: true, message: 'Please input Name', trigger: 'blur'}
                ]
            },
            loading_types: false,
            disableButton: false
        }
    },
    created() {
        this.getTypes();
        if(this.model && this.model.id) {
            this.form = {
                name: this.model.name,
                type_id: this.model.type_id
            }
        }
        this.$EventDispatcher.listen('handleCloseCI', data => {
            this.resetForm('form')
        })
    },
    methods: {
        async getTypes() {
            try {
                this.loading_types = true;
                const res = await this.$API.CategoryInventory.getTypes();
                this.types = res.data;
                this.loading_types = false;
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
                this.storeCategory();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async storeCategory() {
            this.disableButton = true
            try {
                let formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('type_id', this.form.type_id);

                const res = await this.$API.CategoryInventory.storeCategory(formData);

                this.$EventDispatcher.fire('NEW_CATEGORY_INVENTORY', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.resetForm('form');
                this.disableButton = false
            } catch (error) {
                console.log(error);
            }
        },
        async updateType() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('type_id', this.form.type_id);

                const res = await this.$API.CategoryInventory.updateCategory(this.model.id, formData);

                this.$EventDispatcher.fire('UPDATED_CATEGORY_INVENTORY', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.resetForm('form');
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    name: newVal.name,
                    type_id: newVal.type_id
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    name: '',
                    type_id: '',
                }
            }
            else {
                 this.form = {
                    name: this.model.name,
                    type_id: this.model.type_id
                }
            }
        }
    }
}
</script>
