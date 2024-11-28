$(document).ready(function () {
    // Ambil input pencarian dan tabel
    var input = document.getElementById("searchInput");
    var table = document.getElementById("myTable");
    var rows = table.getElementsByTagName("tr");

    // Fungsi pencarian
    input.addEventListener("keyup", function () {
        var filter = input.value.toUpperCase();

        // Loop melalui semua baris dan sembunyikan yang tidak sesuai dengan pencarian
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName("td");
            var match = false;

            // Cek apakah ada teks yang sesuai dalam baris
            for (var j = 0; j < cells.length; j++) {
                var cellValue = cells[j].textContent || cells[j].innerText;
                if (cellValue.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }

            // Sembunyikan baris jika tidak ada kecocokan
            rows[i].style.display = match ? "" : "none";
        }
    });

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
