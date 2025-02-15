<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Dashboard</h3>
                                <p class="text-subtitle text-muted">Accountability Framework​</p>
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
                                <strong>Note:</strong> 
                                <ul>
                                    <li>The cells highlighted in <span class="text-warning"><strong>yellow</strong></span> represent the <span class="text-warning"><strong>Actual</strong></span> values.</li>
                                    <li>The cells highlighted in <span class="text-success"><strong>green</strong></span> represent the <span class="text-success"><strong>Target</strong></span> values.</li>
                                </ul>
                            </div>



                            

                            <!-- Table 1: Long Term Outcomes -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="card-header bg-success text-white" style="color: white !important;">
                                            <h4 style="color: white !important;">Long Term Outcomes</h4>
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
                                                        <table class="table table-hover" id="table">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">Long Term Outcome</th>
                                                                    <th rowspan="2">Indicator</th>
                                                                    <!-- <th colspan="3">Indicator Value</th> -->
                                                                    <!-- <th rowspan="2">Data Source</th>
                                                                    <th rowspan="2">Frequency of Reporting</th> -->
                                                                    <th>Baseline</th>
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                </tr>
                                                                <!-- <tr>
                                                                    <th>Baseline</th>
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                </tr> -->
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td rowspan="7">MITIGATE<br>Coverage rates restored, including by reaching zero-dose children</td>
                                                                    <td rowspan="2">DPT3</td>
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
                                                                    <td rowspan="2">MR1 Coverage (additional long term indicator)</td>
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
                                                                    <td rowspan="2">Reduction in zero-dose</td>
                                                                    <td rowspan="2"><?= $long_term_outcomes['reduction_zd']['baseline'] ?></td>
                                                                    <td class="table-success">Target reduction by end of year 1 (15%)</td>
                                                                    <td class="table-success">Target reduction by end of year 2 (25%)</td>
                                                                    <!-- <td rowspan="2">Administrative Reports</td>
                                                                    <td rowspan="2">Quarterly</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning" style="text-align: center"><?= number_format($long_term_outcomes['reduction_zd']['actual_y1'], 2) ?>%</td>
                                                                    <td class="table-warning" style="text-align: center"><?= number_format($long_term_outcomes['reduction_zd']['actual_y2'], 2) ?>%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Reduction in zero-dose</td>
                                                                    <td>10% of 569,414 (per Dec 2022)</td>
                                                                    <td >Target reduction by end of year 1 (5%)</td>
                                                                    <td >Target reduction by end of year 2 (10%)</td>
                                                                    <!-- <td>Administrative Reports</td>
                                                                    <td>Quarterly</td> -->
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

                            <!-- Table 2: Intermediate Outcomes -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        
                                        <div class="card-header bg-danger text-white" style="color: white !important;">
                                            <h4 style="color: white !important;">Intermediate Outcomes</h4>
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
                                                        <table class="table table-hover" id="table">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">Intermediate Outcomes</th>
                                                                    <th rowspan="2">Indicator</th>
                                                                    
                                                                    <th colspan="3">Indicator Value</th>
                                                                    <!-- <th rowspan="2">Data Source</th>
                                                                    <th rowspan="2">Frequency of Reporting</th> -->
                                                                </tr>
                                                                <tr>
                                                                    <th>Baseline</th>
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td rowspan="2">Routine immunization services restored and reinforced to catch up missed children</td>
                                                                    <td rowspan="2">Percent of primary health facility to conduct immunization service as planned</td>
                                                                    <td rowspan="2">No Baseline Data (See cell comment)</td>
                                                                    <td class="table-success">No Y1 target</td>
                                                                    <td class="table-success">80%</td>
                                                                    <!-- <td rowspan="2">Indonesian Sehat Application (ASIK) digital-based</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= number_format($percent_puskesmas_immunized_2024, 2) . '%' ?></td>
                                                                    <td class="table-warning"><?= number_format($percent_puskesmas_immunized_2025, 2) . '%' ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Zero-dose children identified and targeted in reinforcement of routine immunization services</td>
                                                                    <td rowspan="2">DPT1 in targeted areas</td>
                                                                    <td rowspan="2">82.6% (10 provinces 2021)</td>
                                                                    <td class="table-success">90%</td>
                                                                    <td class="table-success">93%</td>
                                                                    <!-- <td rowspan="2">Administrative Reports</td>
                                                                    <td rowspan="2">Quarterly</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= number_format($percent_dpt1_coverage_2024, 2) ?>%</td>
                                                                    <td class="table-warning"><?= number_format($percent_dpt1_coverage_2025, 2) ?>%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Community demand for & confidence in vaccines and immunization services, including among missed communities</td>
                                                                    <td rowspan="2">Number of district with DO (DPT1-DPT3) less than 5%</td>
                                                                    <td rowspan="2">62% (2021)</td>
                                                                    <td class="table-success">75%</td>
                                                                    <td class="table-success">85%</td>
                                                                    <!-- <td rowspan="2">Activity reports by EPI/health promotion unit/partners which include meeting minutes and trainee attendance</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= number_format($percent_districts_under_5_2024, 0) ?>%</td>
                                                                    <td class="table-warning"><?= number_format($percent_districts_under_5_2025, 0) ?>%</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="6">Institutional capacities to plan and deliver sustained, equitable immunization programmes, as a platform for broader PHC delivery</td>
                                                                    <td rowspan="2">Number of health facilities manage immunization program as per national guidance in 10 targeted provinces. The data will be retracted from Supportive supervision report (dashboard)</td>
                                                                    <td rowspan="2">No baseline available</td>
                                                                    <td class="table-success">30%</td>
                                                                    <td class="table-success">50%</td>
                                                                    <!-- <td rowspan="2">Supportive Supervision Report (Dashboard)</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Number of DTP stock out at health facilities</td>
                                                                    <td rowspan="2">No DPT vaccine stock out in 2022</td>
                                                                    <td class="table-success">N/A</td>
                                                                    <td class="table-success">Zero stock outs</td>
                                                                    <!-- <td rowspan="2">SMILE</td>
                                                                    <td rowspan="2"></td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= number_format($total_dpt_stockout_2024); ?></td>
                                                                    <td class="table-warning"><?= number_format($total_dpt_stockout_2025); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Number of private facilities trained on Immunization Program Management for Private Sectors SOP</td>
                                                                    <td rowspan="2">248 (DKI Jakarta, East Java and Central Java) - HSS report</td>
                                                                    <td class="table-success">350</td>
                                                                    <td class="table-success">235</td>
                                                                    <!-- <td rowspan="2">Training results</td>
                                                                    <td rowspan="2"></td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Sufficient, sustained, and reliable domestic resources for immunization programmes</td>
                                                                    <td rowspan="2">Number of district allocated domestic funding for key immunization activities and other relevant activities to immunization program at 10 provinces</td>
                                                                    <td rowspan="2">No baseline available</td>
                                                                    <td class="table-success">50%</td>
                                                                    <td class="table-success">90%</td>
                                                                    <!-- <td rowspan="2">Assessment/reviews/survey/admins data</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
                                                                </tr>
                                                                <tr>
                                                                    <td rowspan="2">Political commitment to & accountability for equitable immunization (including zero-dose agenda) at national & subnational levels</td>
                                                                    <td rowspan="2">Number of district developed or enacted policy relevant to targeting zero dose and under immunized specifically or immunization program in general</td>
                                                                    <td rowspan="2">No baseline available</td>
                                                                    <td class="table-success">50%</td>
                                                                    <td class="table-success">90%</td>
                                                                    <!-- <td rowspan="2">Assessment/reviews/survey</td>
                                                                    <td rowspan="2">Annually</td> -->
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning">Actual</td>
                                                                    <td class="table-warning">Actual</td>
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
                                            <h4 style="color: white !important;">Grant Implementation & Budget Disbursement</h4>
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
                                                        <table class="table table-hover" id="table">
                                                            <thead >
                                                                <tr>
                                                                    <th rowspan="2">Indicator</th>
                                                                    <th colspan="2">Indicator Value</th>
                                                                    <th rowspan="2">Data Source</th>
                                                                    <th rowspan="2">Frequency of Reporting</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td rowspan="2">Budget execution (use) rate for a given reporting period, Gavi</td>
                                                                    <td class="table-success">90%</td>
                                                                    <td class="table-success">90%</td>
                                                                    <td rowspan="2">Costed Workplan</td>
                                                                    <td rowspan="2">Annually</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="table-warning"><?= $budget_absorption_2024; ?>%</td>
                                                                    <td class="table-warning"><?= $budget_absorption_2025; ?>%</td>
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
                                            <h4 style="color: white !important;">Country Objectives</h4>
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
                                                        <table class="table table-hover" id="table">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">Objective</th>
                                                                    <th rowspan="2">Indicator</th>
                                                                    <th colspan="2">Indicator Value</th>
                                                                    <th rowspan="2">Data Source</th>
                                                                    <th rowspan="2">Frequency of Reporting</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>2024</th>
                                                                    <th>2025</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($objectives as $index => $objective): ?>
                                                                    <tr>
                                                                        <td rowspan="2"><?= ($index + 1) . '. ' . $objective['objective_name']; ?></td>
                                                                        <td rowspan="2">Percent of workplan activities executed</td>
                                                                        <td class="table-success">90%</td>
                                                                        <td class="table-success">100%</td>
                                                                        <td rowspan="2">Costed Workplan</td>
                                                                        <td rowspan="2">Annually</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="table-warning"><?= $completed_activities_2024[$objective['id']] ?? '100'; ?>%</td>
                                                                        <td class="table-warning"><?= $completed_activities_2025[$objective['id']] ?? '100'; ?>%</td>
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
    
    