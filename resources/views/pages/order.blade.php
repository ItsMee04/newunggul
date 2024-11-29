@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DAFTAR ORDER</h4>
                        <h6>Halaman Order</h6>
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
                                    <th>Kode Transaksi</th>
                                    <th>Kode Keranjang</th>
                                    <th>Pelanggan</th>
                                    <th>Total</th>
                                    <th>Sales</th>
                                    <th>Payment Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kodetransaksi }}</td>
                                        <td>{{ $item->keranjang_id }} </td>
                                        <td>{{ $item->pelanggan->nama }}</td>
                                        <td>{{ 'Rp.' . ' ' . number_format($item->total) }}</td>
                                        <td>
                                            <div class="userimgname">
                                                <a href="javascript:void(0);" class="product-img">
                                                    <img src="{{ asset('storage/Avatar/' . $item->user->pegawai->image) }}"
                                                        alt="product">
                                                </a>
                                                <a href="javascript:void(0);">{{ $item->user->pegawai->nama }}</a>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <span class="badge bg-secondary"> Unpaid</span>
                                            @elseif($item->status == 2)
                                                <span class="badge bg-success"> Paid</span>
                                            @else
                                                <span class="badge bg-danger"> Cancel Payment</span>
                                            @endif
                                        </td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                @if ($item->status == 1)
                                                    <a class="me-2 edit-icon  p-2"
                                                        href="/detailOrder/{{ $item->kodetransaksi }}">
                                                        <i data-feather="eye" class="feather-eye"></i>
                                                    </a>
                                                    <a class="me-2 confirm-payment p-2" href="javascript:void(0);"
                                                        data-id="{{ $item->id }}">
                                                        <i data-feather="check-circle" class="feather-edit"></i>
                                                    </a>
                                                    <a class="confirm-cancel p-2" href="javascript:void(0);"
                                                        data-id="{{ $item->id }}">
                                                        <i data-feather="x-circle" class="feather-trash-2"></i>
                                                    </a>
                                                @else
                                                    <a class="me-2 edit-icon  p-2" href="detailOrder/{{ $item->id }}">
                                                        <i data-feather="eye" class="feather-eye"></i>
                                                    </a>
                                                @endif
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

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="{{ asset('js') }}/order.js" type="text/javascript"></script>
@endsection
