<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_lap_mingguan extends CI_Model {
	
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
	
	function get_unit_pelayanan_info($kd_unit_pelayanan) {
		$this->db->select('nm_unit');
		$this->db->from('unit_pelayanan');
		$this->db->where('kd_unit_pelayanan',$kd_unit_pelayanan);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_pelayanan_penyakit_by_date($tgl_mulai, $tgl_akhir, $kd_unit_pelayanan){

        $sql = $this->db->select('pelayanan_penyakit.kd_penyakit, icd.penyakit,kelurahan.nm_kelurahan, golongan_umur.gol_umur, Count(*) AS jml');
        $sql->from('pelayanan_penyakit');
		$sql->join('pelayanan','pelayanan_penyakit.kd_trans_pelayanan=pelayanan.kd_trans_pelayanan','left');
        $sql->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
        $sql->join('unit_pelayanan','pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan','left');
        $sql->join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');
		$sql->join('icd','icd.kd_penyakit=pelayanan_penyakit.kd_penyakit','left');
		$sql->join('golongan_umur','pelayanan_penyakit.kd_gol_umur = golongan_umur.kd_gol_umur','left');
		
        $sql->where('pelayanan.tgl_pelayanan >=', $tgl_mulai);
		$sql->where('pelayanan.tgl_pelayanan <=', $tgl_akhir);
		
		if ($kd_unit_pelayanan != '') {
			$sql->where('pelayanan.kd_unit_pelayanan', $kd_unit_pelayanan);
		}	
		//$this->db->where('pelayanan.kd_unit_pelayanan', $kd_unit_pelayanan);
		$sql->group_by('pasien.kd_kelurahan, pelayanan_penyakit.kd_gol_umur');
        $sql->order_by('pelayanan_penyakit.kd_penyakit, kelurahan.nm_kelurahan','ASC');
		
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_penyakit_info($kd_penyakit) {
		$this->db->select('penyakit');
		$this->db->from('icd');
		$this->db->where('kd_penyakit',$kd_penyakit);
		$query = $this->db->get();
		return $query->row_array();
	}
	function get_pelayanan_penyakit_by_icd($tgl_mulai, $tgl_akhir, $kd_penyakit){

        $sql = $this->db->select('pasien.nm_lengkap, pasien.kd_jenis_kelamin, pelayanan.umur, pasien.idkartu_medical, pasien.alamat, kelurahan.nm_kelurahan, kecamatan.nm_kecamatan, kartu_medical.nama_kk, jenis_kasus.jenis_kasus, icd.penyakit');
        $sql->from('pelayanan');
		$sql->join('pelayanan_penyakit','pelayanan_penyakit.kd_trans_pelayanan=pelayanan.kd_trans_pelayanan', 'left');
		$sql->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
        $sql->join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');
		$sql->join('jenis_kasus','pelayanan_penyakit.kd_jenis_kasus = jenis_kasus.kd_jenis_kasus', 'left');
		$sql->join('icd','icd.kd_penyakit=pelayanan_penyakit.kd_penyakit','left');
		$sql->join('kecamatan','pasien.kd_kecamatan = kecamatan.kd_kecamatan','left');
		$sql->join('kartu_medical','pasien.idkartu_medical = kartu_medical.idkartu_medical','left');
        $sql->where('pelayanan.tgl_pelayanan >=', $tgl_mulai);
		$sql->where('pelayanan.tgl_pelayanan <=', $tgl_akhir);
		if ($kd_penyakit != '') {
			$sql->where('pelayanan_penyakit.kd_penyakit', $kd_penyakit);
		}
		//$sql->where('pelayanan_penyakit.kd_penyakit', $kd_penyakit);
        $sql->order_by('pasien.nm_lengkap','ASC');
		
        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_apotek_out_by_date($tgl_mulai, $tgl_akhir){
        $this->db->select('brg_apotek_keluar_detail.tgl_keluar, brg_apotek_keluar_detail.kd_obat, brg_apotek_keluar_detail.nama_obat, sum(brg_apotek_keluar_detail.jml) as total, brg_apotek_keluar_detail.sat_kecil_obat');
        $this->db->from('brg_apotek_keluar_detail');
        		
        $this->db->where('brg_apotek_keluar_detail.tgl_keluar >=', $tgl_mulai);
		$this->db->where('brg_apotek_keluar_detail.tgl_keluar <=', $tgl_akhir);
		$this->db->group_by('brg_apotek_keluar_detail.kd_obat');
        $this->db->order_by('brg_apotek_keluar_detail.nama_obat','ASC');
		
        $query = $this->db->get();
        return $query->result_array();
		
	}
	
}