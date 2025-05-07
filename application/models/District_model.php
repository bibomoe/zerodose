<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class District_model extends CI_Model {

    // ✅ Ambil data supportive supervision hanya untuk 10 targeted provinces
    public function get_supportive_supervision_targeted_table($province_id = 'all', $year = 2025) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil ID targeted provinces

        // if (empty($targeted_provinces)) {
        //     return []; // Jika tidak ada data, return array kosong
        // }

        $this->db->select("
            p.name_id AS province_name,
            c.name_id AS city_name,
            (SELECT COUNT(id) FROM puskesmas 
                    WHERE " . ($province_id === 'all' || $province_id === 'targeted' ? "province_id = ss.province_id" : "city_id = ss.city_id") . " 
                ) AS total_puskesmas,
            SUM(ss.total_ss) AS total_ss, 
            SUM(ss.good_category_puskesmas) AS good_category_puskesmas
        ");
        $this->db->from('supportive_supervision ss');
        $this->db->join('cities c', 'ss.city_id = c.id', 'left');
        $this->db->join('provinces p', 'ss.province_id = p.id', 'left');

        // ✅ Filter hanya untuk 10 targeted provinces
        // $this->db->where_in('ss.province_id', $targeted_provinces);
        
        // ✅ Filter berdasarkan tahun
        $this->db->where('ss.year', $year);

        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('ss.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('ss.province_id', $province_id);
        }

        // $this->db->group_by('ss.city_id');
        // Grouping berdasarkan province atau city
        $this->db->group_by(($province_id !== 'all' && $province_id !== 'targeted') ? 'ss.city_id' : 'ss.province_id');
        // $this->db->order_by('p.name_id, c.name_id');

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

    // ✅ Ambil data supportive supervision hanya untuk peta
    public function get_supportive_supervision($province_id = 'all', $year = 2025) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil ID targeted provinces

        // if (empty($targeted_provinces)) {
        //     return []; // Jika tidak ada data, return array kosong
        // }

        $this->db->select("
            ss.province_id AS province_id,
            ss.city_id AS city_id,
            SUM(ss.total_ss) AS total_ss,
            (SELECT COUNT(id) FROM puskesmas WHERE city_id = ss.city_id) AS total_puskesmas, 
            SUM(ss.good_category_puskesmas) AS good_category_puskesmas
        ");
        $this->db->from('supportive_supervision ss');
        $this->db->join('cities c', 'ss.city_id = c.id', 'left');
        $this->db->join('provinces p', 'ss.province_id = p.id', 'left');

        // ✅ Filter hanya untuk 10 targeted provinces
        // $this->db->where_in('ss.province_id', $targeted_provinces);
        
        // ✅ Filter berdasarkan tahun
        $this->db->where('ss.year', $year);

        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('ss.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('ss.province_id', $province_id);
        }

        // $this->db->group_by('ss.city_id');
        // Grouping berdasarkan province atau city
        $this->db->group_by(($province_id !== 'all' && $province_id !== 'targeted') ? 'ss.city_id' : 'ss.province_id');
        // $this->db->order_by('p.name_id, c.name_id');

        // $query = $this->db->get()->result_array();
        $query = $this->db->get();
        $result = [];

        // 🔄 Hitung persentase setelah mendapatkan hasil query
        foreach ($query->result_array() as &$row) {
            $total_puskesmas = (int) $row['total_puskesmas'];
            $good_puskesmas = (int) $row['good_category_puskesmas'];
            $total_ss = (int) $row['total_ss'];
            $percentage_good_category = ($total_puskesmas > 0) 
                ? round(($good_puskesmas / $total_puskesmas) * 100, 2) 
                : 0;

            $result_key = ($province_id !== 'all' && $province_id !== 'targeted') ? $row['city_id'] : $row['province_id'];
            $result[$result_key] = array_merge($row, [
                'total_puskesmas' => $total_puskesmas,
                'total_ss' => $total_ss,
                'good_puskesmas' => $good_puskesmas,
                'percentage_good_category' => $percentage_good_category
            ]);
        }

        // var_dump($result);
        // exit;

        return $result;
    }

    // ✅ Fungsi untuk card (Mengambil total data untuk semua 10 targeted provinces)
    public function get_supportive_supervision_targeted_summary($province_id, $year) {
        $province_ids = $this->get_targeted_province_ids();

        $this->db->select('SUM(ss.good_category_puskesmas) AS total_good_puskesmas, SUM(ss.total_ss)', false);
        $this->db->from('supportive_supervision ss');
        $this->db->where('ss.year', $year);
        
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('ss.province_id', $province_ids);
            } else {
                return ['total_puskesmas' => 0, 'total_good_puskesmas' => 0, 'percentage_good' => 0, 'total_ss' => 0];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('ss.province_id', $province_id);
        }

        $total_good_puskesmas = $this->db->get()->row()->total_good_puskesmas ?? 0;
        $total_ss = $this->db->get()->row()->total_ss ?? 0;

        // Hitung total seluruh puskesmas di targeted provinces
        $this->db->select('COUNT(id) AS total_puskesmas');
        $this->db->from('puskesmas');
        // if (!empty($province_ids)) {
        //     $this->db->where_in('province_id', $province_ids);
        // }

        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return ['total_puskesmas' => 0, 'total_good_puskesmas' => 0, 'percentage_good' => 0, 'total_ss' => 0];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        $total_puskesmas = $this->db->get()->row()->total_puskesmas ?? 0;

        // Hitung persentase
        $percentage_good = ($total_puskesmas > 0) 
            ? round(($total_good_puskesmas / $total_puskesmas) * 100, 2) 
            : 0;

        return [
            'total_puskesmas' => $total_puskesmas,
            'total_good_puskesmas' => $total_good_puskesmas,
            'percentage_good' => $percentage_good,
            'total_ss' => $total_ss
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
    
    // Input function

    // ✅ Simpan data supportive supervision ke database
    public function save_supportive_supervision($data) {
        // Cek apakah data untuk province_id, city_id, year, dan month sudah ada
        $this->db->where('province_id', $data['province_id']);
        $this->db->where('city_id', $data['city_id']);
        $this->db->where('year', $data['year']);
        $this->db->where('month', $data['month']);

        $query = $this->db->get('supportive_supervision');

        if ($query->num_rows() > 0) {
            // Data sudah ada, lakukan update
            $this->db->where('province_id', $data['province_id']);
            $this->db->where('city_id', $data['city_id']);
            $this->db->where('year', $data['year']);
            $this->db->where('month', $data['month']);

            $this->db->update('supportive_supervision', $data);
            return $this->db->affected_rows(); // Mengembalikan jumlah baris yang diperbarui
        } else {
            // Data belum ada, lakukan insert
            $this->db->insert('supportive_supervision', $data);
            return $this->db->insert_id(); // Mengembalikan ID dari data yang baru disimpan
        }
    }

    // ✅ Ambil data supportive supervision berdasarkan filter
    public function get_supportive_supervision_data($province_id = null, $city_id = null, $year = null, $month = null) {
        $this->db->select('ss.*, 
                          provinces.name_id AS province_name, 
                          cities.name_id AS city_name');
        $this->db->from('supportive_supervision ss');
        $this->db->join('provinces', 'provinces.id = ss.province_id', 'left');
        $this->db->join('cities', 'cities.id = ss.city_id', 'left');

        if (!empty($province_id)) {
            $this->db->where('ss.province_id', $province_id);
        }
        if (!empty($city_id)) {
            $this->db->where('ss.city_id', $city_id);
        }
        if (!empty($year)) {
            $this->db->where('ss.year', $year);
        }
        if (!empty($month)) {
            $this->db->where('ss.month', $month);
        }

        return $this->db->get()->result();
    }

    // ✅ Hapus data supportive supervision
    public function delete_supportive_supervision($id) {
        $this->db->where('id', $id)->delete('supportive_supervision');
        return $this->db->affected_rows();
    }

    // Simpan data private facility training
    public function save_private_facility_training($data) {
        // Cek apakah data untuk province_id, year, month sudah ada
        $this->db->where('province_id', $data['province_id']);
        $this->db->where('year', $data['year']);
        $this->db->where('month', $data['month']);
        
        $query = $this->db->get('private_facility_training');
    
        if ($query->num_rows() > 0) {
            // Data sudah ada, lakukan update
            $this->db->where('province_id', $data['province_id']);
            $this->db->where('year', $data['year']);
            $this->db->where('month', $data['month']);
    
            $this->db->update('private_facility_training', $data);
            return $this->db->affected_rows(); // Mengembalikan jumlah baris yang diperbarui
        } else {
            // Data belum ada, lakukan insert
            $this->db->insert('private_facility_training', $data);
            return $this->db->insert_id(); // Mengembalikan ID dari data yang baru disimpan
        }
    }

    // Ambil data private facility training berdasarkan filter
    public function get_private_facility_training_data($province_id, $year, $month) {
        $this->db->select('private_facility_training.*, provinces.name_id AS province_name');
        $this->db->from('private_facility_training');
        $this->db->join('provinces', 'provinces.id = private_facility_training.province_id', 'left');

        if (!empty($province_id)) {
            $this->db->where('private_facility_training.province_id', $province_id);
        }
        if (!empty($year)) {
            $this->db->where('private_facility_training.year', $year);
        }
        if (!empty($month)) {
            $this->db->where('private_facility_training.month', $month);
        }

        return $this->db->get()->result();
    }

    // Hapus data private facility training
    public function delete_private_facility_training($id) {
        $this->db->where('id', $id)->delete('private_facility_training');
    }

    // Input Function
}
