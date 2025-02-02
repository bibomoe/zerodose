
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Lost Children</h3>
                                <p class="text-subtitle text-muted">Children will lose their opportunity this year/ has lost their opportunity​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Lost Children</li>
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
                                        <h4 class="card-title">Total Lost Children</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-4">
                                                            <label for="totalInput">Total Lost Children</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="totalInput" class="form-control" name="totalInput" min="0"
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
                                        <h4 class="card-title">District with the highest number of children at risk or already lost.</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
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
                                                            <label for="totalZDInput">Total Lost</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="totalZDInput" class="form-control" name="totalZDInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="percentageInput">% of Total Target</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="percentageInput" class="form-control" name="percentageInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="targetInput">Per 100.000 targets</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="targetInput" class="form-control" name="targetInput" min="0"
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