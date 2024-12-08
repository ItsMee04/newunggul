$(document).ready(function () {
    laodJenis();
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
                    fetch(`/jenis/${itemId}`, {
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

    //function load pegawai
    function laodJenis() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: `jenis/getJenis`, // URL endpoint
            type: "GET",
            data: {
                _token: CSRF_TOKEN,
            },
            dataType: "json",
            success: function (data) {
                let jenisAktif = data.Total;
                $("#daftarJenis").empty(); // Kosongkan daftar sebelumnya
                $.each(data.Data, function (key, item) {
                    let statusBadge =
                        item.status === 1
                            ? '<span class="badge badge-linesuccess text-center w-auto me-1">Active</span>'
                            : '<span class="badge badge-linedanger text-center w-auto me-1">InActive</span>';

                    let imageSrc = item.icon
                        ? `/storage/Icon/${item.icon}?t=${new Date().getTime()}`
                        : `/assets/img/notfound.png`;

                    $("#daftarJenis").append(`
                        <div class="col-md-4 d-flex">
                            <div class="notes-card notes-card-details w-100">
                                <div class="notes-card-body">
                                    <p class="badged medium"><i class="fas fa-circle"></i> Medium</p>
                                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#edit-note-units"><span><i
                                                    data-feather="edit"></i></span>Edit</a>
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#delete-note-units"><span><i
                                                    data-feather="trash-2"></i></span>Delete</a>
                                        <a href="#" class="dropdown-item"><span><i
                                                    data-feather="star"></i></span>Not Important</a>
                                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                            data-bs-target="#view-note-units"><span><i
                                                    data-feather="eye"></i></span>View</a>
                                    </div>
                                </div>
                                <div class="notes-wrap-content">
                                    <h4>
                                        <a href="javascript:void(0);">
                                            ${item.jenis}
                                        </a>
                                    </h4>
                                    <p class="wrap-cal"><i data-feather="calendar" class="feather-calendar"></i>
                                        ${item.created_at}</p>
                                    
                                </div>
                                <div class="notes-slider-widget notes-widget-profile">
                                    <div class="notes-logo">
                                        <a href="javascript:void(0);">
                                            <span>
                                                <img src="${imageSrc}" alt="avatar" class="img-fluid">
                                            </span>
                                        </a>
                                        <div class="d-flex">
                                            <span class="medium-square"><i class="fas fa-square"></i></span>
                                            <p class="medium"> ${item.jenis}</p>
                                        </div>
                                    </div>
                                    <div class="notes-star-delete">
                                        <a href="javascript:void(0);">
                                            <span><i data-feather="trash-2"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });

                $("#totalJenisAktif").text(jenisAktif);
            },
            error: function (xhr, status, error) {
                console.error("Terjadi kesalahan saat memuat data:", error);
            },
        });
    }
});
