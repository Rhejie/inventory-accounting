<template>
    <div>
        <el-button type="primary" size="mini" @click="addConsumable">Add Consumable</el-button>
        <el-input
            size="mini"
            placeholder="Search here....."
            style="width:300px; float:right"
            @keyup.enter.native="applySearch"
            v-model="search">
        </el-input>
        <el-table
            :data="requestMaterialConsumableData"
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
                    prop="consumable_supply.item_code"
                    label="Item Code"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="consumable_supply.item_name"
                    label="Item Name"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="consumable_supply.unit_of_measure"
                    label="Unit of Measure"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="date_requested"
                    label="Date Requested"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="quantity"
                    label="Quantity"
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
            :pagination="requestMaterialConsumablePagination"
            :total="filters.total"
            @handleSizeChange="handleSizeChange"
            @handleCurrentChange="handleCurrentChange">
        </global-pagination>

        <el-dialog :title="mode == 'create' ? 'Add Consumable': 'Update Consumable'" width="35%"  :visible.sync="dialogFormVisibleUpdate"  :before-close="handleClose">
            <request-material-consumable-form :id="id" :mode="mode" :model="model" :date-requested="dateRequested" :projectID="projectID" ></request-material-consumable-form>
        </el-dialog>

        <el-dialog :title="mode == 'create' ? 'Add Consumable': 'Update Consumable'" width="90%"  :visible.sync="dialogFormVisible"  :before-close="handleCloseAdd">
            <request-material-consumable-form-multiple :id="id" :date-requested="dateRequested" :projectID="projectID" ></request-material-consumable-form-multiple>
        </el-dialog>

    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'RequestMaterialConsumableSupply',
    mixins: [paginate],
    props: {
        id: null,
        dateRequested: null,
        projectID: null
    },
    data() {
        return {
            requestMaterialConsumableData: [],
            requestMaterialConsumablePagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            dialogFormVisibleUpdate: false,
            dialogFormVisible: false,
            mode: '',
            model: {}
        }
    },
    created() {
        this.$EventDispatcher.listen('NEW_REQUEST_MATERIAL_CONSUMABLE', data => {
            data.forEach(d => {
                this.requestMaterialConsumableData.unshift(d);
            });
            this.dialogFormVisible = false;
            this.mode = ''
        });

        this.$EventDispatcher.listen('UPDATE_REQUEST_MATERIAL_CONSUMABLE', data => {
            this.requestMaterialConsumableData.forEach(con => {
                if(con.id == data.id) {
                    for(let key in data) {
                        con[key] = data[key];
                    }
                }
            });
            this.dialogFormVisibleUpdate = false
        });

        this.getRequestConsumable();
    },
    methods: {
        async getRequestConsumable() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.RequestMaterial.getRequestConsumable(this.id, params);
                this.requestMaterialConsumableData = res.data.data;
                this.requestMaterialConsumablePagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        addConsumable() {
            this.dialogFormVisible = true;
            this.mode = 'create';
        },
        handleEdit(index, data) {
            this.dialogFormVisibleUpdate = true;
            this.mode = 'update';
            this.model = {...data}
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteConsumableSupply(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteConsumableSupply(index, data) {
            try {
                await this.$API.RequestMaterial.deleteConsumableSupply(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.requestMaterialConsumableData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getRequestConsumable();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getRequestConsumable();
        },
        applySearch() {
            this.getRequestConsumable();
        },
        handleClose(done) {

            this.$confirm('Are you sure to close?')
            .then(_ => {
                this.mode = ''
                    this.$EventDispatcher.fire('handleCloseRMC')
                done();
            })
            .catch(_ => {});
        },
        handleCloseAdd(done) {
            this.$confirm('Are you sure want to close?')
            .then(_ => {
                this.mode = ''
                this.$EventDispatcher.fire('handleCloseRMCMultiple')
                done();
            })
            .catch(_ => {});
        }
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getRequestConsumable();
            }
        }
    }
}
</script>
