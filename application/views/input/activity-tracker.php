
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
                                                        [2025 => '2025', 2024 => '2024'], 
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
                                                                
                                                                <table class="table table-striped" >
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 5%;">Activity Code</th>
                                                                            <th style="width: 60%;">Description</th>
                                                                            <th >Number of Activities</th>
                                                                            <th>Total Budget (IDR)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <!-- <tbody>
                                                                        <tr>
                                                                            <td>(1.1)</td>
                                                                            <td>Improve the accuracy of annual projection for vaccines and logistics by providing training for provincial and districts health officials. The projection will be generated through SMILE with target population as the input for projecting all antigents and related logistics needed at all levels, including Primary Health Care. Moreover, the data will be integrated to the procurement requests form in Directorate General of Medicine and Health Supplies (limit human error)</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.2)</td>
                                                                            <td>Strengthen immunization service delivery at private sectors (capacity building for vaccinators and logistic officers in the private sectors), and post training monitoring.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.3)</td>
                                                                            <td>Providing technical assistance on identifying zero dose children, increasing community demand, and removing barriers at selected provinces.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.4)</td>
                                                                            <td>Implement supportive supervision in selected provinces.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.5)</td>
                                                                            <td>Develop and implement post training monitoring and formulate recommendation to maintain health workers capacity in both public and private sectors.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.6)</td>
                                                                            <td>Providing technical assistance maintain skills and competencies of vaccine logistics managers all health facilities in 10 provinces (5,822 puskesmas) in updating and utilizing SMILE application for better planning and visibility of inventory at national and sub-national level</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.7)</td>
                                                                            <td>Engage health institutions and professional organizations to strengthen curricula on safe immunization delivery.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.8)</td>
                                                                            <td>Workshop on safe injection and multiple injections in selected provinces.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.9)</td>
                                                                            <td>Roll-out of SMILE for routine immunization to be ready for use at the national level, and to support the supply-chain management during catch-up immunization program by enhancing its scalability, functions, performance and security. The enhancement include integration between SMILE and individual registry application (ASIK), IHS (information health system/dashboard) and also other information systems, as well as the process of handing over SMILE from UNDP to the MoH</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.10)</td>
                                                                            <td>Rapid convenience assessment of complete routine immunization in selected areas.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.11)</td>
                                                                            <td>Improving data management and linkage in and between public and private providers for RI; towards better data visibility for accurate zero dose identification and targeting in selected provinces.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.12)</td>
                                                                            <td>Strengthen routine data review, monitoring and coordination of RI services in select provinces/districts through involvement of private facilities (MOH, UNICEF, CHAI).</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.13)</td>
                                                                            <td>Tailoring and specifying service delivery plans and strategy following data review and program monitoring, to increase effectiveness of RI service delivery at district and PHC level, towards reaching ZD by including strengthening public private partnership model.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.14)</td>
                                                                            <td>Adapt service delivery plans and strategy following data review and program monitoring, to continuously improve access and utilization to RI services at district and PHC level.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(1.15)</td>
                                                                            <td>Develop a full scope of work on country guidelines, assessment and development of real-time dashboard on cold-chain capacity at health facility, also to develop a temperature data dashboard where the data will be transmitted regularly from 5,000 cold-chain points.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.1)</td>
                                                                            <td>Develop individual electronic immunization registry and implementation roadmap.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.2)</td>
                                                                            <td>Disseminate and develop one health dashboard particularly on logistics of vaccines, medicines, health supplies for public consumption.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.3)</td>
                                                                            <td>Disseminate electronic immunization registry at public and private health facility.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.4)</td>
                                                                            <td>Coordinate with Civil Registry, Ministry of Home Affairs and other cross ministries on denominator data validation.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.5)</td>
                                                                            <td>Review the functionality, security and performance of electronic immunization logistic registry.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.6)</td>
                                                                            <td>Larger scale of cost-benefit analysis on digitalization of immunization program conducted through the development of guidelines, enhance & update e-learning platform, video tutorials, and attending 15 day international workshop.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.7)</td>
                                                                            <td>Leverage use of GIS and data triangulation analysis from Maternal and Child Health, Vaccine Preventable Diseases (VPD) surveillance, and other programs to map underserved areas in select province/districts.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.8)</td>
                                                                            <td>Characterize, categorize and prioritize catchment areas based on a mix of core indicators performance in province level.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.9)</td>
                                                                            <td>Identify specific barriers (gender-, demand-, and supply-related) to access and utilization of RI services in prioritized districts and facilities, by leveraging Human Centered Design, a creative approach for innovative solution.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.10)</td>
                                                                            <td>Regular feedback on zero dose analysis at national and subnational level, including data triangulation with VPD surveillance.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.11)</td>
                                                                            <td>Engage local government leaders and relevant units in developing and updating microplanning (MOH, UNICEF).</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.12)</td>
                                                                            <td>Engage professional organization and health institution to allocate/distribute additional human resources to reach hard to reach area.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.13)</td>
                                                                            <td>Engage with Ministry of Transportation, Army, Police and other relevant stakeholders to assist in vaccine and logistic distribution, also service delivery.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(2.14)</td>
                                                                            <td>Resource mobilization from private sectors for implementing SOS.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.1)</td>
                                                                            <td>Conduct vaccine acceptance study on routine immunization using BeSD approach at selected district/province.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.2)</td>
                                                                            <td>Develop national communication strategy, including innovative communication intervention in reaching hard to reach communities.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.3)</td>
                                                                            <td>Online quarterly survey regarding community demand on routine immunization.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.4)</td>
                                                                            <td>Empowerment of CSO to increase community demand on routine immunization at grass root level.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.5)</td>
                                                                            <td>Refreshing media communication group to support boosting community confidence in vaccine safety.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.6)</td>
                                                                            <td>Facilitate coordination/advocacy meeting with existing community structures across health programs and sectors to increase public participation in outreach activities and/or other adapted service delivery approach.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.7)</td>
                                                                            <td>Promote targeted engagements between health facility and local community, including community leaders, civil society organizations, specific groups to reinforce community demand and participation in outreach activities.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.8)</td>
                                                                            <td>Establish Private Health Sector Task Force for immunization.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(3.9)</td>
                                                                            <td>Strengthen public-private partnership with variety of potential private providers (e.g. midwives, private clinics).</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(4.1)</td>
                                                                            <td>Regular coordination and review meeting on availability of vaccine and logistics at national and subnational level.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(4.2)</td>
                                                                            <td>Data review meeting on vaccine logistics at subnational level to ensure stock availability and reduce ZD occurrence due to stock-out.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(4.3)</td>
                                                                            <td>Develop, refine and disseminate plans, tools and technical guidelines for action, on cold chain inventory to ensure review meetings are acted upon.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(4.4)</td>
                                                                            <td>Develop a performance monitoring web-based dashboard with clear process and tools to track implementation of zero-dose strategy and provide feedback to the implementation team.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(4.5)</td>
                                                                            <td>Improves the overall efficiency of vaccine distribution to maintain optimal stock at all levels through real-time and accountable monitoring tools combined with joint-routine spot-check (MoH/Inspectorate General, EPI, and Provincial Health Office).</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(5.1)</td>
                                                                            <td>Increase national and subnational government commitment on immunization program based on findings and recommendation of GAVI (Post) Transition Risk Assessment (GTRA).</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(5.2)</td>
                                                                            <td>Assess existing flow of funds for immunization programs and identify resources (public & private sector) including the bottlenecks for service delivery (tracking budget allocation and immunization spending) at district and PHC levels.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(5.3)</td>
                                                                            <td>Develop strategic planning from both public & private sector (human and capital) to support zero dose strategy and broader routine immunization programs to ensure sustainability post MICs funding.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(5.4)</td>
                                                                            <td>Develop strategic costed planning at PHC level on targeting zero dose and restore RI to ensure sustainability post MICs funding.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(5.5)</td>
                                                                            <td>Advocate budget allocation to support access and increase targeted immunization coverage (Coordinate with relevant units, programs, and ministries to act on findings and lessons learned from the immunization financing activities).</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(6.1)</td>
                                                                            <td>Package and leverage lessons learned from implementation at select provinces, districts, and facilities for advocacy towards sustainability and scalability.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>(6.2)</td>
                                                                            <td>Workshops and technical assistance to facilitate and coordinate advocacy efforts to local government at selected provinces and districts aiming for local policy development and budget allocation to reduce zero dose children.</td>
                                                                            <td>
                                                                                <input type="number" id="totalNumberInput" class="form-control" name="totalNumberInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                                    placeholder="" value="0">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody> -->
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
                                                                                    <input type="number" name="activities[<?= $activity['id'] ?>][budget]" class="form-control"
                                                                                        value="<?= $activity['total_budget'] ?>"  min="0">
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
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
    </script>