<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Policy_model extends CI_Model {

    // ✅ Ambil data pendanaan distrik hanya untuk 10 targeted provinces
    public function get_district_funding($year) {
        $targeted_provinces = $this->get_targeted_province_ids(); // Ambil ID targeted provinces

        if (empty($targeted_provinces)) {
            return []; // Jika tidak ada data, return array kosong
        }

        $this->db->select("
            p.name_id AS province_name,
            (SELECT COUNT(id) FROM cities WHERE province_id = df.province_id) AS total_districts,
            SUM(df.funded_districts) AS funded_districts
        ");
        $this->db->from('district_funding df');
        $this->db->join('provinces p', 'df.province_id = p.id', 'left');

        // ✅ Filter hanya untuk 10 targeted provinces
        $this->db->where_in('df.province_id', $targeted_provinces);
        
        // ✅ Filter berdasarkan tahun
        $this->db->where('df.year', $year);

        $this->db->group_by('df.province_id');
        $this->db->order_by('p.name_id');

        $query = $this->db->get()->result_array();

        // 🔄 Hitung persentase setelah mendapatkan hasil query
        foreach ($query as &$row) {
            $total_districts = (int) $row['total_districts'];
            $funded_districts = (int) $row['funded_districts'];
            $row['percentage_allocated'] = ($total_districts > 0) 
                ? round(($funded_districts / $total_districts) * 100, 2) . '%' 
                : '0%';
        }

        return $query;
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

    public function get_district_funding_summary($year) {
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
    
        return [
            'total_districts' => $total_districts,
            'total_funded_districts' => $total_funded_districts,
            'percentage_funded' => $percentage_funded
        ];
    }

    // ✅ Ambil data kebijakan distrik untuk 10 provinsi yang ditargetkan
    public function get_district_policies($year) {
        $targeted_provinces = $this->get_targeted_province_ids(); // Ambil ID provinsi yang ditargetkan

        if (empty($targeted_provinces)) {
            return []; // Jika tidak ada provinsi yang ditargetkan, return array kosong
        }

        $this->db->select("
            p.name_id AS province_name,
            (SELECT COUNT(id) FROM cities WHERE province_id = dp.province_id) AS total_districts,
            SUM(dp.policy_districts) AS policy_districts
        ");
        $this->db->from('district_policy dp');
        $this->db->join('provinces p', 'dp.province_id = p.id', 'left');

        // ✅ Filter hanya untuk 10 provinsi yang ditargetkan
        $this->db->where_in('dp.province_id', $targeted_provinces);

        // ✅ Filter berdasarkan tahun
        $this->db->where('dp.year', $year);

        $this->db->group_by('dp.province_id');
        $this->db->order_by('p.name_id');

        $query = $this->db->get()->result_array();

        // 🔄 Hitung persentase setelah mendapatkan hasil query
        foreach ($query as &$row) {
            $total_districts = (int) $row['total_districts'];
            $policy_districts = (int) $row['policy_districts'];
            $row['percentage'] = ($total_districts > 0) 
                ? round(($policy_districts / $total_districts) * 100, 2) . '%' 
                : '0%';
        }

        return $query;
    }

    // ✅ Ambil total distrik yang telah menerapkan kebijakan imunisasi di 10 provinsi yang ditargetkan
    public function get_policy_summary($year) {
        $targeted_provinces = $this->get_targeted_province_ids(); // Ambil ID provinsi yang ditargetkan

        if (empty($targeted_provinces)) {
            return [
                'total_districts' => 0,
                'policy_districts' => 0,
                'percentage_policy' => '0%'
            ];
        }

        // 🔹 Ambil total distrik yang telah memiliki kebijakan
        $this->db->select('SUM(dp.policy_districts) AS total_policy_districts', false);
        $this->db->from('district_policy dp');
        $this->db->where_in('dp.province_id', $targeted_provinces);
        $this->db->where('dp.year', $year);

        $total_policy_districts = $this->db->get()->row()->total_policy_districts ?? 0;

        // 🔹 Ambil total distrik di provinsi yang ditargetkan
        $this->db->select('COUNT(id) AS total_districts');
        $this->db->from('cities');
        $this->db->where_in('province_id', $targeted_provinces);

        $total_districts = $this->db->get()->row()->total_districts ?? 0;

        // 🔹 Hitung persentase distrik yang memiliki kebijakan
        $percentage_policy = ($total_districts > 0) 
            ? round(($total_policy_districts / $total_districts) * 100, 2) . '%' 
            : '0%';

        return [
            'total_districts' => $total_districts,
            'policy_districts' => $total_policy_districts,
            'percentage_policy' => $percentage_policy
        ];
    }
}
