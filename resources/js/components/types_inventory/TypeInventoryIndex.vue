<template>
    <div>
        <div>
            <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Types</h5>
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
                    <button type="button" class="btn btn-light-primary font-weight-bold ml-2" @click="addType">
                        Add Type
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
                    <type-inventory-list :typesData="typesData" :loading="loading"></type-inventory-list>
                    <global-pagination
                        :current_page="current_page"
                        :current_size="current_size"
                        :pagination="typesPagination"
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
        <el-dialog :title="mode == 'create'? 'Add Type':'Update Type'" width="35%"  :visible.sync="dialogFormVisible" :before-close="handleClose">
            <type-inventory-form :model="model" :mode="mode"></type-inventory-form>
        </el-dialog>

    </div>
</template>
<script>
import paginate from '../../mixin/pagination'
export default {
    name: 'TypeInventoryIndex',
    mixins: [paginate],
    data() {
        return {
            dialogFormVisible: false,
            mode: null,
            loading: false,
            current_page: 1,
            current_size: 25,
            search: null,
            typesData: [],
            typesPagination: [],
            model: {}
        }
    },
    created() {
        this.getType();

        this.$EventDispatcher.listen('EDIT_DATA_VALUE', data => {
            this.dialogFormVisible = true;
            this.model = data;
            this.mode = 'update'
        })

        this.$EventDispatcher.listen('NEW_TYPE_INVENTORY', data => {
            this.typesData.unshift(data);
            this.dialogFormVisible = false;
        });

        this.$EventDispatcher.listen('UPDATED_TYPE_INVENTORY', data => {
            this.typesData.forEach(type => {
                for(let key in data) {
                    if(type.id == data.id) {
                        type[key] = data[key];
                    }
                }
            })
            this.dialogFormVisible = false;
            this.mode = null
            this.model = {}
        })

        this.$EventDispatcher.listen('TYPE_DELETE_DATA', data => {
            this.deleteType(data.index, data.data);
        });
    },
    methods: {
        async getType() {
            try {
                this.loading = true
                let params = {
                    current_size: this.current_size,
                    current_page: this.current_page,
                    search: this.search,
                };
                const res = await this.$API.TypeInventory.getTypes(params);

                this.typesData = res.data.data;
                this.typesPagination = res.data;

                this.loading = false;

            } catch (error) {
                console.log(error);
            }
        },
        async deleteType(index, data) {
            try {
                await this.$API.TypeInventory.deleteType(data.id);
                this.typesData.splice(index, 1);
            } catch (error) {
                console.log(error);
            }
        },
        addType() {
            this.mode = 'create';
            this.model = {}
            this.dialogFormVisible = true
        },
        handleSizeChange(val) {
            this.current_size = val;
            this.getType();
        },
        handleCurrentChange(val) {
            this.current_page = val;
            this.getType();
        },
        applySearch() {
            this.getType();
        },
        handleClose(done) {
            this.mode = ''
            this.$EventDispatcher.fire('handleClosetypes')
            done();
        },
    },
    watch: {
        search(val) {
            if(!val) {
                this.getType();
            }
        }
    }
}
</script>
