$(document).ready(function () {
    loadPegawai();
    searchInput();

    $(document).on("click", "#refreshButton", function () {
        loadPegawai(); // Panggil fungsi untuk memuat ulang data pegawai
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Pegawai Berhasil Direfresh");
        toast.show();
    });

    //function load pegawai
    function loadPegawai() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: `pegawai/getpegawai`, // URL endpoint
            type: "GET",
            data: {
                _token: CSRF_TOKEN,
            },
            dataType: "json",
            success: function (data) {
                let pegawaiAktif = data.Total;
                $("#daftarPegawai").empty(); // Kosongkan daftar sebelumnya
                $.each(data.Data, function (key, item) {
                    let statusBadge =
                        item.status === 1
                            ? '<span class="badge badge-linesuccess text-center w-auto me-1">Active</span>'
                            : '<span class="badge badge-linedanger text-center w-auto me-1">InActive</span>';

                    let imageSrc = item.image
                        ? `/storage/avatar/${
                              item.image
                          }?t=${new Date().getTime()}`
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
                                                        data-item-id="${item.id}">
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

                $("#totalPegawaiAktif").text(pegawaiAktif);
            },
            error: function (xhr, status, error) {
                console.error("Terjadi kesalahan saat memuat data:", error);
            },
        });
    }

    // Fungsi untuk memuat data jabatan
    function loadJabatan() {
        $.ajax({
            url: "/jabatan", // Endpoint untuk mendapatkan data jabatan
            type: "GET",
            success: function (response) {
                let options = '<option value="">-- Pilih Jabatan --</option>';
                response.Data.forEach((item) => {
                    options += `<option value="${item.id}">${item.jabatan}</option>`;
                });
                $("#jabatan").html(options); // Masukkan data ke select
            },
            error: function () {
                alert("Gagal memuat data jabatan!");
            },
        });
    }

    $(".btn-tambahPegawai").on("click", function () {
        $("#mdTambahPegawai").modal("show");
        loadJabatan();
    });

    // Fungsi untuk menangani submit form pegawai
    $("#storePegawai").on("submit", function (event) {
        event.preventDefault(); // Mencegah form submit secara default
        // Ambil elemen input file
        const fileInput = $("#image")[0];
        const file = fileInput.files[0];

        // Buat objek FormData
        const formData = new FormData(this);
        formData.delete("image"); // Hapus field 'image' bawaan form
        formData.append("image", file); // Tambahkan file baru
        $.ajax({
            url: "/pegawai", // Endpoint Laravel untuk menyimpan pegawai
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
                $("#mdTambahPegawai").modal("hide"); // Tutup modal
                $("#storePegawai")[0].reset(); // Reset form
                $("#preview").empty();
                loadPegawai();
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
        const pegawaiId = $(this).data("id");

        $.ajax({
            url: `/pegawai/${pegawaiId}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                // Isi modal dengan data pegawai
                $("#editid").val(response.data.id);
                $("#editnip").val(response.data.nip);
                $("#editnama").val(response.data.nama);
                $("#editkontak").val(response.data.kontak);
                $("#editalamat").val(response.data.alamat);

                // Update preview gambar
                let imageSrc = response.data.image
                    ? `/storage/avatar/${response.data.image}`
                    : `/assets/img/notfound.png`;
                $("#editPreview img").attr("src", imageSrc);

                // Muat opsi jabatan
                $.ajax({
                    url: "/jabatan",
                    type: "GET",
                    success: function (jabatanResponse) {
                        let options =
                            '<option value="">-- Pilih Jabatan --</option>';
                        jabatanResponse.Data.forEach((item) => {
                            const selected =
                                item.id === response.data.jabatan_id
                                    ? "selected"
                                    : "";
                            options += `<option value="${item.id}" ${selected}>${item.jabatan}</option>`;
                        });
                        $("#editjabatan").html(options);
                    },
                });

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
        $("#formEditPegawai")[0].reset();

        // Reset gambar preview (gambar default)
        $("#editPreview img").attr("src", "/assets/img/notfound.png");

        // Reset dropdown status jika perlu
        $("#editstatus").val("").trigger("change"); // Reset select status jika menggunakan Select2 atau lainnya

        // Reset dropdown jabatan jika perlu
        $("#editjabatan").val("").trigger("change"); // Reset select jabatan jika menggunakan Select2 atau lainnya
    });
    
    // Ketika modal ditutup, reset semua field
    $("#mdTambahPegawai").on("hidden.bs.modal", function () {
        // Reset form input (termasuk gambar dan status)
        $("#storePegawai")[0].reset();
        // Reset gambar preview (gambar default)
        $("#preview").empty();
    });
    // Kirim data ke server saat form disubmit
    $(document).on("submit", "#formEditPegawai", function (e) {
        e.preventDefault(); // Mencegah form submit secara default

        // Ambil data dari form
        const dataForm = new FormData();
        dataForm.append("id", $("#editid").val());
        dataForm.append("nip", $("#editnip").val());
        dataForm.append("nama", $("#editnama").val());
        dataForm.append("kontak", $("#editkontak").val());
        dataForm.append("alamat", $("#editalamat").val());
        dataForm.append("status", $("#editstatus").val());
        dataForm.append("jabatan", $("#editjabatan").val());
        dataForm.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF Token Laravel

        const avatar = $("#editImage")[0].files[0]; // Ambil gambar jika ada
        if (avatar) {
            dataForm.append("avatar", avatar);
        }

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: `/pegawai/${$("#editid").val()}`, // URL untuk mengupdate data pegawai
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
                $("#formEditPegawai")[0].reset(); // Reset form
                loadPegawai();
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

    // ketika button hapus di tekan
    $(document).on("click", ".confirm-text", function () {
        const itemId = $(this).data("item-id");

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
                            );
                            loadPegawai();
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

    //function search
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
});
