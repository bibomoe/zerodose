<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model'); // Load model untuk autentikasi
        $this->load->library('session'); // Load library session
        $this->load->library('form_validation');
    }

    // Halaman Login
    public function login() {
        // Cek apakah user sudah login
        if ($this->session->userdata('logged_in')) {
            redirect('home'); // Arahkan ke halaman utama jika sudah login
        }

        // Tampilkan halaman login
        $this->load->view('login');
    }

    // Proses login
    public function login_process() {
        // Validasi input dengan form validation
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/login');
        }

        // Ambil input email dan password
        $email = $this->input->post('email', TRUE);
        $password = $this->input->post('password', TRUE);

        // Verifikasi login
        $user = $this->Auth_model->check_login($email, $password);

        if ($user) {
            // Regenerasi session ID untuk proteksi session fixation
            $this->session->sess_regenerate();

            // Ambil bahasa yang dipilih dari localStorage (dikirim melalui form atau AJAX)
            $selected_language = $this->input->post('language') ?? 'en'; // Default 'en' jika tidak ada data
            
            // Set data session
            $this->session->set_userdata([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'user_category' => $user->category,
                'user_category_name' => $user->user_category_name,
                'partner_category' => $user->partner_category,
                'province_id' => $user->province_id,
                'city_id' => $user->city_id,
                'language' => $selected_language, // Menyimpan bahasa ke session
                'logged_in' => TRUE
            ]);
            
            var_dump($_SESSION);
            redirect('home');
        } else {
            $this->session->set_flashdata('error', 'Email atau password salah.');
            redirect('auth/login');
        }
    }

    // Logout dan hapus session
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
