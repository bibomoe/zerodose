<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('session'); // Load library session

        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // Regenerasi ID session setiap kali user aktif
        $this->session->sess_regenerate();

        // Inisialisasi data sesi di $data
        $this->data = [
            'session_email' => $this->session->userdata('email'),
            'session_name' => $this->session->userdata('name'),
            'session_user_category_name' => $this->session->userdata('user_category_name'),
        ];
        
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

    public function index(){
        // Ambil daftar partner untuk dropdown
        $this->data['partners'] = $this->Partner_model->get_all_partners();

        $user_province = $this->session->userdata('province_id');
        $user_city = $this->session->userdata('city_id');

        $this->data['user_province'] = $user_province;
        $this->data['user_city'] = $user_city;

        // Ambil tahun dan bulan dalam bentuk array
        $this->data['year_options'] = [
            '2025' => '2025',
            '2026' => '2026'
        ];

        // Ambil tahun dan bulan dalam bentuk array
        $this->data['year_options_2'] = [
            '2024' => '2024',
            '2025' => '2025',
            '2026' => '2026'
        ];

        // $this->data['month_options'] = [
        //     'all'  => '-- Bulan --',
        //     '1'  => 'January',
        //     '2'  => 'February',
        //     '3'  => 'March',
        //     '4'  => 'April',
        //     '5'  => 'May',
        //     '6'  => 'June',
        //     '7'  => 'July',
        //     '8'  => 'August',
        //     '9'  => 'September',
        //     '10' => 'October',
        //     '11' => 'November',
        //     '12' => 'December'
        // ];

        

        // Inisialisasi data awal (belum ada filter yang diterapkan)
        $this->data['selected_partner'] = '';
        $this->data['activities'] = [];
        $this->data['title'] = 'Laporan Kerangka Kerja Penurunan Zero Dose';

        

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia

        // Memuat data terjemahan
        $translations = $this->load_translation_report($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

        $this->data['month_options'] = $translations['type_report'];

        // Ambil data provinsi untuk dropdown
        $provinces = $this->Immunization_model->get_provinces();
        $this->data['province_options'] = ['all' => '-- '.$translations['province'].' --'];
        foreach ($provinces as $province) {
            $this->data['province_options'][$province->id] = $province->name_id;
        }

        load_template('report', $this->data);
    }

    private function load_translation_report($lang) {
        $translations = [
            'en' => [
                'page_title' => 'Zero Dose Reduction Framework Report',
                'page_subtitle' => '',
                'filter_label' => 'Select Filter',
                'text1' => 'Download Report',
                'text2' => 'Send Report via Email',
                'text3' => 'Download Partner Report',
                'text4' => 'Send Partner Report via Email',
                'text5' => 'Send',
                'province' => 'Province',
                'city' => 'City',
                'type_report' => [
                    'all' => 'Annual Report',
                    6 => 'Mid-Year Report',
                ]
            ],
            'id' => [
                'page_title' => 'Laporan Kerangka Kerja Penurunan Zero Dose',
                'page_subtitle' => '',
                'filter_label' => 'Pilih Filter',
                'text1' => 'Unduh Laporan',
                'text2' => 'Kirim Laporan Melalui Email',
                'text3' => 'Unduh Laporan Mitra',
                'text4' => 'Kirim Laporan Mitra Melalui Email',
                'text5' => 'Kirim',
                'province' => 'Provinsi',
                'city' => 'Kabkota',
                'type_report' => [
                    'all' => 'Laporan Akhir Tahun',
                    6 => 'Laporan Tengah Tahun',
                ]
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default to Bahasa Indonesia
    }

    public function contohdetail($partner_id = 'all') {
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
            $selected_province = $this->input->post('province_id') ?? 'all';
            $selected_district = $this->input->post('city_id') ?? 'all';
            $selected_year = $this->input->post('year') ?? 2024; // Default tahun 2025
            // $selected_month = $this->input->post('month') ?? date('m'); // Default bulan saat ini 2025
            $selected_month = $this->input->post('month') ?? 'all'; // Default bulan saat ini 2025

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
            $this->data['national_baseline_zd'] = $this->Immunization_model->get_baseline_zd(2024);
        } else {
            // Ambil total ZD dari tabel zd_cases_2023 berdasarkan provinsi yang dipilih
            $this->data['national_baseline_zd'] = $this->Report_model->get_zero_dose_by_province($selected_province, $selected_district);
        }

        // Menentukan baseline DPT 3 dan MR 1
        $this->data['national_baseline_dpt_mr'] = $this->Report_model->get_baseline_by_province($selected_province);

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
        $baseline_zd = $this->data['national_baseline_zd'];
        $baseline_zd = ($year <= 2025 ) ? number_format($baseline_zd * 0.85, 0, ',', '.') : number_format($baseline_zd * 0.75, 0, ',', '.');
        $percent_dpt3_coverage = $this->data["percent_dpt_3_$year"];
        $total_dpt3_coverage = $this->data["total_dpt_3_$year"];

        //Baseline DPT 3
        // $total_dpt3_target = $this->data["total_target_dpt_3_$year"];
        $total_dpt3_target = $this->data['national_baseline_dpt_mr']['dpt3'];

        $total_mr1_coverage = $this->data["total_mr_1_$year"];
        $percent_mr1_coverage = $this->data["percent_mr_1_$year"];

        //Baseline MR 1
        // $total_mr1_target = $this->data["total_target_mr_1_$year"];
        $total_mr1_target = $this->data['national_baseline_dpt_mr']['mr1'];

        $total_dpt1_coverage = $this->data["total_dpt_1_$year"];
        $total_dpt1_target = $this->data["total_target_dpt_1_$year"];

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

        if ($selected_district === 'all'){
            
            $total_district_under_5_DO = $this->data['total_dropout_rate']; //Jumlah Kab/Kota dengan %DO dibawah 5%
            
            $total_cities = $this->Report_model->get_total_regencies_cities($selected_province);

            // Menghitung Persen KabKota dengan DO Rate dibawah 5%
            $percentage_under_5_DO = ($total_cities > 0) 
                ? round(($total_district_under_5_DO / $total_cities) * 100, 2)
                : 0;

            $percentage_under_5_DO = number_format($percentage_under_5_DO, 1, ',', '.');
        } else {
            // Mendapatkan dropout rates per distrik
            $dropout_rates = $this->Report_model->get_puskesmas_under_5_percent_in_district($selected_province,$selected_district,$selected_year, $selected_month);
            
            $total_district_under_5_DO =  $dropout_rates; //Jumlah Puskesmas dengan %DO dibawah 5%
            
            $total_cities = $this->Report_model->get_total_puskesmas_in_district($selected_district);

            // Menghitung Persen KabKota dengan DO Rate dibawah 5%
            $percentage_under_5_DO = ($total_cities > 0) 
                ? round(($total_district_under_5_DO / $total_cities) * 100, 2)
                : 0;

            $percentage_under_5_DO = number_format($percentage_under_5_DO, 1, ',', '.');
        }

        // var_dump($total_cities);
        // var_dump($total_district_under_5_DO);
        // var_dump($percentage_under_5_DO);
        // exit;

        $dropout_rate_all_provinces = $this->data['dropout_rate_all_provinces'];

        // Ambil data jumlah puskesmas & imunisasi dari model baru
        $puskesmas_data = $this->Report_model->get_puskesmas_data($selected_province, $selected_district, $selected_year, $selected_month);
        $this->data['total_immunized_puskesmas'] = $puskesmas_data['total_immunized_puskesmas'];
        $this->data['percentage_puskesmas'] = $puskesmas_data['percentage'];
        $this->data['total_puskesmas'] = $puskesmas_data['total_puskesmas'];

        $puskesmas_conduct_immunization = $this->data['total_immunized_puskesmas'];
        $percentage_puskesmas_conduct_immunization = $this->data['percentage_puskesmas'];
        $total_puskesmas = $this->data['total_puskesmas'];

        // Ambil data jumlah Supportive Supervision
        $ss_data = $this->Report_model->get_supportive_supervision_targeted_summary($selected_province, $selected_district, $selected_year, $selected_month);

        $ss_category_good = $ss_data['total_good_puskesmas'];
        $ss_total_ss = $ss_data['total_ss'];
        $ss_percentage_good = $ss_data['percentage_good'];
        $ss_total_puskesmas = $ss_data['total_puskesmas'];

        // $this->data["total_dpt_stockout_$year"] = $this->Report_model->get_total_dpt_stock_out($selected_province, $selected_district, $selected_year, $selected_month);
        $this->data["total_dpt_stockout_$year"] = $this->Report_model->get_stockout_summary($selected_province, $selected_district, $selected_year, $selected_month);

        $total_dpt_stockout = $this->data["total_dpt_stockout_$year"]['total_stockout'];
        $stockout_total_puskesmas = $this->data["total_dpt_stockout_$year"]['total_puskesmas'];
        $stockout_percentage = $this->data["total_dpt_stockout_$year"]['percentage_stockout'];
        
        // TABLE 3

        // Mengambil data provinsi menggunakan model
        $list_province = $this->Report_model->get_provinces();
        $table_do = []; // Array untuk menyimpan hasil laporan

        if($selected_province === 'all' || $selected_province === 'targeted'){
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
                    'do_rate' => number_format($do_rate, 2, ',', '.'),  // DO rate dalam format 2 desimal
                    'cities_do_under_5' => $cities_do_under_5,
                    'percentage_cities_do_under_5' => number_format($percentage_cities_do_under_5, 2, ',', '.') . '%',  // Persentase dengan format %
                ];

                // Fungsi pembanding untuk mengurutkan berdasarkan persentase (dalam bentuk numerik)
                usort($table_do, function($a, $b) {
                    // Menghapus tanda persen dan mengkonversi ke angka
                    $percentage_a = (float) str_replace('%', '', $a['percentage_cities_do_under_5']);
                    $percentage_b = (float) str_replace('%', '', $b['percentage_cities_do_under_5']);

                    // Urutkan dari yang terbesar
                    if ($percentage_a == $percentage_b) {
                        return 0;
                    }
                    return ($percentage_a > $percentage_b) ? -1 : 1;
                });

                // Sekarang $table_do sudah terurut berdasarkan 'percentage_cities_do_under_5' dari yang terbesar
            }
        } else {
            if ($selected_district !== 'all'){
                // echo 'hi2';
                $dpt_under_5_data_by_district = $this->Report_model->get_districts_under_5_percent_by_district($selected_province,$selected_district,$selected_year, $selected_month);
                foreach ($dpt_under_5_data_by_district as $row){
                    // Periksa apakah dropout_rate dan total_do kurang dari 0, jika iya set ke 0
                    $dropout_rate = ($row['dropout_rate'] < 0) ? 0 : number_format($row['dropout_rate'], 2, ',', '.');
                    $total_do = ($row['total_do'] < 0) ? 0 : $row['total_do'];

                    $table_do[] = [
                        'puskesmas_name' => $row['puskesmas_name'],
                        'dropout_rate' => $dropout_rate,  // DO rate dalam format 2 desimal
                        'total_do' => $total_do
                    ];
                }
            } else {
                // Data per province
                $dpt_under_5_data_by_province = $this->Report_model->get_districts_under_5_percent_by_province($selected_province,$selected_district,$selected_year, $selected_month);
                foreach ($dpt_under_5_data_by_province as $row){
                    // Periksa apakah dropout_rate dan total_do kurang dari 0, jika iya set ke 0
                    $dropout_rate = ($row['dropout_rate'] < 0) ? 0 : number_format($row['dropout_rate'], 2, ',', '.');
                    $total_do = ($row['total_do'] < 0) ? 0 : $row['total_do'];

                    $table_do[] = [
                        'city_name' => $row['city_name'],
                        'dropout_rate' => $dropout_rate,  // DO rate dalam format 2 desimal
                        'total_do' => $total_do
                    ];
                }
            }

            // Fungsi pembanding untuk mengurutkan berdasarkan dropout_rate (dalam bentuk numerik)
            usort($table_do, function($a, $b) {
                // Mengonversi dropout_rate dari format string ke angka desimal
                $dropout_rate_a = (float) str_replace(',', '.', $a['dropout_rate']);
                $dropout_rate_b = (float) str_replace(',', '.', $b['dropout_rate']);

                // Urutkan dari yang terbesar
                if ($dropout_rate_a == $dropout_rate_b) {
                    return 0;
                }
                return ($dropout_rate_a > $dropout_rate_b) ? -1 : 1;
            });

            // Sekarang $table_do sudah terurut berdasarkan 'dropout_rate' dari yang terbesar

        }
        

        
        // TABLE 4

        // Array untuk menyimpan laporan puskesmas imunisasi
        $table_puskesmas_immunization = [];

        if($selected_province === 'all' || $selected_province === 'targeted'){
            $immunization_data = $this->Report_model->get_immunization_puskesmas_table($selected_province,$selected_district,$selected_year, $selected_month);

            foreach ($list_province as $province) {
                $province_id = $province['id'];  // ID Provinsi
                $province_name = $province['name_id'];  // Nama Provinsi (gunakan 'name_id' jika nama provinsi dalam bahasa Indonesia)
    
                // Inisialisasi variabel untuk menyimpan data
                $total_puskesmas_with_immunization = 0;
                $total_puskesmas = 0;
                $percentage_immunization = 0;

                $total_ss = 0;
                $total_good_puskesmas = 0;
                $percentage_good = 0;
    
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

                        // Ambil total puskesmas yang sudah di ss
                        $total_ss = $data['total_ss'];
                        // Ambil total puskesmas dengan kategori baik
                        $total_good_puskesmas = $data['total_good_puskesmas'];
                        // Hitung persentase kategori baik
                        $percentage_good = $data['percentage_good'];

                        break;  // Setelah ditemukan data untuk provinsi ini, keluar dari loop
                    }
                }
    
                // Masukkan data ke dalam array $table_puskesmas_immunization
                $table_puskesmas_immunization[] = [
                    'province_id' => $province_id,
                    'province_name' => $province_name,
                    'total_puskesmas_with_immunization' => $total_puskesmas_with_immunization,
                    'total_puskesmas' => $total_puskesmas,
                    'percentage_immunization' => number_format($percentage_immunization, 2, ',', '.'),
                    'total_ss' => $total_ss,
                    'total_good_puskesmas' => $total_good_puskesmas,
                    'percentage_good' => number_format($percentage_good, 2, ',', '.')
                ];
                
            }
        } else {
            if ($selected_district !== 'all'){
                $immunization_data = $this->Report_model->get_immunization_puskesmas_table_by_district($selected_province,$selected_district,$selected_year, $selected_month);
                
                foreach ($immunization_data as $row) {
                    // Masukkan data ke dalam array $table_puskesmas_immunization
                    $table_puskesmas_immunization[] = [
                        'puskesmas_name' => $row['puskesmas_name']
                    ];
                }
            } else {
                $immunization_data = $this->Report_model->get_immunization_puskesmas_table_by_province($selected_province,$selected_district,$selected_year, $selected_month);

                foreach ($immunization_data as $row){
                    $table_puskesmas_immunization[] = [
                        'city_name' => $row['city_name'],
                        'total_puskesmas_with_immunization' => $row['total_puskesmas_with_immunization'],
                        'total_puskesmas' => $row['total_puskesmas'],
                        'percentage_immunization' => number_format($row['percentage_immunization'], 2, ',', '.'),
                        'total_ss' => $row['total_ss'],
                        'total_good_puskesmas' => $row['total_good_puskesmas'],
                        'percentage_good' => number_format($row['percentage_good'], 2, ',', '.')
                    ];
                }
            }
        }
        

        // TABLE 5
        // Array untuk menyimpan laporan puskesmas stock out
        $table_puskesmas_stock_out = [];

        if($selected_province === 'all' || $selected_province === 'targeted'){
            $puskesmas_dpt_stock_out_data = $this->Report_model->get_puskesmas_dpt_stock_out_table($selected_province,$selected_district,$selected_year, $selected_month);
                
                // var_dump($puskesmas_dpt_stock_out_data);
                // exit;
                foreach ($puskesmas_dpt_stock_out_data as $row){
                    // Masukkan data ke dalam array $table_puskesmas_stock_out
                    $table_puskesmas_stock_out[] = [
                        'province_id' => $row['province_id'],
                        'province_name' => $row['province_name'],
                        'total_stock_out' => $row['total_stockout'],
                        'total_puskesmas' => $row['total_puskesmas'],
                        'percentage_stock_out' => number_format($row['percentage_stockout'], 2, ',', '.')
                    ];
                }
        } else {
            if ($selected_district !== 'all'){
                $puskesmas_dpt_stock_out_data = $this->Report_model->get_puskesmas_dpt_stock_out_table_by_district($selected_province,$selected_district,$selected_year, $selected_month);

                // Cari data puskesmas dengan DPT stock out berdasarkan provinsi
                foreach ($puskesmas_dpt_stock_out_data as $data) {

                    // Masukkan data ke dalam array $table_puskesmas_stock_out
                    $table_puskesmas_stock_out[] = [
                        'puskesmas_name' => $data['puskesmas_name']
                        // 'month' => $data['month']
                    ];
                }
            } else {
                $puskesmas_dpt_stock_out_data = $this->Report_model->get_puskesmas_dpt_stock_out_table_by_province($selected_province,$selected_district,$selected_year, $selected_month);

                // Cari data puskesmas dengan DPT stock out berdasarkan provinsi
                foreach ($puskesmas_dpt_stock_out_data as $row) {
                    
                    $table_puskesmas_stock_out[] = [
                        'province_name' => $row['province_name'],
                        'city_id' => $row['city_id'],
                        'city_name' => $row['city_name'],
                        'total_stock_out' => $row['total_stockout'],
                        'total_puskesmas' => $row['total_puskesmas'],
                        'percentage_stock_out' => number_format($row['percentage_stockout'], 2, ',', '.')
                    ];
                }

                
            }
        }
        
        
        // var_dump($table_puskesmas_stock_out);
        // exit;

        // var_dump($table_puskesmas_stock_out);
        // exit;

        // Data contoh, kamu bisa mengganti ini dengan data asli dari database
        $province_name = "Indonesia";
    
        $data = [
            'cumulative_dpt3' => '<span style="font-size:22pt; font-weight: bold;">' . number_format($total_dpt3_coverage, 0, ',', '.') 
                                        . '</span> <br><br>' . number_format($percent_dpt3_coverage, 1, ',', '.') . '% dari sasaran'
                                        . '<br> Baseline : ' . number_format($total_dpt3_target, 0, ',', '.'),
            'cumulative_mr1' => '<span style="font-size:22pt; font-weight: bold;">' . number_format($total_mr1_coverage, 0, ',', '.') 
                                        . '</span> <br><br>' . number_format($percent_mr1_coverage, 1, ',', '.') . '% dari sasaran'
                                        . '<br> Baseline : ' . number_format($total_mr1_target, 0, ',', '.'),
            'children_zero_dose' => number_format($zero_dose, 0, ',', '.'),
            'baseline_zd' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;"> Target ' . (($year <= 2025 ) ? '15% : ' : '25% : ') . $baseline_zd . ' </span>',
            'cumulative_dpt1' => '<span style="font-size:22pt; font-weight: bold;">' . number_format($total_dpt1_coverage, 0, ',', '.') 
                                    . '</span> <br><br>' . number_format($percent_dpt1_coverage, 1, ',', '.') . '% dari sasaran'
                                    . '<br> Sasaran : ' . number_format($total_dpt1_target, 0, ',', '.') ,
            'drop_out_percentage' => number_format($dropout_rate_all_provinces, 1, ',', '.') . '% <br>',
            'puskesmas_percentage' => number_format($total_district_under_5_DO, 0, ',', '.'),
            'district_under_5_puskesmas' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;">' . $percentage_under_5_DO . (($selected_district === 'all') ? '% dari total Kab/Kota' : '% dari total puskesmas') . ' </span>',
            'puskesmas_conduct_immunization' => number_format($ss_category_good, 0, ',', '.'),
            'total_ss' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;">' . number_format($ss_percentage_good, 1, ',', '.') . '% dari total Puskesmas'
                                                        . '<br> Total SS : ' . number_format($ss_total_ss, 0, ',', '.') . '</span>',
            'percentage_puskesmas_conduct_immunization' => number_format($percentage_puskesmas_conduct_immunization, 1, ',', '.') . '%',
            'total_puskesmas_conduct_immunization' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;"> ' . number_format($puskesmas_conduct_immunization, 0, ',', '.') . ' Puskesmas'
                                                        . '<br>' . (($year <= 2025 ) ? 'Tanpa Target' : 'Target 80%') . '</span>',
            'total_dpt_stockout' => number_format($total_dpt_stockout, 0, ',', '.'),
            'percentage_stockout' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;">' . number_format($stockout_percentage, 1, ',', '.') . '% dari total Puskesmas'
                                                        . '<br> Total Puskesmas : ' . number_format($stockout_total_puskesmas, 0, ',', '.') . '</span>',
            'province_do' => $table_do,
            'puskesmas_do_immunization' => $table_puskesmas_immunization,
            'puskesmas_dpt_stock_out_data' => $table_puskesmas_stock_out
        ];

        // Array nama bulan
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        if ($this->input->post('month')){
            if (isset($months[$selected_month])) {
                $title_month = ' Bulan ' . $months[$selected_month];  // Gunakan nama bulan
            } else {
                $title_month = '';  // Jika bulan tidak valid
            }
        } else {
            $title_month = '';
        }

        // Mendapatkan nama provinsi
        $province_name = $this->Report_model->get_province_name_by_id($selected_province);

        // Mendapatkan nama kabupaten/kota
        $district_name = $this->Report_model->get_district_name_by_id($selected_district);

        if ($selected_province !== 'all'){
            if ($selected_district !== 'all'){
                $title_area = $district_name . ' '; // Gunakan nama Kab Kota
            } else {
                $title_area = 'Provinsi ' . $province_name .' '; // Gunakan nama Provinsi
            }

        } else {
            $title_area = 'Indonesia '; // Gunakan nama Indonesia
        }

        $title_year = 'Tahun ' . $selected_year;
    
        // Membuat objek TCPDF
        // Buat objek PDF
        // **1. Pastikan TCPDF sudah ada di lokasi yang benar**
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php'); 
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Zero Dose Indonesia Team');
        $pdf->SetTitle('Laporan Kerangka Kerja Penurunan Zero Dose ' . $title_area);
        $pdf->SetHeaderData('', 0, 'Laporan Kerangka Kerja Penurunan Zero Dose', $title_area  . $title_year . $title_month);
    
        // Mengatur margin
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/kemkes_update.jpg'), 30, 18, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/imunisasi_lengkap.jpg'), 55, 15, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/logo.jpg'), 82, 20, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/undp-logo-blue.jpg'), 112, 20, 6, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);
        
        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/who_update.jpg'), 130, 20, 25, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/unicef_update.jpg'), 165, 20, 11, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan jarak antara gambar dan judul (gunakan Ln untuk jarak)
        $pdf->Ln(20);  // Menambah jarak 25 unit antara gambar dan judul

        // Judul laporan
        $html = '<h2 style="text-align:center; font-size:18pt;">Laporan Kerangka Kerja Penurunan Zero Dose di <br>'. $title_area .'</h2>';

        // $html .= "<h4>Indonesia</h4>";
        $html .= '<p style="margin-bottom: 20px;"></p>';

        // Tabel 1: Indikator Jangka Panjang
        $html .= '<h3 style="font-size:14pt; ">Indikator Jangka Panjang</h3>';
        $html .= '<table border="1" cellpadding="10" style="text-align:center; border-color: #dddddd;">
                    <thead>
                        <tr>
                            <th style="background-color: green; color: white; font-weight: bold;">Cakupan DPT-3</th>
                            <th style="background-color: green; color: white; font-weight: bold;">Cakupan MR-1</th>
                            <th style="background-color: green; color: white; font-weight: bold;">Jumlah anak yang belum diimunisasi DPT-1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size:12pt; ">' . $data['cumulative_dpt3'] . '</td>
                            <td style="font-size:12pt; ">' . $data['cumulative_mr1'] . '</td>
                            <td style="font-size:22pt; font-weight: bold; color: #d9534f; ">' . $data['children_zero_dose'] . '</td>
                        </tr>
                    </tbody>
                </table>';

        // Menambahkan jarak antara tabel pertama dan kedua
        $html .= '<br>';
        
            // Tabel 2: Indikator Jangka Menengah
            $html .= '<h3 style="font-size:14pt;">Indikator Jangka Menengah</h3>';
            $html .= '<table border="1" cellpadding="10" style="text-align:center; border-color: #dddddd;">
                        <thead>
                            <tr>
                                <th style="background-color: blue; color: white; font-weight: bold;">Cakupan DPT-1</th>
                                <th style="background-color: blue; color: white; font-weight: bold;">% Drop Out</th>';

                
                if ($selected_district === 'all') {
                    $html .=    '<th style="background-color: blue; color: white; font-weight: bold;">Jumlah Kab/Kota dengan %DO dibawah 5%</th>';
                } else {
                    $html .=    '<th style="background-color: blue; color: white; font-weight: bold;">Jumlah Puskesmas dengan %DO dibawah 5%</th>';
                }

            $html .=       '</tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-size:12pt; ">' . $data['cumulative_dpt1'] . '</td>
                                <td style="font-size:22pt; font-weight: bold; color: #d9534f; ">' . $data['drop_out_percentage'] . '</td>
                                <td style="font-size:22pt; font-weight: bold; ">' . $data['puskesmas_percentage'] 
                                                                                    . $data['district_under_5_puskesmas'] 
                                                                                    . '</td>
                            </tr>
    
                            <tr>
                                <th style="background-color: blue; color: white; font-weight: bold;">% puskesmas yang melakukan pelayanan imunisasi</th>
                                <th style="background-color: blue; color: white; font-weight: bold;">Jumlah puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional</th>
                                <th style="background-color: blue; color: white; font-weight: bold;">Jumlah puskesmas dengan status DPT stock out</th>
                            </tr>
    
                            <tr>
                                <td style="font-size:22pt; font-weight: bold; ">' . $data['percentage_puskesmas_conduct_immunization'] . $data['total_puskesmas_conduct_immunization'] . '</td>
                                <td style="font-size:22pt; font-weight: bold; ">' . $data['puskesmas_conduct_immunization'] . $data['total_ss'] . '</td>
                                <td style="font-size:22pt; font-weight: bold; color: #d9534f; ">' . $data['total_dpt_stockout'] . $data['percentage_stockout'] . '</td>
                            </tr>
                        </tbody>
                    </table>';
        
            
                    // Menambahkan jarak antara tabel kedua dan ketiga
            $html .= '<br><br>';
        
        // Menulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Tambahkan halaman baru sebelum menampilkan gambar grafik
        $pdf->AddPage();

        if($selected_province === 'all' || $selected_province === 'targeted'){
        
            // Tabel 3: Kab/Ko dengan % DO dibawah 5%
            $html2 .= '<h3 style="font-size:14pt;">Kab/Kota dengan % DO dibawah 5%</h3>';
            $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Nama Provinsi</th>
                                <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">% Anak DO</th>
                                <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Jumlah Kab/Kota dengan % DO dibawah 5%</th>
                                <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">% Kab/Kota dengan % DO dibawah 5%</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($data['province_do'] as $item) {
                $html2 .= "<tr>
                            <td><b>{$item['name']}</b></td>
                            <td>{$item['do_rate']}%</td>
                            <td>{$item['cities_do_under_5']}</td>
                            <td>{$item['percentage_cities_do_under_5']}</td>
                        </tr>";
            }
            $html2 .= '</tbody></table>';

            // Menambahkan jarak antara tabel keempat dan kelima
            $html2 .= '<br><br>';
        
            // Tabel 4: Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
            // // $html2 .= '<h3 style="font-size:14pt;">Jumlah Puskesmas yang melakukan pelayanan imunisasi</h3>';
            // // $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
            // //             <thead>
            // //                 <tr>
            // //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Nama Provinsi</th>
            // //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas</th>
            // //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">% Puskesmas</th>
            // //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas yang di supervisi suportif</th>
            // //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas yang telah disupervisi suportif dengan hasil kategori baik</th>
            // //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Persentase Kategori "Baik"</th>
            // //                 </tr>
            // //             </thead>
            // //             <tbody>';
            // // foreach ($data['puskesmas_do_immunization'] as $item) {
            // //     $html2 .= "<tr>
            // //                 <td><b>{$item['province_name']}</b></td>
            // //                 <td>{$item['total_puskesmas_with_immunization']}</td>
            // //                 <td>{$item['percentage_immunization']}%</td>
            // //                 <td>{$item['total_ss']}</td>
            // //                 <td>{$item['total_good_puskesmas']}</td>
            // //                 <td>{$item['percentage_good']}%</td>
            // //             </tr>";
            // // }
            // // $html2 .= '</tbody></table>';
        
            // // Menambahkan jarak antara tabel ketiga dan keempat
            // $html2 .= '<br><br>';
        
            // Tabel 5: Puskesmas dengan status DPT stock out
            $html2 .= '<h3 style="font-size:14pt;">Jumlah Puskesmas dengan status DPT stock out</h3>';
            $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Nama Provinsi</th>
                                <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Jumlah Puskesmas</th>
                                <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">% Puskesmas</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
                $html2 .= "<tr>
                            <td><b>{$item['province_name']}</b></td>
                            <td>{$item['total_stock_out']}</td>
                            <td>{$item['percentage_stock_out']}%</td>
                        </tr>";
            }
            $html2 .= '</tbody></table>';
    
        } else {
            if ($selected_district !== 'all'){
                // Tabel 3: Kab/Ko dengan % DO dibawah 5%
                $html2 .= '<h3 style="font-size:14pt;">Puskesmas dengan % DO dibawah 5%</h3>';
                $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Nama Puskesmas</th>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Jumlah Anak DO</th>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">% Anak DO</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($data['province_do'] as $item) {
                    $html2 .= "<tr>
                                <td><b>{$item['puskesmas_name']}</b></td>
                                <td>{$item['total_do']}</td>
                                <td>{$item['dropout_rate']}%</td>
                            </tr>";
                }
                $html2 .= '</tbody></table>';

                // Menambahkan jarak antara tabel keempat dan kelima
                $html2 .= '<br><br>';
            
                // Tabel 4: Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
                // $html2 .= '<h3 style="font-size:14pt;">Puskesmas yang melakukan pelayanan imunisasi</h3>';
                // $html2 .= '<table border="1" cellpadding="10" style="text-align: left;">
                //             <thead>
                //                 <tr align="center">
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">NAMA PUSKESMAS</th>
                //                 </tr>
                //             </thead>
                //             <tbody>';
                // $no = 0;
                // // foreach ($data['puskesmas_do_immunization'] as $item) {
                // //     $no++;
                // //     $html2 .= "
                // //             <tr>
                // //                 <td>{$item['puskesmas_name']}</td>
                // //             </tr>";
                // // }
                // $html2 .= '</tbody></table>';
            
                // // Menambahkan jarak antara tabel ketiga dan keempat
                // $html2 .= '<br><br>';

                // Tabel 5: Puskesmas dengan status DPT stock out
                $html2 .= '<h3 style="font-size:14pt;">Puskesmas dengan status DPT stock out</h3>';
                $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Nama Puskesmas</th>
                                    
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
                    $html2 .= "<tr>
                                <td><b>{$item['puskesmas_name']}</b></td>
                            </tr>";
                }
                $html2 .= '</tbody></table>';

            } else {
                // Tabel 3: Kab/Ko dengan % DO dibawah 5%
                $html2 .= '<h3 style="font-size:14pt;">Kab/Kota dengan % DO dibawah 5%</h3>';
                $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Nama Kab/Kota</th>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Jumlah Anak DO</th>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">% Anak DO</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($data['province_do'] as $item) {
                    $html2 .= "<tr>
                                <td><b>{$item['city_name']}</b></td>
                                <td>{$item['total_do']}</td>
                                <td>{$item['dropout_rate']}%</td>
                            </tr>";
                }
                $html2 .= '</tbody></table>';

                // Menambahkan jarak antara tabel keempat dan kelima
                $html2 .= '<br><br>';
            
                // Tabel 4: Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
                // $html2 .= '<h3 style="font-size:14pt;"> Jumlah Puskesmas yang melakukan pelayanan imunisasi</h3>';
                // $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                //             <thead>
                //                 <tr>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Nama Kab/Kota</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">% Puskesmas</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas yang di supervisi suportif</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas yang telah disupervisi suportif dengan hasil kategori baik</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Persentase Kategori "Baik"</th>
                //                 </tr>
                //             </thead>
                //             <tbody>';
                // foreach ($data['puskesmas_do_immunization'] as $item) {
                //     $html2 .= "<tr>
                //                 <td><b>{$item['city_name']}</b></td>
                //                 <td>{$item['total_puskesmas_with_immunization']}</td>
                //                 <td>{$item['percentage_immunization']}%</td>
                //                 <td>{$item['total_ss']}</td>
                //                 <td>{$item['total_good_puskesmas']}</td>
                //                 <td>{$item['percentage_good']}%</td>
                //             </tr>";
                // }
                // $html2 .= '</tbody></table>';
            
                // // Menambahkan jarak antara tabel ketiga dan keempat
                // $html2 .= '<br><br>';
            
                // Tabel 5: Puskesmas dengan status DPT stock out
                $html2 .= '<h3 style="font-size:14pt;"> Jumlah Puskesmas dengan status DPT stock out</h3>';
                $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Nama Kab/Kota</th>
                                    <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Jumlah Puskesmas</th>
                                    <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">% Puskesmas</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
                    $html2 .= "<tr>
                                <td><b>{$item['city_name']}</b></td>
                                <td>{$item['total_stock_out']}</td>
                                <td>{$item['percentage_stock_out']}%</td>
                            </tr>";
                }
                $html2 .= '</tbody></table>';
            }
        }
        
        // Menulis HTML ke PDF
        $pdf->writeHTML($html2, true, false, true, false, '');
    
        // Menyelesaikan PDF dan menampilkan di browser
        ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        $pdf->Output('Laporan_Zerodose_Indonesia.pdf', 'I');
        exit();
    }

    public function immunization_report_indonesia_attach($param_province, $param_district, $param_year, $param_month) {
        
        
                // Ambil filter provinsi dari dropdown (default: all)
                $selected_province = $param_province;
                $selected_district = $param_district;
                $selected_year = $param_year;
                // $selected_month = $this->input->post('month') ?? date('m'); // Default bulan saat ini 2025
                $selected_month = $param_month;

                $year = $selected_year;

        // Menentukan baseline ZD
        if ($selected_province == 'all') {
            // Ambil baseline ZD 2023 dari tabel target_baseline
            $this->data['national_baseline_zd'] = $this->Immunization_model->get_baseline_zd(2024);
        } else {
            // Ambil total ZD dari tabel zd_cases_2023 berdasarkan provinsi yang dipilih
            $this->data['national_baseline_zd'] = $this->Report_model->get_zero_dose_by_province($selected_province, $selected_district);
        }

        // Menentukan baseline DPT 3 dan MR 1
        $this->data['national_baseline_dpt_mr'] = $this->Report_model->get_baseline_by_province($selected_province);

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
        $baseline_zd = $this->data['national_baseline_zd'];
        $baseline_zd = ($year <= 2025 ) ? number_format($baseline_zd * 0.85, 0, ',', '.') : number_format($baseline_zd * 0.75, 0, ',', '.');
        $percent_dpt3_coverage = $this->data["percent_dpt_3_$year"];
        $total_dpt3_coverage = $this->data["total_dpt_3_$year"];

        //Baseline DPT 3
        // $total_dpt3_target = $this->data["total_target_dpt_3_$year"];
        $total_dpt3_target = $this->data['national_baseline_dpt_mr']['dpt3'];

        $total_mr1_coverage = $this->data["total_mr_1_$year"];
        $percent_mr1_coverage = $this->data["percent_mr_1_$year"];

        //Baseline MR 1
        // $total_mr1_target = $this->data["total_target_mr_1_$year"];
        $total_mr1_target = $this->data['national_baseline_dpt_mr']['mr1'];

        $total_dpt1_coverage = $this->data["total_dpt_1_$year"];
        $total_dpt1_target = $this->data["total_target_dpt_1_$year"];

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

        if ($selected_district === 'all'){
            
            $total_district_under_5_DO = $this->data['total_dropout_rate']; //Jumlah Kab/Kota dengan %DO dibawah 5%
            
            $total_cities = $this->Report_model->get_total_regencies_cities($selected_province);

            // Menghitung Persen KabKota dengan DO Rate dibawah 5%
            $percentage_under_5_DO = ($total_cities > 0) 
                ? round(($total_district_under_5_DO / $total_cities) * 100, 2)
                : 0;

            $percentage_under_5_DO = number_format($percentage_under_5_DO, 1, ',', '.');
        } else {
            // Mendapatkan dropout rates per distrik
            $dropout_rates = $this->Report_model->get_puskesmas_under_5_percent_in_district($selected_province,$selected_district,$selected_year, $selected_month);
            
            $total_district_under_5_DO =  $dropout_rates; //Jumlah Puskesmas dengan %DO dibawah 5%
            
            $total_cities = $this->Report_model->get_total_puskesmas_in_district($selected_district);

            // Menghitung Persen KabKota dengan DO Rate dibawah 5%
            $percentage_under_5_DO = ($total_cities > 0) 
                ? round(($total_district_under_5_DO / $total_cities) * 100, 2)
                : 0;

            $percentage_under_5_DO = number_format($percentage_under_5_DO, 1, ',', '.');
        }

        // var_dump($total_cities);
        // var_dump($total_district_under_5_DO);
        // var_dump($percentage_under_5_DO);
        // exit;

        $dropout_rate_all_provinces = $this->data['dropout_rate_all_provinces'];

        // Ambil data jumlah puskesmas & imunisasi dari model baru
        $puskesmas_data = $this->Report_model->get_puskesmas_data($selected_province, $selected_district, $selected_year, $selected_month);
        $this->data['total_immunized_puskesmas'] = $puskesmas_data['total_immunized_puskesmas'];
        $this->data['percentage_puskesmas'] = $puskesmas_data['percentage'];
        $this->data['total_puskesmas'] = $puskesmas_data['total_puskesmas'];

        $puskesmas_conduct_immunization = $this->data['total_immunized_puskesmas'];
        $percentage_puskesmas_conduct_immunization = $this->data['percentage_puskesmas'];
        $total_puskesmas = $this->data['total_puskesmas'];

        // Ambil data jumlah Supportive Supervision
        $ss_data = $this->Report_model->get_supportive_supervision_targeted_summary($selected_province, $selected_district, $selected_year, $selected_month);

        $ss_category_good = $ss_data['total_good_puskesmas'];
        $ss_total_ss = $ss_data['total_ss'];
        $ss_percentage_good = $ss_data['percentage_good'];
        $ss_total_puskesmas = $ss_data['total_puskesmas'];

        // $this->data["total_dpt_stockout_$year"] = $this->Report_model->get_total_dpt_stock_out($selected_province, $selected_district, $selected_year, $selected_month);
        $this->data["total_dpt_stockout_$year"] = $this->Report_model->get_stockout_summary($selected_province, $selected_district, $selected_year, $selected_month);

        $total_dpt_stockout = $this->data["total_dpt_stockout_$year"]['total_stockout'];
        $stockout_total_puskesmas = $this->data["total_dpt_stockout_$year"]['total_puskesmas'];
        $stockout_percentage = $this->data["total_dpt_stockout_$year"]['percentage_stockout'];
        
        // TABLE 3

        // Mengambil data provinsi menggunakan model
        $list_province = $this->Report_model->get_provinces();
        $table_do = []; // Array untuk menyimpan hasil laporan

        if($selected_province === 'all' || $selected_province === 'targeted'){
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
                    'do_rate' => number_format($do_rate, 2, ',', '.'),  // DO rate dalam format 2 desimal
                    'cities_do_under_5' => $cities_do_under_5,
                    'percentage_cities_do_under_5' => number_format($percentage_cities_do_under_5, 2, ',', '.') . '%',  // Persentase dengan format %
                ];

                // Fungsi pembanding untuk mengurutkan berdasarkan persentase (dalam bentuk numerik)
                usort($table_do, function($a, $b) {
                    // Menghapus tanda persen dan mengkonversi ke angka
                    $percentage_a = (float) str_replace('%', '', $a['percentage_cities_do_under_5']);
                    $percentage_b = (float) str_replace('%', '', $b['percentage_cities_do_under_5']);

                    // Urutkan dari yang terbesar
                    if ($percentage_a == $percentage_b) {
                        return 0;
                    }
                    return ($percentage_a > $percentage_b) ? -1 : 1;
                });

                // Sekarang $table_do sudah terurut berdasarkan 'percentage_cities_do_under_5' dari yang terbesar
            }
        } else {
            if ($selected_district !== 'all'){
                // echo 'hi2';
                $dpt_under_5_data_by_district = $this->Report_model->get_districts_under_5_percent_by_district($selected_province,$selected_district,$selected_year, $selected_month);
                foreach ($dpt_under_5_data_by_district as $row){
                    // Periksa apakah dropout_rate dan total_do kurang dari 0, jika iya set ke 0
                    $dropout_rate = ($row['dropout_rate'] < 0) ? 0 : number_format($row['dropout_rate'], 2, ',', '.');
                    $total_do = ($row['total_do'] < 0) ? 0 : $row['total_do'];

                    $table_do[] = [
                        'puskesmas_name' => $row['puskesmas_name'],
                        'dropout_rate' => $dropout_rate,  // DO rate dalam format 2 desimal
                        'total_do' => $total_do
                    ];
                }
            } else {
                // Data per province
                $dpt_under_5_data_by_province = $this->Report_model->get_districts_under_5_percent_by_province($selected_province,$selected_district,$selected_year, $selected_month);
                foreach ($dpt_under_5_data_by_province as $row){
                    // Periksa apakah dropout_rate dan total_do kurang dari 0, jika iya set ke 0
                    $dropout_rate = ($row['dropout_rate'] < 0) ? 0 : number_format($row['dropout_rate'], 2, ',', '.');
                    $total_do = ($row['total_do'] < 0) ? 0 : $row['total_do'];

                    $table_do[] = [
                        'city_name' => $row['city_name'],
                        'dropout_rate' => $dropout_rate,  // DO rate dalam format 2 desimal
                        'total_do' => $total_do
                    ];
                }
            }

            // Fungsi pembanding untuk mengurutkan berdasarkan dropout_rate (dalam bentuk numerik)
            usort($table_do, function($a, $b) {
                // Mengonversi dropout_rate dari format string ke angka desimal
                $dropout_rate_a = (float) str_replace(',', '.', $a['dropout_rate']);
                $dropout_rate_b = (float) str_replace(',', '.', $b['dropout_rate']);

                // Urutkan dari yang terbesar
                if ($dropout_rate_a == $dropout_rate_b) {
                    return 0;
                }
                return ($dropout_rate_a > $dropout_rate_b) ? -1 : 1;
            });

            // Sekarang $table_do sudah terurut berdasarkan 'dropout_rate' dari yang terbesar

        }
        

        
        // TABLE 4

        // Array untuk menyimpan laporan puskesmas imunisasi
        $table_puskesmas_immunization = [];

        if($selected_province === 'all' || $selected_province === 'targeted'){
            $immunization_data = $this->Report_model->get_immunization_puskesmas_table($selected_province,$selected_district,$selected_year, $selected_month);

            foreach ($list_province as $province) {
                $province_id = $province['id'];  // ID Provinsi
                $province_name = $province['name_id'];  // Nama Provinsi (gunakan 'name_id' jika nama provinsi dalam bahasa Indonesia)
    
                // Inisialisasi variabel untuk menyimpan data
                $total_puskesmas_with_immunization = 0;
                $total_puskesmas = 0;
                $percentage_immunization = 0;

                $total_ss = 0;
                $total_good_puskesmas = 0;
                $percentage_good = 0;
    
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

                        // Ambil total puskesmas yang sudah di ss
                        $total_ss = $data['total_ss'];
                        // Ambil total puskesmas dengan kategori baik
                        $total_good_puskesmas = $data['total_good_puskesmas'];
                        // Hitung persentase kategori baik
                        $percentage_good = $data['percentage_good'];

                        break;  // Setelah ditemukan data untuk provinsi ini, keluar dari loop
                    }
                }
    
                // Masukkan data ke dalam array $table_puskesmas_immunization
                $table_puskesmas_immunization[] = [
                    'province_id' => $province_id,
                    'province_name' => $province_name,
                    'total_puskesmas_with_immunization' => $total_puskesmas_with_immunization,
                    'total_puskesmas' => $total_puskesmas,
                    'percentage_immunization' => number_format($percentage_immunization, 2, ',', '.'),
                    'total_ss' => $total_ss,
                    'total_good_puskesmas' => $total_good_puskesmas,
                    'percentage_good' => number_format($percentage_good, 2, ',', '.')
                ];
                
            }
        } else {
            if ($selected_district !== 'all'){
                $immunization_data = $this->Report_model->get_immunization_puskesmas_table_by_district($selected_province,$selected_district,$selected_year, $selected_month);
                
                foreach ($immunization_data as $row) {
                    // Masukkan data ke dalam array $table_puskesmas_immunization
                    $table_puskesmas_immunization[] = [
                        'puskesmas_name' => $row['puskesmas_name']
                    ];
                }
            } else {
                $immunization_data = $this->Report_model->get_immunization_puskesmas_table_by_province($selected_province,$selected_district,$selected_year, $selected_month);

                foreach ($immunization_data as $row){
                    $table_puskesmas_immunization[] = [
                        'city_name' => $row['city_name'],
                        'total_puskesmas_with_immunization' => $row['total_puskesmas_with_immunization'],
                        'total_puskesmas' => $row['total_puskesmas'],
                        'percentage_immunization' => number_format($row['percentage_immunization'], 2, ',', '.'),
                        'total_ss' => $row['total_ss'],
                        'total_good_puskesmas' => $row['total_good_puskesmas'],
                        'percentage_good' => number_format($row['percentage_good'], 2, ',', '.')
                    ];
                }
            }
        }
        

        // TABLE 5
        // Array untuk menyimpan laporan puskesmas stock out
        $table_puskesmas_stock_out = [];

        if($selected_province === 'all' || $selected_province === 'targeted'){
            $puskesmas_dpt_stock_out_data = $this->Report_model->get_puskesmas_dpt_stock_out_table($selected_province,$selected_district,$selected_year, $selected_month);
                
                // var_dump($puskesmas_dpt_stock_out_data);
                // exit;
                foreach ($puskesmas_dpt_stock_out_data as $row){
                    // Masukkan data ke dalam array $table_puskesmas_stock_out
                    $table_puskesmas_stock_out[] = [
                        'province_id' => $row['province_id'],
                        'province_name' => $row['province_name'],
                        'total_stock_out' => $row['total_stockout'],
                        'total_puskesmas' => $row['total_puskesmas'],
                        'percentage_stock_out' => number_format($row['percentage_stockout'], 2, ',', '.')
                    ];
                }
        } else {
            if ($selected_district !== 'all'){
                $puskesmas_dpt_stock_out_data = $this->Report_model->get_puskesmas_dpt_stock_out_table_by_district($selected_province,$selected_district,$selected_year, $selected_month);

                // Cari data puskesmas dengan DPT stock out berdasarkan provinsi
                foreach ($puskesmas_dpt_stock_out_data as $data) {

                    // Masukkan data ke dalam array $table_puskesmas_stock_out
                    $table_puskesmas_stock_out[] = [
                        'puskesmas_name' => $data['puskesmas_name']
                        // 'month' => $data['month']
                    ];
                }
            } else {
                $puskesmas_dpt_stock_out_data = $this->Report_model->get_puskesmas_dpt_stock_out_table_by_province($selected_province,$selected_district,$selected_year, $selected_month);

                // Cari data puskesmas dengan DPT stock out berdasarkan provinsi
                foreach ($puskesmas_dpt_stock_out_data as $row) {
                    
                    $table_puskesmas_stock_out[] = [
                        'province_name' => $row['province_name'],
                        'city_id' => $row['city_id'],
                        'city_name' => $row['city_name'],
                        'total_stock_out' => $row['total_stockout'],
                        'total_puskesmas' => $row['total_puskesmas'],
                        'percentage_stock_out' => number_format($row['percentage_stockout'], 2, ',', '.')
                    ];
                }

                
            }
        }
        
        
        // var_dump($table_puskesmas_stock_out);
        // exit;

        // var_dump($table_puskesmas_stock_out);
        // exit;

        // Data contoh, kamu bisa mengganti ini dengan data asli dari database
        $province_name = "Indonesia";
    
        $data = [
            'cumulative_dpt3' => '<span style="font-size:22pt; font-weight: bold;">' . number_format($total_dpt3_coverage, 0, ',', '.') 
                                        . '</span> <br><br>' . number_format($percent_dpt3_coverage, 1, ',', '.') . '% dari sasaran'
                                        . '<br> Baseline : ' . number_format($total_dpt3_target, 0, ',', '.'),
            'cumulative_mr1' => '<span style="font-size:22pt; font-weight: bold;">' . number_format($total_mr1_coverage, 0, ',', '.') 
                                        . '</span> <br><br>' . number_format($percent_mr1_coverage, 1, ',', '.') . '% dari sasaran'
                                        . '<br> Baseline : ' . number_format($total_mr1_target, 0, ',', '.'),
            'children_zero_dose' => number_format($zero_dose, 0, ',', '.'),
            'baseline_zd' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;"> Target ' . (($year <= 2025 ) ? '15% : ' : '25% : ') . $baseline_zd . ' </span>',
            'cumulative_dpt1' => '<span style="font-size:22pt; font-weight: bold;">' . number_format($total_dpt1_coverage, 0, ',', '.') 
                                    . '</span> <br><br>' . number_format($percent_dpt1_coverage, 1, ',', '.') . '% dari sasaran'
                                    . '<br> Sasaran : ' . number_format($total_dpt1_target, 0, ',', '.') ,
            'drop_out_percentage' => number_format($dropout_rate_all_provinces, 1, ',', '.') . '% <br>',
            'puskesmas_percentage' => number_format($total_district_under_5_DO, 0, ',', '.'),
            'district_under_5_puskesmas' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;">' . $percentage_under_5_DO . (($selected_district === 'all') ? '% dari total Kab/Kota' : '% dari total puskesmas') . ' </span>',
            'puskesmas_conduct_immunization' => number_format($ss_category_good, 0, ',', '.'),
            'total_ss' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;">' . number_format($ss_percentage_good, 1, ',', '.') . '% dari total Puskesmas'
                                                        . '<br> Total SS : ' . number_format($ss_total_ss, 0, ',', '.') . '</span>',
            'percentage_puskesmas_conduct_immunization' => number_format($percentage_puskesmas_conduct_immunization, 1, ',', '.') . '%',
            'total_puskesmas_conduct_immunization' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;"> ' . number_format($puskesmas_conduct_immunization, 0, ',', '.') . ' Puskesmas'
                                                        . '<br>' . (($year <= 2025 ) ? 'Tanpa Target' : 'Target 80%') . '</span>',
            'total_dpt_stockout' => number_format($total_dpt_stockout, 0, ',', '.'),
            'percentage_stockout' => '<br> <span style="font-size:12pt; font-weight: normal; color: black;">' . number_format($stockout_percentage, 1, ',', '.') . '% dari total Puskesmas'
                                                        . '<br> Total Puskesmas : ' . number_format($stockout_total_puskesmas, 0, ',', '.') . '</span>',
            'province_do' => $table_do,
            'puskesmas_do_immunization' => $table_puskesmas_immunization,
            'puskesmas_dpt_stock_out_data' => $table_puskesmas_stock_out
        ];

        // Array nama bulan
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        if ($this->input->post('month')){
            if (isset($months[$selected_month])) {
                $title_month = ' Bulan ' . $months[$selected_month];  // Gunakan nama bulan
            } else {
                $title_month = '';  // Jika bulan tidak valid
            }
        } else {
            $title_month = '';
        }

        // Mendapatkan nama provinsi
        $province_name = $this->Report_model->get_province_name_by_id($selected_province);

        // Mendapatkan nama kabupaten/kota
        $district_name = $this->Report_model->get_district_name_by_id($selected_district);

        if ($selected_province !== 'all'){
            if ($selected_district !== 'all'){
                $title_area = $district_name . ' '; // Gunakan nama Kab Kota
            } else {
                $title_area = 'Provinsi ' . $province_name .' '; // Gunakan nama Provinsi
            }

        } else {
            $title_area = 'Indonesia '; // Gunakan nama Indonesia
        }

        $title_year = 'Tahun ' . $selected_year;
    
        // Membuat objek TCPDF
        // Buat objek PDF
        // **1. Pastikan TCPDF sudah ada di lokasi yang benar**
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php'); 
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Zero Dose Indonesia Team');
        $pdf->SetTitle('Laporan Kerangka Kerja Penurunan Zero Dose ' . $title_area);
        $pdf->SetHeaderData('', 0, 'Laporan Kerangka Kerja Penurunan Zero Dose', $title_area  . $title_year . $title_month);
    
        // Mengatur margin
        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/kemkes_update.jpg'), 30, 18, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/imunisasi_lengkap.jpg'), 55, 15, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/logo.jpg'), 82, 20, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/undp-logo-blue.jpg'), 112, 20, 6, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);
        
        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/who_update.jpg'), 130, 20, 25, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/unicef_update.jpg'), 165, 20, 11, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan jarak antara gambar dan judul (gunakan Ln untuk jarak)
        $pdf->Ln(20);  // Menambah jarak 25 unit antara gambar dan judul

        // Judul laporan
        $html = '<h2 style="text-align:center; font-size:18pt;">Laporan Kerangka Kerja Penurunan Zero Dose di <br>'. $title_area .'</h2>';

        // $html .= "<h4>Indonesia</h4>";
        $html .= '<p style="margin-bottom: 20px;"></p>';

        // Tabel 1: Indikator Jangka Panjang
        $html .= '<h3 style="font-size:14pt; ">Indikator Jangka Panjang</h3>';
        $html .= '<table border="1" cellpadding="10" style="text-align:center; border-color: #dddddd;">
                    <thead>
                        <tr>
                            <th style="background-color: green; color: white; font-weight: bold;">Cakupan DPT-3</th>
                            <th style="background-color: green; color: white; font-weight: bold;">Cakupan MR-1</th>
                            <th style="background-color: green; color: white; font-weight: bold;">Jumlah anak yang belum diimunisasi DPT-1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="font-size:12pt; ">' . $data['cumulative_dpt3'] . '</td>
                            <td style="font-size:12pt; ">' . $data['cumulative_mr1'] . '</td>
                            <td style="font-size:22pt; font-weight: bold; color: #d9534f; ">' . $data['children_zero_dose'] . '</td>
                        </tr>
                    </tbody>
                </table>';

        // Menambahkan jarak antara tabel pertama dan kedua
        $html .= '<br>';
        
            // Tabel 2: Indikator Jangka Menengah
            $html .= '<h3 style="font-size:14pt;">Indikator Jangka Menengah</h3>';
            $html .= '<table border="1" cellpadding="10" style="text-align:center; border-color: #dddddd;">
                        <thead>
                            <tr>
                                <th style="background-color: blue; color: white; font-weight: bold;">Cakupan DPT-1</th>
                                <th style="background-color: blue; color: white; font-weight: bold;">% Drop Out</th>';

                
                if ($selected_district === 'all') {
                    $html .=    '<th style="background-color: blue; color: white; font-weight: bold;">Jumlah Kab/Kota dengan %DO dibawah 5%</th>';
                } else {
                    $html .=    '<th style="background-color: blue; color: white; font-weight: bold;">Jumlah Puskesmas dengan %DO dibawah 5%</th>';
                }

            $html .=       '</tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="font-size:12pt; ">' . $data['cumulative_dpt1'] . '</td>
                                <td style="font-size:22pt; font-weight: bold; color: #d9534f; ">' . $data['drop_out_percentage'] . '</td>
                                <td style="font-size:22pt; font-weight: bold; ">' . $data['puskesmas_percentage'] 
                                                                                    . $data['district_under_5_puskesmas'] 
                                                                                    . '</td>
                            </tr>
    
                            <tr>
                                <th style="background-color: blue; color: white; font-weight: bold;">% puskesmas yang melakukan pelayanan imunisasi</th>
                                <th style="background-color: blue; color: white; font-weight: bold;">Jumlah puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional</th>
                                <th style="background-color: blue; color: white; font-weight: bold;">Jumlah puskesmas dengan status DPT stock out</th>
                            </tr>
    
                            <tr>
                                <td style="font-size:22pt; font-weight: bold; ">' . $data['percentage_puskesmas_conduct_immunization'] . $data['total_puskesmas_conduct_immunization'] . '</td>
                                <td style="font-size:22pt; font-weight: bold; ">' . $data['puskesmas_conduct_immunization'] . $data['total_ss'] . '</td>
                                <td style="font-size:22pt; font-weight: bold; color: #d9534f; ">' . $data['total_dpt_stockout'] . $data['percentage_stockout'] . '</td>
                            </tr>
                        </tbody>
                    </table>';
        
            
                    // Menambahkan jarak antara tabel kedua dan ketiga
            $html .= '<br><br>';
        
        // Menulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Tambahkan halaman baru sebelum menampilkan gambar grafik
        $pdf->AddPage();

        if($selected_province === 'all' || $selected_province === 'targeted'){
        
            // Tabel 3: Kab/Ko dengan % DO dibawah 5%
            $html2 .= '<h3 style="font-size:14pt;">Kab/Kota dengan % DO dibawah 5%</h3>';
            $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Nama Provinsi</th>
                                <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">% Anak DO</th>
                                <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Jumlah Kab/Kota dengan % DO dibawah 5%</th>
                                <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">% Kab/Kota dengan % DO dibawah 5%</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($data['province_do'] as $item) {
                $html2 .= "<tr>
                            <td><b>{$item['name']}</b></td>
                            <td>{$item['do_rate']}%</td>
                            <td>{$item['cities_do_under_5']}</td>
                            <td>{$item['percentage_cities_do_under_5']}</td>
                        </tr>";
            }
            $html2 .= '</tbody></table>';

            // Menambahkan jarak antara tabel keempat dan kelima
            $html2 .= '<br><br>';
        
            // Tabel 4: Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
            // $html2 .= '<h3 style="font-size:14pt;">Jumlah Puskesmas yang melakukan pelayanan imunisasi</h3>';
            // $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
            //             <thead>
            //                 <tr>
            //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Nama Provinsi</th>
            //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas</th>
            //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">% Puskesmas</th>
            //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas yang di supervisi suportif</th>
            //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas yang telah disupervisi suportif dengan hasil kategori baik</th>
            //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Persentase Kategori "Baik"</th>
            //                 </tr>
            //             </thead>
            //             <tbody>';
            // foreach ($data['puskesmas_do_immunization'] as $item) {
                // $html2 .= "<tr>
                //             <td><b>{$item['province_name']}</b></td>
                //             <td>{$item['total_puskesmas_with_immunization']}</td>
                //             <td>{$item['percentage_immunization']}%</td>
                //             <td>{$item['total_ss']}</td>
                //             <td>{$item['total_good_puskesmas']}</td>
                //             <td>{$item['percentage_good']}%</td>
                //         </tr>";
            // }
            // $html2 .= '</tbody></table>';
        
            // // Menambahkan jarak antara tabel ketiga dan keempat
            // $html2 .= '<br><br>';
        
            // Tabel 5: Puskesmas dengan status DPT stock out
            $html2 .= '<h3 style="font-size:14pt;">Jumlah Puskesmas dengan status DPT stock out</h3>';
            $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Nama Provinsi</th>
                                <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Jumlah Puskesmas</th>
                                <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">% Puskesmas</th>
                            </tr>
                        </thead>
                        <tbody>';
            foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
                $html2 .= "<tr>
                            <td><b>{$item['province_name']}</b></td>
                            <td>{$item['total_stock_out']}</td>
                            <td>{$item['percentage_stock_out']}%</td>
                        </tr>";
            }
            $html2 .= '</tbody></table>';
    
        } else {
            if ($selected_district !== 'all'){
                // Tabel 3: Kab/Ko dengan % DO dibawah 5%
                $html2 .= '<h3 style="font-size:14pt;">Puskesmas dengan % DO dibawah 5%</h3>';
                $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Nama Puskesmas</th>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Jumlah Anak DO</th>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">% Anak DO</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($data['province_do'] as $item) {
                    $html2 .= "<tr>
                                <td><b>{$item['puskesmas_name']}</b></td>
                                <td>{$item['total_do']}</td>
                                <td>{$item['dropout_rate']}%</td>
                            </tr>";
                }
                $html2 .= '</tbody></table>';

                // Menambahkan jarak antara tabel keempat dan kelima
                $html2 .= '<br><br>';
            
                // Tabel 4: Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
                // $html2 .= '<h3 style="font-size:14pt;">Puskesmas yang melakukan pelayanan imunisasi</h3>';
                // $html2 .= '<table border="1" cellpadding="10" style="text-align: left;">
                //             <thead>
                //                 <tr align="center">
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">NAMA PUSKESMAS</th>
                //                 </tr>
                //             </thead>
                //             <tbody>';
                // $no = 0;
                // foreach ($data['puskesmas_do_immunization'] as $item) {
                //     $no++;
                //     $html2 .= "
                //             <tr>
                //                 <td>{$item['puskesmas_name']}</td>
                //             </tr>";
                // }
                // $html2 .= '</tbody></table>';
            
                // // Menambahkan jarak antara tabel ketiga dan keempat
                // $html2 .= '<br><br>';

                // Tabel 5: Puskesmas dengan status DPT stock out
                $html2 .= '<h3 style="font-size:14pt;">Puskesmas dengan status DPT stock out</h3>';
                $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Nama Puskesmas</th>
                                    
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
                    $html2 .= "<tr>
                                <td><b>{$item['puskesmas_name']}</b></td>
                            </tr>";
                }
                $html2 .= '</tbody></table>';

            } else {
                // Tabel 3: Kab/Ko dengan % DO dibawah 5%
                $html2 .= '<h3 style="font-size:14pt;">Kab/Kota dengan % DO dibawah 5%</h3>';
                $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Nama Kab/Kota</th>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">Jumlah Anak DO</th>
                                    <th style="background-color: rgb(235, 44, 44); color: white; font-weight: bold;">% Anak DO</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($data['province_do'] as $item) {
                    $html2 .= "<tr>
                                <td><b>{$item['city_name']}</b></td>
                                <td>{$item['total_do']}</td>
                                <td>{$item['dropout_rate']}%</td>
                            </tr>";
                }
                $html2 .= '</tbody></table>';

                // Menambahkan jarak antara tabel keempat dan kelima
                $html2 .= '<br><br>';
            
                // Tabel 4: Jumlah Puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional
                // $html2 .= '<h3 style="font-size:14pt;"> Jumlah Puskesmas yang melakukan pelayanan imunisasi</h3>';
                // $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                //             <thead>
                //                 <tr>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Nama Kab/Kota</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">% Puskesmas</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas yang di supervisi suportif</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Jumlah Puskesmas yang telah disupervisi suportif dengan hasil kategori baik</th>
                //                     <th style="background-color: rgb(44, 216, 235); color: white; font-weight: bold;">Persentase Kategori "Baik"</th>
                //                 </tr>
                //             </thead>
                //             <tbody>';
                // foreach ($data['puskesmas_do_immunization'] as $item) {
                //     $html2 .= "<tr>
                //                 <td><b>{$item['city_name']}</b></td>
                //                 <td>{$item['total_puskesmas_with_immunization']}</td>
                //                 <td>{$item['percentage_immunization']}%</td>
                //                 <td>{$item['total_ss']}</td>
                //                 <td>{$item['total_good_puskesmas']}</td>
                //                 <td>{$item['percentage_good']}%</td>
                //             </tr>";
                // }
                // $html2 .= '</tbody></table>';
            
                // // Menambahkan jarak antara tabel ketiga dan keempat
                // $html2 .= '<br><br>';
            
                // Tabel 5: Puskesmas dengan status DPT stock out
                $html2 .= '<h3 style="font-size:14pt;"> Jumlah Puskesmas dengan status DPT stock out</h3>';
                $html2 .= '<table border="1" cellpadding="10" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Nama Kab/Kota</th>
                                    <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">Jumlah Puskesmas</th>
                                    <th style="background-color: rgb(100, 56, 161); color: white; font-weight: bold;">% Puskesmas</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($data['puskesmas_dpt_stock_out_data'] as $item) {
                    $html2 .= "<tr>
                                <td><b>{$item['city_name']}</b></td>
                                <td>{$item['total_stock_out']}</td>
                                <td>{$item['percentage_stock_out']}%</td>
                            </tr>";
                }
                $html2 .= '</tbody></table>';
            }
        }
        
        // Menulis HTML ke PDF
        $pdf->writeHTML($html2, true, false, true, false, '');
    
    
        // Menyelesaikan PDF dan menampilkan di browser
        // ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        // $pdf->Output('Laporan_Zerodose_Indonesia.pdf', 'I');
        // exit();

        // Mendapatkan PDF sebagai string (di memori)
        $pdf_output = $pdf->Output('', 'S');  // 'S' untuk output sebagai string

        return $pdf_output;
    }

    public function immunization_report_indonesia_sent_email() {
        // Ambil data dari form filter
        $province_id = $this->input->post('province_id');
        $city_id = $this->input->post('city_id');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $email = $this->input->post('email');
    
        // Generate laporan berdasarkan filter yang diberikan
        $report_data = $this->immunization_report_indonesia_attach($province_id, $city_id, $year, $month);

        $this->send_report_via_email($report_data, $email);
        // Kirim laporan melalui email
        if ($this->send_report_via_email($report_data, $email)) {
            // Set pesan sukses jika email berhasil dikirim
            $this->session->set_flashdata('message', 'Laporan berhasil dikirim melalui email!');
        } else {
            // Set pesan error jika gagal mengirim email
            $this->session->set_flashdata('message', 'Gagal mengirim laporan melalui email!');
        }
    
        // Redirect kembali ke halaman atau tampilkan laporan
        redirect('report');
    }
    
    // Fungsi untuk mengirim laporan via email
    private function send_report_via_email($report_data, $email) {
        // Load library email
        $this->load->library('email');
    
        // Set konfigurasi email
        $this->email->from('adminzd@zerodosemonitor.com', 'Admin Report');
        $this->email->to($email);  // Ganti dengan email penerima
    
        // Subjek email
        $this->email->subject('Laporan Imunisasi Indonesia');
    
        // Pesan email
        $this->email->message('Berikut adalah laporan imunisasi Indonesia yang diminta.');
    
        // Lampirkan file laporan (misalnya file PDF)
        $this->email->attach($report_data, 'attachment', 'immunization_report.pdf', 'application/pdf');
    
        // Kirim email dan cek jika berhasil
        if ($this->email->send()) {
            return true;  // Berhasil mengirim email
        } else {
            // Untuk debugging
            // log_message('error', 'Email failed: ' . $this->email->print_debugger());  // Log error email
            return false;  // Gagal mengirim email
            // echo $this->email->print_debugger();
        }
    }

    // Fungsi untuk mengirim laporan via email
    private function send_report_via_email_partner($report_data, $email) {
        // Load library email
        $this->load->library('email');
    
        // Set konfigurasi email
        $this->email->from('adminzd@zerodosemonitor.com', 'Admin Report');
        $this->email->to($email);  // Ganti dengan email penerima
    
        // Subjek email
        $this->email->subject('LAPORAN KERANGKA KERJA AKUNTABILITAS PENURUNAN ANAK ANAK ZERO DOSE GAVI');
    
        // Pesan email
        $this->email->message('Berikut adalah laporan  yang diminta.');
    
        // Lampirkan file laporan (misalnya file PDF)
        $this->email->attach($report_data, 'attachment', 'partner_report.pdf', 'application/pdf');
    
        // Kirim email dan cek jika berhasil
        if ($this->email->send()) {
            return true;  // Berhasil mengirim email
        } else {
            // Untuk debugging
            // log_message('error', 'Email failed: ' . $this->email->print_debugger());  // Log error email
            return false;  // Gagal mengirim email
            // echo $this->email->print_debugger();
        }
    }

    public function partner_report_indonesia_sent_email() {
        // Ambil data dari form filter
        $partner_id = $this->input->post('partner_id');
        $month = $this->input->post('month');
        $email = $this->input->post('email');
    
        // Generate laporan berdasarkan filter yang diberikan
        $report_data = $this->partner_report_attach($partner_id, $month);

        $this->send_report_via_email($report_data, $email);
        // Kirim laporan melalui email
        if ($this->send_report_via_email($report_data, $email)) {
            // Set pesan sukses jika email berhasil dikirim
            $this->session->set_flashdata('message', 'Laporan berhasil dikirim melalui email!');
        } else {
            // Set pesan error jika gagal mengirim email
            $this->session->set_flashdata('message', 'Gagal mengirim laporan melalui email!');
        }
    
        // Redirect kembali ke halaman atau tampilkan laporan
        redirect('report');
    }
    

    public function partner_report() {

        $selected_partner = $this->input->post('partner_id') ?? 'all';
        $selected_month = $this->input->post('month') ?? 'all'; // Default bulan saat ini 2025
        $this->data['selected_partner'] = $selected_partner;

        // Ambil data budget absorption
        $this->data['budget_absorption_2024'] = $this->Report_model->get_total_budget_absorption_percentage(2024, $selected_month, $selected_partner);
        $this->data['budget_absorption_2025'] = $this->Report_model->get_total_budget_absorption_percentage(2025, $selected_month, $selected_partner);

        // Ambil semua country objectives
        $objectives = $this->Report_model->get_all_objectives();

        // Ambil aktivitas yang sudah selesai
        $this->data['completed_activities_2024'] = $this->Report_model->get_completed_activities_percentage_by_year(2024, $selected_month, $selected_partner);
        $this->data['completed_activities_2025'] = $this->Report_model->get_completed_activities_percentage_by_year(2025, $selected_month, $selected_partner);

        
        // var_dump($this->data['completed_activities_2025'][1]);
        

        $table_country_objectives =[];

        foreach($objectives as $row){

            $table_country_objectives[] = [
                'name' => $row['id']. '. ' . $row['objective_name'],
                'completed_2024' => $this->data['completed_activities_2024'][$row['id']],
                'completed_2025' => $this->data['completed_activities_2025'][$row['id']]
            ];
        }

        // var_dump($table_country_objectives);
        // exit;
        
        // Data untuk laporan imunisasi
        $data = [
    
            // Data untuk laporan Grant Implementation & Budget Disbursement
            'budget_2024' => $this->data['budget_absorption_2024'],
            'budget_2025' => $this->data['budget_absorption_2025'],
            'country_objectives' => $table_country_objectives
        ];

        // Array nama bulan
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        if ($this->input->post('month')){
            if (isset($months[$selected_month])) {
                $title_month = ', Bulan ' . $months[$selected_month];  // Gunakan nama bulan
            } else {
                $title_month = '';  // Jika bulan tidak valid
            }
        } else {
            $title_month = '';
        }

        if ($selected_partner === 'all'){
            $partner_name = 'All';
        } else {
            $partner_name = $this->Report_model->get_partner_name_by_id($selected_partner);
        }
        
    
        // Membuat objek TCPDF
        // **1. Pastikan TCPDF sudah ada di lokasi yang benar**
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php'); 
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Zero Dose Indonesia Team');
        $pdf->SetTitle('LAPORAN KERANGKA KERJA AKUNTABILITAS PENURUNAN ANAK ANAK ZERO DOSE GAVI ');
        $pdf->SetHeaderData('', 0, '', 'Partner: ' . $partner_name . $title_month);
    
        // Mengatur margin
        $pdf->SetMargins(15, 20, 15);
    
        // Halaman 1 - Laporan Imunisasi
        $pdf->AddPage(); // Menambahkan halaman baru

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/kemkes_update.jpg'), 30, 18, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/imunisasi_lengkap.jpg'), 55, 15, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/logo.jpg'), 82, 20, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/undp-logo-blue.jpg'), 112, 20, 6, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);
        
        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/who_update.jpg'), 130, 20, 25, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/unicef_update.jpg'), 165, 20, 11, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan jarak antara gambar dan judul (gunakan Ln untuk jarak)
        $pdf->Ln(20);  // Menambah jarak 25 unit antara gambar dan judul

        $html = '<h2 style="text-align:center;">LAPORAN KERANGKA KERJA AKUNTABILITAS PENURUNAN ANAK ANAK ZERO DOSE GAVI</h2>';
        // $html .= "<h4>Indonesia</h4>";
        // Menambahkan jarak antara tabel pengeluaran dan country objectives
        $html .= '<p style="margin-bottom: 20px;"></p>';
    
        $html .= '<h3 style="font-size:14pt; ">Penggunaan (penyerapan) Budget untuk periode pelaporan tertentu, Gavi</h3>';
    
        // Tabel 6: Grant Implementation & Budget Disbursement
        $html .= '<table border="1" cellpadding="10" style="text-align:center;">
                    <thead>
                        <tr>
                            <th width="50%" style="background-color:rgb(250, 185, 44); color: white; font-weight: bold;">Indikator</th>
                            <th width="25%" style="background-color:rgb(250, 185, 44); color: white; font-weight: bold;">2024</th>
                            <th width="25%" style="background-color:rgb(250, 185, 44); color: white; font-weight: bold;">2025</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="50%" style="font-size:12pt; ">Penggunaan (penyerapan) Budget</td>
                            <td width="25%" style="font-size:22pt; font-weight: bold; color:rgb(0, 0, 0); ">' . number_format($data['budget_2024'], 2, ',', '.') . '%</td>
                            <td width="25%" style="font-size:22pt; font-weight: bold; color:rgb(0, 0, 0); ">' . number_format($data['budget_2025'], 2, ',', '.') . '%</td>
                        </tr>
                    </tbody>
                </table>';
    
        // Menambahkan jarak antara tabel pengeluaran dan country objectives
        $html .= '<br><br>';
    
        // Tabel 7: Country Objectives
        $html .= '<h3 style="font-size:14pt; ">Country Objectives</h3>';
        $html .= '<table border="1" cellpadding="10" style="text-align:center;">
                    <thead>
                        <tr>
                            <th width="30%" style="background-color:rgb(44, 209, 250); color: white; font-weight: bold;">Tujuan</th>
                            <th width="20%" style="background-color:rgb(44, 209, 250); color: white; font-weight: bold;">Indikator</th>
                            <th width="25%" style="background-color:rgb(44, 209, 250); color: white; font-weight: bold;">2024</th>
                            <th width="25%" style="background-color:rgb(44, 209, 250); color: white; font-weight: bold;">2025</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['country_objectives'] as $objective) {
            $html .= '<tr>
                        <td width="30%" style="font-size:12pt; ">'. $objective['name'] . '</td>
                        <td width="20%" style="font-size:12pt; ">Persentase kegiatan rencana kerja yang terlaksana</td>
                        <td width="25%" style="font-size:22pt; font-weight: bold; color:rgb(0, 0, 0); "> '. number_format($objective['completed_2024'], 2, ',', '.') . '%</td>
                        <td width="25%" style="font-size:22pt; font-weight: bold; color:rgb(0, 0, 0); "> '. number_format($objective['completed_2025'], 2, ',', '.') . '%</td>
                      </tr>';
        }
        $html .= '</tbody></table>';
    
        // Menulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Menyelesaikan PDF dan menampilkan di browser
        ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        $pdf->Output('Laporan_Imunisasi_Grant_Indonesia.pdf', 'I');
        exit();
    }

    public function partner_report_attach($param_partner_id, $param_month) {
        $selected_partner = $param_partner_id;
                // $selected_month = $this->input->post('month') ?? date('m'); // Default bulan saat ini 2025
                $selected_month = $param_month;

        // $selected_partner = $this->input->post('partner_id') ?? 'all';
        // $selected_month = $this->input->post('month') ?? 'all'; // Default bulan saat ini 2025
        $this->data['selected_partner'] = $selected_partner;

        // Ambil data budget absorption
        $this->data['budget_absorption_2024'] = $this->Report_model->get_total_budget_absorption_percentage(2024, $selected_month, $selected_partner);
        $this->data['budget_absorption_2025'] = $this->Report_model->get_total_budget_absorption_percentage(2025, $selected_month, $selected_partner);

        // Ambil semua country objectives
        $objectives = $this->Dashboard_model->get_all_objectives();

        // Ambil aktivitas yang sudah selesai
        $this->data['completed_activities_2024'] = $this->Report_model->get_completed_activities_percentage_by_year(2024, $selected_month, $selected_partner);
        $this->data['completed_activities_2025'] = $this->Report_model->get_completed_activities_percentage_by_year(2025, $selected_month, $selected_partner);

        
        // var_dump($this->data['completed_activities_2025'][1]);
        

        $table_country_objectives =[];

        foreach($objectives as $row){

            $table_country_objectives[] = [
                'name' => $row['id']. '. ' . $row['objective_name'],
                'completed_2024' => $this->data['completed_activities_2024'][$row['id']],
                'completed_2025' => $this->data['completed_activities_2025'][$row['id']]
            ];
        }

        // var_dump($table_country_objectives);
        // exit;
        
        // Data untuk laporan imunisasi
        $data = [
    
            // Data untuk laporan Grant Implementation & Budget Disbursement
            'budget_2024' => $this->data['budget_absorption_2024'],
            'budget_2025' => $this->data['budget_absorption_2025'],
            'country_objectives' => $table_country_objectives
        ];

        // Array nama bulan
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        if ($this->input->post('month')){
            if (isset($months[$selected_month])) {
                $title_month = ', Bulan ' . $months[$selected_month];  // Gunakan nama bulan
            } else {
                $title_month = '';  // Jika bulan tidak valid
            }
        } else {
            $title_month = '';
        }

        if ($selected_partner === 'all'){
            $partner_name = 'All';
        } else {
            $partner_name = $this->Report_model->get_partner_name_by_id($selected_partner);
        }
        
    
        // Membuat objek TCPDF
        // **1. Pastikan TCPDF sudah ada di lokasi yang benar**
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php'); 
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Zero Dose Indonesia Team');
        $pdf->SetTitle('LAPORAN KERANGKA KERJA AKUNTABILITAS PENURUNAN ANAK ANAK ZERO DOSE GAVI ');
        $pdf->SetHeaderData('', 0, '', 'Partner: ' . $partner_name . $title_month);
    
        // Mengatur margin
        $pdf->SetMargins(15, 20, 15);
    
        // Halaman 1 - Laporan Imunisasi
        $pdf->AddPage(); // Menambahkan halaman baru

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/kemkes_update.jpg'), 30, 18, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/imunisasi_lengkap.jpg'), 55, 15, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/logo.jpg'), 82, 20, 20, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/undp-logo-blue.jpg'), 112, 20, 6, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);
        
        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/who_update.jpg'), 130, 20, 25, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan gambar logo dengan ukuran yang sesuai dan proporsional
        $pdf->Image(base_url('assets/unicef_update.jpg'), 165, 20, 11, 0, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);

        // Menambahkan jarak antara gambar dan judul (gunakan Ln untuk jarak)
        $pdf->Ln(20);  // Menambah jarak 25 unit antara gambar dan judul

        $html = '<h2 style="text-align:center;">LAPORAN KERANGKA KERJA AKUNTABILITAS PENURUNAN ANAK ANAK ZERO DOSE GAVI</h2>';
        // $html .= "<h4>Indonesia</h4>";
        // Menambahkan jarak antara tabel pengeluaran dan country objectives
        $html .= '<p style="margin-bottom: 20px;"></p>';
    
        $html .= '<h3 style="font-size:14pt; ">Penggunaan (penyerapan) Budget untuk periode pelaporan tertentu, Gavi</h3>';
    
        // Tabel 6: Grant Implementation & Budget Disbursement
        $html .= '<table border="1" cellpadding="10" style="text-align:center;">
                    <thead>
                        <tr>
                            <th width="50%" style="background-color:rgb(250, 185, 44); color: white; font-weight: bold;">Indikator</th>
                            <th width="25%" style="background-color:rgb(250, 185, 44); color: white; font-weight: bold;">2024</th>
                            <th width="25%" style="background-color:rgb(250, 185, 44); color: white; font-weight: bold;">2025</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="50%" style="font-size:12pt; ">Penggunaan (penyerapan) Budget</td>
                            <td width="25%" style="font-size:22pt; font-weight: bold; color:rgb(0, 0, 0); ">' . number_format($data['budget_2024'], 2, ',', '.') . '%</td>
                            <td width="25%" style="font-size:22pt; font-weight: bold; color:rgb(0, 0, 0); ">' . number_format($data['budget_2025'], 2, ',', '.') . '%</td>
                        </tr>
                    </tbody>
                </table>';
    
        // Menambahkan jarak antara tabel pengeluaran dan country objectives
        $html .= '<br><br>';
    
        // Tabel 7: Country Objectives
        $html .= '<h3 style="font-size:14pt; ">Country Objectives</h3>';
        $html .= '<table border="1" cellpadding="10" style="text-align:center;">
                    <thead>
                        <tr>
                            <th width="30%" style="background-color:rgb(44, 209, 250); color: white; font-weight: bold;">Tujuan</th>
                            <th width="20%" style="background-color:rgb(44, 209, 250); color: white; font-weight: bold;">Indikator</th>
                            <th width="25%" style="background-color:rgb(44, 209, 250); color: white; font-weight: bold;">2024</th>
                            <th width="25%" style="background-color:rgb(44, 209, 250); color: white; font-weight: bold;">2025</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($data['country_objectives'] as $objective) {
            $html .= '<tr>
                        <td width="30%" style="font-size:12pt; ">'. $objective['name'] . '</td>
                        <td width="20%" style="font-size:12pt; ">Persentase kegiatan rencana kerja yang terlaksana</td>
                        <td width="25%" style="font-size:22pt; font-weight: bold; color:rgb(0, 0, 0); "> '. number_format($objective['completed_2024'], 2, ',', '.') . '%</td>
                        <td width="25%" style="font-size:22pt; font-weight: bold; color:rgb(0, 0, 0); "> '. number_format($objective['completed_2025'], 2, ',', '.') . '%</td>
                      </tr>';
        }
        $html .= '</tbody></table>';
    
        // Menulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // // Menyelesaikan PDF dan menampilkan di browser
        // ob_end_clean(); // Membersihkan output buffer sebelum mengirim PDF
        // $pdf->Output('Laporan_Imunisasi_Grant_Indonesia.pdf', 'I');
        // exit();

        // Mendapatkan PDF sebagai string (di memori)
        $pdf_output = $pdf->Output('', 'S');  // 'S' untuk output sebagai string

        return $pdf_output;
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
                        <td>Persentase kegiatan rencana kerja yang terlaksana</td>
                        <td>{$objective[1]}</td>
                        <td>{$objective[2]}</td>
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

    // Fungsi untuk mengirim laporan via email
    private function send_report_via_email_automatic($report_data_1, $report_data_2, $email) {
        // Load library email
        $this->load->library('email');
    
        // Set konfigurasi email
        $this->email->from('adminzd@zerodosemonitor.com', 'Admin Report');
        $this->email->to($email);  // Ganti dengan email penerima
    
        // Subjek email
        $this->email->subject('Laporan Imunisasi Indonesia');
    
        // Pesan email
        $this->email->message('Berikut adalah laporan imunisasi Indonesia yang diminta.');
    
        // Lampirkan file laporan (misalnya file PDF)
        $this->email->attach($report_data_1, 'attachment', 'immunization_report.pdf', 'application/pdf');
        // Lampirkan file laporan (misalnya file PDF)
        $this->email->attach($report_data_2, 'attachment', 'partner_report.pdf', 'application/pdf');
    
        // Kirim email dan cek jika berhasil
        if ($this->email->send()) {
            return true;  // Berhasil mengirim email
        } else {
            // Untuk debugging
            log_message('error', 'Email failed: ' . $this->email->print_debugger());  // Log error email
            return false;  // Gagal mengirim email
            echo $this->email->print_debugger();
        }
    }

    // public function sent_monthly_email_chai() {
        
    //     $province_id = 'all';
    //     $city_id = 'all';
    //     $year = date('Y');
    //     $month = 'all';

    //     $partner_id = 2;
    //     $email = 'abdulrahmankhadafi9@gmail.com';
    
    //     // Generate laporan berdasarkan filter yang diberikan
    //     $report_data_1 = $this->immunization_report_indonesia_attach($province_id, $city_id, $year, $month);

    //     // Generate laporan berdasarkan filter yang diberikan
    //     $report_data_2 = $this->partner_report_attach($partner_id, $month);

    //     $this->send_report_via_email_automatic($report_data_1, $report_data_2, $email);
    // }

    public function sent_monthly_email_chai() {

        $province_id = 'all';
        $city_id = 'all';
        $year = date('Y');
        $month = 'all';
    
        // Generate laporan berdasarkan filter yang diberikan
        // Partner ID default
        $partner_id = 2;
    
        // Ambil email yang ditandai untuk menerima email otomatis dan memiliki category antara 1 dan 6
        $this->db->where('send_auto_email', 1); // Ambil hanya email yang perlu dikirimi email otomatis
        $this->db->where_in('category', [1, 2, 3, 4, 5, 6]); // Filter berdasarkan category antara 1-6
        $query = $this->db->get('users');
        $users_to_send_email = $query->result();
    
        // Kirim email ke setiap pengguna yang memenuhi kriteria
        foreach ($users_to_send_email as $user) {
            $email = $user->email; // Ambil email dari data pengguna
    
            // Atur partner_id berdasarkan category
            if ($user->category == 6) {
                $partner_id = 'all'; // Jika category = 6, partner_id di-set 'all'
            } else {
                $partner_id = $user->category; // Jika tidak, partner_id sesuai dengan category
            }
    
            // Generate laporan berdasarkan filter yang diberikan
            $report_data_1 = $this->immunization_report_indonesia_attach($province_id, $city_id, $year, $month);
    
            // Generate laporan berdasarkan partner_id yang sudah diatur
            $report_data_2 = $this->partner_report_attach($partner_id, $month);
    
            // Kirim email otomatis
            $this->send_report_via_email_automatic($report_data_1, $report_data_2, $email);
        }
    }
    
    public function sent_monthly_email_dinkes() {

        $province_id = 'all';
        $city_id = 'all';
        $year = date('Y');
        $month = date('n');
    
        // Ambil email yang ditandai untuk menerima email otomatis dan memiliki category antara 1 dan 6
        $this->db->where('send_auto_email', 1); // Ambil hanya email yang perlu dikirimi email otomatis
        $this->db->where_in('category', [7,8]); // Filter berdasarkan category antara 1-6
        $query = $this->db->get('users');
        $users_to_send_email = $query->result();
    
        // Kirim email ke setiap pengguna yang memenuhi kriteria
        foreach ($users_to_send_email as $user) {
            $email = $user->email; // Ambil email dari data pengguna
    
            // Atur partner_id berdasarkan category
            if ($user->category == 7) {
                $province_id = $user->province_id;
            } else {
                $province_id = $user->province_id;
                $city_id = $user->city_id;
            }
    
            // Generate laporan berdasarkan filter yang diberikan
            $report_data_1 = $this->immunization_report_indonesia_attach($province_id, $city_id, $year, $month);
    
            // Kirim email otomatis
            $this->send_report_via_email($report_data_1, $email);
        }
    }
}
?>
