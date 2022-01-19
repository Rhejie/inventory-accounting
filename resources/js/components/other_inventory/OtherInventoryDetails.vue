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
                                    <img v-if="otherInventoryInfo.photo" :src="`/storage/other_inventory/photo/${otherInventoryInfo.photo}`" class="img_size">
                                    <img v-if="!otherInventoryInfo.photo"  :src="`/img/default.png`" class="img_size">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <el-card class="box-card" shadow="never" style="height:100%">
                                    <div slot="header" class="clearfix">
                                        <span class="equipment_info">{{ otherInventoryInfo.brand_name }}</span>
                                        <el-button style="float: right" size="mini" @click="edit" type="success">Edit</el-button>
                                    </div>
                                    <div class="text item">
                                        <el-descriptions title="Other Fixed Asset Information" :column="2" >
                                            <el-descriptions-item label="DATE ACQUIRED">{{ otherInventoryInfo.date_acquired }}</el-descriptions-item>
                                            <el-descriptions-item label="COST">{{ otherInventoryInfo.cost }}</el-descriptions-item>
                                            <el-descriptions-item label="DESCRIPTION">{{ otherInventoryInfo.description }}</el-descriptions-item>
                                            <el-descriptions-item label="STATUS">{{ otherInventoryInfo.status }}</el-descriptions-item>
                                            <el-descriptions-item label="Location">{{ otherInventoryInfo.fixed_assets | location}}</el-descriptions-item>
                                            <el-descriptions-item label="Return"  v-if="isReturnWarehouse">
                                                <el-button type="info" width="200" v-if="isReturnWarehouse" @click="returnWarehouse" size="mini">Return to Warehouse</el-button>
                                            </el-descriptions-item>
                                        </el-descriptions>
                                    </div>
                                </el-card>
                            </div>
                        </div>
                        <div class=" justify-content-center bg-gray-100" style="padding:10px">
                                <el-row>
                                    <el-tabs v-model="activeName">
                                    <el-tab-pane label="Location History" name="first">
                                        <other-location-history :id="id"></other-location-history>
                                    </el-tab-pane>
                                    <el-tab-pane label="Equipment Documents" name="second" lazy>
                                        <other-inventory-documents :id="id"></other-inventory-documents>
                                    </el-tab-pane>
                                    <el-tab-pane label="Job Order" name="third" lazy>
                                        <other-job-order :id="id"></other-job-order>
                                    </el-tab-pane>
                                    <el-tab-pane label="Maintenance History" name="fourth" lazy>
                                        <other-maintenance :id="id"></other-maintenance>
                                    </el-tab-pane>
                                </el-tabs>
                                </el-row>
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
        <el-dialog title="Update Other" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <other-inventory-form :editData="editData" :mode="mode"></other-inventory-form>
        </el-dialog>
        <el-dialog title="Return to Warehouse" width="35%" :visible.sync="dialogTableVisibleReturn">
            <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
                <el-form-item label="Date Returned" prop="date_returned">
                    <el-date-picker type="date" placeholder="Pick a Date" v-model="form.date_returned" style="width: 100%;"></el-date-picker>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                    <el-button :disabled="disableButton" @click="resetForm('form')">Reset</el-button>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'OtherInventoryDetails',
    props: {
        id: null,
        data: {}
    },
    data() {
        return {
            otherInventoryInfo: {},
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
            this.getOtherInventoryInfo();
        }
        else {
            this.otherInventoryInfo = this.data;
        }

        this.$EventDispatcher.listen('UPDATED_OTHER_INVENTORY', updatedData => {
            this.dialogFormVisible = false
            this.otherInventoryInfo = updatedData
            this.mode = ''
        });
    },
    computed: {
        isReturnWarehouse() {
            if(!this.otherInventoryInfo.fixed_assets.location.length <= 0) {
                if(this.otherInventoryInfo.fixed_assets.location[0].project_name != 'Warehouse') {
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
        async getOtherInventoryInfo() {
            try {
                const res = await this.$API.OtherInventory.getInfo(this.id);
                this.otherInventoryInfo = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        edit() {
            this.dialogFormVisible = true;
            this.editData = this.otherInventoryInfo;
            // this.EventDispatcher.fire('handleCloseOther')
            this.mode = 'update'

        },
        handleClose(done) {
            this.mode = 'create'
            this.$EventDispatcher.fire('handleCloseUpdateOther', this.otherInventoryInfo)
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
                    fixed_asset_id: this.otherInventoryInfo.fixed_assets.id,
                    project_name: 'Warehouse',
                    location: 'Warehouse',
                    status: 'Return from '+this.otherInventoryInfo.fixed_assets.location[0].project_name,
                    date: this.$df.formatDate(this.form.date_returned, "YYYY-MM-DD")
                }

                const res = await this.$API.HeavyEquipment.returnToWarehouse(data);
                this.otherInventoryInfo.fixed_assets.location[0].project_name = 'Warehouse'
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
