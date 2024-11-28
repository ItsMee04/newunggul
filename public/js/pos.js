$(document).ready(function () {
    loadKeranjang();
    loadProducts("all");
    getCount();

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

    document.querySelectorAll(".confirm-text").forEach(function (deleteButton) {
        deleteButton.addEventListener("click", function () {
            const itemId = this.getAttribute("data-item-id"); // Ambil ID item dari data-item-id

            // SweetAlert2 untuk konfirmasi
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
                    // Kirim permintaan hapus (gunakan itemId)
                    fetch(`/jenis/${itemId}`, {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                    })
                        .then((response) => {
                            if (response.ok) {
                                Swal.fire(
                                    "Dihapus!",
                                    "Data berhasil dihapus.",
                                    "success"
                                ).then(() => location.reload());
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
                    // Jika batal, beri tahu pengguna
                    Swal.fire("Dibatalkan", "Data tidak dihapus.", "info");
                }
            });
        });
    });
});
