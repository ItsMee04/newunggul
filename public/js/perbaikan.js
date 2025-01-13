$(document).ready(function () {
    function initTable(selector, url) {
        if ($(selector).length > 0) {
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().destroy(); // Hancurkan instance lama
            }
            $(selector).DataTable({
                scrollX: false,
                bFilter: true,
                sDom: "fBtlpi",
                ordering: true,
                language: {
                    search: " ",
                    sLengthMenu: "_MENU_",
                    searchPlaceholder: "Search",
                    info: "_START_ - _END_ of _TOTAL_ items",
                    paginate: {
                        next: ' <i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>',
                    },
                },
                ajax: {
                    url: url,
                    type: 'GET',
                    dataSrc: 'Data',
                    error: function (xhr, status, error) {
                        console.error("Error loading data:", error);
                    }
                },
                columns: [
                    { data: null, render: (data, type, row, meta) => meta.row + 1, orderable: false },
                    { data: 'produk.kodeproduk' },
                    { data: 'keterangan' },
                    {
                        data: 'status',
                        render: function (data) {
                            return data == 1
                                ? `<span class="badge badge-sm bg-outline-success"> Active</span>`
                                : data == 2
                                ? `<span class="badge badge-sm bg-outline-danger"> Inactive</span>`
                                : `<span class="badge badge-sm bg-outline-secondary"> Unknown</span>`;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        className: "action-table-data",
                        render: function (data, type, row) {
                            return `
                                <div class="edit-delete-action">
                                    <a class="me-2 p-2 btn-edit" data-id="${row.id}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a class="confirm-text p-2" data-id="${row.id}">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>`;
                        }
                    }
                ],
                initComplete: (settings, json) => {
                    $(".dataTables_filter").appendTo("#tableSearch");
                    $(".dataTables_filter").appendTo(".search-input");
                },
                drawCallback: function () {
                    feather.replace();
                },
            });
        }
    }

    // Fungsi untuk memuat data berdasarkan tab yang aktif
    function loadActiveTabData() {
        const activeTab = $(".nav-link.active"); // Tab aktif
        const tabId = activeTab.attr("id"); // ID dari tab aktif

        if (tabId === "kusam-tab") {
            initTable(".kusamTable", 'perbaikan/getProdukKusam');
        } else if (tabId === "rusak-tab") {
            initTable(".rusakTable", 'perbaikan/getProdukRusak');
        }
    }

    // Saat halaman dimuat, cek tab mana yang aktif dan load datanya
    loadActiveTabData();

    // Saat tab diklik, muat data untuk tab yang baru aktif
    $(document).on("click", ".nav-link", function () {
        $(".nav-link").removeClass("active"); // Hapus kelas active dari semua tab
        $(this).addClass("active"); // Tambahkan kelas active ke tab yang diklik
        loadActiveTabData(); // Muat data untuk tab yang baru aktif
    });
});
