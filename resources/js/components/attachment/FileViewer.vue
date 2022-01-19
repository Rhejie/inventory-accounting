<template>
    <div>
        <iframe :src="`/${model.path}/${model.file}`" style="width:100% ; height:1000px"></iframe>
    </div>
</template>
<script>
export default {
    name: 'FileViewer',
    props: {
        model: {}
    },
    data() {
        return {
            info: {}
        }
    },
    created() {
        this.info = this.model
    },
}
</script>
