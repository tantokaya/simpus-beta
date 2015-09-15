<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_rujukan extends CI_Model {
	
	function __construct()
    {
        parent::__construct();

    }

    function get_puskesmas_info($kd_puskesmas){
        $this->db->select('set_puskesmas.*, kecamatan.nm_kecamatan, kota.nm_kota, propinsi.nm_propinsi, kelurahan.nm_kelurahan,jenis_puskesmas.jenis_puskesmas');
        $this->db->from('set_puskesmas');
        $this->db->where('status', '1');
        $this->db->join('kecamatan', 'set_puskesmas.kd_kecamatan = kecamatan.kd_kecamatan');
        $this->db->join('jenis_puskesmas', 'set_puskesmas.id_jenis_puskesmas = jenis_puskesmas.id_jenis_puskesmas');
        $this->db->join('kota','set_puskesmas.kd_kota = kota.kd_kota');
        $this->db->join('propinsi','set_puskesmas.kd_propinsi = propinsi.kd_propinsi');
        $this->db->join('kelurahan','set_puskesmas.kd_kelurahan = kelurahan.kd_kelurahan');
        $query = $this->db->get();
        return $query->row_array();
    }
	
	function get_data_rujukan ($kd_trans_pelayanan) {
		$this->db->select('pelayanan.no_rujukan, pelayanan.jenis_rujukan, pelayanan.tempat_rujukan, pelayanan.poli_rujukan, pelayanan.cat_fisik, pelayanan.cat_dokter, pelayanan.umur, pasien.nm_lengkap, jenis_kelamin.jenis_kelamin, pasien.alamat, icd.penyakit, tindakan.produk, kelurahan.nm_kelurahan, kecamatan.nm_kecamatan, kota.nm_kota, dokter.nm_dokter, dokter.nip_dokter');
        $this->db->from('pelayanan');
        $this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
		$this->db->join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');
		$this->db->join('kecamatan','pasien.kd_kecamatan=kecamatan.kd_kecamatan','left');
		$this->db->join('dokter','dokter.kd_dokter=pelayanan.kd_dokter','left');
		$this->db->join('kota','pasien.kd_kota=kota.kd_kota','left');
		$this->db->join('pelayanan_penyakit','pelayanan_penyakit.kd_trans_pelayanan=pelayanan.kd_trans_pelayanan','left');
		$this->db->join('icd','icd.kd_penyakit=pelayanan_penyakit.kd_penyakit','left');
		$this->db->join('pelayanan_tindakan','pelayanan_tindakan.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan','left');
		$this->db->join('tindakan','tindakan.kd_produk = pelayanan_tindakan.kd_produk','left');
		$this->db->join('jenis_kelamin', 'jenis_kelamin.kd_jenis_kelamin=pasien.kd_jenis_kelamin', 'left');
		$this->db->where('pelayanan.kd_trans_pelayanan', $kd_trans_pelayanan);
		
        $query = $this->db->get();
        return $query->row_array();
	}
	
	function get_data_pasien($kd_trans_pelayanan) {
		$this->db->select('pelayanan.kd_bayar, pelayanan.umur, pelayanan.no_antrian, pasien.nm_lengkap, jenis_kelamin.jenis_kelamin, pasien.alamat, pasien.idkartu_medical, pasien.kd_rekam_medis,pasien.no_asuransi, dokter.nm_dokter, kelurahan.nm_kelurahan, kecamatan.nm_kecamatan, kota.nm_kota, cara_bayar.cara_bayar');
        $this->db->from('pelayanan');
        $this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
		$this->db->join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');
		$this->db->join('kecamatan','pasien.kd_kecamatan=kecamatan.kd_kecamatan','left');
		$this->db->join('kota','pasien.kd_kota=kota.kd_kota','left');
		$this->db->join('dokter','dokter.kd_dokter=pelayanan.kd_dokter','left');
		$this->db->join('cara_bayar','pelayanan.kd_bayar=cara_bayar.kd_bayar','left');
		$this->db->join('jenis_kelamin', 'jenis_kelamin.kd_jenis_kelamin=pasien.kd_jenis_kelamin', 'left');
		$this->db->where('pelayanan.kd_trans_pelayanan', $kd_trans_pelayanan);
		
        $query = $this->db->get();
        return $query->row_array();
	}
}