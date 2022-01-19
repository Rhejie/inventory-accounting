<template>
    <div>
		<router-view :pageData="pageData"></router-view>
	</div>
</template>
<script>
export default {
    name: 'CustomerMainComponent',
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
