@extends('_layouts.admin.default')
@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/custom/datatables/datatables.bundle.css?v=7.1.6') }}">

@endsection
@section('content')
    <app :page-data="{{ json_encode($AssetCategory)}}"></app>
@endsection
