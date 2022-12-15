<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Smartphone Market</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="/../assets/img/favicon.png" rel="icon">
    <link href="/../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/../assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="/../assets/vendor/toastr/toastr.css" rel="stylesheet">
    <link href="/../assets/vendor/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/../assets/vendor/bootstrap-select/ajax-bootstrap-select/css/ajax-bootstrap-select.min.css" rel="stylesheet">
    <link href="/../assets/css/style.css" rel="stylesheet">

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="/../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="/../assets/vendor/php-email-form/validate.js"></script>
    <script src="/../assets/vendor/quill/quill.min.js"></script>
    <script src="/../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="/../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="/../assets/vendor/chart.js/chart.min.js"></script>
    <script src="/../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="/../assets/vendor/echarts/echarts.min.js"></script>
    <script src="/../assets/vendor/toastr/toastr.js"></script>

    <script src="/../assets/vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="/../assets/vendor/bootstrap-select/ajax-bootstrap-select/js/ajax-bootstrap-select.min.js"></script>

    <!-- Template Main JS File -->
    <script src="/../assets/js/main.js"></script>

</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="/index" class="logo d-flex align-items-center">
            <img src="/../assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">Smartphone Market</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->



            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="/../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>Kevin Anderson</h6>
                        <span>Web Designer</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                            <i class="bi bi-question-circle"></i>
                            <span>Need Help?</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="/index">
                <i class="bi bi-grid"></i>
                <span>HOME</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link " href="/admanagement/create">
                <i class="bi bi-journal-text"></i>
                <span>CREATE AD</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link " data-bs-target="#reports-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>REPORTS</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="/report/numberOfAds" class="active">
                        <i class="bi bi-circle"></i><span>Number of ads</span>
                    </a>
                </li>
                <li>
                    <a href="/report/brands" class="active">
                        <i class="bi bi-circle"></i><span>Brands</span>
                    </a>
                </li>
                <li>
                    <a href="/report/adsPerBrand" class="active">
                        <i class="bi bi-circle"></i><span>Ads Per Brands</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>

</aside><!-- End Sidebar-->

<main id="main" class="main">
    {{ renderBody }}
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

</body>

</html>