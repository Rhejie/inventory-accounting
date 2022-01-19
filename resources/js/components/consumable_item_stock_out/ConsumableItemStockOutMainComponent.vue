<template>
    <div>
        <router-view :pageData="pageData"></router-view>
    </div>
</template>
<script>
export default {
    name: 'ConsumableItemStockOutMainComponent',
    props: {
        pageData: {}
    },
    data() {
        return {

        }
    },
    methods: {

    },
}
</script>
