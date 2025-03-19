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
                        <a id="refreshButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                                data-feather="rotate-ccw" class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a href="#" class="btn btn-added btn-tambahProduk"><i data-feather="plus-circle"
                            class="me-2"></i>TAMBAH
                        PRODUK</a>
                </div>
            </div>

            <div class="card-body pb-0">
                <div class="table-top table-top-two table-top-new">
                    <div class="search-set mb-0">
                        <div class="total-employees">
                            <h6><i data-feather="users" class="feather-user"></i>Total Produk
                                <span id="totalProdukAktif"></span>
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
                        <div class="row" id="daftarProduk">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Pegawai -->
    <div class="modal fade" id="mdTambahProduk">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Produk</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="storeProduk" method="POST" enctype="multipart/form-data">
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
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Jenis</label>
                                <select class="select" name="jenis_id" id="jenis">

                                </select>
                            </div>

                            <div class="col-6 mb-3">
                                <label class="form-label">Kondisi</label>
                                <select class="select" name="kondisi_id" id="kondisi">

                                </select>
                            </div>
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

    <div class="modal fade" id="modaledit">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Produk</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditProduk" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">Kode Produk</label>
                            <input type="text" id="editkodeproduk" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" id="editnama" class="form-control" name="nama">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Berat</label>
                                <input type="text" id="editberat" class="form-control" name="berat">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Karat</label>
                                <input type="text" id="editkarat" class="form-control" name="karat">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Jual</label>
                                <input type="text" id="edithargajual" class="form-control" name="hargajual">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Beli</label>
                                <input type="text" id="edithargabeli" class="form-control" name="hargabeli">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis</label>
                                <select class="select" name="jenis_id" id="editjenis">
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kondisi</label>
                                <select class="select" name="kondisi_id" id="editkondisi">
                                </select>
                            </div>
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

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/produk.js" type="text/javascript"></script>
@endsection
