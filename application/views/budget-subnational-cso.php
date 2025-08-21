
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
                                        <li class="breadcrumb-item active" aria-current="page">Budget Disbursement National & Sub-National (CSO)</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- // Basic Horizontal form layout section end -->
                </div>
                <div class="page-content"> 
                    <section class="row">
                        <!-- <div class="col-12 col-lg-12">
                            
                        </div> -->

                            <!-- Filter -->
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 20px;">
                                    <!-- <div class="card">
                                        <div class="card-header"></div>
                                        <div class="card-body"> -->
                                            <?php
                                                // var_dump($selected_province);
                                            ?>
                                            <?= form_open('home/budget_subnational_cso', ['method'=>'get']) ?>
                                                <label for="provinceFilter" class="form-label" style="font-size: 1.2rem; font-weight: bold;"><?= $translations['filter_label'] ?>​</label>
                                                <div class="d-flex flex-column flex-md-row align-items-center gap-2">
                                                
                                                <?= form_dropdown('year', [2025=>'2025', 2026=>'2026'],
                                                    $selected_year, 'class="form-select" style="max-width:120px;height:40px"'); ?>
                                                <button class="btn btn-primary" style="height:40px">Submit</button>
                                            </div>
                                            <?= form_close() ?>
                                        <!-- </div>
                                    </div> -->
                                </div>
                            </div>

                        <!-- Graphic for Budget Disbursement -->
                        <div class="row">
                            <!-- Grafik Bar Budget per Objective -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Budget Sub-National CSO Disbursement</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="chartWrapper" class="d-flex justify-content-center">
                                                <canvas id="csoChart" style="height:460px;width:100%"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                            <!-- table -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4></h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <?php
                                                    // summary per CSO dari data grafik (allocation, total realization, percentage)
                                                    $summaryMap = [];
                                                    foreach ($chart_data as $s) {
                                                        $summaryMap[$s['cso_id']] = $s;
                                                    }

                                                    // hitung jumlah baris per CSO untuk rowspan
                                                    // $rowCountByCso = [];
                                                    // foreach ($table_data as $r) {
                                                    //     $rowCountByCso[$r['cso_id']] = ($rowCountByCso[$r['cso_id']] ?? 0) + 1;
                                                    // }

                                                    function rupiah($v){ return 'Rp '.number_format((float)$v,0,',','.'); }
                                                ?>

                                                <table class="table table-striped" id="table2">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:60px">No</th>
                                                            <th style="width:18%">Kegiatan (CSO)</th>
                                                            <th style="width:24%">Wilayah</th>
                                                            <th style="width:10%">Volume</th>
                                                            <th style="width:12%">Biaya</th>
                                                            <th style="width:12%">Serapan (Provinsi)</th>
                                                            <th style="width:12%">Serapan (Total CSO)</th>
                                                            <th style="width:6%">%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        foreach ($table_data as $r):
                                                            $csoId = $r['cso_id'];
                                                            $sum = $summaryMap[$csoId] ?? ['allocation'=>0,'realization'=>0,'percentage'=>0];
                                                        ?>
                                                        <tr>
                                                            <td><?= $no++ ?></td>
                                                            <td><?= $r['cso_name'] ?></td>
                                                            <td><?= $r['province_name'] ?: '-' ?></td>
                                                            <td><?= $r['volume'] ?: '-' ?></td>
                                                            <td style="text-align:right"><?= rupiah($r['allocation']) ?></td>
                                                            <td style="text-align:right"><?= rupiah($r['realization']) ?></td>
                                                            <td style="text-align:right"><?= rupiah($sum['realization']) ?></td>
                                                            <td style="text-align:center"><?= (int)$sum['percentage'] ?>%</td>
                                                        </tr>
                                                        <?php endforeach; ?>

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
                </div>
            </footer>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

<script>
Chart.register(ChartDataLabels);
const rows   = <?= json_encode($chart_data); ?>; // per CSO
const labels = rows.map(r => r.name);
const alloc  = rows.map(r => +r.allocation);
const real   = rows.map(r => +r.realization);
const pct    = rows.map(r => +r.percentage);

new Chart(document.getElementById('csoChart').getContext('2d'), {
  type:'bar',
  data:{ labels,
    datasets:[
      {label:'Alokasi', data:alloc, backgroundColor:'rgba(0,86,179,0.85)', borderColor:'rgba(0,86,179,1)', yAxisID:'y'},
      {label:'Serapan', data:real,  backgroundColor:'rgba(135,206,235,0.75)', borderColor:'rgba(135,206,235,1)', yAxisID:'y'},
      {type:'scatter', label:'%', data:pct.map((v,i)=>({x:i,y:v})),
        backgroundColor:'orange', borderColor:'orange', pointRadius:3, yAxisID:'y1',
        datalabels:{display:true,anchor:'end',align:'top',formatter:(v)=>v.y>0? v.y+'%':'',color:'orange',font:{weight:'bold',size:9},offset:6}}
    ]},
  options:{
    responsive:true, maintainAspectRatio:false,
    plugins:{ legend:{position:'top'}, datalabels:{display:false},
      tooltip:{callbacks:{label:(ctx)=>ctx.dataset.type==='scatter'? `%: ${ctx.raw.y}%` : `${ctx.dataset.label}: Rp ${ctx.raw.toLocaleString('id-ID')}`}}},
    scales:{ x:{ticks:{autoSkip:false,maxRotation:45,minRotation:45}},
      y:{beginAtZero:true,title:{display:true,text:'Rupiah'},ticks:{callback:(v)=>'Rp '+Number(v).toLocaleString('id-ID')}},
      y1:{beginAtZero:true,max:100,position:'right',grid:{drawOnChartArea:false},title:{display:true,text:'Persentase'}}}
  },
  plugins:[ChartDataLabels]
});
</script>

<!-- Buttons HTML5 untuk export CSV & Excel -->
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function () {
    var table = $('#table2').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csvHtml5',
                text: 'Download CSV',
                className: 'btn btn-primary btn-sm'
            },
            {
                extend: 'excelHtml5',
                text: 'Download Excel',
                className: 'btn btn-success btn-sm'
            }
        ]
    });

    // Fungsi untuk update jumlah baris yang tampil
    function updateRowCount() {
        // api.rows({ filter: 'applied' }) -> baris yg sudah difilter (search)
        var count = table.rows({ filter: 'applied' }).count();
        $('#rowCount').text('Jumlah baris yang tampil: ' + count);
    }

    // Update saat inisialisasi
    updateRowCount();

    // Update tiap kali tabel di draw ulang (filter, paging, dll)
    table.on('draw', function() {
        updateRowCount();
    });

});
</script>
