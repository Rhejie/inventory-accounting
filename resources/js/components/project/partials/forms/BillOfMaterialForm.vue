<template>
    <div class="billOfMaterialForm">
        <el-form :inline="true" :model="form" ref="form" :rules="rules" class="demo-form-inline">
            <el-form-item label="Item" prop="bill_of_material_item_id">
                <el-select v-model="form.bill_of_material_item_id" placeholder="Activity zone" v-loading="loadingItem">
                    <el-option v-for="item in items" :key="item.id" :label="`${item.name} - ${item.description}`" :value="item.id"></el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Description" prop="bill_of_material_description_id">
                <!-- <el-select v-model="form.bill_of_material_description_id" placeholder="Description">
                    <el-option label="Zone one" value="shanghai"></el-option>
                    <el-option label="Zone two" value="beijing"></el-option>
                </el-select> -->
                <el-select
                    v-model="form.bill_of_material_description_id"
                    filterable
                    remote
                    reserve-keyword
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethod"
                    :loading="loading">
                        <el-option
                            v-for="item in descriptions"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                        </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Unit" prop="unit">
                <el-input v-model="form.unit" placeholder="Unit"></el-input>
            </el-form-item>
            <el-form-item label="Quantity" prop="quantity">
                <el-input v-model="form.quantity" placeholder="Quantity"></el-input>
            </el-form-item>
            <el-form-item label="Unit Cost" prop="unit_cost">
                <el-input v-model="form.unit_cost" placeholder="Unit Cost"></el-input>
            </el-form-item>
            <el-form-item label="Amount" prop="amount">
                <el-input v-model="amountValue" disabled placeholder="Amount"></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="submitForm('form')">Save</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'BillOfMaterialForm',
    props : {
        id: null
    },
    data() {
        return {
            form: {
                bill_of_material_item_id : '',
                bill_of_material_description_id : '',
                unit : '',
                unit_cost : '',
                quantity : '',
                amount : '',
                project_id : this.id,
            },
            rules: {
                bill_of_material_item_id: [
                    { required: true, message: 'Please select Item', trigger: 'blur' }
                ],
                bill_of_material_description_id: [
                    { required: true, message: 'Please select Description', trigger: 'blur' }
                ],
                unit: [
                    { required: true, message: 'Please input Unit', trigger: 'blur' }
                ],
                unit_cost: [
                    { required: true, message: 'Please input Unit Cost', trigger: 'blur' }
                ],
                quantity: [
                    { required: true, message: 'Please input Quantity', trigger: 'blur' }
                ],
            },
            items: [],
            descriptions: [],
            loadingItem: false,
            loading: false,
        }
    },
    created() {
        this.getItems();
    },
    computed: {
        amountValue() {
            let value = this.form.quantity * this.form.unit_cost
            return value
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.store();
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async store() {
            try {
                this.form.amount = this.amountValue
                const res = await this.$API.Project.storeMaterials(this.form);
                this.resetForm('form')
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.$EventDispatcher.fire('ADD_NEW_MATERIAL', res.data);
            }
            catch(error) {
                console.log(error)
            }
        },
        async getItems() {
            try {
                this.loadingItem = true
                const res = await this.$API.Project.getBillOfMaterialItems();
                this.items = res.data
                this.loadingItem = false
            } catch (error) {
                console.log(error)
            }
        },
        async remoteMethod(query) {
            if (query !== '') {
                this.loading = true;
                try {
                    const res = await this.$API.Project.getDescriptions(query);
                    this.descriptions = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.descriptions = [];
            }
        }
    },
}
</script>
<style>
    .billOfMaterialForm {
        padding: 10px
    }
</style>
