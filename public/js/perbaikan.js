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
                    { data: 'tanggal_masuk'},
                    { data: 'tanggal_keluar'},
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
                                    <a class="me-2 p-2 btn-detailProduk" data-id="${row.id}">
                                        <i data-feather="eye" class="feather-edit"></i>
                                    </a>
                                    <a class="confirm-service p-2" data-id="${row.id}">
                                        <i data-feather="check-circle" class="feather-trash-2"></i>
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

    $(document).on("click",".btn-detailProduk", function(){
        const itemId = $(this).data("id");
        console.log(itemId);
    })

    $(document).on("click",".confirm-service", function(){
        const itemId = $(this).data("id");

        Swal.fire({
            title: "Status Produk",
            text: "Apakah Produk Sudah Di Reparasi ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Sudah!",
            cancelButtonText: "Batal",
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim permintaan hapus (gunakan itemId)
                fetch(`perbaikan/updatePerbaikanProduk/${itemId}`, {
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
                                "Di Update!",
                                "Data berhasil diperbarui.",
                                "success"
                            );
                            loadActiveTabData();
                        } else {
                            Swal.fire(
                                "Gagal!",
                                "Terjadi kesalahan saat memperbarui data.",
                                "error"
                            );
                        }
                    })
                    .catch((error) => {
                        Swal.fire(
                            "Gagal!",
                            "Terjadi kesalahan dalam memperbarui data.",
                            "error"
                        );
                    });
            } else {
                // Jika batal, beri tahu pengguna
                Swal.fire("Dibatalkan", "Data tidak diperbarui.", "info");
            }
        });
    })
});
