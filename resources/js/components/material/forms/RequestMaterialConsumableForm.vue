<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Consumable Supply" prop="c_s_id">
                <el-select
                    v-model="form.c_s_id"
                    style="width: 100%"
                    filterable
                    :allow-create="mode !== 'update'"
                    remote
                    reserve-keyword
                    @change="changeConsumableSupply"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethod"
                    :loading="loading">
                    <el-option
                    v-for="item in consumables"
                    :key="item.id"
                    :label="item.item_name"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Unit" prop="unit">
                <el-input v-model="form.unit" :disabled="disableUnit || mode == 'update'" placeholder="Unit of Measure..."></el-input>
            </el-form-item>
            <el-form-item label="Date Requested" prop="date_requested">
                <el-date-picker disabled type="date" placeholder="Pick a Starting Date" v-model="form.date_requested" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item label="Quantity" prop="quantity">
                <el-input type="number" v-model="form.quantity" placeholder="Quantity..."></el-input>
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
    name: 'RequestMaterialConsumableForm',
    props: {
        mode: null,
        model: {},
        id: null,
        dateRequested: null,
        projectID: null
    },
    data() {
        return {
            consumables: [],
            loading: false,
            form : {
                c_s_id: '',
                date_requested: '',
                material_request: '',
                quantity: '',
                unit: ''
            },
            rules: {
                c_s_id: [
                    {required: true, message: 'Please select Consumable Supply', trigger: 'blur'}
                ],
                date_requested: [
                    {required: true, message: 'Please input Date Requested', trigger: 'blur'}
                ],
                material_request: [
                    {required: true, message: 'Please input Material Request', trigger: 'blur'}
                ],
                quantity: [
                    {required: true, message: 'Please input Quantity', trigger: 'blur'}
                ],
                unit: [
                    {required: true, message: 'Please input Unit of Measure', trigger: 'blur'}
                ],
            },
            disableButton: false,
            disableUnit: false,
        }
    },
    created() {
        this.form.date_requested = this.dateRequested
        if(this.model && this.model.id && this.mode == 'update') {
            this.form = {
                c_s_id: this.model.consumable_supply.item_name,
                c_s_id_value: this.model.c_s_id,
                date_requested : this.dateRequested,
                material_request: this.model.material_request,
                quantity: this.model.quantity,
                unit: this.model.consumable_supply.unit_of_measure,
            }
        }

        this.$EventDispatcher.listen('handleCloseRMC', data => {
            this.resetForm('form')
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateRequestMaterialConsumableSupply();
                    return
                }
                this.storeRequestMaterialConsumableSupply();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async storeRequestMaterialConsumableSupply() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.form.c_s_id)formData.append('c_s_id', this.form.c_s_id);
                if(this.form.date_requested)formData.append('date_requested', this.form.date_requested);
                if(this.form.material_request)formData.append('material_request', this.form.material_request);
                if(this.form.quantity)formData.append('quantity', this.form.quantity);

                const res = await this.$API.RequestMaterial.storeRequestConsumable(this.id, formData);
                this.$EventDispatcher.fire('NEW_REQUEST_MATERIAL_CONSUMABLE', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.form.quantity = ''
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async updateRequestMaterialConsumableSupply() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.form.c_s_id)formData.append('c_s_id', this.form.c_s_id);
                if(this.form.c_s_id_value)formData.append('c_s_id_value', this.form.c_s_id_value);
                if(this.form.date_requested)formData.append('date_requested', this.form.date_requested);
                if(this.form.material_request)formData.append('material_request', this.form.material_request);
                if(this.form.quantity)formData.append('quantity', this.form.quantity);

                const res = await this.$API.RequestMaterial.updateRequestConsumable(this.model.id, formData);
                console.log(res.data);
                this.$EventDispatcher.fire('UPDATE_REQUEST_MATERIAL_CONSUMABLE', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async remoteMethod(query) {
            if (query !== '') {
                this.loading = true;
                try {
                    const res = await this.$API.RequestMaterial.getConsumableSupply(this.projectID, query);
                    this.consumables = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.consumables = [];
            }
        },
        changeConsumableSupply(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.c_s_id_value = null
                let consumables = this.consumables.filter(consumable => consumable.id == value);
                if(consumables) {
                    this.form.unit = consumables[0].unit_of_measure;
                }
                return value;
            }

            if(typeof (value) != 'string') {
                let consumables = this.consumables.filter(consumable => consumable.id == value);
                if(consumables) {
                    this.disableUnit = true;
                    this.form.unit = consumables[0].unit_of_measure;
                }
                else {
                    this.disableUnit = false;
                }
            }
            else {
                this.disableUnit = false;
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    c_s_id: newVal.consumable_supply.item_name,
                    c_s_id_value: newVal.c_s_id,
                    date_requested : this.dateRequested,
                    material_request: newVal.material_request,
                    quantity: newVal.quantity,
                    unit: newVal.consumable_supply.unit_of_measure,
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    c_s_id: '',
                    c_s_id_value: '',
                    material_request: '',
                    date_requested: this.dateRequested,
                    quantity: '',
                    unit: ''
                }
            }
        }
    }
}
</script>
