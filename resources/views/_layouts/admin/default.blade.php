<!DOCTYPE html>
<html lang="en">

	<!--begin::Head-->
	<head>
		@include('_layouts.admin.base._head')
	</head>

	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

		<!--[html-partial:include:{"file":"layout.html"}]/-->
        @include('_layouts.admin.base._layout')
		<!--[html-partial:include:{"file":"partials/_extras/scrolltop.html"}]/-->
        @include('_layouts.admin.partials._extras.scrolltop')

        @include('_layouts.admin.base._footer-scripts')
	</body>

	<!--end::Body-->
</html>
