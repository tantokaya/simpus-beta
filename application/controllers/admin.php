<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$simkes=$this->load->database('default', TRUE);
		//$simobat=$this->load->database('obat', TRUE);
		
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
	
	/***Default function, redirects to login page if no admin logged in yet***/
	public function index()
	{
		if ($this->session->userdata('logged_in') == true)
			redirect('admin/dashboard');
		else {
			$this->session->unset_userdata();
			$this->session->sess_destroy();
			redirect('login');
		}
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
                        propinsi.nm_propinsi,
                        kecamatan.nm_kecamatan,
                        kelurahan.nm_kelurahan,
                        kota.nm_kota
                        FROM
                        set_puskesmas
                        INNER JOIN propinsi ON set_puskesmas.kd_propinsi = propinsi.kd_propinsi
                        INNER JOIN kecamatan ON set_puskesmas.kd_kecamatan = kecamatan.kd_kecamatan
                        INNER JOIN kelurahan ON set_puskesmas.kd_kelurahan = kelurahan.kd_kelurahan
                        INNER JOIN kota ON set_puskesmas.kd_kota = kota.kd_kota ";
            $hasil = $this->m_crud->manualQuery($text);
            foreach($hasil ->result() as $t){
                $data['nm_puskesmas']   = $t->nm_puskesmas;
                $data['nip_kpl']    = $t->nip_kpl;
                $data['kpl_puskesmas']  = $t->kpl_puskesmas;
                $data['nm_kota']        = $t->nm_kota;
                $data['nm_kecamatan']   = $t->nm_kecamatan;
                $data['nm_kelurahan']   = $t->nm_kelurahan;
                $data['nm_propinsi']    = $t->nm_propinsi;
                $data['alamat']         = $t->alamat;
            }		
			$data['total_pasien_date'] 	= $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
			$data['total_pasien_month']	= $this->m_dashboard->get_total_pasien_monthly(date('m'));
			$data['total_pasien_year']	= $this->m_dashboard->get_total_pasien_yearly(date('Y'));
			
			$data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today(); 
			$data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
			$data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
			$data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));
			
			$data['top_desease']			= $this->m_dashboard->get_top5_desease();
			
			for ($i=1; $i <= 12; $i++){
				$data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i);
				$data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i);
				$data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i);
			}		
			
			//echo '<pre>'; print_r($data['kunjungan']); exit;
			
			$this->template->display('dashboard', $data);
		} else {
			redirect('login');
		}
		
	}
	
	
	/***MASTER CARA MASUK***/
	function cara_masuk($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_cara_masuk'] = $this->input->post('kd_cara_masuk');
			$data['cara_masuk'] = $this->input->post('cara_masuk');
			
			$this->m_crud->simpan('cara_masuk', $data);
			$this->session->set_flashdata('flash_message', 'Data cara masuk pasien berhasil disimpan!');
			redirect('admin/cara_masuk', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_cara_masuk'] = $this->input->post('kd_cara_masuk');
			$data['cara_masuk'] = $this->input->post('cara_masuk');
			
			$this->m_crud->perbaharui('kd_cara_masuk', $par3, 'cara_masuk', $data);
			$this->session->set_flashdata('flash_message', 'Data cara masuk pasien berhasil diperbaharui!');
			redirect('admin/cara_masuk', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_cara_masuk'] = $this->m_crud->get_cara_masuk_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_cara_masuk', $par2);
			$this->db->delete('cara_masuk');
			$this->session->set_flashdata('flash_message', 'Data cara masuk pasien berhasil dihapus!');
			redirect('admin/cara_masuk', 'refresh');
		}
		
		$data['page_name']  = 'cara_masuk';
		$data['page_title'] = 'Cara Masuk Pasien';
		$data['cara_masuk']	= $this->m_crud->get_all_cara_masuk();
			
		$this->template->display('cara_masuk', $data);
		
	}
	
		/***MASTER SUKU / RAS***/
	function ras($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_ras'] = $this->input->post('kd_ras');
			$data['ras'] = $this->input->post('ras');
			
			$this->m_crud->simpan('ras', $data);
			$this->session->set_flashdata('flash_message', 'Data ras / suku berhasil disimpan!');
			redirect('admin/ras', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_ras'] = $this->input->post('kd_ras');
			$data['ras'] = $this->input->post('ras');
			
			$this->m_crud->perbaharui('kd_ras', $par3, 'ras', $data);
			$this->session->set_flashdata('flash_message', 'Data ras / suku berhasil diperbaharui!');
			redirect('admin/ras', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_ras'] = $this->m_crud->get_ras_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_ras', $par2);
			$this->db->delete('ras');
			$this->session->set_flashdata('flash_message', 'Data ras / suku berhasil dihapus!');
			redirect('admin/ras', 'refresh');
		}
		
		$data['page_name']  = 'ras';
		$data['page_title'] = 'Ras / Suku';
		$data['ras']	= $this->m_crud->get_all_ras();
			
		$this->template->display('ras', $data);
		
	}
	
	
	
	/***MASTER SARANA POSYANDU***/
	function sarana_posyandu($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_sarana_posyandu'] = $this->input->post('kd_sarana_posyandu');
			$data['srn_posyandu'] = $this->input->post('srn_posyandu');
			
			$this->m_crud->simpan('sarana_posyandu', $data);
			$this->session->set_flashdata('flash_message', 'Data sarana posyandu berhasil disimpan!');
			redirect('admin/sarana_posyandu', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_sarana_posyandu'] = $this->input->post('kd_sarana_posyandu');
			$data['srn_posyandu'] = $this->input->post('srn_posyandu');
			
			$this->m_crud->perbaharui('kd_sarana_posyandu', $par3, 'sarana_posyandu', $data);
			$this->session->set_flashdata('flash_message', 'Data sarana posyandu berhasil diperbaharui!');
			redirect('admin/sarana_posyandu', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_sarana_posyandu'] = $this->m_crud->get_sarana_posyandu_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_sarana_posyandu', $par2);
			$this->db->delete('sarana_posyandu');
			$this->session->set_flashdata('flash_message', 'Data sarana posyandu berhasil dihapus!');
			redirect('admin/sarana_posyandu', 'refresh');
		}
		
		$data['page_name']  = 'sarana_posyandu';
		$data['page_title'] = 'Sarana Posyandu';
		$data['sarana_posyandu']	= $this->m_crud->get_all_sarana_posyandu();
			
		$this->template->display('sarana_posyandu', $data);
		
	}
	
	
	/***MASTER KELOMPOK PASIEN***/
	function kelompok_pasien($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_kelompok_pasien'] = $this->input->post('kd_kelompok_pasien');
			$data['customer'] = $this->input->post('customer');
			$data['telepon'] = $this->input->post('telepon');
			
			$this->m_crud->simpan('kelompok_pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data kelompok_pasien berhasil disimpan!');
			redirect('admin/kelompok_pasien', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_kelompok_pasien'] = $this->input->post('kd_kelompok_pasien');
			$data['customer'] = $this->input->post('customer');
			$data['telepon'] = $this->input->post('telepon');
			
			$this->m_crud->perbaharui('kd_kelompok_pasien', $par3, 'kelompok_pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data kelompok_pasien berhasil diperbaharui!');
			redirect('admin/kelompok_pasien', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_kelompok_pasien'] = $this->m_crud->get_kelompok_pasien_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_kelompok_pasien', $par2);
			$this->db->delete('kelompok_pasien');
			$this->session->set_flashdata('flash_message', 'Data kelompok_pasien berhasil dihapus!');
			redirect('admin/kelompok_pasien', 'refresh');
		}
		
		$data['page_name']  = 'kelompok_pasien';
		$data['page_title'] = 'Kelompok Pasien' ;
		$data['kelompok_pasien']	= $this->m_crud->get_all_kelompok_pasien();
			
		$this->template->display('kelompok_pasien', $data);
	}
	
	/***MASTER KATEGORI IMUNISASI***/
	function kategori_imunisasi($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_kategori_imunisasi'] = $this->input->post('kd_kategori_imunisasi');
			$data['jenis_imunisasi'] = $this->input->post('jenis_imunisasi');
						
			$this->m_crud->simpan('kategori_imunisasi', $data);
			$this->session->set_flashdata('flash_message', 'Data kategori imunisasi berhasil disimpan!');
			redirect('admin/kategori_imunisasi', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_kategori_imunisasi'] = $this->input->post('kd_kategori_imunisasi');
			$data['jenis_imunisasi'] = $this->input->post('jenis_imunisasi');
						
			$this->m_crud->perbaharui('kd_kategori_imunisasi', $par3, 'kategori_imunisasi', $data);
			$this->session->set_flashdata('flash_message', 'Data kategori imunisasi berhasil diperbaharui!');
			redirect('admin/kategori_imunisasi', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_kategori_imunisasi'] = $this->m_crud->get_kategori_imunisasi_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_kategori_imunisasi', $par2);
			$this->db->delete('kategori_imunisasi');
			$this->session->set_flashdata('flash_message', 'Data kategori imunisasi berhasil dihapus!');
			redirect('admin/kategori_imunisasi', 'refresh');
		}
		
		$data['page_name']  = 'kategori_imunisasi';
		$data['page_title'] = 'Kategori Imunisasi' ;
		$data['kategori_imunisasi']	= $this->m_crud->get_all_kategori_imunisasi();
			
		$this->template->display('kategori_imunisasi', $data);
	}
	
	/***MASTER JENIS PASIEN***/
	function jenis_pasien($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_jenis_pasien'] = $this->input->post('kd_jenis_pasien');
			$data['jenis_pasien'] = $this->input->post('jenis_pasien');
						
			$this->m_crud->simpan('jenis_pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis pasien berhasil disimpan!');
			redirect('admin/jenis_pasien', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_jenis_pasien'] = $this->input->post('kd_jenis_pasien');
			$data['jenis_pasien'] = $this->input->post('jenis_pasien');
						
			$this->m_crud->perbaharui('kd_jenis_pasien', $par3, 'jenis_pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis pasien berhasil diperbaharui!');
			redirect('admin/jenis_pasien', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_jenis_pasien'] = $this->m_crud->get_jenis_pasien_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_jenis_pasien', $par2);
			$this->db->delete('jenis_pasien');
			$this->session->set_flashdata('flash_message', 'Data jenis pasien berhasil dihapus!');
			redirect('admin/jenis_pasien', 'refresh');
		}
		
		$data['page_name']  = 'jenis_pasien';
		$data['page_title'] = 'Jenis Pasien' ;
		$data['jenis_pasien']	= $this->m_crud->get_all_jenis_pasien();
			
		$this->template->display('jenis_pasien', $data);
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
	
	public function edit_profile($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['email'] = $this->input->post('email');
			$data['nama'] = $this->input->post('nama');
			$data['nip'] = $this->input->post('nip');
			
			$this->m_crud->perbaharui('id_user', $par3, 'user', $data);
			$this->session->set_flashdata('flash_message', 'Profil berhasil diperbaharui!');
			redirect('admin/edit_profile', 'refresh');
		
		} else if ($par1 == 'ubah_password') {
			$data['user'] 		= $this->m_crud->get_user_by_id($this->session->userdata('id_user'));
			// cek data input dengan password di db
			if (md5($this->input->post('old_pass')) == $data['user']['password']){
				// cek pass dan re pass
				if($this->input->post('password') ==  $this->input->post('re_pass')){
					$update['password'] = md5($this->input->post('password'));
			
					$this->m_crud->perbaharui('id_user', $this->session->userdata('id_user') , 'user', $update);
					$this->session->set_flashdata('flash_message', 'Profil berhasil diperbaharui!');
					redirect('admin/edit_profile', 'refresh');
				} else {
					$this->session->set_flashdata('flash_message', 'Password dan Re-password tidak cocok!');
					redirect('admin/edit_profile', 'refresh');
				}
				
			} else {
				$this->session->set_flashdata('flash_message', 'Password lama tidak cocok!');
				redirect('admin/edit_profile', 'refresh');
			}
			
			
		}
		
		$data['page_name']  = 'edit_profile';
		$data['page_title'] = 'Edit Profil';
		
		$data['user'] 		= $this->m_crud->get_user_by_id($this->session->userdata('id_user'));
		
		/*
		if(empty($this->session->userdata('kd_puskesmas')))
			$data['puskesmas'] 	= '';
		else
		*/
			
			$data['puskesmas'] 	= $this->m_crud->get_puskesmas_by_id($this->session->userdata('kd_puskesmas'));
			
		$this->template->display('edit_profile', $data);
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

}
