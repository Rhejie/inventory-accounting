<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-row>
                <el-col :span="8">
                    <el-form-item label="Request Material No." prop="request_material_code">
                        <el-input :disabled="mode == 'update'" clearable placeholder="Pick a Date" v-model="form.request_material_code" style="width: 100%;"></el-input>
                    </el-form-item>
                </el-col>
                <el-col :span="1">&nbsp;</el-col>
                <el-col :span="13">
                    <el-form-item label="Project" prop="request_form_from_project_id">
                        <el-select
                            v-model="form.request_form_from_project_id"
                            style="width: 100%"
                            filterable
                            remote
                            :disabled="!form.date_requested || mode == 'update'"
                            reserve-keyword
                            placeholder="Please enter a keyword"
                            :remote-method="remoteMethodProject"
                            :loading="loadingProject">
                            <el-option
                            v-for="item in projectsList"
                            :key="item.id"
                            :label="`${item.project.name} - ${item.project.location}`"
                            :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="Consumable Supply" prop="request_materials_form_consumable_item_id">
                <el-select
                    v-model="form.request_materials_form_consumable_item_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    :disabled="true"
                    @change="changeSupply"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethod"
                    :loading="loading">
                    <el-option
                    v-for="item in consumableSupplies"
                    :key="item.id"
                    :label="`${item.consumable_supply.item_name}`"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Date Delivered" prop="date_delivered">
                <el-date-picker type="date" placeholder="Pick a Date" v-model="form.date_delivered" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item label="Requested Quantity">
                <el-input type="number" disabled v-model="form.requested_quantity" placeholder="Actual Quantity Delivered..."></el-input>
            </el-form-item>
            <el-form-item label="Actual Quantity Delivered" prop="actual_quantity_delivered">
                <el-input type="number" v-model="form.actual_quantity_delivered" @change="quantity" placeholder="Actual Quantity Delivered..."></el-input>
            </el-form-item>
            <el-form-item label="Remarks" prop="remarks">
                <el-input type="textarea" v-model="form.remarks" placeholder="Remarks..."></el-input>
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
    name: 'ConsumableItemStockOutForm',
    props : {
        mode: null,
        model : {},
        consumableItemStockOutData: []
    },
    data() {
        return {
            loading: false,
            consumableSupplies: [],
            form: {
                request_materials_form_consumable_item_id: '',
                actual_quantity_delivered: '',
                date_delivered: '',
                remarks: '',
                request_form_from_project_id: ''
            },
            rules: {
                request_materials_form_consumable_item_id: [
                    {required: true, message: 'Please select Fixed Asset', trigger: 'blur'}
                ],
                actual_quantity_delivered: [
                    {required: true, message: 'Please input Actual Quantity Delivered', trigger: 'blur'}
                ],
                date_delivered: [
                    {required: true, message: 'Please input Date Delivered', trigger: 'blur'}
                ],
                remarks: [
                    {required: true, message: 'Please input Remarks', trigger: 'blur'}
                ],
                date_requested: [
                    {required: true, message: 'Please input Date Delivered', trigger: 'blur'}
                ],
                request_form_from_project_id: [
                    {required: true, message: 'Please Select Project', trigger: 'blur'}
                ]
            },
            disableButton: false,
            loadingProject: false,
            projectsList: [],
            isStay: false
        }
    },
    created() {
        if(this.model && this.model.id && this.mode == 'update') {
            this.form = {
                request_materials_form_consumable_item_id: this.model.consumable_item.consumable_supply.item_name,
                request_materials_form_consumable_item_id_id: this.model.request_materials_form_consumable_item_id,
                actual_quantity_delivered: this.model.actual_quantity_delivered,
                date_delivered: this.model.date_delivered,
                remarks: this.model.remarks,
                request_form_from_project_id: this.model.consumable_item.request_material.project.name,
                request_form_from_project_id_id : this.model.consumable_item.request_material.id,
                date_requested: this.model.consumable_item.request_material.date_request,
                project_id: this.model.consumable_item.consumable_supply.project_id,
                requested_quantity: this.model.consumable_item.quantity,
                request_material_code: this.model.request_material.request_material_code,
            }
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.update();
                    return
                }
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
        quantity(value) {
            let previous = this.model.actual_quantity_delivered
            let stock_on_hand = this.model.consumable_item.consumable_supply.stock_on_hand
            let newQuantity = value
            let totalStock = 0;

            let totalStockOut = 0
            this.consumableItemStockOutData.forEach(stock => {
                if(stock.request_materials_form_consumable_item_id == this.form.request_materials_form_consumable_item_id_id) {
                    totalStockOut = totalStockOut + parseInt(stock.actual_quantity_delivered);
                }
            })


            if(previous < newQuantity) {
                totalStockOut = parseInt(totalStockOut) - parseInt(previous);
                totalStockOut = parseInt(totalStockOut) + parseInt(newQuantity)
                if(parseInt(totalStockOut) > parseInt(this.form.requested_quantity)) {
                    this.$message.error(`Requested Quantity does not match`);
                    this.form.actual_quantity_delivered = previous
                    return
                }
                totalStock = parseInt(previous) + parseInt(stock_on_hand);
                let def = totalStock - newQuantity;
                if(def < 0) {
                    this.$message.error('No more stock available.');
                    this.form.actual_quantity_delivered = previous
                    this.isStay = true
                    return;
                }
            }
            this.form.actual_quantity_delivered = value
            this.isStay = false

            return value;
        },
        async store() {
            this.disableButton = true;
            this.form.date_delivered = this.$df.formatDate(this.form.date_delivered, "YYYY-MM-DD")
            try {
                const res = await this.$API.ConsumableStockOut.store(this.form);

                this.$EventDispatcher.fire('ADD_NEW_CONSUMABLE_STOCK_OUT', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.resetForm('form');
                this.disableButton = false;
            } catch (error) {
                console.log(error);
                this.disableButton = false;
            }
        },
        async update() {
            this.disableButton = true;
            this.form.date_delivered = this.$df.formatDate(this.form.date_delivered, "YYYY-MM-DD")
            try {
                const res = await this.$API.ConsumableStockOut.update(this.model.id, this.form);
                let data = {
                    res: res.data,
                    isStay : this.isStay,
                }
                this.$EventDispatcher.fire('UPDATE_CONSUMABLE_STOCK_OUT', data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.resetForm('form');
                this.disableButton = false;
            } catch (error) {
                console.log(error);
                this.disableButton = false;
            }
        },
        async remoteMethodProject(query) {
            this.form.date_requested = this.$df.formatDate(this.form.date_requested, "YYYY-MM-DD")
            if (query !== '') {
                this.loadingProject = true;
                try {
                    const res = await this.$API.RequestMaterial.getRequestProject(this.form.date_requested, query);
                    this.projectsList = res.data
                    this.loadingProject = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.projectsList = [];
            }
        },

        async remoteMethod(query) {
            let requested_project = null ;
            if(this.form.request_form_from_project_id_id) {
                requested_project = this.form.request_form_from_project_id_id;
            }
            else {
                requested_project = this.form.request_form_from_project_id;
            }
            if (query !== '') {
                this.loading = true;
                try {
                    const res = await this.$API.RequestMaterial.getRequestConsumableStockOut(requested_project, query);
                    this.consumableSupplies = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.consumableSupplies = [];
            }
        },
        changeSupply(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.request_materials_form_consumable_item_id_id = null
                return value
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(this.mode == 'update') {
                if(newVal != oldVal) {
                    this.form = {
                        request_materials_form_consumable_item_id: newVal.consumable_item.consumable_supply.item_name,
                        request_materials_form_consumable_item_id_id: newVal.request_materials_form_consumable_item_id,
                        actual_quantity_delivered: newVal.actual_quantity_delivered,
                        date_delivered: newVal.date_delivered,
                        remarks: newVal.remarks,
                        request_form_from_project_id: newVal.consumable_item.request_material.project.name,
                        request_form_from_project_id_id : newVal.consumable_item.request_material.id,
                        date_requested: newVal.consumable_item.request_material.date_request,
                        project_id: newVal.consumable_item.consumable_supply.project_id,
                        requested_quantity: newVal.consumable_item.quantity,
                        request_material_code: newVal.request_material.request_material_code,
                    }
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    date_delivered: null,
                    remarks: null,
                    request_materials_form_consumable_item_id: null,
                    date_requested: null,
                    request_form_from_project_id: null,
                }
            }
            else if(val == 'update') {
                this.form = {
                    request_materials_form_consumable_item_id: this.model.consumable_item.consumable_supply.item_name,
                    request_materials_form_consumable_item_id_id: this.model.request_materials_form_consumable_item_id,
                    actual_quantity_delivered: this.model.actual_quantity_delivered,
                    date_delivered: this.model.date_delivered,
                    remarks: this.model.remarks,
                    request_form_from_project_id: this.model.consumable_item.request_material.project.name,
                    request_form_from_project_id_id : this.model.consumable_item.request_material.id,
                    date_requested: this.model.consumable_item.request_material.date_request,
                    project_id: this.model.consumable_item.consumable_supply.project_id,
                    requested_quantity: this.model.consumable_item.quantity,
                    request_material_code: this.model.request_material.request_material_code,
                }
            }
        }
    }
}
</script>
