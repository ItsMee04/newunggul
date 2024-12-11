$(document).ready(function () {
    loadNampanProduk()

    $(document).on("click", "#refreshButton", function () {
        if (nampanProdukTable) {
            nampanProdukTable.ajax.reload(); // Reload data dari server
        }
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Nampan Produk Berhasil Direfresh");
        toast.show();
    });

    function loadNampanProduk() {
        // Datatable
        const path = window.location.pathname;
        const paramNampan = path.split('/').pop(); // Ambil ID dari URL
        if ($('.tabelNampanProduk').length > 0) {
            nampanProdukTable = $('.tabelNampanProduk').DataTable({
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
                    url: `/nampan/getNampanProduk/${paramNampan}`, // Ganti dengan URL endpoint server Anda
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
                        data: 'produk.kodeproduk'
                    },
                    {
                        data: 'produk.nama'
                    },
                    {
                        data: 'produk.berat'
                    },
                    {
                        data: 'produk.karat'
                    },
                    {
                        data: 'produk.harga_jual',
                        render: function (data) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 2
                            }).format(data);
                        }
                    },
                    {
                        data: null,        // Kolom aksi
                        orderable: false,  // Aksi tidak perlu diurutkan
                        className: "action-table-data",
                        render: function (data, type, row, meta) {
                            return `
                            <div class="edit-delete-action">
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
            });
        }
    }

    function loadProdukDalamNampan() {
        const path = window.location.pathname;
        const paramNampan = path.split('/').pop(); // Ambil ID dari URL
        if ($('.tabelProdukNampan').length > 0) {
            produkNampanTabel = $('.tabelProdukNampan').DataTable({
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
                    url: `/nampan/getProdukNampan/{id}/${paramNampan}`, // Ganti dengan URL endpoint server Anda
                    type: 'GET', // Metode HTTP (GET/POST)
                    dataSrc: 'Data' // Jalur data di response JSON
                },
                columns: [
                    {
                        data: 'id', // Menggunakan ID sebagai nilai checkbox
                        render: function (data, type, row) {
                            return `
                                <label class="checkboxs">
                                    <input type="checkbox" name="items[]" value="${data}">
                                    <span class="checkmarks"></span>
                                </label>
                            `;
                        },
                    },
                    {
                        data: null, // Kolom nomor urut
                        render: function (data, type, row, meta) {
                            return meta.row + 1; // Nomor urut dimulai dari 1
                        },
                        orderable: false,
                    },
                    {
                        data: 'kodeproduk'
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            // Cek apakah data gambar tersedia atau tidak
                            const imageSrc = row.image ? `/storage/produk/${row.image}` : '/assets/img/notfound.png';
                            return `
                                <div class="productimgname">
                                    <a href="javascript:void(0);" class="product-img stock-img">
                                        <img src="${imageSrc}" alt="product">
                                    </a>
                                    <a href="javascript:void(0);">${row.nama}</a>
                                </div>
                            `;
                        },
                    },
                    {
                        data: 'berat'
                    },
                    {
                        data: null,        // Kolom aksi
                        orderable: false,  // Aksi tidak perlu diurutkan
                        className: "action-table-data",
                        render: function (data, type, row, meta) {
                            return `
                            <div class="edit-delete-action">
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
            });
        }

        console.log(paramNampan)
    }

    $(".btn-tambahProduk").on("click", function () {
        $("#mdTambahProduk").modal("show");

        function loadProdukDalamNampan() {
            const path = window.location.pathname;
            const paramNampan = path.split('/').pop(); // Ambil ID dari URL
            if ($('.tabelProdukNampan').length > 0) {
                produkNampanTabel = $('.tabelProdukNampan').DataTable({
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
                        url: `/nampan/getProdukNampan/{id}/${paramNampan}`, // Ganti dengan URL endpoint server Anda
                        type: 'GET', // Metode HTTP (GET/POST)
                        dataSrc: 'Data' // Jalur data di response JSON
                    },
                    columns: [
                        {
                            data: 'id', // Menggunakan ID sebagai nilai checkbox
                            render: function (data, type, row) {
                                return `
                                    <label class="checkboxs">
                                        <input type="checkbox" name="items[]" value="${data}">
                                        <span class="checkmarks"></span>
                                    </label>
                                `;
                            },
                        },
                        {
                            data: null, // Kolom nomor urut
                            render: function (data, type, row, meta) {
                                return meta.row + 1; // Nomor urut dimulai dari 1
                            },
                            orderable: false,
                        },
                        {
                            data: 'kodeproduk'
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                // Cek apakah data gambar tersedia atau tidak
                                const imageSrc = row.image ? `/storage/produk/${row.image}` : '/assets/img/notfound.png';
                                return `
                                    <div class="productimgname">
                                        <a href="javascript:void(0);" class="product-img stock-img">
                                            <img src="${imageSrc}" alt="product">
                                        </a>
                                        <a href="javascript:void(0);">${row.nama}</a>
                                    </div>
                                `;
                            },
                        },
                        {
                            data: 'berat'
                        },
                        {
                            data: null,        // Kolom aksi
                            orderable: false,  // Aksi tidak perlu diurutkan
                            className: "action-table-data",
                            render: function (data, type, row, meta) {
                                return `
                                <div class="edit-delete-action">
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
                });
            }
    
            console.log(paramNampan)
        }
    });

    














    // // Ambil input pencarian dan tabel
    // var input = document.getElementById("searchInput");
    // var table = document.getElementById("myTable");
    // var rows = table.getElementsByTagName("tr");

    // // Fungsi pencarian
    // input.addEventListener("keyup", function () {
    //     var filter = input.value.toUpperCase();

    //     // Loop melalui semua baris dan sembunyikan yang tidak sesuai dengan pencarian
    //     for (var i = 1; i < rows.length; i++) {
    //         var cells = rows[i].getElementsByTagName("td");
    //         var match = false;

    //         // Cek apakah ada teks yang sesuai dalam baris
    //         for (var j = 0; j < cells.length; j++) {
    //             var cellValue = cells[j].textContent || cells[j].innerText;
    //             if (cellValue.toUpperCase().indexOf(filter) > -1) {
    //                 match = true;
    //                 break;
    //             }
    //         }

    //         // Sembunyikan baris jika tidak ada kecocokan
    //         rows[i].style.display = match ? "" : "none";
    //     }
    // });

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
                    fetch(`/delete-nampan-produk/${itemId}`, {
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
