<template>
    <div>
        <el-card class="box-card">
            <div class="text item">
                <el-button size="mini" @click="addItem" type="primary">Add Item</el-button>
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right; margin-bottom: 10px"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="items"
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
                            prop="name"
                            label="item"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="description"
                            label="Description"
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
                    :pagination="itemsPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create'? 'Add Item' : 'Update Item' " width="45%" :visible.sync="dialogFormVisible">
            <bill-of-material-item-form :mode="mode" :model="model"></bill-of-material-item-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../../mixin/pagination'
export default {
    name: 'BillOfMaterialItem',
    mixins: [paginate],
    data() {
        return {
            items: [],
            itemsPagination: [],
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
        this.getItems()
        this.$EventDispatcher.listen('NEW_BILL_ITEM', data => {
            this.items.unshift(data);
            this.dialogFormVisible = false
        })
        this.$EventDispatcher.listen('UPDATED_ITEM', data => {
            this.items.forEach(item => {
                if(item.id == data.id) {
                    for(let key in data) {
                        item[key] = data[key]
                    }
                }
            })
            this.dialogFormVisible = false
        })
    },
    methods: {
        async getItems() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.BillOfMaterial.getItems(params);
                this.items = res.data.data
                this.itemsPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error)
            }
        },
        addItem() {
            this.dialogFormVisible = true
            this.mode = 'create'
            this.model = {}
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true
            this.mode = 'update'
            this.model = data
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteItem(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteItem(index, data) {
            try {
                await this.$API.BillOfMaterial.deleteItem(data.id);
                this.items.splice(index, 1)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
            }catch (error) {
                console.log(error)
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getItems();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getItems();
        },
        applySearch() {
            this.getItems();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getItems();
            }
        }
    }
}
</script>
