{{-- @extends('_layouts.admin.default') --}}
{{-- @include('_layouts.admin.base._styles') --}}
@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/custom/datatables/datatables.bundle.css?v=7.1.6') }}">
@endsection
{{-- @section('content') --}}
    @include('project.modal')
  
        
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Row-->
            <div class="row" >
                <div class="col-11 mx-auto mb-3">
                    <button class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#addFileProjectDocument">File Upload</button>
                </div>
            </div>
            
            <div class="row" id="projectList">
                <div class="col-md-12">
               
                <!--begin::Column-->
                {{-- table-bordered --}}
                     <table class="table-bordered" id="documentTable">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Remarks</th>
                            <th>Type</th>
                             <th>Date Created</th>
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
{{-- @endsection --}}



@section('scripts')

<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script type="text/javascript">


    var table = $('#documentTable').DataTable({
        processing: true,
        serverSide: true,

        ajax: "{{ route('projectDocument.list',['project_id'=>$project->id]) }}",
        columns: [

            {"data": 'file_name'},
            {"data": 'remarks'},
            {"data": 'type'},
            {"data": 'created_at'},


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
            { "width": "600px", "targets": [0,1,2,3] },

        ]
    }); 

    $('#addProjectDocument').on('submit',function(el){
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

            Swal.fire('Documents','Successfully Added','success' );
            
           
            
            $("#addProjectDocument")[0].reset();
            $('#addFileProjectDocument').modal('hide');
            $(".modal-backdrop").hide()
            $('#documentTable').DataTable().ajax.reload();
        },
        error: function(xhr,status,error)
        {
            $.each(xhr.responseJSON.errors,function(key,item){
                alert(item);
            });

        }
    });

});

    </script>
@endsection



