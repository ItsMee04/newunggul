@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>DETAIL PEMBELIAN</h4>
                        <h6>Halaman Detail Pembelian</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a href="cetakNotaTransaksi/{{ $pembelian->id }}" target="__blank" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Print"><i data-feather="printer"
                                class="feather-rotate-ccw"></i></a>
                    </li>
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

            <div class="card">
                <div class="card-body">
                    <div class="card-sales-split">
                        <h2>Detail Transaction : {{ $pembelian->kodepembelian }}</h2>
                    </div>
                    <div class="invoice-box table-height"
                        style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                        <table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
                            <tbody>
                                <tr class="top">
                                    <td colspan="6" style="padding: 5px;vertical-align: top;">
                                        <table style="width: 100%;line-height: inherit;text-align: left;">
                                            <tbody>

                                                <tr>
                                                    <td
                                                        style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                                            <font
                                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                                Customer</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                @if (is_null($pembelian->suplier_id) && is_null($pembelian->nonsuplierdanpembeli))
                                                                    {{ $pembelian->pelanggan->kontak }}
                                                                @elseif (is_null($pembelian->pelanggan_id) && is_null($pembelian->nonsuplierdanpembeli))
                                                                    {{ $pembelian->suplier->kontak }}
                                                                @elseif (is_null($pembelian->suplier_id) && is_null($pembelian->pelanggan_id))
                                                                    -
                                                                @endif
                                                            </font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                @if (is_null($pembelian->suplier_id) && is_null($pembelian->nonsuplierdanpembeli))
                                                                    {{ $pembelian->pelanggan->nama }}
                                                                @elseif (is_null($pembelian->pelanggan_id) && is_null($pembelian->nonsuplierdanpembeli))
                                                                    {{ $pembelian->suplier->suplier }}
                                                                @elseif (is_null($pembelian->suplier_id) && is_null($pembelian->pelanggan_id))
                                                                    {{ $pembelian->nonsuplierdanpembeli }}
                                                                @endif
                                                            </font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                @if (is_null($pembelian->suplier_id) && is_null($pembelian->nonsuplierdanpembeli))
                                                                    {{ $pembelian->pelanggan->alamat }}
                                                                @elseif (is_null($pembelian->pelanggan_id) && is_null($pembelian->nonsuplierdanpembeli))
                                                                    {{ $pembelian->suplier->alamat }}
                                                                @elseif (is_null($pembelian->suplier_id) && is_null($pembelian->pelanggan_id))
                                                                    -
                                                                @endif
                                                            </font>
                                                        </font><br>
                                                    </td>
                                                    <td
                                                        style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
                                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                                            <font
                                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                                Invoice</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Payment Status</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            <font
                                                                style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">
                                                                Sales</font>
                                                        </font><br>
                                                    </td>
                                                    <td
                                                        style="padding:5px;vertical-align:top;text-align:right;padding-bottom:20px">
                                                        <font style="vertical-align: inherit;margin-bottom:25px;">
                                                            <font
                                                                style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">
                                                                &nbsp;</font>
                                                        </font><br>
                                                        <font style="vertical-align: inherit;">
                                                            @if ($pembelian->status == 1)
                                                                <font
                                                                    style="vertical-align: inherit;font-size: 14px;color:#ff0000;font-weight: 400;">
                                                                    <span class="badge bg-danger">UN PAID</span>
                                                                </font>
                                                            @else
                                                                <font
                                                                    style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;">
                                                                    <span class="badge bg-success">PAID</span>
                                                                </font>
                                                            @endif
                                                        </font><br>
                                                        <font
                                                            style="vertical-align: inherit;font-size: 14px;color:#000000;font-weight: 400;">
                                                            <strong>{{ $pembelian->pembelianproduk->user->pegawai->nama }}</strong>
                                                        </font>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="heading " style="background: #F3F2F7;">
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Nama Item
                                    </td>
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Berat
                                    </td>
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Karat
                                    </td>
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Harga
                                    </td>
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Grand Total
                                    </td>
                                    <td
                                        style="padding: 5px;vertical-align: middle;font-weight: 600;color: #5E5873;font-size: 14px;padding: 10px; ">
                                        Print Surat Product
                                    </td>
                                </tr>
                                @foreach ($produk as $item)
                                    <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                                        <td style="padding: 10px;vertical-align: top; display: flex;align-items: center;">
                                            <img src="{{ $item->pembelianproduk->produk->image ? asset('storage/produk/' . $item->pembelianproduk->produk->image) : asset('assets/img/notfound.png') }}"
                                                alt="Product Image" class="me-2" style="width:40px;height:40px;">
                                            {{ $item->pembelianproduk->produk->nama }}
                                        </td>
                                        <td style="padding: 10px;vertical-align: top; ">
                                            {{ $item->pembelianproduk->produk->berat }} grams
                                        </td>
                                        <td style="padding: 10px;vertical-align: top; ">
                                            {{ $item->pembelianproduk->produk->karat }}
                                        </td>
                                        <td style="padding: 10px;vertical-align: top; ">
                                            {{ 'Rp.' . ' ' . number_format($item->pembelianproduk->produk->harga_beli) }}
                                        </td>
                                        <td style="padding: 10px;vertical-align: top; ">
                                            {{ 'Rp.' . ' ' . number_format($item->pembelianproduk->total) }}
                                        </td>
                                        <td style="padding: 10px;vertical-align: top; ">
                                            <a href="/NotaBarang/{{ $item->pembelianproduk->produk->id }}"
                                                target="__blank">
                                                <i data-feather="printer" class="feather-rotate-ccw"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Cetak Surat Barang">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="col-lg-6 ">
                                <div class="total-order w-100 max-widthauto m-auto mb-4">
                                    <ul>
                                        <li class="total">
                                            <h4>Sub Total</h4>
                                            <h5 class="text-danger">
                                                {{ 'Rp.' . ' ' . number_format($pembelian->pembelianproduk->produk->harga_beli) }}
                                            </h5>
                                        </li>
                                        <li class="total">
                                            <h4>Discount</h4>
                                            <h5>0 %</h5>
                                        </li>
                                        <li class="total">
                                            <h4>Grand Total</h4>
                                            <h5 class="text-success">
                                                {{ 'Rp.' . ' ' . number_format($pembelian->pembelianproduk->total) }}
                                            </h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
