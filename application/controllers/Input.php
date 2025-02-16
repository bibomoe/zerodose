<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Input extends CI_Controller {
    // Constructor untuk memuat model Faskes_model
    public function __construct() {
        parent::__construct();
        //Memuat Helper
        // $this->load->helper('template_helper');

        // Memuat library Curl yang baru dibuat
        // $this->load->library('curl');

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

        //Memuat model
        $this->load->model('MonitoringModel');
        $this->load->model('RujukanModel');
        $this->load->model('ReferensiModel');

        $this->load->model('Activity_model');
        $this->load->model('Partner_model');
        $this->load->model('PartnersActivities_model');
        $this->load->model('Transaction_model');
        $this->load->model('Immunization_model');
        $this->load->helper('form');

        $this->load->model('StockOut_model');
        $this->load->model('District_model');
        $this->load->model('Policy_model');
    }

    // public function index() {
    //     $this->data['title'] = 'Input Data Current ZD Cases';
    //     load_template('input/zd-cases', $this->data);
    // }

    // public function restored() {
    //     $this->data['title'] = 'Input Data Restored ZD Children';
    //     load_template('input/restored-zd-children', $this->data);
    // }

    // public function lost() {
    //     $this->data['title'] = 'Input Data Lost Children';
    //     load_template('input/lost-children', $this->data);
    // }

    // public function dpt1() {
    //     $this->data['title'] = 'Input Data DTP1 in targeted areas';
    //     load_template('input/dpt1', $this->data);
    // }

    // public function zd_tracking() {
    //     $this->data['title'] = 'Input Data Primary Health Facility to Conduct Immunization Service as Planned';
    //     load_template('input/zd-tracking', $this->data);
    // }

    // public function dpt_stock() {
    //     $this->data['title'] = 'Input Data Number of DTP Stock Out at Health Facilities';
    //     load_template('input/dpt-stock', $this->data);
    // }

    // public function district() {
    //     $this->data['title'] = 'Input Data District Program';
    //     load_template('input/district', $this->data);
    // }

    // public function policy() {
    //     $this->data['title'] = 'Input Data District Policy and Financing';
    //     load_template('input/policy', $this->data);
    // }

    public function grant_implementation() {
        $this->data['title'] = 'Input Data Grants Implementation and Budget Disbursement';
        load_template('input/grant-implementation', $this->data);
    }

    public function private_health_facilities() {
        $this->data['title'] = 'Input Data Number of private health facilities in targeted areas​';
        load_template('input/private-health-facilities', $this->data);
    }

    public function excel() {
        $this->data['title'] = 'Input Data from Excel Template​';
        load_template('input/excel', $this->data);
    }

    public function manual() {
        
        $this->data['title'] = 'Input Data Manual​';
    
        // Ambil data provinsi untuk dropdown
        $provinces = $this->Immunization_model->get_provinces();
        $this->data['province_options'] = ['' => '-- Select Province --'];
        foreach ($provinces as $province) {
            $this->data['province_options'][$province->id] = $province->name_id;
        }
    
        // Ambil tahun dan bulan dalam bentuk array
        $this->data['year_options'] = [
            '2024' => '2024',
            '2025' => '2025'
        ];
        
        $this->data['month_options'] = [
            '1'  => 'January',
            '2'  => 'February',
            '3'  => 'March',
            '4'  => 'April',
            '5'  => 'May',
            '6'  => 'June',
            '7'  => 'July',
            '8'  => 'August',
            '9'  => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];
    
        load_template('input/manual', $this->data);
    }

    public function save_immunization() {
        $data = array(
            'province_id'      => $this->input->post('province_id'),
            'city_id'          => $this->input->post('city_id'),
            'subdistrict_id'   => $this->input->post('subdistrict_id'),
            'puskesmas_id'     => $this->input->post('puskesmas_id'),
            'year'             => $this->input->post('year'),
            'month'            => $this->input->post('month'),
            'dpt_hb_hib_1'     => $this->input->post('dpt_1'),
            'dpt_hb_hib_2'     => $this->input->post('dpt_2'),
            'dpt_hb_hib_3'     => $this->input->post('dpt_3'),
            'mr_1'             => $this->input->post('mr_1')
        );
    
        // Panggil fungsi model untuk menyimpan atau mengupdate data imunisasi
        $this->Immunization_model->save_immunization($data);
    
        $this->session->set_flashdata('success', 'Data berhasil disimpan atau diperbarui!');
        redirect('input/manual');
    }
    
    public function get_cities_by_province() {
        $province_id = $this->input->get('province_id');
        $cities = $this->Immunization_model->get_cities_by_province($province_id);
        echo json_encode($cities);
    }
    
    public function get_subdistricts_by_city() {
        $city_id = $this->input->get('city_id');
        $subdistricts = $this->Immunization_model->get_subdistricts_by_city($city_id);
        echo json_encode($subdistricts);
    }
    
    public function get_puskesmas_by_subdistrict() {
        $subdistrict_id = $this->input->get('subdistrict_id');
        $puskesmas = $this->Immunization_model->get_puskesmas_by_subdistrict($subdistrict_id);
        echo json_encode($puskesmas);
    }
    

    // public function activity_tracker() {
    //     $data['title'] = 'Activity Tracker';
    //     $data['partners'] = $this->Partner_model->get_all_partners();
    //     $data['transactions'] = null;  // Awal tidak ada data transaksi
    //     $data['selected_partner'] = '';
    //     $data['selected_year'] = '';
    //     $data['selected_month'] = '';

    //     load_template('input/activity-tracker', $data);  // Menggunakan helper untuk memuat template
    // }

    // public function filter() {
    //     // Ambil data dari POST atau GET
    //     $partner_id = $this->input->post('partner_id') ?? $this->input->get('partner_id');
    //     $year = $this->input->post('year') ?? $this->input->get('year');
    //     $month = $this->input->post('month') ?? $this->input->get('month');

    //     // Ambil semua activities berdasarkan partner
    //     $activities = $this->Activity_model->get_activities_by_partner($partner_id);

    //     // Ambil data transaksi jika sudah ada
    //     $transactions = $this->Transaction_model->get_transactions($partner_id, $year, $month);

    //     // Gabungkan data activities dengan transaksi
    //     $data['activity_data'] = [];
    //     foreach ($activities as $activity) {
    //         $matched_transaction = null;

    //         // Cari transaksi yang cocok berdasarkan activity_id
    //         foreach ($transactions as $transaction) {
    //             if ($transaction->activity_id == $activity->id) {
    //                 $matched_transaction = $transaction;
    //                 break;
    //             }
    //         }

    //         // Jika transaksi ditemukan, gunakan datanya; jika tidak, buat data kosong
    //         $data['activity_data'][] = [
    //             'id' => $activity->id,
    //             'activity_code' => $activity->activity_code,
    //             'description' => $activity->description,
    //             'number_of_activities' => $matched_transaction ? $matched_transaction->number_of_activities : 0,
    //             'total_budget' => $matched_transaction ? $matched_transaction->total_budget : 0
    //         ];
    //     }

    //     $data['partners'] = $this->Partner_model->get_all_partners();
    //     $data['selected_partner'] = $partner_id;
    //     $data['selected_year'] = $year;
    //     $data['selected_month'] = $month;
    //     $data['title'] = 'Activity Tracker';
    
    //     load_template('input/activity-tracker', $data);
    // }

    // public function save_transaction() {
    //     $partner_id = $this->input->post('partner_id');
    //     $year = $this->input->post('year');
    //     $month = $this->input->post('month');
    //     $activities = $this->input->post('activities');
    
    //     foreach ($activities as $activity_id => $values) {
    //         // Cek apakah transaksi sudah ada
    //         $existing_transaction = $this->Transaction_model->check_transaction_exists($partner_id, $year, $month, $activity_id);
    
    //         $data = [
    //             'partner_id' => $partner_id,
    //             'activity_id' => $activity_id,
    //             'year' => $year,
    //             'month' => $month,
    //             'number_of_activities' => $values['number'],
    //             'total_budget' => $values['budget']
    //         ];
    
    //         if ($existing_transaction) {
    //             // Update data jika sudah ada
    //             $this->Transaction_model->update_transaction($existing_transaction->id, $data);
    //         } else {
    //             // Insert data baru jika belum ada
    //             $this->Transaction_model->insert_transaction($data);
    //         }
    //     }

    //     // Set flashdata untuk notifikasi sukses
    //     $this->session->set_flashdata('success', 'Transactions saved successfully!');
    
    //     // Redirect kembali ke halaman filter dengan parameter yang sama
    //     redirect("input/filter?partner_id=$partner_id&year=$year&month=$month");
    // }

    public function activity_tracker() {
        // Menambahkan data khusus untuk view ini
        $this->data['title'] = 'Activity Tracker';
        $this->data['partners'] = $this->Partner_model->get_all_partners();
        $this->data['transactions'] = null;  // Awal tidak ada data transaksi
        $this->data['selected_partner'] = '';
        $this->data['selected_year'] = '';
        $this->data['selected_month'] = '';
    
        // Load template menggunakan $this->data
        load_template('input/activity-tracker', $this->data);
    }
    
    public function filter() {
        // Ambil data dari POST atau GET
        $partner_id = $this->input->post('partner_id') ?? $this->input->get('partner_id');
        $year = $this->input->post('year') ?? $this->input->get('year');
        $month = $this->input->post('month') ?? $this->input->get('month');
    
        // Ambil semua activities berdasarkan partner
        $activities = $this->Activity_model->get_activities_by_partner($partner_id);
    
        // Ambil data transaksi jika sudah ada
        $transactions = $this->Transaction_model->get_transactions($partner_id, $year, $month);
    
        // Gabungkan data activities dengan transaksi
        $this->data['activity_data'] = [];
        foreach ($activities as $activity) {
            $matched_transaction = null;
    
            // Cari transaksi yang cocok berdasarkan activity_id
            foreach ($transactions as $transaction) {
                if ($transaction->activity_id == $activity->id) {
                    $matched_transaction = $transaction;
                    break;
                }
            }
    
            // Jika transaksi ditemukan, gunakan datanya; jika tidak, buat data kosong
            $this->data['activity_data'][] = [
                'id' => $activity->id,
                'activity_code' => $activity->activity_code,
                'description' => $activity->description,
                'number_of_activities' => $matched_transaction ? $matched_transaction->number_of_activities : 0,
                'total_budget' => $matched_transaction ? $matched_transaction->total_budget : 0
            ];
        }
    
        $this->data['partners'] = $this->Partner_model->get_all_partners();
        $this->data['selected_partner'] = $partner_id;
        $this->data['selected_year'] = $year;
        $this->data['selected_month'] = $month;
        $this->data['title'] = 'Activity Tracker';
    
        // Load template menggunakan $this->data
        load_template('input/activity-tracker', $this->data);
    }
    
    public function save_transaction() {
        $partner_id = $this->input->post('partner_id');
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $activities = $this->input->post('activities');
    
        foreach ($activities as $activity_id => $values) {
            // Cek apakah transaksi sudah ada
            $existing_transaction = $this->Transaction_model->check_transaction_exists($partner_id, $year, $month, $activity_id);
    
            $data = [
                'partner_id' => $partner_id,
                'activity_id' => $activity_id,
                'year' => $year,
                'month' => $month,
                'number_of_activities' => $values['number'],
                'total_budget' => $values['budget']
            ];
    
            if ($existing_transaction) {
                // Update data jika sudah ada
                $this->Transaction_model->update_transaction($existing_transaction->id, $data);
            } else {
                // Insert data baru jika belum ada
                $this->Transaction_model->insert_transaction($data);
            }
        }
    
        // Set flashdata untuk notifikasi sukses
        $this->session->set_flashdata('success', 'Transactions saved successfully!');
    
        // Redirect kembali ke halaman filter dengan parameter yang sama
        redirect("input/filter?partner_id=$partner_id&year=$year&month=$month");
    }

    public function target() {
        // Ambil daftar partner untuk dropdown
        $this->data['partners'] = $this->Partner_model->get_all_partners();

        // Ambil tahun dan bulan dalam bentuk array
        $this->data['year_options'] = [
            '2024' => '2024',
            '2025' => '2025'
        ];

        // Inisialisasi data awal (belum ada filter yang diterapkan)
        $this->data['selected_partner'] = '';
        $this->data['activities'] = [];
        $this->data['title'] = 'Set Target';

        // Ambil data provinsi untuk dropdown
        $provinces = $this->Immunization_model->get_provinces();
        $this->data['province_options'] = ['' => '-- Select Province --'];
        foreach ($provinces as $province) {
            $this->data['province_options'][$province->id] = $province->name_id;
        }

        // Load view untuk form filter
        load_template('input/target', $this->data);
    }

    public function filter_target_budget() {
        // Ambil partner_id dari POST atau GET
        $partner_id = $this->input->post('partner_id') ?? $this->input->get('partner_id');
    
        if (empty($partner_id)) {
            show_error('Partner ID is required!', 400);
        }
    
        // Ambil daftar activities untuk partner
        $activities = $this->Activity_model->get_activities_by_partner($partner_id);
    
        // Ambil target budgets dari tabel partners_activities
        $target_budgets = $this->PartnersActivities_model->get_target_budget_by_partner($partner_id);
    
        // Ambil total budget dari tabel total_target_budgets
        $total_budgets = $this->db->select('year, total_budget')
                                  ->where('partner_id', $partner_id)
                                  ->get('total_target_budgets')
                                  ->result(); // Hasil query sebagai object
    
        // Siapkan variabel untuk menyimpan total budget per tahun
        $total_budget_2024 = 0;
        $total_budget_2025 = 0;
    
        foreach ($total_budgets as $budget) {
            if ($budget->year == 2024) {
                $total_budget_2024 = $budget->total_budget;
            } elseif ($budget->year == 2025) {
                $total_budget_2025 = $budget->total_budget;
            }
        }
    
        // Gabungkan data activities dengan target budgets
        $this->data['activities'] = [];
        foreach ($activities as $activity) {
            $matched_budget = null;
    
            foreach ($target_budgets as $budget) {
                if ($budget->activity_id == $activity->id) {
                    $matched_budget = $budget;
                    break;
                }
            }
    
            // Tambahkan data target budget ke setiap activity
            $this->data['activities'][] = [
                'id' => $activity->id,
                'activity_code' => $activity->activity_code,
                'description' => $activity->description,
                'target_budget_2024' => $matched_budget ? $matched_budget->target_budget_2024 : 0,
                'target_budget_2025' => $matched_budget ? $matched_budget->target_budget_2025 : 0,
            ];
        }

        // Ambil data provinsi untuk dropdown
        $provinces = $this->Immunization_model->get_provinces();
        $this->data['province_options'] = ['' => '-- Select Province --'];
        foreach ($provinces as $province) {
            $this->data['province_options'][$province->id] = $province->name_id;
        }

        // Tambahkan data untuk view
        $this->data['partners'] = $this->Partner_model->get_all_partners();
        $this->data['selected_partner'] = $partner_id;
        $this->data['total_budget_2024'] = $total_budget_2024;
        $this->data['total_budget_2025'] = $total_budget_2025;
        $this->data['title'] = 'Set Target Budget for 2024 and 2025';
    
        // Load view
        load_template('input/target', $this->data);
    }

    public function save_target_budget() {
        $partner_id = $this->input->post('partner_id');
        $activities = $this->input->post('activities'); // Data target budget untuk setiap activity
        $total_budget_2024 = $this->input->post('total_budget_2024'); // Total 2024
        $total_budget_2025 = $this->input->post('total_budget_2025'); // Total 2025

        // Simpan target budget untuk setiap activity
        foreach ($activities as $activity_id => $values) {
            $this->PartnersActivities_model->update_target_budget($partner_id, $activity_id, [
                'target_budget_2024' => $values['target_budget_2024'],
                'target_budget_2025' => $values['target_budget_2025'],
            ]);
        }

        // Simpan atau update total budget untuk tahun 2024
        $this->db->replace('total_target_budgets', [
            'partner_id' => $partner_id,
            'year' => 2024,
            'total_budget' => $total_budget_2024,
        ]);

        // Simpan atau update total budget untuk tahun 2025
        $this->db->replace('total_target_budgets', [
            'partner_id' => $partner_id,
            'year' => 2025,
            'total_budget' => $total_budget_2025,
        ]);

        // Flashdata untuk notifikasi sukses
        $this->session->set_flashdata('success', 'Target budgets and totals saved successfully!');

        // Redirect kembali ke halaman filter dengan parameter yang sama
        redirect('input/filter_target_budget?partner_id=' . $partner_id);
    }
    
    // Menyimpan target imunisasi
    public function save_target_immunization() {
        // Ambil data dari form input
        $data = array(
            'province_id'             => $this->input->post('province_id'),
            'city_id'                 => $this->input->post('city_id'),
            'dpt_hb_hib_1_target'    => $this->input->post('dpt_hb_hib_1_target'),
            'dpt_hb_hib_2_target'    => $this->input->post('dpt_hb_hib_2_target'),
            'dpt_hb_hib_3_target'    => $this->input->post('dpt_hb_hib_3_target'),
            'mr_1_target'            => $this->input->post('mr_1_target'),
            'dpt_hb_hib_1_target_actual' => $this->input->post('dpt_hb_hib_1_target_actual'),
            'dpt_hb_hib_2_target_actual' => $this->input->post('dpt_hb_hib_2_target_actual'),
            'dpt_hb_hib_3_target_actual' => $this->input->post('dpt_hb_hib_3_target_actual'),
            'mr_1_target_actual'     => $this->input->post('mr_1_target_actual'),
            'year'                   => $this->input->post('year') // Menambahkan kolom year
        );
        
        // Simpan data target imunisasi
        $this->Immunization_model->save_target_immunization($data);
        
        // Set flash message dan redirect
        $this->session->set_flashdata('success', 'Target imunisasi berhasil disimpan!');
        redirect('input/target');
    }


    public function get_target_immunization()
    {
        $province_id = $this->input->get('province_id');
        $city_id = $this->input->get('city_id');
        $year = $this->input->get('year');

        // Jika province_id kosong, return array kosong
        // if (empty($province_id)) {
        //     echo json_encode([]);
        //     return;
        // }

        $this->db->select('target_immunization.*, provinces.name_id AS province_name, cities.name_id AS city_name');
        $this->db->from('target_immunization');
        $this->db->join('provinces', 'provinces.id = target_immunization.province_id', 'left');
        $this->db->join('cities', 'cities.id = target_immunization.city_id', 'left');
        

        // Province ID opsional (jika ada, tambahkan filter)
        if (!empty($province_id)) {
            $this->db->where('target_immunization.province_id', $province_id);
        }

        // City ID opsional (jika ada, tambahkan filter)
        if (!empty($city_id)) {
            $this->db->where('target_immunization.city_id', $city_id);
        }

        // Year opsional (jika ada, tambahkan filter)
        // if (!empty($year)) {
        //     $this->db->where('target_immunization.year', $year);
        // }


        $query = $this->db->get();
        echo json_encode($query->result());
    }

    public function delete_target_immunization()
    {
        $id = $this->input->post('id');

        if ($this->db->where('id', $id)->delete('target_immunization')) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function get_immunization_data()
    {
        $province_id = $this->input->get('province_id');
        $city_id = $this->input->get('city_id');
        $subdistrict_id = $this->input->get('subdistrict_id');
        $puskesmas_id = $this->input->get('puskesmas_id');
        $year = $this->input->get('year');
        $month = $this->input->get('month');

        // Periksa apakah province_id dan city_id diberikan
        if (empty($province_id) || empty($city_id) || empty($year) || empty($month)) {
            // Return empty array jika filter yang wajib kosong
            echo json_encode([]);
            return;
        }

        $this->db->select('immunization_data.*, provinces.name_id AS province_name, 
                            cities.name_id AS city_name, subdistricts.name AS subdistrict_name, 
                            puskesmas.name AS puskesmas_name');
        $this->db->from('immunization_data');
        $this->db->join('provinces', 'provinces.id = immunization_data.province_id', 'left');
        $this->db->join('cities', 'cities.id = immunization_data.city_id', 'left');
        $this->db->join('subdistricts', 'subdistricts.id = immunization_data.subdistrict_id', 'left');
        $this->db->join('puskesmas', 'puskesmas.id = immunization_data.puskesmas_id', 'left');

        if (!empty($province_id)) {
            $this->db->where('immunization_data.province_id', $province_id);
        }
        if (!empty($city_id)) {
            $this->db->where('immunization_data.city_id', $city_id);
        }
        if (!empty($subdistrict_id)) {
            $this->db->where('immunization_data.subdistrict_id', $subdistrict_id);
        }
        if (!empty($puskesmas_id)) {
            $this->db->where('immunization_data.puskesmas_id', $puskesmas_id);
        }
        if (!empty($year)) {
            $this->db->where('immunization_data.year', $year);
        }
        if (!empty($month)) {
            $this->db->where('immunization_data.month', $month);
        }

        $query = $this->db->get();
        echo json_encode($query->result());
    }

    public function delete_immunization_data($id) {
        // Verifikasi CSRF
        // if ($this->security->get_csrf_hash() !== $this->input->post($this->security->get_csrf_token_name())) {
        //     echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
        //     return;
        // }
        
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }
    
        $this->db->where('id', $id);
        $this->db->delete('immunization_data');
    
        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete data']);
        }
    }

    // Simpan data stock out
    public function save_stock_out() {
        $data = [
            'province_id' => $this->input->post('province_id'),
            'city_id'     => $this->input->post('city_id'),
            'year'        => $this->input->post('year'),
            'month'       => $this->input->post('month'),
            'vaccine_type'=> $this->input->post('vaccine_type'),
            'stock_out_1_month' => $this->input->post('stock_out_1_month'),
            'stock_out_2_months'=> $this->input->post('stock_out_2_months'),
            'stock_out_3_months'=> $this->input->post('stock_out_3_months'),
            'stock_out_more_than_3_months' => $this->input->post('stock_out_more_than_3_months')
        ];

        $this->StockOut_model->save_stock_out($data);
        $this->session->set_flashdata('success', 'Stock out data saved successfully!');
        redirect('input/manual');
    }

    // Ambil data stock out berdasarkan filter
    public function get_stock_out_data() {
        $province_id = $this->input->get('province_id');
        $city_id     = $this->input->get('city_id');
        $year        = $this->input->get('year');
        $month       = $this->input->get('month');

        $data = $this->StockOut_model->get_stock_out_data($province_id, $city_id, $year, $month);
        echo json_encode($data);
    }

    // Hapus data stock out
    public function delete_stock_out_data($id) {
        //Verifikasi CSRF
        // if ($this->security->get_csrf_hash() !== $this->input->post($this->security->get_csrf_token_name())) {
        //     echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
        //     return;
        // }

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $this->StockOut_model->delete_stock_out($id);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete data']);
        }
    }
    
    // ✅ Simpan data Supportive Supervision
    public function save_supportive_supervision() {
        $data = [
            'province_id' => $this->input->post('province_id'),
            'city_id'     => $this->input->post('city_id'),
            'year'        => $this->input->post('year'),
            'month'       => $this->input->post('month'),
            'good_category_puskesmas' => $this->input->post('good_category_puskesmas')
        ];

        $this->District_model->save_supportive_supervision($data);
        $this->session->set_flashdata('success', 'Supportive Supervision data saved successfully!');
        redirect('input/manual');
    }

    // ✅ Ambil data Supportive Supervision berdasarkan filter
    public function get_supportive_supervision_data() {
        $province_id = $this->input->get('province_id');
        $city_id     = $this->input->get('city_id');
        $year        = $this->input->get('year');
        $month       = $this->input->get('month');

        $data = $this->District_model->get_supportive_supervision_data($province_id, $city_id, $year, $month);
        echo json_encode($data);
    }

    // ✅ Hapus data Supportive Supervision
    public function delete_supportive_supervision_data($id) {
        // //Verifikasi CSRF
        // if ($this->security->get_csrf_hash() !== $this->input->post($this->security->get_csrf_token_name())) {
        //     echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
        //     return;
        // }

        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $this->District_model->delete_supportive_supervision($id);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete data']);
        }
    }

    // Fungsi untuk menyimpan data private facility training
    public function save_private_facility_training() {
        $data = [
            'province_id' => $this->input->post('province_id'),
            'year'        => $this->input->post('year'),
            'month'       => $this->input->post('month'),
            'total_private_facilities' => $this->input->post('total_private_facilities'),
            'trained_private_facilities' => $this->input->post('trained_private_facilities')
        ];

        $this->District_model->save_private_facility_training($data);
        $this->session->set_flashdata('success', 'Private facility training data saved successfully!');
        redirect('input/manual');
    }

    // Fungsi untuk mengambil data private facility training berdasarkan filter
    public function get_private_facility_training_data() {
        $province_id = $this->input->get('province_id');
        $year = $this->input->get('year');
        $month = $this->input->get('month');

        $data = $this->District_model->get_private_facility_training_data($province_id, $year, $month);
        echo json_encode($data);
    }

    // Fungsi untuk menghapus data private facility training
    public function delete_private_facility_training_data($id) {
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        $this->District_model->delete_private_facility_training($id);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete data']);
        }
    }

    public function save_district_funding() {
        $data = [
            'province_id'              => $this->input->post('province_id'),
            'year'                     => $this->input->post('year'),
            'month'                    => $this->input->post('month'),
            'funded_districts'         => $this->input->post('funded_districts'),
        ];
    
        
        $result = $this->Policy_model->save_district_funding($data);
    
        if ($result) {
            $this->session->set_flashdata('success', 'District funding data saved successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to save district funding data.');
        }
    
        redirect('input/manual');
    }
    
    public function get_district_funding_data() {
        $province_id = $this->input->get('province_id');
        $year        = $this->input->get('year');
        $month       = $this->input->get('month');
    
        
        $data = $this->Policy_model->get_district_funding_data($province_id, $year, $month);
    
        echo json_encode($data);
    }

    public function delete_district_funding_data($id) {
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }
    
        
        $this->Policy_model->delete_district_funding($id);
    
        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete data']);
        }
    }

    // Fungsi untuk menyimpan data district policy
    public function save_district_policy() {
        $data = [
            'province_id'       => $this->input->post('province_id'),
            'year'              => $this->input->post('year'),
            'month'             => $this->input->post('month'),
            'policy_districts'  => $this->input->post('policy_districts')
        ];

        // Simpan data ke database
        $this->Policy_model->save_district_policy($data);
        
        // Set flashdata dan redirect
        $this->session->set_flashdata('success', 'District policy data saved successfully!');
        redirect('input/manual'); // Redirect kembali ke halaman manual
    }

    // Fungsi untuk mengambil data district policy berdasarkan filter
    public function get_district_policy_data() {
        $province_id = $this->input->get('province_id');
        $year        = $this->input->get('year');
        $month       = $this->input->get('month');

        $data = $this->Policy_model->get_district_policy_data($province_id, $year, $month);
        echo json_encode($data);
    }

    // Fungsi untuk menghapus data district policy
    public function delete_district_policy_data($id) {
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            return;
        }

        // Hapus data
        $this->Policy_model->delete_district_policy($id);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete data']);
        }
    }
    


}
