<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_master_pelayanan extends CI_Controller
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
	
	/***MASTER TINDAKAN***/
	function tindakan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_produk'] = $this->input->post('kd_produk');
			$data['produk'] = $this->input->post('nm_produk');
			$data['harga'] = $this->input->post('harga');
			$data['keterangan_tindakan'] = $this->input->post('ket');
			
			$this->m_crud->simpan('tindakan', $data);
			$this->session->set_flashdata('flash_message', 'Data tindakan berhasil disimpan!');
			redirect('cont_master_pelayanan/tindakan', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_produk'] = $this->input->post('kd_produk');
			$data['produk'] = $this->input->post('nm_produk');
			$data['harga'] = $this->input->post('harga');
			$data['keterangan_tindakan'] = $this->input->post('ket');
			
			$this->m_crud->perbaharui('kd_produk', $par3, 'tindakan', $data);
			$this->session->set_flashdata('flash_message', 'Data tindakan berhasil diperbaharui!');
			redirect('cont_master_pelayanan/tindakan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_tindakan'] = $this->m_crud->get_tindakan_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_produk', $par2);
			$this->db->delete('tindakan');
			$this->session->set_flashdata('flash_message', 'Data tindakan berhasil dihapus!');
			redirect('cont_master_pelayanan/tindakan', 'refresh');
		}
		
		$data['page_name']  = 'tindakan';
		$data['page_title'] = 'Tindakan';
		//$data['tindakan']	= $this->m_crud->get_all_tindakan();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		
	/*	if ($this->session->userdata('id_akses' == 1)) {
			$this->table->set_heading('Kode Produk','Produk','Harga','Keterangan Tindakan','Aksi');		
		} else {
			$this->table->set_heading('Kode Produk','Produk','Harga','Keterangan Tindakan');	
		}
		*/
		$this->table->set_heading('Kode Produk','Produk','Harga','Keterangan Tindakan','Aksi');
		
		$this->template->display('tindakan', $data);
		
	}
	
	/***MASTER ASAL PASIEN***/
	function asal_pasien($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_asal'] = $this->input->post('kd_asal');
			$data['asl_pasien'] = $this->input->post('asl_pasien');
			
			$this->m_crud->simpan('asal_pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data asal pasien berhasil disimpan!');
			redirect('cont_master_pelayanan/asal_pasien', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_asal'] = $this->input->post('kd_asal');
			$data['asl_pasien'] = $this->input->post('asl_pasien');
			
			$this->m_crud->perbaharui('kd_asal', $par3, 'asal_pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data asal pasien berhasil diperbaharui!');
			redirect('cont_master_pelayanan/asal_pasien', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_asal_pasien'] = $this->m_crud->get_asal_pasien_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_asal', $par2);
			$this->db->delete('asal_pasien');
			$this->session->set_flashdata('flash_message', 'Data asal pasien berhasil dihapus!');
			redirect('cont_master_pelayanan/asal_pasien', 'refresh');
		}
		
		$data['page_name']  = 'asal_pasien';
		$data['page_title'] = 'Asal Pasien';
		//$data['asal_pasien']	= $this->m_crud->get_all_asal_pasien();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Asal','Asal Pasien','Aksi');	
		
		$this->template->display('asal_pasien', $data);
		
	}
	/***MASTER UNIT PELAYANAN***/
	function unit_pelayanan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			
			$data['nm_unit'] = $this->input->post('nm_unit');
			//$data['kd_puskesmas'] = $this->input->post('kd_puskesmas');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			$this->m_crud->simpan('unit_pelayanan', $data);
			$this->session->set_flashdata('flash_message', 'Data unit pelayanan berhasil disimpan!');
			redirect('cont_master_pelayanan/unit_pelayanan', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_unit_pelayanan'] = $this->input->post('kd_unit_pelayanan');
			$data['nm_unit'] = $this->input->post('nm_unit');
			//$data['kd_puskesmas'] = $this->input->post('kd_puskesmas');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			$this->m_crud->perbaharui('kd_unit_pelayanan', $par3, 'unit_pelayanan', $data);
			$this->session->set_flashdata('flash_message', 'Data unit pelayanan berhasil diperbaharui!');
			redirect('cont_master_pelayanan/unit_pelayanan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_unit_pelayanan'] = $this->m_crud->get_unit_pelayanan_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_unit_pelayanan', $par2);
			$this->db->delete('unit_pelayanan');
			$this->session->set_flashdata('flash_message', 'Data unit pelayanan berhasil dihapus!');
			redirect('cont_master_pelayanan/unit_pelayanan', 'refresh');
		}
		
		$data['page_name']  = 'unit_pelayanan';
		$data['page_title'] = 'Unit Pelayanan';
		$data['list_puskesmas']	= $this->m_crud->get_list_puskesmas();
		//$data['unit_pelayanan']	= $this->m_crud->get_all_unit_pelayanan();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Nama Unit','Aksi');
		
		$this->template->display('unit_pelayanan', $data);
	}
	
	/***MASTER ICD INDUK***/
	function icd_induk($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_icd_induk'] = $this->input->post('kd_icd_induk');
			$data['nm_icd_induk'] = $this->input->post('nm_icd_induk');
			
			$this->m_crud->simpan('icd_induk', $data);
			$this->session->set_flashdata('flash_message', 'Data ICD Induk berhasil disimpan!');
			redirect('cont_master_pelayanan/icd_induk', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_icd_induk'] = $this->input->post('kd_icd_induk');
			$data['nm_icd_induk'] = $this->input->post('nm_icd_induk');
			
			$this->m_crud->perbaharui('kd_icd_induk', $par3, 'icd_induk', $data);
			$this->session->set_flashdata('flash_message', 'Data ICD Induk berhasil diperbaharui!');
			redirect('cont_master_pelayanan/icd_induk', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_icd_induk'] = $this->m_crud->get_icd_induk_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_icd_induk', $par2);
			$this->db->delete('icd_induk');
			$this->session->set_flashdata('flash_message', 'Data ICD Induk berhasil dihapus!');
			redirect('cont_master_pelayanan/icd_induk', 'refresh');
		}
		
		$data['page_name']  = 'icd_induk';
		$data['page_title'] = 'ICD Induk';
		//$data['icd_induk']	= $this->m_crud->get_all_icd_induk();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode ICD Induk','ICD Induk','Aksi');
			
		$this->template->display('icd_induk', $data);
	}
	
	/***MASTER ICD***/
	function icd($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_penyakit'] = $this->input->post('kd_penyakit');
			$data['penyakit'] = $this->input->post('penyakit');
			//$data['includes'] = $this->input->post('includes');
			//$data['excludes'] = $this->input->post('excludes');
			//$data['notes'] = $this->input->post('notes');
			//$data['statusapp'] = $this->input->post('statusapp');
			$data['deskripsi'] = $this->input->post('deskripsi');
			$data['kd_icd_induk'] = $this->input->post('kd_icd_induk');
			
			$this->m_crud->simpan('icd', $data);
			$this->session->set_flashdata('flash_message', 'Data ICD berhasil disimpan!');
			redirect('cont_master_pelayanan/icd', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_penyakit'] = $this->input->post('kd_penyakit');
			$data['penyakit'] = $this->input->post('penyakit');
			//$data['includes'] = $this->input->post('includes');
			//$data['excludes'] = $this->input->post('excludes');
			//$data['notes'] = $this->input->post('notes');
			//$data['statusapp'] = $this->input->post('statusapp');
			$data['deskripsi'] = $this->input->post('deskripsi');
			$data['kd_icd_induk'] = $this->input->post('kd_icd_induk');
			
			$this->m_crud->perbaharui('kd_penyakit', $par3, 'icd', $data);
			$this->session->set_flashdata('flash_message', 'Data ICD berhasil diperbaharui!');
			redirect('cont_master_pelayanan/icd', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_icd'] = $this->m_crud->get_icd_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_penyakit', $par2);
			$this->db->delete('icd');
			$this->session->set_flashdata('flash_message', 'Data ICD berhasil dihapus!');
			redirect('cont_master_pelayanan/icd', 'refresh');
		}
		
		$data['page_name']  = 'icd';
		$data['page_title'] = 'ICD' ;
		//$data['icd']	= $this->m_crud->get_all_icd();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Penyakit','Kode ICD Induk','Penyakit','Aksi');
		
		$data['list_icd_induk'] = $this->m_crud->get_list_icd_induk();
			
		$this->template->display('icd', $data);
	}
	
	/***MASTER JENIS KASUS***/
	function jenis_kasus($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_jenis_kasus'] = $this->input->post('kd_jenis_kasus');
			$data['jns_kasus'] = $this->input->post('jns_kasus');
			$data['kd_icd_induk'] = $this->input->post('kd_icd_induk');
			$data['kd_jenis'] = $this->input->post('kd_jenis');
			
			
			$this->m_crud->simpan('jenis_kasus', $data);
			$this->session->set_flashdata('flash_message', 'Data Jenis Kasus berhasil disimpan!');
			redirect('cont_master_pelayanan/jenis_kasus', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_jenis_kasus'] = $this->input->post('kd_jenis_kasus');
			$data['jns_kasus'] = $this->input->post('jns_kasus');
			$data['kd_icd_induk'] = $this->input->post('kd_icd_induk');
			$data['kd_jenis'] = $this->input->post('kd_jenis');
			
			$this->m_crud->perbaharui('kd_jenis_kasus', $par3, 'jenis_kasus', $data);
			$this->session->set_flashdata('flash_message', 'Data Jenis kasus berhasil diperbaharui!');
			redirect('cont_master_pelayanan/jenis_kasus', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_jenis_kasus'] = $this->m_crud->get_jenis_kasus_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_jenis_kasus', $par2);
			$this->db->delete('jenis_kasus');
			$this->session->set_flashdata('flash_message', 'Data Jenis Kasus berhasil dihapus!');
			redirect('cont_master_pelayanan/jenis_kasus', 'refresh');
		}
		
		$data['page_name']  = 'jenis_kasus';
		$data['page_title'] = 'Jenis Kasus' ;
		$data['jenis_kasus']	= $this->m_crud->get_all_jenis_kasus();
		$data['list_icd_induk'] = $this->m_crud->get_list_icd_induk();
			
		$this->template->display('jenis_kasus', $data);
	}
	
	/***MASTER KASUS***/
	function kasus($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_jenis_kasus'] = $this->input->post('kd_jenis_kasus');
			$data['variabel_id'] = $this->input->post('variabel_id');
			$data['parent_id'] = $this->input->post('parent_id');
			$data['variabel_name'] = $this->input->post('variabel_name');
			$data['variabel_definisi'] = $this->input->post('variabel_definisi');
			$data['keterangan'] = $this->input->post('keterangan');
			$data['pilihan_value'] = $this->input->post('pilihan_value');
			$data['i_row'] = $this->input->post('i_row');
			
			$this->m_crud->simpan('kasus', $data);
			$this->session->set_flashdata('flash_message', 'Data Kasus berhasil disimpan!');
			redirect('cont_master_pelayanan/kasus', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['variabel_id'] = $this->input->post('variabel_id');
			$data['parent_id'] = $this->input->post('parent_id');
			$data['variabel_name'] = $this->input->post('variabel_name');
			$data['variabel_definisi'] = $this->input->post('variabel_definisi');
			$data['keterangan'] = $this->input->post('keterangan');
			$data['pilihan_value'] = $this->input->post('pilihan_value');
			$data['i_row'] = $this->input->post('i_row');
			
			$this->m_crud->perbaharui('kd_jenis_kasus', $par3, 'kasus', $data);
			$this->session->set_flashdata('flash_message', 'Data kasus berhasil diperbaharui!');
			redirect('cont_master_pelayanan/kasus', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_kasus'] = $this->m_crud->get_kasus_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_jenis_kasus', $par2);
			$this->db->delete('kasus');
			$this->session->set_flashdata('flash_message', 'Data Kasus berhasil dihapus!');
			redirect('cont_master_pelayanan/kasus', 'refresh');
		}
		
		$data['page_name']  = 'kasus';
		$data['page_title'] = 'Kasus' ;
		$data['kasus']	= $this->m_crud->get_all_kasus();
		$data['list_jenis_kasus'] = $this->m_crud->get_list_jenis_kasus();	
		$this->template->display('kasus', $data);
	}
	
	/***MASTER DOKTER***/
	function dokter($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_dokter'] = $this->input->post('kd_dokter');
			$data['nm_dokter'] = $this->input->post('nm_dokter');
			$data['nip_dokter'] = $this->input->post('nip_dokter');
			$data['jabatan_dokter'] = $this->input->post('jabatan_dokter');
			$data['status_dokter'] = $this->input->post('status_dokter');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			$data['kd_spesialisasi'] = $this->input->post('kd_spesialisasi');
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['kd_unit_pelayanan'] = $this->input->post('kd_unit_pelayanan');
						
			$this->m_crud->simpan('dokter', $data);
			$this->session->set_flashdata('flash_message', 'Data dokter berhasil disimpan!');
			redirect('cont_master_pelayanan/dokter', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			//$data['kd_dokter'] = $this->input->post('kd_dokter');
			$data['nm_dokter'] = $this->input->post('nm_dokter');
			$data['nip_dokter'] = $this->input->post('nip_dokter');
			$data['jabatan_dokter'] = $this->input->post('jabatan_dokter');
			$data['status_dokter'] = $this->input->post('status_dokter');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			$data['kd_spesialisasi'] = $this->input->post('kd_spesialisasi');
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['kd_unit_pelayanan'] = $this->input->post('kd_unit_pelayanan');
			
			$this->m_crud->perbaharui('kd_dokter', $par3, 'dokter', $data);
			$this->session->set_flashdata('flash_message', 'Data dokter berhasil diperbaharui!');
			redirect('cont_master_pelayanan/dokter', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_dokter'] = $this->m_crud->get_dokter_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_dokter', $par2);
			$this->db->delete('dokter');
			$this->session->set_flashdata('flash_message', 'Data dokter berhasil dihapus!');
			redirect('cont_master_pelayanan/dokter', 'refresh');
		}
		
		$data['page_name']  = 'dokter';
		$data['page_title'] = 'Dokter' ;
		//$data['dokter']	= $this->m_crud->get_all_dokter();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		//$this->table->set_heading('Kode Dokter','Nama','NIP','Jabatan','Status','Puskesmas','Aksi');
		
		if($this->session->userdata('id_akses') != 1 ){
					$this->table->set_heading('Kode Dokter','Nama','Unit Pelayanan','Aksi');
				} else {
					$this->table->set_heading('Kode Dokter','Nama','Unit Pelayanan','Puskesmas');
				}
		
		$data['list_puskesmas'] = $this->m_crud->get_list_puskesmas();
		$data['list_unit_pelayanan']	= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_spesialisasi']		= $this->m_crud->get_list_spesialisasi('1');
		$data['list_pendidikan_kesehatan']	= $this->m_crud->get_list_pendidikan_kesehatan('1');
		
		$this->template->display('dokter', $data);
	}
	
	/***MASTER KAMAR***/
	function kamar($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_kamar'] = $this->input->post('kd_kamar');
			$data['no_kamar'] = $this->input->post('no_kamar');
			$data['kd_ruangan'] = $this->input->post('kd_ruangan');
			
			$this->m_crud->simpan('kamar', $data);
			$this->session->set_flashdata('flash_message', 'Data kamar berhasil disimpan!');
			redirect('cont_master_pelayanan/kamar', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_kamar'] = $this->input->post('kd_kamar');
			$data['no_kamar'] = $this->input->post('no_kamar');
			$data['kd_ruangan'] = $this->input->post('kd_ruangan');
			
			$this->m_crud->perbaharui('kd_kamar', $par3, 'kamar', $data);
			$this->session->set_flashdata('flash_message', 'Data kamar berhasil diperbaharui!');
			redirect('cont_master_pelayanan/kamar', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_kamar'] = $this->m_crud->get_kamar_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_kamar', $par2);
			$this->db->delete('kamar');
			$this->session->set_flashdata('flash_message', 'Data kamar berhasil dihapus!');
			redirect('cont_master_pelayanan/kamar', 'refresh');
		}
		
		$data['page_name']  = 'kamar';
		$data['page_title'] = 'Kamar' ;
		$data['list_ruang'] = $this->m_crud->get_list_ruang();
		//$data['kamar']	= $this->m_crud->get_all_kamar();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Kamar','No Kamar','Nama Ruangan','Aksi');
		
		$this->template->display('kamar', $data);
	}
	
	/***MASTER STATUS KELUAR PASIEN***/
	function status_keluar_pasien($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_status_pasien'] = $this->input->post('kd_status_pasien');
			$data['keterangan'] = $this->input->post('keterangan');
						
			$this->m_crud->simpan('status_keluar_pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data Status Keluar Pasien berhasil disimpan!');
			redirect('cont_master_pelayanan/status_keluar_pasien', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_status_pasien'] = $this->input->post('kd_status_pasien');
			$data['keterangan'] = $this->input->post('keterangan');
			
			$this->m_crud->perbaharui('kd_status_pasien', $par3, 'status_keluar_pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data Status Keluar Pasien berhasil diperbaharui!');
			redirect('cont_master_pelayanan/status_keluar_pasien', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_status_keluar_pasien'] = $this->m_crud->get_status_keluar_pasien_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_status_pasien', $par2);
			$this->db->delete('status_keluar_pasien');
			$this->session->set_flashdata('flash_message', 'Data Status Keluar Pasien berhasil dihapus!');
			redirect('cont_master_pelayanan/status_keluar_pasien', 'refresh');
		}
		
		$data['page_name']  = 'status_keluar_pasien';
		$data['page_title'] = 'Status Keluar Pasien' ;
		//$data['status_keluar_pasien']	= $this->m_crud->get_all_status_keluar_pasien();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Status','Keterangan','Aksi');
			
		$this->template->display('status_keluar_pasien', $data);
	}
	
	/***MASTER RUANGAN***/
	function ruangan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_ruangan'] = $this->input->post('kd_ruangan');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			$data['nm_ruangan'] = $this->input->post('nm_ruangan');
			$data['jml_kmr'] = $this->input->post('jml_kmr');
			$this->m_crud->simpan('ruangan', $data);
			$this->session->set_flashdata('flash_message', 'Data ruangan berhasil disimpan!');
			redirect('cont_master_pelayanan/ruangan', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_ruangan'] = $this->input->post('kd_ruangan');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			$data['nm_ruangan'] = $this->input->post('nm_ruangan');
			$data['jml_kmr'] = $this->input->post('jml_kmr');
			$this->m_crud->perbaharui('kd_ruangan', $par3, 'ruangan', $data);
			$this->session->set_flashdata('flash_message', 'Data ruangan berhasil diperbaharui!');
			redirect('cont_master_pelayanan/ruangan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_ruangan'] = $this->m_crud->get_ruangan_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_ruangan', $par2);
			$this->db->delete('ruangan');
			$this->session->set_flashdata('flash_message', 'Data ruangan berhasil dihapus!');
			redirect('cont_master_pelayanan/ruangan', 'refresh');
		}
		
		$data['page_name']  = 'ruangan';
		$data['page_title'] = 'Ruangan' ;
		//$data['ruangan']	= $this->m_crud->get_all_ruangan();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
		$this->table->set_heading('Kode Ruangan','Nama Ruangan', 'Jumlah Kamar','Aksi');
		$data['list_puskesmas'] = $this->m_crud->get_list_puskesmas();
			
		$this->template->display('ruangan', $data);
	}
	/***MASTER PETUGAS***/
	function petugas($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_petugas'] = $this->input->post('kd_petugas');
			$data['nama_petugas'] = $this->input->post('nama_petugas');
			$data['kd_unit_pelayanan'] = $this->input->post('kd_unit_pelayanan');
			$data['kd_gol'] = $this->input->post('kd_gol');
			$data['kd_posisi'] = $this->input->post('kd_posisi');
			$data['kd_spesialisasi'] = $this->input->post('kd_spesialisasi');
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			
			$this->m_crud->simpan('petugas', $data);
			$this->session->set_flashdata('flash_message', 'Data petugas berhasil disimpan!');
			redirect('cont_master_pelayanan/petugas', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_petugas'] = $this->input->post('kd_petugas');
			$data['nama_petugas'] = $this->input->post('nama_petugas');
			$data['kd_unit_pelayanan'] = $this->input->post('kd_unit_pelayanan');
			$data['kd_gol'] = $this->input->post('kd_gol');
			$data['kd_posisi'] = $this->input->post('kd_posisi');
			$data['kd_spesialisasi'] = $this->input->post('kd_spesialisasi');
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			
			$this->m_crud->perbaharui('kd_petugas', $par3, 'petugas', $data);
			$this->session->set_flashdata('flash_message', 'Data petugas berhasil diperbaharui!');
			redirect('cont_master_pelayanan/petugas', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_petugas'] = $this->m_crud->get_petugas_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_petugas', $par2);			
			$this->db->delete('petugas');
			$this->session->set_flashdata('flash_message', 'Data petugas berhasil dihapus!');
			redirect('cont_master_pelayanan/petugas', 'refresh');
		}
		
		$data['page_name']  			= 'petugas';
		$data['page_title']				= 'Petugas';
		//$data['petugas']				= $this->m_crud->get_all_petugas('1');
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		//$this->table->set_heading('Kode Petugas','Nama Petugas','Unit Pelayanan','Golongan Petugas','Posisi','Pendidikan Kesehatan','Aksi');
		if($this->session->userdata('id_akses') != 1 ){
			$this->table->set_heading('Kode Petugas','Nama Petugas','Unit Pelayanan','Posisi','Aksi');
		} else {
			$this->table->set_heading('Puskesmas','Kode Petugas','Nama Petugas','Unit Pelayanan','Posisi');
			}
		$data['list_golongan_petugas']	= $this->m_crud->get_list_golongan_petugas('1');
		$data['list_unit_pelayanan']	= $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_spesialisasi']		= $this->m_crud->get_list_spesialisasi('1');
		$data['list_pendidikan_kesehatan']	= $this->m_crud->get_list_pendidikan_kesehatan('1');
		$data['list_posisi']	= $this->m_crud->get_list_posisi('1');
			
		$this->template->display('petugas', $data);
		
	}
	
}
?>