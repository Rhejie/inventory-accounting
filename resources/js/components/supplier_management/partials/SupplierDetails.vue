<template>
    <div>
        <div>
            <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Details-->
                    <div class="d-flex align-items-center flex-wrap mr-2">
                        <!--begin::Title-->
                        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">{{supplierDetails.name}} </h5>
                        <!--end::Title-->
                        <!--begin::Separator-->
                        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                        <!--end::Separator-->


                    </div>
                    <!--end::Details-->
                    <!--begin::Toolbar-->
                    <!--end::Toolbar-->
                </div>
            </div>

        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">

                <el-card class="box-card">
                    <el-descriptions class="margin-top" title="Details:" :column="3" border>

                        <el-descriptions-item>
                        <template slot="label">
                            <i class="el-icon-user"></i>
                            Name
                        </template>
                        {{supplierDetails.name}}
                        </el-descriptions-item>
                        <el-descriptions-item>
                        <template slot="label">
                            <i class="el-icon-mobile-phone"></i>
                            Contact Number
                        </template>
                        {{supplierDetails.contact_no}}
                        </el-descriptions-item>
                        <el-descriptions-item>
                        <template slot="label">
                            <i class="el-icon-location-outline"></i>
                            Delivery Time
                        </template>
                            {{supplierDetails.delivery_time}}
                        </el-descriptions-item>
                        <el-descriptions-item>
                        <template slot="label">
                            <i class="el-icon-tickets"></i>
                            Contact Person:
                        </template>
                        <el-tag size="small">{{supplierDetails.contact_person}}</el-tag>
                        </el-descriptions-item>
                        <el-descriptions-item>
                        <template slot="label">
                            Email
                        </template>
                            {{supplierDetails.email}}
                        </el-descriptions-item>
                        <el-descriptions-item>
                        <template slot="label">
                            <i class="el-icon-office-building"></i>
                            Address
                        </template>
                            {{supplierDetails.address}}
                        </el-descriptions-item>
                    </el-descriptions>
                    <br/>
                    <el-card class="box-card" shadow="never">
                        <div slot="header" class="clearfix">
                            <span class="consumable_item_title">Consumable Items</span>
                            <el-button style="float: right; padding: 3px 0" @click="addItem" type="text"><i class="fas fa-plus-circle"></i> Add Items</el-button>
                        </div>
                        <div class="text item">
                            <consumable-item-list :id="id"></consumable-item-list>
                        </div>
                    </el-card>
                </el-card>

            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
        </div>
        <el-dialog title="Add Item" width="35%"  :visible.sync="dialogFormVisible" :before-close="handleClose">
            <consumable-item-form :id="id" :mode="mode"></consumable-item-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'SupplierDetails',
    props: {
        id: null,
        data: {}
    },
    data() {
        return {
             supplierDetails: {},
             loading: false,
             dialogFormVisible: false,
             mode: ''
        }
    },
    created() {
        if(this.data && this.data.id) {
            this.supplierDetails = this.data;
        }
        else {
            this.getSupplierDetails();
        }

        this.$EventDispatcher.listen('ADD_NEW_ITEM', data => {
            this.dialogFormVisible = false;
        });
    },
    methods: {
        async getSupplierDetails() {
            this.loading = true;
            try {
                const res = await this.$API.SupplierManagement.getSupplierDetails(this.id);
                this.supplierDetails = res.data;
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        addItem() {
            this.dialogFormVisible = true;
            this.mode = 'create';
        },
        handleClose(done) {
            this.mode = ''
            this.$EventDispatcher.fire('handCloseSUpplierItem')
            done();
        },
    },
}
</script>
<style lang="scss">
    .consumable_item_title {
        font-weight: 600;
    }
</style>
