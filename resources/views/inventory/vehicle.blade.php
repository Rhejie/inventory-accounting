@extends('_layouts.admin.default')

@section('content')
    <app :page-data="{{ json_encode($AssetCategory) }}"></app>
@endsection
