<template>
	<div>
        <el-card class="box-card">
            <div class="text item">
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="requestMaterialData"
                    v-loading="loading"
                    style="width: 100%">
                        <el-table-column
                            width="70"
                            label="No."
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.$index + 1}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            prop="request_material_code"
                            label="Req. Material Code"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="date_request"
                            label="Date Requested"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="project.name"
                            label="Project"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="requested_by"
                            label="Requested By"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="approved_by"
                            label="Approved By"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Status"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row | statusFilter}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="text"
                                @click="handleView(scope.$index, scope.row)">View</el-button>
                                <el-button
                                size="mini"
                                type="text"
                                @click="handleEdit(scope.$index, scope.row)">Edit</el-button>
                                <el-button
                                size="mini"
                                type="text"
                                @click="askToDelete(scope.$index, scope.row)">Delete</el-button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="requestMaterialPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog title="Update Request" width="35%"  :visible.sync="dialogFormVisible">
            <request-material-form :mode="mode" :model="model"></request-material-form>
        </el-dialog>
	</div>
</template>

<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'RequestMaterialList',
    mixins: [paginate],
    props: {
        pageData: {}
    },
    data() {
        return {
            requestMaterialData: [],
            requestMaterialPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            dialogFormVisible: false,
            mode: '',
            model: {}
        }
    },
    created() {
        this.getRequest();
        this.$EventDispatcher.listen('NEW_REQUEST_MATERIAL', data => {
            this.requestMaterialData.unshift(data);
        });

        this.$EventDispatcher.listen('UPDATE_REQUEST_MATERIAL', data => {
            this.requestMaterialData.forEach(req => {
                if(req.id == data.id) {
                    for(let key in data) {
                        req[key] = data[key]
                    }
                }
            })
            this.dialogFormVisible = false;
        });
    },
    filters: {
        statusFilter(value) {
            let totalStockout = 0
            let totalRequest = 0
            let totalConsumableItem = 0
            let totalConsumableItemStockOut = 0
            let totalRequestConsumable = 0
            let totalActualRequestDelivered = 0

            value.request_material_fixed_asset_item.forEach(() => {
                totalRequest += 1
            })

            value.request_material_stock_out.forEach(() => {
                totalStockout += 1
            })

            value.request_material_consumable_item.forEach(item => {
                totalConsumableItem+=1
                totalRequestConsumable+=parseInt(item.quantity)
            })

            value.request_material_consumable_stock.forEach(item => {
                totalConsumableItemStockOut += 1
                totalActualRequestDelivered += parseInt(item.actual_quantity_delivered)
            })
            console.log(totalConsumableItem, totalConsumableItemStockOut);

            if(totalStockout === totalRequest && totalStockout != 0 && totalRequest != 0) {

                if(totalConsumableItem != totalConsumableItemStockOut) {
                    if(totalConsumableItem != 0 && totalConsumableItemStockOut == 0) return 'Incomplete'
                    if(totalConsumableItem == 0 && totalConsumableItemStockOut != 0) return 'Incomplete'
                }
                if(totalRequestConsumable === totalActualRequestDelivered && totalRequestConsumable != 0 && totalActualRequestDelivered != 0) {
                    return 'Complete'
                }
                else if(totalRequestConsumable != totalActualRequestDelivered) {
                    return 'Incomplete'
                }
                else if(totalStockout === totalRequest) {
                    return 'Complete'
                }
                return 'Incomplete'
            }

            return 'Incomplete'
        }
    },
    methods: {
        async getRequest() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.RequestMaterial.getRequest(params);
                this.requestMaterialData = res.data.data;
                this.requestMaterialPagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleEdit(index, data) {
            this.mode = 'update'
            this.dialogFormVisible = true;
            this.model = {...data};
        },
        handleView(index, data) {
            this.$router.push({
                name: 'Request Material Details',
                params: {id: data.id, data}
            });
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteRequest(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteRequest(index, data) {
            try {
                await this.$API.RequestMaterial.deleteRequest(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.requestMaterialData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getRequest();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getRequest();
        },
        applySearch() {
            this.getRequest();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getRequest();
            }
        }
    }
}
</script>
