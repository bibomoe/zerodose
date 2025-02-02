
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
                                        <li class="breadcrumb-item active" aria-current="page">Number of private health facilities in targeted areas</li>
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
                                        <h4 class="card-title">Private Health Facilities</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="codeInput">Code</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="codeInput" class="form-control" name="codeInput"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="nameInput">Name</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="nameInput" class="form-control" name="nameInput"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="provinceInput">Select Province</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="provinceInput" name="provinceInput" class="form-select">
                                                                <option selected>East Java</option>
                                                                <option>DKI Jakarta</option>
                                                                <option>West Java</option>
                                                                <option>Central Java</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="districtInput">Select District</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="districtInput" name="districtInput" class="form-select">
                                                                <option selected>Kota Jember</option>
                                                                <option>Kab. Malang</option>
                                                                <option>Kota Malang</option>
                                                                <option>Kab. Kediri</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="addressInput">Address</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <textarea class="form-control" id="addressInput" name="addressInput" rows="3"></textarea>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="typeTreatmentInput">Types of Treatment</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="typeTreatmentInput" name="typeTreatmentInput" class="form-select">
                                                                <option selected>Puskesmas Non Perawatan</option>
                                                                <option>Puskesmas Perawatan (Rawat Jalan)</option>
                                                                <option>Puskesmas Perawatan (Rawat Inap)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="areaCharacteristicsInput">Area Characteristics</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="areaCharacteristicsInput" name="areaCharacteristicsInput" class="form-select">
                                                                <option selected>Perkotaan</option>
                                                                <option>Pedesaan</option>
                                                                <option>Terpencil</option>
                                                                <option>Sangat Terpencil</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="latitudeInput">Latitude</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="latitudeInput" class="form-control" name="latitudeInput"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="longitudeInput">Longitude</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="longitudeInput" class="form-control" name="longitudeInput"
                                                                placeholder="">
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
                    </section>
                    <!-- Basic Horizontal form layout section end -->
                </div>
            </div>

        </div>
    </div>
    
    

    <script>
    </script>