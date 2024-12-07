$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Mengambil token CSRF dari meta tag
        },
    });

    loadUser();
    searchInput();

    $(document).on("click", "#refreshButton", function () {
        loadUser(); // Panggil fungsi untuk memuat ulang data pegawai
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data User Berhasil Direfresh");
        toast.show();
    });

    function loadUser() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: `user/getUser`, // URL endpoint
            type: "GET",
            data: {
                _token: CSRF_TOKEN,
            },
            dataType: "json",
            success: function (data) {
                let userAktif = data.Total;
                $("#daftarUser").empty(); // Kosongkan daftar sebelumnya
                $.each(data.Data, function (key, item) {
                    let statusBadge =
                        item.status === 1
                            ? '<span class="badge badge-linesuccess text-center w-auto me-1">Active</span>'
                            : '<span class="badge badge-linedanger text-center w-auto me-1">InActive</span>';

                    let imageSrc = item.pegawai.image
                        ? `/storage/avatar/${
                              item.pegawai.image
                          }?t=${new Date().getTime()}`
                        : `/assets/img/notfound.png`;

                    let emailStatus =
                        item.email == null
                            ? "<span> - </span>"
                            : `<span>${item.email}`;

                    $("#daftarUser").append(`
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 employee-item" data-name="${item.pegawai.nama}"
                            data-nip="${item.pegawai.nip}">
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
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-info">
                                    <div class="profile-pic profile">
                                        <img src="${imageSrc}" alt="avatar">
                                    </div>
                                    <h5>NIP : ${item.pegawai.nip}</h5>
                                    <h4>${item.pegawai.nama}</h4>
                                    <span>${item.role.role}</span>
                                </div>
                                <ul class="department">
                                    <li>
                                        Email
                                        ${emailStatus}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    `);
                });

                $("#totalUserAktif").text(userAktif);
            },
            error: function (xhr, status, error) {
                console.error("Terjadi kesalahan saat memuat data:", error);
            },
        });
    }

    //ketika button edit di tekan
    $(document).on("click", ".btn-edit", function () {
        const userId = $(this).data("id");

        $.ajax({
            url: `/user/${userId}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                if (response.success) {
                    const editID = response.data[0].id;
                    const namaPegawai = response.data[0].pegawai.nama;
                    const emailPegawai = response.data[0].email;

                    // Set nilai input editNama
                    $("#editID").val(editID);
                    $("#editNama").val(namaPegawai);
                    $("#editEmail").val(emailPegawai);

                    // Tampilkan modal edit
                    $("#modaledit").modal("show");
                }
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

    function updateUser() {}

    // Ketika modal ditutup, reset semua field
    $("#modaledit").on("hidden.bs.modal", function () {
        // Reset form input (termasuk gambar dan status)
        $("#formEditUser")[0].reset();
    });

    // Kirim data ke server saat form disubmit
    $(document).on("submit", "#formEditUser", function (e) {
        e.preventDefault(); // Mencegah form submit secara default

        // Ambil data dari form
        const dataForm = new FormData();
        dataForm.append("id", $("#editID").val());
        dataForm.append("nama", $("#editNama").val());
        dataForm.append("email", $("#editEmail").val());
        dataForm.append("password", $("#editPassword").val());

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: `/user/${$("#editID").val()}`, // URL untuk mengupdate data pegawai
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
                $("#formEditUser")[0].reset(); // Reset form
                loadUser();
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

                    // Check if search value matches any attribute
                    if (
                        name.includes(searchValue) ||
                        nip.includes(searchValue)
                    ) {
                        item.style.display = ""; // Show
                    } else {
                        item.style.display = "none"; // Hide
                    }
                });
            });
    }
});
