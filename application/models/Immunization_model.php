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
    public function get_zero_dose_by_province($province_id, $city_id) {
        $province_ids = $this->get_targeted_province_ids();  // Ambil provinsi yang ditargetkan
        $this->db->select('SUM(zd_cases) AS total_zd_cases');
        $this->db->from('zd_cases_2023');
        $this->db->where('year', 2024); // Filter berdasarkan tahun
        // $this->db->where('year', $year); // Filter berdasarkan tahun

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

        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        } 

        $query = $this->db->get()->row();
        return $query->total_zd_cases ?? 0;
    }

    // Ambil baseline DPT 3 dan MR1 berdasarkan provinsi atau seluruh provinsi
    public function get_baseline_by_province($province_id, $city_id) {
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

        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        } 
    
        $query = $this->db->get()->row();
        return [
            'dpt3' => $query->total_dpt3_baseline ?? 0,
            'mr1'  => $query->total_mr1_baseline ?? 0
        ];
    }
    

    // Ambil jumlah anak dpt1 kejar
    public function get_dpt1_coverage_by_province($province_id, $selected_year, $city_id) {
        $province_ids = $this->get_targeted_province_ids();  // Ambil provinsi yang ditargetkan
        
        $this->db->select('SUM(dpt1_coverage) AS total_dpt1_coverage');
        $this->db->from('immunization_data_kejar');
        
        // Filter berdasarkan tahun yang dipilih
        $this->db->where('year', $selected_year);
        
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
            return $query->total_dpt1_coverage ?? 0;
        } else {
            // Jika provinsi yang dipilih adalah provinsi tertentu
            $this->db->where('province_id', $province_id);
        }

        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        } 

        // Ambil hasil dan kembalikan total cakupan DPT-1
        $query = $this->db->get()->row();
        return $query->total_dpt1_coverage ?? 0;
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

    //Ambil data maks Bulan saat ini
    public function get_max_dpt1_month($year) {
        // Select the maximum quarter for the given year
        $query = $this->db->select('MAX(month) as max_month')
                          ->where('year', $year)
                          ->get('immunization_data');
    
        // Return the maximum quarter value, or 0 if no data is found
        return $query->row()->max_month ?? 1;
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
    public function get_total_target($vaccine_column, $province_id, $city_id, $year) {
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

        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        } 
    
        $result = $this->db->get()->row();
        return $result->total_target ?? 0;
    }
    
    // Total imunisasi berdasarkan jenis vaksin dan filter provinsi
    public function get_total_vaccine($vaccine_column, $province_id, $city_id, $year) {
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

        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        } 
    
        $query = $this->db->get()->row();
        return $query->total ?? 0;
    }

    // Total imunisasi berdasarkan jenis vaksin, filter provinsi, tahun, dan triwulan
    public function get_total_vaccine_by_quarter($vaccine_column, $province_id, $city_id, $year, $quarter) {
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

        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        } 

        // Execute the query
        $query = $this->db->get()->row();

        // Return the total vaccine coverage for that quarter, or 0 if none
        return $query->total ?? 0;
    }


    // Data total DPT-1 per distrik berdasarkan provinsi
    public function get_dpt1_by_district($province_id = 'all', $year = 2025, $max_month = 1) {
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
        // return $this->db->get()->result_array();

        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result as &$row) {
            $total_target = $row['target_district'];
            // if ($quarter == 1) {
            //     $quarter_target = $total_target / 4;
            // } elseif ($quarter == 2) {
            //     $quarter_target = 2 * $total_target / 4;
            // } elseif ($quarter == 3) {
            //     $quarter_target = 3 * $total_target / 4;
            // } else {
            //     $quarter_target = $total_target;
            // }

            // $row['target_district'] = $quarter_target;
            // $row['percentage_target'] = ($row['total_dpt1'] / $quarter_target) * 100;
            // $row['zero_dose_children'] = $quarter_target - $row['total_dpt1'];
            // $row['percent_zero_dose'] = ($row['zero_dose_children'] / $quarter_target) * 100;

            $total_target_cumulative_month = $total_target * $max_month / 12;

            $row['target_district'] = $total_target_cumulative_month;
            $row['percentage_target'] = ($row['total_dpt1'] / $total_target) * 100;
            $row['zero_dose_children'] = $total_target_cumulative_month - $row['total_dpt1'];
            $row['percent_zero_dose'] = ($row['zero_dose_children'] / $total_target_cumulative_month) * 100;
        }

        return $result;
    }

    // Data total DPT-1 per distrik berdasarkan kabkota
    public function get_dpt1_by_puskesmas($province_id = 'all', $city_id = 'all', $year = 2025, $max_month = 1 ) {
        // Fetch province IDs based on the target condition (if needed)
        $province_ids = $this->get_targeted_province_ids();
        
        // Retrieve the total target for DPT-1 based on the selected province and year
        $this->db->select('SUM(dpt_hb_hib_1_target) AS total_target');
        $this->db->from('target_immunization_per_puskesmas');
        $this->db->where('year', $year);

        // Apply filtering based on the province_id
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        // Get the total target
        $total_target = $this->db->get()->row()->total_target ?? 0;

        // Now, fetch the data for each puskesmas
        $this->db->select("
            puskesmas.name AS district, 
            SUM(immunization_data_per_puskesmas.dpt_hb_hib_1) AS total_dpt1,
            target_immunization_per_puskesmas.dpt_hb_hib_1_target AS target_district,
            (SUM(immunization_data_per_puskesmas.dpt_hb_hib_1) / NULLIF(target_immunization_per_puskesmas.dpt_hb_hib_1_target, 0)) * 100 AS percentage_target,  -- Persentase target DPT-1
            (target_immunization_per_puskesmas.dpt_hb_hib_1_target - SUM(immunization_data_per_puskesmas.dpt_hb_hib_1)) AS zero_dose_children,  -- Anak zero dose
            ((target_immunization_per_puskesmas.dpt_hb_hib_1_target - SUM(immunization_data_per_puskesmas.dpt_hb_hib_1)) / NULLIF(target_immunization_per_puskesmas.dpt_hb_hib_1_target, 0)) * 100 AS percent_zero_dose  -- Persentase zero dose
        ", false);

        // Join with immunization data and target table
        $this->db->from('immunization_data_per_puskesmas');
        $this->db->join('puskesmas', 'puskesmas.id = immunization_data_per_puskesmas.puskesmas_id', 'left');
        $this->db->join('target_immunization_per_puskesmas', 'target_immunization_per_puskesmas.puskesmas_id = immunization_data_per_puskesmas.puskesmas_id AND target_immunization_per_puskesmas.year = immunization_data_per_puskesmas.year', 'left');
        $this->db->where('immunization_data_per_puskesmas.year', $year);

        // Apply the province filter
        if ($province_id === 'targeted' && !empty($province_ids)) {
            $this->db->where_in('puskesmas.province_id', $province_ids);
        } elseif ($province_id !== 'all') {
            $this->db->where('puskesmas.province_id', $province_id);
        }

         if ($city_id !== 'all') {
            $this->db->where('puskesmas.city_id', $city_id);
        } 

        // Group by puskesmas and order by the total DPT-1
        $this->db->group_by('immunization_data_per_puskesmas.puskesmas_id, puskesmas.name');
        $this->db->order_by('total_dpt1', 'DESC');

        // return $this->db->get()->result_array();
        $query = $this->db->get();
        $result = $query->result_array();

        // Hitung ulang target per kuartal dan persentasenya
        foreach ($result as &$row) {
            $total_target = $row['target_district'] ?? 0;

            // if ($quarter == 1) {
            //     $quarter_target = $total_target / 4;
            // } elseif ($quarter == 2) {
            //     $quarter_target = 2 * $total_target / 4;
            // } elseif ($quarter == 3) {
            //     $quarter_target = 3 * $total_target / 4;
            // } else {
            //     $quarter_target = $total_target;
            // }

            // $row['target_district'] = $quarter_target;
            // $row['percentage_target'] = $quarter_target > 0 ? ($row['total_dpt1'] / $quarter_target) * 100 : 0;
            // $row['zero_dose_children'] = $quarter_target - $row['total_dpt1'];
            // $row['percent_zero_dose'] = $quarter_target > 0 ? ($row['zero_dose_children'] / $quarter_target) * 100 : 0;

            $total_target_cumulative_month = $total_target * $max_month / 12;

            $row['target_district'] = $total_target_cumulative_month;
            $row['percentage_target'] = $total_target > 0 ? ($row['total_dpt1'] / $total_target) * 100 : 0;
            $row['zero_dose_children'] = $total_target_cumulative_month - $row['total_dpt1'];
            $row['percent_zero_dose'] = $total_target_cumulative_month > 0 ? ($row['zero_dose_children'] / $total_target_cumulative_month) * 100 : 0;
        }

        return $result;
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
            IFNULL(k.total_dpt1_coverage_kejar, 0) AS total_dpt1_coverage_kejar,
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

            $this->db->join('(
                SELECT city_id, SUM(dpt1_coverage) AS total_dpt1_coverage_kejar
                FROM immunization_data_kejar
                WHERE year = ' . $year . '
                GROUP BY province_id
            ) k', 'k.city_id = i.city_id', 'left');  // Menggabungkan dengan hasil SUM
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

            $this->db->join('(
                SELECT city_id, SUM(dpt1_coverage) AS total_dpt1_coverage_kejar
                FROM immunization_data_kejar
                WHERE year = ' . $year . '
                GROUP BY city_id
            ) k', 'k.city_id = i.city_id', 'left');  // Menggabungkan dengan hasil SUM
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

            // Hitung % reduction dari ZD 2024
            $zd_cases_2023 = $row['zd_cases_2023'];
            $total_dpt1_coverage_kejar = $row['total_dpt1_coverage_kejar'];

            // $percent_reduction = ($zd_cases_2023 > 0) ? (($zd_cases_2023 - $zero_dose_children) / $zd_cases_2023) * 100 : 0;
            // $percent_reduction = ($total_dpt1_coverage_kejar > 0) ? ($total_dpt1_coverage_kejar / $zd_cases_2023) * 100 : 0;
            // Ensure we don't divide by zero
            // Ensure we handle the division by zero properly
            if ($zd_cases_2023 > 0 && $total_dpt1_coverage_kejar > 0) {
                $percent_reduction = ($total_dpt1_coverage_kejar / $zd_cases_2023) * 100;
            } elseif ($zd_cases_2023 == 0 && $total_dpt1_coverage_kejar >= 0) {
                $percent_reduction = 100; // If zd_cases_2023 is zero and total_dpt1_coverage_kejar is greater than zero, set percent_reduction to 100
            } else {
                $percent_reduction = 0; // If both are zero or conditions are not met, set percent_reduction to 0
            }

            $result_key = ($province_id !== 'all' && $province_id !== 'targeted') ? $row['city_id'] : $row['province_id'];
    
            $result[$result_key] = array_merge($row, [
                'zero_dose_children' => $zero_dose_children,
                'percentage_target_dpt1' => $percentage_target_dpt1,
                'percentage_target_dpt3' => $percentage_target_dpt3,
                'percentage_target_mr1' => $percentage_target_mr1,
                'zd_children_2023' => $zd_cases_2023,
                'total_dpt1_kejar' => $total_dpt1_coverage_kejar,
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


    // public function get_zero_dose_cases($province_id = 'all', $city_id = 'all') {
    //     // Ambil provinsi yang memiliki priority = 1 (targeted)
    //     $province_ids = $this->get_targeted_province_ids();
    
    //     // Step 1: Ambil total target imunisasi berdasarkan tahun (2026 dan 2025)
    //     if ($province_id === 'all') {
    //         // Ambil total target DPT-1 untuk tahun 2026 dan 2025 dari tabel target_coverage
    //         $this->db->select("
    //             SUM(CASE WHEN year = 2026 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS total_target_2026,
    //             SUM(CASE WHEN year = 2025 AND vaccine_type = 'DPT-1' THEN target_population ELSE 0 END) AS total_target_2025
    //         ", false);
    //         $this->db->from('target_coverage');
    //         $total_target = $this->db->get()->row_array();
    //         $total_target_2026 = $total_target['total_target_2026'] ?? 0;
    //         $total_target_2025 = $total_target['total_target_2025'] ?? 0;
    //     } else {
    //         // Total target untuk tahun 2026
    //         $this->db->select("SUM(dpt_hb_hib_1_target) AS total_target_2026", false);
    //         $this->db->from('target_immunization');
    //         $this->db->where('year', 2026);
    
    //         if ($province_id === 'targeted') {
    //             if (!empty($province_ids)) {
    //                 $this->db->where_in('province_id', $province_ids);
    //             } else {
    //                 return [];
    //             }
    //         } elseif ($province_id !== 'all') {
    //             $this->db->where('province_id', $province_id);
    //         }
    
    //         if ($city_id !== 'all') {
    //             $this->db->where('city_id', $city_id);
    //         }
    
    //         $total_target_2026 = $this->db->get()->row()->total_target_2026 ?? 0;
    
    //         // Total target untuk tahun 2025
    //         $this->db->select("SUM(dpt_hb_hib_1_target) AS total_target_2025", false);
    //         $this->db->from('target_immunization');
    //         $this->db->where('year', 2025);
    
    //         if ($province_id === 'targeted') {
    //             if (!empty($province_ids)) {
    //                 $this->db->where_in('province_id', $province_ids);
    //             } else {
    //                 return [];
    //             }
    //         } elseif ($province_id !== 'all') {
    //             $this->db->where('province_id', $province_id);
    //         }
    
    //         if ($city_id !== 'all') {
    //             $this->db->where('city_id', $city_id);
    //         }
    
    //         $total_target_2025 = $this->db->get()->row()->total_target_2025 ?? 0;
    //     }
    
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

    //     $this->db->where_in('year', array(2025, 2026));
    
    //     $this->db->group_by('year, month');
    //     $this->db->order_by('year ASC, month ASC');
    
    //     $immunization_data = $this->db->get()->result_array();

        
    
    //     // Step 3: Pastikan semua bulan dari Januari - Desember (2026 & 2025) ada
    //     $all_months = [];
    //     for ($y = 2025; $y <= 2026; $y++) {
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

    //     // var_dump($immunization_data);
    //     // exit;
    
    
    //     // Step 4: Hitung ZD Cases dengan metode kumulatif
    //     $zd_cases = [];
    //     $cumulative_immunized_2025 = 0; // Imunisasi kumulatif untuk tahun 2026
    //     $cumulative_immunized_2026 = 0; // Imunisasi kumulatif untuk tahun 2025
    
    //     foreach ($immunization_data as $data) {
    //         if ($data['year'] == 2025) {
    //             $cumulative_immunized_2025 += $data['total_immunized']; // Tambahkan imunisasi tahun 2025
    //             $zd_cases[] = [
    //                 'year' => $data['year'],
    //                 'month' => $data['month'],
    //                 'zd_cases' => max($total_target_2025 - $cumulative_immunized_2025, 0) // Pastikan tidak negatif
    //             ];
    //         } elseif ($data['year'] == 2026) {
    //             $cumulative_immunized_2026 += $data['total_immunized']; // Tambahkan imunisasi tahun 2026
    //             $zd_cases[] = [
    //                 'year' => $data['year'],
    //                 'month' => $data['month'],
    //                 'zd_cases' => max($total_target_2026 - $cumulative_immunized_2026, 0) // Pastikan tidak negatif
    //             ];
    //         }
    //     }
    
    //     return $zd_cases;
    // }
    
    public function get_zero_dose_cases($province_id = 'all', $city_id = 'all') {
        // Fetch province IDs based on the target condition (if needed)
        $province_ids = $this->get_targeted_province_ids();

        // Step 1: Ambil total target (zd_cases) untuk tahun 2024 dari tabel zd_cases_2023
        $this->db->select("SUM(zd_cases) AS total_target_2024", false);
        $this->db->from('zd_cases_2023');
        $this->db->where('year', 2024);

        // Apply filtering based on the province_id
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return [];  // Jika tidak ada province_ids, langsung return kosong
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        // Filter city_id jika diperlukan
        if ($city_id !== 'all') {
            $this->db->where('city_id', $city_id);
        }

        $total_target_2024 = $this->db->get()->row()->total_target_2024 ?? 0;


        // Step 2: Ambil data cakupan DPT-1 per bulan dari tabel immunization_data_kejar
        $this->db->select("
            year, 
            month, 
            COALESCE(SUM(dpt1_coverage), 0) AS total_immunized
        ", false);
        $this->db->from('immunization_data_kejar');
        
        // Apply filtering based on the province_id
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
        
        $this->db->where_in('year', [2025, 2026]);
        $this->db->group_by('year, month');
        $this->db->order_by('year ASC, month ASC');
        
        $immunization_data = $this->db->get()->result_array();

        // Step 3: Pastikan semua bulan dari Januari - Desember (2025 & 2026) ada
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

        // Step 4: Hitung ZD Cases dengan metode kumulatif
        $zd_cases = [];
        $cumulative_immunized_2025 = 0; // Imunisasi kumulatif untuk tahun 2025
        $cumulative_immunized_2026 = 0; // Imunisasi kumulatif untuk tahun 2026

        foreach ($immunization_data as $data) {
            if ($data['year'] == 2025) {
                $cumulative_immunized_2025 += $data['total_immunized']; // Tambahkan imunisasi tahun 2025
                $zd_cases[] = [
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'zd_cases' => max($total_target_2024 - $cumulative_immunized_2025, 0) // Pastikan tidak negatif
                ];
            } elseif ($data['year'] == 2026) {
                $cumulative_immunized_2026 += $data['total_immunized']; // Tambahkan imunisasi tahun 2026
                $zd_cases[] = [
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'zd_cases' => max($total_target_2024 - $cumulative_immunized_2026, 0) // Pastikan tidak negatif
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

    public function get_districts_with_all($province_id) {
        // Ambil data kabupaten/kota berdasarkan province_id
        $districts = $this->db->select('id, name_id, province_id, status')
                            ->where('province_id', $province_id)
                            ->where('active', 1)  // Pastikan hanya yang aktif
                            ->get('cities')
                            ->result_array();
        
        // Tambahkan opsi "All Districts" dan "Targeted Districts" ke dropdown
        $district_options = [
            ['id' => 'all', 'name_id' => 'All Districts']
        ];
        
        // Pisahkan distrik yang memiliki status = 1 (misalnya Targeted Districts)
        foreach ($districts as $district) {
            // Jika ingin memfilter berdasarkan status atau kondisi tertentu, bisa disesuaikan
            $district_options[] = $district;
        }
        
        return $district_options;
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
    
    
    // public function get_restored_children($province_id = 'all', $year = 2025) {
    //     $province_ids = $this->get_targeted_province_ids();
    
    //     $this->db->select("
    //         SUM(CASE WHEN cities.status = 0 THEN immunization_data.dpt_hb_hib_1 ELSE 0 END) AS kabupaten_restored,
    //         SUM(CASE WHEN cities.status = 1 THEN immunization_data.dpt_hb_hib_1 ELSE 0 END) AS kota_restored
    //     ");
    //     $this->db->from('immunization_data');
    //     $this->db->join('cities', 'cities.id = immunization_data.city_id', 'left');
        
    //     // Filter berdasarkan tahun
    //     $this->db->where('immunization_data.year', $year);
    
    //     if ($province_id === 'targeted' && !empty($province_ids)) {
    //         $this->db->where_in('immunization_data.province_id', $province_ids);
    //     } elseif ($province_id !== 'all') {
    //         $this->db->where('immunization_data.province_id', $province_id);
    //     }
    
    //     return $this->db->get()->row_array();
    // }    

    public function get_restored_children($province_id = 'all', $city_id = 'all', $year = 2025) {
        $province_ids = $this->get_targeted_province_ids();

        // Select the sum of restored children (dpt1_coverage) based on city status
        $this->db->select("
            SUM(CASE WHEN cities.status = 0 THEN immunization_data_kejar.dpt1_coverage ELSE 0 END) AS kabupaten_restored,
            SUM(CASE WHEN cities.status = 1 THEN immunization_data_kejar.dpt1_coverage ELSE 0 END) AS kota_restored
        ");
        $this->db->from('immunization_data_kejar'); // Changed the table name to immunization_data_kejar
        $this->db->join('cities', 'cities.id = immunization_data_kejar.city_id', 'left');

        // Filter based on the year
        $this->db->where('immunization_data_kejar.year', $year); // Updated to use the correct table alias

        // Filter by province if necessary
        if ($province_id === 'targeted' && !empty($province_ids)) {
            $this->db->where_in('immunization_data_kejar.province_id', $province_ids); // Updated to correct table
        } elseif ($province_id !== 'all') {
            $this->db->where('immunization_data_kejar.province_id', $province_id); // Updated to correct table
        }

        if ($city_id !== 'all') {
            $this->db->where('immunization_data_kejar.city_id', $city_id);
        }

        return $this->db->get()->row_array();
    }

    //Kejar 03 Agustus 2025
    public function get_kejar_group_by_province($year)
    {
        $this->db->select('
            p.id AS region_id,
            p.name_id AS name,

            COALESCE(SUM(a.dpt1_coverage), 0) AS kejar_asik,
            COALESCE(SUM(m.dpt1_coverage), 0) AS kejar_manual,
            COALESCE(SUM(k.dpt1_coverage), 0) AS kejar_kombinasi,

            (
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.province_id = p.id
            ) AS zd_total,

            ROUND((COALESCE(SUM(a.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.province_id = p.id
            ), 0)) * 100, 1) AS percentage_asik,

            ROUND((COALESCE(SUM(m.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.province_id = p.id
            ), 0)) * 100, 1) AS percentage_manual,

            ROUND((COALESCE(SUM(k.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.province_id = p.id
            ), 0)) * 100, 1) AS percentage_kombinasi
        ', false);

        $this->db->from('provinces p');
        $this->db->join('immunization_data_kejar a', 'a.province_id = p.id AND a.year = ' . (int)$year, 'left');
        $this->db->join('immunization_data_kejar_manual m', 'm.province_id = p.id AND m.year = ' . (int)$year, 'left');
        $this->db->join('immunization_data_kejar_kombinasi k', 'k.province_id = p.id AND k.year = ' . (int)$year, 'left');
        $this->db->group_by('p.id');

        return $this->db->get()->result_array();
    }

    public function get_kejar_group_by_city($province_id, $year)
    {
        $this->db->select('
            c.id AS region_id,
            c.name_id AS name,

            COALESCE(SUM(a.dpt1_coverage), 0) AS kejar_asik,
            COALESCE(SUM(m.dpt1_coverage), 0) AS kejar_manual,
            COALESCE(SUM(k.dpt1_coverage), 0) AS kejar_kombinasi,

            (
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.city_id = c.id
            ) AS zd_total,

            ROUND((COALESCE(SUM(a.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.city_id = c.id
            ), 0)) * 100, 1) AS percentage_asik,

            ROUND((COALESCE(SUM(m.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.city_id = c.id
            ), 0)) * 100, 1) AS percentage_manual,

            ROUND((COALESCE(SUM(k.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.city_id = c.id
            ), 0)) * 100, 1) AS percentage_kombinasi
        ', false);

        $this->db->from('cities c');
        $this->db->join('immunization_data_kejar a', 'a.city_id = c.id AND a.year = ' . (int)$year, 'left');
        $this->db->join('immunization_data_kejar_manual m', 'm.city_id = c.id AND m.year = ' . (int)$year, 'left');
        $this->db->join('immunization_data_kejar_kombinasi k', 'k.city_id = c.id AND k.year = ' . (int)$year, 'left');
        $this->db->where('c.province_id', $province_id);
        $this->db->group_by('c.id');

        return $this->db->get()->result_array();
    }

    public function get_kejar_group_by_puskesmas($province_id, $city_id, $year)
    {
        $this->db->select('
            p.id AS region_id,
            p.name AS name,

            COALESCE(SUM(a.dpt1_coverage), 0) AS kejar_asik,
            COALESCE(SUM(m.dpt1_coverage), 0) AS kejar_manual,
            COALESCE(SUM(k.dpt1_coverage), 0) AS kejar_kombinasi,

            COALESCE(z.zd_cases, 0) AS zd_total,

            ROUND((COALESCE(SUM(a.dpt1_coverage), 0) / NULLIF(z.zd_cases, 0)) * 100, 1) AS percentage_asik,
            ROUND((COALESCE(SUM(m.dpt1_coverage), 0) / NULLIF(z.zd_cases, 0)) * 100, 1) AS percentage_manual,
            ROUND((COALESCE(SUM(k.dpt1_coverage), 0) / NULLIF(z.zd_cases, 0)) * 100, 1) AS percentage_kombinasi
        ');

        $this->db->from('puskesmas p');
        $this->db->join('immunization_data_kejar_per_puskesmas a', 'a.puskesmas_id = p.id AND a.year = ' . (int)$year, 'left');
        $this->db->join('immunization_data_kejar_manual_per_puskesmas m', 'm.puskesmas_id = p.id AND m.year = ' . (int)$year, 'left');
        $this->db->join('immunization_data_kejar_kombinasi_per_puskesmas k', 'k.puskesmas_id = p.id AND k.year = ' . (int)$year, 'left');
        $this->db->join('zd_cases_per_puskesmas z', 'z.puskesmas_id = p.id AND z.year = 2024', 'left');
        $this->db->where('p.province_id', $province_id);
        $this->db->where('p.city_id', $city_id);
        $this->db->group_by('p.id');

        return $this->db->get()->result_array();
    }

    public function get_kejar_group_by_targeted_provinces($year)
    {
        $province_ids = $this->get_targeted_province_ids();
        if (empty($province_ids)) return [];

        $this->db->select('
            p.id AS region_id,
            p.name_id AS name,

            COALESCE(SUM(a.dpt1_coverage), 0) AS kejar_asik,
            COALESCE(SUM(m.dpt1_coverage), 0) AS kejar_manual,
            COALESCE(SUM(k.dpt1_coverage), 0) AS kejar_kombinasi,

            (
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.province_id = p.id
            ) AS zd_total,

            ROUND((COALESCE(SUM(a.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.province_id = p.id
            ), 0)) * 100, 1) AS percentage_asik,

            ROUND((COALESCE(SUM(m.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.province_id = p.id
            ), 0)) * 100, 1) AS percentage_manual,

            ROUND((COALESCE(SUM(k.dpt1_coverage), 0) / NULLIF((
                SELECT SUM(z.zd_cases)
                FROM zd_cases_2023 z
                WHERE z.year = 2024 AND z.province_id = p.id
            ), 0)) * 100, 1) AS percentage_kombinasi
        ', false);

        $this->db->from('provinces p');
        $this->db->join('immunization_data_kejar a', 'a.province_id = p.id AND a.year = ' . (int)$year, 'left');
        $this->db->join('immunization_data_kejar_manual m', 'm.province_id = p.id AND m.year = ' . (int)$year, 'left');
        $this->db->join('immunization_data_kejar_kombinasi k', 'k.province_id = p.id AND k.year = ' . (int)$year, 'left');
        $this->db->where_in('p.id', $province_ids);
        $this->db->group_by('p.id');

        return $this->db->get()->result_array();
    }

    // public function get_province_names()
    // {
    //     return $this->db->select('id, name_id')->from('provinces')->where('active', 1)->get()->result_array();
    // }

    // public function get_cities_name_by_province($province_id)
    // {
    //     return $this->db->select('id, name_id')->from('cities')->where('province_id', $province_id)->where('active', 1)->get()->result_array();
    // }
    
}
?>
