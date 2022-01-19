<template>
    <div>
        <el-card class="box-card">
            <div class="text item">
                <el-select v-model="type" clearable placeholder="Select Type" size="mini">
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                    </el-option>
                </el-select>
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="fixedAssetData"
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
                            prop="assetable.brand_name"
                            label="Brand Name"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="type"
                            label="Type"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="text"
                                @click="handleView(scope.$index, scope.row)">View</el-button>
                                <!--el-button
                                size="mini"
                                type="text"
                                @click="handleDelete(scope.$index, scope.row)">Delete</!--el-button -->
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="fixedAssetPagination"
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
    name: 'FixedAssetList',
    mixins: [paginate],
    props: {
        pageData: {}
    },
    data() {
        return {
            fixedAssetData: [],
            fixedAssetPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            type: '',
            options: [
                {
                    value: 'Heavy Equipment',
                    label: 'Heavy Equipment',
                },
                {
                    value: 'Truck / Vehicle',
                    label: 'Truck / Vehicle',
                },
                {
                    value: 'Other',
                    label: 'Other',
                }
            ]
        }
    },
    created() {
        this.getFixedAssetsData();
    },
    methods: {
        async getFixedAssetsData() {
            this.loading = true;
            try {
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                    type: this.type
                };

                const res = await this.$API.FixedAsset.getFixedAssets(params);

                this.fixedAssetData = res.data.data;
                this.fixedAssetPagination = res.data;

                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getFixedAssetsData();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getFixedAssetsData();
        },
        applySearch() {
            this.getFixedAssetsData();
        },
        handleView(index, data) {
            let fixed_asset = {}
            let location = data.location;
            fixed_asset.location = location;
            data.assetable.fixed_assets = fixed_asset
            if(data.type === 'Other') {
                this.$router.push({
                    name: 'Other Inventory Details',
                    params: {id: data.assetable.id, data: data.assetable}
                });
            }
            if(data.type === 'Heavy Equipment') {
                this.$router.push({
                    name: 'Heavy Equipment Details',
                    params: {id: data.assetable.id, data: data.assetable, pageData: this.pageData}
                });
            }

            if(data.type === 'Truck / Vehicle') {
                this.$router.push({
                    name: 'Truck Vehicle Details',
                    params: {id: data.assetable.id, data: data.assetable, pageData: this.pageData}
                });
            }
            // this.$router.push({
            //     name: 'Other Inventory Details',
            //     params: {id: data.id, data: data}
            // });
        },
        handleDelete(index, data) {

        }
    },
    watch: {
        search(val) {
            if( val == '') {
                this.getFixedAssetsData();
            }
        },
        type(newVal, oldVal) {
            if(newVal != oldVal) {
                this.getFixedAssetsData();
            }
        }
    }
}
</script>
