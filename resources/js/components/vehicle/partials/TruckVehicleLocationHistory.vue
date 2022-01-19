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
                    :data="locaitonHistoryData"
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
                            prop="project_name"
                            label="Project"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="location"
                            label="Location"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="status"
                            label="Status"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="date"
                            label="Date"
                            :sortable="true">
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="locaitonHistoryPagination"
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
    name : 'TruckVehicleLocationHistory',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return {
            locaitonHistoryData: [],
            locaitonHistoryPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
        }
    },
    created() {
        this.getLocationHistory();
        this.$EventDispatcher.listen('RETURN_WAREHOUSE', data => {
            this.locaitonHistoryData.unshift(data)
        })
    },
    methods: {
        async getLocationHistory() {
            try {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };

            const res = await this.$API.TruckVehicle.getHistory(this.id, params);

            this.locaitonHistoryData = res.data.data;
            this.locaitonHistoryPagination = res.data
            this.loading = false;

            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getLocationHistory();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getLocationHistory();
        },
        applySearch() {
            this.getLocationHistory();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getLocationHistory();
            }
        }
    }
}
</script>
