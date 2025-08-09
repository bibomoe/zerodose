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

        if ($menu_id !== 'all') { $alloc->where('menu_id', (int)$menu_id); }
        $alloc = $alloc->group_by('province_id')->get_compiled_select();

        // Subquery serapan per provinsi (akumulasi bulanan)
        $real = $this->db->select('province_id, SUM(amount) AS total_realization', false)
            ->from('budget_realization')
            ->where('year', (int)$year);

        if ($menu_id !== 'all') { $real->where('menu_id', (int)$menu_id); }
        $real = $real->group_by('province_id')->get_compiled_select();

        // Main query
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
        ->from('provinces p')
        ->join("({$alloc}) a", 'a.province_id = p.id', 'left')
        ->join("({$real}) r", 'r.province_id = p.id', 'left')
        ->order_by('p.name_id', 'asc');

        return $this->db->get()->result_array();
    }
}

?>
