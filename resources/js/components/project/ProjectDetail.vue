<template>
    <div v-loading="loading">
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader"  style="position: relative;top:-25px">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-2">
                    <!--begin::Title-->
                    <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Projects</h5>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                    <!--end::Separator-->
                    <!--begin::Search Form-->
                    <!--div class="d-flex align-items-center" id="kt_subheader_search">
                        <span class="text-dark-50 font-weight-bold" id="projectTotal"></span>
                        <form class="ml-5">
                            <div class="input-group input-group-sm input-group-solid" style="max-width: 175px">
                                <input type="text" class="form-control" id="kt_subheader_search_form" placeholder="Search...">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="svg-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                                </g>
                                            </svg>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div -->
                    <div class="d-flex- align-items-center flex-wrap mr-2 d-none" id="kt_subheader_group_actions">
                        <div class="text-dark-50 font-weight-bold">
                        <span id="kt_subheader_group_selected_rows">23</span>Selected:</div>
                        <div class="d-flex ml-6">
                            <div class="dropdown mr-2" id="kt_subheader_group_actions_status_change">
                                <button type="button" class="btn btn-light-primary font-weight-bolder btn-sm dropdown-toggle" data-toggle="dropdown">Update Status</button>
                                <div class="dropdown-menu p-0 m-0 dropdown-menu-sm">
                                    <ul class="navi navi-hover pt-3 pb-4">
                                        <li class="navi-header font-weight-bolder text-uppercase text-primary font-size-lg pb-0">Change status to:</li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="status-change" data-status="1">
                                                <span class="navi-text">
                                                    <span class="label label-light-success label-inline font-weight-bold">Approved</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="status-change" data-status="2">
                                                <span class="navi-text">
                                                    <span class="label label-light-danger label-inline font-weight-bold">Rejected</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="status-change" data-status="3">
                                                <span class="navi-text">
                                                    <span class="label label-light-warning label-inline font-weight-bold">Pending</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="status-change" data-status="4">
                                                <span class="navi-text">
                                                    <span class="label label-light-info label-inline font-weight-bold">On Hold</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <button class="btn btn-light-success font-weight-bolder btn-sm mr-2" id="kt_subheader_group_actions_fetch" data-toggle="modal" data-target="#kt_datatable_records_fetch_modal">Fetch Selected</button>
                            <button class="btn btn-light-danger font-weight-bolder btn-sm mr-2" id="kt_subheader_group_actions_delete_all">Delete All</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <!--begin::Button-->
                    <a href="/metronic/demo1/.html" class=""></a>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" class="btn btn-danger btn-shadow font-weight-bold mr-2 btn-sm" @click="askToDelete">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="button" class="btn btn-success btn-shadow font-weight-bold mr-2 btn-sm" @click="editProject">
                        <i class="far fa-edit"></i> Edit
                    </button>

                    <!--end::Button-->
                    <!--begin::Dropdown-->
                    <!--end::Dropdown-->
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid" >
            <!--begin::Container-->
            <div class="container-fluid">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="d-flex">
                            <!--begin: Pic-->
                            <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                                <div class="symbol symbol-50 symbol-lg-120">
                                    <!-- <img :src="`/storage/project/photo/${project.photo}`" class="img-fluid"> -->
                                    <el-image
                                        v-if="project.photo"
                                        style="width: 200px; height: auto;"
                                        lazy
                                        :src="`/storage/project/photo/${project.photo}`"
                                        :preview-src-list="srcList">
                                    </el-image>

                                    <el-image v-if="!project.photo" style="width: 200px; height: auto" :src="`/img/null-project.png`" fit="scale-cover"/>
                                </div>
                                <div class="symbol symbol-50 symbol-lg-120 symbol-primary d-none">
                                    <span class="font-size-h3 symbol-label font-weight-boldest">JM</span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="mr-3">
                                        <a :href="`project#/project-list/${id}`" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3"> {{project.name}}
                                        <i class="flaticon2-correct text-success icon-md ml-2"></i></a>
                                        <div class="d-flex flex-wrap my-2">
                                            <a href="#" class="text-muted text-hover-primary font-weight-bold">
                                            <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                            </span> {{project.location}} </a>
                                        </div>
                                    </div>
                                    <div class="my-lg-0 my-1">
                                        <a href="#" class="btn btn-sm btn-light-success font-weight-bolder text-uppercase mr-3">Reports</a>
                                        <a href="#" class="btn btn-sm btn-info font-weight-bolder text-uppercase">New Task</a>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center flex-wrap justify-content-between">
                                    <div class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5"> {{project.description}} </div>
                                    <div class="d-flex flex-wrap align-items-center py-2">
                                        <div class="d-flex align-items-center mr-10">
                                            <div class="mr-6">
                                                <div class="font-weight-bold mb-2">Start Date</div>
                                                <span class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold"> {{project.date_start | date_start}} </span>
                                            </div>
                                            <div class="">
                                                <div class="font-weight-bold mb-2">Due Date</div>
                                                <span class="btn btn-sm btn-text btn-light-danger text-uppercase font-weight-bold"> {{project.date_end | date_end}} </span>
                                            </div>
                                        </div>
                                        <!--div class="flex-grow-1 flex-shrink-0 w-150px w-xl-300px mt-4 mt-sm-0">
                                            <span class="font-weight-bold">Progress</span>
                                            <div class="progress progress-xs mt-2 mb-2">
                                                <div class="progress-bar bg-success" role="progressbar" :style="'width: '+project.percentage+'%'" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="font-weight-bolder text-dark"> {{project.percentage}} %</span>
                                        </!div -->
                                    </div>
                                </div>
                                <!--end: Content-->
                            </div>
                            <!--end: Info-->
                        </div>
                        <div class="separator separator-solid my-7"></div>
                        <!--begin: Items-->
                        <div class="d-flex align-items-center flex-wrap">
                            <!--begin: Item-->
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                <span class="mr-4">
                                    <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                                </span>
                                <div class="d-flex flex-column text-dark-75">
                                    <span class="font-weight-bolder font-size-sm">Budget</span>
                                    <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold">₱</span>{{project.budget | budgetStatus}}</span>
                                </div>
                            </div>
                            <!--end: Item-->

                        </div>
                    </div>
                </div>
                <div>
                    <el-tabs>
                        <el-tab-pane label="Account Receivable">
                            <el-card class="box-card">
                                Account Receivable
                            </el-card>
                        </el-tab-pane>
                        <el-tab-pane label="Project Management" lazy>
                            <el-card class="box-card">
                                <project-management></project-management>
                            </el-card>
                        </el-tab-pane>
                        <el-tab-pane label="Bills of Materials" lazy>
                            <el-card class="box-card">
                                <project-bill-materials :id="id"></project-bill-materials>
                            </el-card>
                        </el-tab-pane>
                        <el-tab-pane label="Documents" lazy>
                            <el-card class="box-card">
                                <project-documents :id="id"></project-documents>
                            </el-card>
                        </el-tab-pane>
                        <el-tab-pane label="Consumable Supplies" lazy>
                            <el-card class="box-card">
                                <project-consumable-supply :id="id"></project-consumable-supply>
                            </el-card>
                        </el-tab-pane>
                        <el-tab-pane label="Assets/Tools Delivered" lazy>
                            <el-card class="box-card">
                                <project-fixed-assets-list :id="id"></project-fixed-assets-list>
                            </el-card>
                        </el-tab-pane>
                    </el-tabs>
                </div>
            </div>
        </div>
        <el-dialog
            title="Update Project"
            :visible.sync="dialogVisible"
            :before-close="handleClose"
            width="40%">
                <project-form :page-data="pageData" :project="project" :mode="mode"></project-form>
        </el-dialog>
    </div>
</template>
<script>
export default {
    name: "ProjectDetail",
    props: {
        id: null,
        data: {},
        pageData: {}
    },
    data() {
        return {
            project: {},
            loading: false,
            dialogVisible: false,
            srcList: [],
            mode: ''
        }
    },
    created() {
        this.getProjectDetails();
        if(!this.data) {
            this.loading = true;
            this.getProjectDetails();
        }
        else {
            this.project = this.data;
            this.srcList = [`/storage/project/photo/${this.project.photo}`]
        }

        this.$EventDispatcher.listen('UPDATED_PROJECT', data => {
            this.project = data;
            this.dialogVisible = false;
            this.srcList = [`/storage/project/photo/${this.project.photo}`]
        });
    },
    methods: {
        async getProjectDetails() {
            try {
                const response = await this.$API.Project.getProjectDetails(this.id);
                this.project = response.data;
                this.srcList = [`/storage/project/photo/${this.project.photo}`]
                this.loading = false;
            } catch (error) {
                console.log(error);
            }
        },
        editProject() {
            this.dialogVisible = true;
            this.project = this.project
            this.mode = 'update'

        },
        askToDelete() {
            this.$confirm('This will permanently delete the file. Continue?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                type: 'warning'
                }).then(() => {
                    this.deleteProject();
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: 'Delete canceled'
                    });
                });
        },
        async deleteProject() {
            try {
                const res = await this.$API.Project.deleteProject(this.id);
                console.log(res);
                this.$notify({
                    title: 'Success',
                    message: 'Successfully Deleted',
                    type: 'success'
                });
                this.$router.push({
                    name: 'Project List'
                });
            } catch (error) {
                console.log(error);
            }
        },
        handleClose(done) {
            this.mode = ''
            this.project = this.project
            this.$EventDispatcher.fire('handleCloseProject', this.project)
            done();
        },
    },
    filters: {
        budgetStatus(data) {
            if(!data) {
                return 'Not Set';
            }
            return data;
        },
        date_end(data) {
            if(!data) {
                return 'Not Set'
            }
            return data
        },
        date_start(data) {
            if(!data) {
                return 'Not Set'
            }
            return data
        }
    }
}
</script>
