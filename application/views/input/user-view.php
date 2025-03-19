
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
                                        <h4 class="card-title">List User</h4>
                                        <button class="btn btn-primary ms-auto floating-button bg-white border-white" type="button" style="margin-right: 20px;"
                                                data-bs-toggle="collapse" data-bs-target="#cardContent" aria-expanded="false" aria-controls="cardContent">
                                                <i class="bi bi-arrows-collapse" style="color: gray;"></i> 
                                        </button>
                                    </div>
                                    <div id="cardContent" class="collapse show">
                                        <div class="card-body">
                                            <a href="<?= base_url('user/add_user'); ?>" class="btn btn-primary">Add User</a>
                                                <p>
                                                </p>
                                            <div class="table-responsive">
                                                    <table class="table table-striped" id="table2">
                                                        <thead>
                                                            <tr>
                                                                <!-- <th>ID</th> -->
                                                                <th>Email</th>
                                                                <th>Name</th>
                                                                <th>Category</th>
                                                                <th>Province</th>
                                                                <th>City</th>
                                                                <th>Send Auto Email</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($users as $user): ?>
                                                                <tr>
                                                                    <!-- <td><?= $user->id; ?></td> -->
                                                                    <td><?= $user->email; ?></td>
                                                                    <td><?= $user->name; ?></td>
                                                                    <td><?= $user->category_name; ?></td> <!-- Nama kategori -->
                                                                    <td><?= $user->province_name; ?></td> <!-- Nama provinsi -->
                                                                    <td><?= $user->city_name; ?></td> <!-- Nama kota -->
                                                                    <td><?= $user->send_auto_email == 1 ? 'Yes' : 'No'; ?></td>
                                                                    <td>
                                                                        <?php
                                                                        // Cek ID pengguna dan pastikan ID tidak kosong
                                                                        // echo $user->id; // Cek ID pengguna yang valid

                                                                        // Enkripsi ID dan pastikan hasilnya valid
                                                                        $encrypted_id = $this->User_model->encrypt_id($user->id);
                                                                        // echo $encrypted_id; // Debugging untuk melihat hasil enkripsi
                                                                        ?>

                                                                        <a href="<?= base_url('user/update_user/'.$encrypted_id); ?>" class="btn btn-warning">Edit</a>
                                                                        <a href="<?= base_url('user/delete_user/'.$encrypted_id); ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                                                    </td>
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
                    <!-- Basic Horizontal form layout section end -->
                </div>
            </div>

        </div>
    </div>

    <script>
        // Inisialisasi DataTable hanya sekali
    let table2 = $('#table2').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        responsive: true
    });
    </script>









