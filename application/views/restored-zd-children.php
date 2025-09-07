
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

                            <!-- DPT1 dan ZD -->
                            <div class="row">
                                <!-- National Baseline -->
                                <!-- <?php
                                    // if($selected_province == 'all'){
                                ?> -->
                                <div class="col-12 col-lg-6 col-md-12">
                                <!-- <?php
                                    // } else {
                                ?> -->
                                <!-- <div class="col-12 col-lg-12 col-md-12"> -->
                                <!-- <?php
                                    // }
                                ?> -->
                                
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5 text-center">
                                            <h6 class="text-muted font-semibold"><?= $translations['text_baseline'] ?></h6>
                                            <h6 class="font-extrabold mb-0 highlight"><?= number_format($national_baseline_zd) ?> <?= $translations['children'] ?></h6>
                                            <br>
                                            <?php
                                                if($selected_province == 'all'){
                                            ?>
                                                <div class="card-subtext"><?= $translations['text22'] ?></div>
                                            <?php
                                                } else {
                                            ?>
                                                <div class="card-subtext"><?= $translations['text21'] ?></div>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                    // if($selected_province == 'all'){
                                ?>
                                <!-- National Baseline -->
                                <div class="col-12 col-lg-6 col-md-12">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5 text-center">
                                            <h6 class="text-muted font-semibold"><?= $translations['text_baseline2'] ?></h6>
                                            <h6 class="font-extrabold mb-0 highlight">
                                                <?= number_format($dpt1_coverage_kejar) ?> <?= $translations['children'] . " ("; ?>
                                                <?php 
                                                    if ($national_baseline_zd == 0) {
                                                        echo "100% )";
                                                    } else {
                                                        echo number_format($dpt1_coverage_kejar / $national_baseline_zd * 100, 1) . "% )";
                                                    }
                                                ?>
                                            </h6>
                                            <br>
                                            <div class="card-subtext">
                                                <?= $translations['text5_3'] ?>
                                                <?= number_format($national_baseline_zd * 0.15) ?>
                                                <?= $translations['children'] ?>
                                                <?php echo " (15%)"; ?>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    // }
                                ?>
                            </div>

                            <!-- Target DPT1 in Year -->
                            <div class="row">
                                <!-- National Baseline -->
                                <div class="col-12 col-lg-12 col-md-12">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5 text-center">
                                            <h6 class="text-muted font-semibold"><?= $translations['text_baseline3'] . $selected_year ?></h6>
                                            <h6 class="font-extrabold mb-0 highlight">
                                                <?= number_format(${"total_target_dpt_1_in_$selected_year"}) ?> 
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    // }
                                ?>
                            </div>

                            <!-- LAST UPDATE -->
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 20px; text-align: left;">
                                    <!-- <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body"> -->
                                            
                                                <span  class="form-label" style="font-size: 14px;"><?= $translations['text23'] ?>​ <?= $last_update_date;?></span>
                                                
                                        <!-- </div>
                                    </div> -->
                                </div>
                            </div>

                            <!-- CARD  -->
                            <div class="row">
                                <!-- <?php //foreach ([2025, 2026] as $year): ?> -->
                                <?php foreach ([$selected_year] as $year): ?>
                                    <!-- Target Year -->
                                    <div class="col-6 col-lg-4 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                        <div class="stats-icon purple mb-2">
                                                            <i class="iconly-boldUser1"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                        <h6 class="text-muted font-semibold"><?= $translations['text1'] ?> <?= $year; ?> <br> <b> <?= $translations['text1_cumulative'] ?> <?= $max_month_name; ?> </b> </h6>
                                                        <?php
                                                            // Get the total target for the given year
                                                            $total_target = ${"total_target_dpt_1_$year"};  // We assume the variable already contains a valid value

                                                            // Calculate the quarter portion of the total target based on the quarter
                                                            $quarter_target = $total_target;

                                                            // Check if total target is 0, then set the quarter target to 0 as well
                                                            // if ($total_target == 0) {
                                                            //     $quarter_target = 0;
                                                            // } else {
                                                            //     // Calculate based on the quarter if total target is not zero
                                                            //     if ($quarter == 1) {
                                                            //         $quarter_target = $total_target / 4; // Quarter 1: 1/4 of total target
                                                            //     } elseif ($quarter == 2) {
                                                            //         $quarter_target = 2 * $total_target / 4; // Quarter 2: 2/4 of total target
                                                            //     } elseif ($quarter == 3) {
                                                            //         $quarter_target = 3 * $total_target / 4; // Quarter 3: 3/4 of total target
                                                            //     } elseif ($quarter == 4) {
                                                            //         $quarter_target = $total_target; // Quarter 4: Full total target
                                                            //     }
                                                            // }
                                                        ?>
                                                        <div class="card-number font-extrabold mb-0"><?= number_format($quarter_target); ?></div>
                                                        
                                                        <div class="card-subtext"><?= $translations['text2'] ?> <?= $year; ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- DPT-1 Coverage -->
                                    <div class="col-6 col-lg-4 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                        <div class="stats-icon blue mb-2">
                                                            <i class="iconly-boldPlus"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                        <h6 class="text-muted font-semibold"><?= $translations['text3'] ?> <?= $year; ?> <b> <?= $translations['text1_cumulative'] ?> <?= $max_month_name; ?> </b> </h6>
                                                        <div class="card-number font-extrabold mb-0"><?= number_format(${"total_dpt_1_$year"}); ?></div>
                                                        <div class="card-subtext">
                                                            <?= ${"total_target_dpt_1_in_$year"} > 0 
                                                                ? round((${"total_dpt_1_$year"} / ${"total_target_dpt_1_in_$year"}) * 100, 1) . $translations['text4'] . $year
                                                                : '0% of the target'; 
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Zero Dose -->
                                    <div class="col-6 col-lg-4 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start">
                                                        <div class="stats-icon red mb-2">
                                                            <i class="iconly-boldProfile"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                        <h6 class="text-muted font-semibold"><?= $translations['text5'] ?> <?= $year; ?> <b> <?= $translations['text1_cumulative'] ?> <?= $max_month_name; ?> </b></h6>
                                                        <div class="card-number font-extrabold mb-0"><?= number_format(${"zero_dose_$year"}); ?></div>
                                                        <!-- <div class="card-subtext"><?= ${"zd_narrative_$year"}; ?></div> -->
                                                        
                                                        <?php
                                                            $user_category = $this->session->userdata('user_category'); // Ambil kategori pengguna yang login

                                                            if($user_category != 7 && $user_category != 8){
                                                        ?>
                                                        <div class="card-subtext">
                                                        <?= $translations['text5_2'] ?> <?= $year; ?>
                                                            <?php if ($year == 2025): ?>
                                                                <?php echo " = "; ?>
                                                                <?= number_format($national_baseline_zd * 0.85) ?>
                                                                <?php echo " (15% " . $translations['text5_4'] . ")"; ?>
                                                                
                                                            <?php elseif ($year == 2026): ?>
                                                                <?php echo " = "; ?>
                                                                <?= number_format($national_baseline_zd * 0.75) ?>
                                                                <?php echo " (25% " . $translations['text5_4'] . ")"; ?>
                                                                
                                                            <?php else: ?>
                                                                <!-- You can put a default value here if needed -->
                                                                <?= number_format($national_baseline_zd) ?>
                                                            <?php endif; ?>
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>


                            <!-- DPT 3 dan MR1 -->
                            <div class="row">
                                <?php
                                    //  var_dump(number_format($total_dpt_3_2025));
                                    ?>
                                <?php // foreach ([2025, 2026] as $year): ?>
                                <?php foreach ([$selected_year] as $year): ?>
                                    <!-- DPT-3 Coverage -->
                                    
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <h6 class="text-muted font-semibold"><?= $translations['text10'] ?> <?= $year; ?></h6>
                                                <div class="card-number font-extrabold mb-3"><?= number_format(${"total_dpt_3_$year"}); ?></div>
                                                <div class="card-subtext mb-1"><?= ${"percent_dpt_3_$year"}; ?><?= $translations['text11'] ?></div>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                        style="width: <?= ${"percent_dpt_3_$year"}; ?>%;" 
                                                        aria-valuenow="<?= ${"percent_dpt_3_$year"}; ?>" 
                                                        aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="mt-1 text-muted mb-4"><?= number_format(${"missing_dpt_3_$year"}); ?> <?= $translations['text12'] ?> DPT-3</div>

                                                <!-- Baseline and Target Coverage -->
                                                <div class="mt-1">
                                                    <!-- <p><strong>Baseline: </strong><?= number_format(${"total_target_dpt_3_$year"}); ?> <?= $translations['children'] ?></p> -->
                                                    <!-- <p><strong>Baseline: </strong><?= number_format($national_baseline_dpt_mr['dpt3']); ?> <?= $translations['children'] ?></p> -->
                                                    <p><strong><?= $translations['text13'] ?> <?= ($year == 2025) ? '90%' : '95%'; ?> </strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MR-1 Coverage -->
                                    <div class="col-12 col-lg-6 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-4-5">
                                                <h6 class="text-muted font-semibold"><?= $translations['text14'] ?> <?= $year; ?></h6>
                                                <div class="card-number font-extrabold mb-3"><?= number_format(${"total_mr_1_$year"}); ?></div>
                                                <div class="card-subtext mb-1"><?= ${"percent_mr_1_$year"}; ?> <?= $translations['text11'] ?></div>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                        style="width: <?= ${"percent_mr_1_$year"}; ?>%;" 
                                                        aria-valuenow="<?= ${"percent_mr_1_$year"}; ?>" 
                                                        aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <div class="mt-1 text-muted mb-4"><?= number_format(${"missing_mr_1_$year"}); ?> <?= $translations['text12'] ?> MR-1</div>

                                                <!-- Baseline and Target Coverage -->
                                                <div class="mt-1">
                                                    <!-- <p><strong>Baseline: </strong><?= number_format(${"total_target_mr_1_$year"}); ?> <?= $translations['children'] ?></p> -->
                                                    <!-- <p><strong>Baseline: </strong><?= number_format($national_baseline_dpt_mr['mr1']); ?> <?= $translations['children'] ?></p> -->
                                                    <p><strong><?= $translations['text13'] ?> <?= ($year == 2025) ? '90%' : '95%'; ?> </strong></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- <div class="row">
                                <h4>Total Immunized Children</h4>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                    DPT 1 Immunized</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dpt_1) ?> <small>(<?= number_format($percent_dpt_1, 1) ?>%)</small></h6>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card"> 
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">DPT 3 Immunized</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_dpt_3) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">MR 1 Immunized</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($total_mr_1) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldProfile"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Reduction in Zero-Dose</h6>
                                                    <h6 class="font-extrabold mb-0"><?= number_format($reduction_in_zero_dose) ?></br> <small>(<?= number_format($percent_reduction_zero_dose, 0) ?>%)</small></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- table -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4><?= $selected_district == 'all' ? $translations['text17'] : $translations['text17_2'] ?> <?= $year; ?></h4>
                                        </div>
                                        <!-- <div class="card-body">
                                            <div id="chart-profile-visit"></div>
                                        </div> -->
                                        <div class="card-body">
                                            <!-- <button class="btn btn-primary floating-button" data-bs-toggle="modal"
                                                data-bs-target="#tableFilter">
                                                <i class="bi bi-funnel"></i> Filter
                                            </button> -->
                                            <!-- Filter Modal -->
                                            <div class="modal fade text-left" id="tableFilter" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel33">Filter Table </h4>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                        <form action="#">
                                                            <div class="modal-body">
                                                                <label for="groupFilter">Group: </label>
                                                                <div class="form-group">
                                                                    <select id="groupFilter" class="form-select">
                                                                        <option selected>All Group</option>
                                                                        <option>Group A</option>
                                                                        <option>Group B</option>
                                                                        <option>Group C</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!-- <button type="button" class="btn btn-light-secondary"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-x d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Close</span>
                                                                </button> -->
                                                                <button type="button" class="btn btn-primary ms-1"
                                                                    data-bs-dismiss="modal">
                                                                    <i class="bx bx-check d-block d-sm-none"></i>
                                                                    <span class="d-none d-sm-block">Apply</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table2">
                                                    <thead>
                                                        <tr>
                                                            <!-- <th><?= $translations['tabelcoloumn1'] ?></th>
                                                            <th><?= $translations['tabelcoloumn6'] ?></th> -->
                                                            <th><?= $selected_district == 'all' ? $translations['tabelcoloumn1'] : $translations['tabelcoloumn1_2'] ?></th>
                                                            <th><?= $selected_district == 'all' ? $translations['tabelcoloumn6'] : $translations['tabelcoloumn6_2'] ?> <?= $translations['text1_cumulative'] ?> <?= $max_month_name; ?></th>
                                                            <th><?= $translations['tabelcoloumn2'] ?> <?= $translations['text1_cumulative'] ?> <?= $max_month_name; ?></th>
                                                            <th><?= $translations['tabelcoloumn3'] ?> </th>
                                                            <th><?= $translations['tabelcoloumn4'] ?> <?= $translations['text1_cumulative'] ?> <?= $max_month_name; ?></th>
                                                            <th><?= $translations['tabelcoloumn5'] ?> <?= $translations['text1_cumulative'] ?> <?= $max_month_name; ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($district_data as $district): ?>
                                                            <tr>
                                                                <td><?= $district['district'] ?></td>
                                                                <td><?= number_format($district['target_district']) ?> </td>
                                                                <td><?= number_format($district['total_dpt1']) ?></td>
                                                                <td><?= number_format($district['percentage_target'], 2) ?>%</td>
                                                                <td><?= number_format($district['zero_dose_children']) ?></td>
                                                                <td><?= number_format($district['percent_zero_dose'], 2) ?>%</td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PETA -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4><?= $translations['text18'] ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- <div class="googlemaps">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d107.57311654129782!3d-6.903273917028756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1633023222539!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                            </div> -->
                                            <?php
                                                // var_dump($immunization_data);
                                            ?>
                                            <div id="map" style="height: 400px; position: relative;  z-index: 1;" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Grafik -->
                            <div class="row">
                                <!-- DPT Coverage per quarter -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title"><?= $translations['text24'] ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="dptChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- ZD Trend -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title"><?= $translations['text19'] ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- Tombol Filter Grafik (Hanya jika provinsi ≠ "All" atau "Targeted") -->
                                            <?php if ($show_chart_filter): ?>
                                                <!-- <button class="btn btn-primary floating-button" data-bs-toggle="modal" data-bs-target="#chartFilter">
                                                    <i class="bi bi-funnel"></i> Filter
                                                </button> -->

                                                <div class="modal fade text-left" id="chartFilter" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Filter Chart</h4>
                                                                <button type="button" class="close" data-bs-dismiss="modal">
                                                                    <i data-feather="x"></i>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="province" value="<?= $selected_province; ?>">

                                                                <!-- **Filter Distrik** -->
                                                                <label for="districtFilter" class="form-label">Select District:</label>
                                                                <?= form_dropdown('district', ['all' => 'All Districts'] + array_column($districts_array, 'name_id', 'id'), $selected_district, [
                                                                    'class' => 'form-select', 'id' => 'districtFilter'
                                                                ]); ?>

                                                                <!-- **Filter Tahun** -->
                                                                <label for="yearFilter" class="form-label mt-3">Select Year:</label>
                                                                <select id="yearFilter" class="form-select">
                                                                    <option value="2025" selected>2025</option>
                                                                    <option value="2026">2026</option>
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary" id="applyFilter">Apply</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                                // var_dump($zero_dose_cases);
                                                // var_dump($zero_dose_data);
                                            ?>
                                            <canvas id="zdChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <!-- ZD Region Type -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title"><?= $translations['text20'] ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                                // var_dump($restored_data);
                                            ?>
                                            <canvas id="locationChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-secondary mb-3" role="alert">
                                <strong><?= $translations['text26'] ?></strong> 
                            </div>
                            <!-- Grafik Kejar -->
                            <div class="row">
                                <!-- ZD Region Type -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title"><?= $translations['text25'] ?></h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- <canvas id="kejarChart" style="height: 500px; width: 100%;"></canvas> -->
                                             <canvas id="kejarChart" style="width: 100%; height: <?= count($chart_data) * 30 ?>px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- table kejar -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table3">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:30%"> 
                                                                <?php
                                                                    if( $selected_province === 'all' || $selected_province === 'targeted' ) {
                                                                ?>
                                                                    <?= $translations['tabel2coloumn1'] ?>
                                                                <?php
                                                                    } else if ($selected_district == 'all'){
                                                                ?>
                                                                    <?= $translations['tabel2coloumn1_b'] ?>
                                                                <?php
                                                                    } else {
                                                                ?>
                                                                    <?= $translations['tabel2coloumn1_c'] ?>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </th>
                                                            <th><?= $translations['tabel2coloumn5'] ?> </th>
                                                            <th><?= $translations['tabel2coloumn2'] ?> <?= $translations['text1_cumulative'] ?> <?= $max_month_name_asik; ?> </th>
                                                            <th><?= $translations['tabel2coloumn3'] ?> <?= $translations['text1_cumulative'] ?> <?= $max_month_name_manual; ?> </th>
                                                            <th><?= $translations['tabel2coloumn4'] ?> <?= $translations['text1_cumulative'] ?> <?= $max_month_name_kombinasi; ?> </th>
                                                            <th><?= $translations['tabel2coloumn6'] ?> </th>
                                                            <th><?= $translations['tabel2coloumn7'] ?> </th>
                                                            <th><?= $translations['tabel2coloumn8'] ?> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($chart_data as $data): ?>
                                                            <tr>
                                                                <td><?= $data['name'] ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['zd_total']) ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['kejar_asik']) ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['kejar_manual']) ?></td>
                                                                <td style="text-align: center;"><?= number_format($data['kejar_kombinasi']) ?></td>
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
$(document).ready(function () {
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
            kejar_asik: "Catch up (ASIK)",
            kejar_manual: "Catch up (Manual)",
            kejar_kombinasi: "Catch up (Combined)",
            zd_total: "Zero Dose Children in 2024",
            percent_asik: "% Catch up (ASIK)",
            percent_manual: "% Catch up (Manual)",
            percent_kombinasi: "% Catch up (Combined)",
            y1_title: "% of ZD",
            y_title: "Number of Children"
        },
        id: {
            kejar_asik: "Imunisasi Kejar (ASIK)",
            kejar_manual: "Imunisasi Kejar (Manual)",
            kejar_kombinasi: "Imunisasi Kejar (Kombinasi)",
            zd_total: "Jumlah Anak Zero Dose Tahun 2024",
            percent_asik: "% Imunisasi Kejar (ASIK)",
            percent_manual: "% Imunisasi Kejar (Manual)",
            percent_kombinasi: "% Imunisasi Kejar (Kombinasi)",
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
                    yAxisID: 'y',
                    order: 1 // ✅ tampil duluan
                },
                {
                    label: t.kejar_manual,
                    data: kejarManual,
                    backgroundColor: '#28a745', // Hijau
                    stack: 'total',
                    yAxisID: 'y',
                    order: 2 // ✅ tampil duluan
                },
                {
                    label: t.kejar_kombinasi,
                    data: kejarKombinasi,
                    backgroundColor: '#ffc107', // Kuning
                    stack: 'total',
                    yAxisID: 'y',
                    order: 3 // ✅ tampil duluan
                },
                {
                    label: t.zd_total,
                    data: zdTotal,
                    backgroundColor: '#dee2e6', // Abu
                    stack: 'total',
                    yAxisID: 'y',
                    order: 4 // ✅ tampil duluan
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
                    clip: false, // ✅ tambahkan ini
                    order: 10, // ✅ scatter muncul terakhir
                    datalabels: {
                        display: true,
                        anchor: 'end',    
                        align: 'right',   
                        // formatter: value => value.y > 0 ? value.y + '%' : '',
                        formatter: value => value.x > 0 ? value.x.toFixed(1) + '%' : '',
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
                    clip: false, // ✅ tambahkan ini 
                    order: 12, // ✅ scatter muncul terakhir
                    datalabels: {
                        display: true,
                        anchor: 'end',    
                        align: 'right',    
                        // formatter: value => value.y > 0 ? value.y + '%' : '',
                        formatter: value => value.x > 0 ? value.x.toFixed(1) + '%' : '',
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
                    clip: false, // ✅ tambahkan ini
                    order: 13, // ✅ scatter muncul terakhir
                    datalabels: {
                        display: true,
                        anchor: 'end',    
                        align: 'right',   
                        // formatter: value => value.y > 0 ? value.y + '%' : '',
                        formatter: value => value.x > 0 ? value.x.toFixed(1) + '%' : '',
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
                            // max: 100,
                            suggestedMax: 100,
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
});
</script>


<!-- Grafik Line ZD Trend-->
<script>
    $(document).ready(function () {
            // console.log("Zero Dose Data:", <?= json_encode($zero_dose_cases); ?>);

            const zeroDoseData = <?= json_encode($zero_dose_cases); ?>;

            
            let isProvinceLevelCheck = ["all", "targeted"].includes("<?= $selected_province ?>");
            let isDistrictLevelCheck = ["all", "targeted"].includes("<?= $selected_district ?>");

            // Mapping data untuk Chart.js
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            let zdCases2025 = Array(12).fill(null);
            let zdCases2026 = Array(12).fill(null);

            zeroDoseData.forEach(item => {
                if (item.year === 2025) {
                    zdCases2025[item.month - 1] = item.zd_cases;
                } else if (item.year === 2026) {
                    zdCases2026[item.month - 1] = item.zd_cases;
                }
            });

            year = <?= $selected_year ?>;
            let scaleXlabel ='';
            let scaleYlabel ='';
            let titleLineChart ='';

            // Object untuk menyimpan terjemahan
            const translationsLineChart = {
                    en: {
                        title: `Number of ZD Children from 2024 Targeted for Outreach in Year ${year}`,
                        scaleX: 'Months',
                        scaleY: 'ZD Children'
                        
                    },
                    id: {
                        title: `Jumlah Anak ZD 2024 yang dikejar di Tahun ${year}`,
                        scaleX: 'Bulan',
                        scaleY: 'Jumlah Anak ZD'
                    }
            };

            function setLanguageLineChart(lang) {
                titleLineChart = translationsLineChart[lang].title;
                scaleXlabel = translationsLineChart[lang].scaleX;
                scaleYlabel = translationsLineChart[lang].scaleY;
            }

            // Function to find first non-null value in an array, or 0 if none found
            function firstNonNullValue(arr) {
                for (let val of arr) {
                    if (val !== null && val !== undefined) return val;
                }
                return 0;
            }

            // Get first non-null zd case value for the selected year
            let firstValue = 0;
            if (year === 2025) {
                firstValue = firstNonNullValue(zdCases2025);
            } else if (year === 2026) {
                firstValue = firstNonNullValue(zdCases2026);
            }

            // Tentukan batas atas dan bawah Y axis berdasarkan checkProvince, checkDistrict, dan firstValue
            let yMin = 0;
            let yMax = 1000000; // default Per Indonesia

            if (firstValue === 0) {
                // If no data, set a default max to avoid zero scale
                yMax = 1000;
            } else {
                // Set yMax as 10% above the first value
                yMax = firstValue * 1.1;
            }

            // Inisialisasi bahasa berdasarkan localStorage
            // let savedLang = localStorage.getItem("selectedLanguage");
            const savedLang = localStorage.getItem("selectedLanguage") || 'en'; // Default fallback
            setLanguageLineChart(savedLang);

            let zdChart; // Mendeklarasikan variable untuk chart
            const zdCtx = document.getElementById('zdChart').getContext('2d');
            zdChart = new Chart(zdCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: titleLineChart,
                        data: year === 2025 ? zdCases2025 : zdCases2026,
                        backgroundColor: 'rgba(0, 86, 179, 0.2)',
                        borderColor: 'rgba(0, 86, 179, 1)',
                        borderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        // legend: { display: true, position: 'top' }
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
                    },
                    scales: {
                        x: { title: { display: true, text: scaleXlabel } },
                        y: {
                                title: { display: true, text: scaleYlabel },
                                min: yMin,
                                max: yMax
                            }
                    }
                }
            });


            // Fungsi untuk menangani perubahan filter tahun dan distrik
            $(document).ready(function () {
                $("#applyFilter").click(function () {
                    let selectedYear = $("#yearFilter").val(); // Ambil tahun yang dipilih
                    let selectedDistrict = $("#districtFilter").val(); // Ambil district yang dipilih
                    let selectedProvince = $("input[name='province']").val(); // Ambil province (hidden input)

                    // Lakukan ajax untuk mengambil data berdasarkan filter yang dipilih
                    $.ajax({
                        url: "<?= base_url('home/get_zero_dose_trend_ajax'); ?>", 
                        type: "GET",
                        data: {
                            province: selectedProvince,
                            district: selectedDistrict
                        },
                        dataType: "json",
                        success: function (response) {
                                        // console.log("Filtered Data:", response);

                                        // Filter data berdasarkan tahun yang dipilih
                                        let filteredData = response.filter(item => item.year == selectedYear);

                                        // Pastikan dataset lama dihapus sebelum menambahkan yang baru
                                        zdChart.data.labels = filteredData.map(item => months[item.month - 1]);
                                        zdChart.data.datasets = [{
                                            label: `ZD Cases ${selectedYear}`,
                                            data: filteredData.map(item => item.zd_cases),
                                            backgroundColor: selectedYear == 2025 ? 'rgba(0, 86, 179, 0.2)' : 'rgba(255, 99, 132, 0.2)',
                                            borderColor: selectedYear == 2025 ? 'rgba(0, 86, 179, 1)' : 'rgba(255, 99, 132, 1)',
                                            borderWidth: 2,
                                            tension: 0.4
                                        }];

                                        zdChart.update(); // Update grafik
                                    },
                        error: function (xhr, status, error) {
                            console.error("Error fetching data:", error);
                        }
                    });

                    $("#chartFilter").modal("hide"); // Tutup modal filter
                });
            });


                // **Fungsi untuk menambahkan tombol download secara dinamis**
                function addZdDownloadButtons() {
                    const container = zdCtx.canvas.parentNode;

                    // Buat wrapper untuk tombol
                    const buttonWrapper = document.createElement('div');
                    buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

                    // Tombol Download CSV
                    const csvButton = document.createElement('button');
                    csvButton.textContent = 'Download CSV';
                    csvButton.className = 'btn btn-primary btn-sm'; // Ukuran kecil
                    csvButton.addEventListener('click', () => downloadZdCSV());

                    // Tombol Download Excel
                    const excelButton = document.createElement('button');
                    excelButton.textContent = 'Download Excel';
                    excelButton.className = 'btn btn-success btn-sm'; // Ukuran kecil
                    excelButton.addEventListener('click', () => downloadZdExcel());

                    // Tambahkan tombol ke dalam wrapper
                    buttonWrapper.appendChild(csvButton);
                    buttonWrapper.appendChild(excelButton);

                    // Sisipkan wrapper di atas grafik
                    container.insertBefore(buttonWrapper, zdCtx.canvas);
                }

                // **Fungsi untuk download CSV**
                function downloadZdCSV() {
                    const labels = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    
                    // Ambil dataset yang sedang digunakan di chart
                    let dataset = zdChart.data.datasets[0]; // Ambil dataset aktif
                    let year = dataset.label.match(/\d{4}/)[0]; // Ambil tahun dari label dataset

                    let csvContent = "data:text/csv;charset=utf-8,";
                    csvContent += `Month,ZD Cases ${year}\n`; // Header CSV

                    labels.forEach((label, index) => {
                        let value = dataset.data[index] ?? ""; // Ambil data bulan tertentu, jika tidak ada kosongkan
                        csvContent += `${label},${value}\n`;
                    });

                    const encodedUri = encodeURI(csvContent);
                    const link = document.createElement("a");
                    link.setAttribute("href", encodedUri);
                    link.setAttribute("download", `zero_dose_cases_${year}.csv`);
                    document.body.appendChild(link);
                    link.click();
                }


                // **Fungsi untuk download Excel**
                function downloadZdExcel() {
                    const labels = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];

                    // Ambil dataset yang sedang digunakan
                    let dataset = zdChart.data.datasets[0];
                    let year = dataset.label.match(/\d{4}/)[0]; // Ambil tahun dari label dataset

                    // Buat workbook Excel
                    const workbook = XLSX.utils.book_new();
                    const worksheetData = [["Month", `ZD Cases ${year}`], 
                        ...labels.map((label, index) => [label, dataset.data[index] ?? ""])
                    ];
                    const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
                    XLSX.utils.book_append_sheet(workbook, worksheet, "Zero Dose Cases");

                    // Generate file Excel dan unduh
                    XLSX.writeFile(workbook, `zero_dose_cases_${year}.xlsx`);
                }


                // **Tambahkan tombol download ke DOM**
                addZdDownloadButtons();
    });
</script>

<!-- Grafik Line DPT Coverage per quarter -->
<!-- <script>
$(document).ready(function () {
    const quarters = <?= json_encode($quarters); ?>;
    const targetData = <?= json_encode($target_data); ?>;
    const coverageData = <?= json_encode($coverage_data); ?>;

    let nowQuarter = <?= $quarter; ?>;
    
    const quarter = ["Q1", "Q2", "Q3", "Q4"];
    
    // Object for chart translations (you can adapt this based on your selected language)
    const translationsCoverageLineChart = {
        en: {
            title: 'DPT-1 Target and Coverage per Quarter',
            scaleX: 'Quarters',
            scaleY: 'Target / Coverage'
        },
        id: {
            title: 'Sasaran dan Cakupan DPT-1 per Triwulan',
            scaleX: 'Triwulan',
            scaleY: 'Sasaran / Cakupan'
        }
    };

    let titleCoverageLineChart = translationsCoverageLineChart['en'].title;
    let scaleXlabel3 = translationsCoverageLineChart['en'].scaleX;
    let scaleYlabel3 = translationsCoverageLineChart['en'].scaleY;

    // Slice data to only show up to the current quarter
    // const quartersToShow = quarter.slice(0, nowQuarter);
    // const targetDataToShow = targetData.slice(0, nowQuarter);
    const coverageDataToShow = coverageData.slice(0, nowQuarter);

    // Create the chart
    const ctx = document.getElementById('dptChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: quarter,
            datasets: [{
                label: 'Target DPT-1',
                data: targetData,
                backgroundColor: 'rgba(0, 86, 179, 0.2)',
                borderColor: 'rgba(0, 86, 179, 1)',
                borderWidth: 2,
                tension: 0.4
            }, {
                label: 'DPT-1 Coverage',
                // data: coverageData,
                data: coverageDataToShow,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                // legend: { display: true, position: 'top' }
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
            },
            scales: {
                x: { title: { display: true, text: scaleXlabel3 } },
                y: { title: { display: true, text: scaleYlabel3 } }
            }
        }
    });

    // **Fungsi untuk menambahkan tombol download secara dinamis**
    function addCoverageDownloadButtons() {
        const container = ctx.canvas.parentNode;

        // Buat wrapper untuk tombol
        const buttonWrapper = document.createElement('div');
        buttonWrapper.className = 'd-flex mb-3 gap-2'; // Bootstrap classes

        // Tombol Download CSV
        const csvButton = document.createElement('button');
        csvButton.textContent = 'Download CSV';
        csvButton.className = 'btn btn-primary btn-sm'; // Ukuran kecil
        csvButton.addEventListener('click', () => downloadCoverageCSV());

        // Tombol Download Excel
        const excelButton = document.createElement('button');
        excelButton.textContent = 'Download Excel';
        excelButton.className = 'btn btn-success btn-sm'; // Ukuran kecil
        excelButton.addEventListener('click', () => downloadCoverageExcel());

        // Tambahkan tombol ke dalam wrapper
        buttonWrapper.appendChild(csvButton);
        buttonWrapper.appendChild(excelButton);

        // Sisipkan wrapper di atas grafik
        container.insertBefore(buttonWrapper, ctx.canvas);
    }

    // **Fungsi untuk download CSV**
    function downloadCoverageCSV() {
        const labels = ["Q1", "Q2", "Q3", "Q4"];
        
        // Ambil dataset yang sedang digunakan di chart
        let dataset = zdChart.data.datasets[0]; // Ambil dataset aktif
        let year = dataset.label.match(/\d{4}/)[0]; // Ambil tahun dari label dataset

        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += `Quarter,Target DPT-1, DPT-1 Coverage\n`; // Header CSV

        labels.forEach((label, index) => {
            let target = targetData[index] ?? ""; // Ambil data target bulan tertentu, jika tidak ada kosongkan
            let coverage = coverageData[index] ?? ""; // Ambil data cakupan bulan tertentu, jika tidak ada kosongkan
            csvContent += `${label},${target},${coverage}\n`;
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `dpt_coverage_data.csv`);
        document.body.appendChild(link);
        link.click();
    }

    // **Fungsi untuk download Excel**
    function downloadCoverageExcel() {
        const labels = ["Q1", "Q2", "Q3", "Q4"];

        // Ambil dataset yang sedang digunakan
        let dataset = zdChart.data.datasets[0];
        let year = dataset.label.match(/\d{4}/)[0]; // Ambil tahun dari label dataset

        // Buat workbook Excel
        const workbook = XLSX.utils.book_new();
        const worksheetData = [["Quarter", "Target DPT-1", "DPT-1 Coverage"], 
            ...labels.map((label, index) => [label, targetData[index] ?? "", coverageData[index] ?? ""])
        ];
        const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
        XLSX.utils.book_append_sheet(workbook, worksheet, "DPT-1 Coverage");

        // Generate file Excel dan unduh
        XLSX.writeFile(workbook, `dpt_coverage_data_${year}.xlsx`);
    }

    // **Tambahkan tombol download ke DOM**
    addCoverageDownloadButtons();
});
</script> -->

<!-- Grafik Line DPT Coverage per month -->
<script>
$(document).ready(function () {
    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    const targetData = <?= json_encode($target_data); ?>;   // Akumulatif target per bulan
    const coverageData = <?= json_encode($coverage_data); ?>; // Cakupan real per bulan

    // Tentukan bulan terakhir (opsional, jika hanya ingin tampil sampai bulan tertentu)
    let nowMonth = <?= $max_month ?? 12; ?>;

    // Object for chart translations
    const translationsCoverageLineChart = {
        en: {
            title: 'DPT-1 Target and Coverage per Month',
            scaleX: 'Months',
            scaleY: 'Target / Coverage'
        },
        id: {
            title: 'Sasaran dan Cakupan DPT-1 per Bulan',
            scaleX: 'Bulan',
            scaleY: 'Sasaran / Cakupan'
        }
    };

    let titleCoverageLineChart = translationsCoverageLineChart['en'].title;
    let scaleXlabel3 = translationsCoverageLineChart['en'].scaleX;
    let scaleYlabel3 = translationsCoverageLineChart['en'].scaleY;

    // Slice data sampai bulan terakhir (misalnya: Sep = bulan ke-9 → index 8)
    const labelsToShow = months.slice(0, nowMonth);
    const targetDataToShow = targetData.slice(0, nowMonth);
    const coverageDataToShow = coverageData.slice(0, nowMonth);

    const ctx = document.getElementById('dptChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labelsToShow,
            datasets: [{
                label: 'Target DPT-1',
                data: targetDataToShow,
                backgroundColor: 'rgba(0, 86, 179, 0.2)',
                borderColor: 'rgba(0, 86, 179, 1)',
                borderWidth: 2,
                tension: 0.4
            }, {
                label: 'DPT-1 Coverage',
                data: coverageDataToShow,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
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
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: scaleXlabel3
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: scaleYlabel3
                    },
                    beginAtZero: true
                }
            }
        }
    });

    // Fungsi untuk download tombol CSV & Excel tetap sama
    function addCoverageDownloadButtons() {
        const container = ctx.canvas.parentNode;

        const buttonWrapper = document.createElement('div');
        buttonWrapper.className = 'd-flex mb-3 gap-2';

        const csvButton = document.createElement('button');
        csvButton.textContent = 'Download CSV';
        csvButton.className = 'btn btn-primary btn-sm';
        csvButton.addEventListener('click', () => downloadCoverageCSV());

        const excelButton = document.createElement('button');
        excelButton.textContent = 'Download Excel';
        excelButton.className = 'btn btn-success btn-sm';
        excelButton.addEventListener('click', () => downloadCoverageExcel());

        buttonWrapper.appendChild(csvButton);
        buttonWrapper.appendChild(excelButton);
        container.insertBefore(buttonWrapper, ctx.canvas);
    }

    function downloadCoverageCSV() {
        const labels = months.slice(0, nowMonth);

        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += `Month,Target DPT-1,DPT-1 Coverage\n`;

        labels.forEach((label, index) => {
            let target = targetData[index] ?? "";
            let coverage = coverageData[index] ?? "";
            csvContent += `${label},${target},${coverage}\n`;
        });

        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", `dpt_coverage_data.csv`);
        document.body.appendChild(link);
        link.click();
    }

    function downloadCoverageExcel() {
        const labels = months.slice(0, nowMonth);

        const workbook = XLSX.utils.book_new();
        const worksheetData = [["Month", "Target DPT-1", "DPT-1 Coverage"],
            ...labels.map((label, index) => [
                label,
                targetData[index] ?? "",
                coverageData[index] ?? ""
            ])
        ];
        const worksheet = XLSX.utils.aoa_to_sheet(worksheetData);
        XLSX.utils.book_append_sheet(workbook, worksheet, "DPT-1 Coverage");
        XLSX.writeFile(workbook, `dpt_coverage_data.xlsx`);
    }

    addCoverageDownloadButtons();
});
</script>


<!-- Grafik Bar -->
<script>
$(document).ready(function () {
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
            const savedLang = localStorage.getItem("selectedLanguage") || 'en'; // Default fallback
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
                        // legend: {
                        //     display: false
                        // }
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
});
</script>

<!-- Peta -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('map').setView([-7.250445, 112.768845], 7);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let immunizationData = <?= json_encode($immunization_data, JSON_NUMERIC_CHECK); ?>;
        // console.log(immunizationData);
        
        function cleanCityCode(code) { 
            if (!code) return ""; 
            return String(code).replace(/\./g, ''); 
        }

        function formatValue(value, isPercentage = false) {
            if (isNaN(value) || value === null || value === undefined) {
                return isPercentage ? "0%" : "0";
            }
            return isPercentage ? value.toFixed(1) + "%" : value;
        }

        function getColor(percentReductionZD) {
            // let threshold = isProvince ? 10000 : 1000;
            // return dpt1 > threshold ? '#1A9850' : '#D73027';
            // return percentReductionZD > 85 ? '#1A9850' : '#D73027';

            let yearFilter = <?= $selected_year; ?>;

            // Adjust the color condition based on the selected year
            if (yearFilter === 2025) {
                return percentReductionZD > 15 ? '#1A9850' : '#D73027';
            } else if (yearFilter === 2026) {
                return percentReductionZD > 25 ? '#1A9850' : '#D73027';
            }
        }

        let isProvinceLevel = ["all", "targeted"].includes("<?= $selected_province ?>");

        fetch("<?= $geojson_file; ?>")
        .then(response => response.json())
        .then(data => {
            let geojsonLayer = L.geoJSON(data, {
                style: function (feature) {
                    let rawCode = isProvinceLevel 
                        ? feature.properties.KDPPUM  
                        : feature.properties.KDPKAB; 

                    let regionId = cleanCityCode(rawCode);
                    let regionData = immunizationData[regionId] || {}; 

                    let dpt1 = formatValue(regionData.dpt1);
                    let percentReductionZD  = formatValue(regionData.percent_reduction);
                    // console.log(percentReductionZD);

                    return {
                        fillColor: getColor(percentReductionZD),
                        weight: 1.5,
                        opacity: 1,
                        color: '#ffffff',
                        fillOpacity: 0.8
                    };
                },
                onEachFeature: function (feature, layer) {
                    let rawCode = isProvinceLevel 
                        ? feature.properties.KDPPUM  
                        : feature.properties.KDPKAB;  

                    let regionId = cleanCityCode(rawCode);
                    let regionData = immunizationData[regionId] || {}; 
                    // console.log(regionData);

                    let dpt1 = formatValue(regionData.dpt1);
                    let dpt2 = formatValue(regionData.dpt2);
                    let dpt3 = formatValue(regionData.dpt3);
                    let mr1  = formatValue(regionData.mr1);
                    let zeroDoseChildren = formatValue(regionData.zero_dose_children);
                    let percentZD = formatValue(regionData.percent_zero_dose, true);

                    let dpt1Coverage = formatValue(regionData.percentage_target_dpt1, true);
                    let dpt3Coverage = formatValue(regionData.percentage_target_dpt3, true);
                    let mr1Coverage  = formatValue(regionData.percentage_target_mr1, true);

                    let total_kejar = formatValue(regionData.total_dpt1_kejar);
                    let percentReductionZD  = formatValue(regionData.percent_reduction, true);

                    let name = isProvinceLevel 
                        ? feature.properties.WADMPR  
                        : feature.properties.NAMOBJ;  

                    // let popupContent = `<b>${name}</b><br>
                    //                     DPT1 Coverage: ${dpt1} (Coverage: ${dpt1Coverage})<br>
                    //                     DPT3 Coverage: ${dpt3} (Coverage: ${dpt3Coverage})<br>
                    //                     MR1 Coverage: ${mr1} (Coverage: ${mr1Coverage})<br>
                    //                     Zero Dose Children: ${zeroDoseChildren}<br>
                    //                     % Zero Dose: ${percentZD}<br>
                    //                     Zero Dose Children 2024: ${zd2023}<br>
                    //                     % Reduction From ZD 2024: ${percentReductionZD}`;

                    // Create a number formatter for the locale
                    const numberFormat = new Intl.NumberFormat();

                    let popupContent = `<b>${name}</b><br>
                                        DPT1 Coverage: ${numberFormat.format(dpt1)} (%Coverage: ${dpt1Coverage})<br>
                                        DPT3 Coverage: ${numberFormat.format(dpt3)} (%Coverage: ${dpt3Coverage})<br>
                                        MR1 Coverage: ${numberFormat.format(mr1)} (%Coverage: ${mr1Coverage})<br>
                                        Zero Dose Children Outreach: ${numberFormat.format(total_kejar)}<br>
                                        % Reduction From ZD 2024: ${percentReductionZD}`;
                                        
                    
                    // Jika ini level provinsi, tambahkan tombol
                    if (isProvinceLevel) {
                        let selectedYear = "<?= $selected_year ?>"; // Ambil dari PHP

                        popupContent += `<br><br>
                            <a href="<?= base_url('home/restored'); ?>?year=${selectedYear}&province=${regionId}&get_detail=1" target="">
                                <button class="btn btn-primary btn-sm">View Details</button>
                            </a>`;
                    }

                    layer.bindPopup(popupContent);

                    if (feature.geometry.type === "Polygon" || feature.geometry.type === "MultiPolygon") {
                        try {
                            let labelPoint = turf.pointOnFeature(feature);
                            let latlng = [labelPoint.geometry.coordinates[1], labelPoint.geometry.coordinates[0]];
                            
                            // let labelSize = adjustLabelSize(map.getZoom()); // Adjust size based on current zoom level

                            if (feature.properties.NAMOBJ) {
                                let label = L.divIcon({
                                    className: 'label-class',
                                    html: `<strong style="font-size: 9px;">${feature.properties.NAMOBJ}</strong>`,
                                    iconSize: [100, 20]
                                });
                                L.marker(latlng, { icon: label }).addTo(map);
                            } else if (feature.properties.WADMPR) { 
                                let label = L.divIcon({
                                    className: 'label-class',
                                    html: `<strong style="font-size: 8px;">${feature.properties.WADMPR}</strong>`,
                                    iconSize: [50, 15]
                                });
                                L.marker(latlng, { icon: label }).addTo(map);
                            }
                        } catch (error) {
                            console.warn("Turf.js error while generating label:", error, feature);
                        }
                    }
                }
            }).addTo(map);

            map.fitBounds(geojsonLayer.getBounds());
        })
        .catch(error => console.error("Error loading GeoJSON:", error));
    });
</script>

<!-- Auto Focus to Map Card -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Periksa jika parameter get_detail ada di URL dan bernilai 1
        const urlParams = new URLSearchParams(window.location.search);
        const getDetail = urlParams.get('get_detail');

        // Jika parameter get_detail == 1, scroll ke bagian peta
        if (getDetail == '1') {
            let mapSection = document.getElementById("map");
            if (mapSection) {
                mapSection.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        }

        // Lanjutkan kode untuk peta...
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

});
</script>