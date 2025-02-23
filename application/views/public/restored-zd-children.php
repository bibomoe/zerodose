<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Zero Dosed'; ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/logo.png'); ?>" type="image/x-icon">
    <!-- <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png"> -->
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/iconly.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/extensions/simple-datatables/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/table-datatable.css'); ?>">
    <script src="<?= base_url('assets/extensions/jquery/jquery.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/extensions/flatpickr/flatpickr.min.css'); ?>">

    <script src="<?= base_url('assets/compiled/js/chart.js'); ?>"></script>

    <link rel="stylesheet" href="<?= base_url('assets/extensions/leaflet/leaflet.css'); ?>">
    <script src="<?= base_url('assets/extensions/leaflet/leaflet.js'); ?>"></script>
    <script src="<?= base_url('assets/extensions/leaflet/turf.min.js'); ?>"></script>

    <script src="<?= base_url('assets/extensions/xlsx/xlsx.full.min.js'); ?>"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script> -->


    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap JS (wajib ada) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <meta name="csrf_token" content="<?= $this->security->get_csrf_hash(); ?>">

    <style>
            body {
                font-family: 'Nunito', sans-serif;
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .navbar-custom {
                background-color: #fff;
            }

            .navbar-custom .navbar-brand,
            .navbar-custom .navbar-nav .nav-link {
                color: #333;
            }

            .btn-custom {
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 25px;
                padding: 10px 25px;
                font-weight: bold;
            }

            .btn-custom:hover {
                background-color: #0056b3;
                color: white;
            }

            /* .hero-section {
                background-color: #f8f9fa;
                padding: 5rem 0;
                text-align: center;
            }

            .hero-image {
                max-width: 800px;
                margin: 0 auto;
            } */
            /* Background Gradient */
            .hero-section {
                margin-top: 0px; /* Adjust this value as needed */
                background: linear-gradient(to right, #F0F2F5,rgb(228, 244, 255));
                /* min-height: 100vh; */
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                text-align: left;
                padding: 150px 0;
            }

            /* Typography */
            .hero-section h1 {
                font-size: 3rem;
                font-weight: 700;
                color: #2A2E5B;
            }

            .hero-section p {
                font-size: 1.2rem;
                color: #555;
            }

            /* Buttons */
            .btn-primary {
                background-color: #2A2E5B;
                border: none;
                padding: 12px 25px;
                font-size: 1rem;
                border-radius: 50px;
                box-shadow: 0 5px 15px rgba(42, 46, 91, 0.3);
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #1E2A5B;
                box-shadow: 0 8px 20px rgba(42, 46, 91, 0.4);
            }

            .btn-outline-primary {
                border-color: #1E2A5B; /* Warna biru */
                color: #1E2A5B; /* Warna teks biru */
                background-color: transparent;
                border-radius: 25px; /* Buat tombol lebih bulat */
                padding: 10px 20px; /* Sesuaikan ukuran padding */
                font-weight: bold;
                transition: all 0.3s ease-in-out;
            }

            .btn-outline-primary:hover {
                background-color: #1E2A5B;
                color: #fff;
            }


            /* Hero Image */
            .hero-image {
                width: 100%;
                max-width: 400px;
                animation: float 3s infinite ease-in-out;
                margin: auto;
            }

            /* Floating Animation */
            /* @keyframes float {
                0% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0); }
            } */

            /* Navigation */
            .navbar {
                background: transparent;
                /* background: linear-gradient(to right, #F0F2F5,rgb(228, 244, 255)); */
                /* background: transparent; */
                position: absolute;
                width: 100%;
                z-index: 1000;
                padding: 20px 0;
            }

            .navbar a {
                font-size: 1rem;
                font-weight: bold;
                color: #2A2E5B;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .hero-section {
                    flex-direction: column;
                    text-align: center;
                }

                .hero-image {
                    width: 80%;
                    margin-top: 30px;
                }

                .navbar .header-top-left {
                    display: flex;
                    justify-content: center;
                    margin-bottom: 10px;
                }

                .navbar .header-top-right {
                    display: flex;
                    justify-content: center;
                }

                .dropdown-menu {
                    min-width: 150px;
                    text-align: center;
                }

                .language-toggle {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    margin-left: 0;
                    justify-content: center;
                }

                .language-toggle img {
                    width: 25px;
                    height: 15px;
                }
            }

            /* Floating Animation */
            @keyframes float {
                0% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
                100% { transform: translateY(0); }
            }

            /* Language Toggle */
            .dropdown-toggle {
                background: transparent;
                border: none;
                font-size: 1rem;
                color: #333;
                display: flex;
                align-items: center;
            }

            .dropdown-toggle img {
                width: 25px;
                margin-right: 5px;
            }

            .dropdown-menu {
                min-width: 150px;
            }

            .dropdown-item {
                display: flex;
                align-items: center;
            }

            .dropdown-item img {
                width: 20px;
                margin-right: 10px;
            }


            .language-toggle {
                display: flex;
                align-items: center;
                gap: 10px;
                cursor: pointer;
                margin-left: 15px;
            }

            .language-toggle img {
                width: 30px;
                height: 20px;
                border-radius: 3px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            }

            .header-top-right {
                display: flex;
                align-items: center;
                justify-content: flex-end;
            }

            .header-top-left {
                display: flex;
                align-items: center;
                justify-content: flex-start;
            }

            .header-top-right .btn {
                margin-left: auto;
            }

            .public-dashboard-section {
                padding: 4rem 0;
                background: linear-gradient(135deg, #c5cae9, #bbdefb);


                color: white;
                animation: fadeInUp 1s ease-in-out;
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .public-dashboard-section h2 {
                font-size: 2.5rem;
                font-weight: bold;
                margin-bottom: 1rem;
            }

            .public-dashboard-section p {
                /* color: #2c3e50; */
                color: #333; /* Sama dengan warna teks di hero section */
                font-size: 1.2rem;
                margin-bottom: 2rem;
            }

            .public-dashboard-section .btn-custom {
                padding: 10px 20px;
                font-weight: bold;
                background-color: #ffffff;
                color: #2c3e50;
                border: none;
                border-radius: 25px;
                text-transform: uppercase;
            }

            .public-dashboard-section .btn-custom:hover {
                background-color: #ffffff;
                color: #0056b3;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }


            .public-dashboard-section img {
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                border-radius: 10px;
            }


            @media (max-width: 768px) {
                .public-dashboard-section .row {
                    flex-direction: column;
                    text-align: center;
                }

                .public-dashboard-section img {
                    margin-bottom: 1.5rem;
                }
            }

            .label-class {
                font-size: 12px;
                font-weight: bold;
                color: #000; /* Warna teks hitam untuk keterbacaan */
                text-shadow: 
                    -1px -1px 0 #fff,  /* Garis luar putih di kiri atas */
                    1px -1px 0 #fff,  /* Garis luar putih di kanan atas */
                    -1px  1px 0 #fff,  /* Garis luar putih di kiri bawah */
                    1px  1px 0 #fff;  /* Garis luar putih di kanan bawah */
                white-space: nowrap; /* Hindari teks terpotong */
                text-align: center;
            }
    </style>
</head>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <!-- <header>
                <div class="header-top">
                    <div class="container">
                        <div class="logo">
                            <a href="">
                                <img src="<?= base_url('assets/compiled/svg/logo-rshs.png'); ?>" alt="Logo" style="width: 100px; height: auto;"> 
                            </a>
                        </div>
                        <div class="header-top-right">
                            <div class="language-toggle" id="language-toggle">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Flag_of_Indonesia.svg/2560px-Flag_of_Indonesia.svg.png" alt="Indonesian Flag" id="lang-id">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/2560px-Flag_of_the_United_States.svg.png" alt="English Flag" id="lang-en" style="display: none;">
                            </div>
                            <a href="<?= base_url('landing/login'); ?>" class="btn btn-outline-primary">Login</a>
                        </div>
                    </div>
                </div>
            </header> -->
            <div class="page-heading">
                
                <nav class="navbar">
                        <div class="container d-flex justify-content-between align-items-center">
                            
                        <div class="header-top-left">
                            <a href="#" class="logo">
                                <img src="<?= base_url('assets/kemenkes.png'); ?>" alt="Logo" style="width: 120px; height: auto; margin-right: 10px;">
                            </a>
                            <!-- <a href="#" class="logo">
                                <img src="<?= base_url('assets/gavi_full_logo.png'); ?>" alt="Logo" style="width: 150px; height: auto; margin-right: 20px;">
                            </a> -->
                            <a href="#" class="logo">
                                <img src="<?= base_url('assets/imunisasi_lengkap.png'); ?>" alt="Logo" style="width: 100px; height: auto; margin-right: 10px;">
                            </a>
                            <a href="#" class="logo">
                                <img src="<?= base_url('assets/logo.png'); ?>" alt="Logo" style="width: 80px; height: auto; margin-right: 20px;">
                            </a>
                            <a href="#" class="logo">
                                <img src="<?= base_url('assets/undp-logo-blue.svg'); ?>" alt="Logo" style="width: 30px; height: auto; margin-right: 20px;">
                            </a>
                            <a href="#" class="logo">
                                <img src="<?= base_url('assets/who.svg'); ?>" alt="Logo" style="width: 100px; height: auto; margin-right: 20px;">
                            </a>
                            <a href="#" class="logo">
                                <img src="<?= base_url('assets/UNICEF_Logo.png'); ?>" alt="Logo" style="width: 100px; height: auto; margin-right: 10px;">
                            </a>
                            
                        </div>

                            <div class="header-top-right">
                                <!-- Language Toggle -->
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img id="current-lang" src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Flag_of_Indonesia.svg/2560px-Flag_of_Indonesia.svg.png" width="20" alt="Current Language">
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                                        <li><a class="dropdown-item lang-option" href="#" data-lang="en"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Flag_of_the_United_States.svg/2560px-Flag_of_the_United_States.svg.png" width="20"> English</a></li>
                                        <li><a class="dropdown-item lang-option" href="#" data-lang="id"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Flag_of_Indonesia.svg/2560px-Flag_of_Indonesia.svg.png" width="20"> Bahasa Indonesia</a></li>
                                    </ul>
                                </div>
                                <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline-primary">Login</a>
                            </div>
                        </div>
                </nav>

                
                <!-- <div class="page-content">  -->
                    <section class="hero-section">
                        <div class="col-12 col-lg-12">
                            <!-- Filter -->
                            <div class="row m-4">
                                <div class="col-12" style="margin-bottom: 20px;">
                                    <!-- <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body"> -->
                                            <?php
                                                // var_dump($selected_province);
                                            ?>
                                            <?= form_open('PublicDashboard', ['method' => 'get']) ?>
                                                <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;"><?= $translations['filter_label'] ?>​</label>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    <?= form_dropdown('province', 
                                                        array_column($provinces, 'name_id', 'id'), 
                                                        $selected_province, 
                                                        ['class' => 'form-select', 'id' => 'provinceFilter', 'style' => 'width: 100%; max-width: 300px; height: 48px; font-size: 1rem;']
                                                    ); ?>
                                                    <?= form_dropdown(
                                                            'year', 
                                                            [2025 => '2025', 2024 => '2024'], 
                                                            set_value('year', $selected_year ?? 2025), 
                                                            'class="form-select" style="width: 100%; max-width: 150px; height: 48px; font-size: 1rem;" required'
                                                        ); ?>
                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                        <i class="bi bi-filter"></i> Submit
                                                    </button>
                                                </div>
                                            <?= form_close() ?>
                                        <!-- </div>
                                    </div> -->
                                </div>
                            </div>

                            <!-- PETA -->
                            <div class="row m-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4><?= $translations['text18'] ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- <div class="googlemaps">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d107.57311654129782!3d-6.903273917028756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1633023222539!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                            </div> -->
                                            <?php
                                                // var_dump($immunization_data);
                                            ?>
                                            <div id="map" style="height: 400px; position: relative;  z-index: 1;" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .highlight {
                                    font-size: 1.5rem;
                                    /* font-weight: 700; */
                                    /* color: #0056b3; */
                                }
                                .small-text {
                                    font-size: 1rem;
                                }
                                .card-body h6 {
                                    margin-bottom: 1rem;
                                }
                                .card-body .card-number {
                                    font-size: 1.5rem;
                                    /* font-weight: 700; */
                                    /* color: #0056b3; */
                                }
                                .card-body .card-subtext {
                                    font-size: 0.875rem;
                                    color: #6c757d;
                                }
                                .card-body .row {
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                }
                                .card-body .col-md-4 {
                                    text-align: center;
                                }
                            </style>

                            <!-- DPT1 dan ZD -->
                            <div class="row m-4">

                                    <!-- Target Year -->
                                    <div class="col-6 col-lg-4 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                        <div class="stats-icon purple mb-2">
                                                            <i class="iconly-boldUser1"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                        <h6 class="text-muted font-semibold"><?= $translations['text1'] ?> <?= $year; ?></h6>
                                                        <div class="card-number font-extrabold mb-0"><?= number_format(${"total_target_dpt_1_$year"}); ?></div>
                                                        <div class="card-subtext"><?= $translations['text2'] ?> <?= $year; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- DPT-1 Coverage -->
                                    <div class="col-6 col-lg-4 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                        <div class="stats-icon blue mb-2">
                                                            <i class="iconly-boldPlus"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                        <h6 class="text-muted font-semibold"><?= $translations['text3'] ?> <?= $year; ?></h6>
                                                        <div class="card-number font-extrabold mb-0"><?= number_format(${"total_dpt_1_$year"}); ?></div>
                                                        <div class="card-subtext">
                                                            <?= ${"total_target_dpt_1_$year"} > 0 
                                                                ? round((${"total_dpt_1_$year"} / ${"total_target_dpt_1_$year"}) * 100, 1) . $translations['text4']
                                                                : '0% of the target'; 
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Zero Dose -->
                                    <div class="col-6 col-lg-4 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                        <div class="stats-icon red mb-2">
                                                            <i class="iconly-boldProfile"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                        <h6 class="text-muted font-semibold"><?= $translations['text5'] ?> <?= $year; ?></h6>
                                                        <div class="card-number font-extrabold mb-0"><?= number_format(${"zero_dose_$year"}); ?></div>
                                                        <div class="card-subtext"><?= ${"zd_narrative_$year"}; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <!-- DPT 3 dan MR1 -->
                            <div class="row m-4">
                                    <!-- DPT-3 Coverage -->
                                    
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <h6 class="text-muted font-semibold"><?= $translations['text10'] ?> <?= $year; ?></h6>
                                                <div class="card-number font-extrabold mb-3"><?= number_format(${"total_dpt_3_$year"}); ?></div>
                                                <div class="card-subtext mb-1"><?= ${"percent_dpt_3_$year"}; ?><?= $translations['text11'] ?></div>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                        style="width: <?= ${"percent_dpt_3_$year"}; ?>%;" 
                                                        aria-valuenow="<?= ${"percent_dpt_3_$year"}; ?>" 
                                                        aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="mt-1 text-muted mb-4"><?= number_format(${"missing_dpt_3_$year"}); ?> <?= $translations['text12'] ?> DPT-3</div>

                                                <!-- Baseline and Target Coverage -->
                                                <div class="mt-1">
                                                    <p><strong>Baseline: </strong><?= number_format(${"total_target_dpt_3_$year"}); ?> <?= $translations['children'] ?></p>
                                                    <p><strong><?= $translations['text13'] ?> <?= ($year == 2024) ? '90%' : '95%'; ?> </strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MR-1 Coverage -->
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <h6 class="text-muted font-semibold"><?= $translations['text14'] ?> <?= $year; ?></h6>
                                                <div class="card-number font-extrabold mb-3"><?= number_format(${"total_mr_1_$year"}); ?></div>
                                                <div class="card-subtext mb-1"><?= ${"percent_mr_1_$year"}; ?> <?= $translations['text11'] ?></div>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                        style="width: <?= ${"percent_mr_1_$year"}; ?>%;" 
                                                        aria-valuenow="<?= ${"percent_mr_1_$year"}; ?>" 
                                                        aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="mt-1 text-muted mb-4"><?= number_format(${"missing_mr_1_$year"}); ?> <?= $translations['text12'] ?> MR-1</div>

                                                <!-- Baseline and Target Coverage -->
                                                <div class="mt-1">
                                                    <p><strong>Baseline: </strong><?= number_format(${"total_target_mr_1_$year"}); ?> <?= $translations['children'] ?></p>
                                                    <p><strong><?= $translations['text13'] ?> <?= ($year == 2024) ? '90%' : '95%'; ?> </strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            
                        </div>
                    </section>
                <!-- </div> -->
            </div>
        </div>
    </div>

<!-- SCRIPT PETA -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('map').setView([-7.250445, 112.768845], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let immunizationData = <?= json_encode($immunization_data, JSON_NUMERIC_CHECK); ?>;
        // console.log(immunizationData);
        
        function cleanCityCode(code) { 
            if (!code) return ""; 
            return String(code).replace(/\./g, ''); 
        }

        function formatValue(value, isPercentage = false) {
            if (isNaN(value) || value === null || value === undefined) {
                return isPercentage ? "0%" : "0";
            }
            return isPercentage ? value.toFixed(1) + "%" : value;
        }

        function getColor(percentReductionZD) {
            // let threshold = isProvince ? 10000 : 1000;
            // return dpt1 > threshold ? '#1A9850' : '#D73027';
            return percentReductionZD > 85 ? '#1A9850' : '#D73027';
        }

        let isProvinceLevel = ["all", "targeted"].includes("<?= $selected_province ?>");

        fetch("<?= $geojson_file; ?>")
        .then(response => response.json())
        .then(data => {
            let geojsonLayer = L.geoJSON(data, {
                style: function (feature) {
                    let rawCode = isProvinceLevel 
                        ? feature.properties.KDPPUM  
                        : feature.properties.KDPKAB; 

                    let regionId = cleanCityCode(rawCode);
                    let regionData = immunizationData[regionId] || {}; 

                    let dpt1 = formatValue(regionData.dpt1);
                    let percentReductionZD  = formatValue(regionData.percent_reduction);
                    // console.log(percentReductionZD);

                    return {
                        fillColor: getColor(percentReductionZD),
                        weight: 1.5,
                        opacity: 1,
                        color: '#ffffff',
                        fillOpacity: 0.8
                    };
                },
                onEachFeature: function (feature, layer) {
                    let rawCode = isProvinceLevel 
                        ? feature.properties.KDPPUM  
                        : feature.properties.KDPKAB;  

                    let regionId = cleanCityCode(rawCode);
                    let regionData = immunizationData[regionId] || {}; 
                    // console.log(regionData);

                    let dpt1 = formatValue(regionData.dpt1);
                    let dpt2 = formatValue(regionData.dpt2);
                    let dpt3 = formatValue(regionData.dpt3);
                    let mr1  = formatValue(regionData.mr1);
                    let zeroDoseChildren = formatValue(regionData.zero_dose_children);
                    let percentZD = formatValue(regionData.percent_zero_dose, true);

                    let dpt1Coverage = formatValue(regionData.percentage_target_dpt1, true);
                    let dpt3Coverage = formatValue(regionData.percentage_target_dpt3, true);
                    let mr1Coverage  = formatValue(regionData.percentage_target_mr1, true);

                    let zd2023 = formatValue(regionData.zd_children_2023);
                    let percentReductionZD  = formatValue(regionData.percent_reduction, true);

                    let name = isProvinceLevel 
                        ? feature.properties.WADMPR  
                        : feature.properties.NAMOBJ;  

                    // let popupContent = `<b>${name}</b><br>
                    //                     DPT1 Coverage: ${dpt1}<br>
                    //                     DPT2 Coverage: ${dpt2}<br>
                    //                     DPT3 Coverage: ${dpt3} (Coverage: ${dpt3Coverage})<br>
                    //                     MR1 Coverage: ${mr1} (Coverage: ${mr1Coverage})<br>
                    //                     Zero Dose Children: ${zeroDoseChildren}<br>
                    //                     % Zero Dose: ${percentZD}`;

                    let popupContent = `<b>${name}</b><br>
                                        DPT1 Coverage: ${dpt1} (Coverage: ${dpt1Coverage})<br>
                                        DPT3 Coverage: ${dpt3} (Coverage: ${dpt3Coverage})<br>
                                        MR1 Coverage: ${mr1} (Coverage: ${mr1Coverage})<br>
                                        Zero Dose Children: ${zeroDoseChildren}<br>
                                        % Zero Dose: ${percentZD}<br>
                                        Zero Dose Children 2023: ${zd2023}<br>
                                        % Reduction From ZD 2023: ${percentReductionZD}`;
                                        
                    
                    // Jika ini level provinsi, tambahkan tombol
                    if (isProvinceLevel) {
                        let selectedYear = "<?= $selected_year ?>"; // Ambil dari PHP

                        popupContent += `<br><br>
                            <a href="<?= base_url('PublicDashboard'); ?>?year=${selectedYear}&province=${regionId}&get_detail=1" target="">
                                <button class="btn btn-primary btn-sm">View Details</button>
                            </a>`;
                    }

                    layer.bindPopup(popupContent);

                    if (feature.geometry.type === "Polygon" || feature.geometry.type === "MultiPolygon") {
                        try {
                            let labelPoint = turf.pointOnFeature(feature);
                            let latlng = [labelPoint.geometry.coordinates[1], labelPoint.geometry.coordinates[0]];
                            
                            // let labelSize = adjustLabelSize(map.getZoom()); // Adjust size based on current zoom level

                            if (feature.properties.NAMOBJ) {
                                let label = L.divIcon({
                                    className: 'label-class',
                                    html: `<strong style="font-size: 9px;">${feature.properties.NAMOBJ}</strong>`,
                                    iconSize: [100, 20]
                                });
                                L.marker(latlng, { icon: label }).addTo(map);
                            } else if (feature.properties.WADMPR) { 
                                let label = L.divIcon({
                                    className: 'label-class',
                                    html: `<strong style="font-size: 8px;">${feature.properties.WADMPR}</strong>`,
                                    iconSize: [50, 15]
                                });
                                L.marker(latlng, { icon: label }).addTo(map);
                            }
                        } catch (error) {
                            console.warn("Turf.js error while generating label:", error, feature);
                        }
                    }
                }
            }).addTo(map);

            map.fitBounds(geojsonLayer.getBounds());
        })
        .catch(error => console.error("Error loading GeoJSON:", error));
    });

</script>

<script>
        document.addEventListener("DOMContentLoaded", function () {
            const langOptions = document.querySelectorAll(".lang-option");
            const currentLangImg = document.getElementById("current-lang");

            function updateLanguage(lang, imgSrc) {
                // Cek apakah bahasa yang dipilih berbeda dari yang sebelumnya
                const currentLang = localStorage.getItem("selectedLanguage");

                if (lang !== currentLang) {
                    // Simpan bahasa yang dipilih ke localStorage
                    localStorage.setItem("selectedLanguage", lang);

                    // Perbarui gambar bahasa yang dipilih
                    currentLangImg.src = imgSrc;

                    // Ambil CSRF token dari meta tag atau hidden field
                    const csrfToken = document.querySelector('meta[name="csrf_token"]').getAttribute('content');

                    // Kirim bahasa yang dipilih ke server menggunakan fetch
                    fetch("<?= base_url('PublicDashboard/set_language'); ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: `language=${lang}&csrf_test_name=${csrfToken}`
                    }).then(response => {
                        if (response.ok) {
                            // Setelah bahasa berhasil dikirim ke server, refresh halaman
                            window.location.reload(); // Halaman akan di-refresh setelah bahasa dipilih
                        } else {
                            console.error("Failed to set language.");
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                    });
                }
            }

            // Inisialisasi bahasa berdasarkan localStorage
            let savedLang = localStorage.getItem("selectedLanguage");

            // Jika bahasa tidak ada di localStorage, set bahasa default dan kirim ke server
            if (!savedLang) {
                savedLang = 'en'; // Atur bahasa default ke 'en' (english)
                const defaultLangOption = document.querySelector(`.lang-option[data-lang="${savedLang}"] img`);
                const defaultLangImgSrc = defaultLangOption ? defaultLangOption.src : ''; // Mendapatkan gambar bendera default
                updateLanguage(savedLang, defaultLangImgSrc); // Ubah gambar dan kirim ke server
            } else {
                // Update gambar bahasa yang disimpan
                const savedLangOption = document.querySelector(`.lang-option[data-lang="${savedLang}"] img`);
                if (savedLangOption) {
                    currentLangImg.src = savedLangOption.src; // Update gambar bahasa yang disimpan
                }
                // // Tetap update bahasa walaupun sudah ada di localStorage
                // updateLanguage(savedLang, savedLangOption.src);
            }

            langOptions.forEach(option => {
                option.addEventListener("click", function (e) {
                    e.preventDefault();
                    const selectedLang = this.getAttribute("data-lang");
                    const imgSrc = this.querySelector("img").src;
                    updateLanguage(selectedLang, imgSrc);  // Panggil fungsi untuk memperbarui bahasa
                });
            });

            // Set bahasa yang tersimpan sebelumnya jika ada
            // const savedLang = localStorage.getItem("selectedLanguage") || 'en';
            // const savedLangOption = document.querySelector(`.lang-option[data-lang="${savedLang}"] img`);
            // if (savedLangOption) {
            //     currentLangImg.src = savedLangOption.src; // Update gambar bahasa yang disimpan
            // }
        });



    </script>

</body>

</html>
