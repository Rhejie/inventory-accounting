<template>
    <div>
        <el-card class="box-card">
            <div class="text item">
                <el-input
                    size="mini"
                    placeholder="Search here....."
                    style="width:300px; float:right; margin-bottom: 10px"
                    @keyup.enter.native="applySearch"
                    v-model="search">
                </el-input>
                <el-table
                    :data="customers"
                    v-loading="loading"
                    style="width: 100%">
                        <el-table-column
                            width="70"
                            label="No."
                            :sortable="true">
                                <template slot-scope="scope">
                                    {{scope.$index + 1}}
                                </template>
                        </el-table-column>
                        <el-table-column
                            label="Name"
                            prop="name"
                            show-overflow-tooltip
                            :sortable="true">
                                <!--<template slot-scope="scope">
                                    <el-button type="text" @click="viewCustomer(scope.row)">{{scope.row.name}}</el-button>
                                </template> -->
                        </el-table-column>
                        <el-table-column
                            prop="email"
                            label="Email"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="contact"
                            label="Contact"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="150"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                    size="mini"
                                    type="text"
                                    @click="handleEdit(scope.$index, scope.row)">
                                        Edit
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="text"
                                    @click="handleView(scope.$index, scope.row)">
                                        View
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="text"
                                    @click="askToDelete(scope.$index, scope.row)">
                                        Delete
                                </el-button>
                            </template>
                        </el-table-column>
                </el-table>
                <global-pagination
                    :current_page="current_page"
                    :current_size="current_size"
                    :pagination="customersPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
        <el-dialog :title="title" width="60%" :visible.sync="dialogFormVisible" :before-close="handleClose">
            <customer-form :mode="mode" :isView="isView" :model="model"></customer-form>
        </el-dialog>
    </div>
</template>
<script>
    import paginate from '../../../mixin/pagination'
    export default {
        name: 'ServiceList',
        mixins: [paginate],
        data() {
            return {
                customers: [],
                customersPagination: [],
                loading: false,
                current_page: 1,
                current_size: 25,
                search: null,
                mode: '',
                model: {},
                dialogFormVisible: false,
                isView: false,
                title: ''
            }
        },
        created() {
            this.getCustomers()

            this.$EventDispatcher.listen('ADD_NEW_CUSTOMER', data => {
                this.customers.unshift(data);
                this.dialogFormVisible = false
            })

            this.$EventDispatcher.listen('UPDATE_CUSTOMER', data => {
                this.customers.forEach(customer  => {
                    if(customer.id == data.id) {
                        for(let key in data) {
                            customer[key] = data[key]
                        }
                    }
                })
                this.dialogFormVisible = false
            })
        },
        methods: {
            async getCustomers() {
                try {
                    this.loading = true;
                    let params = {
                        current_size: this.current_size,
                        current_page: this.current_page,
                        search: this.search,
                    };

                    const res = await this.$API.Customer.getCustomers(params);
                    this.customers = res.data.data
                    this.customersPagination = res.data
                    this.loading = false
                } catch (error) {
                    console.log(error)
                }
            },
            addCustomer() {
                this.mode = 'create'
                this.model = {}
                this.dialogFormVisible = true
                this.isView = false
                this.title = 'Add Customer'
            },
            handleClose(done) {
                this.mode = ''
                this.model = {}
                this.$EventDispatcher.fire('CLOSE_CUSTOMER');
                done();
            },
            handleEdit(index, data) {
                this.mode = 'update'
                this.model = data
                this.title = 'Update Customer'
                this.isView = false
                this.dialogFormVisible = true
            },
            askToDelete(index, data) {
                this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                    }).then(() => {
                        this.delete(index, data);
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: 'Delete canceled'
                        });
                    });
            },
            async delete(index, data) {
                try {
                    await this.$API.Customer.deleteCustomer(data.id)
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Deleted',
                        type: 'success'
                    });
                    this.customers.splice(index, 1)
                } catch (error) {
                    console.log(error);
                }
            },
            handleView(index, data) {
                this.mode = 'update'
                this.model = data
                this.title = 'Customer Details'
                this.dialogFormVisible = true
                this.isView = true
            },
            viewCustomer(data) {
                this.$router.push({name: 'View Customer', params : {id: data.id, model: data} })
            },
            handleSizeChange(val) {
                this.current_size = val;
                this.getCustomers();
            },
            handleCurrentChange(val) {
                this.current_page = val;
                this.getCustomers();
            },
            applySearch() {
                this.getCustomers();
            },
        },
        watch: {
            search(val) {
                if( val == '') {
                    this.getCustomers();
                }
            }
        }
    }
</script>
