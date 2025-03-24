<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords"
        content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">
    <title>Dreams POS - Inventory Management & Admin Dashboard Template</title>

    <script src="{{ asset('assets') }}/js/theme-script.js" type="text/javascript"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/img/favicon.png">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets') }}/img/apple-touch-icon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">

    <!-- animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/animate.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/dataTables.bootstrap5.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap-datetimepicker.min.css">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/summernote/summernote-bs4.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome/css/all.min.css">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/tabler-icons/tabler-icons.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">

</head>

<body>

    <div class="content">
        <!-- Invoices -->
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-between align-items-center border-bottom mb-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <img src="{{ asset('assets') }}/img/logo.png" width="150px" class="img-fluid"
                                alt="logo">
                        </div>
                        <p class="mb-1 fw-medium">Jl. Kapten patimura No. 8, karanglewas lor, </p>
                        <p class="mb-1 fw-medium">Kec. Purwokerto Barat, kab. Banyumas, Jawa Tengah
                            53136</p>
                    </div>
                    <div class="col-md-6">
                        <div class=" text-end mb-3">
                            <h5 class="text-gray mb-1">Invoice No <span class="text-primary">#INV0001</span>
                            </h5>
                            <p class="mb-1 fw-medium">Created Date : <span class="text-dark">Sep 24,
                                    2024</span> </p>
                            <p class="fw-medium">Due Date : <span class="text-dark">Sep 30, 2024</span> </p>
                        </div>
                    </div>
                </div>
                <div class="row border-bottom mb-3">
                    <div class="col-md-5">
                        <p class="text-dark mb-2 fw-semibold">From</p>
                        <div>
                            <h4 class="mb-1">Thomas Lawler</h4>
                            <p class="mb-1">2077 Chicago Avenue Orosi, CA 93647</p>
                            <p class="mb-1">Email : <span class="text-dark"><a href="/cdn-cgi/l/email-protection"
                                        class="__cf_email__"
                                        data-cfemail="98ccf9eaf9f4f9aaacacadd8fde0f9f5e8f4fdb6fbf7f5">[email&#160;protected]</a></span>
                            </p>
                            <p>Phone : <span class="text-dark">+1 987 654 3210</span></p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <p class="text-dark mb-2 fw-semibold">To</p>
                        <div>
                            <h4 class="mb-1">Carl Evans</h4>
                            <p class="mb-1">3103 Trainer Avenue Peoria, IL 61602</p>
                            <p class="mb-1">Email : <span class="text-dark"><a href="/cdn-cgi/l/email-protection"
                                        class="__cf_email__"
                                        data-cfemail="ffac9e8d9ea096919ccccbbf9a879e928f939ad19c9092">[email&#160;protected]</a></span>
                            </p>
                            <p>Phone : <span class="text-dark">+1 987 471 6589</span></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <p class="text-title mb-2 fw-medium">Payment Status </p>
                            <span class="bg-success text-white fs-10 px-1 rounded"><i
                                    class="ti ti-point-filled "></i>Paid</span>
                            <div class="mt-3">
                                <img src="{{ asset('assets') }}/img/qr.svg" class="img-fluid" alt="QR">
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <p class="fw-medium">Invoice For : <span class="text-dark fw-medium">Design &
                            development of Website</span></p>
                    <div class="table-responsive mb-3">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Job Description</th>
                                    <th class="text-end">Qty</th>
                                    <th class="text-end">Cost</th>
                                    <th class="text-end">Discount</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <h6>UX Strategy</h6>
                                    </td>
                                    <td class="text-gray-9 fw-medium text-end">1</td>
                                    <td class="text-gray-9 fw-medium text-end">$500</td>
                                    <td class="text-gray-9 fw-medium text-end">$100</td>
                                    <td class="text-gray-9 fw-medium text-end">$500</td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Design System</h6>
                                    </td>
                                    <td class="text-gray-9 fw-medium text-end">1</td>
                                    <td class="text-gray-9 fw-medium text-end">$5000</td>
                                    <td class="text-gray-9 fw-medium text-end">$100</td>
                                    <td class="text-gray-9 fw-medium text-end">$5000</td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Brand Guidellines</h6>
                                    </td>
                                    <td class="text-gray-9 fw-medium text-end">1</td>
                                    <td class="text-gray-9 fw-medium text-end">$5000</td>
                                    <td class="text-gray-9 fw-medium text-end">$100</td>
                                    <td class="text-gray-9 fw-medium text-end">$5000</td>
                                </tr>
                                <tr>
                                    <td>
                                        <h6>Social Media Template</h6>
                                    </td>
                                    <td class="text-gray-9 fw-medium text-end">1</td>
                                    <td class="text-gray-9 fw-medium text-end">$5000</td>
                                    <td class="text-gray-9 fw-medium text-end">$100</td>
                                    <td class="text-gray-9 fw-medium text-end">$5000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row border-bottom mb-3">
                    <div class="col-md-5 ms-auto mb-3">
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                            <p class="mb-0">Sub Total</p>
                            <p class="text-dark fw-medium mb-2">$5500</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                            <p class="mb-0">Discount (0%)</p>
                            <p class="text-dark fw-medium mb-2">$400</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                            <p class="mb-0">VAT (5%)</p>
                            <p class="text-dark fw-medium mb-2">$54</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                            <h5>Total Amount</h5>
                            <h5>$5775</h5>
                        </div>
                        <p class="fs-12">
                            Amount in Words : Dollar Five thousand Seven Seventy Five
                        </p>
                    </div>
                </div>
                <div class="row align-items-center border-bottom mb-3">
                    <div class="col-md-7">
                        <div>
                            <div class="mb-3">
                                <h6 class="mb-1">Terms and Conditions</h6>
                                <p>Please pay within 15 days from the date of invoice, overdue interest @ 14%
                                    will be charged on delayed payments.</p>
                            </div>
                            <div class="mb-3">
                                <h6 class="mb-1">Notes</h6>
                                <p>Please quote invoice number when remitting funds.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="text-end">
                            <img src="{{ asset('assets') }}/img/sign.svg" class="img-fluid" alt="sign">
                        </div>
                        <div class="text-end mb-3">
                            <h6 class="fs-14 fw-medium pe-3">Ted M. Davis</h6>
                            <p>Assistant Manager</p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="mb-3">
                        <img src="{{ asset('assets') }}/img/logo.svg" width="130" class="img-fluid"
                            alt="logo">
                    </div>
                    <p class="text-dark mb-1">Payment Made Via bank transfer / Cheque in the name of Thomas
                        Lawler</p>
                    <div class="d-flex justify-content-center align-items-center">
                        <p class="fs-12 mb-0 me-3">Bank Name : <span class="text-dark">HDFC Bank</span></p>
                        <p class="fs-12 mb-0 me-3">Account Number : <span class="text-dark">45366287987</span>
                        </p>
                        <p class="fs-12">IFSC : <span class="text-dark">HDFC0018159</span></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Invoices -->
    </div>

    <!-- jQuery -->
    <script>
        window.onload = function() {
            window.print(); // Membuka dialog cetak otomatis
        };
    </script>

    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets') }}/js/feather.min.js" type="text/javascript"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets') }}/js/jquery.slimscroll.min.js" type="text/javascript"></script>

    <!-- Datatable JS -->
    <script src="{{ asset('assets') }}/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets') }}/js/moment.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets') }}/js/bootstrap.bundle.min.js" type="text/javascript"></script>

    <!-- Summernote JS -->
    <script src="{{ asset('assets') }}/plugins/summernote/summernote-bs4.min.js" type="text/javascript"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js" type="text/javascript"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets') }}/js/theme-colorpicker.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/js/script.js" type="text/javascript"></script>
</body>

</html>
