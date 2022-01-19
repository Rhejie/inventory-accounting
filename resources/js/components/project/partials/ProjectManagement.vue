<template>
    <div>
        <el-row>
            <el-button type="info" size="small">Add Item Group</el-button>
            <el-button type="info" size="small">Copy From Existing Project</el-button>
        </el-row>
        <div v-for="(data, index) in tableData" :key="index">
            <table class="table">
                <thead class="table-borderless">
                    <th colspan="10 custom_head_table">
                    </th>
                    <th class="total custom_head_table">Budget</th>
                    <th class="total custom_head_table">Actual</th>
                    <th class="total custom_head_table">Under/Over</th>
                </thead>
                <thead class="custom_thead_proj table-bordered">
                    <th class="item_index project_title">{{index + 1}}</th>
                    <th>{{data.title}} <span style="float: right">{{data.percentage}}</span></th>
                    <th colspan="2">
                        <div class="custom_th_project_mngt">
                            <div class="background_icon_header_labor">
                                <i class="fas fa-user icon_center"></i>
                            </div>
                            <div>
                                Labor
                            </div>
                        </div>
                    </th>
                    <th colspan="2">
                        <div class="custom_th_project_mngt">
                            <div class="background_icon_header_equipment">
                                <i class="fas fa-cogs icon_center"></i>
                            </div>
                            <div>
                                Equipment
                            </div>
                        </div>
                    </th>
                    <th colspan="2">
                        <div class="custom_th_project_mngt">
                            <div class="background_icon_header_materials">
                                <i class="fas fa-cube icon_center"></i>
                            </div>
                            <div>
                                Materials
                            </div>
                        </div>
                    </th>
                    <th colspan="2">
                        <div class="custom_th_project_mngt">
                            <div class="background_icon_header_other_cost">
                                <i class="fas fa-hand-holding-usd icon_center"></i>
                            </div>
                            <div>
                                Others Cost
                            </div>
                        </div>
                    </th>
                    <th class="total">₱ {{data.total_budget}}</th>
                    <th class="total">₱ {{data.total_actual}}</th>
                    <th class="total">₱ {{data.total_under_over}}</th>
                </thead>
                <tbody class="table-bordered tbody_bordered_style_custom">
                    <tr v-for="(value, index) in data.item_project" :key="index">
                        <td class="item_title_index">
                            <div class="item_index">
                                {{index + 1}}
                            </div>
                        </td>
                        <td @click="updateItem(value)" class=" item_title_click">
                            <div class="item_title">
                                 {{value.title_item}} <span style="float:right">{{value.percentage}}</span>
                            </div>
                       </td>
                        <td class="labor">
                            <div class="align_content_center" v-if="value.labor_details.labor_hrs">
                                <div class="labor_hrs">
                                    {{value.labor_details.labor_hrs}}
                                </div>
                                <div>
                                    {{value.labor_details.labor_hrs_cost | isEmpty}}
                                </div>
                            </div>
                            <div v-else>
                                <div class="plus_icon_wrapper">
                                    <i class="fas fa-plus-circle plus_icon"></i>
                                </div>
                            </div>
                        </td>
                        <td class="labor">
                            <div class="align_content_center">
                                <div class="labor_hrs">
                                    {{value.labor_details.labor_count}}
                                </div>
                                <div>
                                    {{value.labor_details.labor_count_cost | isEmpty}}
                                </div>
                            </div>
                        </td>
                        <td class="labor">
                            <div class="align_content_center" v-if="value.equipment_details.equipment_hrs">
                                <div class="labor_hrs">
                                    {{value.equipment_details.equipment_hrs}}
                                </div>
                                <div>
                                    {{value.equipment_details.equipment_hrs_cost | isEmpty}}
                                </div>
                            </div>
                            <div v-else>
                                <div class="plus_icon_wrapper">
                                    <i class="fas fa-plus-circle plus_icon"></i>
                                </div>
                            </div>
                        </td>
                        <td class="labor">
                            <div :class="'align_content_center ' + value.equipment_details.equipment_count ? 'empty_value' : ''">
                                <div class="labor_hrs">
                                    {{value.equipment_details.equipment_count}}
                                </div>
                                <div>
                                    {{value.equipment_details.equipment_count_cost | isEmpty}}
                                </div>
                            </div>
                        </td>
                        <td class="labor">
                            <div class="align_content_center" v-if="value.material_details.material_item">
                                <div class="labor_hrs">
                                    {{value.material_details.material_item}}
                                </div>
                                <div>
                                    {{value.material_details.material_item_cost | isEmpty}}
                                </div>
                            </div>
                            <div v-else>
                                <div class="plus_icon_wrapper">
                                    <i class="fas fa-plus-circle plus_icon"></i>
                                </div>
                            </div>
                        </td>
                        <td class="labor">
                            <div :class="'align_content_center  ' + value.material_details.material_count ? 'empty_value' : ''">
                                <div class="labor_hrs">
                                    {{value.material_details.material_count}}
                                </div>
                                <div>
                                    {{value.material_details.material_count_cost | isEmpty}}
                                </div>
                            </div>
                        </td>
                        <td class="labor">
                            <div class="align_content_center" v-if="value.material_details.material_item">
                                <div class="labor_hrs">
                                    {{value.other_cost_details.other_cost_item}}
                                </div>
                                <div>
                                    {{value.other_cost_details.other_cost_item_cost | isEmpty}}
                                </div>
                            </div>
                            <div v-else>
                                <div class="plus_icon_wrapper">
                                    <i class="fas fa-plus-circle plus_icon"></i>
                                </div>
                            </div>
                        </td>
                        <td class="labor">
                            <div class="align_content_center">
                                <div class="labor_hrs">
                                    {{value.other_cost_details.other_cost_count}}
                                </div>
                                <div>
                                        {{value.other_cost_details.other_cost_count_cost | isEmpty}}
                                </div>
                            </div>
                        </td>
                        <td class="total">
                            ₱ {{value.project_budget}}
                        </td>
                        <td class="total">
                            ₱ {{value.project_actual}}
                        </td>
                        <td class="total">
                            ₱ {{value.project_under_over}}
                        </td>
                    </tr>
                </tbody>
                <tfoot class="table-bordered">
                    <th colspan="2" @click="storeActionItem" class="item_title_click">
                        <div class="footer_action_item">
                            <i class="fas fa-plus-circle plus_icon"></i> {{data.footer.title}}
                        </div>
                    </th>
                    <th>
                        <div class="footer_action_total">
                            {{data.footer.total_labor_hrs_cost | isEmpty}}
                        </div>
                    </th>
                    <th>
                        <div class="footer_action_total">
                            {{data.footer.total_labor_count_cost | isEmpty}}
                        </div>
                    </th>
                    <th>
                        <div class="footer_action_total">
                            {{data.footer.total_equipment_hrs_cost | isEmpty}}
                        </div>
                    </th>
                    <th>
                        <div class="footer_action_total">
                            {{data.footer.total_equipment_count_cost | isEmpty}}
                        </div>
                    </th>
                    <th>
                        <div class="footer_action_total">
                            {{data.footer.total_material_item_cost | isEmpty}}
                        </div>
                    </th>
                    <th>
                        <div class="footer_action_total">
                            {{data.footer.total_material_count_cost | isEmpty}}
                        </div>
                    </th>
                    <th>
                        <div class="footer_action_total">
                            {{data.footer.total_other_item_cost | isEmpty}}
                        </div>
                    </th>
                    <th>
                        <div class="footer_action_total">
                            {{data.footer.total_other_count_cost | isEmpty}}
                        </div>
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tfoot>
            </table>

        </div>

        <el-dialog :title=" mode == 'create' ? 'Add Action Item' : 'Update Action Item'" width="40%" :visible.sync="dialogTableVisible">
            <project-management-form :edit-data="editData"></project-management-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: 'ProjectManagement',
    data() {
        return {
            tableData: [
                {
                    title: 'Site Preparation',
                    percentage: '65%',
                    total_budget: '12,850.00',
                    total_actual: '1,105.00',
                    total_under_over: '11,745.00',
                    item_project : [
                        {
                            title_item : 'Remove all plants and concrete',
                            percentage: '92%',
                            labor_details: {
                                labor_hrs: '300 HRS',
                                labor_hrs_cost: '7,500.00',
                                labor_count: '1',
                                labor_count_cost: '105.0',
                            },
                            equipment_details : {
                                equipment_hrs : '30 HRS',
                                equipment_hrs_cost: '300.00',
                                equipment_count: '',
                                equipment_count_cost: ''
                            },
                            material_details : {
                                material_item : '1 ITEM',
                                material_item_cost: '1050.00',
                                material_count: '',
                                material_count_cost: ''
                            },
                            other_cost_details : {
                                other_cost_item : '1 ITEM',
                                other_cost_item_cost: '1050.00',
                                other_cost_count: '1',
                                other_cost_count_cost: '1000.00'
                            },
                            project_budget: '12,850.00',
                            project_actual: '1,105.00',
                            project_under_over: '11,745.00',
                        },
                        {
                            title_item : 'Spray weed Killer',
                            percentage: '90%',
                            labor_details: {
                                labor_hrs: '',
                                labor_hrs_cost: '',
                                labor_count: '',
                                labor_count_cost: '',
                            },
                            equipment_details : {
                                equipment_hrs : '',
                                equipment_hrs_cost: '',
                                equipment_count: '',
                                equipment_count_cost: ''
                            },
                            material_details : {
                                material_item : '',
                                material_item_cost: '',
                                material_count: '',
                                material_count_cost: ''
                            },
                            other_cost_details : {
                                other_cost_item : '',
                                other_cost_item_cost: '',
                                other_cost_count: '',
                                other_cost_count_cost: ''
                            },
                            project_budget: '0.00',
                            project_actual: '0.00',
                            project_under_over: '0.00',
                        },
                        {
                            title_item : 'Compacting',
                            percentage: '70%',
                            labor_details: {
                                labor_hrs: '',
                                labor_hrs_cost: '',
                                labor_count: '',
                                labor_count_cost: '',
                            },
                            equipment_details : {
                                equipment_hrs : '',
                                equipment_hrs_cost: '',
                                equipment_count: '',
                                equipment_count_cost: ''
                            },
                            material_details : {
                                material_item : '',
                                material_item_cost: '',
                                material_count: '',
                                material_count_cost: ''
                            },
                            other_cost_details : {
                                other_cost_item : '',
                                other_cost_item_cost: '',
                                other_cost_count: '',
                                other_cost_count_cost: ''
                            },
                            project_budget: '0.00',
                            project_actual: '0.00',
                            project_under_over: '0.00',
                        },
                        {
                            title_item : 'Foundation',
                            percentage: '74%',
                            labor_details: {
                                labor_hrs: '',
                                labor_hrs_cost: '',
                                labor_count: '',
                                labor_count_cost: '',
                            },
                            equipment_details : {
                                equipment_hrs : '',
                                equipment_hrs_cost: '',
                                equipment_count: '',
                                equipment_count_cost: ''
                            },
                            material_details : {
                                material_item : '',
                                material_item_cost: '',
                                material_count: '',
                                material_count_cost: ''
                            },
                            other_cost_details : {
                                other_cost_item : '',
                                other_cost_item_cost: '',
                                other_cost_count: '',
                                other_cost_count_cost: ''
                            },
                            project_budget: '0.00',
                            project_actual: '0.00',
                            project_under_over: '0.00',
                        },
                        {
                            title_item : 'Dig',
                            percentage: '0%',
                            labor_details: {
                                labor_hrs: '',
                                labor_hrs_cost: '',
                                labor_count: '',
                                labor_count_cost: '',
                            },
                            equipment_details : {
                                equipment_hrs : '',
                                equipment_hrs_cost: '',
                                equipment_count: '',
                                equipment_count_cost: ''
                            },
                            material_details : {
                                material_item : '',
                                material_item_cost: '',
                                material_count: '',
                                material_count_cost: ''
                            },
                            other_cost_details : {
                                other_cost_item : '',
                                other_cost_item_cost: '',
                                other_cost_count: '',
                                other_cost_count_cost: ''
                            },
                            project_budget: '0.00',
                            project_actual: '0.00',
                            project_under_over: '0.00',
                        }
                    ],
                    footer: {
                        total_labor_hrs_cost : '7,500.00',
                        total_labor_count_cost: '105.00',
                        total_equipment_hrs_cost: '300.00',
                        total_equipment_count_cost: '0.00',
                        total_material_item_cost: '1,050.00',
                        total_material_count_cost: '0.00',
                        total_other_item_cost: '1,050.00',
                        total_other_count_cost: '1,050.00',
                    }
                },
            ],
            dialogTableVisible: false,
            mode: 'create',
            editData: {}
        }
    },
    created() {
        this.tableData.forEach(data => {
            data.footer.title = 'Add Action Item '
        })
    },
    methods: {
        storeActionItem() {
            this.dialogTableVisible = true;
            this.mode = 'create';
        },
        updateItem(data) {
            this.dialogTableVisible = true;
            this.editData = data
            this.mode = 'update'
        }
    },
    filters : {
        isEmpty(val) {
            if(val != '') {
                return '₱ ' + val;
            }
        }
    }
}
</script>
<style lang="scss">
    .table th {
        padding: 0 ;
    }
    .table td {
        padding: 0 ;
    }
    .labor {
        padding: 0;
    }
    .align_content_center {
        text-align: center;

        .labor_hrs{
            background-color: #ebebeb;
            margin: 0;
            width: 100%;

        }
    }

    .item_index {
        text-align: center;
        padding: 10px;
    }

    .project_title {
        background-color: grey;
    }

    .item_title {
        vertical-align: middle;
        padding: 5px;
        height: 100%;
    }

    .item_title_index{
        background-color: #ebebeb;
    }
    .empty_value {
        width: 35px;
    }
    .total {
        text-align: right;
        vertical-align: middle;
        padding: 5px !important;
    }

    .custom_head_table{
        border-top-style: none !important;
        border-top-width: 0;
    }
    .custom_th_project_mngt {
        display: flex;
        flex-direction: row;
    }
    .background_icon_header_labor {
        background-color: #0376fa;
        margin-right: 10px;
        width: 38px;
        height: 30px;
    }


    .background_icon_header_equipment {
        background-color: #ffe600;
        margin-right: 10px;
        width: 38px;
        height: 30px;
    }


    .background_icon_header_materials {
        background-color: #906a00;
        margin-right: 10px;
        width: 38px;
        height: 30px;
    }

    .background_icon_header_other_cost {
        background-color: #0dff6a;
        margin-right: 10px;
        width: 38px;
        height: 30px;
    }

    .table .custom_thead_proj th {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    .icon_center {
       display: block;
        margin-left: auto;
        margin-top: 5px;
        margin-right: auto;
        width: 40%;
    }

    .plus_icon_wrapper{

        text-align: center;
        padding: 10px;
        cursor: pointer;

        .plus_icon {
            font-size: 25px;
        }

    }

    .footer_action_item{

        padding: 10px;
        font-size: 18px;
        .plus_icon {
            font-size: 20px;
        }
    }

    .footer_action_total{
        padding: 10px;
        text-align: center;
    }

    .item_title_click {
        cursor: pointer;
    }
</style>
