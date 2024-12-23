@extends('layouts.app')

@section('content')
    <!-- /Main Wrapper -->
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header transfer">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Daftar Pembelian Barang</h4>
                        <h6>Halaman Pembelian Barang</h6>
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
                    <a class="btn btn-added btn-formTambahPembelian" id="toggleFormBtn"><i data-feather="plus-circle"
                            class="me-2"></i>TAMBAH
                        PEMBELIAN</a>
                </div>
            </div>

            <div class="card" id="formContainer" style="display: none">
                <div class="card-body add-product pb-0">
                    <form method="POST" enctype="multipart/form-data" id="storePembelian">
                        @csrf
                        <div class="modal-body text-start">
                            <div class="input-blocks add-products">
                                <label class="d-block">Pembelian Dari</label>
                                <div class="single-pill-product mb-3">
                                    <ul class="nav nav-pills" id="pills-tab1" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <span class="custom_radio me-4 mb-0 active" id="pills-home-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-home" role="tab"
                                                aria-controls="pills-home" aria-selected="true">
                                                <input type="radio" class="form-control" name="payment">
                                                <span class="checkmark"></span> Suplier</span>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <span class="custom_radio me-2 mb-0" id="pills-profile-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-profile" role="tab"
                                                aria-controls="pills-profile" aria-selected="false">
                                                <input type="radio" class="form-control" name="sign">
                                                <span class="checkmark"></span> Pelanggan</span>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <span class="custom_radio me-2 mb-0" id="pills-pembeli-tab"
                                                data-bs-toggle="pill" data-bs-target="#pills-pembeli" role="tab"
                                                aria-controls="pills-pembeli" aria-selected="false">
                                                <input type="radio" class="form-control" name="sign">
                                                <span class="checkmark"></span> Non Suplier / Pelanggan</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Suplier</label>
                                            <select class="select" name="suplier_id" id="suplier_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                        aria-labelledby="pills-profile-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Pelanggan</label>
                                            <select class="select" name="pelanggan_id" id="pelanggan_id">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-pembeli" role="tabpanel"
                                        aria-labelledby="pills-pembeli-tab">
                                        <div class="mb-3">
                                            <label class="form-label">Non Suplier / Pembeli</label>
                                            <input type="text" name="nonsuplierdanpembeli" id="nonsuplierdanpembeli"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body add-product pb-0">
                                            <div class="accordion-card-one accordion" id="accordionExample">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="headingOne">
                                                        <div class="accordion-button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseOne" aria-controls="collapseOne">
                                                            <div class="addproduct-icon">
                                                                <h5><i data-feather="info" class="add-info"></i><span>
                                                                        FORM
                                                                        TAMBAH PRODUK</span></h5>
                                                                <a href="javascript:void(0);"><i
                                                                        data-feather="chevron-down"
                                                                        class="chevron-down-add"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="collapseOne" class="accordion-collapse collapse"
                                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Produk</label>
                                                                <input type="text" name="nama" id="nama"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label">Berat</label>
                                                                    <input type="text" name="berat" id="berat"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label">Karat</label>
                                                                    <input type="text" name="karat" id="karat"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label">Jenis</label>
                                                                    <select class="select" name="jenis_id"
                                                                        id="jenis">
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <label class="form-label">Harga Beli</label>
                                                                    <input type="text" name="harga_beli"
                                                                        id="hargabeli" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Kondisi Fisik</label>
                                                                <select class="select" name="kondisi_id" id="kondisi">
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Keterangan</label>
                                                                <textarea class="form-control" rows="4" name="keterangan" id="keterangan"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-card-one accordion" id="accordionExample4">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="headingFour">
                                                        <div class="accordion-button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapseFour" aria-controls="collapseFour">
                                                            <div class="text-editor add-list">
                                                                <div class="addproduct-icon list">
                                                                    <h5><i data-feather="list"
                                                                            class="add-info"></i><span>PRODUK
                                                                            TABEL</span>
                                                                    </h5>
                                                                    <a href="javascript:void(0);"><i
                                                                            data-feather="chevron-down"
                                                                            class="chevron-down-add"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="collapseFour" class="accordion-collapse collapse"
                                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample4">
                                                        <div class="accordion-body">
                                                            <div class="table-top">
                                                                <div class="search-set">
                                                                    <div class="search-input">
                                                                        <a href="" class="btn btn-searchset"><i
                                                                                data-feather="search"
                                                                                class="feather-search"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="table-responsive product-list">
                                                                <table class="table datanew table-hover"
                                                                    style="width: 100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No.</th>
                                                                            <th>Nama Produk</th>
                                                                            <th>Berat </th>
                                                                            <th>Action</th>
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
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="select" name="status" id="status">
                                            <option>Pilih Status</option>
                                            <option value="1">Aktif</option>
                                            <option value="2">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Tambahan -->
                        </div>
                        <div class="footer">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- /product list -->
            <div class="card table-list-card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-input">
                                <a href="" class="btn btn-searchset"><i data-feather="search"
                                        class="feather-search"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- /Filter -->
                    <div class="card" id="filter_inputs">
                        <div class="card-body pb-0">
                        </div>
                    </div>
                    <!-- /Filter -->
                    <div class="table-responsive product-list">
                        <table class="table pembelianTable table-hover" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Pembelian</th>
                                    <th>Penjual</th>
                                    <th>Nama Produk</th>
                                    <th>Berat </th>
                                    <th>Tanggal </th>
                                    <th>Status </th>
                                    <th>Action</th>
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

    <!-- MODAL TAMBAH PEMBELIAN -->
    <div class="modal fade" id="mdtambahPembelian">
        <div class="modal-dialog modal-lg modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">TAMBAH PEMBELIAN</h4>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="storePembelian">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="input-blocks add-products">
                            <label class="d-block">Pembelian Dari</label>
                            <div class="single-pill-product mb-3">
                                <ul class="nav nav-pills" id="pills-tab1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <span class="custom_radio me-4 mb-0 active" id="pills-home-tab"
                                            data-bs-toggle="pill" data-bs-target="#pills-home" role="tab"
                                            aria-controls="pills-home" aria-selected="true">
                                            <input type="radio" class="form-control" name="payment">
                                            <span class="checkmark"></span> Suplier</span>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <span class="custom_radio me-2 mb-0" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" role="tab" aria-controls="pills-profile"
                                            aria-selected="false">
                                            <input type="radio" class="form-control" name="sign">
                                            <span class="checkmark"></span> Pelanggan</span>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <span class="custom_radio me-2 mb-0" id="pills-pembeli-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-pembeli" role="tab" aria-controls="pills-pembeli"
                                            aria-selected="false">
                                            <input type="radio" class="form-control" name="sign">
                                            <span class="checkmark"></span> Non Suplier / Pelanggan</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Suplier</label>
                                        <select class="select2" name="suplier_id" id="suplier_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Pelanggan</label>
                                        <select class="select2" name="pelanggan_id" id="pelanggan_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-pembeli" role="tabpanel"
                                    aria-labelledby="pills-pembeli-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Non Suplier / Pembeli</label>
                                        <input type="text" name="nonsuplierdanpembeli" id="nonsuplierdanpembeli"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body add-product pb-0">
                                        <div class="accordion-card-one accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <div class="accordion-header" id="headingOne">
                                                    <div class="accordion-button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne" aria-controls="collapseOne">
                                                        <div class="addproduct-icon">
                                                            <h5><i data-feather="info" class="add-info"></i><span> FORM
                                                                    TAMBAH PRODUK</span></h5>
                                                            <a href="javascript:void(0);"><i data-feather="chevron-down"
                                                                    class="chevron-down-add"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapseOne" class="accordion-collapse collapse"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Produk</label>
                                                            <input type="text" name="nama" id="nama"
                                                                class="form-control">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label">Berat</label>
                                                                <input type="text" name="berat" id="berat"
                                                                    class="form-control">
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label">Karat</label>
                                                                <input type="text" name="karat" id="karat"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label">Jenis</label>
                                                                <select class="select2" name="jenis_id" id="jenis">
                                                                </select>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label">Harga Beli</label>
                                                                <input type="text" name="harga_beli" id="hargabeli"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Kondisi Fisik</label>
                                                            <select class="select2" name="kondisi_id" id="kondisi">
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Keterangan</label>
                                                            <textarea class="form-control" rows="4" name="keterangan" id="keterangan"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="accordion-card-one accordion" id="accordionExample4">
                                            <div class="accordion-item">
                                                <div class="accordion-header" id="headingFour">
                                                    <div class="accordion-button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseFour" aria-controls="collapseFour">
                                                        <div class="text-editor add-list">
                                                            <div class="addproduct-icon list">
                                                                <h5><i data-feather="list"
                                                                        class="add-info"></i><span>PRODUK TABEL</span>
                                                                </h5>
                                                                <a href="javascript:void(0);"><i
                                                                        data-feather="chevron-down"
                                                                        class="chevron-down-add"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapseFour" class="accordion-collapse collapse"
                                                    aria-labelledby="headingFour" data-bs-parent="#accordionExample4">
                                                    <div class="accordion-body">
                                                        <div class="table-top">
                                                            <div class="search-set">
                                                                <div class="search-input">
                                                                    <a href="" class="btn btn-searchset"><i
                                                                            data-feather="search"
                                                                            class="feather-search"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="table-responsive product-list">
                                                            <table class="table datanew table-hover" style="width: 100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>No.</th>
                                                                        <th>Nama Produk</th>
                                                                        <th>Berat </th>
                                                                        <th>Action</th>
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
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="select2" name="status" id="status">
                                        <option>Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="2">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Form Tambahan -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /MODAL TAMBAH PEMBELIAN-->

    <!-- MODAL DETAIL PEMBELIAN -->
    <div class="modal fade" id="modalDetail">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title text-center">DETAIL PEMBELIAN</h4>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="storePembelian">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="input-blocks add-products">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="mb-3">
                                    <label class="form-label">Kode Pembelian</label>
                                    <input type="text" id="detailKodepembelian" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Penjual</label>
                                    <input type="text" id="detailPenjual" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="nama" id="detailNama" class="form-control" readonly>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Berat</label>
                                        <input type="text" name="berat" id="detailBerat" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Karat</label>
                                        <input type="text" name="karat" id="detailKarat" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Jenis</label>
                                        <input type="text" name="karat" id="detailJenis" class="form-control"
                                            readonly>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Harga Beli</label>
                                        <input type="text" name="harga_beli" id="detailHargabeli"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kondisi Fisik</label>
                                    <input type="text" name="karat" id="detailKondisi" class="form-control"
                                        readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control" rows="4" name="keterangan" id="detailKeterangan" readonly></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <input type="text" name="karat" id="detailStatus" class="form-control"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <!-- Form Tambahan -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /MODAL DETAIL PEMBELIAN -->

    <!-- MODAL EDIT PEMBELIAN -->
    <div class="modal fade" id="modaledit">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">EDIT PEMBELIAN</h4>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="formEditPembelian">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="input-blocks add-products">
                            <div class="mb-3">
                                <label class="form-label">ID</label>
                                <input type="text" name="id" id="editid" class="form-control">
                            </div>
                            <label class="d-block">Pembelian Dari</label>
                            <div class="single-pill-product mb-3">
                                <ul class="nav nav-pills" id="editpills-tab1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <span class="custom_radio me-4 mb-0" id="editpills-home-tab"
                                            data-bs-toggle="pill" data-bs-target="#editpills-home" role="tab"
                                            aria-controls="editpills-home" aria-selected="true">
                                            <input type="radio" id="editsuplier" class="form-control"
                                                name="editsuplier">
                                            <span class="checkmark"></span> Suplier</span>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <span class="custom_radio me-2 mb-0" id="editpills-profile-tab"
                                            data-bs-toggle="pill" data-bs-target="#editpills-profile" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">
                                            <input type="radio" id="editpelanggan" class="form-control"
                                                name="editpelanggan">
                                            <span class="checkmark"></span> Pelanggan</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="editpills-tabContent">
                                <div class="tab-pane fade show" id="editpills-home" role="tabpanel"
                                    aria-labelledby="editpills-home-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Suplier</label>
                                        <select class="select" name="suplier_id" id="editsuplier_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="editpills-profile" role="tabpanel"
                                    aria-labelledby="editpills-profile-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Pelanggan</label>
                                        <select class="select" name="pelanggan_id" id="editpelanggan_id">
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="nama" id="editnama" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Berat</label>
                                        <input type="text" name="berat" id="editberat" class="form-control">
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Karat</label>
                                        <input type="text" name="karat" id="editkarat" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Jenis</label>
                                        <select class="select" name="jenis_id" id="editjenis">
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Harga Beli</label>
                                        <input type="text" name="harga_beli" id="edithargabeli" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kondisi Fisik</label>
                                    <select class="select" name="kondisi" id="editkondisi">
                                        <option selected> Pilih Kondisi</option>
                                        <option value="baik">Baik</option>
                                        <option value="kusam">Kusam</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control" rows="4" name="keterangan" id="editketerangan"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="select" name="status" id="editstatus">
                                        <option>Pilih Status</option>
                                        <option value="1">Aktif</option>
                                        <option value="2">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Form Tambahan -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /MODAL EDIT PEMBELIAN-->

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/pembelian.js" type="text/javascript"></script>
@endsection
