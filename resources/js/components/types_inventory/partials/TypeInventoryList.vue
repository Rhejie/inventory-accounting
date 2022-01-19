<template>
    <div>
        <el-table
            :data="typesData"
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
                    prop="resource_type"
                    label="Resource Type"
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
        <el-dialog title="Update Type" width="35%"  :visible.sync="dialogFormVisible">
            <type-inventory-form :model="model" :mode="mode"></type-inventory-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'typeInventoryList',
    props: {
        typesData: {},
        loading: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            dialogFormVisible: false,
            model: {},
            mode: ''
        }
    },
    created() {
        this.$EventDispatcher.listen('UPDATED_TYPE_INVENTORY', data => {
            this.dialogFormVisible = false;
        })
    },
    methods: {
        handleEdit(inde, data) {
            // this.$EventDispatcher.fire('EDIT_DATA_VALUE', data);
            this.dialogFormVisible = true;
            this.model = {...data}
            this.mode = 'update'
        },
        handleDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    let value = {
                        index,
                        data
                    }
                    this.$EventDispatcher.fire('TYPE_DELETE_DATA', value);
                    this.$message({
                        type: 'success',
                        message: 'Delete completed'
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        }
    },
}
</script>
