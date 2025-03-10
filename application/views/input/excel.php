
<div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Input Data from Excel Template</h3>
                                <p class="text-subtitle text-muted">​</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Input Excel</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="page-content"> 
                    <!-- Basic Horizontal form layout section start -->
                    <section id="basic-horizontal-layouts">
                        <!-- Display success or error messages -->
                        <?php if($this->session->flashdata('success')): ?>
                            <div style="color: green;"><?php echo $this->session->flashdata('success'); ?></div>
                        <?php endif; ?>

                        <?php if($this->session->flashdata('error')): ?>
                            <div style="color: red;"><?php echo $this->session->flashdata('error'); ?></div>
                        <?php endif; ?>

                        <div class="row match-height">
                            <div class="col-md-8 col-12">
                                <div class="card">
                                    <!-- <div class="card-header">
                                        <h4 class="card-title">Input Excel</h4>
                                    </div> -->
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <?= form_open('input/import', ['class' => 'form form-horizontal', 'enctype' => 'multipart/form-data']); ?>
                                                        <!-- <div class="form-body"> -->
                                                            <div class="col-md-4">
                                                                <label for="formFile">Choose Excel File to Import:</label>
                                                            </div>
                                                            <div class="col-md-8 form-group">
                                                                <input class="form-control" type="file" name="excel_file" id="formFile">
                                                            </div>
                                                            <div class="col-sm-12 d-flex justify-content-end">
                                                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                                            </div>
                                                        <!-- </div> -->
                                                        <?= form_close(); ?>

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