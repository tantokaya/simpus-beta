<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_dashboard extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	/**********************************************************************************************************/
/* COUNTING JUMLAH PASIEN																				*/	/**********************************************************************************************************/
	function get_total_pasien_today($date, $sess = NULL)
	{
		$this->db->select('COUNT(*) as total_pasien');
		$this->db->from('pasien');
		$this->db->where('tanggal_daftar', $date);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_total_pasien_monthly($month, $sess = NULL)
	{
		$this->db->select('COUNT(*) as total_pasien');
		$this->db->from('pasien');
		$this->db->where('MONTH(tanggal_daftar)', $month);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_total_pasien_yearly($year, $sess = NULL)
	{
		$this->db->select('COUNT(*) as total_pasien');
		$this->db->from('pasien');
		$this->db->where('YEAR(tanggal_daftar)', $year);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	/**********************************************************************************************************/
/* COUNTING JUMLAH KUNJUNGAN PASIEN																		  */	/**********************************************************************************************************/
	function get_total_kunjungan_today($sess = NULL)
	{
		$this->db->select('COUNT(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->where('tgl_pelayanan = CURDATE()');
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		#echo $this->db->last_query(); exit;
		
		return $query->row_array();
	}
	
	function get_total_kunjungan_today_dlm_wil($sess = NULL)
	{
		$this->db->select('count(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		$this->db->join('set_wil_kerja_pusk','pasien.kd_kelurahan=set_wil_kerja_pusk.kd_kelurahan');
		$this->db->where('pelayanan.tgl_pelayanan = CURDATE()');
		$this->db->where('set_wil_kerja_pusk.kd_wil', 1);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_total_kunjungan_today_luar_wil($sess = NULL)
	{
		$this->db->select('count(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		$this->db->join('set_wil_kerja_pusk','pasien.kd_kelurahan=set_wil_kerja_pusk.kd_kelurahan');
		$this->db->where('pelayanan.tgl_pelayanan = CURDATE()');
		$this->db->where('set_wil_kerja_pusk.kd_wil', 2);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_total_kunjungan_today_luar_kota($sess = NULL)
	{
		$this->db->select('count(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		$this->db->where('pelayanan.tgl_pelayanan = CURDATE()');
		$this->db->where('pasien.kd_kota != 3271');
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function get_total_kunjungan_monthly($month, $sess = NULL)
	{
		$this->db->select('COUNT(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $month);

		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_total_kunjungan_weekly($sess = NULL)
	{
		$this->db->select('COUNT(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->where('YEARWEEK(tgl_pelayanan) = YEARWEEK(CURRENT_DATE)');
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		return $query->row_array();
	}
	function get_total_kunjungan_weekly_dlm_wil($sess = NULL)
	{
		$this->db->select('COUNT(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		$this->db->join('set_wil_kerja_pusk','pasien.kd_kelurahan=set_wil_kerja_pusk.kd_kelurahan');
		$this->db->where('set_wil_kerja_pusk.kd_wil', 1);
		$this->db->where('YEARWEEK(tgl_pelayanan) = YEARWEEK(CURRENT_DATE)');
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		return $query->row_array();
	}
	function get_total_kunjungan_weekly_luar_wil($sess = NULL)
	{
		$this->db->select('COUNT(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		$this->db->join('set_wil_kerja_pusk','pasien.kd_kelurahan=set_wil_kerja_pusk.kd_kelurahan');
		$this->db->where('set_wil_kerja_pusk.kd_wil', 2);
		$this->db->where('YEARWEEK(tgl_pelayanan) = YEARWEEK(CURRENT_DATE)');
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		return $query->row_array();
	}
	function get_total_kunjungan_weekly_luar_kota($sess = NULL)
	{
		$this->db->select('COUNT(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		$this->db->where('pasien.kd_kota != 3271');
		$this->db->where('YEARWEEK(tgl_pelayanan) = YEARWEEK(CURRENT_DATE)');
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_total_kunjungan_yearly($year, $sess = NULL)
	{
		$this->db->select('COUNT(*) as total_kunjungan');
		$this->db->from('pelayanan');
		$this->db->where('YEAR(tgl_pelayanan)', $year);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	/**********************************************************************************************************/
/* TOP 5 DESEASE																						  */	/**********************************************************************************************************/
	function get_top5_desease($limit = 5)
	{
		$this->db->select('pelayanan_penyakit.kd_penyakit, icd.penyakit, count(pelayanan_penyakit.kd_penyakit) total');
		$this->db->from('pelayanan_penyakit');
		$this->db->join('icd', 'pelayanan_penyakit.kd_penyakit = icd.kd_penyakit');
		$this->db->group_by('pelayanan_penyakit.kd_penyakit');
		$this->db->order_by('total', 'desc'); 
		$this->db->limit($limit);
		
		$query = $this->db->get();
		
		$data['total_data'] = $query->num_rows();
		$data['data'] = $query->result_array();
		
		if($query->num_rows() > 0)
			return $data;
		else
			return array('');
	}
	
	/**********************************************************************************************************/
/* GRAFIK JUMLAH PASIEN PERTAHUN BERDASARKAN JENIS KELAMIN									  			  */	/**********************************************************************************************************/
	function get_pasien_laki($month, $sess = NULL)
	{
		$this->db->select('COUNT(*) as jumlah');
		$this->db->from('pasien');
		$this->db->where('MONTH(tanggal_daftar)', $month);
		$this->db->where('YEAR(tanggal_daftar) = YEAR(CURDATE())');
		$this->db->where('kd_jenis_kelamin', 1);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_pasien_perempuan($month, $sess = NULL)
	{
		$this->db->select('COUNT(*) as jumlah');
		$this->db->from('pasien');
		$this->db->where('MONTH(tanggal_daftar)', $month);
		$this->db->where('YEAR(tanggal_daftar) = YEAR(CURDATE())');
		$this->db->where('kd_jenis_kelamin', 2);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}

		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	/**********************************************************************************************************/
/* GRAFIK JUMLAH KUNJUNGAN PERBULAN															  			 */	/**********************************************************************************************************/

	/**********************************************************************************************************/
/* TOP 10 MEDICINE																						  */	/**********************************************************************************************************/
	function get_top10_medicine($limit = 10){
		$this->db->select('brg_apotek_keluar_detail.kd_obat, obat.nama_obat, count(brg_apotek_keluar_detail.kd_obat) total');
		$this->db->from('brg_apotek_keluar_detail');
		$this->db->join('obat', 'brg_apotek_keluar_detail.kd_obat = obat.kd_obat');
		$this->db->group_by('brg_apotek_keluar_detail.kd_obat');
		$this->db->order_by('total', 'desc'); 
		$this->db->limit($limit);
		
		$query = $this->db->get();
		
		$data['total_data'] = $query->num_rows();
		$data['data'] = $query->result_array();
		
		if($query->num_rows() > 0)
			return $data;
		else
			return array('');
	}

/**********************************************************************************************
/* JUMLAH KUNJUNGAN RAWAT JALAN DAN INAP
/**********************************************************************************************/
	function get_kunjungan_rawat_jalan($month, $sess = NULL)
	{
		$this->db->select('COUNT(*) as jumlah');
		$this->db->from('pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $month);
		$this->db->where('YEAR(tgl_pelayanan) = YEAR(CURDATE())');
		$this->db->where('kd_jenis_layanan', 2);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_kunjungan_rawat_inap($month, $sess = NULL)
	{
		$this->db->select('COUNT(*) as jumlah');
		$this->db->from('pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $month);
		$this->db->where('YEAR(tgl_pelayanan) = YEAR(CURDATE())');
		$this->db->where('kd_jenis_layanan', 3);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		
		$query = $this->db->get();
		
		return $query->row_array();
		
	}
	

/**********************************************************************************************
/* JUMLAH KUNJUNGAN KASUS BARU DAN LAMA  /********************************************************************************************/
	function get_kunjungan_kasus_lama($month, $sess=NULL)
	{
		$this->db->select('COUNT(*) as jumlah');
		$this->db->from('v_pelayanan_penyakit');
		$this->db->where('MONTH(tgl_pelayanan)', $month);
		$this->db->where('YEAR(tgl_pelayanan) = YEAR(CURDATE())');
		$this->db->where('kd_jenis_kasus', 2);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		
		$query = $this->db->get();
		
		return $query->row_array();
	}
	
	function get_kunjungan_kasus_baru($month, $sess=NULL)
	{
		$this->db->select('COUNT(*) as jumlah');
		$this->db->from('v_pelayanan_penyakit');
		$this->db->where('MONTH(tgl_pelayanan)', $month);
		$this->db->where('YEAR(tgl_pelayanan) = YEAR(CURDATE())');
		$this->db->where('kd_jenis_kasus', 1);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		
		$query = $this->db->get();
		
		return $query->row_array();	
	}
	
	function get_all_poli(){
		$query = $this->db->get('unit_pelayanan');
		
		return $query->result_array();
	}
	
	function get_kunjungan_per_poli($month, $kd_poli, $sess=NULL)
	{
		$this->db->select('COUNT(*) as jumlah');
		$this->db->from('pelayanan');
		$this->db->where('MONTH(tgl_pelayanan)', $month);
		$this->db->where('YEAR(tgl_pelayanan) = YEAR(CURDATE())');
		$this->db->where('kd_unit_pelayanan', $kd_poli);
		
		if($sess !== NULL){
			$this->db->where('kd_puskesmas', $sess);
		}
		
		$query = $this->db->get();
		
		return $query->row_array();	
	}
	
	
	
}
/* End of file m_dashboard.php */
/* Location: ./application/models/m_dashboard.php */
