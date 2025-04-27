
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
                            <!-- Filter -->
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
                                                            [2024 => '2024', 2025 => '2025', 2026 => '2026', 'all' => 'All'], 
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

                            <!-- Card Row -->
                            <div class="row">
                                <!-- Grafik Bar -->
                                <div class="col-md-12">
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
                                
                                <!-- Grafik Bar for Comparison -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Comparison of Completed Activities for Each Partner per Objective</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="chartWrapper" class="d-flex justify-content-center">
                                                <canvas id="activitiesComparisonChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grafik Bar Budget per Objective -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Budget Disbursed per Objective</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="chartWrapper" class="d-flex justify-content-center">
                                                <canvas id="budgetPerObjectiveChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Grafik Line Budget Absorption -->
                                <!-- <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Budget Absorption</h4>
                                        </div>
                                        <div class="card-body">
                                            
                                                <div class="col-md-12 text-center">
                                                    <h5 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 10px;">Total Target Budget</h5>
                                                    <p style="font-size: 1.2rem;">
                                                    <strong style="color: <?= ($selected_year == 2024) ? '#0056b3' : (($selected_year == 2025) ? '#00b359' : '#ff9900'); ?>;">
                                                        <?= $selected_year; ?>:
                                                    </strong> 
                                                    <?= number_format(
                                                        ($selected_year == 2024) 
                                                            ? $total_target_budget_2024 
                                                            : (($selected_year == 2025) 
                                                                ? $total_target_budget_2025 
                                                                : $total_target_budget_2026), 
                                                        0, ',', '.'); ?> USD | 
                                                    <?= number_format(
                                                        ($selected_year == 2024) 
                                                            ? $total_target_budget_2024_idr 
                                                            : (($selected_year == 2025) 
                                                                ? $total_target_budget_2025_idr 
                                                                : $total_target_budget_2026_idr), 
                                                        0, ',', '.'); ?> IDR
                                                    </p>
                                                </div>
                                                <div id="chartWrapper" class="d-flex justify-content-center">
                                                    <canvas id="budgetAbsorptionChart"></canvas>
                                                </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Budget Absorption</h4>
                                        </div>
                                        <div class="card-body">
                                            
                                                <div class="col-md-12 text-center">
                                                    <h5 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 10px;">Total Target Budget</h5>
                                                    <p style="font-size: 1.2rem;">
                                                    <strong style="color: <?= ($selected_year == 2024) ? '#0056b3' : (($selected_year == 2025) ? '#00b359' : '#ff9900'); ?>;">
                                                        <?= $selected_year; ?>:
                                                    </strong> 

                                                    <?php
                                                        if($selected_year == 'all'){
                                                            $total_target_budget = $total_target_budget_all;
                                                            $total_target_budget_IDR = $total_target_budget_all_idr;
                                                        } else if($selected_year == 2024){
                                                            $total_target_budget = $total_target_budget_2024;
                                                            $total_target_budget_IDR = $total_target_budget_2024_idr;
                                                        } else if($selected_year == 2025){
                                                            $total_target_budget = $total_target_budget_2025;
                                                            $total_target_budget_IDR = $total_target_budget_2025_idr;
                                                        } else if($selected_year == 2026){
                                                            $total_target_budget = $total_target_budget_2026;
                                                            $total_target_budget_IDR = $total_target_budget_2026_idr;
                                                        }
                                                    ?>
                                                    <?= number_format(
                                                        $total_target_budget, 
                                                        0, ',', '.'); ?> USD | 
                                                    <?= number_format(
                                                        $total_target_budget_IDR, 
                                                        0, ',', '.'); ?> IDR
                                                    </p>
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
    
    
<!-- Grafik Line Budget Absorption -->
<script>
        var selectedYear = <?= $selected_year ?>;
        

        const months = <?= json_encode($months); ?>;
        const budget2024 = <?= json_encode(!empty($budget_2024) ? $budget_2024 : array_fill(0, 12, 0)); ?>;
        const budget2025 = <?= json_encode(!empty($budget_2025) ? $budget_2025 : array_fill(0, 12, 0)); ?>;
        const budget2026 = <?= json_encode(!empty($budget_2026) ? $budget_2026 : array_fill(0, 12, 0)); ?>;

        const percentage2024 = <?= json_encode(!empty($percentage_2024) ? $percentage_2024 : array_fill(0, 12, 0)); ?>;
        const percentage2025 = <?= json_encode(!empty($percentage_2025) ? $percentage_2025 : array_fill(0, 12, 0)); ?>;
        const percentage2026 = <?= json_encode(!empty($percentage_2026) ? $percentage_2026 : array_fill(0, 12, 0)); ?>;
        

        // Inisialisasi Chart.js
        const ctx = document.getElementById('budgetAbsorptionChart').getContext('2d');
        const budgetAbsorptionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($months); ?>, // Labels bulan
                datasets: [
                    {
                        label: selectedYear + ' Budget Absorption (%)',
                        data: selectedYear == 2024 ? percentage2024 : (selectedYear == 2025 ? percentage2025 : percentage2026),
                        borderColor: selectedYear == 2024 ? 'rgba(0, 86, 179, 1)' : (selectedYear == 2025 ? 'rgba(0, 179, 89, 1)' : 'rgba(255, 153, 0, 1)'),
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
                                
                                // Menambahkan nilai IDR pada tooltip
                                const totalBudget = selectedYear == 2024 ? budget2024 : (selectedYear == 2025 ? budget2025 : budget2026);
                                const totalValue = totalBudget[context.dataIndex].toLocaleString();

                                // Konversi ke IDR
                                const totalValueIDR = totalBudget[context.dataIndex] * 14500;
                                const totalValueIDRFormatted = totalValueIDR.toLocaleString();

                                return `${label}: ${value} (Absorption: ${totalValue} USD | ${totalValueIDRFormatted} IDR)`;
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
            const selectedDataset = budgetAbsorptionChart.data.datasets[0]; // Ambil dataset aktif
            const selectedYear = selectedDataset.label.match(/\d{4}/)[0]; // Ambil tahun dari label
            const selectedBudget = selectedYear == 2024 ? budget2024 : (selectedYear == 2025 ? budget2025 : budget2026); // Ambil data sesuai tahun
            const conversionRate = 14500; // Kurs IDR per USD

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += `Month,${selectedYear} Budget Absorption (USD),${selectedYear} Budget Absorption (IDR)\n`; // Header

            months.forEach((month, index) => {
                const usdValue = selectedBudget[index];
                const idrValue = usdValue * conversionRate;
                csvContent += `${month},${usdValue},${idrValue}\n`;
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `budget_absorption_${selectedYear}.csv`);
            document.body.appendChild(link);
            link.click();
        }

        // Fungsi download Excel
        function downloadBudgetAbsorptionExcel() {
            const selectedDataset = budgetAbsorptionChart.data.datasets[0]; // Ambil dataset aktif
            const selectedYear = selectedDataset.label.match(/\d{4}/)[0]; // Ambil tahun dari label
            const selectedBudget = selectedYear == 2024 ? budget2024 : (selectedYear == 2025 ? budget2025 : budget2026); // Ambil data sesuai tahun
            const conversionRate = 14500; // Kurs IDR per USD

            // Buat worksheet
            const worksheetData = [
                ["Month", `${selectedYear} Budget Absorption (USD)`, `${selectedYear} Budget Absorption (IDR)`], // Header
                ...months.map((month, index) => {
                    const usdValue = selectedBudget[index];
                    const idrValue = usdValue * conversionRate;
                    return [month, usdValue, idrValue]; // Data
                })
            ];

            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
            XLSX.utils.book_append_sheet(workbook, worksheet, "Budget Absorption");

            // Generate file Excel dan unduh
            XLSX.writeFile(workbook, `budget_absorption_${selectedYear}.xlsx`);
        }



        // Tambahkan tombol download saat halaman dimuat
        document.addEventListener('DOMContentLoaded', addBudgetAbsorptionDownloadButtons);

        

        

</script>

<!-- Grafik Bar Activites Conducted -->
<script>
        selectedYear = <?= $selected_year ?>;
        
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
        const completedActivities2026 = <?= json_encode($completed_activities_2026); ?>;
        const completedActivities_all = <?= json_encode($completed_activities_all); ?>;

        // Menentukan data yang akan digunakan berdasarkan tahun yang dipilih
        let selectedActivities;

        if (selectedYear === 'all') {
            selectedActivities = completedActivitiesAll;
        } else if (selectedYear == 2024) {
            selectedActivities = completedActivities2024;
        } else if (selectedYear == 2025) {
            selectedActivities = completedActivities2025;
        } else if (selectedYear == 2026) {
            selectedActivities = completedActivities2026;
        }

        
        console.log(selectedYear);
        console.log(completedActivities_all);

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
                        data: selectedActivities,
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
            const selectedDataset = activitiesChart.data.datasets[1]; // Ambil dataset aktif
            const selectedYear = selectedDataset.label.match(/\d{4}/)[0]; // Ambil tahun dari label
            const selectedCompletedActivities = selectedActivities;

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += `Objective,Total Activities,Completed Activities (${selectedYear})\n`; // Header

            objectivesLabels.forEach((label, index) => {
                csvContent += `${label},${totalActivities[index]},${selectedCompletedActivities[index]}\n`;
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `activities_chart_${selectedYear}.csv`);
            document.body.appendChild(link);
            link.click();
        }


        // Fungsi untuk download Excel
        function downloadActivitiesExcel() {
            const selectedDataset = activitiesChart.data.datasets[1]; // Ambil dataset aktif
            const selectedYear = selectedDataset.label.match(/\d{4}/)[0]; // Ambil tahun dari label
            const selectedCompletedActivities = selectedActivities;

            // Buat worksheet
            const worksheetData = [
                ["Objective", "Total Activities", `Completed Activities (${selectedYear})`], // Header
                ...objectivesLabels.map((label, index) => [
                    label, totalActivities[index], selectedCompletedActivities[index]
                ])
            ];

            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
            XLSX.utils.book_append_sheet(workbook, worksheet, "Activities Data");
            XLSX.writeFile(workbook, `activities_chart_${selectedYear}.xlsx`);
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


<!-- SCRIPT FOR BAR COMPARISON -->
<script>

    const totalActivitiesForComparison = <?= json_encode($total_activities_for_comparison); ?>;
    const completedActivitiesForComparison2024 = <?= json_encode($completed_activities_2024_for_comparison); ?>;
    const completedActivitiesForComparison2025 = <?= json_encode($completed_activities_2025_for_comparison); ?>;
    const completedActivitiesForComparison2026 = <?= json_encode($completed_activities_2026_for_comparison); ?>;
    const partnersForComparison = <?= json_encode($partners_for_comparison); ?>;
    const objectivesForComparison = <?= json_encode($objectives_for_comparison); ?>;

    // Fungsi untuk mendapatkan data completed activities berdasarkan tahun yang dipilih
    function getCompletedActivitiesByYear(year) {
        if (year == 2024) {
            return completedActivitiesForComparison2024;
        } else if (year == 2025) {
            return completedActivitiesForComparison2025;
        } else if (year == 2026) {
            return completedActivitiesForComparison2026;
        }
        return []; // Default return empty array if no matching year
    }

    // Fungsi untuk memilih warna berdasarkan indeks
    function getPartnerColor(index) {
        const colors = [
            '#33FF57', // Green
            '#3357FF', // Blue
            '#FF33A1', // Pink
            '#1ABC9C', // Teal
            '#FF5733', // Red
            '#33FFF2', // Light Cyan
            '#FF6F00', // Amber
            '#8E44AD', // Purple
            '#F39C12', // Orange
            '#3498DB'  // Light Blue
        ];
        return colors[index % colors.length];  // Memastikan jika lebih dari jumlah warna, warna akan diulang
    }

        // Inisialisasi grafik bar Chart.js 
        const ctxActivitiesComparison = document.getElementById('activitiesComparisonChart').getContext('2d');
        const activitiesComparisonChart = new Chart(ctxActivitiesComparison, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_map(fn($o) => 'Obj ' . $o['id'], $objectives)); ?>, // Labels lebih pendek
                datasets: [
                    {
                        label: 'Total Activities (All Partners)',
                        data: totalActivitiesForComparison,
                        backgroundColor: 'rgba(54, 162, 235, 0.8)', // Warna biru
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    ...partnersForComparison.map((partner, index) => ({
                        label: partner.name,
                        data: getCompletedActivitiesByYear(selectedYear)[partner.id], // Ambil data completed activities per partner untuk tahun yang dipilih
                        backgroundColor: getPartnerColor(index), // Warna dinamis per partner
                        borderColor: getPartnerColor(index), // Warna border dinamis per partner
                        borderWidth: 1
                    }))
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

    // Fungsi untuk download CSV untuk bar comparison
    function downloadComparisonCSV() {
        const selectedYear = <?= json_encode($selected_year); ?>;
        const selectedCompletedActivities = getCompletedActivitiesByYear(selectedYear);

        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += `Objective,Total Activities,${partnersForComparison.map(partner => partner.name).join(',')}\n`;

        objectivesLabels.forEach((label, index) => {
            let row = `${label},${totalActivitiesForComparison[index]}`;
            partnersForComparison.forEach(partner => {
                row += `,${selectedCompletedActivities[partner.id][index]}`;
            });
            csvContent += row + "\n";
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `activities_comparison_chart_${selectedYear}.csv`);
        document.body.appendChild(link);
        link.click();
    }


    function downloadComparisonExcel() {
        const selectedYear = <?= json_encode($selected_year); ?>;
        const selectedCompletedActivities = getCompletedActivitiesByYear(selectedYear);

        const worksheetData = [
            ["Objective", "Total Activities", ...partnersForComparison.map(partner => partner.name)],
            ...objectivesLabels.map((label, index) => [
                label,
                totalActivitiesForComparison[index],
                ...partnersForComparison.map(partner => selectedCompletedActivities[partner.id][index])
            ])
        ];

        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
        XLSX.utils.book_append_sheet(workbook, worksheet, "Comparison Data");
        XLSX.writeFile(workbook, `activities_comparison_chart_${selectedYear}.xlsx`);
    }

    // Fungsi untuk menambahkan tombol download CSV dan Excel di bawah grafik comparison
    function addComparisonDownloadButtons() {
        // Ambil parent dari grafik
        const container = document.getElementById('activitiesComparisonChart').parentNode;

        // Buat wrapper untuk tombol
        const buttonWrapper = document.createElement('div');
        buttonWrapper.className = 'd-flex justify-content-center mt-3'; // Pusatkan tombol dengan margin ke atas

        // Tombol download CSV
        const csvButton = document.createElement('button');
        csvButton.textContent = 'Download CSV';
        csvButton.className = 'btn btn-primary btn-sm mx-2'; // Tambahkan margin antar tombol
        csvButton.addEventListener('click', () => downloadComparisonCSV());

        // Tombol download Excel
        const excelButton = document.createElement('button');
        excelButton.textContent = 'Download Excel';
        excelButton.className = 'btn btn-success btn-sm mx-2';
        excelButton.addEventListener('click', () => downloadComparisonExcel());

        // Tambahkan tombol ke wrapper
        buttonWrapper.appendChild(csvButton);
        buttonWrapper.appendChild(excelButton);

        // Tambahkan wrapper tombol di bawah grafik
        container.parentNode.insertBefore(buttonWrapper, container.nextSibling);
    }

    // Tambahkan tombol download saat halaman dimuat
    document.addEventListener('DOMContentLoaded', addComparisonDownloadButtons);



</script>

<script>
    const targetBudget2024 = <?= json_encode($target_budget_by_objectives_2024 ?? array_fill(0, count($objectives), 0)); ?>;
const targetBudget2025 = <?= json_encode($target_budget_by_objectives_2025 ?? array_fill(0, count($objectives), 0)); ?>;
const targetBudget2026 = <?= json_encode($target_budget_by_objectives_2026 ?? array_fill(0, count($objectives), 0)); ?>;

const absorbedBudget2024 = <?= json_encode($budget_by_objectives_2024 ?? array_fill(0, count($objectives), 0)); ?>;
const absorbedBudget2025 = <?= json_encode($budget_by_objectives_2025 ?? array_fill(0, count($objectives), 0)); ?>;
const absorbedBudget2026 = <?= json_encode($budget_by_objectives_2026 ?? array_fill(0, count($objectives), 0)); ?>;

const labelsObjectives = <?= json_encode(array_map(fn($o) => 'Obj ' . $o['id'], $objectives)); ?>;

const budgetPerObjectiveCtx = document.getElementById('budgetPerObjectiveChart').getContext('2d');
const selectedTarget = selectedYear == 2024 ? targetBudget2024 : (selectedYear == 2025 ? targetBudget2025 : targetBudget2026);
const selectedAbsorbed = selectedYear == 2024 ? absorbedBudget2024 : (selectedYear == 2025 ? absorbedBudget2025 : absorbedBudget2026);

const budgetPerObjectiveChart = new Chart(budgetPerObjectiveCtx, {
    type: 'bar',
    data: {
        labels: labelsObjectives,
        datasets: [
            {
                label: 'Target Budget (USD)',
                data: selectedTarget,
                backgroundColor: 'rgba(255, 206, 86, 0.7)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            },
            {
                label: 'Absorbed Budget (USD)',
                data: selectedAbsorbed,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const usd = context.raw;
                        const idr = usd * 14500;
                        return `${context.dataset.label}: ${usd.toLocaleString()} USD | ${idr.toLocaleString()} IDR`;
                    }
                }
            },
            legend: { display: true }
        },
        scales: {
            x: { title: { display: true, text: 'Objectives' } },
            y: {
                title: { display: true, text: 'Budget (USD)' },
                beginAtZero: true
            }
        }
    }
});

</script>