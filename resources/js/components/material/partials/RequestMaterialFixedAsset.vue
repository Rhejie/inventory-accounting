<template>
    <div>
        <el-button type="primary" size="mini" @click="addFixed">Add Fixed Asset</el-button>
        <el-input
            size="mini"
            placeholder="Search here....."
            style="width:300px; float:right"
            @keyup.enter.native="applySearch"
            v-model="search">
        </el-input>
        <el-table
            :data="requestMaterialFixedAssetData"
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
                    prop="fixed_asset.assetable.brand_name"
                    label="Brand Name"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="type"
                    label="Fixed Asset type"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="date_requested"
                    label="Requested"
                    :sortable="true">
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
            :pagination="requestMaterialFixedAssetPagination"
            :total="filters.total"
            @handleSizeChange="handleSizeChange"
            @handleCurrentChange="handleCurrentChange">
        </global-pagination>
        <el-dialog :title="mode == 'create' ? 'Add Fixed Asset': 'Update Fixed Asset'" width="35%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <request-material-fixed-asset-form :mode="mode" :model="model" :id="id" :date-requested="dateRequested"></request-material-fixed-asset-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'RequestMaterialFixedAsset',
    mixins: [paginate],
    props: {
        id: null,
        dateRequested: null
    },
    data() {
        return {
            requestMaterialFixedAssetData: [],
            requestMaterialFixedAssetPagination: [],
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
        this.$EventDispatcher.listen('NEW_REQUEST_FIXED_ASSET', data => {
            this.requestMaterialFixedAssetData.unshift(data);
            this.dialogFormVisible = false;
            this.mode = ''
        });
        this.$EventDispatcher.listen('UPDATE_REQUEST_FIXED_ASSET', data => {
            this.requestMaterialFixedAssetData.forEach(fixed => {
                if(fixed.id == data.id) {
                    for(let key in data) {
                        fixed[key] = data[key]
                    }
                }
            });
            this.dialogFormVisible = false
        });

        this.getRequest();
    },
    methods: {
        async getRequest() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.RequestMaterial.getRequestFixedAsset(this.id, params);
                this.requestMaterialFixedAssetData = res.data.data;
                this.requestMaterialFixedAssetPagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        addFixed() {
            this.mode = 'create';
            this.dialogFormVisible = true;
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true;
            this.model = {...data}
            this.mode = 'update'
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteFixedAsset(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteFixedAsset(index, data) {
            try {
                await this.$API.RequestMaterial.deleteFixedAsset(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.requestMaterialFixedAssetData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getRequest();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getRequest();
        },
        applySearch() {
            this.getRequest();
        },
        handleClose(done) {
            this.mode = ''
            this.$EventDispatcher.fire('handleCloseRMF')
            done();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getRequest();
            }
        }
    }
}
</script>
