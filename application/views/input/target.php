
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
                                                                    <!-- <h6>Country Objectives</h6> -->
                                                                    <table class="table table-hover" id="table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th rowspan="2" style="width: 5%;">Activity Code</th>
                                                                                <th rowspan="2" style="width: 60%;">Description</th>
                                                                                <th colspan="2" style="width: 35%;">Target (IDR)</th>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Y1 (2024) </th>
                                                                                <th>Y2 (2025) </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <!-- <tbody>
                                                                            <tr>
                                                                                <td>1. Improve subnational capacity in planning, implementing and monitoring to catch-up vaccination</td>
                                                                                <td>Percent of workplan activities executed</td>
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
                                                                                <td>2. Improve routine data quality and data use, including high risk and hard to reach areas, to identify and target zero dose</td>
                                                                                <td>Percent of workplan activities executed</td>
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
                                                                                <td>3. Evidence-based demand generation supported by cross sectoral involvement, including private sector, particularly for missed communities</td>
                                                                                <td>Percent of workplan activities executed</td>
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
                                                                                <td>4. Improve EPI capacity at national and subnational level in vaccine logistics, social mobilization and advocacy for sustainable and equitable immunization coverage</td>
                                                                                <td>Percent of workplan activities executed</td>
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
                                                                                <td>5. Facilitate sustainable subnational financing for operations of immunization programs</td>
                                                                                <td>Percent of workplan activities executed</td>
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
                                                                                <td>6. Strengthen coordination to promote shared accountability at national and subnational level</td>
                                                                                <td>Percent of workplan activities executed</td>
                                                                                <td>
                                                                                    <input type="number" id="targety1Input" class="form-control" name="targety1Input" min="0"
                                                                                        placeholder="" value="0">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number" id="targety2Input" class="form-control" name="targety2Input" min="0"
                                                                                        placeholder="" value="0">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody> -->
                                                                        <tbody>
                                                                            <?php foreach ($activities as $activity): ?>
                                                                                <tr>
                                                                                    <td><?= $activity['activity_code']; ?></td>
                                                                                    <td><?= $activity['description']; ?></td>
                                                                                    <td>
                                                                                        <input type="number" 
                                                                                            name="activities[<?= $activity['id']; ?>][target_budget_2024]" 
                                                                                            value="<?= $activity['target_budget_2024']; ?>" 
                                                                                            class="form-control target_budget_2024" 
                                                                                            min="0" required>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" 
                                                                                            name="activities[<?= $activity['id']; ?>][target_budget_2025]" 
                                                                                            value="<?= $activity['target_budget_2025']; ?>" 
                                                                                            class="form-control target_budget_2025" 
                                                                                            min="0" required>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                            <!-- Baris Total -->
                                                                            <tr>
                                                                                <td colspan="2"><strong>Total Target Budget</strong></td>
                                                                                <td>
                                                                                    <strong id="total_budget_2024">
                                                                                        <?= number_format($total_budget_2024, 0, ',', '.'); ?>
                                                                                    </strong>
                                                                                    <!-- <br>
                                                                                    <small>(Indicator: Budget execution (use) rate for 2024 reporting period, Gavi)</small> -->
                                                                                </td>
                                                                                <td>
                                                                                    <strong id="total_budget_2025">
                                                                                        <?= number_format($total_budget_2025, 0, ',', '.'); ?>
                                                                                    </strong>
                                                                                    <!-- <br>
                                                                                    <small>(Indicator: Budget execution (use) rate for 2025 reporting period, Gavi)</small> -->
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <input type="hidden" id="hidden_total_budget_2024" name="total_budget_2024" value="<?= $total_budget_2024; ?>">
                                                                    <input type="hidden" id="hidden_total_budget_2025" name="total_budget_2025" value="<?= $total_budget_2025; ?>">
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
                                <div class="col-md-6 col-12">
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
                                                            <?= form_label('Select City', 'city_id'); ?>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <?= form_dropdown('city_id', ['' => '-- Select City --'], '', 'class="form-select" id="city_id"'); ?>
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
        function calculateTotals() {
            let total2024 = 0;
            let total2025 = 0;

            document.querySelectorAll('.target_budget_2024').forEach(input => {
                total2024 += parseFloat(input.value) || 0;
            });

            document.querySelectorAll('.target_budget_2025').forEach(input => {
                total2025 += parseFloat(input.value) || 0;
            });

            document.getElementById('total_budget_2024').textContent = total2024.toLocaleString();
            document.getElementById('total_budget_2025').textContent = total2025.toLocaleString();

            document.getElementById('hidden_total_budget_2024').value = total2024;
            document.getElementById('hidden_total_budget_2025').value = total2025;
        }

        // Hitung total setiap kali input berubah
        document.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });

        // Hitung total saat halaman dimuat
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