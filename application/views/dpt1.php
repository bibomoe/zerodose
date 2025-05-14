
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3><?= $translations['page_title'] ?></h3>
                                <p class="text-subtitle text-muted"><?= $translations['page_subtitle'] ?>​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">DPT-1 coverage and drop out rates</li>
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
                                <div class="col-12" style="margin-bottom: 20px;">
                                    <!-- <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body"> -->
                                            <?php
                                                // var_dump($selected_province);
                                            ?>
                                            <?= form_open('home/dpt1', ['method' => 'post']) ?>
                                                <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;"><?= $translations['filter_label'] ?></label>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    <?php
                                                        $user_category = $this->session->userdata('user_category'); // Ambil kategori pengguna yang login

                                                        if($user_category != 7 && $user_category != 8){
                                                    ?>
                                                    <?= form_dropdown('province', 
                                                        array_column($provinces, 'name_id', 'id'), 
                                                        $selected_province, 
                                                        ['class' => 'form-select', 'id' => 'provinceFilter', 'style' => 'width: 100%; max-width: 200px; height: 48px; font-size: 1rem;']
                                                    ); ?>
                                                    <?= form_dropdown('district', 
                                                        array_column($district_dropdown, 'name_id', 'id'), 
                                                        $selected_district,
                                                        'class="form-select" id="city_id" style="width: 100%; max-width: 200px; height: 48px; font-size: 1rem;"'); ?>
                                                    <?php
                                                        } else {
                                                            if($user_category == 7){
                                                    ?>
                                                        <input type="hidden" id="province" name="province" value="<?=$selected_province;?>">
                                                        <?= form_dropdown('district', 
                                                            array_column($district_dropdown, 'name_id', 'id'), 
                                                            $selected_district,
                                                            'class="form-select" id="city_id" style="width: 100%; max-width: 200px; height: 48px; font-size: 1rem;"'); ?>
                                                    <?php
                                                            } else if($user_category == 8){
                                                    ?>
                                                        <input type="hidden" id="province" name="province" value="<?=$selected_province;?>">
                                                        <input type="hidden" id="district" name="province" value="<?=$selected_district;?>">
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                    <?= form_dropdown(
                                                            'year', 
                                                            [2025 => '2025', 2026 => '2026'], 
                                                            set_value('year', $selected_year ?? 2025), 
                                                            'class="form-select" style="width: 100%; max-width: 200px; height: 48px; font-size: 1rem;" required'
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

                            <!-- 4 Card -->
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
                                                    <h6 class="text-muted font-semibold"><?= $translations['text1'] ?></h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dpt1_coverage); ?> <small>(<?= number_format($percent_dpt1_coverage, 0) ?>%)</small></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-6 col-lg-3 col-md-6">
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
                                </div> -->
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
                                                    <h6 class="text-muted font-semibold"><?= $translations['text2'] ?></h6>
                                                    <h6 class="text-muted font-semibold">(DPT-1 - DPT-3)</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($dropout_rate_all_provinces,2); ?>%</h6>
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
                                                    <h6 class="text-muted font-semibold"><?= $selected_district == 'all' ? $translations['text3'] : $translations['text3_2'] ?></h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dropout_rate); ?> <small>(<?= number_format($percent_districts_under_5, 2) ?>%)</small></h6>
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
                                                    <h6 class="text-muted font-semibold"><?= $selected_district == 'all' ? $translations['text4'] : $translations['text4_2'] ?></h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_regencies_cities); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Peta -->
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

                            <!-- Tabel -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <!-- <h4>Current mapping of ZD children based on GIS analysis</h4> -->
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table1">
                                                    <thead>
                                                        <tr>
                                                            <th><?= $translations['tabelcoloumn1'] ?></th>
                                                            <th><?= $translations['tabelcoloumn2'] ?></th>
                                                            <th><?= $translations['tabelcoloumn3'] ?> <?= $translations['text5'] ?> <?= $quarter ?></th>
                                                            <th><?= $translations['tabelcoloumn4'] ?></th>
                                                            <th><?= $translations['tabelcoloumn5'] ?></th>
                                                            <th><?= $translations['tabelcoloumn6'] ?></th>
                                                            <th><?= $translations['tabelcoloumn7'] ?></th>
                                                            <th><?= $translations['tabelcoloumn8'] ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($district_details as $district): ?>
                                                            <tr>
                                                                <td><?= htmlspecialchars($district['province_name']); ?></td>
                                                                <td><?= htmlspecialchars($district['district_name']) ?></td>
                                                                <td><?= number_format($district['target']) ?></td>
                                                                <td><?= number_format($district['dpt1_coverage']) ?></td>
                                                                <td><?= $district['percent_dpt1_coverage'] ?>%</td>
                                                                <td><?= number_format($district['dpt3_coverage']) ?></td>
                                                                <td><?= number_format($district['dropout_number']) ?></td>
                                                                <td><?= $district['dropout_rate'] ?>%</td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
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
document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-7.250445, 112.768845], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let dptUnder5Data = <?= json_encode($dpt_under_5_data, JSON_NUMERIC_CHECK); ?>;

    let dptCoverageData = <?= json_encode($total_dpt1_coverage_per_province, JSON_NUMERIC_CHECK); ?>;
    let dptTargetData = <?= json_encode($total_dpt1_target_per_province, JSON_NUMERIC_CHECK); ?>;
    let totalCitiesData = <?= json_encode($total_cities_per_province, JSON_NUMERIC_CHECK); ?>;

    let percentDptCoverageData = <?= json_encode($percent_dpt1_coverage_per_province, JSON_NUMERIC_CHECK); ?>;
    let dropout_rate_per_provinces = <?= json_encode($dropout_rate_per_provinces, JSON_NUMERIC_CHECK); ?>;
    let percentDptUnder5Data = <?= json_encode($percent_dpt_under_5_per_province, JSON_NUMERIC_CHECK); ?>;

    console.log(dptUnder5Data);
    console.log(dptCoverageData);
    console.log(dropout_rate_per_provinces);
    

    function getColor(dpt, doRate) {
        return (doRate < 5 && dpt != 0) ? '#1A9850' : '#D73027'; // Hijau jika do < 5 dan dpt != 0, merah jika tidak
    }

    function cleanCityCode(code) { 
            if (!code) return ""; 
            return String(code).replace(/\./g, ''); 
        }


    let isProvinceLevel = ["all", "targeted"].includes("<?= $selected_province ?>");

    fetch("<?= $geojson_file; ?>")
    .then(response => response.json())
    .then(data => {
        let geojsonLayer = L.geoJSON(data, {
            style: function (feature) {
                // Mendapatkan rawCode untuk membandingkan dengan data DPT yang sudah diproses
                let rawCode = isProvinceLevel 
                        ? feature.properties.KDPPUM  
                        : feature.properties.KDPKAB;

                let regionId = cleanCityCode(rawCode); // Langsung menggunakan rawCode untuk membandingkan

                // Cek apakah ada data DPT untuk wilayah ini
                let dptUnder5 = dptUnder5Data[regionId] || 0;

                // Ambil Dropout Rate per provinsi
                let dropoutRate = dropout_rate_per_provinces[regionId] || 0;

                // Safely access average and handle undefined values
                let averageDropoutRate = dropoutRate.average ? dropoutRate.average.toFixed(2) : '0';  // Default to '100' if undefined


                return {
                    fillColor: getColor(dptUnder5, averageDropoutRate),
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

                let regionId = cleanCityCode(rawCode); // Langsung menggunakan rawCode untuk membandingkan

                

                // Cek apakah ada data DPT untuk wilayah ini
                let dptUnder5 = dptUnder5Data[regionId] || 0;

                // Ambil total DPT1 Coverage dan DPT1 Target berdasarkan province_id
                let dptCoverage = dptCoverageData.find(item => item.province_id == regionId) || { dpt1_coverage: 0 };
                let dptTarget = dptTargetData.find(item => item.province_id == regionId) || { dpt1_target: 0 };

                // Ambil total jumlah cities per provinsi
                let totalCities = totalCitiesData.find(item => item.province_id == regionId) || { total_cities: 0 };

                // Ambil persentase cakupan DPT1 per provinsi
                let percentDptCoverage = percentDptCoverageData[regionId] || 0;

                // Ambil Dropout Rate per provinsi
                let dropoutRate = dropout_rate_per_provinces[regionId] || 0;

                // Safely access average and handle undefined values
                let averageDropoutRate = dropoutRate.average ? dropoutRate.average.toFixed(2) : '0';  // Default to '100' if undefined

                // Jika nilai averageDropoutRate kurang dari 0, set ke 0
                averageDropoutRate = parseFloat(averageDropoutRate) < 0 ? '0' : averageDropoutRate;

                // Ambil persentase districts dengan coverage (DPT1-DPT3) < 5% per provinsi
                let percentDptUnder5 = percentDptUnder5Data[regionId] || 0;

                // Nama wilayah/provinsi
                let name = isProvinceLevel 
                        ? feature.properties.WADMPR  
                        : feature.properties.NAMOBJ;  

                // Membuat konten pop-up untuk menampilkan informasi
                let popupContent = `<b>${name}</b><br>`;
                popupContent += `Total Districts: ${totalCities.total_cities}<br>`;
                popupContent += `Dropout Rate: ${averageDropoutRate}%<br>`;
                popupContent += `Total Districts with DO (DPT1-DPT3) < 5%: ${dptUnder5} (${percentDptUnder5}%)<br>`;
                popupContent += `DPT1 Coverage: ${dptCoverage.dpt1_coverage} (${percentDptCoverage}%)<br>`;
                popupContent += `DPT1 Target: ${dptTarget.dpt1_target}`;

                layer.bindPopup(popupContent);

                if (feature.geometry.type === "Polygon" || feature.geometry.type === "MultiPolygon") {
                    let labelPoint = turf.pointOnFeature(feature);
                    let latlng = [labelPoint.geometry.coordinates[1], labelPoint.geometry.coordinates[0]];

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
                            iconSize: [50, 15] // Ukuran lebih kecil
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

<script>
$(document).ready(function () {
    $('#provinceFilter').change(function () {
        var province_id = $(this).val();
        if (province_id !== 'all' || province_id !== 'targeted') {
            $.ajax({
                url: "<?= base_url('input/get_cities_by_province') ?>",
                type: "GET",
                data: { province_id: province_id },
                dataType: "json",
                success: function (data) {
                    $('#city_id').html('<option value="all">-- Kab/Kota --</option>');
                    $.each(data, function (key, value) {
                        $('#city_id').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                    });
                }
            });
        } else {
            $('#city_id').html('<option value="all">-- Kab/Kota --</option>');
        }
    });
});
</script>


