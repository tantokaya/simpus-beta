<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Op_pendaftaran extends CI_Controller
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
			redirect('op_pendaftaran/dashboard');
		else
			redirect('login');	
	}
	
	/***ADMIN DASHBOARD***/
	function dashboard()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$this->load->model('m_dashboard');
			
			$data['page_name']  = 'dashboard';
			$data['page_title'] = 'Dashboard';
			
			$sess = $this->session->userdata('kd_puskesmas');
						
			$data['total_pasien_date'] 	= $this->m_dashboard->get_total_pasien_today(date('Y-m-d'), $sess); 
			$data['total_pasien_month']	= $this->m_dashboard->get_total_pasien_monthly(date('m'), $sess);
			$data['total_pasien_year']	= $this->m_dashboard->get_total_pasien_yearly(date('Y'), $sess);
			
			$data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today($sess); 
			$data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'), $sess);
			$data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly($sess);
			$data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'), $sess);
			
			$data['top_desease']			= $this->m_dashboard->get_top5_desease();
			
			for ($i=1; $i <= 12; $i++){
				$data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i, $sess);
				$data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i, $sess);
				$data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i, $sess);
			}
			
			$data['info_login'] = $this->m_crud->get_puskesmas_by_id($this->session->userdata('kd_puskesmas'));
			$data['info_kecamatan'] = $this->m_crud->get_kecamatan_by_id($data['info_login']['kd_kecamatan']);
			
			$this->template->display('dashboard', $data);
		} else {
			redirect('login');
		}	
	}
	
	
	/***TRANSAKSI PENDAFTARAN PASIEN***/
	function pendaftaran($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_rekam_medis'] = $this->m_crud->generate_rekam_medis($this->session->userdata('kd_puskesmas'));
			$data['nm_lengkap'] = $this->input->post('nm_lengkap');
			$data['tanggal_daftar'] = $this->functions->convert_date_sql($this->input->post('tanggal_daftar'));
			$data['tempat_lahir'] = $this->input->post('tempat_lahir');
			$data['tanggal_lahir'] = $this->functions->convert_date_sql($this->input->post('tanggal_lahir'));
	
			$hitung = $this->functions->dateDifference($data['tanggal_lahir'],$data['tanggal_daftar']);
			$data['umur'] = $hitung[0];
			
			$data['kd_jenis_kelamin'] = $this->input->post('kd_jenis_kelamin');
			$data['kd_jenis_pasien'] = $this->input->post('kd_jenis_pasien');
			$data['kd_bayar'] = $this->input->post('kd_bayar');
			$data['no_kk'] = $this->input->post('no_kk');
			$data['nm_kk'] = $this->input->post('nm_kk');
			$data['asuransi'] = $this->input->post('asuransi');
			$data['no_asuransi'] = $this->input->post('no_asuransi');
			//$data['ket_wilayah'] = $this->input->post('wilayah');
			$data['nik'] = $this->input->post('nik');
			$data['alamat'] = $this->input->post('alamat');
			$data['kd_propinsi'] = $this->input->post('kd_propinsi');
			$data['kd_kota'] = $this->input->post('kd_kota');
			$data['kd_kecamatan'] = $this->input->post('kd_kecamatan');
			$data['kd_kelurahan'] = $this->input->post('kd_kelurahan');
			$data['kd_pos'] = $this->input->post('kd_pos');
			$data['no_telepon'] = $this->input->post('no_telepon');
			$data['no_hp'] = $this->input->post('no_hp');
			$data['kd_agama'] = $this->input->post('kd_agama');
			$data['kd_gol_darah'] = $this->input->post('kd_gol_darah');
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['kd_pekerjaan'] = $this->input->post('kd_pekerjaan');
			$data['kd_status_marital'] = $this->input->post('kd_status_marital');
			$data['nm_ayah'] = $this->input->post('nm_ayah');
			$data['nm_ibu'] = $this->input->post('nm_ibu');
			$data['nm_orang'] = $this->input->post('nm_orang');
			$data['rincian_penanggung'] = $this->input->post('rincian_penanggung');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			
			$this->m_crud->simpan('pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data Pendaftaran berhasil disimpan!');
			redirect('op_pendaftaran/pendaftaran', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_rekam_medis'] = $this->m_crud->generate_rekam_medis($this->session->userdata('kd_puskesmas'));
			$data['nm_lengkap'] = $this->input->post('nm_lengkap');
			$data['tanggal_daftar'] = $this->functions->convert_date_sql($this->input->post('tanggal_daftar'));
			$data['tempat_lahir'] = $this->input->post('tempat_lahir');
			$data['tanggal_lahir'] = $this->functions->convert_date_sql($this->input->post('tanggal_lahir'));
			$data['kd_jenis_kelamin'] = $this->input->post('kd_jenis_kelamin');
			$data['kd_jenis_pasien'] = $this->input->post('kd_jenis_pasien');
			$data['kd_bayar'] = $this->input->post('kd_bayar');
			$data['no_kk'] = $this->input->post('no_kk');
			$data['nm_kk'] = $this->input->post('nm_kk');
			$data['asuransi'] = $this->input->post('asuransi');
			$data['no_asuransi'] = $this->input->post('no_asuransi');
			//$data['ket_wilayah'] = $this->input->post('wilayah');
			$data['nik'] = $this->input->post('nik');
			$data['alamat'] = $this->input->post('alamat');
			$data['kd_propinsi'] = $this->input->post('kd_propinsi');
			$data['kd_kota'] = $this->input->post('kd_kota');
			$data['kd_kecamatan'] = $this->input->post('kd_kecamatan');
			$data['kd_kelurahan'] = $this->input->post('kd_kelurahan');
			$data['kd_pos'] = $this->input->post('kd_pos');
			$data['no_telepon'] = $this->input->post('no_telepon');
			$data['no_hp'] = $this->input->post('no_hp');
			$data['kd_agama'] = $this->input->post('kd_agama');
			$data['kd_gol_darah'] = $this->input->post('kd_gol_darah');
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['kd_pekerjaan'] = $this->input->post('kd_pekerjaan');
			$data['kd_status_marital'] = $this->input->post('kd_status_marital');
			$data['nm_ayah'] = $this->input->post('nm_ayah');
			$data['nm_ibu'] = $this->input->post('nm_ibu');
			$data['nm_orang'] = $this->input->post('nm_orang');
			$data['rincian_penanggung'] = $this->input->post('rincian_penanggung');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			
			$this->m_crud->perbaharui('kd_rekam_medis', $par3, 'pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data Pendaftaran berhasil diperbaharui!');
			redirect('op_pendaftaran/pendaftaran', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pendaftaran'] = $this->m_crud->get_pendaftaran_by_id($par2);
			$data['edit_kota'] = $this->m_crud->get_kota_by_propinsi_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,2));
			$data['edit_kecamatan'] = $this->m_crud->get_kecamatan_by_kota_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,4));
			$data['edit_kelurahan'] = $this->m_crud->get_kelurahan_by_kec_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,7));
		}
		
		if ($par1 == 'hapus') {
			$this->db->where('kd_rekam_medis', $par2);
			$this->db->delete('pasien');
			$this->session->set_flashdata('flash_message', 'Data pendaftaran berhasil dihapus!');
			redirect('op_pendaftaran/pendaftaran', 'refresh');
		}
		
		if ($par1 == 'view') {
			$data['view_rekam_medis'] = $this->m_crud->get_list_pasien($par2);
			$data['view_trans_pelayanan'] = $this->m_crud->get_pasien_rekam_medis($par2);
		}
		
		$data['page_name']  = 'pendaftaran';
		$data['page_title'] = 'Pendaftaran' ;
		//$data['pendaftaran']	= $this->m_crud->get_all_pendaftaran();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered" width="100%">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('No. Rekam Medis','Nama Pasien','NIK','Tanggal Lahir','Umur','Aksi');
		
		$data['list_jenis_kelamin'] = $this->m_crud->get_list_jenis_kelamin('1');
		$data['list_jp'] = $this->m_crud->get_list_jp('1');
		$data['list_cb'] = $this->m_crud->get_list_cb('1');
		$data['list_agama'] = $this->m_crud->get_list_agama('1');
		$data['list_golongan_darah'] = $this->m_crud->get_list_golongan_darah('1');
		$data['list_pendidikan'] = $this->m_crud->get_list_pendidikan('1');
		$data['list_pekerjaan'] = $this->m_crud->get_list_pekerjaan('1');
		//$data['list_ras'] = $this->m_crud->get_list_ras('1');
		//$data['list_asal_pasien'] = $this->m_crud->get_list_asal_pasien('1');
		$data['list_status_marital'] = $this->m_crud->get_list_status_marital('1');
		$data['list_provinsi'] = $this->m_crud->get_list_provinsi('1');
		$data['list_spesialisasi'] = $this->m_crud->get_list_spesialisasi('1');
		
		$data['list_ruangan'] = $this->m_crud->get_list_ruangan('1');
		$data['list_kamar'] = $this->m_crud->get_list_kamar('1');
		$data['list_petugas'] = $this->m_crud->get_list_petugas('1');
		$data['list_unit_pelayanan'] = $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_kota'] = $this->m_crud->get_list_kota('1');
		$data['list_kecamatan'] = $this->m_crud->get_list_kcmt('1');
		//$data['list_kelurahan'] = $this->m_crud->get_list_kelurahan('1');
		//$data['list_puskesmas']	= $this->m_crud->get_list_puskesmas();
		
		$this->template->display('pendaftaran', $data);
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
					
			$tgl_lahir							= $this->functions->convert_date_sql($this->input->post('tanggal_lahir'));
			
			$pelayanan['umur'] = $this->functions->daysBetween($pelayanan['tgl_pelayanan'], $tgl_lahir);
			//$pelayanan['umur'] = dateDifference($hitung[0]);
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			$pelayanan['kd_puskesmas']	 		= $this->session->userdata('kd_puskesmas'); // datanya diambil dari login session
			//$pelayanan['kd_dokter'] 			= $this->input->post('kd_dokter');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			//$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			//$pelayanan['anamnesa'] 				= $this->input->post('anamnesa');
			//$pelayanan['cat_fisik'] 			= $this->input->post('cat_fisik');
			//$pelayanan['cat_dokter'] 			= $this->input->post('cat_dokter');
			//$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
			//$pelayanan['no_rujukan'] 			= $this->input->post('no_rujukan');
			//$pelayanan['tempat_rujukan'] 		= $this->input->post('tempat_rujukan');
			
			// start transaksi dengan db
			/*$this->db->trans_start();
			
			$this->m_crud->simpan('pelayanan', $pelayanan);
			
			foreach ($_POST as $key=>$val) {
				$$key = $val;
			}
			
			// Insert Pelayanan Obat
			$i = 1;
			while(isset(${"nama_obat_".$i})) {
				if(isset(${"nama_obat_".$i}) or !empty(${"nama_obat_".$i}) or ${"nama_obat_".$i} !== ""){
					$pelayanan_obat['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_obat['kd_obat'] 				= ${"kd_obat_".$i};
					$pelayanan_obat['dosis'] 				= ${"dosis_".$i};
					$pelayanan_obat['kd_sat_kecil_obat'] 	= ${"satuan_".$i};
					$pelayanan_obat['qty'] 					= ${"jumlah_".$i};
				
					$this->m_crud->simpan('pelayanan_obat', $pelayanan_obat);
					$i++;
				} else {
					exit;
				}	
			}
			
			// Insert Pelayanan Penyakit
			$i = 1;
			while(isset(${"kd_penyakit_".$i})) {
				if(isset(${"kd_penyakit_".$i}) or !empty(${"kd_penyakit_".$i}) or ${"kd_penyakit_".$i} !== ""){
					$pelayanan_penyakit['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_penyakit['kd_penyakit'] 			= ${"kd_penyakit_".$i};
					$pelayanan_penyakit['kd_jenis_kasus'] 		= ${"kd_jenis_kasus_".$i};
					$pelayanan_penyakit['kd_jenis_diagnosa'] 	= ${"kd_jenis_diagnosa_".$i};
					
					$this->m_crud->simpan('pelayanan_penyakit', $pelayanan_penyakit);
					$i++;
				} else {
					exit;
				}	
			}
			
			// Insert Pelayanan Tindakan
			$i = 1;
			while(isset(${"kd_produk_".$i})) {
				if(isset(${"kd_produk_".$i}) or !empty(${"kd_produk_".$i}) or ${"kd_produk_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $trans_id;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
					$i++;
				} else {
					exit;
				}	
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
			}*/
			
			$this->m_crud->simpan('pelayanan', $pelayanan);
			$this->session->set_flashdata('flash_message', 'Data Pelayanan berhasil disimpan!');
			redirect('op_pendaftaran/pelayanan', 'refresh');
		}
		
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			//$pelayanan['kd_trans_pelayanan'] 	= $this->input->post('kd_trans_pelayanan');
			$pelayanan['kd_rekam_medis'] 		= $this->input->post('kd_rekam_medis');
			$pelayanan['kd_jenis_layanan'] 		= $this->input->post('kd_jenis_layanan');
			$pelayanan['tgl_pelayanan'] 		= $this->functions->convert_date_sql($this->input->post('tgl_pelayanan'));
			$tgl_lahir							= $this->functions->convert_date_sql($this->input->post('tanggal_lahir'));
			$pelayanan['umur']					= $this->functions->daysBetween($pelayanan['tgl_pelayanan'], $tgl_lahir);
			
			if($pelayanan['kd_jenis_layanan'] == 3){
				$pelayanan['kd_bed']		 		= $this->input->post('kd_bed');
				
			} else {
				$pelayanan['kd_bed']		 		= NULL;
			}
			
			//print_r($pelayanan['kd_jenis_layanan']); exit;
			
			$pelayanan['kd_unit_pelayanan'] 	= $this->input->post('kd_unit_pelayanan');
			$pelayanan['kd_puskesmas']	 		= $this->session->userdata('kd_puskesmas'); // harusnya diambil dari session
			//$pelayanan['kd_dokter'] 			= $this->input->post('kd_dokter');
			$pelayanan['kd_petugas'] 			= $this->input->post('kd_petugas');
			//$pelayanan['kd_status_pasien'] 		= $this->input->post('kd_status_pasien'); // blm
			//$pelayanan['anamnesa'] 				= $this->input->post('anamnesa');
			//$pelayanan['cat_fisik'] 			= $this->input->post('cat_fisik');
			//$pelayanan['cat_dokter'] 			= $this->input->post('cat_dokter');
			//
			//$pelayanan['no_rujukan'] 			= $this->input->post('no_rujukan');
			//$pelayanan['tempat_rujukan'] 		= $this->input->post('tempat_rujukan');
			
			// start transaksi dengan database
			//$this->db->trans_start();
			
			// delete existing record on table pelayanan_obat, pelayanan_penyakit, pelayanan_tindakan first
			// and then insert new record
			/*$this->db->where('kd_trans_pelayanan', $par3);
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
				if(isset(${"nama_obat_".$i}) or !empty(${"nama_obat_".$i}) or ${"nama_obat_".$i} !== ""){
					$pelayanan_obat['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_obat['kd_obat'] 				= ${"kd_obat_".$i};
					$pelayanan_obat['dosis'] 				= ${"dosis_".$i};
					$pelayanan_obat['kd_sat_kecil_obat'] 	= ${"satuan_".$i};
					$pelayanan_obat['qty'] 					= ${"jumlah_".$i};
				
					$this->m_crud->simpan('pelayanan_obat', $pelayanan_obat);
					$i++;
				} else {
					exit;
				}	
			}
			
			// Insert Pelayanan Penyakit
			$i = 1;
			while(isset(${"kd_penyakit_".$i})) {
				if(isset(${"kd_penyakit_".$i}) or !empty(${"kd_penyakit_".$i}) or ${"kd_penyakit_".$i} !== ""){
					$pelayanan_penyakit['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_penyakit['kd_penyakit'] 			= ${"kd_penyakit_".$i};
					$pelayanan_penyakit['kd_jenis_kasus'] 		= ${"kd_jenis_kasus_".$i};
					$pelayanan_penyakit['kd_jenis_diagnosa'] 	= ${"kd_jenis_diagnosa_".$i};
					
					$this->m_crud->simpan('pelayanan_penyakit', $pelayanan_penyakit);
					$i++;
				} else {
					exit;
				}	
			}
			
			// Insert Pelayanan Tindakan
			$i = 1;
			while(isset(${"kd_produk_".$i})) {
				if(isset(${"kd_produk_".$i}) or !empty(${"kd_produk_".$i}) or ${"kd_produk_".$i} !== ""){
					$pelayanan_tindakan['kd_trans_pelayanan'] 	= $par3;
					$pelayanan_tindakan['kd_produk'] 			= ${"kd_produk_".$i};
					$pelayanan_tindakan['qty'] 					= ${"qty_".$i};
					$pelayanan_tindakan['ket_tindakan']		 	= ${"ket_tindakan_".$i};
					
					$this->m_crud->simpan('pelayanan_tindakan', $pelayanan_tindakan);
					$i++;
				} else {
					exit;
				}	
			}
			*/
			// update table pelayanan
			$this->m_crud->perbaharui('kd_trans_pelayanan', $par3, 'pelayanan', $pelayanan);
			$this->session->set_flashdata('flash_message', 'Data transaksi pelayanan berhasil diperbaharui!');
			redirect('op_pendaftaran/pelayanan', 'refresh');
			/*
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
			
			redirect('op_pendaftaran/pelayanan', 'refresh');
			*/
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
	
			redirect('op_pendaftaran/pelayanan', 'refresh');
		}
				
		$data['page_name']  = 'pelayanan';
		$data['page_title'] = 'Pelayanan';
		//$data['pelayanan']	= $this->m_crud->get_all_pelayanan();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('No. Transaksi Pelayanan','Tanggal','No. Rekam Medis','Nama Pasien','Jenis Pelayanan','Unit Layanan','Tanggal Format','Aksi');
		
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
	
	/***Get Kota***/
	function getKota()
	{
		$kd_propinsi = $this->input->post('kd_propinsi');
		$kota = $this->m_crud->get_kota_by_propinsi_id($kd_propinsi);
		
		$data = "<option value=''></option>\n";
		foreach($kota as $v){
			$data .= "<option value='$v[kd_kota]'>$v[nm_kota]</option>\n";
		}
		
		echo $data;
	}
	
	function getListKota() {
		$kd_propinsi = $this->input->post('kd_propinsi');
		$kota = $this->m_crud->get_list_kota($kd_propinsi);
		$data .= "<option value=''>--Pilih Kota--</option>";
		foreach ($kota as $k) {
			$data .= "<option value='$k[kd_kota]'>$k[nm_kota]</option>";
		}
		echo $data;
	}
	
	function autoCompleteICD() {
		if (isset($_REQUEST['term'])){
		  $q = strtolower($_GET['term']);
		  $output = $this->m_crud->get_icd($q);
		  $this->output->set_content_type('application/json')->set_output(json_encode($output));
    	}
	}
	
	function getKecamatan()
	{
		$kd_kota = $this->input->post('kd_kota');
		$kecamatan = $this->m_crud->get_kecamatan_by_kota_id($kd_kota);
		
		$data = "<option value=''></option>\n";
		foreach($kecamatan as $v){
			$data .= "<option value='$v[kd_kecamatan]'>$v[nm_kecamatan]</option>\n";
		}
		
		echo $data;
	}
	
	function getKelurahan()
	{
		$kd_kecamatan = $this->input->post('kd_kecamatan');
		$kelurahan = $this->m_crud->get_kelurahan_by_kec_id($kd_kecamatan);
		
		$data = "<option value=''></option>\n";
		foreach($kelurahan as $v){
			$data .= "<option value='$v[kd_kelurahan]'>$v[nm_kelurahan]</option>\n";
		}
		
		echo $data;
	}
	
	function lb1($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/format_lb1.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
			
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);
			
			//get puskesmas info from session
			$data['puskesmas'] = $this->m_crud->get_info_puskesmas($kd_puskesmas);
			switch($this->input->post('bulan'))
			{
				case 1:
					$bulan = "JANUARI"; break;
				case 2:
					$bulan = "FEBRUARI"; break;
				case 3:
					$bulan = "MARET"; break;
				case 4:
					$bulan = "APRIL"; break;
				case 5:
					$bulan = "MEI"; break;
				case 6:
					$bulan = "JUNI"; break;
				case 7:
					$bulan = "JULI"; break;
				case 8:
					$bulan = "AGUSTUS"; break;
				case 9:
					$bulan = "SEPTEMBER"; break;
				case 10:
					$bulan = "OKTOBER"; break;
				case 11:
					$bulan = "NOVEMBER"; break;
				case 12:
					$bulan = "DESEMBER"; break;
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('F1', $data['puskesmas'][0]['kd_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('F3', $data['puskesmas'][0]['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('F4', $data['puskesmas'][0]['nm_kecamatan']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH5', $bulan);
			$objPHPExcel->getActiveSheet()->setCellValue('AH6', $this->input->post('tahun'));
			
			
			
			
			$filename='LB1_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		
		$data['page_name']  = 'lb1';
		$data['page_title'] = 'LB1';
		$this->template->display('form_lb1', $data);
	}
	
	public function cari_pasien()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$rm = $this->input->post('rekam_medis');
			$data = $this->m_crud->get_pasien_by_id($rm, $this->session->userdata('kd_puskesmas'));
			echo $data;
			
		}else{
			header('location:'.base_url());
		}
	}

}
