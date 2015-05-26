<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_register_harian extends CI_Model {
	
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
	
	function get_pasien_rawat_umum_by_date($tgl, $kd_unit_pelayanan){

        $this->db->select('dokter.nm_dokter,pelayanan.kd_trans_pelayanan, pelayanan.tgl_pelayanan, pasien.no_reg, pelayanan.kd_rekam_medis, pasien.nm_lengkap, pasien.kd_jenis_kelamin, golongan_umur.gol_umur,cara_bayar.cara_bayar, unit_pelayanan.nm_unit, pasien.alamat, kelurahan.nm_kelurahan, kota.nm_kota, pelayanan_penyakit.kd_penyakit,jenis_kasus.jenis_kasus, GROUP_CONCAT(DISTINCT jenis_kasus.jenis_kasus SEPARATOR "; ") as jns_kasus, pelayanan_tindakan.kd_produk, GROUP_CONCAT(DISTINCT tindakan.produk SEPARATOR "; ") as tindakan, status_keluar_pasien.keterangan,GROUP_CONCAT(DISTINCT pelayanan_penyakit.kd_penyakit SEPARATOR "; ") as kd_icd, GROUP_CONCAT(DISTINCT icd.penyakit SEPARATOR "; ") as penyakit');
        $this->db->from('pelayanan');
        $this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
        $this->db->join('cara_bayar','pelayanan.kd_bayar = cara_bayar.kd_bayar','left');
        $this->db->join('unit_pelayanan','pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan','left');
        $this->db->join('status_keluar_pasien','pelayanan.kd_status_pasien = status_keluar_pasien.kd_status_pasien','left');
        $this->db->join('dokter','pelayanan.kd_dokter=dokter.kd_dokter','left');
		$this->db->join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');
		$this->db->join('kota','pasien.kd_kota=kota.kd_kota','left');
		$this->db->join('pelayanan_penyakit','pelayanan.kd_trans_pelayanan=pelayanan_penyakit.kd_trans_pelayanan','left');
		$this->db->join('icd','pelayanan_penyakit.kd_penyakit=icd.kd_penyakit','left');
		$this->db->join('pelayanan_tindakan','pelayanan.kd_trans_pelayanan=pelayanan_tindakan.kd_trans_pelayanan','left');
		$this->db->join('tindakan','pelayanan_tindakan.kd_produk=tindakan.kd_produk','left');
		$this->db->join('golongan_umur','pelayanan.kd_gol_umur=golongan_umur.kd_gol_umur');
		$this->db->join('jenis_kasus','pelayanan_penyakit.kd_jenis_kasus=jenis_kasus.kd_jenis_kasus','left');
		
        $this->db->where('pelayanan.tgl_pelayanan', $tgl);
		$this->db->where('pelayanan.kd_unit_pelayanan', $kd_unit_pelayanan);
		$this->db->group_by('pelayanan.kd_trans_pelayanan');
        $this->db->order_by('dokter.nm_dokter, pelayanan.kd_trans_pelayanan','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}