
@extends('_layouts.admin.default')



@section('content')

    <!--begin::Subheader-->
    <app :page-data="{{ json_encode($statusProject) }}"></app>
@endsection


