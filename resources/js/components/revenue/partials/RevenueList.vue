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
                    :data="revenueData"
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
                            prop="date"
                            label="Date"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="date"
                            label="Amount"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.amount | addComma}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Account"
                            prop="account.bank_name"
                            show-overflow-tooltip
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.account.bank_name}} - {{scope.row.account.holder_name}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            prop="customer.name"
                            label="Customer"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="project.name"
                            show-overflow-tooltip
                            label="Project"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="reference"
                            label="Reference"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="description"
                            label="Description"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="description"
                            label="Attachment"
                            show-overflow-tooltip
                            :sortable="true">
                                <template slot-scope="scope">
                                    <template v-if="scope.row.attachable">
                                        <a type="text" :href="`/attachment/attachment-file?file=${scope.row.attachable.file}&path=${scope.row.attachable.path}`" target="_blank">{{scope.row.attachable.file_name}}</a>
                                    </template>
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Action">
                            <template slot-scope="scope">
                                <button type="button" class="btn btn-icon btn-success btn-sm" @click="handleEdit(scope.$index, scope.row)">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-danger btn-sm" @click="askToDelete(scope.$index, scope.row)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="revenuePagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
                <el-dialog :title="mode == 'create' ? 'Add Revenue' : 'Update Revenue'" width="55%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
                    <revenue-form :mode="mode" :model="model"></revenue-form>
                </el-dialog>
            </div>
        </el-card>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'RevenueList',
    mixins: [paginate],
    data() {
        return {
            revenueData: [],
            revenuePagination: [],
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
        this.getRevenues()
        this.$EventDispatcher.listen('NEW_REVENUE', data => {
            this.revenueData.unshift(data)
            this.dialogFormVisible = false
            this.mode = ''
            this.model = {}
        })

        this.$EventDispatcher.listen('UPDATE_REVENUE', data => {
            this.revenueData.forEach(rev => {
                if(rev.id == data.id) {
                    for(let key in data) {
                        rev[key] = data[key]
                    }
                }
            })
            this.dialogFormVisible = false
        })
    },
    filters: {
        addComma(value) {
            if(value) {
                return 'P ' +value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            return 'P 0.00'
        },
        file(value) {
            if(value.attachable) {
                return value.attachable.file_name
            }
        }
    },
    methods: {
        async getRevenues() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.Revenue.getRevenues(params)
                this.revenueData = res.data.data
                this.revenuePagination = res.data.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        addNew() {
            this.dialogFormVisible = true
            this.mode = 'create'
            this.model = {}
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true
            this.mode = 'update'
            this.model = {...data}
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
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
                await this.$API.Revenue.deleteRevenue(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.revenueData.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.mode = ''
            this.model = {}
            this.$EventDispatcher.fire('CLOSE_REVENUE')
            done();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getRevenues();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getRevenues();
        },
        applySearch() {
            this.getRevenues();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getRevenues();
            }
        }
    }
}
</script>
