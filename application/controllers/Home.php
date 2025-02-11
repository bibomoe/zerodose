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
        
        load_template('dashboard', $this->data);
    }

    // Fungsi lainnya
    public function zd_cases() {
        $this->data['title'] = 'Current ZD Cases';
        load_template('zd-cases', $this->data);
    }

    public function restored() {
        $user_category = $this->session->userdata('user_category');
        $user_province = $this->session->userdata('province_id');
        $user_city = $this->session->userdata('city_id');

        // Ambil filter provinsi dari dropdown (default: all)
        $selected_province = $this->input->get('province') ?? 'all';
        $selected_district = $this->input->get('district') ?? 'all';

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

        // var_dump([
        //     'user_category' => $user_category,
        //     'session_province_id' => $user_province,
        //     'session_city_id' => $user_city,
        //     'input_province' => $this->input->get('province'),
        //     'final_selected_province' => $selected_province
        // ]);
        // exit;
        // Ambil daftar provinsi untuk dropdown + targeted provinces
        $this->data['provinces'] = $this->Immunization_model->get_provinces_with_targeted();
        $this->data['selected_province'] = $selected_province;
        $this->data['selected_district'] = $selected_district;

        // Ambil daftar distrik berdasarkan provinsi
        if ($selected_province !== 'all' && $selected_province !== 'targeted') {
            $this->data['districts'] = $this->Immunization_model->get_cities_by_province($selected_province);
            $this->data['districts_array'] = $this->Immunization_model->get_cities_by_province_array($selected_province);
        } else {
            $this->data['districts'] = [];
            $this->data['districts_array'] = [];
        }

        // Total imunisasi berdasarkan provinsi
        $this->data['total_dpt_1'] = $this->Immunization_model->get_total_vaccine('dpt_hb_hib_1', $selected_province);
        $this->data['total_dpt_2'] = $this->Immunization_model->get_total_vaccine('dpt_hb_hib_2', $selected_province);
        $this->data['total_dpt_3'] = $this->Immunization_model->get_total_vaccine('dpt_hb_hib_3', $selected_province);
        $this->data['total_mr_1'] = $this->Immunization_model->get_total_vaccine('mr_1', $selected_province);

        // Data imunisasi DPT-1 per distrik
        $this->data['districts'] = $this->Immunization_model->get_dpt1_by_district($selected_province);

        // Ambil data cakupan imunisasi berdasarkan provinsi/kota
        $this->data['immunization_data'] = $this->Immunization_model->get_immunization_coverage($selected_province);

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
        $restored_data = $this->Immunization_model->get_restored_children($selected_province);
        $this->data['restored_data'] = [
            'kabupaten' => $restored_data['kabupaten_restored'] ?? 0,
            'kota' => $restored_data['kota_restored'] ?? 0
        ];

        // Cek apakah tombol filter grafik harus ditampilkan
        $this->data['show_chart_filter'] = ($selected_province !== 'all' && $selected_province !== 'targeted');
        $this->data['districts_array'] =  $this->Immunization_model->get_cities_by_province_array($selected_province);

        $this->data['title'] = 'Restored ZD Children';
        load_template('restored-zd-children', $this->data);
    }

    // public function lost() {
    //     $this->data['title'] = 'Lost Children';
    //     load_template('lost-children', $this->data);
    // }

    public function dpt1() {
        // Ambil data dari model
        $this->load->model('Dpt1_model');

        $province_ids = $this->Immunization_model->get_targeted_province_ids(); // Ambil province_id yang priority = 1
        
        // Mendapatkan dropout rates per provinsi
        $dropout_rates = $this->Dpt1_model->get_districts_under_5_percent();
        
        // Menjumlahkan semua nilai dropout rate per provinsi
        $total_dropout_rate = array_sum($dropout_rates);

        // Menambahkan total dropout rate ke data view
        $this->data['total_dropout_rate'] = $total_dropout_rate;

        $this->data['total_dpt1_coverage'] = $this->Dpt1_model->get_total_dpt1_coverage();
        $this->data['total_dpt1_target'] = $this->Dpt1_model->get_total_dpt1_target();
        // $this->data['districts_under_5'] = $this->Dpt1_model->get_districts_under_5_percent();
        $this->data['total_regencies_cities'] = $this->Dpt1_model->get_total_regencies_cities();

        // var_dump($this->data['districts_under_5']);
        // exit;
        

        // Mengambil data cakupan DPT untuk provinsi yang telah dipilih
        // $dpt_under_5_data = $this->Dpt1_model->get_dpt_under_5_percent_cities($province_ids);
        $dpt_under_5_data = $this->Dpt1_model->get_districts_under_5_percent();

        $this->data['total_dpt1_coverage_per_province'] = $this->Dpt1_model->get_dpt1_coverage_per_province($province_ids);
        $this->data['total_dpt1_target_per_province'] = $this->Dpt1_model->get_dpt1_target_per_province($province_ids);
        // Mengambil data total cities per provinsi
        $this->data['total_cities_per_province'] = $this->Dpt1_model->get_total_cities_per_province($province_ids);

        // Kirim data ke view dalam format array
        $this->data['dpt_under_5_data'] = $dpt_under_5_data;
        $this->data['geojson_file'] = base_url('assets/geojson/targeted.geojson');  // File GeoJSON untuk targeted provinces

    
        $this->data['title'] = 'DPT1 in targeted areas';
        load_template('dpt1', $this->data);
    }
    

    public function zd_tracking() {
        $this->data['title'] = 'Primary Health Facility to Conduct Immunization Service as Planned';
        load_template('zd-tracking', $this->data);
    }

    public function dpt_stock() {
        $this->data['title'] = 'Number of DTP Stock Out at Health Facilities';
        load_template('dpt-stock', $this->data);
    }

    public function district() {
        $this->data['title'] = 'District Program, Financing & Policy';
        load_template('district', $this->data);
    }

    public function policy() {
        $this->data['title'] = 'District Policy and Financing';
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

    public function private_health_facilities() {
        $this->data['title'] = 'Number of private health facilities in targeted areas​';
        load_template('private-health-facilities', $this->data);
    }

    public function get_districts_by_province() {
        $province_id = $this->input->get('province_id');
        $districts = $this->Immunization_model->get_cities_by_province($province_id);
        echo json_encode($districts);
    }
    
    public function get_zero_dose_trend_ajax() {
        $province_id = $this->input->get('province');
        $city_id = $this->input->get('district'); // Ambil filter district dari request
        $data = $this->Immunization_model->get_zero_dose_cases($province_id, $city_id);
        
        echo json_encode($data);
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
