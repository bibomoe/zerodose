<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function load_template($view, $data = []) {
    $CI =& get_instance();
    $CI->load->view('templates/header', $data);
    $CI->load->view('templates/sidebar');
    $CI->load->view($view, $data);
    $CI->load->view('templates/footer');
}