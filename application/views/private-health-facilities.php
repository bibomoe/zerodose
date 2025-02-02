
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Number of private health facilities in targeted areas​</h3>
                                <p class="text-subtitle text-muted">​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Number of private health facilities in targeted areas​</li>
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
                                <!-- <div class="col-12"> -->
                                <div class="col-6 col-lg-6 col-md-6">
                                    <div class="card">
                                        <!-- <div class="card-header"></div> -->
                                        <div class="card-body">
                                            <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;">Province</label>
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                <select id="provinceFilter" class="form-select" style="width: 100%; max-width: 300px; height: 48px; font-size: 1rem;">
                                                    <option value="" disabled >Select Province</option>
                                                    <option selected>East Java</option>
                                                    <option>Jakarta</option>
                                                    <option>West Java</option>
                                                </select>
                                                <button type="submit" class="btn btn-primary" style="height: 48px; font-size: 1rem; padding: 0 20px;">
                                                    <i class="bi bi-filter"></i> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-6 col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                    Total Private Health Facilities in East Java</h6>
                                                    <h6 class="font-extrabold mb-0">50.000</h6>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div> -->
                            </div>


                            <div class="row">
                                <div class="col-6 col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldUser1"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">
                                                    Total Private Health Facilities</h6>
                                                    <h6 class="font-extrabold mb-0">800</h6>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 col-md-6">
                                    <div class="card"> 
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon blue mb-2">
                                                        <i class="iconly-boldProfile"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Total Private Health Facilities Conducting Immunization</h6>
                                                    <h6 class="font-extrabold mb-0">650</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon green mb-2">
                                                        <i class="iconly-boldProfile"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <h6 class="text-muted font-semibold">Total Private Health Facilities Not Conducting Immunization</h6>
                                                    <h6 class="font-extrabold mb-0">15.000</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>List of Private Health Facilities</h4>
                                        </div>
                                        <!-- <div class="card-body">
                                            <div id="chart-profile-visit"></div>
                                        </div> -->
                                        <div class="card-body">
                                            <table class="table table-striped" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th>Private Health Facilities Name</th>
                                                        <th>Province</th>
                                                        <th>District</th>
                                                        <th>Address</th>
                                                        <th>Conducting Immunization</th>
                                                        <!-- <th>Area Characteristics</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Klinik Mawar</td>
                                                    <td>Jawa Timur</td>
                                                    <td>Kab. Sampang</td>
                                                    <td>Jl.Raya Karang Penang, Kec. Karang Penang</td>
                                                    <td>Ya</td>
                                                    <!-- <td>Perdesaan</td> -->
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Private Health Facilities mapping</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="googlemaps">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d107.57311654129782!3d-6.903273917028756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1633023222539!5m2!1sen!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
    
    

    <script>
        
    </script>