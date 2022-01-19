<template>
    <div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!-- begin::Card-->
                <div class="card card-custom overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row bg-gray-100" style="padding: 10px">
                            <div class="col-md-3">
                                <div class="mb-5 justify-content-center " v-loading="loading">
                                    <img v-if="equipmentInfo.photo" :src="`/storage/heavy_equipments/photo/${equipmentInfo.photo}`" class="img_size">
                                    <img v-else  :src="`/img/default.png`" class="img_size">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <el-card class="box-card" style="height:100%">
                                    <div slot="header" class="clearfix">
                                        <span class="equipment_info">{{ equipmentInfo.brand_name }}</span>
                                        <el-button style="float: right" size="mini" @click="edit" type="success">Edit</el-button>
                                    </div>
                                    <div class="text item">
                                        <el-descriptions title="Equipment Information" :column="2">
                                            <el-descriptions-item label="CONTROL NUMBER">{{ equipmentInfo.control_number}}</el-descriptions-item>
                                            <el-descriptions-item label="MODEL">{{ equipmentInfo.model}}</el-descriptions-item>
                                            <el-descriptions-item label="ENGINE NUMBER">{{ equipmentInfo.engine_number}}</el-descriptions-item>
                                            <el-descriptions-item label="ENGINE MODEL"> {{ equipmentInfo.engine_model}}</el-descriptions-item>
                                            <el-descriptions-item label="CAPACITY">{{ equipmentInfo.capacity}}</el-descriptions-item>
                                            <el-descriptions-item label="COST">{{ equipmentInfo.cost}}</el-descriptions-item>
                                            <el-descriptions-item label="SERIAL NUMBER">{{ equipmentInfo.serial_number}}</el-descriptions-item>
                                            <el-descriptions-item label="REFERENCE NO">{{ equipmentInfo.reference_number}}</el-descriptions-item>
                                            <el-descriptions-item label="DESCRIPTION">{{ equipmentInfo.description}}</el-descriptions-item>
                                            <el-descriptions-item label="DATE ACQUIRED">{{ equipmentInfo.date_acquired}}</el-descriptions-item>
                                            <el-descriptions-item label="ASSIGNED TO">{{ equipmentInfo.assigned_to}}</el-descriptions-item>
                                            <el-descriptions-item label="STATUS">{{ equipmentInfo.status}}</el-descriptions-item>
                                            <el-descriptions-item label="Location">{{ equipmentInfo.fixed_assets | location}}</el-descriptions-item>
                                            <el-descriptions-item label="Return"  v-if="isReturnWarehouse">
                                                <el-button type="info" width="200" v-if="isReturnWarehouse" @click="returnWarehouse" size="mini">Return to Warehouse</el-button>
                                            </el-descriptions-item>
                                        </el-descriptions>
                                    </div>
                                </el-card>
                            </div>
                        </div>
                        <div class="justify-content-center bg-gray-100" style="padding:10px">
                            <el-tabs v-model="activeName">
                                <el-tab-pane label="Location History" name="first">
                                    <heavy-equipment-location-history :id="id"></heavy-equipment-location-history>
                                </el-tab-pane>
                                <el-tab-pane label="Equipment Documents" name="second" lazy>
                                    <heavy-equipment-document-list :id="id"></heavy-equipment-document-list>
                                </el-tab-pane>
                                <el-tab-pane label="Job Order" name="third" lazy>
                                    <heavy-equipment-job-order :id="id"></heavy-equipment-job-order>
                                </el-tab-pane>
                                <el-tab-pane label="Maintenance History" name="fourth" lazy>
                                    <heavy-equipment-maintenance :id="id"></heavy-equipment-maintenance>
                                </el-tab-pane>
                            </el-tabs>
                        </div>
                        <!-- end: Invoice footer-->
                        <!-- begin: Invoice action-->

                        <!-- end: Invoice action-->
                        <!-- end: Invoice-->
                    </div>
                </div>
                <!-- end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <el-dialog title="Update Equipment" :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <add-form :pageData="pageData" :equipmentInfo="equipmentInfo" :mode="mode"></add-form>
        </el-dialog>
        <el-dialog title="Return to Warehouse" width="35%" :visible.sync="dialogTableVisibleReturn">
            <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
                <el-form-item label="Date Returned" prop="date_returned">
                    <el-date-picker type="date" placeholder="Pick a Date" v-model="form.date_returned" style="width: 100%;"></el-date-picker>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" :disabled="disabledButton" @click="submitForm('form')">Save</el-button>
                    <el-button :disabled="disabledButton" @click="resetForm('form')">Reset</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'HeavyEquipmentDetails',
    props: {
        id: null,
        data: {},
        pageData: {}
    },
    data() {
        return {
            loading: false,
            equipmentInfo: {},
            activeName: 'first',
            dialogFormVisible: false,
            mode: '',
            editedData : {},
            dialogTableVisibleReturn: false,
            form: {
                date_returned: ''
            },
            rules: {
                date_returned: [
                    {required: true, message: 'Please input Date Returned', trigger: 'blur'}
                ],
            },
            disabledButton: false,
        }
    },
    created() {
        if(!this.data) {
            this.loading = true;
            this.getEquipmentInfo();
        }
        else {
            this.equipmentInfo = this.data;
        }



        this.$EventDispatcher.listen('UPDATED_HEAVY_EQUIPMENT', data => {
			this.equipmentInfo = data
            this.dialogFormVisible = false;
            this.editedData = data;
		})
    },
    computed: {
        isReturnWarehouse() {
            if(!this.equipmentInfo.fixed_assets.location.length <= 0) {
                if(this.equipmentInfo.fixed_assets.location[0].project_name != 'Warehouse') {
                    return true
                }

                return false
            }

            return false
        }
    },
    filters: {
        notSetFilter(value) {
            if(value) {
                return value
            }

            return 'Not Set'
        },
        location(value) {
            if(value.location.length <= 0) {
                return 'Warehouse'
            }
            return value.location[0].project_name
        }
    },
    methods: {
        async getEquipmentInfo() {
            try {
                const res = await this.$API.HeavyEquipment.getEquipmentInfo(this.id);
                this.equipmentInfo = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        edit() {
            this.dialogFormVisible = !this.dialogFormVisible
            this.mode = 'update'
            this.equipmentInfo = this.editedData.length > 0 ? this.editedData : this.equipmentInfo
        },
        handleClose(done) {
            this.mode = 'create'
            this.$EventDispatcher.fire('handleCloseUpdateHE', this.equipmentInfo)
            this.model = {}
            done();
        },
        async returnWarehouse() {
            this.dialogTableVisibleReturn = !this.dialogTableVisibleReturn

        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                this.storeReturned();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        async storeReturned() {
            try {
                this.disabledButton = true;
                let data = {
                    fixed_asset_id: this.equipmentInfo.fixed_assets.id,
                    project_name: 'Warehouse',
                    location: 'Warehouse',
                    status: 'Returned from '+this.equipmentInfo.fixed_assets.location[0].project_name,
                    date: this.$df.formatDate(this.form.date_returned, "YYYY-MM-DD")
                }

                const res = await this.$API.HeavyEquipment.returnToWarehouse(data);
                this.equipmentInfo.fixed_assets.location[0].project_name = 'Warehouse'
                this.$EventDispatcher.fire('RETURN_WAREHOUSE', res.data)
                this.resetForm('form')
                this.dialogTableVisibleReturn = false
                this.disabledButton = false
            } catch (error) {
                console.log(error);
                this.disabledButton = false
            }
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        }
    }
}
</script>
<style>
    .wrapper_heavy_equipment {
        margin: 10px;
    }
    .equipment_info {
        font-weight: 600;
        font-size: 20px;
    }
</style>
