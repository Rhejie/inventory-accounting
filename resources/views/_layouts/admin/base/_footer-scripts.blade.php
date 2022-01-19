
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {!! json_encode(config('layout-admin.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
</script>

<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('/theme/admin/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/theme/admin/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('/theme/admin/js/scripts.bundle.js') }}"></script>

<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
@yield('scripts')
<!--end::Page Scripts-->

<!--begin::Page Vendors(used by this page)-->
@yield('page-scripts')
<!--end::Page Vendors-->

