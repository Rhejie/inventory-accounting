
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {!! json_encode(config('layout-cashier.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
</script>

<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('/theme/cashier/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/theme/cashier/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('/theme/cashier/js/scripts.bundle.js') }}"></script>

<!--end::Global Theme Bundle-->

@yield('scripts')

@yield('page-scripts')
