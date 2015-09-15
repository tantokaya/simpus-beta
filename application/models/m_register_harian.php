<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_register_harian extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    function get_puskesmas_info(){
        $this->db->select('nm_puskesmas');
        $this->db->from('set_puskesmas');
        $this->db->where('status', '1');

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
	function get_cara_bayar_info($kd_bayar) {
		$this->db->select('cara_bayar');
		$this->db->from('cara_bayar');
		$this->db->where('kd_bayar',$kd_bayar);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_pasien_rawat_umum_by_date($tgl_mulai, $tgl_akhir, $kd_unit_pelayanan, $kd_bayar){
		
        $sql = $this->db->select('pelayanan.kd_rekam_medis, dokter.nm_dokter,pelayanan.kd_trans_pelayanan, pelayanan.tgl_pelayanan, pasien.no_reg, pelayanan.kd_rekam_medis, pasien.nm_lengkap, pasien.kd_jenis_kelamin, golongan_umur.gol_umur,cara_bayar.cara_bayar, pasien.no_asuransi, unit_pelayanan.nm_unit, pasien.alamat, kelurahan.nm_kelurahan, kota.nm_kota, pelayanan_penyakit.kd_penyakit,jenis_kasus.jenis_kasus, GROUP_CONCAT(DISTINCT jenis_kasus.jenis_kasus SEPARATOR "; ") as jns_kasus, pelayanan_tindakan.kd_produk, GROUP_CONCAT(DISTINCT tindakan.produk SEPARATOR "; ") as tindakan, status_keluar_pasien.keterangan,GROUP_CONCAT(DISTINCT pelayanan_penyakit.kd_penyakit SEPARATOR "; ") as kd_icd, GROUP_CONCAT(DISTINCT icd.penyakit SEPARATOR "; ") as penyakit', false);
        $sql->from('pelayanan');
        $sql->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
        $sql->join('cara_bayar','pelayanan.kd_bayar = cara_bayar.kd_bayar','left');
        $sql->join('unit_pelayanan','pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan','left');
        $sql->join('status_keluar_pasien','pelayanan.kd_status_pasien = status_keluar_pasien.kd_status_pasien','left');
        $sql->join('dokter','pelayanan.kd_dokter=dokter.kd_dokter','left');
		$sql->join('kelurahan','pasien.kd_kelurahan=kelurahan.kd_kelurahan','left');
		$sql->join('kota','pasien.kd_kota=kota.kd_kota','left');
		$sql->join('pelayanan_penyakit','pelayanan.kd_trans_pelayanan=pelayanan_penyakit.kd_trans_pelayanan','left');
		$sql->join('icd','pelayanan_penyakit.kd_penyakit=icd.kd_penyakit','left');
		$sql->join('pelayanan_tindakan','pelayanan.kd_trans_pelayanan=pelayanan_tindakan.kd_trans_pelayanan','left');
		$sql->join('tindakan','pelayanan_tindakan.kd_produk=tindakan.kd_produk','left');
		$sql->join('golongan_umur','pelayanan.kd_gol_umur=golongan_umur.kd_gol_umur','left');
		$sql->join('jenis_kasus','pelayanan_penyakit.kd_jenis_kasus=jenis_kasus.kd_jenis_kasus','left');
		$sql->where('pelayanan.tgl_pelayanan >=', $tgl_mulai);
		$sql->where('pelayanan.tgl_pelayanan <=', $tgl_akhir);
	
		if ($kd_unit_pelayanan != '') {
			$sql->where('pelayanan.kd_unit_pelayanan', $kd_unit_pelayanan);
		}	
		if ($kd_bayar != '') {
			$sql->where('pelayanan.kd_bayar', $kd_bayar);
		}	
		$sql->group_by('pelayanan.tgl_pelayanan, pelayanan.kd_trans_pelayanan');
        $sql->order_by('unit_pelayanan.nm_unit, dokter.nm_dokter','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_rekap_cara_bayar($tgl_mulai, $tgl_akhir){

        $this->db->select('pelayanan.kd_bayar,unit_pelayanan.nm_unit, count(*) AS jml');
        $this->db->from('pelayanan');
        $this->db->join('unit_pelayanan','pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');	
        $this->db->where('pelayanan.tgl_pelayanan >=', $tgl_mulai);
		$this->db->where('pelayanan.tgl_pelayanan <=', $tgl_akhir);
		$this->db->group_by('unit_pelayanan.nm_unit, pelayanan.kd_bayar');
        $this->db->order_by('pelayanan.kd_bayar','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
	
	function get_rekap_stok_obat(){

        $this->db->select('obat.kd_obat,obat.nama_obat,obat.apotek_stok,obat.obat_stok,satuan_kecil.sat_kecil_obat');
        $this->db->from('obat');
        $this->db->join('satuan_kecil','obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat');	
        $this->db->order_by('obat.kd_obat','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}