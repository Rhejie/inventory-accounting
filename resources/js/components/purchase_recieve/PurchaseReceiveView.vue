<template>
     <div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                    <el-card class="box-card" shadow="never" v-loading="loadingDetails">
                        <div class="text item">
                            <el-descriptions title="Purchase Recieved Item">
                                <el-descriptions-item label-class-name="my-label" label="Purchase Ref. No">{{details.purchase_order_form.purchase_order_reference_no}}</el-descriptions-item>
                                <el-descriptions-item label-class-name="my-label" label="Material Ref. No">{{details.purchase_order_form.material_reference_no}}</el-descriptions-item>
                                <el-descriptions-item label-class-name="my-label" label="Purchase Order Date">{{ details.purchase_order_form.push_order_date }}</el-descriptions-item>
                                <el-descriptions-item label-class-name="my-label" label="Received Quantity"></el-descriptions-item>
                                <el-descriptions-item label-class-name="my-label" label="Remaining Quantity"></el-descriptions-item>
                                <el-descriptions-item label-class-name="my-label" label="Project">
                                <el-tag size="small" v-loading="loadingDetails">{{ details.purchase_order_form.project.name }}</el-tag>
                                </el-descriptions-item>
                            </el-descriptions>
                        </div>
                    </el-card>
                    <el-card class="box-card" shadow="never" v-loading="loadingItem">
                        <div class="text item">
                            <el-button type="primary" size="mini" @click="addItem">Add Received Item</el-button>
                            <el-input
                                size="mini"
                                placeholder="Search here....."
                                style="width:300px; float:right"
                                @keyup.enter.native="applySearch"
                                v-model="search">
                            </el-input>
                            <el-table
                                :data="itemReceived"
                                v-loading="loadingItem"
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
                                        prop="purchase_order_item.consumable_item.item"
                                        label="Item"
                                        :sortable="true">
                                    </el-table-column>
                                    <el-table-column
                                        label="Date Received"
                                        :sortable="true">
                                            <template slot-scope="scope">
                                                {{$df.formatDate(scope.row.date_received, "YYYY-MMM-DD")}}
                                            </template>
                                    </el-table-column>
                                    <el-table-column
                                        prop="received_quantity"
                                        label="Received Quantity"
                                        :sortable="true">
                                    </el-table-column>
                                    <el-table-column
                                        label="Remaining Quantity"
                                        :sortable="true">
                                            <template slot-scope="scope">
                                                {{scope.row.remaining_quantity_to_receive | remaining}}
                                            </template>
                                    </el-table-column>
                                    <el-table-column
                                        width="180"
                                        fixed="right"
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
                                :pagination="itemReceivedPagination"
                                :total="filters.total"
                                @handleSizeChange="handleSizeChange"
                                @handleCurrentChange="handleCurrentChange">
                            </global-pagination>
                        </div>
                    </el-card>
            </div>
        </div>
        <el-dialog title="Add Purchase Received" width="90%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <purchase-receive-multiple-form :details="details" :mode="mode"></purchase-receive-multiple-form>
        </el-dialog>
        <el-dialog title="Update Received" width="35%"  :visible.sync="dialogFormVisibleEdit">
            <purchase-received-form :mode="mode" :model="model" ></purchase-received-form>
        </el-dialog>
     </div>
</template>
<script>
import paginate from '../../mixin/pagination'
export default {
    name: 'PurchaseReceiveView',
    mixins: [paginate],
    props: {
        id: null,
        data: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            loadingDetails: false,
            details: {},
            loadingItem: false,
            itemReceived: [],
            itemReceivedPagination: [],
            current_page: 1,
            current_size: 25,
            search: null,
            dialogFormVisible: false,
            mode: '',
            dialogFormVisibleEdit: false,
            model: {}
        }
    },
    created() {
        if(this.data && this.data.id) {
            this.details = this.data
            this.getItems();
        }
        else {
            this.loadingDetails = true
            this.getDetails();
        }

        this.$EventDispatcher.listen('ADD_NEW_ITEM_PURCHASE_RECEIVED', data => {
            data.forEach(item => {
                this.itemReceived.unshift(item)
            })
            this.dialogFormVisible = false
            this.mode = '';
        });

        this.$EventDispatcher.listen('UPDATE_PURCHASE_RECEIVED', data => {
            this.dialogFormVisibleEdit = false
            this.itemReceived.forEach(pr => {
                if(pr.id == data.id) {
                    for(let key in data) {
                        pr[key] = data[key];
                    }
                }
            })
        });
    },
    methods: {
        async getDetails() {
            try {
                const res = await this.$API.PurchaseReceived.getReceivedDetails(this.id);

                this.details = res.data;
                this.loadingDetails = false
                this.getItems();
            } catch (error) {
                console.log(error);
            }
        },
        async getItems() {
            try {
                this.loadingItem = true
                let params = {
                        current_size: this.current_size,
                        current_page: this.current_page,
                        search: this.search,
                    };
                const res = await this.$API.PurchaseReceived.getReceivedItems(this.details.purchase_order_form_id, params);

                this.itemReceived = res.data.data;
                this.itemReceivedPagination = res.data
                this.loadingItem = false
            } catch (error) {
                console.log(error);
            }
        },
        addItem() {
            this.dialogFormVisible = true;
            this.mode = 'addItem'
            this.details = this.details
        },
        handleEdit(index, data) {
            console.log(data);
            this.dialogFormVisibleEdit = true;
            this.mode = 'update'
            this.model = {...data};
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getItems();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getItems();
        },
        applySearch() {
            this.getItems();
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
                this.itemReceived.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.$confirm('Are you sure want to close?')
            .then(_ => {
                this.$EventDispatcher.fire('handleClosePR')
                this.mode = ''
                done();
            })
            .catch(_ => {});

        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getItems();
            }
        }
    },
    filters: {
        remaining(value) {
            if(!value) {
                return '0'
            }
            else {
                return value
            }
        }
    }
}
</script>
<style lang="scss" scoped>
    .my-label {
        font-weight: 600;
    }
</style>
