<template>
    <div>
        <el-card class="box-card">
            <div class="text item">
                <el-button size="mini" @click="addDescription" type="primary">Add Item</el-button>
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right; margin-bottom: 10px"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="descriptions"
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
                    :pagination="descriptionsPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create'? 'Add Description' : 'Update Description' " width="45%" :visible.sync="dialogFormVisible">
            <bill-of-material-description-form :mode="mode" :model="model"></bill-of-material-description-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../../mixin/pagination'
export default {
    name: 'BillOfMaterialDescription',
    mixins: [paginate],
    data() {
        return {
            descriptions: [],
            descriptionsPagination: [],
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
        this.getDescriptions();
        this.$EventDispatcher.listen('NEW_BILL_DESCRIPTION', data => {
            this.descriptions.unshift(data);
            this.dialogFormVisible = false
        })
        this.$EventDispatcher.listen('UPDATED_DESCRIPTION', data => {
            this.descriptions.forEach(item => {
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
        async getDescriptions() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.BillOfMaterial.getDescriptions(params);
                this.descriptions = res.data.data
                this.descriptionsPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error)
            }
        },
        addDescription() {
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
                    this.deleteDescription(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteDescription(index, data) {
            try {
                await this.$API.BillOfMaterial.deleteDescription(data.id);
                this.descriptions.splice(index, 1)
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
            this.getDescriptions();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getDescriptions();
        },
        applySearch() {
            this.getDescriptions();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getDescriptions();
            }
        }
    }
}
</script>
