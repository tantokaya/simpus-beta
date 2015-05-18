<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_transaksi_pelayanan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$simkes=$this->load->database('default', TRUE);
		
		// cek session
		if ($this->session->userdata('logged_in') == false && $this->session->userdata('id_akses') !== 1) {
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
			$pelayanan['kd_puskesmas']	 		= $this->session->userdata('kd_puskesmas'); 
			//$pelayanan['kd_puskesmas']	 		= 'P3271020101'; // harusnya diambil dari session
			$pelayanan['kd_dokter'] 			= $this->input->post('kd_dokter');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			$pelayanan['anamnesa'] 				= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 			= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 			= $this->input->post('cat_dokter');
			//$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
			
			//----------- cek no rujukan
			if( $this->input->post('kd_status_pasien') == "SKP-3" || $this->input->post('kd_status_pasien') == "SKP-4")	{
				$pelayanan['no_rujukan'] 			= $this->m_crud->MaxKodeRujukan(date('Y-m-d'),'P3271020101');
			} else {
				$pelayanan['no_rujukan'] 			= NULL;
			}
			
			$pelayanan['tempat_rujukan'] 		= $this->input->post('tempat_rujukan');
			$pelayanan['timestamps']			= date('Y-m-d H:i:s');
			
			
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
			
			foreach ($_POST as $key=>$val) {
				$$key = $val;
			}
			
			// Insert Pelayanan Obat
			$i = 1;
			while(isset(${"nama_obat_".$i})) {
				//if(isset(${"nama_obat_".$i}) and !empty(${"nama_obat_".$i}) and ${"nama_obat_".$i} !== ""){
				if(${"nama_obat_".$i} !== ""){
					$pelayanan_obat['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_obat['kd_obat'] 				= ${"kd_obat_".$i};
					$pelayanan_obat['dosis'] 				= ${"dosis_".$i};
					$pelayanan_obat['kd_sat_kecil_obat'] 	= ${"satuan_".$i};
					$pelayanan_obat['qty'] 					= ${"jumlah_".$i};
				
					$this->m_crud->simpan('pelayanan_obat', $pelayanan_obat);
				} 	
				$i++;
			}
			
			// Insert Pelayanan Penyakit
			$i = 1;
			while(isset(${"kd_penyakit_".$i})) {
				//if(isset(${"kd_penyakit_".$i}) and !empty(${"kd_penyakit_".$i}) and ${"kd_penyakit_".$i} !== ""){
				if(${"kd_penyakit_".$i} !== ""){
					$pelayanan_penyakit['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_penyakit['kd_penyakit'] 			= ${"kd_penyakit_".$i};
					$pelayanan_penyakit['kd_jenis_kasus'] 		= ${"kd_jenis_kasus_".$i};
					$pelayanan_penyakit['kd_jenis_diagnosa'] 	= ${"kd_jenis_diagnosa_".$i};
					
					$this->m_crud->simpan('pelayanan_penyakit', $pelayanan_penyakit);
				} 	
				$i++;
			}
			
			// Insert Pelayanan Tindakan
			$i = 1;
			while(isset(${"kd_produk_".$i})) {
				//if(isset(${"kd_produk_".$i}) and !empty(${"kd_produk_".$i}) and ${"kd_produk_".$i} !== ""){
				if(${"kd_produk_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}	
				$i++;
			}
			
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
			
			redirect('cont_transaksi_pelayanan/pelayanan', 'refresh');
		}
		
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			//$pelayanan['kd_trans_pelayanan'] 	= $this->input->post('kd_trans_pelayanan');
			if($this->session->userdata('id_akses') == 7){
                      
			$pelayanan['kd_jenis_layanan'] 	= $this->input->post('kd_jenis_layanan');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			}
			//print_r($pelayanan['kd_jenis_layanan']); exit;
			$pelayanan['kd_rekam_medis'] 		= $this->input->post('kd_rekam_medis');
			$pelayanan['kd_trans_pelayanan']	= $this->input->post('kodepelayanan');
			$pelayanan['tgl_pelayanan'] 	= $this->functions->convert_date_sql($this->input->post('tgl_pelayanan'));
			$pelayanan['kd_puskesmas']	 	= $this->session->userdata('kd_puskesmas'); // harusnya diambil dari session
			
			$pelayanan['kd_dokter'] 		= $this->input->post('kd_dokter');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			$pelayanan['anamnesa'] 			= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 		= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 		= $this->input->post('cat_dokter');
		
			$pelayanan['no_rujukan'] 		= $this->input->post('no_rujukan');
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
			
			foreach ($_POST as $key=>$val) {
				$$key = $val;
			}
			
			// Insert Pelayanan Obat
			$i = 1;
			while(isset(${"nama_obat_".$i})) {
				//if(isset(${"nama_obat_".$i}) or !empty(${"nama_obat_".$i}) or ${"nama_obat_".$i} !== ""){
				if(${"nama_obat_".$i} !== ""){
					$pelayanan_obat['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_obat['kd_obat'] 				= ${"kd_obat_".$i};
					$pelayanan_obat['dosis'] 				= ${"dosis_".$i};
					$pelayanan_obat['kd_sat_kecil_obat'] 	= ${"satuan_".$i};
					$pelayanan_obat['qty'] 					= ${"jumlah_".$i};
				
					$this->m_crud->simpan('pelayanan_obat', $pelayanan_obat);
				}	
				$i++;
			}
			
			// Insert Pelayanan Penyakit
			$i = 1;
			while(isset(${"kd_penyakit_".$i})) {
				//if(isset(${"kd_penyakit_".$i}) or !empty(${"kd_penyakit_".$i}) or ${"kd_penyakit_".$i} !== ""){
				if(${"kd_penyakit_".$i} !== ""){
					$pelayanan_penyakit['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_penyakit['kd_penyakit'] 			= ${"kd_penyakit_".$i};
					$pelayanan_penyakit['kd_jenis_kasus'] 		= ${"kd_jenis_kasus_".$i};
					$pelayanan_penyakit['kd_jenis_diagnosa'] 	= ${"kd_jenis_diagnosa_".$i};
					
					$this->m_crud->simpan('pelayanan_penyakit', $pelayanan_penyakit);
				}	
				$i++;
			}
			
			// Insert Pelayanan Tindakan
			$i = 1;
			while(isset(${"kd_produk_".$i})) {
				//if(isset(${"kd_produk_".$i}) or !empty(${"kd_produk_".$i}) or ${"kd_produk_".$i} !== ""){
				if(${"kd_produk_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}
				$i++;
			}
			
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
			
			redirect('cont_transaksi_pelayanan/pelayanan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pelayanan'] = $this->m_crud->get_pelayanan_by_id($par2);
			$data['edit_pasien'] = $this->m_crud->get_list_pasien($data['edit_pelayanan'][0]['kd_rekam_medis']);
			
			if(!empty($data['edit_pelayanan'][0]['kd_bed'])){
				$data['edit_bed'] = $this->m_crud->get_list_bed_by_id($data['edit_pelayanan'][0]['kd_bed']);
				$data['list_bed'] = $this->m_crud->get_list_kamar($data['edit_bed']['kd_ruangan'], $data['edit_bed']['kelas']); 	
			}
			
			$data['edit_penyakit'] = $this->m_crud->get_list_pelayanan_penyakit_by_id($par2);
			$data['counter']	   = $this->m_crud->get_total_pelayanan_penyakit_by_id($par2);
			
			$data['edit_tindakan'] = $this->m_crud->get_list_pelayanan_tindakan_by_id($par2);
			$data['counter2']	   = $this->m_crud->get_total_pelayanan_tindakan_by_id($par2);
			
			$data['edit_lab']	 = $this->m_crud->get_list_pelayanan_lab_by_id($par2);
			$data['counter4']	   = $this->m_crud->get_total_pelayanan_lab_by_id($par2);	
			
			$data['edit_obat'] 		= $this->m_crud->get_list_pelayanan_obat_by_id($par2);
			$data['counter3']	   	= $this->m_crud->get_total_pelayanan_obat_by_id($par2);
			
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
	
			redirect('cont_transaksi_pelayanan/pelayanan', 'refresh');
		}
				
		$data['page_name']  = 'pelayanan';
		$data['page_title'] = 'Pelayanan';
		$data['pelayanan_hr_ini']	= $this->m_crud->get_pelayanan_by_date();
		
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('No. Layanan','Tanggal','No. Rekam Medis','Nama Pasien','Jenis Pelayanan','Unit Layanan', 'Aksi');
		
		
		$data['list_jenis_layanan']			= $this->m_crud->get_list_jenis_layanan();
		$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_petugas']				= $this->m_crud->get_list_petugas('1');
		$data['list_dokter']				= $this->m_crud->get_list_dokter();
		$data['list_jenis_kasus']			= $this->m_crud->get_list_jenis_kasus();
		$data['list_jenis_diagnosa']		= $this->m_crud->get_list_jenis_diagnosa();
		$data['list_ruangan']				= $this->m_crud->get_list_ruangan_by_id($this->session->userdata('kd_puskesmas')); // id puskesmas
		//$data['list_bed']					= $this->m_crud->get_list_kamar('RG-01'); // kd_ruangan
		$data['list_satuan_kecil']			= $this->m_crud->get_list_satuan_kecil('1');
		$data['list_status_keluar']			= $this->m_crud->get_list_status_keluar('1');
		
		$this->template->display('pelayanan', $data);
		
	}
	
	/***MASTER PELAYANAN TODAY***/
	function pelayanan_today($par1 = '', $par2 = '', $par3 = '')
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
			$pelayanan['kd_puskesmas']	 		= $this->session->userdata('kd_puskesmas'); 
			//$pelayanan['kd_puskesmas']	 		= 'P3271020101'; // harusnya diambil dari session
			$pelayanan['kd_dokter'] 			= $this->input->post('kd_dokter');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			$pelayanan['anamnesa'] 				= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 			= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 			= $this->input->post('cat_dokter');
			//$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
			
			//----------- cek no rujukan
			if( $this->input->post('kd_status_pasien') == "SKP-3" || $this->input->post('kd_status_pasien') == "SKP-4")	{
				$pelayanan['no_rujukan'] 			= $this->m_crud->MaxKodeRujukan(date('Y-m-d'),'P3271020101');
			} else {
				$pelayanan['no_rujukan'] 			= NULL;
			}
			
			$pelayanan['tempat_rujukan'] 		= $this->input->post('tempat_rujukan');
			$pelayanan['timestamps'] 			= date('Y-m-d H:i:s');
			
			
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
			
			foreach ($_POST as $key=>$val) {
				$$key = $val;
			}
			
			// Insert Pelayanan Obat
			$i = 1;
			while(isset(${"nama_obat_".$i})) {
				//if(isset(${"nama_obat_".$i}) and !empty(${"nama_obat_".$i}) and ${"nama_obat_".$i} !== ""){
				if(${"nama_obat_".$i} !== ""){
					$pelayanan_obat['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_obat['kd_obat'] 				= ${"kd_obat_".$i};
					$pelayanan_obat['dosis'] 				= ${"dosis_".$i};
					$pelayanan_obat['kd_sat_kecil_obat'] 	= ${"satuan_".$i};
					$pelayanan_obat['qty'] 					= ${"jumlah_".$i};
					$pelayanan_obat['racikan'] 				= ${"racikan_".$i};
					$this->m_crud->simpan('pelayanan_obat', $pelayanan_obat);
				} 	
				$i++;
			}
			
			// Insert Pelayanan Penyakit
			$i = 1;
			while(isset(${"kd_penyakit_".$i})) {
				//if(isset(${"kd_penyakit_".$i}) and !empty(${"kd_penyakit_".$i}) and ${"kd_penyakit_".$i} !== ""){
				if(${"kd_penyakit_".$i} !== ""){
					$pelayanan_penyakit['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_penyakit['kd_penyakit'] 			= ${"kd_penyakit_".$i};
					$pelayanan_penyakit['kd_jenis_kasus'] 		= ${"kd_jenis_kasus_".$i};
					$pelayanan_penyakit['kd_jenis_diagnosa'] 	= ${"kd_jenis_diagnosa_".$i};
					
					$this->m_crud->simpan('pelayanan_penyakit', $pelayanan_penyakit);
				} 	
				$i++;
			}
			
			// Insert Pelayanan Tindakan
			$i = 1;
			while(isset(${"kd_produk_".$i})) {
				//if(isset(${"kd_produk_".$i}) and !empty(${"kd_produk_".$i}) and ${"kd_produk_".$i} !== ""){
				if(${"kd_produk_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}	
				$i++;
			}
			
			// Insert Pelayanan laborat
			$i = 1;
			while(isset(${"kd_produk_lab_".$i})) {
				
				if(${"kd_produk_lab_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_lab_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_lab_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_lab_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}	
				$i++;
			}
			
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
		/*	if($this->session->userdata('id_akses') == 2 )
			{ 	redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
			} else { redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh'); }	*/
			
			redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh');
		}
		
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			//$pelayanan['kd_trans_pelayanan'] 	= $this->input->post('kd_trans_pelayanan');
		
                      
			$pelayanan['kd_jenis_layanan'] 	= $this->input->post('kd_jenis_layanan');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			
			//print_r($pelayanan['kd_jenis_layanan']); exit;
			$pelayanan['kd_rekam_medis'] 		= $this->input->post('kd_rekam_medis');
			$pelayanan['kd_trans_pelayanan']	= $this->input->post('kodepelayanan');
			$pelayanan['tgl_pelayanan'] 	= $this->functions->convert_date_sql($this->input->post('tgl_pelayanan'));
			$pelayanan['kd_puskesmas']	 	= $this->session->userdata('kd_puskesmas'); // harusnya diambil dari session
			
			$pelayanan['kd_dokter'] 		= $this->input->post('kd_dokter');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			$pelayanan['anamnesa'] 			= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 		= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 		= $this->input->post('cat_dokter');
		
			$pelayanan['no_rujukan'] 		= $this->input->post('no_rujukan');
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
			
			foreach ($_POST as $key=>$val) {
				$$key = $val;
			}
			
			// Insert Pelayanan Obat
			$i = 1;
			while(isset(${"nama_obat_".$i})) {
				//if(isset(${"nama_obat_".$i}) or !empty(${"nama_obat_".$i}) or ${"nama_obat_".$i} !== ""){
				if(${"nama_obat_".$i} !== ""){
					$pelayanan_obat['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_obat['kd_obat'] 				= ${"kd_obat_".$i};
					$pelayanan_obat['dosis'] 				= ${"dosis_".$i};
					$pelayanan_obat['kd_sat_kecil_obat'] 	= ${"satuan_".$i};
					$pelayanan_obat['qty'] 					= ${"jumlah_".$i};
					$pelayanan_obat['racikan']				= ${"racikan_".$i};
					$this->m_crud->simpan('pelayanan_obat', $pelayanan_obat);
				}	
				$i++;
			}
			
			// Insert Pelayanan Penyakit
			$i = 1;
			while(isset(${"kd_penyakit_".$i})) {
				//if(isset(${"kd_penyakit_".$i}) or !empty(${"kd_penyakit_".$i}) or ${"kd_penyakit_".$i} !== ""){
				if(${"kd_penyakit_".$i} !== ""){
					$pelayanan_penyakit['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_penyakit['kd_penyakit'] 			= ${"kd_penyakit_".$i};
					$pelayanan_penyakit['kd_jenis_kasus'] 		= ${"kd_jenis_kasus_".$i};
					$pelayanan_penyakit['kd_jenis_diagnosa'] 	= ${"kd_jenis_diagnosa_".$i};
					
					$this->m_crud->simpan('pelayanan_penyakit', $pelayanan_penyakit);
				}	
				$i++;
			}
			
			// Insert Pelayanan Tindakan
			$i = 1;
			while(isset(${"kd_produk_".$i})) {
				//if(isset(${"kd_produk_".$i}) or !empty(${"kd_produk_".$i}) or ${"kd_produk_".$i} !== ""){
				if(${"kd_produk_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}
				$i++;
			}
			// Insert Pelayanan laborat
			$i = 1;
			while(isset(${"kd_produk_lab_".$i})) {
				
				if(${"kd_produk_lab_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_lab_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_lab_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_lab_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}	
				$i++;
			}
			
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
			
			redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pelayanan'] = $this->m_crud->get_pelayanan_by_id($par2);
			$data['edit_pasien'] = $this->m_crud->get_list_pasien($data['edit_pelayanan'][0]['kd_rekam_medis']);
			
			if(!empty($data['edit_pelayanan'][0]['kd_bed'])){
				$data['edit_bed'] = $this->m_crud->get_list_bed_by_id($data['edit_pelayanan'][0]['kd_bed']);
				$data['list_bed'] = $this->m_crud->get_list_kamar($data['edit_bed']['kd_ruangan'], $data['edit_bed']['kelas']); 	
			}
			
			$data['edit_penyakit'] = $this->m_crud->get_list_pelayanan_penyakit_by_id($par2);
			$data['counter']	   = $this->m_crud->get_total_pelayanan_penyakit_by_id($par2);
			
			$data['edit_tindakan'] = $this->m_crud->get_list_pelayanan_tindakan_by_id($par2);
			$data['counter2']	   = $this->m_crud->get_total_pelayanan_tindakan_by_id($par2);	
			
			$data['edit_lab'] = $this->m_crud->get_list_pelayanan_lab_by_id($par2);
			$data['counter4']	   = $this->m_crud->get_total_pelayanan_lab_by_id($par2);	
			
			$data['edit_obat'] 		= $this->m_crud->get_list_pelayanan_obat_by_id($par2);
			$data['counter3']	   	= $this->m_crud->get_total_pelayanan_obat_by_id($par2);
			
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
	
			redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh');
		}
				
		$data['page_name']  = 'pelayanan';
		$data['page_title'] = 'Pelayanan';
		$data['pelayanan_hr_ini']	= $this->m_crud->get_pelayanan_by_date();
		
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		
		
		 if($this->session->userdata('id_akses') == 5 || $this->session->userdata('id_akses') == 10 || $this->session->userdata('id_akses') == 11 || $this->session->userdata('id_akses') == 12 || $this->session->userdata('id_akses') == 4)
			{ $this->table->set_heading('Kode Layanan','Tanggal','No. Rekam Medis','Nama Pasien','Jenis Pelayanan','Unit Layanan', 'Aksi');
             } else {
				 $this->table->set_heading('Kode. Layanan','Tanggal','No. Rekam Medis','Nama Pasien','Jenis Pelayanan','Unit Layanan', 'Aksi'); }
		
		$data['list_jenis_layanan']			= $this->m_crud->get_list_jenis_layanan();
		$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_petugas']				= $this->m_crud->get_list_petugas('1');
		$data['list_dokter']				= $this->m_crud->get_list_dokter();
		$data['list_jenis_kasus']			= $this->m_crud->get_list_jenis_kasus();
		$data['list_jenis_diagnosa']		= $this->m_crud->get_list_jenis_diagnosa();
	$data['list_ruangan']				= $this->m_crud->get_list_ruangan_by_id($this->session->userdata('kd_puskesmas')); 
		//$data['list_bed']					= $this->m_crud->get_list_kamar('RG-01'); // kd_ruangan
		$data['list_satuan_kecil']			= $this->m_crud->get_list_satuan_kecil('1');
		$data['list_status_keluar']			= $this->m_crud->get_list_status_keluar('1');
		
		$this->template->display('pelayanan_today', $data);
		
	}
	
	/***MASTER PELAYANAN TODAY***/
	function pelayanan_today_lab($par1 = '', $par2 = '', $par3 = '')
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
			$pelayanan['kd_puskesmas']	 		= $this->session->userdata('kd_puskesmas'); 
			//$pelayanan['kd_puskesmas']	 		= 'P3271020101'; // harusnya diambil dari session
			$pelayanan['kd_dokter'] 			= $this->input->post('kd_dokter');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			$pelayanan['anamnesa'] 				= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 			= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 			= $this->input->post('cat_dokter');
			//$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
			
			//----------- cek no rujukan
			if( $this->input->post('kd_status_pasien') == "SKP-3" || $this->input->post('kd_status_pasien') == "SKP-4")	{
				$pelayanan['no_rujukan'] 			= $this->m_crud->MaxKodeRujukan(date('Y-m-d'),'P3271020101');
			} else {
				$pelayanan['no_rujukan'] 			= NULL;
			}
			
			$pelayanan['tempat_rujukan'] 		= $this->input->post('tempat_rujukan');
			$pelayanan['timestamps'] 			= date('Y-m-d H:i:s');
			
			
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
			
			foreach ($_POST as $key=>$val) {
				$$key = $val;
			}
			
			// Insert Pelayanan Obat
			$i = 1;
			while(isset(${"nama_obat_".$i})) {
				//if(isset(${"nama_obat_".$i}) and !empty(${"nama_obat_".$i}) and ${"nama_obat_".$i} !== ""){
				if(${"nama_obat_".$i} !== ""){
					$pelayanan_obat['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_obat['kd_obat'] 				= ${"kd_obat_".$i};
					$pelayanan_obat['dosis'] 				= ${"dosis_".$i};
					$pelayanan_obat['kd_sat_kecil_obat'] 	= ${"satuan_".$i};
					$pelayanan_obat['qty'] 					= ${"jumlah_".$i};
					$pelayanan_obat['racikan'] 				= ${"racikan_".$i};
					$this->m_crud->simpan('pelayanan_obat', $pelayanan_obat);
				} 	
				$i++;
			}
			
			// Insert Pelayanan Penyakit
			$i = 1;
			while(isset(${"kd_penyakit_".$i})) {
				//if(isset(${"kd_penyakit_".$i}) and !empty(${"kd_penyakit_".$i}) and ${"kd_penyakit_".$i} !== ""){
				if(${"kd_penyakit_".$i} !== ""){
					$pelayanan_penyakit['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_penyakit['kd_penyakit'] 			= ${"kd_penyakit_".$i};
					$pelayanan_penyakit['kd_jenis_kasus'] 		= ${"kd_jenis_kasus_".$i};
					$pelayanan_penyakit['kd_jenis_diagnosa'] 	= ${"kd_jenis_diagnosa_".$i};
					
					$this->m_crud->simpan('pelayanan_penyakit', $pelayanan_penyakit);
				} 	
				$i++;
			}
			
			// Insert Pelayanan Tindakan
			$i = 1;
			while(isset(${"kd_produk_".$i})) {
				//if(isset(${"kd_produk_".$i}) and !empty(${"kd_produk_".$i}) and ${"kd_produk_".$i} !== ""){
				if(${"kd_produk_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}	
				$i++;
			}
			
			// Insert Pelayanan laborat
			$i = 1;
			while(isset(${"kd_produk_lab_".$i})) {
				
				if(${"kd_produk_lab_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_lab_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_lab_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_lab_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}	
				$i++;
			}
			
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
		/*	if($this->session->userdata('id_akses') == 2 )
			{ 	redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
			} else { redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh'); }	*/
			
			redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh');
		}
		
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			//$pelayanan['kd_trans_pelayanan'] 	= $this->input->post('kd_trans_pelayanan');
		
                      
			$pelayanan['kd_jenis_layanan'] 	= $this->input->post('kd_jenis_layanan');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			
			//print_r($pelayanan['kd_jenis_layanan']); exit;
			$pelayanan['kd_rekam_medis'] 		= $this->input->post('kd_rekam_medis');
			$pelayanan['kd_trans_pelayanan']	= $this->input->post('kodepelayanan');
			$pelayanan['tgl_pelayanan'] 	= $this->functions->convert_date_sql($this->input->post('tgl_pelayanan'));
			$pelayanan['kd_puskesmas']	 	= $this->session->userdata('kd_puskesmas'); // harusnya diambil dari session
			
			$pelayanan['kd_dokter'] 		= $this->input->post('kd_dokter');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			$pelayanan['anamnesa'] 			= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 		= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 		= $this->input->post('cat_dokter');
		
			$pelayanan['no_rujukan'] 		= $this->input->post('no_rujukan');
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
			
			foreach ($_POST as $key=>$val) {
				$$key = $val;
			}
			
			// Insert Pelayanan Obat
			$i = 1;
			while(isset(${"nama_obat_".$i})) {
				//if(isset(${"nama_obat_".$i}) or !empty(${"nama_obat_".$i}) or ${"nama_obat_".$i} !== ""){
				if(${"nama_obat_".$i} !== ""){
					$pelayanan_obat['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_obat['kd_obat'] 				= ${"kd_obat_".$i};
					$pelayanan_obat['dosis'] 				= ${"dosis_".$i};
					$pelayanan_obat['kd_sat_kecil_obat'] 	= ${"satuan_".$i};
					$pelayanan_obat['qty'] 					= ${"jumlah_".$i};
					$pelayanan_obat['racikan']				= ${"racikan_".$i};
					$this->m_crud->simpan('pelayanan_obat', $pelayanan_obat);
				}	
				$i++;
			}
			
			// Insert Pelayanan Penyakit
			$i = 1;
			while(isset(${"kd_penyakit_".$i})) {
				//if(isset(${"kd_penyakit_".$i}) or !empty(${"kd_penyakit_".$i}) or ${"kd_penyakit_".$i} !== ""){
				if(${"kd_penyakit_".$i} !== ""){
					$pelayanan_penyakit['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_penyakit['kd_penyakit'] 			= ${"kd_penyakit_".$i};
					$pelayanan_penyakit['kd_jenis_kasus'] 		= ${"kd_jenis_kasus_".$i};
					$pelayanan_penyakit['kd_jenis_diagnosa'] 	= ${"kd_jenis_diagnosa_".$i};
					
					$this->m_crud->simpan('pelayanan_penyakit', $pelayanan_penyakit);
				}	
				$i++;
			}
			
			// Insert Pelayanan Tindakan
			$i = 1;
			while(isset(${"kd_produk_".$i})) {
				//if(isset(${"kd_produk_".$i}) or !empty(${"kd_produk_".$i}) or ${"kd_produk_".$i} !== ""){
				if(${"kd_produk_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}
				$i++;
			}
			// Insert Pelayanan laborat
			$i = 1;
			while(isset(${"kd_produk_lab_".$i})) {
				
				if(${"kd_produk_lab_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_lab_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_lab_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_lab_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
				}	
				$i++;
			}
			
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
			
			redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pelayanan'] = $this->m_crud->get_pelayanan_by_id($par2);
			$data['edit_pasien'] = $this->m_crud->get_list_pasien($data['edit_pelayanan'][0]['kd_rekam_medis']);
			
			if(!empty($data['edit_pelayanan'][0]['kd_bed'])){
				$data['edit_bed'] = $this->m_crud->get_list_bed_by_id($data['edit_pelayanan'][0]['kd_bed']);
				$data['list_bed'] = $this->m_crud->get_list_kamar($data['edit_bed']['kd_ruangan'], $data['edit_bed']['kelas']); 	
			}
			
			$data['edit_penyakit'] = $this->m_crud->get_list_pelayanan_penyakit_by_id($par2);
			$data['counter']	   = $this->m_crud->get_total_pelayanan_penyakit_by_id($par2);
			
			$data['edit_tindakan'] = $this->m_crud->get_list_pelayanan_tindakan_by_id($par2);
			$data['counter2']	   = $this->m_crud->get_total_pelayanan_tindakan_by_id($par2);	
			
			$data['edit_lab'] = $this->m_crud->get_list_pelayanan_lab_by_id($par2);
			$data['counter4']	   = $this->m_crud->get_total_pelayanan_lab_by_id($par2);	
			
			$data['edit_obat'] 		= $this->m_crud->get_list_pelayanan_obat_by_id($par2);
			$data['counter3']	   	= $this->m_crud->get_total_pelayanan_obat_by_id($par2);
			
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
	
			redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh');
		}
				
		$data['page_name']  = 'pelayanan';
		$data['page_title'] = 'Pelayanan';
		$data['pelayanan_hr_ini']	= $this->m_crud->get_pelayanan_by_date();
		
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		
		
		$this->table->set_heading('Kode Layanan','No. Rekam Medis','Nama Pasien','Tindakan Lab','Jumlah', 'Aksi');
       
		
		$data['list_jenis_layanan']			= $this->m_crud->get_list_jenis_layanan();
		$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_petugas']				= $this->m_crud->get_list_petugas('1');
		$data['list_dokter']				= $this->m_crud->get_list_dokter();
		$data['list_jenis_kasus']			= $this->m_crud->get_list_jenis_kasus();
		$data['list_jenis_diagnosa']		= $this->m_crud->get_list_jenis_diagnosa();
	$data['list_ruangan']				= $this->m_crud->get_list_ruangan_by_id($this->session->userdata('kd_puskesmas')); 
		
		$data['list_satuan_kecil']			= $this->m_crud->get_list_satuan_kecil('1');
		$data['list_status_keluar']			= $this->m_crud->get_list_status_keluar('1');
		
		$this->template->display('pelayanan_today_lab', $data);
		
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
	
	function autoCompleteLaborat()
	{
		if (isset($_REQUEST['term'])){
		  $q = strtolower($_GET['term']);
		  $output = $this->m_crud->get_tindakan_lab($q);
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
	function autoCompleteDosis()
	{
		if (isset($_REQUEST['term'])){
		  $q = strtolower($_GET['term']);
		  $output = $this->m_crud->get_dosis($q);
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
	public function cetak_resep()
	{
			$id = $this->uri->segment(3); //$this->session->userdata('id');
			$id_p = $this->session->userdata('id');
			
			$d['id'] = $id;
				
			$text = "SELECT *
					FROM pelayanan 
					WHERE kd_trans_pelayanan='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['tgl_pelayanan'] = $this->m_crud->tgl_indo($t->tgl_pelayanan);
			}
			
			
			$text = "SELECT *
					FROM pelayanan_obat,obat, satuan_kecil
					WHERE pelayanan_obat.kd_obat = obat.kd_obat AND pelayanan_obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat AND pelayanan_obat.kd_trans_pelayanan='$id'";

			$d['data'] = $this->m_crud->manualQuery($text);
			
			$d['data'] = $this->m_crud->manualQuery($text);
			
			$text = "SELECT * FROM puskesmas";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['nm_puskesmas'] = $t->nm_puskesmas;
				$d['alamat']	   = $t->alamat;
			}
			
			
			$this->template->tampil_cetak_resep('cetak_resep',$d);
							
			
	}
	
	public function cari_kamar()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kd_ruangan = $this->input->post('kd_ruangan');
			$kelas		= $this->input->post('kelas');
			
			//$data = $kd_ruangan.','.$kelas;
			
			$kamar = $this->m_crud->get_list_kamar_tersedia($kd_ruangan, $kelas);

			$data = "<option value='-'>Pilih Kamar</option>\n";
			
			if(!empty($kamar)){
				foreach($kamar as $v){
					$data .= "<option value='$v[kd_bed]'>Kamar $v[no_kamar] - Bed $v[no_bed]</option>\n";
				}
			} 
			
			echo $data;
			
		}else{
			header('location:'.base_url());
		}
	}
	
}
?>