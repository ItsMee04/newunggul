<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams Pos Admin Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets') }}/img/favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap-datetimepicker.min.css">

    <!-- animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/animate.css">

    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/feather.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/summernote/summernote-bs4.min.css">

    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/dataTables.bootstrap5.min.css">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/owlcarousel/owl.theme.default.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">

</head>

<body>
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        @include('components.header')

        @include('components.sidebar')

        @yield('content')

        <div class="customizer-links" id="setdata">
            <ul class="sticky-sidebar">
                <li class="sidebar-icons">
                    <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left"
                        data-bs-original-title="Theme">
                        <i data-feather="settings" class="feather-five"></i>
                    </a>
                </li>
            </ul>
        </div>

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets') }}/js/jquery-3.7.1.min.js" type="text/javascript"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets') }}/js/feather.min.js" type="text/javascript"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets') }}/js/jquery.slimscroll.min.js" type="text/javascript"></script>

    <!-- Datatable JS -->
    <script src="{{ asset('assets') }}/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>

    <!-- Summernote JS -->
    <script src="{{ asset('assets') }}/plugins/summernote/summernote-bs4.min.js" type="text/javascript"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.min.js" type="text/javascript"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ asset('assets') }}/js/moment.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

    <!-- Owl JS -->
    <script src="{{ asset('assets') }}/plugins/owlcarousel/owl.carousel.min.js" type="text/javascript"></script>

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{ asset('assets') }}/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js" type="text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets') }}/js/bootstrap.bundle.min.js" type="text/javascript"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets') }}/plugins/apexchart/apexcharts.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/plugins/apexchart/chart-data.js" type="text/javascript"></script>

    <!-- Sweetalert 2 -->
    <script src="{{ asset('assets') }}/plugins/sweetalert/sweetalert2.all.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/plugins/sweetalert/sweetalerts.min.js" type="text/javascript"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets') }}/js/theme-script.js" type="text/javascript"></script>
    <script src="{{ asset('assets') }}/js/script.js" type="text/javascript"></script>
</body>

</html>
