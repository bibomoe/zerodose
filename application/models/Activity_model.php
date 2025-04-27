<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model {
    public function get_activities_by_partner($partner_id) {
        // Mengambil data aktivitas yang sesuai dengan partner
        $this->db->select('a.id, a.activity_code, a.description, a.objective_id, o.objective_name');
        $this->db->from('activities a');
        $this->db->join('partners_activities pa', 'a.id = pa.activity_id');
        $this->db->join('country_objectives o', 'a.objective_id = o.id');
        $this->db->where('pa.partner_id', $partner_id);

        $query = $this->db->get();
        return $query->result();
    }
    

    // Ambil total aktivitas per country objective
    public function get_total_activities_by_objectives($partner_id = null) {
        $this->db->select('objective_id, COUNT(a.id) AS total');
        $this->db->from('activities a');
        $this->db->join('country_objectives o', 'a.objective_id = o.id', 'left');

        if ($partner_id) {
            $this->db->join('partners_activities pa', 'a.id = pa.activity_id');
            $this->db->where('pa.partner_id', $partner_id);
        }

        $this->db->group_by('objective_id');
        $query = $this->db->get();

        return $query->result_array();
    }

    // Ambil aktivitas yang selesai per country objective per tahun
    public function get_completed_activities_by_objectives_and_year($year, $partner_id = null) {
        $this->db->select('a.objective_id, COUNT(DISTINCT t.activity_id) AS completed');
        $this->db->from('transactions t');
        $this->db->join('activities a', 't.activity_id = a.id');
        $this->db->join('country_objectives o', 'a.objective_id = o.id', 'left');

        if($year !== 'all'){
            $this->db->where('t.year', $year);
        }
        
        $this->db->where('t.number_of_activities >', 0);

        if ($partner_id) {
            $this->db->where('t.partner_id', $partner_id);
        }

        $this->db->group_by('a.objective_id');
        $query = $this->db->get();

        return $query->result_array();
    }
}

?>

