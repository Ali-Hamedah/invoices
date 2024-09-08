<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>A simple, clean, and responsive HTML invoice template</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .invoice-box.rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .invoice-box.rtl table {
            text-align: right;
        }

        .invoice-box.rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{ asset('assets/img/logo.png') }}"
                                 style="width: 100%; max-width: 300px"/>
                        </td>

                        <td>
                            invoice_number : {{ $invoices->invoice_number }}<br/>
                            Created: {{ $invoices->invoice_Date }}<br/>
                            Due: {{ Carbon\Carbon::now()->format('Y-m-d') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            Acme Corp.<br/>
                            {{__('invoices.Invoice_Number')}}: {{ $invoices->invoice_number }}<br/>
                            {{__('invoices.Date_addition')}} : {{ $invoices->invoice_Date }}<br/>
                            {{__('invoices.Due_Date')}}: {{ $invoices->Due_date }}<br/>
                            {{__('invoices.Section')}} : {{ $invoices->sections->section_name }}
                        </td>

                        <td>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>{{__('invoices.Product')}}</td>
            <td> {{__('invoices.Collection_Amount')}}</td>

        </tr>

        <tr class="details">
            <td>{{ $invoices->product }}</td>
            <td>{{ $invoices->Amount_collection }}</td>


        </tr>

        <tr class="heading">
            <td>Prices</td>

            <td>Price</td>
        </tr>

        <tr class="item">
            <td>{{ $invoices->Amount_Commission }}</td>

            <td> {{__('invoices.Commission_Amount')}}</td>
        </tr>

        <tr class="item">
            <td>{{ $invoices->Rate_VAT }}</td>

            <td> {{__('invoices.Tax_Rate')}}</td>
        </tr>

        <tr class="item last">
            <td>{{ $invoices->Discount }}</td>

            <td> {{__('invoices.Tax_Value')}}</td>
        </tr>

        <tr class="total">
            <td></td>

            <td>Total: {{ $invoices->Total }}</td>
        </tr>
    </table>
</div>
</body>
</html>
