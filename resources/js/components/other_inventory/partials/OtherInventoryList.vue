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
                    :data="othersData"
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
                            label="BRAND NAME"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="description"
                            label="DESCRIPTION"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="cost"
                            label="COST"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="status"
                            label="STATUS"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="date_acquired"
                            label="DATE ACQUIRED"
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
                    :pagination="othersPagination"
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
    name: 'OtherInventoryList',
    mixins: [paginate],
    data() {
        return {
            othersData: [],
            othersPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
        }
    },
    created() {

        this.getOtherInventory();

        this.$EventDispatcher.listen('NEW_ADDED_OTHER_INVENTORY', newData => {
            this.othersData.unshift(newData);
        });

   },
    methods: {
        async getOtherInventory() {
            this.loading = true;
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.OtherInventory.getOtherInventoryData(params);
                this.othersData = res.data.data;
                this.othersPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getOtherInventory();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getOtherInventory();
        },
        applySearch() {
            this.getOtherInventory();
        },
        handleView(index, data) {
            this.$router.push({
                name: 'Other Inventory Details',
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
                await this.$API.OtherInventory.deleteOtherInventory(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.othersData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getOtherInventory();
            }
        }
    }
}
</script>
