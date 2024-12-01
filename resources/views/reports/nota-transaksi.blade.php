<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Calibri, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #393939;
            padding: 20px;
            width: 20cm;
            height: 10cm;
            margin: 0;
        }

        h1 {
            font-size: 24pt;
            color: #3A5775;
            text-align: left;
        }

        h2 {
            font-size: 12pt;
            color: #3A5775;
            font-weight: bold;
        }

        .container {
            width: auto;
            height: auto;
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: left;
            margin-bottom: 10px;
        }

        .header h2 {
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10pt;
        }

        /* Client & Invoice Details Section */
        .details {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        .client,
        .invoice-info {
            width: 48%;
            font-size: 10pt;
        }

        /* Table Section */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 6px;
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

        .table td img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .table tfoot td {
            padding: 6px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <h2>INVOICE <strong>{{ $transaksi->kodetransaksi }}</strong></h2>
            <h1>UNGGUL KENCANA</h1>
            <p>Jl. Kapten Pattimura No.8, Kec. Purwokerto Barat.</p>
            <p>Kabupaten Banyumas, Jawa Tengah 53136</p>
            <p>Phone: 0822-2537-7888 | Email: contact@yourcompany.com</p>
        </div>

        <!-- Client & Invoice Details Section -->
        <div class="details">
            <!-- Client Details -->
            <div class="client">
                <p><strong>Client Name:</strong> {{ $transaksi->pelanggan->nama }}</p>
                <p><strong>Address:</strong> {{ $transaksi->pelanggan->alamat }}</p>
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
                        <td>
                            <div style="display: flex; align-items: center;">
                                <img src="storage/produk/{{ $item->produk->image }}" alt="Product A Image"
                                    style="width: 40px; height: 40px; margin-right: 10px;" />
                                <span>{{ $item->produk->nama }}</span>
                            </div>
                        </td>
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
