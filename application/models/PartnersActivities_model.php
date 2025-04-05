<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PartnersActivities_model extends CI_Model {

    // Ambil data target budget berdasarkan partner_id
    public function get_target_budget_by_partner($partner_id) {
        return $this->db->select('*')
                        ->where('partner_id', $partner_id)
                        ->get('partners_activities')
                        ->result(); // Kembalikan sebagai object
    }

    // Update target budget berdasarkan partner_id dan activity_id
    public function update_target_budget($partner_id, $activity_id, $data) {
        $this->db->where('partner_id', $partner_id)
                ->where('activity_id', $activity_id)
                ->update('partners_activities', $data);
    }

    public function get_target_budget_by_partner_and_year($partner_id, $year) {
        $this->db->select('SUM(target_budget_' . $year . ') AS total_target_budget')
                 ->where('partner_id', $partner_id);
    
        $result = $this->db->get('partners_activities')->row_array();
        return $result['total_target_budget'] ?? 0; // Default 0 jika tidak ada data
    }
    
    public function get_total_target_budget_by_year($year) {
        $this->db->select('SUM(target_budget_' . $year . ') AS total_target_budget');
        $result = $this->db->get('partners_activities')->row_array();
        return $result['total_target_budget'] ?? 0; // Default 0 jika tidak ada data
    }

    public function get_target_budget_by_objective_and_year($year, $partner_id = null) {
        $this->db->select('a.objective_id, SUM(pa.target_budget_' . $year . ') AS target_budget');
        $this->db->from('partners_activities pa');
        $this->db->join('activities a', 'pa.activity_id = a.id');
        
        if (!is_null($partner_id) && $partner_id !== 'all') {
            $this->db->where('pa.partner_id', $partner_id);
        }
    
        $this->db->group_by('a.objective_id');
        $result = $this->db->get()->result_array();
    
        // Siapkan array default
        $objectives = $this->CountryObjective_model->get_all_objectives();
        $budget_data = array_fill(0, count($objectives), 0);
    
        foreach ($result as $row) {
            $index = $row['objective_id'] - 1;
            $budget_data[$index] = (float) $row['target_budget'];
        }
    
        return $budget_data;
    }
    
}

?>