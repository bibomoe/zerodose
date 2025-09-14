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
                                        <li class="breadcrumb-item active" aria-current="page"></li>
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
                            <!-- Penjelasan di luar tabel -->
                            <!-- Penjelasan di luar tabel -->
                            <div class="alert alert-secondary mb-3" role="alert">
                                <strong><?= $translations['text1'] ?></strong> 
                                <ul>
                                    <li><?= $translations['text2'] ?></li>
                                    <li><?= $translations['text3'] ?></li>
                                </ul>
                            </div>



                            

                            <!-- Table 1: Long Term Outcomes -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-success text-white" style="color: white !important;">
                                            <h4 style="color: white !important;"><?= $translations['text4'] ?></h4>
                                            <button class="btn btn-primary ms-auto floating-button bg-success border-success" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent" aria-expanded="false" aria-controls="cardContent">
                                                <i class="bi bi-arrows-collapse"></i> 
                                            </button>
                                        </div>
                                        <div id="cardContent" class="collapse show">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <!-- <table class="table table-hover" id="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th rowspan="2">Long Term Outcome</th>
                                                                        <th rowspan="2">Indicator</th>
                                                                        <th colspan="3">Indicator Value</th>
                                                                        <th rowspan="2">Data Source</th>
                                                                        <th rowspan="2">Frequency of Reporting</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Baseline</th>
                                                                        <th>2024</th>
                                                                        <th>2025</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td rowspan="7">MITIGATE<br>Coverage rates restored, including by reaching zero-dose children</td>
                                                                        <td rowspan="2">DPT3</td>
                                                                        <td rowspan="2">4,199,289</td>
                                                                        <td class="table-success">90%</td>
                                                                        <td class="table-success">95%</td>
                                                                        <td rowspan="2">Administrative Reports</td>
                                                                        <td rowspan="2">Quarterly</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="table-warning"><?= number_format($long_term_outcomes['dpt3']['actual_y1'], 2) ?>%</td>
                                                                        <td class="table-warning"><?= number_format($long_term_outcomes['dpt3']['actual_y2'], 2) ?>%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td rowspan="2">MR1 Coverage (additional long term indicator)</td>
                                                                        <td rowspan="2">4,244,731</td>
                                                                        <td class="table-success">90%</td>
                                                                        <td class="table-success">95%</td>
                                                                        <td rowspan="2">Administrative Reports</td>
                                                                        <td rowspan="2">Quarterly</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="table-warning"><?= number_format($long_term_outcomes['mr1']['actual_y1'], 2) ?>%</td>
                                                                        <td class="table-warning"><?= number_format($long_term_outcomes['mr1']['actual_y2'], 2) ?>%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td rowspan="2">Reduction in zero-dose</td>
                                                                        <td rowspan="2">25% of 569,414 (per Dec 2022)</td>
                                                                        <td class="table-success">Target reduction by end of year 1 (15%)</td>
                                                                        <td class="table-success">Target reduction by end of year 2 (25%)</td>
                                                                        <td rowspan="2">Administrative Reports</td>
                                                                        <td rowspan="2">Quarterly</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="table-warning"><?= number_format($long_term_outcomes['reduction_zd']['actual_y1'], 2) ?>%</td>
                                                                        <td class="table-warning"><?= number_format($long_term_outcomes['reduction_zd']['actual_y2'], 2) ?>%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Reduction in zero-dose</td>
                                                                        <td>10% of 569,414 (per Dec 2022)</td>
                                                                        <td >Target reduction by end of year 1 (5%)</td>
                                                                        <td >Target reduction by end of year 2 (10%)</td>
                                                                        <td>Administrative Reports</td>
                                                                        <td>Quarterly</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table> -->

                                                            <table id="table_export" class="table table-bordered d-none">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?= $translations['text4'] ?></th> <!-- Indikator Jangka Panjang -->
                                                                        <th><?= $translations['text8'] ?></th> <!-- Indikator -->
                                                                        <th>Baseline</th>
                                                                        <th>2025</th>
                                                                        <th>2026</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- DPT-3 -->
                                                                    <tr>
                                                                        <td><?= $translations['table1text1'] ?></td>
                                                                        <td><?= $translations['table1text2'] ?></td>
                                                                        <td><?= number_format($long_term_outcomes['dpt3']['baseline_y1']) ?> (2024)</td>
                                                                        <td>90%</td>
                                                                        <td>95%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= $translations['table1text1'] ?></td>
                                                                        <td><?= $translations['table1text2'] ?></td>
                                                                        <td><?= number_format($long_term_outcomes['dpt3']['baseline_y2']) ?> (2025)</td>
                                                                        <td><?= number_format($long_term_outcomes['dpt3']['actual_y1'], 1) ?>%</td>
                                                                        <td><?= number_format($long_term_outcomes['dpt3']['actual_y2'], 1) ?>%</td>
                                                                    </tr>

                                                                    <!-- MR-1 -->
                                                                    <tr>
                                                                        <td><?= $translations['table1text1'] ?></td>
                                                                        <td><?= $translations['table1text3'] ?></td>
                                                                        <td><?= number_format($long_term_outcomes['mr1']['baseline_y1']) ?> (2024)</td>
                                                                        <td>90%</td>
                                                                        <td>95%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= $translations['table1text1'] ?></td>
                                                                        <td><?= $translations['table1text3'] ?></td>
                                                                        <td><?= number_format($long_term_outcomes['mr1']['baseline_y2']) ?> (2025)</td>
                                                                        <td><?= number_format($long_term_outcomes['mr1']['actual_y1'], 1) ?>%</td>
                                                                        <td><?= number_format($long_term_outcomes['mr1']['actual_y2'], 1) ?>%</td>
                                                                    </tr>

                                                                    <!-- Penurunan Zero Dose (25%) -->
                                                                    <tr>
                                                                        <td><?= $translations['table1text1'] ?></td>
                                                                        <td><?= $translations['table1text4'] ?></td>
                                                                        <td>25% <?= $translations['table1text5'] ?> <?= $long_term_outcomes['reduction_zd']['baseline'] ?></td>
                                                                        <td><?= $translations['table1text6'] ?></td>
                                                                        <td><?= $translations['table1text7'] ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= $translations['table1text1'] ?></td>
                                                                        <td><?= $translations['table1text4'] ?></td>
                                                                        <td></td>
                                                                        <td><?= number_format($long_term_outcomes['reduction_zd']['actual_y1'], 2) ?>%</td>
                                                                        <td><?= number_format($long_term_outcomes['reduction_zd']['actual_y2'], 2) ?>%</td>
                                                                    </tr>

                                                                    <!-- Penurunan Zero Dose (10%) -->
                                                                    <tr>
                                                                        <td><?= $translations['table1text4'] ?></td>
                                                                        <td>10% <?= $translations['table1text5'] ?> <?= $long_term_outcomes['reduction_zd']['baseline'] ?></td>
                                                                        <td></td>
                                                                        <td><?= $translations['table1text8'] ?></td>
                                                                        <td><?= $translations['table1text9'] ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                            <!-- Hapus dulu -->
                                                            <table class="table table-hover" id="table2">
                                                                <thead>
                                                                    <tr>
                                                                        <th rowspan="2"><?= $translations['text4'] ?></th>
                                                                        <th rowspan="2"><?= $translations['text8'] ?></th>
                                                                        <!-- <th colspan="3">Indicator Value</th> -->
                                                                        <!-- <th rowspan="2">Data Source</th>
                                                                        <th rowspan="2">Frequency of Reporting</th> -->
                                                                        <th>Baseline</th>
                                                                        <th>2025</th>
                                                                        <th>2026</th>
                                                                    </tr>
                                                                    <!-- <tr>
                                                                        <th>Baseline</th>
                                                                        <th>2024</th>
                                                                        <th>2025</th>
                                                                    </tr> -->
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td rowspan="7"><?= $translations['table1text1'] ?></td>
                                                                        <td rowspan="2"><?= $translations['table1text2'] ?></td>
                                                                        <td ><?= number_format($long_term_outcomes['dpt3']['baseline_y1']) ?> (2024)</td>
                                                                        <td class="table-success" style="text-align: center">90%</td>
                                                                        <td class="table-success" style="text-align: center">95%</td>
                                                                        <!-- <td rowspan="2">Administrative Reports</td>
                                                                        <td rowspan="2">Quarterly</td> -->
                                                                    </tr>
                                                                    <tr>
                                                                        <td ><?= number_format($long_term_outcomes['dpt3']['baseline_y2']) ?> (2025)</td>
                                                                        <td class="table-warning" style="text-align: center"><?= number_format($long_term_outcomes['dpt3']['actual_y1'], 1) ?>%</td>
                                                                        <td class="table-warning" style="text-align: center"><?= number_format($long_term_outcomes['dpt3']['actual_y2'], 1) ?>%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td rowspan="2"><?= $translations['table1text3'] ?></td>
                                                                        <td ><?= number_format($long_term_outcomes['mr1']['baseline_y1']) ?> (2024)</td>
                                                                        <td class="table-success" style="text-align: center">90%</td>
                                                                        <td class="table-success" style="text-align: center">95%</td>
                                                                        <!-- <td rowspan="2">Administrative Reports</td>
                                                                        <td rowspan="2">Quarterly</td> -->
                                                                    </tr>
                                                                    <tr>
                                                                        <td ><?= number_format($long_term_outcomes['mr1']['baseline_y2']) ?> (2025)</td>
                                                                        <td class="table-warning" style="text-align: center"><?= number_format($long_term_outcomes['mr1']['actual_y1'], 1) ?>%</td>
                                                                        <td class="table-warning" style="text-align: center"><?= number_format($long_term_outcomes['mr1']['actual_y2'], 1) ?>%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td rowspan="2"><?= $translations['table1text4'] ?></td>
                                                                        <td rowspan="2">25% <?= $translations['table1text5'] ?> <?= $long_term_outcomes['reduction_zd']['baseline'] ?></td>
                                                                        <td class="table-success"><?= $translations['table1text6'] ?></td>
                                                                        <td class="table-success"><?= $translations['table1text7'] ?></td>
                                                                        <!-- <td rowspan="2">Administrative Reports</td>
                                                                        <td rowspan="2">Quarterly</td> -->
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="table-warning" style="text-align: center"><?= number_format($long_term_outcomes['reduction_zd']['actual_y1'], 2) ?>%</td>
                                                                        <td class="table-warning" style="text-align: center"><?= number_format($long_term_outcomes['reduction_zd']['actual_y2'], 2) ?>%</td>
                                                                    </tr>
                                                                    <!-- <tr>
                                                                        <td><?= $translations['table1text4'] ?></td>
                                                                        <td>10% <?= $translations['table1text5'] ?> <?= $long_term_outcomes['reduction_zd']['baseline'] ?></td>
                                                                        <td ><?= $translations['table1text8'] ?></td>
                                                                        <td ><?= $translations['table1text9'] ?></td>=
                                                                    </tr> -->
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Graph Long Term -->
                            <!-- Long Term Outcome Graphs -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                    <div class="card-header"><strong><?= $translations['table1text2'] ?></strong></div>
                                    <div class="card-body">
                                        <canvas id="chartDpt3" height="300"></canvas>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                    <div class="card-header"><strong><?= $translations['table1text3'] ?></strong></div>
                                    <div class="card-body">
                                        <canvas id="chartMr1" height="300"></canvas>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card">
                                    <div class="card-header"><strong><?= $translations['table1text4'] ?></strong></div>
                                    <div class="card-body">
                                        <canvas id="chartZd" height="300"></canvas>
                                    </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Table 2: Intermediate Outcomes -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        
                                        <div class="card-header bg-danger text-white" style="color: white !important;">
                                            <h4 style="color: white !important;"><?= $translations['text5'] ?></h4>
                                            <button class="btn btn-primary ms-auto floating-button bg-danger border-danger" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent2" aria-expanded="false" aria-controls="cardContent2">
                                                <i class="bi bi-arrows-collapse"></i> 
                                            </button>
                                        </div>
                                        <div id="cardContent2" class="collapse show">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="table_export_2" class="table table-bordered d-none">
                                                            <thead>
                                                                <tr>
                                                                    <th><?= $translations['text5'] ?></th> <!-- Program Area -->
                                                                    <th><?= $translations['text8'] ?></th> <!-- Indicator -->
                                                                    <th><?= $translations['text9'] ?></th> <!-- Sub-Indicator -->
                                                                    <th>Baseline</th>
                                                                    <th>2025</th>
                                                                    <th>2026</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $translations['table2text1'] ?></td>
                                                                    <td><?= $translations['table2text2'] ?></td>
                                                                    <td><?= $translations['table2text3'] ?></td>
                                                                    <td><?= $translations['table2text4'] ?></td>
                                                                    <td>80%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table2text1'] ?></td>
                                                                    <td><?= $translations['table2text2'] ?></td>
                                                                    <td><?= $translations['table2text3'] ?></td>
                                                                    <td></td>
                                                                    <td><?= number_format(0, 2) ?>%</td>
                                                                    <td><?= number_format(0, 2) ?>%</td>
                                                                </tr>

                                                                <tr>
                                                                    <td><?= $translations['table2text5'] ?></td>
                                                                    <td><?= $translations['table2text6'] ?></td>
                                                                    <td><?= $translations['table2text7'] ?></td>
                                                                    <td></td>
                                                                    <td>90%</td>
                                                                    <td>93%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table2text5'] ?></td>
                                                                    <td><?= $translations['table2text6'] ?></td>
                                                                    <td><?= $translations['table2text7'] ?></td>
                                                                    <td></td>
                                                                    <td><?= number_format($percent_dpt1_coverage_2025, 2) ?>%</td>
                                                                    <td><?= number_format($percent_dpt1_coverage_2026, 2) ?>%</td>
                                                                </tr>

                                                                <tr>
                                                                    <td><?= $translations['table2text8'] ?></td>
                                                                    <td><?= $translations['table2text9'] ?></td>
                                                                    <td>62% (2021)</td>
                                                                    <td></td>
                                                                    <td>75%</td>
                                                                    <td>85%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table2text8'] ?></td>
                                                                    <td><?= $translations['table2text9'] ?></td>
                                                                    <td>62% (2021)</td>
                                                                    <td></td>
                                                                    <td><?= number_format($percent_districts_under_5_2025, 0) ?>%</td>
                                                                    <td><?= number_format($percent_districts_under_5_2026, 0) ?>%</td>
                                                                </tr>

                                                                <tr>
                                                                    <td><?= $translations['table2text10'] ?></td>
                                                                    <td><?= $translations['table2text11'] ?></td>
                                                                    <td><?= $translations['table2text12'] ?></td>
                                                                    <td></td>
                                                                    <td>30%</td>
                                                                    <td>50%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table2text10'] ?></td>
                                                                    <td><?= $translations['table2text11'] ?></td>
                                                                    <td><?= $translations['table2text12'] ?></td>
                                                                    <td></td>
                                                                    <td><?= number_format($percent_health_facilities_2025, 2) ?>%</td>
                                                                    <td><?= number_format($percent_health_facilities_2026, 2) ?>%</td>
                                                                </tr>

                                                                <tr>
                                                                    <td><?= $translations['table2text10'] ?></td>
                                                                    <td><?= $translations['table2text13'] ?></td>
                                                                    <td><?= $translations['table2text14'] ?></td>
                                                                    <td>N/A</td>
                                                                    <td><?= $translations['table2text15'] ?></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table2text10'] ?></td>
                                                                    <td><?= $translations['table2text13'] ?></td>
                                                                    <td><?= $translations['table2text14'] ?></td>
                                                                    <td></td>
                                                                    <td><?= number_format($total_dpt_stockout_2025); ?></td>
                                                                    <td><?= number_format($total_dpt_stockout_2026); ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><?= $translations['table2text10'] ?></td>
                                                                    <td><?= $translations['table2text16'] ?></td>
                                                                    <td><?= $translations['table2text17'] ?></td>
                                                                    <td>350</td>
                                                                    <td>235</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table2text10'] ?></td>
                                                                    <td><?= $translations['table2text16'] ?></td>
                                                                    <td><?= $translations['table2text17'] ?></td>
                                                                    <td></td>
                                                                    <td><?= number_format($private_facility_trained_2025) ?></td>
                                                                    <td><?= number_format($private_facility_trained_2026) ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td><?= $translations['table2text18'] ?></td>
                                                                    <td><?= $translations['table2text19'] ?></td>
                                                                    <td><?= $translations['table2text20'] ?></td>
                                                                    <td>50%</td>
                                                                    <td>90%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table2text18'] ?></td>
                                                                    <td><?= $translations['table2text19'] ?></td>
                                                                    <td><?= $translations['table2text20'] ?></td>
                                                                    <td></td>
                                                                    <td><?= $percent_district_funding_2025 ?>%</td>
                                                                    <td><?= $percent_district_funding_2026 ?>%</td>
                                                                </tr>

                                                                <tr>
                                                                    <td><?= $translations['table2text21'] ?></td>
                                                                    <td><?= $translations['table2text22'] ?></td>
                                                                    <td><?= $translations['table2text20'] ?></td>
                                                                    <td>50%</td>
                                                                    <td>90%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table2text21'] ?></td>
                                                                    <td><?= $translations['table2text22'] ?></td>
                                                                    <td><?= $translations['table2text20'] ?></td>
                                                                    <td></td>
                                                                    <td><?= $percent_district_policy_2025 ?>%</td>
                                                                    <td><?= $percent_district_policy_2026 ?>%</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table class="table table-hover" id="table">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2"><?= $translations['text5'] ?></th>
                                                                    <th rowspan="2"><?= $translations['text8'] ?></th>
                                                                    
                                                                    <th colspan="3"><?= $translations['text9'] ?></th>
                                                                    <!-- <th rowspan="2">Data Source</th>
                                                                    <th rowspan="2">Frequency of Reporting</th> -->
                                                                </tr>
                                                                <tr>
                                                                    <th>Baseline</th>
                                                                    <th>2025</th>
                                                                    <th>2026</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td rowspan="2"><?= $translations['table2text1'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text2'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text3'] ?></td>
                                                                    <td class="table-success"><?= $translations['table2text4'] ?></td>
                                                                    <td class="table-success">80%</td>
                                                                    <!-- <td rowspan="2">Indonesian Sehat Application (ASIK) digital-based</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <!-- <td class="table-warning"><?= number_format($percent_puskesmas_immunized_2025, 2) . '%' ?></td>
                                                                    <td class="table-warning"><?= number_format($percent_puskesmas_immunized_2026, 2) . '%' ?></td> -->
                                                                    <td class="table-warning"><?= number_format(0, 2) . '%' ?></td>
                                                                    <td class="table-warning"><?= number_format(0, 2) . '%' ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2"><?= $translations['table2text5'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text6'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text7'] ?></td>
                                                                    <td class="table-success">90%</td>
                                                                    <td class="table-success">93%</td>
                                                                    <!-- <td rowspan="2">Administrative Reports</td>
                                                                    <td rowspan="2">Quarterly</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= number_format($percent_dpt1_coverage_2025, 2) ?>%</td>
                                                                    <td class="table-warning"><?= number_format($percent_dpt1_coverage_2026, 2) ?>%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2"><?= $translations['table2text8'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text9'] ?></td>
                                                                    <td rowspan="2">62% (2021)</td>
                                                                    <td class="table-success">75%</td>
                                                                    <td class="table-success">85%</td>
                                                                    <!-- <td rowspan="2">Activity reports by EPI/health promotion unit/partners which include meeting minutes and trainee attendance</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= number_format($percent_districts_under_5_2025, 0) ?>%</td>
                                                                    <td class="table-warning"><?= number_format($percent_districts_under_5_2026, 0) ?>%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="6"><?= $translations['table2text10'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text11'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text12'] ?></td>
                                                                    <td class="table-success">30%</td>
                                                                    <td class="table-success">50%</td>
                                                                    <!-- <td rowspan="2">Supportive Supervision Report (Dashboard)</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">
                                                                        <?= number_format($percent_health_facilities_2025, 2) . '%'; ?>
                                                                    </td>
                                                                    <td class="table-warning">
                                                                        <?= number_format($percent_health_facilities_2026, 2) . '%'; ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td rowspan="2"><?= $translations['table2text13'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text14'] ?></td>
                                                                    <td class="table-success">N/A</td>
                                                                    <td class="table-success"><?= $translations['table2text15'] ?></td>
                                                                    <!-- <td rowspan="2">SMILE</td>
                                                                    <td rowspan="2"></td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= number_format($total_dpt_stockout_2025); ?></td>
                                                                    <td class="table-warning"><?= number_format($total_dpt_stockout_2026); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2"><?= $translations['table2text16'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text17'] ?></td>
                                                                    <td class="table-success">350</td>
                                                                    <td class="table-success">235</td>
                                                                    <!-- <td rowspan="2">Training results</td>
                                                                    <td rowspan="2"></td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">
                                                                        <?= number_format($private_facility_trained_2025) ?>
                                                                    </td>
                                                                    <td class="table-warning">
                                                                        <?= number_format($private_facility_trained_2026) ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2"><?= $translations['table2text18'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text19'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text20'] ?></td>
                                                                    <td class="table-success">50%</td>
                                                                    <td class="table-success">90%</td>
                                                                    <!-- <td rowspan="2">Assessment/reviews/survey/admins data</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= $percent_district_funding_2025; ?>%</td>
                                                                    <td class="table-warning"><?= $percent_district_funding_2026; ?>%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2"><?= $translations['table2text21'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text22'] ?></td>
                                                                    <td rowspan="2"><?= $translations['table2text20'] ?></td>
                                                                    <td class="table-success">50%</td>
                                                                    <td class="table-success">90%</td>
                                                                    <!-- <td rowspan="2">Assessment/reviews/survey</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= $percent_district_policy_2025; ?>%</td>
                                                                    <td class="table-warning"><?= $percent_district_policy_2026; ?>%</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Graph Intermediate Outcomes -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header"><strong><?= $translations['table2text2'] ?></strong></div>
                                        <div class="card-body">
                                            <canvas id="chartPuskesmasImunisasi" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header"><strong><?= $translations['table2text6'] ?></strong></div>
                                        <div class="card-body">
                                            <canvas id="chartDpt1Coverage" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header"><strong><?= $translations['table2text9'] ?></strong></div>
                                        <div class="card-body">
                                            <canvas id="chartDistrictDoUnder5" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sisanya bisa untuk grafik intermediate #2 dan #3 -->
                            </div>

                            <!-- Graph Intermediate Outcomes -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header"><strong><?= $translations['table2text11'] ?></strong></div>
                                        <div class="card-body">
                                            <canvas id="chartFacilityCompliant" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header"><strong><?= $translations['table2text13'] ?></strong></div>
                                        <div class="card-body">
                                            <canvas id="chartDptStockout" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header"><strong><?= $translations['table2text16'] ?></strong></div>
                                        <div class="card-body">
                                            <canvas id="chartFacilityGuided" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>


                                <!-- Sisanya bisa untuk grafik intermediate #2 dan #3 -->
                            </div>

                            <!-- Graph Intermediate Outcomes -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header"><strong><?= $translations['table2text19'] ?></strong></div>
                                        <div class="card-body">
                                            <canvas id="chartDistrictFunding" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header"><strong><?= $translations['table2text22'] ?></strong></div>
                                        <div class="card-body">
                                            <canvas id="chartDistrictPolicy" height="300"></canvas>
                                        </div>
                                    </div>
                                </div>


                                <!-- Sisanya bisa untuk grafik intermediate #2 dan #3 -->
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body">
                                        <?= form_open('home/index', ['method' => 'get']); ?>
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
                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                        <i class="bi bi-filter"></i> Submit
                                                    </button>
                                                </div>
                                            <?= form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Table 3: Grant Implementation & Budget Disbursement -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-warning text-white" style="color: white !important;">
                                            <h4 style="color: white !important;"><?= $translations['text6'] ?></h4>
                                            <button class="btn btn-primary ms-auto floating-button bg-warning border-warning" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent3" aria-expanded="false" aria-controls="cardContent3">
                                                <i class="bi bi-arrows-collapse"></i> 
                                            </button>
                                        </div>
                                        <div id="cardContent3" class="collapse show">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="table_export_3" class="table table-bordered d-none">
                                                            <thead>
                                                                <tr>
                                                                    <th><?= $translations['text8'] ?></th> <!-- Indicator -->
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                    <th>2026</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $translations['table3text1'] ?></td>
                                                                    <td>90%</td>
                                                                    <td>90%</td>
                                                                    <td>90%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $translations['table3text1'] ?></td>
                                                                    <td><?= $budget_absorption_2024 ?>%</td>
                                                                    <td><?= $budget_absorption_2025 ?>%</td>
                                                                    <td><?= $budget_absorption_2026 ?>%</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table class="table table-hover" id="table">
                                                            <thead >
                                                                <tr>
                                                                    <th rowspan="2"><?= $translations['text8'] ?></th>
                                                                    <th colspan="3"><?= $translations['text9'] ?></th>
                                                                    <!-- <th rowspan="2">Data Source</th>
                                                                    <th rowspan="2">Frequency of Reporting</th> -->
                                                                </tr>
                                                                <tr>
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                    <th>2026</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td rowspan="2"><?= $translations['table3text1'] ?></td>
                                                                    <td class="table-success">90%</td>
                                                                    <td class="table-success">90%</td>
                                                                    <td class="table-success">90%</td>
                                                                    <!-- <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= $budget_absorption_2024; ?>%</td>
                                                                    <td class="table-warning"><?= $budget_absorption_2025; ?>%</td>
                                                                    <td class="table-warning"><?= $budget_absorption_2026; ?>%</td>
                                                                </tr>
                                                                <!-- 
                                                                <tr>
                                                                    <td rowspan="2">Budget execution (use) rate for a given reporting period, domestic</td>
                                                                    <td>90%</td>
                                                                    <td>90%</td>
                                                                    <td rowspan="2">Reports from implementing partners, including MoH</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Timely disbursement of funds reaching sub-national level, Gavi</td>
                                                                    <td>n/a</td>
                                                                    <td>n/a</td>
                                                                    <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Timely disbursement of funds reaching sub-national level, domestic</td>
                                                                    <td>n/a</td>
                                                                    <td>n/a</td>
                                                                    <td rowspan="2">Reports from implementing partners, including MoH</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Funding allocated to civil society and community organizations</td>
                                                                    <td>n/a</td>
                                                                    <td>n/a</td>
                                                                    <td rowspan="2">Reports from implementing partners, including MoH</td>
                                                                    <td rowspan="2">[select from dropdown]</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr> -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table 4: Country Objectives -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-info text-white" style="color: white !important;">
                                            <h4 style="color: white !important;"><?= $translations['text7'] ?></h4>
                                            <button class="btn btn-primary ms-auto floating-button bg-info border-info" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent4" aria-expanded="false" aria-controls="cardContent4">
                                                <i class="bi bi-arrows-collapse"></i> 
                                            </button>
                                        </div>
                                        <div id="cardContent4" class="collapse show">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="table_export_4" class="table table-bordered d-none">
                                                            <thead>
                                                                <tr>
                                                                    <th><?= $translations['table4text1'] ?></th> <!-- Objective -->
                                                                    <th><?= $translations['text8'] ?></th>        <!-- Indicator -->
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                    <th>2026</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($objectives as $index => $objective): ?>
                                                                    <tr>
                                                                        <td><?= ($index + 1) . '. ' . $objective['objective_name']; ?></td>
                                                                        <td><?= $translations['table4text2'] ?></td>
                                                                        <td>90%</td>
                                                                        <td>100%</td>
                                                                        <td>100%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><?= ($index + 1) . '. ' . $objective['objective_name']; ?></td>
                                                                        <td><?= $translations['table4text2'] ?></td>
                                                                        <td><?= isset($completed_activities_2024[$objective['id']]) ? $completed_activities_2024[$objective['id']] : '100'; ?>%</td>
                                                                        <td><?= isset($completed_activities_2025[$objective['id']]) ? $completed_activities_2025[$objective['id']] : '100'; ?>%</td>
                                                                        <td><?= isset($completed_activities_2026[$objective['id']]) ? $completed_activities_2026[$objective['id']] : '100'; ?>%</td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>

                                                        <table class="table table-hover" id="table">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2"><?= $translations['table4text1'] ?></th>
                                                                    <th rowspan="2"><?= $translations['text8'] ?></th>
                                                                    <th colspan="3"><?= $translations['text9'] ?></th>
                                                                    <!-- <th rowspan="2">Data Source</th>
                                                                    <th rowspan="2">Frequency of Reporting</th> -->
                                                                </tr>
                                                                <tr>
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                    <th>2026</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($objectives as $index => $objective): ?>
                                                                    <tr>
                                                                        <td rowspan="2"><?= ($index + 1) . '. ' . $objective['objective_name']; ?></td>
                                                                        <td rowspan="2"><?= $translations['table4text2'] ?></td>
                                                                        <td class="table-success">90%</td>
                                                                        <td class="table-success">100%</td>
                                                                        <td class="table-success">100%</td>
                                                                        <!-- <td rowspan="2">Costed Workplan</td>
                                                                        <td rowspan="2">Annually</td> -->
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="table-warning"><?= $completed_activities_2024[$objective['id']] ?? '100'; ?>%</td>
                                                                        <td class="table-warning"><?= $completed_activities_2025[$objective['id']] ?? '100'; ?>%</td>
                                                                        <td class="table-warning"><?= $completed_activities_2026[$objective['id']] ?? '100'; ?>%</td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                            <!-- <tbody>
                                                                <tr>
                                                                    <td rowspan="2">1. Improve subnational capacity in planning, implementing and monitoring to catch-up vaccination</td>
                                                                    <td rowspan="2">Percent of workplan activities executed</td>
                                                                    <td>90%</td>
                                                                    <td>100%</td>
                                                                    <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">2. Improve routine data quality and data use, including high risk and hard to reach areas, to identify and target zero dose</td>
                                                                    <td rowspan="2">Percent of workplan activities executed</td>
                                                                    <td>90%</td>
                                                                    <td>100%</td>
                                                                    <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">3. Evidence-based demand generation supported by cross sectoral involvement, including private sector, particularly for missed communities</td>
                                                                    <td rowspan="2">Percent of workplan activities executed</td>
                                                                    <td>90%</td>
                                                                    <td>100%</td>
                                                                    <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">4. Improve EPI capacity at national and subnational level in vaccine logistics, social mobilization and advocacy for sustainable and equitable immunization coverage</td>
                                                                    <td rowspan="2">Percent of workplan activities executed</td>
                                                                    <td>90%</td>
                                                                    <td>100%</td>
                                                                    <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">5. Facilitate sustainable subnational financing for operations of immunization programs</td>
                                                                    <td rowspan="2">Percent of workplan activities executed</td>
                                                                    <td>90%</td>
                                                                    <td>100%</td>
                                                                    <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">6. Strengthen coordination to promote shared accountability at national and subnational level</td>
                                                                    <td rowspan="2">Percent of workplan activities executed</td>
                                                                    <td>80%</td>
                                                                    <td>100%</td>
                                                                    <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                            </tbody> -->
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                            </div>
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
    

<!-- Buttons HTML5 untuk export CSV & Excel -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
$(document).ready(function () {
    $('#table_export').DataTable({
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
        ],
        paging: false,
        searching: false,
        ordering: false,
        info: false // 👉 Tambahkan baris ini untuk menyembunyikan "Showing x to y of z entries"
    });

    $('#table_export_2').DataTable({
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
            ],
            paging: false,
            searching: false,
            ordering: false,
            info: false
        });
    
    $('#table_export_3').DataTable({
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
        ],
        paging: false,
        searching: false,
        ordering: false,
        info: false
    });
    $('#table_export_4').DataTable({
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
        ],
        paging: false,
        searching: false,
        ordering: false,
        info: false
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

    var table2 = $('#table3').DataTable({
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

<script>
    const lang = <?= json_encode($this->session->userdata('language') ?? 'en'); ?>;

    const t = {
        en: {
            dpt3_label: 'DPT-3 Coverage',
            mr1_label: 'MR-1 Coverage',
            zd_label_total: 'Zero Dose Children',
            zd_label_chased: 'Catch Up (Immunized)',
            zd_label_percent: '% Reduction',
            puskesmas_label: 'Number of Puskesmas',
            dpt_stockout_label: '<?= $translations['table2text13'] ?>',
            facility_guided_label: 'Number of Private Facilities',
            facility_compliant_label: 'Number of Puskesmas',
            district_do_label: 'Number of District',
            dpt1_coverage_label : 'DPT-1 Coverage',
            y_axis_absolute: 'Number of Children',
            y_axis_percent: 'Reduction (%)',
            tooltip_percent: '%: ',
            tooltip_absolute: ': '
        },
        id: {
            dpt3_label: 'Cakupan DPT-3',
            mr1_label: 'Cakupan MR-1',
            zd_label_total: 'Jumlah Anak Zero Dose',
            zd_label_chased: 'Sudah Diimunisasi Kejar',
            zd_label_percent: '% Penurunan',
            puskesmas_label: 'Jumlah Puskesmas',
            dpt_stockout_label: '<?= $translations['table2text13'] ?>',
            facility_guided_label: 'Jumlah Layanan Swasta',
            facility_compliant_label: 'Jumlah Puskesmas',
            district_do_label: 'Jumlah Kab/Kota',
            dpt1_coverage_label : 'Cakupan DPT-1',
            y_axis_absolute: 'Jumlah Anak',
            y_axis_percent: 'Penurunan (%)',
            tooltip_percent: '%: ',
            tooltip_absolute: ': '
        }
    }[lang];

    const labels = ['(2024) Baseline', '2025', '2026'];

    const dpt3 = <?= json_encode($long_term_outcomes['dpt3']) ?>;
    const mr1 = <?= json_encode($long_term_outcomes['mr1']) ?>;
    const zd = <?= json_encode($long_term_outcomes['reduction_zd']) ?>;

    const zd_baseline = zd.baseline;
    const zd_y1_kejar = zd.absolute_y1;
    const zd_y2_kejar = zd.absolute_y2;

    const zd_y1_total = zd_baseline;
    const zd_y2_total = zd_baseline;

    const zd_y1_sisa = zd_baseline - zd_y1_kejar;
    const zd_y2_sisa = zd_baseline - zd_y2_kejar;

    const zd_percent = [
        0,
        ((zd_y1_kejar / zd_baseline) * 100),
        ((zd_y2_kejar / zd_baseline) * 100)
    ];

    const colorBlue = '#007bff';
    const colorGreen = '#28a745';
    const colorCyan = '#17a2b8';
    const colorGray = '#6c757d';
    const colorRed = '#ff0000';
    const colorOrange = '#ffa500';

    function createMultiAxisChart(ctx, labels, datasets, isStacked = false, customYAxisLabels = {}) {
        const { y_label = t.y_axis_absolute, y1_label = t.y_axis_percent } = customYAxisLabels;

        new Chart(ctx, {
            type: 'bar',
            data: { labels, datasets },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                if (ctx.dataset.type === 'scatter') {
                                    return t.tooltip_percent + ctx.raw.y.toFixed(1) + '%';
                                } else {
                                    return `${ctx.dataset.label}${t.tooltip_absolute}${ctx.raw.toLocaleString('id-ID')}`;
                                }
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: isStacked,
                        title: { display: true, text: y_label },
                        ticks: { callback: v => v.toLocaleString('id-ID') }
                    },
                    y1: {
                        beginAtZero: true,
                        max: 110,
                        position: 'right',
                        grid: { drawOnChartArea: false },
                        title: { display: true, text: y1_label },
                        ticks: { callback: v => v + '%' }
                    }
                }
            }
        });
    }


    // === Chart DPT-3 ===
    createMultiAxisChart(
        document.getElementById('chartDpt3').getContext('2d'),
        labels,
        [
            {
                label: t.dpt3_label,
                data: [dpt3.baseline_y1, dpt3.absolute_y1, dpt3.absolute_y2],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 100 },
                    { x: 1, y: dpt3.actual_y1 },
                    { x: 2, y: dpt3.actual_y2 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        { y_label: t.y_axis_absolute, y1_label: 'Percentage (%)' }
    );


    // === Chart MR-1 ===
    createMultiAxisChart(
        document.getElementById('chartMr1').getContext('2d'),
        labels,
        [
            {
                label: t.mr1_label,
                data: [mr1.baseline_y1, mr1.absolute_y1, mr1.absolute_y2],
                backgroundColor: colorGreen,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 100 },
                    { x: 1, y: mr1.actual_y1 },
                    { x: 2, y: mr1.actual_y2 }
                ],
                backgroundColor: colorOrange,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        { y_label: t.y_axis_absolute, y1_label: 'Percentage (%)' }
    );


    // === Chart Zero Dose (Stacked) ===
    createMultiAxisChart(
        document.getElementById('chartZd').getContext('2d'),
        labels,
        [
            {
                label: t.zd_label_total,
                data: [zd_baseline, zd_y1_sisa, zd_y2_sisa],
                backgroundColor: colorGray,
                yAxisID: 'y',
                stack: 'zd'
            },
            {
                label: t.zd_label_chased,
                data: [0, zd_y1_kejar, zd_y2_kejar],
                backgroundColor: colorCyan,
                yAxisID: 'y',
                stack: 'zd'
            },
            {
                type: 'scatter',
                label: t.zd_label_percent,
                data: [
                    { x: 0, y: 0 },
                    { x: 1, y: zd_percent[1] },
                    { x: 2, y: zd_percent[2] }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        true,
        { y_label: t.y_axis_absolute, y1_label: t.zd_label_percent } // <-- label khusus
    );

</script>

<script>
    const puskesmasData = {
        baseline: <?= (int) $total_puskesmas ?>,
        2025: <?= (int) $absolute_puskesmas_immunized_2025 ?>,
        2026: <?= (int) $absolute_puskesmas_immunized_2026 ?>,
        percent_2025: <?= (float) $percent_puskesmas_immunized_2025 ?>,
        percent_2026: <?= (float) $percent_puskesmas_immunized_2026 ?>
    };

    createMultiAxisChart(
        document.getElementById('chartPuskesmasImunisasi').getContext('2d'),
        ['Baseline', '2025', '2026'],
        [
            {
                label: t.puskesmas_label,
                data: [
                    puskesmasData.baseline,
                    puskesmasData[2025],
                    puskesmasData[2026]
                ],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 100 },
                    { x: 1, y: puskesmasData.percent_2025 },
                    { x: 2, y: puskesmasData.percent_2026 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        { y_label: 'Number of Facilities', y1_label: 'Percentage (%)' }
    );

    const stockout = {
        baseline: 0,
        y1: <?= (int) $total_dpt_stockout_2025 ?>,
        y2: <?= (int) $total_dpt_stockout_2026 ?>,
        percent_y1: <?= (float) $percent_dpt_stockout_2025 ?>,
        percent_y2: <?= (float) $percent_dpt_stockout_2026 ?>
    };

    createMultiAxisChart(
        document.getElementById('chartDptStockout').getContext('2d'),
        ['Baseline', '2025', '2026'],
        [
            {
                label: t.dpt_stockout_label,
                data: [stockout.baseline, stockout.y1, stockout.y2],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 0 },
                    { x: 1, y: stockout.percent_y1 },
                    { x: 2, y: stockout.percent_y2 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        {
            y_label: 'Number of Facilities',
            y1_label: 'Percentage (%)'
        }
    );

    const facilityGuided = {
        baseline: 0, // Tidak ada baseline untuk 2024
        y1: <?= (int) $private_facility_trained_2025 ?>,
        y2: <?= (int) $private_facility_trained_2026 ?>,
        percent_y1: <?= (float) $percent_facility_2025 ?>,
        percent_y2: <?= (float) $percent_facility_2026 ?>,
        target_y1: <?= (int) $baseline_facility_2025 ?>,
        target_y2: <?= (int) $baseline_facility_2026 ?>
    };

    createMultiAxisChart(
        document.getElementById('chartFacilityGuided').getContext('2d'),
        ['2025', '2026'],
        [
            {
                label: 'Target',
                data: [facilityGuided.target_y1, facilityGuided.target_y2],
                backgroundColor: colorGray,
                yAxisID: 'y',
                type: 'bar'
            },
            {
                label: t.facility_guided_label,
                data: [facilityGuided.y1, facilityGuided.y2],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: facilityGuided.percent_y1 },
                    { x: 1, y: facilityGuided.percent_y2 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        {
            y_label: 'Number of Facilities',
            y1_label: 'Percentage (%)'
        }
    );

    const healthFacility = {
        baseline: <?= (int) $total_puskesmas ?>, // dari model langsung
        y1: <?= (int) $total_health_facilities_2025 ?>,
        y2: <?= (int) $total_health_facilities_2026 ?>,
        percent_y1: <?= (float) $percent_health_facilities_2025 ?>,
        percent_y2: <?= (float) $percent_health_facilities_2026 ?>
    };

    createMultiAxisChart(
        document.getElementById('chartFacilityCompliant').getContext('2d'),
        ['Baseline', '2025', '2026'],
        [
            {
                label: t.facility_compliant_label,
                data: [healthFacility.baseline, healthFacility.y1, healthFacility.y2],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 100 },
                    { x: 1, y: healthFacility.percent_y1 },
                    { x: 2, y: healthFacility.percent_y2 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        {
            y_label: 'Number of Facilities',
            y1_label: 'Percentage (%)'
        }
    );

    const districtDO = {
        baseline: <?= (int) $total_districts ?>,
        y1: <?= (int) $absolute_districts_under_5_2025 ?>,
        y2: <?= (int) $absolute_districts_under_5_2026 ?>,
        percent_y1: <?= (float) $percent_districts_under_5_2025 ?>,
        percent_y2: <?= (float) $percent_districts_under_5_2026 ?>
    };

    createMultiAxisChart(
        document.getElementById('chartDistrictDoUnder5').getContext('2d'),
        ['Baseline', '2025', '2026'],
        [
            {
                label: t.district_do_label,
                data: [districtDO.baseline, districtDO.y1, districtDO.y2],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 100 },
                    { x: 1, y: districtDO.percent_y1 },
                    { x: 2, y: districtDO.percent_y2 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        {
            y_label: 'Number of Districts',
            y1_label: 'Percentage (%)'
        }
    );

    const dpt1Coverage = {
        baseline_y1: <?= (int) $baseline_dpt1_target_2025 ?>,
        baseline_y2: <?= (int) $baseline_dpt1_target_2026 ?>,
        y1: <?= (int) $absolute_dpt1_coverage_2025 ?>,
        y2: <?= (int) $absolute_dpt1_coverage_2026 ?>,
        percent_y1: <?= (float) $percent_dpt1_coverage_2025 ?>,
        percent_y2: <?= (float) $percent_dpt1_coverage_2026 ?>
    };

    createMultiAxisChart(
        document.getElementById('chartDpt1Coverage').getContext('2d'),
        ['Baseline', '2025', '2026'],
        [
            {
                label: t.dpt1_coverage_label,
                data: [dpt1Coverage.baseline_y1, dpt1Coverage.y1, dpt1Coverage.y2],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 100 },
                    { x: 1, y: dpt1Coverage.percent_y1 },
                    { x: 2, y: dpt1Coverage.percent_y2 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        {
            y_label: 'Number of Children',
            y1_label: 'Percentage (%)'
        }
    );

    const districtFunding = {
        baseline: <?= (int) $total_districts ?>, // total kabupaten (baseline)
        y1: <?= (int) $absolute_district_funding_2025 ?>,
        y2: <?= (int) $absolute_district_funding_2026 ?>,
        percent_y1: <?= (float) $percent_district_funding_2025 ?>,
        percent_y2: <?= (float) $percent_district_funding_2026 ?>
    };

    createMultiAxisChart(
        document.getElementById('chartDistrictFunding').getContext('2d'),
        ['Baseline', '2025', '2026'],
        [
            {
                label: t.district_do_label,
                data: [districtFunding.baseline, districtFunding.y1, districtFunding.y2],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 100 },
                    { x: 1, y: districtFunding.percent_y1 },
                    { x: 2, y: districtFunding.percent_y2 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        {
            y_label: 'Number of Districts',
            y1_label: 'Percentage (%)'
        }
    );

    const districtPolicy = {
        baseline: <?= (int) $total_districts ?>,
        y1: <?= (int) $absolute_district_policy_2025 ?>,
        y2: <?= (int) $absolute_district_policy_2026 ?>,
        percent_y1: <?= (float) $percent_district_policy_2025 ?>,
        percent_y2: <?= (float) $percent_district_policy_2026 ?>
    };

    createMultiAxisChart(
        document.getElementById('chartDistrictPolicy').getContext('2d'),
        ['Baseline', '2025', '2026'],
        [
            {
                label: t.district_do_label,
                data: [districtPolicy.baseline, districtPolicy.y1, districtPolicy.y2],
                backgroundColor: colorBlue,
                yAxisID: 'y'
            },
            {
                type: 'scatter',
                label: '%',
                data: [
                    { x: 0, y: 100 },
                    { x: 1, y: districtPolicy.percent_y1 },
                    { x: 2, y: districtPolicy.percent_y2 }
                ],
                backgroundColor: colorRed,
                yAxisID: 'y1',
                pointRadius: 4
            }
        ],
        false,
        {
            y_label: 'Number of Districts',
            y1_label: 'Percentage (%)'
        }
    );








</script>




