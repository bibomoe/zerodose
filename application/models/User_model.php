<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Hash password sebelum disimpan ke database
     * 
     * @param string $password
     * @return string
     */
    public function hash_password($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Menambahkan user baru ke database
     * 
     * @param array $data
     * @return bool
     */
    public function insert_user($data) {
        return $this->db->insert('users', $data);  // Query insert menggunakan Query Builder
    }
}
