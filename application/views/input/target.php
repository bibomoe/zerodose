
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Target</h3>
                                <!-- <p class="text-subtitle text-muted">Children will lose their opportunity this year/ has lost their opportunity​</p> -->
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Target</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="page-content"> 
                <?php if ($this->session->flashdata('success')): ?>
                                                                <div class="alert alert-success">
                                                                    <?= $this->session->flashdata('success'); ?>
                                                                </div>
                                                            <?php endif; ?>
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Target Budget for Activities</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- <form class="form form-horizontal"> -->
                                                <!-- <div class="form-body"> -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <?= form_open('input/filter_target_budget'); ?>
                                                                <label for="partnersInput" class="form-label" style="font-size: 1rem; font-weight: bold;">Select Gavi MICs Partners/implementers </label>
                                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                                    <?php
                                                                        // Ambil session partner_category
                                                                        $partner_category = $this->session->userdata('partner_category');

                                                                        // Cek apakah partner_category valid (tidak kosong, tidak null, tidak 0)
                                                                        $is_disabled = !empty($partner_category) && $partner_category != 0;

                                                                        // Tentukan value untuk partner_id
                                                                        $partner_id_value = $is_disabled ? $partner_category : set_value('partner_id', $selected_partner);
                                                                    ?>
                                                                    <?= form_dropdown('partner_id', 
                                                                        array_column($partners, 'name', 'id'), // Data dropdown: id => name
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
                                                    <div class="row">
                                                        </br>
                                                    </div>
                                                    <!-- <div class="row">
                                                        <div class="col-md-12">
                                                            <h4>Grant Implementation & Budget Disbursement</h4>
                                                            <table class="table" id="table">
                                                                <thead >
                                                                    <tr>
                                                                        <th rowspan="2">Indicator</th>
                                                                        <th colspan="2">Target</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Y1</th>
                                                                        <th>Y2</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Budget execution (use) rate for a given reporting period, Gavi</td>
                                                                        <td>
                                                                            <input type="number" id="targety1Input" class="form-control" name="targety1Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" id="targety2Input" class="form-control" name="targety2Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Budget execution (use) rate for a given reporting period, domestic</td>
                                                                        <td>
                                                                            <input type="number" id="targety1Input" class="form-control" name="targety1Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" id="targety2Input" class="form-control" name="targety2Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Timely disbursement of funds reaching sub-national level, Gavi</td>
                                                                        <td>
                                                                            <input type="number" id="targety1Input" class="form-control" name="targety1Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" id="targety2Input" class="form-control" name="targety2Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Timely disbursement of funds reaching sub-national level, domestic</td>
                                                                        <td>
                                                                            <input type="number" id="targety1Input" class="form-control" name="targety1Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" id="targety2Input" class="form-control" name="targety2Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Funding allocated to civil society and community organizations</td>
                                                                        <td>
                                                                            <input type="number" id="targety1Input" class="form-control" name="targety1Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                        <td>
                                                                            <input type="number" id="targety2Input" class="form-control" name="targety2Input" min="0"
                                                                                placeholder="" value="0">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div> -->
                                                    <!-- <?php var_dump($selected_partner) ; ?> -->
                                                    <?php if (!empty($activities)): ?>
                                                        <?= form_open('input/save_target_budget'); ?>
                                                            <input type="hidden" name="partner_id" value="<?= $partner_id_value; ?>">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    </br>
                                                                    <div class="table-responsive">
                                                                        <table class="table table-hover" id="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th rowspan="2" style="width: 5%;">Activity Code</th>
                                                                                    <th rowspan="2" style="width: 30%;">Description</th>
                                                                                    <th colspan="2" style="width: 65%;">Target (USD)</th>
                                                                                    <th colspan="2" style="width: 65%;">Target (IDR)</th> <!-- New columns for IDR -->
                                                                                </tr>
                                                                                <tr>
                                                                                    <th>Y1 (2024 USD)</th>
                                                                                    <th>Y2 (2025 USD)</th>
                                                                                    <th>Y1 (2024 IDR)</th> <!-- New column for IDR -->
                                                                                    <th>Y2 (2025 IDR)</th> <!-- New column for IDR -->
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($activities as $activity): ?>
                                                                                    <tr>
                                                                                        <td><?= $activity['activity_code']; ?></td>
                                                                                        <td><?= $activity['description']; ?></td>
                                                                                        <td>
                                                                                            <input type="number" 
                                                                                                name="activities[<?= $activity['id']; ?>][target_budget_2024]" 
                                                                                                value="<?= $activity['target_budget_2024_usd']; ?>" 
                                                                                                class="form-control target_budget_2024" 
                                                                                                min="0" required>
                                                                                        </td>
                                                                                        <td>
                                                                                            <input type="number" 
                                                                                                name="activities[<?= $activity['id']; ?>][target_budget_2025]" 
                                                                                                value="<?= $activity['target_budget_2025_usd']; ?>" 
                                                                                                class="form-control target_budget_2025" 
                                                                                                min="0" required>
                                                                                        </td>
                                                                                        <td>
                                                                                            <label id="target_budget_2024_idr"><?= number_format($activity['target_budget_2024_idr'], 0, ',', '.'); ?></label> <!-- Convert USD to IDR -->
                                                                                        </td>
                                                                                        <td>
                                                                                            <label id="target_budget_2025_idr"><?= number_format($activity['target_budget_2025_idr'], 0, ',', '.'); ?></label> <!-- Convert USD to IDR -->
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                                <!-- Baris Total -->
                                                                                <tr>
                                                                                    <td colspan="2"><strong>Total Target Budget</strong></td>
                                                                                    <td>
                                                                                        <strong id="total_budget_2024">
                                                                                            <?= number_format($total_budget_2024_usd, 0, ',', '.'); ?>
                                                                                        </strong>
                                                                                    </td>
                                                                                    <td>
                                                                                        <strong id="total_budget_2025">
                                                                                            <?= number_format($total_budget_2025_usd, 0, ',', '.'); ?>
                                                                                        </strong>
                                                                                    </td>
                                                                                    <td>
                                                                                        <strong id="total_budget_2024_idr">
                                                                                            <?= number_format($total_budget_2024_idr, 0, ',', '.'); ?>
                                                                                        </strong>
                                                                                    </td>
                                                                                    <td>
                                                                                        <strong id="total_budget_2025_idr">
                                                                                            <?= number_format($total_budget_2025_idr, 0, ',', '.'); ?>
                                                                                        </strong>
                                                                                    </td>
                                                                                </tr>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <input type="hidden" id="hidden_total_budget_2024" name="total_budget_2024" value="<?= $total_budget_2024_idr; ?>">
                                                                    <input type="hidden" id="hidden_total_budget_2025" name="total_budget_2025" value="<?= $total_budget_2025_idr; ?>">
                                                                    <div class="col-sm-12 d-flex justify-content-end">
                                                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                                                        <button type="reset"
                                                                            class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?= form_close(); ?>
                                                    <?php endif; ?>
                                                <!-- </div> -->
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row match-height">
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Target Coverage</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="dpt1Input">Target DPT 1</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="dpt1Input" class="form-control" name="dpt1Input" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="dpt2Input">Target DPT 2</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="dpt2Input" class="form-control" name="dpt2Input" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="dpt3Input">Target DPT 3</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="dpt3Input" class="form-control" name="dpt3Input" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="mr1Input">Target MR 1</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="mr1Input" class="form-control" name="mr1Input" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-sm-12 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                                            <button type="reset"
                                                                class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                </section>

                    <!-- Basic Horizontal form layout section start -->
                    <?php if (in_array($this->session->userdata('user_category'), [2, 9])): ?>
                        <section id="basic-horizontal-layouts">
                            <div class="row match-height">
                                <div class="col-md-12 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Immunization Coverage</h4>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <?= form_open('input/save_target_immunization', ['class' => 'form form-horizontal']); ?>
                                                <div class="form-body">
                                                    <div class="row">
                                                        <!-- <?php if ($this->session->flashdata('success')): ?>
                                                            <div class="alert alert-success">
                                                                <?= $this->session->flashdata('success'); ?>
                                                            </div>
                                                        <?php endif; ?> -->

                                                        <div class="col-md-4">
                                                            <?= form_label('Select Province', 'province_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('province_id', $province_options, '', 'class="form-select" id="province_id"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('City', 'city_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('city_id', ['' => '-- Select City --'], '', 'class="form-select" id="city_id"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('Select Year', 'year'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('year', $year_options, '', 'class="form-select" id="year"'); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('DPT 1 Target', 'dpt_hb_hib_1_target'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_hb_hib_1_target', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_hb_hib_1_target']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('DPT 2 Target', 'dpt_hb_hib_2_target'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_hb_hib_2_target', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_hb_hib_2_target']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('DPT 3 Target', 'dpt_hb_hib_3_target'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_hb_hib_3_target', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_hb_hib_3_target']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('MR 1 Target', 'mr_1_target'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'mr_1_target', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'mr_1_target']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('DPT 1 Actual Target', 'dpt_hb_hib_1_target_actual'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_hb_hib_1_target_actual', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_hb_hib_1_target_actual']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('DPT 2 Actual Target', 'dpt_hb_hib_2_target_actual'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_hb_hib_2_target_actual', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_hb_hib_2_target_actual']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('DPT 3 Actual Target', 'dpt_hb_hib_3_target_actual'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'dpt_hb_hib_3_target_actual', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'dpt_hb_hib_3_target_actual']); ?>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <?= form_label('MR 1 Actual Target', 'mr_1_target_actual'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_input(['name' => 'mr_1_target_actual', 'type' => 'number', 'class' => 'form-control', 'min' => 0, 'id' => 'mr_1_target_actual']); ?>
                                                        </div>

                                                        <div class="col-sm-12 d-flex justify-content-end">
                                                            <?= form_submit('submit', 'Submit', 'class="btn btn-primary me-1 mb-1"'); ?>
                                                            <?= form_reset('reset', 'Reset', 'class="btn btn-light-secondary me-1 mb-1"'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?= form_close(); ?>
                                                </br>
                                                <!-- Garis Pembatas -->
                                                <hr class="my-4">

                                                <div class="row mb-3">
                                                    <div class="col-md-3">
                                                        <label for="filter_province">Filter by Province:</label>
                                                        <select id="filter_province" class="form-select">
                                                            <?php foreach ($province_options as $key => $value): ?>
                                                                <option value="<?= $key; ?>"><?= $value; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="filter_city">Filter by City:</label>
                                                        <select id="filter_city" class="form-select">
                                                            <option value="">-- Select City --</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                    <label for="filter_year">Filter By Year</label>
                                                        <select id="filter_year" class="form-select">
                                                            <option value="">- Year -</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                        </select>
                                                    </div>

                                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                                        value="<?= $this->security->get_csrf_hash(); ?>">

                                                    <div class="col-md-4 d-flex align-items-end">
                                                        <button id="filter_btn" class="btn btn-secondary">Apply Filter</button>
                                                    </div>
                                                </div>

                                                <!-- Garis Pembatas -->
                                                <hr class="my-4">

                                                <div class="table-responsive">
                                                    <table class="table table-striped" id="table2">
                                                        <thead>
                                                            <tr>
                                                                <th>Province</th>
                                                                <th>City/District</th>
                                                                <th>Year</th>
                                                                <th>DPT 1</th>
                                                                <th>DPT 2</th>
                                                                <th>DPT 3</th>
                                                                <th>MR 1</th>
                                                                <th>DPT 1 Actual</th>
                                                                <th>DPT 2 Actual</th>
                                                                <th>DPT 3 Actual</th>
                                                                <th>MR 1 Actual</th>
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
                        </section>
                    <?php endif; ?>
                    <!-- Basic Horizontal form layout section end -->
                    
                </div>
            </div>

        </div>
    </div>
    
    

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fungsi untuk menghitung total dan update IDR
        function calculateTotals() {
            let total2024 = 0;
            let total2025 = 0;

            // Menghitung total untuk tahun 2024
            document.querySelectorAll('.target_budget_2024').forEach(input => {
                total2024 += parseFloat(input.value) || 0;
            });

            // Menghitung total untuk tahun 2025
            document.querySelectorAll('.target_budget_2025').forEach(input => {
                total2025 += parseFloat(input.value) || 0;
            });

            // Update total USD
            document.getElementById('total_budget_2024').textContent = total2024.toLocaleString();
            document.getElementById('total_budget_2025').textContent = total2025.toLocaleString();

            // Update hidden total values for form submission
            document.getElementById('hidden_total_budget_2024').value = total2024;
            document.getElementById('hidden_total_budget_2025').value = total2025;

            // Update IDR labels based on USD inputs
            updateIDRLabels(total2024, total2025); // Passing total2024 and total2025 as parameters
        }

        // Fungsi untuk mengupdate label IDR
        function updateIDRLabels(total2024, total2025) {
            const conversionRate = 14500; // Rp14.500 per USD

            // Update IDR for 2024
            document.querySelectorAll('.target_budget_2024').forEach(input => {
                const usdValue = parseFloat(input.value) || 0;
                const idrValue = usdValue * conversionRate;
                // Update the corresponding IDR label
                input.closest('tr').querySelector('label[id="target_budget_2024_idr"]').textContent = idrValue.toLocaleString();
            });

            // Update IDR for 2025
            document.querySelectorAll('.target_budget_2025').forEach(input => {
                const usdValue = parseFloat(input.value) || 0;
                const idrValue = usdValue * conversionRate;
                // Update the corresponding IDR label
                input.closest('tr').querySelector('label[id="target_budget_2025_idr"]').textContent = idrValue.toLocaleString();
            });

            // Update total IDR in the last row based on USD totals
            const total2024IDR = total2024 * conversionRate;
            const total2025IDR = total2025 * conversionRate;

            // Update the total IDR labels in the footer
            document.getElementById('total_budget_2024_idr').textContent = total2024IDR.toLocaleString();
            document.getElementById('total_budget_2025_idr').textContent = total2025IDR.toLocaleString();
        }

        // Recalculate totals and update labels whenever an input changes
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });

        // Initial IDR update when the page is loaded
        calculateTotals();
    });


    $('#province_id').change(function () {
        var province_id = $(this).val();
        if (province_id) {
            $.ajax({
                url: "<?= base_url('input/get_cities_by_province') ?>",
                type: "GET",
                data: { province_id: province_id },
                dataType: "json",
                success: function (data) {
                    $('#city_id').html('<option value="">-- Select City --</option>');
                    $.each(data, function (key, value) {
                        $('#city_id').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                    });
                }
            });
        }
    });
</script>

<script>
$(document).ready(function () {
    // Inisialisasi DataTable hanya sekali
    let table2 = $('#table2').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true
    });
    
    function loadTable(province_id = '', city_id = '', year = null) {
        $.ajax({
            url: "<?= base_url('input/get_target_immunization'); ?>",
            type: "GET",
            data: { province_id: province_id, city_id: city_id, year: year },
            dataType: "json",
            success: function (response) {
                let tableBody = $("#table2 tbody");
                tableBody.empty(); // Kosongkan tabel sebelum diisi ulang

                if (response.length > 0) {
                    let rows = [];
                    response.forEach(row => {
                        // let newRow = `<tr>
                        //     <td>${row.province_name}</td>
                        //     <td>${row.city_name}</td>
                        //     <td>${row.year}</td>
                        //     <td>${row.dpt_hb_hib_1_target}</td>
                        //     <td>${row.dpt_hb_hib_2_target}</td>
                        //     <td>${row.dpt_hb_hib_3_target}</td>
                        //     <td>${row.mr_1_target}</td>
                        //     <td>${row.dpt_hb_hib_1_target_actual}</td>
                        //     <td>${row.dpt_hb_hib_2_target_actual}</td>
                        //     <td>${row.dpt_hb_hib_3_target_actual}</td>
                        //     <td>${row.mr_1_target_actual}</td>
                        //     <td>
                        //         <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}">Delete</button>
                        //     </td>
                        // </tr>`;
                        // tableBody.append(newRow);
                        let newRow = [
                            row.province_name,  // Province Name
                            row.city_name,      // City Name
                            row.year,           // Year
                            row.dpt_hb_hib_1_target,    // DPT 1 Target
                            row.dpt_hb_hib_2_target,    // DPT 2 Target
                            row.dpt_hb_hib_3_target,    // DPT 3 Target
                            row.mr_1_target,    // MR 1 Target
                            row.dpt_hb_hib_1_target_actual,  // Actual DPT 1 Target
                            row.dpt_hb_hib_2_target_actual,  // Actual DPT 2 Target
                            row.dpt_hb_hib_3_target_actual,  // Actual DPT 3 Target
                            row.mr_1_target_actual,  // Actual MR 1 Target
                            `<button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}" onclick="deleteData(this)">Delete</button>`  // Delete Button
                        ];

                        // Push the newRow into the rows array
                        rows.push(newRow);
                    });

                    // Refresh tabel dengan data baru
                    table2.clear().rows.add(rows).draw();

                    // Pastikan fitur pencarian dan pengurutan masih berfungsi
                    table2.search('').draw();  // Kosongkan pencarian dan gambar ulang DataTable
                } else {
                    tableBody.append('<tr><td colspan="11" class="text-center">No data found</td></tr>');
                }
            }
        });
    }

    // Load data pertama kali tanpa filter
    loadTable();

    // Event Listener untuk tombol filter
    $("#filter_btn").on("click", function () {
        let province_id = $("#filter_province").val();
        let city_id = $("#filter_city").val();
        let year = $("#filter_year").val();

        // alert(year);
        // console.log(year);
        loadTable(province_id, city_id,year);
    });

    // Hapus data dengan AJAX
    $(document).on("click", ".delete-btn", function () {
        let rowId = $(this).data("id");
        let csrfToken = $("input[name='csrf_test_name']").val(); // Ambil token CSRF dari input hidden

        if (confirm("Are you sure you want to delete this entry?")) {
            $.ajax({
                url: "<?= base_url('input/delete_target_immunization'); ?>",
                type: "POST",
                data: { id: rowId, csrf_test_name: csrfToken }, // Kirim CSRF Token
                dataType: "json",
                success: function (response) {
                    if (response.status === 'success') {
                        alert("Data deleted successfully!");
                        loadTable(); // Reload tabel setelah menghapus data
                    } else {
                        alert("Failed to delete data.");
                    }
                },
                error: function () {
                    alert("Error deleting data.");
                }
            });
        }
    });


    // Load kota berdasarkan provinsi yang dipilih
    $("#filter_province, #province_id").on("change", function () {
        let province_id = $(this).val();
        $.ajax({
            url: "<?= base_url('input/get_cities_by_province'); ?>",
            type: "GET",
            data: { province_id: province_id },
            dataType: "json",
            success: function (response) {
                let cityDropdown = $("#filter_city, #city_id");
                cityDropdown.empty().append('<option value="">-- Select City --</option>');
                response.forEach(city => {
                    cityDropdown.append(`<option value="${city.id}">${city.name_id}</option>`);
                });
            }
        });
    });
});

</script>