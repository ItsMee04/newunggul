@extends('layouts.app')
@section('content')
    <div class="page-wrapper notes-page-wrapper">
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
                    <a href="#" class="btn btn-added btn-tambahJenis"><i data-feather="plus-circle"
                            class="me-2"></i>TAMBAH JENIS</a>
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
                        <table class="table jenisTable table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

    <!-- Add Jenis -->
    <div class="modal fade" id="mdTambahjenis">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">TAMBAH JENIS</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="storeJenis" method="POST" enctype="multipart/form-data">
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

    <!-- Edit Jenis -->
    <div class="modal fade" id="modaledit">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">TAMBAH JENIS</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditJenis" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <input type="hidden" name="jenis" class="form-control" id="editid">
                        <div class="mb-3">
                            <label class="form-label">Jenis Produk</label>
                            <input type="text" name="jenis" class="form-control" id="editjenis">
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
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Jenis -->

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/jenis.js" type="text/javascript"></script>
@endsection
