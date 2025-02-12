<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zero Dose - Performance Monitoring Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app-dark.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/iconly.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="shortcut icon" href="<?= base_url('assets/compiled/svg/favicon.svg'); ?>" type="image/x-icon">

    <!-- Bootstrap JS (wajib ada) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                            <a href="<?= base_url('auth/login'); ?>" class="btn btn-outline-primary">Login</a>
                        </div>
                    </div>
                </div>
            </header> -->


            <div class="page-heading">
                
                <nav class="navbar">
                        <div class="container d-flex justify-content-between align-items-center">
                            
                        <div class="header-top-left">
                            <a href="#" class="logo">
                                <img src="<?= base_url('assets/logo.png'); ?>" alt="Logo" style="width: 100px; height: auto; margin-right: 20px;">
                            </a>
                            <a href="#" class="logo">
                                <img src="<?= base_url('assets/kemenkes.png'); ?>" alt="Logo" style="width: 150px; height: auto;">
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

                <!-- Hero Section -->
                <section class="hero-section">
                    <div class="container">
                        <div class="row align-items-center">
                            <!-- <div class="d-flex justify-content-center"> -->
                                <div class="col-md-6">
                                    <h1 class="fw-bold" id="title">Zero Dose</h1>
                                    <p class="text-muted" id="subtitle"></p>
                                    <p id="description"></p>
                                    <button class="btn btn-primary" id="download-btn">Download Panduan</button>
                                    <!-- <a href="<?= base_url('PublicController'); ?>" id="public-dashboard-button" class="btn btn-custom">Lihat Selengkapnya</a> -->
                                </div>
                            <!-- </div> -->
                            <div class="col-md-6 text-center">
                                <!-- <img src="<?= base_url('assets/compiled/svg/vaksin.svg'); ?>" alt="Dashboard Image" class="img-fluid hero-image" style="width: 300px; height: auto;"> -->
                                <!-- <img src="<?= base_url('assets/compiled/jpg/immunization-1.jpg'); ?>" alt="Dashboard Image" class="img-fluid hero-image" style="width: 300px; height: auto;"> -->
                                <img src="<?= base_url('assets/compiled/svg/dashboard.svg'); ?>" 
                                    alt="Preview Dashboard Publik" style="width: 400px; height: auto;"
                                    class="img-fluid">
                                <p class="attribution" style="font-size: 12px; color: #888; text-align: center;">
                                    Designed by <a href="https://www.freepik.com/" target="_blank">Freepik</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Public Dashboard Section -->
                <!-- <section class="public-dashboard-section">
                    <div class="container">
                        <h2 id="public-dashboard-title">Dashboard Publik</h2>
                        <p id="public-dashboard-description" class="text-center">
                            Temukan wawasan real-time tentang cakupan vaksinasi di dashboard publik kami.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <img src="<?= base_url('assets/compiled/svg/dashboard.svg'); ?>" 
                                    alt="Preview Dashboard Publik" style="width: 500px; height: auto;"
                                    class="img-fluid">
                                <p class="attribution" style="font-size: 12px; color: #888; text-align: center;">
                                    Designed by <a href="https://www.freepik.com/" target="_blank">Freepik</a>
                                </p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center">
                                <div>
                                    <p>
                                        Dashboard publik ini memberikan wawasan real-time tentang cakupan vaksinasi, tren populasi, 
                                        dan performa wilayah.
                                    </p>
                                    <a href="<?= base_url('PublicController'); ?>" id="public-dashboard-button" class="btn btn-custom">Lihat Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const langOptions = document.querySelectorAll(".lang-option");
            const currentLangImg = document.getElementById("current-lang");

            // Object untuk menyimpan terjemahan
            const translations = {
                en: {
                    title: 'Zero Dose',
                    description: 'Web Dashboard for Monitoring the Performance of Zero-Dose Strategy Implementation in Indonesia 2024-2025.',
                    downloadBtn: 'Download Guide',
                    publicDashboardTitle: 'Public Dashboard',
                    publicDashboardDescription: 'Explore real-time insights about vaccination coverage on our public dashboard.',
                    publicDashboardButton: 'Explore Now'
                },
                id: {
                    title: 'Zero Dose',
                    description: 'Web Dashboard Monitoring Kinerja Implementasi Strategi Zero Dose di Indonesia 2024-2025.',
                    downloadBtn: 'Download Panduan',
                    publicDashboardTitle: 'Dashboard Publik',
                    publicDashboardDescription: 'Temukan wawasan real-time tentang cakupan vaksinasi di dashboard publik kami.',
                    publicDashboardButton: 'Lihat Selengkapnya'
                }
            };

            function setLanguage(lang) {
                document.getElementById('title').textContent = translations[lang].title;
                document.getElementById('description').textContent = translations[lang].description;
                document.getElementById('download-btn').textContent = translations[lang].downloadBtn;
                document.getElementById('public-dashboard-title').textContent = translations[lang].publicDashboardTitle;
                document.getElementById('public-dashboard-description').textContent = translations[lang].publicDashboardDescription;
                document.getElementById('public-dashboard-button').textContent = translations[lang].publicDashboardButton;
            }

            function updateLanguage(lang, imgSrc) {
                localStorage.setItem("selectedLanguage", lang);
                currentLangImg.src = imgSrc;
                setLanguage(lang);
            }

            langOptions.forEach(option => {
                option.addEventListener("click", function (e) {
                    e.preventDefault();
                    const selectedLang = this.getAttribute("data-lang");
                    const imgSrc = this.querySelector("img").src;
                    updateLanguage(selectedLang, imgSrc);
                });
            });

            // Set bahasa yang tersimpan sebelumnya
            const savedLang = localStorage.getItem("selectedLanguage") || 'id';
            const savedLangOption = document.querySelector(`.lang-option[data-lang="${savedLang}"] img`);
            if (savedLangOption) {
                updateLanguage(savedLang, savedLangOption.src);
            }
        });


    </script>

    <!-- <script>
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
    </script> -->
</body>

</html>
