<template>
    <div class="d-flex flex-column-fluid" v-loading="loading">
        <!--begin::Container-->
        <div class="container">
            <el-card class="box-card">
                <div class="text item">
                    <el-button type="primary" @click="projectStatus" size="mini">
                        Add Project Status
                    </el-button>
                    <el-input
                        size="mini"
                        placeholder="Search here....."
                        style="width:300px; float:right"
                        @keyup.enter.native="applySearch"
                        v-model="search">
                    </el-input>
                    <el-table
                        :data="projectStatusData"
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
                                label="NAME"
                                :sortable="true">
                            </el-table-column>
                            <el-table-column
                                label="ACTION">
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
                        :pagination="projectStatusPagination"
                        :total="filters.total"
                        @handleSizeChange="handleSizeChange"
                        @handleCurrentChange="handleCurrentChange">
                    </global-pagination>
                </div>
            </el-card>
        </div>
        <el-dialog :title="mode == 'create'? 'Add Status':'Update Status'" width="35%"  :visible.sync="dialogFormVisible" :before-close="handleClose">
            <project-status-form :mode="mode" :model="model"></project-status-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'ProjectStatus',
    mixins: [paginate],
    data() {
        return {
            projectStatusData: [],
            projectStatusPagination: [],
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
        this.getProjectStatus();
        this.$EventDispatcher.listen('NEW_PROJECT_STATUS', data => {
            this.projectStatusData.unshift(data)
            this.dialogFormVisible = false
        })
        this.$EventDispatcher.listen('UPDATE_PROJECT_STATUS', data => {
            this.projectStatusData.forEach(status => {
                if(status.id == data.id) {
                    for(let key in data) {
                        status[key] = data[key]
                    }
                }
            })
            this.dialogFormVisible = false
        })
    },
    methods: {
        async getProjectStatus() {
            this.loading = true;
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.ProjectStatus.getData(params);
                this.projectStatusData = res.data.data;
                this.projectStatusPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getProjectStatus();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getProjectStatus();
        },
        applySearch() {
            this.getProjectStatus();
        },
        handleClose(done) {
            this.mode = ''
            this.$EventDispatcher.fire('handleCloseProjectStatus')
            done();
        },
        projectStatus() {
            this.mode = 'create',
            this.model = {}
            this.dialogFormVisible = true
        },
        handleEdit(index, data) {
            this.mode = 'update',
            this.model = data
            this.dialogFormVisible = true
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteMaintenance(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteMaintenance(index, data) {
            try {
                await this.$API.ProjectStatus.delete(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted!',
                    type: 'success'
                });
                this.projectStatusData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getProjectStatus();
            }
        }
    }
}
</script>
