<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockOut_model extends CI_Model {

    public function get_targeted_province_ids() {
        $query = $this->db->select('id')
                          ->from('provinces')
                          ->where('priority', 1)
                          ->get();
    
        return array_column($query->result_array(), 'id'); // Return array ID
    }

    // // Simpan data stock out ke database
    // public function save_stock_out($data) {
    //     // Cek apakah data untuk province_id, city_id, year, month, dan vaccine_type sudah ada
    //     $this->db->where('province_id', $data['province_id']);
    //     $this->db->where('city_id', $data['city_id']);
    //     $this->db->where('year', $data['year']);
    //     $this->db->where('month', $data['month']);
    //     $this->db->where('vaccine_type', $data['vaccine_type']);
        
    //     $query = $this->db->get('stock_out_data');
    
    //     if ($query->num_rows() > 0) {
    //         // Data sudah ada, lakukan update
    //         $this->db->where('province_id', $data['province_id']);
    //         $this->db->where('city_id', $data['city_id']);
    //         $this->db->where('year', $data['year']);
    //         $this->db->where('month', $data['month']);
    //         $this->db->where('vaccine_type', $data['vaccine_type']);
    
    //         $this->db->update('stock_out_data', $data);
    //         return $this->db->affected_rows(); // Mengembalikan jumlah baris yang diperbarui
    //     } else {
    //         // Data belum ada, lakukan insert
    //         $this->db->insert('stock_out_data', $data);
    //         return $this->db->insert_id(); // Mengembalikan ID dari data yang baru disimpan
    //     }
    // }
    
    // Ambil data stock out berdasarkan filter
    // public function get_stock_out_data($province_id, $city_id, $year, $month) {
    //     $this->db->select('stock_out_data.*, 
    //                       provinces.name_id AS province_name, 
    //                       cities.name_id AS city_name');
    //     $this->db->from('stock_out_data');
    //     $this->db->join('provinces', 'provinces.id = stock_out_data.province_id', 'left');
    //     $this->db->join('cities', 'cities.id = stock_out_data.city_id', 'left');

    //     if (!empty($province_id)) {
    //         $this->db->where('stock_out_data.province_id', $province_id);
    //     }
    //     if (!empty($city_id)) {
    //         $this->db->where('stock_out_data.city_id', $city_id);
    //     }
    //     if (!empty($year)) {
    //         $this->db->where('stock_out_data.year', $year);
    //     }
    //     if (!empty($month)) {
    //         $this->db->where('stock_out_data.month', $month);
    //     }

    //     return $this->db->get()->result();
    // }

    // // Hapus data stock out
    // public function delete_stock_out($id) {
    //     $this->db->where('id', $id)->delete('stock_out_data');
    // }

    public function save_stock_out($data) {
        // Cek apakah data untuk province_id, city_id, year, month sudah ada
        $this->db->where('province_id', $data['province_id']);
        $this->db->where('city_id', $data['city_id']);
        $this->db->where('subdistrict_id', $data['subdistrict_id']);  // Cek subdistrict_id
        $this->db->where('puskesmas_id', $data['puskesmas_id']);  // Cek puskesmas_id
        $this->db->where('year', $data['year']);
        $this->db->where('month', $data['month']);
        
        $query = $this->db->get('puskesmas_stock_out_details');  // Nama tabel sesuai dengan yang Anda berikan
    
        if ($query->num_rows() > 0) {
            // Data sudah ada, lakukan update
            $this->db->where('province_id', $data['province_id']);
            $this->db->where('city_id', $data['city_id']);
            $this->db->where('subdistrict_id', $data['subdistrict_id']);
            $this->db->where('puskesmas_id', $data['puskesmas_id']);
            $this->db->where('year', $data['year']);
            $this->db->where('month', $data['month']);
            
            // Update data vaksin baru
            $this->db->update('puskesmas_stock_out_details', $data);
            return $this->db->affected_rows();  // Mengembalikan jumlah baris yang diperbarui
        } else {
            // Data belum ada, lakukan insert
            $this->db->insert('puskesmas_stock_out_details', $data);
            return $this->db->insert_id();  // Mengembalikan ID dari data yang baru disimpan
        }
    }

    public function get_stock_out_data($province_id, $city_id, $subdistrict_id, $puskesmas_id, $year, $month) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil daftar targeted provinces
        
        // Pilih kolom-kolom yang dibutuhkan dari tabel
        $this->db->select('puskesmas_stock_out_details.*, 
                           provinces.name_id AS province_name, 
                           cities.name_id AS city_name, 
                           subdistricts.name AS subdistrict_name, 
                           puskesmas.name AS puskesmas_name');
        $this->db->from('puskesmas_stock_out_details');
        $this->db->join('provinces', 'provinces.id = puskesmas_stock_out_details.province_id', 'left');
        $this->db->join('cities', 'cities.id = puskesmas_stock_out_details.city_id', 'left');
        $this->db->join('subdistricts', 'subdistricts.id = puskesmas_stock_out_details.subdistrict_id', 'left');
        $this->db->join('puskesmas', 'puskesmas.id = puskesmas_stock_out_details.puskesmas_id', 'left');

        if (!empty($province_id)) {
            $this->db->where('province_id', $province_id);
        }

        if (!empty($city_id)) {
            $this->db->where('cities.id', $city_id);
        }
        if (!empty($subdistrict_id)) {
            $this->db->where('subdistricts.id', $subdistrict_id);
        }
        if (!empty($puskesmas_id)) {
            $this->db->where('puskesmas.id', $puskesmas_id);
        }
        if (!empty($year)) {
            $this->db->where('puskesmas_stock_out_details.year', $year);
        }
        if (!empty($month)) {
            $this->db->where('puskesmas_stock_out_details.month', $month);
        }
    
        // Eksekusi query dan kembalikan hasilnya
        return $this->db->get()->result();
    }
    
    public function delete_stock_out($id) {
        // Hapus data berdasarkan ID
        $this->db->where('id', $id)->delete('puskesmas_stock_out_details');
    }
    
    

    public function get_dpt_stock_out($province_id, $year) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil daftar targeted provinces

        $this->db->select('month, 
                           SUM(stock_out_1_month) AS stock_out_1, 
                           SUM(stock_out_2_months) AS stock_out_2, 
                           SUM(stock_out_3_months) AS stock_out_3,
                           SUM(stock_out_more_than_3_months) AS stock_out_4'); // Tambah Stock Out >3 Bulan
        $this->db->from('stock_out_data');
        $this->db->where('vaccine_type', 'DPT'); // Hanya vaksin DPT
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
    
        $this->db->group_by('month');
        $this->db->order_by('month', 'ASC');
    
        return $this->db->get()->result_array();
    }

    // Fungsi untuk mengambil data stok kosong per puskesmas dan bulan
    // public function get_dpt_stock_out_by_month($province_id, $year) {
    //     // Ambil data vaksin per puskesmas tanpa melakukan SUM atau GROUP BY
    //     $this->db->select('month, 
    //                        province_id, 
    //                        city_id, 
    //                        subdistrict_id, 
    //                        puskesmas_id, 
    //                        DPT_HB_Hib_5_ds, 
    //                        Pentavalent_Easyfive_10_ds, 
    //                        Pentavac_10_ds, 
    //                        Vaksin_ComBE_Five_10_ds');
    //     $this->db->from('puskesmas_stock_out_details');
    //     $this->db->where('year', $year);

    //     if ($province_id !== 'all') {
    //         $this->db->where('province_id', $province_id);
    //     }

    //     $this->db->order_by('month', 'ASC');
    //     $this->db->order_by('puskesmas_id', 'ASC');  // Agar data terurut dengan baik
    //     return $this->db->get()->result_array();
    // }

    // Fungsi untuk menghitung kategori durasi stok kosong per puskesmas dan bulan
    // public function calculate_stock_out_category($data) {
    //     $monthly_stock_out = [];

    //     foreach ($data as $row) {
    //         // Ambil durasi stok kosong untuk setiap vaksin
    //         $durations = [
    //             'DPT_HB_Hib_5_ds' => $row['DPT_HB_Hib_5_ds'],
    //             'Pentavalent_Easyfive_10_ds' => $row['Pentavalent_Easyfive_10_ds'],
    //             'Pentavac_10_ds' => $row['Pentavac_10_ds'],
    //             'Vaksin_ComBE_Five_10_ds' => $row['Vaksin_ComBE_Five_10_ds']
    //         ];

    //         // Hanya pilih vaksin yang memiliki durasi stok kosong lebih dari 0
    //         $valid_durations = array_filter($durations, function($duration) {
    //             return $duration > 0;
    //         });

    //         // Tentukan kategori berdasarkan durasi stok kosong terpendek
    //         if (count($valid_durations) === 0) {
    //             $category = 'No Stock Out';
    //         } else {
    //             // Cari durasi stok kosong terpendek
    //             $shortest_duration = min($valid_durations);

    //             // Tentukan kategori berdasarkan durasi stok kosong terpendek
    //             if ($shortest_duration >= 30 && $shortest_duration < 60) {
    //                 $category = '1 Month';
    //             } elseif ($shortest_duration >= 60 && $shortest_duration < 90) {
    //                 $category = '2 Months';
    //             } elseif ($shortest_duration >= 90 && $shortest_duration < 120) {
    //                 $category = '3 Months';
    //             } elseif ($shortest_duration >= 120) {
    //                 $category = '> 3 Months';
    //             } else {
    //                 $category = 'No stock out';
    //             }
    //         }

    //         // Inisialisasi jika belum ada entri untuk bulan ini
    //         if (!isset($monthly_stock_out[$row['month']])) {
    //             $monthly_stock_out[$row['month']] = [
    //                 'stock_out_1' => '0',
    //                 'stock_out_2' => '0',
    //                 'stock_out_3' => '0',
    //                 'stock_out_4' => '0',
    //                 'stock_out_no' => '0'
    //             ];
    //         }

    //         // Menambahkan jumlah puskesmas untuk kategori durasi stok kosong
    //         if ($category == '1 Month') {
    //             $monthly_stock_out[$row['month']]['stock_out_1']++;
    //         } elseif ($category == '2 Months') {
    //             $monthly_stock_out[$row['month']]['stock_out_2']++;
    //         } elseif ($category == '3 Months') {
    //             $monthly_stock_out[$row['month']]['stock_out_3']++;
    //         } elseif ($category == '> 3 Months') {
    //             $monthly_stock_out[$row['month']]['stock_out_4']++;
    //         } elseif ($category == 'No stock out') {
    //             $monthly_stock_out[$row['month']]['stock_out_no']++;
    //         }
    //     }

    //     // Format data untuk menyesuaikan dengan struktur yang diinginkan
    //     $result = [];
    //     foreach ($monthly_stock_out as $month => $categories) {
    //         $result[] = [
    //             'month' => (string)$month,  // Menjadikan bulan dalam format string
    //             'stock_out_1' => $categories['stock_out_1'],
    //             'stock_out_2' => $categories['stock_out_2'],
    //             'stock_out_3' => $categories['stock_out_3'],
    //             'stock_out_4' => $categories['stock_out_4'],
    //             'stock_out_no' => $categories['stock_out_no']
    //         ];
    //     }

    //     return $result;
    // }

    // Fungsi untuk mengambil data stok kosong per puskesmas dan bulan, termasuk data tahun sebelumnya
    public function get_dpt_stock_out_by_month($province_id, $city_id, $year) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil daftar targeted provinces
    
        // Ambil data vaksin per puskesmas tanpa melakukan SUM atau GROUP BY
        $this->db->select('month, 
                        year,
                        province_id, 
                        city_id, 
                        subdistrict_id, 
                        puskesmas_id, 
                        DPT_HB_Hib_5_ds, 
                        Pentavalent_Easyfive_10_ds, 
                        Pentavac_10_ds, 
                        Vaksin_ComBE_Five_10_ds, 
                        status_stockout'); // Menambahkan status_stockout
        $this->db->from('puskesmas_stock_out_details');

        // Ambil data untuk tahun yang diminta
        $this->db->where('year', $year);

        // Jika province_id tidak 'all', filter berdasarkan province_id
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

        // Ambil data untuk tahun sebelumnya
        $this->db->or_where('year', $year - 1);

        // Urutkan berdasarkan tahun, bulan, dan puskesmas_id
        $this->db->order_by('year', 'ASC');
        $this->db->order_by('month', 'ASC');
        $this->db->order_by('puskesmas_id', 'ASC');

        // Ambil data yang sesuai dengan filter
        $result = $this->db->get()->result_array();

        var_dump($result);
        exit;
        return $result;
    }


    public function calculate_stock_out_category($data, $selected_year) {
        $monthly_stock_out = [];
        
        // Array untuk menyimpan status stockout per bulan dan tahun
        $previous_month_stockout = [];
        
        foreach ($data as $row) {
            $month = $row['month'];
            $year = $row['year']; // Tahun data
    
            // Hanya proses data untuk tahun yang dipilih
            if ($year != $selected_year) {
                continue; // Lewatkan data jika tahun tidak sesuai
            }
    
            // Tentukan bulan-bulan yang akan dicek untuk 3 bulan sebelumnya
            $previous_months = [];
        
            // Tentukan bulan-bulan sebelumnya
            for ($i = 1; $i <= 3; $i++) {
                $prev_month = $month - $i;
        
                // Jika bulan sebelumnya kurang dari 1 (misalnya Januari - 1), kita perlu mengubah tahun
                if ($prev_month < 1) {
                    $prev_month += 12; // Bulan Desember, November, Oktober...
                    $prev_year = $year - 1; // Tahun sebelumnya
                } else {
                    $prev_year = $year; // Tahun yang sama jika bulan tidak kurang dari 1
                }
        
                // Simpan bulan dan tahun sebelumnya
                $previous_months[] = [
                    'month' => $prev_month,
                    'year' => $prev_year
                ];
            }
        
            // Menyimpan status stockout untuk bulan-bulan sebelumnya
            $statuses_previous_months = [];
        
            // Loop untuk mencari status stockout bulan-bulan sebelumnya
            foreach ($previous_months as $prev) {
                foreach ($data as $previous_row) {
                    if ($previous_row['month'] == $prev['month'] && $previous_row['year'] == $prev['year'] && $previous_row['puskesmas_id'] == $row['puskesmas_id']) {
                        $statuses_previous_months[$prev['month']] = $previous_row['status_stockout'];
                    }
                }
            }
        
            // Tentukan kategori berdasarkan status stockout
            if ($row['status_stockout'] == 1) {
                // Jika bulan sebelumnya ada yang memiliki status 0
                // if (!isset($statuses_previous_months[10]) && !isset($statuses_previous_months[11]) && !isset($statuses_previous_months[12])) {
                //     $category = '1 Month';
                // } else {
                //     // Jika ada lebih dari satu bulan berturut-turut dengan status 1
                //     $count_consecutive_1 = 0;
                //     foreach ($previous_months as $prev) {
                //         if (isset($statuses_previous_months[$prev['month']]) && $statuses_previous_months[$prev['month']] == 1) {
                //             $count_consecutive_1++;
                //         }
                //     }
        
                //     // Tentukan kategori berdasarkan jumlah bulan berturut-turut
                //     if ($count_consecutive_1 >= 3) {
                //         $category = '> 3 Months';
                //     } elseif ($count_consecutive_1 == 2) {
                //         $category = '3 Months';
                //     } elseif ($count_consecutive_1 == 1) {
                //         $category = '2 Months';
                //     }
                // }

                // Hitung bulan berturut-turut dengan status stockout
                $count_consecutive_1 = 0;
                foreach ($previous_months as $prev) {
                    if (isset($statuses_previous_months[$prev['month']]) && $statuses_previous_months[$prev['month']] == 1) {
                        $count_consecutive_1++;
                    }
                }

                // Tentukan kategori berdasarkan jumlah bulan berturut-turut
                if ($count_consecutive_1 >= 3) {
                    $category = '> 3 Months';
                } elseif ($count_consecutive_1 == 2) {
                    $category = '3 Months';
                } elseif ($count_consecutive_1 == 1) {
                    $category = '2 Months';
                } else {
                    $category = '1 Month'; // Jika hanya bulan ini yang stockout
                }
            } else {
                $category = 'No Stock Out';
            }
        
            // Menyimpan kategori untuk setiap bulan
            if (!isset($monthly_stock_out[$month])) {
                $monthly_stock_out[$month] = [
                    'stock_out_1' => 0,
                    'stock_out_2' => 0,
                    'stock_out_3' => 0,
                    'stock_out_4' => 0,
                    'stock_out_no' => 0
                ];
            }
        
            // Menambahkan jumlah puskesmas untuk kategori durasi stok kosong
            if ($category == '1 Month') {
                $monthly_stock_out[$month]['stock_out_1']++;
            } elseif ($category == '2 Months') {
                $monthly_stock_out[$month]['stock_out_2']++;
            } elseif ($category == '3 Months') {
                $monthly_stock_out[$month]['stock_out_3']++;
            } elseif ($category == '> 3 Months') {
                $monthly_stock_out[$month]['stock_out_4']++;
            } elseif ($category == 'No Stock Out') {
                $monthly_stock_out[$month]['stock_out_no']++;
            }
        
            // Menyimpan status stockout untuk bulan ini
            $previous_month_stockout[$month] = $row['status_stockout'];
        }
        
        // Format data untuk menyesuaikan dengan struktur yang diinginkan
        $result = [];
        foreach ($monthly_stock_out as $month => $categories) {
            $result[] = [
                'month' => (string)$month,  // Menjadikan bulan dalam format string
                'stock_out_1' => $categories['stock_out_1'],
                'stock_out_2' => $categories['stock_out_2'],
                'stock_out_3' => $categories['stock_out_3'],
                'stock_out_4' => $categories['stock_out_4'],
                'stock_out_no' => $categories['stock_out_no']
            ];
        }
    
        // var_dump($result);
        
        return $result;
    }
    
    public function get_puskesmas_stockout_table($province_id, $city_id, $year) {
        $province_ids = $this->get_targeted_province_ids(); // Ambil daftar targeted provinces
    
        // Ambil data vaksin per puskesmas yang pernah stockout
        $this->db->select('
                            puskesmas.province_id, 
                            provinces.name_id AS province_name, 
                            puskesmas.city_id, 
                            cities.name_id AS city_name, 
                            puskesmas.subdistrict_id, 
                            subdistricts.name AS subdistrict_name,
                            puskesmas.name AS puskesmas_name,
                            SUM(CASE WHEN psd.month = 1 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_1,
                            SUM(CASE WHEN psd.month = 2 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_2,
                            SUM(CASE WHEN psd.month = 3 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_3,
                            SUM(CASE WHEN psd.month = 4 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_4,
                            SUM(CASE WHEN psd.month = 5 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_5,
                            SUM(CASE WHEN psd.month = 6 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_6,
                            SUM(CASE WHEN psd.month = 7 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_7,
                            SUM(CASE WHEN psd.month = 8 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_8,
                            SUM(CASE WHEN psd.month = 9 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_9,
                            SUM(CASE WHEN psd.month = 10 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_10,
                            SUM(CASE WHEN psd.month = 11 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_11,
                            SUM(CASE WHEN psd.month = 12 AND psd.status_stockout = "1" THEN 1 ELSE 0 END) AS month_12
                        ');
    
        $this->db->from('puskesmas_stock_out_details psd');
        
        // Gabungkan tabel puskesmas dengan tabel lainnya
        $this->db->join('puskesmas', 'psd.puskesmas_id = puskesmas.id');
        $this->db->join('provinces', 'puskesmas.province_id = provinces.id');
        $this->db->join('cities', 'puskesmas.city_id = cities.id');
        $this->db->join('subdistricts', 'puskesmas.subdistrict_id = subdistricts.id');
    
        // Filter data berdasarkan tahun
        $this->db->where('psd.year', $year);

        if ($province_id === 'targeted') {
            if (!empty($province_ids)) {
                $this->db->where_in('psd.province_id', $province_ids);
            } else {
                return 0;
            }
        } elseif ($province_id !== 'all') {
            $this->db->where('psd.province_id', $province_id);
        }

        if ($city_id !== 'all') {
            $this->db->where('psd.city_id', $city_id);
        }
    
        // Group by puskesmas_id dan data terkait
        $this->db->group_by('puskesmas.province_id, 
                            provinces.name_id, 
                            puskesmas.city_id, 
                            cities.name_id, 
                            puskesmas.subdistrict_id, 
                            subdistricts.name, 
                            puskesmas.name');
    
        // Hanya ambil puskesmas yang pernah stockout
        $this->db->having('month_1 > 0 
                           OR month_2 > 0 
                           OR month_3 > 0 
                           OR month_4 > 0 
                           OR month_5 > 0 
                           OR month_6 > 0 
                           OR month_7 > 0 
                           OR month_8 > 0 
                           OR month_9 > 0 
                           OR month_10 > 0 
                           OR month_11 > 0 
                           OR month_12 > 0');
    
        // Urutkan berdasarkan provinsi, kabupaten, subdistrik, dan puskesmas_id
        $this->db->order_by('puskesmas.province_id', 'ASC');
        $this->db->order_by('cities.name_id', 'ASC');
        $this->db->order_by('subdistricts.name', 'ASC');
        $this->db->order_by('puskesmas.name', 'ASC');
    
        // Ambil data yang sesuai dengan filter
        $result = $this->db->get()->result_array();
    
        return $result;
    }
    
    
}
