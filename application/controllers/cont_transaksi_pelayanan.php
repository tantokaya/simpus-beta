<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_transaksi_pelayanan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_rujukan');
		
		// cek session
		if ($this->session->userdata('logged_in') == false) {
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
			$pelayanan['no_antrian']			= $this->m_crud->generate_queue($this->input->post('kd_unit_pelayanan'));
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
			$pelayanan['kd_dokter'] 			= $this->input->post('kd_dokter');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			$pelayanan['kd_bayar'] 				= $this->input->post('kd_bayar');
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			$pelayanan['anamnesa'] 				= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 			= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 			= $this->input->post('cat_dokter');
						
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
			
			$umur = $query['tanggal_lahir']; // dapet tgl lahir misal 2010-06-16
			//echo $umur; exit;
			
			$hitung = $this->functions->CalcAge($umur, date('Y-m-d'));
			$umurku=$hitung[0].' Th, '.$hitung[1].' Bln, '.$hitung[2].' Hr';
			//echo $hitung[0];
			//echo '<pre>'; print_r($hitung); exit;
			$pelayanan['umur'] = $umurku; // dalam bentuk string
			//echo $hitung; exit;
			//$pelayanan['umur'] = $umur_dlm_hari['umur_in_days']/365; // masukin angka umur ke dbase
			//echo '<pre>'; print_r($list_gol_umur); exit;
			#print_r($umur_dlm_hari); exit;
			#echo $umur_dlm_hari['umur_in_days']; exit;
			$umur_dlm_hari = $this->m_crud->calculate_age_in_days($pelayanan['tgl_pelayanan'],$umur);
			foreach($list_gol_umur as $rs):
				if($umur_dlm_hari['umur_in_days'] >= $rs['min_hr'] and $umur_dlm_hari['umur_in_days'] <= $rs['max_hr']){
					$pelayanan_penyakit['kd_gol_umur'] = $rs['kd_gol_umur'];
					$pelayanan['kd_gol_umur'] = $rs['kd_gol_umur'];
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
			
	/*		if($this->session->userdata('id_akses') == 2 ) //akun pendaftaran
			{ 	redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
			} else { redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh'); }	*/
			
			redirect('cont_transaksi_pelayanan/pelayanan_today', 'refresh');
		}
		
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			if ($this->session->userdata('id_akses') == 2) // pendaftaran hanya update 3 field 
			{
			$pelayanan['kd_jenis_layanan'] 	= $this->input->post('kd_jenis_layanan');
			$pelayanan['kd_petugas'] 	= $this->input->post('kd_petugas');

			$pelayanan['kd_bayar'] 		= $this->input->post('kd_bayar');


			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			} 
			$pelayanan['kd_status_pasien'] 	= $this->input->post('kd_status_pasien');
			$pelayanan['no_rujukan'] 		= $this->input->post('no_rujukan');
			$pelayanan['tempat_rujukan'] 	= $this->input->post('tempat_rujukan');
			
			} else { // jika bukan pendaftaran
			$pelayanan['kd_jenis_layanan'] 	= $this->input->post('kd_jenis_layanan');
			$pelayanan['kd_petugas'] 	= $this->input->post('kd_petugas');

			$pelayanan['kd_bayar'] 		= $this->input->post('kd_bayar');


			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			
			$pelayanan['kd_rekam_medis'] 		= $this->input->post('kd_rekam_medis');
			$pelayanan['kd_trans_pelayanan']	= $this->input->post('kodepelayanan');
			$pelayanan['tgl_pelayanan'] 	= $this->functions->convert_date_sql($this->input->post('tgl_pelayanan'));
			$pelayanan['kd_puskesmas']	 	= $this->session->userdata('kd_puskesmas'); // harusnya diambil dari session
			$pelayanan['kd_dokter'] 		= $this->input->post('kd_dokter');
			$pelayanan['anamnesa'] 			= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 		= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 		= $this->input->post('cat_dokter');
			
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
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
			
			
			//$pelayanan['umur'] = $umur_dlm_hari['umur_in_days']/365;
			
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
			} // endif bukan pendaftaran
			
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
				//$data['list_bed_all'] = $this->m_crud->get_list_kamar($data['edit_bed']['kd_ruangan']);	
				$data['list_bed_all'] = $this->m_crud->get_list_kamar_by_id($data['edit_bed']['kd_ruangan']);			
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
			//print_r($data['list_bed']);
			//exit;
			//echo $par2;
			#echo '<pre>'; print_r($data); exit;
			
			
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
		if ($par1 == 'view') {
			$data['view_rekam_medis'] = $this->m_crud->get_list_pasien($par2);
			$data['view_trans_pelayanan'] = $this->m_crud->get_pasien_rekam_medis($par2);
		}
				
		$data['page_name']  = 'pelayanan';
		$data['page_title'] = 'Pelayanan';
		$data['pelayanan_hr_ini']	= $this->m_crud->get_pelayanan_by_date();
		
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        	$this->table->set_template($tmpl);
 	
		if ($this->session->userdata('id_akses') == 2) // pendaftaran, dengan NO KK dan no KS
		{ $this->table->set_heading('No Antrian','Kode. Layanan','No. RM','Nama Pasien','No KK','Alamat','Umur','Pembayaran','No. KS','Status', 'Aksi');
		} 
		elseif ($this->session->userdata('id_akses') == 10 || $this->session->userdata('id_akses') == 11 || $this->session->userdata('id_akses') == 12 || $this->session->userdata('id_akses') == 13 )
		{ 	// view datatable jika di poli
			$this->table->set_heading('No Antrian','Kode. Layanan','No. RM','Nama Pasien','Alamat','Umur','Status', 'Aksi');
		} else { $this->table->set_heading('No Antrian','Kode. Layanan','No. RM','Nama Pasien','Alamat','Umur','Pembayaran','Status', 'Aksi'); 
		}	
		
		
		$data['list_jenis_layanan']			= $this->m_crud->get_list_jenis_layanan();
		$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_petugas']				= $this->m_crud->get_list_petugas('1');
		$data['list_cara_bayar']			= $this->m_crud->get_list_cara_bayar('1');
		$data['list_dokter']				= $this->m_crud->get_list_dokter();
		$data['list_jenis_kasus']			= $this->m_crud->get_list_jenis_kasus();
		$data['list_jenis_diagnosa']		= $this->m_crud->get_list_jenis_diagnosa();
		$data['list_ruangan']				= $this->m_crud->get_list_ruangan_by_id($this->session->userdata('kd_puskesmas')); 
		$data['list_bed']					= $this->m_crud->get_list_kamar('1'); // kd_ruangan
		$data['list_satuan_kecil']			= $this->m_crud->get_list_satuan_kecil('1');
		$data['list_status_keluar']			= $this->m_crud->get_list_status_keluar('1');
		$data['all_new_resep']	            = $this->m_crud->get_all_new_resep();
		
		$this->template->display('pelayanan_today', $data);
		#echo '<pre>'; print_r($data); exit;
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
	
	
	
	/***MASTER PELAYANAN TODAY LAB***/
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
			
			$pelayanan['kd_bayar'] 			= $this->input->post('kd_bayar');


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
			
			$pelayanan['umur'] = $umur_dlm_hari['umur_in_days']/365;
			
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
			if($this->session->userdata('id_akses') == 2 )
			{ 	redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
			} else { redirect('cont_transaksi_pelayanan/pelayanan_today_lab', 'refresh'); }	
			
			//redirect('cont_transaksi_pelayanan/pelayanan_today_lab', 'refresh');
		}
		
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			if ($this->session->userdata('id_akses') == 2) // pendaftaran hanya update 3 field 
			{
			$pelayanan['kd_jenis_layanan'] 	= $this->input->post('kd_jenis_layanan');
			$pelayanan['kd_petugas'] 	= $this->input->post('kd_petugas');

			$pelayanan['kd_bayar'] 		= $this->input->post('kd_bayar');


			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			} 
			$pelayanan['kd_status_pasien'] 	= $this->input->post('kd_status_pasien');
			$pelayanan['no_rujukan'] 		= $this->input->post('no_rujukan');
			$pelayanan['tempat_rujukan'] 	= $this->input->post('tempat_rujukan');
			
			} else { // jika bukan pendaftaran
			$pelayanan['kd_jenis_layanan'] 	= $this->input->post('kd_jenis_layanan');
			$pelayanan['kd_petugas'] 	= $this->input->post('kd_petugas');

			$pelayanan['kd_bayar'] 		= $this->input->post('kd_bayar');


			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			
			$pelayanan['kd_rekam_medis'] 		= $this->input->post('kd_rekam_medis');
			$pelayanan['kd_trans_pelayanan']	= $this->input->post('kodepelayanan');
			$pelayanan['tgl_pelayanan'] 	= $this->functions->convert_date_sql($this->input->post('tgl_pelayanan'));
			$pelayanan['kd_puskesmas']	 	= $this->session->userdata('kd_puskesmas'); // harusnya diambil dari session
			$pelayanan['kd_dokter'] 		= $this->input->post('kd_dokter');
			$pelayanan['anamnesa'] 			= $this->input->post('anamnesa');
			$pelayanan['cat_fisik'] 		= $this->input->post('cat_fisik');
			$pelayanan['cat_dokter'] 		= $this->input->post('cat_dokter');
			
			$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
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
			
			
			$pelayanan['umur'] = $umur_dlm_hari['umur_in_days']/365;
			
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
			} // endif bukan pendaftaran
			
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
			
			
			redirect('cont_transaksi_pelayanan/pelayanan_today_lab', 'refresh');
			
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
	
			redirect('cont_transaksi_pelayanan/pelayanan_today_lab', 'refresh');
		}
		if ($par1 == 'view') {
			$data['view_rekam_medis'] = $this->m_crud->get_list_pasien($par2);
			$data['view_trans_pelayanan'] = $this->m_crud->get_pasien_rekam_medis($par2);
		}
				
		$data['page_name']  = 'pelayanan';
		$data['page_title'] = 'Pelayanan';
		$data['pelayanan_hr_ini']	= $this->m_crud->get_pelayanan_by_date();
		
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 	
		$this->table->set_heading('Kode. Layanan','No. Rekam Medis','Nama Pasien','ALamat','Umur','Jenis Pemeriksaan','Jml');
	
		$data['list_jenis_layanan']			= $this->m_crud->get_list_jenis_layanan();
		$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_petugas']				= $this->m_crud->get_list_petugas('1');
		$data['list_cara_bayar']			= $this->m_crud->get_list_cara_bayar('1');
		$data['list_dokter']				= $this->m_crud->get_list_dokter();
		$data['list_jenis_kasus']			= $this->m_crud->get_list_jenis_kasus();
		$data['list_jenis_diagnosa']		= $this->m_crud->get_list_jenis_diagnosa();
		$data['list_ruangan']				= $this->m_crud->get_list_ruangan_by_id($this->session->userdata('kd_puskesmas')); 
		//$data['list_bed']					= $this->m_crud->get_list_kamar('RG-01'); // kd_ruangan
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
				
			$text = "SELECT pelayanan.kd_trans_pelayanan,pelayanan.kd_rekam_medis,pelayanan.tgl_pelayanan,pelayanan.kd_jenis_layanan,pelayanan.kd_unit_pelayanan,
                    pelayanan.kd_puskesmas,pelayanan.kd_dokter,pelayanan.kd_petugas,pelayanan.kd_status_pasien,pelayanan.anamnesa,pelayanan.cat_fisik,
                    pelayanan.cat_dokter,pelayanan.kd_bed,pelayanan.no_rujukan,pelayanan.tempat_rujukan,pelayanan.umur,pelayanan.`status`,pelayanan.timestamps,
                    pasien.no_reg,pasien.nm_lengkap,pasien.alamat,pasien.kd_kota,pasien.umur,pasien.kd_bayar,cara_bayar.cara_bayar
                    FROM pelayanan
                    LEFT JOIN pasien ON pelayanan.kd_rekam_medis = pasien.kd_rekam_medis
                    LEFT JOIN cara_bayar ON pasien.kd_bayar = cara_bayar.kd_bayar WHERE kd_trans_pelayanan='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['tgl_pelayanan'] = $this->m_crud->tgl_indo($t->tgl_pelayanan);
				$d['nm_lengkap'] = $t->nm_lengkap;
				$d['alamat_pasien'] = $t->alamat;
				$d['umur'] = $t->umur;
				$d['cara_bayar'] = $t->cara_bayar;
				$d['no_reg'] = $t->no_reg;
			}
			
			
			$text = "SELECT
                    pelayanan_obat.kd_trans_obat,
                    pelayanan_obat.kd_trans_pelayanan,
                    pelayanan_obat.kd_obat,
                    pelayanan_obat.dosis,
                    pelayanan_obat.qty,
                    pelayanan_obat.racikan,
                    obat.nama_obat,
                    obat.kd_sat_kecil_obat,
                    satuan_kecil.sat_kecil_obat
                    FROM
                    pelayanan_obat
                    LEFT JOIN obat ON pelayanan_obat.kd_obat = obat.kd_obat
                    LEFT JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                    WHERE
                    pelayanan_obat.kd_obat = obat.kd_obat
                    AND pelayanan_obat.kd_trans_pelayanan='$id'
                    ORDER BY pelayanan_obat.kd_trans_pelayanan DESC";
			
		   $d['data'] = $this->m_crud->manualQuery($text);

        $text = "SELECT
                    set_puskesmas.`status`,
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
                    set_puskesmas.telp,
                    kecamatan.nm_kecamatan,
                    propinsi.nm_propinsi,
                    kota.nm_kota,
                    kelurahan.nm_kelurahan
                    FROM set_puskesmas
                    LEFT JOIN propinsi ON set_puskesmas.kd_propinsi = propinsi.kd_propinsi
                    LEFT JOIN kecamatan ON set_puskesmas.kd_kecamatan = kecamatan.kd_kecamatan
                    LEFT JOIN kota ON set_puskesmas.kd_kota = kota.kd_kota
                    LEFT JOIN kelurahan ON set_puskesmas.kd_kelurahan = kelurahan.kd_kelurahan";
        $hasil = $this->m_crud->manualQuery($text);
        foreach($hasil ->result() as $t){
            $d['nm_puskesmas']  = $t->nm_puskesmas;
            $d['alamat']	    = $t->alamat;
            $d['nm_propinsi']   = $t->nm_propinsi;
            $d['nm_kota']       = $t->nm_kota;
            $d['nm_kecamatan']  = $t->nm_kecamatan;
            $d['nm_kelurahan']  = $t->nm_kelurahan;
            $d['telp']          = $t->telp;
        }
			
			
			$this->template->tampil_cetak_resep('cetak_resep',$d);
							
			
	}	
	public function cari_kamar()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$kd_ruangan = $this->input->post('kd_ruangan');
			
			if(empty($kd_ruangan)){
				$kode = $this->m_crud->get_pelayanan_by_id($this->uri->segment(4));
				$kd_ruangan = $kode['kd_bed'];	
			}
			
			$kamar = $this->m_crud->get_list_kamar_by_id($kd_ruangan);
			$data = "<option value='-'>Pilih Bed</option>\n";
						
			if(!empty($kamar)){
				foreach($kamar as $v){
					$data .= "<option value='$v[kd_bed]'>$v[kd_bed]</option>\n"; 
				}
			} 
			
			echo $data;
			
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak_rujukan() {
        $kd_trans_pelayanan = $this->uri->segment(3);
		$q="SELECT kd_status_pasien, tempat_rujukan FROM pelayanan WHERE kd_trans_pelayanan='$kd_trans_pelayanan'";
		$kueri = $this->m_crud->manualQuery($q);
		$hasil = $kueri->row_array();
		if ($hasil['kd_status_pasien'] != 'SKP-4' AND $hasil['tempat_rujukan']=='') {
			echo "Pasien tidak dirujuk";
		} 
		
		elseif ($hasil['kd_status_pasien'] == 'SKP-4' AND $hasil['tempat_rujukan']== '' ){
			echo "Tempat rujukan belum diisi oleh dokter";
		}
		elseif (($hasil['kd_status_pasien'] == 'SKP-4' AND $hasil['tempat_rujukan']!= '') OR ($hasil['kd_status_pasien'] != 'SKP-4' AND $hasil['tempat_rujukan']!='') ){
				
        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetPageOrientation('P');
        $pdf->SetAuthor('Pemerintah Kota Bogor');
        $pdf->SetTitle('Surat Rujukan Umum');
        $pdf->SetSubject('Surat Rujukan Rumah Sakit');
        $pdf->SetKeywords('Surat Rujukan');
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__).'/lang/eng.php'))
        {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 8, '', true);
        $pdf->AddPage();
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        $puskesmas = $this->m_rujukan->get_puskesmas_info($this->session->userdata('kd_puskesmas'));
		$kd_trans_pelayanan = $this->uri->segment(3);
		$surat = $this->m_rujukan->get_data_rujukan($kd_trans_pelayanan);
		
		if ($surat['alamat']=='') {$surat['alamat']= "-";}
		if ($surat['umur']=='') {$surat['umur']= "-";}
		if ($surat['jenis_kelamin']=='') {$surat['jenis_kelamin']= "-";}
		if ($surat['penyakit']=='') {$surat['penyakit']= "-";}
		if ($surat['tindakan']=='') {$surat['tindakan']= "-";}
		if ($surat['tempat_rujukan']=='') {$surat['tempat_rujukan']= "-";}
		
		#echo $this->db->last_query(); exit;
		
        $html     = '<table align="center" border="0" align="left">';
        $html    .= '<tr>
                        <td width="30%" style="text-align: center;"><img src="'.base_url().'assets/img/logo.png" width="80" height="80"/></td>
                        <td width="70%"><h3>PEMERINTAH KOTA BOGOR<br>DINAS KESEHATAN KOTA</h3>
                        <h4>UPTD '.$puskesmas["nm_puskesmas"].'<br>'.$puskesmas["alamat"].'</h4>
                        </td>
                    </tr>';
        $html    .= '</table>';
        $html    .= '<p align="center"><b>SURAT RUJUKAN</b></p>';

        $html   .= '<table align="center" cellpadding="2" cellspacing="0" border="0" width="100%">
    <tr>
        <td width="30%" style="text-align: left;">Kepada Yth. TS dr. Poli</td>
        <td width="5%" style="text-align: left;">:</td>
        <td width="65%" style="text-align: left;">................................</td>
    </tr>
    <tr>
        <td style="text-align: left;">Di RS</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["tempat_rujukan"].'</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align: left;" colspan="3">Mohon untuk pemeriksaan dan penanganan selanjutnya, OS: </td>
    </tr>
    <tr>
        <td style="text-align: left;">Nama</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["nm_lengkap"].'</td>
    </tr>
    <tr>
        <td style="text-align: left;">Umur</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["umur"].' Tahun</td>
    </tr>
    <tr>
        <td style="text-align: left;">Jenis Kelamin</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["jenis_kelamin"].'</td>
    </tr>
    <tr>
        <td style="text-align: left;">Alamat</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["alamat"].', Kel. '.ucwords(strtolower($surat["nm_kelurahan"])).', Kec. '.ucwords(strtolower($surat["nm_kecamatan"])).' , '.ucwords(strtolower($surat["nm_kota"])).'</td>
    </tr>
    <tr>
        <td style="text-align: left;">Diagnosa</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["penyakit"].'</td>
    </tr>
    <tr>
        <td style="text-align: left;">Telah diberikan</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["tindakan"].'</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align: left;" colspan="3">Demikian atas bantuannya, kami ucapkan terima kasih.</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Salam Sejawat,</td>
     </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><u>........................................... </u><br> <br>...........................................</td>
    </tr>
</table>';

        $pdf->SetTitle('Judul');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Pengarang');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->Output('Surat Rujukan.pdf', 'I');
    }
	}
	
	//_______ Cetak Kerta Resep Kosong __________//
	public function cetak_kertas_resep() {
       
        $this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm','A5', true, 'UTF-8', false);
        // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetPageOrientation('P');
        $pdf->SetAuthor('Pemerintah Kota Bogor');
        $pdf->SetTitle('Resep Obat');
        $pdf->SetSubject('Resep Obat');
        $pdf->SetKeywords('Resep Obat');
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        $pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__).'/lang/eng.php'))
        {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 12, '', true);
        $pdf->AddPage();
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        $puskesmas = $this->m_rujukan->get_puskesmas_info($this->session->userdata('kd_puskesmas'));
		$kd_trans_pelayanan = $this->uri->segment(3);
		$surat = $this->m_rujukan->get_data_pasien($kd_trans_pelayanan);
		
		if ($surat['alamat']=='') {$surat['alamat']= "-";}
		if ($surat['umur']=='') {$surat['umur']= "-";}
		if ($surat['jenis_kelamin']=='') {$surat['jenis_kelamin']= "-";}
		if ($surat['idkartu_medical']=='') {$surat['idkartu_medical']= "-";}
		if ($surat['kd_bayar']=='') {$surat['kd_bayar']= "-";}
		if ($surat['no_asuransi']=='') {$surat['no_asuransi']= "-";}
		if ($surat['nm_dokter']=='') {$surat['nm_dokter']= "_____________________";}
		$tgl=date('d-m-Y');
		
		#echo $this->db->last_query(); exit;
		
        $html     = '<table align="center" border="0" align="left">';
        $html    .= '<tr>
                        <td width="20%" style="text-align: center;"><img src="'.base_url().'assets/img/logo.png" width="80" height="80"/></td>
						
                        <td width="80%" style="text-align: center;"><h5>00/DOK IN PKM - USI/01/PKM/151/2011</h5><br><h3>PEMERINTAH KOTA BOGOR<br>DINAS KESEHATAN</h3>
                        <h4>UPTD '.$puskesmas["nm_puskesmas"].'<br>'.$puskesmas["alamat"].'<br>'.$puskesmas["no_telp"].'</h4>
					    </td>
                    </tr>';
        $html    .= '</table>';
        $html    .= '<p align="left"><b>Resep Obat</b></p>';

        $html   .= '<table align="center" cellpadding="2" cellspacing="0" border="0" width="100%">
    <tr>
        <td width="20%" border="1px" style="text-align: center;">'.$surat["kd_bayar"].'</td>
        <td width="5%" style="text-align: left;"></td>
        <td width="75%" style="text-align: right;">Bogor, '.$tgl.'</td>
    </tr>
    <tr>
        <td style="text-align: right;" colspan="3">No KK: '.$surat["idkartu_medical"].'</td>
    </tr>
	<tr>
        <td style="text-align: right;" colspan="3">No R.M. Pasien: '.$surat["kd_rekam_medis"].'</td>
    </tr>
    <tr>
    <td><p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
	<p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
	<p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
    <tr>
        <td style="text-align: right;" colspan="3">Pemeriksa, </td>
    </tr>
	<tr>
    <td><p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>	
	<tr>
        <td style="text-align: right;" colspan="3">'.$surat["nm_dokter"].'</td>
    </tr>
	<tr>
        <td width="15%" style="text-align: left;">No. Antrian</td>
        <td width="2%" style="text-align: left;">:</td>
        <td width="83%" style="text-align: left;">'.$surat["no_antrian"].'</td>
    </tr>
    <tr>
        <td width="15%" style="text-align: left;">Nama</td>
        <td width="2%" style="text-align: left;">:</td>
        <td width="83%" style="text-align: left;">'.$surat["nm_lengkap"].'</td>
    </tr>
    <tr>
        <td style="text-align: left;">Umur</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["umur"].'</td>
    </tr>
    <tr>
        <td style="text-align: left;">Alamat</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["alamat"].', Kel. '.ucwords(strtolower($surat["nm_kelurahan"])).', Kec. '.ucwords(strtolower($surat["nm_kecamatan"])).' , '.ucwords(strtolower($surat["nm_kota"])).'</td>
    </tr>
    <tr>
        <td style="text-align: left;">Status Psn</td>
        <td style="text-align: left;">:</td>
        <td style="text-align: left;">'.$surat["cara_bayar"].' , No '.$surat["no_asuransi"].'</td>
    </tr>
</table>';

        $pdf->SetTitle('Judul');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Pengarang');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->Output('Resep.pdf', 'I');
    
	}
}
?>