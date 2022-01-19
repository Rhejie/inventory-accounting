<div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="Add Project" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('project.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label  class="col-2 col-form-label">Name</label>
                    <div class="col-10">
                        <input class="form-control" type="text" id="name-input" name="name" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-2 col-form-label">Location</label>
                    <div class="col-10">
                        <input class="form-control" type="text" id="location-input" name="location" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-date-input" class="col-2 col-form-label">Date</label>
                    <div class="col-5">
                        <input class="form-control" type="date" id="date-start-input" name="date_start" required/>
                    </div>
                    <div class="col-5">
                        <input class="form-control" type="date" id="date-end-input" name="date_end"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="budget" class="col-2 col-form-label">Budget</label>
                    <div class="col-10 input-group">
                        <div class="input-group-prepend"><span class="input-group-text">₱</span></div>
                        <input type="number" class="form-control" placeholder="0.00" id="budget-input" name="budget"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="budget" class="col-2 col-form-label">Status</label>
                    <div class="col-10 input-group">
                        <select class="form-control" id="status-input" name="status_id" >
                            @foreach($helper::activeProjectStatuses() as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-email-input" class="col-2 col-form-label">Progress</label>
                    <div class="col-10">
                        <input class="form-control" type="range" id="range-input" name="percentage" required/>
                        <span class="form-text text-muted text-right" id="range-percentage-label">50%</span>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <div class="col-2">
                        <label>Photo</label>
                    </div>
                    <div class="col-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo-input" accept="image/*" name="photo"/>
                            <label class="custom-file-label" for="customFile">Choose image</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label">Description</label>
                    <div class="col-10">
                        <textarea class="form-control form-control-solid" rows="3" id="description-input" name="description"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success mr-2">Submit</button>
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
            <!-- onclick="storeProject();" -->
        </div>
        </form>
    </div>
</div>