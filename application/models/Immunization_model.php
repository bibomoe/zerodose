<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Immunization_model extends CI_Model {

    //Tambahan baru Restored
    // Ambil Zero Dose Baseline dari target_baseline berdasarkan tahun
    public function get_baseline_zd($year) {
        $query = $this->db->select('zd')
                        ->where('year', $year)
                        ->get('target_baseline');

        return $query->row()->zd ?? 0;
    }

    // Ambil total target dari target_coverage (All Provinces) dengan filter tahun
    public function get_total_target_coverage($vaccine_type, $year) {
        $query = $this->db->select('SUM(target_population) AS total_target')
                        ->where('vaccine_type', $vaccine_type)
                        ->where('year', $year)
                        ->get('target_coverage');

        return $query->row()->total_target ?? 0;
    }

    // Ambil total target dari target_immunization (Targeted/Specific Province) dengan filter tahun
    public function get_total_target($vaccine_column, $province_id, $year) {
        $province_ids = $this->get_targeted_province_ids();
    
        $this->db->select("SUM({$vaccine_column}_target) AS total_target"); // ✅ Corrected
        $this->db->from('target_immunization');
        $this->db->where('year', $year);
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        $result = $this->db->get()->row();
        return $result->total_target ?? 0;
    }
    
    // Total imunisasi berdasarkan jenis vaksin dan filter provinsi
    public function get_total_vaccine($vaccine_column, $province_id, $year) {
        $province_ids = $this->get_targeted_province_ids();
        $this->db->select("SUM($vaccine_column) AS total");
        $this->db->from('immunization_data');
        $this->db->where('year', $year); // <-- Pastikan ini ada!
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        $query = $this->db->get()->row();
        return $query->total ?? 0;
    }

    

    // Ambil semua provinsi
    public function get_provinces() {
        return $this->db->select('id, name_id')->where('active', 1)->get('provinces')->result();
    }

    public function get_cities_by_province($province_id) {
        return $this->db->where('province_id', $province_id)->where('active', 1)->get('cities')->result();
    }

    public function get_cities_by_province_array($province_id) {
        return $this->db->where('province_id', $province_id)->where('active', 1)->get('cities')->result_array();
    }
    
    public function get_subdistricts_by_city($city_id) {
        return $this->db->where('city_id', $city_id)->where('active', 1)->get('subdistricts')->result();
    }
    
    public function get_puskesmas_by_subdistrict($subdistrict_id) {
        return $this->db->where('subdistrict_id', $subdistrict_id)->where('active', 1)->get('puskesmas')->result();
    }    

    // Simpan data imunisasi
    public function save_immunization($data) {
        // Cek apakah sudah ada data dengan kombinasi puskesmas_id, year, month
        $this->db->where('puskesmas_id', $data['puskesmas_id']);
        $this->db->where('year', $data['year']);
        $this->db->where('month', $data['month']);
        $query = $this->db->get('immunization_data');
    
        // Jika data sudah ada, lakukan update
        if ($query->num_rows() > 0) {
            $this->db->where('puskesmas_id', $data['puskesmas_id']);
            $this->db->where('year', $data['year']);
            $this->db->where('month', $data['month']);
            $this->db->update('immunization_data', $data);
            return $this->db->affected_rows(); // Return jumlah baris yang diupdate
        } else {
            // Jika data belum ada, lakukan insert
            $this->db->insert('immunization_data', $data);
            return $this->db->insert_id(); // Return ID insert baru
        }
    }
    
    public function get_targeted_province_ids() {
        $query = $this->db->select('id')
                          ->from('provinces')
                          ->where('priority', 1)
                          ->get();
    
        return array_column($query->result_array(), 'id'); // Return array ID
    }
    
    
    

    // public function get_total_target($vaccine_column, $province_id = 'all') {
    //     // Ambil province_id dengan priority = 1
    //     $province_ids = $this->get_targeted_province_ids();
    
    //     // Ambil total target berdasarkan provinsi
    //     $this->db->select('SUM(' . $vaccine_column . '_target) AS total_target');
    //     $this->db->from('target_immunization');
    
    //     if ($province_id === 'targeted') {
    //         if (!empty($province_ids)) {
    //             $this->db->where_in('province_id', $province_ids);
    //         } else {
    //             return 0; // Jika tidak ada provinsi dengan priority, kembalikan 0
    //         }
    //     } elseif ($province_id !== 'all') {
    //         $this->db->where('province_id', $province_id);
    //     }
    
    //     // Mengambil total target dari hasil query
    //     $result = $this->db->get()->row();
    //     return $result->total_target ?? 0;
    // }
    
    
    

    // Data total DPT-1 per distrik berdasarkan provinsi
    public function get_dpt1_by_district($province_id = 'all') {
        $province_ids = $this->get_targeted_province_ids(); // Ambil province_id yang priority = 1

        // Ambil total target berdasarkan provinsi
        $this->db->select('SUM(dpt_hb_hib_1_target) AS total_target')
                ->from('target_immunization');

        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return []; // Jika tidak ada provinsi priority, return array kosong
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        $total_target = $this->db->get()->row()->total_target ?? 0;
    
        // Ambil data DPT-1 per distrik
        $this->db->select("
            cities.name_id AS district, 
            SUM(immunization_data.dpt_hb_hib_1) AS total_dpt1,
            (SUM(immunization_data.dpt_hb_hib_1) / NULLIF($total_target, 0)) * 100 AS percentage_target,
            (SUM(immunization_data.dpt_hb_hib_1) / 100000) * 100 AS per_100k_targets
        ", false);
    
        $this->db->from('immunization_data');
        $this->db->join('cities', 'cities.id = immunization_data.city_id', 'left');
    
        if ($province_id === 'targeted' && !empty($province_ids)) {
            $this->db->where_in('cities.province_id', $province_ids);
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }
    
        $this->db->group_by('immunization_data.city_id, cities.name_id');
        $this->db->order_by('total_dpt1', 'DESC');
    
        return $this->db->get()->result_array();
    }
    
    public function get_provinces_with_targeted() {
        $provinces = $this->db->select('id, name_id, priority')
                              ->where('active', 1)
                              ->get('provinces')
                              ->result_array();
    
        // Tambahkan opsi "All Provinces" dan "Targeted Provinces" ke dropdown
        $province_options = [
            ['id' => 'all', 'name_id' => 'All Provinces'],
            ['id' => 'targeted', 'name_id' => 'Targeted Provinces']
        ];
    
        // Pisahkan provinsi yang memiliki priority = 1
        foreach ($provinces as $province) {
            // if ($province['priority'] == 1) {
                $province_options[] = $province;
            // }
        }
    
        return $province_options;
    }
    

    // Simpan data target imunisasi
    public function save_target_immunization($data) {
        // Cek apakah data untuk province_id dan city_id sudah ada
        $this->db->where('province_id', $data['province_id']);
        $this->db->where('city_id', $data['city_id']);
        $query = $this->db->get('target_immunization');
    
        // Jika data sudah ada, update data tersebut
        if ($query->num_rows() > 0) {
            $this->db->where('province_id', $data['province_id']);
            $this->db->where('city_id', $data['city_id']);
            $this->db->update('target_immunization', $data);
            return $this->db->affected_rows(); // Return jumlah baris yang diupdate
        } else {
            // Jika data belum ada, insert data baru
            $this->db->insert('target_immunization', $data);
            return $this->db->insert_id(); // Return ID insert baru
        }
    }
    
    public function get_target_immunization($province_id, $city_id) {
        $this->db->where('province_id', $province_id);
        $this->db->where('city_id', $city_id);
        $query = $this->db->get('target_immunization');
        return $query->row();  // Mengambil data satu baris
    }

    public function get_immunization_coverage($province_id = 'all') {
        $province_ids = $this->get_targeted_province_ids(); // Ambil province_id yang priority = 1

        $this->db->select('province_id, city_id, 
                           SUM(dpt_hb_hib_1) AS dpt1, 
                           SUM(dpt_hb_hib_2) AS dpt2, 
                           SUM(dpt_hb_hib_3) AS dpt3, 
                           SUM(mr_1) AS mr1');
        $this->db->from('immunization_data');
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        $this->db->group_by(($province_id !== 'all' && $province_id !== 'targeted') ? 'city_id' : 'province_id');
    
        $query = $this->db->get();
    
        $result = [];
        foreach ($query->result_array() as $row) {
            if ($province_id !== 'all' && $province_id !== 'targeted') {
                $result[$row['city_id']] = $row; // Simpan berdasarkan city_id jika provinsi dipilih
            } else {
                $result[$row['province_id']] = $row; // Simpan berdasarkan province_id jika menampilkan semua provinsi
            }
        }
    
        return $result;
    }
    
    public function get_zero_dose_cases($province_id = 'all', $city_id = 'all') {
        $province_ids = $this->get_targeted_province_ids(); // Ambil province_id yang priority = 1

        // Step 1: Ambil total target imunisasi
        $this->db->select("SUM(dpt_hb_hib_1_target) AS total_target", false);
        $this->db->from('target_immunization');
        
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        }
        
        $total_target = $this->db->get()->row()->total_target ?? 0;
    
        // Step 2: Ambil data imunisasi per bulan
        $this->db->select("
            year, 
            month, 
            COALESCE(SUM(dpt_hb_hib_1), 0) AS total_immunized
        ", false);
        $this->db->from('immunization_data');
    
        if ($province_id === 'targeted' && !empty($province_ids)) {
            $this->db->where_in('province_id', $province_ids);
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        }
    
        $this->db->group_by('year, month');
        $this->db->order_by('year ASC, month ASC');
    
        $immunization_data = $this->db->get()->result_array();
    
        // Step 3: Pastikan semua bulan dari Januari - Desember (2024 & 2025) ada
        $all_months = [];
        for ($y = 2024; $y <= 2025; $y++) {
            for ($m = 1; $m <= 12; $m++) {
                $all_months["$y-$m"] = [
                    'year' => $y,
                    'month' => $m,
                    'total_immunized' => 0 // Default 0 jika tidak ada data
                ];
            }
        }
    
        // Masukkan data imunisasi yang sudah ada
        foreach ($immunization_data as $data) {
            $key = "{$data['year']}-{$data['month']}";
            $all_months[$key]['total_immunized'] = intval($data['total_immunized']);
        }
    
        // Konversi ke array numerik untuk perhitungan kumulatif
        $immunization_data = array_values($all_months);
    
        // Step 4: Hitung ZD Cases dengan metode kumulatif
        $zd_cases = [];
        $cumulative_immunized = 0; // Imunisasi kumulatif
        foreach ($immunization_data as $data) {
            $cumulative_immunized += $data['total_immunized']; // Tambahkan imunisasi baru
            $zd_cases[] = [
                'year' => $data['year'],
                'month' => $data['month'],
                'zd_cases' => max($total_target - $cumulative_immunized, 0) // Pastikan tidak negatif
            ];
        }
        // var_dump($zd_cases);
    
        return $zd_cases;
    }
    
    public function get_zero_dose_trend($province_id, $city_id) {
        return $this->get_zero_dose_cases($province_id, $city_id); // Gunakan fungsi yang sama
    }
    
    
    public function get_restored_children($province_id = 'all') {
        $province_ids = $this->get_targeted_province_ids();

        $this->db->select("
            SUM(CASE WHEN cities.status = 0 THEN immunization_data.dpt_hb_hib_1 ELSE 0 END) AS kabupaten_restored,
            SUM(CASE WHEN cities.status = 1 THEN immunization_data.dpt_hb_hib_1 ELSE 0 END) AS kota_restored
        ");
        $this->db->from('immunization_data');
        $this->db->join('cities', 'cities.id = immunization_data.city_id', 'left');
    
        if ($province_id === 'targeted' && !empty($province_ids)) {
            $this->db->where_in('immunization_data.province_id', $province_ids);
        } elseif ($province_id !== 'all') {
            $this->db->where('immunization_data.province_id', $province_id);
        }
    
        return $this->db->get()->row_array();
    }
    
    
}
?>
