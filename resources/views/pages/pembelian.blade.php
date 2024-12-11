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
                    <a class="btn btn-added btn-tambahPembelian"><i data-feather="plus-circle" class="me-2"></i>TAMBAH
                        PEMBELIAN</a>
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($pembelian as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kodepembelian }} </td>
                                        <td>
                                            @if ($item->suplier_id == null)
                                                {{ $item->pelanggan->nama }}
                                            @elseif($item->pelanggan_id == null)
                                                {{ $item->suplier->suplier }}
                                            @endif
                                        </td>
                                        <td>{{ $item->produk->nama }}</td>
                                        <td>{{ $item->produk->berat }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2" href="javascript:void(0);">
                                                    <i data-feather="eye" class="action-eye"></i>
                                                </a>
                                                <a class="me-2 p-2" data-bs-toggle="modal" data-bs-target="#edit-units">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a class="confirm-text p-2" href="javascript:void(0);">
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

    <!-- Add Pegawai -->
    <div class="modal fade" id="mdtambahPembelian">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pembelian</h4>
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
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Suplier</label>
                                        <select class="select" name="suplier_id" id="suplier">
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <div class="mb-3">
                                        <label class="form-label">Pelanggan</label>
                                        <select class="select" name="pelanggan_id" id="pelanggan">
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Produk</label>
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
                                        <label class="form-label">Jenis</label>
                                        <select class="select" name="jenis_id" id="jenis">
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label">Harga Beli</label>
                                        <input type="text" name="harga_beli" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kondisi Fisik</label>
                                    <select class="form-control" name="kondisi">
                                        <option selected> Pilih Kondisi</option>
                                        <option value="baik">Baik</option>
                                        <option value="kusam">Kusam</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control" rows="4" name="keterangan"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="form-control" name="status">
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
    <!-- /Add Pegawai -->

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/pembelian.js" type="text/javascript"></script>
@endsection
