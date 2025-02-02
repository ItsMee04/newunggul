@extends('layouts.app')
@section('content')
    <div class="page-wrapper pos-pg-wrapper">
        <div class="content pos-design p-0">
            <div class="row align-items-start pos-wrapper">
                <div class="col-md-12 col-lg-8">
                    <div class="pos-categories tabs_wrapper">
                        <h5>Nampan Perhiasan</h5>
                        <p>Pilih Dari Nampan Di Bawah Ini</p>
                        <ul class="tabs owl-carousel pos-category">
                            <li class="active" id="all">
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('assets') }}/img/categories/category-01.png" alt="Categories">
                                </a>
                                <h6><a href="javascript:void(0);">All Categories</a></h6>
                                <span>{{ $produk->where('status', 1)->count() }}</span>
                            </li>
                            @foreach ($nampan as $item)
                                <li id="{{ $item->id }}">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('storage/Icon/' . $item->jenis->icon) }}" alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">{{ $item->nampan }}</a></h6>
                                    <span>{{ $nampanProduk->where('nampan_id', $item->id)->count() }} Item</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="pos-products">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-3">Produk</h5>
                            </div>
                            <div class="tabs_container">
                                <div class="row" id="daftarProduk">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 ps-0">
                    <aside class="product-order-list">
                        <div class="head d-flex align-items-center justify-content-between w-100">
                            <div class>
                                <h5>Order List</h5>
                                <span>Transaction ID : <b id="transaksi_id"></b></span>
                            </div>
                        </div>
                        <div class="customer-info block-section">
                            <h6>Customer Information</h6>
                            <div class="input-block d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <select class="select" id="pelanggan" name="pelanggan">
                                        <option>Walk in Customer</option>
                                        @foreach ($pelanggan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <a href="#" class="btn btn-primary btn-icon" data-bs-toggle="modal"
                                    data-bs-target="#tambahPelanggan"><i data-feather="user-plus"
                                        class="feather-16"></i></a>
                            </div>
                        </div>
                        <div class="product-added block-section">
                            <div class="head-text d-flex align-items-center justify-content-between">
                                <h6 class="d-flex align-items-center mb-0">Product Added<span class="count"
                                        id="produkCount"></span>
                                </h6>
                                <a href="javascript:void(0);"
                                    class="d-flex align-items-center confirm-deleteAll text-danger"><span class="me-1"><i
                                            data-feather="x" class="feather-16"></i></span class="deleteAll">Clear all
                                </a>
                            </div>
                            <div class="product-wrap" id="keranjang">
                            </div>
                        </div>
                        <div class="block-section">
                            <div class="selling-info">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-block">
                                            <label>Discount</label>
                                            <select class="select" id="pilihDiskon" name="diskon">
                                                <option value="zero" selected>Pilih Diskon</option>
                                                @foreach ($diskon as $item)
                                                    <option value="{{ $item->diskon }}"> {{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-total">
                                <table class="table table-responsive table-borderless">
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-end" id="totalhargabarang">0</td>
                                    </tr>
                                    <tr>
                                        <td class="danger">Discount (<span id="discount"></span> %)</td>
                                        <td class="danger text-end" id="hargadiskon"></td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-end" id="total"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="d-grid btn-block">
                            <a class="btn btn-secondary" href="javascript:void(0);">
                                <span class="danger text-end" id="grandtotal">0</span>
                            </a>
                        </div>
                        <div class="btn-row d-sm-flex align-items-center justify-content-between">
                            <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill" id="checkout"><span
                                    class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                        class="feather-16"></i></span>Checkout</a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahPelanggan">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pelanggan</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="pelanggan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control">
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
    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/pos.js" type="text/javascript"></script>
@endsection
