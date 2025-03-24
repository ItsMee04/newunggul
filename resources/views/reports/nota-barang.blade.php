<!DOCTYPE html>
<html lang="en">

<head>
    <title>Unggul Kencana - Cetak Surat Barang</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
</head>

<body>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-between align-items-center border-bottom mb-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <img src="{{ asset('assets') }}/img/logo.png" width="150px" class="img-fluid"
                                alt="logo">
                        </div>
                        <p class="mb-1 fw-medium">Jl. Kapten Patimura No. 8, Karanglewas Lor,</p>
                        <p class="mb-1 fw-medium">Kec. Purwokerto Barat, Kab. Banyumas, Jawa Tengah 53136</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5 class="text-gray mb-1">Invoice No <span class="text-primary" id="kodetransaksi"></span></h5>
                        <p class="mb-1 fw-medium">Created Date: <span class="text-dark" id="tanggalDibuat"></span></p>
                    </div>
                </div>

                <div class="row border-bottom mb-3">
                    <div class="col-md-5">
                        <p class="text-dark mb-2 fw-semibold">To</p>
                        <h4 class="mb-1" id="namapelanggan"></h4>
                        <p class="mb-1" id="alamatpelanggan"></p>
                        <p>No. Hp : <span class="text-dark" id="kontak"></span></p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p class="text-title mb-2 fw-medium">Payment Status</p>
                        <span id="paymentstatus" class="px-2 py-1 rounded text-white"></span>
                        <div class="mt-3">
                            <img src="" id="barcodeproduk" class="img-fluid" width="70" height="70"
                                alt="QR">
                        </div>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th>Kode Produk</th>
                                <th class="text-end">Nama</th>
                                <th class="text-end">Berat</th>
                                <th class="text-end">Karat</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody id="produk-list"></tbody>
                    </table>
                </div>

                <div class="row align-items-center border-bottom mb-3">
                    <div class="col-md-7">
                        <div>
                            <div class="mb-3">
                                <h6 class="mb-1">Terms and Conditions</h6>
                                <p>Please pay within 15 days from the date of invoice, overdue interest @ 14%
                                    will be charged on delayed payments.</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">Notes</h6>
                                <p>Please quote invoice number when remitting funds.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="text-end">
                            <img src="{{ asset('assets') }}/img/logo.png" width="100" class="img-fluid"
                                alt="sign">
                        </div>
                        <div class="text-end mb-3">
                            <h6 class="fs-14 fw-medium pe-3" id="sales"></h6>
                            <p>Pegawai Unggul Kencana</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="mb-3">
                        <img src="{{ asset('assets') }}/img/logo.png" width="100" class="img-fluid" alt="logo">
                    </div>
                    <p class="text-dark mb-1">Payment Made Via bank transfer / Cheque in the name of Thomas
                        Lawler</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <p class="fs-12 mb-0 me-3">Bank Name : <span class="text-dark">HDFC Bank</span></p>
                        <p class="fs-12 mb-0 me-3">Account Number : <span class="text-dark">45366287987</span>
                        </p>
                        <p class="fs-12">IFSC : <span class="text-dark">HDFC0018159</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Set tanggal hari ini
            let today = new Date();
            let formattedDate = today.toISOString().split("T")[0];
            document.getElementById("tanggalDibuat").textContent = formattedDate;

            // Ambil parameter ID dari URL
            let pathArray = window.location.pathname.split("/");

            // Ambil nilai ID dari segmen terakhir URL
            let id = pathArray[pathArray.length - 1];

            // Fetch data dari API
            console.log(id)
            if (id) {
                fetch(`/getNotaBarang/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            let transaksi = data.Data;

                            // Isi data transaksi
                            document.getElementById("kodetransaksi").textContent = transaksi.kodetransaksi;
                            document.getElementById("namapelanggan").textContent = transaksi.pelanggan.nama;
                            document.getElementById("alamatpelanggan").textContent = transaksi.pelanggan.alamat;
                            document.getElementById("kontak").textContent = transaksi.pelanggan.kontak;
                            let salesElement = document.getElementById("sales");

                            if (salesElement) {
                                salesElement.textContent = transaksi.user.pegawai.nama;
                            } else {
                                console.error("Elemen dengan ID 'sales' tidak ditemukan!");
                            }

                            // Isi data produk
                            let produk = transaksi.keranjang.produk;
                            let berat = parseFloat(produk.berat).toFixed(4);
                            let hargaTotal = (produk.harga_jual * berat).toFixed(2);

                            // Isi Payment Status
                            let paymentStatusElem = document.getElementById("paymentstatus");
                            let isPaid = transaksi.status === 1;
                            paymentStatusElem.textContent = isPaid ? "Paid" : "Unpaid";
                            paymentStatusElem.classList.add(isPaid ? "bg-success" : "bg-danger");

                            // Isi barcode produk
                            document.getElementById("barcodeproduk").src =
                                `/storage/barcode/${produk.kodeproduk}.png`;

                            let row = `
                                <tr>
                                    <td>${produk.kodeproduk}</td>
                                    <td class="text-end">
                                        <div style="display: flex; align-items: center;">
                                            <img src="/storage/produk/${produk.image}" alt="${produk.nama}" style="width: 120px; height: 80px; object-fit: cover; margin-right: 10px; border-radius: 5px;">
                                            <span>${produk.nama}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">${berat} g</td>
                                    <td class="text-end">${produk.karat}K</td>
                                    <td class="text-end">Rp ${produk.harga_jual.toLocaleString()}</td>
                                    <td class="text-end">Rp ${parseFloat(hargaTotal).toLocaleString()}</td>
                                </tr>
                            `;
                            document.getElementById("produk-list").innerHTML = row;

                            // Hitung total harga
                            let subTotal = transaksi.total;
                            let diskon = transaksi.diskon;
                            let diskonValue = (subTotal * (diskon / 100)).toFixed(2);
                            let totalAmount = (subTotal - diskonValue).toFixed(2);

                            document.getElementById("subtotal").textContent = "Rp " + subTotal.toLocaleString();
                            document.getElementById("diskon").textContent = diskon;
                            document.getElementById("discount-value").textContent = "Rp " + parseFloat(
                                diskonValue).toLocaleString();
                            document.getElementById("total-amount").textContent = "Rp " + parseFloat(
                                totalAmount).toLocaleString();
                        } else {
                            alert("Data tidak ditemukan.");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            } else {
                alert("ID transaksi tidak ditemukan di URL.");
            }

            // Cetak otomatis setelah data dimuat
            setTimeout(() => {
                window.print();
            });
        });
    </script>
</body>

</html>
