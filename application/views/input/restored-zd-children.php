
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Restored ZD Children</h3>
                                <p class="text-subtitle text-muted">Vaccine coverage in targeted areas​​​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Restored ZD Children</li>
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
                                        <h4 class="card-title">Total Restored / Coverage</h4>
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
                                                                <option selected>DPT1</option>
                                                                <option>DPT3</option>
                                                                <option>MR2</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="groupAInput">Total Group A</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="groupAInput" class="form-control" name="groupAInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="groupBInput">Total Group B</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="groupBInput" class="form-control" name="groupBInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="groupCInput">Total Group C</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="groupCInput" class="form-control" name="groupCInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="totalCasesInput">Total Cases</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="totalCasesInput" class="form-control" name="totalCasesInput" min="0"
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
                                        <h4 class="card-title">District with the highest number of restored children</h4>
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
                                                            <label for="totalZDInput">Total Restored</label>
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
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Zero-Dose Cases</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="groupInput">Select Group</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <select id="groupInput" name="groupInput" class="form-select">
                                                                <option selected>Group A</option>
                                                                <option>Group B</option>
                                                                <option>Group C</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="totalZdInput">Total ZD Cases</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="totalZdInput" class="form-control" name="totalZdInput" min="0"
                                                                placeholder="">
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
                                        <h4 class="card-title">Number of Restored Children by Gender</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="numberMaleInput">Male Children Count</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="numberMaleInput" class="form-control" name="numberMaleInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="numberFemaleInput">Female Children Count</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="numberFemaleInput" class="form-control" name="numberFemaleInput" min="0"
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
                                        <h4 class="card-title">Number of Restored Children by Place of Residence</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="ruralInput">Children Count in Rural Areas</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="ruralInput" class="form-control" name="ruralInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="urbanInput">Children Count in Urban Areas</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="urbanInput" class="form-control" name="urbanInput" min="0"
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
                                        <h4 class="card-title">Number of Restored Children by Group Age</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label for="groupAcountInput">Aged 3-11 Months</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="groupAcountInput" class="form-control" name="groupAcountInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="groupBcountInput">Aged 12-23 Months</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="groupBcountInput" class="form-control" name="groupBcountInput" min="0"
                                                                placeholder="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="groupCcountInput">Aged 24-59 Months</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" id="groupCcountInput" class="form-control" name="groupCcountInput" min="0"
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