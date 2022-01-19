<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Project" prop="project_id">
                <el-select
                    v-model="form.project_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    @change="changeProjectID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteProjectMethod"
                    :loading="loadingProjects">
                    <el-option
                    v-for="item in projects"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Item Code" prop="item_code">
                <el-input v-model="form.item_code" placeholder="Item Code..."></el-input>
            </el-form-item>
            <el-form-item label="Item Name" prop="item_name">
                <el-input v-model="form.item_name" placeholder="Item Name..."></el-input>
            </el-form-item>
            <el-form-item label="Bar Code" prop="bar_code">
                <el-input v-model="form.bar_code" placeholder="Bar Code..."></el-input>
            </el-form-item>
            <el-form-item label="Lot Number" prop="lot_number">
                <el-input v-model="form.lot_number" placeholder="Lot Number..."></el-input>
            </el-form-item>
            <el-form-item label="Description" prop="description">
                <el-input type="textarea" v-model="form.description" placeholder="Description..."></el-input>
            </el-form-item>
            <el-form-item label="Unit of Measure" prop="unit_of_measure">
                <el-input v-model="form.unit_of_measure" placeholder="Unit of Measure..."></el-input>
            </el-form-item>
            <el-form-item label="Stock on Hand" prop="stock_on_hand">
                <el-input type="number" min="0" v-model="form.stock_on_hand" placeholder="Stock on Hand..."></el-input>
            </el-form-item>
            <el-form-item label="Reorder Point" prop="reorder_point">
                <el-input type="number" min="0" v-model="form.reorder_point" placeholder="Reorder Point..."></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                <el-button @click="resetForm('form')" :disabled="disableButton" v-if="mode != 'update'">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'ConsumableSupplyForm',
    props: {
        mode: '',
        model: {}
    },
    data() {
        return {
            form: {
                project_id: '',
                item_code: '',
                item_name: '',
                bar_code: '',
                lot_number: '',
                description: '',
                unit_of_measure: '',
                quantity: '',
                stock_on_hand: '',
                reorder_point: '',
            },
            rules:{
                project_id: [
                    {required: true, message: 'Please select Project', trigger: 'blur'}
                ],
                item_code: [
                    {required: true, message: 'Please input Item Code', trigger: 'blur'}
                ],
                item_name: [
                    {required: true, message: 'Please input Item Name', trigger: 'blur'}
                ],
                bar_code: [
                    {required: true, message: 'Please input Bar Code', trigger: 'blur'}
                ],
                lot_number: [
                    {required: true, message: 'Please input Lot Number', trigger: 'blur'}
                ],
                description: [
                    {required: true, message: 'Please input Description', trigger: 'blur'}
                ],
                unit_of_measure: [
                    {required: true, message: 'Please input Unit of Measure', trigger: 'blur'}
                ],
                quantity: [
                    {required: true, message: 'Please input Quantity', trigger: 'blur'}
                ],
                stock_on_hand: [
                    {required: true, message: 'Please input Stock on Hand', trigger: 'blur'}
                ],
                reorder_point: [
                    {required: true, message: 'Please input Reorder Point', trigger: 'blur'}
                ],
            },
            loadingProjects: false,
            projects: [],
            disableButton: false,
        }
    },
    created() {
        if(this.model && this.model.id && this.mode == 'update') {
            this.form = {
                project_id: this.model.project.name,
                project_id_id: this.model.project_id,
                item_code : this.model.item_code,
                item_name : this.model.item_name,
                bar_code : this.model.bar_code,
                lot_number : this.model.lot_number,
                description : this.model.description,
                unit_of_measure : this.model.unit_of_measure,
                quantity : this.model.quantity,
                stock_on_hand : this.model.stock_on_hand,
                reorder_point : this.model.reorder_point,
            }
        }
        this.$EventDispatcher.listen('handleCLoseConsumbleSupply', data => {
            this.resetForm('form')
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateSupply();
                    return
                }
                this.storeSupply();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async remoteProjectMethod(query) {
            if (query !== '') {
                this.loadingProjects = true;
                try {
                    const res = await this.$API.Project.getPorjectsData(query);
                    this.projects = res.data
                    this.loadingProjects = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.projects = [];
            }
        },
        changeProjectID(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.project_id_id = null
                return value;
            }
        },
        async storeSupply() {
            this.disableButton = true
            try {
                let formData = new FormData();
                if(this.form.project_id)formData.append('project_id', this.form.project_id);
                if(this.form.item_code)formData.append('item_code', this.form.item_code);
                if(this.form.item_name)formData.append('item_name', this.form.item_name);
                if(this.form.bar_code)formData.append('bar_code', this.form.bar_code);
                if(this.form.lot_number)formData.append('lot_number', this.form.lot_number);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.unit_of_measure)formData.append('unit_of_measure', this.form.unit_of_measure);
                if(this.form.quantity)formData.append('quantity', this.form.quantity);
                if(this.form.stock_on_hand)formData.append('stock_on_hand', this.form.stock_on_hand);
                if(this.form.reorder_point)formData.append('reorder_point', this.form.reorder_point);

                const res = await this.$API.Consumable.storeSupply(formData);

                this.$EventDispatcher.fire('NEW_CONSUMABLE_SUPPLY', res.data);
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
        async updateSupply() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.form.project_id_id)formData.append('project_id_id', this.form.project_id_id);
                if(this.form.project_id)formData.append('project_id', this.form.project_id);
                if(this.form.item_code)formData.append('item_code', this.form.item_code);
                if(this.form.item_name)formData.append('item_name', this.form.item_name);
                if(this.form.bar_code)formData.append('bar_code', this.form.bar_code);
                if(this.form.lot_number)formData.append('lot_number', this.form.lot_number);
                if(this.form.description)formData.append('description', this.form.description);
                if(this.form.unit_of_measure)formData.append('unit_of_measure', this.form.unit_of_measure);
                if(this.form.quantity)formData.append('quantity', this.form.quantity);
                if(this.form.stock_on_hand)formData.append('stock_on_hand', this.form.stock_on_hand);
                if(this.form.reorder_point)formData.append('reorder_point', this.form.reorder_point);

                const res = await this.$API.Consumable.updateSupply(this.model.id, formData);

                this.$EventDispatcher.fire('UPDATE_CONSUMABLE_SUPPLY', res.data);
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
                    project_id : newVal.project.name,
                    project_id_id : newVal.project_id,
                    item_code : newVal.item_code,
                    item_name : newVal.item_name,
                    bar_code : newVal.bar_code,
                    lot_number : newVal.lot_number,
                    description : newVal.description,
                    unit_of_measure : newVal.unit_of_measure,
                    quantity : newVal.quantity,
                    stock_on_hand : newVal.stock_on_hand,
                    reorder_point : newVal.reorder_point,
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    project_id : '',
                    project_id_id : '',
                    item_code : '',
                    item_name : '',
                    bar_code : '',
                    lot_number : '',
                    description : '',
                    unit_of_measure : '',
                    quantity : '',
                    stock_on_hand : '',
                    reorder_point : '',
                }
            }
        }
    }
}
</script>
