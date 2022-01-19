<template>
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <el-tabs type="border-card">
                <el-tabs v-model="activeName">
                    <el-tab-pane label="Item" name="first" lazy>
                        <bill-of-material-item></bill-of-material-item>
                    </el-tab-pane>
                    <el-tab-pane label="Description" name="second" lazy>
                        <bill-of-material-description></bill-of-material-description>
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
        name: 'BillOfMaterialsSetting',
        data() {
            return {
                activeName: 'first'
            }
        },
    }
</script>
