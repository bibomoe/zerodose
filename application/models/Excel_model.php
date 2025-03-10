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
}
