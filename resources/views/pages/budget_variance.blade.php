@extends('_layouts.admin.default')


@section('styles')
 <!-- w3school google icon -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- w3school fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
  <style type="text/css">
        
   
    th, td {text-align: center;}
    label{font-size: 12px;}
     
   
    </style>
@endsection

@section('content')
<div style="background: #fff">
  <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-4"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-4"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                <div id="button-download" class="text-right mt-2 mb-2">
                    <div class="dropdown">
                        <button class="btn btn-light border-dark dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Download
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <button id="btn-download-pdf" class="btn btn-light dropdown-item" type="button">
                                Download as PDF
                            </button>
                            <button id="btn-download-excel" class="btn btn-light dropdown-item" type="button">
                                Download as Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="report">
        <h4 class="text-center mt-1 mb-2">Budget Variance Report</h4>
        <h5 class="text-center mt-1 mb-4">Income statement variance report for March quarter</h5>
        <div class="container">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th></th>
                        <th><label>Budget</label><br/><label>P</label></th>
                        <th><label>Actual</label><br/><label>P</label></th>
                        <th><label>Variance</label><br/><label>P</label></th>
                        <th><label>%</label></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-left"><label>Sales Revenue</label></td>
                        <td><label>600,000</label></td>
                        <td><label>500,000</label></td>
                        <td><label>100,000</label></td>
                        <td><label>20%</label></td>
                    </tr>
                    <tr>
                        <td colspan="100%" class="text-left"><label>Less Cost of Goods Sold</label> <br/> <label class="pl-5">Stock as at Jan 1</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Add Purchase</label></td>
                        <td><label>200,000</label></td>
                        <td><label>200,000</label></td>
                        <td><label>0</label></td>
                        <td><label>0</label></td>
                    </tr>
                    <tr>
                        <td ><label class="text-right">Sub Total</label></td>
                        <td><label>200,000</label></td>
                        <td><label>200,000</label></td>
                        <td><label>0</label></td>
                        <td><label>0</label></td>
                    </tr>
                    <tr>
                        <td><label class="text-right pr-5">Less Stock as at March 30</label></td>
                        <td><label>50,000</label></td>
                        <td><label>75,000</label></td>
                        <td><label>(25,000)</label></td>
                        <td><label>(100)</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label>Cost of Goods Sold</label></td>
                        <td><label>150,000</label></td>
                        <td><label>125,000</label></td>
                        <td><label>25,000</label></td>
                        <td><label>17</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label><b>Gross Profit</b></label></td>
                        <td><label><b>450,000</b></label></td>
                        <td><label><b>375,000</b></label></td>
                        <td><label><b>75,000</b></label></td>
                        <td><label><b>17</b></label></td>
                    </tr>
                    <tr>
                        <td colspan="100%"></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label>Less Operating System Expenses</label></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Advertising</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Bank fees</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Postage</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Power</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Insurance</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Motor vehicle</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Lease</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label>Salary Costs</label></td>
                        <td><label></label></td>
                        <td><label></label></td>
                        <td><label></label></td>
                        <td><label></label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Wages</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label class="pl-5">Superannuation</label></td>
                        <td><label>1</label></td>
                        <td><label>2</label></td>
                        <td><label>3</label></td>
                        <td><label>4</label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label><b>Total Expenses</b></label></td>
                        <td><label><b>235,000</b></label></td>
                        <td><label><b>220,100</b></label></td>
                        <td><label><b>15,000</b></label></td>
                        <td><label><b>6</b></label></td>
                    </tr>
                    <tr>
                        <td class="text-left"><label><b>Operating Profit</b></label></td>
                        <td><label><b>214,900</b></label></td>
                        <td><label><b>154,900</b></label></td>
                        <td><label><b>60,000</b></label></td>
                        <td><label><b>28</b></label></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


</div>
@endsection



@section('scripts')
<script type="text/javascript">
   window.onload = function () {
        document.getElementById("btn-download-pdf")
        .addEventListener("click", () => {
            const invoice = this.document.getElementById("report");
            var opt = {
                margin: 0,
                filename: 'convertedtopdf.pdf',
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(report).set(opt).save();
        })
    };
</script>
@endsection