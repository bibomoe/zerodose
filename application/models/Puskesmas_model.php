<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puskesmas_model extends CI_Model {

    /**
     * Mengambil jumlah total puskesmas dan jumlah puskesmas yang melakukan imunisasi
     * berdasarkan provinsi, kabupaten, dan tahun yang dipilih.
     */
    public function get_puskesmas_data($province_id, $district_id, $year) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil daftar targeted provinces
    
        // **1. Ambil total jumlah puskesmas berdasarkan filter**
        $this->db->select('COUNT(id) as total_puskesmas');
        $this->db->from('puskesmas');
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return ['total_puskesmas' => 0, 'total_immunized_puskesmas' => 0, 'percentage' => 0];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        if ($district_id !== 'all') {
            $this->db->where('city_id', $district_id);
        }
    
        $total_puskesmas = $this->db->get()->row()->total_puskesmas ?? 0;
    
        // **2. Ambil jumlah puskesmas yang telah melakukan imunisasi setidaknya 1 kali**
        $this->db->select('COUNT(DISTINCT puskesmas_id) as total_immunized_puskesmas');
        $this->db->from('immunization_data');
        $this->db->where('year', $year);
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        if ($district_id !== 'all') {
            $this->db->where('city_id', $district_id);
        }
    
        $total_immunized_puskesmas = $this->db->get()->row()->total_immunized_puskesmas ?? 0;
    
        // **3. Hitung persentase**
        $percentage = ($total_puskesmas > 0) ? round(($total_immunized_puskesmas / $total_puskesmas) * 100, 2) : 0;
    
        return [
            'total_puskesmas' => $total_puskesmas,
            'total_immunized_puskesmas' => $total_immunized_puskesmas,
            'percentage' => $percentage
        ];
    }
    

    // Ambil data total Puskesmas & yang sudah imunisasi per wilayah
    // public function get_puskesmas_coverage($province_id = 'all', $year = 2025) {
    //     $province_ids = $this->get_targeted_province_ids(); // Jika ada targeted province

    //     $this->db->select('
    //         p.province_id AS province_id,
    //         p.city_id AS city_id,
    //         COUNT(DISTINCT p.id) AS total_puskesmas,
    //         COUNT(DISTINCT CASE WHEN i.puskesmas_id IS NOT NULL THEN i.puskesmas_id END) AS conducted_puskesmas
    //     ', false);

    //     $this->db->from('puskesmas p');
    //     $this->db->join('immunization_data i', 'i.puskesmas_id = p.id AND i.year = ' . $this->db->escape($year), 'left');

    //     // Filter berdasarkan tahun
    //     $this->db->where('i.year', $year);

    //     if ($province_id === 'targeted') {
    //         if (!empty($province_ids)) {
    //             $this->db->where_in('p.province_id', $province_ids);
    //         } else {
    //             return [];
    //         }
    //     } elseif ($province_id !== 'all') {
    //         $this->db->where('p.province_id', $province_id);
    //     }

    //     // Grouping berdasarkan province atau city
    //     $this->db->group_by(($province_id !== 'all' && $province_id !== 'targeted') ? 'p.city_id' : 'p.province_id');

    //     $query = $this->db->get();
    //     $result = [];

    //     foreach ($query->result_array() as $row) {
    //         // Hitung persentase
    //         $percentage_immunization = ($row['total_puskesmas'] != 0) ? ($row['conducted_puskesmas'] / $row['total_puskesmas']) * 100 : 0;

    //         $result_key = ($province_id !== 'all' && $province_id !== 'targeted') ? $row['city_id'] : $row['province_id'];

    //         $result[$result_key] = array_merge($row, [
    //             'percentage_immunization' => $percentage_immunization
    //         ]);
    //     }

    //     return $result;
    // }
    
    // Ambil data total Puskesmas & yang sudah imunisasi per wilayah
    public function get_puskesmas_coverage($province_id = 'all', $year = 2025) {
        $province_ids = $this->get_targeted_province_ids(); // Jika ada targeted province

        $this->db->select('
            p.province_id AS province_id,
            p.city_id AS city_id,
            COUNT(p.id) AS total_puskesmas,  -- ✅ Hitung total puskesmas dari tabel puskesmas
            COUNT(DISTINCT i.puskesmas_id) AS conducted_puskesmas -- ✅ Hitung hanya puskesmas unik yang sudah imunisasi
        ', false);

        $this->db->from('puskesmas p');
        $this->db->join('immunization_data i', 'i.puskesmas_id = p.id AND i.year = ' . $this->db->escape($year), 'left');

        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('p.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('p.province_id', $province_id);
        }

        // Grouping berdasarkan province atau city
        $this->db->group_by(($province_id !== 'all' && $province_id !== 'targeted') ? 'p.city_id' : 'p.province_id');

        $query = $this->db->get();
        $result = [];

        foreach ($query->result_array() as $row) {
            // Hitung persentase
            $percentage_immunization = ($row['total_puskesmas'] != 0) ? ($row['conducted_puskesmas'] / $row['total_puskesmas']) * 100 : 0;

            $result_key = ($province_id !== 'all' && $province_id !== 'targeted') ? $row['city_id'] : $row['province_id'];

            $result[$result_key] = array_merge($row, [
                'percentage_immunization' => $percentage_immunization
            ]);
        }

        return $result;
    }


    public function get_targeted_province_ids() {
        $query = $this->db->select('id')
                          ->from('provinces')
                          ->where('priority', 1)
                          ->get();
    
        return array_column($query->result_array(), 'id'); // Return array ID
    }

    public function get_puskesmas_rca_data($province_id, $year) {
        $province_ids = $this->get_targeted_province_ids(); // Jika ada targeted province
    
        // Query untuk mengambil total Puskesmas yang melakukan Rapid Community Assessment (RCA)
        $this->db->select('COUNT(DISTINCT r.id) AS total_puskesmas_rca'); // Menghitung total Puskesmas yang melakukan RCA
        $this->db->from('puskesmas p');
        $this->db->join('puskesmas_rca r', 'r.puskesmas_id = p.id AND r.year = ' . $this->db->escape($year), 'left');
        
        // Jika province_id adalah 'targeted', filter berdasarkan targeted provinces
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('p.province_id', $province_ids);
            } else {
                return 0; // Jika tidak ada province_ids yang ditentukan, return 0
            }
        } elseif ($province_id !== 'all') {
            // Jika province_id bukan 'all', filter berdasarkan province_id tertentu
            $this->db->where('p.province_id', $province_id);
        }
    
        // Jalankan query dan ambil hasilnya
        $query = $this->db->get();
    
        // Return total Puskesmas yang melakukan RCA
        return $query->row()->total_puskesmas_rca ?? 0;
    }
    
    
}
