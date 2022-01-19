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
                    :data="payments"
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
                            prop="amount"
                            label="Amount"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.amount | addComma}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Account"
                            prop="account"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.account.bank_name}} - {{scope.row.account.holder_name}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            prop="supplier.name"
                            label="Supplier"
                            show-overflow-tooltip
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
                            prop="reference"
                            label="Reference"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="description"
                            label="Description"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="attachable"
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
                            fixed="right"
                            width="150"
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
                    :pagination="paymentsPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create' ? 'Add Payment' : 'Update Payment'" width="55%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <payment-form :mode="mode" :model="model"></payment-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'PaymentList',
    mixins: [paginate],
    data() {
        return {
            payments: [],
            paymentsPagination: [],
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
        this.getPayments();
        this.$EventDispatcher.listen('NEW_PAYMENT', data => {
            this.payments.unshift(data)
        })

        this.$EventDispatcher.listen('UPDATE_PAYMENT', data => {
            this.payments.forEach(pay => {
                if(pay.id == data.id) {
                    for(let key in data) {
                        pay[key] = data[key];
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
        async getPayments() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.Payment.getPayments(params);
                this.payments = res.data.data
                this.paymentsPagination = res.data.data
                this.loading = false
            } catch (error) {
                console.log(error);
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
                await this.$API.Payment.deletePayment(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.payments.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleEdit(index, data) {
            this.mode = 'update'
            this.model = {...data}
            this.dialogFormVisible = true
        },
        handleClose(done) {
            this.mode = ''
            this.model = {}
            this.$EventDispatcher.fire('CLOSE_PAYMENT')
            done();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getPayments();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getPayments();
        },
        applySearch() {
            this.getPayments();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getPayments();
            }
        }
    }
}
</script>
