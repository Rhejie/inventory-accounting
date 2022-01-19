<template>
    <div>
        <el-card class="box-card">
            <div class="text item">
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right; margin-bottom: 10px"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="bills"
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
                            prop="bill_number"
                            label="Ref. No."
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="supplier.name"
                            show-overflow-tooltip
                            label="Supplier"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="project.name"
                            label="Project"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="customer.name"
                            label="Customer"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="title"
                            label="Title"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="bill_date"
                            label="Bill Date"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="due_date"
                            label="Due Date"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Due Amount"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.total_due | addComma}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Status"
                            :sortable="true">
                                <template slot-scope="scope">
                                    <el-tag effect="dark" v-if="scope.row.status == 'Sent'" type="warning">{{scope.row.status}}</el-tag>
                                    <el-tag effect="dark" v-if="scope.row.status == 'Draft'" type="info">{{scope.row.status}}</el-tag>
                                    <el-tag effect="dark" v-if="scope.row.status == 'Paid'" type="success">{{scope.row.status}}</el-tag>
                                    <el-tag effect="dark" v-if="scope.row.status == 'Partaily Paid'" type="primary">{{scope.row.status}}</el-tag>
                                    <el-tag effect="dark" v-if="scope.row.status == 'Due'" type="danger">{{scope.row.status}}</el-tag>
                                </template>
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="150"
                            label="Action">
                            <template slot-scope="scope">
                                <button type="button" class="btn btn-icon btn-success btn-sm" @click="handleEdit(scope.$index, scope.row)">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-icon btn-primary btn-sm" @click="handleView(scope.$index, scope.row)">
                                    <i class="fas fa-eye"></i>
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
                    :pagination="billPagination"
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
    name: 'BillList',
    mixins: [paginate],
    data() {
        return {
            bills: [],
            billPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            mode: '',
            model: {},
        }
    },
    created() {
        this.getBills();
    },
    filters: {
        addComma(value) {
            if(value) {
                value = parseFloat(value).toFixed(2)
                return 'P ' +value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            return 'P 0.00'
        },
    },
    methods: {
        async getBills() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.Bill.getBills(params);
                this.bills = res.data.data
                this.billPagination = res.data
                this.loading = false

            } catch (error) {
                console.log(error);
            }
        },
        handleView(index, data) {
            if(data.type == 'company') {
                this.$router.push({name: 'Bill View 2', params: {id: data.id, model: data} })
            }
            else {
                this.$router.push({name: 'Bill View', params: {id: data.id, model: data} })
            }

        },
        handleEdit(index, data) {
            if(data.type == 'po') {
                this.$router.push({name: 'Bill Update', params: {id: data.id, mode: 'update', model: data } });
            }
            else {
                this.$router.push({name: 'Bill Update 2', params: {id: data.id, mode: 'update', model: data } });
            }
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
                await this.$API.Bill.deleteBill(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.bills.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getBills();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getBills();
        },
        applySearch() {
            this.getBills();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getBills();
            }
        }
    }
}
</script>
