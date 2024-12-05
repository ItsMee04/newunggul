$(document).ready(function () {
    loadPegawai();
    searchInput();

    function loadPegawai() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: `/getpegawai`, // URL endpoint
            type: "GET",
            data: {
                _token: CSRF_TOKEN,
            },
            dataType: "json",
            success: function (data) {
                $("#daftarPegawai").empty(); // Kosongkan daftar sebelumnya
                $.each(data.Data, function (key, item) {
                    let statusBadge =
                        item.status === 1
                            ? '<span class="badge badge-linesuccess text-center w-auto me-1">Active</span>'
                            : '<span class="badge badge-linedanger text-center w-auto me-1">InActive</span>';

                    let imageSrc = item.image
                        ? `/storage/avatar/${item.image}`
                        : `/assets/img/notfound.png`;

                    $("#daftarPegawai").append(`
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 employee-item" data-name="${item.nama}"
                            data-nip="${item.nip}" data-jabatan="${item.jabatan.jabatan}">
                            <div class="employee-grid-profile">
                                <div class="profile-head">
                                    <label class="checkboxs">
                                        <span class="checkmarks"></span>
                                    </label>
                                    <div class="profile-head-action">
                                        ${statusBadge}
                                        <div class="dropdown profile-action ms-2">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i data-feather="more-vertical"
                                                    class="feather-more-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                            
                                                            <a href="javascript:void(0);" class="dropdown-item btn-edit"
                                            data-id="${item.id}"
                                            <i data-feather="edit" class="info-img"></i>Edit
                                        </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item confirm-text mb-0"
                                                        data-item-id="{{ $item->id }}">
                                                        <i data-feather="trash-2" class="info-img"></i>Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-info">
                                    <div class="profile-pic profile">
                                        <img src="${imageSrc}" alt="avatar">
                                    </div>
                                    <h5>NIP : ${item.nip}</h5>
                                    <h4>${item.nama}</h4>
                                    <span>${item.jabatan.jabatan}</span>
                                </div>
                                <ul class="department">
                                    <li>
                                        Kontak
                                        <span>${item.kontak}</span>
                                    </li>
                                    <li>
                                        Alamat
                                        <span>${item.alamat}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    `);
                });
            },
            error: function (xhr, status, error) {
                console.error("Terjadi kesalahan saat memuat data:", error);
            },
        });
    }

    $('.btn-tambahPegawai').on('click', function () {
        $('#mdTambahPegawai').modal('show');
    })

    function storePegawai()
    {
        $('#formTambahPegawai').on('submit', function (e) {
            e.preventDefault(); // Mencegah form dari pengiriman normal
    
            let formData = new FormData(this);
    
            console.log(formData)
        });
    }

    function searchInput() {
        document
            .getElementById("searchInput")
            .addEventListener("input", function () {
                const searchValue = this.value.toLowerCase();
                const employeeItems =
                    document.querySelectorAll(".employee-item");

                employeeItems.forEach((item) => {
                    const name = item.getAttribute("data-name").toLowerCase();
                    const nip = item.getAttribute("data-nip").toLowerCase();
                    const jabatan = item
                        .getAttribute("data-jabatan")
                        .toLowerCase();

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
    }

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
