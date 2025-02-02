$(document).ready(function () {

    loadStok();

    // Inisialisasi tooltip Bootstrap
    function initializeTooltip() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

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
})