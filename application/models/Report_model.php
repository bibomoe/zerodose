<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    /**
     * Fungsi untuk mendapatkan nama provinsi berdasarkan ID
     * @param int $province_id
     * @return string $province_name
     */
    public function get_province_name_by_id($province_id) {
        // Query untuk mendapatkan nama provinsi berdasarkan ID
        $this->db->select('name_id'); // Field name_id untuk nama provinsi dalam bahasa Indonesia
        $this->db->from('provinces'); // Nama tabel provinsi
        $this->db->where('id', $province_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->name_id; // Mengembalikan nama provinsi dalam bahasa Indonesia
        } else {
            return null; // Jika provinsi tidak ditemukan
        }
    }

    /**
     * Fungsi untuk mendapatkan nama kabupaten/kota berdasarkan ID
     * @param int $district_id
     * @return string $district_name
     */
    public function get_district_name_by_id($district_id) {
        // Query untuk mendapatkan nama kabupaten/kota berdasarkan ID
        $this->db->select('name_id'); // Field name_id untuk nama kabupaten/kota dalam bahasa Indonesia
        $this->db->from('cities'); // Nama tabel kota
        $this->db->where('id', $district_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->name_id; // Mengembalikan nama kabupaten/kota dalam bahasa Indonesia
        } else {
            return null; // Jika kabupaten/kota tidak ditemukan
        }
    }

    public function get_targeted_province_ids() {
        $query = $this->db->select('id')
                            ->from('provinces')
                            ->where('priority', 1)
                            ->get();
    
        return array_column($query->result_array(), 'id'); // Return array ID
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
    public function get_total_vaccine($vaccine_column, $province_id, $city_id, $year, $month) {
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

        // Menambahkan kondisi untuk filter bulan
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }
    
        $query = $this->db->get()->row();

        // var_dump($query);
        // exit;
        return $query->total ?? 0;
    }

    // Tabel 2

    // Mengambil jumlah distrik dengan coverage (DPT1-DPT3) kurang dari 5% 
    public function get_districts_under_5_percent($province_id = 'all', $city_id = 'all',$year = 2025, $month = 12) {
        $province_ids = $this->get_targeted_province_ids();
    
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
        
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('cities.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }

        if ($city_id !== 'all') {
            $this->db->where('cities.id', $city_id);
        } 

        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun

        // Menambahkan kondisi untuk filter bulan
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('immunization_data.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }

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

        // var_dump($dropout_rates);
        // exit;

        
    
        return $dropout_rates; // Kembalikan hanya drop-out rate
    }

    // Mengambil total jumlah regencies/cities untuk 10 provinsi priority
    public function get_total_regencies_cities($province_id) {
        $province_ids = $this->get_targeted_province_ids();

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

    public function get_districts_under_5_percent_by_province($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        $province_ids = $this->get_targeted_province_ids();
        
        // Query untuk mendapatkan cakupan DPT1, DPT2, DPT3 dan target masing-masing untuk setiap distrik
        $this->db->select("
            cities.province_id,
            cities.id AS city_id,
            cities.name_id AS city_name,
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
        
        // Kondisi untuk filter provinsi atau kota
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('cities.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }
    
        if ($city_id !== 'all') {
            $this->db->where('cities.id', $city_id);
        } 
    
        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun
    
        // Menambahkan kondisi untuk filter bulan
        if ($month !== 'all') {
            $this->db->where('immunization_data.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }
    
        $this->db->group_by('cities.id'); // Group by city_id untuk perhitungan tiap kota/distrik
        
        // Ambil hasil query
        $query = $this->db->get();
        $districts = $query->result_array();
    
        // Kumulatif data berdasarkan provinsi atau per kota
        $dropout_rates = [];
    
        if ($province_id === 'all' || $province_id === 'targeted') {
            // Kondisi ketika provinsi adalah 'all' atau 'targeted' (kumulatif per provinsi)
            foreach ($districts as $district) {
                $dpt1_coverage = $district['dpt1_coverage'];
                $dpt3_coverage = $district['dpt3_coverage'];
    
                $dropout_rate_dpt1_to_dpt3 = 0;
                if ($dpt1_coverage > 0) {
                    $not_received_dpt3 = $dpt1_coverage - $dpt3_coverage;
                    $dropout_rate_dpt1_to_dpt3 = ($not_received_dpt3 / $dpt1_coverage) * 100;
                } else {
                    $dropout_rate_dpt1_to_dpt3 = 100;
                }
    
                // Masukkan hanya dropout rate untuk provinsi yang memiliki drop-out rate DPT-1 ke DPT-3 kurang dari 5%
                if ($dropout_rate_dpt1_to_dpt3 < 5) {
                    if (isset($dropout_rates[$district['province_id']])) {
                        $dropout_rates[$district['province_id']] += 1;
                    } else {
                        $dropout_rates[$district['province_id']] = 1;
                    }
                } else {
                    if (isset($dropout_rates[$district['province_id']])) {
                        $dropout_rates[$district['province_id']] += 0;
                    } else {
                        $dropout_rates[$district['province_id']] = 0;
                    }
                }
            }
        } else {
            // Kondisi ketika provinsi adalah selain 'all' atau 'targeted' (per kota)
            foreach ($districts as $district) {
                $dpt1_coverage = $district['dpt1_coverage'];
                $dpt3_coverage = $district['dpt3_coverage'];
                $city_name = $district['city_name'];
    
                $dropout_rate_dpt1_to_dpt3 = 0;
                if ($dpt1_coverage > 0) {
                    $not_received_dpt3 = $dpt1_coverage - $dpt3_coverage;
                    $dropout_rate_dpt1_to_dpt3 = ($not_received_dpt3 / $dpt1_coverage) * 100;
                } else {
                    $not_received_dpt3 = 0;
                    $dropout_rate_dpt1_to_dpt3 = 100;
                }
    
                // Menambahkan hasil untuk tiap distrik
                $dropout_rates[$district['city_id']] = [
                    'city_name' => $city_name,
                    'dpt1_coverage' => $dpt1_coverage,
                    'dpt3_coverage' => $dpt3_coverage,
                    'total_do' => $not_received_dpt3,
                    'dropout_rate' => $dropout_rate_dpt1_to_dpt3
                ];
            }
        }

    
        return $dropout_rates; // Kembalikan data dropout rates sesuai kondisi
    }

    public function get_districts_under_5_percent_by_district($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        
        // Query untuk mendapatkan cakupan DPT1, DPT2, DPT3 dan target masing-masing untuk setiap distrik
        $this->db->select("
            puskesmas.id AS puskesmas_id,
            puskesmas.name AS puskesmas_name,
            COALESCE(immunization_data.dpt_hb_hib_1, 0) AS dpt1_coverage,
            COALESCE(immunization_data.dpt_hb_hib_3, 0) AS dpt3_coverage
        ");
        $this->db->from('puskesmas');
        $this->db->join('immunization_data', 'immunization_data.puskesmas_id = puskesmas.id', 'left');
        
        // Kondisi untuk filter provinsi atau kota
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('puskesmas.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('puskesmas.province_id', $province_id);
        }
    
        if ($city_id !== 'all') {
            $this->db->where('puskesmas.city_id', $city_id);
        } 
    
        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun
    
        // Menambahkan kondisi untuk filter bulan
        if ($month !== 'all') {
            $this->db->where('immunization_data.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }
    
        // $this->db->group_by('cities.id'); // Group by city_id untuk perhitungan tiap kota/distrik
        
        // Ambil hasil query
        $query = $this->db->get();
        $districts = $query->result_array();
    
        // Kumulatif data berdasarkan provinsi atau per kota
        $dropout_rates = [];
    
            // Kondisi ketika provinsi adalah selain 'all' atau 'targeted' (per kota)
            foreach ($districts as $district) {
                $dpt1_coverage = $district['dpt1_coverage'];
                $dpt3_coverage = $district['dpt3_coverage'];
                $puskesmas_name = $district['puskesmas_name'];
    
                $dropout_rate_dpt1_to_dpt3 = 0;
                if ($dpt1_coverage > 0) {
                    $not_received_dpt3 = $dpt1_coverage - $dpt3_coverage;
                    $dropout_rate_dpt1_to_dpt3 = ($not_received_dpt3 / $dpt1_coverage) * 100;
                } else {
                    $not_received_dpt3 = 0;
                    $dropout_rate_dpt1_to_dpt3 = 100;
                }
    
                // Menambahkan hasil untuk tiap distrik
                $dropout_rates[$district['puskesmas_id']] = [
                    'puskesmas_name' => $puskesmas_name,
                    'dpt1_coverage' => $dpt1_coverage,
                    'dpt3_coverage' => $dpt3_coverage,
                    'total_do' => $not_received_dpt3,
                    'dropout_rate' => $dropout_rate_dpt1_to_dpt3
                ];
            }
    
        return $dropout_rates; // Kembalikan data dropout rates sesuai kondisi
    }
    

    // Menghitung dropout rate untuk tiap provinsi
    public function get_dropout_rates_per_province($province_id = 'all', $city_id = 'all',$year = 2025, $month = 12) {
        $province_ids = $this->get_targeted_province_ids();

        // Query untuk mendapatkan cakupan DPT1 dan DPT3 untuk setiap distrik
        $this->db->select("
            cities.province_id,
            COALESCE(SUM(immunization_data.dpt_hb_hib_1), 0) AS dpt1_coverage,
            COALESCE(SUM(immunization_data.dpt_hb_hib_3), 0) AS dpt3_coverage
        ");
        $this->db->from('cities');
        $this->db->join('immunization_data', 'immunization_data.city_id = cities.id', 'left');
        // $this->db->where_in('cities.province_id', $province_ids); // Hanya untuk provinsi dengan priority = 1

        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('cities.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }

        if ($city_id !== 'all') {
            $this->db->where('cities.id', $city_id);
        } 

        $this->db->where('immunization_data.year', $year); // Filter berdasarkan tahun

        // Menambahkan kondisi untuk filter bulan
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('immunization_data.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }

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

    public function get_puskesmas_data($province_id, $district_id, $year, $month = 12) {
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

        // Menambahkan kondisi untuk filter bulan
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }
    
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

    // ✅ Fungsi untuk card (Mengambil total data untuk semua 10 targeted provinces)
    public function get_supportive_supervision_targeted_summary($province_id, $district_id, $year, $month = 12) {
        // $province_ids = $this->get_targeted_province_ids();
        $province_ids = $this->get_targeted_province_ids(); // Ambil daftar targeted provinces

        $this->db->select('SUM(ss.good_category_puskesmas) AS total_good_puskesmas, SUM(ss.total_ss) AS total_ss', false);
        $this->db->from('supportive_supervision ss');
        $this->db->where('ss.year', $year);
        
        // if (!empty($province_ids)) {
        //     $this->db->where_in('ss.province_id', $province_ids);
        // }

        // Menambahkan kondisi untuk filter bulan
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('ss.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }

        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('ss.province_id', $province_ids);
            } else {
                return ['total_puskesmas' => 0, 'total_good_puskesmas' => 0, 'percentage_good' => 0, 'total_ss' => 0];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('ss.province_id', $province_id);
        }
    
        if ($district_id !== 'all') {
            $this->db->where('ss.city_id', $district_id);
        }

        $query = $this->db->get()->row();
        $total_good_puskesmas = $query->total_good_puskesmas ?? 0;
        $total_ss = $query->total_ss ?? 0;

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
    
        if ($district_id !== 'all') {
            $this->db->where('city_id', $district_id);
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

    
    public function get_total_dpt_stock_out($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        $province_ids = $this->get_targeted_province_ids();
        $this->db->select('
            SUM(stock_out_1_month) + 
            SUM(stock_out_2_months) + 
            SUM(stock_out_3_months) + 
            SUM(stock_out_more_than_3_months) AS total_stock_out', false);
        $this->db->from('stock_out_data');
        $this->db->where('vaccine_type', 'DPT'); // Hanya untuk DPT
        $this->db->where('year', $year);
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }


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
    
        $query = $this->db->get();
        return $query->row()->total_stock_out ?? 0;
    }

    public function get_stockout_summary($province_id, $district_id, $year, $month = 12) {
        $province_ids = $this->get_targeted_province_ids(); // Targeted provinces
    
        // ================================
        // Ambil total Puskesmas yang stockout (distinct)
        // ================================
        $this->db->distinct();
        $this->db->select('puskesmas_id');
        $this->db->from('puskesmas_stock_out_details');
        $this->db->where('year', $year);
        $this->db->where('status_stockout', 1);
        
        if ($month !== 'all') {
            $this->db->where('month <=', $month);
        }
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return ['total_stockout' => 0, 'total_puskesmas' => 0, 'percentage_stockout' => 0];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        if ($district_id !== 'all') {
            $this->db->where('city_id', $district_id);
        }
    
        $total_stockout = $this->db->get()->num_rows(); // Puskesmas unik dengan stockout
    
        // ================================
        // Ambil total puskesmas yang aktif
        // ================================
        $this->db->select('COUNT(id) AS total_puskesmas');
        $this->db->from('puskesmas');
    
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('province_id', $province_ids);
            } else {
                return ['total_stockout' => 0, 'total_puskesmas' => 0, 'percentage_stockout' => 0];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        if ($district_id !== 'all') {
            $this->db->where('city_id', $district_id);
        }
    
        $total_puskesmas = $this->db->get()->row()->total_puskesmas ?? 0;
    
        // ================================
        // Hitung persentase
        // ================================
        $percentage_stockout = ($total_puskesmas > 0)
            ? round(($total_stockout / $total_puskesmas) * 100, 2)
            : 0;
    
        // ================================
        // Return hasil
        // ================================
        return [
            'total_stockout' => $total_stockout,
            'total_puskesmas' => $total_puskesmas,
            'percentage_stockout' => $percentage_stockout
        ];
    }
    

    // Tabel 3
    // Mengambil total jumlah cities per provinsi
    public function get_total_cities_per_province($province_id = 'all', $city_id = 'all') {
        $province_ids = $this->get_targeted_province_ids();
        $this->db->select('province_id, COUNT(id) AS total_cities');
        $this->db->from('cities');
        // $this->db->where_in('province_id', $province_ids);
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
            $this->db->where('id', $city_id);
        } 

        $this->db->group_by('province_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Fungsi untuk mendapatkan id, name_id, name_en dari tabel provinces
    public function get_provinces() {
        // Memilih kolom yang dibutuhkan
        $this->db->select('id, name_id, name_en');
        
        // Dari tabel 'provinces'
        $this->db->from('provinces');
        
        // // Jika parameter 'active' diberikan (default = 1), tambahkan kondisi filter
        // if ($active !== null) {
            $this->db->where('active', 1);
        // }

        // Menjalankan query
        $query = $this->db->get();
        
        // Mengembalikan hasil query sebagai array
        return $query->result_array();
    }

    // ✅ Ambil data supportive supervision hanya untuk 10 targeted provinces
    public function get_supportive_supervision_targeted_table($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        $province_ids = $this->get_targeted_province_ids();

        $this->db->select("
            p.id AS province_id,
            p.name_id AS province_name,
            c.id AS city_id,
            c.name_id AS city_name,
            (SELECT COUNT(id) FROM puskesmas WHERE city_id = ss.city_id) AS total_puskesmas, 
            SUM(ss.good_category_puskesmas) AS good_category_puskesmas
        ");
        $this->db->from('supportive_supervision ss');
        $this->db->join('cities c', 'ss.city_id = c.id', 'left');
        $this->db->join('provinces p', 'ss.province_id = p.id', 'left');

        // ✅ Filter hanya untuk 10 targeted provinces
        // $this->db->where_in('ss.province_id', $targeted_provinces);

        // $this->db->where_in('province_id', $province_ids);
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('ss.province_id', $province_ids);
            } else {
                return [];
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('ss.province_id', $province_id);
        }

        if ($city_id !== 'all') {
            $this->db->where('ss.city_id', $city_id);
        } 
        
        // ✅ Filter berdasarkan tahun
        $this->db->where('ss.year', $year);

        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('ss.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }



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

    public function get_immunization_puskesmas_table($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        // Mengambil daftar province yang ditargetkan (bisa menggunakan function get_targeted_province_ids)
        $province_ids = $this->get_targeted_province_ids();
    
        // Mengambil data dari tabel-tabel yang dibutuhkan
        $this->db->select("
            p.id AS province_id,
            p.name_id AS province_name,
            COUNT(DISTINCT pd.id) AS total_puskesmas_with_immunization,  -- Jumlah Puskesmas yang melakukan imunisasi
            (SELECT COUNT(id) FROM puskesmas WHERE province_id = p.id AND active = 1) AS total_puskesmas  -- Jumlah total Puskesmas aktif di provinsi
        ");
        $this->db->from('immunization_data id');
        $this->db->join('puskesmas pd', 'id.puskesmas_id = pd.id', 'left');  // Gabungkan dengan tabel puskesmas
        $this->db->join('provinces p', 'id.province_id = p.id', 'left');  // Gabungkan dengan tabel provinces
    
        // Filter berdasarkan provinsi yang ditargetkan
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('id.province_id', $province_ids);
            } else {
                return []; // Jika tidak ada province yang ditargetkan, kembalikan array kosong
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('id.province_id', $province_id);
        }
    
        // Filter berdasarkan kota jika diberikan
        if ($city_id !== 'all') {
            $this->db->where('id.city_id', $city_id);
        }
    
        // Filter berdasarkan tahun
        $this->db->where('id.year', $year);
    
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('id.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }
    
        // Kelompokkan hasil berdasarkan provinsi
        $this->db->group_by('id.province_id');
        // $this->db->order_by('p.name_id');
    
        // Ambil hasil query
        $query = $this->db->get()->result_array();
    
        // Proses untuk menghitung persentase
        foreach ($query as &$row) {
            $total_puskesmas = (int) $row['total_puskesmas'];
            $puskesmas_with_immunization = (int) $row['total_puskesmas_with_immunization'];
            
            // Hitung persentase Puskesmas yang sudah melakukan imunisasi
            $row['percentage_immunization'] = ($total_puskesmas > 0) 
                ? round(($puskesmas_with_immunization / $total_puskesmas) * 100, 2) 
                : 0;
        }
    
        // Kembalikan hasil query
        return $query;
    }

    public function get_immunization_puskesmas_table_by_province($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        // Mengambil daftar province yang ditargetkan (bisa menggunakan function get_targeted_province_ids)
        $province_ids = $this->get_targeted_province_ids();
    
        // Mengambil data dari tabel-tabel yang dibutuhkan
        $this->db->select("
            p.id AS province_id,
            p.name_id AS province_name,
            c.id as city_id,
            c.name_id AS city_name,
            COUNT(DISTINCT pd.id) AS total_puskesmas_with_immunization,  -- Jumlah Puskesmas yang melakukan imunisasi
            (SELECT COUNT(id) FROM puskesmas WHERE city_id = c.id ) AS total_puskesmas  -- Jumlah total Puskesmas aktif di provinsi
        ");
        $this->db->from('immunization_data id');
        $this->db->join('puskesmas pd', 'id.puskesmas_id = pd.id', 'left');  // Gabungkan dengan tabel puskesmas
        $this->db->join('provinces p', 'id.province_id = p.id', 'left');  // Gabungkan dengan tabel provinces
        $this->db->join('cities c', 'id.city_id = c.id', 'left');

        // Filter berdasarkan provinsi yang ditargetkan
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('id.province_id', $province_ids);
            } else {
                return []; // Jika tidak ada province yang ditargetkan, kembalikan array kosong
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('id.province_id', $province_id);
        }
    
        // Filter berdasarkan kota jika diberikan
        if ($city_id !== 'all') {
            $this->db->where('id.city_id', $city_id);
        }
    
        // Filter berdasarkan tahun
        $this->db->where('id.year', $year);
    
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('id.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }
    
        // Kelompokkan hasil berdasarkan provinsi
        // $this->db->group_by('id.province_id');
        $this->db->group_by('id.city_id');
        // $this->db->order_by('p.name_id');
    
        // Ambil hasil query
        $query = $this->db->get()->result_array();
    
        // Proses untuk menghitung persentase
        foreach ($query as &$row) {
            $total_puskesmas = (int) $row['total_puskesmas'];
            $puskesmas_with_immunization = (int) $row['total_puskesmas_with_immunization'];
            
            // Hitung persentase Puskesmas yang sudah melakukan imunisasi
            $row['percentage_immunization'] = ($total_puskesmas > 0) 
                ? round(($puskesmas_with_immunization / $total_puskesmas) * 100, 2) 
                : 0;
        }
        
        // var_dump($query);
        // exit;
    
        // Kembalikan hasil query
        return $query;
    }

    public function get_immunization_puskesmas_table_by_district($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        // Mengambil daftar province yang ditargetkan (bisa menggunakan function get_targeted_province_ids)
        $province_ids = $this->get_targeted_province_ids();
    
        // Mengambil data dari tabel-tabel yang dibutuhkan
        $this->db->select("
            pd.id AS puskesmas_id,
            pd.name AS puskesmas_name
        ");
        $this->db->from('immunization_data id');
        $this->db->join('puskesmas pd', 'id.puskesmas_id = pd.id', 'left');  // Gabungkan dengan tabel puskesmas
        

        // Filter berdasarkan provinsi yang ditargetkan
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('id.province_id', $province_ids);
            } else {
                return []; // Jika tidak ada province yang ditargetkan, kembalikan array kosong
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('id.province_id', $province_id);
        }
    
        // Filter berdasarkan kota jika diberikan
        if ($city_id !== 'all') {
            $this->db->where('id.city_id', $city_id);
        }
    
        // Filter berdasarkan tahun
        $this->db->where('id.year', $year);
    
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('id.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }

        $this->db->group_by('id.puskesmas_id');
        // $this->db->order_by('p.name_id');
    
        // Ambil hasil query
        $query = $this->db->get()->result_array();
        
        // var_dump($query);
        // exit;
    
        // Kembalikan hasil query
        return $query;
    }
    
    public function get_puskesmas_dpt_stock_out_table($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        // Mengambil daftar province yang ditargetkan (bisa menggunakan function get_targeted_province_ids)
        $province_ids = $this->get_targeted_province_ids();
    
        // Mengambil data dari tabel stock_out_data yang berkaitan dengan DPT
        $this->db->select("
            p.id AS province_id,
            p.name_id AS province_name,
            SUM(sod.stock_out_1_month) AS total_stock_out_1_month,  -- Jumlah Puskesmas yang mengalami stock out 1 bulan
            SUM(sod.stock_out_2_months) AS total_stock_out_2_months,  -- Jumlah Puskesmas yang mengalami stock out 2 bulan
            SUM(sod.stock_out_3_months) AS total_stock_out_3_months,  -- Jumlah Puskesmas yang mengalami stock out 3 bulan
            SUM(sod.stock_out_more_than_3_months) AS total_stock_out_more_than_3_months,  -- Jumlah Puskesmas yang mengalami stock out lebih dari 3 bulan
            (SELECT COUNT(id) FROM puskesmas WHERE province_id = p.id AND active = 1) AS total_puskesmas  -- Jumlah total Puskesmas aktif di provinsi
        ");
        $this->db->from('stock_out_data sod');
        $this->db->join('provinces p', 'sod.province_id = p.id', 'left');  // Gabungkan dengan tabel provinces
    
        // Filter berdasarkan provinsi yang ditargetkan
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('sod.province_id', $province_ids);
            } else {
                return []; // Jika tidak ada province yang ditargetkan, kembalikan array kosong
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('sod.province_id', $province_id);
        }
    
        // Filter berdasarkan kota jika diberikan
        if ($city_id !== 'all') {
            $this->db->where('sod.city_id', $city_id);
        }
    
        // Filter berdasarkan tahun
        $this->db->where('sod.year', $year);
    
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('sod.month =', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }
    
        // Kelompokkan hasil berdasarkan provinsi
        $this->db->group_by('sod.province_id');
        // $this->db->order_by('p.name_id');
    
        // Ambil hasil query
        $query = $this->db->get()->result_array();

        // var_dump($query);
        // exit;
    
        // Proses untuk menghitung persentase
        foreach ($query as &$row) {
            $total_puskesmas = (int) $row['total_puskesmas'];
            $total_stock_out = (int) $row['total_stock_out_1_month'] + (int) $row['total_stock_out_2_months'] + (int) $row['total_stock_out_3_months'] + (int) $row['total_stock_out_more_than_3_months'];
    
            // Hitung persentase Puskesmas yang mengalami DPT stock out
            $row['percentage_stock_out'] = ($total_puskesmas > 0) 
                ? round(($total_stock_out / $total_puskesmas) * 100, 2) 
                : 0;
        }
    
        // Kembalikan hasil query
        return $query;
    }

    public function get_puskesmas_dpt_stock_out_table_by_province($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        // Mengambil daftar province yang ditargetkan (bisa menggunakan function get_targeted_province_ids)
        $province_ids = $this->get_targeted_province_ids();
    
        // Mengambil data dari tabel stock_out_data yang berkaitan dengan DPT
        $this->db->select("
            p.id AS province_id,
            p.name_id AS province_name,
            c.id as city_id,
            c.name_id AS city_name,
            SUM(sod.stock_out_1_month) AS total_stock_out_1_month,  -- Jumlah Puskesmas yang mengalami stock out 1 bulan
            SUM(sod.stock_out_2_months) AS total_stock_out_2_months,  -- Jumlah Puskesmas yang mengalami stock out 2 bulan
            SUM(sod.stock_out_3_months) AS total_stock_out_3_months,  -- Jumlah Puskesmas yang mengalami stock out 3 bulan
            SUM(sod.stock_out_more_than_3_months) AS total_stock_out_more_than_3_months,  -- Jumlah Puskesmas yang mengalami stock out lebih dari 3 bulan
            (SELECT COUNT(id) FROM puskesmas WHERE city_id = c.id) AS total_puskesmas  -- Jumlah total Puskesmas aktif di provinsi
        ");
        $this->db->from('stock_out_data sod');
        $this->db->join('provinces p', 'sod.province_id = p.id', 'left');  // Gabungkan dengan tabel provinces
        $this->db->join('cities c', 'sod.city_id = c.id', 'left');

        // Filter berdasarkan provinsi yang ditargetkan
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('sod.province_id', $province_ids);
            } else {
                return []; // Jika tidak ada province yang ditargetkan, kembalikan array kosong
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('sod.province_id', $province_id);
        }
    
        // Filter berdasarkan kota jika diberikan
        if ($city_id !== 'all') {
            $this->db->where('sod.city_id', $city_id);
        }
    
        // Filter berdasarkan tahun
        $this->db->where('sod.year', $year);
    
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('sod.month =', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }
    
        // Kelompokkan hasil berdasarkan provinsi
        // $this->db->group_by('sod.province_id');
        $this->db->group_by('sod.city_id');
        // $this->db->order_by('p.name_id');
    
        // Ambil hasil query
        $query = $this->db->get()->result_array();

        
    
        // Proses untuk menghitung persentase
        foreach ($query as &$row) {
            $total_puskesmas = (int) $row['total_puskesmas'];
            $total_stock_out = (int) $row['total_stock_out_1_month'] + (int) $row['total_stock_out_2_months'] + (int) $row['total_stock_out_3_months'] + (int) $row['total_stock_out_more_than_3_months'];
    
            // Hitung persentase Puskesmas yang mengalami DPT stock out
            $row['percentage_stock_out'] = ($total_puskesmas > 0) 
                ? round(($total_stock_out / $total_puskesmas) * 100, 2) 
                : 0;
        }

        // var_dump($query);
        // exit;
    
        // Kembalikan hasil query
        return $query;
    }

    public function get_puskesmas_dpt_stock_out_table_by_district($province_id = 'all', $city_id = 'all', $year = 2025, $month = 12) {
        // Mengambil daftar province yang ditargetkan (bisa menggunakan function get_targeted_province_ids)
        $province_ids = $this->get_targeted_province_ids();
    
        // Mengambil data dari tabel stock_out_data yang berkaitan dengan DPT
        $this->db->select("
            sod.puskesmas_id AS puskesmas_id,
            pd.name AS puskesmas_name,
            sod.month AS month,
            sod.total_dpt_stock AS stock
        ");
        $this->db->from('puskesmas_stock_out_details sod');
        $this->db->join('provinces p', 'sod.province_id = p.id', 'left');  // Gabungkan dengan tabel provinces
        $this->db->join('cities c', 'sod.city_id = c.id', 'left');
        $this->db->join('puskesmas pd', 'sod.puskesmas_id = pd.id', 'left');

        // Filter berdasarkan provinsi yang ditargetkan
        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('sod.province_id', $province_ids);
            } else {
                return []; // Jika tidak ada province yang ditargetkan, kembalikan array kosong
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('sod.province_id', $province_id);
        }
    
        // Filter berdasarkan kota jika diberikan
        if ($city_id !== 'all') {
            $this->db->where('sod.city_id', $city_id);
        }
    
        // Filter berdasarkan tahun
        $this->db->where('sod.year', $year);
    
        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('sod.month =', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
        }

        $this->db->where('sod.total_dpt_stock =', 0);

        // $this->db->group_by('sod.puskesmas_id');
        $this->db->order_by('sod.month');
        // Ambil hasil query
        $query = $this->db->get()->result_array();

        // var_dump($query);
        // exit;
    
        // Kembalikan hasil query
        return $query;
    }

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
    public function get_total_budget_absorption_percentage($year, $month, $partner_id = null) {
        $data = $this->get_cumulative_budget_absorption_with_percentage($year, $partner_id);

        if ($month === 12 || $month ==='all'){
            $index_month = 11;
        } else {
            $month = (int)$month;
            $index_month = $month - 1;
        }
        // var_dump($data[0]);
        // exit;
        // Ambil data bulan terakhir (Desember)
        return $data[$index_month]['percentage'] ?? 0;
    }

    /**
     * Mengambil semua country objectives
     */
    public function get_all_objectives() {
        // if($this->session->userdata('language') == 'id'){
            $this->db->select('id, objective_name_id as objective_name');
        // } else {
        //     $this->db->select('id, objective_name');
        // }
        

        $this->db->from('country_objectives');
        return $this->db->get()->result_array();
    }

    /**
     * Mengambil jumlah aktivitas yang sudah terlaksana dalam bentuk persentase berdasarkan country objectives
     */
    public function get_completed_activities_percentage_by_year($year, $month = 'all', $partner_id = null) {
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

        // Jika bulan bukan 'all', maka ambil data dari bulan 1 sampai bulan yang ditentukan
        if ($month !== 'all') {
            $this->db->where('t.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
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

    public function get_partner_name_by_id($partner_id) {
        // Mengambil nama partner berdasarkan ID
        $this->db->select('name');
        $this->db->from('partners');
        $this->db->where('id', $partner_id);
        
        // Mengeksekusi query
        $query = $this->db->get();
        
        // Mengecek apakah data ditemukan
        if ($query->num_rows() > 0) {
            // Mengembalikan nama partner
            return $query->row()->name;
        } else {
            // Mengembalikan NULL jika tidak ada data
            return null;
        }
    }
    
    
}

?>