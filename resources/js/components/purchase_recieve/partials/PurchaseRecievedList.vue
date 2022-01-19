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
                    :data="purchaseRecievedData"
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
                            prop="purchase_order_form.purchase_order_reference_no"
                            label="PO Ref No."
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Status"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row | filterStatus}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            prop="quantity"
                            label="Received Quantity"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Remaining Quantity"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row | remaining}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Total"
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.row | totalQuantity}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="primary"
                                @click="handleView(scope.$index, scope.row)">View</el-button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="purchaseRecievedPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog title="Update Received" width="35%"  :visible.sync="dialogFormVisible">
            <purchase-received-form :mode="mode" :model="model" ></purchase-received-form>
        </el-dialog>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'PurchaseRecievedList',
    mixins: [paginate],
    data() {
        return {
            purchaseRecievedData: [],
            purchaseRecievedPagination: [],
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
        this.getReceived();
        this.$EventDispatcher.listen('ADD_NEW_PURCHASE_RECEIVED', data => {
            this.mode = '';
            let received = this.purchaseRecievedData.filter(item => item.purchase_order_form_id == data.purchase_order_form_id);
            if(received.length > 0) {
                this.purchaseRecievedData.forEach(item => {
                    if(item.purchase_order_form_id == data.purchase_order_form_id) {
                        for(let key in data) {
                            item[key] = data[key];
                        }
                    }
                });
            }
            else {
                this.purchaseRecievedData.unshift(data);
            }
        });

        this.$EventDispatcher.listen('UPDATE_PURCHASE_RECEIVED', data => {
            this.purchaseRecievedData.forEach(pr => {
                if(pr.id == data.id) {
                    for(let key in data) {
                        pr[key] = data[key];
                    }
                }
            })
            this.dialogFormVisible = false;
        })
    },
    methods: {
        async getReceived() {
            try {
                this.loading = true;
                let params = {
                        current_size: this.current_size,
                        current_page: this.current_page,
                        search: this.search,
                    };

                const res = await this.$API.PurchaseReceived.getReceived(params);
                this.purchaseRecievedData = res.data.data
                this.purchaseRecievedPagination = res.data
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleEdit(index, data) {
            this.dialogFormVisible = true;
            this.mode = 'update',
            this.model = {...data}
        },
        handleView(index, data) {
            this.$router.push({
                name: 'Purchase Received View',
                params: {id : data.purchase_order_form_id, data : data}
            })
        },
        askToDelete(index, data) {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deletePurchaseReceived(index, data);
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deletePurchaseReceived(index, data) {
            try {
                await this.$API.PurchaseReceived.deletePurchaseReceived(data.id);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.purchaseRecievedData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getReceived();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getReceived();
        },
        applySearch() {
            this.getReceived();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getReceived();
            }
        }
    },
    filters: {
        remaining(value) {
            let totalQuantity = 0;

            value.purchase_order_items.forEach(item => {
                totalQuantity  = totalQuantity + item.quantity;
            });

            return totalQuantity - value.quantity
        },
        totalQuantity(value) {
            let totalQuantity = 0;

            value.purchase_order_items.forEach(item => {
                totalQuantity  = totalQuantity + item.quantity;
            });

            return totalQuantity
        },

        filterStatus(value) {
            let totalQuantity = 0;

            value.purchase_order_items.forEach(item => {
                totalQuantity  = totalQuantity + item.quantity;
            });

            let valueData = totalQuantity - value.quantity
            return valueData <= 0 ? 'Complete' : 'Incomplete'
        }
    }
}
</script>
