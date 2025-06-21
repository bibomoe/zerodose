
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3><?= $title ?></h3>
                                <p class="text-subtitle text-muted">​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Budget Disbursement National & Sub-National (CSO)</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- // Basic Horizontal form layout section end -->
                </div>
                <div class="page-content"> 
                    <section class="row">
                        <!-- <div class="col-12 col-lg-12">
                            
                        </div> -->

                        <!-- table Budget Disbursement National-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Budget Disbursement National</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table2">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" class="text-center">No</th> <!--  Name -->
                                                        <th rowspan="2" class="text-center">Menu</th> <!--  Name -->
                                                        <th rowspan="2" class="text-center">Total</th> <!--  Name -->
                                                        <th colspan="12" class="text-center">Jumlah Alokasi</th> <!-- Column for months -->
                                                    </tr>
                                                    <tr>
                                                        <!-- Columns for Province -->
                                                        <th class="text-center">1. Aceh</th>
                                                        <th class="text-center">2. Sumut</th>
                                                        <th class="text-center">3. Sumbar</th>
                                                        <th class="text-center">4. Riau</th>
                                                        <th class="text-center">5. Lampung</th>
                                                        <th class="text-center">6. Jabar</th>
                                                        <th class="text-center">7. DIY</th>
                                                        <th class="text-center">8. Bali</th>
                                                        <th class="text-center">9. Sulsel</th>
                                                        <th class="text-center">10. Kalbar</th>
                                                        <th class="text-center">11. NTB</th>
                                                        <th class="text-center">12. Papteng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">A</th>
                                                        <td class="text-left">MICs TI Zero Dose - Penurunan Dosis Nol</th>
                                                        <td class="text-right">Rp. 4.423.514.000</th>
                                                        <td class="text-right">Rp. 336.464.000</th>
                                                        <td class="text-right">Rp. 773.193.000</th>
                                                        <td class="text-right">Rp. 234.424.000</th>
                                                        <td class="text-right">Rp. 228.684.000</th>
                                                        <td class="text-right">Rp. 288.906.000</th>
                                                        <td class="text-right">Rp. 934.760.000</th>
                                                        <td class="text-right"></th>
                                                        <td class="text-right"></th>
                                                        <td class="text-right">Rp. 618.977.000</th>
                                                        <td class="text-right">Rp. 287.722.000</th>
                                                        <td class="text-right">Rp. 288.220.000</th>
                                                        <td class="text-right">Rp. 432.164.000</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">1</th>
                                                        <td class="text-left">Workshop peningkatan capaian imunisasi di fasilitas pelayanan kesehatan swasta</th>
                                                        <td class="text-right">Rp. 868.855.000</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">Rp. 277.475.000</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">Rp. 256.660.000</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">Rp 331.720.000</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">-</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">2</th>
                                                        <td class="text-left">Pelaksanaan Pelacakan sasaran dan Imunisasi Kejar</th>
                                                        <td class="text-right">Rp. 1.683.448.000</th>
                                                        <td class="text-right">Rp. 160.840.000</th>
                                                        <td class="text-right">Rp. 323.460.000</th>
                                                        <td class="text-right">Rp. 97.556.000</th>
                                                        <td class="text-right">Rp. 77.856.000</th>
                                                        <td class="text-right">Rp. 134.852.000</th>
                                                        <td class="text-right">Rp. 509.272.000</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">Rp 100.936.000</th>
                                                        <td class="text-right">Rp 138.876.000</th>
                                                        <td class="text-right">Rp 103.956.000</th>
                                                        <td class="text-right">Rp 35.844.000</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">3</th>
                                                        <td class="text-left">Sosialisasi EIRS (Electronic Immunization Registry) di Faskes Swasta</th>
                                                        <td class="text-right">Rp. 1.778.043.000</th>
                                                        <td class="text-right">Rp. 167.288.000</th>
                                                        <td class="text-right">Rp. 163.726.000</th>
                                                        <td class="text-right">Rp. 128.680.000</th>
                                                        <td class="text-right">Rp. 142.084.000</th>
                                                        <td class="text-right">Rp. 146.670.000</th>
                                                        <td class="text-right">Rp. 157.396.000</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">Rp 177.253.000</th>
                                                        <td class="text-right">Rp 140.910.000</th>
                                                        <td class="text-right">Rp 174.068.000</th>
                                                        <td class="text-right">Rp 379.968.000</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">4</th>
                                                        <td class="text-left">Asistensi Teknis Penguatan Sistem Informasi Imunisasi dan Rantai Dingin Vaksin</th>
                                                        <td class="text-right">Rp. 93.168.000</th>
                                                        <td class="text-right">Rp. 8.336.000</th>
                                                        <td class="text-right">Rp. 8.532.000</th>
                                                        <td class="text-right">Rp. 8.188.000</th>
                                                        <td class="text-right">Rp. 8.744.000</th>
                                                        <td class="text-right">Rp. 7.384.000</th>
                                                        <td class="text-right">Rp. 8.432.000</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">-</th>
                                                        <td class="text-right">Rp 9.068.000</th>
                                                        <td class="text-right">Rp 7.936.000</th>
                                                        <td class="text-right">Rp 10.196.000</th>
                                                        <td class="text-right">Rp 16.352.000</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- table Budget Disbursement Sub-National (CSO)-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Budget Disbursement Sub-National CSO</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table2">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th> <!--  Name -->
                                                        <th class="text-center">Kegiatan</th> <!--  Name -->
                                                        <th class="text-center">Volume</th> <!--  Name -->
                                                        <th class="text-center">Biaya</th> <!-- Column for months -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">1.</th>
                                                        <td class="text-left">HUDA - (Provinsi Aceh)</th>
                                                        <td class="text-center">1 PT</th>
                                                        <td class="text-right">Rp. 171.902.000</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">2.</th>
                                                        <td class="text-left">AISYIYAH - (Provinsi Jawa Barat)</th>
                                                        <td class="text-center">1 PT</th>
                                                        <td class="text-right">Rp. 609.430.000</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">3.</th>
                                                        <td class="text-left">PERDHAKI - (Provinsi Kalimantan Barat dan Nusa Tenggara Timur)</th>
                                                        <td class="text-center">1 PT</th>
                                                        <td class="text-right">Rp. 474.450.000</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">4.</th>
                                                        <td class="text-left">PELKESI - (Provinsi Lampung dan Sumatera Utara)</th>
                                                        <td class="text-center">1 PT</th>
                                                        <td class="text-right">Rp. 445.410.000</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">5.</th>
                                                        <td class="text-left">MUSLIMAT NU - (Provinsi Nusa Tenggara Barat)</th>
                                                        <td class="text-center">1 PT</th>
                                                        <td class="text-right">Rp. 194.753.000</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">6.</th>
                                                        <td class="text-left">PKK - (Provinsi Sumatera Barat, Riau, Papua Tengah, Sumatera Utara (Kota Binjai) dan Jawa Barat (Kota Tasikmalaya))</th>
                                                        <td class="text-center">1 PT</th>
                                                        <td class="text-right">Rp. 1.212.412.300</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center"></th>
                                                        <td class="text-center"><b>TOTAL</b></th>
                                                        <td class="text-center"></th>
                                                        <td class="text-right">Rp. 3.108.357.300</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Grafik Bar Budget per Objective -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Budget Disbursement Sub-National CSO Graph</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="chartWrapper" class="d-flex justify-content-center">
                                                <canvas id="budgetPerObjectiveChart"></canvas>
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
                </div>
            </footer>
        </div>
    </div>

<!-- SCRIPT FOR BAR BUDGET BY OBJECTIVE -->
<script>
    const budgetPerObjectiveCtx = document.getElementById('budgetPerObjectiveChart').getContext('2d');
    
    const budgetPerObjectiveChart = new Chart(budgetPerObjectiveCtx, {
        type: 'bar',
        data: {
            labels: ['HUDA', 'AISYIYAH', 'PERDHAKI', 'PELKESI', 'MUSLIMAT NU', 'PKK'],
            datasets: [
                {
                    label: 'Target Budget (USD)',
                    data: [171902000],
                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Absorbed Budget (USD)',
                    data: [],
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
