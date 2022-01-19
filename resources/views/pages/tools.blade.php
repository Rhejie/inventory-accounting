@extends('_layouts.admin.default')


@section('styles')
 <!-- w3school google icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- w3school fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style type="text/css">
       
        i{
            margin-right: 5px;
            margin-left: 5px;
        }
        span{
             margin-right: 5px;
            margin-left: 5px;
        }
        .spacing{
          padding-left:30px;
          padding-right:30px;
        }
         .dataTables_filter{
            float: right;
        }
        .dataTables_length {
            float: right;
        }
       .navbar-nav > li{
          padding-left:10px;
          padding-right:10px;
        }
        i{
          width: 10px;
        }
   
    </style>
@endsection

@section('content')
 <div class="container-fluid" style="background: #fff"> 
    <div class="row">
      <div class="col-sm-12">
        <h4 class="text-success" style="margin-top: 10px;">TOOLS</h4>
      </div>
      <div class="col-sm-12">
        <label>TOTAL VALUE | <span>$423123</span></label>  
        <label style="padding-left: 20px">INVENTORY COUNT | <span>17</span></label>
      </div>
      <div class="col-sm-3">
        <button class="btn btn-outline-secondary" disabled>
          <i class="fa fa-bolt" style="font-size:20px"></i><span>2</span>
        </button>
        <button class="btn btn-outline-secondary">View Damaged</button>
      </div>
      <div class="col-sm-3">
        <button class="btn btn-outline-secondary" disabled>
          <i class="fa fa-star" style="font-size:20px"></i><span>17</span>
        </button>
        <button class="btn btn-outline-secondary">View 30 Day New</button>
      </div>
      <div class="col-sm-3">
        <button class="btn btn-outline-secondary" disabled>
          <i class="fa fa-inbox" style="font-size:20px"></i><span>4</span>
        </button>
        <button class="btn btn-outline-secondary">View Toolshed</button>
      </div>
      <div class="col-sm-3">
        <button class="btn btn-outline-secondary" style="width: 150px;">MAP</button>
      </div>
      <div class="col-sm-12">
        <hr>
      </div>
      <div class="col-sm-12">
        <button class="btn btn-info">Add Tool</button>
        <button class="btn btn-info">Export to CSV</button>
        <button class="btn btn-secondary" disabled>Move to Toolbox</button>
        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" disabled="">Action</button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Link 1</a>
          <a class="dropdown-item" href="#">Link 2</a>
          <a class="dropdown-item" href="#">Link 3</a>
        </div>
      </div>

      
    <!-- DATA TABLE -->
    <div class="col-sm-12" style="overflow-x:auto; margin-top: 10px;" >
      <table id="example" class="table" style="width:100%">
        <thead class="bg-light">
          <tr>
            <th><input type="checkbox" id="" name="" value=""></th>
            <th>ID</th>
            <th>Name/Description</th>
            <th>Project</th>
            <th>QR ID</th>
            <th>SVC Item</th>
            <th>Toolbox</th>
            <th>Category</th>
            <th>Value</th>
            <th>Last Moved</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td><a data-toggle="modal" data-id="11111" class="openmodal" href="#myModal" >11111</a></td>
            <td>System Architect</td>
            <td>Edinburgh</td>
            <td>61</td>
            <td>2011/04/25</td>
            <td>$320,800</td>
            <td>123</td>
            <td>123</td>
            <td>213</td>
            <td>123</td>
          </tr>
          <tr>
            <td></td>
            <td><a data-toggle="modal"  data-id="22222" class="openmodal" href="#myModal">22222</a></td>
            <td>Accountant</td>
            <td>Tokyo</td>
            <td>63</td>
            <td>2011/07/25</td>
            <td>$170,750</td>
            <td>123</td>
            <td>123</td>
            <td>123</td>
            <td>123</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>



<!-- <div class="container"> -->

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">TOOL DETAILS</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <form action="">
                <!-- STATUS RADIO BUTTON -->
                <label>Status</label><br>
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>Excellent
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">Good
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>Fair
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">Poor
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio1">
                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="option1" checked>Damaged
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">Missing
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label" for="radio2">
                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="option2">Out of Service
                  </label>
                </div><br><br>
                <!-- STATUS RADIO BUTTON -->
                <label>Location</label><br>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-check-inline">
                      <label class="form-check-label" for="radio1">
                        <input type="radio" class="form-check-input" id="radio1" name="optradio2" value="option1" checked>Project
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label" for="radio2">
                        <input type="radio" class="form-check-input" id="radio2" name="optradio2" value="option2">User
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label" for="radio2">
                        <input type="radio" class="form-check-input" id="radio2" name="optradio2" value="option2">Toolbox
                      </label>
                    </div>
                    <div class="form-check-inline">
                      <label class="form-check-label" for="radio2">
                        <input type="radio" class="form-check-input" id="radio2" name="optradio2" value="option2">ToolShed
                      </label>
                    </div>
                  </div>
                  <!-- Checkbox -->
                  <div class="col-sm-6">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="">Is Service Item?
                      </label>
                    </div>
                  </div>
                  <!-- Textboxes -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <input type="text" class="form-control" name="itemtype" id="itemtype" placeholder="Type">
                    </div>
                  </div>
                  <!-- DATE TIME PICKER -->
                  <div class="col-sm-6">
                    <div class="form-group row">                      
                      <input class="form-control" type="datetime-local" value="" id="example-datetime">
                    </div>
                  </div>
                  <!-- Textboxes -->
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="usr">Sticker Code ID:</label>
                      <input type="text" class="form-control" id="usr">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="usr">Name</label>
                      <input type="text" class="form-control" id="usr">
                    </div>
                  </div>
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label for="usr">Brand</label>
                      <input type="text" class="form-control" id="usr">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="usr">Model</label>
                      <input type="text" class="form-control" id="usr">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="usr">Value</label>
                      <input type="text" class="form-control" id="usr">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label></label><br>
                    <div class="input-group mb-3 input-group-sm">
                      <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                      </div>
                      <input type="text" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="usr">Category</label>
                      <input type="text" class="form-control" id="usr">
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Description</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <button class="btn btn-success" >Add Comment</button>
                  </div>
                  <!-- ITEM/EQUIPMENT HISTORY-->
                  <div class="col-sm-12">
                    <br>
                    <label>-April 11, 2018 9:43 AM</label><br>
                    <label>-Sounded Wierd</label><br>
                    <label>-June 1, 2018 7:43 AM</label><br>
                    <label>-Repaired and sounds is all good -John</label><br>
                  </div>
                  <!-- IMAGES OF ITEM-->
                  <div class="col-sm-6">
                    <img src="drill.jpg" style="width: 100px; height: 100px">
                  </div>
                  <div class="col-sm-6">
                    <img src="drill.jpg" style="width: 100px; height: 100px">
                  </div>

                </div><!-- div row -->
              </form>
            </div>
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
<!-- </div> -->

@endsection



@section('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable( {
        columnDefs: [ {
            
            orderable: false,
            className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'multi',//define multiple selection on checkboxes
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]],
        "dom": '<"top"lf>t<"bottom"irp><"clear">' //show the data table tools from CDN
    } );
} );
  $(document).on("click", ".openmodal", function () { //this let the id to be passed on textbox
       var myId = $(this).data('id');
       $(".modal-body #itemtype").val( myId );
  });
</script>
@endsection