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
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                                class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                data-feather="chevron-up" class="feather-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a class="btn btn-added" data-bs-toggle="modal" href="#tambahPembelian" title="Tambah Pembelian"
                        id="tambahPembelianButton">
                        <i data-feather="plus-circle" class="me-2"></i>TAMBAH
                        PEMBELIAN
                    </a>
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
                        <table class="table  datanew list">
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
                                @foreach ($pembelian as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kodepembelian }} </td>
                                        <td>
                                            @if ($item->supplier_id == null)
                                                {{ $item->pelanggan->nama }}
                                            @else
                                                {{ $item->suplier->suplier }}
                                            @endif
                                        </td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->berat }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>

    <!-- Add Pegawai -->
    <div class="modal fade" id="tambahPembelian">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pembelian</h4>
                    <button aria-label="Close" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/pembelian" method="POST" enctype="multipart/form-data" id="formPembelian">
                    @csrf
                    <div class="modal-body text-start">
                        <!-- Form untuk Suplier -->
                        <div id="formSuplier" style="display: none;" class="mb-3">
                            <label class="form-label">Suplier</label>
                            <select class="form-control" name="suplier_id">
                                <option>Pilih Suplier</option>
                                @foreach ($suplier as $item)
                                    <option value="{{ $item->id }}"> {{ $item->suplier }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Form untuk Pelanggan -->
                        <div id="formPelanggan" style="display: none;" class="mb-3">
                            <label class="form-label">Pelanggan</label>
                            <select class="form-control" name="pelanggan_id">
                                <option>Pilih Pelanggan</option>
                                @foreach ($pelanggan as $item)
                                    <option value="{{ $item->id }}"> {{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Form Tambahan -->
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
                                <select class="form-control" name="jenis_id">
                                    <option>Pilih Jenis</option>
                                    @foreach ($jenis as $item)
                                        <option value="{{ $item->id }}"> {{ $item->jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Harga Beli</label>
                                <input type="text" name="hargabeli" class="form-control">
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
    <script src="{{asset('assets')}}/js/jquery-3.7.1.min.js" type="754ab5592cf1ed2f16b073bb-text/javascript"></script>
    <script>
        $(document).ready(function() {
            // Trigger ketika modal dibuka
            $('#tambahPembelian').on('show.bs.modal', function() {
                Swal.fire({
                    title: 'Pilih Jenis Pembelian',
                    input: 'radio',
                    inputOptions: {
                        'suplier': 'Pembelian dari Suplier',
                        'pelanggan': 'Pembelian dari Pelanggan',
                    },
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Anda harus memilih salah satu!';
                        }
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value === 'suplier') {
                            $('#formSuplier').show();
                            $('#formPelanggan').hide();
                        } else if (result.value === 'pelanggan') {
                            $('#formPelanggan').show();
                            $('#formSuplier').hide();
                        }
                    } else {
                        // Tutup modal jika pembatalan dilakukan
                        $('#tambahPembelian').modal('hide');
                    }
                });
            });

            // Reset modal saat ditutup
            $('#tambahPembelian').on('hidden.bs.modal', function() {
                $('#formSuplier, #formPelanggan').hide();
                $('#formPembelian')[0].reset();
            });
        });
    </script>
@endsection
