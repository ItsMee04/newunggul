$(document).ready(function () {
    document
        .getElementById("searchInput")
        .addEventListener("input", function () {
            const searchValue = this.value.toLowerCase();
            const employeeItems = document.querySelectorAll(".employee-item");

            employeeItems.forEach((item) => {
                const name = item.getAttribute("data-name").toLowerCase();
                const nip = item.getAttribute("data-nip").toLowerCase();
                const jabatan = item.getAttribute("data-jabatan").toLowerCase();

                // Check if search value matches any attribute
                if (
                    name.includes(searchValue) ||
                    nip.includes(searchValue) ||
                    jabatan.includes(searchValue)
                ) {
                    item.style.display = ""; // Show
                } else {
                    item.style.display = "none"; // Hide
                }
            });
        });

    //ini saat input
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
    //ini saat input

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
                    fetch(`/pegawai/${itemId}`, {
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
