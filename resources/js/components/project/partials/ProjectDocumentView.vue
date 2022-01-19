<template>
    <div>
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <el-card class="box-card">
                    <object :data="`/storage/project/documents/${file_detail.file}`"  style="width:100% ; height:1000px">
                        <embed :src="`/storage/project/documents/${file_detail.file}`" />
                    </object>
                </el-card>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
    </div>
</template>
<script>
export default {
    name: 'ProjectDocumentView',
    props: {
        fileData: {}
    },
    data() {
        return {
            file_detail: {},
        }
    },
    created() {
        this.file_detail = this.fileData;
    },
    methods: {
        onLoad(frame) {
            this.myIframe = frame.contentWindow
        }
    },
    computed: {
        fileType() {
            let result = /[^/]*$/.exec(this.file_detail)[0];
            return result;
        }
    }
}
</script>
