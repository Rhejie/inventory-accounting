<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Fixed Asset" prop="type_id">
                <el-select
                    v-model="form.type_id"
                    style="width: 100%"
                    filterable
                    remote
                    reserve-keyword
                    @change="changeAsset"
                    placeholder="Please enter a keyword"
                    :remote-method="remoteMethod"
                    :loading="loading">
                    <el-option
                    v-for="item in fixedAssets"
                    :key="item.id"
                    :label="item.assetable.brand_name"
                    :value="item.id">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="Date Requested" prop="date_requested">
                <el-date-picker disabled type="date" placeholder="Pick a Starting Date" v-model="form.date_requested" style="width: 100%;"></el-date-picker>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                <el-button @click="resetForm('form')" :disabled="disableButton" v-if="mode !='update'">Reset</el-button>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'RequestMaterialFixedAssetForm',
    props: {
        mode: null,
        model: {},
        id: null,
        dateRequested: null
    },
    data() {
        return {
            fixedAssets: [],
            loading: false,
            form : {
                date_requested: null,
                type_id: null,
            },
            rules: {
                type_id: [
                    {required: true, message: 'Please select Fixed Asset', trigger: 'blur'}
                ],
                date_requested: [
                    {required: true, message: 'Please input Date Requested', trigger: 'blur'}
                ],
            },
            disableButton: false,
        }
    },
    created() {
        if(this.model && this.model.id && this.mode == 'update') {
            this.form = {
                date_requested : this.model.date_requested,
                type_id : this.model.fixed_asset.assetable.brand_name,
                type_id_id : this.model.type_id,
                type: this.model.type
            }
        }
        else if (this.dateRequested) {
            this.form.date_requested = this.dateRequested;
        }
        this.$EventDispatcher.listen('handleCloseRMF', data => {
            this.resetForm('form')
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateRequestMaterialFixedAsset();
                    return
                }
                this.storeRequestMaterialFixedAsset();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async storeRequestMaterialFixedAsset() {
            this.disableButton = true;

            let type_id = this.fixedAssets.filter(asset => asset.id == this.form.type_id);

            try {
                let formData = new FormData();
                if(this.form.date_requested)formData.append('date_requested', this.form.date_requested)
                if(this.form.type_id)formData.append('type_id', this.form.type_id)
                if(this.form.type_id)formData.append('type', type_id[0].type);

                const res = await this.$API.RequestMaterial.storeRequestMaterialFixedAsset(this.id, formData)

                this.$EventDispatcher.fire('NEW_REQUEST_FIXED_ASSET', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });

                this.resetForm('form')
                this.fixedAssets = []

                this.disableButton = false
            } catch (error) {
                console.log(error);
            }
        },
        async updateRequestMaterialFixedAsset() {
            this.disableButton = true;
            let type_id = this.fixedAssets.filter(asset => asset.id == this.form.type_id);
            try {
                let formData = new FormData();
                if(this.form.date_requested)formData.append('date_requested', this.form.date_requested)
                if(this.form.type_id)formData.append('type_id', this.form.type_id)
                if(this.form.type_id_id)formData.append('type_id_id', this.form.type_id_id)
                if(this.form.type)formData.append('type', type_id[0].type);

                const res = await this.$API.RequestMaterial.updateRequestMaterialFixedAsset(this.model.id, formData)

                this.$EventDispatcher.fire('UPDATE_REQUEST_FIXED_ASSET', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async remoteMethod(query) {
            this.fixedAssets = []
            if (query !== '') {
                this.loading = true;
                try {
                    const res = await this.$API.RequestMaterial.getFixedAsset(query);
                    this.fixedAssets = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.fixedAssets = [];
            }
        },
        changeAsset(value) {
            if(this.model && this.model.id && this.mode == 'update') {
                this.form.type_id_id = null
                return value;
            }
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    date_requested : newVal.date_requested,
                    type_id : newVal.fixed_asset.assetable.brand_name,
                    type_id_id : newVal.type_id,
                    type: newVal.type,
                }


            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    date_requested : this.dateRequested,
                    type_id : '',
                    type: '',
                }
                this.fixedAssets = []
            }
            else {
                this.fixedAssets = []
            }
        }
    }
}
</script>
