@extends('_layouts.admin.default')

@section('styles')

 <link rel="stylesheet" type="text/css" href="{{ URL::asset('/theme/admin/css/pages/invoice/style_invoice.css') }}">
@endsection

@section('content')
  

        <div class="container-fluid" id="main">
     <!-- Header or navigation part. -->
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container-fluid">
                <img src="{{ URL::asset('img/invoice.png') }}" class="rounded-circle">
                <div class="navbar-nav ml-auto">
                    <h1 id="title"><b>INVOICE</b></h1>
                </div>
            </div>
        </nav>
    <!-- End of Header or navigation part. -->


        <hr/>
        <div class="row">
            <div class="col-lg-6">
                <form class="form-group formCompanyInfo">
                    <!-- Input fields for Company Information -->
                    <label>Company Name: </label>
                    <input class="form-control" type="text" name="txtCompanyName" placeholder="Enter name">
                    <label>Company Street Address: </label>
                    <input class="form-control" type="text" name="txtStreetAddress" placeholder="Input company street address">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>City: </label>
                            <input class="form-control" type="text" name="txtCity" placeholder="Input city"> 
                        </div>
                        <div class="col-lg-6">
                            <label>ST ZIP: </label>
                            <input class="form-control" type="text" name="txtStZip" placeholder="Input st zip"> 
                        </div>
                    </div>
                    <label>Telephone Number: </label> <span style="color: red" class="companyAlert"></span>
                    <input class="form-control" type="number" name="txtTelephoneNumber" id="companyPhoneNumber" placeholder="Input telephone number"> 
                    <label>Email Address: </label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="txtEmail"  placeholder="Input email">
                        <div class="input-group-append">
                            <span class="input-group-text" id="companyEmail">(ex.) @gmail.com</span> 
                        </div>
                    </div>
                </form>
                <!-- End of company input fields -->

            </div>
            <div class="col-lg-6">
                <!-- Input fields of right side of UI -->
                <div class="row">
                    <div class="col-lg-6">
                        <label>INVOICE NO. </label><span style="color: red" class="invoiceAlert"> </span>
                        <input class="form-control" type="number" name="txtInvoiceNumber" id="invoiceNumber" placeholder="Input telephone number"> 

                    </div>
                    <div class="col-lg-6">
                        <label>DATE</label>
                        <input class="form-control" type="date" name="txtDate"> 
                        <small id="purchaseDate" class="form-text text-muted" >Select appropiate date.</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <label>CUSTOMER ID</label>
                        <input class="form-control" type="text" name="txtCustomerId" placeholder="Input customer id"> 
                    </div>
                    <div class="col-lg-6">
                        <label>TERMS</label>
                        <input class="form-control" type="text" name="txtTerms" placeholder="Input terms"> <br/>
                    </div>
                </div>
            </div>
            <!-- End of right side input fields -->

        </div>
        <div class="row">
            <div class="col-lg-6">
                <form class="form-group formBillToInfo">
                    <!-- Input fields for BillTo Information -->
                    <h6>BILL TO: </h6>
                    <label>ATTN. Name/Dept </label>
                    <input class="form-control" type="text" name="txtBillToAttn" placeholder="Enter name or department">
                    <label>Company Name:</label>
                    <input class="form-control" type="text" name="txtBillToCompanyName" placeholder="Input company name">
                    <label>Street Address: </label>
                    <input class="form-control" type="text" name="txtBillToStreetAddress" placeholder="Input company street address">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>City: </label>
                            <input class="form-control" type="text" name="txtBillToCity" placeholder="Input city"> 
                        </div>
                        <div class="col-lg-6">
                            <label>ST ZIP: </label>
                            <input class="form-control" type="text" name="txtBillToStZip" placeholder="Input st zip"> 
                        </div>
                    </div>
                    <label>Telephone Number: </label> <span style="color: red" class="billToAlert"></span>
                    <input class="form-control" type="number" name="txtBillToTelephoneNumber" id="billToTelephoneNumber" placeholder="Input telephone number"> 
                    <label>Email Address: </label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="txtBillToEmail"  placeholder="Input email">
                        <div class="input-group-append">
                            <span class="input-group-text" id="billToEmail">(ex.) @gmail.com</span> 
                        </div>
                    </div>
                </form>
                <!-- End of Bill To input fields -->
            </div>
            <div class="col-lg-6">
                <form class="form-group formShipToInfo">
                    <!-- Input fields for ShipTo's Information -->
                    <h6>SHIP TO:</h6>
                    <label>ATTN. Name/Dept </label>
                    <input class="form-control" type="text" name="txtShipToAttn" placeholder="Enter name or department">
                    <label>Company Name:</label>
                    <input class="form-control" type="text" name="txtShipToCompanyName" placeholder="Input company name">
                    <label>Street Address: </label>
                    <input class="form-control" type="text" name="txtShipToStreetAddress" placeholder="Input company street address">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>City: </label>
                            <input class="form-control" type="text" name="txtShipToCity" placeholder="Input city"> 
                        </div>
                        <div class="col-lg-6">
                            <label>ST ZIP: </label>
                            <input class="form-control" type="text" name="txtShipToStZip" placeholder="Input st zip"> 
                        </div>
                    </div>

                    <label>Telephone Number: </label> <span style="color: red;" class="shipToAlert"></span>
                    <input class="form-control" type="number" name="txtShipToTelephoneNumber" id="shipToTelephoneNumber" placeholder="Input telephone number">
                </form>
                <!-- End of Ship To input fields -->
            </div>
        </div>
        <!-- Table for Description and Amounts -->
        <table class="table">
            <thead style="font-family: Arial; background-color: lightblue;">
                <tr>
                    <th width="70%">Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Services 1</td>
                    <td>25.00</td>
                </tr>
                <tr>
                    <td>Services 2</td>
                    <td>50.00</td>
                </tr>
            </tbody>
        </table>
        <!-- End of Table Descriptions and Amounts -->

        
        <div class="container-fluid">
            <div class="row">
                <!-- Remarks or Instruction -->
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="remarks"><b>Remarks / Instructions:</b></label>
                        <textarea class="form-control" rows="5" id="txtRemarks"></textarea>
                    </div>
                    <div class="container text-center"><h3>THANK YOU!</h3></div>
                </div>
                <!-- End of Remarks or Instruction -->

                <!-- Table for Subtotal -->
                <div class="col-lg-4">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 70%;"><b>SUBTOTAL</b></td>
                                <td style="text-align: right">125</td>
                            </tr>
                            <tr> 
                                <td><b>TAX (3.8%)</b></td>
                                <td style="text-align: right">4.75</td>
                            </tr>
                            <tr>
                                <td><b>SHIPPING AND HANDLING</b></td>
                                <td style="text-align: right">10.00</td>
                            </tr>
                            <tr>
                                <td><b>TOTAL</b></td>
                                <td style="text-align: right">$ 139.75</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- End of Table Subtotal -->

            </div>
        </div>
    </div>

@endsection



@section('scripts')
<script>
$(function(){
    $("#companyPhoneNumber").keypress(function(event) {
        if (event.which < 48 || event.which > 57) {
            $(".companyAlert").html("Enter numbers only.").show().fadeOut(2000);
            return false;
        }
    });
    $("#invoiceNumber").keypress(function(event) {
        if (event.which < 48 || event.which > 57) {
            $(".invoiceAlert").html("Enter numbers only.").show().fadeOut(2000);
            return false;
        }
    });
    $("#billToTelephoneNumber").keypress(function(event) {
        if (event.which < 48 || event.which > 57) {
            $(".billToAlert").html("Enter numbers only.").show().fadeOut(2000);
            return false;
        }
    });
    $("#shipToTelephoneNumber").keypress(function(event) {
        if (event.which < 48 || event.which > 57) {
            $(".shipToAlert").html("Enter numbers only.").show().fadeOut(2000);
            return false;
        }
    });
});
</script>

@endsection