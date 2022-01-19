<template>
    <div>
        <div>
            <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Details-->
                    <div class="d-flex align-items-center flex-wrap mr-2">
                        <!--begin::Title-->
                        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Fixed Assets</h5>
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
                        <!--button type="button" class="btn btn-light-primary font-weight-bold ml-2" @click="dialogFormVisible = !dialogFormVisible">
                            Add Others
                        </!--button -->
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
                    <fixed-asset-list :pageData="pageData"></fixed-asset-list>
                    <!--end::Row-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
    </div>
</template>
<script>
export default {
    name: 'FixedAssetIndex',
    props: {
        pageData: {}
    },
    data() {
        return {

        }
    }
}
</script>
