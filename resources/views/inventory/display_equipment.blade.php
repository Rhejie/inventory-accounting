@extends('_layouts.admin.default')

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/custom/datatables/datatables.bundle.css?v=7.1.6') }}">

@endsection


@section('content')
@include('inventory.modal.add_documents')
<div class="container-fluid">
 <div class="row">
       <div class="col-md-3">
       	   <div class="pic  p-3" style="background: #fff">
       	    <img src="/assets/img/equipments/{{ $equipment->photo }}" class="img-fluid">
       	   </div>
       </div>
       <div class="col-md-9">
       	   <div class="card card-custom">
       	   		<div class="card-header">
       	   			<div class="card-title">
       	   			<h3 class="card-label">Equipment Information</h3>
       	   			</div>
       	   			 <div class="card-toolbar">
			            <a href="#" class="btn btn-sm btn-success font-weight-bold">
			                <i class="flaticon2-pen"></i> Edit
			            </a> &nbsp;
			            <a href="{{route('equipment.index')}}" class="btn btn-sm btn-secondary font-weight-bold">
			                <i class="flaticon-signs-1"></i> Back to list
			            </a>
			        </div>
       	   		</div>
       	   		<div class="card-body">
       	   			<div class="row">
	       	   			<div class="col-md-6">
	       	   			<p class="m-0"><span style="font-weight: bold">CONTROL NUMBER:</span> {{ $equipment->control_number }}</p>
	       	   			<p class="m-0"><span style="font-weight: bold">BRAND NAME:</span> {{ $equipment->brand_name }}</p>
	       	   			<p class="m-0"><span style="font-weight: bold">MODEL:</span> {{ $equipment->model }}</p>
	       	   			<p class="m-0"><span style="font-weight: bold">ENGINE NUMBER:</span> {{ $equipment->engine_number }}</p>
	       	   			<p class="m-0"><span style="font-weight: bold">ENGINE MODEL:</span> {{ $equipment->engine_model }}</p>
	       	   			<p class="m-0"><span style="font-weight: bold">CAPACITY:</span> {{ $equipment->capacity }}</p>
			       	   	</div>
			       	   	<div class="col-md-6">
	       	   			<p class="m-0"><span style="font-weight: bold">SERIAL NUMBER:</span> {{ $equipment->serial_number }}</p>
	       	   			<p class="m-0"><span style="font-weight: bold">REFERENCE NUMBER:</span> {{ $equipment->reference_number }}</p>
			       	   	<p class="m-0"><span style="font-weight: bold">DESCRIPTION:</span> {{ $equipment->description }}</p>
			       	   	<p class="m-0"><span style="font-weight: bold">DATE ACQUIRED:</span> {{ $equipment->date_acquired }}</p>
			       	   	<p class="m-0"><span style="font-weight: bold">COST:</span> {{ number_format($equipment->cost,2) }} Php</p>
			       	   	<p class="m-0"><span style="font-weight: bold">ASSIGNED TO:</span> {{ $equipment->assigned_to }}</p>
			       	   	</div>
		       	   	</div>
       	   		</div>
       	   </div>
       </div>
 </div>
 <br>
 <div class="row">
   <div class="col-md-12">

   	<div class="card card-custom">
	 <div class="card-header card-header-tabs-line">
	  <div class="card-toolbar">
	   <ul class="nav nav-tabs nav-bold nav-tabs-line">
	    <li class="nav-item">
	     <a class="nav-link active" data-toggle="tab" href="#location">
	     <span class="nav-text">Location History</span>
	     </a>
	    </li>
	    <li class="nav-item">
	     <a class="nav-link" data-toggle="tab" href="#documents">
	     <span class="nav-text">Equipment Documents</span>
	     </a>
	    </li>
	     <li class="nav-item">
	     <a class="nav-link" data-toggle="tab" href="#joborder">
	     <span class="nav-text">Job Order History</span>
	     </a>
	    </li>
	    <li class="nav-item">
	     <a class="nav-link" data-toggle="tab" href="#maintainance">
	     <span class="nav-text">Maintainance History</span>
	     </a>
	    </li>
	   </ul>
	  </div>
	  <div class="card-toolbar">
	      
				<div class="dropdown dropleft">
				    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				        Add New
				    </button>
				    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				        <a class="dropdown-item" data-toggle="modal" data-target="#addDocumentDialog">Documents</a>
				        <a class="dropdown-item" href="#">Job Order</a>
				        <a class="dropdown-item" href="#">Maintainance</a>
				    </div>
				</div>
	  </div>
	 </div>
	 <div class="card-body">
	  <div class="tab-content">
	   <div class="tab-pane fade show active" id="location" role="tabpanel" aria-labelledby="kt_tab_pane_1_4">
	    ...
	   </div>
	   <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="kt_tab_pane_2_4">
	    
	   		<div>
	   			
	   			 <table class="table table-separate table-head-custom " id="DocumentTable">
                    <thead>
                        <tr>
                            <th>Attached File</th>
                            <th>File Type</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
	   		</div>

	   </div>
	   <div class="tab-pane fade" id="joborder" role="tabpanel" aria-labelledby="kt_tab_pane_3_4">
	    ...
	   </div>
	     <div class="tab-pane fade" id="maintainance" role="tabpanel" aria-labelledby="kt_tab_pane_3_4">
	    ...
	   </div>
	  </div>
	 </div>
	</div>

 </div>
</div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script type="text/javascript">
	

	 var table = $('#DocumentTable').DataTable({
        processing: true,
        serverSide: true,

        ajax: "/inventory/equipment/documents/{{ $equipment->id }}",
        columns: [

            {"data": 'attached_file'},
            {"data": 'file_type'},
            {"data": 'created_at'},
            {"data": 'action', name: 'action', orderable: false, searchable: false},

        ],

        fixedColumns: true,
        "columnDefs": [
            { "width": "600px", "targets": [0,1,2,3] },

        ]
    }); 

$(document).on('submit','form[id="add_document_form"]',function(el){
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

            Swal.fire('Document','Successfully Added','success' );
            $("#add_document_form")[0].reset();
            $('#addDocumentDialog').modal('hide');

            $('#DocumentTable').DataTable().ajax.reload();
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