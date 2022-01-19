<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Request Material No." prop="request_material_code">
                <el-select
                    v-model="form.request_material_code"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    @change="rmChange"
                    :disabled="mode == 'update'"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethodRMList"
                    :loading="loadingProject">
                        <el-option
                            v-for="item in rmList"
                            :key="item.id"
                            :label="`${item.request_material_code} - ${item.status}`"
                            :disabled="item.isComplete"
                            :value="item.id">
                        </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Project" prop="request_form_from_project_id">
                <el-select
                    v-model="form.request_form_from_project_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    :disabled="true"
                    @change="projectChange"
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
            <el-form-item label="Fixed Asset" prop="request_materials_form_fixed_asset_items_id">
                <el-select
                    v-model="form.request_materials_form_fixed_asset_items_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    :disabled="!form.request_material_code || mode == 'update'"
                    @change="changeAsset"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethod"
                    :loading="loading">
                    <el-option
                    v-for="item in fixedAssets"
                    :key="item.id"
                    :label="`${item.fixed_asset.assetable.brand_name}`"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Date Delivered" prop="date_delivered">
                <el-date-picker type="date" placeholder="Pick a Starting Date" v-model="form.date_delivered"></el-date-picker>
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
    name: 'FixedAssetStockOutForm',
    props: {
        mode: null,
        model: {},
    },
    data() {
        return {
            loading: false,
            fixedAssets: [],
            rmList: [],
            form : {
                date_delivered: null,
                remarks: null,
                request_materials_form_fixed_asset_items_id: null,
                date_requested: null,
                request_form_from_project_id: null,
                request_material_code: ''
            },
            rules: {
                request_materials_form_fixed_asset_items_id: [
                    {required: true, message: 'Please select Fixed Asset', trigger: 'blur'}
                ],
                request_material_code: [
                    {required: true, message: 'Please select Material Code', trigger: 'blur'}
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
            projectsList: []
        }
    },
    created() {
        if(this.model && this.model.id && this.mode == 'update') {
            this.form = {
                date_delivered: this.model.date_delivered,
                remarks: this.model.remarks,
                request_materials_form_fixed_asset_items_id: this.model.request_materials_fixed_asset.fixed_asset.assetable.brand_name,
                request_materials_form_fixed_asset_items_id_id: this.model.request_materials_fixed_asset.id,
                date_requested: this.model.request_materials_fixed_asset.date_requested,
                request_form_from_project_id: this.model.request_materials_fixed_asset.request_material.project.name,
                request_form_from_project_id_id : this.model.request_materials_fixed_asset.id,
                request_material_code: this.model.request_materials_fixed_asset.request_material.request_material_code,
                request_material_code_id : this.model.request_material_id
            }
        }

        this.$EventDispatcher.listen('CLOSE_FIXED_MULTIPLE_FORM', data => {
            this.resetForm('form')
        })
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
        async store() {
            this.disableButton = true;

            this.form.date_delivered = this.$df.formatDate(this.form.date_delivered, "YYYY-MM-DD")

            let asset = this.fixedAssets.filter(asset => asset.id == this.form.request_materials_form_fixed_asset_items_id);

            this.form.delivered_from = asset[0].request_material.project.name

            let request_material_id = this.rmList.filter(rm => rm.id == this.form.request_material_code);


            try {
                this.form.request_material_id = request_material_id[0].id
                const res = await this.$API.FixedAssetStockOut.store(this.form);

                this.$EventDispatcher.fire('ADD_NEW_ASSET_STOCK_OUT', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.rmList = []
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
                const res = await this.$API.FixedAssetStockOut.update(this.model.id, this.form);

                this.$EventDispatcher.fire('UPDATE_ASSET_STOCK_OUT', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.rmList = []
                this.resetForm('form');
                this.disableButton = false;
            } catch (error) {
                console.log(error);
                this.disableButton = false;
            }
        },
        async remoteMethod(query) {
            let requested_project = null ;
            let request_material_id = this.rmList.filter(rm => rm.id == this.form.request_material_code);
            if(this.form.request_material_code_id) {
                requested_project = this.form.request_material_code_id;
            }
            else {
                requested_project = request_material_id[0].id
            }

            if (query !== '') {
                this.loading = true;
                try {
                    const res = await this.$API.RequestMaterial.getRequestFixedAssetStockOut(requested_project, query);
                    this.fixedAssets = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.fixedAssets = [];
            }
        },
        async remoteMethodProject(query) {
            if (query !== '') {
                this.loadingProject = true;
                try {
                    const res = await this.$API.RequestMaterial.getRequestProject(query);
                    this.projectsList = res.data
                    this.loadingProject = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.projectsList = [];
            }
        },
        async remoteMethodRMList(query) {
            try {
                if (query !== '') {
                    this.loadingProject = true;
                    try {
                        const res = await this.$API.RequestMaterial.getRequestMaterialCodet(query);
                        let lists = res.data.map(code => {
                            let newArray = {}
                            let totalRequest = 0
                            let totalStockOut = 0
                            code.request_material_fixed_asset.forEach(rm => {
                                totalRequest += 1
                            })

                            code.request_material_stock_out.forEach(rm => {
                                totalStockOut += 1
                            })

                            if(totalRequest === totalStockOut && totalRequest != 0 && totalStockOut != 0) {
                                return newArray = {
                                    id : code.id,
                                    isComplete: true,
                                    project_id: code.project_id,
                                    project_name: code.project.name,
                                    status: 'Complete',
                                    request_material_code: code.request_material_code
                                }
                            }

                            return newArray = {
                                id : code.id,
                                isComplete: false,
                                project_id: code.project_id,
                                project_name: code.project.name,
                                status: 'Incomplete',
                                request_material_code: code.request_material_code
                            }

                        })
                        this.rmList = lists.filter(list => !list.isComplete)
                        this.loadingProject = false
                    } catch (error) {
                        console.log(error);
                    }
                } else {
                    this.rmList = [];
                }
            } catch (error) {
                console.log(error);
            }
        },
        changeAsset(value) {
            let asset = this.fixedAssets.filter(asset => asset.id == value);
            let status = asset[0].fixed_asset.assetable.status

            if(this.model && this.model.id && this.mode == 'update') {
                if(status != 'Active') {
                    this.$message.error(`This asset is ${status}.`);
                    return this.form.request_materials_form_fixed_asset_items_id = null
                }

                this.form.request_materials_form_fixed_asset_items_id_id = null
                return value
            }


            if(status != 'Active') {
                this.$message.error(`This asset is ${status}.`);
                return this.form.request_materials_form_fixed_asset_items_id = null
            }
            else {
                this.form.fixed_asset_id = asset[0].fixed_asset.id
                this.form.asset_id = asset[0].fixed_asset.assetable_id
            }
        },
        projectChange() {
            this.form.request_materials_form_fixed_asset_items_id = null
            this.fixedAssets = []
        },
        rmChange(value){
            this.form.request_materials_form_fixed_asset_items_id = null
            this.fixedAssets = []
            let project = this.rmList.filter(rm => rm.id == value)
            this.form.request_form_from_project_id = project[0].project_name
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(this.mode == 'update') {
                if(newVal != oldVal) {
                    this.form = {
                        date_delivered: newVal.date_delivered,
                        remarks: newVal.remarks,
                        request_materials_form_fixed_asset_items_id: newVal.request_materials_fixed_asset.fixed_asset.assetable.brand_name,
                        request_materials_form_fixed_asset_items_id_id: newVal.request_materials_fixed_asset.id,
                        date_requested: newVal.request_materials_fixed_asset.date_requested,
                        request_form_from_project_id: newVal.request_materials_fixed_asset.request_material.project.name,
                        request_form_from_project_id_id : newVal.request_materials_fixed_asset.id,
                        request_material_code: newVal.request_materials_fixed_asset.request_material.request_material_code,
                        request_material_code_id : newVal.request_material_id
                    }
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    date_delivered: null,
                    remarks: null,
                    request_materials_form_fixed_asset_items_id: null,
                    date_requested: null,
                    request_form_from_project_id: null,
                    request_material_code: ''
                }
            }
            else if(val == 'update') {
                this.form = {
                    date_delivered: this.model.date_delivered,
                    remarks: this.model.remarks,
                    request_materials_form_fixed_asset_items_id: this.model.request_materials_fixed_asset.fixed_asset.assetable.brand_name,
                    request_materials_form_fixed_asset_items_id_id: this.model.request_materials_fixed_asset.id,
                    date_requested: this.model.request_materials_fixed_asset.date_requested,
                    request_form_from_project_id: this.model.request_materials_fixed_asset.request_material.project.name,
                    request_form_from_project_id_id : this.model.request_materials_fixed_asset.id,
                    request_material_code: this.model.request_materials_fixed_asset.request_material.request_material_code,
                    request_material_code_id : this.model.request_material_id
                }
            }
        }
    }
}
</script>
