<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            width: 100%;
            margin: auto;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
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
            background: #dff4ff;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: .5px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td {
            border-top: .5px solid #eee;
        }

        .footer {
            font-size: 7px;
            color: #555;
            width: 100%;
            position: fixed;
            bottom: -15px;
            border-top: .5px solid #eee;
        }
    </style>
</head>
<body>
<div class='invoice-box'>
    <table cellpadding='0' cellspacing='0'>
        <tr class='top'>
            <td colspan='2'>
                <table>
                    <tr>
                        <td class='title'>
                            <img src="var:logo" style='width: 100%; max-width: 100px;'>
                            <p style='font-size:20px;'>TheraConnect</p>
                        </td>
                        <td>
                            <p style='font-size:40px; font-weight:bold; color:#3a86ff;'>INVOICE</p>
                            {{$invoice_number}}<br>
                            Date: {{$billing_date}}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class='information'>
            <td colspan='2'>
                <table>
                    <tr>
                        <td>
                            <span style='font-weight:bold; color:#3a86ff;'>Bill To:</span><br>
                            {{$patient_name}}<br>
                            {{$patient_phone_number}}<br>
                            @if($patient_email)
                                {{$patient_email}}<br>
                            @endif
                            {{$patient_address}}<br>
                            Mode of Transaction: {{ucfirst($payment_mode)}}
                        </td>
                        <td style='text-align:left; padding-left:200px;'>
                            <span style='font-weight:bold; color:#3a86ff;'>Bill From:</span><br>
                            Jasodha Health Clinic<br>
                            9830619165<br>
                            jasodahealthcare@gmail.com<br>
                            Dumdum<br>
                            GST: 19EJDPS4723L
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class='heading'>
            <td>Item</td>
            <td>Amount (₹)</td>
        </tr>
        @foreach($clinical_test as $test)
            <tr class='total'>
                <td>{{$test->name}}</td>
                <td>₹{{number_format($test->amount, 2)}}</td>
            </tr>
        @endforeach
        <tr class='total'>
            <td>Total Test Amount:</td>
            <td>₹{{number_format($clinical_test_amount, 2)}}</td>
        </tr>
        <tr class='total'>
            <td>GST ({{$gst_percentage}}%):</td>
            <td>₹{{ $is_gst_bill ? number_format($gst_amount, 2) : number_format(0, 2)}}</td>
        </tr>
        <tr class='total'>
            <td>Total with GST:</td>
            <td>₹{{ number_format($clinical_test_amount + $gst_amount, 2) }}</td>
        </tr>
        <tr class='item'>
            <td>Doctor Fees: <span style="display: {{$is_add_doctor_fees ? 'block' : 'none'}}">({{$doctor_name}})</span>
            </td>
            <td>₹{{$doctor_fees}}</td>
        </tr>
        <tr class='total'>
            <td style='font-size: 15px; color: #3a86ff;'><strong>Net Amount:</strong></td>
            <td style='font-size: 15px; color: #3a86ff;'><strong>₹{{number_format($billing_amount, 2)}}</strong></td>
        </tr>
    </table>
    <p style='font-size:12px; text-align:right;'>{{$billing_amount_in_word}} Rupees
        Only</p>
</div>
</body>
</html>
