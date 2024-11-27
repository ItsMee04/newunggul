@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR PRODUK {{ $nampan->nampan }}</h4>
                        <h6>Halaman Produk {{ $nampan->nampan }}</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                                class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#tambahProduk"><i
                            data-feather="plus-circle" class="me-2"></i>TAMBAH PRODUK</a>
                </div>
                <div class="page-btn import">
                    <a href="#" onclick="history.back();" class="btn btn-added btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#view-notes"><i data-feather="chevrons-left" class="me-2"></i> Kembali Ke
                        Nampan</a>
                </div>
            </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a href="javascript:void(0);" class="btn btn-searchset"><i data-feather="search"
                                        class="feather-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- /Filter -->
                    <div class="card mb-0" id="filter_inputs">
                        <div class="card-body pb-0">
                        </div>
                    </div>
                    <!-- /Filter -->
                    <div class="table-responsive product-list">
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Produk</th>
                                    <th>Nama</th>
                                    <th>Berat</th>
                                    <th>Karat</th>
                                    <th>Harga</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nampanProduk as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $item->produk->kodeproduk }} </td>
                                        <td>
                                            <div class="productimgname">
                                                <a href="javascript:void(0);" class="product-img stock-img">
                                                    @if ($item->produk->image != null)
                                                        <img src="{{ asset('storage/produk/' . $item->produk->image) }}"
                                                            alt="avatar">
                                                    @else
                                                        <img src="{{ asset('assets') }}/img/notfound.png" alt="avatar">
                                                    @endif
                                                </a>
                                                <a href="javascript:void(0);">{{ $item->produk->nama }} </a>
                                            </div>
                                        </td>
                                        <td>{{ $item->produk->berat }} </td>
                                        <td>{{ $item->produk->karat }}</td>
                                        <td>{{ $item->produk->harga_jual }}</td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2" data-bs-effect="effect-sign" data-bs-toggle="modal"
                                                    href="#modaledit{{ $item->id }}">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a class="me-2 p-2 confirm-text" href="javascript:void(0);"
                                                    data-item-id="{{ $item->id }}">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

    <div class="modal fade" id="tambahProduk">
        <div class="modal-dialog modal-lg modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Produk</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="/produk-nampan/{{ $nampan->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="table-responsive">
                            <input type="text" id="searchInput" class="form-control col-md-3"
                                placeholder="Search for names...">
                            <table class="table datanew" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>No.</th>
                                        <th>Kode Produk</th>
                                        <th>Nama</th>
                                        <th>Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk as $item)
                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox" name="items[]" value="{{ $item->id }}">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td><span>{{ $item->kodeproduk }}</span></td>
                                            <td>
                                                <div class="productimgname">
                                                    <a href="javascript:void(0);" class="product-img stock-img">
                                                        <img src="{{ asset('storage/produk/' . $item->image) }}"
                                                            alt="product">
                                                    </a>
                                                    <a href="javascript:void(0);">{{ $item->nama }}</a>
                                                </div>
                                            </td>
                                            <td>{{ $item->berat }} / grams</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Ambil input pencarian dan tabel
        var input = document.getElementById("searchInput");
        var table = document.getElementById("myTable");
        var rows = table.getElementsByTagName("tr");

        // Fungsi pencarian
        input.addEventListener("keyup", function() {
            var filter = input.value.toUpperCase();

            // Loop melalui semua baris dan sembunyikan yang tidak sesuai dengan pencarian
            for (var i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var match = false;

                // Cek apakah ada teks yang sesuai dalam baris
                for (var j = 0; j < cells.length; j++) {
                    var cellValue = cells[j].textContent || cells[j].innerText;
                    if (cellValue.toUpperCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }

                // Sembunyikan baris jika tidak ada kecocokan
                rows[i].style.display = match ? "" : "none";
            }
        });

        document.querySelectorAll('.confirm-text').forEach(function(deleteButton) {
            deleteButton.addEventListener('click', function() {
                const itemId = this.getAttribute('data-item-id'); // Ambil ID item dari data-item-id

                // SweetAlert2 untuk konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan hapus (gunakan itemId)
                        fetch(`/delete-nampan/${itemId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pastikan token CSRF disertakan
                                }
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire('Dihapus!', 'Data berhasil dihapus.', 'success')
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire('Gagal!',
                                        'Terjadi kesalahan saat menghapus data.', 'error');
                                }
                            })
                            .catch(error => {
                                Swal.fire('Gagal!', 'Terjadi kesalahan dalam penghapusan data.',
                                    'error');
                            });
                    } else {
                        // Jika batal, beri tahu pengguna
                        Swal.fire(
                            'Dibatalkan',
                            'Data tidak dihapus.',
                            'info'
                        );
                    }
                });
            });
        });
    </script>
@endsection
