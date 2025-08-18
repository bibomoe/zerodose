<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Budget_model extends CI_Model
{
    /**
     * Rekap nasional per provinsi.
     * Jika $menu_id = 'all' maka total semua menu, jika angka maka filter per menu.
     */
    public function get_budget_by_province($year, $menu_id = 'all')
    {
        // Subquery alokasi per provinsi
        $alloc = $this->db->select('province_id, SUM(amount) AS total_allocation', false)
            ->from('budget_allocation')
            ->where('year', (int)$year);

        if ($menu_id !== 'all') { 
            $alloc->where('menu_id', (int)$menu_id); 
        }
        $alloc = $alloc->group_by('province_id')->get_compiled_select();

        // Subquery serapan per provinsi (akumulasi bulanan)
        $real = $this->db->select('province_id, SUM(amount) AS total_realization', false)
            ->from('budget_realization')
            ->where('year', (int)$year);

        if ($menu_id !== 'all') { 
            $real->where('menu_id', (int)$menu_id); 
        }
        $real = $real->group_by('province_id')->get_compiled_select();

        // Main query – hanya provinsi yang ada di allocation
        $this->db->select("
            p.id AS region_id,
            p.name_id AS name,
            IFNULL(a.total_allocation, 0) AS allocation,
            IFNULL(r.total_realization, 0) AS realization,
            CASE 
                WHEN IFNULL(a.total_allocation,0) > 0 
                THEN ROUND(IFNULL(r.total_realization,0) / a.total_allocation * 100, 0)
                ELSE 0
            END AS percentage
        ", false)
        ->from("({$alloc}) a") // ganti source utama jadi allocation
        ->join('provinces p', 'p.id = a.province_id', 'inner')
        ->join("({$real}) r", 'r.province_id = p.id', 'left')
        ->order_by('p.name_id', 'asc');

        return $this->db->get()->result_array();
    }

    public function get_budget_by_province_breakdown($year)
    {
        // Ambil semua menu aktif
        $menus = $this->db->get_where('menu_objective', ['active' => 1])->result_array();

        // Ambil alokasi & realisasi total per provinsi
        $this->db->select('
            p.id AS region_id,
            p.name_id AS name,
            COALESCE(SUM(b1.amount), 0) AS allocation,
            COALESCE(SUM(b2.amount), 0) AS realization,
            CASE
                WHEN COALESCE(SUM(b1.amount), 0) > 0
                THEN ROUND(SUM(b2.amount) / SUM(b1.amount) * 100, 0)
                ELSE 0
            END AS percentage
        ');
        $this->db->from('provinces p');
        $this->db->join('budget_allocation b1', 'b1.province_id = p.id AND b1.year = ' . (int)$year, 'left');
        $this->db->join('budget_realization b2', 'b2.province_id = p.id AND b2.year = ' . (int)$year, 'left');
        $this->db->group_by('p.id');
        $results = $this->db->get()->result_array();

        // Ambil realisasi per provinsi per menu
        $breakdown = [];
        foreach ($menus as $menu) {
            $menu_id = $menu['id'];
            $q = $this->db->select('province_id, SUM(amount) AS total', false)
                ->from('budget_realization')
                ->where('year', (int)$year)
                ->where('menu_id', $menu_id)
                ->group_by('province_id')
                ->get()
                ->result_array();

            foreach ($q as $r) {
                $breakdown[$r['province_id']][$menu_id] = $r['total'];
            }
        }

        // Gabungkan realisasi per menu ke result utama
        foreach ($results as &$row) {
            $row['menus'] = [];
            $prov_id = $row['region_id'];
            foreach ($menus as $menu) {
                $menu_id = $menu['id'];
                $real = isset($breakdown[$prov_id][$menu_id]) ? $breakdown[$prov_id][$menu_id] : 0;
                $alloc = $row['allocation'];
                $row['menus'][$menu_id] = [
                    'real' => $real,
                    'percentage' => $alloc > 0 ? round(($real / $alloc) * 100) : 0
                ];
            }
        }

        return $results;
    }


}

?>
