@extends('_layouts.admin.default')


@section('styles')
 <!-- w3school google icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- w3school fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style type="text/css">
      .pads{
        padding-top: 2%;
        padding-bottom: 1%;
      }
      .onetblcol{
        width: 200px;
        text-align: right;
      }
      .twotblcol{
        width: 550px;
      }
      .tbltitle{
        font-size: 19px;
      }
      table{
        table-layout: fixed;
        word-wrap: break-word;
      }

      /*modal styles*/
      .modal-footer{
        font-size: 13px;
      }
      .optmonth{
        font-size: 13px;
        margin-left: 5px;
        width: 100px;
        height: 20px;
      }
      .optyear{
        font-size: 13px;
        margin-left: 5px;
        width: 70px;
        height: 20px;
      }

      .popover{
        max-width: 400px;
        max-height: 30%;    
      }

    </style>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <h4>Income vs Expense</h4>
      </div>
      <div class="col-md-12 border-top border-bottom">
        <div class="row">
          <div class="col-md-12">
            <nav class="navbar navbar-expand-sm">
              <!-- Links -->
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">All Categories</a>
                  <div class="dropdown-menu">
                    <a href="#" class="dropdown-item">Sample Category1</a>
                    <div class="dropdown-divider"></div>
                    <a href="#"class="dropdown-item">Sample Category1</a>
                  </div>
                </li>
                <li class="nav-item dropdown">
                  <a href="#myModal" class="nav-link dropdown-toggle openmodal" data-toggle="modal">May 2021 - May 2021</a>
                </li>
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">All Accounts</a>
                </li>
              </ul>
              <ul class="nav navbar-nav ml-auto">
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link" data-toggle="dropdown"><i class="fa fa-file-o"></i> Export</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div><!--  end of navigation bars -->
      <div class="col-md-12">
        <h4 class="pads text-secondary">Income vs Expense</h4>
      </div>
    </div><!--  END OF DIV ROW -->
    <div class="table-responsive" style="overflow-x: auto;">
      <table class="table table-sm ">
        <thead>
          <tr>
            <th class="onetblcol border-top-0"></th>
            <th class="border-top-0 onetblcol">MAR 2021</th>
            <th class="border-top-0 onetblcol">APR 2021</th>
            <th class="border-top-0 onetblcol" class="border-top-0" class="border-top-0">MAY 2021</th>
            <th class="border-top-0 onetblcol" class="border-top-0">AVERAGE</th>
            <th class="border-top-0 onetblcol">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="twotblcol tbltitle" style="padding-top: 2%;"><span class="dropdown-toggle"></span><span class="text-success"> Income</span></th>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
          </tr>
          <tr>
            <td class="twotblcol table-active"><span style="padding-left: 20px">All Income Sources </span></td>
            <td class="onetblcol table-active"></td>
            <td class="onetblcol table-active"></td>
            <td class="onetblcol table-active"></td>
            <td class="onetblcol table-active" class="onetblcol"></td>
            <td class="onetblcol table-active"></td>
          </tr>
          <tr>
            <td class="twotblcol"><span style="padding-left: 20px">Total All Income Sources </span></td>
            <td class="onetblcol">&#8369;0.00</td>
            <td class="onetblcol">&#8369;0.00</td>
            <td class="onetblcol">&#8369;0.00</td>
            <td class="onetblcol">&#8369;0.00</td>
            <td class="onetblcol">&#8369;0.00</td>
          </tr>
          <tr>
            <td class="twotblcol table-active"><span style="padding-left: 20px">Total Income </span></td>
            <td class="onetblcol table-active">&#8369;0.00</td>
            <td class="onetblcol table-active">&#8369;0.00</td>
            <td class="onetblcol table-active">&#8369;0.00</td>
            <td class="onetblcol table-active">&#8369;0.00</td>
            <td class="onetblcol table-active">&#8369;0.00</td>
          </tr>
          <tr>
            <th class="twotblcol tbltitle" style="padding-top: 2%;"><span class="dropdown-toggle"></span><span class="text-danger"> Expense</span></th>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
          </tr>
          <tr>
            <td class="twotblcol table-active"><span style="padding-left: 20px">Total Expenses </span></td>
            <td class="onetblcol table-active">&#8369;0.00</td>
            <td class="onetblcol table-active">&#8369;0.00</td>
            <td class="onetblcol table-active">&#8369;0.00</td>
            <td class="onetblcol table-active">&#8369;0.00</td>
            <td class="onetblcol table-active">&#8369;0.00</td>
          </tr>
          <tr>
            <th class="twotblcol tbltitle" style="padding-top: 2%;">Net Income</th>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
            <td class="onetblcol"></td>
          </tr>
          <tr>
            <td class="twotblcol"></td>
            <td class="onetblcol tbltitle" style="font-weight: bold;">&#8369;0.00</td>
            <td class="onetblcol tbltitle" style="font-weight: bold;">&#8369;0.00</td>
            <td class="onetblcol tbltitle" style="font-weight: bold;">&#8369;0.00</td>
            <td class="onetblcol tbltitle" style="font-weight: bold;">&#8369;0.00</td>
            <td class="onetblcol tbltitle" style="font-weight: bold;">&#8369;0.00</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  
 <!-- The Modal -->
    <div class="modal" id="myModal">
      <div class="modal-dialog ">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h6 class="modal-title">Timeframe</h6>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-2">
                  <span class="badge badge-pill badge-primary">This month</span>
                </div>
                <div class="col-3">
                  <span class="badge badge-pill text-primary">Latest 3 Months</span>
                </div>
                <div class="col-2">
                  <span class="badge badge-pill text-primary">This year</span>
                </div>
                <div class="col-2">
                  <span class="badge badge-pill text-primary">Last year</span>
                </div>
                <div class="col-2">
                  <span class="badge badge-pill text-primary">All dates</span>
                </div>
                <div class="col-2">
                  
                </div>
              </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
              <div class="container-fluid">
                <div class="row">
                  <div class="col-sm-6 d-inline-flex">
                    <span>From: </span>
                    <select class="optmonth">
                      <option selected>May</option>
                      <option>January</option>
                      <option>Feb</option>
                      <option>Mar</option>
                      <option>Apr</option>
                      <option>June</option>
                      <option>July</option>
                      <option>Aug</option>
                      <option>Sept</option>
                      <option>Oct</option>
                      <option>Nov</option>
                      <option>Dec</option>
                    </select>
                    <select class="optyear">
                      <option>2018</option>
                      <option>2019</option>
                      <option>2020</option>
                      <option>2021</option>
                      <option>2023</option>
                      <option>2024</option>
                    </select>
                  </div>
                  <div class="col-sm-6 d-inline-flex">
                    <span>From: </span>
                    <select class="optmonth">
                      <option selected>May</option>
                      <option>January</option>
                      <option>Feb</option>
                      <option>Mar</option>
                      <option>Apr</option>
                      <option>June</option>
                      <option>July</option>
                      <option>Aug</option>
                      <option>Sept</option>
                      <option>Oct</option>
                      <option>Nov</option>
                      <option>Dec</option>
                    </select>
                    <select class="optyear">
                      <option>2018</option>
                      <option>2019</option>
                      <option>2020</option>
                      <option>2021</option>
                      <option>2023</option>
                      <option>2024</option>
                    </select>
                  </div>
                  <div class="col-sm-12 text-right" >
                    <br><br>
                    <button type="button" class="btn btn-sm btn-outline-secondary text-primary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-sm btn-primary" type="button" >Done</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div><!-- end of modal -->



@endsection



@section('scripts')

@endsection