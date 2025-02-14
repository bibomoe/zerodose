<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StockOut_model extends CI_Model {

    // Simpan data stock out ke database
    public function save_stock_out($data) {
        // Cek apakah data untuk province_id, city_id, year, month, dan vaccine_type sudah ada
        $this->db->where('province_id', $data['province_id']);
        $this->db->where('city_id', $data['city_id']);
        $this->db->where('year', $data['year']);
        $this->db->where('month', $data['month']);
        $this->db->where('vaccine_type', $data['vaccine_type']);
        
        $query = $this->db->get('stock_out_data');
    
        if ($query->num_rows() > 0) {
            // Data sudah ada, lakukan update
            $this->db->where('province_id', $data['province_id']);
            $this->db->where('city_id', $data['city_id']);
            $this->db->where('year', $data['year']);
            $this->db->where('month', $data['month']);
            $this->db->where('vaccine_type', $data['vaccine_type']);
    
            $this->db->update('stock_out_data', $data);
            return $this->db->affected_rows(); // Mengembalikan jumlah baris yang diperbarui
        } else {
            // Data belum ada, lakukan insert
            $this->db->insert('stock_out_data', $data);
            return $this->db->insert_id(); // Mengembalikan ID dari data yang baru disimpan
        }
    }
    
    

    // Ambil data stock out berdasarkan filter
    public function get_stock_out_data($province_id, $city_id, $year, $month) {
        $this->db->select('stock_out_data.*, 
                          provinces.name_id AS province_name, 
                          cities.name_id AS city_name');
        $this->db->from('stock_out_data');
        $this->db->join('provinces', 'provinces.id = stock_out_data.province_id', 'left');
        $this->db->join('cities', 'cities.id = stock_out_data.city_id', 'left');

        if (!empty($province_id)) {
            $this->db->where('stock_out_data.province_id', $province_id);
        }
        if (!empty($city_id)) {
            $this->db->where('stock_out_data.city_id', $city_id);
        }
        if (!empty($year)) {
            $this->db->where('stock_out_data.year', $year);
        }
        if (!empty($month)) {
            $this->db->where('stock_out_data.month', $month);
        }

        return $this->db->get()->result();
    }

    // Hapus data stock out
    public function delete_stock_out($id) {
        $this->db->where('id', $id)->delete('stock_out_data');
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
    
}
