<template>
    <div>
        <el-card class="box-card" shadow="never" >
            <div class="text item">
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="consumableSupplyData"
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
                            prop="item_code"
                            width="180"
                            label="Item Code"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="item_name"
                            width="180"
                            label="Item Name"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="project.name"
                            width="180"
                            label="For Project"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="bar_code"
                            width="180"
                            label="Bar Code"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="lot_number"
                            width="180"
                            label="Lot Number"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="description"
                            width="180"
                            label="Description"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="unit_of_measure"
                            width="180"
                            label="Unit Of Measure"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="stock_on_hand"
                            width="180"
                            label="Stock"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="reorder_point"
                            width="180"
                            label="Reorder Point"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="110"
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
                    :pagination="consumablePagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog title="Update Supply" width="35%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <consumable-supply-form :mode="mode" :model="model"></consumable-supply-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'ConsumableSupplyList',
    mixins: [paginate],
    data() {
        return {
            consumableSupplyData: [],
            consumablePagination: [],
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
        this.getSupply();
        this.$EventDispatcher.listen('NEW_CONSUMABLE_SUPPLY', data => {
            this.consumableSupplyData.unshift(data);
        })

        this.$EventDispatcher.listen('UPDATE_CONSUMABLE_SUPPLY', data => {
            this.consumableSupplyData.forEach(con => {
                if(con.id == data.id) {
                    for(let key in data) {
                        con[key] = data[key]
                    }
                }
            });

            this.dialogFormVisible = false
        })
    },
    methods: {
        async getSupply() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.Consumable.getSupply(params);
                this.consumableSupplyData = res.data.data;
                this.consumablePagination = res.data;
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
            this.dialogFormVisible = true;
            this.mode = 'update';
            this.model = {...data}
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteSupply(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteSupply(index, data) {
            try {
                await this.$API.Consumable.deleteSupply(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.consumableSupplyData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getSupply();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getSupply();
        },
        applySearch() {
            this.getSupply();
        },
        handleClose(done) {
            this.mode = ''
            this.$EventDispatcher.fire('handleCLoseConsumbleSupply')
            done();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getSupply();
            }
        }
    }
}
</script>
