<template>
    <div>
        <el-input
            size="mini"
            placeholder="Search here....."
            style="width:300px; float:right"
            @keyup.enter.native="applySearch"
            v-model="search">
        </el-input>
        <el-table
            :data="invoicePaymentData"
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
                    show-overflow-tooltip
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
                    show-overflow-tooltip
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
                    fixed="right"
                    width="100"
                    label="Action">
                    <template slot-scope="scope">
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
            :pagination="invoicePaymentPagination"
            :total="filters.total"
            @handleSizeChange="handleSizeChange"
            @handleCurrentChange="handleCurrentChange">
        </global-pagination>
        <el-dialog :title="mode == 'create' ? 'Add Account' : 'Update Account'" width="55%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <bank-account-form :mode="mode" :model="model"></bank-account-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'InvoicePaymentList',
    mixins: [paginate],
    props: {
        id: null,
    },
    data() {
        return {
            invoicePaymentData: [],
            invoicePaymentPagination: [],
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
        if(this.id) {
            this.current_size = 10
        }

        this.$EventDispatcher.listen('NEW_PAYMENT', data => {
            this.invoicePaymentData.unshift(data)
        })
    },
    filters: {
        addComma(value) {
            if(value) {
                value = parseFloat(value).toFixed(2)
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
                const res = await this.$API.InvoicePayment.getPayments(this.id, params);
                this.invoicePaymentData = res.data.data
                this.invoicePaymentPagination = res.data
                this.loading = false;
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
                await this.$API.InvoicePayment.deletePayment(data.id)
                this.$EventDispatcher.fire('DELETE_PAYMENT', data.amount)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.invoicePaymentData.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.dialogFormVisible = false;
            this.mode = ''
            this.model = {}
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
