@extends('_layouts.admin.default')


@section('styles')
 <!--  html to pdf cdn -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
   
   <style type="text/css">
    input[type="text"]{
      border: none;
      border-bottom: 2px solid #DCDCDC;
      border-radius: 0;
      background-color: white;
    }
    td>.tbl-head{
      background-color: #A9A9A9;
      border: 2px solid white;
    }
    input[type="text"].solid-lined{
      border-bottom: 2px solid black;
    }
    .title-spans{
      font-size: 15px;
    }

    .first-row{
      font-size: 23px;
    }

    h4{
      font-size: 15px !important;
    }

   </style>
@endsection

@section('content')
<div class="container-fluid" style="background: #fff">
  <div class="row">
    <div class="col-12">
      <button id="btn-download-pdf" class="btn btn-light float-right" type="button">Download as PDF</button>
    </div>
  </div>
  <div class="container-fluid" id="report">
    <div class="row">
      <div class="col-lg-3">
        <h4>CANVASS FORM</h4>
      </div>
      <div class="col-lg-9 text-center">
        <h4>REGION V : BICOL</h4>
      </div>
      <div class="col-lg-12 text-center">
        <h4>Construction Materials Price Data (CMPD) 1<sup>st</sup> Quarter CY 2019</h4>
      </div>

      <div class="col-lg-3">
        <span class="text-left title-spans">District Engineering Office</span> 
      </div>
      <div class="col-lg-9 text-left">
        <span class="">:</span><input type="text" name="" style="width: 95%;">
      </div>
      <div class="col-lg-3">
        <span class="text-left title-spans">Supplier/hardware Name</span>
      </div>
      <div class="col-lg-9 text-left">
        <span class="">:</span><input type="text" name="" style="width: 95%;">
      </div>
      <div class="col-lg-3">
        <span class="text-left title-spans">Location</span>
      </div>
      <div class="col-lg-9 text-left">
        <span class="">:</span><input type="text" name="" style="width: 95%;">
      </div>
      <div class="col-lg-3">
        <span class="text-left title-spans">Date of Canvass</span>
      </div>
      <div class="col-lg-9 text-left">
        <span class="">:</span><input type="text" name="" style="width: 95%;">
      </div>
    </div>
    <div class="mt-3">
      <table class="table-bordered text-center">
        <thead class="first-row table-dark">
          <tr>
            <th style="width: 1000px;">MATERIAL DESCRIPTION</th>
            <th style="width: 80px;">UNIT</th>
            <th style="width: 200px;">UNIT PRICE</th>
            <th style="width: 200px;">REMARKS</th>
          </tr>
          
        </thead>
        <tbody>
          <tr class="">
            <!-- Colored table column -->
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr class="">
            <!-- Colored table column -->
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr class="">
            <!-- Colored table column -->
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr class="">
            <!-- Colored table column -->
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr class="">
            <!-- Colored table column -->
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr class="">
            <!-- Colored table column -->
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr class="">
            <!-- Colored table column -->
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
            <td class="table-secondary"><input type="text" class="tbl-head" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
          <tr>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
            <td><input type="text" name="" style="width: 100%;"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <br>
        </div>
        <div class="col-8">
          <h6>Owner/Authorized Representative:</h6>
        </div>
        <div class="col-4">
          <h6>Contact No.:</h6>
        </div>
        <div class="col-8">
          <input type="text" class="solid-lined" name="" style="width: 60%;">
        </div>
        <div class="col-4">
          <input type="text" class="solid-lined" name="" style="width: 100%;">
        </div>
        <div class="col-12">
          <br>
        </div>
        <div class="col-8">
          <span><bold>Canvassed by:</bold></span>
        </div>
        <div class="col-4">
          <span><bold>Validated by:</bold></span>
        </div>
        <div class="col-8">
          <input type="text" class="solid-lined" name="" style="width: 60%;">
        </div>
        <div class="col-4">
          <input type="text" class="solid-lined" name="" style="width: 100%;">
        </div>
        <div class="col-12">
          <br>
        </div>
      </div>
    </div>
  </div>

</div>
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