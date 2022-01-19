<template>
    <div>
        <el-card class="box-card">
            <div class="text item">
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right; margin-bottom: 10px"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    size="mini"
                    fit
                    :data="purchaseOrderData"
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
                            prop="purchase_order_reference_no"
                            label="P.O Ref. No"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="supplier.name"
                            show-overflow-tooltip
                            label="Supplier"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="project.name"
                            show-overflow-tooltip
                            label="Project"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            show-overflow-tooltip
                            label="Status"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row | statusPurchaseOrder}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="160"
                            label="Action">
                            <template slot-scope="scope">
                                <span>
                                    <el-dropdown
                                        trigger="click"
                                        @command="handleTableAction">
                                        <el-button
                                            class="text-gray"
                                            type="text"
                                            icon="fas fa-ellipsis-v">
                                        </el-button>
                                        <el-dropdown-menu slot="dropdown">
                                            <el-dropdown-item :command="{action: 'view', data: scope.row, index: scope.$index}">
                                                <span class="text-red">
                                                    <i class="far fa-eye"></i> {{ 'View' }}
                                                </span>
                                            </el-dropdown-item>
                                            <el-dropdown-item :command="{action: 'edit', data: scope.row, index: scope.$index}">
                                                <span class="text-red">
                                                    <i class="fas fa-edit"></i> {{ 'Edit' }}
                                                </span>
                                            </el-dropdown-item>
                                            <el-dropdown-item :command="{action: 'delete', data: scope.row, index: scope.$index}">
                                                <span class="text-red">
                                                    <i class="fas fa-trash-alt"></i> {{ 'Delete' }}
                                                </span>
                                            </el-dropdown-item>
                                        </el-dropdown-menu>
                                    </el-dropdown>
                                </span>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="purchaseOrderPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog title="Add Purchase Order" width="90%" :visible.sync="dialogFormVisible">
            <purchase-order-form :mode="mode" :model="model"></purchase-order-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'PurchaseOrderList',
    mixins: [paginate],
    data() {
        return {
            purchaseOrderData: [],
            purchaseOrderPagination: [],
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
        this.getPurchaseOrders();
        this.$EventDispatcher.listen('NEW_PUCHASE_ORDER', data => {
            this.purchaseOrderData.unshift(data);
        });

        this.$EventDispatcher.listen('UPDATE_PURCHASE_ORDER', data => {
            this.purchaseOrderData.forEach(order => {
                if(order.id == data.id) {
                    for(let key in data) {
                        order[key] = data[key]
                    }
                }
            });
            this.dialogFormVisible = false
        })
    },
    filters: {
        statusPurchaseOrder(value) {
            let receive = 0
            let request = 0
            let statusPO = null
            if(value.purchase_order_form_item.length > 0) {
                value.purchase_order_form_item.forEach(item => {
                    request = request + parseInt(item.quantity)
                })
                if(value.purchase_received.length > 0) {
                    value.purchase_received.forEach(item => {
                        receive  = receive + parseInt(item.received_quantity)
                    });
                    statusPO = parseInt(request) - parseInt(receive)
                    if(statusPO === 0) {
                        return 'Complete'
                    }
                    return 'Incomplete'
                }

                return 'Incomplete'
            }

            return 'Incomplete'
        }
    },
    methods: {
        async getPurchaseOrders() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.PurchaseOrder.getOrders(params);
                this.purchaseOrderData = res.data.data;
                this.purchaseOrderPagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleView(index, data) {
            this.$router.push({
                name: 'Purchase Order View',
                params: {id : data.id, data}
            })
        },
        handleEdit(index, data) {
            this.mode = 'update',
            this.model = {...data}
            this.dialogFormVisible = true
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteOrder(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteOrder(index, data) {
            try {
                await this.$API.PurchaseOrder.deleteOrder(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.purchaseOrderData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleTableAction(info) {
            if (info.action === 'delete') {
                this.askToDelete(info.index, info.data)
            }
            if (info.action === 'view') {
                this.handleView(info.index, info.data)
            }
            if (info.action === 'edit') {
                this.handleEdit(info.index, info.data)
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getPurchaseOrders();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getPurchaseOrders();
        },
        applySearch() {
            this.getPurchaseOrders();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getPurchaseOrders();
            }
        }
    }
}
</script>
<style lang="scss" scoped>
    .PO_more_item {
        padding: 5px;
    }
</style>
