<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner_model extends CI_Model {
    public function get_all_partners() {
        $query = $this->db->get('partners');
        return $query->result();
    }
}
?>