<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to insert data into 'immunization_data' table
    public function insertData($data) {
        // Insert the data into the table
        $this->db->insert('immunization_data', $data);

        // Check for database errors
        $error = $this->db->error(); // Get the error if there is one
        if ($error['code'] != 0) {
            log_message('error', 'Database Error: ' . $error['message']);
            // Optionally, you can show the error for debugging
            echo "Error: " . $error['message'];
        }
    }

    // Function to split code and name
    public function splitCodeName($value) {
        // Check if value contains a hyphen (-), if so split it into code and name
        if (strpos($value, '-') !== false) {
            list($code, $name) = explode(' - ', $value);
            return $code; // Only return the code
        }
        // If there's no hyphen, return the value as code
        return $value;
    }

    // Function to validate and insert province
    public function validate_and_insert_province($province) {
        // Split the value into code and name
        list($province_id, $province_name) = explode(' - ', $province);

        // Check if the province already exists in the database
        $province_data = $this->db->get_where('provinces', ['id' => $province_id])->row_array();

        if (!$province_data) {
            // If the province doesn't exist, insert it
            $this->db->insert('provinces', [
                'id' => $province_id,
                'name_id' => $province_name,
                'name_en' => $province_name, // Assuming name_en and name_id are the same
                'active' => 1
            ]);
        }

        return $province_id; // Return the province ID (either existing or newly inserted)
    }

    // Function to validate and insert city
    public function validate_and_insert_city($city, $province_id) {
        // Split the value into code and name
        list($city_id, $city_name) = explode(' - ', $city);

        // Check if the city already exists in the database
        $city_data = $this->db->get_where('cities', ['id' => $city_id])->row_array();

        if (!$city_data) {
            // If the city doesn't exist, insert it
            $this->db->insert('cities', [
                'id' => $city_id,
                'name_id' => $city_name,
                'province_id' => $province_id,
                'name_en' => $city_name, // Assuming name_en and name_id are the same
                'active' => 1
            ]);
        }

        return $city_id; // Return the city ID (either existing or newly inserted)
    }

    // Function to validate and insert subdistrict
    public function validate_and_insert_subdistrict($subdistrict, $city_id, $province_id) {
        // Split the value into code and name
        list($subdistrict_id, $subdistrict_name) = explode(' - ', $subdistrict);

        // Check if the subdistrict already exists in the database
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
        }

        return $subdistrict_id; // Return the subdistrict ID (either existing or newly inserted)
    }

    // Function to validate and insert puskesmas
    public function validate_and_insert_puskesmas($puskesmas, $subdistrict_id, $city_id, $province_id) {
        // Split the value into code and name
        list($puskesmas_id, $puskesmas_name) = explode(' - ', $puskesmas);

        // Check if the puskesmas already exists in the database
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
        }

        return $puskesmas_id; // Return the puskesmas ID (either existing or newly inserted)
    }
}
