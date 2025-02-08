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

    public function get_long_term_outcomes() {
        // Ambil daftar 10 provinsi prioritas
        $priority_provinces = $this->db->select('id')
                                       ->where('priority', 1)
                                       ->get('provinces')
                                       ->result_array();
        $province_ids = array_column($priority_provinces, 'id');
    
        // Ambil target baseline dari tabel target_baseline
        $baseline = $this->db->get_where('target_baseline', ['id' => 1])->row_array();
        $target_dpt1 = $baseline['dpt1'];
        $target_dpt3 = $baseline['dpt3'];
        $target_mr1 = $baseline['mr1'];
    
        // DPT3 Coverage
        $this->db->select("
            (SUM(CASE WHEN year = 2024 THEN dpt_hb_hib_3 ELSE 0 END) / $target_dpt3) * 100 AS actual_y1,
            (SUM(CASE WHEN year IN (2024, 2025) THEN dpt_hb_hib_3 ELSE 0 END) / $target_dpt3) * 100 AS actual_y2
        ", FALSE);
        $this->db->where_in('province_id', $province_ids);
        $dpt3 = $this->db->get('immunization_data')->row_array();
    
        // MR1 Coverage
        $this->db->select("
            (SUM(CASE WHEN year = 2024 THEN mr_1 ELSE 0 END) / $target_mr1) * 100 AS actual_y1,
            (SUM(CASE WHEN year IN (2024, 2025) THEN mr_1 ELSE 0 END) / $target_mr1) * 100 AS actual_y2
        ", FALSE);
        $this->db->where_in('province_id', $province_ids);
        $mr1 = $this->db->get('immunization_data')->row_array();
    
        // Reduction in Zero Dose (DPT1)
        $this->db->select("
            (SUM(CASE WHEN year = 2024 THEN dpt_hb_hib_1 ELSE 0 END) / $target_dpt1) * 100 AS actual_y1,
            (SUM(CASE WHEN year IN (2024, 2025) THEN dpt_hb_hib_1 ELSE 0 END) / $target_dpt1) * 100 AS actual_y2
        ", FALSE);
        $this->db->where_in('province_id', $province_ids);
        $reduction_zd = $this->db->get('immunization_data')->row_array();
    
        return [
            'dpt3' => $dpt3,
            'mr1' => $mr1,
            'reduction_zd' => $reduction_zd
        ];
    }
    
}
