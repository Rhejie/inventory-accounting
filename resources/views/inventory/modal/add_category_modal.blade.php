<div class="modal fade" id="addCategoryDialog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payment-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">

                {{-- form --}}
                                  
                <!-- Profile Settings Form -->
                <form id="add_category_form" method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">                    
                   
                    @csrf
                  
                    <div class="row form-row">
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>*Name <span class="font-italic">(e.g Heavy Equipment, Wheels, Tools)</span></label>
                                <input type="text" class="form-control" name="name" value="" required="required">
                            </div>
                        </div>
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label>*Type</label>
                                <select class="form-control" name="type_id" required="required">
                                    <option value="">- select -</option>
                                    @foreach($assetType as $t)

                                     <option value="{{ $t->id }}">{{ $t->name }}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                      
                    </div>
                    <div class="submit-section">
                        <button type="submit" class="btn btn-primary submit-btn">Save Category</button>
                    </div>
                </form>
                <!-- /Profile Settings Form -->
                            
                      
                {{-- end form --}}
                

            </div>
        </div>
    </div>
</div>