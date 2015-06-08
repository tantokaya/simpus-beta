<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_master_farmasi extends CI_Controller
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
	
	/***MASTER OBAT***/
	function obat($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_obat'] 		= $this->input->post('kd_obat');
			$data['nama_obat'] 		= $this->input->post('nama_obat');
			$data['harga_beli'] 		= $this->input->post('harga_beli');
			$data['harga_jual'] 		= $this->input->post('harga_jual');
			$data['kd_gol_obat']		= $this->input->post('kd_gol_obat');
			$data['kd_sat_kecil_obat'] 	= $this->input->post('kd_sat_kecil_obat');
			$data['kd_terapi_obat'] 	= $this->input->post('kd_terapi_obat');
			$data['pabrik'] 		= $this->input->post('pabrik');
			$data['singkatan'] 		= $this->input->post('singkatan');
			$data['kd_milik_obat'] 		= $this->input->post('kd_milik_obat');
			$data['tgl_kadaluarsa'] 	= $this->m_crud->tgl_sql($this->input->post('tgl_kadaluarsa'));
			
			$this->m_crud->simpan('obat', $data);
			$this->session->set_flashdata('flash_message', 'Data obat berhasil disimpan!');
			redirect('cont_master_farmasi/obat', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_obat'] 		= $this->input->post('kd_obat');
			$data['nama_obat'] 		= $this->input->post('nama_obat');
			$data['harga_beli'] 		= $this->input->post('harga_beli');
			$data['harga_jual'] 		= $this->input->post('harga_jual');
			$data['kd_gol_obat'] 		= $this->input->post('kd_gol_obat');
			$data['kd_sat_kecil_obat'] 	= $this->input->post('kd_sat_kecil_obat');
			$data['kd_terapi_obat'] 	= $this->input->post('kd_terapi_obat');
			$data['pabrik'] 		= $this->input->post('pabrik');
			$data['singkatan'] 		= $this->input->post('singkatan');
			$data['kd_milik_obat'] 		= $this->input->post('kd_milik_obat');
			$data['tgl_kadaluarsa'] 	= $this->m_crud->tgl_sql($this->input->post('tgl_kadaluarsa'));
			
			
			$this->m_crud->perbaharui('kd_obat', $par3, 'obat', $data);
			$this->session->set_flashdata('flash_message', 'Data obat berhasil diperbaharui!');
			redirect('cont_master_farmasi/obat', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_obat'] = $this->m_crud->get_obat_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_obat', $par2);
			$this->db->delete('obat');
			$this->session->set_flashdata('flash_message', 'Data obat berhasil dihapus!');
			redirect('cont_master_farmasi/obat', 'refresh');
		}
		
		$data['page_name']  = 'obat';
		$data['page_title'] = 'Obat';
		$data['obat']	= $this->m_crud->get_all_obat();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
		
		if ($this->session->userdata('id_akses')== 1 || $this->session->userdata('id_akses')==6 || $this->session->userdata('id_akses')==8 || $this->session->userdata('id_akses')==7) {
			$this->table->set_heading('Kode Obat','Nama Obat','Satuan','Terapi','Tgl Kadaluwarsa','Aksi');
		} else {
			$this->table->set_heading('Kode Obat','Nama Obat','Satuan','Terapi','Tgl Kadaluwarsa');
		}
		
 		//$this->table->set_heading('Kode Obat','Nama Obat','Golongan','Satuan','Terapi','Aksi');
		$data['list_golongan_obat'] = $this->m_crud->get_list_golongan_obat('1');
		$data['list_satuan_kecil'] = $this->m_crud->get_list_satuan_kecil('1');
		$data['list_terapi_obat'] = $this->m_crud->get_list_terapi_obat('1');
		$data['list_milik_obat'] = $this->m_crud->get_list_milik_obat();
			
		$this->template->display('obat', $data);
		
	}
	
	/***MASTER STOK OBAT***/
	function obat_gudang_stok($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		$data['page_name']  = 'stokgudang';
		$data['page_title'] = 'Stok Gudang Obat';
		$data['obat']	= $this->m_crud->get_all_obat();
		
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Obat','Nama Obat','Golongan','Stok Akhir','Satuan','Terapi');
		$data['list_golongan_obat'] = $this->m_crud->get_list_golongan_obat('1');
		$data['list_satuan_kecil'] = $this->m_crud->get_list_satuan_kecil('1');
		$data['list_milik_obat'] = $this->m_crud->get_list_milik_obat('1');
		
		$this->template->display('stok_gudang', $data);
		
	}
	
	function obat_apotek_stok($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		$data['page_name']  = 'stokapotek';
		$data['page_title'] = 'Stok Obat Apotek';
		$data['obat']	= $this->m_crud->get_all_obat();
		
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Obat','Nama Obat','Golongan','Stok Akhir','Satuan','Terapi');
		$data['list_golongan_obat'] = $this->m_crud->get_list_golongan_obat('1');
		$data['list_satuan_kecil'] = $this->m_crud->get_list_satuan_kecil('1');
		//$data['list_satuan_besar'] = $this->m_crud->get_list_satuan_besar('1');
		//$data['list_terapi_obat'] = $this->m_crud->get_list_terapi_obat('1');
		$data['list_milik_obat'] = $this->m_crud->get_list_milik_obat('1');
			
		$this->template->display('stok_apotek', $data);
		
	}
	
	
	/***MASTER GOLONGAN OBAT***/
	function golongan_obat($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_gol_obat'] = $this->input->post('kd_gol_obat');
			$data['gol_obat'] = $this->input->post('gol_obat');
			
			$this->m_crud->simpan('golongan_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data golongan obat berhasil disimpan!');
			redirect('cont_master_farmasi/golongan_obat', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_gol_obat'] = $this->input->post('kd_gol_obat');
			$data['gol_obat'] = $this->input->post('gol_obat');
			$this->m_crud->perbaharui('kd_gol_obat', $par3, 'golongan_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data golongan obat berhasil diperbaharui!');
			redirect('cont_master_farmasi/golongan_obat', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_golongan_obat'] = $this->m_crud->get_golongan_obat_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_gol_obat', $par2);
			$this->db->delete('golongan_obat');
			$this->session->set_flashdata('flash_message', 'Data golongan obat berhasil dihapus!');
			redirect('cont_master_farmasi/golongan_obat', 'refresh');
		}
		
		$data['page_name']  = 'golongan_obat';
		$data['page_title'] = 'Golongan Obat';
		//$data['golongan_obat']	= $this->m_crud->get_all_golongan_obat();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
		if($this->session->userdata('id_akses') == 1) {
			$this->table->set_heading('Kode Golongan Obat','Golongan Obat','Aksi');
		} else {
		 	$this->table->set_heading('Kode Golongan Obat','Golongan Obat');
		}
 		//$this->table->set_heading('Kode Golongan Obat','Golongan Obat','Aksi');
		
		$this->template->display('golongan_obat', $data);
		
	}
	
	/***MASTER HARGA OBAT***/
	function harga_obat($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_tarif'] = $this->input->post('kd_tarif');
			$data['harga_beli'] = $this->input->post('harga_beli');
			$data['harga_jual'] = $this->input->post('harga_jual');
			$data['kd_milik_obat'] = $this->input->post('kd_milik_obat');
			$data['kd_obat'] = $this->input->post('kd_obat');
			
			$this->m_crud->simpan('harga_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data harga obat berhasil disimpan!');
			redirect('cont_master_farmasi/harga_obat', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_tarif'] = $this->input->post('kd_tarif');
			$data['harga_beli'] = $this->input->post('harga_beli');
			$data['harga_jual'] = $this->input->post('harga_jual');
			$data['kd_milik_obat'] = $this->input->post('kd_milik_obat');
			$data['kd_obat'] = $this->input->post('kd_obat');
			
			$this->m_crud->perbaharui('kd_tarif', $par3, 'harga_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data harga obat berhasil diperbaharui!');
			redirect('cont_master_farmasi/harga_obat', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_harga_obat'] = $this->m_crud->get_harga_obat_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_tarif', $par2);
			$this->db->delete('harga_obat');
			$this->session->set_flashdata('flash_message', 'Data harga obat berhasil dihapus!');
			redirect('cont_master_farmasi/harga_obat', 'refresh');
		}
		
		$data['page_name']  = 'harga_obat';
		$data['page_title'] = 'Harga Obat';
		$data['harga_obat']	= $this->m_crud->get_all_harga_obat();
		$data['list_obat']	= $this->m_crud->get_list_obat();
		$data['list_milik_obat'] = $this->m_crud->get_list_milik_obat('1');

			
		$this->template->display('harga_obat', $data);
		
	}

	/***TAMBAH STOK OBAT***/
	function stok_obat($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah' && $par2 == 'do_update') {
			$data['kd_jenis_obat'] = $this->input->post('kd_jenis_obat');
			$data['jenis_obat'] = $this->input->post('jenis_obat');
			
			$this->m_crud->perbaharui('kd_jenis_obat', $par3, 'jenis_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis obat berhasil diperbaharui!');
			
			redirect('cont_master_farmasi/gudang', 'refresh');
			
		} else if ($par1 == 'tambah') {
			
			$data['tambah_stok_obat'] = $this->m_crud->get_obat_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_jenis_obat', $par2);
			$this->db->delete('jenis_obat');
			$this->session->set_flashdata('flash_message', 'Data jenis obat berhasil dihapus!');
			redirect('cont_master_farmasi/jenis_obat', 'refresh');
		}
		
		$data['tgl_beli']			= date('d-m-Y');
		$data['kode_beli']			= $this->m_crud->MaxKodeBeli(); 
		$data['page_name']  		= 'stok_obat';
		$data['page_title']	 		= 'Stok Obat';
		$data['list_milik_obat'] 	= $this->m_crud->get_list_milik_obat('1');
		$data['list_unit_farmasi'] 	= $this->m_crud->get_list_unit_farmasi('1');
		$data['obat_masuk']			= $this->m_crud->get_all_masuk();
			
		$this->template->display('gudang', $data);
		
	}

	
	/***MASTER JENIS OBAT***/
	function jenis_obat($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_jenis_obat'] = $this->input->post('kd_jenis_obat');
			$data['jenis_obat'] = $this->input->post('jenis_obat');
			
			$this->m_crud->simpan('jenis_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis obat berhasil disimpan!');
			redirect('cont_master_farmasi/jenis_obat', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_jenis_obat'] = $this->input->post('kd_jenis_obat');
			$data['jenis_obat'] = $this->input->post('jenis_obat');
			
			$this->m_crud->perbaharui('kd_jenis_obat', $par3, 'jenis_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis obat berhasil diperbaharui!');
			redirect('cont_master_farmasi/jenis_obat', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_jenis_obat'] = $this->m_crud->get_jenis_obat_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_jenis_obat', $par2);
			$this->db->delete('jenis_obat');
			$this->session->set_flashdata('flash_message', 'Data jenis obat berhasil dihapus!');
			redirect('cont_master_farmasi/jenis_obat', 'refresh');
		}
		
		$data['page_name']  = 'jenis_obat';
		$data['page_title'] = 'Jenis Obat';
		//$data['jenis_obat']	= $this->m_crud->get_all_jenis_obat();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 			if($this->session->userdata('id_akses') == 1) {
					$this->table->set_heading('Kode Jenis Obat','Jenis Obat','Aksi');
				} else {
						$this->table->set_heading('Kode Jenis Obat','Jenis Obat');
				}
		//$this->table->set_heading('Kode Jenis Obat','Jenis Obat','Aksi');
			
		$this->template->display('jenis_obat', $data);
		
	}
	
	/***MASTER MILIK OBAT***/
	function milik_obat($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_milik_obat'] = $this->input->post('kd_milik_obat');
			$data['kepemilikan'] = $this->input->post('kepemilikan');
			
			$this->m_crud->simpan('milik_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data milik obat berhasil disimpan!');
			redirect('cont_master_farmasi/milik_obat', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_milik_obat'] = $this->input->post('kd_milik_obat');
			$data['kepemilikan'] = $this->input->post('kepemilikan');
			
			$this->m_crud->perbaharui('kd_milik_obat', $par3, 'milik_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data milik obat berhasil diperbaharui!');
			redirect('cont_master_farmasi/milik_obat', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_milik_obat'] = $this->m_crud->get_milik_obat_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_milik_obat', $par2);
			$this->db->delete('milik_obat');
			$this->session->set_flashdata('flash_message', 'Data milik obat berhasil dihapus!');
			redirect('cont_master_farmasi/milik_obat', 'refresh');
		}
		
		$data['page_name']  = 'milik_obat';
		$data['page_title'] = 'Milik Obat';
		//$data['milik_obat']	= $this->m_crud->get_all_milik_obat();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Milik Obat','Kepemilikan','Aksi');
			
		$this->template->display('milik_obat', $data);
		
	}
	
	
	
	/***MASTER SATUAN KECIL***/
	function satuan_kecil($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_sat_kecil_obat'] = $this->input->post('kd_sat_kecil_obat');
			$data['sat_kecil_obat'] = $this->input->post('sat_kecil_obat');
			
			$this->m_crud->simpan('satuan_kecil', $data);
			$this->session->set_flashdata('flash_message', 'Data satuan kecil obat berhasil disimpan!');
			redirect('cont_master_farmasi/satuan_kecil', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_sat_kecil_obat'] = $this->input->post('kd_sat_kecil_obat');
			$data['sat_kecil_obat'] = $this->input->post('sat_kecil_obat');
			
			$this->m_crud->perbaharui('kd_sat_kecil_obat', $par3, 'satuan_kecil', $data);
			$this->session->set_flashdata('flash_message', 'Data satuan kecil obat berhasil diperbaharui!');
			redirect('cont_master_farmasi/satuan_kecil', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_satuan_kecil'] = $this->m_crud->get_satuan_kecil_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_sat_kecil_obat', $par2);
			$this->db->delete('satuan_kecil');
			$this->session->set_flashdata('flash_message', 'Data satuan kecil obat berhasil dihapus!');
			redirect('cont_master_farmasi/satuan_kecil', 'refresh');
		}
		
		$data['page_name']  = 'satuan_kecil';
		$data['page_title'] = 'Satuan Kecil Obat';
		//$data['satuan_kecil']	= $this->m_crud->get_all_satuan_kecil();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		if ($this->session->userdata('id_akses') == 1){
			$this->table->set_heading('Kode Satuan Kecil Obat','Satuan Kecil Obat','Aksi');
		} else {	$this->table->set_heading('Kode Satuan Kecil Obat','Satuan Kecil Obat');
		}
		//$this->table->set_heading('Kode Satuan Kecil Obat','Satuan Kecil Obat','Aksi');
			
		$this->template->display('satuan_kecil', $data);
		
	}
	
	/***MASTER TERAPI OBAT***/
	function terapi_obat($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_terapi_obat'] = $this->input->post('kd_terapi_obat');
			$data['terapi_obat'] = $this->input->post('terapi_obat');
			
			$this->m_crud->simpan('terapi_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data terapi obat berhasil disimpan!');
			redirect('cont_master_farmasi/terapi_obat', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_terapi_obat'] = $this->input->post('kd_terapi_obat');
			$data['terapi_obat'] = $this->input->post('terapi_obat');
			
			$this->m_crud->perbaharui('kd_terapi_obat', $par3, 'terapi_obat', $data);
			$this->session->set_flashdata('flash_message', 'Data terapi obat berhasil diperbaharui!');
			redirect('cont_master_farmasi/terapi_obat', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_terapi_obat'] = $this->m_crud->get_terapi_obat_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_terapi_obat', $par2);
			$this->db->delete('terapi_obat');
			$this->session->set_flashdata('flash_message', 'Data terapi obat berhasil dihapus!');
			redirect('cont_master_farmasi/terapi_obat', 'refresh');
		}
		
		$data['page_name']  = 'terapi_obat';
		$data['page_title'] = 'Terapi Obat';
		//$data['terapi_obat']	= $this->m_crud->get_all_terapi_obat();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Terapi Obat','Terapi Obat','Aksi');
			
		$this->template->display('terapi_obat', $data);
		
	}
	
	/***MASTER UNIT FARMASI***/
	function unit_farmasi($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_unit_farmasi'] = $this->input->post('kd_unit_farmasi');
			$data['nama_unit_farmasi'] = $this->input->post('nama_unit_farmasi');
			$data['farmasi_utama'] = $this->input->post('farmasi_utama');
			
			$this->m_crud->simpan('unit_farmasi', $data);
			$this->session->set_flashdata('flash_message', 'Data unit farmasi berhasil disimpan!');
			redirect('cont_master_farmasi/unit_farmasi', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_unit_farmasi'] = $this->input->post('kd_unit_farmasi');
			$data['nama_unit_farmasi'] = $this->input->post('nama_unit_farmasi');
			$data['farmasi_utama'] = $this->input->post('farmasi_utama');
			
			$this->m_crud->perbaharui('kd_unit_farmasi', $par3, 'unit_farmasi', $data);
			$this->session->set_flashdata('flash_message', 'Data unit farmasi berhasil diperbaharui!');
			redirect('cont_master_farmasi/unit_farmasi', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_unit_farmasi'] = $this->m_crud->get_unit_farmasi_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_unit_farmasi', $par2);
			$this->db->delete('unit_farmasi');
			$this->session->set_flashdata('flash_message', 'Data unit farmasi berhasil dihapus!');
			redirect('cont_master_farmasi/unit_farmasi', 'refresh');
		}
		
		$data['page_name']  = 'unit_farmasi';
		$data['page_title'] = 'Unit Farmasi / Apotik';
		//$data['unit_farmasi']	= $this->m_crud->get_all_unit_farmasi();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Unit Farmasi Obat','Nama Unit Farmasi','Farmasi Utama','Aksi');
			
		$this->template->display('unit_farmasi', $data);
		
	}
	
	/***MASTER DOSIS***/
	function dosis($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['takaran_dosis'] = $this->input->post('takaran_dosis');
			
			$this->m_crud->simpan('dosis', $data);
			$this->session->set_flashdata('flash_message', 'Data takaran dosis berhasil disimpan!');
			redirect('cont_master_farmasi/dosis', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_dosis'] = $this->input->post('kd_dosis');
			$data['takaran_dosis'] = $this->input->post('takaran_dosis');
			
			$this->m_crud->perbaharui('kd_dosis', $par3, 'dosis', $data);
			$this->session->set_flashdata('flash_message', 'Data takaran dosis berhasil diperbaharui!');
			redirect('cont_master_farmasi/dosis', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_dosis'] = $this->m_crud->get_dosis_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_dosis', $par2);
			$this->db->delete('dosis');
			$this->session->set_flashdata('flash_message', 'Data takaran dosis berhasil dihapus!');
			redirect('cont_master_farmasi/dosis', 'refresh');
		}
		
		$data['page_name']  = 'unit_dosis';
		$data['page_title'] = 'Unit Farmasi / Dosis';
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
        if ($this->session->userdata('id_akses') != 1){
 			$this->table->set_heading('Takaran Dosis','Aksi');
 		}else{
 			$this->table->set_heading('Takaran Dosis');
 		}
			
		$this->template->display('dosis', $data);
		
	}
}
?>