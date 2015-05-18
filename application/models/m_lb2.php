<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lb2 extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	function get_stok_all($bln, $thn){
		$table_name = 'lb2_'.$bln;
		$this->db->select("$table_name.* , obat.nama_obat, satuan_kecil.sat_kecil_obat");
		$this->db->from($table_name);
		$this->db->join('obat', "$table_name.kd_obat = obat.kd_obat");
		$this->db->join('satuan_kecil','obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat');
		$this->db->where('tahun', $thn);
		$this->db->group_by('kd_obat'); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_stok($bln, $thn, $kd_obat)
	{
		$table_name = 'lb2_'.$bln;
		$query = $this->db->query("select jml_keluar from $table_name where tahun = '$thn' and kd_obat='$kd_obat'");
		foreach ($query->result() as $row){
			return $row->jml_keluar;
		}
	}
	
	function get_stok_opname($cur_month, $cur_year, $kd_obat)
	{
		if($cur_month == 1){
			$bln = 11;
			$thn = $cur_year-1;
			
			$latest = $this->get_stok($cur_month, $cur_year, $kd_obat);
			$total = $latest;
			
			for($i=1; $i<=2; $i++){
				$x = $this->get_stok($bln, $thn, $kd_obat);
				$total = $total + $x;
				$bln++; 
			}
			
		}else {
			$bln = $cur_month-2;
			$thn = $cur_year;
			
			$total = 0;
			
			for($i=1; $i<=3; $i++){
				$x = $this->get_stok($bln, $thn, $kd_obat);
				$total = $total + $x;
				$bln++; 
			}
		}
		
		$stok_opt = ($total * 4)/3;
		
		return $stok_opt;
	}
}