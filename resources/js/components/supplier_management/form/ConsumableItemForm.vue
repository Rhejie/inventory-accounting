<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Item" prop="item">
                <el-input v-model="form.item" placeholder="Item"></el-input>
            </el-form-item>
            <el-form-item label="Unit" prop="unit">
                <el-input v-model="form.unit" placeholder="Example: Per Sack..."></el-input>
            </el-form-item>
            <el-form-item label="Unit Price" prop="unit_price">
                <el-input type="number" v-model="form.unit_price" placeholder="Price..."></el-input>
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
    name: 'ConsumableItemForm',
    props: {
        mode: null,
        model: {},
        id: null
    },
    data() {
        return {
            form: {
                item: '',
                unit_price: '',
            },
            rules:{
                item: [
                    {required: true, message: 'Please input Name', trigger: 'blur'}
                ],
                unit_price: [
                    {required: true, message: 'Please input Unit Price', trigger: 'blur'}
                ],
                unit: [
                    {required: true, message: 'Please input Unit', trigger: 'blur'}
                ],
            },
            disableButton : false
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.form = {
                item: this.model.item,
                unit: this.model.unit,
                unit_price: this.model.unit_price,
            }
        }

        this.$EventDispatcher.listen('handCloseSUpplierItem', data => {
            this.resetForm('form')
        })
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
            this.disableButton = true
            try {
                let formData = new FormData();
                if(this.form.item)formData.append('item', this.form.item)
                if(this.form.unit)formData.append('unit', this.form.unit)
                if(this.form.unit_price)formData.append('unit_price', this.form.unit_price)
                const res = await this.$API.Consumable.storeConsumableItem(this.id, formData);
                this.$EventDispatcher.fire('ADD_NEW_ITEM', res.data);
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
        async updateItem() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.form.item)formData.append('item', this.form.item)
                if(this.form.unit)formData.append('unit', this.form.unit)
                if(this.form.unit_price)formData.append('unit_price', this.form.unit_price)
                const res = await this.$API.Consumable.updateConsumableItem(this.model.id, formData);
                this.$EventDispatcher.fire('UPDATE_ITEM', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
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
                    item: newVal.item,
                    unit: newVal.unit,
                    unit_price: newVal.unit_price
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    item: '',
                    unit: '',
                    unit_price: '',
                }
            }
        }
    }
}
</script>
