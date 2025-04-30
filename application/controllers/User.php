<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');  // Load model User
        $this->load->model('Immunization_model');  // Load model untuk provinsi dan kota
        $this->load->library('form_validation');
        $this->load->library('encryption'); // Pastikan library encryption diload

        $this->load->library('session'); // Load library session

        // Cek apakah user sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // Regenerasi ID session setiap kali user aktif
        $this->session->sess_regenerate();

        // Inisialisasi data sesi di $data
        $this->data = [
            'session_email' => $this->session->userdata('email'),
            'session_name' => $this->session->userdata('name'),
            'session_user_category_name' => $this->session->userdata('user_category_name'),
        ];
    }

    public function index() {
        $user_category = $this->session->userdata('user_category'); // Ambil kategori pengguna yang login
        $user_province = $this->session->userdata('province_id');
        $user_city = $this->session->userdata('city_id');

        // Logika kontrol akses berdasarkan kategori pengguna
        if ($user_category == 1) {
            // Jika kategori adalah 1, tampilkan data untuk kategori 7 dan 8 (PHO & DHO)
            $this->data['allowed_categories'] = [7, 8];
        } elseif ($user_category == 2 || $user_category == 9) {
            // Jika kategori adalah 2 atau 9, tampilkan data untuk semua kategori
            $this->data['allowed_categories'] = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        } elseif ($user_category == 7) {
            // Jika kategori adalah 7, tampilkan data hanya untuk kategori 8
            $this->data['allowed_categories'] = [8];
        } else {
            // Kategori lainnya tidak bisa mengakses halaman ini
            show_error('Access denied.', 403);
        }

        // Ambil data user yang sesuai kategori yang diperbolehkan
        $this->data['title'] = 'User Management';
        $this->data['users'] = $this->User_model->get_users_by_categories($this->data['allowed_categories'], $user_province);
        load_template('input/user-view', $this->data);
    }

    // Fungsi untuk menambah user
    public function add_user() {

        $user_category = $this->session->userdata('user_category'); // Ambil kategori pengguna yang login
    
        // Logika kontrol akses berdasarkan kategori pengguna
        if ($user_category == 1) {
            // Jika kategori adalah 1, tampilkan data untuk kategori 7 dan 8 (PHO & DHO)
            $this->data['allowed_categories'] = [7, 8];
        } elseif ($user_category == 2 || $user_category == 9) {
            // Jika kategori adalah 2 atau 9, tampilkan data untuk semua kategori
            $this->data['allowed_categories'] = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        } elseif ($user_category == 7) {
            // Jika kategori adalah 7, tampilkan data hanya untuk kategori 8
            $this->data['allowed_categories'] = [8];
        } else {
            // Kategori lainnya tidak bisa mengakses halaman ini
            show_error('Access denied.', 403);
        }
        
        // Menyiapkan data kategori untuk dropdown
        $category_data = [
            1 => 'Ministry of Health',
            2 => 'CHAI',
            3 => 'WHO',
            4 => 'UNICEF',
            5 => 'UNDP',
            6 => 'GAVI',
            7 => 'PHO',
            8 => 'DHO',
            9 => 'Administrator'
        ];

        // Hanya tampilkan kategori yang sesuai dengan $allowed_categories
        $this->data['category_options'] = array_intersect_key($category_data, array_flip($this->data['allowed_categories']));
        // Ambil data provinsi untuk dropdown
        $provinces = $this->Immunization_model->get_provinces();
        $this->data['province_options'] = ['' => '-- Select Province --'];
        foreach ($provinces as $province) {
            $this->data['province_options'][$province->id] = $province->name_id;
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        // Jika validasi form gagal
        if ($this->form_validation->run() == FALSE) {
            // Menampilkan halaman input form untuk tambah user
            $this->data['title'] = 'Add User';
            // $this->load->view('input/add_user', $this->data);
            load_template('input/add_user', $this->data);
        } else {
            // Ambil input data
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);
            $name = $this->input->post('name', TRUE);
            $category = $this->input->post('category', TRUE);
            $send_auto_email = $this->input->post('send_auto_email', TRUE); // Ambil nilai auto email

            // Menentukan nilai partner_category jika kategori 1-5
            $partner_category = ($category >= 1 && $category <= 5) ? $category : NULL;
            
            // Jika kategori adalah PHO (7) atau DHO (8), ambil province dan city
            if ($category == 7 || $category == 8) {
                $province_id = $this->input->post('province_id', TRUE);
                $city_id = $this->input->post('city_id', TRUE);
                if ($city_id === ''){
                    $city_id = null;
                }
            }

            $hashed_password = $this->User_model->hash_password($password);

            // Data yang akan disimpan
            $data = [
                'email' => $email,
                'password' => $hashed_password,
                'name' => $name,
                'category' => $category,
                'partner_category' => $partner_category,
                'send_auto_email' => $send_auto_email,  // Nilai 1 untuk Yes, 0 untuk No
                'province_id' => isset($province_id) ? $province_id : NULL,
                'city_id' => isset($city_id) ? $city_id : NULL
            ];

            // Menambahkan user baru
            $this->User_model->insert_user($data);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
            redirect('user');
        }
    }

    // Fungsi untuk mengupdate user
    public function update_user($encrypted_id) {
        // Dekripsi ID yang terenkripsi
        $id = $this->User_model->decrypt_id($encrypted_id);

        $user_category = $this->session->userdata('user_category'); // Ambil kategori pengguna yang login
    
        // Logika kontrol akses berdasarkan kategori pengguna
        if ($user_category == 1) {
            // Jika kategori adalah 1, tampilkan data untuk kategori 7 dan 8 (PHO & DHO)
            $this->data['allowed_categories'] = [7, 8];
        } elseif ($user_category == 2 || $user_category == 9) {
            // Jika kategori adalah 2 atau 9, tampilkan data untuk semua kategori
            $this->data['allowed_categories'] = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        } elseif ($user_category == 7) {
            // Jika kategori adalah 7, tampilkan data hanya untuk kategori 8
            $this->data['allowed_categories'] = [8];
        } else {
            // Kategori lainnya tidak bisa mengakses halaman ini
            show_error('Access denied.', 403);
        }
        
        // Menyiapkan data kategori untuk dropdown
        $category_data = [
            1 => 'Ministry of Health',
            2 => 'CHAI',
            3 => 'WHO',
            4 => 'UNICEF',
            5 => 'UNDP',
            6 => 'GAVI',
            7 => 'PHO',
            8 => 'DHO',
            9 => 'Administrator'
        ];

        // Hanya tampilkan kategori yang sesuai dengan $allowed_categories
        $this->data['category_options'] = array_intersect_key($category_data, array_flip($this->data['allowed_categories']));

        // Ambil data provinsi untuk dropdown
        $provinces = $this->Immunization_model->get_provinces();
        $this->data['province_options'] = ['' => '-- Select Province --'];
        foreach ($provinces as $province) {
            $this->data['province_options'][$province->id] = $province->name_id;
        }
        
        $user = $this->User_model->get_user_by_id($id);
        if (!$user) {
            show_404();
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->data['user'] = $user;
            $this->data['title'] = 'Edit User';
            // Tampilkan form untuk edit user
            // $this->load->view('input/edit_user', $this->data);
            load_template('input/edit_user', $this->data);
        } else {
            $email = $this->input->post('email', TRUE);
            $name = $this->input->post('name', TRUE);
            $category = $this->input->post('category', TRUE);
            $send_auto_email = $this->input->post('send_auto_email', TRUE); // Ambil nilai auto email

            // Jika kategori adalah PHO (7) atau DHO (8), ambil province dan city
            if ($category == 7 || $category == 8) {
                $province_id = $this->input->post('province_id', TRUE);
                $city_id = $this->input->post('city_id', TRUE);
                if ($city_id === ''){
                    $city_id = null;
                }
            }

            $data = [
                'email' => $email,
                'name' => $name,
                'category' => $category,
                'send_auto_email' => $send_auto_email,  // Nilai 1 untuk Yes, 0 untuk No
                'province_id' => isset($province_id) ? $province_id : NULL,
                'city_id' => isset($city_id) ? $city_id : NULL
            ];

            $this->User_model->update_user($id, $data);
            $this->session->set_flashdata('success', 'User berhasil diupdate!');
            redirect('user');
        }
    }

    // Fungsi untuk menghapus user
    public function delete_user($encrypted_id) {
        // Dekripsi ID yang terenkripsi
        $id = $this->User_model->decrypt_id($encrypted_id);

        $this->User_model->delete_user($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('user');
    }

    // Fungsi untuk mengambil data kota berdasarkan provinsi
    public function get_cities_by_province() {
        $province_id = $this->input->get('province_id');
        $cities = $this->Immunization_model->get_cities_by_province($province_id);
        echo json_encode($cities);
    }
}
