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
                    :data="invoices"
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
                            prop="ref_number"
                            label="Ref. No."
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="customer.name"
                            label="Customer"
                            show-overflow-tooltip
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
                            prop="project.name"
                            label="Project"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="issue_date"
                            label="Issue Date"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="due_date"
                            label="Due Date"
                            :sortable="true">
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
                                    <el-tag effect="dark" v-if="scope.row.status == 'Due date'" type="danger">{{scope.row.status}}</el-tag>
                                </template>
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="150"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                    size="mini"
                                    type="text"
                                    @click="handleEdit(scope.$index, scope.row)">
                                        Edit
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="text"
                                    @click="handleView(scope.$index, scope.row)">
                                        View
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="text"
                                    @click="askToDelete(scope.$index, scope.row)">
                                        Delete
                                </el-button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="invoicePagination"
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
        name: 'InvoiceList',
        mixins: [paginate],
        data() {
            return {
                invoices: [],
                invoicePagination: [],
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
            this.getInvoices();
        },
        filters: {
            addComma(value) {
                if(value) {
                    value = parseFloat(value).toFixed(2)
                    return 'P ' +value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

                return 'P 0.00';
            }
        },
        methods: {
            async getInvoices() {
                try {
                    this.loading = true;
                    let params = {
                        current_size: this.current_size,
                        current_page: this.current_page,
                        search: this.search,
                    };
                    const res = await this.$API.Invoice.getInvoices(params);
                    this.invoices = res.data.data
                    this.invoicePagination = res.data.data
                    this.loading = false;
                } catch (error) {
                    console.log(error);
                }
            },
            addNew() {
                this.$router.push({name: 'Create Invoice'})
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
                    await this.$API.Invoice.deleteInvoice(data.id)
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Deleted',
                        type: 'success'
                    });
                    this.invoices.splice(index, 1)
                } catch (error) {
                    console.log(error);
                }
            },
            handleEdit(index, data) {
                this.$router.push({name: 'Update Invoice', params: {id: data.id, model: data, mode: 'update'} })
            },
            handleView(index, data) {
                this.$router.push({name: 'Invoice View', params : {id : data.id, model : data } })
            },
            handleSizeChange(val) {
                this.current_size = val;
                this.getInvoices();
            },
            handleCurrentChange(val) {
                this.current_page = val;
                this.getInvoices();
            },
            applySearch() {
                this.getInvoices();
            },
        },
        watch: {
            search(val) {
                if( val == '') {
                    this.getInvoices();
                }
            }
        }
    }
</script>
