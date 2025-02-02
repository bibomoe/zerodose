
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Number of DTP Stock Out at Health Facilities</h3>
                                <p class="text-subtitle text-muted">Vaccine Availability</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Number of DTP Stock Out at Health Facilities</li>
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
                                        <h4 class="card-title">Month of Stock for Each Vaccine</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="vaccineTypeInput">Type of Vaccine</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="vaccineTypeInput" name="vaccineTypeInput" class="form-select">
                                                                <option selected>HBO</option>
                                                                <option>BCG</option>
                                                                <option>DPT</option>
                                                                <option>MR</option>
                                                                <option>PCV</option>
                                                                <option>RV</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="stockInput">Month of Stock</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="stockInput" class="form-control" name="stockInput" min="0"
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
                                        <h4 class="card-title">Number of Health Facilities with Vaccine Stockout</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="vaccineTypeInput2">Type of Vaccine</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="vaccineTypeInput2" name="vaccineTypeInput2" class="form-select">
                                                                <option selected>HBO</option>
                                                                <option>BCG</option>
                                                                <option>DPT</option>
                                                                <option>MR</option>
                                                                <option>PCV</option>
                                                                <option>RV</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="totalFacilitesInput">Number of Facilities</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="totalFacilitesInput" class="form-control" name="totalFacilitesInput" min="0"
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