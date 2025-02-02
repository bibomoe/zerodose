
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Number of DTP Stock Out at Health Facilities</h3>
                                <p class="text-subtitle text-muted">Vaccine Availability</p>
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
                                <div class="col-md-6">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Stock Out by Duration and Vaccine Type</h4>
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

        // Chart.js setup for stockOutByDurationChart
const stockOutByDurationCtx = document.getElementById('stockOutByDurationChart').getContext('2d');

new Chart(stockOutByDurationCtx, {
    type: 'bar',
    data: {
        labels: ['HBO', 'BCG', 'DPT', 'MR', 'PCV', 'RV'], // Vaccine types
        datasets: [
            {
                label: '1 Month',
                data: [5, 4, 3, 2, 1, 0], // Example: number of facilities stockout for 1 month
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
            },
            {
                label: '2 Months',
                data: [3, 6, 4, 1, 2, 1], // Example: number of facilities stockout for 2 months
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
            },
            {
                label: '3 Months',
                data: [2, 1, 2, 4, 0, 1], // Example: number of facilities stockout for 3 months
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Stock Out by Duration and Vaccine Type'
            }
        },
        scales: {
            x: {
                stacked: true,
                title: {
                    display: true,
                    text: 'Vaccine Type'
                }
            },
            y: {
                stacked: true,
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Number of Facilities'
                }
            }
        }
    }
});

    </script>