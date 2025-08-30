
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
                                                    <?= form_dropdown(
                                                            'sort_by',
                                                            [
                                                                'kejar_asik' => $translations['sort_kejar_asik'] ?? 'Urutkan Kejar ASIK Tertinggi',
                                                                'kejar_manual' => $translations['sort_kejar_manual'] ?? 'Urutkan Kejar Manual Tertinggi',
                                                                'kejar_kombinasi' => $translations['sort_kejar_kombinasi'] ?? 'Urutkan Kejar Kombinasi Tertinggi',
                                                            ],
                                                            $sort_by ?? '',
                                                            'class="form-select" style="width: 100%; max-width: 250px; height: 48px; font-size: 1rem;"'
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
                                            <h4 class="card-title"><?= $translations['text1'] ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- <canvas id="kejarChart" style="height: 500px; width: 100%;"></canvas> -->
                                             <canvas id="kejarChart" style="width: 100%; height: <?= count($chart_data) * 30 ?>px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- table -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table2">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:30%"> 
                                                                <?php
                                                                    if( $selected_province === 'all' || $selected_province === 'targeted' ) {
                                                                ?>
                                                                    <?= $translations['tabelcoloumn1'] ?>
                                                                <?php
                                                                    } else if ($selected_district == 'all'){
                                                                ?>
                                                                    <?= $translations['tabelcoloumn1_b'] ?>
                                                                <?php
                                                                    } else {
                                                                ?>
                                                                    <?= $translations['tabelcoloumn1_c'] ?>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </th>
                                                            <th><?= $translations['tabelcoloumn2'] ?> </th>
                                                            <th><?= $translations['tabelcoloumn3'] ?> </th>
                                                            <th><?= $translations['tabelcoloumn4'] ?> </th>
                                                            <th><?= $translations['tabelcoloumn5'] ?> </th>
                                                            <th><?= $translations['tabelcoloumn6'] ?> </th>
                                                            <th><?= $translations['tabelcoloumn7'] ?> </th>
                                                            <th><?= $translations['tabelcoloumn8'] ?> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($chart_data as $data): ?>
                                                            <tr>
                                                                <td><?= $data['name'] ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['kejar_asik']) ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['kejar_manual']) ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['kejar_kombinasi']) ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['zd_total']) ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['percentage_asik'], 2) ?>%</td>
                                                                <td style="text-align: center;"><?= number_format($data['percentage_manual'], 2) ?>%</td>
                                                                <td style="text-align: center;"><?= number_format($data['percentage_kombinasi'], 2) ?>%</td>
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





<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<!-- Grafik Bar -->
<script>
    Chart.register(ChartDataLabels);

    const data = <?= json_encode($chart_data) ?>;

    const labels = data.map(item => item.name);
    const zdTotal = data.map(item => parseInt(item.zd_total));
    const kejarAsik = data.map(item => parseInt(item.kejar_asik));
    const kejarManual = data.map(item => parseInt(item.kejar_manual));
    const kejarKombinasi = data.map(item => parseInt(item.kejar_kombinasi));

    const percentageAsik = data.map(item => parseFloat(item.percentage_asik));
    const percentageManual = data.map(item => parseFloat(item.percentage_manual));
    const percentageKombinasi = data.map(item => parseFloat(item.percentage_kombinasi));

    const lang = localStorage.getItem("selectedLanguage") || "id";

    const t = {
        en: {
            kejar_asik: "ASIK Chased",
            kejar_manual: "Manual Chased",
            kejar_kombinasi: "Combined Chased",
            zd_total: "Zero Dose Children in 2024",
            percent_asik: "% Chased (ASIK)",
            percent_manual: "% Chased (Manual)",
            percent_kombinasi: "% Chased (Combined)",
            y1_title: "% of ZD",
            y_title: "Number of Children"
        },
        id: {
            kejar_asik: "Kejar ASIK",
            kejar_manual: "Kejar Manual",
            kejar_kombinasi: "Kejar Kombinasi",
            zd_total: "Jumlah Anak Zero Dose Tahun 2024",
            percent_asik: "% Kejar (ASIK)",
            percent_manual: "% Kejar (Manual)",
            percent_kombinasi: "% Kejar (Kombinasi)",
            y1_title: "% dari ZD",
            y_title: "Jumlah Anak"
        }
    }[lang];

    new Chart(document.getElementById('kejarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: t.kejar_asik,
                    data: kejarAsik,
                    backgroundColor: '#007bff', // Biru
                    stack: 'total',
                    yAxisID: 'y'
                },
                {
                    label: t.kejar_manual,
                    data: kejarManual,
                    backgroundColor: '#28a745', // Hijau
                    stack: 'total',
                    yAxisID: 'y'
                },
                {
                    label: t.kejar_kombinasi,
                    data: kejarKombinasi,
                    backgroundColor: '#ffc107', // Kuning
                    stack: 'total',
                    yAxisID: 'y'
                },
                {
                    label: t.zd_total,
                    data: zdTotal,
                    backgroundColor: '#dee2e6', // Abu
                    stack: 'total',
                    yAxisID: 'y'
                },
                {
                    type: 'scatter',
                    label: t.percent_asik,
                    // data: percentageAsik.map((val, i) => ({ x: i, y: val })),
                    data: percentageAsik.map((val, i) => ({ x: val, y: i })),
                    backgroundColor: 'red',
                    borderColor: 'red',
                    pointRadius: 2,
                    xAxisID: 'x1', 
                    datalabels: {
                        display: true,
                        anchor: 'end',    
                        align: 'right',   
                        // formatter: value => value.y > 0 ? value.y + '%' : '',
                        formatter: value => value.x > 0 ? value.x + '%' : '',
                        color: 'red'
                    }
                },
                {
                    type: 'scatter',
                    label: t.percent_manual,
                    // data: percentageManual.map((val, i) => ({ x: i, y: val })),
                    data: percentageManual.map((val, i) => ({ x: val, y: i })),
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    pointRadius: 2,
                    xAxisID: 'x1', 
                    datalabels: {
                        display: true,
                        anchor: 'end',    
                        align: 'right',    
                        // formatter: value => value.y > 0 ? value.y + '%' : '',
                        formatter: value => value.x > 0 ? value.x + '%' : '',
                        color: 'orange'
                    }
                },
                {
                    type: 'scatter',
                    label: t.percent_kombinasi,
                    // data: percentageKombinasi.map((val, i) => ({ x: i, y: val })),
                    data: percentageKombinasi.map((val, i) => ({ x: val, y: i })),
                    backgroundColor: 'purple',
                    borderColor: 'purple',
                    pointRadius: 2,
                    xAxisID: 'x1', 
                    datalabels: {
                        display: true,
                        anchor: 'end',    
                        align: 'right',   
                        // formatter: value => value.y > 0 ? value.y + '%' : '',
                        formatter: value => value.x > 0 ? value.x + '%' : '',
                        color: 'purple'
                    }
                }
            ]
        },
        options: {
            indexAxis: 'y', // ✅ Ubah bar menjadi horizontal
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: { top: 30, bottom: 30 }
            },
            plugins: {
                datalabels: {
                    display: false
                },
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 12,
                        padding: 15,
                        font: {
                            size: 10
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.dataset.label || '';
                            let value = context.raw;

                            // Jika titik (dot persen)
                            if (context.dataset.type === 'scatter') {
                                // return `${label}: ${value.y}%`;
                                return `${label}: ${value.x.toFixed(1)}%`;
                            }

                            // Format angka biasa (ribuan)
                            if (typeof value === 'number') {
                                value = value.toLocaleString('id-ID'); // atau en-US jika pakai English
                            }

                            return `${label}: ${value}`;
                        }
                    }
                }
            },
            // scales: {
            //     x: {
            //         stacked: true,
            //         ticks: {
            //             autoSkip: false,
            //             maxRotation: 45,
            //             minRotation: 45
            //         }
            //     },
            //     y: {
            //         stacked: true,
            //         beginAtZero: true,
            //         title: {
            //             display: true,
            //             text: t.y_title
            //         }
            //     },
            //     y1: {
            //         beginAtZero: true,
            //         position: 'right',
            //         max: 100,
            //         title: {
            //             display: true,
            //             text: t.y1_title
            //         },
            //         grid: {
            //             drawOnChartArea: false
            //         }
            //     }
            // }
            scales: {
            x: {
                position: 'bottom',           // Ini untuk bar
                stacked: true,
                beginAtZero: true,
                title: {
                    display: true,
                    text: t.y_title           // Jumlah Anak
                },
                ticks: {
                    callback: val => val.toLocaleString('id-ID')
                }
            },
            x1: {
                position: 'top',              // ✅ Ini untuk persen (scatter)
                beginAtZero: true,
                max: 100,
                grid: {
                    drawOnChartArea: false    // Biar tidak mengganggu bar chart
                },
                title: {
                    display: true,
                    text: t.y1_title          // % dari ZD
                },
                ticks: {
                    callback: val => val + '%'
                }
            },
            y: {
                stacked: true,
                beginAtZero: true,
                ticks: {
                    mirror: false,
                    padding: 10
                }
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

    var table = $('#table2').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csvHtml5',
                text: 'Download CSV',
                className: 'btn btn-primary btn-sm'
            },
            {
                extend: 'excelHtml5',
                text: 'Download Excel',
                className: 'btn btn-success btn-sm'
            }
        ]
    });

    // Fungsi untuk update jumlah baris yang tampil
    function updateRowCount() {
        // api.rows({ filter: 'applied' }) -> baris yg sudah difilter (search)
        var count = table.rows({ filter: 'applied' }).count();
        $('#rowCount').text('Jumlah baris yang tampil: ' + count);
    }

    // Update saat inisialisasi
    updateRowCount();

    // Update tiap kali tabel di draw ulang (filter, paging, dll)
    table.on('draw', function() {
        updateRowCount();
    });

});
</script>