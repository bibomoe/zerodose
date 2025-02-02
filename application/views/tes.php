<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Dosed - Performance Monitoring Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/iconly.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="shortcut icon" href="<?= base_url('assets/compiled/svg/favicon.svg'); ?>" type="image/x-icon">

    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    
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

        .hero-section {
            background-color: #f8f9fa;
            padding: 5rem 0;
            text-align: center;
        }

        .hero-image {
            max-width: 800px;
            margin: 0 auto;
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

        .card-header {
            margin-bottom: 20px;
            padding: 15px 20px;
            border-bottom: 2px solid #e8e8e8;
        }
        .table th {
            background-color: #28a745;
            color: white;
            text-align: center;
            vertical-align: middle;
        }
        .table td {
            vertical-align: middle;
        }
        .card-header.bg-success {
            color: white !important;
        }
        .card-header.bg-danger {
            color: white !important;
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


            <div class="page-heading">
                <div class="main-content container mt-5">
                    <h1 class="mb-4">Immunization Dashboard</h1>

                    <!-- Table 1: Long Term Outcomes -->
                    <section class="section">
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white" style="color: white !important;">
                                <h4 style="color: white !important;">Long Term Outcomes</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Long Term Outcome</th>
                                            <th rowspan="2">Indicator</th>
                                            <th colspan="3">Indicator Value</th>
                                            <th rowspan="2">Data Source</th>
                                            <th rowspan="2">Frequency of Reporting</th>
                                        </tr>
                                        <tr>
                                            <th>Baseline</th>
                                            <th>Y1</th>
                                            <th>Y2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="7">MITIGATE<br>Coverage rates restored, including by reaching zero-dose children</td>
                                            <td rowspan="2">DPT3</td>
                                            <td rowspan="2">4,199,289</td>
                                            <td>90%</td>
                                            <td>95%</td>
                                            <td rowspan="2">Administrative Reports</td>
                                            <td rowspan="2">Quarterly</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">MR1 Coverage (additional long term indicator)</td>
                                            <td rowspan="2">4,244,731</td>
                                            <td>90%</td>
                                            <td>95%</td>
                                            <td rowspan="2">Administrative Reports</td>
                                            <td rowspan="2">Quarterly</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Reduction in zero-dose</td>
                                            <td rowspan="2">25% of 569,414 (per Dec 2022)</td>
                                            <td>Target reduction by end of year 1 (15%)</td>
                                            <td>Target reduction by end of year 2 (25%)</td>
                                            <td rowspan="2">Administrative Reports</td>
                                            <td rowspan="2">Quarterly</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td>Reduction in zero-dose</td>
                                            <td>10% of 569,414 (per Dec 2022)</td>
                                            <td>Target reduction by end of year 1 (5%)</td>
                                            <td>Target reduction by end of year 2 (10%)</td>
                                            <td>Administrative Reports</td>
                                            <td>Quarterly</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <!-- Table 2: Intermediate Outcomes -->
                    <section class="section">
                        <div class="card shadow-sm">
                            <div class="card-header bg-danger text-white">
                                <h4>Intermediate Outcomes</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Intermediate Outcomes</th>
                                            <th rowspan="2">Indicator</th>
                                            
                                            <th colspan="3">Indicator Value</th>
                                            <th rowspan="2">Data Source</th>
                                            <th rowspan="2">Frequency of Reporting</th>
                                        </tr>
                                        <tr>
                                            <th>Baseline</th>
                                            <th>Y1</th>
                                            <th>Y2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="2">Routine immunization services restored and reinforced to catch up missed children</td>
                                            <td rowspan="2">Percent of primary health facility to conduct immunization service as planned</td>
                                            <td rowspan="2">No Baseline Data (See cell comment)</td>
                                            <td>No Y1 target</td>
                                            <td>80%</td>
                                            <td rowspan="2">Indonesian Sehat Application (ASIK) digital-based</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Zero-dose children identified and targeted in reinforcement of routine immunization services</td>
                                            <td rowspan="2">DPT1 in targeted areas</td>
                                            <td rowspan="2">82.6% (10 provinces 2021)</td>
                                            <td>90%</td>
                                            <td>93%</td>
                                            <td rowspan="2">Administrative Reports</td>
                                            <td rowspan="2">Quarterly</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Community demand for & confidence in vaccines and immunization services, including among missed communities</td>
                                            <td rowspan="2">Number of district with DO (DPT1-DPT3) less than 5%</td>
                                            <td rowspan="2">62% (2021)</td>
                                            <td>75%</td>
                                            <td>85%</td>
                                            <td rowspan="2">Activity reports by EPI/health promotion unit/partners which include meeting minutes and trainee attendance</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="4">Institutional capacities to plan and deliver sustained, equitable immunization programmes, as a platform for broader PHC delivery</td>
                                            <td rowspan="2">Number of health facilities manage immunization program as per national guidance in 10 targeted provinces. The data will be retracted from Supportive supervision report (dashboard)</td>
                                            <td rowspan="2">No baseline available</td>
                                            <td>30%</td>
                                            <td>50%</td>
                                            <td rowspan="2">Supportive Supervision Report (Dashboard)</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td>Number of DTP stock out at health facilities</td>
                                            <td>No DPT vaccine stock out in 2022</td>
                                            <td>N/A</td>
                                            <td>Zero stock outs</td>
                                            <td>SMILE</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Number of private facilities trained on Immunization Program Management for Private Sectors SOP</td>
                                            <td>248 (DKI Jakarta, East Java and Central Java) - HSS report</td>
                                            <td>350</td>
                                            <td>235</td>
                                            <td >Training results</td>
                                            <td ></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Sufficient, sustained, and reliable domestic resources for immunization programmes</td>
                                            <td rowspan="2">Number of district allocated domestic funding for key immunization activities and other relevant activities to immunization program at 10 provinces</td>
                                            <td rowspan="2">No baseline available</td>
                                            <td>50%</td>
                                            <td>90%</td>
                                            <td rowspan="2">Assessment/reviews/survey/admins data</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Political commitment to & accountability for equitable immunization (including zero-dose agenda) at national & subnational levels</td>
                                            <td rowspan="2">Number of district developed or enacted policy relevant to targeting zero dose and under immunized specifically or immunization program in general</td>
                                            <td rowspan="2">No baseline available</td>
                                            <td>50%</td>
                                            <td>90%</td>
                                            <td rowspan="2">Assessment/reviews/survey</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <!-- Table 3: Grant Implementation & Budget Disbursement -->
                    <section class="section">
                        <div class="card shadow-sm">
                            <div class="card-header bg-warning text-dark">
                                <h4>Grant Implementation & Budget Disbursement</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2">Indicator</th>
                                            <th colspan="2">Indicator Value</th>
                                            <th rowspan="2">Data Source</th>
                                            <th rowspan="2">Frequency of Reporting</th>
                                        </tr>
                                        <tr>
                                            <th>Y1</th>
                                            <th>Y2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="2">Budget execution (use) rate for a given reporting period, Gavi</td>
                                            <td>90%</td>
                                            <td>90%</td>
                                            <td rowspan="2">Costed Workplan</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Budget execution (use) rate for a given reporting period, domestic</td>
                                            <td>90%</td>
                                            <td>90%</td>
                                            <td rowspan="2">Reports from implementing partners, including MoH</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Timely disbursement of funds reaching sub-national level, Gavi</td>
                                            <td>n/a</td>
                                            <td>n/a</td>
                                            <td rowspan="2">Costed Workplan</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Timely disbursement of funds reaching sub-national level, domestic</td>
                                            <td>n/a</td>
                                            <td>n/a</td>
                                            <td rowspan="2">Reports from implementing partners, including MoH</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Funding allocated to civil society and community organizations</td>
                                            <td>n/a</td>
                                            <td>n/a</td>
                                            <td rowspan="2">Reports from implementing partners, including MoH</td>
                                            <td rowspan="2">[select from dropdown]</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>


                    <!-- Table 4: Country Objectives -->
                    <section class="section">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h4>Country Objectives</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th rowspan="2">Objective</th>
                                            <th rowspan="2">Indicator</th>
                                            <th colspan="2">Indicator Value</th>
                                            <th rowspan="2">Data Source</th>
                                            <th rowspan="2">Frequency of Reporting</th>
                                        </tr>
                                        <tr>
                                            <th>Y1</th>
                                            <th>Y2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="2">1. Improve subnational capacity in planning, implementing and monitoring to catch-up vaccination</td>
                                            <td rowspan="2">Percent of workplan activities executed</td>
                                            <td>90%</td>
                                            <td>100%</td>
                                            <td rowspan="2">Costed Workplan</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">2. Improve routine data quality and data use, including high risk and hard to reach areas, to identify and target zero dose</td>
                                            <td rowspan="2">Percent of workplan activities executed</td>
                                            <td>90%</td>
                                            <td>100%</td>
                                            <td rowspan="2">Costed Workplan</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">3. Evidence-based demand generation supported by cross sectoral involvement, including private sector, particularly for missed communities</td>
                                            <td rowspan="2">Percent of workplan activities executed</td>
                                            <td>90%</td>
                                            <td>100%</td>
                                            <td rowspan="2">Costed Workplan</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">4. Improve EPI capacity at national and subnational level in vaccine logistics, social mobilization and advocacy for sustainable and equitable immunization coverage</td>
                                            <td rowspan="2">Percent of workplan activities executed</td>
                                            <td>90%</td>
                                            <td>100%</td>
                                            <td rowspan="2">Costed Workplan</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">5. Facilitate sustainable subnational financing for operations of immunization programs</td>
                                            <td rowspan="2">Percent of workplan activities executed</td>
                                            <td>90%</td>
                                            <td>100%</td>
                                            <td rowspan="2">Costed Workplan</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">6. Strengthen coordination to promote shared accountability at national and subnational level</td>
                                            <td rowspan="2">Percent of workplan activities executed</td>
                                            <td>80%</td>
                                            <td>100%</td>
                                            <td rowspan="2">Costed Workplan</td>
                                            <td rowspan="2">Annually</td>
                                        </tr>
                                        <tr>
                                            <td>Actual</td>
                                            <td>Actual</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>

    <script>
        const langId = document.getElementById('lang-id');
        const langEn = document.getElementById('lang-en');

        const translations = {
            en: {
                title: 'Zero Dosed',
                subtitle: 'Web Based Performance Monitoring Dashboard',
                description: 'Zero Dosed is a comprehensive and user-friendly vaccination performance monitoring dashboard.',
                downloadBtn: 'Download Guide',
                publicDashboardTitle: 'Public Dashboard',
                publicDashboardDescription: 'Explore real-time insights about vaccination coverage on our public dashboard.',
                publicDashboardButton: 'Explore Now'
            },
            id: {
                title: 'Zero Dosed',
                subtitle: 'Dashboard Monitoring Kinerja Berbasis Web',
                description: 'Zero Dosed adalah dashboard monitoring kinerja vaksinasi yang komprehensif dan mudah digunakan.',
                downloadBtn: 'Download Panduan',
                publicDashboardTitle: 'Dashboard Publik',
                publicDashboardDescription: 'Temukan wawasan real-time tentang cakupan vaksinasi di dashboard publik kami.',
                publicDashboardButton: 'Lihat Selengkapnya'
            }
        };

        function toggleLanguage() {
            if (langId.style.display === 'none') {
                langId.style.display = 'block';
                langEn.style.display = 'none';
                setLanguage('id');
                localStorage.setItem('selectedLanguage', 'id');
            } else {
                langId.style.display = 'none';
                langEn.style.display = 'block';
                setLanguage('en');
                localStorage.setItem('selectedLanguage', 'en');
            }
        }

        function setLanguage(lang) {
            document.getElementById('title').textContent = translations[lang].title;
            document.getElementById('subtitle').textContent = translations[lang].subtitle;
            document.getElementById('description').textContent = translations[lang].description;
            document.getElementById('download-btn').textContent = translations[lang].downloadBtn;
            document.getElementById('public-dashboard-title').textContent = translations[lang].publicDashboardTitle;
            document.getElementById('public-dashboard-description').textContent = translations[lang].publicDashboardDescription;
            document.getElementById('public-dashboard-button').textContent = translations[lang].publicDashboardButton;
        }

        function initializeLanguage() {
            const savedLanguage = localStorage.getItem('selectedLanguage') || 'id';
            if (savedLanguage === 'id') {
                langId.style.display = 'block';
                langEn.style.display = 'none';
            } else {
                langId.style.display = 'none';
                langEn.style.display = 'block';
            }
            setLanguage(savedLanguage);
        }

        document.addEventListener('DOMContentLoaded', initializeLanguage);
        document.getElementById('language-toggle').addEventListener('click', toggleLanguage);
    </script>
</body>

</html>
