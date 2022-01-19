<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .container {

        }

        .header {
            background-color: #0d1033;
            color: #fff
        }

        .header_content {
            width: 400px;
            padding: 10px
        }

        .header_content_1 {
            /* width: 400px; */
            padding: 10px;
            margin-left: 0;
            margin-top: -100;
        }

        .header_content h1 {
            font-style: italic;
        }

        .asde_logo {
            width: 110px;
            float: right;
        }

        .side {
            text-align: right;
        }

        .side span {
            font-size: 11px;
        }

        .info_proposal table {
            width: 100%;
        }

        .info_proposal table thead th{
            text-align: left;
        }
        .brand-section{
           background-color: #0d1033;
           padding: 10px 40px;
        }
        .logo{
            width: 50%;
        }

        .row{
            display: flex;
            flex-wrap: wrap;
        }
        .col-6{
            width: 50%;
            flex: 0 0 auto;
        }
        .text-white{
            color: #fff;
        }
        .company-details{
            float: right;
            text-align: right;
        }
        .body-section{

        }
        .heading{
            font-size: 20px;
            margin-bottom: 08px;
        }
        .sub-heading{
            color: #262626;
            margin-bottom: 05px;
        }
        table{
            background-color: #fff;
            width: 100%;
            border-collapse: collapse;
        }
        table thead tr{
            border: 1px solid #111;
            background-color: #f2f2f2;
        }
        table td {
            vertical-align: middle !important;
            text-align: center;
        }
        table th, table td {
            padding-top: 08px;
            padding-bottom: 08px;
        }

        table tbody tr td {
            font-size: 11px;
        }
        table thead th {
            font-size: 13px;
        }
        .table-bordered{
            box-shadow: 0px 0px 5px 0.5px gray;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
        }
        .text-right{
            justify-content: right;
        }
        .w-20{
            width: 20%;
        }
        .float-right{
            float: right;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- <img src="{{ public_path('/img/logo.png') }}" style="width: 100px; height: 100px"> --}}
        <div class="header">
            <div class="header_content">
                <h1>PROPOSAL</h1>
            </div>
            <div class="header_content_1 side">
                {{-- <img src="/img/logo.png" class="asde_logo" alt="ASDEC logo"><br/><br/><br/> --}}
                <img src="{{public_path('/img/logo.png')}}" class="asde_logo" alt="ASDEC logo"><br/><br/><br/>
                <span>ASDEC BUILDERS CORPORATION</span><br/>
                <span>225 BANLAT ROAD TANDANG SORA, QUEZON CITY</span><br/>
                <span>TEL NO. 3455-5115 * TELEFAX NO. 7000-9800 * CEL NOS. (Sun) 0925-864-5310 (Globe) 09661430147</span><br/>
                <span>EMAIL ADD: <span class="invoice_company_email">asdec_mae@yahoo.com</span> * <span class="invoice_company_email">asdecbuilders@yahoo.com</span></span>
            </div>
        </div>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>PROPOSAL NO.</th>
                    <th>ISSUE DATE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$proposal->proposal_number}}</td>
                    <td>{{$proposal->date_issue}}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th style="text-align: left;">PROJECT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:left">{{$proposal->project->name}}</td>
                </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <tr>
                    <th style="text-align: left;">PROPOSAL TO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align:left">
                        <p>Name: <span>{{$proposal->customer->name}}</span></p>
                        <p>Email: <span>{{$proposal->customer->email}}</span></p>
                        <p>Contact: <span>{{$proposal->customer->contact}}</span></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <hr>
        <div class="body-section">
            <h3 class="heading">Services</h3>
            <br>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Fee</th>
                        <th>Qty</th>
                        <th>Tax</th>
                        <th>Unit</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proposal->items as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->service_fee}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->tax_rate}} </td>
                            <td>{{$item->unit}}</td>
                            <td style=" font-weight: 800">{{$item->price}}<br/> <span style="color:#da3300; font-weight:600; font-size=10px">without tax</span></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-right">Sub Total</td>
                        <td style="font-weight: 800"> {{$proposal->subtotal}} <br/> <span style="color:#da3300; font-size=10px">without tax</span></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">Discount</td>
                        <td style="font-weight: 800"> {{$proposal->total_discount}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">Tax</td>
                        <td style="font-weight: 800"> {{$proposal->total_tax}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">Total</td>
                        <td style="font-weight: 800"> {{$proposal->total_amount}} <br/> <span style="color:#da3300; font-size=10px">with tax</span></td>
                    </tr>
                </tbody>
            </table>
            <br/>
            <br/>
            <span style="font-size:10px; font-weight:600;">{{$proposal->date}}</span>
        </div>
    </div>
</body>
</html>
