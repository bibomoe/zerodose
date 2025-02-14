
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
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
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
                                                    <button id="btn_filter" class="btn btn-secondary">Apply Filter</button>
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
                        <div class="row match-height">
                            <div class="col-md-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Stock Out at Health Facilities</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <!-- <div class="form form-horizontal"> -->
                                                <?= form_open('input/save_stock_out', ['class' => 'form form-horizontal']); ?>
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4"><?= form_label('Select Province', 'province_id'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('province_id', $province_options, '', 'class="form-select" id="province_id2"'); ?></div>

                                                        <div class="col-md-4"><?= form_label('Select District', 'city_id'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('city_id', ['' => '-- Select City --'], '', 'class="form-select" id="city_id2"'); ?></div>

                                                        <div class="col-md-4"><?= form_label('Select Year', 'year'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('year', $year_options, '', 'class="form-select" id="year"'); ?></div>

                                                        <div class="col-md-4"><?= form_label('Select Month', 'month'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('month', $month_options, '', 'class="form-select" id="month"'); ?></div>

                                                        <div class="col-md-4"><?= form_label('Vaccine Type', 'vaccine_type'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_dropdown('vaccine_type', ['DPT' => 'DPT'], '', 'class="form-select" id="vaccine_type"'); ?></div>

                                                        <div class="col-md-4"><?= form_label('Stock Out 1 Month', 'stock_out_1_month'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'stock_out_1_month', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                        <div class="col-md-4"><?= form_label('Stock Out 2 Months', 'stock_out_2_months'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'stock_out_2_months', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                        <div class="col-md-4"><?= form_label('Stock Out 3 Months', 'stock_out_3_months'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'stock_out_3_months', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

                                                        <div class="col-md-4"><?= form_label('Stock Out 3+ Months', 'stock_out_more_than_3_months'); ?></div>
                                                        <div class="col-md-8 form-group"><?= form_input(['name' => 'stock_out_more_than_3_months', 'type' => 'number', 'class' => 'form-control', 'min' => 0]); ?></div>

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
                                                        <label for="filter_province2">Filter By Province</label>
                                                        <!-- <select id="filter_province" class="form-select">
                                                            <option value="">-- Select Province --</option>
                                                            <?php foreach ($provinces as $province): ?>
                                                                <option value="<?= $province['id'] ?>"><?= $province['name_id'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select> -->
                                                        <?= form_dropdown('filter_province2', $province_options, '', 'class="form-select" id="filter_province2"'); ?>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label for="filter_city2">Filter By District</label>
                                                        <select id="filter_city2" class="form-select">
                                                            <option value="">-- Select City --</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="filter_year2">Filter By Year</label>
                                                        <select id="filter_year2" class="form-select">
                                                            <option value="">-- Select Year --</option>
                                                            <option value="2024">2024</option>
                                                            <option value="2025">2025</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label for="filter_month2">Filter By Month</label>
                                                        <select id="filter_month2" class="form-select">
                                                            <option value="">-- Select Month --</option>
                                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                                <option value="<?= $i ?>"><?= date('F', mktime(0, 0, 0, $i, 1)) ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                                                            value="<?= $this->security->get_csrf_hash(); ?>">

                                                    <div class="col-md-2 d-flex align-items-end">
                                                        <button id="btn_filter2" class="btn btn-secondary">Apply Filter</button>
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
                                                                    <th>Year</th>
                                                                    <th>Month</th>
                                                                    <th>Vaccine Type</th>
                                                                    <th>Stock Out 1 Month</th>
                                                                    <th>Stock Out 2 Months</th>
                                                                    <th>Stock Out 3 Months</th>
                                                                    <th>Stock Out 3+ Months</th>
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
        let year = $("#filter_year2").val();
        let month = $("#filter_month2").val();
        // alert(city);

        $.ajax({
            url: "<?= base_url('input/get_stock_out_data') ?>",  // Ganti dengan URL yang sesuai untuk mendapatkan data stock out
            type: "GET",
            data: {
                province_id: province,
                city_id: city,
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
                    let rows = [];
                    data.forEach(row => {
                        rows.push([
                            row.province_name,
                            row.city_name,
                            row.year,
                            new Date(row.month).toLocaleString('en-us', { month: 'long' }),
                            row.vaccine_type,
                            row.stock_out_1_month,
                            row.stock_out_2_months,
                            row.stock_out_3_months,
                            row.stock_out_more_than_3_months,
                            `<button class="btn btn-danger btn-sm delete-btn-stock-out" data-id="${row.id}" onclick="deleteStockOutData(this)">Delete</button>`
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
        // let city = $("#filter_city2").val();
        // console.log(city);

        // Check if Province and City are selected
        if (!province) {
            alert("Please select a Province.");
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




