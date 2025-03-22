<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-container {
            width: 100%;
            border: 1px solid black;
            padding: 10px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table,
        .header-table th,
        .header-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        .header-table .no-border {
            border: none;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        .barcode-sales {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .box {
            width: 150px;
            height: 100px;
            border: 1px solid black;
        }

        @media print {
            img {
                display: block !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <table class="header-table">
            <tr>
                <td rowspan="4" style="text-align: center; width: 200px;" class="no-border">
                    <img src="{{ url('assets/img/logo.png') }}" alt="Logo" width="150">
                </td>
                <td rowspan="4" class="no-border">
                    <strong>Jl. Kapten Patimura No.8, Karanglewas Lor,</strong><br>
                    Kec. Purwokerto Barat, Kab. Banyumas, Jawa Tengah 53136<br>
                    0822-2537-7888
                </td>
                <td>Purwokerto</td>
                <td>30, November 2025</td>
            </tr>
            <tr>
                <td>Mr/Mrs</td>
                <td>Dimnas Anugerah</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>Purbalingga</td>
            </tr>
            <tr>
                <td>No. Hp</td>
                <td>081390469322</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td>Sales</td>
                <td>Indra Kusuma</td>
            </tr>
            <tr>
                <td colspan="2" class="no-border"></td>
                <td>No. Transaksi</td>
                <td>#00001</td>
            </tr>
        </table>

        <table class="table">
            <tr>
                <th>NO</th>
                <th>KODE BARANG</th>
                <th>NAMA BARANG / ITEM</th>
                <th>BERAT</th>
                <th>KARAT</th>
                <th>HARGA</th>
                <th>TOTAL</th>
            </tr>
            <tr>
                <td>1</td>
                <td>K-0001</td>
                <td>CINCIN</td>
                <td>2,93</td>
                <td>18</td>
                <td>Rp 650.000</td>
                <td>Rp 1.907.100</td>
            </tr>
        </table>

        <p><strong>TERBILANG:</strong> SATU JUTA SEMBILAN RATUS TUJUH RIBU SERATUS RUPIAH</p>

        <p><strong>KETERANGAN</strong><br>
            THANK YOU FOR YOUR BUSINESS!<br>
            PLEASE MAKE PAYMENT BY THE DUE DATE SPECIFIED ABOVE</p>
    </div>
</body>

</html>
