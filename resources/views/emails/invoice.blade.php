<style>

    .header {
        display: flex;
        flex-direction: row;
    }

    .invoice span {
        font-weight: 600;
        font-size: 60px;
    }


    .invoice {
        width: 50%;
        padding: 5px
    }

    .content {
        display: flex;
        flex-direction: row;
    }

    .customer {
        width: 50%;
        padding: 10px;
        margin-left: 10%;
        margin-right: 10%;
    }

    .services {
        padding: 10px;
        margin-left: 10%;
        margin-right: 10%;
    }

    .services span {
        font-weight: 600;
        font-size: 30px
    }

    .services table{
        width: 100%;
    }

    .services table thead th {
        text-align: left;
    }

    .customer p {
        line-height: 0.7
    }

    .customer p span {
        font-weight: 600
    }

    .container {
        padding: 10px;
        margin-left: 10%;
        margin-right: 10%;
        background-color: rgb(255, 255, 255)
    }

    .wrapper {
        padding: 10px;
    }

    .total_display {
        justify-content: center;
        padding: 10px;
        margin-left: 10%;
        margin-right: 10%;
    }

    .total_display .content_total span {
        font-weight: 600
    }
</style>
<div style="">
    <div class="container">
        <div class="wrapper">
            <div class="header">
                <div class="invoice">
                    <span>INVOICE</span>
                </div>
                <div class="invoice">
                    <img src="https://asdec-qa.gleentacademy.com/img/logo.png" alt=""><br/>
                    <div class="address" style="text-align: right; margin-right:33%">
                        <span style="font-size: 13px; text-align: right">ASDEC BUILDERS CORPORATION</span><br/>
                        <span style="font-size: 13px; text-align: right">225 BANLAT ROAD TANDANG SORA, QUEZON CITY</span><br/>
                        <span style="font-size: 13px; text-align: right">TEL NO. 3455-5115 * TELEFAX NO. 7000-9800 * CEL NOS. (Sun) 0925-864-5310 (Globe) 09661430147</span><br/>
                        <span style="font-size: 13px; text-align: right">EMAIL ADD: <span style="font-size: 13px; text-align: right" class="invoice_company_email">asdec_mae@yahoo.com</span> * <span style="font-size: 13px; text-align: right" class="invoice_company_email">asdecbuilders@yahoo.com</span></span>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="customer">
                    <p>Name: <span>{{$details->info->customer->name}}</span></p>
                    <p>Email: <span>{{$details->info->customer->email}}</span></p>
                    <p>Contact: <span>{{$details->info->customer->contact}}</span></p>

                </div>
                <div class="customer">
                    <p>CREATED: <span>{{$details->info->created_at}}</span></p>
                    <p>INVOICE NO.: <span>{{$details->info->ref_number}}</span></p>
                    <p>ISSUE DATE: <span>{{$details->info->issue_date}}</span></p>
                    <p>DUE DATE: <span>{{$details->info->due_date}}</span></p>
                    <p>PROJECT: <span>{{$details->info->project->name}}</span></p>
                </div>
            </div>
            <div class="services">
                <span>Services</span>
                <table class="services_table">
                    <thead>
                        <th>NAME</th>
                        <th>FEE</th>
                        <th>QUANTITY</th>
                        <th>TAX</th>
                        <th>UNIT</th>
                        <th>AMOUNT</th>
                    </thead>
                    <tbody>
                        @foreach ($details->info->items as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->service_fee}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{$item->tax_rate}} </td>
                                <td>{{$item->unit}}</td>
                                <td>{{$item->price}} <br/><span style="font-size:13px; color:rgb(179, 33, 33)">without tax</span></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
            <div class="total_display">
                <div class="content_total">
                    <p>Subtotal: <span>{{$details->info->subtotal}} - </span><span style="color:rgb(179, 33, 33)">without tax</span></p>
                    <p>discount: <span>{{$details->info->total_discount}}</span></p>
                    <p>Tax: <span>{{$details->info->total_tax}}</span></p>
                    <p>Total: <span>{{$details->info->total_amount}} -</span> <span style="color:rgb(179, 33, 33)">with tax</span></p>
                </div>
            </div>
            {{-- <img src="/img/logo.png" alt="" srcset=""> --}}

        </div>
    </div>

</div>

{{-- @component('mail::message')
# Introduction
{{$details}}
The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent --}}
