<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_kasir extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    function get_puskesmas_info($kd_puskesmas){
        $this->db->select('nm_puskesmas');
        $this->db->from('puskesmas');
        $this->db->where('kd_puskesmas', $kd_puskesmas);

        $query = $this->db->get();
        return $query->row_array();
    }
	function get_jenis_tindakan_info($kd_jenis_tindakan) {
		$this->db->select('jenis_tindakan');
		$this->db->from('jenis_tindakan');
		$this->db->where('kd_jenis_tindakan',$kd_jenis_tindakan);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_list_jenis_tindakan($id)
	{
		$this->db->select('*');
		$this->db->from('jenis_tindakan');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_total_uang($tgl_mulai, $tgl_akhir){

        $sql = $this->db->select('jenis_tindakan.jenis_tindakan,tindakan.produk, SUM(btindakan_detail.jml*tindakan.harga) as total_uang');
        $sql->from('btindakan_detail ');
		$sql->join('tindakan','btindakan_detail.kd_produk=tindakan.kd_produk','left');
		$sql->join('jenis_tindakan','jenis_tindakan.kd_jenis_tindakan=tindakan.kd_jenis_tindakan','left');
        $sql->where('btindakan_detail.tgl_bayar >=', $tgl_mulai);
		$sql->where('btindakan_detail.tgl_bayar <=', $tgl_akhir);
		$sql->order_by('tindakan.kd_jenis_tindakan');
		$sql->group_by('tindakan.kd_produk');
		//$sql->order_by('tindakan.kd_jenis_tindakan');
		
        $query = $this->db->get();
        return $query->result_array();
    }
	function get_total_uang_rekap($tgl_mulai, $tgl_akhir){

        $sql = $this->db->select('jenis_tindakan.jenis_tindakan,tindakan.produk, SUM(btindakan_detail.jml*tindakan.harga) as total_uang');
        $sql->from('btindakan_detail ');
		$sql->join('tindakan','btindakan_detail.kd_produk=tindakan.kd_produk','left');
		$sql->join('jenis_tindakan','jenis_tindakan.kd_jenis_tindakan=tindakan.kd_jenis_tindakan','left');
        $sql->where('btindakan_detail.tgl_bayar >=', $tgl_mulai);
		$sql->where('btindakan_detail.tgl_bayar <=', $tgl_akhir);
		$sql->group_by('tindakan.kd_jenis_tindakan');
		
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_detail_uang($tgl_mulai, $tgl_akhir, $kd_jenis_tindakan){

        $sql = $this->db->select('jenis_tindakan.jenis_tindakan, btindakan_detail.tgl_bayar, btindakan_detail.kd_bayar, tindakan.produk, btindakan_detail.jml, tindakan.harga, (btindakan_detail.jml*tindakan.harga) as sub_total, pasien.nm_lengkap');
        $sql->from('btindakan_detail ');
		$sql->join('tindakan','btindakan_detail.kd_produk=tindakan.kd_produk','left');
		$sql->join('jenis_tindakan','jenis_tindakan.kd_jenis_tindakan=tindakan.kd_jenis_tindakan','left');
		$sql->join('btindakan_header','btindakan_header.kd_bayar=btindakan_detail.kd_bayar','left');
		$sql->join('pasien','btindakan_header.kd_rekam_medis = pasien.kd_rekam_medis','left');
        $sql->where('btindakan_detail.tgl_bayar >=', $tgl_mulai);
		$sql->where('btindakan_detail.tgl_bayar <=', $tgl_akhir);
		if ($kd_jenis_tindakan != '') {
			$sql->where('tindakan.kd_jenis_tindakan', $kd_unit_pelayanan);
		}
		//$sql->where('tindakan.kd_jenis_tindakan', $kd_jenis_tindakan);
		$sql->order_by('jenis_tindakan.jenis_tindakan, btindakan_detail.kd_bayar');
		
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_jml_total_uang($tgl_mulai, $tgl_akhir, $kd_jenis_tindakan){

        $sql = $this->db->select('tindakan.kd_jenis_tindakan, btindakan_detail.tgl_bayar,  btindakan_detail.kd_bayar, btindakan_detail.jml, tindakan.harga, SUM(btindakan_detail.jml*tindakan.harga) as total');
        $sql->from('btindakan_detail');
		$sql->join('tindakan','btindakan_detail.kd_produk=tindakan.kd_produk','left');
		$sql->join('jenis_tindakan','jenis_tindakan.kd_jenis_tindakan=tindakan.kd_jenis_tindakan','left');
        $sql->where('btindakan_detail.tgl_bayar >=', $tgl_mulai);
		$sql->where('btindakan_detail.tgl_bayar <=', $tgl_akhir);
		if ($kd_jenis_tindakan != '') {
			$sql->where('tindakan.kd_jenis_tindakan', $kd_unit_pelayanan);
		}
		//$sql->where('tindakan.kd_jenis_tindakan', $kd_jenis_tindakan);
		
        $query = $this->db->get();
        return $query->row_array();
    }
	
}