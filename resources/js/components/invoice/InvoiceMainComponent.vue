<template>
    <div>
		<router-view :pageData="pageData"></router-view>
	</div>
</template>
<script>
export default {
    name: 'InvoiceMainComponent',
    props: {
        pageData : {}
    },
    data() {
        return {

        }
    },
    created() {

    },
    methods: {

    },
}
</script>
