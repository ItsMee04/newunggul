@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title me-auto">
                    <h4>DAFTAR PRODUK PERBAIKAN</h4>
                    <h6>Halaman Produk perbaikan</h6>
                </div>
                <ul class="table-top-head low-stock-top-head">
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                                class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
            </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    <div class="tabs-set">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="kusam-tab" data-bs-toggle="tab" data-bs-target="#kusam"
                                    type="button" role="tab" aria-controls="kusam" aria-selected="true">Produk
                                    Kusam</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="rusak-tab" data-bs-toggle="tab" data-bs-target="#rusak"
                                    type="button" role="tab" aria-controls="rusak" aria-selected="false">Produk
                                    Rusak</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="kusam" role="tabpanel"
                                aria-labelledby="kusam-tab">
                                <div class="table-top">
                                    <div class="search-set">
                                        <div class="search-input">
                                            <a href="" class="btn btn-searchset"><i data-feather="search"
                                                    class="feather-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table kusamTable table-hover" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kode Produk</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="rusak" role="tabpanel" aria-labelledby="rusak-tab">
                                <div class="table-top">
                                    <div class="search-set">
                                        <div class="search-input">
                                            <a href="" class="btn btn-searchset"><i data-feather="search"
                                                    class="feather-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table rusakTable table-hover" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kode Produk</th>
                                                <th>Keterangan</th>
                                                <th>Status</th>
                                                <th>Discount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/perbaikan.js" type="text/javascript"></script>
@endsection
