@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR PRODUK</h4>
                        <h6>Halaman Produk</h6>
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
            </div>

            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new">
                    <div class="search-set mb-0">
                        <div class="total-employees">
                            <h6><i data-feather="shopping-bag" class="feather-user"></i>Total Produk
                                <span>{{ $count }}</span>
                            </h6>
                        </div>
                        <div class="search-input">
                            <a href="#" class="btn btn-searchset"><i data-feather="search"
                                    class="feather-search"></i></a>
                            <input type="search" id="searchInput" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pos-products">
                <div class="tabs_container">
                    <div class="tab_content">
                        <div class="row">
                            @foreach ($produk as $item)
                                <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3 produk-item" data-name="{{ $item->nama }}"
                                    data-harga="{{ $item->harga }}" data-berat="{{ $item->berat }}"
                                    data-kode="{{ $item->kodeproduk }}">
                                    <div class="product-info default-cover card">
                                        <div class="dropdown ms-auto pb-3">
                                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                                data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="downloadBarcode/{{ $item->id }}">
                                                        Download Barcode
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="downloadBarcode/{{ $item->id }}">
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
                                            <img src="{{ asset('storage/Produk/' . $item->image) }}" width="100px"
                                                height="100px" alt="Products">
                                        </a>
                                        <h6 class="cat-name text-center"><a
                                                href="javascript:void(0);">{{ $item->jenis->jenis }}</a>
                                        </h6>
                                        <h6 class="product-name text-center"><a
                                                href="javascript:void(0);">{{ $item->nama }}</a></h6>
                                        <div class="d-flex align-items-center justify-content-between price">
                                            <span>
                                                <strong>
                                                    Berat :{{ $item->berat }} </br> Karat :{{ $item->karat }}
                                                </strong>
                                            </span>
                                            <p>
                                                <strong>
                                                    Harga : {{ 'Rp.' . ' ' . number_format($item->harga_jual) }}
                                                </strong>
                                            </p>
                                        </div>

                                    </div>
                                </div>

                                <div class="modal fade" id="modaledit{{ $item->id }}">
                                    <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                        <div class="modal-content modal-content-demo">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Produk</h4><button aria-label="Close"
                                                    class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="/produk/{{ $item->id }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body text-start">
                                                    <div class="mb-3">
                                                        <label class="form-label">Kode Produk</label>
                                                        <input type="text" value="{{ $item->kodeproduk }}"
                                                            class="form-control" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" value="{{ $item->nama }}"
                                                            class="form-control" name="nama">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Berat</label>
                                                            <input type="text" value="{{ $item->berat }}"
                                                                class="form-control" name="berat">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Karat</label>
                                                            <input type="text" value="{{ $item->karat }}"
                                                                class="form-control" name="karat">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Harga Jual</label>
                                                            <input type="text" value="{{ $item->harga_jual }}"
                                                                class="form-control" name="hargajual">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Harga Beli</label>
                                                            <input type="text" value="{{ $item->harga_beli }}"
                                                                class="form-control" name="hargabeli">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Jenis</label>
                                                        <select class="select" name="jenis_id">
                                                            <option>Pilih Jenis</option>
                                                            @foreach ($jenis as $itemjenis)
                                                                <option value="{{ $item->id }}"
                                                                    @if ($item->jenis_id == $itemjenis->id) selected="selected" @endif>
                                                                    {{ $itemjenis->jenis }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Keterangan</label>
                                                        <textarea class="form-control" name="keterangan">{{ $item->keterangan }}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="new-employee-field">
                                                                <label class="form-label">Image</label>
                                                                <div class="profile-pic-upload">
                                                                    <div class="profile-pic active-profile preview2"
                                                                        id="preview2">
                                                                        @if ($item->image != null)
                                                                            <img src="{{ asset('storage/Produk/' . $item->image) }}"
                                                                                alt="avatar">
                                                                        @else
                                                                            <img src="{{ asset('assets') }}/img/notfound.jpg"
                                                                                alt="avatar">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="new-employee-field">
                                                                <label class="form-label">Barcode</label>
                                                                <div class="profile-pic-upload">
                                                                    <div class="profile-pic active-profile preview2"
                                                                        id="preview2">
                                                                        @if ($item->image != null)
                                                                            <img src="{{ asset('storage/Barcode/' . $item->image) }}"
                                                                                alt="avatar">
                                                                        @else
                                                                            <img src="{{ asset('assets') }}/img/notfound.jpg"
                                                                                alt="avatar">
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class=" mb-3">
                                                            <div class="mb-3">
                                                                <input type="file" class="form-control"
                                                                    name="image_file" id="image2">
                                                            </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Pegawai -->
    <div class="modal fade" id="tambahProduk">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Produk</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="/produk" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Berat</label>
                                <input type="text" name="berat" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Karat</label>
                                <input type="text" name="karat" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Harga Jual</label>
                                <input type="text" name="hargajual" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Harga Beli</label>
                                <input type="text" name="hargabeli" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis</label>
                            <select class="select" name="jenis_id">
                                <option>Pilih Jenis</option>
                                @foreach ($jenis as $item)
                                    <option value="{{ $item->id }}"> {{ $item->jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" rows="4" name="keterangan"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6 new-employee-field">
                                <label class="form-label">Image</label>
                                <div class="profile-pic-upload">
                                    <div class="profile-pic active-profile preview" id="preview">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Image</label>
                                <div class="col-md-12">
                                    <input id="image" type="file" class="form-control" name="image_file">
                                </div>
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
                        <button type="submit" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Pegawai -->

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
        })

        document.getElementById('searchInput').addEventListener('input', function() {
            const searchValue = this.value.toLowerCase();
            const employeeItems = document.querySelectorAll('.produk-item');

            employeeItems.forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                const harga = item.getAttribute('data-harga').toLowerCase();
                const berat = item.getAttribute('data-berat').toLowerCase();
                const kode = item.getAttribute('data-kode').toLowerCase();

                // Check if search value matches any attribute
                if (name.includes(searchValue) || harga.includes(searchValue) || berat.includes(
                        searchValue) || kode.includes(searchValue)) {
                    item.style.display = ''; // Show
                } else {
                    item.style.display = 'none'; // Hide
                }
            });
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
                        fetch(`/produk/${itemId}`, {
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
