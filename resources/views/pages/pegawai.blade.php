@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR PEGAWAI</h4>
                        <h6>Halaman Pegawai</h6>
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
                    <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#tambahPegawai"><i
                            data-feather="plus-circle" class="me-2"></i>TAMBAH PEGAWAI</a>
                </div>
            </div>
            <!-- /product list -->
            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new">
                    <div class="search-set mb-0">
                        <div class="total-employees">
                            <h6><i data-feather="users" class="feather-user"></i>Total Pegawai
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
            <!-- /product list -->


            <div class="employee-grid-widget">
                <div class="row">
                    @foreach ($pegawai as $item)
                        <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 employee-item" data-name="{{ $item->nama }}"
                            data-nip="{{ $item->nip }}" data-jabatan="{{ $item->jabatan->jabatan }}">
                            <div class="employee-grid-profile">
                                <div class="profile-head">
                                    <label class="checkboxs">
                                        <span class="checkmarks"></span>
                                    </label>
                                    <div class="profile-head-action">
                                        @if ($item->status == 1)
                                            <span class="badge badge-linesuccess text-center w-auto me-1">Active</span>
                                        @else
                                            <span class="badge badge-linedanger text-center w-auto me-1">InActive</span>
                                        @endif
                                        <div class="dropdown profile-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false"><i data-feather="more-vertical"
                                                    class="feather-user"></i></a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a data-bs-effect="effect-sign" data-bs-toggle="modal"
                                                        href="#modaledit{{ $item->id }}" class="dropdown-item"><i
                                                            data-feather="edit" class="info-img"></i>Edit</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item confirm-text mb-0"
                                                        data-item-id="{{ $item->id }}">
                                                        <i data-feather="trash-2" class="info-img"></i>Delete
                                                    </a>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-info">
                                    <div class="profile-pic profile">
                                        @if ($item->image != null)
                                            <img src="{{ asset('storage/avatar/' . $item->image) }}" alt="avatar">
                                        @else
                                            <img src="{{ asset('assets') }}/img/notfound.png" alt="avatar">
                                        @endif
                                    </div>
                                    <h5>NIP : {{ $item->nip }}</h5>
                                    <h4>{{ $item->nama }}</h4>
                                    <span>{{ $item->jabatan->jabatan }}</span>
                                </div>
                                <ul class="department">
                                    <li>
                                        Kontak
                                        <span>{{ $item->kontak }}</span>
                                    </li>
                                    <li>
                                        Alamat
                                        <span>{{ $item->alamat }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- EDIT PEGAWAI -->
                        <div class="modal fade" id="modaledit{{ $item->id }}">
                            <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Pegawai</h4><button aria-label="Close"
                                            class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="pegawai/{{ $item->id }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label">NIP</label>
                                                <input type="text" name="nip" value="{{ $item->nip }}"
                                                    class="form-control" readonly>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="nama" value="{{ $item->nama }}"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Kontak</label>
                                                    <input type="text" name="kontak" value="{{ $item->kontak }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jabatan</label>
                                                <select class="select" name="jabatan">
                                                    <option>Pilih Jabatan</option>
                                                    @foreach ($jabatan as $itemjabatan)
                                                        <option value="{{ $itemjabatan->id }}"
                                                            @if ($item->jabatan_id == $itemjabatan->id) selected="selected" @endif>
                                                            {{ $itemjabatan->jabatan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class=" mb-3">
                                                <div class="new-employee-field">
                                                    <label class="form-label">Avatar</label>
                                                    <div class="profile-pic-upload">
                                                        <div class="profile-pic active-profile preview2"
                                                            data-target="preview2-{{ $item->id }}">
                                                            @if ($item->image != null)
                                                                <img src="{{ asset('storage/Avatar/' . $item->image) }}"
                                                                    alt="avatar">
                                                            @else
                                                                <img src="{{ asset('assets') }}/img/notfound.png"
                                                                    alt="avatar">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="file" class="form-control" name="avatar"
                                                        id="image2-{{ $item->id }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Alamat</label>
                                                <textarea class="form-control" name="alamat">{{ $item->alamat }}</textarea>
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

    <!-- Add Pegawai -->
    <div class="modal fade" id="tambahPegawai">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pegawai</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="pegawai" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Kontak</label>
                                    <input type="text" name="kontak" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <select class="select" name="jabatan">
                                <option>Pilih Jabatan</option>
                                @foreach ($jabatan as $itemjabatan)
                                    <option value="{{ $itemjabatan->id }}">{{ $itemjabatan->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="new-employee-field">
                            <label class="form-label">Avatar</label>
                            <div class="profile-pic-upload">
                                <div class="profile-pic active-profile preview" id="preview">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Avatar</label>
                            <div class="col-md-12">
                                <input id="image" type="file" class="form-control" name="avatar">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat"></textarea>
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
    <!-- /Add Pegawai -->

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const employeeItems = document.querySelectorAll('.employee-item');

                employeeItems.forEach(item => {
                    const name = item.getAttribute('data-name').toLowerCase();
                    const nip = item.getAttribute('data-nip').toLowerCase();
                    const jabatan = item.getAttribute('data-jabatan').toLowerCase();

                    // Check if search value matches any attribute
                    if (name.includes(searchValue) || nip.includes(searchValue) || jabatan.includes(
                            searchValue)) {
                        item.style.display = ''; // Show
                    } else {
                        item.style.display = 'none'; // Hide
                    }
                });
            });

            //ini saat input
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
            //ini saat input
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
                        fetch(`/pegawai/${itemId}`, {
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
