<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    /**
     * Memeriksa login berdasarkan email dan password
     *
     * @param string $email
     * @param string $password
     * @return object|null
     */
    public function check_login($email, $password) {
        // Cek apakah email ada di database dengan JOIN ke tabel user_category
        $this->db->select('users.*, user_category.name as user_category_name');
        $this->db->from('users');
        $this->db->join('user_category', 'users.category = user_category.id', 'left');
        $this->db->where('users.email', $email);
        $query = $this->db->get();
        $user = $query->row(); // Ambil data user jika ditemukan

        // Verifikasi password
        if ($user && password_verify($password, $user->password)) {
            return $user; // Jika user ditemukan dan password cocok, kembalikan data user
        }

        return null; // Jika user tidak ditemukan atau password tidak cocok
    }

    /**
     * Meng-hash password
     *
     * @param string $password
     * @return string
     */
    public function hash_password($password) {
        return password_hash($password, PASSWORD_DEFAULT); // Menggunakan bcrypt untuk meng-hash
    }
}
