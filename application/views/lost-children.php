
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Lost Children</h3>
                                <p class="text-subtitle text-muted">Children will lose their opportunity this year/ has lost their opportunity ​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Lost Children</li>
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
                                                    <h6 class="text-muted font-semibold">Total Lost Children</h6>
                                                    <h6 class="font-extrabold mb-0">2.356</h6>
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
                                            <h4>District with the highest number of children at risk or already lost.</h4>
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
                        </div>
                    </section>
                </div>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 &copy; CHAI</p>
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
    </script>