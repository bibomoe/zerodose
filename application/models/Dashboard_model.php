<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    /**
     * Mengambil total target budget berdasarkan tahun
     */
    public function get_total_target_budget_by_year($year, $partner_id = null) {
        $this->db->select('SUM(target_budget_' . $year . ') AS total_target_budget');
        $this->db->from('partners_activities');

        if ($partner_id && $partner_id !== 'all') {
            $this->db->where('partner_id', $partner_id);
        }

        $result = $this->db->get()->row_array();
        return $result['total_target_budget'] ?? 0;
    }

    /**
     * Mengambil data serapan anggaran kumulatif dengan persentase terhadap target budget
     */
    public function get_cumulative_budget_absorption_with_percentage($year, $partner_id = null) {
        // Ambil total target budget
        $total_target_budget = $this->get_total_target_budget_by_year($year, $partner_id);

        $this->db->select('MONTH, SUM(total_budget) AS total_budget');
        $this->db->from('transactions');
        $this->db->where('year', $year);

        if ($partner_id && $partner_id !== 'all') {
            $this->db->where('partner_id', $partner_id);
        }

        $this->db->group_by('MONTH');
        $this->db->order_by('MONTH', 'ASC');
        $data = $this->db->get()->result_array();

        // Inisialisasi array kumulatif
        $cumulative = [];
        $total = 0;
        $months = range(1, 12); // Semua bulan (1 sampai 12)

        foreach ($months as $month) {
            $found = false;

            foreach ($data as $row) {
                if ($row['MONTH'] == $month) {
                    $total += $row['total_budget']; // Tambahkan nilai kumulatif
                    $percentage = ($total_target_budget > 0) ? ($total / $total_target_budget) * 100 : 0;
                    $cumulative[] = [
                        'MONTH' => $month,
                        'total_budget' => $total,
                        'percentage' => round($percentage, 2)
                    ];
                    $found = true;
                    break;
                }
            }

            // Jika bulan tidak ada di data transaksi, tambahkan nilai terakhir
            if (!$found) {
                $percentage = ($total_target_budget > 0) ? ($total / $total_target_budget) * 100 : 0;
                $cumulative[] = [
                    'MONTH' => $month,
                    'total_budget' => $total,
                    'percentage' => round($percentage, 2)
                ];
            }
        }

        return $cumulative;
    }

    /**
     * Menghitung total serapan anggaran untuk tahun tertentu (diambil dari bulan Desember)
     */
    public function get_total_budget_absorption_percentage($year, $partner_id = null) {
        $data = $this->get_cumulative_budget_absorption_with_percentage($year, $partner_id);

        // Ambil data bulan terakhir (Desember)
        return $data[11]['percentage'] ?? 0;
    }

    /**
     * Mengambil jumlah aktivitas yang sudah terlaksana dalam bentuk persentase berdasarkan country objectives
     */
    public function get_completed_activities_percentage_by_year($year, $partner_id = null) {
        // Ambil semua objectives
        $objectives = $this->db->select('id')->from('country_objectives')->get()->result_array();
    
        // Ambil total activities per objective
        $this->db->select('a.objective_id, COUNT(DISTINCT a.id) AS total');
        $this->db->from('activities a');
        $this->db->join('country_objectives o', 'a.objective_id = o.id', 'left');
    
        if (!is_null($partner_id) && $partner_id !== 'all') {
            $this->db->join('partners_activities pa', 'a.id = pa.activity_id');
            $this->db->where('pa.partner_id', $partner_id);
        }
    
        $this->db->group_by('a.objective_id');
        $query = $this->db->get();
        $total_activities = $query->result_array();
    
        // Ambil jumlah completed activities per objective
        $this->db->select('a.objective_id, COUNT(DISTINCT t.activity_id) AS completed');
        $this->db->from('transactions t');
        $this->db->join('activities a', 't.activity_id = a.id');
        $this->db->join('country_objectives o', 'a.objective_id = o.id', 'left');
    
        $this->db->where('t.year', $year);
        $this->db->where('t.number_of_activities >', 0);
    
        if (!is_null($partner_id) && $partner_id !== 'all') {
            $this->db->where('t.partner_id', $partner_id);
        }
    
        $this->db->group_by('a.objective_id');
        $query = $this->db->get();
        $completed_activities = $query->result_array();
    
        // Gabungkan data ke dalam array sesuai objective_id
        $result = [];
    
        foreach ($objectives as $objective) {
            $objective_id = $objective['id'];
            $total = 0;
            $completed = 0;
    
            // Cari total activities
            foreach ($total_activities as $activity) {
                if ($activity['objective_id'] == $objective_id) {
                    $total = $activity['total'];
                    break;
                }
            }
    
            // Cari jumlah completed berdasarkan objective_id
            foreach ($completed_activities as $completed_activity) {
                if ($completed_activity['objective_id'] == $objective_id) {
                    $completed = $completed_activity['completed'];
                    break;
                }
            }
    
            // Jika total = 0 tapi filter per partner, maka 100%
            if ($total == 0 && (!is_null($partner_id) && $partner_id !== 'all')) {
                $percentage = 100;
            } else {
                $percentage = ($total > 0) ? ($completed / $total) * 100 : 0; 
            }
    
            $result[$objective_id] = round($percentage, 2);
        }
    
        return $result;
    }
    
    

    /**
     * Mengambil semua country objectives
     */
    public function get_all_objectives() {
        if($this->session->userdata('language') == 'id'){
            $this->db->select('id, objective_name_id as objective_name');
        } else {
            $this->db->select('id, objective_name');
        }
        

        $this->db->from('country_objectives');
        return $this->db->get()->result_array();
    }

    // public function get_long_term_outcomes() {
    //     // Ambil daftar 10 provinsi prioritas
    //     $priority_provinces = $this->db->select('id')
    //                                    ->where('priority', 1)
    //                                    ->get('provinces')
    //                                    ->result_array();
    //     $province_ids = array_column($priority_provinces, 'id');
    
    //     // Ambil baseline dari tabel target_baseline (Baseline ZD 2023)
    //     $baseline = $this->db->get_where('target_baseline', ['year' => 2024])->row_array();
    //     // $baseline_zd_2023 = $baseline['zd'];
    //     $baseline_zd_2024 = $baseline['zd'];
    
    //     // Ambil target dari tabel target_coverage untuk DPT3 & MR1 per tahun
    //     $this->db->select("
    //         SUM(CASE WHEN year = 2025 AND vaccine_type = 'DPT-3' THEN target_population ELSE 0 END) AS baseline_dpt3_y1,
    //         SUM(CASE WHEN year = 2026 AND vaccine_type = 'DPT-3' THEN target_population ELSE 0 END) AS baseline_dpt3_y2,
    //         SUM(CASE WHEN year = 2025 AND vaccine_type = 'MR-1' THEN target_population ELSE 0 END) AS baseline_mr1_y1,
    //         SUM(CASE WHEN year = 2026 AND vaccine_type = 'MR-1' THEN target_population ELSE 0 END) AS baseline_mr1_y2
    //     ", FALSE);
    //     $coverage = $this->db->get('target_coverage')->row_array();
    
    //     // DPT3 Coverage
    //     $this->db->select("
    //         (SUM(CASE WHEN year = 2025 THEN dpt_hb_hib_3 ELSE 0 END) / NULLIF({$coverage['baseline_dpt3_y1']}, 0)) * 100 AS actual_y1,
    //         (SUM(CASE WHEN year = 2026 THEN dpt_hb_hib_3 ELSE 0 END) / NULLIF({$coverage['baseline_dpt3_y2']}, 0)) * 100 AS actual_y2
    //     ", FALSE);
    //     // $this->db->where_in('province_id', $province_ids);
    //     $dpt3 = $this->db->get('immunization_data')->row_array();
    
    //     // MR1 Coverage
    //     $this->db->select("
    //         (SUM(CASE WHEN year = 2025 THEN mr_1 ELSE 0 END) / NULLIF({$coverage['baseline_mr1_y1']}, 0)) * 100 AS actual_y1,
    //         (SUM(CASE WHEN year = 2026 THEN mr_1 ELSE 0 END) / NULLIF({$coverage['baseline_mr1_y2']}, 0)) * 100 AS actual_y2
    //     ", FALSE);
    //     // $this->db->where_in('province_id', $province_ids);
    //     $mr1 = $this->db->get('immunization_data')->row_array();
    
    //     // // Reduction in Zero Dose (ZD) berdasarkan target baseline 2023
    //     // $target_reduction_y1 = 0.25 * $baseline_zd_2023; // 25% dari baseline ZD 2023
    //     // $target_reduction_y2 = 0.10 * $baseline_zd_2023; // 10% dari baseline ZD 2023
    
    //     // // Hitung realisasi reduction ZD
    //     // $this->db->select("
    //     //     SUM(CASE WHEN year = 2025 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y1,
    //     //     SUM(CASE WHEN year = 2026 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y2
    //     // ", FALSE);
    //     // // $this->db->where_in('province_id', $province_ids);
    //     // $reduction_zd = $this->db->get('immunization_data')->row_array();
    
    //     // // Menghitung persentase realisasi reduction ZD
    //     // $percent_reduction_y1 = ($baseline_zd_2023 - $reduction_zd['actual_y1']) / $baseline_zd_2023 * 100;
    //     // $percent_reduction_y2 = ($baseline_zd_2023 - $reduction_zd['actual_y2']) / $baseline_zd_2023 * 100;
        
    //     // Reduction in Zero Dose (DPT1) berdasarkan target_coverage
    //     $this->db->select("
    //     SUM(CASE WHEN year = 2025 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS target_dpt1_y1,
    //     SUM(CASE WHEN year = 2026 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS target_dpt1_y2
    //     ", FALSE);
    //     $target_dpt1 = $this->db->get('target_coverage')->row_array();

    //     // // Ambil realisasi imunisasi DPT-1 dari immunization_data
    //     // $this->db->select("
    //     // SUM(CASE WHEN year = 2025 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y1,
    //     // SUM(CASE WHEN year = 2026 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y2
    //     // ", FALSE);
    //     // //$this->db->where_in('province_id', $province_ids);
    //     // $reduction_zd = $this->db->get('immunization_data')->row_array();

    //     // // Hitung jumlah anak yang belum menerima DPT-1 (Zero Dose)
    //     // $zd_remaining_y1 = max($target_dpt1['target_dpt1_y1'] - $reduction_zd['actual_y1'], 0);
    //     // $zd_remaining_y2 = max($target_dpt1['target_dpt1_y2'] - $reduction_zd['actual_y2'], 0);

    //     // // Menghitung persentase pengurangan zero dose
    //     // $percent_reduction_y1 = ($baseline_zd_2024 - $zd_remaining_y1) / $baseline_zd_2024 * 100;
    //     // $percent_reduction_y2 = ($baseline_zd_2024 - $zd_remaining_y2) / $baseline_zd_2024 * 100;

    //     // Ambil realisasi imunisasi DPT-1 dari tabel immunization_data_kejar
    //     $this->db->select("
    //         SUM(CASE WHEN year = 2025 THEN dpt1_coverage ELSE 0 END) AS actual_y1,
    //         SUM(CASE WHEN year = 2026 THEN dpt1_coverage ELSE 0 END) AS actual_y2
    //     ", FALSE);

    //     // Pastikan untuk menambahkan kondisi yang sesuai, seperti provinsi atau kota, jika perlu
    //     //$this->db->where_in('province_id', $province_ids);
    //     $reduction_zd = $this->db->get('immunization_data_kejar')->row_array();

    //     // Menghitung persentase pengurangan zero dose berdasarkan cakupan
    //     $percent_reduction_y1 = ($reduction_zd['actual_y1'] / $baseline_zd_2024) * 100;
    //     $percent_reduction_y2 = ($reduction_zd['actual_y2'] / $baseline_zd_2024) * 100;

    //     // Menghitung persentase pengurangan zero dose, jika negatif maka set ke 0
    //     // $percent_reduction_y1 = max(($baseline_zd_2023 - $zd_remaining_y1) / $baseline_zd_2023 * 100, 0);
    //     // $percent_reduction_y2 = max(($baseline_zd_2023 - $zd_remaining_y2) / $baseline_zd_2023 * 100, 0);

    //     return [
    //         'dpt3' => [
    //             'baseline' => 4_199_289, // Sesuai dengan nilai tetap yang ada di view
    //             'baseline_y1' => $coverage['baseline_dpt3_y1'],
    //             'baseline_y2' => $coverage['baseline_dpt3_y2'],
    //             'actual_y1' => $dpt3['actual_y1'],
    //             'actual_y2' => $dpt3['actual_y2']
    //         ],
    //         'mr1' => [
    //             'baseline' => 4_244_731, // Sesuai dengan nilai tetap yang ada di view
    //             'baseline_y1' => $coverage['baseline_mr1_y1'],
    //             'baseline_y2' => $coverage['baseline_mr1_y2'],
    //             'actual_y1' => $mr1['actual_y1'],
    //             'actual_y2' => $mr1['actual_y2']
    //         ],
    //         'reduction_zd' => [
    //             // 'baseline' => "25% of {$baseline_zd_2023} (per Dec 2022)",
    //             'baseline' => $baseline_zd_2024,
    //             // 'target_y1' => $target_reduction_y1,
    //             // 'target_y2' => $target_reduction_y2,
    //             'actual_y1' => $percent_reduction_y1,
    //             'actual_y2' => $percent_reduction_y2
    //         ]
    //     ];
    // }

    public function get_long_term_outcomes() {
        // Ambil daftar 10 provinsi prioritas
        $priority_provinces = $this->db->select('id')
                                    ->where('priority', 1)
                                    ->get('provinces')
                                    ->result_array();
        $province_ids = array_column($priority_provinces, 'id');

        // Ambil baseline dari tabel target_baseline (Baseline ZD 2024)
        $baseline = $this->db->get_where('target_baseline', ['year' => 2024])->row_array();
        $baseline_zd_2024 = $baseline['zd'];

        // Ambil target dari tabel target_coverage untuk DPT3 & MR1 per tahun
        $this->db->select("
            SUM(CASE WHEN year = 2025 AND vaccine_type = 'DPT-3' THEN target_population ELSE 0 END) AS baseline_dpt3_y1,
            SUM(CASE WHEN year = 2026 AND vaccine_type = 'DPT-3' THEN target_population ELSE 0 END) AS baseline_dpt3_y2,
            SUM(CASE WHEN year = 2025 AND vaccine_type = 'MR-1' THEN target_population ELSE 0 END) AS baseline_mr1_y1,
            SUM(CASE WHEN year = 2026 AND vaccine_type = 'MR-1' THEN target_population ELSE 0 END) AS baseline_mr1_y2,
            SUM(CASE WHEN year = 2025 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS target_dpt1_y1,
            SUM(CASE WHEN year = 2026 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS target_dpt1_y2
        ", FALSE);
        $coverage = $this->db->get('target_coverage')->row_array();

        // --- DPT3 Coverage (Absolut & Persen)
        $this->db->select("
            SUM(CASE WHEN year = 2025 THEN dpt_hb_hib_3 ELSE 0 END) AS absolute_y1,
            SUM(CASE WHEN year = 2026 THEN dpt_hb_hib_3 ELSE 0 END) AS absolute_y2
        ", FALSE);
        $dpt3_raw = $this->db->get('immunization_data')->row_array();
        $dpt3 = [
            'absolute_y1' => (int) $dpt3_raw['absolute_y1'],
            'absolute_y2' => (int) $dpt3_raw['absolute_y2'],
            'actual_y1'   => $coverage['baseline_dpt3_y1'] > 0 ? round($dpt3_raw['absolute_y1'] / $coverage['baseline_dpt3_y1'] * 100, 2) : 0,
            'actual_y2'   => $coverage['baseline_dpt3_y2'] > 0 ? round($dpt3_raw['absolute_y2'] / $coverage['baseline_dpt3_y2'] * 100, 2) : 0,
            'baseline_y1' => $coverage['baseline_dpt3_y1'],
            'baseline_y2' => $coverage['baseline_dpt3_y2'],
            'baseline'    => 4_199_289 // statis
        ];

        // --- MR1 Coverage
        $this->db->select("
            SUM(CASE WHEN year = 2025 THEN mr_1 ELSE 0 END) AS absolute_y1,
            SUM(CASE WHEN year = 2026 THEN mr_1 ELSE 0 END) AS absolute_y2
        ", FALSE);
        $mr1_raw = $this->db->get('immunization_data')->row_array();
        $mr1 = [
            'absolute_y1' => (int) $mr1_raw['absolute_y1'],
            'absolute_y2' => (int) $mr1_raw['absolute_y2'],
            'actual_y1'   => $coverage['baseline_mr1_y1'] > 0 ? round($mr1_raw['absolute_y1'] / $coverage['baseline_mr1_y1'] * 100, 2) : 0,
            'actual_y2'   => $coverage['baseline_mr1_y2'] > 0 ? round($mr1_raw['absolute_y2'] / $coverage['baseline_mr1_y2'] * 100, 2) : 0,
            'baseline_y1' => $coverage['baseline_mr1_y1'],
            'baseline_y2' => $coverage['baseline_mr1_y2'],
            'baseline'    => 4_244_731
        ];

        // --- Reduction in Zero Dose (DPT1)
        $this->db->select("
            SUM(CASE WHEN year = 2025 THEN dpt1_coverage ELSE 0 END) AS absolute_y1,
            SUM(CASE WHEN year = 2026 THEN dpt1_coverage ELSE 0 END) AS absolute_y2
        ", FALSE);
        $zd_raw = $this->db->get('immunization_data_kejar')->row_array();
        $zd = [
            'absolute_y1' => (int) $zd_raw['absolute_y1'],
            'absolute_y2' => (int) $zd_raw['absolute_y2'],
            'actual_y1'   => $baseline_zd_2024 > 0 ? round(($zd_raw['absolute_y1'] / $baseline_zd_2024) * 100, 2) : 0,
            'actual_y2'   => $baseline_zd_2024 > 0 ? round(($zd_raw['absolute_y2'] / $baseline_zd_2024) * 100, 2) : 0,
            'baseline'    => $baseline_zd_2024
        ];

        return [
            'dpt3' => $dpt3,
            'mr1' => $mr1,
            'reduction_zd' => $zd
        ];
    }


    public function get_dpt1_coverage_percentage($year) {
        $this->load->model('Dpt1_model'); // Pastikan model Dpt1_model diload
    
        $total_coverage = $this->Dpt1_model->get_total_dpt1_coverage($year, 'all', 'all');
        $total_target = $this->Dpt1_model->get_total_dpt1_target($year, 'all', 'all');
    
        // Hitung persentase cakupan DPT1
        return ($total_target > 0) ? round(($total_coverage / $total_target) * 100, 2) : 0;
    }
    
    public function get_districts_under_5_percentage($year) {
        $this->load->model('Dpt1_model'); // Pastikan model Dpt1_model diload
    
        $total_dropout_rate = array_sum($this->Dpt1_model->get_districts_under_5_percent($year, 'all'));
        $total_regencies = $this->Dpt1_model->get_total_regencies_cities('all');
    
        // Hitung persentase distrik dengan DO < 5%
        return ($total_regencies > 0) ? round(($total_dropout_rate / $total_regencies) * 100, 2) : 0;
    }

    public function get_puskesmas_immunization_percentage($year) {
        $this->db->select("
            (COUNT(DISTINCT i.puskesmas_id) / COUNT(DISTINCT p.id)) * 100 AS percentage", false);
        $this->db->from('puskesmas p');
        $this->db->join('immunization_data i', 'i.puskesmas_id = p.id AND i.year = ' . $this->db->escape($year), 'left');
    
        $query = $this->db->get();
        return $query->row()->percentage ?? 0;
    }

    public function get_puskesmas_immunized_absolute($year) {
        $this->db->distinct();
        $this->db->select('puskesmas_id');
        $this->db->from('immunization_data');
        $this->db->where('year', $year);

        return $this->db->get()->num_rows();
    }

    public function get_total_puskesmas() {
        $this->db->where('active', 1); // Pastikan hanya yang aktif
        return $this->db->count_all_results('puskesmas');
    }


    // public function get_total_dpt_stock_out($year) {
    //     $this->db->select('
    //         SUM(stock_out_1_month) + 
    //         SUM(stock_out_2_months) + 
    //         SUM(stock_out_3_months) + 
    //         SUM(stock_out_more_than_3_months) AS total_stock_out', false);
    //     $this->db->from('stock_out_data');
    //     $this->db->where('vaccine_type', 'DPT'); // Hanya untuk DPT
    //     $this->db->where('year', $year);
    
    //     $query = $this->db->get();
    //     return $query->row()->total_stock_out ?? 0;
    // }

    // Fungsi untuk mengambil data stok kosong per puskesmas dan bulan, termasuk data tahun sebelumnya
    public function get_dpt_stock_out_by_month($province_id, $year) {
        // Ambil data vaksin per puskesmas tanpa melakukan SUM atau GROUP BY
        $this->db->select('month, 
                        year,
                        province_id, 
                        city_id, 
                        subdistrict_id, 
                        puskesmas_id, 
                        DPT_HB_Hib_5_ds, 
                        Pentavalent_Easyfive_10_ds, 
                        Pentavac_10_ds, 
                        Vaksin_ComBE_Five_10_ds, 
                        status_stockout'); // Menambahkan status_stockout
        $this->db->from('puskesmas_stock_out_details');

        // Ambil data untuk tahun yang diminta
        $this->db->where('year', $year);

        // Jika province_id tidak 'all', filter berdasarkan province_id
        if ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        // Ambil data untuk tahun sebelumnya
        $this->db->or_where('year', $year - 1);

        // Urutkan berdasarkan tahun, bulan, dan puskesmas_id
        $this->db->order_by('year', 'ASC');
        $this->db->order_by('month', 'ASC');
        $this->db->order_by('puskesmas_id', 'ASC');

        // Ambil data yang sesuai dengan filter
        $result = $this->db->get()->result_array();

        // var_dump($result);
        // exit;
        return $result;
    }


    public function calculate_stock_out_category($data, $selected_year) {
        $monthly_stock_out = [];
        
        // Array untuk menyimpan status stockout per bulan dan tahun
        $previous_month_stockout = [];
        
        foreach ($data as $row) {
            $month = $row['month'];
            $year = $row['year']; // Tahun data
    
            // Hanya proses data untuk tahun yang dipilih
            if ($year != $selected_year) {
                continue; // Lewatkan data jika tahun tidak sesuai
            }
    
            // Tentukan bulan-bulan yang akan dicek untuk 3 bulan sebelumnya
            $previous_months = [];
        
            // Tentukan bulan-bulan sebelumnya
            for ($i = 1; $i <= 3; $i++) {
                $prev_month = $month - $i;
        
                // Jika bulan sebelumnya kurang dari 1 (misalnya Januari - 1), kita perlu mengubah tahun
                if ($prev_month < 1) {
                    $prev_month += 12; // Bulan Desember, November, Oktober...
                    $prev_year = $year - 1; // Tahun sebelumnya
                } else {
                    $prev_year = $year; // Tahun yang sama jika bulan tidak kurang dari 1
                }
        
                // Simpan bulan dan tahun sebelumnya
                $previous_months[] = [
                    'month' => $prev_month,
                    'year' => $prev_year
                ];
            }
        
            // Menyimpan status stockout untuk bulan-bulan sebelumnya
            $statuses_previous_months = [];
        
            // Loop untuk mencari status stockout bulan-bulan sebelumnya
            foreach ($previous_months as $prev) {
                foreach ($data as $previous_row) {
                    if ($previous_row['month'] == $prev['month'] && $previous_row['year'] == $prev['year'] && $previous_row['puskesmas_id'] == $row['puskesmas_id']) {
                        $statuses_previous_months[$prev['month']] = $previous_row['status_stockout'];
                    }
                }
            }
        
            // Tentukan kategori berdasarkan status stockout
            if ($row['status_stockout'] == 1) {
                // Jika bulan sebelumnya ada yang memiliki status 0
                if (!isset($statuses_previous_months[10]) && !isset($statuses_previous_months[11]) && !isset($statuses_previous_months[12])) {
                    $category = '1 Month';
                } else {
                    // Jika ada lebih dari satu bulan berturut-turut dengan status 1
                    $count_consecutive_1 = 0;
                    foreach ($previous_months as $prev) {
                        if (isset($statuses_previous_months[$prev['month']]) && $statuses_previous_months[$prev['month']] == 1) {
                            $count_consecutive_1++;
                        }
                    }
        
                    // Tentukan kategori berdasarkan jumlah bulan berturut-turut
                    if ($count_consecutive_1 >= 3) {
                        $category = '> 3 Months';
                    } elseif ($count_consecutive_1 == 2) {
                        $category = '3 Months';
                    } elseif ($count_consecutive_1 == 1) {
                        $category = '2 Months';
                    }
                }
            } else {
                $category = 'No Stock Out';
            }
        
            // Menyimpan kategori untuk setiap bulan
            if (!isset($monthly_stock_out[$month])) {
                $monthly_stock_out[$month] = [
                    'stock_out_1' => 0,
                    'stock_out_2' => 0,
                    'stock_out_3' => 0,
                    'stock_out_4' => 0,
                    'stock_out_no' => 0
                ];
            }
        
            // Menambahkan jumlah puskesmas untuk kategori durasi stok kosong
            if ($category == '1 Month') {
                $monthly_stock_out[$month]['stock_out_1']++;
            } elseif ($category == '2 Months') {
                $monthly_stock_out[$month]['stock_out_2']++;
            } elseif ($category == '3 Months') {
                $monthly_stock_out[$month]['stock_out_3']++;
            } elseif ($category == '> 3 Months') {
                $monthly_stock_out[$month]['stock_out_4']++;
            } elseif ($category == 'No Stock Out') {
                $monthly_stock_out[$month]['stock_out_no']++;
            }
        
            // Menyimpan status stockout untuk bulan ini
            $previous_month_stockout[$month] = $row['status_stockout'];
        }
        
        // Format data untuk menyesuaikan dengan struktur yang diinginkan
        $result = [];
        foreach ($monthly_stock_out as $month => $categories) {
            $result[] = [
                'month' => (string)$month,  // Menjadikan bulan dalam format string
                'stock_out_1' => $categories['stock_out_1'],
                'stock_out_2' => $categories['stock_out_2'],
                'stock_out_3' => $categories['stock_out_3'],
                'stock_out_4' => $categories['stock_out_4'],
                'stock_out_no' => $categories['stock_out_no']
            ];
        }
    
        // var_dump($result);
        
        return $result;
    }

    public function get_total_dpt_stock_out($year) {
        // Ambil data stok kosong per bulan dan puskesmas untuk tahun yang dipilih
        $stock_out_data = $this->get_dpt_stock_out_by_month('all', $year);
    
        // Menghitung kategori durasi stok kosong per bulan
        $monthly_stock_out_categories = $this->calculate_stock_out_category($stock_out_data, $year);
    
        // Menghitung total puskesmas stockout
        $total_faskes_stockout = 0;
    
        // Menjumlahkan total faskes yang mengalami stockout berdasarkan kategori
        foreach ($monthly_stock_out_categories as $category) {
            // Menambah total faskes yang mengalami stockout di setiap kategori
            $total_faskes_stockout += $category['stock_out_1']; // 1 Month
            $total_faskes_stockout += $category['stock_out_2']; // 2 Months
            $total_faskes_stockout += $category['stock_out_3']; // 3 Months
            $total_faskes_stockout += $category['stock_out_4']; // > 3 Months
        }
    
        // Mengembalikan total faskes yang mengalami stockout
        return $total_faskes_stockout;
    }

    public function get_total_stockout_puskesmas($year) {
        $this->db->distinct(); // Pastikan hasilnya unik
        $this->db->select('puskesmas_id');
        $this->db->from('puskesmas_stock_out_details');
        $this->db->where('year', $year);
        $this->db->where('status_stockout', '1');
    
        $query = $this->db->get();
        return $query->num_rows(); // Hitung total puskesmas unik yang stockout
    }

    // ✅ Ambil ID dari 10 targeted provinces
    public function get_targeted_province_ids() {
        $query = $this->db->select('id')
                          ->from('provinces')
                          ->where('priority', 1) // ✅ Hanya provinces dengan priority = 1
                          ->limit(10) // ✅ Batasi ke 10 provinces
                          ->get();

        return array_column($query->result_array(), 'id'); // Return array ID targeted provinces
    }

    public function get_health_facilities_percentage($year) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil 10 targeted provinces
    
        // Ambil total puskesmas di 10 provinsi terpilih
        $this->db->select('COUNT(id) AS total_puskesmas');
        $this->db->from('puskesmas');
        if (!empty($province_ids)) {
            $this->db->where_in('province_id', $province_ids);
        }
        $total_puskesmas = $this->db->get()->row()->total_puskesmas ?? 0;
    
        // Ambil total puskesmas yang masuk kategori "Good" dalam supervisi
        $this->db->select('SUM(good_category_puskesmas) AS total_good_puskesmas', false);
        $this->db->from('supportive_supervision');
        $this->db->where('year', $year);
        if (!empty($province_ids)) {
            $this->db->where_in('province_id', $province_ids);
        }
        $total_good_puskesmas = $this->db->get()->row()->total_good_puskesmas ?? 0;
    
        // Hitung persentase
        $percentage = ($total_puskesmas > 0) 
            ? round(($total_good_puskesmas / $total_puskesmas) * 100, 2) 
            : 0;
    
        return $percentage;
    }
    
    public function get_private_facility_trained_specific($year) {
        $province_ids = [31, 33, 35]; // DKI Jakarta (31), Jawa Tengah (33), Jawa Timur (35)
    
        $this->db->select("SUM(trained_private_facilities) AS total_trained", false);
        $this->db->from('private_facility_training');
        $this->db->where('year', $year);
        $this->db->where_in('province_id', $province_ids); // Hanya untuk provinsi tertentu
    
        $query = $this->db->get();
        return $query->row()->total_trained ?? 0; // Jika null, return 0
    }

    public function get_district_funding_percentage($year) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil 10 targeted provinces
    
        // ✅ Hitung total distrik di 10 targeted provinces
        $this->db->select('COUNT(id) AS total_districts');
        $this->db->from('cities'); 
        if (!empty($province_ids)) {
            $this->db->where_in('province_id', $province_ids);
        }
    
        $total_districts = $this->db->get()->row()->total_districts ?? 0;
    
        // ✅ Hitung total distrik yang sudah melakukan pendanaan
        $this->db->select('SUM(funded_districts) AS total_funded_districts', false);
        $this->db->from('district_funding');
        $this->db->where('year', $year);
        if (!empty($province_ids)) {
            $this->db->where_in('province_id', $province_ids);
        }
    
        $total_funded_districts = $this->db->get()->row()->total_funded_districts ?? 0;
    
        // ✅ Hitung persentase
        $percentage_funded = ($total_districts > 0) 
            ? round(($total_funded_districts / $total_districts) * 100, 2) 
            : 0;
    
        return $percentage_funded;
    }

    public function get_district_policy_percentage($year) {
        $targeted_provinces = $this->get_targeted_province_ids(); // Ambil 10 targeted provinces
    
        if (empty($targeted_provinces)) {
            return '0%';
        }
    
        // 🔹 Ambil total distrik yang memiliki kebijakan
        $this->db->select('SUM(dp.policy_districts) AS total_policy_districts', false);
        $this->db->from('district_policy dp');
        $this->db->where_in('dp.province_id', $targeted_provinces);
        $this->db->where('dp.year', $year);
    
        $total_policy_districts = $this->db->get()->row()->total_policy_districts ?? 0;
    
        // 🔹 Ambil total distrik di targeted provinces
        $this->db->select('COUNT(id) AS total_districts');
        $this->db->from('cities');
        $this->db->where_in('province_id', $targeted_provinces);
    
        $total_districts = $this->db->get()->row()->total_districts ?? 0;
    
        // 🔹 Hitung persentase distrik yang memiliki kebijakan
        $percentage_policy = ($total_districts > 0) 
            ? round(($total_policy_districts / $total_districts) * 100, 2) . '%' 
            : '0%';
    
        return $percentage_policy;
    }
    
    
    
    
    
    
}
