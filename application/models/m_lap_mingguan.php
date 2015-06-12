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

        $sql = $this->db->select('pasien.nm_lengkap, pasien.kd_jenis_kelamin, pelayanan.umur, pasien.idkartu_medical, pasien.alamat, kelurahan.nm_kelurahan, kecamatan.nm_kecamatan, kartu_medical.nama_kk, jenis_kasus.jenis_kasus, icd.penyakit, pelayanan.tgl_pelayanan');
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
        $sql->order_by('pelayanan.tgl_pelayanan','ASC');
		
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
	
	function get_mon_resep_by_icd($bln, $thn, $kd_penyakit){
		$sql = $this->db->select('pelayanan.tgl_pelayanan, pelayanan.kd_trans_pelayanan, pasien.nm_lengkap, pelayanan.umur, pelayanan.anamnesa, satuan_kecil.sat_kecil_obat, GROUP_CONCAT(DISTINCT tindakan.produk SEPARATOR "; ") as tindakan, GROUP_CONCAT(pelayanan_obat.qty SEPARATOR "; ") as jml_obat, GROUP_CONCAT(obat.nama_obat SEPARATOR "; ") as obat, GROUP_CONCAT(pelayanan_obat.dosis SEPARATOR "; ") as dosis_obat, icd.penyakit, count(obat.nama_obat) AS jml_obat ');
		//DATE_FORMAT(pelayanan.tgl_pelayanan, "%d-%m-%Y") as tgl_indo
		$sql->from('pelayanan_penyakit');
		$sql->join('pelayanan', 'pelayanan_penyakit.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan');
		$sql->join('pelayanan_obat','pelayanan_obat.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan','left');
		$sql->join('pelayanan_tindakan','pelayanan_tindakan.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan','left');
		$sql->join('pasien','pasien.kd_rekam_medis = pelayanan.kd_rekam_medis');
		$sql->join('satuan_kecil','satuan_kecil.kd_sat_kecil_obat = pelayanan_obat.kd_sat_kecil_obat','left');
		$sql->join('obat','pelayanan_obat.kd_obat = obat.kd_obat','left');
		$sql->join('tindakan','tindakan.kd_produk = pelayanan_tindakan.kd_produk','left');
		$sql->join('icd','icd.kd_penyakit = pelayanan_penyakit.kd_penyakit','left');
		$sql->where('MONTH(pelayanan.tgl_pelayanan)',$bln);
		$sql->where('YEAR(pelayanan.tgl_pelayanan)',$thn);
		$sql->where('pelayanan_penyakit.kd_penyakit',$kd_penyakit);
		$sql->group_by('pelayanan.kd_trans_pelayanan');
	
		$query = $this->db->get();
		return $query->result_array();
		
	}
	function get_icd($kd_penyakit) {
		$this->db->select('penyakit');
        $this->db->from('icd');
        $this->db->where('kd_penyakit', $kd_penyakit);

        $query = $this->db->get();
        return $query->row_array();
	}
	
}