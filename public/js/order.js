$(document).ready(function () {
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
                                ).then(() => location.reload());
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
                                ).then(() => location.reload());
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
