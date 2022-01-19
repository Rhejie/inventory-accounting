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
                    :data="equipmentData"
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
                        prop="control_number"
                        width="180"
                        label="CONTROL NUMBER"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="model"
                        width="180"
                        label="MODEL"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="brand_name"
                        width="180"
                        label="BRAND NAME"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="category.name"
                        width="180"
                        label="CATEGORY"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="status"
                        width="180"
                        label="STATUS"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="serial_number"
                        width="180"
                        label="SERIAL NUMBER"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="reference_number"
                        width="180"
                        label="REFERENCE NUMBER"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="date_acquired"
                        width="180"
                        label="DATE ACQUIRED"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                            width="180"
                            fixed="right"
                            label="ACTION">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="text"
                                @click="handleView(scope.$index, scope.row)">View</el-button>
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
                    :pagination="equipmentDataPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'HeavyEquipmentList',
    mixins: [paginate],
    props: {
        pageData: {}
    },
    data() {
        return {
            equipmentData: [],
            equipmentDataPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            filters: {
                search: null,
            },
        }
    },
    created() {
        this.getEquipments();

        this.$EventDispatcher.listen('ADD_NEW_HEAVY_EQUIPMENT', data => {
			this.equipmentData.unshift(data)
		})
    },
    methods: {
        async getEquipments() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.HeavyEquipment.getEquipments(params);
                this.equipmentData = res.data.data;
                this.equipmentDataPagination = res.data;
                console.log(res.data);
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getEquipments();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getEquipments();
        },
        applySearch() {
            this.getEquipments();
        },
        handleView(index, data) {
            this.$router.push({
                name: 'Heavy Equipment Details',
                params: {id:  data.id, data: data, pageData: this.pageData}
            });
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteProject(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteProject(index, data) {
            try {
                await this.$API.HeavyEquipment.deleteHeavyEquipment(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.equipmentData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getEquipments();
            }
        }
    }
}
</script>
