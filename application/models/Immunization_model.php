<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Immunization_model extends CI_Model {

    // Ambil semua provinsi
    public function get_provinces() {
        return $this->db->select('id, name_en')->where('active', 1)->get('provinces')->result();
    }

    public function get_cities_by_province($province_id) {
        return $this->db->where('province_id', $province_id)->where('active', 1)->get('cities')->result();
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
    
    
    // Total imunisasi berdasarkan jenis vaksin dan filter provinsi
    public function get_total_vaccine($vaccine_column, $province_id = 'all') {
        $this->db->select("SUM($vaccine_column) AS total");
        $this->db->from('immunization_data');
        if ($province_id !== 'all') {
            $this->db->where('province_id', $province_id);
        }
        $query = $this->db->get()->row();
        return $query->total ?? 0;
    }

    // Data total DPT-1 per distrik berdasarkan provinsi
    public function get_dpt1_by_district($province_id = 'all') {
        $this->db->select('cities.name_en AS district, SUM(immunization_data.dpt_hb_hib_1) AS total_dpt1');
        $this->db->from('immunization_data');
        $this->db->join('cities', 'cities.id = immunization_data.city_id', 'left');

        if ($province_id !== 'all') {
            $this->db->where('cities.province_id', $province_id);
        }

        $this->db->group_by('immunization_data.city_id');
        $this->db->order_by('total_dpt1', 'DESC');

        return $this->db->get()->result_array();
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
}
?>
