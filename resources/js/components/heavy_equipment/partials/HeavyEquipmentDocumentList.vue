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
                    :data="equipmentDocuments"
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
                                <a type="text" :href="`/view-heavy-equipment-document?file=${scope.row.attached_file}`" target="_blank">{{scope.row.file_name}}</a>
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
                    :pagination="equipmentDocumentsPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>

        <el-dialog :title="mode == 'create'? 'Add Equipment Documents': 'Update Equipment Documents'" width="35%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <add-equipment-document-form
                :id="id"
                @AddEquimentDocument="AddEquimentDocument"
                :mode="mode"
                :editData="editData">
            </add-equipment-document-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'HeavyEquipmentDocumentList',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return  {
            equipmentDocuments: [],
            equipmentDocumentsPagination: [],
            dialogFormVisible: false,
            current_page: 1,
            current_size: 25,
            search: null,
            filters: {
                search: null,
            },
            mode: 'create',
            loading: false,
            editData: {},
            isNewDocument: false,
        }
    },
    created() {
        this.getDoucments();

        this.$EventDispatcher.listen('HEAVY_EQUIPMENT_DOCUMENT_UPDATE', data => {
            this.equipmentDocuments.forEach(eq => {
                if(eq.id == data.id) {
                    for(let key in data) {
                        eq[key] = data[key]
                    }
                }
            });

            this.dialogFormVisible = false;
        })
    },
    methods: {
        uploadDocument() {
            this.dialogFormVisible = true
            this.mode = 'create'
            this.editData = {}
        },
        async getDoucments() {
            this.loading = true;
            try {
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.HeavyEquipment.getEquipmentDocuments(this.id, params);
                this.equipmentDocuments = res.data.data;
                this.equipmentDocumentsPagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        AddEquimentDocument(data) {
            this.equipmentDocuments.unshift(data);
            this.dialogFormVisible = false;
            this.mode = 'create'
            this.editData = {}
        },
        handleEdit(index, data) {
            this.editData = {...data}
            this.dialogFormVisible = true
            this.mode = 'update'
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
                await this.$API.HeavyEquipment.deleteDocument(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.equipmentDocuments.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        applySearch() {
            this.getDoucments();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getDoucments();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getDoucments();
        },
        handleClose(done) {
            this.mode = ''
            this.editData = {}
            this.$EventDispatcher.fire('handleCloseHEDOC')
            done();
        }
    },
    watch: {
        search(val) {
            if(val == '') {
                this.getDoucments();
            }
        }
    }
}
</script>
