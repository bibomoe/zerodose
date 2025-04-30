
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>User Management</h3>
                                <!-- <p class="text-subtitle text-muted">Vaccine coverage in targeted areas​​​</p> -->
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">User Management</li>
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
                                        <h4 class="card-title">Add User</h4>
                                        <button class="btn btn-primary ms-auto floating-button bg-white border-white" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent" aria-expanded="false" aria-controls="cardContent">
                                                <i class="bi bi-arrows-collapse" style="color: gray;"></i> 
                                        </button>
                                    </div>
                                    <div id="cardContent" class="collapse show">
                                        <div class="card-body">
                                            <!-- <div class="form form-horizontal"> -->
                                                <?= form_open('user/add_user', ['class' => 'form form-horizontal']); ?>
                                                <div class="form-body">
                                                    <div class="row">
                                                            
                                                        <div class="form-group">
                                                            <?= form_label('Email', 'email'); ?>
                                                            <?= form_input('email', '', 'class="form-control" required'); ?>
                                                        </div>

                                                        <div class="form-group">
                                                            <?= form_label('Password', 'password'); ?>
                                                            <?= form_password('password', '', 'class="form-control" required'); ?>
                                                        </div>

                                                        <div class="form-group">
                                                            <?= form_label('Name', 'name'); ?>
                                                            <?= form_input('name', '', 'class="form-control" required'); ?>
                                                        </div>

                                                        <?php
                                                            $user_category = $this->session->userdata('user_category'); // Ambil kategori pengguna yang login

                                                            if($user_category == 1){
                                                                $category_value = 7;
                                                            } else if($user_category == 7){
                                                                $category_value = 8;
                                                            } else {
                                                                $category_value = '';
                                                            }

                                                            // var_dump($category_value);
                                                        ?>

                                                        <div class="form-group">
                                                            <?= form_label('Category', 'category'); ?>
                                                            <?= form_dropdown('category', $category_options , $category_value, 'class="form-control" id="category"'); ?>
                                                        </div>

                                                        <!-- Dropdown untuk send_auto_email (Yes/No) -->
                                                        <div class="form-group">
                                                            <?= form_label('Send Auto Email?', 'send_auto_email'); ?>
                                                            <?= form_dropdown('send_auto_email', [1 => 'Yes', 0 => 'No'], '', 'class="form-control"'); ?>
                                                        </div>

                                                        <!-- Dropdown untuk memilih province dan city (untuk kategori 7 dan 8) -->
                                                        <div id="province-city-group" style="display: <?= ($category_value == 7 || $category_value == 8) ? 'block' : 'none'; ?>;">
                                                            <?php
                                                                if($user_category != 7){
                                                            ?>
                                                                <?= form_label('Province', 'province_id'); ?>
                                                                <?= form_dropdown('province_id', $province_options, '', 'class="form-control" id="province_id"'); ?>
                                                            <?php
                                                                } else {
                                                            ?>
                                                                <?= form_label('Province', 'province_idx'); ?>
                                                                <?= form_dropdown('province_idx', $province_options, $user_province, 'class="form-control" id="province_idx" disabled'); ?>
                                                                <input type="hidden" id="province_id" name="province_id" value="<?=$user_province;?>">
                                                            <?php
                                                                }
                                                            ?>
                                                            <?= form_label('City', 'city_id'); ?>
                                                            <?= form_dropdown('city_id', [], '', 'class="form-control" id="city_id"'); ?>
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
                    <!-- Basic Horizontal form layout section end -->
                </div>
            </div>

        </div>
    </div>
    
    

    <script>
        $(document).ready(function () {

            var category = $('#category').val();
            // alert(category);
            if (category == 8) {
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
                            $.each(data, function (key, value) {
                                $('#city_id').append('<option value="' + value.id + '">' + value.name_id + '</option>');
                            });
                        }
                    });
                }
            });

            // Menampilkan dropdown provinsi dan kota jika kategori adalah PHO atau DHO
            $('#category').change(function() {
                var category = $(this).val();
                if (category == 7 || category == 8) {
                    $('#province-city-group').show();
                } else {
                    $('#province-city-group').hide();
                }
            });
        });
    </script>









