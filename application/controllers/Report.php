<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('PartnersActivities_model');
        $this->load->model('Activity_model');
        $this->load->model('CountryObjective_model');
        $this->load->model('Partner_model');
        // $this->load->library('Tcpdf');
    }

    public function index($partner_id = 'all') {
        // Ambil daftar bulan
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Ambil session partner_category
        $partner_category = $this->session->userdata('partner_category');

        // Cek apakah partner_category valid
        $is_disabled = !empty($partner_category) && $partner_category != 0;

        // Tentukan filter partner berdasarkan session atau GET
        $partner_id = $is_disabled ? $partner_category : ($this->input->get('partner_id') ?? 'all');
        
        // Ambil data partner jika bukan 'all'
        $partner_name = ($partner_id === 'all') ? 'All Partners' : $this->db->get_where('partners', ['id' => $partner_id])->row()->name;

        // Ambil total target budget dari model berdasarkan filter
        $total_target_budget_2024 = ($partner_id === 'all') 
            ? $this->PartnersActivities_model->get_total_target_budget_by_year(2024) 
            : $this->PartnersActivities_model->get_target_budget_by_partner_and_year($partner_id, 2024);

        $total_target_budget_2025 = ($partner_id === 'all') 
            ? $this->PartnersActivities_model->get_total_target_budget_by_year(2025) 
            : $this->PartnersActivities_model->get_target_budget_by_partner_and_year($partner_id, 2025);

        // Ambil data budget absorption berdasarkan filter
        if ($partner_id === 'all') {
            $data_2024 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2024);
            $data_2025 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2025);
        } else {
            $data_2024 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2024, $partner_id, $total_target_budget_2024);
            $data_2025 = $this->Transaction_model->get_cumulative_budget_absorption_with_percentage(2025, $partner_id, $total_target_budget_2025);
        }

        // Format data untuk chart
        $budget_2024 = array_fill(0, 12, 0);
        $percentage_2024 = array_fill(0, 12, 0);
        $budget_2025 = array_fill(0, 12, 0);
        $percentage_2025 = array_fill(0, 12, 0);

        foreach ($data_2024 as $row) {
            $budget_2024[$row['MONTH'] - 1] = $row['total_budget'];
            $percentage_2024[$row['MONTH'] - 1] = $row['percentage'];
        }

        foreach ($data_2025 as $row) {
            $budget_2025[$row['MONTH'] - 1] = $row['total_budget'];
            $percentage_2025[$row['MONTH'] - 1] = $row['percentage'];
        }

        // Ambil data aktivitas berdasarkan filter
        if ($partner_id === 'all') {
            $total_activities = $this->Activity_model->get_total_activities_by_objectives();
            $completed_activities_2024 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024);
            $completed_activities_2025 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025);
        } else {
            $total_activities = $this->Activity_model->get_total_activities_by_objectives($partner_id);
            $completed_activities_2024 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2024, $partner_id);
            $completed_activities_2025 = $this->Activity_model->get_completed_activities_by_objectives_and_year(2025, $partner_id);
        }

        // Ambil daftar country objectives
        $objectives = $this->CountryObjective_model->get_all_objectives();
        $total_activities_data = array_fill(0, count($objectives), 0);
        $completed_activities_2024_data = array_fill(0, count($objectives), 0);
        $completed_activities_2025_data = array_fill(0, count($objectives), 0);

        foreach ($total_activities as $activity) {
            $index = $activity['objective_id'] - 1;
            $total_activities_data[$index] = (int) $activity['total'];
        }

        foreach ($completed_activities_2024 as $activity) {
            $index = $activity['objective_id'] - 1;
            $completed_activities_2024_data[$index] = (int) $activity['completed'];
        }

        foreach ($completed_activities_2025 as $activity) {
            $index = $activity['objective_id'] - 1;
            $completed_activities_2025_data[$index] = (int) $activity['completed'];
        }

        // Buat objek PDF
        // **1. Pastikan TCPDF sudah ada di lokasi yang benar**
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php'); 
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Grant Implementation Report');
        $pdf->SetHeaderData('', 0, 'Grant Implementation Report', "Partner: $partner_name");

        $pdf->SetMargins(15, 20, 15);
        $pdf->AddPage();

        $html = '<h2 style="text-align:center;">Grant Implementation Report</h2>';
        $html .= "<p><strong>Partner:</strong> $partner_name</p>";
        $html .= "<p><strong>Total Budget 2024:</strong> " . number_format($total_target_budget_2024, 0, ',', '.') . " IDR</p>";
        $html .= "<p><strong>Total Budget 2025:</strong> " . number_format($total_target_budget_2025, 0, ',', '.') . " IDR</p>";

        // URL API QuickChart untuk grafik budget absorption
        $chartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
            'type' => 'line',
            'data' => [
                'labels' => $months,
                'datasets' => [
                    [
                        'label' => '2024 Budget Absorption (%)',
                        'data' => $percentage_2024,
                        'borderColor' => 'blue',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => '2025 Budget Absorption (%)',
                        'data' => $percentage_2025,
                        'borderColor' => 'green',
                        'borderWidth' => 2,
                        'fill' => false
                    ]
                ]
            ],
            'options' => [
                'scales' => [
                    // 'yAxes' => [[ 'ticks' => [ 'beginAtZero' => true ]]]
                    'yAxes' => [[ 
                        'ticks' => [
                            'beginAtZero' => true,
                            'max' => 100  // Set maksimum 100% untuk Y-axis
                        ]
                    ]]

                ]
            ]
        ]));

        // Konversi grafik menjadi Base64
        $chartImageData = file_get_contents($chartUrl);
        $chartImageBase64 = 'data:image/png;base64,' . base64_encode($chartImageData);

        // Buat label yang lebih pendek untuk grafik (Obj 1, Obj 2, Obj 3, ...)
        $short_objectives = array_map(function($key) {
            return 'Obj ' . ($key + 1);
        }, array_keys($objectives));

        // URL API QuickChart untuk grafik aktivitas (Bar Chart)
        $barChartUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $short_objectives, // Menggunakan label yang lebih pendek
                'datasets' => [
                    [
                        'label' => 'Total Activities',
                        'data' => $total_activities_data,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.8)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'Completed 2024',
                        'data' => $completed_activities_2024_data,
                        'backgroundColor' => 'rgba(75, 192, 192, 0.8)',
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'Completed 2025',
                        'data' => $completed_activities_2025_data,
                        'backgroundColor' => 'rgba(255, 99, 132, 0.8)',
                        'borderColor' => 'rgba(255, 99, 132, 1)',
                        'borderWidth' => 1
                    ]
                ]
            ],
            'options' => [
                'scales' => [
                    'xAxes' => [[
                        'ticks' => [
                            'autoSkip' => false,
                            'maxRotation' => 0,  // Membuat label tetap horizontal
                            'minRotation' => 0
                        ]
                    ]],
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                            'precision' => 0
                        ]
                    ]]
                ],
                'legend' => [
                    'position' => 'top',
                    'align' => 'center'
                ],
                'title' => [
                    'display' => true,
                    'text' => 'Activities Conducted by Objectives',
                    'fontSize' => 16
                ]
            ]
        ]));

        // Konversi grafik menjadi Base64
        $barChartImageData = file_get_contents($barChartUrl);
        $barChartImageBase64 = 'data:image/png;base64,' . base64_encode($barChartImageData);



        // Bagian 1: Budget Absorption Table
        $html .= '<h3>Bagian 1 - Tabel Budget Absorption</h3>';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Absorbed Budget 2024</th>
                            <th>% Absorption 2024</th>
                            <th>Absorbed Budget 2025</th>
                            <th>% Absorption 2025</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($months as $index => $month) {
            $html .= "<tr>
                        <td>$month</td>
                        <td>" . number_format($budget_2024[$index], 0, ',', '.') . "</td>
                        <td>" . round($percentage_2024[$index], 2) . "%</td>
                        <td>" . number_format($budget_2025[$index], 0, ',', '.') . "</td>
                        <td>" . round($percentage_2025[$index], 2) . "%</td>
                      </tr>";
        }
        $html .= '</tbody></table>';

        // Bagian 2: Activities Conducted Table
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Ln(10);

        $html .= '<h3 style="font-weight: bold;">Bagian 2 - Tabel Activities Conducted</h3>';
        $html .= '<table border="1" cellspacing="0" cellpadding="4">
                    <thead>
                        <tr style="font-weight: bold; background-color: #f2f2f2; text-align: center;">
                            <th>No</th>
                            <th style="text-align: left;">Country Objective</th>
                            <th>Total Activities</th>
                            <th>Completed 2024</th>
                            <th>Completed 2025</th>
                        </tr>
                    </thead>
                    <tbody>';
                    
        $no = 1;
        foreach ($objectives as $index => $objective) {
            $html .= "<tr>
                        <td align='center'>".$no++."</td>
                        <td style='text-align: left;'>{$objective['objective_name']}</td>
                        <td align='center'>{$total_activities_data[$index]}</td>
                        <td align='center'>{$completed_activities_2024_data[$index]}</td>
                        <td align='center'>{$completed_activities_2025_data[$index]}</td>
                    </tr>";
        }
        $html .= '</tbody></table>';
        
        $pdf->writeHTML($html, true, false, true, false, '');

        // Tambahkan halaman baru sebelum menampilkan gambar grafik
        $pdf->AddPage();

        // Tampilkan grafik di halaman kedua setelah tabel
        $pdf->Image('@' . base64_decode(str_replace('data:image/png;base64,', '', $chartImageBase64)), 15, 40, 180, 90, 'PNG');

        // Tambahkan ruang kosong agar gambar tidak bertumpuk dengan konten berikutnya
        $pdf->Ln(100);

        $pdf->AddPage();
        $pdf->Image('@' . base64_decode(str_replace('data:image/png;base64,', '', $barChartImageBase64)), 15, 50, 180, 90, 'PNG');

        // Tambahkan halaman baru jika ingin menambahkan grafik lain atau data tambahan
        // $pdf->AddPage();

        ob_end_clean(); // Bersihkan output buffer sebelum mengirim PDF
        $pdf->Output('Grant_Report.pdf', 'I');
        exit();
    }
}
?>
