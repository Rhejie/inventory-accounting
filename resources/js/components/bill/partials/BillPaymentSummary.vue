<template>
    <div>
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
                    :sortable="true">
                        <template slot-scope="scope">
                            {{scope.row.account.bank_name}} {{scope.row.account.holder_name}}
                        </template>
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
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'BillPaymentSummary',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return {
            payments: [],
            paymentsPagination: [],
            loading: false,
            current_page: 1,
            current_size: 10,
            search: null,
            mode: '',
            model: {},
        }
    },
    created() {
        this.getPayments();

        this.$EventDispatcher.listen('NEW_PAYMENT', data => {
            this.payments.unshift(data)
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

                const res = await this.$API.BillPayment.getPayments(this.id, params)
                this.payments = res.data.data
                this.paymentsPagination = res.data
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
                await this.$API.BillPayment.deletePayment(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });

                this.$EventDispatcher.fire('DELETE_PAYMENT', data.amount)
                this.payments.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
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
