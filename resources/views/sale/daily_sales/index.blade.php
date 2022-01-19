@extends('_layouts.admin.default')

@section('content')

{{-- modal --}}
    @include('sale.daily_sales.modal.sales-form')
{{-- end modal --}}



<div class="card card-custom" >

    <div class="card-header">
        <div class="card-title">
            <div class="card-label">
                <h3>Sales</h3>
            </div>
        </div>

        <div class="card-toolbar">
            <button class="btn btn-primary" data-toggle="modal" data-target="#salesFormModal">Add Sales</button>
        </div>
    </div>
    <div class="card-body">

        <div class="col-md-4 my-2 my-md-0">
            <div class="input-icon">
                <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query">
                <span>
                    <i class="flaticon2-search-1 text-muted"></i>
                </span>
            </div>
        </div>
        <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable" ></div>
    </div>
</div>


@endsection

@section('page-scripts')
    @include('_page-scripts.sales.sales-scripts')
    @include('_page-scripts.sales.sales-add-scripts')
@endsection
