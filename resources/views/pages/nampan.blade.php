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
                        <table class="table datanew">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nampan / Baki</th>
                                    <th>Jenis</th>
                                    <th>Jumlah Produk</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nampan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }} </td>
                                        <td>
                                            <a href="nampan/{{ $item->id }}">
                                                <button type="button" class="btn btn-outline-secondary my-1 me-2">
                                                    {{ $item->nampan }}
                                                </button>
                                            </a>
                                        </td>
                                        <td>{{ $item->jenis->jenis }} </td>
                                        <td>{{ $item->nampan }}</td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2" data-bs-effect="effect-sign" data-bs-toggle="modal"
                                                    href="#modaledit{{ $item->id }}">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a class="me-2 p-2 confirm-text" href="javascript:void(0);"
                                                    data-item-id="{{ $item->id }}">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="modaledit{{ $item->id }}">
                                        <div class="modal-dialog modal-dialog-centered text-center" role="document">
                                            <div class="modal-content modal-content-demo">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit Nampan Produk</h4><button
                                                        aria-label="Close" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="update-nampan/{{ $item->id }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label">Jenis Produk</label>
                                                            <select class="select" name="jenis">
                                                                <option>Pilih Jenis Produk</option>
                                                                @foreach ($jenis as $itemjenis)
                                                                    <option value="{{ $itemjenis->id }}"
                                                                        @if ($item->jenis_id == $itemjenis->id) selected="selected" @endif>
                                                                        {{ $itemjenis->jenis }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nampan / Baki</label>
                                                            <input type="text" name="nampan"
                                                                value="{{ $item->nampan }}" class="form-control">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select class="select" name="status">
                                                                <option>Pilih Status</option>
                                                                <option value="1"
                                                                    @if ($item->status == 1) selected="selected" @endif>
                                                                    Aktif</option>
                                                                <option value="2"
                                                                    @if ($item->status == 2) selected="selected" @endif>
                                                                    Tidak Aktif</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-cancel"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
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
@endsection
