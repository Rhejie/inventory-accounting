<template>
    <div>
        <el-table
            :data="attachments"
            v-loading="loading"
            style="width: 100%">
                <el-table-column
                    prop="file_name"
                    label="ATTACHMENTS"
                    show-overflow-tooltip
                    :sortable="true">
                        <template slot-scope="scope">
                            <a type="text" :href="`/attachment/attachment-file?file=${scope.row.file}&path=${scope.row.path}`" target="_blank">{{scope.row.file_name}}</a>
                        </template>
                </el-table-column>
                <el-table-column
                    width="70">
                    <template slot="header">
                        <el-button size="mini" type="text" @click="addAttachment">ADD</el-button>
                    </template>
                    <template slot-scope="scope">
                        <button type="button" class="btn btn-icon btn-danger btn-sm" @click="askToDelete(scope.$index, scope.row)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </template>
                </el-table-column>
        </el-table>
        <!--<global-pagination
            :current_page="current_page"
            :current_size="current_size"
            :pagination="attachmentPagination"
            :total="filters.total"
            @handleSizeChange="handleSizeChange"
            @handleCurrentChange="handleCurrentChange">
        </global-pagination> -->
        <el-dialog width="30%" title="Add Attachment" :visible.sync="dialogFormVisibleAttachmentFile" :before-close="handeCloseAttachment">
            <attachment-form :attachment-id="id" :type="type"></attachment-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'AttachmentFileList',
    mixins: [paginate],
    props: {
        id: null,
        type: null
    },
    data() {
        return {
            attachments: [],
            attachmentPagination: [],
            loading: false,
            current_page: 1,
            current_size: 5,
            search: null,
            mode: '',
            model: {},
            dialogFormVisibleAttachmentFile: false,
        }
    },
    created() {
        this.getAttachments()

        this.$EventDispatcher.listen('NEW_ATTACHMENT_BILL', data => {
            this.attachments.unshift(data)
            this.dialogFormVisibleAttachmentFile = false;
        })
    },
    methods: {
        async getAttachments() {
            try {
                this.loading = true;
                let params = {
                    attachable_id: this.id,
                    type: this.type,
                }
                const res = await this.$API.Attachment.getAttachments(params);
                this.attachments = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        addAttachment() {
            this.dialogFormVisibleAttachmentFile = true;
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
                await this.$API.Attachment.deleteAttachment(data.id, this.type)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                let params = {
                    'index' : index,
                    data
                }
                this.attachments.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handeCloseAttachment(done) {
            this.$EventDispatcher.fire('CLOSE_ATTACHMENT_FORM')
            done();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getAttachments();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getAttachments();
        },
        applySearch() {
            this.getAttachments();
        },
    },
}
</script>
