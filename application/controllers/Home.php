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

        // Ambil semua country objectives
        $this->data['objectives'] = $this->Dashboard_model->get_all_objectives();

        // Ambil aktivitas yang sudah selesai
        $this->data['completed_activities_2024'] = $this->Dashboard_model->get_completed_activities_percentage_by_year(2024, $selected_partner);
        $this->data['completed_activities_2025'] = $this->Dashboard_model->get_completed_activities_percentage_by_year(2025, $selected_partner);

        // Ambil data long term outcomes
        $this->data['long_term_outcomes'] = $this->Dashboard_model->get_long_term_outcomes();

        // ✅ Ambil nilai DPT1 Coverage dan Dropout Rate untuk 2024 & 2025
        $this->data['percent_dpt1_coverage_2024'] = $this->Dashboard_model->get_dpt1_coverage_percentage(2024);
        $this->data['percent_dpt1_coverage_2025'] = $this->Dashboard_model->get_dpt1_coverage_percentage(2025);

        $this->data['percent_districts_under_5_2024'] = $this->Dashboard_model->get_districts_under_5_percentage(2024);
        $this->data['percent_districts_under_5_2025'] = $this->Dashboard_model->get_districts_under_5_percentage(2025);

        // ✅ Ambil persentase Puskesmas yang telah melakukan imunisasi
        $this->data['percent_puskesmas_immunized_2024'] = $this->Dashboard_model->get_puskesmas_immunization_percentage(2024);
        $this->data['percent_puskesmas_immunized_2025'] = $this->Dashboard_model->get_puskesmas_immunization_percentage(2025);

        $this->data['total_dpt_stockout_2024'] = $this->Dashboard_model->get_total_dpt_stock_out(2024);
        $this->data['total_dpt_stockout_2025'] = $this->Dashboard_model->get_total_dpt_stock_out(2025);

        // ✅ Ambil persentase fasilitas kesehatan yang menjalankan program imunisasi (10 targeted provinces)
        $this->data['percent_health_facilities_2024'] = $this->Dashboard_model->get_health_facilities_percentage(2024);
        $this->data['percent_health_facilities_2025'] = $this->Dashboard_model->get_health_facilities_percentage(2025);

        // ✅ Ambil total fasilitas kesehatan swasta yang telah dilatih (hanya untuk provinsi ID 31, 33, 35)
        $this->data['private_facility_trained_2024'] = $this->Dashboard_model->get_private_facility_trained_specific(2024);
        $this->data['private_facility_trained_2025'] = $this->Dashboard_model->get_private_facility_trained_specific(2025);

        // ✅ Ambil persentase distrik yang mengalokasikan pendanaan domestik (10 targeted provinces)
        $this->data['percent_district_funding_2024'] = $this->Dashboard_model->get_district_funding_percentage(2024);
        $this->data['percent_district_funding_2025'] = $this->Dashboard_model->get_district_funding_percentage(2025);

        // ✅ Ambil persentase distrik yang memiliki kebijakan imunisasi
        $this->data['percent_district_policy_2024'] = $this->Dashboard_model->get_district_policy_percentage(2024);
        $this->data['percent_district_policy_2025'] = $this->Dashboard_model->get_district_policy_percentage(2025);


        load_template('dashboard', $this->data);
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

        // Ambil filter provinsi dari dropdown (default: all)
        $selected_province = $this->input->get('province') ?? 'all';
        $selected_district = $this->input->get('district') ?? 'all';
        $selected_year = $this->input->get('year') ?? 2025; // Default tahun 2025

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

        // Ambil daftar distrik berdasarkan provinsi
        if ($selected_province !== 'all' && $selected_province !== 'targeted') {
            $this->data['districts'] = $this->Immunization_model->get_cities_by_province($selected_province);
            $this->data['districts_array'] = $this->Immunization_model->get_cities_by_province_array($selected_province);
        } else {
            $this->data['districts'] = [];
            $this->data['districts_array'] = [];
        }

        // Ambil baseline ZD 2023
        $this->data['national_baseline_zd'] = $this->Immunization_model->get_baseline_zd(2023);

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia

        // Ambil data untuk tahun 2024 & 2025
        foreach ([2024, 2025] as $year) {
            if ($selected_province === 'all') {
                // Ambil target dari target_coverage untuk semua provinsi
                $this->data["total_target_dpt_1_$year"] = $this->Immunization_model->get_total_target_coverage('DPT-1', $year);
                $this->data["total_target_dpt_3_$year"] = $this->Immunization_model->get_total_target_coverage('DPT-3', $year);
                $this->data["total_target_mr_1_$year"] = $this->Immunization_model->get_total_target_coverage('MR-1', $year);
            } else {
                // Ambil target dari target_immunization untuk provinsi tertentu atau targeted
                $this->data["total_target_dpt_1_$year"] = $this->Immunization_model->get_total_target('dpt_hb_hib_1', $selected_province, $year);
                $this->data["total_target_dpt_3_$year"] = $this->Immunization_model->get_total_target('dpt_hb_hib_3', $selected_province, $year);
                $this->data["total_target_mr_1_$year"] = $this->Immunization_model->get_total_target('mr_1', $selected_province, $year);
            }

            // Ambil data cakupan imunisasi dari immunization_data
            $this->data["total_dpt_1_$year"] = $this->Immunization_model->get_total_vaccine('dpt_hb_hib_1', $selected_province, $year);
            $this->data["total_dpt_3_$year"] = $this->Immunization_model->get_total_vaccine('dpt_hb_hib_3', $selected_province, $year);
            $this->data["total_mr_1_$year"] = $this->Immunization_model->get_total_vaccine('mr_1', $selected_province, $year);
            // echo "Year: $year, DPT1: {$this->data["total_dpt_1_$year"]}, DPT3: {$this->data["total_dpt_3_$year"]}, MR1: {$this->data["total_mr_1_$year"]}"; 


            // Hitung Zero Dose (ZD)
            $this->data["zero_dose_$year"] = max($this->data["total_target_dpt_1_$year"] - $this->data["total_dpt_1_$year"], 0);
            
            if($this->session->userdata('language') == 'en'){
                // Hitung persentase ZD dari baseline 2023
                if ($this->data["zero_dose_$year"] <= $this->data['national_baseline_zd']) {
                    $this->data["zd_narrative_$year"] = round((($this->data['national_baseline_zd'] - $this->data["zero_dose_$year"]) / $this->data['national_baseline_zd']) * 100, 1) . "% reduction from 2023 national baseline for $year";
                } elseif ($this->data["zero_dose_$year"] > 2 * $this->data['national_baseline_zd']) {
                    $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% increase from 2023 national baseline for $year";
                } else {
                    $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% change from 2023 national baseline for $year";
                }
            } else {
                // Hitung persentase ZD dari baseline 2023
                if ($this->data["zero_dose_$year"] <= $this->data['national_baseline_zd']) {
                    $this->data["zd_narrative_$year"] = round((($this->data['national_baseline_zd'] - $this->data["zero_dose_$year"]) / $this->data['national_baseline_zd']) * 100, 1) . "% penurunan dari baseline nasional 2023 untuk tahun $year";
                } elseif ($this->data["zero_dose_$year"] > 2 * $this->data['national_baseline_zd']) {
                    $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% peningkatan dari baseline nasional 2023 untuk tahun $year";
                } else {
                    $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% perubahan dari baseline nasional 2023 untuk tahun $year";
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
        $this->data['district_data'] = $this->Immunization_model->get_dpt1_by_district($selected_province, $selected_year);

        // Urutkan array berdasarkan 'zero_dose_children' secara menurun
        usort($this->data['district_data'], function($a, $b) {
            // Pastikan nilai 'zero_dose_children' tidak null
            return $b['zero_dose_children'] <=> $a['zero_dose_children'];
        });

        // Ambil data cakupan imunisasi berdasarkan provinsi/kota
        $this->data['immunization_data'] = $this->Immunization_model->get_immunization_coverage($selected_province, $selected_year);

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

        // **Fix: Pastikan ini ada**
        $this->data['zero_dose_cases'] = $this->Immunization_model->get_zero_dose_cases($selected_province, $selected_district);


        // Data untuk grafik bar Restored Children (berdasarkan kota/kabupaten)
        $restored_data = $this->Immunization_model->get_restored_children($selected_province, $selected_year);
        $this->data['restored_data'] = [
            'kabupaten' => $restored_data['kabupaten_restored'] ?? 0,
            'kota' => $restored_data['kota_restored'] ?? 0
        ];

        // Cek apakah tombol filter grafik harus ditampilkan
        $this->data['show_chart_filter'] = ($selected_province !== 'all' && $selected_province !== 'targeted');
        $this->data['districts_array'] =  $this->Immunization_model->get_cities_by_province_array($selected_province);

        $this->data['title'] = 'Restored ZD Children';

        

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
                'filter_label' => 'Select Province',
                'text_baseline' => 'Children Zero Dose Year 2023 (National Baseline)',
                'children' => ' children',
                'text1' => 'Target Year ',
                'text2' => 'Based on the Population Census Survey (SUPAS)',
                'text3' => 'DPT-1 Coverage Year ',
                'text4' => ' of the target',
                'text5' => 'Zero Dose Year ',
                'text6' => 'from 2023 national baseline for 2024',
                // 'text7' => 'Target Year 2025',
                // 'text8' => 'DPT-1 Coverage Year 2025',
                // 'text9' => 'Zero Dose Year 2025',
                'text10' => 'DPT-3 Coverage Year ',
                'text11' => ' of the baseline',
                'text12' => ' children need vaccination',
                'text13' => 'Target Coverage ',
                'text14' => 'MR-1 Coverage Year ',
                // 'text15' => 'DPT-3 Coverage Year 2025',
                // 'text16' => 'MR-1 Coverage Year 2025',
                'text17' => 'District with the highest number of zero dose children',
                'tabelcoloumn1' => 'District',
                'tabelcoloumn6' => 'Target District',
                'tabelcoloumn2' => 'Total Coverage DPT1',
                'tabelcoloumn3' => '% of Total Target',
                'tabelcoloumn4' => 'Number of ZD Children',
                'tabelcoloumn5' => '% of Zero Dose',
                'text18' => 'Zero Dose Children Mapping',
                'text19' => 'Zero-Dose Children Trend by Month',
                'text20' => 'Zero Dose Children by Region Type'
            ],
            'id' => [
                'page_title' => 'Mitigasi',
                'page_subtitle' => 'Tingkat cakupan yang dipulihkan, termasuk mencapai anak zero-dose',
                'filter_label' => 'Pilih Provinsi',
                'text_baseline' => 'Anak Zero Dose Tahun 2023 (National Baseline)',
                'children' => ' anak',
                'text1' => 'Target Tahun ',
                'text2' => 'Berdasarkan Survei Penduduk (SUPAS)',
                'text3' => 'Cakupan DPT-1 Tahun ',
                'text4' => ' dari target',
                'text5' => 'Zero Dose Tahun ',
                'text6' => 'dari baseline nasional 2023 untuk 2024',
                // 'text7' => 'Target Tahun 2025',
                // 'text8' => 'Cakupan DPT-1 Tahun 2025',
                // 'text9' => 'Zero Dose Tahun 2025',
                'text10' => 'Cakupan DPT-3 Tahun ',
                'text11' => ' dari baseline',
                'text12' => ' anak-anak membutuhkan vaksinasi',
                'text13' => 'Target Cakupan ',
                'text14' => 'Cakupan MR-1 Tahun ',
                // 'text15' => 'Cakupan DPT-3 Tahun 2025',
                // 'text16' => 'Cakupan MR-1 Tahun 2025',
                'text17' => 'Kab/Kota dengan jumlah anak zero dose terbanyak',
                'tabelcoloumn1' => 'Kab/Kota',
                'tabelcoloumn6' => 'Target Kab/Kota',
                'tabelcoloumn2' => 'Total Cakupan DPT1',
                'tabelcoloumn3' => '% dari Total Target',
                'tabelcoloumn4' => 'Jumlah Anak ZD',
                'tabelcoloumn5' => '% dari Zero Dose',
                'text18' => 'Pemetaan Anak Zero Dose',
                'text19' => 'Tren Anak Zero-Dose per Bulan',
                'text20' => 'Anak Zero Dose Berdasarkan Jenis Wilayah'
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

        $selected_year = $this->input->get('year') ?? 2025; // Default tahun 2025
        $this->data['selected_year'] = $selected_year;

        $province_ids = $this->Immunization_model->get_targeted_province_ids(); // Ambil province_id yang priority = 1
        
        // Mendapatkan dropout rates per provinsi
        $dropout_rates = $this->Dpt1_model->get_districts_under_5_percent($selected_year);
        
        // Menjumlahkan semua nilai dropout rate per provinsi
        $total_dropout_rate = array_sum($dropout_rates);
        
        // Menambahkan total dropout rate ke data view
        $this->data['total_dropout_rate'] = $total_dropout_rate;

        // Ambil dropout rates per provinsi
        $dropout_rates_per_province = $this->Dpt1_model->get_dropout_rates_per_province($selected_year);

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


        $this->data['total_dpt1_coverage'] = $this->Dpt1_model->get_total_dpt1_coverage($selected_year);
        $this->data['total_dpt1_target'] = $this->Dpt1_model->get_total_dpt1_target($selected_year);
        // $this->data['districts_under_5'] = $this->Dpt1_model->get_districts_under_5_percent();
        $this->data['total_regencies_cities'] = $this->Dpt1_model->get_total_regencies_cities();

        // Hitung persentase DPT1 Coverage
        $this->data['percent_dpt1_coverage'] = ($this->data['total_dpt1_target'] > 0) 
            ? ($this->data['total_dpt1_coverage'] / $this->data['total_dpt1_target']) * 100 
            : 0;

        // Hitung persentase Districts dengan Coverage < 5%
        $this->data['percent_districts_under_5'] = ($this->data['total_regencies_cities'] > 0) 
            ? ($this->data['total_dropout_rate'] / $this->data['total_regencies_cities']) * 100 
            : 0;

        // Mengambil data cakupan DPT untuk provinsi yang telah dipilih
        // $dpt_under_5_data = $this->Dpt1_model->get_dpt_under_5_percent_cities($province_ids);
        $dpt_under_5_data = $this->Dpt1_model->get_districts_under_5_percent($selected_year);

        $this->data['total_dpt1_coverage_per_province'] = $this->Dpt1_model->get_dpt1_coverage_per_province($province_ids, $selected_year);
        $this->data['total_dpt1_target_per_province'] = $this->Dpt1_model->get_dpt1_target_per_province($province_ids, $selected_year);
        // Mengambil data total cities per provinsi
        $this->data['total_cities_per_province'] = $this->Dpt1_model->get_total_cities_per_province($province_ids);

        // Kirim data ke view dalam format array
        $this->data['dpt_under_5_data'] = $dpt_under_5_data;

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
        
        

        // **Hitung persentase districts dengan coverage < 5% per provinsi**
        $this->data['percent_dpt_under_5_per_province'] = [];
        foreach ($dpt_under_5_data as $province_id => $district_count) {
            $total_cities = $this->data['total_cities_per_province'][$province_id]['total_cities'] ?? 0;

            $this->data['percent_dpt_under_5_per_province'][$province_id] = ($total_cities > 0)
                ? round(($district_count / $total_cities) * 100, 2)
                : 0;
        }

        //DO per Provinces untuk peta
        $this->data['dropout_rate_per_provinces'] = $dropout_rates_per_province;

        $this->data['geojson_file'] = base_url('assets/geojson/targeted.geojson');  // File GeoJSON untuk targeted provinces

        // Ambil data distrik dan cakupan DPT
        $this->data['district_details'] = $this->Dpt1_model->get_district_details($province_ids, $selected_year);

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
                'filter_label' => 'Select Year',
                'text1' => 'DPT-1 Coverage',
                'text2' => 'Dropout Rate',
                'text3' => 'Number of districts with DO (DPT1-DPT3) less than 5%',
                'text4' => 'Total Districts',
                'tabelcoloumn1' => 'Province',
                'tabelcoloumn2' => 'District',
                'tabelcoloumn3' => 'Target',
                'tabelcoloumn4' => 'DPT1 Coverage',
                'tabelcoloumn5' => '% of DPT1 Coverage',
                'tabelcoloumn6' => 'DPT3 Coverage',
                'tabelcoloumn7' => 'Number of Dropout',
                'tabelcoloumn8' => 'Drop Out Rate',
            ],
            'id' => [
                'page_title' => 'Cakupan DPT-1 dan Tingkat Dropout',
                'page_subtitle' => 'Persentase anak - di bawah 5 tahun dengan cakupan DPT 1 dan jumlah Kab/Kota dengan DO (DPT1-DPT3) kurang dari 5%',
                'filter_label' => 'Pilih Tahun',
                'text1' => 'Cakupan DPT-1',
                'text2' => 'Tingkat Dropout',
                'text3' => 'Jumlah Kab/Kota dengan DO (DPT1-DPT3) kurang dari 5%',
                'text4' => 'Jumlah Kab/Kota',
                'tabelcoloumn1' => 'Provinsi',
                'tabelcoloumn2' => 'Kab/Kota',
                'tabelcoloumn3' => 'Target',
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
    
        // Ambil filter dari dropdown
        $selected_province = $this->input->get('province') ?? 'all';
        $selected_district = $this->input->get('district') ?? 'all';
        $selected_year = $this->input->get('year') ?? 2025;

        // Ambil parameter dari URL
        $get_detail = $this->input->get('get_detail') ?? 0; // Default 0 jika tidak ada parameter

        // Kirim data ke view
        $this->data['get_detail'] = $get_detail;
    
        // Jika user PHO atau DHO, sesuaikan wilayah default
        if ($user_category == 7 && empty($this->input->get('province'))) { 
            $selected_province = $user_province;
        }
        if ($user_category == 8 && empty($this->input->get('province'))) {
            $selected_province = $user_province;
            $selected_district = $user_city;
        }
    
        // Ambil data jumlah puskesmas & imunisasi dari model baru
        $puskesmas_data = $this->Puskesmas_model->get_puskesmas_data($selected_province, $selected_district, $selected_year);

        // Ambil daftar provinsi untuk dropdown + targeted provinces
        $this->data['provinces'] = $this->Immunization_model->get_provinces_with_targeted();

        $this->data['selected_province'] = $selected_province;
        $this->data['selected_district'] = $selected_district;
        $this->data['selected_year'] = $selected_year;
        $this->data['total_puskesmas'] = $puskesmas_data['total_puskesmas'];
        $this->data['total_immunized_puskesmas'] = $puskesmas_data['total_immunized_puskesmas'];
        $this->data['percentage_puskesmas'] = $puskesmas_data['percentage'];

        $puskesmas_data = $this->Puskesmas_model->get_puskesmas_coverage($selected_province, $selected_year);

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

        // ✅ Data untuk tabel (per district)
        $this->data['supportive_supervision_table'] = $this->District_model->get_supportive_supervision_targeted_table($selected_year);
    
        // ✅ Data untuk card (summary seluruh 10 targeted provinces)
        $this->data['supportive_supervision_2024'] = $this->District_model->get_supportive_supervision_targeted_summary(2024);
        $this->data['supportive_supervision_2025'] = $this->District_model->get_supportive_supervision_targeted_summary(2025);

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
                'filter_label' => 'Select Province',
                'text1' => 'Total number of Puskesmas',
                'text2' => 'Total Puskesmas that have conducted immunization',
                'text3' => 'Percentage of Puskesmas that have conducted immunization',
                'text4' => 'Number of Puskesmas have conducted a Rapid Community Assessment (RCA)',
                'text5' => 'Number of Health Facilities manage immunization program as per national guidance in 10 targeted provinces Year ',
                'text6' => ' % of Total Puskesmas',
                'text7' => 'Number of Health Facilities manage immunization program as per national guidance in 10 targeted provinces',
                'tabelcoloumn1' => 'Province',
                'tabelcoloumn2' => 'District',
                'tabelcoloumn3' => 'Total number of Puskesmas',
                'tabelcoloumn4' => 'Number of Puskesmas that Have Undergone Supportive Supervision with "Good" Category',
                'tabelcoloumn5' => 'Percentage of "Good" Category',
            ],
            'id' => [
                'page_title' => 'Kinerja Imunisasi Puskesmas',
                'page_subtitle' => 'Persentase Fasilitas Kesehatan Primer untuk Melaksanakan Layanan Imunisasi sesuai Rencana',
                'filter_label' => 'Pilih Provinsi',
                'text1' => 'Jumlah Puskesmas',
                'text2' => 'Jumlah Puskesmas yang telah melaksanakan imunisasi',
                'text3' => 'Persentase Puskesmas yang telah melaksanakan imunisasi',
                'text4' => 'Jumlah Puskesmas yang telah melakukan Rapid Community Assessment (RCA)',
                'text5' => 'Jumlah Fasilitas Kesehatan yang mengelola program imunisasi sesuai pedoman nasional di 10 provinsi yang menjadi sasaran Tahun ',
                'text6' => ' % dari Total Puskesmas',
                'text7' => 'Jumlah Fasilitas Kesehatan yang mengelola program imunisasi sesuai pedoman nasional di 10 provinsi yang menjadi sasaran',
                'tabelcoloumn1' => 'Provinsi',
                'tabelcoloumn2' => 'Kabupaten/Kota',
                'tabelcoloumn3' => 'Jumlah Puskesmas',
                'tabelcoloumn4' => 'Jumlah Puskesmas yang telah mengikuti Supervisi Dukungan dengan Kategori "Baik"',
                'tabelcoloumn5' => 'Persentase Kategori "Baik"',
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke Bahasa Indonesia
    }
    
    

    public function dpt_stock() {
        $this->load->model('StockOut_model'); // Pastikan model dipanggil

        $selected_province = $this->input->get('province') ?? 'all';
        $selected_year = $this->input->get('year') ?? 2025;

        // Ambil daftar provinsi untuk dropdown + targeted provinces
        $this->data['provinces'] = $this->Immunization_model->get_provinces_with_targeted();

        // Ambil data stock out hanya untuk vaksin DPT
        $stock_out_data = $this->StockOut_model->get_dpt_stock_out($selected_province, $selected_year);

        // Kirim data ke view
        $this->data['selected_province'] = $selected_province;
        $this->data['selected_year'] = $selected_year;
        // $this->data['stock_out_data'] = json_encode($stock_out_data); // Kirim dalam bentuk JSON
        $this->data['stock_out_data'] = $stock_out_data; // Kirim dalam bentuk JSON

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia
        
        // Memuat data terjemahan
        $translations = $this->load_translation_dpt_stock($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

        $this->data['title'] = 'Number of DTP Stock Out at Health Facilities';
        load_template('dpt-stock', $this->data);
    }

    private function load_translation_dpt_stock($lang) {
        $translations = [
            'en' => [
                'page_title' => 'Number of DTP Stock Out at Health Facilities',
                'page_subtitle' => 'Vaccine Availability',
                'filter_label' => 'Select Province',
                'text1' => 'Stock Out by Duration',
            ],
            'id' => [
                'page_title' => 'Jumlah Stock Out DTP di Fasilitas Kesehatan',
                'page_subtitle' => 'Ketersediaan Vaksin',
                'filter_label' => 'Pilih Provinsi',
                'text1' => 'Stock Out Berdasarkan Durasi',
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke Bahasa Indonesia
    }
    

    public function district() {
        $this->data['title'] = 'District Program';
        $this->load->model('District_model'); // Load model
    
        // Ambil tahun dari filter (default: 2025)
        $selected_year = $this->input->get('year') ?? 2025;
        $this->data['selected_year'] = $selected_year;
    
        // // ✅ Data untuk tabel (per district)
        // $this->data['supportive_supervision_table'] = $this->District_model->get_supportive_supervision_targeted_table($selected_year);
    
        // // ✅ Data untuk card (summary seluruh 10 targeted provinces)
        // $this->data['supportive_supervision_2024'] = $this->District_model->get_supportive_supervision_targeted_summary(2024);
        // $this->data['supportive_supervision_2025'] = $this->District_model->get_supportive_supervision_targeted_summary(2025);


        // ✅ Data untuk tabel Private Facility Training
        $this->data['private_facility_training'] = $this->District_model->get_private_facility_training($selected_year);

         // ✅ Data untuk Card (Summary Total)
        $this->data['private_facility_training_2024'] = $this->District_model->get_private_facility_training_summary(2024);
        $this->data['private_facility_training_2025'] = $this->District_model->get_private_facility_training_summary(2025);


    
        load_template('district', $this->data);
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
        $this->data['district_funding_2024'] = $this->Policy_model->get_district_funding_summary(2024);
        $this->data['district_funding_2025'] = $this->Policy_model->get_district_funding_summary(2025);

        // ✅ Ambil data kebijakan distrik dari model
        $this->data['district_policies'] = $this->Policy_model->get_district_policies($selected_year);

        // ✅ Data untuk card (summary seluruh 10 targeted provinces)
        $this->data['district_policy_2024'] = $this->Policy_model->get_policy_summary(2024);
        $this->data['district_policy_2025'] = $this->Policy_model->get_policy_summary(2025);

        load_template('policy', $this->data);
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

        // Ambil data budget absorption berdasarkan filter
        if ($filter_partner_id === 'all') {
            $data_2024 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2024);
            $data_2025 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2025);
        } else {
            $data_2024 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2024, $filter_partner_id, $total_target_budget_2024);
            $data_2025 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2025, $filter_partner_id, $total_target_budget_2025);
        }

        // Inisialisasi data chart dengan nilai default 0
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

        // Ambil daftar partner untuk filter dropdown
        $partners = $this->Partner_model->get_all_partners();

        // Ambil data aktivitas yang sudah terlaksana berdasarkan filter
        if ($filter_partner_id === 'all') {
            $total_activities = $this->Activity_model->get_total_activities_by_objectives();
            $completed_activities_2024 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024);
            $completed_activities_2025 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025);
        } else {
            $total_activities = $this->Activity_model->get_total_activities_by_objectives($filter_partner_id);
            $completed_activities_2024 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024, $filter_partner_id);
            $completed_activities_2025 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025, $filter_partner_id);
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

        // Kirim data ke view
        $this->data['months'] = $months;
        $this->data['budget_2024'] = $budget_2024;
        $this->data['percentage_2024'] = $percentage_2024;
        $this->data['budget_2025'] = $budget_2025;
        $this->data['percentage_2025'] = $percentage_2025;
        $this->data['total_target_budget_2024'] = $total_target_budget_2024;
        $this->data['total_target_budget_2025'] = $total_target_budget_2025;
        $this->data['partners'] = $partners;
        $this->data['selected_partner'] = $filter_partner_id;
        // Kirim data ke view
        $this->data['total_activities'] = $total_activities_data;
        $this->data['completed_activities_2024'] = $completed_activities_2024_data;
        $this->data['completed_activities_2025'] = $completed_activities_2025_data;
        $this->data['objectives'] = $objectives;

        // Ambil tahun dari request (default 2025)
        $selected_year = $this->input->get('year') ?? 2025;

        $this->data['selected_year'] = $selected_year;

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
