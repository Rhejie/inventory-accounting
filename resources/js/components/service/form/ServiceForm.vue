<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Name" prop="name">
                <el-input v-model="form.name"></el-input>
            </el-form-item>
            <el-form-item label="Service Fee" prop="service_fee">
                <el-input type="number" v-model="form.service_fee"></el-input>
            </el-form-item>
            <el-form-item label="Description" prop="description">
                <el-input type="textarea" v-model="form.description"></el-input>
            </el-form-item>
            <el-form-item label="Tax" prop="tax_id">
                <el-select
                    v-model="form.tax_id"
                    style="width: 100%"
                    filterable
                    remote
                    clearable
                    reserve-keyword
                    @change="changeTaxID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteTaxMethod"
                    :loading="loadingTaxes">
                    <el-option
                    v-for="item in taxes"
                    :key="item.id"
                    :label="`${item.name} - ${item.rate}%`"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Unit" prop="unit_id">
                <el-select
                    v-model="form.unit_id"
                    style="width: 100%"
                    filterable
                    clearable
                    remote
                    reserve-keyword
                    @change="changeUnitID"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteUnitMethod"
                    :loading="loadingUnits">
                    <el-option
                    v-for="item in units"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <div class="row">
                <div class="col-md-12">
                    <el-form-item style="float:right">
                        <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                        <el-button :disabled="disableButton" v-if="mode != 'update'" @click="resetForm('form')">Reset</el-button>
                    </el-form-item>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
    export default {
        name: 'ServiceForm',
        props: {
            mode: null,
            model: {}
        },
        data() {
            return {
                form: {
                    name: null,
                    description: null,
                    service_fee: null,
                    tax_id: null,
                    category_id: null,
                    unit_id: null,
                    type: 'Service',
                },
                rules: {
                    name: [
                        {required: true, message: 'Please input Name', trigger: 'blur'}
                    ],
                    description: [
                        {required: true, message: 'Please input Description', trigger: 'blur'}
                    ],
                    service_fee: [
                        {required: true, message: 'Please input Service Fee', trigger: 'blur'}
                    ],
                    // tax_id: [
                    //     {required: true, message: 'Please select Tax', trigger: 'blur'}
                    // ],
                    // unit_id: [
                    //     {required: true, message: 'Please select Unit', trigger: 'blur'}
                    // ]
                },
                disableButton: false,
                taxes: [],
                loadingTaxes: false,
                loadingUnits: false,
                units: []
            }
        },
        created() {
            if(this.model && this.model.id) {
                let tax_id = ''
                let tax_id_id = ''
                let unit_id = ''
                let unit_id_id = ''
                if(this.model.tax) {
                    tax_id = `${this.model.tax.name} - ${this.model.tax.rate}%`
                    tax_id_id = this.model.tax.id
                }

                if(this.model.unit) {
                    unit_id = this.model.unit.name
                    unit_id_id = this.model.unit.id
                }
                this.form = {
                    name: this.model.name,
                    description: this.model.description,
                    service_fee: this.model.service_fee,
                    tax_id: tax_id,
                    tax_id_id: tax_id_id,
                    category_id: null,
                    unit_id_id: unit_id_id,
                    unit_id: unit_id,
                    type: 'Service',
                }
            }

            this.$EventDispatcher.listen('CLOSE_SERVICE', data => {
                this.resetForm('form')
            })
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                if (valid) {
                    if(this.mode == 'update') {
                        this.updateService();
                        return
                    }
                    this.storeService();
                } else {
                    console.log('error submit!!');
                    return false;
                }
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            async storeService() {
                try {
                    this.disableButton = true
                    const res = await this.$API.Service.storeService(this.form);
                    this.$EventDispatcher.fire('ADD_NEW_SERVICE', res.data);
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Added',
                        type: 'success'
                    });
                    this.resetForm('form');
                    this.disableButton = false;
                } catch (error) {
                    console.log(error)
                }
            },
            async updateService() {
                try {
                    this.disableButton = true;
                    const res = await this.$API.Service.updateService(this.model.id, this.form)
                    this.$EventDispatcher.fire('UPDATE_SERVICE', res.data)
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Added',
                        type: 'success'
                    });
                    this.disableButton = false;
                } catch (error) {
                    console.log(error)
                }
            },
            async remoteTaxMethod(query) {
                if (query !== '') {
                    this.loadingTaxes = true;
                    try {
                        const res = await this.$API.Constant.searchTax(query);
                        this.taxes = res.data
                        this.loadingTaxes = false
                    } catch (error) {
                        console.log(error);
                    }
                } else {
                    this.taxes = [];
                }
            },
            async remoteUnitMethod(query) {
                if (query !== '') {
                    this.loadingUnits = true;
                    try {
                        const res = await this.$API.Constant.searchUnit(query);
                        this.units = res.data
                        this.loadingUnits = false
                    } catch (error) {
                        console.log(error);
                    }
                } else {
                    this.units = [];
                }
            },
            changeTaxID(value) {
                if(this.model && this.model.id && this.mode == 'update') {
                    this.form.tax_id_id = null
                    return value;
                }
            },
            changeUnitID(value) {
                if(this.model && this.model.id && this.mode == 'update') {
                    this.form.unit_id_id = null
                    return value;
                }
            },
        },
        watch: {
            mode(val) {
                if(val) {
                    if(val == 'create') {
                        this.form = {
                            name: null,
                            description: null,
                            service_fee: null,
                            tax_id: null,
                            category_id: null,
                            unit_id: null,
                            type: 'Service',
                        }
                    }
                }
            },
            model(newVal, oldVal) {
                if(newVal != oldVal && this.mode == 'update') {
                    let tax_id = null;
                    let tax_id_id = null
                    let unit_id = null;
                    let unit_id_id = null
                    if(newVal.tax && newVal.tax.id) {
                        tax_id =  `${newVal.tax.name} - ${newVal.tax.rate}%`
                        tax_id_id = newVal.tax.id
                    }
                    if(newVal.unit && newVal.unit.id) {
                        unit_id =  `${newVal.unit.name} - ${newVal.unit.rate}%`
                        unit_id_id = newVal.unit.id
                    }
                    this.form = {
                        name: newVal.name,
                        description: newVal.description,
                        service_fee: newVal.service_fee,
                        type: 'Service',
                        tax_id: tax_id,
                        tax_id_id: tax_id_id,
                        category_id: null,
                        unit_id: unit_id,
                        unit_id_id: unit_id_id,
                    }
                }
            }
        }
    }
</script>
