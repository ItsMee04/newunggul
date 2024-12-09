$(document).ready(function () {
    loadProduk();

    $(document).on("click", "#refreshButton", function () {
        loadProduk(); // Panggil fungsi untuk memuat ulang data pegawai
        const successtoastExample = document.getElementById("successToast");
        const toast = new bootstrap.Toast(successtoastExample);
        $(".toast-body").text("Data Pegawai Berhasil Direfresh");
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
                        ? `/storage/Produk/${item.image
                        }?t=${new Date().getTime()}`
                        : `/assets/img/notfound.png`;

                        const formatter = new Intl.NumberFormat("id-ID", {
                            style:"currency",
                            currency: "IDR",
                            minimumFractionDigits:0
                        });

                        const hargaJual = formatter.format(item.harga_jual)

                    $("#daftarProduk").append(`
                        <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3 produk-item" data-name="${item.nama }"
                                    data-harga="${item.harga_jual }" data-berat="${ item.berat }"
                                    data-kode="${ item.kodeproduk }">
                                    <div class="product-info default-cover card">
                                        <div class="dropdown ms-auto pb-3">
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                                data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="downloadBarcode/${ item.id }">
                                                        Download Barcode
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="downloadBarcode/${ item.id }">
                                                        Stream Barcode
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" data-bs-effect="effect-sign"
                                                        data-bs-toggle="modal" href="#modaledit{{ $item->id }}">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item confirm-text" data-item-id="{{ $item->id }}"
                                                        href="javascript:void(0);"> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <a href="javascript:void(0);" class="img-bg">
                                        <img src="${imageSrc}" width="100px" height="100px" alt="Products">
                                        </a>
                                        <h6 class="cat-name text-center"><a
                                                href="javascript:void(0);">${ item.jenis.jenis }</a>
                                        </h6>
                                        <h6 class="product-name text-center"><a
                                                href="javascript:void(0);">${ item.nama }</a></h6>
                                        <div class="d-flex align-items-center justify-content-between price">
                                            <span>
                                                <strong>
                                                    Berat :${ item.berat } </br> Karat :${ item.karat }
                                                </strong>
                                            </span>
                                            <p>
                                                <strong>
                                                    Harga : ${ hargaJual }
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
