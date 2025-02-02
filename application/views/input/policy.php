
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>District Policy and Financing</h3>
                                <!-- <p class="text-subtitle text-muted">Children will lose their opportunity this year/ has lost their opportunity​</p> -->
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

                </div>
                <div class="page-content"> 
                    <!-- Basic Horizontal form layout section start -->
                    <section id="basic-horizontal-layouts">
                        <div class="row match-height">
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Number of district allocated domestic funding for key immunization activities and other relevant activities to support immunization program at 10 provinces</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="provinceInput3">Select Province</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="provinceInput3" name="provinceInput3" class="form-select">
                                                                <option selected>East Java</option>
                                                                <option>DKI Jakarta</option>
                                                                <option>West Java</option>
                                                                <option>Central Java</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="districtInput3">Select District</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="districtInput3" name="districtInput3" class="form-select">
                                                                <option selected>Kota Jember</option>
                                                                <option>Kab. Malang</option>
                                                                <option>Kota Malang</option>
                                                                <option>Kab. Kediri</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="totalBudgetInput">Total Regional Budget (APBD)</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="totalBudgetInput" class="form-control" name="totalBudgetInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="healthAllocationInput">Allocation for Health Programs</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="healthAllocationInput" class="form-control" name="healthAllocationInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="p2pAllocationInput">Allocation for Disease Prevention and Control (P2P)</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="p2pAllocationInput" class="form-control" name="p2pAllocationInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="immunizationAllocationInput">Allocation for Immunization Programs</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="immunizationAllocationInput" class="form-control" name="immunizationAllocationInput" min="0"
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
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Number of district developed or enacted policy relevant to targeting for immunization program in general</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="provinceInput4">Select Province</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="provinceInput4" name="provinceInput4" class="form-select">
                                                                <option selected>East Java</option>
                                                                <option>DKI Jakarta</option>
                                                                <option>West Java</option>
                                                                <option>Central Java</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="districtInput4">Select District</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="districtInput4" name="districtInput4" class="form-select">
                                                                <option selected>Kota Jember</option>
                                                                <option>Kab. Malang</option>
                                                                <option>Kota Malang</option>
                                                                <option>Kab. Kediri</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="availabilityInput">Availability</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="availabilityInput" name="availabilityInput" class="form-select">
                                                                <option selected>Yes</option>
                                                                <option>No</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="linkInput">Link to Access the Policy</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="linkInput" class="form-control" name="linkInput"
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