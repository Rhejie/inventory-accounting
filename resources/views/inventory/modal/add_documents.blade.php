<div class="modal fade" id="addDocumentDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment-title">Add Equipment Documents</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                {{-- form --}}
                                  
                <!-- Profile Settings Form -->
                <form id="add_document_form" method="POST" action="{{ route('document.store') }}" enctype="multipart/form-data">                    
                   
                    @csrf
                  
                    <div class="row form-row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>*Attached File</label>
                                <input type="file" class="form-control" name="file" value="" required="required">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>*Document Type</label>
                                <select class="form-control" name="file_type" required="required">
                                    <option value="">- select -</option>
                                    <option value="insurance">Insurance</option>
                                    <option value="LTO registration">LTO Registration</option>
                                     <option value="emissions">Emissions</option>
                                      <option value="third party certificate">Third Party Certificate</option>
                                </select>
                            </div>

                            <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

                        </div>
                      
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save Document</button>
                    </div>
                </form>
                <!-- /Profile Settings Form -->
                            
                      
                {{-- end form --}}
                

            </div>
        </div>
    </div>
</div>