<?php 
    $helper = new App\Helpers\Helper; 
?>

<!-- ADD PROJECT MODAL -->
{{-- <div class="modal fade" id="addProject" tabindex="-1" role="dialog" aria-labelledby="Add Project" aria-hidden="true">
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
</div> --}}
@if(isset($project))
<!-- EDIT PROJECT MODAL -->
<div class="modal fade" id="editProject" tabindex="-1" role="dialog" aria-labelledby="Edit Project" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ URL::route('project.update', $project->id) }}" enctype="multipart/form-data">
        @csrf
        {{ method_field('PUT') }}
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label  class="col-2 col-form-label" >Name</label>
                    <div class="col-10">
                        <input class="form-control" type="text" id="name-input" name="name" value="{{ $project->name }}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label  class="col-2 col-form-label">Location</label>
                    <div class="col-10">
                        <input class="form-control" type="text" id="location-input" name="location" value="{{ $project->location }}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-date-input" class="col-2 col-form-label">Date</label>
                    <div class="col-5">
                        <input class="form-control" type="date" id="date-start-input" name="date_start" value="{{ $project->date_start }}" required/>
                    </div>
                    <div class="col-5">
                        <input class="form-control" type="date" id="date-end-input" name="date_end" value="{{ $project->date_end }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="budget" class="col-2 col-form-label">Budget</label>
                    <div class="col-10 input-group">
                        <div class="input-group-prepend"><span class="input-group-text">₱</span></div>
                        <input type="number" class="form-control" placeholder="0.00" id="budget-input" name="budget" value="{{ $project->budget }}"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="budget" class="col-2 col-form-label">Status</label>
                    <div class="col-10 input-group">
                        <select class="form-control" id="status-input" name="status_id" value="{{ $project->status_id }}" required>
                            @foreach($helper::activeProjectStatuses() as $status)
                            <option value="{{ $status->id }}" <?php if($status->id == $project->status_id){echo "selected";}?>>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="example-email-input" class="col-2 col-form-label">Progress</label>
                    <div class="col-10">
                        <input class="form-control" type="range" id="percentage-input-edit" name="percentage" value="{{ $project->percentage }}" required/>
                        <span class="form-text text-muted text-right" id="range-percentage-label-edit">50%</span>
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
                        <textarea class="form-control form-control-solid" rows="3" id="description-input" name="description">{{ $project->description }}</textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success mr-2" >Submit</button>
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
            <!-- onclick="storeProject();" -->
        </div>
        </form>
    </div>
</div>
@endif
@if(isset($project))
<!-- DELETE PROJECT MODAL -->
<div class="modal fade" id="deleteProject" tabindex="-1" role="dialog" aria-labelledby="Delete Project" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('project.destroy', $project->id) }}" > 
        <input name="_method" type="hidden" value="DELETE">
        {{ csrf_field() }}

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <strong>Are you sure you want to delete <span class="text-danger">{{ $project->name }}</span>?</strong><br>
                <p>You will not be able to recover this project.</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger mr-2" >Submit</button>
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
            <!-- onclick="storeProject();" -->
        </div>
        </form>
    </div>
</div>
@endif

{{-- DOCUMENTS MODAL --}}






<div class="modal fade"  id="addFileProjectDocument" tabindex="-1" role="dialog" aria-labelledby="Add File" aria-hidden="true" >
    <div class="modal-dialog" role="document">
        <form method="POST"  id="addProjectDocument" action="{{ route('projectDocument.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="card card-custom card-stretch">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Remarks:</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" placeholder="Enter Remarks" name="remarks">
                                        {{-- <span class="form-text text-muted">Remarks</span> --}}
                                    </div>
                                </div>
                                    <input class="form-control" type="hidden" value="{{ $project->id }}" name="project_id">
                                {{-- SELECT --}}
    
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label text-lg-right">Type:</label>
                                        <div class="col-lg-6">
                                            <select class="form-control" name="type">
                                                <option value="quotation">Quotation</option>
                                                <option value="contracts">Contracts</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                               

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label text-lg-right">Upload File:</label>
                                    <div class="col-lg-6">
                                        <div class="uppy" id="kt_uppy_5">
                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">Upload file</label>
                                                <input type="file" class="form-control-file" name="file">
                                            </div>
                                        {{-- <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
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
