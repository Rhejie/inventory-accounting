<template>
    <div>
        <el-input
            size="mini"
            placeholder="Search here....."
            style="width:300px; float:right; margin-bottom: 10px"
            @keyup.enter.native="applySearch"
            v-model="search">
        </el-input>
        <el-table
            :data="notes"
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
                    prop="bill.bill_number"
                    label="Bill"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="supplier.name"
                    label="Supplier"
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
            :pagination="notesPagination"
            :total="filters.total"
            @handleSizeChange="handleSizeChange"
            @handleCurrentChange="handleCurrentChange">
        </global-pagination>
        <el-dialog title="Update Debit Note" width="45%" :visible.sync="dialogFormVisible">
            <debit-note-form :mode="mode" :model="model" :formBill="true"></debit-note-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'BillDebitNoteList',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return {
            notes: [],
            notesPagination: [],
            loading: false,
            current_page: 1,
            current_size: 10,
            search: null,
            mode: '',
            model: {},
            bill_id: null,
            dialogFormVisible: false,
            prev_amount: null,
        }
    },
    created() {
        this.bill_id = this.id
        this.getNotes();
        this.$EventDispatcher.listen('NEW_NOTE', data => {
            this.notes.unshift(data)
            this.dialogFormVisible = false
        })

        this.$EventDispatcher.listen('UPDATE_NOTE', data => {
            this.notes.forEach(note => {
                if(note.id == data.id) {
                    for(let key in data) {
                        note[key] = data[key]
                    }
                }
            })

            let amount = {
                prevAmount : this.prev_amount,
                newAmount : data.amount
            }

            this.$EventDispatcher.fire('NEW_DEBIT_NOTE_AMOUNT', amount)

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
        async getNotes() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.DebitNote.getNotes(this.id, params);
                this.notes = res.data.data
                this.notesPagination = res.data
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true
            this.mode = "update"
            this.model = {...data}
            this.prev_amount = data.amount
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
                await this.$API.DebitNote.deleteNote(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                let params = {
                    'index' : index,
                    data
                }
                this.$EventDispatcher.fire('DELETE_NOTE', params)
                this.notes.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getNotes();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getNotes();
        },
        applySearch() {
            this.getNotes();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getNotes();
            }
        }
    }
}
</script>
