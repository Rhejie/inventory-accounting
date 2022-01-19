<template>
    <div>
		<router-view :pageData="pageData"></router-view>
	</div>
</template>
<script>
export default {
    name: 'ProposalMainComponent',
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
