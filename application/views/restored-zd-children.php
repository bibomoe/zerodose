
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Restored ZD Children</h3>
                                <p class="text-subtitle text-muted">Vaccine coverage in targeted areas​​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Restored ZD Children</li>
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
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body">
                                            <?= form_open('home/restored', ['method' => 'get']) ?>
                                                <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;">Select Province</label>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    <?= form_dropdown('province', 
                                                        ['all' => 'All Provinces'] + array_column($provinces, 'name_id', 'id'), 
                                                        $selected_province, 
                                                        ['class' => 'form-select', 'id' => 'provinceFilter', 'style' => 'width: 100%; max-width: 300px; height: 48px; font-size: 1rem;']
                                                    ); ?>
                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                        <i class="bi bi-filter"></i> Submit
                                                    </button>
                                                </div>
                                            <?= form_close() ?>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <h4>Total Immunized Children</h4>
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
                                                    DPT 1 Immunized</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dpt_1) ?></h6>
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
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">DPT 2 Immunized</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dpt_2) ?></h6>
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
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">DPT 3 Immunized</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dpt_3) ?></h6>
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
                                                    <h6 class="text-muted font-semibold">MR 1 Immunized</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_mr_1) ?></h6>
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
                                            <!-- <button class="btn btn-primary floating-button" data-bs-toggle="modal"
                                                data-bs-target="#tableFilter">
                                                <i class="bi bi-funnel"></i> Filter
                                            </button> -->
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
                                                    <!-- <tr>
                                                        <td>Kab. Kediri</td>
                                                        <td>7,000</td>
                                                        <td>29%</td>
                                                        <td>7.6</td>
                                                    </tr> -->
                                                    <?php foreach ($districts as $district): ?>
                                                        <tr>
                                                            <td><?= $district['district'] ?></td>
                                                            <td><?= number_format($district['total_dpt1']) ?></td>
                                                            <td>--%</td>
                                                            <td>--</td>
                                                        </tr>
                                                    <?php endforeach; ?>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Zero-Dose Cases</h4>
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
                                <!-- <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Number of Restored Children by Gender</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="genderChart"></canvas>
                                        </div>
                                    </div>
                                </div> -->
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
                                <!-- <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Number of Restored Children by Group Age</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="ageChart"></canvas>
                                        </div>
                                    </div>
                                </div> -->
                                
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
    </script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-7.250445, 112.768845], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let immunizationData = <?= json_encode($immunization_data, JSON_NUMERIC_CHECK); ?>;
    // console.log("Immunization Data:", immunizationData);

    function cleanCityCode(code) { 
        if (!code) return ""; 
        return String(code).replace(/\./g, ''); 
    }

    function getColor(value) {
        return value === 0 ? '#D73027' :  
               value > 0  ? '#1A9850' :  
                            '#f0f0f0';  
    }

    let isProvinceLevel = "<?= $selected_province ?>" === "all";

    fetch("<?= $geojson_file; ?>")
    .then(response => response.json())
    .then(data => {
        // console.log("GeoJSON Data:", data);

        let geojsonLayer = L.geoJSON(data, {
            style: function (feature) {
                let rawCode = isProvinceLevel 
                    ? feature.properties.KDPPUM  
                    : feature.properties.KDPKAB; 

                let regionId = cleanCityCode(rawCode);
                // console.log(`Raw : ${rawCode}, Cleaned: ${regionId}`);

                let dpt1 = immunizationData[regionId]?.dpt1 ? parseInt(immunizationData[regionId].dpt1) : 0;

                return {
                    fillColor: getColor(dpt1),
                    weight: 1.5,
                    opacity: 1,
                    color: '#ffffff',
                    fillOpacity: 0.8
                };
            },
            onEachFeature: function (feature, layer) {
                let regionId = isProvinceLevel 
                    ? cleanCityCode(feature.properties.KDPPUM)  
                    : cleanCityCode(feature.properties.KDPKAB);  

                let dpt1 = immunizationData[regionId]?.dpt1 || 0;
                let dpt2 = immunizationData[regionId]?.dpt2 || 0;
                let dpt3 = immunizationData[regionId]?.dpt3 || 0;
                let mr1  = immunizationData[regionId]?.mr1 || 0;

                let name = isProvinceLevel 
                    ? feature.properties.WADMPR  
                    : feature.properties.NAMOBJ;  

                let popupContent = `<b>${name}</b><br>`;
                popupContent += `DPT1 Immunized: ${dpt1}<br>`;
                popupContent += `DPT2 Immunized: ${dpt2}<br>`;
                popupContent += `DPT3 Immunized: ${dpt3}<br>`;
                popupContent += `MR1 Immunized: ${mr1}`;
                layer.bindPopup(popupContent);

                if (feature.geometry.type === "Polygon" || feature.geometry.type === "MultiPolygon") {
                    let labelPoint = turf.pointOnFeature(feature);
                    let latlng = [labelPoint.geometry.coordinates[1], labelPoint.geometry.coordinates[0]];

                    if (feature.properties.NAMOBJ) {
                        let label = L.divIcon({
                            className: 'label-class',
                            html: `<strong>${feature.properties.NAMOBJ}</strong>`,
                            iconSize: [100, 20]
                        });

                        L.marker(latlng, { icon: label }).addTo(map);
                    }
                }
            }
        }).addTo(map);

        // ✅ Set view ke center dari bounding box GeoJSON
        map.fitBounds(geojsonLayer.getBounds());

    })
    .catch(error => console.error("Error loading GeoJSON:", error));
});


</script>
