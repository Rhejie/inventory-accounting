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
            :data="fixedAssetStockOutData"
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
                    prop="fixed_asset.assetable.brand_name"
                    label="Brand Name"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="fixed_asset.type"
                    label="Type"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="date_delivered"
                    label="Date Delivered"
                    :sortable="true">
                </el-table-column>
                <el-table-column
                    prop="date_released"
                    label="Date Released"
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
            :pagination="fixedAssetStockOutPagination"
            :total="filters.total"
            @handleSizeChange="handleSizeChange"
            @handleCurrentChange="handleCurrentChange">
        </global-pagination>
    </div>
</template>
<script>
import paginate from '../../../mixin/pagination'
export default {
    name: 'ProjectFixedAssetList',
    mixins: [paginate],
    props: {
        id: null
    },
    data() {
        return {
            fixedAssetStockOutData: [],
            fixedAssetStockOutPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
        }
    },
    created() {
        this.getFIxedAssets();
    },
    methods: {
        async getFIxedAssets() {
            this.loading = true;
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.Project.fixedAssets(params, this.id);
                this.fixedAssetStockOutData = res.data.data;
                this.fixedAssetStockOutPagination = res.data
                this.loading = false
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getFIxedAssets();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getFIxedAssets();
        },
        applySearch() {
            this.getFIxedAssets();
        },
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getFIxedAssets();
            }
        }
    }
}
</script>
