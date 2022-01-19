<div class="modal fade" id="addTypesDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment-title">Add Asset Types</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                {{-- form --}}
                                  
                <!-- Profile Settings Form -->
                <form id="add_type_form" method="POST" action="{{ route('types.store') }}" enctype="multipart/form-data">                    
                   
                    @csrf
                  
                    <div class="row form-row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>*Name</label>
                                <input type="text" class="form-control" name="name" value="" required="required">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>*Resources Type</label>
                                <select class="form-control" name="resource_type" required="required">
                                    <option value="">- select -</option>
                                    <option value="1">Asset</option>
                                    <option value="2">Replenishable</option>
                                </select>
                            </div>
                        </div>
                      
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save Type</button>
                    </div>
                </form>
                <!-- /Profile Settings Form -->
                            
                      
                {{-- end form --}}
                

            </div>
        </div>
    </div>
</div>