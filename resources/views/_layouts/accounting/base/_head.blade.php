<base href="">
<meta charset="utf-8" />
    <title>ASDEC | @yield('title', $page_title ?? '')</title>
{{-- Meta Data --}}
<meta name="description" content="@yield('page_description', $page_description ?? '')"/>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
<script src="{{ asset('js/app.js') }}" defer></script>
<link rel="shortcut icon" href="/img/company-logo.png" >

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),
        'locale' => config('app.locale'),
    ]); ?>;
</script>

@include('_layouts.admin.base._styles')
