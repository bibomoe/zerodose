<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Include REST_Controller library
require APPPATH . '/libraries/REST_Controller.php';

// Use the correct namespace for REST_Controller
use Restserver\Libraries\REST_Controller;

class Stockout extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        // Set the request rate limits
        $this->methods['puskesmas_stock_out_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->load->helper('jwt_helper');  // Pastikan sudah load helper
    }

    /**
     * POST method for adding puskesmas stock out details
     */
    public function puskesmas_stock_out_post()
    {
        // Get the token from the Authorization header (format: Bearer <token>)
        $token = $this->input->get_request_header('Authorization', TRUE);

        // Validate the token format (Authorization: Bearer <token>)
        if (!$token) {
            $this->response([
                'status' => FALSE,
                'message' => 'Token is required'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
            return;
        }

        // Validate the token format (Authorization: Bearer <token>)
        if (!$token || !preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            $this->response([
                'status' => FALSE,
                'message' => 'Token is required or invalid format'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        $token = $matches[1];  // Extract token from the format "Bearer <token>"

        if (empty($token)) {
            // If token is empty, respond with a clear error message
            $this->response([
                'status' => FALSE,
                'message' => 'Token cannot be empty'
            ], REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }

        $jwt_helper = new Jwt_helper();  // Membuat objek Jwt_helper
        // Decode the token using Jwt_helper
        $decoded = $jwt_helper->decode($token);

        // If decoding fails or the token is invalid
        if (!$decoded) {
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid token'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // Now that the token is valid, you can extract the user information
        $user_data = $decoded; // This will have the decoded data from JWT

        // Proceed with receiving the input data
        $data = [
            'year' => $this->post('year'),
            'month' => $this->post('month'),
            'province_id' => $this->post('province_id'),
            'city_id' => $this->post('city_id'),
            'subdistrict_id' => $this->post('subdistrict_id'),  // The new field
            'puskesmas_id' => $this->post('puskesmas_id'),
            'status_stockout' => $this->post('status_stockout')
            // 'DPT_HB_Hib_5_ds' => $this->post('DPT_HB_Hib_5_ds'),
            // 'Pentavalent_Easyfive_10_ds' => $this->post('Pentavalent_Easyfive_10_ds'),
            // 'Pentavac_10_ds' => $this->post('Pentavac_10_ds'),
            // 'Vaksin_ComBE_Five_10_ds' => $this->post('Vaksin_ComBE_Five_10_ds')
        ];

        // Validate if puskesmas_id is valid (check against database)
        $this->load->database();
        $puskesmas_data = $this->db->get_where('puskesmas', ['id' => $data['puskesmas_id']])->row_array();

        if (!$puskesmas_data) {
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid puskesmas_id'
            ], REST_Controller::HTTP_BAD_REQUEST); // 400 Bad Request
        }

        // Check if the combination of puskesmas_id, year, and month already exists
        $existing_data = $this->db->get_where('puskesmas_stock_out_details', [
            'puskesmas_id' => $data['puskesmas_id'],
            'year' => $data['year'],
            'month' => $data['month']
        ])->row_array();

        if ($existing_data) {
            // If data exists, update the record
            $this->db->where('id', $existing_data['id']);
            if ($this->db->update('puskesmas_stock_out_details', $data)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Stock out details updated successfully'
                ], REST_Controller::HTTP_OK); // 200 OK
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to update stock out details'
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
            }
        } else {
            // If the data doesn't exist, insert it as a new record
            if ($this->db->insert('puskesmas_stock_out_details', $data)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Stock out details added successfully'
                ], REST_Controller::HTTP_CREATED); // 201 Created
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to add stock out details'
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
            }
        }
    }
}
