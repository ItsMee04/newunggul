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

            <!-- Always responsive -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card-body pb-0">

                    </div>
                    <div class="card">
                        <div class="card-header justify-content-between">
                            <div class="table-top table-top-two table-top-new">
                                <div class="search-set mb-0">
                                    <div class="total-employees">
                                        <h6><i data-feather="tag" class="feather-user"></i>Total Jenis
                                            <span id="totalJenisAktif"></span>
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
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>

                                            <th scope="col">Jenis</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="daftarJenis">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Always responsive -->
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

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/jenis.js" type="text/javascript"></script>
@endsection
