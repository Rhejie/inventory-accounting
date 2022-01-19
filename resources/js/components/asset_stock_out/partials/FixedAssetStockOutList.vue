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
                    :data="fixedAssetStockOutData"
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
                            prop="request_materials_fixed_asset.fixed_asset.assetable.brand_name"
                            show-overflow-tooltip
                            label="Brand Name"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="request_materials_fixed_asset.request_material.project.name"
                            show-overflow-tooltip
                            label="Project"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="request_materials_fixed_asset.request_material.project.location"
                            show-overflow-tooltip
                            label="Location"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            show-overflow-tooltip
                            label="Is Delivered"
                            :sortable="true">
                            <template slot-scope="prop">
                                <el-switch
                                    @change="isDelivered($event, prop.row)"
                                    v-model="prop.row.is_delivered"
                                    active-color="#13ce66"
                                    inactive-color="#ff4949">
                                </el-switch>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="date_delivered"
                            show-overflow-tooltip
                            label="Date Delivered"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="remarks"
                            show-overflow-tooltip
                            label="Remarks"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            label="Action">
                            <template slot-scope="scope">
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
                    :pagination="fixedAssetStockOutPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog title="Update Release To" :visible.sync="dialogFormVisible">
            <fixed-asset-stock-out-form :mode="mode" :model="model"></fixed-asset-stock-out-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'FixedAssetStockOutList',
    mixins: [paginate],
    data() {
        return {
            fixedAssetStockOutData: [],
            fixedAssetStockOutPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            mode: 'update',
            model : {},
            dialogFormVisible: false,
        }
    },
    created() {
        this.getStockOut();

        this.$EventDispatcher.listen('ADD_NEW_ASSET_STOCK_OUT', data => {
            this.fixedAssetStockOutData.unshift(data);
        });

        this.$EventDispatcher.listen('UPDATE_ASSET_STOCK_OUT', data => {
            this.fixedAssetStockOutData.forEach(asset => {
                if(asset.id == data.id) {
                    for(let key in data) {
                        asset[key] = data[key]
                    }
                }
            })
            this.dialogFormVisible = false;
        })
    },
    methods: {
        async getStockOut() {
            this.loading = true;
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.FixedAssetStockOut.getStockOut(params);
                this.fixedAssetStockOutData = res.data.data;
                this.fixedAssetStockOutPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        async isDelivered(event, data) {
            try {
                if(event) {
                    let delivered_from = ''
                    if(data.request_materials_fixed_asset.fixed_asset.location && data.request_materials_fixed_asset.fixed_asset.location.length > 0) {
                        delivered_from = data.request_materials_fixed_asset.fixed_asset.location[0].project_name
                    }
                    else {
                        delivered_from = 'Warehouse'
                    }
                    event = 1
                    let project_asset = {
                        'project_id' : data.request_materials_fixed_asset.request_material.project_id,
                        'project_name' : data.request_materials_fixed_asset.request_material.project.name,
                        'location' : data.request_materials_fixed_asset.request_material.project.location,
                        'fixed_asset_id' : data.request_materials_fixed_asset.fixed_asset.id,
                        'date_delivered' : data.date_delivered,
                        'remarks' : data.remarks,
                        delivered_from
                    }

                    this.$API.Project.ProjectFixedAsset(project_asset);
                }
                else if(event == false) {
                    event = 0
                    let project_asset = {
                        'project_id' : data.request_materials_fixed_asset.request_material.project_id,
                        'fixed_asset_id' : data.request_materials_fixed_asset.fixed_asset.id,
                    }

                    // this.$API.Project.deleteProjectFixedAsset(project_asset);
                }


                await this.$API.FixedAssetStockOut.isDelivered(data.id, event);
            } catch (error) {
                console.log(error);
            }
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true;
            this.mode = 'update'
            this.model = {...data};
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    let value = {
                        index,
                        data
                    }
                    this.delete(index, data);

                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async delete(index, data) {
            try {
                await this.$API.FixedAssetStockOut.delete(data.id);
                this.fixedAssetStockOutData.splice(index, 1);
                this.$message({
                    type: 'success',
                    message: 'Delete completed'
                });
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getStockOut();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getStockOut();
        },
        applySearch() {
            this.getStockOut();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getStockOut();
            }
        }
    }
}
</script>
