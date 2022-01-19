<template>
     <div>
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Taxes </h5>
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
                    <button type="button" class="btn btn-light-primary font-weight-bold ml-2" @click="addTax">
                        Add Tax
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
                <taxes-list></taxes-list>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <el-dialog :title="mode == 'create' ? 'Add Tax' : 'Update Tax'" width="35%"  :visible.sync="dialogFormVisible"  :before-close="handleClose">
            <taxes-form :mode="mode" :model="model"></taxes-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'TaxesConstantIndex',
    data() {
        return {
            dialogFormVisible: false,
            model: {},
            mode: ''
        }
    },
    created() {
        this.$EventDispatcher.listen('NEW_TAX', data => {
            this.dialogFormVisible = false
            this.mode = ''
            this.model = {}
        })
    },
    methods: {
        addTax() {
            this.dialogFormVisible = true;
            this.mode = 'create';
            this.model = {}
        },
        handleClose(done) {
            this.$EventDispatcher.fire('handleCLoseConsumbleSupply')
            done();
        },
    },
}
</script>
