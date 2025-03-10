
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Manual Input</h3>
                                <p class="text-subtitle text-muted">Vaccine coverage in targeted areas​​​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Manual</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="page-content"> 
                    <!-- Basic Horizontal form layout section start -->
                    <section id="basic-horizontal-layouts">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= $this->session->flashdata('success'); ?>
                            </div>
                        <?php endif; ?>
                        <!-- Immunization Coverage -->
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Immunization Coverage</h4>
                                        <button class="btn btn-primary ms-auto floating-button bg-white border-white" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent" aria-expanded="false" aria-controls="cardContent">
                                                <i class="bi bi-arrows-collapse" style="color: gray;"></i> 
                                        </button>
                                    </div>
                                    <div id="cardContent" class="collapse show">
                                        <div class="card-body">
                                            <!-- <div class="form form-horizontal"> -->
                                                <?= form_open('input/save_immunization', ['class' => 'form form-horizontal']); ?>
                                                <div class="form-body">
                                                    <div class="row">
                                                            
                                                        <div class="col-md-4">
                                                            <?= form_label('Select Province', 'province_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('province_id', $province_options, '', 'class="form-select" id="province_id"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Select District', 'city_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('city_id', ['' => '-- Select City --'], '', 'class="form-select" id="city_id"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Select Subdistrict', 'subdistrict_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('subdistrict_id', ['' => '-- Select Subdistrict --'], '', 'class="form-select" id="subdistrict_id"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Select Puskesmas', 'puskesmas_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('puskesmas_id', ['' => '-- Select Puskesmas --'], '', 'class="form-select" id="puskesmas_id"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Select Year', 'year'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('year', $year_options, '', 'class="form-select" id="year"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Select Month', 'month'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('month', $month_options, '', 'class="form-select" id="month"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Total DPT 1', 'dpt_1'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_1', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_1']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Total DPT 2', 'dpt_2'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_2', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_2']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Total DPT 3', 'dpt_3'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_3', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_3']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Total MR 1', 'mr_1'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'mr_1', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'mr_1']); ?>
                                                        </div>

                                                        <div class="col-sm-12 d-flex justify-content-end">
                                                            <?= form_submit('submit', 'Submit', 'class="btn btn-primary me-1 mb-1"'); ?>
                                                            <?= form_reset('reset', 'Reset', 'class="btn btn-light-secondary me-1 mb-1"'); ?>
                                                        </div>

                                                    </div>
                                                </div>
                                                <?= form_close(); ?>
                                            <!-- </div> -->
                                                </br>
                                                <!-- Garis Pembatas -->
                                                <hr class="my-4">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="filter_province">Filter By Province</label>
                                                    <!-- <select id="filter_province" class="form-select">
                                                        <option value="">-- Select Province --</option>
                                                        <?php foreach ($provinces as $province): ?>
                                                            <option value="<?= $province['id'] ?>"><?= $province['name_id'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select> -->
                                                    <?= form_dropdown('filter_province', $province_options, '', 'class="form-select" id="filter_province"'); ?>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_city">Filter By District</label>
                                                    <select id="filter_city" class="form-select">
                                                        <option value="">-- Select City --</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_subdistrict">Filter By Subdistrict</label>
                                                    <select id="filter_subdistrict" class="form-select">
                                                        <option value="">-- Select Subdistrict --</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_puskesmas">Filter By Puskesmas</label>
                                                    <select id="filter_puskesmas" class="form-select">
                                                        <option value="">-- Select Puskesmas --</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_year">Filter By Year</label>
                                                    <select id="filter_year" class="form-select">
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_month">Filter By Month</label>
                                                    <select id="filter_month" class="form-select">
                                                        <!-- <option value="">-- Select Month --</option> -->
                                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                                            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                                        value="<?= $this->security->get_csrf_hash(); ?>">

                                                <div class="col-md-3 d-flex align-items-end">
                                                    <button id="btn_filter" class="btn btn-secondary" type="button">Apply Filter</button>
                                                </div>
                                            </div>

                                            <!-- Garis Pembatas -->
                                            <hr class="my-4">

                                            <div class="table-responsive">
                                                    <table class="table table-striped" id="table2">
                                                        <thead>
                                                            <tr>
                                                                <th>Province</th>
                                                                <th>District</th>
                                                                <th>Subdistrict</th>
                                                                <th>Puskesmas</th>
                                                                <th>Year</th>
                                                                <th>Month</th>
                                                                <th>DPT 1</th>
                                                                <th>DPT 2</th>
                                                                <th>DPT 3</th>
                                                                <th>MR 1</th>
                                                                <th>Action</th> <!-- Kolom untuk tombol hapus -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Stockout -->
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Stock Out at Health Facilities</h4>
                                        <button class="btn btn-primary ms-auto floating-button bg-white border-white" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent2" aria-expanded="false" aria-controls="cardContent2">
                                                <i class="bi bi-arrows-collapse" style="color: gray;"></i> 
                                        </button>
                                    </div>
                                    <div id="cardContent2" class="collapse show">
                                        <div class="card-body">
                                            <!-- <div class="form form-horizontal"> -->
                                                <?= form_open('input/save_stock_out', ['class' => 'form form-horizontal']); ?>
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4"><?= form_label('Select Province', 'province_id'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('province_id', $province_options, '', 'class="form-select" id="province_id2"'); ?></div>

                                                        <div class="col-md-4"><?= form_label('Select District', 'city_id'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('city_id', ['' => '-- Select City --'], '', 'class="form-select" id="city_id2"'); ?></div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Select Subdistrict', 'subdistrict_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('subdistrict_id', ['' => '-- Select Subdistrict --'], '', 'class="form-select" id="subdistrict_id2"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Select Puskesmas', 'puskesmas_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('puskesmas_id', ['' => '-- Select Puskesmas --'], '', 'class="form-select" id="puskesmas_id2"'); ?>
                                                        </div>

                                                        <div class="col-md-4"><?= form_label('Select Year', 'year'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('year', $year_options, '', 'class="form-select" id="year"'); ?></div>

                                                        <div class="col-md-4"><?= form_label('Select Month', 'month'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('month', $month_options, '', 'class="form-select" id="month"'); ?></div>

                                                        <!-- <div class="col-md-4"><?= form_label('Vaccine Type', 'vaccine_type'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('vaccine_type', ['DPT' => 'DPT'], '', 'class="form-select" id="vaccine_type"'); ?></div>

                                                        <div class="col-md-4"><?= form_label('Stock Out 1 Month', 'stock_out_1_month'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'stock_out_1_month', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                        <div class="col-md-4"><?= form_label('Stock Out 2 Months', 'stock_out_2_months'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'stock_out_2_months', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                        <div class="col-md-4"><?= form_label('Stock Out 3 Months', 'stock_out_3_months'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'stock_out_3_months', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                        <div class="col-md-4"><?= form_label('Stock Out 3+ Months', 'stock_out_more_than_3_months'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'stock_out_more_than_3_months', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div> -->

                                                        <div class="col-md-4"><?= form_label('DPT-HB-Hib @5 ds', 'DPT_HB_Hib_5_ds'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'DPT_HB_Hib_5_ds', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'step' => 'any']); ?></div>

                                                        <div class="col-md-4"><?= form_label('Pentavalent (Easyfive) @10 ds', 'Pentavalent_Easyfive_10_ds'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'Pentavalent_Easyfive_10_ds', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'step' => 'any']); ?></div>

                                                        <div class="col-md-4"><?= form_label('Pentavac 10 ds', 'Pentavac_10_ds'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'Pentavac_10_ds', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'step' => 'any']); ?></div>

                                                        <div class="col-md-4"><?= form_label('Vaksin ComBE Five @10 ds', 'Vaksin_ComBE_Five_10_ds'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'Vaksin_ComBE_Five_10_ds', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'step' => 'any']); ?>

                                                        <div class="col-md-12 d-flex justify-content-end">
                                                            <?= form_submit('submit', 'Submit', 'class="btn btn-primary me-1 mb-1"'); ?>
                                                            <?= form_reset('reset', 'Reset', 'class="btn btn-light-secondary me-1 mb-1"'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?= form_close(); ?>
                                            <!-- </div> -->
                                                </br>
                                                <!-- Garis Pembatas -->
                                                <hr class="my-4">


                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label for="filter_province">Filter By Province</label>
                                                        <!-- <select id="filter_province" class="form-select">
                                                            <option value="">-- Select Province --</option>
                                                            <?php foreach ($provinces as $province): ?>
                                                                <option value="<?= $province['id'] ?>"><?= $province['name_id'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select> -->
                                                        <?= form_dropdown('filter_province', $province_options, '', 'class="form-select" id="filter_province2"'); ?>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="filter_city2">Filter By District</label>
                                                        <select id="filter_city2" class="form-select">
                                                            <option value="">-- Select City --</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="filter_subdistrict2">Filter By Subdistrict</label>
                                                        <select id="filter_subdistrict2" class="form-select">
                                                            <option value="">-- Select Subdistrict --</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="filter_puskesmas2">Filter By Puskesmas</label>
                                                        <select id="filter_puskesmas2" class="form-select">
                                                            <option value="">-- Select Puskesmas --</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="filter_year2">Filter By Year</label>
                                                        <select id="filter_year2" class="form-select">
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="filter_month2">Filter By Month</label>
                                                        <select id="filter_month2" class="form-select">
                                                            <!-- <option value="">-- Select Month --</option> -->
                                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                                            value="<?= $this->security->get_csrf_hash(); ?>">

                                                    <div class="col-md-3 d-flex align-items-end">
                                                        <button id="btn_filter2" class="btn btn-secondary" type="button">Apply Filter</button>
                                                    </div>
                                                </div>

                                                <!-- Garis Pembatas -->
                                                <hr class="my-4">

                                                <div class="table-responsive">
                                                        <table class="table table-striped" id="table3">
                                                            <thead>
                                                                <tr>
                                                                    <th>Province</th>
                                                                    <th>District</th>
                                                                    <th>Subdistrict</th>
                                                                    <th>Puskesmas</th>
                                                                    <th>Year</th>
                                                                    <th>Month</th>
                                                                    <th>DPT-HB-Hib @5 ds</th>
                                                                    <th>Pentavalent (Easyfive) @10 ds</th>
                                                                    <th>Pentavac 10 ds</th>
                                                                    <th>Vaksin ComBE Five @10 ds</th>
                                                                    <th>Action</th> <!-- Kolom untuk tombol hapus -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Supportive Supervision -->
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Supportive Supervision</h4>
                                        <button class="btn btn-primary ms-auto floating-button bg-white border-white" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent4" aria-expanded="false" aria-controls="cardContent4">
                                            <i class="bi bi-arrows-collapse" style="color: gray;"></i> 
                                        </button>
                                    </div>
                                    <div id="cardContent4" class="collapse show">
                                        <div class="card-body">
                                            <!-- Form Input Supportive Supervision -->
                                            <?= form_open('input/save_supportive_supervision', ['class' => 'form form-horizontal']); ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4"><?= form_label('Select Province', 'province_id'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('province_id', $province_options, '', 'class="form-select" id="province_id4"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select District', 'city_id'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('city_id', ['' => '-- Select City --'], '', 'class="form-select" id="city_id4"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select Year', 'year'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('year', $year_options, '', 'class="form-select" id="year4"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select Month', 'month'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('month', $month_options, '', 'class="form-select" id="month4"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Good Category Puskesmas', 'good_category_puskesmas'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_input(['name' => 'good_category_puskesmas', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <?= form_submit('submit', 'Submit', 'class="btn btn-primary me-1 mb-1"'); ?>
                                                        <?= form_reset('reset', 'Reset', 'class="btn btn-light-secondary me-1 mb-1"'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= form_close(); ?>
                                            </br>
                                            <hr class="my-4">

                                            <!-- Filter Form -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="filter_province4">Filter By Province</label>
                                                    <?= form_dropdown('filter_province4', $province_options, '', 'class="form-select" id="filter_province4"'); ?>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_city4">Filter By District</label>
                                                    <select id="filter_city4" class="form-select">
                                                        <option value="">-- Select City --</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="filter_year4">Filter By Year</label>
                                                    <select id="filter_year4" class="form-select">
                                                        <option value="">-- Select Year --</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2">
                                                    <label for="filter_month4">Filter By Month</label>
                                                    <select id="filter_month4" class="form-select">
                                                        <option value="">-- Select Month --</option>
                                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                                            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="csrf_test_name" 
                                                        value="<?= $this->security->get_csrf_hash(); ?>">

                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button id="btn_filter4" class="btn btn-secondary">Apply Filter</button>
                                                </div>
                                            </div>
                                            <hr class="my-4">

                                            <!-- Table Displaying Data -->
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table4">
                                                    <thead>
                                                        <tr>
                                                            <th>Province</th>
                                                            <th>District</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Good Category Puskesmas</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Private Facility Training Form -->
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Private Facility Training</h4>
                                        <button class="btn btn-primary ms-auto floating-button bg-white border-white" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent5" aria-expanded="false" aria-controls="cardContent5">
                                                <i class="bi bi-arrows-collapse" style="color: gray;"></i> 
                                        </button>
                                    </div>
                                    <div id="cardContent5" class="collapse show">
                                        <div class="card-body">
                                            <?= form_open('input/save_private_facility_training', ['class' => 'form form-horizontal']); ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4"><?= form_label('Select Province', 'province_id'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('province_id', $province_options, '', 'class="form-select" id="province_id5"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select Year', 'year'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('year', $year_options, '', 'class="form-select" id="year5"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select Month', 'month'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('month', $month_options, '', 'class="form-select" id="month5"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Total Private Facilities', 'total_private_facilities'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_input(['name' => 'total_private_facilities', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                    <div class="col-md-4"><?= form_label('Trained Private Facilities', 'trained_private_facilities'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_input(['name' => 'trained_private_facilities', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <?= form_submit('submit', 'Submit', 'class="btn btn-primary me-1 mb-1"'); ?>
                                                        <?= form_reset('reset', 'Reset', 'class="btn btn-light-secondary me-1 mb-1"'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= form_close(); ?>

                                            <!-- Garis Pembatas -->
                                            <hr class="my-4">

                                            <!-- Filter Data -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="filter_province5">Filter By Province</label>
                                                    <?= form_dropdown('filter_province5', $province_options, '', 'class="form-select" id="filter_province5"'); ?>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_year5">Filter By Year</label>
                                                    <select id="filter_year5" class="form-select">
                                                        <option value="">-- Select Year --</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_month5">Filter By Month</label>
                                                    <select id="filter_month5" class="form-select">
                                                        <option value="">-- Select Month --</option>
                                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                                            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 d-flex align-items-end">
                                                    <button id="btn_filter5" class="btn btn-secondary">Apply Filter</button>
                                                </div>
                                            </div>

                                            <!-- Garis Pembatas -->
                                            <hr class="my-4">

                                            <!-- Tabel Data -->
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table5">
                                                    <thead>
                                                        <tr>
                                                            <th>Province</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Total Private Facilities</th>
                                                            <th>Trained Private Facilities</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- District Funding Form -->
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">District Funding</h4>
                                        <button class="btn btn-primary ms-auto floating-button bg-white border-white" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent6" aria-expanded="false" aria-controls="cardContent6">
                                            <i class="bi bi-arrows-collapse" style="color: gray;"></i> 
                                        </button>
                                    </div>
                                    <div id="cardContent6" class="collapse show">
                                        <div class="card-body">
                                            <?= form_open('input/save_district_funding', ['class' => 'form form-horizontal']); ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4"><?= form_label('Select Province', 'province_id'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('province_id', $province_options, '', 'class="form-select" id="province_id6"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select Year', 'year'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('year', $year_options, '', 'class="form-select" id="year6"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select Month', 'month'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('month', $month_options, '', 'class="form-select" id="month6"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Number of Funded Districts', 'funded_districts'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_input(['name' => 'funded_districts', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <?= form_submit('submit', 'Submit', 'class="btn btn-primary me-1 mb-1"'); ?>
                                                        <?= form_reset('reset', 'Reset', 'class="btn btn-light-secondary me-1 mb-1"'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= form_close(); ?>

                                            <!-- Garis Pembatas -->
                                            <hr class="my-4">

                                            <!-- Filter Data -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="filter_province6">Filter By Province</label>
                                                    <?= form_dropdown('filter_province6', $province_options, '', 'class="form-select" id="filter_province6"'); ?>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_year6">Filter By Year</label>
                                                    <select id="filter_year6" class="form-select">
                                                        <option value="">-- Select Year --</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_month6">Filter By Month</label>
                                                    <select id="filter_month6" class="form-select">
                                                        <option value="">-- Select Month --</option>
                                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                                            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 d-flex align-items-end">
                                                    <button id="btn_filter6" class="btn btn-secondary">Apply Filter</button>
                                                </div>
                                            </div>

                                            <!-- Garis Pembatas -->
                                            <hr class="my-4">

                                            <!-- Tabel Data -->
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table6">
                                                    <thead>
                                                        <tr>
                                                            <th>Province</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Funded Districts</th>
                                                            <th>Action</th> <!-- Kolom untuk tombol hapus -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Data akan dimuat melalui AJAX -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- District Policy Form -->
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">District Policy</h4>
                                        <button class="btn btn-primary ms-auto floating-button bg-white border-white" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent7" aria-expanded="false" aria-controls="cardContent7">
                                            <i class="bi bi-arrows-collapse" style="color: gray;"></i> 
                                        </button>
                                    </div>
                                    <div id="cardContent7" class="collapse show">
                                        <div class="card-body">
                                            <?= form_open('input/save_district_policy', ['class' => 'form form-horizontal']); ?>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4"><?= form_label('Select Province', 'province_id'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('province_id', $province_options, '', 'class="form-select" id="province_id7"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select Year', 'year'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('year', $year_options, '', 'class="form-select" id="year7"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Select Month', 'month'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_dropdown('month', $month_options, '', 'class="form-select" id="month7"'); ?></div>

                                                    <div class="col-md-4"><?= form_label('Number of Districts with Policies', 'policy_districts'); ?></div>
                                                    <div class="col-md-8 form-group"><?= form_input(['name' => 'policy_districts', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <?= form_submit('submit', 'Submit', 'class="btn btn-primary me-1 mb-1"'); ?>
                                                        <?= form_reset('reset', 'Reset', 'class="btn btn-light-secondary me-1 mb-1"'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?= form_close(); ?>

                                            <!-- Garis Pembatas -->
                                            <hr class="my-4">

                                            <!-- Filter Data -->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="filter_province7">Filter By Province</label>
                                                    <?= form_dropdown('filter_province7', $province_options, '', 'class="form-select" id="filter_province7"'); ?>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_year7">Filter By Year</label>
                                                    <select id="filter_year7" class="form-select">
                                                        <option value="">-- Select Year --</option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filter_month7">Filter By Month</label>
                                                    <select id="filter_month7" class="form-select">
                                                        <option value="">-- Select Month --</option>
                                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                                            <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 d-flex align-items-end">
                                                    <button id="btn_filter7" class="btn btn-secondary">Apply Filter</button>
                                                </div>
                                            </div>

                                            <!-- Garis Pembatas -->
                                            <hr class="my-4">

                                            <!-- Tabel Data -->
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="table7">
                                                    <thead>
                                                        <tr>
                                                            <th>Province</th>
                                                            <th>Year</th>
                                                            <th>Month</th>
                                                            <th>Policy Districts</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </section>
                    <!-- Basic Horizontal form layout section end -->
                </div>
            </div>

        </div>
    </div>
    
    

    <script>
        $(document).ready(function () {
            // Ketika province dipilih, load district
            $('#province_id').change(function () {
                var province_id = $(this).val();
                if (province_id) {
                    $.ajax({
                        url: "<?= base_url('input/get_cities_by_province') ?>",
                        type: "GET",
                        data: { province_id: province_id },
                        dataType: "json",
                        success: function (data) {
                            $('#city_id').html('<option value="">-- Select District --</option>');
                            $('#subdistrict_id').html('<option value="">-- Select Subdistrict --</option>');
                            $('#puskesmas_id').html('<option value="">-- Select Puskesmas --</option>');
                            $.each(data, function (key, value) {
                                $('#city_id').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                            });
                        }
                    });
                }
            });

            // Ketika district dipilih, load subdistrict
            $('#city_id').change(function () {
                var city_id = $(this).val();
                if (city_id) {
                    $.ajax({
                        url: "<?= base_url('input/get_subdistricts_by_city') ?>",
                        type: "GET",
                        data: { city_id: city_id },
                        dataType: "json",
                        success: function (data) {
                            $('#subdistrict_id').html('<option value="">-- Select Subdistrict --</option>');
                            $('#puskesmas_id').html('<option value="">-- Select Puskesmas --</option>');
                            $.each(data, function (key, value) {
                                $('#subdistrict_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Ketika subdistrict dipilih, load puskesmas
            $('#subdistrict_id').change(function () {
                var subdistrict_id = $(this).val();
                if (subdistrict_id) {
                    $.ajax({
                        url: "<?= base_url('input/get_puskesmas_by_subdistrict') ?>",
                        type: "GET",
                        data: { subdistrict_id: subdistrict_id },
                        dataType: "json",
                        success: function (data) {
                            $('#puskesmas_id').html('<option value="">-- Select Puskesmas --</option>');
                            $.each(data, function (key, value) {
                                $('#puskesmas_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Ketika province dipilih, load district
            $('#province_id2').change(function () {
                var province_id = $(this).val();
                if (province_id) {
                    $.ajax({
                        url: "<?= base_url('input/get_cities_by_province') ?>",
                        type: "GET",
                        data: { province_id: province_id },
                        dataType: "json",
                        success: function (data) {
                            $('#city_id2').html('<option value="">-- Select District --</option>');
                            $.each(data, function (key, value) {
                                $('#city_id2').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                            });
                        }
                    });
                }
            });

            // Ketika district dipilih, load subdistrict
            $('#city_id2').change(function () {
                var city_id = $(this).val();
                if (city_id) {
                    $.ajax({
                        url: "<?= base_url('input/get_subdistricts_by_city') ?>",
                        type: "GET",
                        data: { city_id: city_id },
                        dataType: "json",
                        success: function (data) {
                            $('#subdistrict_id2').html('<option value="">-- Select Subdistrict --</option>');
                            $('#puskesmas_id2').html('<option value="">-- Select Puskesmas --</option>');
                            $.each(data, function (key, value) {
                                $('#subdistrict_id2').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Ketika subdistrict dipilih, load puskesmas
            $('#subdistrict_id2').change(function () {
                var subdistrict_id = $(this).val();
                if (subdistrict_id) {
                    $.ajax({
                        url: "<?= base_url('input/get_puskesmas_by_subdistrict') ?>",
                        type: "GET",
                        data: { subdistrict_id: subdistrict_id },
                        dataType: "json",
                        success: function (data) {
                            $('#puskesmas_id2').html('<option value="">-- Select Puskesmas --</option>');
                            $.each(data, function (key, value) {
                                $('#puskesmas_id2').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>

<!-- Imminuzation Coverage -->
<script>
    // $(document).ready(function () {
    // Ketika province dipilih, load city
    $('#filter_province').change(function () {
        var province_id = $(this).val();
        if (province_id) {
            $.ajax({
                url: "<?= base_url('input/get_cities_by_province') ?>",
                type: "GET",
                data: { province_id: province_id },
                dataType: "json",
                success: function (data) {
                    $('#filter_city').html('<option value="">-- Select District --</option>');
                    $('#filter_subdistrict').html('<option value="">-- Select Subdistrict --</option>');
                    $('#filter_puskesmas').html('<option value="">-- Select Puskesmas --</option>');
                    $.each(data, function (key, value) {
                        $('#filter_city').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                    });
                }
            });
        }
    });

    // Ketika district dipilih, load subdistrict
    $('#filter_city').change(function () {
        var city_id = $(this).val();
        if (city_id) {
            $.ajax({
                url: "<?= base_url('input/get_subdistricts_by_city') ?>",
                type: "GET",
                data: { city_id: city_id },
                dataType: "json",
                success: function (data) {
                    $('#filter_subdistrict').html('<option value="">-- Select Subdistrict --</option>');
                    $('#filter_puskesmas').html('<option value="">-- Select Puskesmas --</option>');
                    $.each(data, function (key, value) {
                        $('#filter_subdistrict').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    // Ketika subdistrict dipilih, load puskesmas
    $('#filter_subdistrict').change(function () {
        var subdistrict_id = $(this).val();
        if (subdistrict_id) {
            $.ajax({
                url: "<?= base_url('input/get_puskesmas_by_subdistrict') ?>",
                type: "GET",
                data: { subdistrict_id: subdistrict_id },
                dataType: "json",
                success: function (data) {
                    $('#filter_puskesmas').html('<option value="">-- Select Puskesmas --</option>');
                    $.each(data, function (key, value) {
                        $('#filter_puskesmas').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    // Inisialisasi DataTable hanya sekali
    let table2 = $('#table2').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true
    });

    // Function to load data based on filters
    function loadImmunizationData() {
        let province = $("#filter_province").val();
        let city = $("#filter_city").val();
        let subdistrict = $("#filter_subdistrict").val();
        let puskesmas = $("#filter_puskesmas").val();
        let year = $("#filter_year").val();
        let month = $("#filter_month").val();

        $.ajax({
            url: "<?= base_url('input/get_immunization_data') ?>",  // Replace with correct URL to fetch data
            type: "GET",
            data: {
                province_id: province,
                city_id: city,
                subdistrict_id: subdistrict,
                puskesmas_id: puskesmas,
                year: year,
                month: month
            },
            success: function(response) {
                let data = JSON.parse(response);
                let tableBody = $("#table2 tbody");
                tableBody.empty();

                if (data.length === 0) {
                    tableBody.append('<tr><td colspan="11" class="text-center">No Data Found</td></tr>');
                } else {
                    // data.forEach(row => {
                    //     tableBody.append(`
                    //         <tr>
                    //             <td>${row.province_name}</td>
                    //             <td>${row.city_name}</td>
                    //             <td>${row.subdistrict_name}</td>
                    //             <td>${row.puskesmas_name}</td>
                    //             <td>${row.year}</td>
                    //             <td>${new Date(row.month).toLocaleString('en-us', { month: 'long' })}</td>
                    //             <td>${row.dpt_hb_hib_1}</td>
                    //             <td>${row.dpt_hb_hib_2}</td>
                    //             <td>${row.dpt_hb_hib_3}</td>
                    //             <td>${row.mr_1}</td>
                    //             <td>
                    //                 <button class="btn btn-danger btn-sm" data-id="${row.id}" onclick="deleteData(this)">Delete</button>
                    //             </td>
                    //         </tr>
                    //     `);
                    // });
                    let rows = [];
                    data.forEach(row => {
                        rows.push([
                            row.province_name,
                            row.city_name,
                            row.subdistrict_name,
                            row.puskesmas_name,
                            row.year,
                            new Date(row.month).toLocaleString('en-us', { month: 'long' }),
                            row.dpt_hb_hib_1,
                            row.dpt_hb_hib_2,
                            row.dpt_hb_hib_3,
                            row.mr_1,
                            `<button class="btn btn-danger btn-sm" data-id="${row.id}" onclick="deleteData(this)">Delete</button>`
                        ]);
                    });

                    // Refresh tabel dengan data baru
                    table2.clear().rows.add(rows).draw();

                    // Pastikan fitur pencarian dan pengurutan masih berfungsi
                    table2.search('').draw();  // Kosongkan pencarian dan gambar ulang DataTable
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ', status, error);  // Log the error for debugging
            }
        });
    }
    // Trigger for Apply Filter
    $("#btn_filter").on("click", function() {
        let province = $("#filter_province").val();
        let city = $("#filter_city").val();

        // Check if Province and City are selected
        if (!province) {
            alert("Please select a Province.");
            return;  // Stop further code execution
        }

        if (!city) {
            alert("Please select a District.");
            return;  // Stop further code execution
        }

        // If both Province and City are selected, proceed to load the filtered data
        loadImmunizationData();  // Load filtered data
    });


    // Event delegation untuk tombol delete
    $(document).on("click", ".delete-btn", function () {
        deleteData(this);
    });

    

        // Optionally, you can also trigger loading data when the page loads
        loadImmunizationData();  // Load initial data when the page is loaded

    // });

        function deleteData(button) {
            let id = $(button).data('id');
            let csrfToken = $("input[name='csrf_test_name']").val(); // Ambil token CSRF dari input hidden
            // const csrfHash = '<?= $this->security->get_csrf_hash(); ?>';

            if (confirm("Are you sure you want to delete this data?")) {
                $.ajax({
                    url: "<?= base_url('input/delete_immunization_data/') ?>" + id, // Ganti dengan URL yang sesuai
                    type: "POST",
                    data: {csrf_test_name: csrfToken }, // Kirim CSRF Token
                    success: function(response) {
                        alert("Data deleted successfully.");
                        loadImmunizationData(); // Refresh table
                    },
                    error: function(xhr, status, error) {
                        alert("Failed to delete data.");
                        console.log(status, error); // Debugging
                    }
                });
            }
        }
</script>

<!-- DPT Stockout-->
<script>
$(document).ready(function () {
    // Ketika province dipilih, load city
    $('#filter_province2').change(function () {
        var province_id = $(this).val();
        if (province_id) {
            $.ajax({
                url: "<?= base_url('input/get_cities_by_province') ?>",
                type: "GET",
                data: { province_id: province_id },
                dataType: "json",
                success: function (data) {
                    $('#filter_city2').html('<option value="">-- Select City --</option>');
                    $.each(data, function (key, value) {
                        $('#filter_city2').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                    });
                }
            });
        }
    });

    // Ketika district dipilih, load subdistrict
    $('#filter_city2').change(function () {
        var city_id = $(this).val();
        if (city_id) {
            $.ajax({
                url: "<?= base_url('input/get_subdistricts_by_city') ?>",
                type: "GET",
                data: { city_id: city_id },
                dataType: "json",
                success: function (data) {
                    $('#filter_subdistrict2').html('<option value="">-- Select Subdistrict --</option>');
                    $('#filter_puskesmas2').html('<option value="">-- Select Puskesmas --</option>');
                    $.each(data, function (key, value) {
                        $('#filter_subdistrict2').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    // Ketika subdistrict dipilih, load puskesmas
    $('#filter_subdistrict2').change(function () {
        var subdistrict_id = $(this).val();
        if (subdistrict_id) {
            $.ajax({
                url: "<?= base_url('input/get_puskesmas_by_subdistrict') ?>",
                type: "GET",
                data: { subdistrict_id: subdistrict_id },
                dataType: "json",
                success: function (data) {
                    $('#filter_puskesmas2').html('<option value="">-- Select Puskesmas --</option>');
                    $.each(data, function (key, value) {
                        $('#filter_puskesmas2').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        }
    });

    // Inisialisasi DataTable hanya sekali
    let table3 = $('#table3').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true
    });

    // Function to load data based on filters
    function loadStockOutData() {
        let province = $("#filter_province2").val();
        let city = $("#filter_city2").val();
        let subdistrict = $("#filter_subdistrict2").val();
        let puskesmas = $("#filter_puskesmas2").val();
        let year = $("#filter_year2").val();
        let month = $("#filter_month2").val();
        // alert(city);

        $.ajax({
            url: "<?= base_url('input/get_stock_out_data') ?>",  // Ganti dengan URL yang sesuai untuk mendapatkan data stock out
            type: "GET",
            data: {
                province_id: province,
                city_id: city,
                subdistrict_id: subdistrict,
                puskesmas_id: puskesmas,
                year: year,
                month: month
            },
            success: function (response) {
                let data = JSON.parse(response);
                console.log(data.length);
                let tableBody = $("#table3 tbody");
                tableBody.empty();

                if (data.length === 0) {
                    tableBody.append('<tr><td colspan="10" class="text-center">No Data Found</td></tr>');
                } else {
                    // data.forEach(row => {
                    //     tableBody.append(`
                    //         <tr>
                    //             <td>${row.province_name}</td>
                    //             <td>${row.city_name}</td>
                    //             <td>${row.year}</td>
                    //             <td>${new Date(row.month).toLocaleString('en-us', { month: 'long' })}</td>
                    //             <td>${row.vaccine_type}</td>
                    //             <td>${row.stock_out_1_month}</td>
                    //             <td>${row.stock_out_2_months}</td>
                    //             <td>${row.stock_out_3_months}</td>
                    //             <td>${row.stock_out_more_than_3_months}</td>
                    //             <td>
                    //                 <!-- Tombol untuk menghapus Stock Out -->
                    //                 <button class="btn btn-danger btn-sm delete-btn-stock-out" data-id="${row.id}" onclick="deleteStockOutData(this)">Delete</button>

                    //             </td>
                    //         </tr>
                    //     `);
                    // });
                    // let rows = [];
                    // data.forEach(row => {
                    //     rows.push([
                    //         row.province_name,
                    //         row.city_name,
                    //         row.year,
                    //         new Date(row.month).toLocaleString('en-us', { month: 'long' }),
                    //         row.vaccine_type,
                    //         row.stock_out_1_month,
                    //         row.stock_out_2_months,
                    //         row.stock_out_3_months,
                    //         row.stock_out_more_than_3_months,
                    //         `<button class="btn btn-danger btn-sm delete-btn-stock-out" data-id="${row.id}" >Delete</button>`
                    //     ]);
                    // });

                    let rows = [];
                    data.forEach(row => {
                        rows.push([
                            row.province_name,
                            row.city_name,
                            row.subdistrict_name,
                            row.puskesmas_name,
                            row.year,
                            new Date(row.month).toLocaleString('en-us', { month: 'long' }),
                            row.DPT_HB_Hib_5_ds,
                            row.Pentavalent_Easyfive_10_ds,
                            row.Pentavac_10_ds,
                            row.Vaksin_ComBE_Five_10_ds,
                            `<button class="btn btn-danger btn-sm delete-btn-stock-out" data-id="${row.id}" >Delete</button>`
                        ]);
                    });

                    // console.log(rows);
                    // Refresh tabel dengan data baru
                    table3.clear().rows.add(rows).draw();

                    // Pastikan fitur pencarian dan pengurutan masih berfungsi
                    table3.search('').draw();  // Kosongkan pencarian dan gambar ulang DataTable
                }
            },
            error: function (xhr, status, error) {
                console.log('Error: ', status, error);  // Log the error for debugging
            }
        });
    }

    // Trigger for Apply Filter
    $("#btn_filter2").on("click", function () {
        // alert('halo');
        let province = $("#filter_province2").val();
        let city = $("#filter_city2").val();
        // let city = $("#filter_city2").val();
        // console.log(city);

        // Check if Province and City are selected
        if (!province) {
            alert("Please select a Province.");
            return;  // Stop further code execution
        }

        if (!city) {
            alert("Please select a District.");
            return;  // Stop further code execution
        }

        // If both Province and City are selected, proceed to load the filtered data
        loadStockOutData();  // Load filtered data
    });

    $(document).on("click", ".delete-btn-stock-out", function () {
        deleteStockOutData(this); // Panggil fungsi delete khusus stock out
    });

    // Optionally, you can also trigger loading data when the page loads
    loadStockOutData();  // Load initial data when the page is loaded

    // Function to delete stock out data
    function deleteStockOutData(button) {
        let id = $(button).data('id');
        let csrfToken = $("input[name='csrf_test_name']").val(); // Ambil token CSRF dari input hidden

        if (confirm("Are you sure you want to delete this stock out data?")) {
            $.ajax({
                url: "<?= base_url('input/delete_stock_out_data/') ?>" + id, // Ganti dengan URL yang sesuai
                type: "POST",
                data: { csrf_test_name: csrfToken }, // Kirim CSRF Token
                success: function (response) {
                    alert("Stock Out data deleted successfully.");
                    loadStockOutData(); // Refresh table
                },
                error: function (xhr, status, error) {
                    alert("Failed to delete stock out data.");
                    console.log(status, error); // Debugging
                }
            });
        }
    }


    

});

</script>

<!-- SS Script -->
<script>
$(document).ready(function () {
    // Ketika province dipilih, load district
    $('#province_id4').change(function () {
        var province_id = $(this).val();
        if (province_id) {
            $.ajax({
                url: "<?= base_url('input/get_cities_by_province') ?>", // Ganti dengan URL yang sesuai untuk mendapatkan data kota
                type: "GET",
                data: { province_id: province_id },
                dataType: "json",
                success: function (data) {
                    $('#city_id4').html('<option value="">-- Select District --</option>');
                    $.each(data, function (key, value) {
                        $('#city_id4').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                    });
                }
            });
        }
    });

    // Load City based on Province
    $('#filter_province4').change(function () {
        var province_id = $(this).val();
        if (province_id) {
            $.ajax({
                url: "<?= base_url('input/get_cities_by_province') ?>",
                type: "GET",
                data: { province_id: province_id },
                dataType: "json",
                success: function (data) {
                    $('#filter_city4').html('<option value="">-- Select City --</option>');
                    $.each(data, function (key, value) {
                        $('#filter_city4').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                    });
                }
            });
        }
    });

    // Initialize DataTable
    let table4 = $('#table4').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true
    });

    // Load data with filter
    function loadSupportiveSupervisionData() {
        let province = $("#filter_province4").val();
        let city = $("#filter_city4").val();
        let year = $("#filter_year4").val();
        let month = $("#filter_month4").val();

        $.ajax({
            url: "<?= base_url('input/get_supportive_supervision_data') ?>",
            type: "GET",
            data: {
                province_id: province,
                city_id: city,
                year: year,
                month: month
            },
            success: function (response) {
                let data = JSON.parse(response);
                let tableBody = $("#table4 tbody");
                tableBody.empty();

                if (data.length === 0) {
                    tableBody.append('<tr><td colspan="6" class="text-center">No Data Found</td></tr>');
                } else {
                    let rows = [];
                    data.forEach(row => {
                        rows.push([
                            row.province_name,
                            row.city_name,
                            row.year,
                            new Date(row.month).toLocaleString('en-us', { month: 'long' }),
                            row.good_category_puskesmas,
                            `<button class="btn btn-danger btn-sm delete-btn-ss" data-id="${row.id}" >Delete</button>`
                        ]);
                    });
                    table4.clear().rows.add(rows).draw();
                    table4.search('').draw();
                }
            }
        });
    }

    // Apply filter action
    $("#btn_filter4").on("click", function () {
        loadSupportiveSupervisionData();
    });

    // Delete Supportive Supervision data
    $(document).on("click", ".delete-btn-ss", function () {
        deleteSupportiveSupervisionData(this);
    });

    // Function to delete data
    function deleteSupportiveSupervisionData(button) {
        let id = $(button).data('id');
        let csrfToken = $("input[name='csrf_test_name']").val();

        if (confirm("Are you sure you want to delete this data?")) {
            $.ajax({
                url: "<?= base_url('input/delete_supportive_supervision_data/') ?>" + id,
                type: "POST",
                data: { csrf_test_name: csrfToken },
                success: function (response) {
                    alert("Data deleted successfully.");
                    loadSupportiveSupervisionData();
                },
                error: function () {
                    alert("Failed to delete data.");
                }
            });
        }
    }

    // Initial data load on page load
    loadSupportiveSupervisionData();
});
</script>

<!-- Script untuk Handle AJAX Private -->
<script>
$(document).ready(function () {
    // Inisialisasi DataTable
    let table5 = $('#table5').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true
    });

    // Function untuk load data berdasarkan filter
    function loadPrivateFacilityTrainingData() {
        let province = $("#filter_province5").val();
        let year = $("#filter_year5").val();
        let month = $("#filter_month5").val();

        $.ajax({
            url: "<?= base_url('input/get_private_facility_training_data') ?>",
            type: "GET",
            data: { province_id: province, year: year, month: month },
            success: function (response) {
                let data = JSON.parse(response);
                let tableBody = $("#table5 tbody");
                tableBody.empty();

                if (data.length === 0) {
                    tableBody.append('<tr><td colspan="6" class="text-center">No Data Found</td></tr>');
                } else {
                    let rows = [];
                    data.forEach(row => {
                        rows.push([
                            row.province_name,
                            row.year,
                            new Date(row.month).toLocaleString('en-us', { month: 'long' }),
                            row.total_private_facilities,
                            row.trained_private_facilities,
                            `<button class="btn btn-danger btn-sm delete-btn-private5" data-id="${row.id}" >Delete</button>`
                        ]);
                    });

                    // Refresh DataTable
                    table5.clear().rows.add(rows).draw();
                }
            },
            error: function (xhr, status, error) {
                console.log('Error:', status, error);
            }
        });
    }

    // Trigger filter
    $("#btn_filter5").on("click", function () {
        let province = $("#filter_province5").val();
        // if (!province) {
        //     alert("Please select a Province.");
        //     return;
        // }
        loadPrivateFacilityTrainingData();
    });

    // Delete Supportive Supervision data
    $(document).on("click", ".delete-btn-private5", function () {
        deletePrivateFacilityTrainingData(this);
    });

    // Function untuk hapus data
    function deletePrivateFacilityTrainingData(button) {
        let id = $(button).data('id');
        let csrfToken = $("input[name='csrf_test_name']").val();

        if (confirm("Are you sure you want to delete this data?")) {
            $.ajax({
                url: "<?= base_url('input/delete_private_facility_training_data/') ?>" + id,
                type: "POST",
                data: { csrf_test_name: csrfToken },
                success: function (response) {
                    alert("Data deleted successfully.");
                    loadPrivateFacilityTrainingData();
                },
                error: function (xhr, status, error) {
                    alert("Failed to delete data.");
                    console.log(status, error);
                }
            });
        }
    }

    // Load awal data
    loadPrivateFacilityTrainingData();
});
</script>

<!-- Funding -->
<script>
    $(document).ready(function () {
        // Ketika province dipilih, load district
        $('#filter_province6').change(function () {
            var province_id = $(this).val();
            if (province_id) {
                $.ajax({
                    url: "<?= base_url('input/get_cities_by_province') ?>",
                    type: "GET",
                    data: { province_id: province_id },
                    dataType: "json",
                    success: function (data) {
                        $('#filter_city6').html('<option value="">-- Select District --</option>');
                        $.each(data, function (key, value) {
                            $('#filter_city6').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                        });
                    }
                });
            }
        });

        // Initialize DataTable
        let table6 = $('#table6').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true
        });

        // Function to load data based on filters
        function loadDistrictFundingData() {
            let province = $("#filter_province6").val();
            let year = $("#filter_year6").val();
            let month = $("#filter_month6").val();

            $.ajax({
                url: "<?= base_url('input/get_district_funding_data') ?>",
                type: "GET",
                data: {
                    province_id: province,
                    year: year,
                    month: month
                },
                success: function (response) {
                    let data = JSON.parse(response);
                    let tableBody = $("#table6 tbody");
                    tableBody.empty();

                    if (data.length === 0) {
                        tableBody.append('<tr><td colspan="5" class="text-center">No Data Found</td></tr>');
                    } else {
                        let rows = [];
                        data.forEach(row => {
                            rows.push([
                                row.province_name,
                                row.year,
                                new Date(row.month).toLocaleString('en-us', { month: 'long' }),
                                row.funded_districts,
                                `<button class="btn btn-danger btn-sm delete-btn-funding" data-id="${row.id}" >Delete</button>`
                            ]);
                        });

                        // Refresh the table with new data
                        table6.clear().rows.add(rows).draw();
                        table6.search('').draw();
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Error: ', status, error);
                }
            });
        }

        // Apply Filter
        $("#btn_filter6").on("click", function () {
            loadDistrictFundingData();
        });

        $(document).on("click", ".delete-btn-funding", function () {
            deleteDistrictFundingData(this); 
        });

        // Function to delete district funding data
        function deleteDistrictFundingData(button) {
            let id = $(button).data('id');
            let csrfToken = $("input[name='csrf_test_name']").val();

            if (confirm("Are you sure you want to delete this district funding data?")) {
                $.ajax({
                    url: "<?= base_url('input/delete_district_funding_data/') ?>" + id,
                    type: "POST",
                    data: { csrf_test_name: csrfToken },
                    success: function (response) {
                        alert("District funding data deleted successfully.");
                        loadDistrictFundingData(); 
                    },
                    error: function (xhr, status, error) {
                        alert("Failed to delete district funding data.");
                        console.log(status, error);
                    }
                });
            }
        }

        // Trigger data load when the page loads
        loadDistrictFundingData();
    });
</script>

<!-- 🔥 SCRIPT AJAX UNTUK LOAD DATA & DELETE DATA Policy-->
<script>
$(document).ready(function () {
    // 🔄 Load Data ke Tabel
    function loadDistrictPolicyData() {
        let province = $("#filter_province7").val();
        let year = $("#filter_year7").val();
        let month = $("#filter_month7").val();

        $.ajax({
            url: "<?= base_url('input/get_district_policy_data') ?>", 
            type: "GET",
            data: { province_id: province, year: year, month: month },
            success: function (response) {
                let data = JSON.parse(response);
                let tableBody = $("#table7 tbody");
                tableBody.empty();

                if (data.length === 0) {
                    tableBody.append('<tr><td colspan="5" class="text-center">No Data Found</td></tr>');
                } else {
                    let rows = [];
                    data.forEach(row => {
                        rows.push([
                            row.province_name,
                            row.year,
                            new Date(row.month).toLocaleString('en-us', { month: 'long' }),
                            row.policy_districts,
                            `<button class="btn btn-danger btn-sm delete-btn-dp" data-id="${row.id}" >Delete</button>`
                        ]);
                    });

                    let table7 = $('#table7').DataTable();
                    table7.clear().rows.add(rows).draw();
                    table7.search('').draw();
                }
            },
            error: function (xhr, status, error) {
                console.log('Error:', status, error);
            }
        });
    }

    // 🎯 Apply Filter
    $("#btn_filter7").on("click", function () {
        let province = $("#filter_province7").val();
        if (!province) {
            alert("Please select a Province.");
            return;
        }
        loadDistrictPolicyData();
    });

    $(document).on("click", ".delete-btn-dp", function () {
        deleteDistrictPolicyData(this); 
    });

    // ❌ Hapus Data
    function deleteDistrictPolicyData(button) {
        let id = $(button).data('id');
        let csrfToken = $("input[name='csrf_test_name']").val(); 

        if (confirm("Are you sure you want to delete this data?")) {
            $.ajax({
                url: "<?= base_url('input/delete_district_policy_data/') ?>" + id, 
                type: "POST",
                data: { csrf_test_name: csrfToken }, 
                success: function (response) {
                    alert("Data deleted successfully.");
                    loadDistrictPolicyData();
                },
                error: function (xhr, status, error) {
                    alert("Failed to delete data.");
                    console.log(status, error);
                }
            });
        }
    }

    // Inisialisasi DataTable
    $('#table7').DataTable({ paging: true, searching: true, ordering: true, info: true, responsive: true });

    // Load data pertama kali saat halaman dimuat
    loadDistrictPolicyData();
});
</script>




