@extends('_layouts.accounting.default')

@section('content')

    <?php
        $pageData = new \stdClass();
        $pageData->status = $status;
        $pageData = json_encode($pageData);
    ?>
    <app :page-data="{{$pageData}}"></app>

@endsection

