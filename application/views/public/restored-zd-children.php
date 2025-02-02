<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'My Website'; ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/compiled/svg/favicon.svg'); ?>" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/iconly.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/extensions/simple-datatables/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/table-datatable.css'); ?>">
    <script src="<?= base_url('assets/extensions/jquery/jquery.min.js'); ?>"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?= base_url('assets/extensions/flatpickr/flatpickr.min.css'); ?>">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6.5.0/turf.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/leaflet-textpath@1.2.0/leaflet.textpath.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <style>
        /*!
        * Template Mazer - Bootstrap 5
        * Copyright (c) 2021-current Ahmad Saugi
        * Licensed under MIT (https://opensource.org/licenses/MIT)
        */
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

        .floating-button {
            position: absolute;
            top: 20px;
            right: 0px;
            z-index: 1;
        }

        .language-toggle img {
            width: 30px;
            height: 20px;
            border-radius: 3px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header>
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
            </header>


                
                <div class="page-content"> 
                    <section class="row m-3">
                        <div class="col-12 col-lg-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body">
                                            <label for="groupFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;">Vaccine Coverage</label>
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                <select id="groupFilter" class="form-select" style="width: 100%; max-width: 300px; height: 48px; font-size: 1rem;">
                                                    <option value="" disabled >Select Vaccine</option>
                                                    <option selected>DPT1</option>
                                                    <option>DPT3</option>
                                                    <option>MR1</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                    <i class="bi bi-filter"></i> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                    Total children immunized with DPT 1</h6>
                                                    <h6 class="font-extrabold mb-0">50.000</h6>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card"> 
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldProfile"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Group A</h6>
                                                    <h6 class="font-extrabold mb-0">25.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="iconly-boldProfile"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Group B</h6>
                                                    <h6 class="font-extrabold mb-0">15.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldProfile"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Group C</h6>
                                                    <h6 class="font-extrabold mb-0">10.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>District with the highest number of restored children</h4>
                                        </div>
                                        <!-- <div class="card-body">
                                            <div id="chart-profile-visit"></div>
                                        </div> -->
                                        <div class="card-body">
                                            <button class="btn btn-primary floating-button" data-bs-toggle="modal"
                                                data-bs-target="#tableFilter">
                                                <i class="bi bi-funnel"></i> Filter
                                            </button>
                                            <!-- Filter Modal -->
                                            <div class="modal fade text-left" id="tableFilter" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel33">Filter Table </h4>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                        <form action="#">
                                                            <div class="modal-body">
                                                                <label for="groupFilter">Group: </label>
                                                                <div class="form-group">
                                                                    <select id="groupFilter" class="form-select">
                                                                        <option selected>All Group</option>
                                                                        <option>Group A</option>
                                                                        <option>Group B</option>
                                                                        <option>Group C</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!-- <button type="button" class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button> -->
                                                                <button type="button" class="btn btn-primary ms-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Apply</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="table table-striped" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th>District</th>
                                                        <th>Total</th>
                                                        <th>% of Total Target</th>
                                                        <th>per 100,000 targets</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Kota Jember</td>
                                                    <td>20,000</td>
                                                    <td>20%</td>
                                                    <td>23.5</td>
                                                </tr>
                                                <tr>
                                                    <td>Kab. Malang</td>
                                                    <td>15,000</td>
                                                    <td>15%</td>
                                                    <td>10.5</td>
                                                </tr>
                                                <tr>
                                                    <td>Kota Malang</td>
                                                    <td>10,000</td>
                                                    <td>18%</td>
                                                    <td>8.9</td>
                                                </tr>
                                                <tr>
                                                    <td>Kab. Kediri</td>
                                                    <td>7,000</td>
                                                    <td>29%</td>
                                                    <td>7.6</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Restored ZD children mapping</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="googlemaps">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d107.57311654129782!3d-6.903273917028756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1633023222539!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Zero-Dose Cases in Group A</h4>
                                        </div>
                                        <div class="card-body">
                                        <button class="btn btn-primary floating-button" data-bs-toggle="modal"
                                                data-bs-target="#chartFilter">
                                                <i class="bi bi-funnel"></i> Filter
                                            </button>
                                            <!-- Filter Modal -->
                                            <div class="modal fade text-left" id="chartFilter" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel33">Filter Chart </h4>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                        <form action="#">
                                                            <div class="modal-body">
                                                                <label for="groupFilter">Group: </label>
                                                                <div class="form-group">
                                                                    <select id="groupFilter" class="form-select">
                                                                        <option selected>All Group</option>
                                                                        <option>Group A</option>
                                                                        <option>Group B</option>
                                                                        <option>Group C</option>
                                                                    </select>
                                                                </div>
                                                                <label for="districtFilter" class="form-label">District:</label>
                                                                <div class="form-group">
                                                                    <select id="districtFilter" class="form-select">
                                                                        <option selected>All District</option>
                                                                        <option>Kota Jember</option>
                                                                        <option>Kab. Malang</option>
                                                                        <option>Kota Malang</option>
                                                                        <option>Kab. Kediri</option>
                                                                    </select>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!-- <button type="button" class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button> -->
                                                                <button type="button" class="btn btn-primary ms-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Apply</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <canvas id="zdChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Number of Restored Children by Gender</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="genderChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Number of Restored Children by Place of Residence</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="locationChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Number of Restored Children by Group Age</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="ageChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </section>
            </div>
        </div>
    </div>

    <script>
            // Chart.js setup for zdChart
            const zdCtx = document.getElementById('zdChart').getContext('2d');
            const zdChart = new Chart(zdCtx, {
                type: 'line',
                data: {
                    labels: ['Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    datasets: [{
                        label: 'ZD Cases',
                        data: [3000, 2800, 2500, 2200, 2000],
                        backgroundColor: 'rgba(0, 86, 179, 0.2)',
                        borderColor: 'rgba(0, 86, 179, 1)',
                        borderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'ZD Cases'
                            }
                        }
                    }
                }
            });

            // Function to create buttons dynamically for zdChart
            function addZdDownloadButtons() {
                const container = zdCtx.canvas.parentNode;

                // Create a wrapper for the buttons
                const buttonWrapper = document.createElement('div');
                buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

                // Create CSV download button
                const csvButton = document.createElement('button');
                csvButton.textContent = 'Download CSV';
                csvButton.className = 'btn btn-primary btn-sm'; // Smaller button
                csvButton.addEventListener('click', () => downloadZdCSV());

                // Create Excel download button
                const excelButton = document.createElement('button');
                excelButton.textContent = 'Download Excel';
                excelButton.className = 'btn btn-success btn-sm'; // Smaller button
                excelButton.addEventListener('click', () => downloadZdExcel());

                // Append buttons to the wrapper
                buttonWrapper.appendChild(csvButton);
                buttonWrapper.appendChild(excelButton);

                // Insert the wrapper above the chart
                container.insertBefore(buttonWrapper, zdCtx.canvas);
            }

            // Function to download CSV for zdChart
            function downloadZdCSV() {
                const labels = ['Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const data = [3000, 2800, 2500, 2200, 2000];

                let csvContent = "data:text/csv;charset=utf-8,";
                csvContent += "Months,ZD Cases\n"; // Header
                labels.forEach((label, index) => {
                    csvContent += `${label},${data[index]}\n`;
                });

                const encodedUri = encodeURI(csvContent);
                const link = document.createElement('a');
                link.setAttribute('href', encodedUri);
                link.setAttribute('download', 'zd_chart_data.csv');
                link.click();
            }

            // Function to download Excel for zdChart
            function downloadZdExcel() {
                const labels = ['Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const data = [3000, 2800, 2500, 2200, 2000];

                // Create Excel content using XLSX.js
                const workbook = XLSX.utils.book_new();
                const worksheetData = [['Months', 'ZD Cases'], ...labels.map((label, index) => [label, data[index]])];
                const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Data');

                // Generate Excel file and download
                XLSX.writeFile(workbook, 'zd_chart_data.xlsx');
            }

            // Add buttons to the DOM for zdChart
            addZdDownloadButtons();


            // Chart.js setup for genderChart
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            new Chart(genderCtx, {
                type: 'bar',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        label: 'Number of Children',
                        data: [1237, 2546],
                        backgroundColor: ['rgba(0, 86, 179, 0.7)', 'rgba(0, 179, 230, 0.7)']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Gender'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Children'
                            }
                        }
                    }
                }
            });

            // Function to create buttons dynamically for genderChart
            function addGenderDownloadButtons() {
                const container = genderCtx.canvas.parentNode;

                // Create a wrapper for the buttons
                const buttonWrapper = document.createElement('div');
                buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

                // Create CSV download button
                const csvButton = document.createElement('button');
                csvButton.textContent = 'Download CSV';
                csvButton.className = 'btn btn-primary btn-sm'; // Smaller button
                csvButton.addEventListener('click', () => downloadGenderCSV());

                // Create Excel download button
                const excelButton = document.createElement('button');
                excelButton.textContent = 'Download Excel';
                excelButton.className = 'btn btn-success btn-sm'; // Smaller button
                excelButton.addEventListener('click', () => downloadGenderExcel());

                // Append buttons to the wrapper
                buttonWrapper.appendChild(csvButton);
                buttonWrapper.appendChild(excelButton);

                // Insert the wrapper above the chart
                container.insertBefore(buttonWrapper, genderCtx.canvas);
            }

            // Function to download CSV for genderChart
            function downloadGenderCSV() {
                const labels = ['Male', 'Female'];
                const data = [1237, 2546];

                let csvContent = "data:text/csv;charset=utf-8,";
                csvContent += "Gender,Number of Children\n"; // Header
                labels.forEach((label, index) => {
                    csvContent += `${label},${data[index]}\n`;
                });

                const encodedUri = encodeURI(csvContent);
                const link = document.createElement('a');
                link.setAttribute('href', encodedUri);
                link.setAttribute('download', 'gender_chart_data.csv');
                link.click();
            }

            // Function to download Excel for genderChart
            function downloadGenderExcel() {
                const labels = ['Male', 'Female'];
                const data = [1237, 2546];

                // Create Excel content using XLSX.js
                const workbook = XLSX.utils.book_new();
                const worksheetData = [['Gender', 'Number of Children'], ...labels.map((label, index) => [label, data[index]])];
                const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Data');

                // Generate Excel file and download
                XLSX.writeFile(workbook, 'gender_chart_data.xlsx');
            }

            // Add buttons to the DOM for genderChart
            addGenderDownloadButtons();


            // Chart.js setup for locationChart
            const locationCtx = document.getElementById('locationChart').getContext('2d');
            new Chart(locationCtx, {
                type: 'bar',
                data: {
                    labels: ['Rural', 'Urban'],
                    datasets: [{
                        label: 'Number of Children',
                        data: [6375, 2746],
                        backgroundColor: ['rgba(0, 86, 179, 0.7)', 'rgba(0, 179, 230, 0.7)']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Place of Residence'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Children'
                            }
                        }
                    }
                }
            });

            // Function to create buttons dynamically for locationChart
            function addLocationDownloadButtons() {
                const container = locationCtx.canvas.parentNode;

                // Create a wrapper for the buttons
                const buttonWrapper = document.createElement('div');
                buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

                // Create CSV download button
                const csvButton = document.createElement('button');
                csvButton.textContent = 'Download CSV';
                csvButton.className = 'btn btn-primary btn-sm'; // Smaller button
                csvButton.addEventListener('click', () => downloadLocationCSV());

                // Create Excel download button
                const excelButton = document.createElement('button');
                excelButton.textContent = 'Download Excel';
                excelButton.className = 'btn btn-success btn-sm'; // Smaller button
                excelButton.addEventListener('click', () => downloadLocationExcel());

                // Append buttons to the wrapper
                buttonWrapper.appendChild(csvButton);
                buttonWrapper.appendChild(excelButton);

                // Insert the wrapper above the chart
                container.insertBefore(buttonWrapper, locationCtx.canvas);
            }

            // Function to download CSV for locationChart
            function downloadLocationCSV() {
                const labels = ['Rural', 'Urban'];
                const data = [6375, 2746];

                let csvContent = "data:text/csv;charset=utf-8,";
                csvContent += "Place of Residence,Number of Children\n"; // Header
                labels.forEach((label, index) => {
                    csvContent += `${label},${data[index]}\n`;
                });

                const encodedUri = encodeURI(csvContent);
                const link = document.createElement('a');
                link.setAttribute('href', encodedUri);
                link.setAttribute('download', 'location_chart_data.csv');
                link.click();
            }

            // Function to download Excel for locationChart
            function downloadLocationExcel() {
                const labels = ['Rural', 'Urban'];
                const data = [6375, 2746];

                // Create Excel content using XLSX.js
                const workbook = XLSX.utils.book_new();
                const worksheetData = [['Place of Residence', 'Number of Children'], ...labels.map((label, index) => [label, data[index]])];
                const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Data');

                // Generate Excel file and download
                XLSX.writeFile(workbook, 'location_chart_data.xlsx');
            }

            // Add buttons to the DOM for locationChart
            addLocationDownloadButtons();


            // Chart.js setup for ageChart
            const ageCtx = document.getElementById('ageChart').getContext('2d');
            new Chart(ageCtx, {
                type: 'bar',
                data: {
                    labels: ['3-11 Months', '12-23 Months', '24-59 Months'],
                    datasets: [{
                        label: 'Number of Children',
                        data: [2537, 4658, 2846],
                        backgroundColor: [
                            'rgba(0, 86, 179, 0.7)',
                            'rgba(0, 179, 230, 0.7)',
                            'rgba(179, 0, 230, 0.7)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Group Age'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Number of Children'
                            }
                        }
                    }
                }
            });

            // Function to create buttons dynamically for ageChart
            function addAgeDownloadButtons() {
                const container = ageCtx.canvas.parentNode;

                // Create a wrapper for the buttons
                const buttonWrapper = document.createElement('div');
                buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

                // Create CSV download button
                const csvButton = document.createElement('button');
                csvButton.textContent = 'Download CSV';
                csvButton.className = 'btn btn-primary btn-sm'; // Smaller button
                csvButton.addEventListener('click', () => downloadAgeCSV());

                // Create Excel download button
                const excelButton = document.createElement('button');
                excelButton.textContent = 'Download Excel';
                excelButton.className = 'btn btn-success btn-sm'; // Smaller button
                excelButton.addEventListener('click', () => downloadAgeExcel());

                // Append buttons to the wrapper
                buttonWrapper.appendChild(csvButton);
                buttonWrapper.appendChild(excelButton);

                // Insert the wrapper above the chart
                container.insertBefore(buttonWrapper, ageCtx.canvas);
            }

            // Function to download CSV for ageChart
            function downloadAgeCSV() {
                const labels = ['3-11 Months', '12-23 Months', '24-59 Months'];
                const data = [2537, 4658, 2846];

                let csvContent = "data:text/csv;charset=utf-8,";
                csvContent += "Group Age,Number of Children\n"; // Header
                labels.forEach((label, index) => {
                    csvContent += `${label},${data[index]}\n`;
                });

                const encodedUri = encodeURI(csvContent);
                const link = document.createElement('a');
                link.setAttribute('href', encodedUri);
                link.setAttribute('download', 'age_chart_data.csv');
                link.click();
            }

            // Function to download Excel for ageChart
            function downloadAgeExcel() {
                const labels = ['3-11 Months', '12-23 Months', '24-59 Months'];
                const data = [2537, 4658, 2846];

                // Create Excel content using XLSX.js
                const workbook = XLSX.utils.book_new();
                const worksheetData = [['Group Age', 'Number of Children'], ...labels.map((label, index) => [label, data[index]])];
                const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Data');

                // Generate Excel file and download
                XLSX.writeFile(workbook, 'age_chart_data.xlsx');
            }

            // Add buttons to the DOM for ageChart
            addAgeDownloadButtons();

    </script>
</body>

</html>
