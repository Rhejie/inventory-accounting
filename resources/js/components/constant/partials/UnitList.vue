<template>
    <div>
        <el-card class="box-card" shadow="never" >
            <div class="text item">
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="unitsData"
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
                    :pagination="unitsPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="mode == 'create' ? 'Add Unit' : 'Update Unit'" width="35%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <unit-form :mode="mode" :model="model"></unit-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'UnitList',
    mixins: [paginate],
    data() {
        return {
            unitsData: [],
            unitsPagination: [],
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
        this.getUnits();

        this.$EventDispatcher.listen('NEW_UNIT', data => {
            this.unitsData.unshift(data)
            this.dialogFormVisible = false
            this.mode = ''
            this.model = {}
        })

        this.$EventDispatcher.listen('UPDATE_UNIT', data => {
            this.unitsData.forEach(tax => {
                if(tax.id == data.id) {
                    for(let key in data) {
                        tax[key] = data[key]
                    }
                }
            })
            this.dialogFormVisible = false
        })
    },
    methods: {
        async getUnits() {
            try {
                this.loading = true;
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };

                const res = await this.$API.Constant.getUnits(params);
                this.unitsData = res.data.data
                this.unitsPagination = res.data
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        addNew() {
            this.dialogFormVisible = true;
            this.mode = 'create';
            this.model = {}
        },
        handleEdit(index, data) {
            this.model = {...data};
            this.mode = 'update';
            this.dialogFormVisible = true;
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
                await this.$API.Constant.deleteUnit(data.id)
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.unitsData.splice(index, 1)
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.mode = ''
            this.$EventDispatcher.fire('handleCLoseConsumbleSupply')
            done();
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getUnits();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getUnits();
        },
        applySearch() {
            this.getUnits();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getUnits();
            }
        }
    }
}
</script>
