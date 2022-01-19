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
                    :data="truckVehicleData"
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
                            prop="brand_name"
                            width="160"
                            label="BRAND NAME"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="plate_number"
                            width="160"
                            label="PLATE NUMBER"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="body_type"
                            width="160"
                            label="BODY TYPE"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="date_acquired"
                            width="160"
                            label="DATE ACQUIRED"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="cost"
                            width="160"
                            label="COST"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.cost | addComma}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            prop="status"
                            width="160"
                            label="STATUS"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="assigned_to"
                            width="160"
                            label="ASSIGNED TO"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="110"
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
                    :pagination="truckVehiclePagination"
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
    name: 'TruckVehicleList',
    mixins: [paginate],
    data() {
        return {
            truckVehicleData: [],
            truckVehiclePagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
        }
    },
    created() {
        this.getTrucksVehicles();
        this.$EventDispatcher.listen('ADD_NEW_TRUCK_VEHICLE', data => {
            this.truckVehicleData.unshift(data);
        })
    },
    filters: {
        addComma(value) {
            if(value) {
                return 'P '+ value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            return '0.00'
        }
    },
    methods: {
        async getTrucksVehicles() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.TruckVehicle.getTrucksVehicles(params);
                this.truckVehicleData = res.data.data;
                this.truckVehiclePagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getTrucksVehicles();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getTrucksVehicles();
        },
        applySearch() {
            this.getTrucksVehicles();
        },
        handleView(index, data) {
            this.$router.push({
                name: 'Truck Vehicle Details',
                params: {id: data.id, data: data}
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
                await this.$API.TruckVehicle.deleteTruckVehicle(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.truckVehicleData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getTrucksVehicles();
            }
        }
    }
}
</script>
