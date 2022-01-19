<template>
    <div>
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Debit Note </h5>
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
                    <button type="button" class="btn btn-light-primary font-weight-bold ml-2" @click="addNote">
                        Add Debit Note
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
                <debit-note-list></debit-note-list>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <el-dialog title="Add Debit Note" width="45%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <debit-note-form :mode="mode" :model="model"></debit-note-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'DebitNoteIndex',
    data() {
        return {
            dialogFormVisible: false,
            mode: '',
            model: {}
        }
    },
    created() {
        this.$EventDispatcher.listen('NEW_NOTE', data => {
            this.dialogFormVisible = false;
            this.mode = '',
            this.model = {}
        })
    },
    methods: {
        addNote() {
            this.dialogFormVisible = true;
            this.mode = 'create';
            this.model = {}
        },
        handleClose(done) {
            this.mode = 'close';
            this.$EventDispatcher.fire('CLOSE_DEBIT_NOTE');
            done();
        }
    },
}
</script>
