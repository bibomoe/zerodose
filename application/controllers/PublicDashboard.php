<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicDashboard extends CI_Controller {
    // Constructor untuk memuat model Faskes_model
    public function __construct() {
        parent::__construct();
        //Memuat Helper
        // $this->load->helper('template_helper');

        // Memuat library Curl yang baru dibuat
        // $this->load->library('curl');

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

    public function index() {
        // Ambil filter provinsi dari dropdown (default: all)
        $selected_province = $this->input->get('province') ?? 'all';
        $selected_district = $this->input->get('district') ?? 'all';
        $selected_year = $this->input->get('year') ?? 2025; // Default tahun 2025

        $this->data['selected_province'] = $selected_province;
        $this->data['selected_district'] = $selected_district;
        $this->data['selected_year'] = $selected_year;
        $this->data['year'] = $selected_year;

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

        // Menentukan baseline ZD
        if ($selected_province == 'all') {
            // Ambil baseline ZD 2023 dari tabel target_baseline
            $this->data['national_baseline_zd'] = $this->Immunization_model->get_baseline_zd(2023);
        } else {
            // Ambil total ZD dari tabel zd_cases_2023 berdasarkan provinsi yang dipilih
            $this->data['national_baseline_zd'] = $this->Immunization_model->get_zero_dose_by_province($selected_province);
        }

        // Menentukan bahasa yang dipilih
        $selected_language = $this->session->userdata('language') ?? 'en'; // Default ke bahasa Indonesia

        // Ambil data untuk tahun 2024 & 2025
        foreach ([2024, 2025] as $year) {
            // Hitung target dpt1 pertahun
            // if ($selected_province === 'all') {
            //     // Ambil target dari target_coverage untuk semua provinsi
            //     $this->data["total_target_dpt_1_$year"] = $this->Immunization_model->get_total_target_coverage('DPT-1', $year);
            //     $this->data["total_target_dpt_3_$year"] = $this->Immunization_model->get_total_target_coverage('DPT-3', $year);
            //     $this->data["total_target_mr_1_$year"] = $this->Immunization_model->get_total_target_coverage('MR-1', $year);
            // } else {
                // Ambil target dari target_immunization untuk provinsi tertentu atau targeted
                $this->data["total_target_dpt_1_$year"] = $this->Immunization_model->get_total_target('dpt_hb_hib_1', $selected_province, $year);
                $this->data["total_target_dpt_3_$year"] = $this->Immunization_model->get_total_target('dpt_hb_hib_3', $selected_province, $year);
                $this->data["total_target_mr_1_$year"] = $this->Immunization_model->get_total_target('mr_1', $selected_province, $year);
            // }

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
                // } elseif ($this->data["zero_dose_$year"] > 2 * $this->data['national_baseline_zd']) {
                } else {
                    $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% increase from 2023 national baseline for $year";
                // } else {
                //     $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% change from 2023 national baseline for $year";
                }
            } else {
                // Hitung persentase ZD dari baseline 2023
                if ($this->data["zero_dose_$year"] <= $this->data['national_baseline_zd']) {
                    $this->data["zd_narrative_$year"] = round((($this->data['national_baseline_zd'] - $this->data["zero_dose_$year"]) / $this->data['national_baseline_zd']) * 100, 1) . "% penurunan dari baseline nasional 2023 untuk tahun $year";
                // } elseif ($this->data["zero_dose_$year"] > 2 * $this->data['national_baseline_zd']) {
                } else {
                    $this->data["zd_narrative_$year"] = round((($this->data["zero_dose_$year"] - $this->data['national_baseline_zd']) / $this->data['national_baseline_zd']) * 100, 1) . "% peningkatan dari baseline nasional 2023 untuk tahun $year";
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

        // Memuat data terjemahan
        $translations = $this->load_translation_restored($selected_language);

        // Mengirim data terjemahan ke view
        $this->data['translations'] = $translations;

        $data['title'] = 'Zero Dose Public Dashboard';
        $this->load->view('public/restored-zd-children', $this->data);  // Menggunakan helper untuk memuat template
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
                'text2' => 'Based on the Population Census Survey (SUPAS) Year',
                'text3' => 'DPT-1 Coverage Year ',
                'text4' => '% of the target',
                'text5' => 'Zero Dose Year ',
                'text6' => 'from 2023 national baseline for 2024',
                // 'text7' => 'Target Year 2025',
                // 'text8' => 'DPT-1 Coverage Year 2025',
                // 'text9' => 'Zero Dose Year 2025',
                'text10' => 'DPT-3 Coverage Year ',
                'text11' => '% of the baseline',
                'text12' => ' children need vaccination ',
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
                'text_baseline' => 'Jumlah Anak Zero Dose Tahun 2023 (National Baseline)',
                'children' => ' anak',
                'text1' => 'Sasaran Tahun ',
                'text2' => 'Survei Penduduk Antar Sensus Tahun',
                'text3' => 'Cakupan DPT-1 Tahun ',
                'text4' => '% dari sasaran',
                'text5' => 'Jumlah Anak Zero Dose Tahun ',
                'text6' => 'dari baseline nasional 2023 untuk 2024',
                // 'text7' => 'Target Tahun 2025',
                // 'text8' => 'Cakupan DPT-1 Tahun 2025',
                // 'text9' => 'Zero Dose Tahun 2025',
                'text10' => 'Cakupan DPT-3 Tahun ',
                'text11' => '% dari baseline',
                'text12' => ' anak-anak membutuhkan vaksinasi ',
                'text13' => 'Sasaran Cakupan ',
                'text14' => 'Cakupan MR-1 Tahun ',
                // 'text15' => 'Cakupan DPT-3 Tahun 2025',
                // 'text16' => 'Cakupan MR-1 Tahun 2025',
                'text17' => 'Kab/Kota dengan jumlah anak zero dose terbanyak',
                'tabelcoloumn1' => 'Kab/Kota',
                'tabelcoloumn6' => 'Sasaran Kab/Kota',
                'tabelcoloumn2' => 'Total Cakupan DPT1',
                'tabelcoloumn3' => '% dari Total Sasaran',
                'tabelcoloumn4' => 'Jumlah Anak ZD',
                'tabelcoloumn5' => '% dari Zero Dose',
                'text18' => 'Pemetaan Anak Zero Dose',
                'text19' => 'Tren Anak Zero-Dose per Bulan',
                'text20' => 'Jumlah Anak Zero Dose Berdasarkan Jenis Wilayah'
            ]
        ];
    
        return $translations[$lang] ?? $translations['id']; // Default ke bahasa Indonesia
    }

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


}
