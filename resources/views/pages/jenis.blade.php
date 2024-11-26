@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR JENIS PRODUK</h4>
                        <h6>Halaman Jenis Produk</h6>
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
                    <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#tambahJenis"><i
                            data-feather="plus-circle" class="me-2"></i>TAMBAH JENIS</a>
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
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenis as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>
                                            <div class="productimgname">
                                                <a href="javascript:void(0);" class="product-img stock-img">
                                                    @if ($item->icon != null)
                                                        <img src="{{ asset('storage/icon/' . $item->icon) }}"
                                                            alt="avatar">
                                                    @else
                                                        <img src="{{ asset('assets') }}/img/notfound.png" alt="avatar">
                                                    @endif
                                                </a>
                                                <a href="javascript:void(0);">{{ $item->jenis }} </a>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge badge-md bg-success"> Active</span>
                                            @else
                                                <span class="badge badge-md bg-danger"> InActive</span>
                                            @endif
                                        </td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 edit-icon  p-2" data-bs-effect="effect-sign"
                                                    data-bs-toggle="modal" href="#modaldetail{{ $item->id }}">
                                                    <i data-feather="eye" class="feather-eye"></i>
                                                </a>
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

                                    <div class="modal fade" id="modaldetail{{ $item->id }}">
                                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Detail Jenis Produk</h4><button
                                                        aria-label="Close" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label">Jenis Produk</label>
                                                            <input type="text" value="{{ $item->jenis }}"
                                                                class="form-control" readonly>
                                                        </div>
                                                        <div class=" mb-3">
                                                            <div class="new-employee-field">
                                                                <label class="form-label">Icon</label>
                                                                <div class="profile-pic-upload">
                                                                    <div class="profile-pic active-profile">
                                                                        @if ($item->icon != null)
                                                                            <img src="{{ asset('storage/icon/' . $item->icon) }}"
                                                                                alt="avatar">
                                                                        @else
                                                                            <img src="{{ asset('assets') }}/img/notfound.jpg"
                                                                                alt="avatar">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            @if ($item->status == 1)
                                                                <input type="text" value="Aktif" class="form-control"
                                                                    readonly>
                                                            @else
                                                                <input type="text" value="Tidak Aktif"
                                                                    class="form-control" readonly>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-cancel"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EDIT JENIS PRODUK -->
                                    <div class="modal fade" id="modaledit{{ $item->id }}">
                                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Jenis Produk</h4><button
                                                        aria-label="Close" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="jenis/{{ $item->id }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label">Jenis Produk</label>
                                                            <input type="text" name="jenis"
                                                                value="{{ $item->jenis }}" class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="new-employee-field">
                                                                <label class="form-label">Icon</label>
                                                                <div class="profile-pic-upload">
                                                                    <div class="profile-pic active-profile preview2"
                                                                        id="preview2">
                                                                        @if ($item->icon != null)
                                                                            <img src="{{ asset('storage/icon/' . $item->icon) }}"
                                                                                alt="avatar">
                                                                        @else
                                                                            <img src="{{ asset('assets') }}/img/notfound.jpg"
                                                                                alt="avatar">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <input type="file" class="form-control" name="icon"
                                                                    id="image2">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select class="select" name="status">
                                                                <option>Pilih Status</option>
                                                                <option value="1"
                                                                    @if ($item->status == 1) selected="selected" @endif>
                                                                    Aktif</option>
                                                                <option value="2"
                                                                    @if ($item->status == 2) selected="selected" @endif>
                                                                    Tidak Aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-cancel"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

    <!-- Add Jenis -->
    <div class="modal fade" id="tambahJenis">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Jenis</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="jenis" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">Jenis Produk</label>
                            <input type="text" name="jenis" class="form-control">
                        </div>
                        <div class="new-employee-field">
                            <label class="form-label">Avatar</label>
                            <div class="profile-pic-upload">
                                <div class="profile-pic active-profile preview" id="preview">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon</label>
                            <div class="col-md-12">
                                <input id="image" type="file" class="form-control" name="icon">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="select" name="status">
                                <option>Pilih Status</option>
                                <option value="1"> Aktif</option>
                                <option value="2"> Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Jenis -->

    <script>
        const imgInput = document.getElementById('image')
        const previewImage = document.getElementById('preview')

        imgInput.addEventListener("change", () => {
            const file = imgInput.files[0]
            const reader = new FileReader;

            reader.addEventListener("load", () => {
                previewImage.innerHTML = ""
                const img = document.createElement("img")
                img.src = reader.result

                previewImage.appendChild(img)
            })

            reader.readAsDataURL(file)
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
                        fetch(`/jenis/${itemId}`, {
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
