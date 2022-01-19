<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <div class="row">
                <div class="col-md-4">
                    <el-form-item label="Name" prop="name">
                        <el-input v-model="form.name" placeholder="Name"></el-input>
                    </el-form-item>
                    <el-form-item label="Contact Number" prop="contact_no">
                        <el-input @keypress.native="isNumber($event)" v-model="form.contact_no" placeholder="09**********..."></el-input>
                    </el-form-item>
                    <el-form-item label="Contact Person" prop="contact_person">
                        <el-input v-model="form.contact_person" placeholder="Contact Person"></el-input>
                    </el-form-item>
                    <el-form-item label="Email" prop="email">
                        <el-input v-model="form.email" placeholder="Email..."></el-input>
                    </el-form-item>
                    <el-form-item label="Delivery Time" prop="delivery_time">
                        <el-input v-model="form.delivery_time" placeholder="Example: Every 3 Days"></el-input>
                    </el-form-item>
                    <el-form-item label="Address" prop="address">
                        <el-input type="textarea" v-model="form.address" placeholder="Address"></el-input>
                    </el-form-item>
                </div>
                <div class="col-md-4">
                    <el-form-item label="Billing Name" prop="billing_name">
                        <el-input  v-model="form.billing_name" placeholder="Billing Name"></el-input>
                    </el-form-item>
                    <el-form-item label="Billing Country" prop="billing_country">
                        <el-input  v-model="form.billing_country" placeholder="Billing Country"></el-input>
                    </el-form-item>
                    <el-form-item label="Billing State" prop="billing_state">
                        <el-input  v-model="form.billing_state" placeholder="Billing State"></el-input>
                    </el-form-item>
                    <el-form-item label="Billing City" prop="billing_city">
                        <el-input  v-model="form.billing_city" placeholder="Billing City"></el-input>
                    </el-form-item>
                    <el-form-item label="Billing Phone" prop="billing_phone">
                        <el-input  v-model="form.billing_phone" @keypress.native="isNumber($event)" placeholder="Billing Phone"></el-input>
                    </el-form-item>
                    <el-form-item label="Billing Zip" prop="billing_zip">
                        <el-input  v-model="form.billing_zip" placeholder="Billing Zip"></el-input>
                    </el-form-item>
                    <el-form-item label="Billing Address" prop="billing_address">
                        <el-input  v-model="form.billing_address" placeholder="Billing Address"></el-input>
                    </el-form-item>
                </div>
                <div class="col-md-4">
                    <el-button size="mini" style="float:right" type="primary" @click="copy">Shipping Same as Billing</el-button>
                    <el-form-item label="Shipping Name" prop="shipping_name">
                        <el-input  v-model="form.shipping_name" placeholder="Shipping Name"></el-input>
                    </el-form-item>
                    <el-form-item label="Shipping Country" prop="shipping_country">
                        <el-input  v-model="form.shipping_country" placeholder="Shipping Country"></el-input>
                    </el-form-item>
                    <el-form-item label="Shipping State" prop="shipping_state">
                        <el-input  v-model="form.shipping_state" placeholder="Shipping State"></el-input>
                    </el-form-item>
                    <el-form-item label="Shipping City" prop="shipping_city">
                        <el-input  v-model="form.shipping_city" placeholder="Shipping City"></el-input>
                    </el-form-item>
                    <el-form-item label="Shipping Phone" prop="shipping_phone">
                        <el-input  v-model="form.shipping_phone" @keypress.native="isNumber($event)" placeholder="Shipping Phone"></el-input>
                    </el-form-item>
                    <el-form-item label="Shipping Zip" prop="shipping_zip">
                        <el-input  v-model="form.shipping_zip" placeholder="Shipping Zip"></el-input>
                    </el-form-item>
                    <el-form-item label="Shipping Address" prop="shipping_address">
                        <el-input  v-model="form.shipping_address" placeholder="Shipping Address"></el-input>
                    </el-form-item>
                </div>
                <div class="col-md-12">
                    <el-form-item style="float:right">
                        <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                        <el-button :disabled="disableButton" v-if="mode != 'update'" @click="resetForm('form')">Reset</el-button>
                    </el-form-item>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'SupplierForm',
    props: {
        mode: null,
        model: {}
    },
    data() {
        return {
            form: {
                name: '',
                contact_no: '',
                contact_person: '',
                delivery_time: '',
                address: '',
                email: '',
                billing_name: '',
                billing_country: '',
                billing_state: '',
                billing_city: '',
                billing_phone: '',
                billing_zip: '',
                billing_address: '',
                shipping_name: '',
                shipping_country: '',
                shipping_state: '',
                shipping_city: '',
                shipping_phone: '',
                shipping_zip: '',
                shipping_address: '',
            },
            rules:{
                name: [
                    {required: true, message: 'Please input Name', trigger: 'blur'}
                ],
                contact_no: [
                    {required: true, message: 'Please input Contact Number', trigger: 'blur'},
                    {min: 11, max: 11, message: 'Length should be 11 ', trigger: 'blur' },
                ],
                contact_person: [
                    {required: true, message: 'Please input Contact Person', trigger: 'blur'}
                ],
                address: [
                    {required: true, message: 'Please input Address', trigger: 'blur'}
                ],
                email: [
                    {required: true, message: 'Please input Email', trigger: 'blur'},
                    {type: 'email', required: true, message: 'Please input Valid Email', trigger: 'blur'}
                ],
                billing_name: [
                    {required: true, message: 'Please input Billing Name', trigger: 'blur'}
                ],
                billing_country: [
                    {required: true, message: 'Please input Billing Country', trigger: 'blur'}
                ],
                billing_state: [
                    {required: true, message: 'Please input Billing State', trigger: 'blur'}
                ],
                billing_city: [
                    {required: true, message: 'Please input Billing City', trigger: 'blur'}
                ],
                billing_phone: [
                    {required: true, message: 'Please input Billing Phone', trigger: 'blur'},
                    {min: 11, max: 11, message: 'Length should be 11 ', trigger: 'blur' },
                ],
                billing_zip: [
                    {required: true, message: 'Please input Billing Zip', trigger: 'blur'}
                ],
                billing_address: [
                    {required: true, message: 'Please input Billing Address', trigger: 'blur'}
                ],
                shipping_name: [
                    {required: true, message: 'Please input Shipping Name', trigger: 'blur'}
                ],
                shipping_country: [
                    {required: true, message: 'Please input Shipping Country', trigger: 'blur'}
                ],
                shipping_state: [
                    {required: true, message: 'Please input Shipping State', trigger: 'blur'}
                ],
                shipping_city: [
                    {required: true, message: 'Please input Shipping City', trigger: 'blur'}
                ],
                shipping_phone: [
                    {required: true, message: 'Please input Shipping Phone', trigger: 'blur'},
                    {min: 11, max: 11, message: 'Length should be 11 ', trigger: 'blur' },
                ],
                shipping_zip: [
                    {required: true, message: 'Please input Shipping Zip', trigger: 'blur'}
                ],
                shipping_address: [
                    {required: true, message: 'Please input Shipping Address', trigger: 'blur'}
                ],
            },
            disableButton: false,
        }
    },
    created() {
        if(this.model && this.model.id) {
            this.form = {
                name: this.model.name,
                contact_no: this.model.contact_no,
                contact_person: this.model.contact_person,
                delivery_time: this.model.delivery_time,
                address: this.model.address,
                email: this.model.email,
                billing_name: this.model.billing_name,
                billing_country: this.model.billing_country,
                billing_state: this.model.billing_state,
                billing_city: this.model.billing_city,
                billing_phone: this.model.billing_phone,
                billing_zip: this.model.billing_zip,
                billing_address: this.model.billing_address,
                shipping_name: this.model.shipping_name,
                shipping_country: this.model.shipping_country,
                shipping_state: this.model.shipping_state,
                shipping_city: this.model.shipping_city,
                shipping_phone: this.model.shipping_phone,
                shipping_zip: this.model.shipping_zip,
                shipping_address: this.model.shipping_address,
            }
        }

        this.$EventDispatcher.listen('handClose', data => {
            this.resetForm('form')
        });
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                if(this.mode == 'update') {
                    this.updateSupplier();
                    return
                }
                console.log('running sssss');
                this.storeSupplier();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        async storeSupplier() {
            this.disableButton = true;
            try {

                const res = await this.$API.SupplierManagement.storeSupplier(this.form);

                this.$EventDispatcher.fire('ADD_NEW_SUPPLIER', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });

                this.resetForm('form');
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async updateSupplier() {
            this.disableButton = true;
            try {

                const res = await this.$API.SupplierManagement.updateSupplier(this.model.id, this.form);

                this.$EventDispatcher.fire('UPDATE_SUPPLIER', res.data);
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
        isNumber(evt) {
            evt = (evt) ? evt : window.event;
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },
        copy() {
            const newShiiping = {
                shipping_name: this.form.billing_name,
                shipping_country: this.form.billing_country,
                shipping_state : this.form.billing_state,
                shipping_city : this.form.billing_city,
                shipping_phone : this.form.billing_phone,
                shipping_zip : this.form.billing_zip,
                shipping_address : this.form.billing_address,
            }

            const form = this.form

            this.form = {...form, ...newShiiping}
        }
    },
    watch: {
        model(newVal, oldVal) {
            if(newVal != oldVal) {
                this.form = {
                    name: newVal.name,
                    contact_no: newVal.contact_no,
                    contact_person: newVal.contact_person,
                    delivery_time: newVal.delivery_time,
                    address: newVal.address,
                    email: newVal.email,
                    billing_name: newVal.billing_name,
                    billing_country: newVal.billing_country,
                    billing_state: newVal.billing_state,
                    billing_city: newVal.billing_city,
                    billing_phone: newVal.billing_phone,
                    billing_zip: newVal.billing_zip,
                    billing_address: newVal.billing_address,
                    shipping_name: newVal.shipping_name,
                    shipping_country: newVal.shipping_country,
                    shipping_state: newVal.shipping_state,
                    shipping_city: newVal.shipping_city,
                    shipping_phone: newVal.shipping_phone,
                    shipping_zip: newVal.shipping_zip,
                    shipping_address: newVal.shipping_address,
                }
            }
        },
        mode(val) {
            if(val == 'create') {
                this.form = {
                    name: '',
                    contact_no: '',
                    contact_person: '',
                    delivery_time: '',
                    address: ''
                }
            }
        }
    }
}
</script>
