@extends('layouts.app')
@section('content')
    <div class="page-wrapper cardhead">
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>SCAN BARCODE PRODUK</h4>
                        <h6>Halaman Scan Barcode</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg"
                                alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                                src="assets/img/icons/excel.svg" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Print"><i data-feather="printer"
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
                <div class="page-btn">
                    <a href="add-product.html" class="btn btn-added"><i data-feather="plus-circle" class="me-2"></i>Add
                        New Product</a>
                </div>
                <div class="page-btn import">
                    <a href="#" class="btn btn-added color" data-bs-toggle="modal" data-bs-target="#view-notes"><i
                            data-feather="download" class="me-2"></i>Import Product</a>
                </div>
            </div>

            <!-- /product list -->
            <section class="comp-section comp-cards">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                        <div class="card flex-fill bg-white">
                            <div id="reader"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4 d-flex">
                    </div>
                </div>
            </section>
            <!-- /product list -->
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            function onScanSuccess(decodedText, decodedResult) {
                // handle the scanned code as you like, for example:

                // alert(decodedText);
                $("#result").val(decodedText);
                let id = decodedText;
                html5QrcodeScanner
                    .clear()
                    .then((_) => {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
                        $.ajax({
                            url: "scanqr",
                            type: "POST",
                            data: {
                                _methode: "POST",
                                _token: CSRF_TOKEN,
                                qr_code: id,
                            },
                            success: function(data) {
                                if (data) {
                                    const successtoastExample =
                                        document.getElementById("successToastDelete");
                                    const toast = new bootstrap.Toast(
                                        successtoastExample
                                    );
                                    toast.show();

                                    window.location = "scan/" + id;
                                } else {
                                    const dangertoastExample =
                                        document.getElementById("dangerToastScan");
                                    const toast = new bootstrap.Toast(
                                        dangertoastExample
                                    );
                                    toast.show();
                                }
                            },
                        });
                    })
                    .catch((error) => {
                        const dangertoastExample =
                            document.getElementById("dangerToastScan");
                        const toast = new bootstrap.Toast(dangertoastExample);
                        toast.show();
                    });
            }

            function onScanFailure(error) {
                // handle scan failure, usually better to ignore and keep scanning.
                // for example:
                // console.warn(`Code scan error = ${error}`);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250,
                    },
                },
                /* verbose= */
                false
            );
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        })
    </script>
@endsection
