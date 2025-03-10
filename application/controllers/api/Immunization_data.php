<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Include REST_Controller library
require APPPATH . '/libraries/REST_Controller.php';

// Use the correct namespace for REST_Controller
use Restserver\Libraries\REST_Controller;

class Immunization_data extends REST_Controller {

    public function __construct()
    {
        parent::__construct();

        // Set the request rate limits
        $this->methods['immunization_post']['limit'] = 100; // 100 requests per hour per user/key
    }

    /**
     * POST method for adding immunization data
     */
    public function immunization_post()
    {
        // Get the token from the Authorization header
        $token = $this->input->get_request_header('Authorization', TRUE);

        // Validate the token
        if (!$token) {
            $this->response([
                'status' => FALSE,
                'message' => 'Token is required'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // Verify the token (check against the session or another method)
        if ($token !== $this->session->userdata('user_token')) {
            $this->response([
                'status' => FALSE,
                'message' => 'Invalid token'
            ], REST_Controller::HTTP_UNAUTHORIZED); // 401 Unauthorized
        }

        // Receive the input data
        $data = [
            'province' => $this->post('province'), // Format: 11 - ACEH
            'city' => $this->post('city'), // Format: 1102 - KAB. ACEH TENGGARA
            'subdistrict' => $this->post('subdistrict'), // Format: 110201 - LAWE ALAS
            'puskesmas' => $this->post('puskesmas'), // Format: 1032292 - PANDAK I
            'year' => $this->post('year'),
            'month' => $this->post('month'),
            'dpt_hb_hib_1' => $this->post('dpt_hb_hib_1'),
            'dpt_hb_hib_2' => $this->post('dpt_hb_hib_2'),
            'dpt_hb_hib_3' => $this->post('dpt_hb_hib_3'),
            'mr_1' => $this->post('mr_1')
        ];

        // Validate and insert into the respective master tables
        $province_id = $this->validate_and_insert_province($data['province']);
        $city_id = $this->validate_and_insert_city($data['city'], $province_id);
        $subdistrict_id = $this->validate_and_insert_subdistrict($data['subdistrict'], $city_id, $province_id);
        $puskesmas_id = $this->validate_and_insert_puskesmas($data['puskesmas'], $subdistrict_id, $city_id, $province_id);

        // Prepare the data for insertion into the immunization_data table
        $immunization_data = [
            'province_id' => $province_id,
            'city_id' => $city_id,
            'subdistrict_id' => $subdistrict_id,
            'puskesmas_id' => $puskesmas_id,
            'year' => $data['year'],
            'month' => $data['month'],
            'dpt_hb_hib_1' => $data['dpt_hb_hib_1'],
            'dpt_hb_hib_2' => $data['dpt_hb_hib_2'],
            'dpt_hb_hib_3' => $data['dpt_hb_hib_3'],
            'mr_1' => $data['mr_1']
        ];

        // Check if the immunization data already exists based on puskesmas_id, year, and month
        $this->load->database();
        $existing_data = $this->db->get_where('immunization_data', [
            'puskesmas_id' => $puskesmas_id,
            'year' => $data['year'],
            'month' => $data['month']
        ])->row_array();

        if ($existing_data) {
            // If the data exists, update the record
            $this->db->where('id', $existing_data['id']);
            if ($this->db->update('immunization_data', $immunization_data)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Immunization data updated successfully'
                ], REST_Controller::HTTP_OK); // 200 OK
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to update immunization data'
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
            }
        } else {
            // If the data doesn't exist, insert it as a new record
            if ($this->db->insert('immunization_data', $immunization_data)) {
                $this->response([
                    'status' => TRUE,
                    'message' => 'Immunization data added successfully'
                ], REST_Controller::HTTP_CREATED); // 201 Created
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to add immunization data'
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR); // 500 Internal Server Error
            }
        }
    }

    /**
     * Helper function to validate and insert province
     */
    private function validate_and_insert_province($province)
    {
        // Split the input into ID and name
        list($province_id, $province_name) = explode(' - ', $province);

        // Validate if the province already exists in the database by id
        $this->load->database();
        $province_data = $this->db->get_where('provinces', ['id' => $province_id])->row_array();

        if (!$province_data) {
            // If the province doesn't exist, insert it
            $this->db->insert('provinces', [
                'id' => $province_id,
                'name_id' => $province_name,
                'name_en' => $province_name, // Assuming name_en and name_id are the same
                // 'order_number' => 0, // Optional default value
                'priority' => 0, // Optional default value
                'active' => 1
            ]);
            return $province_id; // Return the newly inserted province_id
        }

        return $province_data['id']; // Return the existing province_id
    }

    /**
     * Helper function to validate and insert city
     */
    private function validate_and_insert_city($city, $province_id)
    {
        // Split the input into ID and name
        list($city_id, $city_name) = explode(' - ', $city);

        // Check if the city name contains the word "Kota"
        $status = (strpos(strtolower($city_name), 'kota') !== false) ? 1 : 0;

        // Validate if the city already exists in the database by id
        $this->load->database();
        $city_data = $this->db->get_where('cities', ['id' => $city_id])->row_array();

        if (!$city_data) {
            // If the city doesn't exist, insert it
            $this->db->insert('cities', [
                'id' => $city_id,
                'name_id' => $city_name,
                'province_id' => $province_id,
                'name_en' => $city_name, // Assuming name_en and name_id are the same
                'status' => $status,
                'active' => 1
            ]);
            return $city_id; // Return the newly inserted city_id
        }

        return $city_data['id']; // Return the existing city_id
    }

    /**
     * Helper function to validate and insert subdistrict
     */
    private function validate_and_insert_subdistrict($subdistrict, $city_id, $province_id)
    {
        // Split the input into ID and name
        list($subdistrict_id, $subdistrict_name) = explode(' - ', $subdistrict);

        // Validate if the subdistrict already exists in the database by id
        $this->load->database();
        $subdistrict_data = $this->db->get_where('subdistricts', ['id' => $subdistrict_id])->row_array();

        if (!$subdistrict_data) {
            // If the subdistrict doesn't exist, insert it
            $this->db->insert('subdistricts', [
                'id' => $subdistrict_id,
                'name' => $subdistrict_name,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'active' => 1
            ]);
            return $subdistrict_id; // Return the newly inserted subdistrict_id
        }

        return $subdistrict_data['id']; // Return the existing subdistrict_id
    }

    /**
     * Helper function to validate and insert puskesmas
     */
    private function validate_and_insert_puskesmas($puskesmas, $subdistrict_id, $city_id, $province_id)
    {
        // Split the input into ID and name
        list($puskesmas_id, $puskesmas_name) = explode(' - ', $puskesmas);

        // Validate if the puskesmas already exists in the database by id
        $this->load->database();
        $puskesmas_data = $this->db->get_where('puskesmas', ['id' => $puskesmas_id])->row_array();

        if (!$puskesmas_data) {
            // If the puskesmas doesn't exist, insert it
            $this->db->insert('puskesmas', [
                'id' => $puskesmas_id,
                'name' => $puskesmas_name,
                'province_id' => $province_id,
                'city_id' => $city_id,
                'subdistrict_id' => $subdistrict_id,
                'active' => 1
            ]);
            return $puskesmas_id; // Return the newly inserted puskesmas_id
        }

        return $puskesmas_data['id']; // Return the existing puskesmas_id
    }
}
