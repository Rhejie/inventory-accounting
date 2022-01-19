<template>
    <div class="d-flex flex-column-fluid" v-loading="loading">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <el-card class="box-card" shadow="never" >
                <div class="text item">
                    <el-descriptions title="Request Material Form">
                        <el-descriptions-item label-class-name="my-label" label="Request Material Code">{{requestForm.request_material_code}}</el-descriptions-item>
                        <el-descriptions-item label-class-name="my-label" label="Date Requested">{{requestForm.date_request}}</el-descriptions-item>
                        <el-descriptions-item label-class-name="my-label" label="Requested By">{{requestForm.requested_by}}</el-descriptions-item>
                        <el-descriptions-item label-class-name="my-label" label="Approved By">{{requestForm.approved_by}}</el-descriptions-item>
                        <el-descriptions-item label-class-name="my-label" label="Project">
                        <el-tag size="small" v-loading="loading">{{requestForm.project.name}}</el-tag>
                        </el-descriptions-item>
                    </el-descriptions>
                </div>
            </el-card>
            <hr>
            <el-tabs type="border-card">
                <el-tabs v-model="activeName">
                    <el-tab-pane label="Consumable Items" name="first" lazy>
                        <request-material-consumable-supply :id="id" :date-requested="requestForm.date_request" :projectID="requestForm.project.id"> </request-material-consumable-supply>
                    </el-tab-pane>
                    <el-tab-pane label="Fixed Assets" name="second" lazy>
                        <request-material-fixed-asset :id="id" :date-requested="requestForm.date_request"></request-material-fixed-asset>
                    </el-tab-pane>
                </el-tabs>
            </el-tabs>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
</template>
<script>
export default {
    name: 'RequestMaterialDetails',
    props: {
        id: null,
        data: {}
    },
    data() {
        return {
            requestForm: [],
            loading: false,
            activeName: 'first'
        }
    },
    created() {
        if(this.data && this.data.id) {
            this.requestForm = this.data;
        }
        else {
            this.loading = true
            this.getRequest();
        }
    },
    methods: {
        async getRequest() {
            try {
                const res = await this.$API.RequestMaterial.getRequestDetails(this.id);
                this.requestForm = res.data
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        }
    }
}
</script>
<style lang="scss" scoped>
    .my-label {
        font-weight: 600;
    }
</style>
