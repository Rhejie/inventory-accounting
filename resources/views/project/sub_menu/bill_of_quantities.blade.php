<style>
    .header{
  margin-top: 30px;
  margin-bottom: 30px;
}
.form-edit{
  margin-bottom: 30px;
}
input{
    border: none;
    border-bottom: 1px solid silver;
    outline:none ;
    padding-right: 80%;
    margin-top: 10px;
}
#date{
  padding-right: 86.5%;
}
label{
  margin-left: 10px;
  margin-right: 10px;
  margin-top: 10px;
}
td{
    border: 2px solid black;
}
thead{
    border: 2px solid black;
    text-align: center;
    background-color:  #d6dce4
}
.table thead th{
    border: 2px solid black;
}
.a{
    color: red ;
}
.b, .c{
    background-color:#d6dce4 ;
    text-align: center;
}
.d{
    background-color: #f8cbad;
    text-align: center;
}
.td-1, .td-2, .td-3, .td-4, .td-5, .td-6, .td-7, .td-8, .td-9, .td-10, .td-11, .td-12, .td-13, .td-14, .td-15, .td-16, .td-17 {
    text-align: center;
}
footer{
    margin-top: 50px;
}
.footer-1{
    margin-bottom: 40px;
}
.footer-2{
    margin: auto;
}
</style>


<div class="bills-of-quantities">

    <head>
        <title>Bill of Quantities</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        {{-- <link rel="stylesheet" href="bill-of-quantities-style.css"> --}}
    </head>
    <body>
        <div class="container-fluid">
        <div class="header">
        {{-- <img src="logo.png">  --}}
        <img src="/assets/img/bill_of_quantities/logo.png"> 
        <p><b>ASDEC BUILDERS CORPORATION</b></p>
        </div>
        <form action="/action_page.php" method="post">
        <div class="form-edit">
        <div class="form-row">
        <label>Date:</label>
            <input type="date" id="date" name="name" required autocomplete="name">
        </div>
        <div class="form-row">
        <label>Owner:</label>
            <input type="text" id="name" name="name" required autocomplete="name"placeholder="Enter owner">
        </div>
        <div class="form-row">
        <label>Project:</label>
            <input type="text" id="name" name="name" required autocomplete="name"placeholder="Enter project">
        </div>
        <div class="form-row">
        <label>Subject:</label>
            <input type="text" id="sub" name="name" required autocomplete="name"placeholder="Input subject">
        </div>
    </div>
    </form>
    <table class="table">
        <thead>
            <tr>
            <th>ITEM#</th>
            <th>DESCRIPTION</th>
            <th>UNIT</th>
            <th>QTY</th>
            <th>UNIT COST</th>
            <th>AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td class="td-1"><b>1.0</b></td>
            <td><b>GENERAL REQUIREMENTS</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            <tr>
            <td></td>
            <td>Mobilization / Demobilzation</td>
            <td class="td-2">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Materials Sampling and Testing</td>
            <td class="td-3">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>As-built, Shop Drawings, Submittals and Reports</td>
            <td class="td-4">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Construction Survey, Site Survey and Stake out</td>
            <td class="td-5">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Temporary Facilities</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            <tr>
            <td></td>
            <td>Site Office and Warehouse</td>
            <td class="td-6">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Staffhouse / Barracks</td>
            <td class="td-7">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Utilities (power, water, etc.)</td>
            <td class="td-7">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Project Overhead, Administrative Cost</td>
            <td class="td-8">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Bonds and Insurance</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            <tr>
            <td></td>
            <td>Downpayment Bond (20%)</td>
            <td class="td-9">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Performance Bond (30%)</td>
            <td class="td-10">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Contractor's All Risk Insurance (CAR) (20%)</td>
            <td class="td-11">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Guarantee Bond (10%)</td>
            <td class="td-11">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Permits & Licenses (Brgy. Clearance, Local permits)</td>
            <td class="td-12">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td class="a">Only DENR permits shall be provided by the Landco</td>
            <td></td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Security, Safety and Housekeeping (includes workers PPE)</td>
            <td class="td-13">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Temporary Fence</td>
            <td class="td-14">lm</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Others please specify</td>
            <td></td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Mobilization & Demobilization of Batching Plant</td>
            <td class="td-15">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td>Miscellaneous Contractor Expenses - deliveries, communication, supplies, service crane/vehicles</td>
            <td class="td-16">lot</td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>-</td>
            </tr>
            <tr class="b">
            <td></td>
            <td><b>Sub-Total 1.0</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b>-</b></td>
            </tr>
            <tr>
            <td class="td-17"><b>2.0</b></td>
            <td>Earthworms</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            <tr class="c">
            <td></td>
            <td><b>Sub-Total 2.0</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b>-</b></td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            <tr class="d">
            <td></td>
            <td><b>TOTAL COST</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
        </tbody>
        </table>
        <footer>
            <p class="footer-1">Submitted by:</p>
            <p class="footer-2"><b>ASDEC BUILDERS CORPORATION</b></p>
            <p>Generator Contractor</p>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </div>
    </body>
</div>