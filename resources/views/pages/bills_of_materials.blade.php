@extends('_layouts.admin.default')


@section('styles')
    <!--  html to pdf cdn -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>

    <style type="text/css">
        span{
            font-size: 13px;
            font-weight: bold;
        }
        .border-row{
            border:1px solid gray;
        }
        .border-table{
           /* border:1px solid gray;*/
            background-color: #FAFAD2;
            height: 25px;
        }
        thead{
            font-size: 13px;
            font-weight: bold;
        }
        .unresponsive{
            min-width: 50px;
        }
    </style>
@endsection

@section('content')
 <div class="container-fluid" style="background: #fff;padding-top: 20px;padding-bottom: 20px"> 
   <div class="row">
        <div class="col-12">
            <button id="btn-download-pdf" class="btn btn-light float-right" type="button">Download as PDF</button>

        </div>
    </div>
     <br>
  <div class="container-fluid border" id="report">
        <!-- first row -->
        <div class="row">
            <div class="col-lg-2 text-center border-row">
                <h2>EMERGE</h2>
            </div>
            <div class="col-lg-10 text-center border-row">
                <h5 class="mt-2">Bill of Materials</h5>
            </div>
        </div>
        <!-- second row -->
        <div class="row">
            <div class="col-lg-2 col-sm-6 col-6 text-lg-right text-right border-row" style="background-color: #48D1CC;">
                <span class="d-block">Product Name</span>
                <span class="d-block">Assembly Name</span>
                <span class="d-block">Assembly Number</span>
                <span class="d-block">Assembly Revisions</span>
            </div>
            <div class="col-lg-3 col-sm-6 col-6 border-row" style="background-color: lightblue;">
                 <span class="d-block"></span>
                <span class="d-block"></span>
                <span class="d-block"></span>
                <span class="d-block"></span>
            </div>
            <div class="col-lg-2 col-sm-4 col-4 text-right border-row" style="background-color: #8cff66;">
                <span class="d-block">Approved By</span>
                <span class="d-block">Approved Date</span>
                <span class="d-block">Part Count</span>
                <span class="d-block">Total Cost</span>
            </div>
             <div class="col-lg-3 col-sm-4 col-4 text-right border-row" style="background-color:lightgreen;">
                <span class="d-block"><br></span>
                <span class="d-block"><br></span>
                <span class="d-block">0</span>
                <span class="d-block">&#8369;0.00</span>
            </div>
            <div class="col-lg-2 col-sm-4 col-4 text-center my-auto">
                <span>Product Image</span>
            </div>
        </div>
        <!-- Third Row -->
        <div class="row ">
            <div class="col-lg-12 border-row">
                <div class="m-4">
                    
                </div>
            </div>
        </div>
        <!-- fourth row -->
        <div class="unresponsive border-row" style="overflow-x: auto;">
            <table class="table">
                <thead style="background-color: #F0E68C;">
                    <tr>
                        <th scope="col">BOM level</th>
                        <th scope="col">Part#</th>
                        <th scope="col">Part Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Quantity</th>  
                        <th scope="col">Units</th>
                        <th scope="col">Unit Cost</th>
                        <th scope="col">Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="background-color:#FFB6C1;">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="background-color: #F08080">Total</td>
                        <td>0</td>
                        <td></td>
                        <td style="background-color: #F08080">Total</td>
                        <td>&#8369;0.00</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
  </div>
  
<!-- </div> -->

@endsection



@section('scripts')
 <script>
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