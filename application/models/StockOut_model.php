<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockOut_model extends CI_Model {

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
        
        // Filter berdasarkan parameter yang diberikan
        if (!empty($province_id)) {
            $this->db->where('provinces.id', $province_id);
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
        $this->db->select('month, 
                           SUM(stock_out_1_month) AS stock_out_1, 
                           SUM(stock_out_2_months) AS stock_out_2, 
                           SUM(stock_out_3_months) AS stock_out_3,
                           SUM(stock_out_more_than_3_months) AS stock_out_4'); // Tambah Stock Out >3 Bulan
        $this->db->from('stock_out_data');
        $this->db->where('vaccine_type', 'DPT'); // Hanya vaksin DPT
        $this->db->where('year', $year);
    
        if ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
    
        $this->db->group_by('month');
        $this->db->order_by('month', 'ASC');
    
        return $this->db->get()->result_array();
    }

    // Fungsi untuk mengambil data stok kosong per puskesmas dan bulan
    public function get_dpt_stock_out_by_month($province_id, $year) {
        // Ambil data vaksin per puskesmas tanpa melakukan SUM atau GROUP BY
        $this->db->select('month, 
                           province_id, 
                           city_id, 
                           subdistrict_id, 
                           puskesmas_id, 
                           DPT_HB_Hib_5_ds, 
                           Pentavalent_Easyfive_10_ds, 
                           Pentavac_10_ds, 
                           Vaksin_ComBE_Five_10_ds');
        $this->db->from('puskesmas_stock_out_details');
        $this->db->where('year', $year);

        if ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }

        $this->db->order_by('month', 'ASC');
        $this->db->order_by('puskesmas_id', 'ASC');  // Agar data terurut dengan baik
        return $this->db->get()->result_array();
    }

    // Fungsi untuk menghitung kategori durasi stok kosong per puskesmas dan bulan
    public function calculate_stock_out_category($data) {
        $monthly_stock_out = [];

        foreach ($data as $row) {
            // Ambil durasi stok kosong untuk setiap vaksin
            $durations = [
                'DPT_HB_Hib_5_ds' => $row['DPT_HB_Hib_5_ds'],
                'Pentavalent_Easyfive_10_ds' => $row['Pentavalent_Easyfive_10_ds'],
                'Pentavac_10_ds' => $row['Pentavac_10_ds'],
                'Vaksin_ComBE_Five_10_ds' => $row['Vaksin_ComBE_Five_10_ds']
            ];

            // Hanya pilih vaksin yang memiliki durasi stok kosong lebih dari 0
            $valid_durations = array_filter($durations, function($duration) {
                return $duration > 0;
            });

            // Tentukan kategori berdasarkan durasi stok kosong terpendek
            if (count($valid_durations) === 0) {
                $category = 'No Stock Out';
            } else {
                // Cari durasi stok kosong terpendek
                $shortest_duration = min($valid_durations);

                // Tentukan kategori berdasarkan durasi stok kosong terpendek
                if ($shortest_duration >= 30 && $shortest_duration <= 60) {
                    $category = '1 Month';
                } elseif ($shortest_duration > 60 && $shortest_duration <= 90) {
                    $category = '2 Months';
                } elseif ($shortest_duration > 90 && $shortest_duration <= 120) {
                    $category = '3 Months';
                } else {
                    $category = '> 3 Months';
                }
            }

            // Inisialisasi jika belum ada entri untuk bulan ini
            if (!isset($monthly_stock_out[$row['month']])) {
                $monthly_stock_out[$row['month']] = [
                    'stock_out_1' => '0',
                    'stock_out_2' => '0',
                    'stock_out_3' => '0',
                    'stock_out_4' => '0',
                    'stock_out_no' => '0'
                ];
            }

            // Menambahkan jumlah puskesmas untuk kategori durasi stok kosong
            if ($category == '1 Month') {
                $monthly_stock_out[$row['month']]['stock_out_1']++;
            } elseif ($category == '2 Months') {
                $monthly_stock_out[$row['month']]['stock_out_2']++;
            } elseif ($category == '3 Months') {
                $monthly_stock_out[$row['month']]['stock_out_3']++;
            } elseif ($category == '> 3 Months') {
                $monthly_stock_out[$row['month']]['stock_out_4']++;
            } else {
                $monthly_stock_out[$row['month']]['stock_out_no']++;
            }
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

        return $result;
    }
    
}
