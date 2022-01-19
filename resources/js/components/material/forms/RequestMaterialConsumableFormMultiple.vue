<template>
    <div>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="demo-ruleForm">
            <el-form-item label="Date Requested" prop="date_requested">
                <el-date-picker disabled type="date" placeholder="Pick a Starting Date" v-model="form.date_requested"></el-date-picker>
            </el-form-item>
            <el-form-item label="Consumable Supply Items">
                <el-select
                    v-model="form.c_s_id"
                    style="margin-bottom: 10px;"
                    :filterable="true"
                    remote
                    reserve-keyword
                    @change="changeConsumableSupply"
                    placeholder="Search and Select Item...."
                    :remote-method="remoteMethod"
                    :loading="loading">
                        <el-button size="mini" style="margin-left: 10px" icon="el-icon-plus" @click="addNewConsumable">Add New</el-button>
                        <el-option
                            v-for="item in consumables"
                            :key="item.id"
                            :label="item.item_name"
                            :value="item.id">
                        </el-option>
                        <template slot="empty">
                            <el-button icon="el-icon-plus" size="mini" style="margin:10px" @click="addNewConsumable">Add New</el-button>
                        </template>
                </el-select>
                <el-table
                    ref="multipleTable"
                    :data="consumable_items"
                    border
                    style="width: 100%">
                        <el-table-column
                            label="Item Code"
                            prop="item_code">
                        </el-table-column>
                        <el-table-column
                            label="Item Name"
                            prop="item_name">
                        </el-table-column>
                        <el-table-column
                            label="Unit of Measure">
                            <template slot-scope="scope">
                                <template v-if="scope.row.newItem && scope.row.newItem == 'new'">
                                    <el-input v-model="scope.row.unit_of_measure"></el-input>
                                </template>
                                <template v-else>
                                    {{scope.row.unit_of_measure}}
                                </template>
                            </template>
                        </el-table-column>
                        <el-table-column
                            label="Quantity">
                            <template slot-scope="scope">
                                <el-input type="number" min="0" v-model="scope.row.quantity"></el-input>
                            </template>
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="180"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                size="mini"
                                type="text"
                                @click="askToDelete(scope.$index, scope.row)">Remove</el-button>
                            </template>
                        </el-table-column>
                </el-table>
            </el-form-item>
            <el-form-item>
                <div style="float: right;">
                    <el-button type="primary" :disabled="disableButton" @click="submitForm('form')">Save</el-button>
                    <el-button @click="resetForm('form')" :disabled="disableButton">Reset</el-button>
                </div>
            </el-form-item>
        </el-form>
    </div>
</template>
<script>
export default {
    name: 'RequestMaterialConsumableFormMultiple',
    props: {
        id: null,
        dateRequested: null,
        projectID: null
    },
    data() {
        return {
            form : {
                c_s_id: '',
                date_requested: '',
                material_request: '',
                quantity: '',
                unit: ''
            },
            newConsumable: '',
            rules: {
                date_requested: [
                    {required: true, message: 'Please input Date Requested', trigger: 'blur'}
                ],
            },
            disableButton: false,
            consumable_items: [],
            consumables: [],
            loading: false,
            loadingItems: false,
            allowToCreate: false,
        }
    },
    created() {
        this.form.date_requested = this.dateRequested
        this.$EventDispatcher.listen('handleCloseRMCMultiple', data => {
            this.resetForm('form')
        })
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate((valid) => {
            if (valid) {
                this.storeRequestMaterialConsumableSupply();
            } else {
                console.log('error submit!!');
                return false;
            }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
            this.consumable_items = [];
            this.consumables =[]
        },
        async storeRequestMaterialConsumableSupply() {
            this.disableButton = true;
            try {
                this.form.consumable_items = this.consumable_items;
                this.form.date_requested = this.$df.formatDate(this.form.date_requested, "YYYY-MM-DD")

                const res = await this.$API.RequestMaterial.storeRequestConsumable(this.id, this.form);
                this.$EventDispatcher.fire('NEW_REQUEST_MATERIAL_CONSUMABLE', res.data);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Added',
                    type: 'success'
                });
                this.resetForm('form')
                this.disableButton = false;
            } catch (error) {
                console.log(error);
            }
        },
        async remoteMethod(query) {
            this.newConsumable = query
            if (query !== '') {
                this.loading = true;
                try {
                    const res = await this.$API.RequestMaterial.getConsumableSupply(this.projectID, query);
                    this.consumables = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error);
                }
            } else {
                this.consumables = [];
            }
        },
        changeConsumableSupply(value) {

            let consumables = this.consumables.filter(consumable => consumable.id == value);
            if(consumables.length > 0) {
                let isExist = this.consumable_items.filter(item => item.id == value);
                if(isExist.length > 0) {
                    this.$notify.error({
                        title: 'Error',
                        message: 'The item is already exist'
                    });
                    return;
                }
                consumables[0].quantity = null
                this.consumable_items.unshift(consumables[0]);
                this.form.c_s_id = null
            }

            if(typeof(value) == "string"){
                let isExist = this.consumable_items.filter(item => item.item_name == value);
                if(isExist.length > 0) {
                    this.$notify.error({
                        title: 'Error',
                        message: 'The item is already exist'
                    });
                    return;
                }
                this.consumable_items.unshift({
                    item_name: value,
                    item_code: 'N/A',
                    bar_code: 'N/A',
                    description: 'N/A',
                    lot_number: 'N/A',
                    quantity: null,
                    reorder_point: 0,
                    project_id: this.projectID,
                    stock_on_hand: 0,
                    unit_of_measure: 'N/A',
                    newItem: 'new'
                });
                this.form.c_s_id = null
            }

            this.consumables = []
        },
        askToDelete(index, data) {
            this.$confirm('Are you sure you want to remove this file?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    let value = {
                        index,
                        data
                    }

                    this.consumable_items.splice(index, 1)

                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        addNewConsumable() {
            this.consumable_items.unshift({
                bar_code: 'N/A',
                description: 'N/A',
                item_code: 'N/A',
                item_name: this.newConsumable,
                lot_number: 'N/A',
                unit_of_measure: 'N/A',
                quantity: null,
                reorder_point: 0,
                project_id: this.projectID,
                stock_on_hand: 0,
                newItem: 'new'
            });
            this.form.c_s_id = ''
        },
    },
    watch: {
        consumables(val) {
            if(val.length == 0) {
                this.allowToCreate = true;
            }
        },
    }
}
</script>
