<template>
    <div>
        <el-card class="box-card" shadow="never">
            <div class="text item">
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="consumbaleData"
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
                            prop="item"
                            label="Item"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="unit"
                            label="Unit"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="unit_price"
                            label="Unit Price"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
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
                    :pagination="consumbalePagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog title="Add Item" width="35%"  :visible.sync="dialogFormVisible">
            <consumable-item-form :id="id" :mode="mode" :model="model"></consumable-item-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'ConsumbaleItemList',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return {
            consumbaleData: [],
            consumbalePagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            mode: '',
            model: {},
            dialogFormVisible: false
        }
    },
    created() {
        this.getConsumableItems();

        this.$EventDispatcher.listen('ADD_NEW_ITEM', data => {
            this.consumbaleData.unshift(data);
        });

        this.$EventDispatcher.listen('UPDATE_ITEM', data => {
            this.consumbaleData.forEach(cons => {
                if(cons.id == data.id) {
                    for(let key in data) {
                        cons[key] = data[key]
                    }
                }
            });
            this.dialogFormVisible = false;
        });
    },
    methods: {
        async getConsumableItems() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.Consumable.getConsumableItems(this.id, params);
                this.consumbaleData = res.data.data;
                this.consumbalePagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleEdit(index, data) {
            this.mode = 'update';
            this.model = {...data}
            this.dialogFormVisible = true
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteConsumableItem(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteConsumableItem(index, data) {
            try {
                await this.$API.Consumable.deleteConsumableItem(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.consumbaleData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getConsumableItems();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getConsumableItems();
        },
        applySearch() {
            this.getConsumableItems();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getConsumableItems();
            }
        }
    }
}
</script>
