
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>DPT1 in targeted areas</h3>
                                <p class="text-subtitle text-muted">Percentage children -under 5 years with DPT 1 coverage and number of district with DO (DPT1-DPT3) less than 5%​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">DPT1 in targeted areas</li>
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
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldTick-Square"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                    <h6 class="text-muted font-semibold">Number of DPT1 Coverage</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dpt1_coverage); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldArrow---Right-Circle"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                    <h6 class="text-muted font-semibold">Number of DPT1 Target</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dpt1_target); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="iconly-boldChart"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                    <h6 class="text-muted font-semibold">Number of districts with coverage (DPT1-DPT3) less than 5%</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dropout_rate); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldHome"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                    <h6 class="text-muted font-semibold">Total Districts</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_regencies_cities); ?></h6>
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
                                            <!-- <h4>Current mapping of ZD children based on GIS analysis</h4> -->
                                        </div>
                                        <div class="card-body">
                                            <!-- <div class="googlemaps">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d107.57311654129782!3d-6.903273917028756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1633023222539!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                            </div> -->
                                            <?php
                                                // var_dump($dpt_under_5_data);
                                            ?>
                                            <div id="map" style="height: 400px; position: relative;  z-index: 1;" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">

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
document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-7.250445, 112.768845], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let dptUnder5Data = <?= json_encode($dpt_under_5_data, JSON_NUMERIC_CHECK); ?>;
    console.log(dptUnder5Data);
    console.log()

    let dptCoverageData = <?= json_encode($total_dpt1_coverage_per_province, JSON_NUMERIC_CHECK); ?>;
    let dptTargetData = <?= json_encode($total_dpt1_target_per_province, JSON_NUMERIC_CHECK); ?>;
    let totalCitiesData = <?= json_encode($total_cities_per_province, JSON_NUMERIC_CHECK); ?>;

    function getColor(dpt) {
        return (dpt) ? '#1A9850' : '#D73027' ; // Hijau jika ada lebih dari 0% cakupan, merah jika tidak ada
    }

    fetch("<?= $geojson_file; ?>")
    .then(response => response.json())
    .then(data => {
        let geojsonLayer = L.geoJSON(data, {
            style: function (feature) {
                // Mendapatkan rawCode untuk membandingkan dengan data DPT yang sudah diproses
                let rawCode = feature.properties.KDPPUM;
                let regionId = rawCode; // Langsung menggunakan rawCode untuk membandingkan

                // Cek apakah ada data DPT untuk wilayah ini
                let dptUnder5 = dptUnder5Data[regionId] || 0;
                // let dpt1Under5 = dptUnder5 || 0;
                // let dpt2Under5 = dptUnder5.dpt2_under_5 || 0;
                // let dpt3Under5 = dptUnder5.dpt3_under_5 || 0;

                return {
                    fillColor: getColor(dptUnder5),
                    weight: 1.5,
                    opacity: 1,
                    color: '#ffffff',
                    fillOpacity: 0.8
                };
            },
            onEachFeature: function (feature, layer) {
                let rawCode = feature.properties.KDPPUM;
                let regionId = rawCode; // Langsung menggunakan rawCode untuk membandingkan

                // Cek apakah ada data DPT untuk wilayah ini
                let dptUnder5 = dptUnder5Data[regionId] || 0;

                // Ambil total DPT1 Coverage dan DPT1 Target berdasarkan province_id
                let dptCoverage = dptCoverageData.find(item => item.province_id == regionId) || { dpt1_coverage: 0 };
                let dptTarget = dptTargetData.find(item => item.province_id == regionId) || { dpt1_target: 0 };

                // Ambil total jumlah cities per provinsi
                let totalCities = totalCitiesData.find(item => item.province_id == regionId) || { total_cities: 0 };

                let name = feature.properties.WADMPR; // Nama wilayah/provinsi

                // Membuat konten pop-up untuk menampilkan informasi
                let popupContent = `<b>${name}</b><br>`;
                popupContent += `Total Districts: ${totalCities.total_cities}<br>`;
                popupContent += `Total Districts with DO (DPT1-DPT3) < 5%: ${dptUnder5}<br>`;
                // popupContent += `Total Districts with DPT2 < 5%: ${dpt2Under5}<br>`;
                // popupContent += `Total Districts with DPT3 < 5%: ${dpt3Under5}<br>`;
                popupContent += `DPT1 Coverage: ${dptCoverage.dpt1_coverage}<br>`;
                popupContent += `DPT1 Target: ${dptTarget.dpt1_target}`;

                layer.bindPopup(popupContent);
            }
        }).addTo(map);

        // ✅ Set view ke center dari bounding box GeoJSON
        map.fitBounds(geojsonLayer.getBounds());
    })
    .catch(error => console.error("Error loading GeoJSON:", error));
});
</script>


