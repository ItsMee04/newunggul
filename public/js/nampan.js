$(document).ready(function () {
    loadNampan();

    function loadNampan() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: `nampan/getNampan`, // URL endpoint
            type: "GET",
            data: {
                _token: CSRF_TOKEN,
            },
            dataType: "json",
            success: function (data) {
                let produkAktif = data.Total;
                $("#daftarNampan").empty(); // Kosongkan daftar sebelumnya
                $.each(data.Data, function (key, item) {
                    let statusBadge =
                        item.status === 1
                            ? '<span class="badge badge-linesuccess text-center w-auto me-1">Active</span>'
                            : '<span class="badge badge-linedanger text-center w-auto me-1">InActive</span>';

                    let imageSrc = item.image
                        ? `/storage/icon/${
                              item.image
                          }?t=${new Date().getTime()}`
                        : `/assets/img/notfound.png`;

                    $("#daftarNampan").append(`
                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                            <div class="bank-box">
                                <div class="bank-header">
                                    <div class="bank-name">
                                        <h6>${item.nampan}</h6>
                                        <p>${statusBadge}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="system-app-icon">
                                        <img src="assets/img/icons/fb-icon.svg" alt="">
                                    </span>
                                    <div class="bank-info">
                                        <h6>${item.jenis.jenis}</h6>
                                    </div>
                                    <div class="edit-delete-action bank-action-btn">
                                        <a class="me-2 p-2">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a class="confirm-text p-2" href="javascript:void(0);">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });

                $("#totalProdukAktif").text(produkAktif);
            },
            error: function (xhr, status, error) {
                console.error("Terjadi kesalahan saat memuat data:", error);
            },
        });
    }

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
                    fetch(`/delete-nampan/${itemId}`, {
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
