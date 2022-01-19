<div class="modal fade" id="addOthers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment-title">Add Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                {{-- form --}}
                                  
                <!-- Profile Settings Form -->
                <form id="add_others_form" method="POST" action="{{ route('others.store') }}" enctype="multipart/form-data">                    
                   
                    @csrf
                  
                    <div class="row form-row">
                         <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>*Brand Name</label>
                                <input type="text" class="form-control" name="brand_name" value="" required="required">
                            </div>
                        </div>


                    
                         <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>Date Acquired</label>
                                <input type="date" class="form-control" name="date_acquired" value="" >
                            </div>
                        </div>
                         <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" class="form-control" name="photo" value="" >
                            </div>
                        </div>
                         <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="text" class="form-control" name="cost" value="" >
                            </div>
                        </div>

                         <div class="col-6 col-md-6">
                            <div class="form-group">
                                <label>Assigned To</label>
                                <input type="text" class="form-control" name="assigned_to" value="">
                            </div>
                        </div>

                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save Vehicle</button>
                    </div>
                </form>
                <!-- /Profile Settings Form -->
                            
                      
                {{-- end form --}}
                

            </div>
        </div>
    </div>
</div>