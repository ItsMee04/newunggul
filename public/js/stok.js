$(document).ready(function () {

    loadStok();

    // Inisialisasi tooltip Bootstrap
    function initializeTooltip() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    $(document).on("click", "#refreshButton", function () {
        if (tabelStok) {
            tabelStok.ajax.reload(); // Reload data dari server
        }
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Stok Berhasil Direfresh");
        toast.show();
    });

    // Fungsi untuk memuat data nampan
    function loadNampan() {
        $.ajax({
            url: "/nampan/getNampan", // Endpoint untuk mendapatkan data jabatan
            type: "GET",
            success: function (response) {
                let options = '<option value="">-- Pilih Nampan --</option>';
                response.Data.forEach((item) => {
                    options += `<option value="${item.id}">${item.nampan}</option>`;
                });
                $("#nampan").html(options); // Masukkan data ke select
            },
            error: function () {
                alert("Gagal memuat data jabatan!");
            },
        });
    }

    function loadStok() {
        // Datatable
        if ($('.tabelStok').length > 0) {
            tabelStok = $('.tabelStok').DataTable({
                "scrollX": false, // Jangan aktifkan scroll horizontal secara paksa
                "bFilter": true,
                "sDom": 'fBtlpi',
                "ordering": true,
                "language": {
                    search: ' ',
                    sLengthMenu: '_MENU_',
                    searchPlaceholder: "Search",
                    info: "_START_ - _END_ of _TOTAL_ items",
                    paginate: {
                        next: ' <i class=" fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i> '
                    },
                },
                ajax: {
                    url: 'stock/getStokByNampan', // Ganti dengan URL endpoint server Anda
                    type: 'GET', // Metode HTTP (GET/POST)
                    dataSrc: 'Data' // Jalur data di response JSON
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
                        data: 'kodetransaksi',
                        render: function (data, type, row) {
                            return `
                                <a href="/stock/detailStok/${row.nampan_id}" class="btn btn-secondary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Detail Stok Data">
                                    ${data}  <!-- Menampilkan name sebagai button-link -->
                                </a>
                            `;
                        },
                    },
                    {
                        data: 'nampan.nampan',
                    },
                    {
                        data: 'tanggal',
                    },
                    {
                        data: 'keterangan',
                    },
                    {
                        data: 'status',
                        render: function (data, type, row) {
                            // Menampilkan badge sesuai dengan status
                            if (data == 1) {
                                return `<span class="badge badge-sm bg-outline-success"> Active</span>`;
                            } else if (data == 2) {
                                return `<span class="badge badge-sm bg-outline-danger"> Inactive</span>`;
                            } else {
                                return `<span class="badge badge-sm bg-outline-secondary"> Unknown</span>`;
                            }
                        }
                    },     // Kolom Nama
                    {
                        data: null,        // Kolom aksi
                        orderable: false,  // Aksi tidak perlu diurutkan
                        className: "action-table-data",
                        render: function (data, type, row, meta) {
                            return `
                            <div class="edit-delete-action">
                                <a class="me-2 p-2 btn-edit" data-id="${row.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit Data">
                                    <i data-feather="edit" class="feather-edit"></i>
                                </a>
                                <a class="confirm-text p-2" data-id="${row.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Hapus Data">
                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                </a>
                            </div>
                        `;
                        }
                    }
                ],
                initComplete: (settings, json) => {
                    $('.dataTables_filter').appendTo('#tableSearch');
                    $('.dataTables_filter').appendTo('.search-input');

                },
                drawCallback: function () {
                    // Re-inisialisasi Feather Icons setelah render ulang DataTable
                    feather.replace();
                    // Re-inisialisasi tooltip Bootstrap setelah render ulang DataTable
                    initializeTooltip();
                }
            });
        }
    }

    $(".btn-tambahStok").on("click", function () {
        $("#mdTambahStok").modal("show");
        loadNampan();
    });

    //kirim data ke server
    $("#storeStok").on("submit", function (event) {
        event.preventDefault(); // Mencegah form submit secara default
        // Ambil elemen input file

        // Buat objek FormData
        const formData = new FormData(this);
        $.ajax({
            url: "/stock", // Endpoint Laravel untuk menyimpan pegawai
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
                $("#mdTambahStok").modal("hide"); // Tutup modal
                $("#storeStok")[0].reset(); // Reset form
                tabelStok.ajax.reload(); // Reload data dari server
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

    //ketika button edit di tekan
    $(document).on("click", ".btn-edit", function () {
        const stokID = $(this).data("id");

        $.ajax({
            url: `/stock/${stokID}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                // Isi modal dengan data pegawai
                $("#editid").val(response.Data.id);
                $("#editketerangan").val(response.Data.keterangan);
                $("#editkodetransaksi").val(response.Data.kodetransaksi);

                // // Muat opsi nampan
                $.ajax({
                    url: "/nampan/getNampan",
                    type: "GET",
                    success: function (jabatanResponse) {
                        let options =
                            '<option value="">-- Pilih Nampan --</option>';
                        jabatanResponse.Data.forEach((item) => {
                            const selected =
                                item.id === response.Data.nampan_id
                                    ? "selected"
                                    : "";
                            options += `<option value="${item.id}" ${selected}>${item.nampan}</option>`;
                        });
                        $("#editnampan").html(options);
                    },
                });

                // Tampilkan modal edit
                $("#modaledit").modal("show");
            },
            error: function () {
                Swal.fire(
                    "Gagal!",
                    "Tidak dapat mengambil data jenis.",
                    "error"
                );
            },
        });
    });

    // Ketika modal ditutup, reset semua field
    $("#modaledit").on("hidden.bs.modal", function () {
        // Reset form input (termasuk gambar dan status)
        $("#formEditNampan")[0].reset();

        // Reset dropdown status jika perlu
        $("#editnampan").val("").trigger("change"); // Reset select status jika menggunakan Select2 atau lainnya
    });

    // Kirim data ke server saat form disubmit
    $(document).on("submit", "#formEditStok", function (e) {
        e.preventDefault(); // Mencegah form submit secara default

        // Ambil data dari form
        const dataForm = new FormData();
        dataForm.append("id", $("#editid").val());
        dataForm.append("nampan", $("#editnampan").val());
        dataForm.append("keterangan", $("#editketerangan").val());
        dataForm.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF Token Laravel

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: `/update-stock/${$("#editid").val()}`, // URL untuk mengupdate data pegawai
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
                $("#formEditStok")[0].reset(); // Reset form
                if (tabelStok) {
                    tabelStok.ajax.reload(); // Reload data dari server
                }
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

    // ketika button hapus di tekan
    $(document).on("click", ".confirm-text", function () {
        const itemId = this.getAttribute("data-id"); // Ambil ID item dari data-item-id

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
                fetch(`/delete-stock/${itemId}`, {
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
                            );
                            tabelStok.ajax.reload(); // Reload data dari server
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

    function loadProduk() {
        const path = window.location.pathname;
        const paramNampan = path.split('/').pop(); // Ambil ID dari URL
        // Datatable
        if ($('.tabelProdukStok').length > 0) {
            tabelStok = $('.tabelProdukStok').DataTable({
                "scrollX": false, // Jangan aktifkan scroll horizontal secara paksa
                "bFilter": true,
                "sDom": 'fBtlpi',
                "ordering": true,
                "language": {
                    search: ' ',
                    sLengthMenu: '_MENU_',
                    searchPlaceholder: "Search",
                    info: "_START_ - _END_ of _TOTAL_ items",
                    paginate: {
                        next: ' <i class=" fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i> '
                    },
                },
                ajax: {
                    url: `/stock/getProdukByNampanID/${paramNampan}`,
                    type: 'GET',
                    dataSrc: function (json) {
                        // Pastikan total_berat adalah angka
                        totalBerat = parseFloat(json.total_berat) || 0; // Jika null atau NaN, set menjadi 0
                        return json.Data;
                    }
                },
                columns: [
                    {
                        data: null, // Kolom nomor urut
                        render: function (data, type, row, meta) {
                            return meta.row + 1; // Nomor urut dimulai dari 1
                        },
                        orderable: false,
                    },
                    { data: 'produk.kodeproduk' },
                    { data: 'produk.nama' },
                    { 
                        data: 'produk.berat',
                        render: function (data, type, row) {
                            // Format berat dengan 2 angka di belakang koma
                            return parseFloat(data).toFixed(4); // Format angka menjadi 2 desimal
                        }
                    },
                    { 
                        data: 'produk.harga_jual',
                        render: function (data, type, row) {
                            // Format harga jual menjadi angka dengan pemisah ribuan
                            return 'Rp ' + parseFloat(data).toLocaleString(); // Format angka dengan pemisah ribuan
                        }
                    }
                ],
                "footerCallback": function (row, data, start, end, display) {
                    let api = this.api();
            
                    // Pastikan totalBerat adalah angka
                    if (typeof totalBerat === 'number') {
                        $(api.column(3).footer()).html(`<strong class="text-danger">Total: ${totalBerat.toFixed(4)} g</strong>`);
                    } else {
                        $(api.column(3).footer()).html(`<strong>Total: 0 g</strong>`);
                    }
                },
                initComplete: function (settings, json) {
                    $('.dataTables_filter').appendTo('#tableSearch');
                    $('.dataTables_filter').appendTo('.search-input');
                },
                drawCallback: function () {
                    feather.replace();
                }
            });
        }
    }

    const path = window.location.pathname;

    // Periksa apakah URL mengandung "stock/detailStok/"
    if (path.includes("stock/detailStok/")) {
        loadProduk(); // Jalankan fungsi jika URL cocok
    }
})