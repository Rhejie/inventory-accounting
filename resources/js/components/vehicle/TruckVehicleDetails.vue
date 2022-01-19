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
                                <div class="mb-5 justify-content-center" v-loading="loading">
                                    <img v-if="truckVehicleInfo.photo" :src="`/storage/truck_vehicle/photo/${truckVehicleInfo.photo}`" class="img_size">
                                            <img v-else  :src="`/img/default.png`" class="img_size">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <el-card class="box-card" style="height:100%">
                                    <div slot="header" class="clearfix">
                                        <span class="equipment_info">{{ truckVehicleInfo.brand_name }}</span>
                                        <el-button style="float: right" size="mini" @click="edit" type="success">Edit</el-button>
                                    </div>
                                    <div class="text item">
                                        <el-descriptions title="Truck / Vehicle Information" :column="2">
                                            <el-descriptions-item label="PLATE NUMBER">{{ truckVehicleInfo.plate_number}}</el-descriptions-item>
                                            <el-descriptions-item label="BODY TYPE">{{ truckVehicleInfo.body_type}}</el-descriptions-item>
                                            <el-descriptions-item label="DATE ACQUIRED">{{ truckVehicleInfo.date_acquired}}</el-descriptions-item>
                                            <el-descriptions-item label="COST">{{ truckVehicleInfo.cost}}</el-descriptions-item>
                                            <el-descriptions-item label="ASSIGNED TO">{{ truckVehicleInfo.assigned_to}}</el-descriptions-item>
                                            <el-descriptions-item label="STATUS">{{ truckVehicleInfo.status}}</el-descriptions-item>
                                            <el-descriptions-item label="Location">{{ truckVehicleInfo.fixed_assets | location}}</el-descriptions-item>
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
                                    <truck-vehicle-location-history :id="id"></truck-vehicle-location-history>
                                </el-tab-pane>
                                <el-tab-pane label="Equipment Documents" name="second" lazy>
                                    <truck-vehicle-document-list :id="id"></truck-vehicle-document-list>
                                </el-tab-pane>
                                <el-tab-pane label="Job Order" name="third" lazy>
                                    <truck-vehicle-job-order :id="id"></truck-vehicle-job-order>
                                </el-tab-pane>
                                <el-tab-pane label="Maintenance History" name="fourth" lazy>
                                    <truck-vehicle-maintenance :id="id"></truck-vehicle-maintenance>
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
        <!--end::Entry-->

        <el-dialog title="Update Truck / Vehicle" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <truck-vehicle-form :editData="editData" :mode="mode"></truck-vehicle-form>
        </el-dialog>
        <el-dialog title="Return to Warehouse1" width="35%" :visible.sync="dialogTableVisibleReturn">
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
    name: 'TruckVehicleDetails',
    props: {
        id: null,
        data: {}
    },
    data() {
        return {
            truckVehicleInfo: [],
            loading: false,
            activeName: 'first',
            editData: {},
            dialogFormVisible: false,
            mode: '',
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
            this.getTruckVehicleInfo();
        }
        else {
            this.truckVehicleInfo = this.data;
        }

        this.$EventDispatcher.listen('UPDATED_TRUCK_VEHICLE', updatedData => {
            this.truckVehicleInfo = updatedData
            this.dialogFormVisible = false
        });
    },
    computed: {
        isReturnWarehouse() {
            if(!this.truckVehicleInfo.fixed_assets.location.length <= 0) {
                if(this.truckVehicleInfo.fixed_assets.location[0].project_name != 'Warehouse') {
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
        async getTruckVehicleInfo() {
            try {
                const res = await this.$API.TruckVehicle.getInfo(this.id);
                this.truckVehicleInfo = res.data;
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        edit() {
            this.editData = {...this.truckVehicleInfo}
            this.dialogFormVisible = true
            this.mode = 'update'
        },
        handleClose(done) {
            this.mode = 'create'
            this.$EventDispatcher.fire('handleCloseUpdateTruck', this.truckVehicleInfo)
            this.editData = {}
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
                    fixed_asset_id: this.truckVehicleInfo.fixed_assets.id,
                    project_name: 'Warehouse',
                    location: 'Warehouse',
                    status: 'Returned from '+this.truckVehicleInfo.fixed_assets.location[0].project_name,
                    date: this.$df.formatDate(this.form.date_returned, "YYYY-MM-DD")
                }

                console.log(data);

                const res = await this.$API.HeavyEquipment.returnToWarehouse(data);
                this.truckVehicleInfo.fixed_assets.location[0].project_name = 'Warehouse'
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
<style lang="scss">
    .img_size {
        width: 100%;
    }
</style>
