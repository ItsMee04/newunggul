@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR PRODUK {{ $nampan->nampan }}</h4>
                        <h6>Halaman Produk {{ $nampan->nampan }}</h6>
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
                    <a class="btn btn-added btn-tambahProduk"><i data-feather="plus-circle" class="me-2"></i>TAMBAH
                        PRODUK</a>
                </div>
                <div class="page-btn import">
                    <a onclick="history.back();" class="btn btn-added btn-secondary" data-bs-toggle="modal"
                        data-bs-target="#view-notes"><i data-feather="chevrons-left" class="me-2"></i> Kembali Ke
                        Nampan</a>
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
                        <table class="table tabelNampanProduk table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Produk</th>
                                    <th>Nama</th>
                                    <th>Berat</th>
                                    <th>Karat</th>
                                    <th>Harga</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($nampanProduk as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>{{ $item->produk->kodeproduk }} </td>
                                        <td>
                                            <div class="productimgname">
                                                <a href="javascript:void(0);" class="product-img stock-img">
                                                    @if ($item->produk->image != null)
                                                        <img src="{{ asset('storage/produk/' . $item->produk->image) }}"
                                                            alt="avatar">
                                                    @else
                                                        <img src="{{ asset('assets') }}/img/notfound.png" alt="avatar">
                                                    @endif
                                                </a>
                                                <a href="javascript:void(0);">{{ $item->produk->nama }} </a>
                                            </div>
                                        </td>
                                        <td>{{ $item->produk->berat }} </td>
                                        <td>{{ $item->produk->karat }}</td>
                                        <td>{{ 'Rp.' . ' ' . number_format($item->produk->harga_jual) }}</td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2 confirm-text" href="javascript:void(0);"
                                                    data-item-id="{{ $item->id }}">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

    <div class="modal fade" id="mdTambahProduk">
        <div class="modal-dialog modal-lg modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Produk</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form id="storeTambahProdukNampan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="table-responsive product-list">
                            <table class="table ProdukNampan" style="width: 100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th class="no-sort">
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>No.</th>
                                        <th>Kode Produk</th>
                                        <th>Nama</th>
                                        <th>Berat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
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

    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/nampanProduk.js" type="text/javascript"></script>
@endsection
