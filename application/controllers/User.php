<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');  // Load model User
        $this->load->library('form_validation'); // Load library form validation
    }

    // Fungsi untuk menambahkan user baru
    public function add_user() {
        // Validasi form input
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Jika form tidak valid, tampilkan pesan error
            $this->load->view('add_user');
        } else {
            // Ambil input data
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);
            $name = $this->input->post('name', TRUE);
            $category = $this->input->post('category', TRUE);
            $partner_category = $this->input->post('partner_category', TRUE);

            // Hash password sebelum disimpan
            $hashed_password = $this->User_model->hash_password($password);

            // Data yang akan disimpan
            $data = array(
                'email' => $email,
                'password' => $hashed_password,
                'name' => $name,
                'category' => $category,
                'partner_category' => $partner_category
            );

            // Menambahkan user baru ke database
            $this->User_model->insert_user($data);

            // Redirect setelah user berhasil ditambahkan
            $this->session->set_flashdata('success', 'User baru berhasil ditambahkan!');
            redirect('user/add_user');
        }
    }
}
