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

            <div class="card">
                <div class="card-body">
                    <form action="sales-list.html">
                        <div class="invoice-box table-height"
                            style="max-width: 1600px;width:100%;overflow: auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
                            <div class="sales-details-items d-flex">
                                <div class="details-item">
                                    <h6>Customer Info</h6>
                                    <p>walk-in-customer<br>
                                        <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                            data-cfemail="1a6d7b767137737437796f696e75777f685a7f627b776a767f34797577">[email&#160;protected]</a><br>
                                        123456780<br>
                                        N45 , Dhaka
                                    </p>
                                </div>
                                <div class="details-item">
                                    <h6>Company Info</h6>
                                    <p>DGT<br>
                                        <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                            data-cfemail="d8b9bcb5b1b698bda0b9b5a8b4bdf6bbb7b5">[email&#160;protected]</a><br>
                                        6315996770<br>
                                        3618 Abia Martin Drive
                                    </p>
                                </div>
                                <div class="details-item">
                                    <h6>Invoice Info</h6>
                                    <p>Reference<br>
                                        Payment Status<br>
                                        Status
                                    </p>
                                </div>
                                <div class="details-item">
                                    <h5><span>SL0101</span>Paid<br> Completed</h5>
                                </div>
                            </div>
                            <h5 class="order-text">Order Summary</h5>
                            <div class="table-responsive no-pagination">
                                <table class="table  datanew">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Purchase Price($)</th>
                                            <th>Discount($)</th>
                                            <th>Tax(%)</th>
                                            <th>Tax Amount($)</th>
                                            <th>Unit Cost($)</th>
                                            <th>Total Cost(%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="productimgname">
                                                    <a href="javascript:void(0);" class="product-img stock-img">
                                                        <img src="assets/img/products/stock-img-02.png" alt="product">
                                                    </a>
                                                    <a href="javascript:void(0);">Nike Jordan</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="product-quantity">
                                                    <span class="quantity-btn">+<i data-feather="plus-circle"
                                                            class="plus-circle"></i></span>
                                                    <input type="text" class="quntity-input" value="2">
                                                    <span class="quantity-btn"><i data-feather="minus-circle"
                                                            class="feather-search"></i></span>
                                                </div>
                                            </td>
                                            <td>2000</td>
                                            <td>500</td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>1500</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="productimgname">
                                                    <a href="javascript:void(0);" class="product-img stock-img">
                                                        <img src="assets/img/products/stock-img-03.png" alt="product">
                                                    </a>
                                                    <a href="javascript:void(0);">Apple Series 5 Watch</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="product-quantity">
                                                    <span class="quantity-btn">+<i data-feather="plus-circle"
                                                            class="plus-circle"></i></span>
                                                    <input type="text" class="quntity-input" value="2">
                                                    <span class="quantity-btn"><i data-feather="minus-circle"
                                                            class="feather-search"></i></span>
                                                </div>
                                            </td>
                                            <td>3000</td>
                                            <td>400</td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>1700</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="productimgname">
                                                    <a href="javascript:void(0);" class="product-img stock-img">
                                                        <img src="assets/img/products/stock-img-05.png" alt="product">
                                                    </a>
                                                    <a href="javascript:void(0);">Lobar Handy</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="product-quantity">
                                                    <span class="quantity-btn">+<i data-feather="plus-circle"
                                                            class="plus-circle"></i></span>
                                                    <input type="text" class="quntity-input" value="2">
                                                    <span class="quantity-btn"><i data-feather="minus-circle"
                                                            class="feather-search"></i></span>
                                                </div>
                                            </td>
                                            <td>2500</td>
                                            <td>500</td>
                                            <td>
                                                0.00
                                            </td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                            <td>2000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">

                            <div class="row">
                                <div class="col-lg-6 ms-auto">
                                    <div class="total-order w-100 max-widthauto m-auto mb-4">
                                        <ul>
                                            <li>
                                                <h4>Order Tax</h4>
                                                <h5>$ 0.00</h5>
                                            </li>
                                            <li>
                                                <h4>Discount</h4>
                                                <h5>$ 0.00</h5>
                                            </li>
                                            <li>
                                                <h4>Grand Total</h4>
                                                <h5>$ 5200.00</h5>
                                            </li>
                                            <li>
                                                <h4>Paid</h4>
                                                <h5>$ 5200.00</h5>
                                            </li>
                                            <li>
                                                <h4>Due</h4>
                                                <h5>$ 0.00</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
