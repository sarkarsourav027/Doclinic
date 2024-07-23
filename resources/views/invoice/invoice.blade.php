<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Invoice</title>

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        li {
            list-style: none;
        }

        .header-part {
            display: flex;
            justify-content: flex-end;
        }

        .header-address {
            margin-bottom: 20px;
            text-align: right;
        }

        .header-address img {
            width: 240px;
        }

        .header-address ul li {
            line-height: 25px;
            font-size: 15px;
        }

        .invoice-container {
            border: 1px solid #ededed;
            padding: 20px;
        }

        .customer-details-invoice {
            display: grid;
            grid-template-columns: 1fr 1fr;
            margin-bottom: 20px;
            gap: 0 10px;
        }

        .address h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            border-bottom: 1px solid;
            display: inline-block;
        }

        .address ul li {
            line-height: 25px;
            font-size: 15px;
            font-weight: 500;
        }

        .address p {
            font-size: 15px;
            font-weight: 500;
            margin-top: 5px;
        }

        .customer-invoice table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ededed;
        }

        .customer-invoice table td {
            border: 1px solid #555555;
            border-collapse: collapse;
            padding: 5px;
        }

        .tax-invoice {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .tax-invoice td, th {
            border: 1px solid #555555;
            padding: 5px;
        }

        .subtotal {
            text-align: right;
        }

        .footer-part {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background-color: #ededed;
            padding: 20px;
            gap: 0 10px;
        }

        .terms {
            margin-top: 10px;
        }

        .terms h4 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .terms ul li {
            font-size: 15px;
            line-height: 25px;
        }

        .file-upload {
            border: 1px solid #555555;
            height: 100%;
            width: 100%;
        }
        .new-page-section {
            page-break-before: always;
        }
    </style>
</head>
<body>
<section class="invoice-section">
    <div class="invoice-container">
        <div class="header-part">
            <div class="header-address">
                <ul>
                    <li>PARTY NAME</li>
                    <li>2F-1, No.130, Nanjing E.Road</li>
                    <li>Sector -4, Songshan District</li>
                    <li>Taipei city-105, Taiwan R.O.C</li>
                    <li> Website: www.intersoftkk.com</li>
                    <li>Co. Reg No. : 27547926,Tax id - 111309435</li>
                </ul>
            </div>
        </div>
        <div class="customer-details-invoice">
            <address class="address">
                <h2>Customer Name & Address</h2>
                <ul>
                    <li>INTERSOFTKK (TAIWAN) PVT. LTD.</li>
                    <li>2F-1, No.130, Nanjing E.Road</li>
                    <li>Sector -4, Songshan District</li>
                    <li> Taipei city-105, Taiwan R.O.C</li>
                    <li>Website: www.intersoftkk.com</li>
                    <li>Co. Reg No. : 27547926,Tax id - 111309435</li>
                    <li>Corporate Tax id -  52490393</li>
                    <li>VAT ID/GST ID: 52490393</li>
                    <li>Company code (in SAP): 7490</li>
                </ul>
            </address>
            <div class="customer-invoice">
                <table>
                    <tbody>
                    <tr>
                        <td>Invoice Date</td>
                        <td>06-06-2024</td>
                    </tr>
                    <tr>
                        <td>Invoice No.</td>
                        <td>XXXXXX</td>
                    </tr>
                    <tr>
                        <td>Invoice No.</td>
                        <td>XXXXXX</td>
                    </tr>
                    <tr>
                        <td>P.O</td>
                        <td>XXXXXX</td>
                    </tr>
                    <tr>
                        <td>Terms</td>
                        <td>45 Days</td>
                    </tr>
                    <tr>
                        <td>Due Date</td>
                        <td>=I8+45</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <table class="tax-invoice">
            <thead>
            <tr>
                <th></th>
                <th>DESCRIPTION</th>
                <th>Monthly Rate In INR</th>
                <th>Service Month</th>
                <th>AMOUNT (INR)</th>
            </tr>
            </thead>
            <tbody>
            @for($i=1;$i<2;$i++)
                <tr>
                    <td>{{$i}}</td>
                    <td>Test</td>
                    <td>Test</td>
                    <td>Test</td>
                    <td>Test</td>
                </tr>
            @endfor
            <tr>
                <td></td>
                <td>Professional Service Fees</td>
                <td>XXXX</td>
                <td>MAY 2024</td>
                <td>XXXX</td>
            </tr>
            <tr>
                <td></td>
                <td>Resource's Name:</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" class="subtotal">Subtotal</td>
                <td>=SUM(J21:J30)</td>
            </tr>
            <tr>
                <td colspan="4" class="subtotal">Subtotal</td>
                <td>=SUM(J21:J30)</td>
            </tr>
            <tr>
                <td colspan="4" class="subtotal">Subtotal</td>
                <td>=SUM(J21:J30)</td>
            </tr>
            <tr>
                <td colspan="4" class="subtotal">Subtotal</td>
                <td>=SUM(J21:J30)</td>
            </tr>
            </tbody>
        </table>
        <div class="footer-part new-page-section">
            <div class="">
                <address class="address">
                    <h4>Account Information</h4>
                    <h2>Mega International Commercial Bank</h2>
                    <ul>
                        <li>HSIN YI Branch</li>
                        <li>No.65, Sector -2, Keelung Road</li>
                        <li>Taipei, Taiwan 11052</li>
                        <li>Corporate Account #: 4809014142</li>
                        <li>A/C Name: Intersoftkk (Taiwan) Pvt Ltd</li>
                    </ul>
                    <p>(SWIFT code for NTD: 0170480) (SWIFT code for foreign currency: ICBCTWTP048)</p>
                </address>
                <div class="terms">
                    <h4>Terms & Conditions:</h4>
                    <ul>
                        <li>Prices are quoted in Taiwan Dollar (TWD)</li>
                        <li>Payments to be paid within 30days from the date of invoice</li>
                        <li>There will be a 1.5% interest charge per month on overdue payments</li>
                    </ul>
                </div>
            </div>
            <div class="file-upload"></div>
        </div>
    </div>
</section>
</body>
</html>
