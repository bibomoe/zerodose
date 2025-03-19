<?php
class User_model extends CI_Model {
    public function get_users_by_categories($categories) {
        $this->db->select('users.id, users.email, users.name, users.category, users.province_id, users.city_id, users.send_auto_email');
        $this->db->select('user_category.name AS category_name');
        $this->db->select('provinces.name_id AS province_name');
        $this->db->select('cities.name_id AS city_name');
        
        // Melakukan JOIN antara tabel users, user_category, provinces, dan cities
        $this->db->join('user_category', 'user_category.id = users.category', 'left');
        $this->db->join('provinces', 'provinces.id = users.province_id', 'left');
        $this->db->join('cities', 'cities.id = users.city_id', 'left');
        
        // Menggunakan kondisi untuk memfilter kategori yang diizinkan
        $this->db->where_in('users.category', $categories);
        
        $query = $this->db->get('users');

        // var_dump($query->result());
        // exit;
        return $query->result();
    }

    // Mendapatkan nama kategori berdasarkan ID kategori
    public function get_category_name($category_id) {
        $categories = [
            1 => 'Ministry of Health',
            2 => 'CHAI',
            3 => 'WHO',
            4 => 'UNICEF',
            5 => 'UNDP',
            6 => 'Gavi',
            7 => 'PHO',
            8 => 'DHO',
            9 => 'Administrator'
        ];

        return isset($categories[$category_id]) ? $categories[$category_id] : '-';
    }

    // Mendapatkan nama provinsi berdasarkan ID
    public function get_province_name($province_id) {
        if ($province_id) {
            $this->db->select('name_id');
            $this->db->where('id', $province_id);
            $query = $this->db->get('provinces');
            $result = $query->row();
            return $result ? $result->name_id : '-';
        }

        return '-';
    }

    // Mendapatkan nama kota berdasarkan ID
    public function get_city_name($city_id) {
        if ($city_id) {
            $this->db->select('name_id');
            $this->db->where('id', $city_id);
            $query = $this->db->get('cities');
            $result = $query->row();
            return $result ? $result->name_id : '-';
        }

        return '-';
    }

    public function encrypt_id($id) {
        // Mengenkripsi ID menggunakan base64
        return urlencode(base64_encode($id));  // Enkripsi ID menjadi string base64 yang aman untuk URL
    }
    
    public function decrypt_id($encrypted_id) {
        // Mendekripsi ID yang dienkripsi dengan base64
        return base64_decode(urldecode($encrypted_id));  // Mengembalikan ke ID asli
    }

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        return $this->db->delete('users', ['id' => $id]);
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function hash_password($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
