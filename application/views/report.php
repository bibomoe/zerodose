
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
                <?php if ($this->session->flashdata('message')): ?>
                    <div class="alert alert-info">
                        <?= $this->session->flashdata('message'); ?>
                    </div>
                <?php endif; ?>

                <!-- Unduh Laporan -->
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

                                                                    <?php
                                                                        $user_category = $this->session->userdata('user_category'); // Ambil kategori pengguna yang login

                                                                        if($user_category != 7 && $user_category != 8){
                                                                    ?>
                                                                        <?= form_dropdown('province_id', $province_options, '', 
                                                                        'class="form-select" id="province_id" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                        <?= form_dropdown('city_id', ['all' => '-- Kab/Kota --'], '',
                                                                        'class="form-select" id="city_id" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?php
                                                                        } else {
                                                                            if($user_category == 7){
                                                                    ?>
                                                                        <?= form_dropdown('province_idx', $province_options, $user_province, 
                                                                            'class="form-select" id="province_idx" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"
                                                                            disabled'); ?>
                                                                        <input type="hidden" id="province_id" name="province_id" value="<?=$user_province;?>">
                                                                        <?= form_dropdown('city_id', ['all' => '-- Kab/Kota --'], '',
                                                                        'class="form-select" id="city_id" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?php
                                                                            } else if($user_category == 8){
                                                                    ?>
                                                                        <?= form_dropdown('province_idx', $province_options, $user_province, 
                                                                            'class="form-select" id="province_idx" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"
                                                                            disabled'); ?>
                                                                        <input type="hidden" id="province_id" name="province_id" value="<?=$user_province;?>">
                                                                        <?= form_dropdown('city_idx', ['all' => '-- Kab/Kota --'], '',
                                                                            'class="form-select" id="city_idx" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"
                                                                            disabled'); ?>
                                                                        <input type="hidden" id="city_id" name="city_id" value="<?=$user_city;?>">
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>

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
                                                <!-- </div> -->
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <!-- Kirim laporan -->
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Kirim Laporan Melalui Email</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- <form class="form form-horizontal"> -->
                                                <!-- <div class="form-body"> -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <?= form_open('report/immunization_report_indonesia_sent_email'); ?>
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
                                                                        'class="form-select" id="province_id2" style="width: 20%; max-width: 150px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('city_id', ['all' => '-- Kab/Kota --'], '',
                                                                        'class="form-select" id="city_id2" style="width: 20%; max-width: 150px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('year', $year_options, '', 
                                                                        'class="form-select" id="year" style="width: 20%; max-width: 100px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('month', $month_options, '', 
                                                                        'class="form-select" id="month" style="width: 20%; max-width: 100px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_input([
                                                                        'name' => 'email',
                                                                        'id' => 'email',
                                                                        'type' => 'email',
                                                                        'value' => '',
                                                                        'class' => 'form-control',
                                                                        'placeholder' => 'Enter your email',
                                                                        'required' => 'required',
                                                                        'style' => 'width: 20%; max-width: 300px; height: 48px; font-size: 1rem;'
                                                                    ]); ?>
                                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                                        <i class="bi bi-envelope-arrow-up-fill"></i> Kirim
                                                                    </button>
                                                                </div>
                                                            <?= form_close(); ?>
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <?php if (!in_array($this->session->userdata('user_category'), [7, 8])): ?>

                <!-- Unduh Laporan Mitra -->
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Unduh Laporan Mitra</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- <form class="form form-horizontal"> -->
                                                <!-- <div class="form-body"> -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <?= form_open('report/partner_report'); ?>
                                                                <label for="partnersInput" class="form-label" style="font-size: 1rem; font-weight: bold;">Pilih Filter </label>
                                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                                    <?php
                                                                        // Ambil session partner_category
                                                                        $partner_category = $this->session->userdata('partner_category');

                                                                        // Cek apakah partner_category valid (tidak kosong, tidak null, tidak 0)
                                                                        $is_disabled = !empty($partner_category) && $partner_category != 0;

                                                                        // Tentukan value untuk partner_id
                                                                        $partner_id_value = $is_disabled ? $partner_category : set_value('partner_id', $selected_partner);

                                                                        $dropdown_options = ['all' => 'All'] + array_column($partners, 'name', 'id');
                                                                    ?>
                                                                    <?= form_dropdown('partner_id', 
                                                                        $dropdown_options, // Data dropdown: ['all' => 'All', 'id' => 'name']
                                                                        $partner_id_value, // Value yang dipilih
                                                                        'id="partner_id" class="form-select" style="width: 20%; max-width: 150px; height: 48px; font-size: 1rem;" ' 
                                                                        // . ($is_disabled ? 'disabled' : '') 
                                                                        . ' required'
                                                                    ); ?>
                                                                    <!-- <?php if ($is_disabled): ?>
                                                                        <input type="hidden" name="partner_id" value="<?= $partner_category ?>">
                                                                    <?php endif; ?> -->
                                                                    <!-- <?= form_dropdown('province_id', $province_options, '', 
                                                                        'class="form-select" id="province_id3" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('city_id', ['all' => '-- Kab/Kota --'], '',
                                                                        'class="form-select" id="city_id" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('year', $year_options, '', 
                                                                        'class="form-select" id="year" style="width: 20%; max-width: 100px; height: 48px; font-size: 1rem;"'); ?> -->
                                                                    <?= form_dropdown('month', $month_options, '', 
                                                                        'class="form-select" id="month" style="width: 20%; max-width: 150px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                                        <i class="bi bi-download"></i> Download
                                                                    </button>
                                                                </div>
                                                            <?= form_close(); ?>
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <!-- Kirim laporan Mitra -->
                <section id="basic-horizontal-layouts">
                    <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Kirim Laporan Mitra Melalui Email</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- <form class="form form-horizontal"> -->
                                                <!-- <div class="form-body"> -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <?= form_open('report/partner_report_indonesia_sent_email'); ?>
                                                                <label for="partnersInput" class="form-label" style="font-size: 1rem; font-weight: bold;">Pilih Filter </label>
                                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                                    <?php
                                                                        // Ambil session partner_category
                                                                        $partner_category = $this->session->userdata('partner_category');

                                                                        // Cek apakah partner_category valid (tidak kosong, tidak null, tidak 0)
                                                                        $is_disabled = !empty($partner_category) && $partner_category != 0;

                                                                        // Tentukan value untuk partner_id
                                                                        $partner_id_value = $is_disabled ? $partner_category : set_value('partner_id', $selected_partner);
                                                                        $dropdown_options = ['all' => 'All'] + array_column($partners, 'name', 'id');
                                                                    ?>
                                                                    <?= form_dropdown('partner_id', 
                                                                        $dropdown_options, // Data dropdown: ['all' => 'All', 'id' => 'name']
                                                                        $partner_id_value, // Value yang dipilih
                                                                        'id="partner_id" class="form-select" style="width: 20%; max-width: 150px; height: 48px; font-size: 1rem;" ' 
                                                                        // . ($is_disabled ? 'disabled' : '') 
                                                                        . ' required'
                                                                    ); ?>
                                                                    <!-- <?php if ($is_disabled): ?>
                                                                        <input type="hidden" name="partner_id" value="<?= $partner_category ?>">
                                                                    <?php endif; ?> -->
                                                                    <!-- <?= form_dropdown('province_id', $province_options, '', 
                                                                        'class="form-select" id="province_id4" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('city_id', ['all' => '-- Kab/Kota --'], '',
                                                                        'class="form-select" id="city_id" style="width: 20%; max-width: 250px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_dropdown('year', $year_options, '', 
                                                                        'class="form-select" id="year" style="width: 20%; max-width: 100px; height: 48px; font-size: 1rem;"'); ?> -->
                                                                    <?= form_dropdown('month', $month_options, '', 
                                                                        'class="form-select" id="month" style="width: 20%; max-width: 150px; height: 48px; font-size: 1rem;"'); ?>
                                                                    <?= form_input([
                                                                        'name' => 'email',
                                                                        'id' => 'email',
                                                                        'type' => 'email',
                                                                        'value' => '',
                                                                        'class' => 'form-control',
                                                                        'placeholder' => 'Enter your email',
                                                                        'required' => 'required',
                                                                        'style' => 'width: 20%; max-width: 300px; height: 48px; font-size: 1rem; '
                                                                    ]); ?>
                                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                                        <i class="bi bi-envelope-arrow-up-fill"></i> Kirim
                                                                    </button>
                                                                </div>
                                                            <?= form_close(); ?>
                                                        </div>
                                                    </div>
                                                <!-- </div> -->
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <?php endif; ?>

                    <!-- Basic Horizontal form layout section start -->
                    <?php if (in_array($this->session->userdata('user_category'), [2, 9])): ?>
                        
                    <?php endif; ?>
                    <!-- Basic Horizontal form layout section end -->
                    
                </div>
            </div>

        </div>
    </div>
    
    

<script>
$(document).ready(function () {
            const user_category = <?= $user_category; ?>;

            if (user_category == 7) {
                var province_id = $('#province_id').val();
                // if (province_id) {
                    $.ajax({
                        url: "<?= base_url('input/get_cities_by_province') ?>",
                        type: "GET",
                        data: { province_id: province_id },
                        dataType: "json",
                        success: function (data) {
                            $('#city_id').html('<option value="">-- Select District --</option>');
                            $.each(data, function (key, value) {
                                $('#city_id').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                            });
                        }
                    });
                // }
                
            }

    $('#province_id').change(function () {
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

    $('#province_id2').change(function () {
        var province_id = $(this).val();
        if (province_id !== 'all' || province_id !== 'targeted') {
            $.ajax({
                url: "<?= base_url('input/get_cities_by_province') ?>",
                type: "GET",
                data: { province_id: province_id },
                dataType: "json",
                success: function (data) {
                    $('#city_id2').html('<option value="all">-- Kab/Kota --</option>');
                    $.each(data, function (key, value) {
                        $('#city_id2').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                    });
                }
            });
        } else {
            $('#city_id').html('<option value="all">-- Kab/Kota --</option>');
        }
    });

    // Mengecek jika province_id sudah memiliki nilai saat halaman dimuat
    var initialProvinceId = $('#province_id').val();  // Ambil nilai province_id saat halaman dimuat
        if (initialProvinceId && initialProvinceId !== 'all' && initialProvinceId !== 'targeted') {
            // Jika province_id tidak bernilai 'all' atau 'targeted', lakukan request untuk mendapatkan kota
            $.ajax({
                url: "<?= base_url('input/get_cities_by_province') ?>",  // URL ke controller Anda
                type: "GET",
                data: { province_id: initialProvinceId },
                dataType: "json",
                success: function (data) {
                    // Mengosongkan dropdown kota sebelum menambah opsi baru
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
