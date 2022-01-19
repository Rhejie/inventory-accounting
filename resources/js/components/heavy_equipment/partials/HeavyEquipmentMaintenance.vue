<template>
    <div>
        <el-card class="box-card">
            <div class="text item">
                <el-button type="primary" @click="addJO" size="mini">
                    Add Maintenance
                </el-button>
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="equipmentMaintenanceData"
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
                            prop="maintenance_type.type"
                            width="180"
                            label="Type"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="date"
                            width="180"
                            label="Maintenance Date"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="assigned"
                            width="180"
                            label="Assigned"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="amount"
                            width="180"
                            label="Amount"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            width="180"
                            label="Attachment"
                            :sortable="true">
                                <template slot-scope="scope">
                                    <a class=""  :href="`/view-heavy-equipment-attachment?file=${scope.row.file}`" target="_blank">{{scope.row.file_name}}</a>
                                </template>
                        </el-table-column>
                        <el-table-column
                            width="180"
                            fixed="right"
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
                    :pagination="equipmentMaintenanceDataPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create' ?  'Add Maintenance' : 'Update Maintenance'" :visible.sync="dialogTableVisible" :before-close="handleClose">
            <heavy-equipment-maintenance-form :id="id" :mode="mode" :model="model"></heavy-equipment-maintenance-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'HeavyEquipmentMaintenance',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return {
            equipmentMaintenanceData: [],
            equipmentMaintenanceDataPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            dialogTableVisible: false,
            mode: '',
            model: {}
        }
    },
    created() {
        this.$EventDispatcher.listen('ADD_NEW_HEAVY_MAINTENANCE', data => {
            this.equipmentMaintenanceData.unshift(data)
            this.dialogTableVisible = false
        });

        this.$EventDispatcher.listen('UPDATED_HEAVY_MAINTENANCE', data => {
            this.equipmentMaintenanceData.forEach(jo => {
                if(jo.id === data.id) {
                    console.log('runnig');
                    for(let key in data) {
                        jo[key] = data[key]
                    }
                }
            });
            this.dialogTableVisible = false
        });

        this.getMaintenance();
    },
    methods: {
        async getMaintenance() {
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                this.loading = true;
                const res = await this.$API.HeavyEquipmentMaintenance.getHeavyEquipmentMaintenance(this.id, params);
                this.equipmentMaintenanceData = res.data.data
                this.equipmentMaintenanceDataPagination = res.data
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        addJO() {
            this.dialogTableVisible = !this.dialogTableVisible
            this.mode = 'create'
            this.model = {}
        },
        handleEdit(index, data) {
            this.dialogTableVisible = !this.dialogTableVisible
            this.model = data
            this.mode = 'update'
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
                await this.$API.HeavyEquipmentMaintenance.deleteMaintenance(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted!',
                    type: 'success'
                });
                this.equipmentMaintenanceData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.mode = ''
            this.model = {}
            done();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getMaintenance();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getMaintenance();
        },
        applySearch() {
            this.getMaintenance();
        },

    },
    watch: {
        search(val) {
            if( val == '') {
                this.getMaintenance();
            }
        }
    }
}
</script>
