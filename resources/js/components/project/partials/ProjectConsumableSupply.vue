<template>
    <div>
        <el-input
            size="mini"
            placeholder="Search here....."
            style="width:300px; float:right"
            @keyup.enter.native="applySearch"
            v-model="search">
        </el-input>
        <el-table
            :data="consumableSuppliesData"
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
                    prop="consumable_item.consumable_supply.item_code"
                    label="Item Code"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="consumable_item.consumable_supply.item_name"
                    label="Item Name"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="date_delivered"
                    label="Date Delivered"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="actual_quantity_delivered"
                    label="Quantity"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="remarks"
                    label="Remarks"
                    :sortable="true">
                </el-table-column>
        </el-table>
        <global-pagination
            :current_page="current_page"
            :current_size="current_size"
            :pagination="consumableSuppliesPagination"
            :total="filters.total"
            @handleSizeChange="handleSizeChange"
            @handleCurrentChange="handleCurrentChange">
        </global-pagination>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'ProjectConsumableSupply',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return {
            consumableSuppliesData: [],
            consumableSuppliesPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
        }
    },
    created() {
        this.getConsumableSupplies();
    },
    methods: {
        async getConsumableSupplies() {
            this.loading = true;
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.Project.ConsumableSupplies(params, this.id);
                this.consumableSuppliesData = res.data.data;
                this.consumableSuppliesPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getConsumableSupplies();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getConsumableSupplies();
        },
        applySearch() {
            this.getConsumableSupplies();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getConsumableSupplies();
            }
        }
    }
}
</script>
