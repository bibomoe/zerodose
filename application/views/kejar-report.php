
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
                                            <?= form_open('home/kejar_report', ['method' => 'post']) ?>
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





<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<!-- Grafik Bar -->
<script>
    Chart.register(ChartDataLabels);

    const data = <?= json_encode($chart_data) ?>;
    const labels = data.map(item => item.name);
    const coverage = data.map(item => parseInt(item.coverage));
    const zdTotal = data.map(item => parseInt(item.zd_total));
    const percentage = data.map((item, index) => {
        const zd = parseInt(item.zd_total);
        const cov = parseInt(item.coverage);
        return zd > 0 ? Math.round((cov / zd) * 1000) / 10 : 0;
    });

    const lang = localStorage.getItem("selectedLanguage") || "id";

    const translationsKejarChart = {
        en: {
            barLabel1: "Children Reached (Manual Data)",
            barLabel2: "Total Zero Dose Children in 2024",
            lineLabel: "% Reached from ZD 2024",
            yLeft: "Number of Children",
            yRight: "% of ZD"
        },
        id: {
            barLabel1: "Jumlah Anak Zero Dose Tahun 2024 yang dikejar (manual)",
            barLabel2: "Jumlah Anak Zero Dose Tahun 2024",
            lineLabel: "Persentase yang Dikejar dari ZD 2024",
            yLeft: "Jumlah Anak",
            yRight: "% dari ZD"
        }
    };

    const t = translationsKejarChart[lang];

    new Chart(document.getElementById('kejarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: t.barLabel2, // Total ZD
                    data: zdTotal,
                    backgroundColor: 'rgba(135, 206, 235, 0.7)', // biru muda
                    yAxisID: 'y'
                },
                {
                    label: t.barLabel1, // Dikejar (manual)
                    data: coverage,
                    backgroundColor: 'rgba(0, 86, 179, 1)', // biru tua
                    yAxisID: 'y'
                },
                {
                    type: 'line',
                    label: t.lineLabel,
                    data: percentage,
                    borderColor: 'rgba(255, 0, 0, 1)',
                    backgroundColor: 'rgba(255, 0, 0, 1)',
                    yAxisID: 'y1',
                    tension: 0.4,
                    fill: false,
                    pointRadius: 2,
                    pointHoverRadius: 3,
                    datalabels: {
                        display: true,
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value > 0 ? value + '%' : '';
                        },
                        color: '#ff0000',
                        font: {
                            weight: 'bold',
                            size: 8
                        },
                        offset: 6
                    }
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                datalabels: {
                    display: false // default, override per dataset
                },
                legend: {
                    display: true
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.dataset.label === t.lineLabel) {
                                return context.formattedValue + '%';
                            }
                            return context.formattedValue;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: t.yLeft
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: t.yRight
                    },
                    grid: {
                        drawOnChartArea: false
                    },
                    max: 100
                }
            }
        },
        plugins: [ChartDataLabels]
    });
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