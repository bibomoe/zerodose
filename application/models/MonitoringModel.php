<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonitoringModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to fetch SEP data from the API
    public function get_sep_data($tgl_sep = null, $jenis_pelayanan = null) {
        // API base URL
        $api_url = 'http://127.0.0.1:8083/monitoring/data_kunjungan';

        // Add query parameters if available
        $query_params = [];
        if ($tgl_sep) {
            $query_params['tgl_sep'] = $tgl_sep;
        }
        if ($jenis_pelayanan) {
            $query_params['jns_pelayanan'] = $jenis_pelayanan;
        }

        // Make cURL request to fetch data from API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($query_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            // If cURL error occurs
            log_message('error', 'cURL Error: ' . curl_error($ch));
            return false;
        }
        curl_close($ch);

        // Decode JSON response
        $response_data = json_decode($response, true);

        // Check if the response contains data
        if (isset($response_data['response_data']['sep'])) {
            return $response_data['response_data']['sep'];
        }

        return [];
    }

    // Function to fetch klaim data from the API
    public function get_klaim_data($tgl_sep = null, $jenis_pelayanan = null, $status = null) {
        // API base URL
        $api_url = 'http://127.0.0.1:8083/monitoring/data_klaim';

        // Construct query parameters
        $query_params = [];
        if ($tgl_sep) {
            $query_params['tgl_sep'] = $tgl_sep;
        }
        if ($jenis_pelayanan) {
            $query_params['jns_pelayanan'] = $jenis_pelayanan;
        }
        if ($status) {
            $query_params['status'] = $status;
        }

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($query_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);  // Timeout
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for development

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        // Get the HTTP status code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check if the request was successful
        if ($http_code != 200) {
            log_message('error', "API returned HTTP status code: $http_code");
            return false;
        }

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the response contains valid data
        if ($data['code'] == '200' && isset($data['response_data']['klaim'])) {
            return $data['response_data']['klaim'];  // Return the klaim data
        }

        return [];
    }

    // Function to fetch service history data from the API
    public function get_histori_data($no_kepesertaan, $tgl_mulai, $tgl_akhir) {
        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/monitoring/data_history_pelayanan_peserta';

        // // Build query parameters
        // $query_params = [
        //     'no_kepesertaan' => $no_kepesertaan,
        //     'tgl_mulai' => $tgl_mulai,
        //     'tgl_akhir' => $tgl_akhir
        // ];

        // Construct query parameters
        $query_params = [];
        if ($no_kepesertaan) {
            $query_params['no_kepesertaan'] = $no_kepesertaan;
        }
        if ($tgl_mulai) {
            $query_params['tgl_mulai'] = $tgl_mulai;
        }
        if ($tgl_akhir) {
            $query_params['tgl_akhir'] = $tgl_akhir;
        }

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($query_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification if needed

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the response contains valid data
        if ($data['code'] == '200' && isset($data['response_data']['histori'])) {
            return $data['response_data']['histori'];  // Return the "histori" data
        }

        return []; // Return an empty array if no data
    }

    public function get_klaim_jasa_raharja($jenis_pelayanan, $tgl_mulai, $tgl_akhir) {
        // API endpoint URL
        $api_url = 'http://127.0.0.1:8083/monitoring/data_klaim_jasa_raharja';

        // Construct query parameters
        $query_params = [];
        if ($jenis_pelayanan) {
            $query_params['jns_pelayanan'] = $jenis_pelayanan;
        }
        if ($tgl_mulai) {
            $query_params['tgl_mulai'] = $tgl_mulai;
        }
        if ($tgl_akhir) {
            $query_params['tgl_akhir'] = $tgl_akhir;
        }

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($query_params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification if needed

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        // echo $response;
        // Decode the JSON response
        $data = json_decode($response, true);

        // Check if the response contains valid data
        if ($data['code'] == '200' && isset($data['response_data']['jaminan'])) {
            return $data['response_data']['jaminan'];  // Return the "jaminan" data
        }

        return []; // Return an empty array if no data or error occurred
    }
}
?>
