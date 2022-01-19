<template>
    <div>
        <el-form :model="ruleForm" label-position="top" :rules="rules" ref="ruleForm" class="demo-ruleForm">
            <el-row>
                <el-col :span="12" class="form_wrapper">
                    <el-form-item label="Brand Name" prop="brand_name">
                        <el-input v-model="ruleForm.brand_name"></el-input>
                    </el-form-item>
                    <el-form-item label="Description" prop="description">
                        <el-input type="textarea" v-model="ruleForm.description"></el-input>
                    </el-form-item>
                    <el-form-item label="Cost" prop="cost">
                        <el-input-number controls-position="right" style="width:100%" v-model="ruleForm.cost" :precision="2" :step="1.0"></el-input-number>
                    </el-form-item>
                </el-col>
                <el-col :span="12" class="form_wrapper">
                    <el-form-item label="Status" prop="status">
                        <el-select v-model="ruleForm.status" style="width:100%" placeholder="Select">
                            <el-option
                                label="Active"
                                value="Active">
                            </el-option>
                            <el-option
                                label="For Repair"
                                value="For Repair">
                            </el-option>
                            <el-option
                                label="Under Repair"
                                value="Under Repair">
                            </el-option>
                            <el-option
                                label="Missing"
                                value="Missing">
                            </el-option>
                            <el-option
                                label="Damage"
                                value="Damage">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="Date Acquired" prop="date_acquired">
                        <el-date-picker
                            v-model="ruleForm.date_acquired"
                            type="date"
                            style="width:100%"
                            placeholder="Pick a day">
                        </el-date-picker>
                    </el-form-item>

                    <el-form-item prop="photo">
                        <el-upload
                            class="upload-demo"
                            action=""
                            ref="uploadDocument"
                            name="projectDocument"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :on-change="fileChange"
                            :file-list="fileList"
                            :auto-upload="false"
                            accept="image/png, image/gif, image/jpeg, image/jpg"
                            :limit="1"
                            :list-type="list_type">
                            <el-button size="small" type="primary">Click to upload Photo</el-button>
                        </el-upload>
                    </el-form-item>
                </el-col>
            </el-row>

            <el-row>
                <el-col :span="24">
                    <el-form-item>
                        <div style="float:right">
                            <el-button type="primary" :disabled="disableButton" @click="submitForm('ruleForm')">Save</el-button>
                            <el-button :disabled="disableButton" v-if="mode != 'update'" @click="resetForm('ruleForm')">Reset</el-button>
                        </div>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'OtherInventoryForm',
    props: {
        editData: {},
        mode: null
    },
    data() {
        return {
            ruleForm : {
                brand_name: '',
                date_acquired: '',
                description: '',
                cost: '',
                status: ''
            },
            rules: {
                brand_name: [
                    { required: true, message: 'Please select Brand Name', trigger: 'change' }
                ],
                status: [
                    { required: true, message: 'Please select Status', trigger: 'change' }
                ],
            },
            fileList: [],
            list_type: 'picture',
            disableButton: false

        }
    },
    created() {
        if(this.editData && this.editData.id) {
            this.ruleForm = {
                brand_name: this.editData.brand_name,
                date_acquired: this.editData.date_acquired,
                description: this.editData.description,
                cost: this.editData.cost,
                status: this.editData.status,
            }
            if(this.editData.photo) this.fileList = [{name: this.editData.photo, url: `/storage/other_inventory/photo/${this.editData.photo}`}]
        }
        this.$EventDispatcher.listen('handleCloseOther', data => {
            this.resetForm('ruleForm')
        })

        this.$EventDispatcher.listen('handleCloseUpdateOther', data => {
            this.ruleForm = {
                brand_name: data.brand_name,
                date_acquired: data.date_acquired,
                description: data.description,
                cost: data.cost,
                status: data.status,
            }
            if(data.photo) this.fileList = [{name: data.photo, url: `/storage/other_inventory/photo/${data.photo}`}]
            else this.fileList.splice(1,1)
        });

        this.$EventDispatcher.listen('handleCloseOtherAsset', data => {
            this.resetForm('ruleForm')
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.update();
                    return
                }
                this.store();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.fileList.splice(1,1);
            this.$refs[formName].resetFields();
        },
        async store() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.ruleForm.brand_name)formData.append('brand_name', this.ruleForm.brand_name);
                if(this.ruleForm.description)formData.append('description', this.ruleForm.description);
                if(this.ruleForm.cost)formData.append('cost', this.ruleForm.cost);
                if(this.ruleForm.date_acquired)formData.append('date_acquired', this.$df.formatDate(this.ruleForm.date_acquired, "YYYY-MM-DD"));
                if(this.ruleForm.photo)formData.append('photo', this.ruleForm.photo);
                if(this.ruleForm.status)formData.append('status', this.ruleForm.status);

                const res = await this.$API.OtherInventory.storeOtherInventory(formData);

                this.resetForm('ruleForm');
                this.$emit('closeForm');
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.$EventDispatcher.fire('NEW_ADDED_OTHER_INVENTORY', res.data);
                this.disableButton = false

            } catch (error) {
                console.log(error);
            }
        },
        async update() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.ruleForm.brand_name)formData.append('brand_name', this.ruleForm.brand_name);
                if(this.ruleForm.description)formData.append('description', this.ruleForm.description);
                if(this.ruleForm.cost)formData.append('cost', this.ruleForm.cost);
                if(this.ruleForm.date_acquired)formData.append('date_acquired', this.$df.formatDate(this.ruleForm.date_acquired, "YYYY-MM-DD"));
                if(this.ruleForm.photo)formData.append('photo', this.ruleForm.photo);
                if(this.ruleForm.status)formData.append('status', this.ruleForm.status);

                const res = await this.$API.OtherInventory.updateOtherInventory(this.editData.id, formData);
                this.$emit('closeForm');
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated',
                    type: 'success'
                });
                this.$EventDispatcher.fire('UPDATED_OTHER_INVENTORY', res.data);
                this.disableButton = false

            } catch (error) {
                console.log(error);
            }
        },
        handlePreview(file) {
            console.log(file);
        },
        handleRemove(file, fileList) {
            console.log(file, fileList);
        },
        fileChange(file, fileList) {
            this.ruleForm.photo = file.raw
        },
    },
    watch: {
        mode(val) {
            if(val == 'create') {
                this.resetForm('ruleForm');
            }
        }
    }
}
</script>
