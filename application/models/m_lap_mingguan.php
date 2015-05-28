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

        $this->db->select('pelayanan_penyakit.kd_penyakit, icd.penyakit,kelurahan.nm_kelurahan, golongan_umur.gol_umur, Count(*) AS jml');
        $this->db->from('pelayanan');
        $this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
        $this->db->join('unit_pelayanan','pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan','left');
        $this->db->join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');
		$this->db->join('pelayanan_penyakit','pelayanan_penyakit.kd_trans_pelayanan=pelayanan.kd_trans_pelayanan','left');
		$this->db->join('icd','icd.kd_penyakit=pelayanan_penyakit.kd_penyakit','left');
		$this->db->join('golongan_umur','pelayanan_penyakit.kd_gol_umur = golongan_umur.kd_gol_umur','left');
		
        $this->db->where('pelayanan.tgl_pelayanan >=', $tgl_mulai);
		$this->db->where('pelayanan.tgl_pelayanan <=', $tgl_akhir);
		$this->db->where('pelayanan.kd_unit_pelayanan', $kd_unit_pelayanan);
		$this->db->group_by('pasien.kd_kelurahan, pelayanan_penyakit.kd_gol_umur');
        $this->db->order_by('pelayanan_penyakit.kd_penyakit, kelurahan.nm_kelurahan','ASC');
		
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

        $this->db->select('pasien.nm_lengkap, pasien.kd_jenis_kelamin, pelayanan.umur, pasien.idkartu_medical, pasien.alamat, kelurahan.nm_kelurahan, kecamatan.nm_kecamatan, kartu_medical.nama_kk');
        $this->db->from('pelayanan');
        $this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
        $this->db->join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');
		$this->db->join('pelayanan_penyakit','pelayanan_penyakit.kd_trans_pelayanan=pelayanan.kd_trans_pelayanan', 'left');
		$this->db->join('icd','icd.kd_penyakit=pelayanan_penyakit.kd_penyakit','left');
		$this->db->join('kecamatan','pasien.kd_kecamatan = kecamatan.kd_kecamatan','left');
		$this->db->join('kartu_medical','pasien.idkartu_medical = kartu_medical.idkartu_medical','left');
        $this->db->where('pelayanan.tgl_pelayanan >=', $tgl_mulai);
		$this->db->where('pelayanan.tgl_pelayanan <=', $tgl_akhir);
		$this->db->where('pelayanan_penyakit.kd_penyakit', $kd_penyakit);
        $this->db->order_by('pasien.nm_lengkap','ASC');
		
        $query = $this->db->get();
        return $query->result_array();
    }
	
}