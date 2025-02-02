<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicController extends CI_Controller {
    // Constructor untuk memuat model Faskes_model
    public function __construct() {
        parent::__construct();
        //Memuat Helper
        // $this->load->helper('template_helper');

        // Memuat library Curl yang baru dibuat
        // $this->load->library('curl');

        //Memuat model
        $this->load->model('MonitoringModel');
        $this->load->model('RujukanModel');
        $this->load->model('ReferensiModel');
    }

    public function index() {
        $data['title'] = 'Zero Dosed';
        $this->load->view('public/restored-zd-children', $data);  // Menggunakan helper untuk memuat template
    }


}
