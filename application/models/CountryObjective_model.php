<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CountryObjective_model extends CI_Model {

    public function get_all_objectives() {
        $this->db->select('id, objective_name');
        $this->db->from('country_objectives');
        return $this->db->get()->result_array();
    }
}

?>
