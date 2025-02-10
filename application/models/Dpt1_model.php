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
    public function get_total_dpt1_coverage() {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select('SUM(dpt_hb_hib_1) AS total_dpt1');
        $this->db->from('immunization_data');
        $this->db->where_in('province_id', $province_ids);
        $query = $this->db->get();
        return $query->row()->total_dpt1 ?? 0;
    }

    // Mengambil total DPT1 target untuk 10 provinsi priority
    public function get_total_dpt1_target() {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select('SUM(dpt_hb_hib_1_target) AS total_target');
        $this->db->from('target_immunization');
        $this->db->where_in('province_id', $province_ids);
        $query = $this->db->get();
        return $query->row()->total_target ?? 0;
    }

    // Mengambil jumlah distrik dengan coverage (DPT1-DPT3) kurang dari 5% 
    public function get_districts_under_5_percent() {
        // Mengambil 10 provinsi dengan priority = 1
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id'); // Ambil array ID provinsi
    
        // Query untuk mendapatkan cakupan DPT1, DPT2, DPT3 dan target masing-masing untuk setiap distrik
        $this->db->select("
            cities.name_id AS district, 
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
        $this->db->where_in('cities.province_id', $province_ids); // Hanya untuk provinsi dengan priority = 1
        $this->db->group_by('cities.name_id');
        
        // Ambil hasil query
        $query = $this->db->get();
        $districts = $query->result_array();
    
        // Filter distrik yang memiliki cakupan DPT1, DPT2, DPT3 di bawah 5%
        $under_5_percent_districts = [];

        foreach ($districts as $district) {
            // Pastikan tidak membagi dengan 0
            $dpt1_percentage = $district['dpt_hb_hib_1_target'] != 0 ? ($district['dpt1_coverage'] / $district['dpt_hb_hib_1_target']) * 100 : 0;
            $dpt2_percentage = $district['dpt_hb_hib_2_target'] != 0 ? ($district['dpt2_coverage'] / $district['dpt_hb_hib_2_target']) * 100 : 0;
            $dpt3_percentage = $district['dpt_hb_hib_3_target'] != 0 ? ($district['dpt3_coverage'] / $district['dpt_hb_hib_3_target']) * 100 : 0;

            // Memeriksa apakah cakupan DPT1, DPT2, atau DPT3 di bawah 5%
            if ($dpt1_percentage < 5 || $dpt2_percentage < 5 || $dpt3_percentage < 5) {
                $under_5_percent_districts[] = $district;
            }
        }

    
        return $under_5_percent_districts;
    }
    
    

    // Mengambil total jumlah regencies/cities untuk 10 provinsi priority
    public function get_total_regencies_cities() {
        $provinces = $this->get_targeted_provinces();
        $province_ids = array_column($provinces, 'id');

        $this->db->select('COUNT(DISTINCT id) AS total_cities');
        $this->db->from('cities');
        $this->db->where_in('province_id', $province_ids);
        $query = $this->db->get();
        return $query->row()->total_cities ?? 0;
    }
}
