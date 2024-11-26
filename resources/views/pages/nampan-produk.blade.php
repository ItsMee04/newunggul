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
                    <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#tambahNampan"><i
                            data-feather="plus-circle" class="me-2"></i>TAMBAH NAMPAN / BAKI</a>
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

    <script>
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
