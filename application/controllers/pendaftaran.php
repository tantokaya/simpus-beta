<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pendaftaran extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// cek session
		if ($this->session->userdata('logged_in') == false && $this->session->userdata('id_akses') !== 2) {
			$this->session->unset_userdata();
			$this->session->sess_destroy();
			redirect('login');
		}
		
		$this->load->library('template');
		
		$this->load->library('Datatables');
        $this->load->library('table');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	/***Default function, redirects to login page if no admin logged in yet***/
	public function index()
	{
		if ($this->session->userdata('logged_in') == true)
			redirect('pendaftaran/dashboard');
		else
			redirect('login');	
	}
	
	/*** DASHBOARD***/
	function dashboard()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$this->load->model('m_dashboard');
			
			$data['page_name']  = 'dashboard';
			$data['page_title'] = 'Dashboard';
			
			$text = "SELECT  set_puskesmas.`status`,
                        set_puskesmas.kd_puskesmas,
                        set_puskesmas.nm_puskesmas,
                        set_puskesmas.alamat,
                        set_puskesmas.id_jenis_puskesmas,
                        set_puskesmas.kd_kecamatan,
                        set_puskesmas.puskesmas_induk,
                        set_puskesmas.obat_prev,
                        set_puskesmas.jns_puskesmas,
                        set_puskesmas.nip_kpl,
                        set_puskesmas.kpl_puskesmas,
                        set_puskesmas.kd_propinsi,
                        set_puskesmas.kd_kota,
                        set_puskesmas.kd_kelurahan,
                        set_puskesmas.logo,
                        propinsi.nm_propinsi,
                        kecamatan.nm_kecamatan,
                        kelurahan.nm_kelurahan,
                        kota.nm_kota
                        FROM
                        set_puskesmas
                        LEFT JOIN propinsi ON set_puskesmas.kd_propinsi = propinsi.kd_propinsi
                        LEFT JOIN kecamatan ON set_puskesmas.kd_kecamatan = kecamatan.kd_kecamatan
                        LEFT JOIN kelurahan ON set_puskesmas.kd_kelurahan = kelurahan.kd_kelurahan
                        LEFT JOIN kota ON set_puskesmas.kd_kota = kota.kd_kota ";
            $hasil = $this->m_crud->manualQuery($text);
            foreach($hasil->result() as $t){
                $data['nm_puskesmas']   = $t->nm_puskesmas;
                $data['nip_kpl']        = $t->nip_kpl;
                $data['kpl_puskesmas']  = $t->kpl_puskesmas;
                $data['nm_kota']        = $t->nm_kota;
                $data['nm_kecamatan']   = $t->nm_kecamatan;
                $data['nm_kelurahan']   = $t->nm_kelurahan;
                $data['nm_propinsi']    = $t->nm_propinsi;
                $data['alamat']         = $t->alamat;
                $data['logo']           = $t->logo;
            }
		
			$data['total_pasien_date'] 	= $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
			$data['total_pasien_month']	= $this->m_dashboard->get_total_pasien_monthly(date('m'));
			$data['total_pasien_year']	= $this->m_dashboard->get_total_pasien_yearly(date('Y'));
			
			$data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today(); 
			$data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
			$data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
			$data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));
			
			$data['total_kunjungan_date_dlm_wil'] 	= $this->m_dashboard->get_total_kunjungan_today_dlm_wil();
			$data['total_kunjungan_date_luar_wil'] 	= $this->m_dashboard->get_total_kunjungan_today_luar_wil();
			$data['total_kunjungan_date_luar_kota'] = $this->m_dashboard->get_total_kunjungan_today_luar_kota();
			$data['total_kunjungan_week_dlm_wil']	= $this->m_dashboard->get_total_kunjungan_weekly_dlm_wil();
			$data['total_kunjungan_week_luar_wil']	= $this->m_dashboard->get_total_kunjungan_weekly_luar_wil();
			$data['total_kunjungan_week_luar_kota']	= $this->m_dashboard->get_total_kunjungan_weekly_luar_kota();
			
			$data['top_desease']			= $this->m_dashboard->get_top5_desease();
			
			for ($i=1; $i <= 12; $i++){
				$data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i);
				$data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i);
				$data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i);
			}		
			
			$this->template->display('dashboard', $data);
		} else {
			redirect('login');
		}
		
	}
	
	function laporan()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'laporan';
			$data['page_title'] = 'Pelaporan';
			
			$this->template->display('laporan', $data);
		} else {
			redirect('login');
		}
		
	} 
	/***MASTER PELAYANAN***/
	function pelayanan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$trans_id 							= $this->m_crud->generate_transaksi();
			$pelayanan['kd_trans_pelayanan'] 	= $trans_id;
			$pelayanan['kd_rekam_medis'] 		= $this->input->post('kd_rekam_medis');
			$pelayanan['tgl_pelayanan'] 		= $this->functions->convert_date_sql($this->input->post('tgl_pelayanan'));
			$pelayanan['kd_jenis_layanan'] 		= $this->input->post('kd_jenis_layanan');
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			$pelayanan['kd_puskesmas']	 		= $this->session->userdata('kd_puskesmas'); // harusnya diambil dari session
			//$pelayanan['kd_puskesmas']	 		= 'P3271020101'; // harusnya diambil dari session
			$pelayanan['kd_dokter'] 			= NULL;
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			$pelayanan['anamnesa'] 				= NULL;
			$pelayanan['cat_fisik'] 			= NULL;
			$pelayanan['cat_dokter'] 			= NULL;
			//$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
			
			//----------- cek no rujukan
			if( $this->input->post('kd_status_pasien') == "SKP-3" || $this->input->post('kd_status_pasien') == "SKP-4")	{
				$pelayanan['no_rujukan'] 			= $this->m_crud->MaxKodeRujukan(date('Y-m-d'), $this->session->userdata('kd_puskesmas'));
			} else {
				$pelayanan['no_rujukan'] 			= NULL;
			}
			
			$pelayanan['tempat_rujukan'] 		= $this->input->post('tempat_rujukan');
			
			
			// calculate age in days (in category)
			//-------------------------------------
			//echo $pelayanan['tgl_pelayanan']; exit; 
			$list_gol_umur = $this->m_crud->get_list_golongan_umur();
			
			$this->db->select('tanggal_lahir');
			$this->db->from('pasien');
			$this->db->where('kd_rekam_medis', $pelayanan['kd_rekam_medis']);
			$query = $this->db->get()->row_array();
			
			$umur = $query['tanggal_lahir'];
			#echo $umur; exit;
			
			//echo '<pre>'; print_r($list_gol_umur); exit;
			$umur_dlm_hari = $this->m_crud->calculate_age_in_days($pelayanan['tgl_pelayanan'],$umur);
			#print_r($umur_dlm_hari); exit;
			#echo $umur_dlm_hari['umur_in_days']; exit;
			
			foreach($list_gol_umur as $rs):
				if($umur_dlm_hari['umur_in_days'] >= $rs['min_hr'] and $umur_dlm_hari['umur_in_days'] <= $rs['max_hr']){
					$pelayanan_penyakit['kd_gol_umur'] = $rs['kd_gol_umur'];	
				}
			endforeach;
			
			#print_r($pelayanan_penyakit); exit;
			
			// start transaksi dengan db
			$this->db->trans_start();
			
			$this->m_crud->simpan('pelayanan', $pelayanan);
			
			// transaksi db selesai
			$this->db->trans_complete();

			//jika transaksi gagal maka rollback
		
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$this->session->set_flashdata('flash_message', 'Data transaksi pelayanan gagal disimpan!');
			} else {
				//jika berhasil lakukan disini 
				$this->db->trans_commit();
				$this->session->set_flashdata('flash_message', 'Data transaksi pelayanan berhasil disimpan!');
			}
			
			redirect('pendaftaran/pelayanan', 'refresh');
		}
		
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			//$pelayanan['kd_trans_pelayanan'] 	= $this->input->post('kd_trans_pelayanan');
			$pelayanan['kd_rekam_medis'] 		= $this->input->post('kd_rekam_medis');
			$pelayanan['kd_jenis_layanan'] 		= $this->input->post('kd_jenis_layanan');
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			
			//print_r($pelayanan['kd_jenis_layanan']); exit;
			
			$pelayanan['tgl_pelayanan'] 		= $this->functions->convert_date_sql($this->input->post('tgl_pelayanan'));
			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			$pelayanan['kd_puskesmas']	 		= $this->session->userdata('kd_puskesmas'); // harusnya diambil dari session
			//$pelayanan['kd_puskesmas']	 		= 'P3271020101';
			/*
			$pelayanan['kd_dokter'] 			= $this->input->post('kd_dokter');
			*/
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			/*
			$pelayanan['anamnesa'] 				= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 			= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 			= $this->input->post('cat_dokter');
			*/
			//
			$pelayanan['no_rujukan'] 			= $this->input->post('no_rujukan');
			$pelayanan['tempat_rujukan'] 		= $this->input->post('tempat_rujukan');
			
			// calculate age in days (in category)
			//-------------------------------------
			//echo $pelayanan['tgl_pelayanan']; exit; 
			$list_gol_umur = $this->m_crud->get_list_golongan_umur();
			
			$this->db->select('tanggal_lahir');
			$this->db->from('pasien');
			$this->db->where('kd_rekam_medis', $pelayanan['kd_rekam_medis']);
			$query = $this->db->get()->row_array();
			
			$umur = $query['tanggal_lahir'];
			#echo $umur; exit;
			
			//echo '<pre>'; print_r($list_gol_umur); exit;
			$umur_dlm_hari = $this->m_crud->calculate_age_in_days($pelayanan['tgl_pelayanan'],$umur);
			#print_r($umur_dlm_hari); exit;
			#echo $umur_dlm_hari['umur_in_days']; exit;
			
			foreach($list_gol_umur as $rs):
				if($umur_dlm_hari['umur_in_days'] >= $rs['min_hr'] and $umur_dlm_hari['umur_in_days'] <= $rs['max_hr']){
					$pelayanan_penyakit['kd_gol_umur'] = $rs['kd_gol_umur'];	
				}
			endforeach;
			
			#print_r($pelayanan_penyakit); exit;
			
			// start transaksi dengan database
			$this->db->trans_start();
			
			// delete existing record on table pelayanan_obat, pelayanan_penyakit, pelayanan_tindakan first
			// and then insert new record
			$this->db->where('kd_trans_pelayanan', $par3);
			$this->db->delete('pelayanan_obat');
			
			$this->db->where('kd_trans_pelayanan', $par3);
			$this->db->delete('pelayanan_penyakit');
			
			$this->db->where('kd_trans_pelayanan', $par3);
			$this->db->delete('pelayanan_tindakan');
			
			
			// update table pelayanan
			$this->m_crud->perbaharui('kd_trans_pelayanan', $par3, 'pelayanan', $pelayanan);
			
			// transaksi db selesai
			$this->db->trans_complete();

			//jika transaksi gagal maka rollback
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$this->session->set_flashdata('flash_message', 'Data transaksi pelayanan gagal diperbaharui!');
			} else {
				//jika berhasil lakukan disini 
				$this->db->trans_commit();
				$this->session->set_flashdata('flash_message', 'Data transaksi pelayanan berhasil diperbaharui!');
			}
			
			redirect('pendaftaran/pelayanan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pelayanan'] = $this->m_crud->get_pelayanan_by_id($par2);
			$data['edit_pasien'] = $this->m_crud->get_list_pasien($data['edit_pelayanan'][0]['kd_rekam_medis']);
			
			if(!empty($data['edit_pelayanan'][0]['kd_bed'])){
				$data['edit_bed'] = $this->m_crud->get_list_bed_by_id($data['edit_pelayanan'][0]['kd_bed']);
				$data['list_bed'] = $this->m_crud->get_list_kamar($data['edit_bed']['kd_ruangan'], $data['edit_bed']['kelas']); 	
			}
			
			//print_r($data['edit_penyakit']).'\n'; print_r($data['list_bed']); exit;
			
			
			//print $this->db->last_query();
			//exit;
		}
		if ($par1 == 'hapus') {
			$this->db->trans_start();
			
			$this->db->where('kd_trans_pelayanan', $par2);
			$this->db->delete('pelayanan_obat');
			
			$this->db->where('kd_trans_pelayanan', $par2);
			$this->db->delete('pelayanan_penyakit');
			
			$this->db->where('kd_trans_pelayanan', $par2);
			$this->db->delete('pelayanan_tindakan');
			
			$this->db->where('kd_trans_pelayanan', $par2);
			$this->db->delete('pelayanan');
			
			
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$this->session->set_flashdata('flash_message', 'Data transaksi pelayanan gagal dihapus!');
			} else { 
				$this->db->trans_commit();
				$this->session->set_flashdata('flash_message', 'Data transaksi pelayanan berhasil dihapus!');
			}
	
			redirect('pendaftaran/pelayanan', 'refresh');
		}
				
		$data['page_name']  = 'pelayanan';
		$data['page_title'] = 'Pelayanan';
		//$data['pelayanan']	= $this->m_crud->get_all_pelayanan();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('No. Transaksi Pelayanan','Tanggal','No. Rekam Medis','Nama Pasien','Jenis Pelayanan','Unit Layanan', 'Tanggal Format', 'Aksi');
		
		$data['list_jenis_layanan']			= $this->m_crud->get_list_jenis_layanan();
		$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_petugas']				= $this->m_crud->get_list_petugas('1');
		//$data['list_dokter']				= $this->m_crud->get_list_dokter();
		$data['list_jenis_kasus']			= $this->m_crud->get_list_jenis_kasus();
		$data['list_jenis_diagnosa']		= $this->m_crud->get_list_jenis_diagnosa();
		$data['list_ruangan']				= $this->m_crud->get_list_ruangan_by_id($this->session->userdata('kd_puskesmas')); // id puskesmas
		//$data['list_bed']					= $this->m_crud->get_list_kamar('RG-01'); // kd_ruangan
		//$data['list_satuan_kecil']			= $this->m_crud->get_list_satuan_kecil('1');
		$data['list_status_keluar']			= $this->m_crud->get_list_status_keluar('1');
		
		$this->template->display('pelayanan', $data);
		
	}
	
	/***AUTO COMPLETE***/
	function autoCompleteICD() 
	{
		if (isset($_REQUEST['term'])){
		  $q = strtolower($_GET['term']);
		  $output = $this->m_crud->get_icd($q);
		  $this->output->set_content_type('application/json')->set_output(json_encode($output));
    	}
	}
	
	function autoCompleteTindakan()
	{
		if (isset($_REQUEST['term'])){
		  $q = strtolower($_GET['term']);
		  $output = $this->m_crud->get_tindakan($q);
		  $this->output->set_content_type('application/json')->set_output(json_encode($output));
    	}
	}
	
	function autoCompleteObat()
	{
		if (isset($_REQUEST['term'])){
		  $q = strtolower($_GET['term']);
		  $output = $this->m_crud->get_obat($q);
		  $this->output->set_content_type('application/json')->set_output(json_encode($output));
    	}
	}	
	
	public function cari_pasien()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$rm = $this->input->post('rekam_medis');
			$data = $this->m_crud->get_pasien_by_id($rm);
			echo $data;
			
		}else{
			header('location:'.base_url());
		}
	}

}
?>
