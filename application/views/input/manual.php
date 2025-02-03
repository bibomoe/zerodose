
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
                        <div class="row match-height">
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Immunization Coverage</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- <div class="form form-horizontal"> -->
                                                <?= form_open('input/save_immunization', ['class' => 'form form-horizontal']); ?>
                                                <div class="form-body">
                                                    <div class="row">
                                                            <?php if ($this->session->flashdata('success')): ?>
                                                                <div class="alert alert-success">
                                                                    <?= $this->session->flashdata('success'); ?>
                                                                </div>
                                                            <?php endif; ?>
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
        });
    </script>
