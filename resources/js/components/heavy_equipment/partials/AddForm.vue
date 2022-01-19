<template>
    <div>
        <el-form :model="ruleForm" label-position="top" :rules="rules" ref="ruleForm" class="demo-ruleForm">
            <el-row>
                <el-col :span="12" class="form_wrapper">
                    <el-form-item label="Control Number" prop="control_number">
                        <el-input v-model="ruleForm.control_number"></el-input>
                    </el-form-item>
                    <el-form-item label="Brand Name" prop="brand_name">
                        <el-input v-model="ruleForm.brand_name"></el-input>
                    </el-form-item>
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
                    <el-form-item label="Engine Model" prop="engine_model">
                        <el-input v-model="ruleForm.engine_model"></el-input>
                    </el-form-item>
                    <el-form-item label="Serial Number" prop="serial_number">
                        <el-input v-model="ruleForm.serial_number"></el-input>
                    </el-form-item>
                    <el-form-item label="Capacity" prop="capacity">
                        <el-input v-model="ruleForm.capacity"></el-input>
                    </el-form-item>
                    <el-form-item label="Date Acquired" prop="date_acquired">
                        <el-date-picker
                            v-model="ruleForm.date_acquired"
                            type="date"
                            style="width:100%"
                            placeholder="Pick a day">
                        </el-date-picker>
                    </el-form-item>

                    <el-form-item label="Cost" prop="cost">
                        <el-input-number controls-position="right" style="width:100%" v-model="ruleForm.cost" :precision="2" :step="1.0"></el-input-number>
                    </el-form-item>
                </el-col>
                <el-col :span="12" class="form_wrapper">
                    <el-form-item label="Category" prop="asset_category_id">
                        <el-select v-model="ruleForm.asset_category_id" style="width:100%" placeholder="Select">
                            <el-option
                                v-for="item in pageData"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="Model" prop="model">
                        <el-input v-model="ruleForm.model"></el-input>
                    </el-form-item>
                    <el-form-item label="Engine Number" prop="engine_number">
                        <el-input v-model="ruleForm.engine_number"></el-input>
                    </el-form-item>
                    <el-form-item label="Reference Number" prop="reference_number">
                        <el-input v-model="ruleForm.reference_number"></el-input>
                    </el-form-item>
                    <el-form-item label="Description" prop="description">
                        <el-input type="textarea" v-model="ruleForm.description"></el-input>
                    </el-form-item>
                    <el-form-item label="Assigned To" prop="assigned_to">
                        <el-input type="textarea" v-model="ruleForm.assigned_to"></el-input>
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
                            accept="image/png, image/gif, image/jpeg, image/jpg"
                            :auto-upload="false"
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
                            <el-button @click="resetForm('ruleForm')" :disabled="disableButton" v-if="mode != 'update'">Reset</el-button>
                        </div>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'AddForm',
    props: {
        pageData: {},
        equipmentInfo: {},
        mode: null
    },
    data() {
        return {
            ruleForm: {
                asset_category_id: '',
                control_number: '',
                brand_name: '',
                model: '',
                engine_model: '',
                engine_number: '',
                serial_number: '',
                reference_number: '',
                capacity: '',
                description: '',
                date_acquired: null,
                photo: '',
                assigned_to: '',
                cost: null,
                status: ''
            },
            rules: {
                control_number: [
                    { required: true, message: 'Please input Control Number', trigger: 'blur' },
                ],
                brand_name: [
                    { required: true, message: 'Please select Brand Name', trigger: 'change' }
                ],
                asset_category_id: [
                    { required: true, message: 'Please select Category', trigger: 'blur' }
                ],
                status: [
                    { required: true, message: 'Please select Status', trigger: 'blur' }
                ]
            },
            fileList: [],
            list_type: 'picture',
            disableButton: false,
        }
    },
    created() {
        if(this.equipmentInfo && this.equipmentInfo.id) {
            this.ruleForm = {
                asset_category_id: this.equipmentInfo.asset_category_id,
                control_number: this.equipmentInfo.control_number,
                brand_name: this.equipmentInfo.brand_name,
                model: this.equipmentInfo.model,
                engine_model: this.equipmentInfo.engine_model,
                engine_number: this.equipmentInfo.engine_number,
                serial_number: this.equipmentInfo.serial_number,
                reference_number: this.equipmentInfo.reference_number,
                capacity: this.equipmentInfo.capacity,
                description: this.equipmentInfo.description,
                date_acquired: this.equipmentInfo.date_acquired,
                photo: this.equipmentInfo.photo,
                assigned_to: this.equipmentInfo.assigned_to,
                cost: this.equipmentInfo.cost,
                status: this.equipmentInfo.status,
            };
            if(this.equipmentInfo.photo) {
                this.fileList = [{name: this.equipmentInfo.photo, url: `/storage/heavy_equipments/photo/${this.equipmentInfo.photo}`}]
            }
        }

        this.$EventDispatcher.listen('handleCloseUpdateHE', data => {
            this.ruleForm = {
                asset_category_id: data.asset_category_id,
                control_number: data.control_number,
                brand_name: data.brand_name,
                model: data.model,
                engine_model: data.engine_model,
                engine_number: data.engine_number,
                serial_number: data.serial_number,
                reference_number: data.reference_number,
                capacity: data.capacity,
                description: data.description,
                date_acquired: data.date_acquired,
                photo: data.photo,
                assigned_to: data.assigned_to,
                cost: data.cost,
                status: data.status,
            };
            if(data.photo) {
                this.fileList = [{name: data.photo, url: `/storage/heavy_equipments/photo/${data.photo}`}]
            }
            else {
                this.fileList.splice(1,1)
            }
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateHeavyEquipment();
                }
                else {
                    this.storeHeavyEquipment();
                }
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.fileList.splice(1,1);
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
        async storeHeavyEquipment(){
            this.disableButton = true
            try {
                let formData = new FormData();
                if(this.ruleForm.control_number)formData.append('control_number', this.ruleForm.control_number);
                if(this.ruleForm.brand_name)formData.append('brand_name', this.ruleForm.brand_name);
                if(this.ruleForm.engine_model)formData.append('engine_model', this.ruleForm.engine_model);
                if(this.ruleForm.serial_number)formData.append('serial_number', this.ruleForm.serial_number);
                if(this.ruleForm.capacity)formData.append('capacity', this.ruleForm.capacity);
                if(this.ruleForm.date_acquired)formData.append('date_acquired', this.$df.formatDate(this.ruleForm.date_acquired, "YYYY-MM-DD"))
                if(this.ruleForm.cost)formData.append('cost', this.ruleForm.cost);
                if(this.ruleForm.asset_category_id)formData.append('asset_category_id', this.ruleForm.asset_category_id);
                if(this.ruleForm.model)formData.append('model', this.ruleForm.model);
                if(this.ruleForm.engine_number)formData.append('engine_number', this.ruleForm.engine_number);
                if(this.ruleForm.reference_number)formData.append('reference_number', this.ruleForm.reference_number);
                if(this.ruleForm.description)formData.append('description', this.ruleForm.description);
                if(this.ruleForm.assigned_to)formData.append('assigned_to', this.ruleForm.assigned_to);
                if(this.ruleForm.photo)formData.append('photo', this.ruleForm.photo);
                if(this.ruleForm.status)formData.append('status', this.ruleForm.status);

                const res = await this.$API.HeavyEquipment.storeEquipement(formData);

                this.resetForm('ruleForm');
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added!',
                    type: 'success'
                });

                this.$EventDispatcher.fire('ADD_NEW_HEAVY_EQUIPMENT', res.data);
                this.disableButton = false

            } catch (error) {
                console.log(error);
            }
        },
        async updateHeavyEquipment() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.ruleForm.control_number)formData.append('control_number', this.ruleForm.control_number);
                if(this.ruleForm.brand_name)formData.append('brand_name', this.ruleForm.brand_name);
                if(this.ruleForm.engine_model)formData.append('engine_model', this.ruleForm.engine_model);
                if(this.ruleForm.serial_number)formData.append('serial_number', this.ruleForm.serial_number);
                if(this.ruleForm.capacity)formData.append('capacity', this.ruleForm.capacity);
                if(this.ruleForm.date_acquired)formData.append('date_acquired', this.$df.formatDate(this.ruleForm.date_acquired, "YYYY-MM-DD"))
                if(this.ruleForm.cost)formData.append('cost', this.ruleForm.cost);
                if(this.ruleForm.asset_category_id)formData.append('asset_category_id', this.ruleForm.asset_category_id);
                if(this.ruleForm.model)formData.append('model', this.ruleForm.model);
                if(this.ruleForm.engine_number)formData.append('engine_number', this.ruleForm.engine_number);
                if(this.ruleForm.reference_number)formData.append('reference_number', this.ruleForm.reference_number);
                if(this.ruleForm.description)formData.append('description', this.ruleForm.description);
                if(this.ruleForm.assigned_to)formData.append('assigned_to', this.ruleForm.assigned_to);
                if(this.ruleForm.photo)formData.append('photo', this.ruleForm.photo);
                if(this.ruleForm.status)formData.append('status', this.ruleForm.status);

                const res = await this.$API.HeavyEquipment.updateEquipment(this.equipmentInfo.id, formData);

                console.log('============updated========================');
                console.log(res.data);
                console.log('====================================');
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated!',
                    type: 'success'
                });
                this.$EventDispatcher.fire('UPDATED_HEAVY_EQUIPMENT', res.data);
                this.disableButton = false;


            } catch (error) {
                console.log(error);
            }
        }
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
<style>
    .form_wrapper{
        padding: 10px;
    }
</style>
