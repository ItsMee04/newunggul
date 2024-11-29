$(document).ready(function () {
    loadKeranjang();
    loadProducts("all");
    getCount();
    initDeleteHandler(); // Inisialisasi event handler untuk tombol hapus
    totalHargaKeranjang();
    kodeTransaksi();

    $("ul.tabs li").click(function () {
        var $this = $(this);
        var $theTab = $(this).attr("id");
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        if ($this.hasClass("active")) {
        } else {
            $this
                .closest(".tabs_wrapper")
                .find("ul.tabs li, .tabs_container .tab_content")
                .removeClass("active");
            $(
                '.tabs_container .tab_content[data-tab="' +
                $theTab +
                '"], ul.tabs li[id="' +
                $theTab +
                '"]'
            ).addClass("active");

            loadProducts($theTab);
        }
    });

    // Fungsi untuk memuat produk berdasarkan kategori
    function loadProducts(category) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: `/pos/${category}`, // URL endpoint kategori yang dipilih
            type: "GET",
            data: {
                _token: CSRF_TOKEN,
            },
            dataType: "json",
            success: function (data) {
                $("#daftarProduk").empty(); // Kosongkan daftar produk sebelumnya
                $.each(data.Data, function (key, item) {
                    const formatter = new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                        minimumFractionDigits: 0, // Biasanya mata uang Rupiah tidak menggunakan desimal
                    });

                    const hargajual = formatter.format(item.harga_jual); // Output: "Rp1.500.000"
                    $("#daftarProduk").append(
                        `
                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
                            <div class="product-info default-cover card">
                                <a href="javascript:void(0);" class="img-bg">
                                    <img src="/storage/produk/${item.image}"
                                        alt="Products" width="100px" height="100px"/>
                                </a>
                                <h6 class="cat-name">
                                    <a href="javascript:void(0);">KODE : ${item.kodeproduk}</a>
                                </h6>
                                <h6 class="product-name">
                                    <a href="javascript:void(0);">NAMA : ${item.nama}</a>
                                </h6>
                                <div
                                    class="d-flex align-items-center justify-content-between price">
                                    <span>BERAT : ${item.berat} /gram</span>
                                    <p>HARGA: Rp. ${hargajual}</p>
                                </div>
                                <div class="align-items-center justify-content-between price text-center">
                                    <button data-id="${item.id}" data-name="${item.nama}" data-harga="${item.harga_jual}" data-berat="${item.berat}" class="btn btn-sm btn-outline-secondary ms-1 addCart">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    `
                    );
                });
            },
        });
    }

    $(document).on("click", ".addCart", function (e) {
        e.preventDefault(); // Mencegah reload halaman
        var produkID = $(this).data("id"); // Ambil ID produk dari atribut data-id
        addToCart(produkID); // Panggil fungsi untuk menambahkan produk ke keranjang
    });

    function addToCart(produkID) {
        // Ambil CSRF token dari meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: `/addtocart/${produkID}`, // Endpoint untuk menambahkan produk
            method: "POST",
            data: {
                _token: csrfToken, // CSRF Token untuk keamanan
                id: produkID, // ID produk yang akan ditambahkan
            },
            success: function (response) {
                if (response.success === true) {
                    // Menampilkan notifikasi sukses menggunakan Bootstrap Toast
                    const successtoastExample =
                        document.getElementById("successToast");
                    const toast = new bootstrap.Toast(successtoastExample);
                    $(".toast-body").text(response.message);
                    toast.show();

                    // Memuat ulang keranjang setelah produk ditambahkan
                    loadKeranjang();
                    totalHargaKeranjang();
                } else if (response.status === "error") {
                    // Menampilkan notifikasi error menggunakan Bootstrap Toast
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(response.message);
                    toast.show();
                }
            },
            error: function (xhr) {
                // Menampilkan notifikasi error jika terjadi masalah dengan request
                const dangertoastExample =
                    document.getElementById("dangerToastErrors");
                const toast = new bootstrap.Toast(dangertoastExample);
                document.getElementById("dangerToastMessage").innerText =
                    "Terjadi kesalahan pada server."; // Pesan fallback
                toast.show();
            },
        });
    }

    function loadKeranjang() {
        // Menggunakan AJAX untuk mengambil data dari server
        $.ajax({
            url: "/getKeranjang", // Endpoint di Laravel
            type: "GET",
            dataType: "json", // Pastikan response otomatis di-parse sebagai JSON
            success: function (response) {
                if (response.success && Array.isArray(response.data)) {
                    $("#keranjang").empty(); // Kosongkan elemen keranjang sebelumnya

                    response.data.forEach((item) => {
                        const produk = item.produk; // Detail produk dari properti `produk`

                        // Format harga menjadi Rupiah
                        const formatter = new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR",
                            minimumFractionDigits: 0,
                        });
                        const hargajual = formatter.format(produk.harga_jual);

                        // Tambahkan item ke elemen keranjang
                        $("#keranjang").append(`
                            <div class="product-list d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center product-info" data-bs-toggle="modal"
                                    data-bs-target="#products">
                                    <a href="javascript:void(0);" class="img-bg">
                                        <img src="storage/produk/${produk.image}" alt="${produk.nama}">
                                    </a>
                                    <div class="info">
                                        <span>${item.kodekeranjang}</span>
                                        <h6><a href="javascript:void(0);">${produk.nama}</a></h6>
                                        <p>${hargajual}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center action">
                                    <a class="me-2 p-2 confirm-text" href="javascript:void(0);"
                                        data-item-id="${item.id}">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </div>
                        `);
                    });
                } else {
                    console.error(
                        "Data keranjang tidak ditemukan atau response tidak valid."
                    );
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    }

    function getCount() {
        $.ajax({
            url: "/getCount", // Endpoint di Laravel
            type: "GET",
            success: function (response) {
                // Loop melalui setiap item yang dikembalikan dari server
                $(".count").text(0);
                if (response.success) {
                    $(".count").text(response.count);
                } else {
                    $(".count").text(0);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    }
    // Fungsi untuk menangani penghapusan item
    function initDeleteHandler() {
        $(document).on("click", ".confirm-text", function () {
            const deleteButton = $(this); // Tombol yang diklik
            const itemId = deleteButton.data("item-id"); // ID item dari atribut data-item-id

            // SweetAlert untuk konfirmasi
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus ke server
                    fetch(`/deleteKeranjangItem/${itemId}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    })
                        .then((response) => {
                            if (response.ok) {
                                Swal.fire("Dihapus!", "Data berhasil dihapus.", "success");
                                getCount();
                                loadKeranjang();
                                totalHargaKeranjang();
                            } else {
                                Swal.fire(
                                    "Gagal!",
                                    "Terjadi kesalahan saat menghapus data.",
                                    "error"
                                );
                            }
                        })
                        .catch((error) => {
                            Swal.fire(
                                "Gagal!",
                                "Terjadi kesalahan dalam penghapusan data.",
                                "error"
                            );
                        });
                } else {
                    Swal.fire("Dibatalkan", "Data tidak dihapus.", "info");
                }
            });
        });

        $(document).on("click", ".confirm-deleteAll", function () {
            const deleteButton = $(this); // Tombol yang diklik

            // SweetAlert untuk konfirmasi
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus ke server
                    fetch(`/deleteKeranjangAll`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    })
                        .then((response) => {
                            if (response.ok) {
                                Swal.fire("Dihapus!", "Data berhasil dihapus.", "success");
                                getCount();
                                loadKeranjang();
                                totalHargaKeranjang();
                            } else {
                                Swal.fire(
                                    "Gagal!",
                                    "Terjadi kesalahan saat menghapus data.",
                                    "error"
                                );
                            }
                        })
                        .catch((error) => {
                            Swal.fire(
                                "Gagal!",
                                "Terjadi kesalahan dalam penghapusan data.",
                                "error"
                            );
                        });
                } else {
                    Swal.fire("Dibatalkan", "Data tidak dihapus.", "info");
                }
            });
        });
    }

    function totalHargaKeranjang() {
        $.ajax({
            url: "/totalHargaKeranjang", // Endpoint di Laravel
            type: "GET",
            success: function (response) {
                // Loop melalui setiap item yang dikembalikan dari server
                $("#totalhargabarang").text(0);
                if (response.success) {
                    const total = response.total;

                    const formatter = new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                        minimumFractionDigits: 0, // Biasanya mata uang Rupiah tidak menggunakan desimal
                    });

                    var formattedAmount = formatter.format(total); // Output: "Rp1.500.000"

                    $("#totalhargabarang").text(formattedAmount);
                } else {
                    $("#totalhargabarang").text(0);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    }

    // Event listener untuk perubahan dropdown
    $(document).on("change", "#pilihDiskon", function getDiscount() {
        const diskon = $(this).val();

        // Simpan nilai yang dipilih ke localStorage
        localStorage.setItem("selectedDiskon", diskon);

        $.ajax({
            url: "/totalHargaKeranjang", // Endpoint di Laravel
            type: "GET",
            success: function (response) {
                // Reset nilai tampilan
                $("#hargadiskon").text(0);
                $("#total").text(0);
                $("#grandtotal").text(0);
                $("#discount").text(diskon);

                if (response.success) {
                    const total = response.total;
                    const subDiskon = diskon / 100;
                    const TotalDiskon = total * subDiskon;
                    const subTotalDiskon = total - TotalDiskon;

                    // Format angka ke Rupiah
                    const formatter = new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                        minimumFractionDigits: 0, // Biasanya mata uang Rupiah tidak menggunakan desimal
                    });

                    const hargatotaldiskon = formatter.format(TotalDiskon); // Output diskon
                    const hargatotal = formatter.format(subTotalDiskon); // Output subtotal

                    // Update tampilan dengan data baru
                    $("#hargadiskon").text(hargatotaldiskon);
                    $("#total").text(hargatotal);
                    $("#grandtotal").text(hargatotal);
                } else {
                    // Jika ada kesalahan dari server
                    $("#hargadiskon").text(0);
                    $("#total").text(0);
                    $("#grandtotal").text(0);
                    $("#discount").text(diskon);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    });

    $(document).on("click", "#checkout", function (e) {
        e.preventDefault();

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        const pelanggan = document.querySelector("#pelanggan").value;
        const diskon = document.querySelector("#pilihDiskon").value;

        // Pastikan transaksi_id didefinisikan
        const transaksi_id = document.querySelector("#transaksi_id").textContent;
        // Validasi elemen DOM
        if (pelanggan === "walk in customer" || diskon === "pilih diskon") {
            console.error("Pelanggan atau diskon tidak dipilih.");
            console.log(pelanggan)
            console.log(diskon)
            return;
        } else {
            $.ajax({
                url: "/getKodeKeranjang", // Endpoint di Laravel
                type: "GET",
                success: function (response) {
                    // Jika keranjang tidak ditemukan
                    if (!response.success) {
                        const dangerToastExample = document.getElementById("dangerToastError");
                        const toast = new bootstrap.Toast(dangerToastExample);
                        $(".toast-body").text(response.message);
                        toast.show();
                    } 
                    // Jika keranjang ditemukan
                    else if (response.success && response.kode && response.produk_id) {
                        // Ambil total harga keranjang
                        $.ajax({
                            url: "/totalHargaKeranjang", // Endpoint di Laravel
                            type: "GET",
                            success: function (items) {
                                if (items.success) {
                                    const total = items.total;
                                    const subDiskon = diskon / 100; // Hitung diskon
                                    const TotalDiskon = total * subDiskon;
                                    const subTotalDiskon = total - TotalDiskon;
            
                                    // Kirim data pembayaran
                                    $.ajax({
                                        url: `/payment`, // Route Laravel
                                        type: "POST",
                                        data: {
                                            _token: csrfToken, // Sertakan token CSRF
                                            pelangganID: pelanggan,
                                            diskonID: diskon,
                                            transaksiID: transaksi_id,
                                            kodeKeranjangID: response.kode.kodekeranjang,
                                            produkID: response.produk_id,
                                            total: subTotalDiskon,
                                        },
                                        success: function (paymentResponse) {
                                            // Jika pembayaran sukses
                                            if (paymentResponse.success) {
                                                const successToastExample = document.getElementById("successToast");
                                                const toast = new bootstrap.Toast(successToastExample);
                                                $(".toast-body").text(paymentResponse.message);
                                                toast.show();
            
                                                // Perbarui UI setelah pembayaran berhasil
                                                loadKeranjang();
                                                loadProducts("all");
                                                getCount();
                                                initDeleteHandler(); // Inisialisasi ulang tombol hapus
                                                totalHargaKeranjang();
                                            } 
                                            // Jika pembayaran gagal
                                            else {
                                                const dangerToastExample = document.getElementById("dangerToastError");
                                                const toast = new bootstrap.Toast(dangerToastExample);
                                                $(".toast-body").text(paymentResponse.message);
                                                toast.show();
                                            }
                                        },
                                        error: function (xhr, status, error) {
                                            console.error("Error saat pembayaran:", error);
                                        },
                                    });
                                } else {
                                    console.error("Error fetching total keranjang:", items);
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error("Error fetching total keranjang:", error);
                            },
                        });
                    } 
                    // Jika respons tidak valid
                    else {
                        console.error("Response getKodeKeranjang tidak valid:", response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching data:", error);
                },
            });
            
        }
    });

    function kodeTransaksi() {
        $.ajax({
            url: "/generateCodeTransaksi", // Endpoint di Laravel
            type: "GET",
            success: function (response) {
                // Loop melalui setiap item yang dikembalikan dari server
                $("#transaksi_id").text(response.kodetransaksi); // Tampilkan ke elemen
            },
            error: function (xhr, status, error) {
                console.error("Error fetching data:", error);
            },
        });
    }

});
