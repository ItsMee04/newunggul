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
        if ($('.pembelianTable').length > 0) {
            pembelianTable = $('.pembelianTable').DataTable({
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
                    url: 'pembelian/getPembelian', // Ganti dengan URL endpoint server Anda
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
                        data: 'kodepembelian'
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
                                return '-'; // Jika keduanya tidak ada, tampilkan tanda "-"
                            }
                        }
                    },
                    {
                        data: 'produk.nama'
                    },
                    {
                        data: 'produk.berat'
                    },
                    {
                        data: 'tanggal'
                    },     // Kolom Nama
                    {
                        data: null,        // Kolom aksi
                        orderable: false,  // Aksi tidak perlu diurutkan
                        className: "action-table-data",
                        render: function (data, type, row, meta) {
                            return `
                            <div class="edit-delete-action">
                                <a class="me-2 p-2 btn-detail" data-id="${row.id}">
                                    <i data-feather="eye" class="action-eye"></i>
                                </a>
                                <a class="me-2 p-2 btn-edit" data-id="${row.id}">
                                    <i data-feather="edit" class="feather-edit"></i>
                                </a>
                                <a class="confirm-text p-2" data-id="${row.id}">
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
                    feather.replace(); // Inisialisasi ulang Feather Icons
                }
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

    $(".btn-tambahPembelian").on("click", function () {
        $("#mdtambahPembelian").modal("show");
        loadJenis();
        loadSuplier();
        loadPelanggan();
    });

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

    //ketika button edit di tekan
    $(document).on("click", ".btn-detail", function () {
        const pembelianID = $(this).data("id");

        $.ajax({
            url: `/pembelian/${pembelianID}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                // Isi modal dengan data pembelian
                // $("#detailPenjual").val(response.Data.id);
                $("#detailNama").val(response.Data[0].produk.nama);
                $("#detailBerat").val(response.Data[0].produk.berat);
                $("#detailKarat").val(response.Data[0].produk.karat);
                $("#detailJenis").val(response.Data[0].produk.jenis);
                $("#detailHargabeli").val(response.Data[0].produk.harga_beli);
                $("#detailKondisi").val(response.Data[0].kondisi);
                $("#detailKeterangan").val(response.Data[0].produk.keterangan);
                $("#detailKeterangan").val(response.Data[0].status);

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

});