@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR DISKON</h4>
                        <h6>Halaman Diskon Promo</h6>
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
                    <a class="btn btn-added btn-tambahDiskon"><i data-feather="plus-circle" class="me-2"></i>TAMBAH
                        DISKON</a>
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
                        <table class="table tableDiskon table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Diskon</th>
                                    <th>Nilai Diskon</th>
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

    <div class="modal fade" id="mdtambahDiskon">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Diskon</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="storeDiskon" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">Nama Diskon</label>
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nilai Dison</label>
                            <input type="text" name="diskon" id="diskon" class="form-control">
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

    <!-- EDIT DISKON -->
    <div class="modal fade" id="modaledit">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Diskon</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditDiskon" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">ID</label>
                            <input type="text" name="nama" id="editid" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Diskon</label>
                            <input type="text" name="nama" id="editnama" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nilai Diskon</label>
                            <input type="text" name="diskon" id="editdiskon" class="form-control">
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
    <script src="{{ asset('js') }}/diskon.js" type="text/javascript"></script>
@endsection
