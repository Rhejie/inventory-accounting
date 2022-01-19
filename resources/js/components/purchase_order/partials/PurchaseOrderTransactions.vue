<template>
    <div>
        <el-table
            :data="transactions"
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
                    prop="purchase_order_item.consumable_item.item"
                    label="Item"
                    show-overflow-tooltip
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="purchase_order_item.quantity"
                    label="Request Quantity"
                    width="160"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="received_quantity"
                    label="Received Quantity"
                    width="160"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="received_quantity"
                    label="Remaining Quantity"
                    width="180"
                    :sortable="true">
                        <template slot-scope="scope">
                            {{ramaining(scope.row)}}
                        </template>
                </el-table-column>
        </el-table>
    </div>
</template>
<script>
export default {
    name: 'PurchaseOrderTransactions',
    props: {
        purchaseOrder: {}
    },
    data() {
        return {
            transactions: [],
            loading: false,
        }
    },
    created() {
        this.getTransactionsItems();
    },
    methods: {
        async getTransactionsItems() {
            try {
                this.loading = true
                const res = await this.$API.PurchaseOrder.getTransactionsItems(this.purchaseOrder.id);
                this.transactions = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        ramaining(data) {
            let remaining = parseInt(data.purchase_order_item.quantity) - parseInt(data.received_quantity)
            return remaining
        }
    },
}
</script>
