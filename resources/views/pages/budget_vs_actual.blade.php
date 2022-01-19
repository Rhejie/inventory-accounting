@extends('_layouts.admin.default')


@section('styles')
 
    
<style type="text/css">
      img{
        width: 20px;
        height: 20px;
      }
        .twospan > i{
            opacity: 0.2;
        }
        .threetbl{
            width: 280px;
        }
        .vcentering{
            display: flex;
            align-items: center;
        }
        .twotbl{
            width: 150px;
            height: auto;
            padding: 0px 0px 0px 0px;
            margin: 0px;
            box-sizing: border-box;
        }
        .onetbl{
            width: 130px;
            height: 5px; 
            padding: 0px 0px 0px 0px;
            font-size: 13px;
        }
        .tblbox{
            width:50px;
            background-color:   #E8E8E8;
            padding: 0px 0px 0px 0px;
            text-align: center;
        }
        .twospan{
            width: 5%;
            text-align: center;
            padding: 0px 0px 0px 0px;
        }
        .onespan{
            width: 5%;
            text-align: right;
        }
        td{
            font-size: 13px;
            min-height: height: 1px;
            max-height: height: 1px;
        }
        th{
            font-size: 15px;\
            height: 1px;
            min-height: height: 1px;
            max-height: height: 1px;
        }
        .curr{
            float: right;
        }
        .borderlessThead >th{
            border:none !important;

        }

        .table-responsive{
        	font-size: 13px;
        }

        .openmodal{
        	font-size: 13px;
        }

        .openmodal label{
        	font-size: 13px;
        }

    </style>
@endsection

@section('content')



<div class="container-fluid table-responsive" style="background: #fff;">
	<h2 style="margin-top: 10px;">Budget Vs Actual</h2>
  <table class="table table-sm table-bordered" >
    <!-- Borderless ROW -->
    <thead>
       <tr class="borderlessThead">
        <th></th>
        <th></th>
        <th colspan="2"></th>
        <th colspan="2"></th>
        <th colspan="2"></th>
        <th colspan="2"></th>
        <th class="onetbl" style="text-align: right;">Budget</th>
        <th class="onetbl" style="text-align: right;">Actual</th>
        <th class="onetbl" style="text-align: right;">Under/Over</th> 
      </tr> 
    </thead>
    <!-- TABLE HEAD ROW -->
    <thead>
      <tr>
        <th class="tblbox" style="background-color: #989898"></th>
        <th><div class="threetbl" style="opacity: 0.6;">Site Preparation<label class="float-right" style="font-weight: normal;">65%</label></div></th>
        <th colspan="2"><div class="twotbl" ><i class="fa fa-address-book" style="font-size:24px"></i> <label style="opacity: 0.6;">Labor</label></div></th>
        <th colspan="2"><div class="twotbl" ><i class="fa fa-gavel" style="font-size:24px"></i> <label style="opacity: 0.6;">Equipment</label></div></th>
        <th colspan="2"><div class="twotbl" ><i class="fa fa-cube" style="font-size:28px"></i> <label style="opacity: 0.6;">Materials</label></div></th>
        <th colspan="2"><div class="twotbl" ><i class="fa fa-usd" style="font-size:24px"></i> <label style="opacity: 0.6;">Other Cost</label></div></th>
        <th class="onetbl"><div> <label class="curr">&#8369; 12,850.00</label></div></th>
        <th class="onetbl"><div> <label class="curr">&#8369; 1,105.00</label></div></th>
        <th class="onetbl"><div> <label class="curr">&#8369; 11,745.00</label></div></th> 
      </tr>
    </thead>
    <tbody>
    <!-- ROW 1 of TABLE BODY-->
      <tr>
        <th class="tblbox">1</th>
        <th><a data-toggle="modal" data-id="1" class="openmodal" href="#myModal" style="color: black;"><div class="threetbl">Remove all plants and concrete <label class="float-right" style="font-weight: normal;">92%</label></div></a></th>
        <td class="twospan">300hrs<br>&#8369; 7,500.00</td>
        <td class="twospan">1<br>&#8369; 105.00</td>
        <td class="twospan">30hrs<br>&#8369; 300.00</td>
        <td class="twospan"></td>
        <td class="twospan">1 ITEM <br>&#8369; 1,050.00</td>
        <td class="twospan"></td>
        <td class="twospan">1 ITEM <br>&#8369; 4,000.00</td>
        <td class="twospan">1<br>&#8369; 1,000.00</td>
        <td class="onetbl"><label class="curr">12,850.00</label></td>
        <td class="onetbl"><label class="curr">1,105.00</label></td>
        <td class="onetbl"><label class="curr">11,745.00</label></td>
      </tr>
    <!-- ROW 2 of TABLE BODY-->
      <tr>
        <th class="tblbox">2</th>
        <th><a data-toggle="modal" data-id="2" class="openmodal" href="#myModal" style="color: black;"><div class="threetbl">Spray weed killer<label class="float-right" style="font-weight: normal;">90%</label></div></a></th>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
      </tr>
    <!-- ROW 3 of TABLE BODY-->
      <tr>
        <th class="tblbox">3</th>
        <th><a data-toggle="modal" data-id="3" class="openmodal" href="#myModal" style="color: black;"><div class="threetbl">Compacting <label class="float-right" style="font-weight: normal;">70%</label></div></a></th>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
      </tr>
    <!-- ROW 4 of TABLE BODY-->
      <tr>
        <th class="tblbox">4</th>
        <th><a data-toggle="modal" data-id="1" class="openmodal" href="#myModal" style="color: black;"><div class="threetbl">Foundation <label class="float-right" style="font-weight: normal;">70%</label></div></a></th>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
      </tr>
    <!-- ROW 5 of TABLE BODY-->
      <tr>
        <th class="tblbox">5</th>
        <th><a data-toggle="modal" data-id="1" class="openmodal" href="#myModal" style="color: black;"><div class="threetbl">dig <label class="float-right" style="font-weight: normal;">70%</label></div></a></th>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="twospan"><i class="material-icons" style="font-size:30px">control_point</i></td>
        <td class="twospan"></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
      </tr>
       <tr>
        <td colspan="2"><div class="threetbl vcentering"><i class="material-icons" style="font-size:30px;">control_point</i><label style="font-size: 13px; padding-left: 10px;"> Add Action Item</label></div></td>
        <td class="twospan">&#8369; 7,500.00</td>
        <td class="twospan">&#8369; 105.00</td>
        <td class="twospan">&#8369; 300.00</td>
        <td class="twospan">&#8369; 0.00</td>
        <td class="twospan">&#8369; 1,050.00</td>
        <td class="twospan">&#8369; 0.00</td>
        <td class="twospan">&#8369; 4,000.00</td>
        <td class="twospan">&#8369; 1,000.00</td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
        <td class="onetbl"><label class="curr">0.00</label></td>
      </tr>
    </tbody>
  </table>
</div>
    
    <!-- The Modal -->
    <div class="modal" id="myModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Modal Heading</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-8">
                  <div class="form-group">
                    <label for="titlename">Title/Name</label>
                    <input type="text" class="form-control" id="titlename">
                  </div>
                </div>
                <div class="col-sm-4">
                    <label for="txtColor">Color</label>
                    <!-- <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="#" id="txtColor">
                      <div class="input-group-append">
                        <span class="input-group-text"></span>
                      </div>
                    </div> -->
                    <div id="cp2" class="input-group colorpicker-component mb-3"> 
                    <input type="text" value="#00AABB" class="form-control" /> 
                    <div class="input-group-append">
                    <span class="input-group-addon" ><i></i></span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Include Note</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="example-date-input" class="col-6 col-form-label">Start Date</label>
                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="example-date-input" class="col-6 col-form-label">End Date</label>
                        <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="example-time-input" class="col-6 col-form-label">Start Time</label>
                        <input class="form-control" type="time" value="13:45:00" id="example-time-input">
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group">
                        <label for="example-time-input" class="col-6 col-form-label">End Time</label>
                        <input class="form-control" type="time" value="13:45:00" id="example-time-input">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <input type="text" class="form-control" id="projectname" placeholder="Select Person...">
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" checked="">
                    <label class="form-check-label" for="defaultCheck1">
                      Show progress indicator
                    </label>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <button class="btn btn-outline-primary" type="button">-</button>
                    </div>
                    <input type="text" class="form-control" placeholder="0">
                    <div class="input-group-prepend">
                      <button class="btn btn-outline-primary" type="button">+</button>
                    </div>
                  </div>
                </div>
                <div class="col-sm-7">
                  <div class="progress" style="height: 39px">
                    <div class="progress-bar" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100">92%</div>
                  </div>
                </div>
                <div class="col-sm-2">
                  <button class="btn btn-secondary" type="button" disabled>COMPLETE</button>
                </div>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-3">
                    <button class="btn btn-danger" type="button" >DELETE</button>
                  </div>
                  <div class="col-9 text-right" >
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="button" >SAVE</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>




@endsection



@section('scripts')
<script type="text/javascript">
     $(document).on("click", ".openmodal", function () { //this let the id to be passed on textbox
       var myId = $(this).data('id');
       $(".modal-body #titlename").val( myId );
  });
     $('#cp2').colorpicker();
</script>
@endsection