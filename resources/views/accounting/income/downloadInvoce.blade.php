<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),
            'locale' => config('app.locale'),
        ]); ?>;
    </script>
    @include('_layouts.admin.base._styles')
</head>
<body>
    <div id="app">
        <invoice-download :id="{{$id}}" :model="{{$invoice}}"></invoice-download>
    </div>
</body>
</html>
