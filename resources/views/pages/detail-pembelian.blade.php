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
            <div class="content p-0">
                <div class="card">
                    <div class="card-body">
                        <form action="purchase-returns.html">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <label class="form-label">Supplier</label>
                                        <div class="row">
                                            <div class="col-lg-10 col-sm-10 col-10">
                                                <select class="select">
                                                    <option>Apex Computers</option>
                                                    <option>Modern Automobile</option>
                                                    <option>AIM Infotech</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                                <div class="add-icon">
                                                    <a href="#" class="choose-add"><i data-feather="plus-circle"
                                                            class="plus"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <label>Date</label>
                                        <div class="input-groupicon calender-input">
                                            <i data-feather="calendar" class="info-img"></i>
                                            <input type="text" class="datetimepicker" placeholder="Choose">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <label class="form-label">Reference No.</label>
                                        <input type="text" class="form-control" value="PT001">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <label>Product Name</label>
                                        <div class="input-groupicon select-code">
                                            <input type="text" placeholder="Please type product code and select"
                                                value="Apex Computers">
                                            <div class="addonset">
                                                <img src="assets/img/icons/qrcode-scan.svg" alt="img">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive no-pagination">
                                <table class="table  datanew">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Date</th>
                                            <th>Supplier</th>
                                            <th>Reference</th>
                                            <th>Status</th>
                                            <th>Grand Total ($)</th>
                                            <th>Paid ($)</th>
                                            <th>Due ($)</th>
                                            <th>Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a class="product-img">
                                                    <img src="assets/img/products/product1.jpg" alt="product">
                                                </a>
                                            </td>
                                            <td>2/27/2022</td>
                                            <td>Apex Computers </td>
                                            <td>PT001</td>
                                            <td><span class="badges bg-lightgreen">Received</span></td>
                                            <td>550</td>
                                            <td>120</td>
                                            <td>550</td>
                                            <td><span class="badges bg-lightgreen">Paid</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a class="product-img">
                                                    <img src="assets/img/products/product5.jpg" alt="product">
                                                </a>
                                            </td>
                                            <td>3/24/2022</td>
                                            <td>Best Power Tools</td>
                                            <td>PT0011</td>
                                            <td><span class="badges bg-lightred">Pending</span></td>
                                            <td>2580</td>
                                            <td>1250</td>
                                            <td>2580</td>
                                            <td><span class="badges bg-lightred">Unpaid</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

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
                                                <h4>Shipping</h4>
                                                <h5>$ 0.00</h5>
                                            </li>
                                            <li>
                                                <h4>Grand Total</h4>
                                                <h5>$ 0.00</h5>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <label>Order Tax</label>
                                        <div class="input-groupicon select-code">
                                            <input type="text" value="0" class="p-2">
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <label>Discount</label>
                                        <div class="input-groupicon select-code">
                                            <input type="text" value="0" class="p-2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks">
                                        <label>Shipping</label>
                                        <div class="input-groupicon select-code">
                                            <input type="text" value="0" class="p-2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="input-blocks mb-5">
                                        <label>Status</label>
                                        <select class="select">
                                            <option>Choose</option>
                                            <option>Pending</option>
                                            <option>Received</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="button" class="btn btn-cancel add-cancel me-3"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-submit add-sale">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    </div>
@endsection
