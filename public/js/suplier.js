$(document).ready(function () {
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
                    fetch(`/suplier/${itemId}`, {
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
