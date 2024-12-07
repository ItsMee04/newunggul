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
                        <tr data-jenis=${item.jenis}>
                            <th scope="row">
                            <div class="productimgname">
                                    <a href="javascript:void(0);" class="product-img stock-img">
                                        <img src="${imageSrc}" alt="avatar">
                                    </a>
                                    <a href="javascript:void(0);">${item.jenis} </a>
                                </div>	
                            </th>
                            <td>${statusBadge}</td>
                            <td>
                                <div class="hstack gap-2 fs-15">
                                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-success rounded-pill"><i class="feather-download"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-info rounded-pill"><i class="feather-edit"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-soft-danger rounded-pill"><i class="feather-trash"></i></a>
                                </div>
                            </td>
                        </tr>
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
