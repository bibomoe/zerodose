<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('PartnersActivities_model');
        $this->load->model('Activity_model');
        $this->load->model('CountryObjective_model');
        $this->load->model('Partner_model');
        // $this->load->library('Tcpdf');

        $this->load->model('Immunization_model');
        $this->load->model('Dpt1_model');

        $this->load->model('Puskesmas_model'); // Load model baru
        $this->load->model('District_model'); // Load model
        $this->load->model('Dashboard_model');
        $this->load->model('Report_model');
    }

    public function index($partner_id = 'all') {
        // Ambil daftar bulan
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Ambil session partner_category
        $partner_category = $this->session->userdata('partner_category');

        // Cek apakah partner_category valid
        $is_disabled = !empty($partner_category) && $partner_category != 0;

        // Tentukan filter partner berdasarkan session atau GET
        $partner_id = $is_disabled ? $partner_category : ($this->input->get('partner_id') ?? 'all');
        
        // Ambil data partner jika bukan 'all'
        $partner_name = ($partner_id === 'all') ? 'All Partners' : $this->db->get_where('partners', ['id' => $partner_id])->row()->name;

        // Ambil total target budget dari model berdasarkan filter
        $total_target_budget_2024 = ($partner_id === 'all') 
            ? $this->PartnersActivities_model->get_total_target_budget_by_year(2024) 
            : $this->PartnersActivities_model->get_target_budget_by_partner_and_year($partner_id, 2024);

        $total_target_budget_2025 = ($partner_id === 'all') 
            ? $this->PartnersActivities_model->get_total_target_budget_by_year(2025) 
            : $this->PartnersActivities_model->get_target_budget_by_partner_and_year($partner_id, 2025);

        // Ambil data budget absorption berdasarkan filter
        if ($partner_id === 'all') {
            $data_2024 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2024);
            $data_2025 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2025);
        } else {
            $data_2024 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2024, $partner_id, $total_target_budget_2024);
            $data_2025 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2025, $partner_id, $total_target_budget_2025);
        }

        // Format data untuk chart
        $budget_2024 = array_fill(0, 12, 0);
        $percentage_2024 = array_fill(0, 12, 0);
        $budget_2025 = array_fill(0, 12, 0);
        $percentage_2025 = array_fill(0, 12, 0);

        foreach ($data_2024 as $row) {
            $budget_2024[$row['MONTH'] - 1] = $row['total_budget'];
            $percentage_2024[$row['MONTH'] - 1] = $row['percentage'];
        }

        foreach ($data_2025 as $row) {
            $budget_2025[$row['MONTH'] - 1] = $row['total_budget'];
            $percentage_2025[$row['MONTH'] - 1] = $row['percentage'];
        }

        // Ambil data aktivitas berdasarkan filter
        if ($partner_id === 'all') {
            $total_activities = $this->Activity_model->get_total_activities_by_objectives();
            $completed_activities_2024 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024);
            $completed_activities_2025 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025);
        } else {
            $total_activities = $this->Activity_model->get_total_activities_by_objectives($partner_id);
            $completed_activities_2024 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024, $partner_id);
            $completed_activities_2025 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025, $partner_id);
        }

        // Ambil daftar country objectives
        $objectives = $this->CountryObjective_model->get_all_objectives();
        $total_activities_data = array_fill(0, count($objectives), 0);
        $completed_activities_2024_data = array_fill(0, count($objectives), 0);
        $completed_activities_2025_data = array_fill(0, count($objectives), 0);

        foreach ($total_activities as $activity) {
            $index = $activity['objective_id'] - 1;
            $total_activities_data[$index] = (int) $activity['total'];
        }

        foreach ($completed_activities_2024 as $activity) {
            $index = $activity['objective_id'] - 1;
            $completed_activities_2024_data[$index] = (int) $activity['completed'];
        }

        foreach ($completed_activities_2025 as $activity) {
            $index = $activity['objective_id'] - 1;
            $completed_activities_2025_data[$index] = (int) $activity['completed'];
        }

        // Buat objek PDF
        // **1. Pastikan TCPDF sudah ada di lokasi yang benar**
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php'); 
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Grant Implementation Report');
        $pdf->SetHeaderData('', 0, 'Grant Implementation Report', "Partner: $partner_name");

        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();

        $html = '<h2 style="text-align:center;">Grant Implementation Report</h2>';
        $html .= "<p><strong>Partner:</strong> $partner_name</p>";
        $html .= "<p><strong>Total Budget 2024:</strong> " . number_format($total_target_budget_2024, 0, ',', '.') . " IDR</p>";
        $html .= "<p><strong>Total Budget 2025:</strong> " . number_format($total_target_budget_2025, 0, ',', '.') . " IDR</p>";

        // URL API QuickChart untuk grafik budget absorption
        $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
            'type' => 'line',
            'data' => [
                'labels' => $months,
                'datasets' => [
                    [
                        'label' => '2024 Budget Absorption (%)',
                        'data' => $percentage_2024,
                        'borderColor' => 'blue',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => '2025 Budget Absorption (%)',
                        'data' => $percentage_2025,
                        'borderColor' => 'green',
                        'borderWidth' => 2,
                        'fill' => false
                    ]
                ]
            ],
            'options' => [
                'scales' => [
                    // 'yAxes' => [[ 'ticks' => [ 'beginAtZero' => true ]]]
                    'yAxes' => [[ 
                        'ticks' => [
                            'beginAtZero' => true,
                            'max' => 100  // Set maksimum 100% untuk Y-axis
                        ]
                    ]]

                ]
            ]
        ]));

        // Konversi grafik menjadi Base64
        $chartImageData = file_get_contents($chartUrl);
        $chartImageBase64 = 'data:image/png;base64,' . base64_encode($chartImageData);

        // Buat label yang lebih pendek untuk grafik (Obj 1, Obj 2, Obj 3, ...)
        $short_objectives = array_map(function($key) {
            return 'Obj ' . ($key + 1);
        }, array_keys($objectives));

        // URL API QuickChart untuk grafik aktivitas (Bar Chart)
        $barChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $short_objectives, // Menggunakan label yang lebih pendek
                'datasets' => [
                    [
                        'label' => 'Total Activities',
                        'data' => $total_activities_data,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'Completed 2024',
                        'data' => $completed_activities_2024_data,
                        'backgroundColor' => 'rgba(75, 192, 192, 0.8)',
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'Completed 2025',
                        'data' => $completed_activities_2025_data,
                        'backgroundColor' => 'rgba(255, 99, 132, 0.8)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 1
                    ]
                ]
            ],
            'options' => [
                'scales' => [
                    'xAxes' => [[
                        'ticks' => [
                            'autoSkip' => false,
                            'maxRotation' => 0,  // Membuat label tetap horizontal
                            'minRotation' => 0
                        ]
                    ]],
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                            'precision' => 0
                        ]
                    ]]
                ],
                'legend' => [
                    'position' => 'top',
                    'align' => 'center'
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Activities Conducted by Objectives',
                    'fontSize' => 16
                ]
            ]
        ]));

        // Konversi grafik menjadi Base64
        $barChartImageData = file_get_contents($barChartUrl);
        $barChartImageBase64 = 'data:image/png;base64,' . base64_encode($barChartImageData);



        // Bagian 1: Budget Absorption Table
        $html .= '<h3>Bagian 1 - Tabel Budget Absorption</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Absorbed Budget 2024</th>
                            <th>% Absorption 2024</th>
                            <th>Absorbed Budget 2025</th>
                            <th>% Absorption 2025</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($months as $index => $month) {
            $html .= "<tr>
                        <td>$month</td>
                        <td>" . number_format($budget_2024[$index], 0, ',', '.') . "</td>
                        <td>" . round($percentage_2024[$index], 2) . "%</td>
                        <td>" . number_format($budget_2025[$index], 0, ',', '.') . "</td>
                        <td>" . round($percentage_2025[$index], 2) . "%</td>
                      </tr>";
        }
        $html .= '</tbody></table>';

        // Bagian 2: Activities Conducted Table
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(10);

        $html .= '<h3 style="font-weight: bold;">Bagian 2 - Tabel Activities Conducted</h3>';
        $html .= '<table border="1" cellspacing="0" cellpadding="4">
                    <thead>
                        <tr style="font-weight: bold; background-color: #f2f2f2; text-align: center;">
                            <th>No</th>
                            <th style="text-align: left;">Country Objective</th>
                            <th>Total Activities</th>
                            <th>Completed 2024</th>
                            <th>Completed 2025</th>
                        </tr>
                    </thead>
                    <tbody>';
                    
        $no = 1;
        foreach ($objectives as $index => $objective) {
            $html .= "<tr>
                        <td align='center'>".$no++."</td>
                        <td style='text-align: left;'>{$objective['objective_name']}</td>
                        <td align='center'>{$total_activities_data[$index]}</td>
                        <td align='center'>{$completed_activities_2024_data[$index]}</td>
                        <td align='center'>{$completed_activities_2025_data[$index]}</td>
                    </tr>";
        }
        $html .= '</tbody></table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');

        // Tambahkan halaman baru sebelum menampilkan gambar grafik
        $pdf->AddPage();

        // Tampilkan grafik di halaman kedua setelah tabel
        $pdf->Image('@' . base64_decode(str_replace('data:image/png;base64,', '', $chartImageBase64)), 15, 40, 180, 90, 'PNG');

        // Tambahkan ruang kosong agar gambar tidak bertumpuk dengan konten berikutnya
        $pdf->Ln(100);

        $pdf->AddPage();
        $pdf->Image('@' . base64_decode(str_replace('data:image/png;base64,', '', $barChartImageBase64)), 15, 50, 180, 90, 'PNG');

        // Tambahkan halaman baru jika ingin menambahkan grafik lain atau data tambahan
        // $pdf->AddPage();

        ob_end_clean(); // Bersihkan output buffer sebelum mengirim PDF
        $pdf->Output('Grant_Report.pdf', 'I');
        exit();
    }

    public function immunization_report_indonesia() {
        // Ambil filter provinsi dari dropdown (default: all)
        $selected_province = $this->input->get('province') ?? 'all';
        $selected_district = $this->input->get('district') ?? 'all';
        $selected_year = $this->input->get('year') ?? 2024; // Default tahun 2025
        $selected_month = $this->input->get('month') ?? date('m'); // Default bulan saat ini 2025

        $year = $selected_year;
        // Menentukan baseline ZD
        // if ($selected_province == 'all') {
            // Ambil baseline ZD 2023 dari tabel target_baseline
            // $this->data['national_baseline_zd'] = $this->Immunization_model->get_baseline_zd(2023);
        // } else {
        //     // Ambil total ZD dari tabel zd_cases_2023 berdasarkan provinsi yang dipilih
        //     $this->data['national_baseline_zd'] = $this->Immunization_model->get_zero_dose_by_province($selected_province);
        // }

        // Menentukan baseline ZD
        if ($selected_province == 'all') {
            // Ambil baseline ZD 2023 dari tabel target_baseline
            $this->data['national_baseline_zd'] = $this->Immunization_model->get_baseline_zd(2023);
        } else {
            // Ambil total ZD dari tabel zd_cases_2023 berdasarkan provinsi yang dipilih
            $this->data['national_baseline_zd'] = $this->Report_model->get_zero_dose_by_province($selected_province, $selected_district);
        }

        // Ambil target dari target_immunization untuk provinsi tertentu atau targeted
        $this->data["total_target_dpt_1_$year"] = $this->Report_model->get_total_target('dpt_hb_hib_1', $selected_province, $selected_district, $year);
        $this->data["total_target_dpt_3_$year"] = $this->Report_model->get_total_target('dpt_hb_hib_3', $selected_province, $selected_district, $year);
        $this->data["total_target_mr_1_$year"] = $this->Report_model->get_total_target('mr_1', $selected_province, $selected_district, $year);

        // Ambil data cakupan imunisasi dari immunization_data
        $this->data["total_dpt_1_$year"] = $this->Report_model->get_total_vaccine('dpt_hb_hib_1', $selected_province, $selected_district, $year, $selected_month);
        $this->data["total_dpt_3_$year"] = $this->Report_model->get_total_vaccine('dpt_hb_hib_3', $selected_province, $selected_district, $year, $selected_month);
        $this->data["total_mr_1_$year"] = $this->Report_model->get_total_vaccine('mr_1', $selected_province, $selected_district, $year, $selected_month);

        // Hitung Zero Dose (ZD)
        $this->data["zero_dose_$year"] = max($this->data["total_target_dpt_1_$year"] - $this->data["total_dpt_1_$year"], 0);

        // Hitung persentase cakupan terhadap baseline
        $this->data["percent_dpt_3_$year"] = ($this->data["total_target_dpt_3_$year"] != 0)
            ? round(($this->data["total_dpt_3_$year"] / $this->data["total_target_dpt_3_$year"]) * 100, 1)
            : 0;
    
        $this->data["percent_mr_1_$year"] = ($this->data["total_target_mr_1_$year"] != 0)
            ? round(($this->data["total_mr_1_$year"] / $this->data["total_target_mr_1_$year"]) * 100, 1)
            : 0;
        
        $this->data["percent_dpt_1_$year"] = ($this->data["total_target_dpt_1_$year"] != 0)
            ? round(($this->data["total_dpt_1_$year"] / $this->data["total_target_dpt_1_$year"]) * 100, 1)
            : 0;
        
        // var_dump($this->data["percent_dpt_3_$year"]);
        // exit;

        $zero_dose = $this->data["zero_dose_$year"];
        $percent_dpt3_coverage = $this->data["percent_dpt_3_$year"];
        $total_dpt3_coverage = $this->data["total_dpt_3_$year"];
        $total_mr1_coverage = $this->data["total_mr_1_$year"];
        $percent_mr1_coverage = $this->data["percent_mr_1_$year"];

        $total_dpt1_coverage = $this->data["total_dpt_1_$year"];
        $percent_dpt1_coverage = $this->data["percent_dpt_1_$year"];

        // TABLE 2 
        // Mendapatkan dropout rates per provinsi
        $dropout_rates = $this->Report_model->get_districts_under_5_percent($selected_province,$selected_district,$selected_year, $selected_month);
        
        // Menjumlahkan semua nilai dropout rate per provinsi
        $total_dropout_rate = array_sum($dropout_rates);
        
        // Menambahkan total dropout rate ke data view
        $this->data['total_dropout_rate'] = $total_dropout_rate;

        // Ambil dropout rates per provinsi
        $dropout_rates_per_province = $this->Report_model->get_dropout_rates_per_province($selected_province,$selected_district,$selected_year, $selected_month);

        // Hitung total dan jumlah provinsi untuk perhitungan rata-rata
        $total_dropout_rate = 0;
        $total_provinces = count($dropout_rates_per_province);

        // var_dump($dropout_rates_per_province);
        // exit;
        
        foreach ($dropout_rates_per_province as $province_id => $data) {
            $total_dropout_rate += $data['average']; // Menjumlahkan rata-rata dropout rate per provinsi
        }

        // Hitung rata-rata dropout rate dari semua provinsi
        $average_dropout_rate_all_provinces = ($total_provinces > 0) ? $total_dropout_rate / $total_provinces : 0;

        // Menambahkan rata-rata dropout rate ke data view
        $this->data['dropout_rate_all_provinces'] = round($average_dropout_rate_all_provinces, 2);

        $total_district_under_5_DO = $this->data['total_dropout_rate']; //Jumlah Kab/Kota dengan %DO dibawah 5%
        $dropout_rate_all_provinces = $this->data['dropout_rate_all_provinces'];

        // Ambil data jumlah puskesmas & imunisasi dari model baru
        $puskesmas_data = $this->Report_model->get_puskesmas_data($selected_province, $selected_district, $selected_year, $selected_month);
        $this->data['total_immunized_puskesmas'] = $puskesmas_data['total_immunized_puskesmas'];
        $this->data['percentage_puskesmas'] = $puskesmas_data['percentage'];

        $puskesmas_conduct_immunization = $this->data['total_immunized_puskesmas'];
        $percentage_puskesmas_conduct_immunization = $this->data['percentage_puskesmas'];

        $this->data["total_dpt_stockout_$year"] = $this->Report_model->get_total_dpt_stock_out($selected_province, $selected_district, $selected_year, $selected_month);

        $total_dpt_stockout = $this->data["total_dpt_stockout_$year"];
        

        // TABLE 3
        // Mengambil data Jumlah District Dengan DO dibawah 5%
        $dpt_under_5_data = $this->Report_model->get_districts_under_5_percent($selected_province,$selected_district,$selected_year, $selected_month);

        // Mengambil data total cities per provinsi
        $this->data['total_cities_per_province'] = $this->Report_model->get_total_cities_per_province($selected_province,$selected_district);

        // **Hitung persentase districts dengan coverage < 5% per provinsi**
        $this->data['percent_dpt_under_5_per_province'] = [];
        foreach ($dpt_under_5_data as $province_id => $district_count) {
            // Cari total cities berdasarkan province_id
            $total_cities = 0;
            foreach ($this->data['total_cities_per_province'] as $province_data) {
                if ($province_data['province_id'] == $province_id) {
                    $total_cities = (int)$province_data['total_cities'];
                    break; // Keluar dari loop jika ditemukan
                }
            }

            $this->data['percent_dpt_under_5_per_province'][$province_id] = ($total_cities > 0)
                ? round(($district_count / $total_cities) * 100, 2)
                : 0;
        }

        // Mengambil data provinsi menggunakan model
        $list_province = $this->Report_model->get_provinces();
        $table_do = []; // Array untuk menyimpan hasil laporan

        foreach ($list_province as $province) {
            $province_id = $province['id'];
            $province_name = $province['name_id'];  // Misalkan 'name' adalah nama provinsi, sesuaikan jika nama kolom berbeda
            
            // Ambil data untuk setiap provinsi dari variabel yang sudah ada
            $do_rate = isset($dropout_rates_per_province[$province_id]) ? $dropout_rates_per_province[$province_id]['average'] : 0;
            $cities_do_under_5 = isset($dpt_under_5_data[$province_id]) ? $dpt_under_5_data[$province_id] : 0;
            $percentage_cities_do_under_5 = isset($this->data['percent_dpt_under_5_per_province'][$province_id]) ? $this->data['percent_dpt_under_5_per_province'][$province_id] : 0;

            // Masukkan data ke dalam array table_do
            $table_do[] = [
                'province_id' => $province_id,
                'name' => $province_name,
                'do_rate' => number_format($do_rate, 2),  // DO rate dalam format 2 desimal
                'cities_do_under_5' => $cities_do_under_5,
                'percentage_cities_do_under_5' => number_format($percentage_cities_do_under_5, 2) . '%',  // Persentase dengan format %
            ];
        }

        
        // TABLE 4
        $immunization_data = $this->Report_model->get_immunization_puskesmas_table($selected_province,$selected_district,$selected_year, $selected_month);

        // Array untuk menyimpan laporan puskesmas imunisasi
        $table_puskesmas_immunization = [];

        foreach ($list_province as $province) {
            $province_id = $province['id'];  // ID Provinsi
            $province_name = $province['name_id'];  // Nama Provinsi (gunakan 'name_id' jika nama provinsi dalam bahasa Indonesia)

            // Inisialisasi variabel untuk menyimpan data
            $total_puskesmas_with_immunization = 0;
            $total_puskesmas = 0;
            $percentage_immunization = 0;

            // Cari data imunisasi berdasarkan provinsi
            foreach ($immunization_data as $data) {
                // Cek jika province_id dari data sama dengan id provinsi di $list_province
                if ($data['province_id'] == $province_id) {
                    // Ambil total puskesmas yang sudah melakukan imunisasi
                    $total_puskesmas_with_immunization = $data['total_puskesmas_with_immunization'];
                    // Ambil total puskesmas
                    $total_puskesmas = $data['total_puskesmas'];
                    // Hitung persentase imunisasi
                    $percentage_immunization = $data['percentage_immunization'];
                    break;  // Setelah ditemukan data untuk provinsi ini, keluar dari loop
                }
            }

            // Masukkan data ke dalam array $table_puskesmas_immunization
            $table_puskesmas_immunization[] = [
                'province_id' => $province_id,
                'province_name' => $province_name,
                'total_puskesmas_with_immunization' => $total_puskesmas_with_immunization,
                'total_puskesmas' => $total_puskesmas,
                'percentage_immunization' => $percentage_immunization
            ];
        }

        // TABLE 5
        $puskesmas_dpt_stock_out_data = $this->Report_model->get_puskesmas_dpt_stock_out_table($selected_province,$selected_district,$selected_year, $selected_month);

        // var_dump($puskesmas_dpt_stock_out_data);
        // exit;

        // Array untuk menyimpan laporan puskesmas stock out
        $table_puskesmas_stock_out = [];

        foreach ($list_province as $province) {
            $province_id = $province['id'];  // ID Provinsi
            $province_name = $province['name_id'];  // Nama Provinsi (gunakan 'name_id' jika nama provinsi dalam bahasa Indonesia)

            // Inisialisasi variabel untuk menyimpan data
            $total_stock_out_1_month = 0;
            $total_stock_out_2_months = 0;
            $total_stock_out_3_months = 0;
            $total_stock_out_more_than_3_months = 0;
            $total_stock_out = 0;
            $total_puskesmas = 0;
            $percentage_stock_out = 0;

            // Cari data puskesmas dengan DPT stock out berdasarkan provinsi
            foreach ($puskesmas_dpt_stock_out_data as $data) {
                // Cek jika province_id dari data sama dengan id provinsi di $list_province
                if ($data['province_id'] == $province_id) {
                    // Ambil data stock out berdasarkan durasi
                    $total_stock_out_1_month = $data['total_stock_out_1_month'];
                    $total_stock_out_2_months = $data['total_stock_out_2_months'];
                    $total_stock_out_3_months = $data['total_stock_out_3_months'];
                    $total_stock_out_more_than_3_months = $data['total_stock_out_more_than_3_months'];
                    // Ambil total puskesmas aktif di provinsi
                    $total_puskesmas = $data['total_puskesmas'];

                    // Hitung total puskesmas yang mengalami DPT stock out
                    $total_stock_out = $total_stock_out_1_month + $total_stock_out_2_months + $total_stock_out_3_months + $total_stock_out_more_than_3_months;

                    // Hitung persentase Puskesmas dengan DPT stock out
                    $percentage_stock_out = ($total_puskesmas > 0)
                        ? round(($total_stock_out / $total_puskesmas) * 100, 2)
                        : 0;
                    break;  // Setelah ditemukan data untuk provinsi ini, keluar dari loop
                }
            }

            // Masukkan data ke dalam array $table_puskesmas_stock_out
            $table_puskesmas_stock_out[] = [
                'province_id' => $province_id,
                'province_name' => $province_name,
                'total_stock_out_1_month' => $total_stock_out_1_month,
                'total_stock_out_2_months' => $total_stock_out_2_months,
                'total_stock_out_3_months' => $total_stock_out_3_months,
                'total_stock_out_more_than_3_months' => $total_stock_out_more_than_3_months,
                'total_stock_out' => $total_stock_out,
                'total_puskesmas' => $total_puskesmas,
                'percentage_stock_out' => $percentage_stock_out
            ];
        }

        // var_dump($table_puskesmas_stock_out);
        // exit;

        // Data contoh, kamu bisa mengganti ini dengan data asli dari database
        $province_name = "Indonesia";
    
        $data = [
            'cumulative_dpt3' => $percent_dpt3_coverage . '% <br>' . $total_dpt3_coverage,
            'cumulative_mr1' => $percent_mr1_coverage . '% <br>' . $total_mr1_coverage,
            'children_zero_dose' => $zero_dose,
            'cumulative_dpt1' => $percent_dpt1_coverage . '% <br>' . $total_dpt1_coverage,
            'drop_out_percentage' => $dropout_rate_all_provinces . '% <br>',
            'puskesmas_percentage' => $total_district_under_5_DO,
            'puskesmas_conduct_immunization' => $puskesmas_conduct_immunization,
            'percentage_puskesmas_conduct_immunization' => $percentage_puskesmas_conduct_immunization,
            'total_dpt_stockout' => $total_dpt_stockout,
            'province_do' => $table_do,
            'puskesmas_do_immunization' => $table_puskesmas_immunization,
            'puskesmas_dpt_stock_out_data' => $table_puskesmas_stock_out
        ];
    
        // Membuat objek TCPDF
        // Buat objek PDF
        // **1. Pastikan TCPDF sudah ada di lokasi yang benar**
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php'); 
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Organization');
        $pdf->SetTitle('Laporan Kerangka Kerja Penurunan Zero Dose');
        $pdf->SetHeaderData('', 0, 'Laporan Kerangka Kerja Penurunan Zero Dose', "Indonesia");
    
        // Mengatur margin
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();
    
        // Judul laporan
        $html = '<h2 style="text-align:center;">Laporan Kerangka Kerja Penurunan Zero Dose di Indonesia</h2>';
        // $html .= "<h4>Indonesia</h4>";

    
        // Tabel 1: Indikator Jangka Panjang
        $html .= '<h3>Indikator Jangka Panjang</h3>';
        $html .= '<table border="1" cellpadding="5" style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Cakupan DPT-3</th>
                            <th>Cakupan MR-1</th>
                            <th>Jumlah Anak Zero Dose</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>' . $data['cumulative_dpt3'] . '</td>
                            <td>' . $data['cumulative_mr1'] . '</td>
                            <td>' . $data['children_zero_dose'] . '</td>
                        </tr>
                    </tbody>
                </table>';
    
        // Menambahkan jarak antara tabel pertama dan kedua
        $html .= '<br><br>';
    
        // Tabel 2: Indikator Jangka Menengah
        $html .= '<h3>Indikator Jangka Menengah</h3>';
        $html .= '<table border="1" cellpadding="5" style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Cakupan DPT-1</th>
                            <th>% Drop Out</th>
                            <th>Jumlah Kab/Kota dengan %DO dibawah 5%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>' . $data['cumulative_dpt1'] . '</td>
                            <td>' . $data['drop_out_percentage'] . '</td>
                            <td>' . $data['puskesmas_percentage'] . '</td>
                        </tr>

                        <tr>
                            <th>% puskesmas yang melakukan pelayanan imunisasi</th>
                            <th>Jumlah puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional</th>
                            <th>Jumlah puskesmas dengan status DPT stock out</th>
                        </tr>

                        <tr>
                            <td>' . $data['percentage_puskesmas_conduct_immunization'] . '</td>
                            <td>' . $data['puskesmas_conduct_immunization'] . '</td>
                            <td>' . $data['total_dpt_stockout'] . '</td>
                        </tr>
                    </tbody>
                </table>';
    
        
                // Menambahkan jarak antara tabel kedua dan ketiga
        $html .= '<br><br>';

        // Tabel 3: Kab/Ko dengan % DO dibawah 5%
        $html .= '<h3>Kab/Ko dengan % DO dibawah 5%</h3>';
        $html .= '<table border="1" cellpadding="5" style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Nama Provinsi</th>
                            <th>% Anak DO</th>
                            <th>Jumlah Kab/Kotata dengan % DO dibawah 5%</th>
                            <th>% Kab/Kota dengan % DO dibawah 5%</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['province_do'] as $item) {
            $html .= "<tr>
                        <td>{$item['name']}</td>
                        <td>{$item['do_rate']}</td>
                        <td>{$item['cities_do_under_5']}</td>
                        <td>{$item['percentage_cities_do_under_5']}</td>
                    </tr>";
        }
        $html .= '</tbody></table>';

        // Menambahkan jarak antara tabel keempat dan kelima
        $html .= '<br><br>';
    
        // Tabel 4: Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
        $html .= '<h3>Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional</h3>';
        $html .= '<table border="1" cellpadding="5" style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Nama Provinsi</th>
                            <th>Jumlah Puskesmas</th>
                            <th>% Puskesmas</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['puskesmas_do_immunization'] as $item) {
            $html .= "<tr>
                        <td>{$item['province_name']}</td>
                        <td>{$item['total_puskesmas_with_immunization']}</td>
                        <td>{$item['percentage_immunization']}%</td>
                      </tr>";
        }
        $html .= '</tbody></table>';
    
        // Menambahkan jarak antara tabel ketiga dan keempat
        $html .= '<br><br>';
    
        // Tabel 5: Puskesmas dengan status DPT stock out
        $html .= '<h3>Puskesmas dengan status DPT stock out</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Nama Provinsi</th>
                            <th>Jumlah Puskesmas</th>
                            <th>% Puskesmas</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
            $html .= "<tr>
                        <td>{$item['province_name']}</td>
                        <td>{$item['total_stock_out']}</td>
                        <td>{$item['percentage_stock_out']}%</td>
                      </tr>";
        }
        $html .= '</tbody></table>';
    
        // Menulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Menyelesaikan PDF dan menampilkan di browser
        ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        $pdf->Output('Laporan_Zerodose_Indonesia.pdf', 'I');
        exit();
    }
    
    public function immunization_report_province() {
        // Data contoh, kamu bisa mengganti ini dengan data asli dari database
        $province_name = "Provinsi ABC";
    
        $data = [
            'cumulative_dpt3' => 'XX%',
            'cumulative_mr1' => 'XX%',
            'children_zero_dose' => 'NN',
            'cumulative_dpt1' => 'XX%',
            'drop_out_percentage' => 'XX%',
            'puskesmas_percentage' => 'XX%',
            'puskesmas_vaccine_compliant' => 'XX%',
            'puskesmas_dpt_stock_out' => 'XX%',
            'kabko_with_low_do' => [
                ['KabKo Name 1', '5%', '10%'],
                ['KabKo Name 2', '4%', '8%']
            ],
            'puskesmas_vaccine_compliant_data' => [
                ['KabKo Name 1', '20'],
                ['KabKo Name 2', '15']
            ],
            'puskesmas_dpt_stock_out_data' => [
                ['KabKo Name 1', '2'],
                ['KabKo Name 2', '1']
            ]
        ];
    
        // Membuat objek TCPDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Organization');
        $pdf->SetTitle('Laporan Kerangka Kerja Penurunan Zero Dose');
        $pdf->SetHeaderData('', 0, 'Laporan Kerangka Kerja Penurunan Zero Dose', "Provinsi: $province_name");
    
        // Mengatur margin
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();
    
        // Judul laporan
        $html = '<h2 style="text-align:center;">Laporan Kerangka Kerja Penurunan Zero Dose</h2>';
        $html .= "<h4>Provinsi: $province_name</h4>";
    
        // Tabel 1: Indikator Jangka Panjang
        $html .= '<h3>Indikator Jangka Panjang</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Indikator</th>
                            <th>Cakupan DPT-3</th>
                            <th>Cakupan MR-1</th>
                            <th>Jumlah Anak Zero Dose</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>XX</td>
                            <td>' . $data['cumulative_dpt3'] . '</td>
                            <td>' . $data['cumulative_mr1'] . '</td>
                            <td>' . $data['children_zero_dose'] . '</td>
                        </tr>
                    </tbody>
                </table>';
    
        // Menambahkan jarak antara tabel pertama dan kedua
        $html .= '<br><br>';
    
        // Tabel 2: Indikator Jangka Menengah
        $html .= '<h3>Indikator Jangka Menengah</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Indikator</th>
                            <th>Cakupan DPT-1</th>
                            <th>% Drop Out</th>
                            <th>% Puskesmas yang melakukan pelayanan imunisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>XX</td>
                            <td>' . $data['cumulative_dpt1'] . '</td>
                            <td>' . $data['drop_out_percentage'] . '</td>
                            <td>' . $data['puskesmas_percentage'] . '</td>
                        </tr>
                    </tbody>
                </table>';
    
        // Menambahkan jarak antara tabel kedua dan ketiga
        $html .= '<br><br>';
    
        // Tabel 3: Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
        $html .= '<h3>Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Nama Kab/Ko</th>
                            <th>Jumlah Puskesmas</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['puskesmas_vaccine_compliant_data'] as $item) {
            $html .= "<tr>
                        <td>{$item[0]}</td>
                        <td>{$item[1]}</td>
                      </tr>";
        }
        $html .= '</tbody></table>';
    
        // Menambahkan jarak antara tabel ketiga dan keempat
        $html .= '<br><br>';
    
        // Tabel 4: Puskesmas dengan status DPT stock out
        $html .= '<h3>Puskesmas dengan status DPT stock out</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Nama Kab/Ko</th>
                            <th>Jumlah Puskesmas</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
            $html .= "<tr>
                        <td>{$item[0]}</td>
                        <td>{$item[1]}</td>
                      </tr>";
        }
        $html .= '</tbody></table>';
    
        // Menambahkan jarak antara tabel keempat dan kelima
        $html .= '<br><br>';
    
        // Tabel 5: Kab/Ko dengan % DO dibawah 5%
        $html .= '<h3>Kab/Ko dengan % DO dibawah 5%</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Nama Kab/Ko</th>
                            <th>% Anak DO</th>
                            <th>% Anak DO</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['kabko_with_low_do'] as $item) {
            $html .= "<tr>
                        <td>{$item[0]}</td>
                        <td>{$item[1]}</td>
                        <td>{$item[2]}</td>
                      </tr>";
        }
        $html .= '</tbody></table>';
    
        // Tulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Menyelesaikan PDF dan menampilkan di browser
        ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        $pdf->Output('Laporan_Zerodose.pdf', 'I');
        exit();
    }
    
    public function immunization_report_district() {
        // Data contoh yang akan ditampilkan pada laporan (ganti dengan data dari database)
        $kabko_name = "Kabupaten ABC"; // Nama Kab/Ko

        $data = [
            'dpt3' => 'XX%',
            'mr1' => 'XX%',
            'children_zero_dose' => 'NN',
            'dpt1' => 'XX%',
            'drop_out_percentage' => 'XX%',
            'puskesmas_percentage' => 'XX%',
            'compliant_puskesmas' => 'XX%',
            'stock_out' => 'XX%',
            'puskesmas_do_below_5' => [
                ['Puskesmas 1', '5%', '10%'],
                ['Puskesmas 2', '4%', '8%']
            ],
            'puskesmas_compliant' => [
                ['Puskesmas 1', '10'],
                ['Puskesmas 2', '15']
            ],
            'puskesmas_stock_out' => [
                ['Puskesmas 1', '2'],
                ['Puskesmas 2', '3']
            ]
        ];

        // Membuat objek TCPDF
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Organization');
        $pdf->SetTitle('Laporan Kerangka Kerja Penurunan Zero Dose di Kab/Ko');
        $pdf->SetHeaderData('', 0, 'Laporan Kerangka Kerja Penurunan Zero Dose', "Kabupaten: $kabko_name");

        // Mengatur margin
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();

        // Judul laporan
        $html = '<h2 style="text-align:center;">Laporan Kerangka Kerja Penurunan Zero Dose di Kab/Ko</h2>';
        $html .= "<h4>Kabupaten: $kabko_name</h4>";

        // Tabel 1: Indikator Jangka Panjang
        $html .= '<h3>Indikator Jangka Panjang</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Indikator</th>
                            <th>Cakupan DPT-3</th>
                            <th>Cakupan MR-1</th>
                            <th>Jumlah Anak Zero Dose</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>XX</td>
                            <td>' . $data['dpt3'] . '</td>
                            <td>' . $data['mr1'] . '</td>
                            <td>' . $data['children_zero_dose'] . '</td>
                        </tr>
                    </tbody>
                </table>';
        
        // Menambahkan jarak antara tabel pertama dan kedua
        $html .= '<br><br>';

        // Tabel 2: Indikator Jangka Menengah
        $html .= '<h3>Indikator Jangka Menengah</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Indikator</th>
                            <th>Cakupan DPT-1</th>
                            <th>% Drop Out</th>
                            <th>% Puskesmas yang melakukan pelayanan imunisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>XX</td>
                            <td>' . $data['dpt1'] . '</td>
                            <td>' . $data['drop_out_percentage'] . '</td>
                            <td>' . $data['puskesmas_percentage'] . '</td>
                        </tr>
                    </tbody>
                </table>';

        // Menambahkan jarak antara tabel kedua dan ketiga
        $html .= '<br><br>';

        // Tabel 3: Puskesmas dengan % DO dibawah 5%
        $html .= '<h3>Puskesmas dengan % DO dibawah 5%</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Nama Puskesmas</th>
                            <th>Jumlah Anak DO</th>
                            <th>% Anak DO</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['puskesmas_do_below_5'] as $item) {
            $html .= "<tr>
                        <td>{$item[0]}</td>
                        <td>{$item[1]}</td>
                        <td>{$item[2]}</td>
                      </tr>";
        }
        $html .= '</tbody></table>';

        // Menambahkan jarak antara tabel ketiga dan keempat
        $html .= '<br><br>';

        // Tabel 4: Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
        $html .= '<h3>Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Nama Puskesmas</th>
                            <th>Jumlah Puskesmas</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['puskesmas_compliant'] as $item) {
            $html .= "<tr>
                        <td>{$item[0]}</td>
                        <td>{$item[1]}</td>
                      </tr>";
        }
        $html .= '</tbody></table>';

        // Menambahkan jarak antara tabel keempat dan kelima
        $html .= '<br><br>';

        // Tabel 5: Puskesmas dengan status DPT stock out
        $html .= '<h3>Puskesmas dengan status DPT stock out</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Nama Puskesmas</th>
                            <th>Jumlah Puskesmas</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['puskesmas_stock_out'] as $item) {
            $html .= "<tr>
                        <td>{$item[0]}</td>
                        <td>{$item[1]}</td>
                      </tr>";
        }
        $html .= '</tbody></table>';

        // Menulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Menyelesaikan PDF dan menampilkan di browser
        ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        $pdf->Output('Laporan_Zerodose_KabKo.pdf', 'I');
        exit();
    }

    public function immunization_and_grant_report_indonesia() {
        // Data untuk laporan imunisasi
        $province_name = "Indonesia";
        
        // Data untuk laporan imunisasi
        $data = [
            'cumulative_dpt3' => 'XX%',
            'cumulative_mr1' => 'XX%',
            'children_zero_dose' => 'NN',
            'cumulative_dpt1' => 'XX%',
            'drop_out_percentage' => 'XX%',
            'puskesmas_percentage' => 'XX%',
            'puskesmas_vaccine_compliant' => 'XX%',
            'puskesmas_dpt_stock_out' => 'XX%',
            'kabko_with_low_do' => [
                ['KabKo Name 1', '5%', '10%'],
                ['KabKo Name 2', '4%', '8%']
            ],
            'puskesmas_vaccine_compliant_data' => [
                ['KabKo Name 1', '20'],
                ['KabKo Name 2', '15']
            ],
            'puskesmas_dpt_stock_out_data' => [
                ['KabKo Name 1', '2'],
                ['KabKo Name 2', '1']
            ],
    
            // Data untuk laporan Grant Implementation & Budget Disbursement
            'budget_2024' => '4.92%',
            'budget_2025' => '0.59%',
            'country_objectives' => [
                ['Meningkatkan kapasitas daerah dalam perencanaan, pelaksanaan, dan pemantauan imunisasi kejarm', '26.67%', '40%'],
                ['Meningkatkan kualitas dan pemanfaatan data rutin, termasuk di daerah berisiko tinggi', '21.43%', '35.71%'],
                ['Meningkatkan permintaan imunisasi berbasis bukti', '33.33%', '33.33%'],
                ['Memperkuat kapasitas program imunisasi di tingkat nasional dan daerah', '60%', '80%'],
                ['Memfasilitasi pendanaan daerah yang berkelanjutan untuk operasional program imunisasi', '80%', '80%'],
                ['Memperkuat koordinasi untuk meningkatkan akuntabilitas bersamaan di tingkat nasional dan daerah', '100%', '100%']
            ]
        ];
    
        // Membuat objek TCPDF
        // **1. Pastikan TCPDF sudah ada di lokasi yang benar**
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php'); 
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Organization');
        $pdf->SetTitle('Laporan Imunisasi dan Implementasi Grant');
        $pdf->SetHeaderData('', 0, 'Laporan Imunisasi dan Implementasi Grant', "Indonesia");
    
        // Mengatur margin
        $pdf->SetMargins(15, 20, 15);
    
        // Halaman 1 - Laporan Imunisasi
        $pdf->AddPage(); // Menambahkan halaman baru
        $html = '<h2 style="text-align:center;">Laporan Kerangka Kerja Penurunan Zero Dose di Indonesia</h2>';
        // $html .= "<h4>Indonesia</h4>";
    
        // // Tabel 1: Indikator Jangka Panjang
        // $html .= '<h3>Indikator Jangka Panjang</h3>';
        // $html .= '<table border="1" cellpadding="5">
        //             <thead>
        //                 <tr>
        //                     <th>Cakupan DPT-3</th>
        //                     <th>Cakupan MR-1</th>
        //                     <th>Jumlah Anak Zero Dose</th>
        //                 </tr>
        //             </thead>
        //             <tbody>
        //                 <tr>
        //                     <td>' . $data['cumulative_dpt3'] . '</td>
        //                     <td>' . $data['cumulative_mr1'] . '</td>
        //                     <td>' . $data['children_zero_dose'] . '</td>
        //                 </tr>
        //             </tbody>
        //         </table>';
    
        // // Menambahkan jarak antara tabel pertama dan kedua
        // $html .= '<br><br>';
    
        // // Tabel 2: Indikator Jangka Menengah
        // $html .= '<h3>Indikator Jangka Menengah</h3>';
        // $html .= '<table border="1" cellpadding="5">
        //             <thead>
        //                 <tr>
        //                     <th>Cakupan DPT-1</th>
        //                     <th>% Drop Out</th>
        //                     <th>% Puskesmas yang melakukan pelayanan imunisasi</th>
        //                 </tr>
        //             </thead>
        //             <tbody>
        //                 <tr>
        //                     <td>' . $data['cumulative_dpt1'] . '</td>
        //                     <td>' . $data['drop_out_percentage'] . '</td>
        //                     <td>' . $data['puskesmas_percentage'] . '</td>
        //                 </tr>
        //             </tbody>
        //         </table>';
    
        // // Menambahkan jarak antara tabel kedua dan ketiga
        // $html .= '<br><br>';
    
        // // Tabel 3: Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
        // $html .= '<h3>Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional</h3>';
        // $html .= '<table border="1" cellpadding="5">
        //             <thead>
        //                 <tr>
        //                     <th>Nama Kab/Ko</th>
        //                     <th>Jumlah Puskesmas</th>
        //                 </tr>
        //             </thead>
        //             <tbody>';
        // foreach ($data['puskesmas_vaccine_compliant_data'] as $item) {
        //     $html .= "<tr>
        //                 <td>{$item[0]}</td>
        //                 <td>{$item[1]}</td>
        //               </tr>";
        // }
        // $html .= '</tbody></table>';
    
        // // Menambahkan jarak antara tabel ketiga dan keempat
        // $html .= '<br><br>';
    
        // // Tabel 4: Puskesmas dengan status DPT stock out
        // $html .= '<h3>Puskesmas dengan status DPT stock out</h3>';
        // $html .= '<table border="1" cellpadding="5">
        //             <thead>
        //                 <tr>
        //                     <th>Nama Kab/Ko</th>
        //                     <th>Jumlah Puskesmas</th>
        //                 </tr>
        //             </thead>
        //             <tbody>';
        // foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
        //     $html .= "<tr>
        //                 <td>{$item[0]}</td>
        //                 <td>{$item[1]}</td>
        //               </tr>";
        // }
        // $html .= '</tbody></table>';
    
        // // Menambahkan jarak antara tabel keempat dan kelima
        // $html .= '<br><br>';
    
        // // Tabel 5: Kab/Ko dengan % DO dibawah 5%
        // $html .= '<h3>Kab/Ko dengan % DO dibawah 5%</h3>';
        // $html .= '<table border="1" cellpadding="5">
        //             <thead>
        //                 <tr>
        //                     <th>Nama Kab/Ko</th>
        //                     <th>% Anak DO</th>
        //                     <th>% Kab/Ko dengan % DO dibawah 5%</th>
        //                 </tr>
        //             </thead>
        //             <tbody>';
        // foreach ($data['kabko_with_low_do'] as $item) {
        //     $html .= "<tr>
        //                 <td>{$item[0]}</td>
        //                 <td>{$item[1]}</td>
        //                 <td>{$item[2]}</td>
        //               </tr>";
        // }
        // $html .= '</tbody></table>';

        // // Menambahkan jarak antara tabel keempat dan kelima
        // $html .= '<br><br>';
    
        // Halaman 2 - Laporan Grant Implementation & Country Objectives
        // $pdf->AddPage(); // Menambahkan halaman baru
        // $html = '<h2 style="text-align:center;">Grant Implementation & Budget Disbursement</h2>';
        $html .= '<h3>Penggunaan (penyerapan) Budget untuk periode pelaporan tertentu, Gavi</h3>';
    
        // Tabel 6: Grant Implementation & Budget Disbursement
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Indikator</th>
                            <th>2024</th>
                            <th>2025</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Penggunaan (penyerapan) Budget</td>
                            <td>' . $data['budget_2024'] . '</td>
                            <td>' . $data['budget_2025'] . '</td>
                        </tr>
                    </tbody>
                </table>';
    
        // Menambahkan jarak antara tabel pengeluaran dan country objectives
        $html .= '<br><br>';
    
        // Tabel 7: Country Objectives
        $html .= '<h3>Country Objectives</h3>';
        $html .= '<table border="1" cellpadding="5" >
                    <thead>
                        <tr>
                            <th>Tujuan</th>
                            <th>Indikator</th>
                            <th>2024</th>
                            <th>2025</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['country_objectives'] as $objective) {
            $html .= "<tr>
                        <td>{$objective[0]}</td>
                        <td>{$objective[1]}</td>
                        <td>{$objective[2]}</td>
                        <td>{$objective[3]}</td>
                      </tr>";
        }
        $html .= '</tbody></table>';
    
        // Menulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Menyelesaikan PDF dan menampilkan di browser
        ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        $pdf->Output('Laporan_Imunisasi_Grant_Indonesia.pdf', 'I');
        exit();
    }
    
}
?>
