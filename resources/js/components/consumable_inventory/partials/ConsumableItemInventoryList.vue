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
                    :data="consumableItems"
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
                        prop="suppliers.name"
                        label="Supplier"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="item"
                        label="Item"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="unit_price"
                        label="Unit Price"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                        prop="suppliers.delivery_time"
                        label="Delivery Time"
                        :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="text"
                                @click="handleView(scope.$index, scope.row)">View</el-button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="consumablePagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'ConsumableItemInventoryList',
    mixins: [paginate],
    data() {
        return {
            consumableItems: [],
            consumablePagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
        }
    },
    created() {
        this.geConsumableItemsInventory();
    },
    methods: {
        async geConsumableItemsInventory() {
            this.loading = true;
            let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
            try {
                const res = await this.$API.Consumable.geConsumableItemsInventory(params);
                this.consumableItems = res.data.data;
                this.consumablePagination = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleView(index, data) {
            this.$router.push({
                name: 'Supplier Management Details',
                params: {id: data.suppliers.id, data: data.suppliers}
            });
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.geConsumableItemsInventory();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.geConsumableItemsInventory();
        },
        applySearch() {
            this.geConsumableItemsInventory();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.geConsumableItemsInventory();
            }
        }
    }
}
</script>
