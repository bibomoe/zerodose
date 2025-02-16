<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class District_model extends CI_Model {

    // ✅ Ambil data supportive supervision hanya untuk 10 targeted provinces
    public function get_supportive_supervision_targeted_table($year) {
        $targeted_provinces = $this->get_targeted_province_ids(); // Ambil ID targeted provinces

        if (empty($targeted_provinces)) {
            return []; // Jika tidak ada data, return array kosong
        }

        $this->db->select("
            p.name_id AS province_name,
            c.name_id AS city_name,
            (SELECT COUNT(id) FROM puskesmas WHERE city_id = ss.city_id) AS total_puskesmas, 
            SUM(ss.good_category_puskesmas) AS good_category_puskesmas
        ");
        $this->db->from('supportive_supervision ss');
        $this->db->join('cities c', 'ss.city_id = c.id', 'left');
        $this->db->join('provinces p', 'ss.province_id = p.id', 'left');

        // ✅ Filter hanya untuk 10 targeted provinces
        $this->db->where_in('ss.province_id', $targeted_provinces);
        
        // ✅ Filter berdasarkan tahun
        $this->db->where('ss.year', $year);

        $this->db->group_by('ss.city_id');
        $this->db->order_by('p.name_id, c.name_id');

        $query = $this->db->get()->result_array();

        // 🔄 Hitung persentase setelah mendapatkan hasil query
        foreach ($query as &$row) {
            $total_puskesmas = (int) $row['total_puskesmas'];
            $good_puskesmas = (int) $row['good_category_puskesmas'];
            $row['percentage_good_category'] = ($total_puskesmas > 0) 
                ? round(($good_puskesmas / $total_puskesmas) * 100, 2) 
                : 0;
        }

        // var_dump($query);
        // exit;

        return $query;
    }

    // ✅ Fungsi untuk card (Mengambil total data untuk semua 10 targeted provinces)
    public function get_supportive_supervision_targeted_summary($year) {
        $province_ids = $this->get_targeted_province_ids();

        $this->db->select('SUM(ss.good_category_puskesmas) AS total_good_puskesmas', false);
        $this->db->from('supportive_supervision ss');
        $this->db->where('ss.year', $year);
        
        if (!empty($province_ids)) {
            $this->db->where_in('ss.province_id', $province_ids);
        }

        $total_good_puskesmas = $this->db->get()->row()->total_good_puskesmas ?? 0;

        // Hitung total seluruh puskesmas di targeted provinces
        $this->db->select('COUNT(id) AS total_puskesmas');
        $this->db->from('puskesmas');
        if (!empty($province_ids)) {
            $this->db->where_in('province_id', $province_ids);
        }

        $total_puskesmas = $this->db->get()->row()->total_puskesmas ?? 0;

        // Hitung persentase
        $percentage_good = ($total_puskesmas > 0) 
            ? round(($total_good_puskesmas / $total_puskesmas) * 100, 2) 
            : 0;

        return [
            'total_puskesmas' => $total_puskesmas,
            'total_good_puskesmas' => $total_good_puskesmas,
            'percentage_good' => $percentage_good
        ];
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

    public function get_private_facility_training($year) {
        $this->db->select("
            p.name_id AS province_name,
            SUM(pft.total_private_facilities) AS total_private_facilities,
            SUM(pft.trained_private_facilities) AS trained_private_facilities
        ");
        $this->db->from('private_facility_training pft');
        $this->db->join('provinces p', 'pft.province_id = p.id', 'left');
        
        // Filter berdasarkan tahun
        $this->db->where('pft.year', $year);
    
        $this->db->group_by('pft.province_id');
        $this->db->order_by('p.name_id');
    
        return $this->db->get()->result_array();
    }

    public function get_private_facility_training_summary($year) {
        $this->db->select("SUM(trained_private_facilities) AS total_trained", false);
        $this->db->from('private_facility_training');
        $this->db->where('year', $year);
    
        $query = $this->db->get();
        return $query->row()->total_trained ?? 0; // Jika null, return 0
    }
    
    
}
