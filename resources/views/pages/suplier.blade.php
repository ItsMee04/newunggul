@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR SUPLIER</h4>
                        <h6>Halaman Suplier</h6>
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
                    <a class="btn btn-added btn-tambahSuplier"><i data-feather="plus-circle" class="me-2"></i>TAMBAH
                        SUPLIER</a>
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
                        <table class="table suplierTabel table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Supplier</th>
                                    <th>Nama</th>
                                    <th>Kontak</th>
                                    <th>alamat</th>
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

    <div class="modal fade" id="mdtambahSuplier">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Supplier</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="storeSuplier" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="suplier" id="suplier" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" id="kontak" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat"></textarea>
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

    <!-- EDIT SUPPLIER -->
    <div class="modal fade" id="modaledit">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Supplier</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditSuplier" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">ID</label>
                            <input type="text" name="id" id="editid" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Supplier</label>
                            <input type="text" name="kodesupplier" id="editkodesuplier" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="suplier" id="editsuplier" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" id="editkontak" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" id="editalamat"></textarea>
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
    <script src="{{ asset('js') }}/suplier.js" type="text/javascript"></script>
@endsection
