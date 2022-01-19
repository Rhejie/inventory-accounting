@extends('_layouts.admin.default')

@section('styles')

 <link rel="stylesheet" type="text/css" href="{{ URL::asset('/theme/admin/css/pages/purchase-order/style_purchaseOrder.css') }}">
@endsection

@section('content')
    
    <div class="container-fluid" id="main">
        <div class="container-fluid text-center" id="title">
            <hr/><h1 style="font-family: Verdana">PURCHASE ORDERS</h1><hr/>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="form-group formCompanyInfo" id="companyInfo">
                    <!-- Input fields for company information-->
                    <div class="row">
                        <div class="col-lg-12">
                            <label><h6>Company Name: </h6></label>
                            <input class="form-control" type="text" name="txtCompanyName" placeholder="Input Company Name">
                        </div>
                        <div class="col-lg-6">
                            <label>Street Address: </label>
                            <input class="form-control" type="text" name="txtStreetAddress" placeholder="Input street address">
                        </div>
                        <div class="col-lg-6">
                            <label>PO Number: </label>
                            <input class="form-control" type="number" name="txtPurchaseNumber" placeholder="Purchase order number">
                            <small id="purchaseNumber" class="form-text text-muted">Input your purchase order number.</small>
                        </div> 
                        <div class="col-lg-6">
                            <label>Zip, City: </label>
                            <input class="form-control" type="text" name="txtZipCity" placeholder="Input zip city">
                        </div>
                        <div class="col-lg-6">
                            <label>PO Date:</label>
                            <input class="form-control" type="date" name="txtpurchaseDate" placeholder="Input PO Date">
                            <small id="purchaseDate" class="form-text text-muted">Select appropiate purchase order date.</small>
                        </div>
                        <div class="col-lg-9">
                            <label>Email Address: </label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="txtEmail"  placeholder="Input email">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="companyEmail">(ex.) @gmail.com</span> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label>Phone Number: </label> <span style="color: red" class="companyNumber"></span>
                            <input class="form-control" type="number" id="companyPhoneNumber" name="txtPhoneNumber" placeholder="Input phone number">
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <form class="form-group formVendorInfo">
                            <!-- Input fields for Vendor's Information -->
                            <h6>Vendor: </h6>
                            <label>Name: </label>
                            <input class="form-control" type="text" name="txtVendorName" placeholder="Enter name">
                            <label>Company Name:</label>
                            <input class="form-control" type="text" name="txtVendorCompanyName" placeholder="Input company name">
                            <label>Street Address: </label>
                            <input class="form-control" type="text" name="txtVendorStreetAddress" placeholder="Input street address">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>City: </label>
                                    <input class="form-control" type="text" name="txtVendorCity" placeholder="Input city"> 
                                </div>
                                <div class="col-lg-6">
                                    <label>ST ZIP: </label>
                                    <input class="form-control" type="text" name="txtVendorStZip" placeholder="Input st zip"> 
                                </div>
                            </div>
                            <label>Phone Number: </label> <span style="color: red" class="vendorNumber"></span>
                            <input class="form-control" type="number" name="txtVendorStZip" id="vendorPhoneNumber" placeholder="Input phone number"> 
                            
                            <label>Email Address: </label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="txtVendorEmail"  placeholder="Input email">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="vendorEmail">(ex.) @gmail.com</span> 
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form class="form-group formShipToInfo">
                            <!-- Input fields for ShipTo's Information -->
                            <h6>Ship to:</h6>
                            <label>Name: </label>
                            <input class="form-control" type="text" name="txtShipToName" placeholder="Enter name">
                            <label>Company Name:</label>
                            <input class="form-control" type="text" name="txtShipToCompanyName" placeholder="Input company name">
                            <label>Street Address: </label>
                            <input class="form-control" type="text" name="txtShipToStreetAddress" placeholder="Input street address">
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

                            <label>Phone Number: </label> <span style="color: red;" class="shipToNumber"></span>
                            <input class="form-control" type="number" name="txtShipToPhoneNumber" id="shipToPhoneNumber" placeholder="Input phone number">
                            <label>Email Address: </label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text"  name="txtShipToEmail"  placeholder="Input email">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="shipToEmail">(ex.) @gmail.com</span> 
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Tables 1 Information-->
                <table class="table tblFirstTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Purchase Order No.</th>
                            <th>Buyer</th>
                            <th>Date</th>
                            <th>Vendor No.</th>
                            <th>Terms</th>
                            <th>Ship Via</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>P00012</td>
                            <td>Juan Pedro</td>
                            <td>04/25/2020</td>
                            <td>09123456789</td>
                            <td>6 months</td>
                            <td>LBC Express</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Tables 2 Information-->
                <table class="table tblSecondTable">
                    <thead class="thead-light">
                        <tr>
                            <th>IT</th>
                            <th>Part Number</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ex.</td>
                            <td>0001</td>
                            <td>Sample Description</td>
                            <td>12</td>
                            <td>40.00</td>
                            <td>1500.00</td>
                        </tr>
                    </tbody>
                </table>
                <!-- Table for Sub Total Inputs -->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="width: 100%"><b>Sub Total</b></td>
                                        <td>0.00</td>
                                    </tr>
                                    <tr> 
                                        <td><b>Tax 12%</b></td>
                                        <td>0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Discount</b></td>
                                        <td>0.00</td>
                                    </tr>
                                    <tr>
                                        <td><b>Grand Total</b></td>
                                        <td>0.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')


<script>
    $(function(){
        $("#companyPhoneNumber").keypress(function(event) {
            if (event.which < 48 || event.which > 57) {
                $(".companyNumber").html("Enter numbers only.").show().fadeOut(2000);
                return false;
            }
        });
        $("#vendorPhoneNumber").keypress(function(event) {
            if (event.which < 48 || event.which > 57) {
                $(".vendorNumber").html("Enter numbers only.").show().fadeOut(2000);
                return false;
            }
        });
        $("#shipToPhoneNumber").keypress(function(event) {
            if (event.which < 48 || event.which > 57) {
                $(".shipToNumber").html("Enter numbers only.").show().fadeOut(2000);
                return false;
            }
        });
    });
</script>


@endsection