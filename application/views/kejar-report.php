
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
                                        <li class="breadcrumb-item active" aria-current="page">Long Term Health Outcomes</li>
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

                            <!-- Filter -->
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 20px;">
                                    <!-- <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body"> -->
                                            <?php
                                                // var_dump($selected_province);
                                            ?>
                                            <?= form_open('home/restored', ['method' => 'post']) ?>
                                                <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;"><?= $translations['filter_label'] ?>​</label>
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

                            <!-- Grafik -->
                            <div class="row">
                                <!-- ZD Region Type -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Imunisasi Kejar DPT1 (<?= $selected_year ?>)</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="kejarChart"></canvas>
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






<!-- Grafik Bar -->
<script>

            // Fetch data from PHP
            const restoredData = <?= json_encode($restored_data); ?>;

            // Use clearer labels in English
            const regency = restoredData.kabupaten ?? 0;
            const city = restoredData.kota ?? 0;

            let scaleXlabel2 ='';
            let scaleYlabel2 ='';
            let titleBarChart ='';
            let valueLabel =[];

            // Object untuk menyimpan terjemahan
            const translationsBarChart = {
                    en: {
                        title: `Number of Restored Children`,
                        scaleX: 'Region Type',
                        scaleY: 'ZD Children',
                        valueLabel : ['Regency', 'City']
                    },
                    id: {
                        title: `Jumlah Anak Terimunisasi`,
                        scaleX: 'Jenis Wilayah',
                        scaleY: 'Jumlah Anak Terimunisasi',
                        valueLabel : ['Kabupaten', 'Kota']
                    }
            };

            function setLanguageBarChart(lang) {
                titleBarChart = translationsBarChart[lang].title;
                scaleXlabel2 = translationsBarChart[lang].scaleX;
                scaleYlabel2 = translationsBarChart[lang].scaleY;
                valueLabel = translationsBarChart[lang].valueLabel;
            }

            // Inisialisasi bahasa berdasarkan localStorage
            // let savedLang = localStorage.getItem("selectedLanguage");
            setLanguageBarChart(savedLang);

            // Chart.js setup for locationChart
            const locationCtx = document.getElementById('locationChart').getContext('2d');
            new Chart(locationCtx, {
                type: 'bar',
                data: {
                    labels: valueLabel, // Replacing Kabupaten/Kota with English terms
                    datasets: [{
                        label: titleBarChart, // More descriptive label
                        data: [regency, city], // Data from backend
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
                                text: scaleXlabel2 // Replacing "Place of Residence" with a more accurate term
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: scaleYlabel2
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
                let csvContent = "data:text/csv;charset=utf-8,";
                csvContent += "Region Type,Number of Restored Children\n"; // Header
                csvContent += `Regency,${regency}\n`;
                csvContent += `City,${city}\n`;

                const encodedUri = encodeURI(csvContent);
                const link = document.createElement('a');
                link.setAttribute('href', encodedUri);
                link.setAttribute('download', 'restored_children_data.csv');
                link.click();
            }

            // Function to download Excel for locationChart
            function downloadLocationExcel() {
                const workbook = XLSX.utils.book_new();
                const worksheetData = [['Region Type', 'Number of Restored Children'], ['Regency', regency], ['City', city]];
                const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
                XLSX.utils.book_append_sheet(workbook, worksheet, 'Data');

                XLSX.writeFile(workbook, 'restored_children_data.xlsx');
            }

            // Add buttons to the DOM for locationChart
            addLocationDownloadButtons();
</script>

<!-- Buttons HTML5 untuk export CSV & Excel -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

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