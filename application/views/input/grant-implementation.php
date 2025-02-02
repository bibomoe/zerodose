
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Grants Implementation and Budget Disbursement</h3>
                                <p class="text-subtitle text-muted">
                                Number and percentage of costed work plan activities completed, along with the budget execution rate (%) and amount ($) by activity in targeted provinces/districts.​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Grants Implementation and Budget Disbursement</li>
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
                                        <h4 class="card-title">Total Budget</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="partnersInput">Gavi MICs Partners/implementers </label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="partnersInput" name="partnersInput" class="form-select">
                                                                <option selected>Ministry of Health Indonesia</option>
                                                                <option>CHAI</option>
                                                                <option>WHO</option>
                                                                <option>UNICEF</option>
                                                                <option>UNDP</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="totalBudgetInput">Total Budget</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="totalBudgetInput" class="form-control" name="totalBudgetInput"
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
                                        <h4 class="card-title">Budget Absorption</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="partnersInput">Gavi MICs Partners/ implementers </label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="partnersInput" name="partnersInput" class="form-select">
                                                                <option selected>Ministry of Health Indonesia</option>
                                                                <option>CHAI</option>
                                                                <option>WHO</option>
                                                                <option>UNICEF</option>
                                                                <option>UNDP</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="yearInput">Year</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="yearInput" class="form-control" name="yearInput" min="2024"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="monthInput">Select Month</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="monthInput" name="monthInput" class="form-select">
                                                                <option selected>January</option>
                                                                <option>February</option>
                                                                <option>March</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="cumulativeBudgetInput">Cumulative Budget</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="cumulativeBudgetInput" class="form-control" name="cumulativeBudgetInput"
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
                                        <h4 class="card-title">Number of activities conducted</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="partnersInput">Gavi MICs Partners/ implementers </label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="partnersInput" name="partnersInput" class="form-select">
                                                                <option selected>Ministry of Health Indonesia</option>
                                                                <option>CHAI</option>
                                                                <option>WHO</option>
                                                                <option>UNICEF</option>
                                                                <option>UNDP</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="activityInput">Activity</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="activityInput" name="activityInput" class="form-select">
                                                                <option selected>NVI</option>
                                                                <option>ZD</option>
                                                                <option>MSC</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="deliveredActivityInput">Number of Activities Delivered</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="deliveredActivityInput" class="form-control" name="deliveredActivityInput"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="totalActivityInput">Total Activities</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="totalActivityInput" class="form-control" name="totalActivityInput"
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