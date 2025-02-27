
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Laporan Kerangka Kerja Penurunan Zero Dose</h3>
                                <!-- <p class="text-subtitle text-muted">Children will lose their opportunity this year/ has lost their opportunity​</p> -->
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Report</li>
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
                                        <h4 class="card-title">Unduh Laporan</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- <form class="form form-horizontal"> -->
                                                <!-- <div class="form-body"> -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <?= form_open('report/immunization_report_indonesia'); ?>
                                                                <label for="partnersInput" class="form-label" style="font-size: 1rem; font-weight: bold;">Pilih Filter </label>
                                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                                    <?php
                                                                        // Ambil session partner_category
                                                                        $partner_category = $this->session->userdata('partner_category');

                                                                        // Cek apakah partner_category valid (tidak kosong, tidak null, tidak 0)
                                                                        $is_disabled = !empty($partner_category) && $partner_category != 0;

                                                                        // Tentukan value untuk partner_id
                                                                        $partner_id_value = $is_disabled ? $partner_category : set_value('partner_id', $selected_partner);
                                                                    ?>
                                                                    <!-- <?= form_dropdown('partner_id', 
                                                                        array_column($partners, 'name', 'id'), // Data dropdown: id => name
                                                                        $partner_id_value, // Value yang dipilih
                                                                        'id="partner_id" class="form-select" style="width: 20%; max-width: 150px; height: 48px; font-size: 1rem;" ' 
                                                                        . ($is_disabled ? 'disabled' : '') . ' required'
                                                                    ); ?>
                                                                    <?php if ($is_disabled): ?>
                                                                        <input type="hidden" name="partner_id" value="<?= $partner_category ?>">
                                                                    <?php endif; ?> -->
                                                                    <?= form_dropdown('province_id', $province_options, '', 
                                                                        'class="form-select" id="province_id" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('city_id', ['all' => '-- Kab/Kota --'], '',
                                                                        'class="form-select" id="city_id" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('year', $year_options, '', 
                                                                        'class="form-select" id="year" style="width: 20%; max-width: 100px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('month', $month_options, '', 
                                                                        'class="form-select" id="month" style="width: 20%; max-width: 150px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                                        <i class="bi bi-download"></i> Download
                                                                    </button>
                                                                </div>
                                                            <?= form_close(); ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        </br>
                                                    </div>
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
                </section>

                    <!-- Basic Horizontal form layout section start -->
                    <?php if (in_array($this->session->userdata('user_category'), [2, 9])): ?>
                        
                    <?php endif; ?>
                    <!-- Basic Horizontal form layout section end -->
                    
                </div>
            </div>

        </div>
    </div>
    
    

<script>


    $('#province_id').change(function () {
        var province_id = $(this).val();
        if (province_id) {
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
        }
    });
</script>

<script>
    function submitForm() {
        var form = document.getElementById('myForm');
        window.open(form.action, '_blank');
        form.submit();
    }
</script>
