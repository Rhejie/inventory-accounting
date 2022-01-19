<template>
    <div>
        <el-card :body-style="{ padding: '0px' }" class="project_value">
            <el-image v-if="project.photo" style="width: 100%; height: 200px" :src="`/storage/project/photo/${project.photo}`" fit="scale-cover"/>
            <el-image v-else style="width: 100%; height: 200px" :src="`/img/null-project.png`" fit="scale-cover"/>
            <div style="padding: 10px;">
                <span>{{project.name}}</span>
                <div class="project_status">
                    <span class="label label-warning label-pill label-inline mr-2">{{project.project_status.name}}</span>
                </div>
                <div class="bottom clearfix">
                    <el-button type="text" @click="viewProject(project.id)" class="button">VIEW PROJECT</el-button>
                </div>
            </div>
        </el-card>
    </div>
</template>
<script>
export default {
    name: 'ProjectList',
    props: {
        project: {},
        pageData: {}
    },
    data() {
        return {

        }
    },
    methods: {
        viewProject(id) {
            this.$router.push({
                name: 'Project Details',
                params: { id: id, data: this.project, pageData: this.pageData}
            });
        }
    }
}
</script>
<style>
    .time {
        font-size: 13px;
        width: 100%;
        padding: 1px;
        color: #999;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }

    .button {
        padding: 0;
        float: right;
    }

    .image {
        width: 100%;
        display: block;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }

    .project_value{
        margin: 10px;
        height: auto;
    }

    .project_status {
        padding: 3px;
    }
</style>
