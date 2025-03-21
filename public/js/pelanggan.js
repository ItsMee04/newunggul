$(document).ready(function () {
    loadPelanggan();

    // Inisialisasi tooltip Bootstrap
    function initializeTooltip() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    $(document).on("click", "#refreshButton", function () {
        if (pelangganTable) {
            pelangganTable.ajax.reload(); // Reload data dari server
        }
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Pelanggan Berhasil Direfresh");
        toast.show();
    });

    function loadPelanggan() {
        // Datatable
        if ($('.tabelPelanggan').length > 0) {
            pelangganTable = $('.tabelPelanggan').DataTable({
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
                    url: 'pelanggan/getPelanggan', // Ganti dengan URL endpoint server Anda
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
                        data: 'kodepelanggan',
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'alamat'
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

    //ketika klik button tambah
    $(".btn-tambahPelanggan").on("click", function () {
        $("#mdtambahPelanggan").modal("show");
    });

    //kirim data ke server
    $("#storePelanggan").on("submit", function (event) {
        event.preventDefault(); // Mencegah form submit secara default
        // Ambil elemen input file

        // Buat objek FormData
        const formData = new FormData(this);
        $.ajax({
            url: "/pelanggan", // Endpoint Laravel untuk menyimpan pegawai
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
                $("#mdtambahPelanggan").modal("hide"); // Tutup modal
                $("#storePelanggan")[0].reset(); // Reset form
                pelangganTable.ajax.reload(); // Reload data dari server
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
        const pelangganID = $(this).data("id");

        $.ajax({
            url: `/pelanggan/${pelangganID}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                // Isi modal dengan data pegawai
                $("#editid").val(response.Data.id);
                $("#editkodepelanggan").val(response.Data.kodepelanggan);
                $("#editnik").val(response.Data.nik);
                $("#editnama").val(response.Data.nama);
                $("#editkontak").val(response.Data.kontak);
                $("#edittanggal").val(response.Data.tanggal);
                $("#editalamat").val(response.Data.alamat);

                // Update dropdown status sesuai dengan data yang diterima
                // Cek status dan pilih option yang sesuai menggunakan Select2
                if (response.Data.status == 2) {
                    $("#editstatus").val(2).trigger("change"); // Pilih option dengan value=2 dan update Select2
                } else {
                    $("#editstatus").val(1).trigger("change"); // Pilih option dengan value=1 dan update Select2
                }

                // Tampilkan modal edit
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

    // Ketika modal ditutup, reset semua field
    $("#modaledit").on("hidden.bs.modal", function () {
        // Reset form input (termasuk gambar dan status)
        $("#formEditPelanggan")[0].reset();

        // Reset dropdown status jika perlu
        $("#editstatus").val("").trigger("change"); // Reset select status jika menggunakan Select2 atau lainnya
    });

    // Kirim data ke server saat form disubmit
    $(document).on("submit", "#formEditPelanggan", function (e) {
        e.preventDefault(); // Mencegah form submit secara default

        // Ambil data dari form
        const dataForm = new FormData();
        dataForm.append("id", $("#editid").val());
        dataForm.append("kodepelanggan", $("#editkodepelanggan").val());
        dataForm.append("nik", $("#editnik").val());
        dataForm.append("nama", $("#editnama").val());
        dataForm.append("kontak", $("#editkontak").val());
        dataForm.append("tanggal", $("#edittanggal").val());
        dataForm.append("alamat", $("#editalamat").val());
        dataForm.append("status", $("#editstatus").val());
        dataForm.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF Token Laravel
        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: `/pelanggan/${$("#editid").val()}`, // URL untuk mengupdate data pegawai
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
                $("#formEditPelanggan")[0].reset(); // Reset form
                pelangganTable.ajax.reload(); // Reload data dari server
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
                    fetch(`/pelanggan/${itemId}`, {
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
                                pelangganTable.ajax.reload(); // Reload data dari server
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
