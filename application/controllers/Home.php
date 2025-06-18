<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    // Constructor untuk memuat model dan inisialisasi data sesi
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

        // Memuat model
        $this->load->model('MonitoringModel');
        $this->load->model('RujukanModel');
        $this->load->model('ReferensiModel');

        // Load model yang diperlukan
        $this->load->model('Transaction_model');
        $this->load->model('Partner_model');
        $this->load->model('PartnersActivities_model');
        $this->load->model('Activity_model');
        $this->load->model('CountryObjective_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Immunization_model');
    }

    // Fungsi index
    public function index() {
        $user_category = $this->session->userdata('user_category');
        // var_dump($user_category);
        // exit;
        

        if ($user_category == 7 || $user_category == 8) { 
            redirect('home/restored');
        }

        $this->data['title'] = 'Accountability Framework';

        // Ambil daftar partners untuk filter
        $this->data['partners'] = $this->Partner_model->get_all_partners();
        $selected_partner = $this->input->get('partner_id') ?? 'all';
        $this->data['selected_partner'] = $selected_partner;

        // Ambil data budget absorption
        $this->data['budget_absorption_2024'] = $this->Dashboard_model->get_total_budget_absorption_percentage(2024, $selected_partner);
        $this->data['budget_absorption_2025'] = $this->Dashboard_model->get_total_budget_absorption_percentage(2025, $selected_partner);
        $this->data['budget_absorption_2026'] = $this->Dashboard_model->get_total_budget_absorption_percentage(2026, $selected_partner);

        // Ambil semua country objectives
        $this->data['objectives'] = $this->Dashboard_model->get_all_objectives();

        // Ambil aktivitas yang sudah selesai
        $this->data['completed_activities_2024'] = $this->Dashboard_model->get_completed_activities_percentage_by_year(2024, $selected_partner);
        $this->data['completed_activities_2025'] = $this->Dashboard_model->get_completed_activities_percentage_by_year(2025, $selected_partner);
        $this->data['completed_activities_2026'] = $this->Dashboard_model->get_completed_activities_percentage_by_year(2026, $selected_partner);

        // Ambil data long term outcomes
        $this->data['long_term_outcomes'] = $this->Dashboard_model->get_long_term_outcomes();

        // ✅ Ambil nilai DPT1 Coverage dan Dropout Rate untuk 2024 & 2025
        $this->data['percent_dpt1_coverage_2025'] = $this->Dashboard_model->get_dpt1_coverage_percentage(2025);
        $this->data['percent_dpt1_coverage_2026'] = $this->Dashboard_model->get_dpt1_coverage_percentage(2026);

        $this->data['percent_districts_under_5_2025'] = $this->Dashboard_model->get_districts_under_5_percentage(2025);
        $this->data['percent_districts_under_5_2026'] = $this->Dashboard_model->get_districts_under_5_percentage(2026);

        // ✅ Ambil persentase Puskesmas yang telah melakukan imunisasi
        $this->data['percent_puskesmas_immunized_2025'] = $this->Dashboard_model->get_puskesmas_immunization_percentage(2025);
        $this->data['percent_puskesmas_immunized_2026'] = $this->Dashboard_model->get_puskesmas_immunization_percentage(2026);

        // $this->data['total_dpt_stockout_2025'] = $this->Dashboard_model->get_total_dpt_stock_out(2025);
        // $this->data['total_dpt_stockout_2026'] = $this->Dashboard_model->get_total_dpt_stock_out(2026);

        $this->data['total_dpt_stockout_2025'] = $this->Dashboard_model->get_total_stockout_puskesmas(2025);
        $this->data['total_dpt_stockout_2026'] = $this->Dashboard_model->get_total_stockout_puskesmas(2026);

        // ✅ Ambil persentase fasilitas kesehatan yang menjalankan program imunisasi (10 targeted provinces)
        $this->data['percent_health_facilities_2025'] = $this->Dashboard_model->get_health_facilities_percentage(2025);
        $this->data['percent_health_facilities_2026'] = $this->Dashboard_model->get_health_facilities_percentage(2026);

        // ✅ Ambil total fasilitas kesehatan swasta yang telah dilatih (hanya untuk provinsi ID 31, 33, 35)
        $this->data['private_facility_trained_2025'] = $this->Dashboard_model->get_private_facility_trained_specific(2025);
        $this->data['private_facility_trained_2026'] = $this->Dashboard_model->get_private_facility_trained_specific(2026);

        // ✅ Ambil persentase distrik yang mengalokasikan pendanaan domestik (10 targeted provinces)
        $this->data['percent_district_funding_2025'] = $this->Dashboard_model->get_district_funding_percentage(2025);
        $this->data['percent_district_funding_2026'] = $this->Dashboard_model->get_district_funding_percentage(2026);

        // ✅ Ambil persentase distrik yang memiliki kebijakan imunisasi
        $this->data['percent_district_policy_2025'] = $this->Dashboard_model->get_district_policy_percentage(2025);
        $this->data['percent_district_policy_2026'] = $this->Dashboard_model->get_district_policy_percentage(2026);

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia

        // Memuat data terjemahan
        $translations = $this->load_translation_dashboard($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

        load_template('dashboard', $this->data);
    }

    private function load_translation_dashboard($lang) {
        $translations = [
            'en' => [
                'page_title' => 'Dashboard',
                'page_subtitle' => 'Accountability Framework​',
                // 'filter_label' => 'Select Year',
                'text1' => 'Note:',
                'text2' => 'The cells highlighted in <span class="text-warning"><strong>yellow</strong></span> represent the <span class="text-warning"><strong>Actual</strong></span> values.',
                'text3' => 'The cells highlighted in <span class="text-success"><strong>green</strong></span> represent the <span class="text-success"><strong>Target</strong></span> values.',
                'text4' => 'Long Term Outcomes',
                'text5' => 'Intermediate Outcomes',
                'text6' => 'Grant Implementation & Budget Disbursement',
                'text7' => 'Country Objectives',
                'text8' => 'Indicator',
                'text9' => 'Indicator Value',
                'table1text1' => 'MITIGATE<br>Coverage rates restored, including by reaching zero-dose children',
                'table1text2' => 'DPT-3 Coverage',
                'table1text3' => 'MR-1 Coverage',
                'table1text4' => 'Reduction in zero-dose',
                'table1text5' => ' of ',
                'table1text6' => 'Target reduction by end of 2025 (15%)',
                'table1text7' => 'Target reduction by end of 2026 (25%)',
                'table1text8' => 'Target reduction by end of 2025 (5%)',
                'table1text9' => 'Target reduction by end of 2026 (10%)',

                'table2text1' => 'Routine immunization services restored and reinforced to catch up missed children',
                'table2text2' => 'Percent of primary health facility to conduct immunization service as planned',
                'table2text3' => 'No Baseline Data',
                'table2text4' => 'No target',
                'table2text5' => 'Zero-dose children identified and targeted in reinforcement of routine immunization services',
                'table2text6' => 'DPT1 in targeted areas',
                'table2text7' => '82.6% (10 provinces 2021)',
                'table2text8' => 'Community demand for & confidence in vaccines and immunization services, including among missed communities',
                'table2text9' => 'Number of district with DO (DPT1-DPT3) less than 5%',
                'table2text10' => 'Institutional capacities to plan and deliver sustained, equitable immunization programmes, as a platform for broader PHC delivery',
                'table2text11' => 'Number of health facilities managing immunization programs as per national guidance in 10 targeted provinces. The data will be retracted from Supportive supervision report (dashboard)',
                'table2text12' => 'No baseline available',
                'table2text13' => 'Number of DPT stock out at health facilities',
                'table2text14' => 'No DPT vaccine stock out in 2022',
                'table2text15' => 'Zero stock outs',
                'table2text16' => 'Number of private facilities trained on Immunization Program Management for Private Sectors SOP',
                'table2text17' => '248 (DKI Jakarta, East Java and Central Java) - HSS report',
                'table2text18' => 'Sufficient, sustained, and reliable domestic resources for immunization programmes',
                'table2text19' => 'Number of districts allocated domestic funding for key immunization activities and other relevant activities to immunization program at 10 provinces',
                'table2text20' => 'No baseline available',
                'table2text21' => 'Political commitment to & accountability for equitable immunization (including zero-dose agenda) at national & subnational levels',
                'table2text22' => 'Number of districts developed or enacted policy relevant to targeting zero dose and under immunized specifically or immunization program in general',
                
                'table3text1' => 'Budget execution (use) rate for a given reporting period, Gavi',
                'table4text1' => 'Objective',
                'table4text2' => 'Percent of workplan activities executed',
                'table4text3' => '1. Improve subnational capacity in planning, implementing and monitoring to catch-up vaccination',
                'table4text4' => '2. Improve routine data quality and data use, including high risk and hard to reach areas, to identify and target zero dose',
                'table4text5' => '3. Evidence-based demand generation supported by cross sectoral involvement, including private sector, particularly for missed communities',
                'table4text6' => '4. Improve EPI capacity at national and subnational level in vaccine logistics, social mobilization and advocacy for sustainable and equitable immunization coverage',
                'table4text7' => '5. Facilitate sustainable subnational financing for operations of immunization programs',
                'table4text8' => '6. Strengthen coordination to promote shared accountability at national and subnational level',
            ],
            'id' => [
                'page_title' => 'Dashboard',
                'page_subtitle' => 'Accountability Framework',
                // 'filter_label' => 'Pilih Tahun',
                'text1' => 'Catatan:',
                'text2' => 'Sel-sel yang disorot dengan <span class="text-warning"><strong>kuning</strong></span> mewakili nilai <span class="text-warning"><strong>Aktual</strong></span>.',
                'text3' => 'Sel-sel yang disorot dengan <span class="text-success"><strong>hijau</strong></span> mewakili nilai <span class="text-success"><strong>Target</strong></span>.',
                'text4' => 'Indikator Jangka Panjang',
                'text5' => 'Indikator Jangka Menengah',
                'text6' => 'Implementasi Kegiatan & Penyerapan Budget',
                'text7' => 'Tujuan',
                'text8' => 'Indikator',
                'text9' => 'Nilai Indikator',
                'table1text1' => 'MITIGASI </br> Tingkat cakupan dipulihkan, termasuk dengan menjangkau anak-anak yang tidak mendapat imunisasi (zero-dose)',
                'table1text2' => 'Cakupan DPT-3',
                'table1text3' => 'Cakupan MR-1',
                'table1text4' => 'Penurunan Zero Dose',
                'table1text5' => ' dari ',
                'table1text6' => 'Target penurunan pada akhir 2025 (15%)',
                'table1text7' => 'Target penurunan pada akhir 2026 (25%)',
                'table1text8' => 'Target penurunan pada akhir 2025 (5%)',
                'table1text9' => 'Target penurunan pada akhir 2026 (10%)',

                'table2text1' => 'Penguatan layanan imunisasi untuk menjangkau anak anak Zero Dose',
                'table2text2' => '% puskesmas yang melakukan pelayanan imunisasi ',
                'table2text3' => 'Tanpa Baseline',
                'table2text4' => 'Tanpa target',
                'table2text5' => 'Teridentifikasinya anak anak yang belum pernah menerima imunisasi dan menjadi sasaran dalam imunisasi rutin',
                'table2text6' => 'Cakupan DPT-1 di wilayah dampingan',
                'table2text7' => '82,6% (10 provinsi 2021)',
                'table2text8' => 'Peningkatan kepercayaan dan permintaan masyarakat terhadap layanan imunisasi, termasuk pada komunitas yang belum terjangkau',
                'table2text9' => 'Jumlah Kab/Kota dengan %DO dibawah 5% ',
                'table2text10' => 'Penguatan kapasitas puskesmas untuk merencanakan dan memberikan layanan imunisasi yang sustainable dan equitable',
                'table2text11' => 'Jumlah puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional pada 10 provinsi target (data diambil dari dashboard supervisi suportif)',
                'table2text12' => 'Tanpa baseline',
                'table2text13' => 'Jumlah puskesmas dengan status DPT stock out',
                'table2text14' => 'Tidak ada puskesmas dengan status DPT stock out stock out di tahun  2022',
                'table2text15' => 'Tidak ada DPT Stock Out',
                'table2text16' => 'Jumlah layanan swasta yang dilatih mengenai SOP manajemen program imunisasi untuk layanan swasta',
                'table2text17' => '248 (DKI Jakarta,  Jawa Timur dan Jawa Tengah ) - Laporan HSS',
                'table2text18' => 'Penyediaan sumber daya yang cukup, berkelanjutan dan handal untuk program imunisasi',
                'table2text19' => 'Jumlah Kab/Kota yang mengalokasikan pendanaan domestik untuk kegiatan imunisasi dan kegiatan lainnya yang mendukung program imunisasi pada 10 provinsi target',
                'table2text20' => 'Tanpa baseline',
                'table2text21' => 'Komitmen politis dan akuntabilitas untuk pemerataan layanan imunisasi di tingkat nasional dan daerah',
                'table2text22' => 'Jumlah Kab/Kota yang mengembangkan dan memberlakukan kebijakan yang relevant dengan penjangkauan anak ZD secara spesifik atau imunisasi secara umum',

                'table3text1' => 'Pengunaan (penyerapan) Budget untuk periode pelaporan tertentu, Gavi',
                'table4text1' => 'Tujuan',
                'table4text2' => 'Persentase kegiatan rencana kerja yang terlaksana',
                'table4text3' => '1. Meningkatkan kapasitas daerah dalam perencanaan, pelaksanaan, dan pemantauan imunisasi kejar',
                'table4text4' => '2. Meningkatkan kualitas dan pemanfaatan data rutin, termasuk di daerah berisiko tinggi dan sulit dijangkau, untuk mengidentifikasi serta menjangkau anak yang belum pernah imunisasi (Zero Dose)',
                'table4text5' => '3. Meningkatkan permintaan imunisasi berbasis bukti dengan melibatkan berbagai sektor, termasuk sektor swasta, khususnya untuk komunitas yang terlewat',
                'table4text6' => '4. Memperkuat kapasitas program imunisasi (EPI) di tingkat nasional dan daerah dalam logistik vaksin, mobilisasi sosial, dan advokasi untuk cakupan imunisasi yang berkelanjutan dan merata',
                'table4text7' => '5. Memfasilitasi pendanaan daerah yang berkelanjutan untuk operasional program imunisasi',
                'table4text8' => '6. Memperkuat koordinasi untuk meningkatkan akuntabilitas bersama di tingkat nasional dan daerah',
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default to Bahasa Indonesia
    }
    

    // Fungsi lainnya
    // public function zd_cases() {
    //     $this->data['title'] = 'Current ZD Cases';
    //     load_template('zd-cases', $this->data);
    // }

    public function set_language() {
        // Menambahkan CORS header agar bisa menerima request dari domain lain
        header('Access-Control-Allow-Origin: *'); // Memungkinkan semua origin
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); // Metode HTTP yang diperbolehkan
        header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Headers yang diperbolehkan

        // Jika request method adalah OPTIONS (preflight request), cukup kembalikan status 200 OK
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }

        // // Cek CSRF token
        // if ($this->input->post('csrf_test_name') !== $this->security->get_csrf_hash()) {
        //     show_error('CSRF token mismatch');
        //     return;
        // }
    
        // Ambil bahasa yang dipilih dari POST request
        $selected_language = $this->input->post('language');
        
        if ($selected_language) {
            // Simpan bahasa yang dipilih ke dalam session
            $this->session->set_userdata('language', $selected_language);
        }
    
        // Mengirimkan response
        echo json_encode(['status' => 'success']);
    }
    
    

    public function restored() {
        $user_category = $this->session->userdata('user_category');
        $user_province = $this->session->userdata('province_id');
        $user_city = $this->session->userdata('city_id');

        // Ambil filter provinsi dari dropdown, cek dari POST atau GET (default: all)
        $selected_province = $this->input->post('province') ?? $this->input->get('province') ?? 'all';
        $selected_district = $this->input->post('district') ?? $this->input->get('district') ?? 'all';
        $selected_year = $this->input->post('year') ?? $this->input->get('year') ?? date("Y"); // Default tahun 2025

        // Ambil parameter dari URL
        $get_detail = $this->input->get('get_detail') ?? 0; // Default 0 jika tidak ada parameter

        // Kirim data ke view
        $this->data['get_detail'] = $get_detail;

        // Jika user PHO, atur provinsi default sesuai wilayahnya
        if ($user_category == 7 && empty($this->input->get('province'))) { 
            $selected_province = $user_province;
            $this->data['selected_province2'] = $selected_province;
        }

        // Jika user DHO, atur provinsi & district sesuai wilayahnya
        if ($user_category == 8 && empty($this->input->get('province'))) {
            $selected_province = $user_province;
            $selected_district = $user_city;
            $this->data['selected_province2'] = $selected_province;
        }

        $this->data['selected_province'] = $selected_province;
        $this->data['selected_district'] = $selected_district;
        $this->data['selected_year'] = $selected_year;

        // Ambil daftar provinsi untuk dropdown + targeted provinces
        $this->data['provinces'] = $this->Immunization_model->get_provinces_with_targeted();

        // Ambil daftar kabkota untuk dropdown + targeted provinces
        $this->data['district_dropdown'] = $this->Immunization_model->get_districts_with_all($selected_province);

        // Ambil daftar distrik berdasarkan provinsi
        if ($selected_province !== 'all' && $selected_province !== 'targeted') {
            $this->data['districts'] = $this->Immunization_model->get_cities_by_province($selected_province);
            $this->data['districts_array'] = $this->Immunization_model->get_cities_by_province_array($selected_province);
        } else {
            $this->data['districts'] = [];
            $this->data['districts_array'] = [];
        }

        // Menentukan baseline ZD
        if ($selected_province == 'all') {
            // Ambil baseline ZD 2023 dari tabel target_baseline
            $this->data['national_baseline_zd'] = $this->Immunization_model->get_baseline_zd(2024);
        } else {
            // Ambil total ZD dari tabel zd_cases_2023 berdasarkan provinsi yang dipilih
            $this->data['national_baseline_zd'] = $this->Immunization_model->get_zero_dose_by_province($selected_province, $selected_district);
        }

        // Misalnya, ambil cakupan DPT-1 untuk tahun 2025 di provinsi yang dipilih
        $this->data['dpt1_coverage_kejar'] = $this->Immunization_model->get_dpt1_coverage_by_province($selected_province, $selected_year, $selected_district);

        // Menentukan baseline DPT 3 dan MR 1
        $this->data['national_baseline_dpt_mr'] = $this->Immunization_model->get_baseline_by_province($selected_province, $selected_district);

        // Menentukan quarter
        $this->data['quarter'] = $this->Immunization_model->get_max_quarter($selected_year);

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia

        // Ambil data untuk tahun 2024 & 2025
        foreach ([2025, 2026] as $year) {
            // Hitung target dpt1 pertahun
            // if ($selected_province === 'all') {
            //     // Ambil target dari target_coverage untuk semua provinsi
            //     $this->data["total_target_dpt_1_$year"] = $this->Immunization_model->get_total_target_coverage('DPT-1', $year);
            //     $this->data["total_target_dpt_3_$year"] = $this->Immunization_model->get_total_target_coverage('DPT-3', $year);
            //     $this->data["total_target_mr_1_$year"] = $this->Immunization_model->get_total_target_coverage('MR-1', $year);
            // } else {
                // Ambil target dari target_immunization untuk provinsi tertentu atau targeted
                $this->data["total_target_dpt_1_$year"] = $this->Immunization_model->get_total_target('dpt_hb_hib_1', $selected_province, $selected_district, $year);
                $this->data["total_target_dpt_3_$year"] = $this->Immunization_model->get_total_target('dpt_hb_hib_3', $selected_province, $selected_district, $year);
                $this->data["total_target_mr_1_$year"] = $this->Immunization_model->get_total_target('mr_1', $selected_province, $selected_district, $year);
            // }

            // Check if total target is 0, then set the quarter target to 0 as well
            // if ($this->data["total_target_dpt_1_$year"] == 0) {
            //     $quarter_target = 0;
            // } else {
                // Calculate based on the quarter if total target is not zero
                if ($this->data['quarter'] == 1) {
                    $this->data["total_target_dpt_1_$year"] = $this->data["total_target_dpt_1_$year"] / 4; // Quarter 1: 1/4 of total target
                } elseif ($this->data['quarter'] == 2) {
                    $this->data["total_target_dpt_1_$year"] = 2 * $this->data["total_target_dpt_1_$year"] / 4; // Quarter 2: 2/4 of total target
                } elseif ($this->data['quarter'] == 3) {
                    $this->data["total_target_dpt_1_$year"] = 3 * $this->data["total_target_dpt_1_$year"] / 4; // Quarter 3: 3/4 of total target
                } elseif ($this->data['quarter'] == 4) {
                    $this->data["total_target_dpt_1_$year"] = $this->data["total_target_dpt_1_$year"]; // Quarter 4: Full total target
                }
            // }

            // Ambil data cakupan imunisasi dari immunization_data
            $this->data["total_dpt_1_$year"] = $this->Immunization_model->get_total_vaccine('dpt_hb_hib_1', $selected_province, $selected_district, $year);
            $this->data["total_dpt_3_$year"] = $this->Immunization_model->get_total_vaccine('dpt_hb_hib_3', $selected_province, $selected_district, $year);
            $this->data["total_mr_1_$year"] = $this->Immunization_model->get_total_vaccine('mr_1', $selected_province, $selected_district, $year);
            // echo "Year: $year, DPT1: {$this->data["total_dpt_1_$year"]}, DPT3: {$this->data["total_dpt_3_$year"]}, MR1: {$this->data["total_mr_1_$year"]}"; 


            // Hitung Zero Dose (ZD)
            $this->data["zero_dose_$year"] = max($this->data["total_target_dpt_1_$year"] - $this->data["total_dpt_1_$year"], 0);
            
            if($this->session->userdata('language') == 'en'){
                // Hitung persentase ZD dari baseline 2023
                if ($this->data["zero_dose_$year"] <= $this->data['national_baseline_zd']) {
                    // $this->data["zd_narrative_$year"] = round((($this->data['national_baseline_zd'] - $this->data["zero_dose_$year"]) / $this->data['national_baseline_zd']) * 100, 1) . "% reduction from 2024 national baseline for $year";
                    $this->data["zd_narrative_$year"] = "";
                // } elseif ($this->data["zero_dose_$year"] > 2 * $this->data['national_baseline_zd']) {
                } else {
                    // $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% increase from 2024 national baseline for $year";
                    $this->data["zd_narrative_$year"] = "";
                // } else {
                //     $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% change from 2023 national baseline for $year";
                }
            } else {
                // Hitung persentase ZD dari baseline 2023
                if ($this->data["zero_dose_$year"] <= $this->data['national_baseline_zd']) {
                    // $this->data["zd_narrative_$year"] = round((($this->data['national_baseline_zd'] - $this->data["zero_dose_$year"]) / $this->data['national_baseline_zd']) * 100, 1) . "% penurunan dari baseline nasional 2024 untuk tahun $year";
                    $this->data["zd_narrative_$year"] = "";
                // } elseif ($this->data["zero_dose_$year"] > 2 * $this->data['national_baseline_zd']) {
                } else {
                    // $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% peningkatan dari baseline nasional 2024 untuk tahun $year";
                    $this->data["zd_narrative_$year"] = "";
                // } else {
                //     $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% perubahan dari baseline nasional 2023 untuk tahun $year";
                }
            }
            

            // Hitung anak yang belum divaksinasi
            $this->data["missing_dpt_3_$year"] = max($this->data["total_target_dpt_3_$year"] - $this->data["total_dpt_3_$year"], 0);
            $this->data["missing_mr_1_$year"] = max($this->data["total_target_mr_1_$year"] - $this->data["total_mr_1_$year"], 0);

            // Hitung persentase cakupan terhadap baseline
            $this->data["percent_dpt_3_$year"] = ($this->data["total_target_dpt_3_$year"] != 0)
                ? round(($this->data["total_dpt_3_$year"] / $this->data["total_target_dpt_3_$year"]) * 100, 1)
                : 0;
            
            $this->data["percent_mr_1_$year"] = ($this->data["total_target_mr_1_$year"] != 0)
                ? round(($this->data["total_mr_1_$year"] / $this->data["total_target_mr_1_$year"]) * 100, 1)
                : 0;
        }

        // Data imunisasi DPT-1 per distrik
        if ($selected_district == 'all'){
            $this->data['district_data'] = $this->Immunization_model->get_dpt1_by_district($selected_province, $selected_year, $this->data['quarter']);
        } else {
            $this->data['district_data'] = $this->Immunization_model->get_dpt1_by_puskesmas($selected_province, $selected_district, $selected_year, $this->data['quarter']);
        }
        

        // Urutkan array berdasarkan 'zero_dose_children' secara menurun
        usort($this->data['district_data'], function($a, $b) {
            // Pastikan nilai 'zero_dose_children' tidak null
            return $b['zero_dose_children'] <=> $a['zero_dose_children'];
        });

        // Ambil data cakupan imunisasi berdasarkan provinsi/kota
        $this->data['immunization_data'] = $this->Immunization_model->get_immunization_coverage($selected_province, $selected_year);

        // Ambil last update
        $this->data['last_update_date'] = $this->Immunization_model->get_last_immunization_update_date($selected_year);

        // var_dump($this->data['immunization_data']);
        // exit;

        // Ambil file GeoJSON berdasarkan provinsi
        if ($selected_province !== 'all' && $selected_province !== 'targeted') {
            $geojson = $this->db->select('geojson_file')
                                ->where('id', $selected_province)
                                ->get('provinces')
                                ->row();
            $this->data['geojson_file'] = base_url('assets/geojson/' . $geojson->geojson_file);
        } else if ($selected_province == 'all'){
            $this->data['geojson_file'] = base_url('assets/geojson/provinces.geojson');
        } else if ($selected_province == 'targeted'){
            $this->data['geojson_file'] = base_url('assets/geojson/targeted.geojson');
        }

        // Data untuk grafik line Zero-Dose Cases (Berdasarkan Provinsi & Distrik jika ada)
        // $zero_dose_cases = $this->Immunization_model->get_zero_dose_cases($selected_province, $selected_district);
        // $this->data['zero_dose_labels'] = array_map(fn($d) => $d['year'] . '-' . str_pad($d['month'], 2, '0', STR_PAD_LEFT), $zero_dose_cases);
        // $this->data['zero_dose_data'] = array_column($zero_dose_cases, 'zd_cases');

        // Initialize arrays to store data for the target and DPT-1 coverage per quarter
        $quarters = [1, 2, 3, 4];
        $target_data = [];
        $coverage_data = [];

        // Calculate the target and coverage for each quarter
        foreach ($quarters as $quarter) {
            // Fetch total target for DPT-1
            $total_target = $this->Immunization_model->get_total_target('dpt_hb_hib_1', $selected_province, $selected_district, $selected_year);
            
            // Calculate target for the quarter
            $quarter_target = 0;
            if ($quarter == 1) {
                $quarter_target = $total_target / 4;
            } elseif ($quarter == 2) {
                $quarter_target = 2 * $total_target / 4;
            } elseif ($quarter == 3) {
                $quarter_target = 3 * $total_target / 4;
            } elseif ($quarter == 4) {
                $quarter_target = $total_target;
            }

            // Fetch total DPT-1 coverage for the selected quarter
            $dpt_coverage = $this->Immunization_model->get_total_vaccine_by_quarter('dpt_hb_hib_1', $selected_province, $selected_district, $selected_year, $quarter);

            // Store the values
            $target_data[] = $quarter_target;
            $coverage_data[] = $dpt_coverage;
        }

        // Pass the data to the view
        $this->data['target_data'] = $target_data;
        $this->data['coverage_data'] = $coverage_data;
        $this->data['quarters'] = $quarters;

        // **Fix: Pastikan ini ada**
        $this->data['zero_dose_cases'] = $this->Immunization_model->get_zero_dose_cases($selected_province, $selected_district);


        // Data untuk grafik bar Restored Children (berdasarkan kota/kabupaten)
        $restored_data = $this->Immunization_model->get_restored_children($selected_province, $selected_district, $selected_year);
        $this->data['restored_data'] = [
            'kabupaten' => $restored_data['kabupaten_restored'] ?? 0,
            'kota' => $restored_data['kota_restored'] ?? 0
        ];

        // Cek apakah tombol filter grafik harus ditampilkan
        $this->data['show_chart_filter'] = ($selected_province !== 'all' && $selected_province !== 'targeted');
        $this->data['districts_array'] =  $this->Immunization_model->get_cities_by_province_array($selected_province);

        $this->data['title'] = 'Long-term Health Outcomes';

        

        // Memuat data terjemahan
        $translations = $this->load_translation_restored($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;


        load_template('restored-zd-children', $this->data);
    }

    private function load_translation_restored($lang) {
        $translations = [
            'en' => [
                'page_title' => 'Mitigate',
                'page_subtitle' => 'Coverage rates restored, including by reaching zero-dose children',
                'filter_label' => 'Select Filter',
                'text_baseline' => 'Total Zero Dose Children in 2024 (Baseline Year)',
                'text_baseline2' => 'Total Zero Dose Children in 2024 who Get Vaccinated',
                'children' => ' children',
                'text1' => 'Target Year ',
                'text1_quarter' => ' Quarter ',
                'text2' => 'Based on the Pusdatin Kemenkes Target Year',
                'text3' => 'DPT-1 Coverage Year ',
                'text4' => '% of the target',
                'text5' => 'Number of children who are not yet immunized with DPT-1 Year ',
                'text5_2' => 'The maximum number of ZD children Year',
                'text5_4' => 'of the baseline',
                'text5_3' => 'Target ',
                'text6' => 'from 2024 national baseline for 2025',
                // 'text7' => 'Target Year 2025',
                // 'text8' => 'DPT-1 Coverage Year 2025',
                // 'text9' => 'Zero Dose Year 2025',
                'text10' => 'DPT-3 Coverage Year ',
                'text11' => '% achievement of targets',
                'text12' => ' children need vaccination ',
                'text13' => 'Target Coverage ',
                'text14' => 'MR-1 Coverage Year ',
                // 'text15' => 'DPT-3 Coverage Year 2025',
                // 'text16' => 'MR-1 Coverage Year 2025',
                'text17' => 'District with the highest number of not immunized DPT-1 children Year ',
                'text17_2' => 'Puskesmas with the highest number of not immunized DPT-1 children Year ',
                'tabelcoloumn1' => 'District',
                'tabelcoloumn1_2' => 'Puskesmas',
                'tabelcoloumn6' => 'District Target',
                'tabelcoloumn6_2' => 'Puskesmas Targets ',
                'tabelcoloumn2' => 'Total Coverage DPT1',
                'tabelcoloumn3' => '% of Total Target',
                'tabelcoloumn4' => 'Number of Children Not Immunized with DPT-1',
                'tabelcoloumn5' => '% of Children Not Immunized with DPT-1',
                'text18' => 'Zero Dose Children Mapping',
                'text19' => 'Zero-Dose Children Outreach Trend',
                'text20' => 'Zero Dose Children by Region Type',
                'text21' => 'Data source:  Routine Administrative Report, Directorate of Immunization, MOH',
                'text22' => 'Data source:  Routine Administrative Report, Directorate of Immunization, MOH',
                'text23' => 'Data source:  Routine Administrative Report, Directorate of Immunization, MOH, last updated on ',
                'text24' => 'DPT-1 Target and Coverage Trend per Quarter'
            ],
            'id' => [
                'page_title' => 'Mitigasi',
                'page_subtitle' => 'Tingkat cakupan yang dipulihkan, termasuk mencapai anak zero-dose',
                'filter_label' => 'Pilih Filter',
                'text_baseline' => 'Jumlah Anak Zero Dose Tahun 2024 (National Baseline)',
                'text_baseline2' => 'Jumlah Anak Zero Dose Tahun 2024 yang dikejar (ASIK)',
                'children' => ' anak',
                'text1' => 'Sasaran Tahun ',
                'text1_quarter' => ' Triwulan ',
                'text2' => 'Sasaran Pusdatin Kemenkes Tahun',
                'text3' => 'Cakupan DPT-1 Tahun ',
                'text4' => '% dari sasaran',
                'text5' => 'Jumlah Anak Belum di Imunisasi DPT-1 Tahun ',
                'text5_2' => 'Jumlah Maksimal Anak ZD Tahun ',
                'text5_4' => 'dari Baseline',
                'text5_3' => 'Target ',
                'text6' => 'dari baseline nasional 2024 untuk 2025',
                // 'text7' => 'Target Tahun 2025',
                // 'text8' => 'Cakupan DPT-1 Tahun 2025',
                // 'text9' => 'Zero Dose Tahun 2025',
                'text10' => 'Cakupan DPT-3 Tahun ',
                'text11' => '% ketercapaian dari sasaran',
                'text12' => ' anak-anak membutuhkan vaksinasi ',
                'text13' => 'Target Cakupan ',
                'text14' => 'Cakupan MR-1 Tahun ',
                // 'text15' => 'Cakupan DPT-3 Tahun 2025',
                // 'text16' => 'Cakupan MR-1 Tahun 2025',
                'text17' => 'Kab/Kota dengan jumlah anak belum diimunisasi DPT-1 Tahun ',
                'text17_2' => 'Puskesmas dengan jumlah anak belum diimunisasi DPT-1 Tahun ',
                'tabelcoloumn1' => 'Kab/Kota',
                'tabelcoloumn1_2' => 'Puskesmas',
                'tabelcoloumn6' => 'Sasaran Kab/Kota',
                'tabelcoloumn6_2' => 'Sasaran Puskesmas ',
                'tabelcoloumn2' => 'Total Cakupan DPT1',
                'tabelcoloumn3' => '% dari Total Sasaran',
                'tabelcoloumn4' => 'Jumlah Anak Belum di Imunisasi DPT-1',
                'tabelcoloumn5' => '% dari Anak Belum di Imunisasi DPT-1',
                'text18' => 'Pemetaan Anak Zero Dose',
                'text19' => 'Tren Penjangkauan Anak Zero-Dose',
                'text20' => 'Penjangkauan Anak Zero Dose Berdasarkan Jenis Wilayah',
                'text21' => 'Data bersumber dari Laporan Rutin Dit Imunisasi Kemenkes',
                'text22' => 'Data bersumber dari Laporan Rutin Dit Imunisasi Kemenkes',
                'text23' => 'Data bersumber dari Laporan Rutin Dit Imunisasi Kemenkes terakhir diperbaharui pada ',
                
                'text24' => 'Tren Sasaran dan Cakupan DPT-1 per Triwulan'
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke bahasa Indonesia
    }
    

    // public function lost() {
    //     $this->data['title'] = 'Lost Children';
    //     load_template('lost-children', $this->data);
    // }

    public function dpt1() {
        // Ambil data dari model
        $this->load->model('Dpt1_model');

        $user_category = $this->session->userdata('user_category');
        $user_province = $this->session->userdata('province_id');
        $user_city = $this->session->userdata('city_id');

        // Ambil filter provinsi dari dropdown, cek dari POST atau GET (default: all)
        $selected_province = $this->input->post('province') ?? $this->input->get('province') ?? 'all';
        $selected_district = $this->input->post('district') ?? $this->input->get('district') ?? 'all';
        $selected_year = $this->input->post('year') ?? $this->input->get('year') ?? date("Y"); // Default tahun 2025

        // Ambil parameter dari URL
        $get_detail = $this->input->get('get_detail') ?? 0; // Default 0 jika tidak ada parameter

        // Kirim data ke view
        $this->data['get_detail'] = $get_detail;

        // Jika user PHO, atur provinsi default sesuai wilayahnya
        if ($user_category == 7 && empty($this->input->get('province'))) { 
            $selected_province = $user_province;
            $this->data['selected_province2'] = $selected_province;
        }

        // Jika user DHO, atur provinsi & district sesuai wilayahnya
        if ($user_category == 8 && empty($this->input->get('province'))) {
            $selected_province = $user_province;
            $selected_district = $user_city;
            $this->data['selected_province2'] = $selected_province;
        }

        $this->data['selected_province'] = $selected_province;
        $this->data['selected_district'] = $selected_district;
        $this->data['selected_year'] = $selected_year;

        // Ambil daftar provinsi untuk dropdown + targeted provinces
        $this->data['provinces'] = $this->Immunization_model->get_provinces_with_targeted();

        // Ambil daftar kabkota untuk dropdown + targeted provinces
        $this->data['district_dropdown'] = $this->Immunization_model->get_districts_with_all($selected_province);

        $province_ids = $this->Immunization_model->get_targeted_province_ids(); // Ambil province_id yang priority = 1
        
        // Mendapatkan dropout rates per provinsi
        $dropout_rates = $this->Dpt1_model->get_districts_under_5_percent($selected_year, $selected_province);
        
        // Menjumlahkan semua nilai dropout rate per provinsi
        $total_dropout_rate = array_sum($dropout_rates);
        
        // Menambahkan total dropout rate ke data view
        $this->data['total_dropout_rate'] = $total_dropout_rate;

        // Ambil dropout rates per provinsi
        $dropout_rates_per_province = $this->Dpt1_model->get_dropout_rates_per_province($selected_year, $selected_province);

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

        if ($selected_district === 'all'){
            // Menambahkan rata-rata dropout rate ke data view
            $this->data['dropout_rate_all_provinces'] = round($average_dropout_rate_all_provinces, 2);
        } else {
            $dropout_rate_all_district = $this->Dpt1_model->get_dropout_rates_per_city($selected_year, $selected_province, $selected_district);

            // var_dump($dropout_rate_all_district);
            // exit;
            // $this->data['dropout_rate_all_provinces'] = $dropout_rate_all_district[$selected_district];
            $this->data['dropout_rate_all_provinces'] = array_key_exists($selected_district, $dropout_rate_all_district) 
                ? $dropout_rate_all_district[$selected_district] 
                : 0;

        }

        $this->data['total_dpt1_coverage'] = $this->Dpt1_model->get_total_dpt1_coverage($selected_year, $selected_province, $selected_district);
        $this->data['total_dpt1_target'] = $this->Dpt1_model->get_total_dpt1_target($selected_year, $selected_province, $selected_district);
        // $this->data['districts_under_5'] = $this->Dpt1_model->get_districts_under_5_percent();
        

        // Hitung persentase DPT1 Coverage
        $this->data['percent_dpt1_coverage'] = ($this->data['total_dpt1_target'] > 0) 
            ? ($this->data['total_dpt1_coverage'] / $this->data['total_dpt1_target']) * 100 
            : 0;

        if ($selected_district === 'all'){

            $this->data['total_regencies_cities'] = $this->Dpt1_model->get_total_regencies_cities($selected_province);

            // Hitung persentase Districts dengan Coverage < 5%
            $this->data['percent_districts_under_5'] = ($this->data['total_regencies_cities'] > 0) 
                ? ($this->data['total_dropout_rate'] / $this->data['total_regencies_cities']) * 100 
                : 0;
        } else {

            $this->data['total_dropout_rate'] = $this->Dpt1_model->get_puskesmas_under_5_percent_in_district($selected_province,$selected_district,$selected_year);;

            // Hitung total Puskesmas
            $this->data['total_regencies_cities'] = $this->Dpt1_model->get_total_puskesmas_in_district($selected_district);

            // Hitung persentase Puskesmas dengan Coverage < 5%
            $this->data['percent_districts_under_5'] = ($this->data['total_regencies_cities'] > 0) 
                ? ($this->data['total_dropout_rate'] / $this->data['total_regencies_cities']) * 100 
                : 0;
        }

        // Mengambil data cakupan DPT untuk provinsi yang telah dipilih
        // $dpt_under_5_data = $this->Dpt1_model->get_dpt_under_5_percent_cities($province_ids);

        
        
        if($selected_province === 'all' || $selected_province === 'targeted') {
            // Mengambil data cakupan DPT untuk provinsi yang telah dipilih
            $dpt_under_5_data = $this->Dpt1_model->get_districts_under_5_percent($selected_year, $selected_province);
        } else {
            $dpt_under_5_data = $this->Dpt1_model->get_puskesmas_dropout_under_5_percent_per_city($selected_year, $selected_province, 'all');
        }
        
        // Kirim data ke view dalam format array
        $this->data['dpt_under_5_data'] = $dpt_under_5_data;
        
        // Mengambil data total cities per provinsi
        $this->data['total_cities_per_province'] = $this->Dpt1_model->get_total_cities_per_province($selected_province);

        // Mengambil data total puskesmas per kabkota
        $this->data['total_puskesmas_per_city'] = $this->Dpt1_model->get_total_puskesmas_per_city($selected_province);

        $this->data['total_dpt1_coverage_per_province'] = $this->Dpt1_model->get_dpt1_coverage_per_province($selected_province, $selected_year);
        $this->data['total_dpt1_target_per_province'] = $this->Dpt1_model->get_dpt1_target_per_province($selected_province, $selected_year);
        


        // **Hitung persentase DPT1 Coverage per provinsi**
        $this->data['percent_dpt1_coverage_per_province'] = [];

        foreach ($this->data['total_dpt1_coverage_per_province'] as $coverage) {
            $province_id = $coverage['province_id'];
            $coverage_value = $coverage['dpt1_coverage'] ?? 0;

            // Cari target berdasarkan province_id
            $target = 0;
            foreach ($this->data['total_dpt1_target_per_province'] as $target_data) {
                if ($target_data['province_id'] == $province_id) {
                    $target = $target_data['dpt1_target'] ?? 0;
                    break; // Stop loop setelah menemukan match
                }
            }

            // Hitung persentase cakupan DPT1 jika target tidak nol
            $this->data['percent_dpt1_coverage_per_province'][$province_id] = ($target > 0)
                ? round(($coverage_value / $target) * 100, 2)
                : 0;
        }

        // var_dump($this->data['total_dpt1_coverage_per_province']);
        // exit;

        // var_dump($this->data['total_cities_per_province']);
        
        

        // **Hitung persentase districts dengan coverage < 5% per provinsi**
        $this->data['percent_dpt_under_5_per_province'] = [];
        if($selected_province === 'all' || $selected_province === 'targeted') {
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
        } else {
            foreach ($dpt_under_5_data as $city_id => $puskesmas_count) {
                // Cari total cities berdasarkan city_id
                $total_puskesmas = 0;
                foreach ($this->data['total_puskesmas_per_city'] as $city_data) {
                    if ($city_data['city_id'] == $city_id) {
                        $total_puskesmas = (int)$city_data['total_puskesmas'];
                        break; // Keluar dari loop jika ditemukan
                    }
                }

                $this->data['percent_dpt_under_5_per_province'][$city_id] = ($total_puskesmas > 0)
                    ? round(($puskesmas_count / $total_puskesmas) * 100, 2)
                    : 0;
            }
        }


        //DO per Provinces untuk peta
        $this->data['dropout_rate_per_provinces'] = $dropout_rates_per_province;

        $this->data['dropout_rate_per_city'] = $this->Dpt1_model->get_dropout_rates_per_city($selected_year, $selected_province, $selected_district);

        // $this->data['geojson_file'] = base_url('assets/geojson/targeted.geojson');  // File GeoJSON untuk targeted provinces
        // Ambil file GeoJSON berdasarkan provinsi
        if ($selected_province !== 'all' && $selected_province !== 'targeted') {
            $geojson = $this->db->select('geojson_file')
                                ->where('id', $selected_province)
                                ->get('provinces')
                                ->row();
            $this->data['geojson_file'] = base_url('assets/geojson/' . $geojson->geojson_file);
        } else if ($selected_province == 'all'){
            $this->data['geojson_file'] = base_url('assets/geojson/provinces.geojson');
        } else if ($selected_province == 'targeted'){
            $this->data['geojson_file'] = base_url('assets/geojson/targeted.geojson');
        }

        // Menentukan quarter
        $this->data['quarter'] = $this->Immunization_model->get_max_quarter($selected_year);

        if ($selected_district === 'all'){
            // Ambil data distrik dan cakupan DPT
            $this->data['district_details'] = $this->Dpt1_model->get_district_details($selected_province, $selected_year, $this->data['quarter']);
        } else {
            // Ambil data distrik dan cakupan DPT
            $this->data['district_details'] = $this->Dpt1_model->get_puskesmas_details($selected_province, $selected_district, $selected_year, $this->data['quarter']);
        }
        // echo "Total districts from model: " . count($this->data['district_details']);
        // print_r($this->data['district_details']);
        // exit;

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia
        
        // Memuat data terjemahan
        $translations = $this->load_translation_dpt1($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

        $this->data['title'] = 'DPT1 in targeted areas';
        load_template('dpt1', $this->data);
    }

    private function load_translation_dpt1($lang) {
        $translations = [
            'en' => [
                'page_title' => 'DPT-1 coverage and drop out rates',
                'page_subtitle' => 'Percentage children -under 5 years with DPT 1 coverage and number of district with DO (DPT1-DPT3) less than 5%',
                'filter_label' => 'Select Filter',
                'text1' => 'DPT-1 Coverage',
                'text2' => 'Dropout Rate',
                'text3' => 'Number of districts with DO (DPT1-DPT3) less than 5%',
                'text3_2' => 'Number of puskesmas with DO (DPT1-DPT3) less than 5%',
                'text4' => 'Total Districts',
                'text4_2' => 'Total Puskesmas',
                'text5' => ' Quarter ',
                'tabelcoloumn1' => 'Province',
                'tabelcoloumn2' => 'District',
                'tabelcoloumn9' => 'Puskesmas',
                'tabelcoloumn3' => 'Target',
                'tabelcoloumn4' => 'DPT1 Coverage',
                'tabelcoloumn5' => '% of DPT1 Coverage',
                'tabelcoloumn6' => 'DPT3 Coverage',
                'tabelcoloumn7' => 'Number of Dropout',
                'tabelcoloumn8' => 'Drop Out Rate',
            ],
            'id' => [
                'page_title' => 'Cakupan DPT-1 dan % Dropout',
                'page_subtitle' => 'Cakupan DPT-1 dan % drop out pada 10 provinsi target ',
                'filter_label' => 'Pilih Filter',
                'text1' => 'Cakupan DPT-1',
                'text2' => '% drop out wilayah',
                'text3' => 'Jumlah Kab/Kota dengan % DO (DPT1-DPT3) kurang dari 5%',
                'text3_2' => 'Jumlah Puskesmas dengan % DO (DPT1-DPT3) kurang dari 5%',
                'text4' => 'Jumlah Kab/Kota',
                'text4_2' => 'Jumlah Puskesmas',
                'text5' => ' Triwulan ',
                'tabelcoloumn1' => 'Provinsi',
                'tabelcoloumn2' => 'Kab/Kota',
                'tabelcoloumn9' => 'Puskesmas',
                'tabelcoloumn3' => 'Sasaran',
                'tabelcoloumn4' => 'Cakupan DPT1',
                'tabelcoloumn5' => '% Cakupan DPT1',
                'tabelcoloumn6' => 'Cakupan DPT3',
                'tabelcoloumn7' => 'Jumlah Dropout',
                'tabelcoloumn8' => 'Tingkat Dropout',
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke Bahasa Indonesia
    }
    
    

    public function zd_tracking() {
        $this->load->model('Puskesmas_model'); // Load model baru
        $this->load->model('District_model'); // Load model
    
        $user_category = $this->session->userdata('user_category');
        $user_province = $this->session->userdata('province_id');
        $user_city = $this->session->userdata('city_id');

        // Ambil filter provinsi dari dropdown, cek dari POST atau GET (default: all)
        $selected_province = $this->input->post('province') ?? $this->input->get('province') ?? 'all';
        $selected_district = $this->input->post('district') ?? $this->input->get('district') ?? 'all';
        $selected_year = $this->input->post('year') ?? $this->input->get('year') ?? date("Y"); // Default tahun 2025

        // Ambil parameter dari URL
        $get_detail = $this->input->get('get_detail') ?? 0; // Default 0 jika tidak ada parameter

        // Kirim data ke view
        $this->data['get_detail'] = $get_detail;

        // Jika user PHO, atur provinsi default sesuai wilayahnya
        if ($user_category == 7 && empty($this->input->get('province'))) { 
            $selected_province = $user_province;
            $this->data['selected_province2'] = $selected_province;
        }

        // Jika user DHO, atur provinsi & district sesuai wilayahnya
        if ($user_category == 8 && empty($this->input->get('province'))) {
            $selected_province = $user_province;
            $selected_district = $user_city;
            $this->data['selected_province2'] = $selected_province;
        }

        $this->data['selected_province'] = $selected_province;
        $this->data['selected_district'] = $selected_district;
        $this->data['selected_year'] = $selected_year;

        // Ambil daftar provinsi untuk dropdown + targeted provinces
        $this->data['provinces'] = $this->Immunization_model->get_provinces_with_targeted();

        // Ambil daftar kabkota untuk dropdown + targeted provinces
        $this->data['district_dropdown'] = $this->Immunization_model->get_districts_with_all($selected_province);
    
        // Ambil data jumlah puskesmas & imunisasi dari model baru
        $puskesmas_data = $this->Puskesmas_model->get_puskesmas_data($selected_province, $selected_district, $selected_year);

        $this->data['total_puskesmas'] = $puskesmas_data['total_puskesmas'];
        $this->data['total_immunized_puskesmas'] = $puskesmas_data['total_immunized_puskesmas'];
        $this->data['percentage_puskesmas'] = $puskesmas_data['percentage'];

        $puskesmas_data = $this->Puskesmas_model->get_puskesmas_coverage($selected_province, $selected_year);
        $ss_data = $this->District_model->get_supportive_supervision($selected_province, $selected_year);

        // Ambil file GeoJSON berdasarkan provinsi
        if ($selected_province !== 'all' && $selected_province !== 'targeted') {
            $geojson = $this->db->select('geojson_file')
                                ->where('id', $selected_province)
                                ->get('provinces')
                                ->row();
            $this->data['geojson_file'] = base_url('assets/geojson/' . $geojson->geojson_file);
        } else if ($selected_province == 'all'){
            $this->data['geojson_file'] = base_url('assets/geojson/provinces.geojson');
        } else if ($selected_province == 'targeted'){
            $this->data['geojson_file'] = base_url('assets/geojson/targeted.geojson');
        }

        $this->data['puskesmas_data'] = json_encode($puskesmas_data, JSON_NUMERIC_CHECK);
        $this->data['ss_data'] = json_encode($ss_data, JSON_NUMERIC_CHECK);

        // ✅ Data untuk tabel (per district)
        $this->data['supportive_supervision_table'] = $this->District_model->get_supportive_supervision_targeted_table($selected_province, $selected_year);

        // ✅ Data untuk tabel (per puskesmas)
        $this->data['supportive_supervision_table_puskesmas'] = $this->Puskesmas_model->get_immunization_puskesmas_table_by_district($selected_province, $selected_district, $selected_year, 'all');

        // Contoh ambil data puskesmas yang belum imunisasi
        $this->data['puskesmas_belum_imunisasi'] = $this->Puskesmas_model->get_puskesmas_without_immunization(
            $selected_province,
            $selected_district,
            $selected_year,
            'all' // sampai bulan Desember
        );

    
        // ✅ Data untuk card (summary seluruh 10 targeted provinces)
        $this->data['supportive_supervision_2025'] = $this->District_model->get_supportive_supervision_targeted_summary($selected_province, 2025);
        $this->data['supportive_supervision_2026'] = $this->District_model->get_supportive_supervision_targeted_summary($selected_province, 2026);

        // Ambil data Puskesmas yang melakukan RCA
        $rca_puskesmas_data = $this->Puskesmas_model->get_puskesmas_rca_data($selected_province, $selected_year);
        
        // Kirim data ke view
        $this->data['total_puskesmas_rca'] = $rca_puskesmas_data;
        $this->data['title'] = 'Tracking Puskesmas RCA Data';

        // var_dump($rca_puskesmas_data);
        // exit;

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia
        
        // Memuat data terjemahan
        $translations = $this->load_translation_zd_tracking($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

        $this->data['title'] = 'Percentage of Primary Health Facility to Conduct Immunization Service as Planned​';

        // Load template
        load_template('zd-tracking', $this->data);
    }

    private function load_translation_zd_tracking($lang) {
        $translations = [
            'en' => [
                'page_title' => 'PHC Immunization Performance',
                'page_subtitle' => 'Percentage of Primary Health Facility to Conduct Immunization Service as Planned',
                'filter_label' => 'Select Filter',
                'text1' => 'Total number of Puskesmas',
                'text2' => 'Total Puskesmas that have conducted immunization',
                'text3' => 'Percentage of Puskesmas that have conducted immunization',
                'text4' => 'Number of Puskesmas have conducted a Rapid Community Assessment (RCA)',
                'text5' => 'Number of Health Facilities manage immunization program as per national guidance in 10 targeted provinces Year ',
                'text6' => ' % of Total Puskesmas',
                'text7' => 'Number of Health Facilities manage immunization program as per national guidance in 10 targeted provinces',
                'text8' => 'List of Puskesmas That Have Not Provided Immunization',
                'tabelcoloumn1' => 'Province',
                'tabelcoloumn2' => 'District',
                'tabelcoloumn3' => 'Total number of Puskesmas',
                'tabelcoloumn4' => 'Number of Puskesmas that Have Undergone Supportive Supervision with "Good" Category',
                'tabelcoloumn5' => 'Percentage of "Good" Category',
                'tabelcoloumn6' => 'Total Supportive Supervision',
                'tabelcoloumn7' => 'Puskesmas',
                'tabelcoloumn8' => 'Subdistrict'
            ],
            'id' => [
                'page_title' => 'Kinerja Imunisasi',
                'page_subtitle' => 'Persentase Fasilitas Kesehatan Primer untuk Melaksanakan Layanan Imunisasi',
                'filter_label' => 'Pilih Filter',
                'text1' => 'Jumlah Puskesmas',
                'text2' => 'Jumlah Puskesmas yang telah melaksanakan imunisasi',
                'text3' => 'Persentase Puskesmas yang telah melaksanakan imunisasi',
                'text4' => 'Jumlah Puskesmas yang telah melakukan Rapid Community Assessment (RCA)',
                'text5' => 'Jumlah puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional pada 10 provinsi target Tahun ',
                'text6' => ' % dari Total Puskesmas',
                'text7' => 'Jumlah puskesmas yang melakukan pelayanan imunisasi sesuai pedoman nasional pada 10 provinsi target',
                'text8' => 'Daftar Puskesmas yang Belum Melakukan Imunisasi',
                'tabelcoloumn1' => 'Provinsi',
                'tabelcoloumn2' => 'Kab/Kota',
                'tabelcoloumn3' => 'Jumlah Puskesmas',
                'tabelcoloumn4' => 'Jumlah Puskesmas yang telah disupervisi suportif dengan hasil kategori baik',
                'tabelcoloumn5' => 'Persentase Kategori "Baik"',
                'tabelcoloumn6' => 'Jumlah Puskesmas yang di supervisi suportif',
                'tabelcoloumn7' => 'Puskesmas',
                'tabelcoloumn8' => 'Kecamatan'
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke Bahasa Indonesia
    }

    public function dpt_stock() {
        $this->load->model('StockOut_model'); // Pastikan model dipanggil

        $user_category = $this->session->userdata('user_category');
        $user_province = $this->session->userdata('province_id');
        $user_city = $this->session->userdata('city_id');

        // Ambil filter provinsi dari dropdown, cek dari POST atau GET (default: all)
        $selected_province = $this->input->post('province') ?? $this->input->get('province') ?? 'all';
        $selected_district = $this->input->post('district') ?? $this->input->get('district') ?? 'all';
        $selected_year = $this->input->post('year') ?? $this->input->get('year') ?? date("Y"); // Default tahun 2025

        // Jika user PHO, atur provinsi default sesuai wilayahnya
        if ($user_category == 7 && empty($this->input->get('province'))) { 
            $selected_province = $user_province;
            // $this->data['selected_province2'] = $selected_province;
        }

        // Jika user DHO, atur provinsi & district sesuai wilayahnya
        if ($user_category == 8 && empty($this->input->get('province'))) {
            $selected_province = $user_province;
            $selected_district = $user_city;
            // $this->data['selected_province2'] = $selected_province;
        }

        $this->data['selected_province'] = $selected_province;
        $this->data['selected_district'] = $selected_district;
        $this->data['selected_year'] = $selected_year;

        // Ambil daftar provinsi untuk dropdown + targeted provinces
        $this->data['provinces'] = $this->Immunization_model->get_provinces_with_targeted();

        // Ambil daftar kabkota untuk dropdown + targeted provinces
        $this->data['district_dropdown'] = $this->Immunization_model->get_districts_with_all($selected_province);

        // Ambil data stok kosong per bulan dan puskesmas
        $stock_out_data = $this->StockOut_model->get_dpt_stock_out_by_month($selected_province, $selected_district, $selected_year);

        // Menghitung kategori durasi stok kosong per bulan
        $monthly_stock_out_categories = $this->StockOut_model->calculate_stock_out_category($stock_out_data, $selected_year);

        // Ambil data stock out hanya untuk vaksin DPT - lama
        // $stock_out_data = $this->StockOut_model->get_dpt_stock_out($selected_province, $selected_year);

        // **Menambahkan Tabel Puskesmas yang Pernah Stockout**
        $puskesmas_stockout_table = $this->StockOut_model->get_puskesmas_stockout_table($selected_province, $selected_district, $selected_year);
        $this->data['puskesmas_stockout_table'] = $puskesmas_stockout_table;

        // Kirim data ke view
        // $this->data['stock_out_data'] = json_encode($stock_out_data); // Kirim dalam bentuk JSON
        // $this->data['stock_out_data'] = $stock_out_data; // Kirim dalam bentuk JSON
        $this->data['stock_out_data'] = $monthly_stock_out_categories; // Kirim dalam bentuk JSON

        // Ambil data over stock per bulan dan puskesmas
        $over_stock_data = $this->StockOut_model->get_dpt_over_stock_by_month($selected_province, $selected_district, $selected_year);

        // Menghitung kategori durasi over stock per bulan
        $monthly_over_stock_categories = $this->StockOut_model->calculate_over_stock_category($over_stock_data, $selected_year);

        // **Menambahkan Tabel Puskesmas yang Pernah Overstock**
        $puskesmas_overstock_table = $this->StockOut_model->get_puskesmas_overstock_table($selected_province, $selected_district, $selected_year);
        $this->data['puskesmas_overstock_table'] = $puskesmas_overstock_table;

        // Kirim data ke view
        $this->data['over_stock_data'] = $monthly_over_stock_categories;


        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia
        
        // Memuat data terjemahan
        $translations = $this->load_translation_dpt_stock($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

        $this->data['title'] = 'Number of DPT Stock Out at Health Facilities';
        load_template('dpt-stock', $this->data);
    }

    private function load_translation_dpt_stock($lang) {
        $translations = [
            'en' => [
                'page_title' => 'Number of DPT Stock Out at Health Facilities',
                'page_subtitle' => 'Vaccine Availability',
                'filter_label' => 'Select Filter',
                'text1' => 'Stock Out by Duration',
                'text2' => 'Details of Primary Health Facility experiencing stockouts Year ',
                'text3' => 'Data is sourced from the SMILE Ministry of Health Application and updated on the 10th of every month',
                'text4' => 'Over Stock by Duration',
                'text5' => 'Details of Primary Health Facility experiencing overstocks Year ',
                'tabelcoloumn1' => 'Province',
                'tabelcoloumn2' => 'District',
                'tabelcoloumn3' => 'Subdistrict',
                'tabelcoloumn4' => 'Puskesmas',
                'tabelcoloumn5' => 'Months',
            ],
            'id' => [
                'page_title' => 'Jumlah Stock Out DPT di Fasilitas Kesehatan',
                'page_subtitle' => 'Ketersediaan Vaksin',
                'filter_label' => 'Pilih Filter',
                'text1' => 'Stock Out Berdasarkan Durasi',
                'text2' => 'Detail Puskesmas yang mengalami Stock Out Tahun ',
                'text3' => 'Data bersumber dari Aplikasi SMILE diperbaharui tanggal 10 setiap bulannya',
                'text4' => 'Overstock Berdasarkan Durasi',
                'text5' => 'Detail Puskesmas yang mengalami Over Stock Tahun ',
                'tabelcoloumn1' => 'Provinsi',
                'tabelcoloumn2' => 'Kab/Kota',
                'tabelcoloumn3' => 'Kecamatan',
                'tabelcoloumn4' => 'Puskesmas',
                'tabelcoloumn5' => 'Bulan',
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke Bahasa Indonesia
    }
    

    public function district() {
        $this->data['title'] = 'District Program';
        $this->load->model('District_model'); // Load model
    
        // Ambil tahun dari filter (default: 2025)
        $selected_year = $this->input->get('year') ?? date("Y");
        $this->data['selected_year'] = $selected_year;
    
        // // ✅ Data untuk tabel (per district)
        // $this->data['supportive_supervision_table'] = $this->District_model->get_supportive_supervision_targeted_table($selected_year);
    
        // // ✅ Data untuk card (summary seluruh 10 targeted provinces)
        // $this->data['supportive_supervision_2024'] = $this->District_model->get_supportive_supervision_targeted_summary(2024);
        // $this->data['supportive_supervision_2025'] = $this->District_model->get_supportive_supervision_targeted_summary(2025);


        // ✅ Data untuk tabel Private Facility Training
        $this->data['private_facility_training'] = $this->District_model->get_private_facility_training($selected_year);

         // ✅ Data untuk Card (Summary Total)
        $this->data['private_facility_training_2025'] = $this->District_model->get_private_facility_training_summary(2025);
        $this->data['private_facility_training_2026'] = $this->District_model->get_private_facility_training_summary(2026);

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia
        
        // Memuat data terjemahan
        $translations = $this->load_translation_trained_private_facilities($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

    
        load_template('district', $this->data);
    }
    
    private function load_translation_trained_private_facilities($lang) {
        $translations = [
            'en' => [
                'page_title' => 'Trained Private Facilities',
                'page_subtitle' => '', // Subtitle can be added if required
                'filter_label' => 'Select Year',
                'text1' => 'Number of private facilities trained on Immunization Program Management for Private Sectors SOP Year ',
                'text2' => 'Number of private facilities trained on Immunization Program Management for Private Sectors SOP',
                'tabelcoloumn1' => 'Province',
                'tabelcoloumn2' => 'Total Number of Private Facilities',
                'tabelcoloumn3' => 'Number of Private Facilities Trained',
            ],
            'id' => [
                'page_title' => 'Fasilitas Swasta yang Telah Dilatih',
                'page_subtitle' => '', // Subtitle can be added if required
                'filter_label' => 'Pilih Tahun',
                'text1' => 'Jumlah layanan swasta yang dilatih mengenai SOP manajemen program imunisasi untuk layanan swasta Tahun ',
                'text2' => 'Jumlah layanan swasta yang dilatih mengenai SOP manajemen program imunisasi untuk layanan swasta',
                'tabelcoloumn1' => 'Provinsi',
                'tabelcoloumn2' => 'Jumlah Total Layanan Swasta',
                'tabelcoloumn3' => 'Jumlah Layanan Swasta yang Telah Dilatih',
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke Bahasa Indonesia
    }
    

    public function policy() {
        $this->data['title'] = 'District Policy and Financing';
        $this->load->model('Policy_model'); // Load model
        
        // Ambil tahun dari filter (default: 2025)
        $selected_year = $this->input->get('year') ?? 2025;
        $this->data['selected_year'] = $selected_year;
    
        // ✅ Ambil data pendanaan distrik
        $this->data['district_funding'] = $this->Policy_model->get_district_funding($selected_year);

        // ✅ Data untuk card (summary seluruh 10 targeted provinces)
        $this->data['district_funding_2025'] = $this->Policy_model->get_district_funding_summary(2025);
        $this->data['district_funding_2026'] = $this->Policy_model->get_district_funding_summary(2026);

        // ✅ Ambil data kebijakan distrik dari model
        $this->data['district_policies'] = $this->Policy_model->get_district_policies($selected_year);

        // ✅ Data untuk card (summary seluruh 10 targeted provinces)
        $this->data['district_policy_2025'] = $this->Policy_model->get_policy_summary(2025);
        $this->data['district_policy_2026'] = $this->Policy_model->get_policy_summary(2026);

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia
        
        // Memuat data terjemahan
        $translations = $this->load_translation_policy($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

        load_template('policy', $this->data);
    }

    private function load_translation_policy($lang) {
        $translations = [
            'en' => [
                'page_title' => 'District Policy and Financing',
                'page_subtitle' => '', // Subtitle can be added if required
                'filter_label' => 'Select Year',
                'text1' => 'Number of district allocated domestic funding for key immunization activities and other relevant activities to support immunization program at 10 provinces Year ',
                'text2' => '% of Total District',
                'text3' => 'Number of district developed or enacted policy relevant to targeting for immunization program in general Year ',
                'text4' => 'of Total District',
                'text5' => 'Number of district allocated domestic funding for key immunization activities and other relevant activities to support immunization program at 10 provinces',
                'tabelcoloumn1' => 'Province',
                'tabelcoloumn2' => 'Total Number of Districts',
                'tabelcoloumn3' => 'Number of Districts Allocated Domestic Funding',
                'tabelcoloumn4' => 'Percentage Allocated',
                'text6' => 'Number of district developed or enacted policy relevant to targeting for immunization program in general',
                'tabel2coloumn1' => 'Province',
                'tabel2coloumn2' => 'Total Number of Districts',
                'tabel2coloumn3' => 'Number of Districts with Policies Supporting the Immunization Program or Zero Dose',
                'tabel2coloumn4' => 'Percentage',
            ],
            'id' => [
                'page_title' => 'Kebijakan dan Pendanaan Kab/Kota',
                'page_subtitle' => '', // Subtitle can be added if required
                'filter_label' => 'Pilih Tahun',
                'text1' => 'Jumlah Kab/Kota yang mengalokasikan pendanaan domestik untuk kegiatan imunisasi dan kegiatan lainnya yang mendukung program imunisasi pada 10 provinsi target Tahun ',
                'text2' => '% dari Total Kab/Kota',
                'text3' => 'Jumlah Kab/Kota yang mengembangkan dan memberlakukan kebijakan yang relevant dengan penjangkauan anak ZD secara spesifik atau imunisasi secara umum Tahun ',
                'text4' => 'dari Total Kab/Kota',
                'text5' => 'yang mengalokasikan pendanaan domestik untuk kegiatan imunisasi dan kegiatan lainnya yang mendukung program imunisasi pada 10 provinsi target',
                'tabelcoloumn1' => 'Provinsi',
                'tabelcoloumn2' => 'Jumlah Total Kab/Kota',
                'tabelcoloumn3' => 'Jumlah Kab/Kota yang mengalokasikan Pendanaan Domestik',
                'tabelcoloumn4' => 'Persentase yang mengalokasikan',
                'text6' => 'Jumlah Kab/Kota yang mengembangkan dan memberlakukan kebijakan yang relevant dengan penjangkauan anak ZD secara spesifik atau imunisasi secara umum',
                'tabel2coloumn1' => 'Provinsi',
                'tabel2coloumn2' => 'Jumlah Total Kab/Kota',
                'tabel2coloumn3' => 'Jumlah Kab/Kota dengan Kebijakan yang Mendukung Program Imunisasi atau Zero Dose',
                'tabel2coloumn4' => 'Persentase',
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke Bahasa Indonesia
    }
    
    

    public function grant_implementation() {
        // Definisikan daftar bulan
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Ambil session partner_category
        $partner_category = $this->session->userdata('partner_category');

        // Cek apakah partner_category valid
        $is_disabled = !empty($partner_category) && $partner_category != 0;

        // Tentukan filter partner berdasarkan session atau GET
        $filter_partner_id = $is_disabled ? $partner_category : ($this->input->get('partner_id') ?? 'all');

        // Ambil total target budget dari model berdasarkan filter
        $total_target_budget_2024 = ($filter_partner_id === 'all') 
            ? $this->PartnersActivities_model->get_total_target_budget_by_year(2024) 
            : $this->PartnersActivities_model->get_target_budget_by_partner_and_year($filter_partner_id, 2024);

        $total_target_budget_2025 = ($filter_partner_id === 'all') 
            ? $this->PartnersActivities_model->get_total_target_budget_by_year(2025) 
            : $this->PartnersActivities_model->get_target_budget_by_partner_and_year($filter_partner_id, 2025);
        
        $total_target_budget_2026 = ($filter_partner_id === 'all') 
            ? $this->PartnersActivities_model->get_total_target_budget_by_year(2026) 
            : $this->PartnersActivities_model->get_target_budget_by_partner_and_year($filter_partner_id, 2026);

        $total_target_budget_all = $total_target_budget_2024 + $total_target_budget_2025 + $total_target_budget_2026;
    
        // Konversi target budget USD ke IDR
        $conversion_rate = 14500; // Rp 14.500 per USD
        $total_target_budget_2024_idr = $total_target_budget_2024 * $conversion_rate;
        $total_target_budget_2025_idr = $total_target_budget_2025 * $conversion_rate;
        $total_target_budget_2026_idr = $total_target_budget_2026 * $conversion_rate;

        $total_target_budget_all_idr = $total_target_budget_all * $conversion_rate;

        // Ambil data budget absorption berdasarkan filter
        if ($filter_partner_id === 'all') {
            $data_2024 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2024);
            $data_2025 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2025);
            $data_2026 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2026);

            $data_absorbed_2024 = $this->Transaction_model->get_total_budget_absorption(2024);
            $data_absorbed_2025 = $this->Transaction_model->get_total_budget_absorption(2025);
            $data_absorbed_2026 = $this->Transaction_model->get_total_budget_absorption(2026);
        } else {
            $data_2024 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2024, $filter_partner_id, $total_target_budget_2024);
            $data_2025 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2025, $filter_partner_id, $total_target_budget_2025);
            $data_2026 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2026, $filter_partner_id, $total_target_budget_2026);

            $data_absorbed_2024 = $this->Transaction_model->get_total_budget_absorption(2024, $filter_partner_id,);
            $data_absorbed_2025 = $this->Transaction_model->get_total_budget_absorption(2025, $filter_partner_id,);
            $data_absorbed_2026 = $this->Transaction_model->get_total_budget_absorption(2026, $filter_partner_id,);
        }



        // Hitung total absorption untuk masing-masing tahun
        $total_absorbed_2024 = $data_absorbed_2024;
        $total_absorbed_2025 = $data_absorbed_2025;
        $total_absorbed_2026 = $data_absorbed_2026;
        $total_absorbed_all = $total_absorbed_2024 + $total_absorbed_2025 + $total_absorbed_2026;

        // var_dump($data_2024);
        // exit;

        // Konversi absorption ke IDR
        $conversion_rate = 14500; // Rp 14.500 per USD
        $total_absorbed_2024_idr = $total_absorbed_2024 * $conversion_rate;
        $total_absorbed_2025_idr = $total_absorbed_2025 * $conversion_rate;
        $total_absorbed_2026_idr = $total_absorbed_2026 * $conversion_rate;
        $total_absorbed_all_idr = $total_absorbed_all * $conversion_rate;

        // Kirim data ke view
        $this->data['total_absorbed_2024'] = $total_absorbed_2024;
        $this->data['total_absorbed_2025'] = $total_absorbed_2025;
        $this->data['total_absorbed_2026'] = $total_absorbed_2026;
        $this->data['total_absorbed_all'] = $total_absorbed_all;
        $this->data['total_absorbed_2024_idr'] = $total_absorbed_2024_idr;
        $this->data['total_absorbed_2025_idr'] = $total_absorbed_2025_idr;
        $this->data['total_absorbed_2026_idr'] = $total_absorbed_2026_idr;
        $this->data['total_absorbed_all_idr'] = $total_absorbed_all_idr;

        // Inisialisasi data chart dengan nilai default 0
        $budget_2024 = array_fill(0, 12, 0);
        $percentage_2024 = array_fill(0, 12, 0);
        $budget_2025 = array_fill(0, 12, 0);
        $percentage_2025 = array_fill(0, 12, 0);
        $budget_2026 = array_fill(0, 12, 0);
        $percentage_2026 = array_fill(0, 12, 0);

        foreach ($data_2024 as $row) {
            $budget_2024[$row['MONTH'] - 1] = $row['total_budget'];
            $percentage_2024[$row['MONTH'] - 1] = $row['percentage'];
        }

        foreach ($data_2025 as $row) {
            $budget_2025[$row['MONTH'] - 1] = $row['total_budget'];
            $percentage_2025[$row['MONTH'] - 1] = $row['percentage'];
        }

        foreach ($data_2026 as $row) {
            $budget_2026[$row['MONTH'] - 1] = $row['total_budget'];
            $percentage_2026[$row['MONTH'] - 1] = $row['percentage'];
        }

        

        // Ambil daftar partner untuk filter dropdown
        $partners = $this->Partner_model->get_all_partners();

        // Ambil data aktivitas yang sudah terlaksana berdasarkan filter
        if ($filter_partner_id === 'all') {
            $total_activities = $this->Activity_model->get_total_activities_by_objectives();
            $completed_activities_2024 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024);
            $completed_activities_2025 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025);
            $completed_activities_2026 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2026);
            $completed_activities_all = $this->Activity_model->get_completed_activities_by_objectives_and_year('all');
        } else {
            $total_activities = $this->Activity_model->get_total_activities_by_objectives($filter_partner_id);
            $completed_activities_2024 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024, $filter_partner_id);
            $completed_activities_2025 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025, $filter_partner_id);
            $completed_activities_2026 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2026, $filter_partner_id);
            $completed_activities_all = $this->Activity_model->get_completed_activities_by_objectives_and_year('all', $filter_partner_id);
        }

        // Ambil daftar country objectives
        $objectives = $this->CountryObjective_model->get_all_objectives();
        $total_activities_data = array_fill(0, count($objectives), 0);
        $completed_activities_2024_data = array_fill(0, count($objectives), 0);
        $completed_activities_2025_data = array_fill(0, count($objectives), 0);
        $completed_activities_2026_data = array_fill(0, count($objectives), 0);
        $completed_activities_all_data = array_fill(0, count($objectives), 0);


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

        foreach ($completed_activities_2026 as $activity) {
            $index = $activity['objective_id'] - 1;
            $completed_activities_2026_data[$index] = (int) $activity['completed'];
        }

        foreach ($completed_activities_all as $activity) {
            $index = $activity['objective_id'] - 1;
            $completed_activities_all_data[$index] = (int) $activity['completed'];
        }

        // Chart Comparison
        // Ambil partner yang ada
        $partners = $this->Partner_model->get_all_partners();

        // Ambil data total activities dan completed activities untuk setiap objective
        $total_activities_for_comparison = $this->Activity_model->get_total_activities_by_objectives(); // Ambil total activities untuk semua partner per objective

        // Ambil completed activities untuk setiap partner berdasarkan tahun
        $completed_activities_for_comparison_2024 = [];
        $completed_activities_for_comparison_2025 = [];
        $completed_activities_for_comparison_2026 = [];
        foreach ($partners as $partner) {
            $completed_activities_for_comparison_2024[$partner->id] = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024, $partner->id);
            $completed_activities_for_comparison_2025[$partner->id] = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025, $partner->id);
            $completed_activities_for_comparison_2026[$partner->id] = $this->Activity_model->get_completed_activities_by_objectives_and_year(2026, $partner->id);
            $completed_activities_for_comparison_all[$partner->id] = $this->Activity_model->get_completed_activities_by_objectives_and_year('all', $partner->id);
        }

        // Ambil daftar country objectives
        $objectives_for_comparison = $this->CountryObjective_model->get_all_objectives();

        // Format data untuk grafik baru (total activities dan completed activities per partner per objective)
        $total_activities_for_comparison_data = array_fill(0, count($objectives_for_comparison), 0);
        foreach ($total_activities_for_comparison as $activity) {
            $index = $activity['objective_id'] - 1;
            $total_activities_for_comparison_data[$index] = (int) $activity['total'];
        }

        // Format completed activities untuk setiap partner
        $completed_activities_data_2024_for_comparison = [];
        $completed_activities_data_2025_for_comparison = [];
        $completed_activities_data_2026_for_comparison = [];
        $completed_activities_data_all_for_comparison = [];
        
        foreach ($objectives_for_comparison as $index => $objective) {
            foreach ($partners as $partner) {
                $completed_activities_data_2024_for_comparison[$partner->id][$index] = 0;
                $completed_activities_data_2025_for_comparison[$partner->id][$index] = 0;
                $completed_activities_data_2026_for_comparison[$partner->id][$index] = 0;
                $completed_activities_data_all_for_comparison[$partner->id][$index] = 0;
            }
        }

        // Isi completed activities untuk setiap partner dan setiap objective
        foreach ($completed_activities_for_comparison_2024 as $partner_id => $activities) {
            foreach ($activities as $activity) {
                $index = $activity['objective_id'] - 1;
                $completed_activities_data_2024_for_comparison[$partner_id][$index] = (int) $activity['completed'];
            }
        }

        foreach ($completed_activities_for_comparison_2025 as $partner_id => $activities) {
            foreach ($activities as $activity) {
                $index = $activity['objective_id'] - 1;
                $completed_activities_data_2025_for_comparison[$partner_id][$index] = (int) $activity['completed'];
            }
        }

        foreach ($completed_activities_for_comparison_2026 as $partner_id => $activities) {
            foreach ($activities as $activity) {
                $index = $activity['objective_id'] - 1;
                $completed_activities_data_2026_for_comparison[$partner_id][$index] = (int) $activity['completed'];
            }
        }

        foreach ($completed_activities_for_comparison_all as $partner_id => $activities) {
            foreach ($activities as $activity) {
                $index = $activity['objective_id'] - 1;
                $completed_activities_data_all_for_comparison[$partner_id][$index] = (int) $activity['completed'];
            }
        }
        // Chart Comparison

        // Grafik Bar Budget
        // Ambil absorbed budget per objective
        $budget_by_objectives_2024 = $this->Transaction_model->get_budget_by_objective_and_year(2024, $filter_partner_id);
        $budget_by_objectives_2025 = $this->Transaction_model->get_budget_by_objective_and_year(2025, $filter_partner_id);
        $budget_by_objectives_2026 = $this->Transaction_model->get_budget_by_objective_and_year(2026, $filter_partner_id);
        $budget_by_objectives_all = $this->Transaction_model->get_budget_by_objective_and_year('all', $filter_partner_id);

        // Ambil target budget per objective
        $target_budget_by_objectives_2024 = $this->PartnersActivities_model->get_target_budget_by_objective_and_year(2024, $filter_partner_id);
        $target_budget_by_objectives_2025 = $this->PartnersActivities_model->get_target_budget_by_objective_and_year(2025, $filter_partner_id);
        $target_budget_by_objectives_2026 = $this->PartnersActivities_model->get_target_budget_by_objective_and_year(2026, $filter_partner_id);
        $target_budget_by_objectives_all = $this->PartnersActivities_model->get_target_budget_by_objective_and_year('all', $filter_partner_id);

        // Kirim ke view
        $this->data['budget_by_objectives_2024'] = $budget_by_objectives_2024;
        $this->data['budget_by_objectives_2025'] = $budget_by_objectives_2025;
        $this->data['budget_by_objectives_2026'] = $budget_by_objectives_2026;
        $this->data['budget_by_objectives_all'] = $budget_by_objectives_all;

        $this->data['target_budget_by_objectives_2024'] = $target_budget_by_objectives_2024;
        $this->data['target_budget_by_objectives_2025'] = $target_budget_by_objectives_2025;
        $this->data['target_budget_by_objectives_2026'] = $target_budget_by_objectives_2026;
        $this->data['target_budget_by_objectives_all'] = $target_budget_by_objectives_all;

        // Kirim data ke view
        $this->data['months'] = $months;
        $this->data['budget_2024'] = $budget_2024;
        $this->data['percentage_2024'] = $percentage_2024;
        $this->data['budget_2025'] = $budget_2025;
        $this->data['percentage_2025'] = $percentage_2025;
        $this->data['budget_2026'] = $budget_2026;
        $this->data['percentage_2026'] = $percentage_2026;
        $this->data['total_target_budget_2024'] = $total_target_budget_2024;
        $this->data['total_target_budget_2025'] = $total_target_budget_2025;
        $this->data['total_target_budget_2026'] = $total_target_budget_2026;
        $this->data['total_target_budget_all'] = $total_target_budget_all;
        $this->data['total_target_budget_2024_idr'] = $total_target_budget_2024_idr; // IDR
        $this->data['total_target_budget_2025_idr'] = $total_target_budget_2025_idr; // IDR
        $this->data['total_target_budget_2026_idr'] = $total_target_budget_2026_idr; // IDR
        $this->data['total_target_budget_all_idr'] = $total_target_budget_all_idr; // IDR
        $this->data['partners'] = $partners;
        $this->data['selected_partner'] = $filter_partner_id;
        // Kirim data ke view
        $this->data['total_activities'] = $total_activities_data;
        $this->data['completed_activities_2024'] = $completed_activities_2024_data;
        $this->data['completed_activities_2025'] = $completed_activities_2025_data;
        $this->data['completed_activities_2026'] = $completed_activities_2026_data;
        $this->data['completed_activities_all'] = $completed_activities_all_data;
        $this->data['objectives'] = $objectives;

        // Ambil tahun dari request (default 2025)
        $selected_year = $this->input->get('year') ?? date("Y");

        $this->data['selected_year'] = $selected_year;

        // Kirim data untuk grafik baru ke view
        $this->data['partners_for_comparison'] = $partners;
        $this->data['total_activities_for_comparison'] = $total_activities_for_comparison_data;
        $this->data['completed_activities_2024_for_comparison'] = $completed_activities_data_2024_for_comparison;
        $this->data['completed_activities_2025_for_comparison'] = $completed_activities_data_2025_for_comparison;
        $this->data['completed_activities_2026_for_comparison'] = $completed_activities_data_2026_for_comparison;
        $this->data['completed_activities_all_for_comparison'] = $completed_activities_data_all_for_comparison;
        $this->data['objectives_for_comparison'] = $objectives_for_comparison;

        $this->data['title'] = 'Grants Implementation and Budget Disbursement';
        load_template('grant-implementation', $this->data);
    }
    
    public function activity_tracker() {
        $this->data['title'] = 'Activity Tracker';
        load_template('activity-tracker', $this->data);
    }

    // public function private_health_facilities() {
    //     $this->data['title'] = 'Number of private health facilities in targeted areas​';
    //     load_template('private-health-facilities', $this->data);
    // }

    public function get_districts_by_province() {
        $province_id = $this->input->get('province_id');
        $districts = $this->Immunization_model->get_cities_by_province($province_id);
        echo json_encode($districts);
    }
    
    public function get_zero_dose_trend_ajax() {
        $province_id = $this->input->get('province');
        $district_id = $this->input->get('district');

        // Panggil model untuk mengambil data yang sesuai
        $zero_dose_data = $this->Immunization_model->get_zero_dose_cases($province_id, $district_id);

        // Kirim data sebagai JSON
        echo json_encode($zero_dose_data);
    }
    
    
    public function tes_model() {
        // Ambil filter provinsi dari dropdown (default: all)
        $selected_province = $this->input->get('province') ?? 'all';
        $selected_district = $this->input->get('district') ?? 'all';

        // // Ambil daftar provinsi untuk dropdown
        // $this->data['provinces'] = $this->Immunization_model->get_provinces();
        // $this->data['selected_province'] = $selected_province;
        // $this->data['selected_district'] = $selected_district;
        // // **Fix: Pastikan ini ada**
        // $this->data['zero_dose_cases'] = $this->Immunization_model->get_zero_dose_cases($selected_province, $selected_district);
        $this->data['districts'] = $this->Immunization_model->get_cities_by_province($selected_province);
        var_dump($this->data['districts']);
        $this->load->view('blank', $this->data);
    }
    
}
