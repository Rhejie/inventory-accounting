<template>
    <div>
        <el-table
            :data="categoriesData"
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
                    prop="asset_types.name"
                    label="Type"
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
                        @click="handleDelete(scope.$index, scope.row)">Delete</el-button>
                    </template>
                </el-table-column>
        </el-table>
        <el-dialog title="Update Category" width="35%"  :visible.sync="dialogFormVisible">
            <!-- <type-inventory-form :model="model" :mode="mode"></type-inventory-form> -->
            <category-inventory-form :mode="mode" :model="model"></category-inventory-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'CategoryInventoryList',
    props: {
        categoriesData: [],
        loading: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            dialogFormVisible: false,
            mode: '',
            model: {}
        }
    },
    created() {
        this.$EventDispatcher.listen('UPDATED_CATEGORY_INVENTORY', data => {
            this.dialogFormVisible = false;
        });
    },
    methods: {
        handleEdit(index, data) {
            // this.$EventDispatcher.fire('EDIT_DATA_VALUE', data);
            this.dialogFormVisible = true;
            this.model = {...data};
            this.mode = 'update'
        },
        handleDelete(index, data) {
            let value = {
                index,
                data
            }
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.$EventDispatcher.fire('DELETE_CATEGORY_INVENTORY', value);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });

        }
    }
}
</script>
