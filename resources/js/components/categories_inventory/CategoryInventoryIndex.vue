<template>
    <div>
        <div>
            <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Categories</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->


                </div>
                <!--end::Details-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <!--begin::Button-->
                    <a href="" class=""></a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" class="btn btn-light-primary font-weight-bold ml-2" @click="addCategory">
                        Add Category
                    </button>
                    <!--end::Button-->
                    <!--begin::Dropdown-->

                    <!--end::Dropdown-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>

        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <el-card class="box-card">
                    <el-input
                        size="mini"
                        placeholder="Search here....."
                        style="width:300px; float:right"
                        @keyup.enter.native="applySearch"
                        v-model="search">
                    </el-input>
                    <category-inventory-list :categories-data='categoriesData' :loading="loading"></category-inventory-list>
                    <global-pagination
                        :current_page="current_page"
                        :current_size="current_size"
                        :pagination="categoriesPagination"
                        :total="filters.total"
                        @handleSizeChange="handleSizeChange"
                        @handleCurrentChange="handleCurrentChange">
                    </global-pagination>
                </el-card>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
        </div>
        <el-dialog :title="mode == 'create'? 'Add Category':'Update Category'" width="35%"  :visible.sync="dialogFormVisible" :before-close="handleClose">
            <!-- <type-inventory-form :model="model" :mode="mode"></type-inventory-form> -->
            <category-inventory-form :mode="mode" :model="model"></category-inventory-form>
        </el-dialog>

    </div>
</template>
<script>
import paginate from '../../mixin/pagination'
export default {
    name: 'CategoryInventoryIndex',
    mixins: [paginate],
    data() {
        return {
            categoriesData: [],
            categoriesPagination: [],
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            dialogFormVisible: false,
            mode: null,
            model: {}
        }
    },
    created() {
        this.getCategories();

        this.$EventDispatcher.listen('NEW_CATEGORY_INVENTORY', data => {
            this.categoriesData.unshift(data);
            this.dialogFormVisible = false;
        });

        this.$EventDispatcher.listen('EDIT_DATA_VALUE', data => {
            this.mode = 'update';
            this.model = data;
            this.dialogFormVisible = true;
        });

        this.$EventDispatcher.listen('UPDATED_CATEGORY_INVENTORY', data => {
            this.dialogFormVisible = false;
            this.categoriesData.forEach(category => {
                if(category.id == data.id) {
                    for(let key in data) {
                        category[key] = data[key]
                    }
                }
            });
        });

        this.$EventDispatcher.listen('DELETE_CATEGORY_INVENTORY', value => {
            this.deleteCategory(value.index, value.data);
        });
    },
    methods: {
        async getCategories() {
            try {
                this.loading = true
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.CategoryInventory.getCategories(params);
                this.categoriesData = res.data.data
                this.categoriesPagination = res.data;
                this.loading = false

            } catch (error) {
                console.log(error);
            }
        },
        addCategory() {
            this.dialogFormVisible = true;
            this.model = {}
            this.mode = 'create';
        },
        async deleteCategory(index, data) {
            try {
                await this.$API.CategoryInventory.deleteCategory(data.id);
                this.categoriesData.splice(index, 1);
                this.$message({
                    type: 'success',
                    message: 'Delete completed'
                });
            } catch (error) {
                console.log(error);
            }
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getCategories();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getCategories();
        },
        applySearch() {
            this.getCategories();
        },
        handleClose(done) {
            this.mode = ''
            this.$EventDispatcher.fire('handleCloseCI')
            done();
        },
    },
    watch: {
        search(val) {
            if(!val) {
                this.getCategories();
            }
        }
    }
}
</script>
