<template>
    <div>

        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Customers </h5>
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
                    <button type="button" class="btn btn-light-primary font-weight-bold ml-2" @click="addCustomer">
                        Add Customer
                    </button>
                    <!--end::Button-->
                    <!--begin::Dropdown-->

                    <!--end::Dropdown-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <customer-list></customer-list>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <el-dialog :title="title" width="60%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <customer-form :mode="mode" :isView="isView" :model="model"></customer-form>
        </el-dialog>
    </div>
</template>
<script>
    export default {
        name: 'CustomerIndex',
        data() {
            return {
                dialogFormVisible: false,
                mode: '',
                model: {},
                title: '',
                isView: false,
            }
        },
        created() {
            this.$EventDispatcher.listen('ADD_NEW_CUSTOMER', data => {
                this.dialogFormVisible = false
            })
        },
        methods: {
            addCustomer() {
                this.mode = 'create'
                this.model = {}
                this.dialogFormVisible = true
                this.isView = false
                this.title = 'Add Customer'
            },
            handleClose(done) {
                this.mode = ''
                this.model = {}
                this.$EventDispatcher.fire('CLOSE_CUSTOMER');
                done();
            },
        },
    }
</script>
