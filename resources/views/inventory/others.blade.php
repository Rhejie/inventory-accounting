@extends('_layouts.admin.default')
@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/custom/datatables/datatables.bundle.css?v=7.1.6') }}">

@endsection
@section('content')


@include('inventory.modal.add_others_modal')
    <app :page-data="{{ json_encode($AssetCategory) }}"></app>
{{--
   <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader" style="position: relative;top:-25px">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Details-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Others</h5>
                <!--end::Title-->
                <!--begin::Separator-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></div>
                <!--end::Separator-->


            </div>
            <!--end::Details-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                <!--begin::Button-->
                <a href="" class=""></a>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="button" class="btn btn-light-primary font-weight-bold ml-2" data-toggle="modal" data-target="#addOthers">
                    Add Others
                </button>
                <!--end::Button-->
                <!--begin::Dropdown-->
                <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title="" data-placement="left" data-original-title="Quick actions">
                    <a href="#" class="btn btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="svg-icon svg-icon-success svg-icon-2x">
                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Files/File-plus.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                    <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                    <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </a>
                    <div class="dropdown-menu p-0 m-0 dropdown-menu-md dropdown-menu-right">
                        <!--begin::Naviigation-->
                        <ul class="navi">

                        </ul>
                        <!--end::Naviigation-->
                    </div>
                </div>
                <!--end::Dropdown-->
            </div>
            <!--end::Toolbar-->
        </div>
    </div>

    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Row-->
            <div class="row" id="projectList">
                <div class="col-md-12" style="background: #fff;padding-top: 10px">
                <!--begin::Column-->
                     <table class="table table-separate table-head-custom " id="datatable">
                    <thead>
                        <tr>

                            <th>Brand Name</th>
                             <th>Description</th>
                            <th>Cost</th>
                            <th>Date Acquired</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!--end::Column-->
                 </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->


@endsection


@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script type="text/javascript">
      var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,

        ajax: "{{ route('others.list')}}",
        columns: [

            {"data": 'brand_name'},
            {"data": 'description'},
            {"data": 'cost'},
            {"data": 'date_acquired'},
            {"data": 'action', name: 'action', orderable: false, searchable: false},

        ],
        dom:'Bfrtip',
        buttons: [{
            extend:'print',
            exportOptions: {
                columns: ':not(:last-child)',
              }
        }],

        fixedColumns: true,
        "columnDefs": [
            { "width": "600px", "targets": [0,1,2,3,4] },

        ]
    });



$(document).on('submit','form[id="add_others_form"]',function(el){
    el.preventDefault();

    var url = $(this).attr('action');
    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        cacheFile: false,
        contentType: false,
        processData: false,

        success:function(ret) {

            Swal.fire('Others','Successfully Added','success' );
            $("#add_others_form")[0].reset();
            $('#addOthers').modal('hide');

            $('#datatable').DataTable().ajax.reload();
        },
        error: function(xhr,status,error)
        {
            $.each(xhr.responseJSON.errors,function(key,item){
                alert(item);
            });

        }
    });

});



</script> --}}
@endsection
