<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    public function get_transactions($partner_id, $year, $month) {
        $this->db->select('t.*, a.activity_code, a.description');
        $this->db->from('transactions t');
        $this->db->join('activities a', 't.activity_id = a.id');
        $this->db->where('t.partner_id', $partner_id);
        $this->db->where('t.year', $year);
        $this->db->where('t.month', $month);
        $query = $this->db->get();

        return $query->result();
    }

    public function check_transaction_exists($partner_id, $year, $month, $activity_id) {
        $this->db->where('partner_id', $partner_id);
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->where('activity_id', $activity_id);
        $query = $this->db->get('transactions');
        return $query->row(); // Mengembalikan satu baris data jika ada, atau null jika tidak
    }
    
    public function update_transaction($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('transactions', $data);
    }
    

    public function insert_transaction($data) {
        $this->db->insert('transactions', $data);
    }
    
    // public function get_budget_absorption_by_year($year) {
    //     return $this->db->select('MONTH, SUM(total_budget) AS total_budget')
    //                     ->where('year', $year)
    //                     ->group_by('MONTH')
    //                     ->order_by('MONTH', 'ASC')
    //                     ->get('transactions') // Ubah 'transaction' menjadi 'transactions'
    //                     ->result_array();
    // }
    
    // public function get_budget_absorption_by_year_and_partner($year, $partner_id) {
    //     return $this->db->select('MONTH, SUM(total_budget) AS total_budget')
    //                     ->where('year', $year)
    //                     ->where('partner_id', $partner_id)
    //                     ->group_by('MONTH')
    //                     ->order_by('MONTH', 'ASC')
    //                     ->get('transactions') // Ubah 'transaction' menjadi 'transactions'
    //                     ->result_array();
    // }

    public function get_cumulative_budget_absorption_by_year($year, $partner_id = null) {
        $this->db->select('MONTH, SUM(total_budget) AS total_budget')
                 ->where('year', $year);
    
        if ($partner_id) {
            $this->db->where('partner_id', $partner_id);
        }
    
        $this->db->group_by('MONTH')
                 ->order_by('MONTH', 'ASC');
    
        $data = $this->db->get('transactions')->result_array();
    
        // Menghitung kumulatif dan menerapkan carry forward
        $cumulative = [];
        $total = 0;
        $months = range(1, 12); // Semua bulan (1 sampai 12)
    
        foreach ($months as $month) {
            $found = false;
    
            // Cari data untuk bulan ini
            foreach ($data as $row) {
                if ($row['MONTH'] == $month) {
                    $total += $row['total_budget']; // Tambahkan nilai ke total kumulatif
                    $cumulative[] = [
                        'MONTH' => $month,
                        'total_budget' => $total
                    ];
                    $found = true;
                    break;
                }
            }
    
            // Jika tidak ada data untuk bulan ini, gunakan nilai carry forward
            if (!$found) {
                $cumulative[] = [
                    'MONTH' => $month,
                    'total_budget' => $total // Nilai tetap sama seperti bulan sebelumnya
                ];
            }
        }
    
        return $cumulative;
    }
    
    public function get_cumulative_budget_absorption_with_percentage($year, $partner_id = null, $total_target_budget = null) {
        // Ambil data transaksi berdasarkan tahun dan, jika ada, partner_id
        $this->db->select('MONTH, SUM(total_budget) AS total_budget')
                 ->where('year', $year);
    
        if (!is_null($partner_id)) {
            $this->db->where('partner_id', $partner_id);
        }
    
        $this->db->group_by('MONTH')
                 ->order_by('MONTH', 'ASC');
    
        $data = $this->db->get('transactions')->result_array();
    
        // Jika total_target_budget kosong, ambil dari database
        if (is_null($total_target_budget)) {
            $this->db->select('SUM(target_budget_' . $year . ') AS total_target_budget');
            if (!is_null($partner_id)) {
                $this->db->where('partner_id', $partner_id);
            }
            $target_data = $this->db->get('partners_activities')->row_array();
            $total_target_budget = $target_data['total_target_budget'] ?? 0;
        }
    
        // Menghitung kumulatif dan persentase
        $cumulative = [];
        $total = 0;
        $months = range(1, 12); // Semua bulan (1 sampai 12)
    
        foreach ($months as $month) {
            $found = false;
    
            foreach ($data as $row) {
                if ($row['MONTH'] == $month) {
                    $total += $row['total_budget']; // Tambahkan nilai kumulatif
                    $percentage = $total_target_budget > 0 ? ($total / $total_target_budget) * 100 : 0; // Hitung persentase
                    $cumulative[] = [
                        'MONTH' => $month,
                        'total_budget' => $total,
                        'percentage' => $percentage
                    ];
                    $found = true;
                    break;
                }
            }
    
            // Jika bulan tidak ada di data transaksi, tambahkan nilai nol
            if (!$found) {
                $percentage = $total_target_budget > 0 ? ($total / $total_target_budget) * 100 : 0;
                $cumulative[] = [
                    'MONTH' => $month,
                    'total_budget' => $total,
                    'percentage' => $percentage
                ];
            }
        }
    
        return $cumulative;
    }

    public function get_budget_by_objective_and_year($year, $partner_id = null) {
        $this->db->select('a.objective_id, SUM(t.total_budget) as total_budget');
        $this->db->from('transactions t');
        $this->db->join('activities a', 't.activity_id = a.id');
        $this->db->where('t.year', $year);
    
        if (!is_null($partner_id) && $partner_id !== 'all') {
            $this->db->where('t.partner_id', $partner_id);
        }
    
        $this->db->group_by('a.objective_id');
        $result = $this->db->get()->result_array();
    
        // Siapkan array default berdasarkan jumlah objectives
        $objectives = $this->CountryObjective_model->get_all_objectives();
        $budget_data = array_fill(0, count($objectives), 0);
    
        foreach ($result as $row) {
            $index = $row['objective_id'] - 1;
            $budget_data[$index] = (float) $row['total_budget'];
        }
    
        return $budget_data;
    }
    
}

?>