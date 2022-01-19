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
                    :data="supplierData"
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
                            prop="name"
                            label="Name"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="contact_no"
                            label="Contact Number"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="email"
                            label="Email"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="contact_person"
                            label="Contact Person"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="delivery_time"
                            label="Delivery Time"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="address"
                            label="Address"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="text"
                                @click="handleView(scope.$index, scope.row)">View</el-button>
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
                    :pagination="supplierPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog title="Update Supplier" width="75%"  :visible.sync="dialogFormVisible">
            <supplier-form :mode="mode" :model="model"></supplier-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    nmae: 'SupplierList',
    mixins: [paginate],
    props: {

    },
    data() {
        return {
            supplierData: [],
            supplierPagination: [],
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
        this.getSuppliers();
        this.$EventDispatcher.listen('ADD_NEW_SUPPLIER', data => {
            this.supplierData .unshift(data);
        });
        this.$EventDispatcher.listen('UPDATE_SUPPLIER', data => {
            this.supplierData.forEach(sup => {
                if(sup.id == data.id) {
                    for(let key in data) {
                        sup[key] = data[key]
                    }
                }
            });
            this.dialogFormVisible = false;
        })
    },
    methods: {
        async getSuppliers() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.SupplierManagement.getSuppliers(params);
                this.supplierData = res.data.data;
                this.supplierPagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleView(index, data) {
            this.$router.push({
                name: 'Supplier Management Details',
                params: {id: data.id, data}
            });
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true;
            this.mode = 'update'
            this.model = {...data};
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteSupplier(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteSupplier(index, data) {
            try {
                await this.$API.SupplierManagement.deleteSupplier(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.supplierData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getSuppliers();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getSuppliers();
        },
        applySearch() {
            this.getSuppliers();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getSuppliers();
            }
        }
    }
}
</script>
