<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="">
		<meta charset="utf-8" />
         <title>{{ config('app.name') }} | @yield('title', $page_title ?? '')</title>
		{{-- Meta Data --}}
        <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('_layouts.cashier.base._styles')
	</head>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed page-loading">

		<!--[html-partial:include:{"file":"layout.html"}]/-->
        @include('_layouts.cashier.base._layout')

		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-notifications.html"}]/-->
        @include('_layouts.cashier.partials._extras.offcanvas.quick-notifications')

		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-user.html"}]/-->
        @include('_layouts.cashier.partials._extras.offcanvas.quick-user')

		<!--[html-partial:include:{"file":"partials/_extras/offcanvas/quick-panel.html"}]/-->
        @include('_layouts.cashier.partials._extras.offcanvas.quick-panel')

		<!--[html-partial:include:{"file":"partials/_extras/scrolltop.html"}]/-->
        @include('_layouts.cashier.partials._extras.scrolltop')

        @include('_layouts.cashier.base._footer-scripts')
	</body>
	<!--end::Body-->
</html>
