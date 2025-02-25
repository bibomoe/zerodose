<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

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
    
        return $dropout_rates; // Kembalikan hanya drop-out rate
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
            $this->db->where('sod.month <=', $month); // Kumulatif bulan 1 sampai bulan yang ditentukan
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
    
}

?>