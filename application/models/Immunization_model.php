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

    // Ambil Zero Dose (ZD) berdasarkan provinsi atau seluruh provinsi
    public function get_zero_dose_by_province($province_id) {
        $province_ids = $this->get_targeted_province_ids();  // Ambil provinsi yang ditargetkan
        $this->db->select('SUM(zd_cases) AS total_zd_cases');
        $this->db->from('zd_cases_2023');
        $this->db->where('year', 2024); // Filter berdasarkan tahun

        // Jika provinsi yang dipilih adalah 'targeted', ambil provinsi yang ditargetkan
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);  // Filter berdasarkan provinsi yang ditargetkan
            } else {
                return 0;  // Jika tidak ada provinsi yang ditargetkan
            }
        } elseif ($province_id === 'all') {
            // Jika provinsi yang dipilih adalah 'all', ambil data untuk seluruh provinsi
            $query = $this->db->get()->row();
            return $query->total_zd_cases ?? 0;
        } else {
            // Jika provinsi yang dipilih adalah provinsi tertentu
            $this->db->where('province_id', $province_id);
        }

        $query = $this->db->get()->row();
        return $query->total_zd_cases ?? 0;
    }

    // Ambil baseline DPT 3 dan MR1 berdasarkan provinsi atau seluruh provinsi
    public function get_baseline_by_province($province_id) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil provinsi yang ditargetkan
        $this->db->select('SUM(dpt3_baseline) AS total_dpt3_baseline, SUM(mr1_baseline) AS total_mr1_baseline');
        $this->db->from('baseline_immunization');
        $this->db->where('year', 2024); // Filter tahun
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return ['dpt3' => 0, 'mr1' => 0];
            }
        } elseif ($province_id === 'all') {
            $query = $this->db->get()->row();
            return [
                'dpt3' => $query->total_dpt3_baseline ?? 0,
                'mr1'  => $query->total_mr1_baseline ?? 0
            ];
        } else {
            $this->db->where('province_id', $province_id);
        }
    
        $query = $this->db->get()->row();
        return [
            'dpt3' => $query->total_dpt3_baseline ?? 0,
            'mr1'  => $query->total_mr1_baseline ?? 0
        ];
    }
    

    //Ambil data quarter saat ini
    public function get_max_quarter($year) {
        // Select the maximum quarter for the given year
        $query = $this->db->select('MAX(quarter) as max_quarter')
                          ->where('year', $year)
                          ->get('quarter_immunization_data');
    
        // Return the maximum quarter value, or 0 if no data is found
        return $query->row()->max_quarter ?? 1;
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

    // Total imunisasi berdasarkan jenis vaksin, filter provinsi, tahun, dan triwulan
    public function get_total_vaccine_by_quarter($vaccine_column, $province_id, $year, $quarter) {
        // Get the targeted provinces if needed
        $province_ids = $this->get_targeted_province_ids();

        // Start building the query
        $this->db->select("SUM($vaccine_column) AS total");
        $this->db->from('immunization_data');
        $this->db->where('year', $year);  // Ensure year filter is included

        // Adjust the month filter for each quarter
        if ($quarter == 1) {
            // Sum from January to March (quarter 1)
            $this->db->where('month <=', 3);  
        } elseif ($quarter == 2) {
            // Sum from January to June (quarter 2)
            $this->db->where('month <=', 6);
        } elseif ($quarter == 3) {
            // Sum from January to September (quarter 3)
            $this->db->where('month <=', 9);
        } elseif ($quarter == 4) {
            // Sum from January to December (quarter 4)
            $this->db->where('month <=', 12);
        }

        // Filter by province if provided
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        // Execute the query
        $query = $this->db->get()->row();

        // Return the total vaccine coverage for that quarter, or 0 if none
        return $query->total ?? 0;
    }


    // Data total DPT-1 per distrik berdasarkan provinsi
    public function get_dpt1_by_district($province_id = 'all', $year = 2025) {
        $province_ids = $this->get_targeted_province_ids();
    
        // Ambil total target berdasarkan provinsi & tahun
        $this->db->select('SUM(dpt_hb_hib_1_target) AS total_target');
        $this->db->from('target_immunization');
        $this->db->where('year', $year);
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        $total_target = $this->db->get()->row()->total_target ?? 0;

        // Ambil data DPT-1 per distrik berdasarkan tahun
        $this->db->select("
            cities.name_id AS district, 
            SUM(immunization_data.dpt_hb_hib_1) AS total_dpt1,
            target_immunization.dpt_hb_hib_1_target AS target_district,
            (SUM(immunization_data.dpt_hb_hib_1) / NULLIF(target_immunization.dpt_hb_hib_1_target, 0)) * 100 AS percentage_target,  -- Persentase target DPT-1
            (target_immunization.dpt_hb_hib_1_target - SUM(immunization_data.dpt_hb_hib_1)) AS zero_dose_children,  -- Anak zero dose
            ((target_immunization.dpt_hb_hib_1_target - SUM(immunization_data.dpt_hb_hib_1)) / NULLIF(target_immunization.dpt_hb_hib_1_target, 0)) * 100 AS percent_zero_dose  -- Persentase zero dose
        ", false);
    
        $this->db->from('immunization_data');
        $this->db->join('cities', 'cities.id = immunization_data.city_id', 'left');
        $this->db->join('target_immunization', 'target_immunization.city_id = immunization_data.city_id AND target_immunization.year = immunization_data.year', 'left');
        $this->db->where('immunization_data.year', $year);
    
        if ($province_id === 'targeted' && !empty($province_ids)) {
            $this->db->where_in('cities.province_id', $province_ids);
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }
    
        $this->db->group_by('immunization_data.city_id, cities.name_id');
        $this->db->order_by('total_dpt1', 'DESC');
        // var_dump($this->db->get()->result_array());
        // exit;
    
        return $this->db->get()->result_array();
    }

    // Ambil cakupan imunisasi berdasarkan provinsi atau kota dan tahun
    public function get_immunization_coverage($province_id = 'all', $year = 2025) {
        $province_ids = $this->get_targeted_province_ids();
    
        $this->db->select('
            i.province_id AS province_id,
            i.city_id AS city_id,
            SUM(i.dpt_hb_hib_1) AS dpt1, 
            SUM(i.dpt_hb_hib_2) AS dpt2, 
            SUM(i.dpt_hb_hib_3) AS dpt3, 
            SUM(i.mr_1) AS mr1,
            t.dpt_hb_hib_1_target AS target_dpt1,
            t.dpt_hb_hib_3_target AS target_dpt3,
            IFNULL(zd.zd_cases_2023, 0) AS zd_cases_2023,
            t.mr_1_target AS target_mr1
            
        ', false);
        
        $this->db->from('immunization_data i');
        // $this->db->join('target_immunization t', 't.city_id = i.city_id AND t.year = i.year', 'left');
        // $this->db->join('zd_cases_2023 zd', 'zd.city_id = i.city_id', 'left'); // Join berdasarkan city_id
        // Gabungkan dengan target_immunization menggunakan subquery

        if ($province_id === 'targeted' || $province_id === 'all') {
            $this->db->join('(
                SELECT city_id, SUM(dpt_hb_hib_1_target) AS dpt_hb_hib_1_target, 
                SUM(dpt_hb_hib_3_target) AS dpt_hb_hib_3_target, 
                SUM(mr_1_target) AS mr_1_target
                FROM target_immunization
                WHERE year = ' . $year . '
                GROUP BY province_id
            ) t', 't.city_id = i.city_id', 'left'); // Menggunakan subquery untuk target_immunization
            
            $this->db->join('(
                SELECT city_id, SUM(zd_cases) AS zd_cases_2023
                FROM zd_cases_2023
                WHERE year = 2024
                GROUP BY province_id
            ) zd', 'zd.city_id = i.city_id', 'left');  // Menggabungkan dengan hasil SUM
        } else {

            $this->db->join('(
                SELECT city_id, SUM(dpt_hb_hib_1_target) AS dpt_hb_hib_1_target, 
                SUM(dpt_hb_hib_3_target) AS dpt_hb_hib_3_target, 
                SUM(mr_1_target) AS mr_1_target
                FROM target_immunization
                WHERE year = ' . $year . '
                GROUP BY city_id
            ) t', 't.city_id = i.city_id', 'left'); // Menggunakan subquery untuk target_immunization
            
            $this->db->join('(
                SELECT city_id, SUM(zd_cases) AS zd_cases_2023
                FROM zd_cases_2023
                WHERE year = 2024
                GROUP BY city_id
            ) zd', 'zd.city_id = i.city_id', 'left');  // Menggabungkan dengan hasil SUM
        }

        // Filter berdasarkan tahun
        $this->db->where('i.year', $year);
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('i.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('i.province_id', $province_id);
        }
    
        // Pastikan alias digunakan di GROUP BY
        $this->db->group_by(($province_id !== 'all' && $province_id !== 'targeted') ? 'i.city_id' : 'i.province_id');
    
        $query = $this->db->get();

        // var_dump($query->result_array());
        // exit;
        $result = [];
    
        foreach ($query->result_array() as $row) {
            $zero_dose_children = max($row['target_dpt1'] - $row['dpt1'], 0);
            
            $percentage_target_dpt1 = ($row['target_dpt1'] != 0) ? ($row['dpt1'] / $row['target_dpt1']) * 100 : 0;
            $percentage_target_dpt3 = ($row['target_dpt3'] != 0) ? ($row['dpt3'] / $row['target_dpt3']) * 100 : 0;
            $percentage_target_mr1 = ($row['target_mr1'] != 0) ? ($row['mr1'] / $row['target_mr1']) * 100 : 0;
            $percent_zero_dose = ($row['target_dpt1'] != 0) ? ($zero_dose_children / $row['target_dpt1']) * 100 : 0;

            // Hitung % reduction dari ZD 2023
            $zd_cases_2023 = $row['zd_cases_2023'];
            $percent_reduction = ($zd_cases_2023 > 0) ? (($zd_cases_2023 - $zero_dose_children) / $zd_cases_2023) * 100 : 0;


            $result_key = ($province_id !== 'all' && $province_id !== 'targeted') ? $row['city_id'] : $row['province_id'];
    
            $result[$result_key] = array_merge($row, [
                'zero_dose_children' => $zero_dose_children,
                'percentage_target_dpt1' => $percentage_target_dpt1,
                'percentage_target_dpt3' => $percentage_target_dpt3,
                'percentage_target_mr1' => $percentage_target_mr1,
                'zd_children_2023' => $zd_cases_2023,
                'percent_reduction' => $percent_reduction,
                'percent_zero_dose' => $percent_zero_dose
            ]);
        }
    
        return $result;
    }

    // Fungsi untuk mendapatkan tanggal terakhir data imunisasi diupdate berdasarkan tahun
    public function get_last_immunization_update_date($year = 2025) {
        $this->db->select('DATE_FORMAT(MAX(i.updated_at), "%d %M %Y") AS last_update_date');
        $this->db->from('immunization_data i');
        
        // Filter berdasarkan tahun
        $this->db->where('i.year', $year);

        // Eksekusi query
        $query = $this->db->get();

        // Ambil hasilnya
        $result = $query->row_array();
        
        // Jika ada hasil, return tanggal terakhir update
        if (!empty($result['last_update_date'])) {
            return $result['last_update_date'];
        }

        // Jika tidak ada data, return null
        return null;
    }


    public function get_zero_dose_cases($province_id = 'all', $city_id = 'all') {
        // Ambil provinsi yang memiliki priority = 1 (targeted)
        $province_ids = $this->get_targeted_province_ids();
    
        // Step 1: Ambil total target imunisasi berdasarkan tahun (2026 dan 2025)
        if ($province_id === 'all') {
            // Ambil total target DPT-1 untuk tahun 2026 dan 2025 dari tabel target_coverage
            $this->db->select("
                SUM(CASE WHEN year = 2026 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS total_target_2026,
                SUM(CASE WHEN year = 2025 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS total_target_2025
            ", false);
            $this->db->from('target_coverage');
            $total_target = $this->db->get()->row_array();
            $total_target_2026 = $total_target['total_target_2026'] ?? 0;
            $total_target_2025 = $total_target['total_target_2025'] ?? 0;
        } else {
            // Total target untuk tahun 2026
            $this->db->select("SUM(dpt_hb_hib_1_target) AS total_target_2026", false);
            $this->db->from('target_immunization');
            $this->db->where('year', 2026);
    
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
    
            $total_target_2026 = $this->db->get()->row()->total_target_2026 ?? 0;
    
            // Total target untuk tahun 2025
            $this->db->select("SUM(dpt_hb_hib_1_target) AS total_target_2025", false);
            $this->db->from('target_immunization');
            $this->db->where('year', 2025);
    
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
    
            $total_target_2025 = $this->db->get()->row()->total_target_2025 ?? 0;
        }
    
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

        $this->db->where_in('year', array(2025, 2026));
    
        $this->db->group_by('year, month');
        $this->db->order_by('year ASC, month ASC');
    
        $immunization_data = $this->db->get()->result_array();

        
    
        // Step 3: Pastikan semua bulan dari Januari - Desember (2026 & 2025) ada
        $all_months = [];
        for ($y = 2025; $y <= 2026; $y++) {
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

        // var_dump($immunization_data);
        // exit;
    
    
        // Step 4: Hitung ZD Cases dengan metode kumulatif
        $zd_cases = [];
        $cumulative_immunized_2025 = 0; // Imunisasi kumulatif untuk tahun 2026
        $cumulative_immunized_2026 = 0; // Imunisasi kumulatif untuk tahun 2025
    
        foreach ($immunization_data as $data) {
            if ($data['year'] == 2025) {
                $cumulative_immunized_2025 += $data['total_immunized']; // Tambahkan imunisasi tahun 2025
                $zd_cases[] = [
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'zd_cases' => max($total_target_2025 - $cumulative_immunized_2025, 0) // Pastikan tidak negatif
                ];
            } elseif ($data['year'] == 2026) {
                $cumulative_immunized_2026 += $data['total_immunized']; // Tambahkan imunisasi tahun 2026
                $zd_cases[] = [
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'zd_cases' => max($total_target_2026 - $cumulative_immunized_2026, 0) // Pastikan tidak negatif
                ];
            }
        }
    
        return $zd_cases;
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

    // public function get_immunization_coverage($province_id = 'all') {
    //     $province_ids = $this->get_targeted_province_ids(); // Ambil province_id yang priority = 1

    //     $this->db->select('province_id, city_id, 
    //                        SUM(dpt_hb_hib_1) AS dpt1, 
    //                        SUM(dpt_hb_hib_2) AS dpt2, 
    //                        SUM(dpt_hb_hib_3) AS dpt3, 
    //                        SUM(mr_1) AS mr1');
    //     $this->db->from('immunization_data');
    
    //     if ($province_id === 'targeted') {
    //         if (!empty($province_ids)) {
    //             $this->db->where_in('province_id', $province_ids);
    //         } else {
    //             return [];
    //         }
    //     } elseif ($province_id !== 'all') {
    //         $this->db->where('province_id', $province_id);
    //     }
    
    //     $this->db->group_by(($province_id !== 'all' && $province_id !== 'targeted') ? 'city_id' : 'province_id');
    
    //     $query = $this->db->get();
    
    //     $result = [];
    //     foreach ($query->result_array() as $row) {
    //         if ($province_id !== 'all' && $province_id !== 'targeted') {
    //             $result[$row['city_id']] = $row; // Simpan berdasarkan city_id jika provinsi dipilih
    //         } else {
    //             $result[$row['province_id']] = $row; // Simpan berdasarkan province_id jika menampilkan semua provinsi
    //         }
    //     }
    
    //     return $result;
    // }
    
    // public function get_zero_dose_cases($province_id = 'all', $city_id = 'all') {
    //     $province_ids = $this->get_targeted_province_ids(); // Ambil province_id yang priority = 1

    //     // Step 1: Ambil total target imunisasi
    //     $this->db->select("SUM(dpt_hb_hib_1_target) AS total_target", false);
    //     $this->db->from('target_immunization');
        
    //     if ($province_id === 'targeted') {
    //         if (!empty($province_ids)) {
    //             $this->db->where_in('province_id', $province_ids);
    //         } else {
    //             return [];
    //         }
    //     } elseif ($province_id !== 'all') {
    //         $this->db->where('province_id', $province_id);
    //     }

    //     if ($city_id !== 'all') {
    //         $this->db->where('city_id', $city_id);
    //     }
        
    //     $total_target = $this->db->get()->row()->total_target ?? 0;
    
    //     // Step 2: Ambil data imunisasi per bulan
    //     $this->db->select("
    //         year, 
    //         month, 
    //         COALESCE(SUM(dpt_hb_hib_1), 0) AS total_immunized
    //     ", false);
    //     $this->db->from('immunization_data');
    
    //     if ($province_id === 'targeted' && !empty($province_ids)) {
    //         $this->db->where_in('province_id', $province_ids);
    //     } elseif ($province_id !== 'all') {
    //         $this->db->where('province_id', $province_id);
    //     }

    //     if ($city_id !== 'all') {
    //         $this->db->where('city_id', $city_id);
    //     }
    
    //     $this->db->group_by('year, month');
    //     $this->db->order_by('year ASC, month ASC');
    
    //     $immunization_data = $this->db->get()->result_array();
    
    //     // Step 3: Pastikan semua bulan dari Januari - Desember (2024 & 2025) ada
    //     $all_months = [];
    //     for ($y = 2024; $y <= 2025; $y++) {
    //         for ($m = 1; $m <= 12; $m++) {
    //             $all_months["$y-$m"] = [
    //                 'year' => $y,
    //                 'month' => $m,
    //                 'total_immunized' => 0 // Default 0 jika tidak ada data
    //             ];
    //         }
    //     }
    
    //     // Masukkan data imunisasi yang sudah ada
    //     foreach ($immunization_data as $data) {
    //         $key = "{$data['year']}-{$data['month']}";
    //         $all_months[$key]['total_immunized'] = intval($data['total_immunized']);
    //     }
    
    //     // Konversi ke array numerik untuk perhitungan kumulatif
    //     $immunization_data = array_values($all_months);
    
    //     // Step 4: Hitung ZD Cases dengan metode kumulatif
    //     $zd_cases = [];
    //     $cumulative_immunized = 0; // Imunisasi kumulatif
    //     foreach ($immunization_data as $data) {
    //         $cumulative_immunized += $data['total_immunized']; // Tambahkan imunisasi baru
    //         $zd_cases[] = [
    //             'year' => $data['year'],
    //             'month' => $data['month'],
    //             'zd_cases' => max($total_target - $cumulative_immunized, 0) // Pastikan tidak negatif
    //         ];
    //     }
    //     // var_dump($zd_cases);
    
    //     return $zd_cases;
    // }
    
    public function get_zero_dose_trend($province_id, $city_id) {
        return $this->get_zero_dose_cases($province_id, $city_id); // Gunakan fungsi yang sama
    }
    
    
    public function get_restored_children($province_id = 'all', $year = 2025) {
        $province_ids = $this->get_targeted_province_ids();
    
        $this->db->select("
            SUM(CASE WHEN cities.status = 0 THEN immunization_data.dpt_hb_hib_1 ELSE 0 END) AS kabupaten_restored,
            SUM(CASE WHEN cities.status = 1 THEN immunization_data.dpt_hb_hib_1 ELSE 0 END) AS kota_restored
        ");
        $this->db->from('immunization_data');
        $this->db->join('cities', 'cities.id = immunization_data.city_id', 'left');
        
        // Filter berdasarkan tahun
        $this->db->where('immunization_data.year', $year);
    
        if ($province_id === 'targeted' && !empty($province_ids)) {
            $this->db->where_in('immunization_data.province_id', $province_ids);
        } elseif ($province_id !== 'all') {
            $this->db->where('immunization_data.province_id', $province_id);
        }
    
        return $this->db->get()->row_array();
    }    
    
    
}
?>
