<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_monitor_resep extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

	function get_pasien_by_icd($bln, $thn, $kd_penyakit){
		$this->db->select('pelayanan.tgl_pelayanan, pelayanan.kd_trans_pelayanan, pasien.nm_lengkap, pasien.umur, pelayanan.anamnesa, tindakan.produk, obat.nama_obat, pelayanan_obat.qty, pelayanan_obat.dosis, satuan_kecil. sat_kecil_obat');
		$this->db->from('pelayanan_penyakit');
		$this->db->join('pelayanan', 'pelayanan_penyakit.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan');
		$this->db->join('pelayanan_obat','pelayanan_obat.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan','left');
		$this->db->join('pelayanan_tindakan','pelayanan_tindakan.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan','left');
		$this->db->join('pasien','pasien.kd_rekam_medis = pelayanan.kd_rekam_medis');
		$this->db->join('satuan_kecil','satuan_kecil.kd_sat_kecil_obat = pelayanan_obat.kd_sat_kecil_obat','left');
		$this->db->join('obat','pelayanan_obat.kd_obat = obat.kd_obat','left');
		$this->db->join('tindakan','tindakan.kd_produk = pelayanan_tindakan.kd_produk','left');
		//$this->db->where('MONTH(pelayanan.tgl_pelayanan)',$bln);
		//$this->db->where('YEAR(pelayanan.tgl_pelayanan)',$thn);
		//$this->db->where('pelayanan_penyakit.kd_penyakit',$kd_penyakit);
	
		$query = $this->db->get();
		return $query->result_array();
		
	}
	
	
}