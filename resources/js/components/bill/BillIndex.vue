<template>
    <div>
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Details-->
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Manage Bills </h5>
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
                    <button type="button" class="btn btn-light-primary font-weight-bold ml-2" @click="addNewBill">
                        Add Bill
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
                <bill-list></bill-list>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <el-dialog title="Add Choose Type" width="40%" :visible.sync="dialogFormVisiblePayment" :before-close="closeType">
            <el-form :model="form" :rules="rules" ref="form"  class="demo-ruleForm">
                <el-form-item label="Type" prop="type">
                    <el-select v-model="form.type" placeholder="Select Type" style="width:100%">
                        <el-option label="Purchase Order" value="po"></el-option>
                        <el-option label="Company expenses" value="company"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item>
                    <div style="float:right">
                        <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                        <el-button :disabled="disableButton" @click="resetForm('form')">Reset</el-button>
                    </div>
                </el-form-item>
            </el-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'BillIndex',
    data() {
        return {
            dialogFormVisiblePayment: false,
            form: {
                type: null
            },
            rules: {
                type: [
                    {required: true, message: 'Please select Type', trigger: 'blur'}
                ]
            },
            disableButton: false,
        }
    },
    created() {

    },
    methods: {
        addNewBill() {
            this.dialogFormVisiblePayment = true
            // this.$router.push({name: 'Bill Create', params: {mode: 'create', model: {} } });
        },
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    this.disableButton = true
                    if(this.form.type == 'po') {
                        this.$router.push({name: 'Bill Create', params: {mode: 'create', model: {} } });
                    }
                    else {
                        this.$router.push({name: 'Bill Create 2', params: {mode: 'create', model: {} } });
                    }
                    this.disableButton = false
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        closeType(done) {
            this.resetForm('form')
            done();
        }
    },
}
</script>
