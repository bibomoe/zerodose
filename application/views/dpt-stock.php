
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
                                        <li class="breadcrumb-item active" aria-current="page">Number of DTP Stock Out at Health Facilities</li>
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
                                            <?= form_open('home/dpt_stock', ['method' => 'get']) ?>
                                                <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;"><?= $translations['filter_label'] ?></label>
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
                            <div class="row">
                                <!-- <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Month of Stock for Each Vaccine</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="monthStockChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Number of Health Facilities with Vaccine Stockout</h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="stockoutChart"></canvas>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title"><?= $translations['text1'] ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="stockOutByDurationChart"></canvas>
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
    
    

    <!-- <script>
        // Chart.js setup for monthStockChart
        const monthStockCtx = document.getElementById('monthStockChart').getContext('2d');
        new Chart(monthStockCtx, {
            type: 'bar',
            data: {
                labels: ['HBO', 'BCG', 'DPT', 'MR', 'PCV', 'RV'],
                datasets: [{
                    label: 'Month of Stock',
                    data: [2.5, 2.8, 1.2, 3.4, 2, 1.1],
                    backgroundColor: 'rgba(0, 86, 179, 0.7)',
                    borderColor: 'rgba(0, 86, 179, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Month of Stock'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Vaccine Type'
                        }
                    }
                }
            }
        });

        // Function to create buttons dynamically for monthStockChart
        function addMonthStockDownloadButtons() {
            const container = monthStockCtx.canvas.parentNode;

            // Create a wrapper for the buttons
            const buttonWrapper = document.createElement('div');
            buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

            // Create CSV download button
            const csvButton = document.createElement('button');
            csvButton.textContent = 'Download CSV';
            csvButton.className = 'btn btn-primary btn-sm'; // Smaller button
            csvButton.addEventListener('click', () => downloadMonthStockCSV());

            // Create Excel download button
            const excelButton = document.createElement('button');
            excelButton.textContent = 'Download Excel';
            excelButton.className = 'btn btn-success btn-sm'; // Smaller button
            excelButton.addEventListener('click', () => downloadMonthStockExcel());

            // Append buttons to the wrapper
            buttonWrapper.appendChild(csvButton);
            buttonWrapper.appendChild(excelButton);

            // Insert the wrapper above the chart
            container.insertBefore(buttonWrapper, monthStockCtx.canvas);
        }

        // Function to download CSV for monthStockChart
        function downloadMonthStockCSV() {
            const labels = ['HBO', 'BCG', 'DPT', 'MR', 'PCV', 'RV'];
            const data = [2.5, 2.8, 1.2, 3.4, 2, 1.1];

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Vaccine Type,Month of Stock\n"; // Header
            labels.forEach((label, index) => {
                csvContent += `${label},${data[index]}\n`;
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'month_stock_chart_data.csv');
            link.click();
        }

        // Function to download Excel for monthStockChart
        function downloadMonthStockExcel() {
            const labels = ['HBO', 'BCG', 'DPT', 'MR', 'PCV', 'RV'];
            const data = [2.5, 2.8, 1.2, 3.4, 2, 1.1];

            // Create Excel content using XLSX.js
            const workbook = XLSX.utils.book_new();
            const worksheetData = [['Vaccine Type', 'Month of Stock'], ...labels.map((label, index) => [label, data[index]])];
            const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Data');

            // Generate Excel file and download
            XLSX.writeFile(workbook, 'month_stock_chart_data.xlsx');
        }

        // Add buttons to the DOM for monthStockChart
        addMonthStockDownloadButtons();


        // Chart.js setup for stockoutChart
        const stockoutCtx = document.getElementById('stockoutChart').getContext('2d');
        new Chart(stockoutCtx, {
            type: 'bar',
            data: {
                labels: ['HBO', 'BCG', 'DPT', 'MR', 'PCV', 'RV'],
                datasets: [{
                    label: 'Number of Facilities',
                    data: [7, 3, 4, 5, 3, 2],
                    backgroundColor: 'rgba(0, 86, 179, 0.7)',
                    borderColor: 'rgba(0, 86, 179, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Facilities'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Vaccine Type'
                        }
                    }
                }
            }
        });

        // Function to create buttons dynamically for stockoutChart
        function addStockoutDownloadButtons() {
            const container = stockoutCtx.canvas.parentNode;

            // Create a wrapper for the buttons
            const buttonWrapper = document.createElement('div');
            buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

            // Create CSV download button
            const csvButton = document.createElement('button');
            csvButton.textContent = 'Download CSV';
            csvButton.className = 'btn btn-primary btn-sm'; // Smaller button
            csvButton.addEventListener('click', () => downloadStockoutCSV());

            // Create Excel download button
            const excelButton = document.createElement('button');
            excelButton.textContent = 'Download Excel';
            excelButton.className = 'btn btn-success btn-sm'; // Smaller button
            excelButton.addEventListener('click', () => downloadStockoutExcel());

            // Append buttons to the wrapper
            buttonWrapper.appendChild(csvButton);
            buttonWrapper.appendChild(excelButton);

            // Insert the wrapper above the chart
            container.insertBefore(buttonWrapper, stockoutCtx.canvas);
        }

        // Function to download CSV for stockoutChart
        function downloadStockoutCSV() {
            const labels = ['HBO', 'BCG', 'DPT', 'MR', 'PCV', 'RV'];
            const data = [7, 3, 4, 5, 3, 2];

            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "Vaccine Type,Number of Facilities\n"; // Header
            labels.forEach((label, index) => {
                csvContent += `${label},${data[index]}\n`;
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement('a');
            link.setAttribute('href', encodedUri);
            link.setAttribute('download', 'stockout_chart_data.csv');
            link.click();
        }

        // Function to download Excel for stockoutChart
        function downloadStockoutExcel() {
            const labels = ['HBO', 'BCG', 'DPT', 'MR', 'PCV', 'RV'];
            const data = [7, 3, 4, 5, 3, 2];

            // Create Excel content using XLSX.js
            const workbook = XLSX.utils.book_new();
            const worksheetData = [['Vaccine Type', 'Number of Facilities'], ...labels.map((label, index) => [label, data[index]])];
            const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Data');

            // Generate Excel file and download
            XLSX.writeFile(workbook, 'stockout_chart_data.xlsx');
        }

        // Add buttons to the DOM for stockoutChart
        addStockoutDownloadButtons();

    </script> -->
    <script>
        // Chart.js setup for stockOutByDurationChart
            // const stockOutByDurationCtx = document.getElementById('stockOutByDurationChart').getContext('2d');

            // new Chart(stockOutByDurationCtx, {
            //     type: 'bar',
            //     data: {
            //         labels: ['HBO', 'BCG', 'DPT', 'MR', 'PCV', 'RV'], // Vaccine types
            //         datasets: [
            //             {
            //                 label: '1 Month',
            //                 data: [5, 4, 3, 2, 1, 0], // Example: number of facilities stockout for 1 month
            //                 backgroundColor: 'rgba(255, 99, 132, 0.7)',
            //             },
            //             {
            //                 label: '2 Months',
            //                 data: [3, 6, 4, 1, 2, 1], // Example: number of facilities stockout for 2 months
            //                 backgroundColor: 'rgba(54, 162, 235, 0.7)',
            //             },
            //             {
            //                 label: '3 Months',
            //                 data: [2, 1, 2, 4, 0, 1], // Example: number of facilities stockout for 3 months
            //                 backgroundColor: 'rgba(75, 192, 192, 0.7)',
            //             }
            //         ]
            //     },
            //     options: {
            //         responsive: true,
            //         plugins: {
            //             legend: {
            //                 position: 'top',
            //             },
            //             title: {
            //                 display: true,
            //                 text: 'Stock Out by Duration and Vaccine Type'
            //             }
            //         },
            //         scales: {
            //             x: {
            //                 stacked: true,
            //                 title: {
            //                     display: true,
            //                     text: 'Vaccine Type'
            //                 }
            //             },
            //             y: {
            //                 stacked: true,
            //                 beginAtZero: true,
            //                 title: {
            //                     display: true,
            //                     text: 'Number of Facilities'
            //                 }
            //             }
            //         }
            //     }
            // });

    </script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let stockOutData = <?= json_encode($stock_out_data); ?>; // Data dari PHP
    
    let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    
    let stockOut1 = new Array(12).fill(0);
    let stockOut2 = new Array(12).fill(0);
    let stockOut3 = new Array(12).fill(0);
    let stockOut4 = new Array(12).fill(0); // Untuk stock out >3 bulan

    // Mapping data dari database ke array bulan
    stockOutData.forEach(item => {
        let monthIndex = item.month - 1; // Bulan di DB 1-12, tapi array mulai dari 0
        stockOut1[monthIndex] = item.stock_out_1;
        stockOut2[monthIndex] = item.stock_out_2;
        stockOut3[monthIndex] = item.stock_out_3;
        stockOut4[monthIndex] = item.stock_out_4; // Assign data lebih dari 3 bulan
    });

    const ctx = document.getElementById('stockOutByDurationChart').getContext('2d');
    const stockoutChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months, 
            datasets: [
                {
                    label: '1 Month',
                    data: stockOut1,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                },
                {
                    label: '2 Months',
                    data: stockOut2,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                },
                {
                    label: '3 Months',
                    data: stockOut3,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                },
                {
                    label: '> 3 Months',
                    data: stockOut4,
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'DPT Stock Out by Month' }
            },
            scales: {
                x: {
                    stacked: true,
                    title: { display: true, text: 'Month' }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    title: { display: true, text: 'Number of Facilities' }
                }
            }
        }
    });

    // Function to create buttons dynamically
    function addDownloadButtons() {
        const container = ctx.canvas.parentNode;

        // Create a wrapper for the buttons
        const buttonWrapper = document.createElement('div');
        buttonWrapper.className = 'd-flex mb-3 gap-2';

        // Create CSV download button
        const csvButton = document.createElement('button');
        csvButton.textContent = 'Download CSV';
        csvButton.className = 'btn btn-primary btn-sm';
        csvButton.addEventListener('click', () => downloadCSV());

        // Create Excel download button
        const excelButton = document.createElement('button');
        excelButton.textContent = 'Download Excel';
        excelButton.className = 'btn btn-success btn-sm';
        excelButton.addEventListener('click', () => downloadExcel());

        // Append buttons to the wrapper
        buttonWrapper.appendChild(csvButton);
        buttonWrapper.appendChild(excelButton);

        // Insert the wrapper above the chart
        container.insertBefore(buttonWrapper, ctx.canvas);
    }

    // Function to download CSV
    function downloadCSV() {
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Month,Stock Out 1 Month,Stock Out 2 Months,Stock Out 3 Months,Stock Out >3 Months\n";
        
        months.forEach((month, index) => {
            csvContent += `${month},${stockOut1[index]},${stockOut2[index]},${stockOut3[index]},${stockOut4[index]}\n`;
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'dpt_stockout_data.csv');
        link.click();
    }

    // Function to download Excel
    function downloadExcel() {
        const workbook = XLSX.utils.book_new();
        const worksheetData = [
            ['Month', 'Stock Out 1 Month', 'Stock Out 2 Months', 'Stock Out 3 Months', 'Stock Out >3 Months'],
            ...months.map((month, index) => [month, stockOut1[index], stockOut2[index], stockOut3[index], stockOut4[index]])
        ];
        const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
        XLSX.utils.book_append_sheet(workbook, worksheet, 'DPT_StockOut_Data');
        XLSX.writeFile(workbook, 'dpt_stockout_data.xlsx');
    }

    // Add buttons to the DOM
    addDownloadButtons();
});
</script>

