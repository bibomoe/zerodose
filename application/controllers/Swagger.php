<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Swagger extends CI_Controller {

    public function index()
    {
        // Load the view for Swagger UI
        $this->load->view('swagger');
    }
}
