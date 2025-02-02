<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller {
    // Constructor untuk memuat model Faskes_model
    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // Load library session
    }

    public function index() {
        $data['title'] = 'Zero Dosed';
        $this->load->view('landing', $data);  // Menggunakan helper untuk memuat template
    }

    public function login() {
        $data['title'] = 'Login';
        $this->load->view('login', $data);  // Menggunakan helper untuk memuat template
    }

    public function tes() {
        $data['title'] = 'tes';
        $this->load->view('tes', $data);  // Menggunakan helper untuk memuat template
    }

}
