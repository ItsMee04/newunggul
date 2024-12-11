$(document).ready(function () {

    loadOrder();

    $(document).on("click", "#refreshButton", function () {
        if (orderTable) {
            orderTable.ajax.reload(); // Reload data dari server
        }
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Order Berhasil Direfresh");
        toast.show();
    });

    function loadOrder() {
        if ($('.orderTable').length > 0) {
            orderTable = $('.orderTable').DataTable({
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
                    url: `/order/getOrder`, // Ganti dengan URL endpoint server Anda
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
                        data: 'kodetransaksi'
                    },
                    {
                        data: 'keranjang_id'
                    },
                    {
                        data: 'pelanggan.nama'
                    },
                    {
                        data: 'total',
                        render: function (data) {
                            return new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            }).format(data);
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            // Cek apakah data gambar tersedia atau tidak
                            const imageSrc = row.user.pegawai.image ? `/storage/avatar/${row.user.pegawai.image}` : '/assets/img/notfound.png';
                            return `
                                <div class="productimgname">
                                    <a href="javascript:void(0);" class="product-img stock-img">
                                        <img src="${imageSrc}" alt="product">
                                    </a>
                                    <a href="javascript:void(0);">${row.user.pegawai.nama}</a>
                                </div>
                            `;
                        },
                    },
                    {
                        data: 'status',
                        render: function (data, type, row) {
                            // Menampilkan badge sesuai dengan status
                            if (data == 1) {
                                return `<span class="badge badge-sm bg-outline-warning"> UNPAID</span>`;
                            } else if (data == 2) {
                                return `<span class="badge badge-sm bg-outline-success"> PAID</span>`;
                            } else {
                                return `<span class="badge badge-sm bg-outline-danger"> CANCELED</span>`;
                            }
                        }
                    },
                    {
                        data: null,        // Kolom aksi
                        orderable: false,  // Aksi tidak perlu diurutkan
                        className: "action-table-data",
                        render: function (data, type, row, meta) {
                            if (row.status === 1) {
                                // Jika status adalah 1
                                return `
                                    <div class="edit-delete-action">
                                        <a class="me-2 edit-icon  p-2" href="/order/${row.id}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="me-2 confirm-payment p-2" href="javascript:void(0);"
                                            data-id="${row.id}">
                                            <i data-feather="check-circle" class="feather-edit"></i>
                                        </a>
                                        <a class="confirm-cancel p-2" href="javascript:void(0);"
                                            data-id="${row.id}">
                                            <i data-feather="x-circle" class="feather-trash-2"></i>
                                        </a>
                                    </div>
                                `;
                            } else {
                                // Jika status bukan 1
                                return `
                                    <div class="edit-delete-action">
                                        <a class="me-2 edit-icon p-2" href="/order/${row.id}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                    </div>
                                `;
                            }
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
                    fetch(`/confirmPayment/${kodetransaksi}`, {
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
                                orderTable.ajax.reload(); // Reload data dari server
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
        $(document).on("click", ".confirm-cancel", function (e) {
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
                    fetch(`/cancelPayment/${kodetransaksi}`, {
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
                                orderTable.ajax.reload(); // Reload data dari server
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
});
