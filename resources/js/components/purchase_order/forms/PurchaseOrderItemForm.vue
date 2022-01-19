<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Item" prop="item">
                <el-input v-model="form.item" placeholder="Item..."></el-input>
            </el-form-item>
            <el-form-item label="Description" prop="description">
                <el-input type="textarea" v-model="form.description" placeholder="Description..."></el-input>
            </el-form-item>
            <el-form-item label="Quantity" prop="quantity">
                <el-input type="number" v-model="form.quantity" placeholder="Quantity..."></el-input>
            </el-form-item>
            <el-form-item label="Unit" prop="unit">
                <el-input v-model="form.unit" placeholder="Unit..."></el-input>
            </el-form-item>
            <el-form-item label="Unit Price" prop="unit_price">
                <el-input type="number" v-model="form.unit_price" placeholder="Unit Price..."></el-input>
            </el-form-item>
            <el-form-item label="Amount" prop="amount">
                <el-input type="number" v-model="form.amount" placeholder="Amount..."></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('form')">Create</el-button>
                <el-button @click="resetForm('form')">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    nmae: 'PurchaseOrderItemForm',
    props: {
        mode: null,
        model: {},
        id: null,
    },
    data() {
        return {
            form : {
                item: '',
                description: '',
                quantity: '',
                unit: '',
                unit_price: '',
                amount: '',
            },
            rules: {
                item: [
                    {required: true, message: 'Please input Item', trigger: 'blur'}
                ],
                description: [
                    {required: true, message: 'Please input Description', trigger: 'blur'}
                ],
                quantity: [
                    {required: true, message: 'Please input Quantity', trigger: 'blur'}
                ],
                unit: [
                    {required: true, message: 'Please input Unit', trigger: 'blur'}
                ],
                unit_price: [
                    {required: true, message: 'Please input Unit Price', trigger: 'blur'}
                ],
                amount: [
                    {required: true, message: 'Please input Amount', trigger: 'blur'}
                ],
            }
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.form = {
                item: this.model.item,
                description: this.model.description,
                quantity: this.model.quantity,
                unit: this.model.unit,
                unit_price: this.model.unit_price,
                amount: this.model.amount,
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateOrderItem();
                    return
                }
                this.storeOrderItem();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async storeOrderItem(){
            try {
                let formData = new FormData();
                if(this.form.item)formData.append('item', this.form.item);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.unit)formData.append('unit', this.form.unit);
                if(this.form.quantity)formData.append('quantity', this.form.quantity);
                if(this.form.unit_price)formData.append('unit_price', this.form.unit_price);
                if(this.form.amount)formData.append('amount', this.form.amount);

                const res = await this.$API.PurchaseOrder.storeOrderItem(this.id, formData);

                this.$EventDispatcher.fire('NEW_ORDER_ITEM', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.resetForm('form');
            } catch (error) {
                console.log(error);
            }
        },
        async updateOrderItem(){
            try {
                let formData = new FormData();
                if(this.form.item)formData.append('item', this.form.item);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.unit)formData.append('unit', this.form.unit);
                if(this.form.quantity)formData.append('quantity', this.form.quantity);
                if(this.form.unit_price)formData.append('unit_price', this.form.unit_price);
                if(this.form.amount)formData.append('amount', this.form.amount);

                const res = await this.$API.PurchaseOrder.updateOrderItem(this.model.id, formData);

                this.$EventDispatcher.fire('UPDATE_ORDER_ITEM', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.resetForm('form');
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
                    description: newVal.description,
                    quantity: newVal.quantity,
                    unit: newVal.unit,
                    unit_price: newVal.unit_price,
                    amount: newVal.amount,
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    item: '',
                    description: '',
                    quantity: '',
                    unit: '',
                    unit_price: '',
                    amount: '',
                }
            }
        }
    }
}
</script>
