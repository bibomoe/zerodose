
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Percentage of Primary Health Facility to Conduct Immunization Service as Planned​</h3>
                                <p class="text-subtitle text-muted">Zero Dosed Tracking in Selected Provinces​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Percentage </li>
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
                                            <?= form_open('home/zd_tracking', ['method' => 'get']) ?>
                                                <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;">Select Year</label>

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

                            <!-- card -->
                            <div class="row">
                                <!-- <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                                                    <h6 class="text-muted font-semibold">Number of Children Identified / Immunized</h6>
                                                    <h6 class="font-extrabold mb-0">30.000</h6>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card"> 
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldHome"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                                                    <h6 class="text-muted font-semibold">Total number of Puskesmas</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_puskesmas) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="iconly-boldTick-Square"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                                                    <h6 class="text-muted font-semibold">Total Puskesmas that have conducted immunization</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_immunized_puskesmas) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-3 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldShield-Done"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-9">
                                                    <h6 class="text-muted font-semibold">Percentage of Puskesmas that have conducted immunization</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($percentage_puskesmas, 2) ?>%</h6>
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
    
    

    <!-- <script>
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



    </script> -->

    

<script>
document.addEventListener("DOMContentLoaded", function () {
    const map = L.map('map').setView([-2.5489, 118.0149], 5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let puskesmasData = <?= $puskesmas_data ?>;
    
    function cleanRegionCode(code) { 
        return code ? String(code).replace(/\./g, '') : ""; 
    }

    function formatValue(value, isPercentage = false) {
        return isNaN(value) || value === null || value === undefined
            ? (isPercentage ? "0%" : "0")
            : (isPercentage ? value.toFixed(2) + "%" : value);
    }

    function getColor(percentage) {
        return percentage > 50 ? '#1A9850' :
               percentage > 20 ? '#91CF60' :
               percentage > 10 ? '#FEE08B' :
               '#D73027';
    }

    let isProvinceLevel = ["all", "targeted"].includes("<?= $selected_province ?>");

    fetch("<?= $geojson_file; ?>")
    .then(response => response.json())
    .then(data => {
        let geojsonLayer = L.geoJSON(data, {
            style: function (feature) {
                let rawCode = isProvinceLevel ? feature.properties.KDPPUM : feature.properties.KDPKAB;
                let regionId = cleanRegionCode(rawCode);
                let regionData = puskesmasData[regionId] || {}; 

                let percentageImmunization = formatValue(regionData.percentage_immunization, true);

                return {
                    fillColor: getColor(regionData.percentage_immunization),
                    weight: 1.5,
                    opacity: 1,
                    color: '#ffffff',
                    fillOpacity: 0.8
                };
            },
            onEachFeature: function (feature, layer) {
                let rawCode = isProvinceLevel ? feature.properties.KDPPUM : feature.properties.KDPKAB;
                let regionId = cleanRegionCode(rawCode);
                let regionData = puskesmasData[regionId] || {}; 

                let totalPuskesmas = formatValue(regionData.total_puskesmas);
                let conductedPuskesmas = formatValue(regionData.conducted_puskesmas);
                let percentageImmunization = formatValue(regionData.percentage_immunization, true);

                let name = isProvinceLevel ? feature.properties.WADMPR : feature.properties.NAMOBJ;

                let popupContent = `<b>${name}</b><br>
                                    Total Puskesmas: ${totalPuskesmas}<br>
                                    Conducted Immunization: ${conductedPuskesmas}<br>
                                    % Immunization: ${percentageImmunization}`;

                if (isProvinceLevel) {
                    let selectedYear = "<?= $selected_year ?>"; 
                    popupContent += `<br><br>
                        <a href="<?= base_url('home/zd_tracking'); ?>?year=${selectedYear}&province=${regionId}&get_detail=1">
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
        // Periksa jika parameter get_detail ada di URL dan bernilai 1
        const urlParams = new URLSearchParams(window.location.search);
        const getDetail = urlParams.get('get_detail');

        // Jika parameter get_detail == 1, scroll ke bagian peta
        if (getDetail == '1') {
            let mapSection = document.getElementById("map");
            if (mapSection) {
                mapSection.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        }

        // Lanjutkan kode untuk peta...
    });

</script>

