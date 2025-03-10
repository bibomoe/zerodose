<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Alias class to handle PhpSpreadsheet loading
use PhpOffice\PhpSpreadsheet\IOFactory;

class PhpExcel {

    // Function to load Excel file
    public function load($filePath) {
        return IOFactory::load($filePath);
    }

    // You can add more functions here as needed for other operations (e.g. writing to an Excel file)
}
