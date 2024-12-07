$(document).ready(function () {
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

    // Datatable
    if ($("#jenisTable").length > 0) {
        $("#jenisTable").DataTable({
            ajax: {
                url: "/jenis/getJenis", // API endpoint untuk mengambil data jenis
                dataSrc: "Data", // Menyesuaikan dengan respons JSON
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Menampilkan nomor urut
                    },
                },
                { data: "jenis" }, // Menampilkan nama jenis
                {
                    data: "status",
                    render: function (data) {
                        return data ? "Aktif" : "Tidak Aktif"; // Menampilkan status aktif/tidak
                    },
                },
                {
                    data: null,
                    render: function (data, type, row, meta) {
                        return `
                        <td class="action-table-data">
                            <div class="edit-delete-action">
                                <a class="me-2 edit-icon p-2" data="${data.id}">
                                    <i data-feather="eye" class="feather-eye"></i>
                                </a>
                                <a class="me-2 p-2" href="edit-product.html">
                                    <i data-feather="edit" class="feather-edit"></i>
                                </a>
                                <a class="confirm-text p-2" href="javascript:void(0);" data-id="${data.id}" class="btnDelete">
                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                </a>
                            </div>
                        </td>
                    `;
                    },
                },
            ],
            bFilter: true,
            sDom: "fBtlpi",
            ordering: true,
            language: {
                search: " ",
                sLengthMenu: "_MENU_",
                searchPlaceholder: "Search",
                info: "_START_ - _END_ of _TOTAL_ items",
                paginate: {
                    next: ' <i class=" fa fa-angle-right"></i>',
                    previous: '<i class="fa fa-angle-left"></i> ',
                },
            },
            initComplete: (settings, json) => {
                $(".dataTables_filter").appendTo("#tableSearch");
                $(".dataTables_filter").appendTo(".search-input");
            },
        });
    }
});
