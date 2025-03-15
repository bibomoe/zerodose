
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Activity</h3>
                                <!-- <p class="text-subtitle text-muted">Children will lose their opportunity this year/ has lost their opportunity​</p> -->
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Activity</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="page-content"> 
                    <!-- Basic Horizontal form layout section start -->
                    <section id="basic-horizontal-layouts">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <!-- <div class="card-header"></div> -->
                                            <div class="card-body">
                                                <?php if ($this->session->flashdata('success')): ?>
                                                    <div class="alert alert-success">
                                                        <?= $this->session->flashdata('success'); ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?= form_open('input/filter'); ?>
                                                <label for="partnersInput" class="form-label" style="font-size: 1.2rem; font-weight: bold;">Gavi MICs Partners/implementers </label>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    <!-- <select id="partnersInput" class="form-select" style="width: 100%; max-width: 300px; height: 48px; font-size: 1rem;">
                                                        <option selected>Ministry of Health Indonesia</option>
                                                        <option>CHAI</option>
                                                        <option>WHO</option>
                                                        <option>UNICEF</option>
                                                        <option>UNDP</option>
                                                    </select> -->
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
                                                    <?= form_dropdown(
                                                        'year', 
                                                        [2024 => '2024', 2025 => '2025', 2026 => '2026'], 
                                                        set_value('year', $selected_year ?? 2025), 
                                                        'class="form-select" style="width: 100%; max-width: 150px; height: 48px; font-size: 1rem;" required'
                                                    ); ?>
                                                    <?php 
                                                    $months = [
                                                        1 => 'January', 
                                                        2 => 'February', 
                                                        3 => 'March', 
                                                        4 => 'April', 
                                                        5 => 'May', 
                                                        6 => 'June', 
                                                        7 => 'July', 
                                                        8 => 'August', 
                                                        9 => 'September', 
                                                        10 => 'October', 
                                                        11 => 'November', 
                                                        12 => 'December'
                                                    ];
                                                    ?>

                                                    <?= form_dropdown(
                                                        'month', 
                                                        $months, 
                                                        set_value('month', $selected_month ?? 1), // Default value bulan Januari (1) jika tidak ada value
                                                        'class="form-select" style="width: 100%; max-width: 200px; height: 48px; font-size: 1rem;" required'
                                                    ); ?>

                                                    <!-- <select id="yearInput" class="form-select" style="width: 100%; max-width: 150px; height: 48px; font-size: 1rem;">
                                                        <option selected>Year</option>
                                                        <option>2025</option>
                                                        <option>2024</option>
                                                    </select> 
                                                    <input type="number" name="year" min="2024" max="2025" value="<?= set_value('year', $selected_year ? $selected_year : date('Y')) ?>" 
                                                        class="form-control" style="width: 100%; max-width: 150px; height: 48px; font-size: 1rem;" required>
                                                    <select id="monthInput" class="form-select" style="width: 100%; max-width: 150px; height: 48px; font-size: 1rem;">
                                                        <option selected>Month</option>
                                                        <option>January</option>
                                                        <option>February</option>
                                                        <option>March</option>
                                                        <option>April</option>
                                                        <option>May</option>
                                                        <option>June</option>
                                                        <option>July</option>
                                                        <option>August</option>
                                                        <option>September</option>
                                                        <option>October</option>
                                                        <option>November</option>
                                                        <option>December</option>
                                                    </select> 
                                                    <input type="number" name="month" min="1" max="12" value="<?= set_value('month', $selected_month) ?>" 
                                                        class="form-control" style="width: 100%; max-width: 150px; height: 48px; font-size: 1rem;" required>
                                                    -->
                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                        <i class="bi bi-filter"></i> Submit
                                                    </button>
                                                </div>
                                                <?= form_close(); ?>
                                            </div>
                                    </div>
                                </div>
                            </div>

                        <?php if (!empty($activity_data)): ?>
                            <?= form_open('input/save_transaction'); ?>
                                <input type="hidden" name="partner_id" value="<?= $selected_partner ?>">
                                <input type="hidden" name="year" value="<?= $selected_year ?>">
                                <input type="hidden" name="month" value="<?= $selected_month ?>">
                                
                                <div class="row match-height">
                                    <div class="col-md-12 col-12">
                                        <div class="card">
                                            <!-- <div class="card-header">
                                                <h4 class="card-title">Activity</h4>
                                            </div> -->
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <form class="form form-horizontal">
                                                        <div class="form-body">
                                                            <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="width: 5%;">Activity Code</th>
                                                                                <th style="width: 40%;">Description</th>
                                                                                <th style="width: 10%;">Number of Activities</th>
                                                                                <th>Total Budget (USD)</th>
                                                                                <th>Total Budget (IDR)</th> <!-- Kolom baru untuk IDR -->
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($activity_data as $activity): ?>
                                                                                <tr>
                                                                                    <td><?= $activity['activity_code'] ?></td>
                                                                                    <td><?= $activity['description'] ?></td>
                                                                                    <td>
                                                                                        <input type="number" name="activities[<?= $activity['id'] ?>][number]" class="form-control"
                                                                                            value="<?= $activity['number_of_activities'] ?>" min="0">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" name="activities[<?= $activity['id'] ?>][budget]" class="form-control target_budget_2024"
                                                                                            value="<?= $activity['total_budget'] ?>" min="0">
                                                                                    </td>
                                                                                    <td>
                                                                                        <label id="total_budget_idr_<?= str_replace('.', '_', $activity['activity_code']) ?>">
                                                                                            <?= number_format($activity['total_budget_idr'], 0, ',', '.') ?>
                                                                                        </label>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endforeach; ?>
                                                                        </tbody>
                                                                    </table>

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
                                </div>
                            <?= form_close(); ?>
                        <?php endif; ?>
                    </section>
                    <!-- Basic Horizontal form layout section end -->
                </div>
            </div>

        </div>
    </div>
    
    

<script>

document.addEventListener('DOMContentLoaded', function () {
    // Fungsi untuk menghitung dan update IDR
    function updateIDR() {
        const conversionRate = 14500; // Rp 14.500 per USD

        // Update IDR untuk setiap input budget USD
        document.querySelectorAll('input[name*="budget"]').forEach(input => {
            const usdValue = parseFloat(input.value) || 0;
            const idrValue = usdValue * conversionRate;

            // Ambil activity code sebagai ID (ubah titik menjadi garis bawah untuk ID yang valid)
            const activityCode = input.closest('tr').querySelector('td:nth-child(1)').textContent.trim(); // Activity code
            const validId = activityCode.replace('.', '_'); // Ganti titik dengan garis bawah

            // Update label IDR yang sesuai di kolom
            const idrLabel = document.querySelector(`#total_budget_idr_${validId}`);
            if (idrLabel) {
                idrLabel.textContent = idrValue.toLocaleString();
            }
        });
    }

    // Update IDR setiap kali nilai USD diubah
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('input', updateIDR);
    });

    // Update IDR ketika halaman pertama kali dimuat
    updateIDR();
});


</script>