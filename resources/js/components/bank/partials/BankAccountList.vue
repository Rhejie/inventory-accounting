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
                    :data="accountData"
                    v-loading="loading"
                    style="width: 100%">
                        <el-table-column type="expand">
                            <template slot-scope="props">
                                <p>Address: {{ props.row.bank_address }}</p>
                            </template>
                        </el-table-column>
                        <el-table-column
                            width="70"
                            label="No."
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.$index + 1}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            prop="holder_name"
                            show-overflow-tooltip
                            label="Name"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="bank_name"
                            show-overflow-tooltip
                            label="Bank"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="account_number"
                            label="Account"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="opening_balance"
                            label="Balance"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row.opening_balance | addComma}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            prop="contact_number"
                            label="Contact No."
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
                            width="120"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                    size="mini"
                                    v-if="scope.row.id != 1 || scope.row.holder_name != 'Cash'"
                                    type="text"
                                    @click="handleEdit(scope.$index, scope.row)">
                                        Edit
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="text"
                                    v-if="scope.row.id != 1 || scope.row.holder_name != 'Cash'"
                                    @click="askToDelete(scope.$index, scope.row)">
                                        Delete
                                </el-button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="accountPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create' ? 'Add Account' : 'Update Account'" width="55%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <bank-account-form :mode="mode" :model="model"></bank-account-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'BankAccountList',
    mixins: [paginate],
    data() {
        return {
            accountData: [],
            accountPagination: [],
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
        this.getAccounts();

        this.$EventDispatcher.listen('NEW_ACCOUNT', data => {
            this.accountData.unshift(data)
            this.dialogFormVisible = false
            this.mode = ''
            this.model = {}
        })

        this.$EventDispatcher.listen('UPDATE_ACCOUNT', data => {
            this.accountData.forEach(account => {
                if(account.id == data.id) {
                    for(let key in data) {
                        account[key] = data[key]
                    }
                }
            })
            this.dialogFormVisible = false
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
        async getAccounts() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.Bank.getAccounts(params)
                this.accountData = res.data.data
                this.accountPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        addNew() {
            this.dialogFormVisible = true;
            this.mode = 'create';
            this.model = {}
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true;
            this.mode = 'update'
            this.model = {...data}
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    if(data.opening_balance != 0.00) {
                        this.$message({
                            type: 'warning',
                            message: 'This Account has balance'
                        });
                        return
                    }
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
                await this.$API.Bank.deleteAccount(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.accountData.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.$EventDispatcher.fire('CLOSE_ACCOUNT')
            done();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getAccounts();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getAccounts();
        },
        applySearch() {
            this.getAccounts();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getAccounts();
            }
        }
    }
}
</script>
