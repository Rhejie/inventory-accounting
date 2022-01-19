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
                    :data="proposal"
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
                            prop="proposal_number"
                            label="Prop No."
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="customer.name"
                            label="Customer"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="project.name"
                            label="Project"
                            show-overflow-tooltip
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            prop="issue_date"
                            label="Issue Date"
                            :sortable="true">
                        </el-table-column>
                        <el-table-column
                            label="Status"
                            prop="status"
                            :sortable="true">
                                <template slot-scope="scope">
                                    <el-tag effect="dark" v-if="scope.row.status == 0" type="info">Draft</el-tag>
                                    <el-tag effect="dark" v-if="scope.row.status == 1" type="success">Open</el-tag>
                                    <el-tag effect="dark" v-if="scope.row.status == 2" type="success">Accepted</el-tag>
                                    <el-tag effect="dark" v-if="scope.row.status == 3" type="danger">Declined</el-tag>
                                    <el-tag effect="dark" v-if="scope.row.status == 4" type="warning">Close</el-tag>
                                </template>
                        </el-table-column>
                        <el-table-column
                            fixed="right"
                            width="230"
                            label="Action">
                            <template slot-scope="scope">
                                <el-button
                                    size="mini"
                                    type="text"
                                    @click="handleInvoice(scope.$index, scope.row)">
                                        Convert
                                </el-button>
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
                    :pagination="proposalPagination"
                    :total="filters.total"
                    @handleSizeChange="handleSizeChange"
                    @handleCurrentChange="handleCurrentChange">
                </global-pagination>
            </div>
        </el-card>
    </div>
</template>
<script>
    import paginate from '../../../mixin/pagination'
    export default {
        name: 'ProposalList',
        mixins: [paginate],
        props: {
            pageData: {}
        },
        data() {
            return {
                proposal: [],
                proposalPagination: [],
                loading: false,
                current_page: 1,
                current_size: 25,
                search: null,
                mode: '',
                model: {},
                dialogFormVisible: false
            }
        },
        created() {
            this.getProposals();
        },
        methods: {
            async getProposals() {
                try {
                    this.loading = true;
                    let params = {
                        current_size: this.current_size,
                        current_page: this.current_page,
                        search: this.search,
                    };
                    const res = await this.$API.Proposal.getProposals(params);
                    this.proposal = res.data.data
                    this.proposalPagination = res.data
                    this.loading = false;

                } catch (error) {
                    console.log(error);
                }
            },
            addNew() {
                this.$router.push({name: 'Create Proposal'})
            },
            handleEdit(index, data) {
                this.$router.push({name: 'Update Proposal', params: {id: data.id, model: data, mode: 'update', pageData : this.pageData} })
            },
            handleView(index, data) {
                this.$router.push({name: 'Proposal View', params : {id : data.id, model : data , pageData : this.pageData} })
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
                    await this.$API.Proposal.deleteProposal(data.id)
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Deleted',
                        type: 'success'
                    });
                    this.proposal.splice(index, 1)
                } catch (error) {
                    console.log(error);
                }
            },
            handleInvoice(index, data) {
                if(data.invoice && data.invoice.id) {
                    this.$message({
                        type: 'success',
                        message: 'Already Converted into Invoice'
                    });
                    return
                }

                if(data.is_converted) {
                    this.$message({
                        type: 'success',
                        message: 'Already Converted into Invoice'
                    });
                    return
                }
                this.$confirm('Convert into Invoice?', 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                    }).then(() => {
                        this.convertInvoice(index, data);
                    }).catch(() => {
                        this.$message({
                            type: 'info',
                            message: 'Canceled'
                        });
                    });
            },
            async convertInvoice(index, data) {
                try {
                    const res = await this.$API.Proposal.convertToInvoice(data.id)
                    if(res.data == 'converted') {
                        this.$message({
                            type: 'success',
                            message: 'Already Converted into Invoice'
                        });
                        return
                    }
                    this.$notify({
                        title: 'Success',
                        message: 'Successfully Converted',
                        type: 'success'
                    });
                } catch (error) {
                    console.log(error);
                }
            },
            handleSizeChange(val) {
                this.current_size = val;
                this.getProposals();
            },
            handleCurrentChange(val) {
                this.current_page = val;
                this.getProposals();
            },
            applySearch() {
                this.getProposals();
            },
        },
        watch: {
            search(val) {
                if( val == '') {
                    this.getProposals();
                }
            }
        }
    }
</script>
