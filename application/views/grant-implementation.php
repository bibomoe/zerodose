
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Grants Implementation and Budget Disbursement</h3>
                                <p class="text-subtitle text-muted">
                                Number and percentage of costed work plan activities completed, along with the budget execution rate (%) and amount ($) by activity in targeted provinces/districts.​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Grants Implementation and Budget Disbursement</li>
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
                                            <?= form_open('home/grant_implementation', ['method' => 'get', 'id' => 'filter-form']); ?>
                                                <label for="partnersInput" class="form-label" style="font-size: 1.2rem; font-weight: bold;">Gavi MICs Partners/implementers </label>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    

                                                    <?php
                                                        // Ambil session partner_category
                                                        $partner_category = $this->session->userdata('partner_category');

                                                        // Cek apakah partner_category valid (tidak kosong, tidak null, tidak 0)
                                                        $is_disabled = !empty($partner_category) && $partner_category != 0;

                                                        // Tentukan value untuk partner_id
                                                        $partner_id_value = $is_disabled ? $partner_category : set_value('partner_id', $selected_partner);
                                                        // Buat array dropdown dengan opsi "All" di awal
                                                        $dropdown_options = ['all' => 'All'] + array_column($partners, 'name', 'id');
                                                    ?>
                                                        <?= form_dropdown(
                                                            'partner_id',
                                                            $dropdown_options, // Data dropdown: ['all' => 'All', 'id' => 'name']
                                                            $partner_id_value, // Value yang dipilih
                                                            'id="partner_id" class="form-select" style="width: 100%; max-width: 300px; height: 48px; font-size: 1rem;" ' 
                                                            . ($is_disabled ? 'disabled' : '') . ' required'
                                                        ); ?>
                                                        <?php if ($is_disabled): ?>
                                                            <!-- Tambahkan input hidden jika dropdown di-disable -->
                                                            <input type="hidden" name="partner_id" value="<?= $partner_category ?>">
                                                        <?php endif; ?>
                                                        <?= form_dropdown(
                                                            'year', 
                                                            [2025 => '2025', 2024 => '2024'], 
                                                            set_value('year', $selected_year ?? 2025), 
                                                            'class="form-select" style="width: 100%; max-width: 150px; height: 48px; font-size: 1rem;" required'
                                                        ); ?>
                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                        <i class="bi bi-filter"></i> Submit
                                                    </button>
                                                </div>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Budget Absorption</h4>
                                        </div>
                                        <div class="card-body">
                                            
                                                <div class="col-md-12 text-center">
                                                    <h5 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 10px;">Total Target Budget</h5>
                                                    <p style="font-size: 1.2rem;">
                                                        <strong style="color: <?= ($selected_year == 2024) ? '#0056b3' : '#00b359'; ?>;">
                                                            <?= $selected_year; ?>:
                                                        </strong> 
                                                        <?= number_format(($selected_year == 2024) ? $total_target_budget_2024 : $total_target_budget_2025, 0, ',', '.'); ?> IDR
                                                    </p>
                                                </div>
                                                <div id="chartWrapper" class="d-flex justify-content-center">
                                                    <canvas id="budgetAbsorptionChart"></canvas>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Number of activities conducted</h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- Chart -->
                                            <div id="chartWrapper" class="d-flex justify-content-center">
                                                <!-- <canvas id="activitiesConductedChart"></canvas> -->
                                                <!-- <?php var_dump($total_activities); ?>
                                                <?php var_dump($completed_activities_2024); ?>
                                                <?php var_dump($completed_activities_2025); ?> -->
                                                <canvas id="activitiesChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Budget Code: GAVI-INDOVAC1</h4>
                                            <h4 class="card-title">Total Budget: 1500000 $</h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Cumulative Budget</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>January</td>
                                                    <td>73649 $</td>
                                                    <td>5%</td>
                                                </tr>
                                                <tr>
                                                    <td>February</td>
                                                    <td>78274 $</td>
                                                    <td>5%</td>
                                                </tr>
                                                <tr>
                                                    <td>March</td>
                                                    <td>91837 $</td>
                                                    <td>6%</td>
                                                </tr>
                                                <tr>
                                                    <td>April</td>
                                                    <td>182748 $</td>
                                                    <td>12%</td>
                                                </tr>
                                                <tr>
                                                    <td>May</td>
                                                    <td>404573 $</td>
                                                    <td>27%</td>
                                                </tr>
                                                <tr>
                                                    <td>June</td>
                                                    <td>696847 $</td>
                                                    <td>46%</td>
                                                </tr>
                                                <tr>
                                                    <td>July</td>
                                                    <td>706968 $</td>
                                                    <td>47%</td>
                                                </tr>
                                                <tr>
                                                    <td>August</td>
                                                    <td>903358 $</td>
                                                    <td>60%</td>
                                                </tr>
                                                <tr>
                                                    <td>September</td>
                                                    <td>1029485 $</td>
                                                    <td>69%</td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Activities delivered</h4>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>Activity</th>
                                                    <th>Activities delivered</th>
                                                    <th>Total activities</th>
                                                </tr>
                                            </thead>
                                                <tbody>
                                                <tr>
                                                    <td>NVI</td>
                                                    <td>34</td>
                                                    <td>100</td>
                                                </tr>
                                                <tr>
                                                    <td>ZD</td>
                                                    <td>23</td>
                                                    <td>100</td>
                                                </tr>
                                                <tr>
                                                    <td>MSC</td>
                                                    <td>43</td>
                                                    <td>100</td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div> -->
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
        var selectedYear = <?= $selected_year ?>;
        

        const months = <?= json_encode($months); ?>;
        const budget2024 = <?= json_encode(!empty($budget_2024) ? $budget_2024 : array_fill(0, 12, 0)); ?>;
        const budget2025 = <?= json_encode(!empty($budget_2025) ? $budget_2025 : array_fill(0, 12, 0)); ?>;
        const percentage2024 = <?= json_encode(!empty($percentage_2024) ? $percentage_2024 : array_fill(0, 12, 0)); ?>;
        const percentage2025 = <?= json_encode(!empty($percentage_2025) ? $percentage_2025 : array_fill(0, 12, 0)); ?>;

        // Inisialisasi Chart.js lama
        // const ctx = document.getElementById('budgetAbsorptionChart').getContext('2d');
        // const budgetAbsorptionChart = new Chart(ctx, {
        //     type: 'line',
        //     data: {
        //         labels: <?= json_encode($months); ?>, // Labels bulan
        //         datasets: [
        //             {
        //                 label: '2024 Budget Absorption (%)',
        //                 data: <?= json_encode($percentage_2024); ?>, // Data persentase 2024
        //                 borderColor: 'rgba(0, 86, 179, 1)',
        //                 borderWidth: 2,
        //                 fill: false,
        //                 tension: 0.4
        //             },
        //             {
        //                 label: '2025 Budget Absorption (%)',
        //                 data: <?= json_encode($percentage_2025); ?>, // Data persentase 2025
        //                 borderColor: 'rgba(0, 179, 89, 1)',
        //                 borderWidth: 2,
        //                 fill: false,
        //                 tension: 0.4
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             tooltip: {
        //                 callbacks: {
        //                     label: function(context) {
        //                         const label = context.dataset.label || '';
        //                         const value = context.parsed.y.toFixed(2) + '%'; // Tambahkan persen
                                
        //                         // Total budget absorption tambahan (custom tooltip data)
        //                         const totalBudget = <?= json_encode($budget_2024); ?>; // Total untuk tahun 2024
        //                         const totalBudget2025 = <?= json_encode($budget_2025); ?>; // Total untuk tahun 2025

        //                         let totalValue = '';
        //                         if (context.dataset.label.includes('2024')) {
        //                             totalValue = ` (Absorption: ${totalBudget[context.dataIndex].toLocaleString()} IDR)`;
        //                         } else if (context.dataset.label.includes('2025')) {
        //                             totalValue = ` (Absorption: ${totalBudget2025[context.dataIndex].toLocaleString()} IDR)`;
        //                         }

        //                         return `${label}: ${value}${totalValue}`;
        //                     }
        //                 }
        //             },
        //             legend: {
        //                 display: true
        //             }
        //         },
        //         scales: {
        //             x: {
        //                 title: { display: true, text: 'Month' }
        //             },
        //             y: {
        //                 title: { display: true, text: 'Percentage (%)' },
        //                 beginAtZero: true,
        //                 max: 100,
        //                 ticks: {
        //                     callback: function(value) {
        //                         return value + '%';
        //                     }
        //                 }
        //             }
        //         }
        //     }
        // });

        // Inisialisasi Chart.js
        const ctx = document.getElementById('budgetAbsorptionChart').getContext('2d');
        const budgetAbsorptionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($months); ?>, // Labels bulan
                datasets: [
                    {
                        label: selectedYear + ' Budget Absorption (%)',
                        data: selectedYear == 2024 ? <?= json_encode($percentage_2024); ?> : <?= json_encode($percentage_2025); ?>,
                        borderColor: selectedYear == 2024 ? 'rgba(0, 86, 179, 1)' : 'rgba(0, 179, 89, 1)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.4
                    },
                    {
                        label: 'Target (90%)',
                        data: Array(12).fill(90), // Garis target 90% untuk setiap bulan
                        borderColor: 'rgba(255, 0, 0, 0.5)', // Warna merah
                        borderWidth: 2,
                        borderDash: [5, 5], // Garis putus-putus
                        pointRadius: 0 // Hilangkan titik
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const value = context.parsed.y.toFixed(2) + '%';
                                
                                const totalBudget = selectedYear == 2024 ? <?= json_encode($budget_2024); ?> : <?= json_encode($budget_2025); ?>;
                                let totalValue = ` (Absorption: ${totalBudget[context.dataIndex].toLocaleString()} IDR)`;

                                return `${label}: ${value}${totalValue}`;
                            }
                        }
                    },
                    legend: { display: true }
                },
                scales: {
                    x: { title: { display: true, text: 'Month' } },
                    y: {
                        title: { display: true, text: 'Percentage (%)' },
                        beginAtZero: true,
                        max: 100,
                        ticks: { callback: value => value + '%' }
                    }
                }
            }
        });

        // Tambahkan tombol download di atas chart
        function addBudgetAbsorptionDownloadButtons() {
            // Ambil parent dari grafik
            const container = document.getElementById('budgetAbsorptionChart').parentNode;

            // Buat wrapper untuk tombol
            const buttonWrapper = document.createElement('div');
            buttonWrapper.className = 'd-flex justify-content-center mt-3'; // Pusatkan tombol dengan margin ke atas

            // Tombol download CSV
            const csvButton = document.createElement('button');
            csvButton.textContent = 'Download CSV';
            csvButton.className = 'btn btn-primary btn-sm mx-2'; // Tambahkan margin antar tombol
            csvButton.addEventListener('click', () => downloadBudgetAbsorptionCSV());

            // Tombol download Excel
            const excelButton = document.createElement('button');
            excelButton.textContent = 'Download Excel';
            excelButton.className = 'btn btn-success btn-sm mx-2';
            excelButton.addEventListener('click', () => downloadBudgetAbsorptionExcel());

            // Tambahkan tombol ke wrapper
            buttonWrapper.appendChild(csvButton);
            buttonWrapper.appendChild(excelButton);

            // Tambahkan wrapper tombol di bawah grafik
            container.parentNode.insertBefore(buttonWrapper, container.nextSibling);
        }


        // Fungsi download CSV
        function downloadBudgetAbsorptionCSV() {
            const csvContent = "data:text/csv;charset=utf-8," +
                "Month,2024 Budget Absorption (IDR),2025 Budget Absorption (IDR)\n" +
                months.map((month, index) => `${month},${budget2024[index]},${budget2025[index]}`).join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'budget_absorption_chart_data.csv');
            link.click();
        }

        // Fungsi download Excel
        function downloadBudgetAbsorptionExcel() {
            const worksheetData = [
                ['Month', '2024 Budget Absorption (IDR)', '2025 Budget Absorption (IDR)'], // Header
                ...months.map((month, index) => [month, budget2024[index], budget2025[index]]) // Data
            ];

            // Menggunakan XLSX.js untuk membuat Excel
            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Budget Absorption');

            // Generate dan download file Excel
            XLSX.writeFile(workbook, 'budget_absorption_chart_data.xlsx');
        }

        // Tambahkan tombol download saat halaman dimuat
        document.addEventListener('DOMContentLoaded', addBudgetAbsorptionDownloadButtons);

        // Labels untuk grafik bar (Objectives)
        const objectivesLabels = [
            <?php foreach ($objectives as $index => $objective): ?>
                'Objective <?= $index + 1; ?>'<?= $index < count($objectives) - 1 ? ',' : '' ?>
            <?php endforeach; ?>
        ];

        // Data untuk grafik bar
        const totalActivities = <?= json_encode($total_activities); ?>;
        const completedActivities2024 = <?= json_encode($completed_activities_2024); ?>;
        const completedActivities2025 = <?= json_encode($completed_activities_2025); ?>;

        // Inisialisasi grafik bar Chart.js lama
        // const ctxActivities = document.getElementById('activitiesChart').getContext('2d');
        // const activitiesChart = new Chart(ctxActivities, {
        //     type: 'bar',
        //     data: {
        //         labels: objectivesLabels, // Labels untuk Objectives
        //         datasets: [
        //             {
        //                 label: 'Total Activities',
        //                 data: totalActivities,
        //                 backgroundColor: 'rgba(54, 162, 235, 0.8)', // Warna biru
        //                 borderColor: 'rgba(54, 162, 235, 1)',
        //                 borderWidth: 1
        //             },
        //             {
        //                 label: 'Completed Activities (2024)',
        //                 data: completedActivities2024,
        //                 backgroundColor: 'rgba(75, 192, 192, 0.8)', // Warna hijau
        //                 borderColor: 'rgba(75, 192, 192, 1)',
        //                 borderWidth: 1
        //             },
        //             {
        //                 label: 'Completed Activities (2025)',
        //                 data: completedActivities2025,
        //                 backgroundColor: 'rgba(255, 99, 132, 0.8)', // Warna merah
        //                 borderColor: 'rgba(255, 99, 132, 1)',
        //                 borderWidth: 1
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 display: true,
        //                 position: 'top'
        //             },
        //             tooltip: {
        //                 callbacks: {
        //                     label: function(context) {
        //                         let label = context.dataset.label || '';
        //                         if (label) {
        //                             label += ': ';
        //                         }
        //                         label += context.raw; // Menampilkan nilai data
        //                         return label;
        //                     }
        //                 }
        //             }
        //         },
        //         scales: {
        //             x: {
        //                 title: {
        //                     display: true,
        //                     text: 'Objectives'
        //                 }
        //             },
        //             y: {
        //                 beginAtZero: true,
        //                 title: {
        //                     display: true,
        //                     text: 'Number of Activities'
        //                 },
        //                 ticks: {
        //                     stepSize: 1 // Interval
        //                 }
        //             }
        //         }
        //     }
        // });

        // Inisialisasi grafik bar Chart.js 
        const ctxActivities = document.getElementById('activitiesChart').getContext('2d');
        const activitiesChart = new Chart(ctxActivities, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_map(fn($o) => 'Obj ' . $o['id'], $objectives)); ?>, // Labels lebih pendek
                datasets: [
                    {
                        label: 'Total Activities',
                        data: <?= json_encode($total_activities); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Completed Activities (' + selectedYear + ')',
                        data: selectedYear == 2024 ? <?= json_encode($completed_activities_2024); ?> : <?= json_encode($completed_activities_2025); ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Objectives' } },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Number of Activities' },
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });


        // Fungsi untuk download CSV
        function downloadActivitiesCSV() {
            const csvContent = "data:text/csv;charset=utf-8," +
                "Objective,Total Activities,Completed Activities (2024),Completed Activities (2025)\n" +
                objectivesLabels.map((label, index) =>
                    `${label},${totalActivities[index]},${completedActivities2024[index]},${completedActivities2025[index]}`
                ).join("\n");

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'activities_chart_data.csv');
            link.click();
        }

        // Fungsi untuk download Excel
        function downloadActivitiesExcel() {
            const worksheetData = [
                ['Objective', 'Total Activities', 'Completed Activities (2024)', 'Completed Activities (2025)'], // Header
                ...objectivesLabels.map((label, index) => [
                    label, totalActivities[index], completedActivities2024[index], completedActivities2025[index]
                ])
            ];

            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Activities Data');
            XLSX.writeFile(workbook, 'activities_chart_data.xlsx');
        }

        // Tambahkan tombol download di bawah grafik
        function addActivitiesDownloadButtons() {
            // Ambil parent dari grafik
            const container = document.getElementById('activitiesChart').parentNode;

            // Buat wrapper untuk tombol
            const buttonWrapper = document.createElement('div');
            buttonWrapper.className = 'd-flex justify-content-center mt-3'; // Pusatkan tombol dengan margin ke atas

            // Tombol download CSV
            const csvButton = document.createElement('button');
            csvButton.textContent = 'Download CSV';
            csvButton.className = 'btn btn-primary btn-sm mx-2';
            csvButton.addEventListener('click', () => downloadActivitiesCSV());

            // Tombol download Excel
            const excelButton = document.createElement('button');
            excelButton.textContent = 'Download Excel';
            excelButton.className = 'btn btn-success btn-sm mx-2';
            excelButton.addEventListener('click', () => downloadActivitiesExcel());

            // Tambahkan tombol ke wrapper
            buttonWrapper.appendChild(csvButton);
            buttonWrapper.appendChild(excelButton);

            // Tambahkan wrapper tombol di bawah grafik
            container.parentNode.insertBefore(buttonWrapper, container.nextSibling);
        }


        // Tambahkan tombol download saat halaman dimuat
        document.addEventListener('DOMContentLoaded', addActivitiesDownloadButtons);

        // document.getElementById("year").addEventListener("change", function() {
        //     document.getElementById("filter-form").submit();
        // });
    
    </script>