$(document).ready(function () {
    loadKusam();
    loadRusak()

    function loadKusam() {
        // Datatable
        if ($(".kusamTable").length > 0) {
            kusamTable = $(".kusamTable").DataTable({
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
                    url: 'perbaikan/getPerbaikan', // Ganti dengan URL endpoint server Anda
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
                        data: 'produk.kodeproduk',
                    },
                    {
                        data: 'keterangan', // Data field untuk diskon
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
                    $(".dataTables_filter").appendTo("#tableSearch");
                    $(".dataTables_filter").appendTo(".search-input");
                },
                drawCallback: function () {
                    feather.replace(); // Inisialisasi ulang Feather Icons
                },
            });
        }
    }

    function loadRusak() {
        // Datatable
        if ($(".rusakTable").length > 0) {
            rusakTable = $(".rusakTable").DataTable({
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
                    url: 'perbaikan/getPerbaikan', // Ganti dengan URL endpoint server Anda
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
                        data: 'produk.kodeproduk',
                    },
                    {
                        data: 'keterangan', // Data field untuk diskon
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
                    $(".dataTables_filter").appendTo("#tableSearch");
                    $(".dataTables_filter").appendTo(".search-input");
                },
                drawCallback: function () {
                    feather.replace(); // Inisialisasi ulang Feather Icons
                },
            });
        }
    }

    $(document).on("click", "#kusam-tab", function(){
        kusamTable.ajax.reload();
    })

    $(document).on("click", "#rusak-tab", function(){
        rusakTable.ajax.reload();
    })
})