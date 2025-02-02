
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Current ZD Cases</h3>
                                <p class="text-subtitle text-muted">Number of ZD children in targeted areas​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Current ZD Cases</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- // Basic Horizontal form layout section end -->
                </div>
                <div class="page-content"> 
                    <section class="row">
                        <div class="col-12 col-lg-12">
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
                                                    <h6 class="text-muted font-semibold">Total Cases</h6>
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
                                            <h4>District with the Highest ZD</h4>
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
                                            <div class="row">
                                                <!-- <div class="col-md-6">
                                                    <div class="form-group row align-items-center">
                                                        <div class="col-lg-2 col-3">
                                                            <label class="col-form-label" for="first-name">Group</label>
                                                        </div>
                                                        <div class="col-lg-10 col-9">
                                                            <select id="groupFilter" class="form-select">
                                                                <option selected>All Group</option>
                                                                <option>Group A</option>
                                                                <option>Group B</option>
                                                                <option>Group C</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group row align-items-center">
                                                        <div class="col-lg-10 col-12">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-12">
                                                    <table class="table table-striped" id="table1">
                                                        <thead>
                                                            <tr>
                                                                <th>District Name</th>
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>ZD children mapping</h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- <div class="googlemaps">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d107.57311654129782!3d-6.903273917028756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1633023222539!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                            </div> -->
                                            <button class="btn btn-primary floating-button" data-bs-toggle="modal"
                                                data-bs-target="#mapFilter">
                                                <i class="bi bi-funnel"></i> Filter
                                            </button>
                                            <!-- Filter Modal -->
                                            <div class="modal fade text-left" id="mapFilter" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel33">Filter Map </h4>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                        <form action="#">
                                                            <div class="modal-body">
                                                                <label for="scoringFilter" class="form-label">Scoring</label>
                                                                <div class="form-group">
                                                                    <select id="scoringFilter" class="form-select">
                                                                        <option selected>Default</option>
                                                                        <option>Score 1</option>
                                                                        <option>Score 2</option>
                                                                    </select>
                                                                </div>
                                                                <label for="absoluteFilter" class="form-label">Absolute Number</label>
                                                                <div class="form-group">
                                                                    <select id="absoluteFilter" class="form-select">
                                                                        <option selected>Default</option>
                                                                        <option>Number 1</option>
                                                                        <option>Number 2</option>
                                                                    </select>
                                                                </div>
                                                                <label for="percentageFilter" class="form-label">Percentage</label>
                                                                <div class="form-group">
                                                                    <select id="percentageFilter" class="form-select">
                                                                        <option selected>Default</option>
                                                                        <option>10%</option>
                                                                        <option>20%</option>
                                                                    </select>
                                                                </div>
                                                                <label for="restoredFilter" class="form-label">Number Restored</label>
                                                                <div class="form-group">
                                                                    <select id="restoredFilter" class="form-select">
                                                                        <option selected>Default</option>
                                                                        <option>100</option>
                                                                        <option>200</option>
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
                                            <div id="map" style="height: 400px; position: relative;  z-index: 1;" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">ZD by Gender</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="genderChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">ZD by Place of Residence</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="locationChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">ZD by Group Age</h4>
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

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Mazer</p>
                    </div>
                    <!-- <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a></p>
                    </div> -->
                </div>
            </footer>
        </div>
    </div>
    
    

    <script>
            const map = L.map('map').setView([-7.250445, 112.768845], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Menggunakan AJAX untuk memuat GeoJSON
            fetch('<?= base_url('assets/geojson/jawa_timur.geojson'); ?>') // Ganti 'data.geojson' dengan nama file GeoJSON Anda
            .then(response => response.json())
            .then(data => {
                // Fungsi untuk menentukan warna berdasarkan nilai LUASWH
                function getColor(value) {
                    return value > 5000 ? '#D73027' :  // Merah lebih lembut
                        value > 3000 ? '#FC8D59' :
                        value > 2000 ? '#FEE08B' :
                        value > 1000 ? '#D9EF8B' :
                        value > 500  ? '#91CF60' :
                        value > 200  ? '#66BD63' :
                        value > 100  ? '#1A9850' :
                                        '#006837'; // Hijau untuk nilai kecil
                }

                // Fungsi untuk mengatur style setiap polygon
                function style(feature) {
                    return {
                        fillColor: getColor(feature.properties.LUASWH), // Gunakan nilai LUASWH
                        weight: 1.5,  // Ketebalan garis tepi
                        opacity: 1, // Transparansi garis tepi
                        color: '#ffffff', // Garis tepi putih
                        fillOpacity: 0.8 // Transparansi isi polygon
                    };
                }

                L.geoJSON(data, {
                    style: style, // Gunakan fungsi style
                    onEachFeature: function (feature, layer) {
                        // Tambahkan popup untuk menampilkan semua atribut
                        var popupContent = "";
                        for (var key in feature.properties) {
                            popupContent += key + ": " + feature.properties[key] + "<br>";
                        }
                        layer.bindPopup(popupContent);

                        // Tambahkan label nama kabupaten/kota
                        if (feature.geometry.type === "Polygon" || feature.geometry.type === "MultiPolygon") {
                            var labelPoint = turf.pointOnFeature(feature); // Mengambil titik di dalam polygon
                            var latlng = [labelPoint.geometry.coordinates[1], labelPoint.geometry.coordinates[0]];

                            if (feature.properties && feature.properties.NAMOBJ) {
                                var label = L.divIcon({
                                    className: 'label-class', // Gaya CSS untuk label
                                    html: feature.properties.NAMOBJ, // Isi teks
                                    iconSize: [80, 20] // Ukuran teks
                                });

                                L.marker(latlng, { icon: label }).addTo(map);
                            }
                        }
                    }
                }).addTo(map);
            });

            // Chart.js setup
            const genderCtx = document.getElementById('genderChart');
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

            // Function to create buttons dynamically
            function addDownloadButtons() {
                const container = genderCtx.parentNode;

                // Create a wrapper for the buttons
                const buttonWrapper = document.createElement('div');
                buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

                // Create CSV download button
                const csvButton = document.createElement('button');
                csvButton.textContent = 'Download CSV';
                csvButton.className = 'btn btn-primary btn-sm'; // Bootstrap & Mazer classes
                csvButton.addEventListener('click', () => downloadCSV());

                // Create Excel download button
                const excelButton = document.createElement('button');
                excelButton.textContent = 'Download Excel';
                excelButton.className = 'btn btn-success btn-sm'; // Bootstrap & Mazer classes
                excelButton.addEventListener('click', () => downloadExcel());

                // Append buttons to the wrapper
                buttonWrapper.appendChild(csvButton);
                buttonWrapper.appendChild(excelButton);

                // Insert the wrapper above the chart
                container.insertBefore(buttonWrapper, genderCtx);
            }

            // Function to download CSV
            function downloadCSV() {
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

            // Function to download Excel
            function downloadExcel() {
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

            // Add buttons to the DOM
            addDownloadButtons();

            // Chart.js setup for locationChart
            const locationCtx = document.getElementById('locationChart');
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
                const container = locationCtx.parentNode;

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
                container.insertBefore(buttonWrapper, locationCtx);
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
            const ageCtx = document.getElementById('ageChart');
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
                const container = ageCtx.parentNode;

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
                container.insertBefore(buttonWrapper, ageCtx);
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