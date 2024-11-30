<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        /* Universal Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Calibri, sans-serif;
            line-height: 1.6;
            color: #393939;
        }

        h1 {
            font-size: 24pt;
            color: #3A5775;
        }

        h2 {
            font-size: 12pt;
            color: #3A5775;
            font-weight: bold;
        }

        /* Layout for Print */
        @page {
            size: A5 landscape;
            margin: 20mm;

        }

        .container {
            width: auto;
            padding: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .header .company-info {
            text-align: left;
            max-width: 60%;
        }

        .header .client-box {
            border: 1px solid #ddd;
            padding: 10px;
            width: 35%;
            border-radius: 5px;
            background-color: #f5f5f5;
            font-size: 10pt;
        }

        .details {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .details .client,
        .details .invoice-info {
            width: 48%;
            font-size: 10pt;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            font-size: 10pt;
        }

        .table th {
            background-color: #3A5775;
            color: white;
        }

        .table td:nth-child(odd) {
            background-color: #EEF3F7;
        }

        .footer {
            margin-top: 20px;
            text-align: left;
        }

        .footer p {
            font-size: 10pt;
        }

        .total {
            font-weight: bold;
            color: #3A5775;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .container {
                padding: 0;
                margin: 0;
            }

            .header,
            .details,
            .table,
            .footer {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <!-- Company Information -->
            <div class="company-info">
                <h2>INVOICE <strong>{{ $transaksi->kodetransaksi }}</strong></h2>
                <h1>UNGGUL KENCANA</h1>
                <p>Jl. Kapten Pattimura No.8, Kec. Purwokerto Barat.</p>
                <p>Kabupaten Banyumas, Jawa Tengah 53136</p>
                <p>Phone: 0822-2537-7888 | Email: contact@yourcompany.com</p>
            </div>

            <!-- Client Information Box -->
            <div class="client-box">
                <p><strong>Mr/Mrs:</strong> {{ $transaksi->pelanggan->nama }}</p>
                <p><strong>Alamat:</strong> {{ $transaksi->pelanggan->alamat }}</p>
            </div>
        </div>

        <!-- Client & Invoice Details Section -->
        <div class="details">
            <div class="client">
                <p><strong>Invoice Date:</strong> {{ $transaksi->tanggal }}</p>
                <p><strong>Due Date:</strong> {{ $transaksi->duedate }}</p>
            </div>
            <div class="invoice-info">
                <p><strong>Payment Method:</strong> Transfer Bank</p>
                <p><strong>Bank Account:</strong> 123456789</p>
            </div>
        </div>

        <!-- Table Section -->
        <table class="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Item</th>
                    <th>Berat</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keranjang as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->produk->nama }}</td>
                        <td>{{ $item->produk->berat }}</td>
                        <td>{{ 'Rp.' . ' ' . number_format($item->produk->harga_jual) }}</td>
                        <td>{{ 'Rp.' . ' ' . number_format($item->total) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="total">Subtotal</td>
                    <td>{{ 'Rp.' . ' ' . number_format($subtotal) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="total">Diskon</td>
                    <td>{{ $transaksi->diskon }} %</td>
                </tr>
                <tr>
                    <td colspan="4" class="total">Total</td>
                    <td>{{ 'Rp.' . ' ' . number_format($transaksi->total) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer Section -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Please make payment by the due date specified above.</p>
        </div>
    </div>
</body>

</html>
