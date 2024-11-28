$(document).ready(function () {
    const imgInput = document.getElementById("image");
    const previewImage = document.getElementById("preview");

    imgInput.addEventListener("change", () => {
        const file = imgInput.files[0];
        const reader = new FileReader();

        reader.addEventListener("load", () => {
            previewImage.innerHTML = "";
            const img = document.createElement("img");
            img.src = reader.result;

            previewImage.appendChild(img);
        });

        reader.readAsDataURL(file);
    });

    document
        .getElementById("searchInput")
        .addEventListener("input", function () {
            const searchValue = this.value.toLowerCase();
            const employeeItems = document.querySelectorAll(".produk-item");

            employeeItems.forEach((item) => {
                const name = item.getAttribute("data-name").toLowerCase();
                const harga = item.getAttribute("data-harga").toLowerCase();
                const berat = item.getAttribute("data-berat").toLowerCase();
                const kode = item.getAttribute("data-kode").toLowerCase();

                // Check if search value matches any attribute
                if (
                    name.includes(searchValue) ||
                    harga.includes(searchValue) ||
                    berat.includes(searchValue) ||
                    kode.includes(searchValue)
                ) {
                    item.style.display = ""; // Show
                } else {
                    item.style.display = "none"; // Hide
                }
            });
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
                    fetch(`/produk/${itemId}`, {
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
