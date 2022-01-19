<!--begin::Main-->
		<!--[html-partial:include:{"file":"partials/_header-mobile.html"}]/-->
        @include('_layouts.cashier.partials._header-mobile')
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--[html-partial:include:{"file":"partials/_aside.html"}]/-->
                @include('_layouts.cashier.partials._aside')
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--[html-partial:include:{"file":"partials/_header.html"}]/-->
                    @include('_layouts.cashier.partials._header')
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                        @yield('subheader')

                        @yield('content')
					</div>
					<!--[html-partial:include:{"file":"partials/_footer.html"}]/-->
                    @include('_layouts.cashier.base._footer')
				</div>

				<!--end::Wrapper-->
			</div>

			<!--end::Page-->
		</div>

		<!--end::Main-->
