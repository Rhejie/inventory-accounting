<!DOCTYPE html>
<html lang="en">

	<!--begin::Head-->
	<head>
		@include('_layouts.accounting.base._head')
	</head>

	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

		<!--[html-partial:include:{"file":"layout.html"}]/-->
        @include('_layouts.accounting.base._layout')
		<!--[html-partial:include:{"file":"partials/_extras/scrolltop.html"}]/-->
        @include('_layouts.accounting.partials._extras.scrolltop')

        @include('_layouts.accounting.base._footer-scripts')
	</body>

	<!--end::Body-->
</html>
