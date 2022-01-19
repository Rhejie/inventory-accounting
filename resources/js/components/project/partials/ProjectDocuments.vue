<template>
    <div>
        <div class="documents_header">
            <button class="btn btn-success font-weight-bold mr-2 document_upload_button" @click="addDocument">
                <i class="la la-file-import"></i> Upload
            </button>
            <el-input
                size="small"
                placeholder="Search here....."
                style="width:300px; float:right"
                @keyup.enter.native="applySearch"
                v-model="search">
            </el-input>
        </div>
        <el-table
            v-loading="loadingDocuments"
            :data="projectDocuments"
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
                    label="File Name"
                    :sortable="true">
                        <template slot-scope="scope">
                            <!--el-button @click="viewFile(scope.row)" type="text"> {{scope.row.file_name}}</!--el-button> -->
                            <a type="text" :href="`/view-project-document?file=${scope.row.file}`" target="_blank">{{scope.row.file_name}}</a>
                        </template>
                </el-table-column>
                <el-table-column
                    prop="remarks"
                    label="Remarks"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="type"
                    label="Type"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="created_at"
                    :sortable="true"
                    label="Date Created">
                </el-table-column>
                <el-table-column
                    label="Action">
                    <template slot-scope="scope">
                        <el-button
                        size="mini"
                        type="text"
                        @click="handleEdit(scope.$index, scope.row)">Edit</el-button>
                        <el-button
                        size="mini"
                        type="text"
                        @click="askToDelete(scope.$index, scope.row)">Delete</el-button>
                    </template>
                </el-table-column>
        </el-table>

        <global-pagination
            :current_page="current_page"
            :current_size="current_size"
            :pagination="projectDocumentsPagination"
            :total="filters.total"
            @handleSizeChange="handleSizeChange"
            @handleCurrentChange="handleCurrentChange">
        </global-pagination>

        <el-dialog :title="mode == 'create'? 'Add File': 'Update File'" width="40%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <project-document-form :id="id" @addNewDocument="addNewDocument" :edit-data="editData" :mode='mode' ></project-document-form>
        </el-dialog>
    </div>
</template>
<script>
import pagination from  "../../../mixin/pagination";
export default {
    name: "ProjectDocuments",
    mixins: [pagination],
    props: {
        id: null
    },
    data() {
        return {
            projectDocuments: [],
            dialogFormVisible: false,
            mode: 'create',
            loadingDocuments: true,
            current_page: 1,
            current_size: 25,
            projectDocumentsPagination: [],
            search: null,
            filters: {
                search: null,
            },
            FileDialogFormVisible: false,
            fileData: {},
            editData: {}
        }
    },
    created() {
        this.getProjectDocuments();
        this.$EventDispatcher.listen('UPDATED_PROJECT_DOCUMENT', data => {
            this.projectDocuments.forEach(doc => {
                if(doc.id == data.id) {
                    for(let key in data) {
                        doc[key] = data[key];
                    }
                }
                this.dialogFormVisible = false;
            });
        });
    },
    methods: {
        async getProjectDocuments(){
            this.loadingDocuments = true;
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const response = await this.$API.Project.getProjectDocuments(this.id, params);
                this.projectDocuments = response.data.data;
                this.projectDocumentsPagination = response.data;
                this.filters.total = response.data.total;
                this.loadingDocuments = false;
            } catch (error) {
                console.log(error);
            }
        },
        addNewDocument(data) {
            this.projectDocuments.unshift(data)
            this.mode = 'create';
            this.dialogFormVisible = false;
            this.filters.total++;
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getProjectDocuments();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getProjectDocuments();
        },
        applySearch() {
            this.getProjectDocuments();
        },
        viewFile(data) {
            this.$router.push({
                name: 'View Document',
                params: {fileData: data, id: this.id}
            })
        },
        handleEdit(index, data) {
            this.editData = {...data};
            this.mode = 'update';
            this.dialogFormVisible = true;
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteProject(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteProject(index, data) {
            try {
                await this.$API.Project.deleteDocument(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.projectDocuments.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        addDocument() {
            this.mode = 'create';
            this.dialogFormVisible = true;
        },
        handleClose(done) {
            this.mode = ''
            this.$EventDispatcher.fire('handleCloseProjectDoc')
            done();
        }
    },
    watch: {
        search(val) {
            if(val == '') {
                this.getProjectDocuments();
            }
        }
    }
}
</script>
<style>
    .documents_header {

    }
</style>
