<template>
    <div>
		<router-view :pageData="pageData"></router-view>
	</div>
</template>
<script>
export default {
    name: 'BankMainComponent',
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
