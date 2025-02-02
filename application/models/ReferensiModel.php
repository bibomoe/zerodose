<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReferensiModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to get referensi data from the API
    public function get_diagnosa_data($diagnosa) {

        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/referensi/diagnosa';

        // Construct query parameters
        $query_params = [];
        if ($diagnosa) {
            $query_params['diagnosa'] = $diagnosa;
        }

        // Initialize cURL
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $api_url . '?' . http_build_query($query_params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => true, // Enable SSL verification
        ));

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the response contains valid data
        if ($data['code'] == '200' && isset($data['response_data'])) {
            return $data['response_data'];  // Return the response_data part of the JSON
        }

        return []; // Return an empty array if no data or error occurred
    }

    // Function to get referensi data from the API
    public function get_procedure_data($procedure) {

        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/referensi/procedure';

        // Construct query parameters
        $query_params = [];
        if ($procedure) {
            $query_params['procedure'] = $procedure;
        }

        // Initialize cURL
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $api_url . '?' . http_build_query($query_params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => true, // Enable SSL verification
        ));

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the response contains valid data
        if ($data['code'] == '200' && isset($data['response_data'])) {
            return $data['response_data'];  // Return the response_data part of the JSON
        }

        return []; // Return an empty array if no data or error occurred
    }

    // Function to get referensi data from the API
    public function get_poli_data($poli) {

        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/referensi/poli';

        // Construct query parameters
        $query_params = [];
        if ($poli) {
            $query_params['poli'] = $poli;
        }

        // Initialize cURL
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $api_url . '?' . http_build_query($query_params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => true, // Enable SSL verification
        ));

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the response contains valid data
        if ($data['code'] == '200' && isset($data['response_data'])) {
            return $data['response_data'];  // Return the response_data part of the JSON
        }

        return []; // Return an empty array if no data or error occurred
    }

    // Function to get referensi data from the API
    public function get_faskes_data($nama_faskes,$jenis_faskes) {

        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/referensi/faskes';

        // Construct query parameters
        $query_params = [];
        if ($nama_faskes) {
            $query_params['nama_faskes'] = $nama_faskes;
        }
        if ($jenis_faskes) {
            $query_params['jenis_faskes'] = $jenis_faskes;
        }

        // Initialize cURL
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $api_url . '?' . http_build_query($query_params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => true, // Enable SSL verification
        ));

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the response contains valid data
        if ($data['code'] == '200' && isset($data['response_data'])) {
            return $data['response_data'];  // Return the response_data part of the JSON
        }

        return []; // Return an empty array if no data or error occurred
    }
}

?>
