$(document).ready(function () {
    loadProduk();

    $(document).on("click", "#refreshButton", function () {
        loadProduk(); // Panggil fungsi untuk memuat ulang data pegawai
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Produk Berhasil Direfresh");
        toast.show();
    });

    //function load pegawai
    function loadProduk() {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: `produk/getProduk`, // URL endpoint
            type: "GET",
            data: {
                _token: CSRF_TOKEN,
            },
            dataType: "json",
            success: function (data) {
                let produkAktif = data.Total;
                $("#daftarProduk").empty(); // Kosongkan daftar sebelumnya
                $.each(data.Data, function (key, item) {
                    let statusBadge =
                        item.status === 1
                            ? '<span class="badge badge-linesuccess text-center w-auto me-1">Active</span>'
                            : '<span class="badge badge-linedanger text-center w-auto me-1">InActive</span>';

                    let imageSrc = item.image
                        ? `/storage/Produk/${
                              item.image
                          }?t=${new Date().getTime()}`
                        : `/assets/img/notfound.png`;

                    const formatter = new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR",
                        minimumFractionDigits: 0,
                    });

                    const hargaJual = formatter.format(item.harga_jual);

                    $("#daftarProduk").append(`
                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3 produk-item" data-name="${item.nama}"
                                    data-harga="${item.harga_jual}" data-berat="${item.berat}"
                                    data-kode="${item.kodeproduk}">
                                    <div class="product-info default-cover card">
                                        <div class="dropdown ms-auto pb-3">
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                                data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="downloadBarcode/${item.id}">
                                                        Download Barcode
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="downloadBarcode/${item.id}">
                                                        Stream Barcode
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item btn-edit" data-id="${item.id}">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item confirm-text" data-item-id="${ item.id }"
                                                        href="javascript:void(0);"> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="javascript:void(0);" class="img-bg">
                                        <img src="${imageSrc}" width="100px" height="100px" alt="Products">
                                        </a>
                                        <h6 class="cat-name text-center"><a
                                                href="javascript:void(0);">${item.jenis.jenis}</a>
                                        </h6>
                                        <h6 class="product-name text-center"><a
                                                href="javascript:void(0);">${item.nama}</a></h6>
                                        <div class="d-flex align-items-center justify-content-between price">
                                            <span>
                                                <strong>
                                                    Berat :${item.berat} </br> Karat :${item.karat}
                                                </strong>
                                            </span>
                                            <p>
                                                <strong>
                                                    Harga : ${hargaJual} </br> ${statusBadge}
                                                </strong>
                                            </p>
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

    // Fungsi untuk memuat data jabatan
    function loadJenis() {
        $.ajax({
            url: "/jenis/getJenis", // Endpoint untuk mendapatkan data jabatan
            type: "GET",
            success: function (response) {
                let options = '<option value="">-- Pilih Jenis --</option>';
                response.Data.forEach((item) => {
                    options += `<option value="${item.id}">${item.jenis}</option>`;
                });
                $("#jenis").html(options); // Masukkan data ke select
            },
            error: function () {
                alert("Gagal memuat data jabatan!");
            },
        });
    }

    // Fungsi untuk memuat data kondisi
    function loadKondisi() {
        $.ajax({
            url: "/kondisi/getKondisi", // Endpoint untuk mendapatkan data jabatan
            type: "GET",
            success: function (response) {
                let options = '<option value="">-- Pilih Kondisi --</option>';
                response.Data.forEach((item) => {
                    options += `<option value="${item.id}">${item.kondisi}</option>`;
                });
                $("#kondisi").html(options); // Masukkan data ke select
            },
            error: function () {
                alert("Gagal memuat data jabatan!");
            },
        });
    }

    $(".btn-tambahProduk").on("click", function () {
        $("#mdTambahProduk").modal("show");
        loadJenis();
        loadKondisi()
    });

    // Fungsi untuk menangani submit form pegawai
    $("#storeProduk").on("submit", function (event) {
        event.preventDefault(); // Mencegah form submit secara default
        // Ambil elemen input file
        const fileInput = $("#image")[0];
        const file = fileInput.files[0];

        // Buat objek FormData
        const formData = new FormData(this);
        formData.delete("image"); // Hapus field 'image' bawaan form
        formData.append("image", file); // Tambahkan file baru
        $.ajax({
            url: "/produk", // Endpoint Laravel untuk menyimpan pegawai
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
                $("#mdTambahProduk").modal("hide"); // Tutup modal
                $("#storeProduk")[0].reset(); // Reset form

                loadProduk();
                $("#preview").empty();
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
            url: `/produk/${pegawaiId}`, // Endpoint untuk mendapatkan data pegawai
            type: "GET",
            success: function (response) {
                // Isi modal dengan data pegawai
                $("#editkodeproduk").val(response.data.kodeproduk);
                $("#editnama").val(response.data.nama);
                $("#editberat").val(response.data.berat);
                $("#editkarat").val(response.data.karat);
                $("#edithargajual").val(response.data.harga_jual);
                $("#edithargabeli").val(response.data.harga_beli);
                $("#editketerangan").val(response.data.keterangan);

                // Update preview gambar
                let imageSrc = response.data.image
                    ? `/storage/produk/${response.data.image}`
                    : `/assets/img/notfound.png`;
                $("#editPreview img").attr("src", imageSrc);

                // // Muat opsi jabatan
                $.ajax({
                    url: "/jenis/getJenis",
                    type: "GET",
                    success: function (jabatanResponse) {
                        let options =
                            '<option value="">-- Pilih Jenis --</option>';
                        jabatanResponse.Data.forEach((item) => {
                            const selected =
                                item.id === response.data.jenis_id
                                    ? "selected"
                                    : "";
                            options += `<option value="${item.id}" ${selected}>${item.jenis}</option>`;
                        });
                        $("#editjenis").html(options);
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
        $("#formEditProduk")[0].reset();

        // Reset gambar preview (gambar default)
        $("#editPreview img").attr("src", "/assets/img/notfound.png");

        // Reset dropdown status jika perlu
        $("#editstatus").val("").trigger("change"); // Reset select status jika menggunakan Select2 atau lainnya

        // Reset dropdown jabatan jika perlu
        $("#editjenis").val("").trigger("change"); // Reset select jabatan jika menggunakan Select2 atau lainnya
    });

    $("#mdTambahProduk").on("hidden.bs.modal", function () {
        // Reset form input (termasuk gambar dan status)
        $("#storeProduk")[0].reset();

        $("#preview").empty();

        // Reset dropdown status jika perlu
        $("#editstatus").val("").trigger("change"); // Reset select status jika menggunakan Select2 atau lainnya

        // Reset dropdown jabatan jika perlu
        $("#editjenis").val("").trigger("change"); // Reset select jabatan jika menggunakan Select2 atau lainnya
    });

    // Kirim data ke server saat form disubmit
    $(document).on("submit", "#formEditProduk", function (e) {
        e.preventDefault(); // Mencegah form submit secara default

        // Ambil data dari form
        const dataForm = new FormData();
        dataForm.append("kodeproduk", $("#editkodeproduk").val());
        dataForm.append("nama", $("#editnama").val());
        dataForm.append("berat", $("#editberat").val());
        dataForm.append("karat", $("#editkarat").val());
        dataForm.append("hargajual", $("#edithargajual").val());
        dataForm.append("hargabeli", $("#edithargabeli").val());
        dataForm.append("jenis_id", $("#editjenis").val());
        dataForm.append("keterangan", $("#editketerangan").val());
        dataForm.append("status", $("#editstatus").val());
        dataForm.append("_token", $('meta[name="csrf-token"]').attr("content")); // CSRF Token Laravel

        const avatar = $("#editImage")[0].files[0]; // Ambil gambar jika ada
        if (avatar) {
            dataForm.append("avatar", avatar);
        }

        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: `/produk/${$("#editkodeproduk").val()}`, // URL untuk mengupdate data pegawai
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
                $("#formEditProduk")[0].reset(); // Reset form
                loadProduk();
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
                            );
                            loadProduk();
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
});
