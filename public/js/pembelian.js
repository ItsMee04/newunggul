$(document).ready(function () {
    loadPembelian();

    $(document).on("click", "#refreshButton", function () {
        if (pembelianTable) {
            pembelianTable.ajax.reload(); // Reload data dari server
        }
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Pembelian Berhasil Direfresh");
        toast.show();
    });

    function loadPembelian() {
        // Datatable
        if ($(".pembelianTable").length > 0) {
            pembelianTable = $(".pembelianTable").DataTable({
                scrollX: false, // Jangan aktifkan scroll horizontal secara paksa
                bFilter: true,
                sDom: "fBtlpi",
                ordering: true,
                language: {
                    search: " ",
                    sLengthMenu: "_MENU_",
                    searchPlaceholder: "Search",
                    info: "_START_ - _END_ of _TOTAL_ items",
                    paginate: {
                        next: ' <i class=" fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i> ',
                    },
                },
                ajax: {
                    url: "pembelian/getPembelian", // Ganti dengan URL endpoint server Anda
                    type: "GET", // Metode HTTP (GET/POST)
                    dataSrc: "Data", // Jalur data di response JSON
                },
                columns: [
                    {
                        data: null, // Kolom nomor urut
                        render: function (data, type, row, meta) {
                            return meta.row + 1; // Nomor urut dimulai dari 1
                        },
                        orderable: false,
                    },
                    {
                        data: "kodepembelian",
                        render: function (data, type, row) {
                            return `
                                <a href="/pembelian/detailPembelian/${row.id}" class="btn btn-secondary btn-sm">
                                    ${data}  <!-- Menampilkan name sebagai button-link -->
                                </a>
                            `;
                        },
                    },
                    {
                        data: null, // Kolom yang memuat data pelanggan atau suplier
                        render: function (data, type, row) {
                            // Cek apakah pelanggan atau suplier tersedia
                            if (row.suplier_id === null) {
                                return row.pelanggan.nama; // Jika `suplier_id` null, tampilkan nama pelanggan
                            } else if (row.pelanggan_id === null) {
                                return row.suplier.suplier; // Jika `pelanggan_id` null, tampilkan nama suplier
                            } else {
                                return "-"; // Jika keduanya tidak ada, tampilkan tanda "-"
                            }
                        },
                    },
                    {
                        data: "produk.nama",
                    },
                    {
                        data: "produk.berat",
                    },
                    {
                        data: "tanggal",
                    },
                    {
                        data: "status",
                        render: function (data, type, row) {
                            // Menampilkan badge sesuai dengan status
                            if (data == 1) {
                                return `<span class="badge badge-sm bg-outline-warning"> UNPAID</span>`;
                            } else if (data == 2) {
                                return `<span class="badge badge-sm bg-outline-success"> PAID</span>`;
                            } else {
                                return `<span class="badge badge-sm bg-outline-danger"> CANCELED</span>`;
                            }
                        },
                    },
                    {
                        data: null, // Kolom aksi
                        orderable: false, // Aksi tidak perlu diurutkan
                        className: "action-table-data",
                        render: function (data, type, row, meta) {
                            if (row.status === 1) {
                                // Jika status adalah 1
                                return `
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2 btn-detail" data-id="${row.id}">
                                    <i data-feather="eye" class="action-eye"></i>
                                    </a>
                                    <a class="me-2 p-2 btn-edit" data-id="${row.id}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="me-2 p-2 confirm-payment" data-id="${row.id}">
                                        <i data-feather="check-circle" class="feather-edit-2"></i>
                                    </a>
                                    <a class="confirm-text p-2" data-id="${row.id}">
                                        <i data-feather="x-circle" class="feather-trash-2"></i>
                                    </a>
                                    </div>
                                `;
                            } else {
                                // Jika status bukan 1
                                return `
                                    <div class="edit-delete-action">
                                        <a class="me-2 p-2 btn-detail" data-id="${row.id}">
                                            <i data-feather="eye" class="action-eye"></i>
                                        </a>
                                    </div>
                                `;
                            }
                        },
                    },
                ],
                initComplete: (settings, json) => {
                    $(".dataTables_filter").appendTo("#tableSearch");
                    $(".dataTables_filter").appendTo(".search-input");
                },
                drawCallback: function () {
                    feather.replace(); // Inisialisasi ulang Feather Icons
                },
            });
        }
    }

    // Fungsi untuk memuat data Jenis
    function loadJenis() {
        $.ajax({
            url: "/jenis/getJenis", // Endpoint untuk mendapatkan data jabatan
            type: "GET",
            success: function (response) {
                let options = '<option value="">-- Pilih Jenis --</option>';
                response.Data.forEach((item) => {
                    options += `<option value="${item.id}">${item.jenis}</option>`;
                });
                $("#jenis").html(options); // Masukkan data ke select
            },
            error: function () {
                alert("Gagal memuat data jabatan!");
            },
        });
    }

    // Fungsi untuk memuat data Suplier
    function loadSuplier() {
        $.ajax({
            url: "/suplier/getSuplier", // Endpoint untuk mendapatkan data jabatan
            type: "GET",
            success: function (response) {
                let options = '<option value="">-- Pilih Suplier --</option>';
                response.Data.forEach((item) => {
                    options += `<option value="${item.id}">${item.suplier}</option>`;
                });
                $("#suplier_id").html(options); // Masukkan data ke select
            },
            error: function () {
                alert("Gagal memuat data jabatan!");
            },
        });
    }

    // Fungsi untuk memuat data Pelanggan
    function loadPelanggan() {
        $.ajax({
            url: "/pelanggan/getPelanggan", // Endpoint untuk mendapatkan data jabatan
            type: "GET",
            success: function (response) {
                let options = '<option value="">-- Pilih Pelanggan --</option>';
                response.Data.forEach((item) => {
                    options += `<option value="${item.id}">${item.nama}</option>`;
                });
                $("#pelanggan_id").html(options); // Masukkan data ke select
            },
            error: function () {
                alert("Gagal memuat data jabatan!");
            },
        });
    }

    //Fungsi untuk memuat data Kondisi
    function loadKondisi() {
        $.ajax({
            url: "/kondisi/getKondisi", // Endpoint untuk mendapatkan data jabatan
            type: "GET",
            success: function (response) {
                let options = '<option value="">-- Pilih Kondisi --</option>';
                response.Data.forEach((item) => {
                    options += `<option value="${item.id}">${item.kondisi}</option>`;
                });
                $("#kondisi").html(options); // Masukkan data ke select
            },
            error: function () {
                alert("Gagal memuat data jabatan!");
            },
        });
    }

    $(".btn-tambahPembelian").on("click", function () {
        // $("#mdtambahPembelian").modal("show");
        loadJenis();
        loadSuplier();
        loadPelanggan();
        loadKondisi();
    });

    // $("#storePembelianProduk").on("submit", function (event) {
    //     event.preventDefault(); // Mencegah form submit secara default
    //     // Ambil elemen input file

    //     // Buat objek FormData
    //     const formData = new FormData(this);
    //     $.ajax({
    //         url: "/pembelian/storePembelianProduk",
    //         type: "POST",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function (response) {
    //             const successtoastExample =
    //                 document.getElementById("successToast");
    //             const toast = new bootstrap.Toast(successtoastExample);
    //             $(".toast-body").text(response.message);
    //             toast.show();

    //             tabelProdukPembelian.ajax.reload();
    //         }
    //     })
    // })

    $("#storePembelian").on("submit", function (event) {
        event.preventDefault(); // Mencegah form submit secara default
        // Ambil elemen input file

        // Buat objek FormData
        const formData = new FormData(this);
        $.ajax({
            url: "/pembelian", // Endpoint Laravel untuk menyimpan pegawai
            type: "POST",
            data: formData,
            processData: false, // Agar data tidak diubah menjadi string
            contentType: false, // Agar header Content-Type otomatis disesuaikan
            success: function (response) {
                const successtoastExample =
                    document.getElementById("successToast");
                const toast = new bootstrap.Toast(successtoastExample);
                $(".toast-body").text(response.message);
                toast.show();
                $("#mdtambahPembelian").modal("hide"); // Tutup modal
                $("#storePembelian")[0].reset(); // Reset form

                pembelianTable.ajax.reload(); // Reload data dari server
            },
            error: function (xhr) {
                // Tampilkan pesan error dari server
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMessage = "";
                    for (let key in errors) {
                        errorMessage += `${errors[key][0]}\n`;
                    }
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(errorMessage);
                    toast.show();
                } else {
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(response.message);
                    toast.show();
                }
            },
        });
    });

    function formatToIDR(amount) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(amount);
    }

    //ketika button deetail di tekan
    $(document).on("click", ".btn-detail", function () {
        const pembelianID = $(this).data("id");

        $.ajax({
            url: `/pembelian/${pembelianID}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                // Isi modal dengan data pembelian
                const pembelian = response.Data[0]; // Ambil data pertama
                let namaPenjual;
                if (pembelian.suplier_id !== null && pembelian.suplier) {
                    namaPenjual = pembelian.suplier.suplier; // Nama suplier jika suplier_id tidak null
                } else if (
                    pembelian.pelanggan_id !== null &&
                    pembelian.pelanggan
                ) {
                    namaPenjual = pembelian.pelanggan.nama; // Nama pelanggan jika suplier_id null
                } else {
                    namaPenjual = "Tidak Diketahui"; // Default jika keduanya null
                }

                let statusText;
                if (pembelian.status === 1) {
                    statusText = "Aktif";
                } else if (pembelian.status === 2) {
                    statusText = "Pending";
                } else {
                    statusText = "Tidak Diketahui"; // Default jika status tidak sesuai
                }

                const hargaBeliFormatted = formatToIDR(
                    pembelian.produk?.harga_beli || 0
                );

                $("#detailPenjual").val(namaPenjual);
                $("#detailKodepembelian").val(response.Data[0].kodepembelian);
                $("#detailNama").val(response.Data[0].produk.nama);
                $("#detailBerat").val(response.Data[0].produk.berat);
                $("#detailKarat").val(response.Data[0].produk.karat);
                $("#detailJenis").val(response.Data[0].produk.jenis.jenis);
                $("#detailHargabeli").val(hargaBeliFormatted);
                $("#detailKondisi").val(response.Data[0].kondisi);
                $("#detailKeterangan").val(response.Data[0].produk.keterangan);
                $("#detailStatus").val(statusText);

                // Tampilkan modal edit
                $("#modalDetail").modal("show");
            },
            error: function () {
                Swal.fire(
                    "Gagal!",
                    "Tidak dapat mengambil data pegawai.",
                    "error"
                );
            },
        });
    });

    //ketika button edit di tekan
    $(document).on("click", ".btn-edit", function () {
        const pembelianID = $(this).data("id");

        $.ajax({
            url: `/pembelian/${pembelianID}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                // Isi modal dengan data pegawai
                if (
                    response.success &&
                    response.Data &&
                    response.Data.length > 0
                ) {
                    const pembelian = response.Data[0]; // Mengambil data pertama dari array
                    // Pilih Suplier atau Pelanggan berdasarkan ID
                    if (pembelian.suplier_id !== null) {
                        // Tambahkan kelas active pada Suplier tab dan radio button
                        $("#editpills-home-tab").addClass("active");
                        $("#editpills-home").addClass("show active"); // Tampilkan tab Suplier

                        // Sembunyikan tab Pelanggan
                        $("#editpills-profile").removeClass("show active");

                        // Isi dropdown Suplier
                        $.ajax({
                            url: "/suplier/getSuplier",
                            type: "GET",
                            success: function (jabatanResponse) {
                                let options =
                                    '<option value="">-- Pilih Suplier --</option>';
                                jabatanResponse.Data.forEach((item) => {
                                    const selected =
                                        item.id === pembelian.suplier_id
                                            ? "selected"
                                            : "";
                                    options += `<option value="${item.id}" ${selected}>${item.suplier}</option>`;
                                });
                                $("#editsuplier_id").html(options);
                            },
                        });

                        // Isi dropdown Pelanggan
                        $.ajax({
                            url: "/pelanggan/getPelanggan",
                            type: "GET",
                            success: function (jabatanResponse) {
                                let options =
                                    '<option value="">-- Pilih Pelanggan --</option>';
                                jabatanResponse.Data.forEach((item) => {
                                    const selected =
                                        item.id === pembelian.pelanggan_id
                                            ? "selected"
                                            : "";
                                    options += `<option value="${item.id}" ${selected}>${item.nama}</option>`;
                                });
                                $("#editpelanggan_id").html(options);
                            },
                        });
                    } else if (pembelian.pelanggan_id !== null) {
                        // Tambahkan kelas active pada Pelanggan tab dan radio button
                        $("#editpills-profile-tab").addClass("active");
                        $("#editpills-profile").addClass("show active"); // Tampilkan tab Pelanggan

                        // Sembunyikan tab Suplier
                        $("#editpills-home").removeClass("show active");

                        // Isi dropdown Pelanggan
                        $.ajax({
                            url: "/pelanggan/getPelanggan",
                            type: "GET",
                            success: function (jabatanResponse) {
                                let options =
                                    '<option value="">-- Pilih Pelanggan --</option>';
                                jabatanResponse.Data.forEach((item) => {
                                    const selected =
                                        item.id === pembelian.pelanggan_id
                                            ? "selected"
                                            : "";
                                    options += `<option value="${item.id}" ${selected}>${item.nama}</option>`;
                                });
                                $("#editpelanggan_id").html(options);
                            },
                        });

                        // Isi dropdown Suplier
                        $.ajax({
                            url: "/suplier/getSuplier",
                            type: "GET",
                            success: function (jabatanResponse) {
                                let options =
                                    '<option value="">-- Pilih Suplier --</option>';
                                jabatanResponse.Data.forEach((item) => {
                                    const selected =
                                        item.id === pembelian.suplier_id
                                            ? "selected"
                                            : "";
                                    options += `<option value="${item.id}" ${selected}>${item.suplier}</option>`;
                                });
                                $("#editsuplier_id").html(options);
                            },
                        });
                    }

                    // Cek apakah pelanggan_id atau suplier_id yang aktif
                    const isPelangganActive = $(
                        "#editpills-profile-tab"
                    ).hasClass("active");
                    const isSuplierActive = $("#editpills-home-tab").hasClass(
                        "active"
                    );

                    // // Muat opsi jabatan
                    $.ajax({
                        url: "/jenis/getJenis",
                        type: "GET",
                        success: function (jabatanResponse) {
                            let options =
                                '<option value="">-- Pilih Jenis --</option>';
                            jabatanResponse.Data.forEach((item) => {
                                const selected =
                                    item.id === pembelian.produk?.jenis_id || ""
                                        ? "selected"
                                        : "";
                                options += `<option value="${item.id}" ${selected}>${item.jenis}</option>`;
                            });
                            $("#editjenis").html(options);
                        },
                    });

                    // Mengisi data produk
                    $("#editnama").val(pembelian.produk?.nama || "");
                    $("#editberat").val(pembelian.produk?.berat || "");
                    $("#editkarat").val(pembelian.produk?.karat || "");

                    $("#edithargabeli").val(pembelian.produk?.harga_beli);
                    $("#editkondisi")
                        .val(pembelian.kondisi || "")
                        .trigger("change");
                    $("#editketerangan").val(
                        pembelian.produk?.keterangan || ""
                    );
                    $("#editid").val(pembelian.id);

                    // Status pembelian
                    const statusText =
                        pembelian.status === 1 ? "Aktif" : "Pending";
                    $("#editstatus")
                        .val(pembelian.status || "")
                        .trigger("change");
                } else {
                    console.error("Data tidak valid atau tidak ditemukan.");
                }

                // Tampilkan modal
                $("#modaledit").modal("show");
            },
            error: function () {
                Swal.fire(
                    "Gagal!",
                    "Tidak dapat mengambil data pegawai.",
                    "error"
                );
            },
        });
    });

    $("#modaledit").on("hidden.bs.modal", function () {
        // Reset form input di dalam modaledit
        $("#formEditPembelian")[0].reset();

        $("#editjenis").val("").trigger("change"); // Reset dropdown Jenis Produk
        $("#editstatus").val("").trigger("change"); // Reset dropdown Status
        $("#editsuplier_id").val("").trigger("change"); // Reset dropdown Jenis Produk
        $("#editpelanggan_id").val("").trigger("change"); // Reset dropdown Jenis Produk

        // Menghapus class active pada tab dan radio button
        $("#editpills-home-tab").removeClass("active");
        $("#editpills-profile-tab").removeClass("active");
        $("#editpills-home").removeClass("show active");
        $("#editpills-profile").removeClass("show active");
    });

    // Kirim data ke server saat form disubmit
    $(document).on("submit", "#formEditPembelian", function (e) {
        e.preventDefault(); // Mencegah form submit secara default

        // Ambil data dari form
        const dataForm = new FormData();

        // Cek apakah pelanggan_id atau suplier_id yang aktif
        const isPelangganActive = $("#editpills-profile-tab").hasClass(
            "active"
        );
        const isSuplierActive = $("#editpills-home-tab").hasClass("active");

        if (isPelangganActive) {
            dataForm.append("pelanggan_id", $("#editpelanggan_id").val());
            dataForm.append("suplier_id", ""); // Ubah suplier_id menjadi null
        } else if (isSuplierActive) {
            dataForm.append("suplier_id", $("#editsuplier_id").val());
            dataForm.append("pelanggan_id", ""); // Ubah pelanggan_id menjadi null
        }

        dataForm.append("id", $("#editid").val());
        dataForm.append("nama", $("#editnama").val());
        dataForm.append("berat", $("#editberat").val());
        dataForm.append("karat", $("#editkarat").val());
        dataForm.append("jenis_id", $("#editjenis").val());
        dataForm.append("harga_beli", $("#edithargabeli").val());
        dataForm.append("kondisi", $("#editkondisi").val());
        dataForm.append("keterangan", $("#editketerangan").val());
        dataForm.append("status", $("#editstatus").val());
        dataForm.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF Token Laravel

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: `/pembelian/${$("#editid").val()}`, // URL untuk mengupdate data pegawai
            type: "POST", // Gunakan metode POST (atau PATCH jika route mendukung)
            data: dataForm, // Gunakan FormData
            processData: false, // Jangan proses FormData sebagai query string
            contentType: false, // Jangan set Content-Type secara manual
            success: function (response) {
                // Tampilkan toast sukses
                const successtoastExample =
                    document.getElementById("successToast");
                const toast = new bootstrap.Toast(successtoastExample);
                $(".toast-body").text(response.message);
                toast.show();
                $("#modaledit").modal("hide"); // Tutup modal
                $("#formEditPembelian")[0].reset(); // Reset form
                pembelianTable.ajax.reload(); // Reload data dari server
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMessage = "";
                    for (let key in errors) {
                        errorMessage += `${errors[key][0]}\n`;
                    }
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(errorMessage);
                    toast.show();
                }
            },
        });
    });

    initPaymentHandler();
    function initPaymentHandler() {
        //CONFIRM PAYMENT
        $(document).on("click", ".confirm-payment", function (e) {
            e.preventDefault(); // Mencegah reload halaman
            const kodetransaksi = $(this).data("id"); // Ambil ID produk dari atribut data-id

            Swal.fire({
                title: "Konfirmasi Pembayaran",
                text: "Konfirmasi Pembayaran Sudah Dilakukan ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Sudah",
                cancelButtonText: "Batal",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus ke server
                    fetch(`/pembelian/confirmPayment/${kodetransaksi}`, {
                        method: "GET",
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
                                    "Dikonfirmasi!",
                                    "Pembayaran Berhasil Dikonfirmasi",
                                    "success"
                                );
                                pembelianTable.ajax.reload(); // Reload data dari server
                            } else {
                                Swal.fire(
                                    "Gagal!",
                                    "Terjadi kesalahan saat konfirmasi pembayaran.",
                                    "error"
                                );
                            }
                        })
                        .catch((error) => {
                            Swal.fire(
                                "Gagal!",
                                "Terjadi kesalahan dalam konfirmasi pembayaran.",
                                "error"
                            );
                        });
                } else {
                    Swal.fire(
                        "Dibatalkan",
                        "pembayaran tidak dikonfirmasi.",
                        "info"
                    );
                }
            });
        });

        //
        $(document).on("click", ".confirm-text", function (e) {
            e.preventDefault(); // Mencegah reload halaman
            const kodetransaksi = $(this).data("id"); // Ambil ID produk dari atribut data-id

            Swal.fire({
                title: "Pembatalan Pembayaran",
                text: "Konfirmasi Pembayaran Dibatalkan ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Batalkan",
                cancelButtonText: "Batal",
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus ke server
                    fetch(`/pembelian/cancelPayment/${kodetransaksi}`, {
                        method: "GET",
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
                                    "Dibatalkan!",
                                    "Pembayaran Berhasil Dibatalkan.",
                                    "success"
                                );
                                pembelianTable.ajax.reload(); // Reload data dari server
                            } else {
                                Swal.fire(
                                    "Gagal!",
                                    "Terjadi kesalahan saat membatalkan pembayaran.",
                                    "error"
                                );
                            }
                        })
                        .catch((error) => {
                            Swal.fire(
                                "Gagal!",
                                "Terjadi kesalahan dalam pembatalan pembayaran.",
                                "error"
                            );
                        });
                } else {
                    Swal.fire(
                        "Dibatalkan",
                        "Pembayaran tidak dibatalkan.",
                        "info"
                    );
                }
            });
        });
    }

    $('#toggleFormBtn').on('click', function () {
        // Tampilkan atau sembunyikan elemen
        $('#formContainer, #tabelProdukPembelian').toggle(); 
        loadJenis();
        loadKondisi();
        loadPelanggan();
        loadSuplier();
    });

    $("#storePembelianProduk").on("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(this);

        $.ajax({
            url: "/insertProdukPembelian", // Endpoint Laravel untuk menyimpan pegawai
            type: "POST",
            data: formData,
            processData: false, // Agar data tidak diubah menjadi string
            contentType: false, // Agar header Content-Type otomatis disesuaikan
            success: function (response) {
                const successtoastExample =
                    document.getElementById("successToast");
                const toast = new bootstrap.Toast(successtoastExample);
                $(".toast-body").text(response.message);
                toast.show();
            },
            error: function (xhr) {
                // Tampilkan pesan error dari server
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMessage = "";
                    for (let key in errors) {
                        errorMessage += `${errors[key][0]}\n`;
                    }
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(errorMessage);
                    toast.show();
                } else {
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(response.message);
                    toast.show();
                }
            },
        });
    })
});
