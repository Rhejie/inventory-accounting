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
                    :data="transferData"
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
                            label="From Account"
                            prop="from_acount.bank_name"
                            show-overflow-tooltip
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{ scope.row.from_account.bank_name}} - {{ scope.row.from_account.holder_name}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="To Account"
                            prop="to_account.bank_name"
                            show-overflow-tooltip
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{ scope.row.to_account.bank_name}} - {{ scope.row.to_account.holder_name}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Amount"
                            prop="amount"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.amount | addComma}}
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
                            fixed="right"
                            width="120"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                    size="mini"
                                    v-if="scope.$index === 0"
                                    type="text"
                                    @click="handleEdit(scope.$index, scope.row)">
                                        Edit
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="text"
                                    v-if="scope.$index === 0"
                                    @click="askToDelete(scope.$index, scope.row)">
                                        Delete
                                </el-button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="transferPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create' ? 'Add Transfer Account' : 'Update Transfer Account'" width="55%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <bank-transfer-form :mode="mode" :model="model"></bank-transfer-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'BankTransferList',
    mixins: [paginate],
    data() {
        return {
            transferData: [],
            transferPagination: [],
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
        this.getTransfers();
        this.$EventDispatcher.listen('NEW_TRANSFER', data => {
            this.dialogFormVisible = false;
            this.mode = ''
            this.model = {}
            this.transferData.unshift(data);
        })
        this.$EventDispatcher.listen('UPDATE_TRANSFER', data => {
            this.transferData.forEach(transfer => {
                if(transfer.id == data.id) {
                    for(let key in data) {
                        transfer[key] = data[key];
                    }
                }
            })
            this.dialogFormVisible = false;
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
        async getTransfers() {
            try {
                this.loading = true
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.Bank.getTransfers(params)
                this.transferData = res.data.data
                this.transferPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        addNew() {
            this.dialogFormVisible = true;
            this.mode = 'create'
            this.model = {}
        },
        handleClose(done) {
            this.mode = ''
            this.model = {}
            this.$EventDispatcher.fire('CLOSE_TRANSFER')
            done();
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true;
            this.mode = 'update';
            this.model = {...data}
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
                await this.$API.Bank.deleteTransfer(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.transferData.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getTransfers();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getTransfers();
        },
        applySearch() {
            this.getTransfers();
        },
    },
    watch: {
        search(val) {
            if( val == '' ) {
                this.getTransfers();
            }
        }
    }
}
</script>
