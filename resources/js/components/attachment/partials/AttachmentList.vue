<template>
    <div>
        <el-table
            :data="attachments"
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
                    prop="created_at"
                    label="Date Uploaded"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="file_name"
                    label="File Name"
                    show-overflow-tooltip
                    :sortable="true">
                        <template slot-scope="scope">
                            <a type="text" :href="`/attachment/attachment-file?file=${scope.row.file}&path=${scope.row.path}`" target="_blank">{{scope.row.file_name}}</a>
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
        <el-dialog width="100%" :visible.sync="dialogFormVisibleAttachmentFile">
            <file-viewer :model="model"></file-viewer>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'AttachmentList',
    props: {
        type: null,
        attachmentId: null,
    },
    data() {
        return {
            attachments: [],
            loading: false,
            dialogFormVisibleAttachmentFile: false,
            model: {}
        }
    },
    created() {
        this.$EventDispatcher.listen('NEW_ATTACHMENT', data => {
            this.attachments.push(data)
        })
    },
    mounted() {
        this.getAttachments();
    },
    methods: {
        async getAttachments() {
            try {
                this.loading = true;
                let params = {
                    attachable_id: this.attachmentId,
                    type: this.type,
                }
                const res = await this.$API.Attachment.getAttachments(params);
                this.attachments = res.data
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
                this.$EventDispatcher.fire('DELETE_NOTE', params)
                this.attachments.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        showFile(data) {
            this.model = data
            this.dialogFormVisibleAttachmentFile = true;
        }
    },
    watch: {
        attachmentId(newVal, oldVal) {
            if(newVal != oldVal) {
                this.getAttachments();
            }
        }
    }
}
</script>
