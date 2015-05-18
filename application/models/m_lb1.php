<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lb1 extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function get_jml_kunjungan_per_usia($bln, $thn, $jk, $gol_umur, $icd)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kelamin', $jk);
		$this->db->where('kd_gol_umur', $gol_umur);
		$this->db->where('kd_penyakit', $icd);
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_jml_kunjungan_per_kasus($bln, $thn, $jk, $kasus, $icd)
	{
		$this->db->select('count(*) as jml');
		$this->db->from('v_lb1');
		$this->db->where('MONTH(tgl_pelayanan)', $bln);
		$this->db->where('YEAR(tgl_pelayanan)', $thn);
		$this->db->where('kd_jenis_kelamin', $jk);
		$this->db->where('kd_jenis_kasus', $kasus);
		$this->db->where('kd_penyakit', $icd);
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
}