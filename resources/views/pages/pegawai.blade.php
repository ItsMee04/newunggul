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
                        <a id="refreshButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                                data-feather="rotate-ccw" class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a href="#" class="btn btn-added btn-tambahPegawai"><i data-feather="plus-circle"
                            class="me-2"></i>TAMBAH PEGAWAI</a>
                </div>
            </div>
            <!-- /product list -->
            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new">
                    <div class="search-set mb-0">
                        <div class="total-employees">
                            <h6><i data-feather="users" class="feather-user"></i>Total Pegawai
                                <span id="totalPegawaiAktif"></span>
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
                <div class="row" id="daftarPegawai">
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT PEGAWAI -->
    <div class="modal fade" id="modaledit">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Pegawai</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditPegawai" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <input type="hidden" id="editid" class="form-control" readonly>
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" id="editnip" class="form-control" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" id="editnama" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kontak</label>
                                <input type="text" id="editkontak" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <select class="select" id="editjabatan">
                            </select>
                        </div>
                        <div class=" mb-3">
                            <div class="new-employee-field">
                                <label class="form-label">Avatar</label>
                                <div class="profile-pic-upload">
                                    <div class="profile-pic active-profile" id="editPreview">
                                        <img src="" alt="avatar">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control" name="avatar" id="editImage">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" id="editalamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="select" id="editstatus">
                                <option value="1">Aktif</option>
                                <option value="2">Tidak Aktif</option>
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

    <!-- Add Pegawai -->
    <div class="modal fade" id="mdTambahPegawai">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pegawai</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="storePegawai" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Kontak</label>
                                    <input type="text" name="kontak" id="kontak" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <select class="select" name="jabatan" id="jabatan">

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
                                <input id="image" type="file" class="form-control" name="image">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="select" name="status" id="status">
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
    <script src="{{ asset('js') }}/pegawai.js" type="text/javascript"></script>
@endsection
