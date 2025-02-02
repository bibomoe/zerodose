<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RujukanModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to get rujukan data from the API
    public function get_rujukan_data($no_rujukan, $asal_rujukan) {
        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/rujukan/no_rujukan';

        // Construct query parameters
        $query_params = [];
        if ($no_rujukan) {
            $query_params['no_rujukan'] = $no_rujukan;
        }
        if ($asal_rujukan) {
            $query_params['asal_rujukan'] = $asal_rujukan;
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

    // Function to get rujukan data from the API
    public function get_rujukan_data_by_no_kepesertaan($no_kepesertaan, $asal_rujukan) {
        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/rujukan/no_rujukan_no_kartu';

        // Construct query parameters
        $query_params = [];
        if ($no_kepesertaan) {
            $query_params['no_kepesertaan'] = $no_kepesertaan;
        }
        if ($asal_rujukan) {
            $query_params['asal_rujukan'] = $asal_rujukan;
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
        // echo $response;

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

    public function get_jumlah_sep_rujukan_data($no_rujukan, $jenis_rujukan) {
        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/rujukan/data_jumlah_sep_rujukan';

        // Construct query parameters
        $query_params = [];
        if ($no_rujukan) {
            $query_params['no_rujukan'] = $no_rujukan;
        }
        if ($jenis_rujukan) {
            $query_params['jenis_rujukan'] = $jenis_rujukan;
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
