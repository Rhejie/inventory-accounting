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
                    :data="credits"
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
                            prop="invoice.ref_number"
                            label="Invoice No.."
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
                            prop="date"
                            label="Date"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="description"
                            label="description"
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
                    :pagination="creditsPaginations"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create'? 'Add Credit Note' : 'Update Credit Note' " width="45%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <credit-note-form :mode="mode" :model="model"></credit-note-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'CreditNoteList',
    mixins: [paginate],
    data() {
        return {
            credits: [],
            creditsPaginations: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            mode: '',
            model: {},
            dialogFormVisible: false,
            mode: '',
            model: {},
            dialogFormVisible: false,
        }
    },
    created() {
        this.getCredits()
        this.$EventDispatcher.listen('NEW_CREDIT', data => {
            this.credits.unshift(data)
            this.dialogFormVisible = false
        })
        this.$EventDispatcher.listen('UPDATE_CREDIT', data => {
            this.credits.forEach(credit => {
                if(credit.id == data.id) {
                    for(let key in data ) {
                        credit[key] = data[key];
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
        },

        file(value) {
            if(value.attachable) {
                return value.attachable.file_name
            }
        }
    },
    methods: {
        async getCredits() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.CreditNote.getCredits(params);
                this.credits = res.data.data
                this.creditsPaginations = res.data
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        addNew() {
            this.mode = 'create'
            this.model = {}
            this.dialogFormVisible = true
        },
        handleEdit(index, data) {
            this.mode = 'update'
            this.model = {...data}
            this.dialogFormVisible = true
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
                await this.$API.CreditNote.deleteCredit(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.credits.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.mode = ""
            this.model = {}
            this.$EventDispatcher.fire('CLOSE_CREDIT')
            done();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getCredits();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getCredits();
        },
        applySearch() {
            this.getCredits();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getCredits();
            }
        }
    }
}
</script>
