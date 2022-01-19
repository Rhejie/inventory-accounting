@extends('_layouts.admin.default')
@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/custom/datatables/datatables.bundle.css?v=7.1.6') }}">

@endsection
@section('content')


@include('inventory.modal.add_heavy_equipment_modal')

   <!--begin::Subheader-->
    <app :page-data="{{ json_encode($AssetCategory) }}"></app>

@endsection


{{-- @section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script type="text/javascript">
      var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,

        ajax: "{{ route('equipment.list')}}",
        columns: [

            {"data": 'control_number'},
            {"data": 'model'},
            {"data": 'brand_name'},
            {"data": 'asset_category_id'},
            {"data": 'serial_number'},
            {"data": 'reference_number'},
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
            { "width": "600px", "targets": [0,1,2,3,4,5,6,7] },

        ]
    });



$(document).on('submit','form[id="add_equipment_form"]',function(el){
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

            Swal.fire('Equipment','Successfully Added','success' );
            $("#add_equipment_form")[0].reset();
            $('#addEquipmentDialog').modal('hide');

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
{{-- @endsection --}}
