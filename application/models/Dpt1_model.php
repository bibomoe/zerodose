<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpt1_model extends CI_Model {

    // Ambil 10 provinsi dengan priority = 1
    public function get_targeted_provinces() {
        $this->db->select('id, name_id');
        $this->db->from('provinces');
        $this->db->where('priority', 1);
        $this->db->limit(10); // Ambil 10 provinsi saja
        $query = $this->db->get();
        return $query->result_array();
    }

    // Mengambil total DPT1 coverage untuk 10 provinsi priority
    public function get_total_dpt1_coverage($year, $province_id, $city_id) {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select('SUM(dpt_hb_hib_1) AS total_dpt1');
        $this->db->from('immunization_data');
        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun
        // $this->db->where_in('province_id', $province_ids);

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

        $query = $this->db->get();
        return $query->row()->total_dpt1 ?? 0;
    }

    // Mengambil total DPT1 target untuk 10 provinsi priority
    public function get_total_dpt1_target($year, $province_id, $city_id) {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select('SUM(dpt_hb_hib_1_target) AS total_target');
        $this->db->from('target_immunization');
        // $this->db->where_in('province_id', $province_ids);

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

        $this->db->where('target_immunization.year', $year); // Filter berdasarkan tahun
        $query = $this->db->get();
        return $query->row()->total_target ?? 0;
    }

    // Mengambil jumlah distrik dengan coverage (DPT1-DPT3) kurang dari 5% 
    public function get_districts_under_5_percent($year, $province_id) {
        // Mengambil 10 provinsi dengan priority = 1
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id'); // Ambil array ID provinsi
    
        // Query untuk mendapatkan cakupan DPT1, DPT2, DPT3 dan target masing-masing untuk setiap distrik
        $this->db->select("
            cities.province_id,
            COALESCE(SUM(immunization_data.dpt_hb_hib_1), 0) AS dpt1_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_2), 0) AS dpt2_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_3), 0) AS dpt3_coverage,
            COALESCE(target_immunization.dpt_hb_hib_1_target, 0) AS dpt_hb_hib_1_target,
            COALESCE(target_immunization.dpt_hb_hib_2_target, 0) AS dpt_hb_hib_2_target,
            COALESCE(target_immunization.dpt_hb_hib_3_target, 0) AS dpt_hb_hib_3_target
        ");
        $this->db->from('cities');
        $this->db->join('immunization_data', 'immunization_data.city_id = cities.id', 'left');
        $this->db->join('target_immunization', 'target_immunization.city_id = cities.id', 'left');
        // $this->db->where_in('cities.province_id', $province_ids); // Hanya untuk provinsi dengan priority = 1

        // Filter by province if provided
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('cities.province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }

        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun
        $this->db->group_by('cities.id'); // Group by city_id untuk perhitungan tiap kota/distrik
    
        // Ambil hasil query
        $query = $this->db->get();
        $districts = $query->result_array();
    
        // Kumulatif data berdasarkan provinsi
        $dropout_rates = [];
    
        foreach ($districts as $district) {
            // Pastikan tidak membagi dengan 0 dan hitung persentase cakupan DPT-1 dan DPT-3
            $dpt1_coverage = $district['dpt1_coverage'];
            $dpt3_coverage = $district['dpt3_coverage'];
    
            // Menghitung drop-out rate dari DPT-1 ke DPT-3
            $dropout_rate_dpt1_to_dpt3 = 0;
            if ($dpt1_coverage > 0) {
                // Jumlah yang tidak menerima DPT-3
                $not_received_dpt3 = $dpt1_coverage - $dpt3_coverage;
                // Drop-out rate formula: (Jumlah yang tidak menerima DPT-3 / Jumlah yang menerima DPT-1) * 100
                $dropout_rate_dpt1_to_dpt3 = ($not_received_dpt3 / $dpt1_coverage) * 100;
                // echo $dropout_rate_dpt1_to_dpt3.'</br>';
            } else {
                $dropout_rate_dpt1_to_dpt3 = 100;
            }
    
            // Masukkan hanya dropout rate untuk provinsi yang memiliki drop-out rate DPT-1 ke DPT-3 kurang dari 5%
            if ($dropout_rate_dpt1_to_dpt3 < 5) {
                // Jika provinsi sudah ada dalam array, tambahkan ke kumulatif
                if (isset($dropout_rates[$district['province_id']])) {
                    // Menambahkan 1 untuk provinsi yang memiliki dropout rate kurang dari 5%
                    $dropout_rates[$district['province_id']] += 1;
                } else {
                    // Jika provinsi belum ada, tambahkan provinsi dan set nilai awal
                    $dropout_rates[$district['province_id']] = 1;
                }
            } else {
                // Jika provinsi sudah ada dalam array, tambahkan ke kumulatif
                if (isset($dropout_rates[$district['province_id']])) {
                    // Menambahkan 1 untuk provinsi yang memiliki dropout rate kurang dari 5%
                    $dropout_rates[$district['province_id']] += 0;
                } else {
                    // Jika provinsi belum ada, tambahkan provinsi dan set nilai awal
                    $dropout_rates[$district['province_id']] = 0;
                }
            }
        }
    
        return $dropout_rates; // Kembalikan hanya drop-out rate
    }

    public function get_puskesmas_dropout_under_5_percent_per_city($year, $province_id = 'all', $city_id = 'all') {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select("
            puskesmas.city_id,
            puskesmas.id AS puskesmas_id,
            COALESCE(SUM(immunization_data.dpt_hb_hib_1), 0) AS dpt1_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_3), 0) AS dpt3_coverage
        ");
        $this->db->from('puskesmas');
        $this->db->join('immunization_data', 'immunization_data.puskesmas_id = puskesmas.id AND immunization_data.year = ' . $this->db->escape($year), 'left');

        // Filter province_id
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('puskesmas.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('puskesmas.province_id', $province_id);
        }

        // Filter city_id
        if ($city_id !== 'all') {
            $this->db->where('puskesmas.city_id', $city_id);
        }

        // Group by puskesmas id supaya dapat data cakupan per puskesmas
        $this->db->group_by('puskesmas.id');

        $query = $this->db->get();
        $rows = $query->result_array();

        $counts_per_city = [];

        foreach ($rows as $row) {
            $dpt1 = $row['dpt1_coverage'];
            $dpt3 = $row['dpt3_coverage'];
            $city = $row['city_id'];

            if ($dpt1 > 0) {
                $not_received_dpt3 = $dpt1 - $dpt3;
                $dropout_rate = ($not_received_dpt3 / $dpt1) * 100;
            } else {
                $dropout_rate = 100; // Jika DPT1 0 maka dropout dianggap 100%
            }

            if ($dropout_rate < 5) {
                if (!isset($counts_per_city[$city])) {
                    $counts_per_city[$city] = 0;
                }
                $counts_per_city[$city]++;
            } else {
                // Kalau mau bisa juga set city ke 0 dulu biar key tetap ada, tapi opsional
                if (!isset($counts_per_city[$city])) {
                    $counts_per_city[$city] = 0;
                }
            }
        }

        return $counts_per_city;
    }



    // Menghitung dropout rate untuk tiap provinsi
    public function get_dropout_rates_per_province($year, $province_id) {
        // Ambil 10 provinsi dengan priority = 1
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id'); // Ambil array ID provinsi

        // Query untuk mendapatkan cakupan DPT1 dan DPT3 untuk setiap distrik
        $this->db->select("
            cities.province_id,
            COALESCE(SUM(immunization_data.dpt_hb_hib_1), 0) AS dpt1_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_3), 0) AS dpt3_coverage
        ");
        $this->db->from('cities');
        $this->db->join('immunization_data', 'immunization_data.city_id = cities.id', 'left');
        // $this->db->where_in('cities.province_id', $province_ids); // Hanya untuk provinsi dengan priority = 1

        // Filter by province if provided
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('cities.province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }

        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun
        $this->db->group_by('cities.id'); // Group by city_id untuk perhitungan tiap kota/distrik

        // Ambil hasil query
        $query = $this->db->get();
        $districts = $query->result_array();

        // Kumulatif data berdasarkan provinsi
        $dropout_rates_per_province = [];

        foreach ($districts as $district) {
            // Pastikan tidak membagi dengan 0 dan hitung persentase cakupan DPT-1 dan DPT-3
            $dpt1_coverage = $district['dpt1_coverage'];
            $dpt3_coverage = $district['dpt3_coverage'];

            if ($dpt1_coverage > 0) {
                // Jika DPT-3 lebih besar dari DPT-1, tidak ada drop-out
                if ($dpt3_coverage > $dpt1_coverage) {
                    $dropout_rate_dpt1_to_dpt3 = 0;  // Tidak ada drop-out karena cakupan DPT-3 lebih tinggi
                } else {
                    // Jumlah yang tidak menerima DPT-3
                    $not_received_dpt3 = $dpt1_coverage - $dpt3_coverage;
                    // Drop-out rate formula: (Jumlah yang tidak menerima DPT-3 / Jumlah yang menerima DPT-1) * 100
                    $dropout_rate_dpt1_to_dpt3 = ($not_received_dpt3 / $dpt1_coverage) * 100;
                }
            } else {
                // Jika DPT-1 coverage 0, kita anggap dropout rate 100% (karena tidak ada cakupan DPT-1)
                $dropout_rate_dpt1_to_dpt3 = 0;
            }

            // Pastikan dropout rate tidak negatif, jika ya set ke 0
            if ($dropout_rate_dpt1_to_dpt3 < 0) {
                $dropout_rate_dpt1_to_dpt3 = 0;
            }

            // Menambahkan dropout rate untuk provinsi
            if (isset($dropout_rates_per_province[$district['province_id']])) {
                // Menambahkan dropout rate untuk provinsi yang ada
                $dropout_rates_per_province[$district['province_id']]['total'] += $dropout_rate_dpt1_to_dpt3; // Jumlahkan dropout rate
                $dropout_rates_per_province[$district['province_id']]['count'] += 1; // Hitung jumlah distrik
            } else {
                // Jika provinsi belum ada, tambahkan provinsi dan set nilai awal
                $dropout_rates_per_province[$district['province_id']] = [
                    'total' => $dropout_rate_dpt1_to_dpt3,
                    'count' => 1
                ];
            }
        }

        // var_dump($dropout_rates_per_province);
        // exit;

        // Menghitung rata-rata dropout rate untuk setiap provinsi
        foreach ($dropout_rates_per_province as $province_id => $data) {
            // Rata-rata dropout rate per provinsi
            $dropout_rates_per_province[$province_id]['average'] = $data['total'] / $data['count']; 
        }

        // var_dump($dropout_rates_per_province);
        // exit;

        // Kembalikan array dropout rates per provinsi
        return $dropout_rates_per_province;
    }

    public function get_dropout_rates_per_city($year, $province_id = 'all', $city_id = 'all') {
        // Ambil 10 provinsi dengan priority = 1 (jika dibutuhkan)
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id'); // Array ID provinsi

        $this->db->select("
            cities.id AS city_id,
            cities.name_en AS city_name,
            COALESCE(SUM(immunization_data.dpt_hb_hib_1), 0) AS dpt1_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_3), 0) AS dpt3_coverage
        ");
        $this->db->from('cities');
        $this->db->join('immunization_data', 'immunization_data.city_id = cities.id', 'left');

        // Filter provinsi jika diperlukan
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('cities.province_id', $province_ids);
            } else {
                return []; // Tidak ada provinsi targeted
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }

        // Filter kota jika diberikan
        // if ($city_id !== 'all') {
        //     $this->db->where('cities.id', $city_id);
        // }

        $this->db->where('immunization_data.year', $year);
        $this->db->group_by('cities.id');

        $query = $this->db->get();
        $cities = $query->result_array();

        $dropout_rates_per_city = [];

        foreach ($cities as $city) {
            $dpt1_coverage = $city['dpt1_coverage'];
            $dpt3_coverage = $city['dpt3_coverage'];

            if ($dpt1_coverage > 0) {
                if ($dpt3_coverage > $dpt1_coverage) {
                    $dropout_rate = 0;
                } else {
                    $not_received_dpt3 = $dpt1_coverage - $dpt3_coverage;
                    $dropout_rate = ($not_received_dpt3 / $dpt1_coverage) * 100;
                }
            } else {
                $dropout_rate = 0;
            }

            if ($dropout_rate < 0) {
                $dropout_rate = 0;
            }

            // Langsung assign dropout rate sebagai nilai saja
            $dropout_rates_per_city[$city['city_id']] = $dropout_rate;
        }

        return $dropout_rates_per_city;
    }

    // Mengambil total jumlah regencies/cities untuk 10 provinsi priority
    public function get_total_regencies_cities($province_id) {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select('COUNT(DISTINCT id) AS total_cities');
        $this->db->from('cities');
        // $this->db->where_in('province_id', $province_ids);

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

        $query = $this->db->get();
        return $query->row()->total_cities ?? 0;
    }

    // Mengambil total jumlah puskesmas
    public function get_total_puskesmas_in_district($city_id) {
        if ($city_id === 'all') {
            return 0; // Fungsi ini hanya untuk satu distrik
        }
    
        $this->db->select('COUNT(id) AS total_puskesmas');
        $this->db->from('puskesmas');
        $this->db->where('city_id', $city_id);
        $this->db->where('active', 1); // Hanya hitung puskesmas yang aktif (jika perlu)
    
        $query = $this->db->get();
        return $query->row()->total_puskesmas ?? 0;
    }

    public function get_dpt_under_5_percent_cities($province_id) {
        // Query untuk mendapatkan cakupan DPT1, DPT2, DPT3 dan target masing-masing untuk setiap distrik
        $this->db->select("
            cities.province_id,
            COALESCE(SUM(immunization_data.dpt_hb_hib_1), 0) AS dpt1_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_2), 0) AS dpt2_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_3), 0) AS dpt3_coverage,
            COALESCE(target_immunization.dpt_hb_hib_1_target, 0) AS dpt_hb_hib_1_target,
            COALESCE(target_immunization.dpt_hb_hib_2_target, 0) AS dpt_hb_hib_2_target,
            COALESCE(target_immunization.dpt_hb_hib_3_target, 0) AS dpt_hb_hib_3_target
        ");
        $this->db->from('cities');
        $this->db->join('immunization_data', 'immunization_data.city_id = cities.id', 'left');
        $this->db->join('target_immunization', 'target_immunization.city_id = cities.id', 'left');
        // $this->db->where_in('cities.province_id', $province_ids); // Hanya untuk provinsi dengan priority = 1

        // Filter by province if provided
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('cities.province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }

        $this->db->group_by('cities.id'); // Group by city_id untuk perhitungan tiap kota/distrik
        
        // Ambil hasil query
        $query = $this->db->get();
        $districts = $query->result_array();
        
        // Kumulatif data berdasarkan provinsi
        $under_5_percent_provinces = [];
        
        foreach ($districts as $district) {
            // Pastikan tidak membagi dengan 0 dan hitung persentase cakupan
            $dpt1_percentage = ($district['dpt_hb_hib_1_target'] > 0) ? ($district['dpt1_coverage'] / $district['dpt_hb_hib_1_target']) * 100 : 0;
            $dpt2_percentage = ($district['dpt_hb_hib_2_target'] > 0) ? ($district['dpt2_coverage'] / $district['dpt_hb_hib_2_target']) * 100 : 0;
            $dpt3_percentage = ($district['dpt_hb_hib_3_target'] > 0) ? ($district['dpt3_coverage'] / $district['dpt_hb_hib_3_target']) * 100 : 0;
            
            // Memeriksa apakah cakupan DPT1, DPT2, atau DPT3 di bawah 5%
            if ($dpt1_percentage < 5 || $dpt2_percentage < 5 || $dpt3_percentage < 5) {
                // Jika provinsi sudah ada dalam array, tambahkan ke kumulatif
                if (isset($under_5_percent_provinces[$district['province_id']])) {
                    // Tambahkan kota ke kumulatif berdasarkan DPT yang kurang dari 5%
                    $under_5_percent_provinces[$district['province_id']]['dpt1_under_5'] += ($dpt1_percentage < 5) ? 1 : 0;
                    $under_5_percent_provinces[$district['province_id']]['dpt2_under_5'] += ($dpt2_percentage < 5) ? 1 : 0;
                    $under_5_percent_provinces[$district['province_id']]['dpt3_under_5'] += ($dpt3_percentage < 5) ? 1 : 0;
                } else {
                    // Jika provinsi belum ada, tambahkan provinsi dan set nilai awal
                    $under_5_percent_provinces[$district['province_id']] = [
                        'province_id' => $district['province_id'],
                        'dpt1_under_5' => ($dpt1_percentage < 5) ? 1 : 0,
                        'dpt2_under_5' => ($dpt2_percentage < 5) ? 1 : 0,
                        'dpt3_under_5' => ($dpt3_percentage < 5) ? 1 : 0,
                    ];
                }
            }
        }
    
        return $under_5_percent_provinces;
    }

    // menghitung jumlah Puskesmas dalam satu distrik/kabupaten/kota ($city_id) yang memiliki dropout rate DPT1–DPT3 di bawah 5%
    public function get_puskesmas_under_5_percent_in_district($province_id = 'all', $city_id = 'all',$year = 2025) {
        if ($city_id === 'all') {
            return 0; // Fungsi ini hanya untuk satu district
        }
    
        // Mengambil 10 provinsi dengan priority = 1
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id'); // Ambil array ID provinsi
    
        $this->db->select("
            puskesmas.id AS puskesmas_id,
            SUM(immunization_data_per_puskesmas.dpt_hb_hib_1) AS dpt1,
            SUM(immunization_data_per_puskesmas.dpt_hb_hib_3) AS dpt3
        ");
        $this->db->from('puskesmas');
        $this->db->join('immunization_data_per_puskesmas', 'immunization_data_per_puskesmas.puskesmas_id = puskesmas.id', 'left');
        $this->db->where('puskesmas.city_id', $city_id);
        $this->db->where('immunization_data_per_puskesmas.year', $year);
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('puskesmas.province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('puskesmas.province_id', $province_id);
        }
    
        $this->db->group_by('puskesmas.id');
        $query = $this->db->get()->result_array();
    
        $count_under_5 = 0;
    
        foreach ($query as $row) {
            $dpt1 = (int) $row['dpt1'];
            $dpt3 = (int) $row['dpt3'];
    
            if ($dpt1 <= 0) continue;
    
            $dropout_rate = (($dpt1 - $dpt3) / $dpt1) * 100;
            if ($dropout_rate < 5) {
                $count_under_5++;
            }
        }
    
        return $count_under_5;
    }
    
    
    // Mengambil total DPT1 coverage untuk tiap provinsi
    public function get_dpt1_coverage_per_province($province_id, $year) {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        if ($province_id === 'targeted' || $province_id === 'all') {
            $this->db->select('province_id, SUM(dpt_hb_hib_1) AS dpt1_coverage');
        } else {
            $this->db->select('city_id AS province_id, SUM(dpt_hb_hib_1) AS dpt1_coverage');
        }

        // $this->db->select('province_id, SUM(dpt_hb_hib_1) AS dpt1_coverage');
        $this->db->from('immunization_data');
        // $this->db->where_in('province_id', $province_ids);

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

        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun
        // $this->db->group_by('province_id');
        if ($province_id === 'targeted' || $province_id === 'all') {
            $this->db->group_by('province_id');
        } else {
            $this->db->group_by('city_id');
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    // Mengambil total DPT1 target untuk tiap provinsi
    public function get_dpt1_target_per_province($province_id, $year) {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        if ($province_id === 'targeted' || $province_id === 'all') {
            $this->db->select('province_id, SUM(dpt_hb_hib_1_target) AS dpt1_target');
        } else {
            $this->db->select('city_id AS province_id, SUM(dpt_hb_hib_1_target) AS dpt1_target');
        }

        // $this->db->select('province_id, SUM(dpt_hb_hib_1_target) AS dpt1_target');
        $this->db->from('target_immunization');
        // $this->db->where_in('province_id', $province_ids);

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

        $this->db->where('target_immunization.year', $year); // Filter berdasarkan tahun
        // $this->db->group_by('province_id');

        if ($province_id === 'targeted' || $province_id === 'all') {
            $this->db->group_by('province_id');
        } else {
            $this->db->group_by('city_id');
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    // Mengambil total jumlah cities per provinsi
    public function get_total_cities_per_province($province_id) {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select('province_id, COUNT(id) AS total_cities');
        $this->db->from('cities');
        // $this->db->where_in('province_id', $province_ids);

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

        $this->db->group_by('province_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Mengambil total jumlah puskesmas per kabkota
    public function get_total_puskesmas_per_city($province_id = 'all') {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select('city_id, COUNT(id) AS total_puskesmas');
        $this->db->from('puskesmas');
        $this->db->where('active', 1); // Hanya hitung puskesmas yang aktif (jika perlu)

        // Filter berdasarkan province_id
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        // Group by city_id
        $this->db->group_by('city_id');

        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_district_details($province_id, $year, $quarter) {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select("
            cities.name_id AS district_name,
            provinces.name_id AS province_name,
            COALESCE(target_immunization.dpt_hb_hib_1_target, 0) AS target,
            COALESCE(SUM(immunization_data.dpt_hb_hib_1), 0) AS dpt1_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_3), 0) AS dpt3_coverage
        ");
        $this->db->from('cities');
        $this->db->join('provinces', 'provinces.id = cities.province_id', 'left'); // Join ke tabel provinsi
        $this->db->join('immunization_data', 'immunization_data.city_id = cities.id', 'left');
        $this->db->join('target_immunization', 'target_immunization.city_id = cities.id AND target_immunization.year = immunization_data.year', 'left');
        // $this->db->where_in('cities.province_id', $province_ids);

        // Filter by province if provided
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('cities.province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }

        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun
        $this->db->group_by('cities.id'); // Group by agar tidak duplikasi district
    
        $query = $this->db->get();
        $districts = $query->result_array();
    
        // Hitung persentase dan dropout rates
        foreach ($districts as &$district) {
            $total_target = $district['target'];

            // Check if total target is 0, then set the quarter target to 0 as well
            if ($total_target <= 0) {
                $target = 0;

            } else {
                // Calculate based on the quarter if total target is not zero
                if ($quarter == 1) {
                    $target = $total_target / 4; // Quarter 1: 1/4 of total target
                } elseif ($quarter == 2) {
                    $target = 2 * $total_target / 4; // Quarter 2: 2/4 of total target
                } elseif ($quarter == 3) {
                    $target = 3 * $total_target / 4; // Quarter 3: 3/4 of total target
                } elseif ($quarter == 4) {
                    $target = $total_target; // Quarter 4: Full total target
                }
            }
            
            $dpt1_coverage = $district['dpt1_coverage'];
            $dpt3_coverage = $district['dpt3_coverage'];

            $district['target'] = $target;

            // % of DPT1 Coverage
            $district['percent_dpt1_coverage'] = ($target > 0) ? round(($dpt1_coverage / $target) * 100, 2) : 0;

            // Number of Dropout
            $district['dropout_number'] = max(0, $dpt1_coverage - $dpt3_coverage);

            // **Perbaikan Drop Out Rate**
            if ($dpt1_coverage == 0) {
                // Jika DPT1 Coverage = 0, Drop Out Rate harus 100%
                $district['dropout_rate'] = 100;
            } else {
                // Perhitungan normal jika DPT1 Coverage > 0
                $district['dropout_rate'] = round(($district['dropout_number'] / $dpt1_coverage) * 100, 2);
            }
        }

        // Urutkan array $districts berdasarkan dropout_rate secara menurun
        usort($districts, function ($a, $b) {
            return $b['dropout_rate'] - $a['dropout_rate']; // Urutkan secara menurun
        });
    
        return $districts;
    }
    
    public function get_puskesmas_details($province_id, $city_id, $year, $quarter) {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        // Select data from puskesmas, including immunization data and targets
        $this->db->select("
            puskesmas.name AS puskesmas_name,
            provinces.name_id AS province_name,
            COALESCE(target_immunization_per_puskesmas.dpt_hb_hib_1_target, 0) AS target,
            COALESCE(SUM(immunization_data_per_puskesmas.dpt_hb_hib_1), 0) AS dpt1_coverage,
            COALESCE(SUM(immunization_data_per_puskesmas.dpt_hb_hib_3), 0) AS dpt3_coverage
        ");
        $this->db->from('puskesmas');
        $this->db->join('provinces', 'provinces.id = puskesmas.province_id', 'left'); // Join to provinces table
        $this->db->join('immunization_data_per_puskesmas', 'immunization_data_per_puskesmas.puskesmas_id = puskesmas.id', 'left'); // Join to immunization data
        $this->db->join('target_immunization_per_puskesmas', 'target_immunization_per_puskesmas.puskesmas_id = puskesmas.id AND target_immunization_per_puskesmas.year = immunization_data_per_puskesmas.year', 'left'); // Join to target immunization table
        // Filter by province if provided
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('puskesmas.province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('puskesmas.province_id', $province_id);
        }

        if ($city_id !== 'all') {
            $this->db->where('puskesmas.city_id', $city_id);
        }

        $this->db->where('immunization_data_per_puskesmas.year', $year); // Filter by year
        $this->db->group_by('puskesmas.id'); // Group by to avoid duplicate puskesmas entries

        // Execute query
        $query = $this->db->get();
        $puskesmas = $query->result_array();

        // Calculate the percentages and dropout rates
        foreach ($puskesmas as &$puskesmas_data) {
            $total_target = $puskesmas_data['target'];

            // Calculate target based on the quarter
            if ($total_target <= 0) {
                $target = 0;
            } else {
                // Calculate based on quarter
                if ($quarter == 1) {
                    $target = $total_target / 4; // Quarter 1: 1/4 of total target
                } elseif ($quarter == 2) {
                    $target = 2 * $total_target / 4; // Quarter 2: 2/4 of total target
                } elseif ($quarter == 3) {
                    $target = 3 * $total_target / 4; // Quarter 3: 3/4 of total target
                } elseif ($quarter == 4) {
                    $target = $total_target; // Quarter 4: Full total target
                }
            }

            $dpt1_coverage = $puskesmas_data['dpt1_coverage'];
            $dpt3_coverage = $puskesmas_data['dpt3_coverage'];

            $puskesmas_data['target'] = $target;

            // Calculate DPT1 Coverage percentage
            $puskesmas_data['percent_dpt1_coverage'] = ($target > 0) ? round(($dpt1_coverage / $target) * 100, 2) : 0;

            // Calculate number of Dropout
            $puskesmas_data['dropout_number'] = max(0, $dpt1_coverage - $dpt3_coverage);

            // Calculate Dropout Rate
            if ($dpt1_coverage == 0) {
                // If DPT1 Coverage is 0, Drop Out Rate should be 100%
                $puskesmas_data['dropout_rate'] = 100;
            } else {
                // Normal calculation if DPT1 Coverage > 0
                $puskesmas_data['dropout_rate'] = round(($puskesmas_data['dropout_number'] / $dpt1_coverage) * 100, 2);
            }
        }

        // Sort the array based on dropout_rate in descending order
        usort($puskesmas, function ($a, $b) {
            return $b['dropout_rate'] - $a['dropout_rate']; // Sort in descending order
        });

        return $puskesmas;
    }


}
