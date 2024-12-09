@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR NAMPAN</h4>
                        <h6>Halaman Nampan</h6>
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
                    <a href="#" class="btn btn-added" data-bs-toggle="modal" data-bs-target="#tambahNampan"><i
                            data-feather="plus-circle" class="me-2"></i>TAMBAH NAMPAN / BAKI</a>
                </div>
            </div>

            <div class="row" id="daftarNampan">
                <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                    <div class="bank-box">
                        <div class="bank-header">
                            <div class="bank-name">
                                <h6>HDFC</h6>
                                <p>**** **** 1832</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="system-app-icon">
                                <img src="assets/img/icons/fb-icon.svg" alt="">
                            </span>
                            <div class="bank-info">
                                <span>Holder Name</span>
                                <h6>Mathew</h6>
                            </div>
                            <div class="edit-delete-action bank-action-btn">
                                <a class="me-2 p-2" href="#" data-bs-toggle="modal" data-bs-target="#edit-account">
                                    <i data-feather="edit" class="feather-edit"></i>
                                </a>
                                <a class="confirm-text p-2" href="javascript:void(0);">
                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahNampan">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Nampan / Baki</h4><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>
                <form action="nampan" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body text-start">
                        <div class="mb-3">
                            <label class="form-label">Jenis Produk</label>
                            <select class="select" name="jenis">
                                <option>Pilih Jenis Produk</option>
                                @foreach ($jenis as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Nampan</label>
                            <input type="text" name="nampan" class="form-control">
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
                        <button type="submit" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/nampan.js" type="text/javascript"></script>
    <style>
        .bank-action-btn {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            justify-content: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
        }
    </style>
@endsection
