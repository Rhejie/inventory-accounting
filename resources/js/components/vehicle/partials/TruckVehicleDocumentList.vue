<template>
    <div>
        <el-card class="box-card">
            <div class="text item">
                <div class="equipment_documents_header">
                    <el-button type="primary" @click="uploadDocument" size="mini">
                        Upload
                    </el-button>
                    <el-input
                        size="mini"
                        placeholder="Search here....."
                        style="width:300px; float:right"
                        @keyup.enter.native="applySearch"
                        v-model="search">
                    </el-input>
                </div>
                <el-table
                    :data="documentsData"
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
                            label="Attached File"
                            :sortable="true">
                            <template slot-scope="scope">
                                <a type="text" :href="`/view-truck-vehicle-document?file=${scope.row.attached_file}`" target="_blank">{{scope.row.file_name}}</a>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="file_type"
                            label="File Type"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="created_at"
                            label="Created At"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                @click="handleEdit(scope.$index, scope.row)">Edit</el-button>
                                <el-button
                                size="mini"
                                type="danger"
                                @click="askToDelete(scope.$index, scope.row)">Delete</el-button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="documentsPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create'? 'Add Documents': 'Update Documents'" width="35%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <truck-vehicle-document-form :id="id" :mode="mode" :model="model"></truck-vehicle-document-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'TruckVehicleDocumentList',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return {
            loading: false,
            documentsData: [],
            documentsPagination: [],
            current_page: 1,
            current_size: 25,
            search: null,
            mode: '',
            dialogFormVisible : false,
            model: {}
        }
    },
    created() {
        this.getDocuments();
        this.$EventDispatcher.listen('ADD_NEW_TRUCk_VEHICLE_DOCUMENt', data => {
            this.documentsData.unshift(data);
            this.dialogFormVisible = false;
        });

        this.$EventDispatcher.listen('UPDATE_TRUCk_VEHICLE_DOCUMENT', data => {
            this.documentsData.forEach(doc => {
                if(doc.id == data.id) {
                    for(let key in data) {
                        doc[key] = data[key];
                    }
                }
            });
            this.dialogFormVisible = false;
        });
    },
    methods: {
        async getDocuments() {
            try {

                this.loading = true

                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };

                const res = await this.$API.TruckVehicle.getDocuments(this.id, params);
                this.documentsData = res.data.data;
                this.documentsPagination = res.data;

                this.loading = false;

            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getDocuments();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getDocuments();
        },
        applySearch() {
            this.getDocuments();
        },
        uploadDocument() {
            this.dialogFormVisible = true
            this.mode = 'create'
        },
        handleEdit(index, data) {

            this.mode = 'update';
            this.model = data;
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
                await this.$API.TruckVehicle.deleteDocument(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.documentsData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.mode = ''
            this.model = {}
            this.$EventDispatcher.fire('handleCloseTruckDoc')
            done();
        }
    },
    watch: {
        search(val) {
            if(!val) {
                this.getDocuments();
            }
        }
    }
}
</script>
