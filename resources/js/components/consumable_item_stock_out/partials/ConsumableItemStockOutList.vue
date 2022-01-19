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
                    :data="consumableItemStockOutData"
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
                            prop="consumable_item.consumable_supply.item_code"
                            show-overflow-tooltip
                            width="180"
                            label="Item Code"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="consumable_item.consumable_supply.item_name"
                            show-overflow-tooltip
                            width="180"
                            label="Item Name"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="consumable_item.request_material.project.name"
                            show-overflow-tooltip
                            width="180"
                            label="Project"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="consumable_item.request_material.project.location"
                            show-overflow-tooltip
                            width="180"
                            label="Location"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            show-overflow-tooltip
                            width="180"
                            label="Is Delivered (No/Yes)"
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
                            prop="actual_quantity_delivered"
                            show-overflow-tooltip
                            width="180"
                            label="Quantity"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="date_delivered"
                            show-overflow-tooltip
                            width="180"
                            label="Date Delivered"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="remarks"
                            show-overflow-tooltip
                            width="180"
                            label="Remarks"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="100"
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
                    :pagination="consumableItemStockOutPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog title="Update Consumable Item" :visible.sync="dialogFormVisible">
            <consumable-item-stock-out-form :mode="mode" :consumableItemStockOutData="consumableItemStockOutData" :model="model"></consumable-item-stock-out-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'ConsumableItemStockOutList',
    mixins: [paginate],
    data() {
        return {
            consumableItemStockOutData: [],
            consumableItemStockOutPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            dialogFormVisible: false,
            mode: 'update',
            model : {}
        }
    },
    created() {
        this.getStockOuts()

        this.$EventDispatcher.listen('ADD_NEW_CONSUMABLE_STOCK_OUT', data => {
            data.forEach(d => {
                this.consumableItemStockOutData.unshift(d);
            });
        });

        this.$EventDispatcher.listen('UPDATE_CONSUMABLE_STOCK_OUT', data => {
            this.consumableItemStockOutData.forEach(supply => {
                if(supply.id == data.res.id) {
                    for (let key in data.res) {
                        supply[key] = data.res[key];
                    }
                }
            })
            if(!data.isStay) {
                this.dialogFormVisible = false;
            }

        });
    },
    methods: {
        async getStockOuts() {
            this.loading = true;
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.ConsumableStockOut.getStockOut(params);
                this.consumableItemStockOutData = res.data.data;
                this.consumableItemStockOutPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true;
            this.model = {...data}
            this.mode = 'update'
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
                await this.$API.ConsumableStockOut.delete(data.id, data);
                this.consumableItemStockOutData.splice(index, 1);
                this.$message({
                    type: 'success',
                    message: 'Delete completed'
                });
            } catch (error) {
                console.log(error);
            }
        },
        async isDelivered(event, data) {
            try {
                if(event) {
                    event = 1
                }
                else if(event == false) {
                    event = 0
                }
                await this.$API.ConsumableStockOut.isDelivered(data.id, event);
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getStockOuts();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getStockOuts();
        },
        applySearch() {
            this.getStockOuts();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getStockOuts();
            }
        }
    }
}
</script>
