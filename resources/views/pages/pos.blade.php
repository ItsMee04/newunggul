@extends('layouts.app')
@section('content')
    <div class="page-wrapper pos-pg-wrapper">
        <div class="content pos-design p-0">
            <div class="row align-items-start pos-wrapper">
                <div class="col-md-12 col-lg-8">
                    <div class="pos-categories tabs_wrapper">
                        <h5>Jenis Perhiasan</h5>
                        <p>Pilih Dari Jenis Di Bawah Ini</p>
                        <ul class="tabs owl-carousel pos-category">
                            <li id="all">
                                <a href="javascript:void(0);">
                                    <img src="assets/img/categories/category-01.png" alt="Categories">
                                </a>
                                <h6><a href="javascript:void(0);">All Categories</a></h6>
                                <span>{{ $produk->where('status', 1)->count() }}</span>
                            </li>
                            @foreach ($jenis as $item)
                                <li id="{{ $item->id }}">
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('storage/Icon/' . $item->icon) }}" alt="Categories">
                                    </a>
                                    <h6><a href="javascript:void(0);">{{ $item->jenis }}</a></h6>
                                    <span>{{ $produk->where('jenis_id', $item->id)->count() }} Item</span>
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
                                <span>Transaction ID : #<b id="transaksi_id">{{ $kodetransaksi }}</b></span>
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
                                <a href="javascript:void(0);" class="d-flex align-items-center text-danger"
                                    data-bs-toggle="modal" data-bs-target="#modaldeleteALlKeranjang"><span class="me-1"><i
                                            data-feather="x" class="feather-16"></i></span class="deleteAll">Clear all</a>
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
                                                <option value="0" selected>Pilih Diskon</option>
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
                            <a href="javascript:void(0);" class="btn btn-success btn-icon flex-fill" id="payment"><span
                                    class="me-1 d-flex align-items-center"><i data-feather="credit-card"
                                        class="feather-16"></i></span>Payment</a>
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

    <script>
        $(document).ready(function() {
            $("ul.tabs li").click(function() {
                var $this = $(this);
                var $theTab = $(this).attr("id");
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

                if ($this.hasClass("active")) {} else {
                    $this
                        .closest(".tabs_wrapper")
                        .find("ul.tabs li, .tabs_container .tab_content")
                        .removeClass("active");
                    $(
                        '.tabs_container .tab_content[data-tab="' +
                        $theTab +
                        '"], ul.tabs li[id="' +
                        $theTab +
                        '"]'
                    ).addClass("active");

                    $.ajax({
                        url: `/pos/${$theTab}`,
                        type: "GET",
                        _token: CSRF_TOKEN,
                        dataType: "json",
                        success: function(data) {
                            $("#daftarProduk").empty();
                            $.each(data.Data, function(key, item) {
                                const formatter = new Intl.NumberFormat("id-ID", {
                                    style: "currency",
                                    currency: "IDR",
                                    minimumFractionDigits: 0, // Biasanya mata uang Rupiah tidak menggunakan desimal
                                });

                                const hargajual = formatter.format(item
                                    .harga_jual); // Output: "Rp1.500.000"
                                $("#daftarProduk").append(
                                    `
							<div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
								<div class="product-info default-cover card">
									<a href="javascript:void(0);" class="img-bg">
										<img src="/storage/produk/${item.image}"
											alt="Products" width="100px" height="100px"/>
									</a>
									<h6 class="cat-name">
										<a href="javascript:void(0);">KODE : ${item.kodeproduk}</a>
									</h6>
									<h6 class="product-name">
										<a href="javascript:void(0);">NAMA : ${item.nama}</a>
									</h6>
									<div
										class="d-flex align-items-center justify-content-between price">
										<span>BERAT : ${item.berat} /gram</span>
										<p>HARGA: Rp. ${hargajual}</p>
									</div>
									<div class="align-items-center justify-content-between price text-center">
                                        <button data-id="${item.id}" data-name="${item.nama}" data-harga="${item.harga_jual}" data-berat="${item.berat}" class="btn btn-sm btn-outline-primary ms-1 addCart">Add To Cart</button>
                                    </div>
								</div>
							</div>
						`
                                );
                            });
                        },
                    });
                }
            });

            function getCount() {
                $.ajax({
                    url: "/getCount", // Endpoint di Laravel
                    type: "GET",
                    success: function(response) {
                        // Loop melalui setiap item yang dikembalikan dari server
                        $(".count").text(0);
                        if (response.success) {
                            $(".count").text(response.count);
                        } else {
                            $(".count").text(0);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                    },
                });
            }
        })
    </script>
@endsection
