
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3><?= $translations['page_title'] ?></h3>
                                <p class="text-subtitle text-muted"><?= $translations['page_subtitle'] ?>​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">District Policy and Financing</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- // Basic Horizontal form layout section end -->
                </div>
                <div class="page-content"> 
                    <section class="row">
                        <div class="col-12 col-lg-12">
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 20px;">
                                    <!-- <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body"> -->
                                            <?php
                                                // var_dump($selected_province);
                                            ?>
                                            <?= form_open('home/policy', ['method' => 'get']) ?>
                                                <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;"><?= $translations['filter_label'] ?></label>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                    <?= form_dropdown(
                                                            'year', 
                                                            [2025 => '2025', 2024 => '2024'], 
                                                            set_value('year', $selected_year ?? 2025), 
                                                            'class="form-select" style="width: 100%; max-width: 200px; height: 48px; font-size: 1rem;" required'
                                                        ); ?>
                                                    <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                        <i class="bi bi-filter"></i> Submit
                                                    </button>
                                                </div>
                                            <?= form_close() ?>
                                        <!-- </div>
                                    </div> -->
                                </div>
                            </div>

                            <style>
                                .highlight {
                                    font-size: 1.5rem;
                                    /* font-weight: 700; */
                                    /* color: #0056b3; */
                                }
                                .small-text {
                                    font-size: 1rem;
                                }
                                .card-body h6 {
                                    margin-bottom: 1rem;
                                }
                                .card-body .card-number {
                                    font-size: 1.5rem;
                                    /* font-weight: 700; */
                                    /* color: #0056b3; */
                                }
                                .card-body .card-subtext {
                                    font-size: 0.875rem;
                                    color: #6c757d;
                                }
                                .card-body .row {
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                }
                                .card-body .col-md-4 {
                                    text-align: center;
                                }
                            </style>

                            <!-- Funding Card-->
                            <div class="row">
                                <!-- Card 2024 -->
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <h6 class="text-muted font-semibold"><?= $translations['text1'] ?> 2024</h6>
                                            <div class="card-number font-extrabold mb-3">
                                                <?= number_format($district_funding_2024['total_funded_districts']); ?>
                                            </div>
                                            <div class="card-subtext mb-1">
                                                <?= $district_funding_2024['percentage_funded']; ?><?= $translations['text2'] ?>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                    style="width: <?= $district_funding_2024['percentage_funded']; ?>%;" 
                                                    aria-valuenow="<?= $district_funding_2024['percentage_funded']; ?>" 
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2025 -->
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <h6 class="text-muted font-semibold"><?= $translations['text1'] ?> 2025</h6>
                                            <div class="card-number font-extrabold mb-3">
                                                <?= number_format($district_funding_2025['total_funded_districts']); ?>
                                            </div>
                                            <div class="card-subtext mb-1">
                                                <?= $district_funding_2025['percentage_funded']; ?><?= $translations['text2'] ?>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                    style="width: <?= $district_funding_2025['percentage_funded']; ?>%;" 
                                                    aria-valuenow="<?= $district_funding_2025['percentage_funded']; ?>" 
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Policy Card -->
                            <div class="row">
                                <!-- Card 2024 -->
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <h6 class="text-muted font-semibold"><?= $translations['text3'] ?> 2024</h6>
                                            <div class="card-number font-extrabold mb-3">
                                                <?= $district_policy_2024['policy_districts']; ?>
                                            </div>
                                            <div class="card-subtext mb-1">
                                                <?= $district_policy_2024['percentage_policy']; ?> <?= $translations['text4'] ?>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                    style="width: <?= $district_policy_2024['percentage_policy']; ?>;" 
                                                    aria-valuenow="<?= $district_policy_2024['percentage_policy']; ?>" 
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card 2025 -->
                                <div class="col-12 col-lg-6 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <h6 class="text-muted font-semibold"><?= $translations['text3'] ?> 2025</h6>
                                            <div class="card-number font-extrabold mb-3">
                                                <?= $district_policy_2025['policy_districts']; ?>
                                            </div>
                                            <div class="card-subtext mb-1">
                                                <?= $district_policy_2025['percentage_policy']; ?> <?= $translations['text4'] ?>
                                            </div>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar" role="progressbar" 
                                                    style="width: <?= $district_policy_2025['percentage_policy']; ?>;" 
                                                    aria-valuenow="<?= $district_policy_2025['percentage_policy']; ?>" 
                                                    aria-valuemin="0" aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Funding -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4><?= $translations['text5'] ?></h4>
                                        </div>
                                        <!-- <div class="card-body">
                                            <div id="chart-profile-visit"></div>
                                        </div> -->
                                        <div class="card-body">
                                            <table class="table table-striped" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th><?= $translations['tabelcoloumn1'] ?></th>
                                                        <th><?= $translations['tabelcoloumn2'] ?></th>
                                                        <th><?= $translations['tabelcoloumn3'] ?></th>
                                                        <th><?= $translations['tabelcoloumn4'] ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($district_funding as $data): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($data['province_name']); ?></td>
                                                            <td><?= number_format($data['total_districts']); ?></td>
                                                            <td><?= number_format($data['funded_districts']); ?></td>
                                                            <td><?= $data['percentage_allocated']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Policy -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4><?= $translations['text6'] ?></h4>
                                        </div>
                                        <!-- <div class="card-body">
                                            <div id="chart-profile-visit"></div>
                                        </div> -->
                                        <div class="card-body">
                                            <table class="table table-striped" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th><?= $translations['tabel2coloumn1'] ?></th>
                                                        <th><?= $translations['tabel2coloumn2'] ?></th>
                                                        <th><?= $translations['tabel2coloumn3'] ?></th>
                                                        <th><?= $translations['tabel2coloumn4'] ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($district_policies)) : ?>
                                                        <?php foreach ($district_policies as $row) : ?>
                                                            <tr>
                                                                <td><?= $row['province_name']; ?></td>
                                                                <td><?= $row['total_districts']; ?></td>
                                                                <td><?= $row['policy_districts']; ?></td>
                                                                <td><?= $row['percentage']; ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="4" class="text-center">No data available</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 &copy; CHAI</p>
                    </div>
                    <!-- <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a></p>
                    </div> -->
                </div>
            </footer>
        </div>
    </div>
    
    

    <script>
            
    </script>