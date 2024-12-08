$(document).ready(function () {
    laodJenis();
    searchJenis();

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

    $(document).on("click", ".confirm-text", function () {
        const itemId = $(this).data("item-id"); // Ambil ID produk dari atribut data-id

            // // SweetAlert2 untuk konfirmasi
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
                                );
                                laodJenis();
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
    })

    $(document).on("click", "#refreshButton", function () {
        laodJenis(); // Panggil fungsi untuk memuat ulang data pegawai
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Jenis Berhasil Direfresh");
        toast.show();
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
                            <div class=" notes-card notes-card-details w-100 employee-item" data-name="${item.jenis}">
                                <div class="notes-card-body">
                                    ${statusBadge}
                                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu notes-menu dropdown-menu-end">
                                        <a href="#" class="dropdown-item btn-edit" data-id="${item.id}"><span><i
                                                    data-feather="edit"></i></span>Edit</a>
                                        <a class="dropdown-item confirm-text " data-item-id="${item.id}"><span><i
                                                    data-feather="trash-2"></i></span>Delete</a>
                                    </div>
                                </div>
                                <div class="notes-wrap-content">
                                    <h4>
                                        <a href="javascript:void(0);">
                                            ${item.jenis}
                                        </a>
                                    </h4>
                                    
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

    $(".btn-tambahJenis").on("click", function () {
        $("#mdTambahjenis").modal("show");
    });

    $("#storeJenis").on("submit", function (event) {
        event.preventDefault(); // Mencegah form submit secara default
        // Ambil elemen input file
        const fileInput = $("#image")[0];
        const file = fileInput.files[0];

        // Buat objek FormData
        const formData = new FormData(this);
        formData.delete("image"); // Hapus field 'image' bawaan form
        formData.append("image", file); // Tambahkan file baru
        $.ajax({
            url: "/jenis", // Endpoint Laravel untuk menyimpan pegawai
            type: "POST",
            data: formData,
            processData: false, // Agar data tidak diubah menjadi string
            contentType: false, // Agar header Content-Type otomatis disesuaikan
            success: function (response) {
                const successtoastExample =
                    document.getElementById("successToast");
                const toast = new bootstrap.Toast(successtoastExample);
                $(".toast-body").text(response.message);
                toast.show();
                $("#mdTambahjenis").modal("hide"); // Tutup modal
                $("#storeJenis")[0].reset(); // Reset form

                laodJenis();
            },
            error: function (xhr) {
                // Tampilkan pesan error dari server
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMessage = "";
                    for (let key in errors) {
                        errorMessage += `${errors[key][0]}\n`;
                    }
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(errorMessage);
                    toast.show();
                } else {
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(response.message);
                    toast.show();
                }
            },
        });
    });

    //ketika button edit di tekan
    $(document).on("click", ".btn-edit", function () {
        const jenisID = $(this).data("id");

        $.ajax({
            url: `/jenis/${jenisID}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                // Isi modal dengan data pegawai
                $("#editid").val(response.data.id);
                $("#editjenis").val(response.data.jenis);

                // Update preview gambar
                let imageSrc = response.data.icon
                    ? `/storage/icon/${response.data.icon}`
                    : `/assets/img/notfound.png`;
                $("#editPreview img").attr("src", imageSrc);

                // Update dropdown status sesuai dengan data yang diterima
                // Cek status dan pilih option yang sesuai menggunakan Select2
                if (response.data.status == 2) {
                    $("#editstatus").val(2).trigger("change"); // Pilih option dengan value=2 dan update Select2
                } else {
                    $("#editstatus").val(1).trigger("change"); // Pilih option dengan value=1 dan update Select2
                }

                // Tampilkan modal edit
                $("#modaledit").modal("show");
            },
            error: function () {
                Swal.fire(
                    "Gagal!",
                    "Tidak dapat mengambil data pegawai.",
                    "error"
                );
            },
        });
    });

    // Menangani perubahan gambar saat memilih file baru
    $("#editImage").on("change", function (e) {
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function (event) {
            // Update preview gambar dengan gambar baru yang dipilih
            $("#editPreview img").attr("src", event.target.result);
        };

        if (file) {
            reader.readAsDataURL(file); // Membaca file sebagai URL data
        }
    });

    // Ketika modal ditutup, reset semua field
    $("#modaledit").on("hidden.bs.modal", function () {
        // Reset form input (termasuk gambar dan status)
        $("#formEditJenis")[0].reset();

        // Reset gambar preview (gambar default)
        $("#editPreview img").attr("src", "/assets/img/notfound.png");

        // Reset dropdown status jika perlu
        $("#editstatus").val("").trigger("change"); // Reset select status jika menggunakan Select2 atau lainnya
    });

    // Kirim data ke server saat form disubmit
    $(document).on("submit", "#formEditJenis", function (e) {
        e.preventDefault(); // Mencegah form submit secara default

        // Ambil data dari form
        const dataForm = new FormData();
        dataForm.append("id", $("#editid").val());
        dataForm.append("jenis", $("#editjenis").val());
        dataForm.append("status", $("#editstatus").val());
        dataForm.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF Token Laravel

        const avatar = $("#editImage")[0].files[0]; // Ambil gambar jika ada
        if (avatar) {
            dataForm.append("avatar", avatar);
        }

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: `/jenis/${$("#editid").val()}`, // URL untuk mengupdate data pegawai
            type: "POST", // Gunakan metode POST (atau PATCH jika route mendukung)
            data: dataForm, // Gunakan FormData
            processData: false, // Jangan proses FormData sebagai query string
            contentType: false, // Jangan set Content-Type secara manual
            success: function (response) {
                // Tampilkan toast sukses
                const successtoastExample =
                    document.getElementById("successToast");
                const toast = new bootstrap.Toast(successtoastExample);
                $(".toast-body").text(response.message);
                toast.show();
                $("#modaledit").modal("hide"); // Tutup modal
                $("#formEditJenis")[0].reset(); // Reset form
                laodJenis();
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors) {
                    let errorMessage = "";
                    for (let key in errors) {
                        errorMessage += `${errors[key][0]}\n`;
                    }
                    const dangertoastExamplee =
                        document.getElementById("dangerToastError");
                    const toast = new bootstrap.Toast(dangertoastExamplee);
                    $(".toast-body").text(errorMessage);
                    toast.show();
                }
            },
        });
    });

    //function search
    function searchJenis() {
        document
            .getElementById("searchInput")
            .addEventListener("input", function () {
                const searchValue = this.value.toLowerCase();
                const employeeItems =
                    document.querySelectorAll(".employee-item");

                employeeItems.forEach((item) => {
                    const name = item.getAttribute("data-name").toLowerCase();

                    // Check if search value matches any attribute
                    if (
                        name.includes(searchValue)
                    ) {
                        item.style.display = ""; // Show
                    } else {
                        item.style.display = "none"; // Hide
                    }
                });
            });
    }
});
