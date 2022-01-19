<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-row>
                <el-col :span="8">
                    <el-form-item label="Request Material No." prop="request_material_code">
                        <el-select
                            v-model="form.request_material_code"
                            style="width: 100%"
                            filterable
                            remote
                            reserve-keyword
                            @change="rmChange"
                            placeholder="Please enter a keyword"
                            :remote-method="remoteMethodRMList"
                            :loading="loadingProject">
                            <el-option
                            v-for="item in rmList"
                            :key="item.id"
                            :label="`${item.request_material_code}`"
                            :disabled="item.isComplete"
                            :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-col>
                <el-col :span="1">&nbsp;</el-col>
                <el-col :span="13">
                    <el-form-item label="Project" prop="request_form_from_project_id">
                        <el-input disabled v-model="form.request_form_from_project_id"></el-input>
                        <!--el-select
                            v-model="form.request_form_from_project_id"
                            style="width: 100%"
                            filterable
                            remote
                            :disabled="!form.date_requested"
                            reserve-keyword
                            @change="selectProject"
                            placeholder="Please enter a keyword"
                            :remote-method="remoteMethodProject"
                            :loading="loadingProject">
                            <el-option
                            v-for="item in projectsList"
                            :key="item.id"
                            :label="`${item.project.name} - ${item.project.location}`"
                            :value="item.id">
                            </el-option>
                        </!--el-select-->
                    </el-form-item>
                </el-col>
            </el-row>
            <el-form-item label="Date Delivered" prop="date_delivered">
                <el-date-picker type="date" placeholder="Pick a Date" v-model="form.date_delivered" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item label="Consumable Supplies" prop="consumable_items">
                <el-table
                    ref="multipleTable"
                    :data="consumable_items"
                    v-loading="loadingItems"
                    style="width: 100%">
                        <el-table-column
                            width="200"
                            label="Item Name"
                            prop="consumable_supply.item_name">
                        </el-table-column>
                        <el-table-column
                            width="130"
                            label="Item Code"
                            prop="consumable_supply.item_code">
                        </el-table-column>
                        <el-table-column
                            width="130"
                            label="Stock on Hand"
                            prop="consumable_supply.stock_on_hand">
                        </el-table-column>
                        <el-table-column
                            width="180"
                            label="Requested Quantity"
                            prop="quantity">
                        </el-table-column>
                        <el-table-column
                            width="180"
                            label="Previous Stock Out">
                                <template slot-scope="scope">
                                    {{scope.row | previousStockOut}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            width="180"
                            label="Actual Quantity Deliverd">
                            <template slot-scope="scope">
                                <el-input type="number" min="0" @change="actualQuantity(scope.row)" v-model="scope.row.actual_quantity_delivered"></el-input>
                            </template>
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="180"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="text"
                                @click="askToDelete(scope.$index, scope.row)">Remove</el-button>
                            </template>
                        </el-table-column>
                </el-table>
            </el-form-item>
            <el-form-item label="Remarks" prop="remarks">
                <el-input type="textarea" v-model="form.remarks" placeholder="Remarks..."></el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                <el-button @click="resetForm('form')" :disabled="disableButton" >Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'ConsumableItemStockOutMultipleForm.vue',
    data() {
        return {
            loading: false,
            loadingProject: false,
            rmList: [],
            form: {
                date_delivered: '',
                remarks: '',
                request_form_from_project_id: '',
                consumable_items: [],
                date_requested: '',
                request_material_code: ''
            },
            rules: {
                date_delivered: [
                    {required: true, message: 'Please input Date Delivered', trigger: 'blur'}
                ],
                remarks: [
                    {required: true, message: 'Please input Remarks', trigger: 'blur'}
                ],
                request_material_code: [
                    {required: true, message: 'Please input Request Material No.', trigger: 'blur'}
                ],
                date_requested: [
                    {required: true, message: 'Please input Date Delivered', trigger: 'blur'}
                ],
                request_form_from_project_id: [
                    {required: true, message: 'Please Select Project', trigger: 'blur'}
                ],
            },
            disableButton: false,
            loadingProject: false,
            projectsList: [],
            consumable_items: [],
            loadingItems: false,

        }
    },
    created() {
        this.$EventDispatcher.listen('CLOSE_CONSUMABLE_MULTIPLE_FORM', data => {
            this.resetForm('form');
        });
    },
    filters: {
        previousStockOut(value) {
            let total = 0
            if(value.consumable_stock_out.length > 0) {
                value.consumable_stock_out.forEach(item => {
                    total = total + parseInt(item.actual_quantity_delivered)
                })

                return total
            }

            return total
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
            this.consumable_items = []
        },
        selectProject() {
            this.getCOnsumableSupplies();
        },
        changeDateRequested() {
            this.consumable_items = []
            this.projectsList = []
            this.form.request_form_from_project_id = ''
        },
        async store() {
            this.form.consumable_items = this.consumable_items
            this.form.date_delivered = this.$df.formatDate(this.form.date_delivered, "YYYY-MM-DD")
            try {
                this.disableButton = true
                const res = await this.$API.ConsumableStockOut.store(this.form);
                console.log('====================================');
                console.log(this.form);
                console.log('====================================');
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
            }
        },
        async getCOnsumableSupplies() {
            try {
                this.loadingItems = true;
                let params = {
                    request_form_from_project_id: this.form.request_material_code
                }
                const res = await this.$API.RequestMaterial.getConsumableSuppliesData(params);
                this.consumable_items = res.data;
                this.loadingItems = false
            } catch (error) {
                console.log(error);
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
        askToDelete(index, data) {
            this.$confirm('Are you sure you want to remove this file?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    let value = {
                        index,
                        data
                    }

                    this.consumable_items.splice(index, 1)

                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        actualQuantity(data) {
            let total = 0
            if(data.consumable_stock_out.length > 0) {
                data.consumable_stock_out.forEach(item => {
                    total = total + parseInt(item.actual_quantity_delivered)
                })
            }

            let total_stock = total + parseInt(data.actual_quantity_delivered);
            if(total_stock > data.quantity) {
                this.$message.error(`Requested Quantity does not match`);
                data.actual_quantity_delivered = null
                return;
            }

            if(data.actual_quantity_delivered > data.quantity) {
                this.$message.error('Insufficient stock on hand.');
                data.actual_quantity_delivered = null
                return
            }
            if(data.actual_quantity_delivered > data.consumable_supply.stock_on_hand) {
                this.$message.error('No more stock available.');
                data.actual_quantity_delivered = null
                return
            }
        },
        
        async remoteMethodRMList(query) {
            try {
                if (query !== '') {
                    this.loadingProject = true;
                    try {
                        const res = await this.$API.RequestMaterial.getRequestMaterialCodet(query);
                        this.rmList = res.data
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
        rmChange(value) {
            let project = this.rmList.filter(rm => rm.id == value)
            console.log(project);
            this.form.request_form_from_project_id = project[0].project.name
            this.getCOnsumableSupplies();
        }
    },
}
</script>
