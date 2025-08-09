<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cso_budget_model extends CI_Model
{
    // ---- DATA UNTUK GRAFIK (summary per CSO)
    public function get_summary_by_cso($year)
    {
        $alloc = $this->db->select('cso_id, SUM(amount) total_allocation', false)
            ->from('cso_allocation')
            ->where('year', (int)$year)
            ->group_by('cso_id')->get_compiled_select();

        $real  = $this->db->select('cso_id, SUM(amount) total_realization', false)
            ->from('cso_realization')
            ->where('year', (int)$year)
            ->group_by('cso_id')->get_compiled_select();

        return $this->db->select("
                    c.id AS cso_id, c.name AS name,
                    IFNULL(a.total_allocation,0) allocation,
                    IFNULL(r.total_realization,0) realization,
                    CASE WHEN IFNULL(a.total_allocation,0)>0
                         THEN ROUND(IFNULL(r.total_realization,0)/a.total_allocation*100,0)
                         ELSE 0 END AS percentage
                ", false)
                ->from("({$alloc}) a")
                ->join('cso_master c','c.id=a.cso_id','inner')   // hanya yg punya alokasi
                ->join("({$real}) r",'r.cso_id=c.id','left')
                ->order_by('c.name','asc')
                ->get()->result_array();
    }

    // ---- DATA UNTUK TABEL (CSO x Provinsi)
    // sort: 'cso' | 'wilayah'
    public function get_table_cso_province($year, $sort = 'cso')
    {
        // total alokasi & volume per CSO
        $alloc = $this->db->select('cso_id, SUM(amount) total_allocation, MAX(volume) volume', false)
            ->from('cso_allocation')->where('year', (int)$year)
            ->group_by('cso_id')->get_compiled_select();

        // serapan per provinsi per CSO (akumulasi bulanan)
        $real = $this->db->select('cso_id, province_id, SUM(amount) realization', false)
            ->from('cso_realization')->where('year', (int)$year)
            ->group_by(['cso_id','province_id'])->get_compiled_select();

        $this->db->select("
                c.id AS cso_id, c.name AS cso_name,
                p.id AS province_id, p.name_id AS province_name,
                IFNULL(a.total_allocation,0) allocation,
                IFNULL(a.volume,'') volume,
                IFNULL(r.realization,0) realization,
                CASE WHEN IFNULL(a.total_allocation,0)>0
                     THEN ROUND(IFNULL(r.realization,0)/a.total_allocation*100,0)
                     ELSE 0 END AS percentage
            ", false)
            ->from('cso_master c')
            ->join("({$alloc}) a",'a.cso_id=c.id','inner')    // hanya CSO yang punya alokasi
            ->join("({$real}) r",'r.cso_id=c.id','left')
            ->join('provinces p','p.id=r.province_id','left');

        // urutan
        if ($sort === 'wilayah') {
            $this->db->order_by('p.name_id','asc')->order_by('c.name','asc');
        } else {
            $this->db->order_by('c.name','asc')->order_by('p.name_id','asc');
        }

        return $this->db->get()->result_array();
    }
}

?>