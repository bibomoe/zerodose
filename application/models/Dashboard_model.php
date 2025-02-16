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
        $this->db->select('id, objective_name');
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
    
    //     // Ambil target baseline dari tabel target_baseline
    //     $baseline = $this->db->get_where('target_baseline', ['id' => 1])->row_array();
    //     $target_dpt1 = $baseline['dpt1'];
    //     $target_dpt3 = $baseline['dpt3'];
    //     $target_mr1 = $baseline['mr1'];
    //     // var_dump($target_dpt1);
    //     // exit;
    
    //     // DPT3 Coverage
    //     $this->db->select("
    //         (SUM(CASE WHEN year = 2024 THEN dpt_hb_hib_3 ELSE 0 END) / $target_dpt3) * 100 AS actual_y1,
    //         (SUM(CASE WHEN year IN (2024, 2025) THEN dpt_hb_hib_3 ELSE 0 END) / $target_dpt3) * 100 AS actual_y2
    //     ", FALSE);
    //     $this->db->where_in('province_id', $province_ids);
    //     $dpt3 = $this->db->get('immunization_data')->row_array();
    
    //     // MR1 Coverage
    //     $this->db->select("
    //         (SUM(CASE WHEN year = 2024 THEN mr_1 ELSE 0 END) / $target_mr1) * 100 AS actual_y1,
    //         (SUM(CASE WHEN year IN (2024, 2025) THEN mr_1 ELSE 0 END) / $target_mr1) * 100 AS actual_y2
    //     ", FALSE);
    //     $this->db->where_in('province_id', $province_ids);
    //     $mr1 = $this->db->get('immunization_data')->row_array();
    
    //     // Reduction in Zero Dose (DPT1)
    //     $this->db->select("
    //         SUM(CASE WHEN year = 2024 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y1,
    //         SUM(CASE WHEN year IN (2024, 2025) THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y2
    //     ", FALSE);
    //     $this->db->where_in('province_id', $province_ids);
    //     $reduction_zd = $this->db->get('immunization_data')->row_array();

    //     // Menghitung reduction zero dose berdasarkan rumus
    //     $reduction_y1 = $target_dpt1 - $reduction_zd['actual_y1'];
    //     $reduction_y2 = $target_dpt1 - $reduction_zd['actual_y2'];
        

    //     // Menghitung persentase pengurangan zero dose untuk tahun 2024 (Y1) dan (Y2)
    //     $percent_reduction_y1 = ($target_dpt1 - $reduction_y1) / $target_dpt1 * 100;
    //     $percent_reduction_y2 = ($target_dpt1 - $reduction_y2) / $target_dpt1 * 100;

    //     // var_dump($target_dpt1 - $reduction_y1);
    //     // exit;

    //     return [
    //         'dpt3' => $dpt3,
    //         'mr1' => $mr1,
    //         'reduction_zd' => [
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
    
        // Ambil baseline dari tabel target_baseline (Baseline ZD 2023)
        $baseline = $this->db->get_where('target_baseline', ['id' => 1])->row_array();
        $baseline_zd_2023 = $baseline['zd'];
    
        // Ambil target dari tabel target_coverage untuk DPT3 & MR1 per tahun
        $this->db->select("
            SUM(CASE WHEN year = 2024 AND vaccine_type = 'DPT-3' THEN target_population ELSE 0 END) AS baseline_dpt3_y1,
            SUM(CASE WHEN year = 2025 AND vaccine_type = 'DPT-3' THEN target_population ELSE 0 END) AS baseline_dpt3_y2,
            SUM(CASE WHEN year = 2024 AND vaccine_type = 'MR-1' THEN target_population ELSE 0 END) AS baseline_mr1_y1,
            SUM(CASE WHEN year = 2025 AND vaccine_type = 'MR-1' THEN target_population ELSE 0 END) AS baseline_mr1_y2
        ", FALSE);
        $coverage = $this->db->get('target_coverage')->row_array();
    
        // DPT3 Coverage
        $this->db->select("
            (SUM(CASE WHEN year = 2024 THEN dpt_hb_hib_3 ELSE 0 END) / NULLIF({$coverage['baseline_dpt3_y1']}, 0)) * 100 AS actual_y1,
            (SUM(CASE WHEN year = 2025 THEN dpt_hb_hib_3 ELSE 0 END) / NULLIF({$coverage['baseline_dpt3_y2']}, 0)) * 100 AS actual_y2
        ", FALSE);
        // $this->db->where_in('province_id', $province_ids);
        $dpt3 = $this->db->get('immunization_data')->row_array();
    
        // MR1 Coverage
        $this->db->select("
            (SUM(CASE WHEN year = 2024 THEN mr_1 ELSE 0 END) / NULLIF({$coverage['baseline_mr1_y1']}, 0)) * 100 AS actual_y1,
            (SUM(CASE WHEN year = 2025 THEN mr_1 ELSE 0 END) / NULLIF({$coverage['baseline_mr1_y2']}, 0)) * 100 AS actual_y2
        ", FALSE);
        // $this->db->where_in('province_id', $province_ids);
        $mr1 = $this->db->get('immunization_data')->row_array();
    
        // // Reduction in Zero Dose (ZD) berdasarkan target baseline 2023
        // $target_reduction_y1 = 0.25 * $baseline_zd_2023; // 25% dari baseline ZD 2023
        // $target_reduction_y2 = 0.10 * $baseline_zd_2023; // 10% dari baseline ZD 2023
    
        // // Hitung realisasi reduction ZD
        // $this->db->select("
        //     SUM(CASE WHEN year = 2024 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y1,
        //     SUM(CASE WHEN year = 2025 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y2
        // ", FALSE);
        // // $this->db->where_in('province_id', $province_ids);
        // $reduction_zd = $this->db->get('immunization_data')->row_array();
    
        // // Menghitung persentase realisasi reduction ZD
        // $percent_reduction_y1 = ($baseline_zd_2023 - $reduction_zd['actual_y1']) / $baseline_zd_2023 * 100;
        // $percent_reduction_y2 = ($baseline_zd_2023 - $reduction_zd['actual_y2']) / $baseline_zd_2023 * 100;
        
        // Reduction in Zero Dose (DPT1) berdasarkan target_coverage
        $this->db->select("
        SUM(CASE WHEN year = 2024 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS target_dpt1_y1,
        SUM(CASE WHEN year = 2025 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS target_dpt1_y2
        ", FALSE);
        $target_dpt1 = $this->db->get('target_coverage')->row_array();

        // Ambil realisasi imunisasi DPT-1 dari immunization_data
        $this->db->select("
        SUM(CASE WHEN year = 2024 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y1,
        SUM(CASE WHEN year = 2025 THEN dpt_hb_hib_1 ELSE 0 END) AS actual_y2
        ", FALSE);
        $this->db->where_in('province_id', $province_ids);
        $reduction_zd = $this->db->get('immunization_data')->row_array();

        // Hitung jumlah anak yang belum menerima DPT-1 (Zero Dose)
        $zd_remaining_y1 = max($target_dpt1['target_dpt1_y1'] - $reduction_zd['actual_y1'], 0);
        $zd_remaining_y2 = max($target_dpt1['target_dpt1_y2'] - $reduction_zd['actual_y2'], 0);

        // Menghitung persentase pengurangan zero dose
        $percent_reduction_y1 = ($baseline_zd_2023 - $zd_remaining_y1) / $baseline_zd_2023 * 100;
        $percent_reduction_y2 = ($baseline_zd_2023 - $zd_remaining_y2) / $baseline_zd_2023 * 100;

        // Menghitung persentase pengurangan zero dose, jika negatif maka set ke 0
        // $percent_reduction_y1 = max(($baseline_zd_2023 - $zd_remaining_y1) / $baseline_zd_2023 * 100, 0);
        // $percent_reduction_y2 = max(($baseline_zd_2023 - $zd_remaining_y2) / $baseline_zd_2023 * 100, 0);

        return [
            'dpt3' => [
                'baseline' => 4_199_289, // Sesuai dengan nilai tetap yang ada di view
                'baseline_y1' => $coverage['baseline_dpt3_y1'],
                'baseline_y2' => $coverage['baseline_dpt3_y2'],
                'actual_y1' => $dpt3['actual_y1'],
                'actual_y2' => $dpt3['actual_y2']
            ],
            'mr1' => [
                'baseline' => 4_244_731, // Sesuai dengan nilai tetap yang ada di view
                'baseline_y1' => $coverage['baseline_mr1_y1'],
                'baseline_y2' => $coverage['baseline_mr1_y2'],
                'actual_y1' => $mr1['actual_y1'],
                'actual_y2' => $mr1['actual_y2']
            ],
            'reduction_zd' => [
                // 'baseline' => "25% of {$baseline_zd_2023} (per Dec 2022)",
                'baseline' => "25% of {$baseline_zd_2023}",
                // 'target_y1' => $target_reduction_y1,
                // 'target_y2' => $target_reduction_y2,
                'actual_y1' => $percent_reduction_y1,
                'actual_y2' => $percent_reduction_y2
            ]
        ];
    }

    public function get_dpt1_coverage_percentage($year) {
        $this->load->model('Dpt1_model'); // Pastikan model Dpt1_model diload
    
        $total_coverage = $this->Dpt1_model->get_total_dpt1_coverage($year);
        $total_target = $this->Dpt1_model->get_total_dpt1_target($year);
    
        // Hitung persentase cakupan DPT1
        return ($total_target > 0) ? round(($total_coverage / $total_target) * 100, 2) : 0;
    }
    
    public function get_districts_under_5_percentage($year) {
        $this->load->model('Dpt1_model'); // Pastikan model Dpt1_model diload
    
        $total_dropout_rate = array_sum($this->Dpt1_model->get_districts_under_5_percent($year));
        $total_regencies = $this->Dpt1_model->get_total_regencies_cities();
    
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

    public function get_total_dpt_stock_out($year) {
        $this->db->select('
            SUM(stock_out_1_month) + 
            SUM(stock_out_2_months) + 
            SUM(stock_out_3_months) + 
            SUM(stock_out_more_than_3_months) AS total_stock_out', false);
        $this->db->from('stock_out_data');
        $this->db->where('vaccine_type', 'DPT'); // Hanya untuk DPT
        $this->db->where('year', $year);
    
        $query = $this->db->get();
        return $query->row()->total_stock_out ?? 0;
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
    
    
    
    
}
