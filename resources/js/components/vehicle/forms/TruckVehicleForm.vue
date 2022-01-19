<template>
    <div>
        <el-form :model="ruleForm" label-position="top" :rules="rules" ref="ruleForm" class="demo-ruleForm">
            <el-row>
                <el-col :span="12" class="form_wrapper">
                    <el-form-item label="Brand Name" prop="brand_name">
                        <el-input v-model="ruleForm.brand_name"></el-input>
                    </el-form-item>
                    <el-form-item label="Body Type" prop="body_type">
                        <el-input v-model="ruleForm.body_type"></el-input>
                    </el-form-item>
                    <el-form-item label="Plate Number" prop="plate_number">
                        <el-input v-model="ruleForm.plate_number"></el-input>
                    </el-form-item>
                    <el-form-item label="Assigned To" prop="assigned_to">
                        <el-input v-model="ruleForm.assigned_to"></el-input>
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
                    <el-form-item label="Cost" prop="cost">
                        <el-input-number controls-position="right" style="width:100%" v-model="ruleForm.cost" :precision="2" :step="1.0"></el-input-number>
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
                            list-type="picture">
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
    name: 'TruckVehicleForm',
    props: {
        editData: {},
        mode: null
    },
    data() {
        return {
            ruleForm : {
                brand_name: '',
                body_type: '',
                plate_number: '',
                assigned_to: '',
                date_acquired: '',
                cost: '',
                status: ''
            },
            rules: {
                brand_name: [
                    { required: true, message: 'Please select Brand Name', trigger: 'change' }
                ],
                plate_number: [
                    { required: true, message: 'Please input Plate Number', trigger: 'blur' }
                ],
                status: [
                    { required: true, message: 'Please select Status', trigger: 'blur' }
                ],
            },
            fileList: [],
            list_type: 'picture',
            disableButton: false,
        }
    },
    created() {
        if(this.editData && this.editData.id) {
            this.ruleForm  = {
                id: this.editData.id,
                brand_name: this.editData.brand_name,
                body_type: this.editData.body_type,
                plate_number: this.editData.plate_number,
                assigned_to: this.editData.assigned_to,
                date_acquired: this.editData.date_acquired,
                cost: this.editData.cost,
                status: this.editData.status,
            }
            if(this.editData.photo) this.fileList = [{name: this.editData.photo, url: `/storage/truck_vehicle/photo/${this.editData.photo}`}]
        }
        this.$EventDispatcher.listen('handleCloseTruck', data => {
            this.resetForm('ruleForm')
        });

        this.$EventDispatcher.listen('handleCloseUpdateTruck', data => {
            this.ruleForm  = {
                id: data.id,
                brand_name: data.brand_name,
                body_type: data.body_type,
                plate_number: data.plate_number,
                assigned_to: data.assigned_to,
                date_acquired: data.date_acquired,
                cost: data.cost,
                status: data.status,
            }
            if(data.photo) this.fileList = [{name: data.photo, url: `/storage/truck_vehicle/photo/${data.photo}`}]
            else this.fileList.splice(1,1)
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.update();
                }
                else {
                    this.store();
                }
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        async store() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.ruleForm.brand_name)formData.append('brand_name', this.ruleForm.brand_name);
                if(this.ruleForm.plate_number)formData.append('plate_number', this.ruleForm.plate_number);
                if(this.ruleForm.body_type)formData.append('body_type', this.ruleForm.body_type);
                if(this.ruleForm.date_acquired)formData.append('date_acquired', this.$df.formatDate(this.ruleForm.date_acquired, "YYYY-MM-DD"));
                if(this.ruleForm.cost)formData.append('cost', this.ruleForm.cost);
                if(this.ruleForm.assigned_to)formData.append('assigned_to', this.ruleForm.assigned_to);
                if(this.ruleForm.photo)formData.append('photo', this.ruleForm.photo);
                if(this.ruleForm.status)formData.append('status', this.ruleForm.status);

                // const res = await this.$API.TruckVehicle.storeTruckVehicle(formData);
                const response = await this.$API.TruckVehicle.addTruckVehicle(formData);

                this.resetForm('ruleForm');

                this.$EventDispatcher.fire('ADD_NEW_TRUCK_VEHICLE', response.data);

                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.disableButton = false;

            } catch (error) {
                console.log(error);
            }
        },
        async update() {
            this.disableButton = true;
            try {
                let formData = new FormData();
                if(this.ruleForm.brand_name)formData.append('brand_name', this.ruleForm.brand_name);
                if(this.ruleForm.plate_number)formData.append('plate_number', this.ruleForm.plate_number);
                if(this.ruleForm.body_type)formData.append('body_type', this.ruleForm.body_type);
                if(this.ruleForm.date_acquired)formData.append('date_acquired', this.$df.formatDate(this.ruleForm.date_acquired, "YYYY-MM-DD"));
                if(this.ruleForm.cost)formData.append('cost', this.ruleForm.cost);
                if(this.ruleForm.assigned_to)formData.append('assigned_to', this.ruleForm.assigned_to);
                if(this.ruleForm.photo)formData.append('photo', this.ruleForm.photo);
                if(this.ruleForm.status)formData.append('status', this.ruleForm.status);

                // const res = await this.$API.TruckVehicle.storeTruckVehicle(formData);
                const response = await this.$API.TruckVehicle.updateTruckVehicle(this.ruleForm.id, formData);

                this.$notify({
                    title: 'Success',
                    message: 'Successfully Updated!',
                    type: 'success'
                });

                this.$EventDispatcher.fire('UPDATED_TRUCK_VEHICLE', response.data);
                this.disableButton = false
            } catch (error) {
                console.log(error);
            }
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.fileList.splice(1,1)
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
