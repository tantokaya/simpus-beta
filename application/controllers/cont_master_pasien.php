<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_master_pasien extends CI_Controller
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
	/***MASTER AGAMA***/
	function agama($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_agama'] = $this->input->post('kd_agama');
			$data['nm_agama'] = $this->input->post('nm_agama');
			
			$this->m_crud->simpan('agama', $data);
			$this->session->set_flashdata('flash_message', 'Data agama berhasil disimpan!');
			redirect('cont_master_pasien/agama', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_agama'] = $this->input->post('kd_agama');
			$data['nm_agama'] = $this->input->post('nm_agama');
			
			$this->m_crud->perbaharui('kd_agama', $par3, 'agama', $data);
			$this->session->set_flashdata('flash_message', 'Data agama berhasil diperbaharui!');
			redirect('cont_master_pasien/agama', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_agama'] = $this->m_crud->get_agama_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_agama', $par2);
			$this->db->delete('agama');
			$this->session->set_flashdata('flash_message', 'Data agama berhasil dihapus!');
			redirect('cont_master_pasien/agama', 'refresh');
		}
		
		$data['page_name']  = 'agama';
		$data['page_title'] = 'Agama';
		//$data['agama']	= $this->m_crud->get_all_agama();
		
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('No','Nama Agama','Aksi');
			
		$this->template->display('agama', $data);
		
	}
	
	/***MASTER CARA BAYAR***/
	function cara_bayar($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_bayar'] = $this->input->post('kd_bayar');
			$data['cara_bayar'] = $this->input->post('cara_bayar');
			$data['kd_customer'] = $this->input->post('kd_customer');
			
			$this->m_crud->simpan('cara_bayar', $data);
			$this->session->set_flashdata('flash_message', 'Data cara bayar berhasil disimpan!');
			redirect('cont_master_pasien/cara_bayar', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_bayar'] = $this->input->post('kd_bayar');
			$data['cara_bayar'] = $this->input->post('cara_bayar');
			$data['kd_customer'] = $this->input->post('kd_customer');
			
			$this->m_crud->perbaharui('kd_bayar', $par3, 'cara_bayar', $data);
			$this->session->set_flashdata('flash_message', 'Data cara bayar berhasil diperbaharui!');
			redirect('cont_master_pasien/cara_bayar', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_cara_bayar'] = $this->m_crud->get_cara_bayar_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_bayar', $par2);
			$this->db->delete('cara_bayar');
			$this->session->set_flashdata('flash_message', 'Data cara bayar berhasil dihapus!');
			redirect('cont_master_pasien/cara_bayar', 'refresh');
		}
		
		$data['page_name']  = 'cara_bayar';
		$data['page_title'] = 'Cara Bayar';
		//$data['cara_bayar']	= $this->m_crud->get_all_cara_bayar();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Bayar','Cara Bayar','Kode Customer','Aksi');
			
		$this->template->display('cara_bayar', $data);
		
	}
	
	
	
	/***MASTER JENIS KELAMIN***/
	function jenis_kelamin($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_jenis_kelamin'] = $this->input->post('kd_jenis_kelamin');
			$data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
			
			$this->m_crud->simpan('jenis_kelamin', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis kelamin berhasil disimpan!');
			redirect('cont_master_pasien/jenis_kelamin', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_jenis_kelamin'] = $this->input->post('kd_jenis_kelamin');
			$data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
			
			$this->m_crud->perbaharui('kd_jenis_kelamin', $par3, 'jenis_kelamin', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis kelamin berhasil diperbaharui!');
			redirect('cont_master_pasien/jenis_kelamin', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_jenis_kelamin'] = $this->m_crud->get_jenis_kelamin_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_jenis_kelamin', $par2);
			$this->db->delete('jenis_kelamin');
			$this->session->set_flashdata('flash_message', 'Data jenis kelamin berhasil dihapus!');
			redirect('cont_master_pasien/jenis_kelamin', 'refresh');
		}
		
		$data['page_name']  = 'jenis_kelamin';
		$data['page_title'] = 'Jenis Kelamin';
		//$data['jenis_kelamin']	= $this->m_crud->get_all_jenis_kelamin();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Jenis Kelamin','Jenis Kelamin','Aksi');
			
		$this->template->display('jenis_kelamin', $data);
		
	}
	
	
	/***MASTER STATUS MARITAL***/
	function status_marital($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_status_marital'] = $this->input->post('kd_status_marital');
			$data['status_marital'] = $this->input->post('status_marital');
			
			$this->m_crud->simpan('status_marital', $data);
			$this->session->set_flashdata('flash_message', 'Data status marital berhasil disimpan!');
			redirect('cont_master_pasien/status_marital', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_status_marital'] = $this->input->post('kd_status_marital');
			$data['status_marital'] = $this->input->post('status_marital');
			
			$this->m_crud->perbaharui('kd_status_marital', $par3, 'status_marital', $data);
			$this->session->set_flashdata('flash_message', 'Data status marital berhasil diperbaharui!');
			redirect('cont_master_pasien/status_marital', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_status_marital'] = $this->m_crud->get_status_marital_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_status_marital', $par2);
			$this->db->delete('status_marital');
			$this->session->set_flashdata('flash_message', 'Data status marital berhasil dihapus!');
			redirect('cont_master_pasien/status_marital', 'refresh');
		}
		
		$data['page_name']  = 'status_marital';
		$data['page_title'] = 'Status Marital';
		$data['status_marital']	= $this->m_crud->get_all_status_marital();
			
		$this->template->display('status_marital', $data);
		
	}
	
	/***MASTER GOLONGAN DARAH***/
	function golongan_darah($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_gol_darah'] = $this->input->post('kd_gol_darah');
			$data['gol_darah'] = $this->input->post('gol_darah');
			
			$this->m_crud->simpan('golongan_darah', $data);
			$this->session->set_flashdata('flash_message', 'Data golongan darah berhasil disimpan!');
			redirect('cont_master_pasien/golongan_darah', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_gol_darah'] = $this->input->post('kd_gol_darah');
			$data['gol_darah'] = $this->input->post('gol_darah');
			
			$this->m_crud->perbaharui('kd_gol_darah', $par3, 'golongan_darah', $data);
			$this->session->set_flashdata('flash_message', 'Data golongan darah berhasil diperbaharui!');
			redirect('cont_master_pasien/golongan_darah', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_gol_darah'] = $this->m_crud->get_gol_darah_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_gol_darah', $par2);
			$this->db->delete('golongan_darah');
			$this->session->set_flashdata('flash_message', 'Data golongan darah berhasil dihapus!');
			redirect('cont_master_pasien/golongan_darah', 'refresh');
		}
		
		$data['page_name']  = 'golongan_darah';
		$data['page_title'] = 'Golongan Darah';
		//$data['golongan_darah']	= $this->m_crud->get_all_gol_darah();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Golongan Darah','Golongan Darah','Aksi');
			
		$this->template->display('golongan_darah', $data);
		
	}
	
	/***MASTER PENDIDIKAN***/
	function pendidikan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['pendidikan'] = $this->input->post('pendidikan');
			
			$this->m_crud->simpan('pendidikan', $data);
			$this->session->set_flashdata('flash_message', 'Data pendidikan berhasil disimpan!');
			redirect('cont_master_pasien/pendidikan', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['pendidikan'] = $this->input->post('pendidikan');
			
			$this->m_crud->perbaharui('kd_pendidikan', $par3, 'pendidikan', $data);
			$this->session->set_flashdata('flash_message', 'Data pendidikan berhasil diperbaharui!');
			redirect('cont_master_pasien/pendidikan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pendidikan'] = $this->m_crud->get_pendidikan_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_pendidikan', $par2);
			$this->db->delete('pendidikan');
			$this->session->set_flashdata('flash_message', 'Data pendidikan berhasil dihapus!');
			redirect('cont_master_pasien/pendidikan', 'refresh');
		}
		
		$data['page_name']  = 'pendidikan';
		$data['page_title'] = 'Pendidikan';
		//$data['pendidikan']	= $this->m_crud->get_all_pendidikan();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Pendidikan','Pendidikan','Aksi');
		
		$this->template->display('pendidikan', $data);
		
	}
	
	/***MASTER PEKERJAAN***/
	function pekerjaan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_pekerjaan'] = $this->input->post('kd_pekerjaan');
			$data['pekerjaan'] = $this->input->post('pekerjaan');
			
			$this->m_crud->simpan('pekerjaan', $data);
			$this->session->set_flashdata('flash_message', 'Data pekerjaan berhasil disimpan!');
			redirect('cont_master_pasien/pekerjaan', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_pekerjaan'] = $this->input->post('kd_pekerjaan');
			$data['pekerjaan'] = $this->input->post('pekerjaan');
			
			$this->m_crud->perbaharui('kd_pekerjaan', $par3, 'pekerjaan', $data);
			$this->session->set_flashdata('flash_message', 'Data pekerjaan berhasil diperbaharui!');
			redirect('cont_master_pasien/pekerjaan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pekerjaan'] = $this->m_crud->get_pekerjaan_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_pekerjaan', $par2);
			$this->db->delete('pekerjaan');
			$this->session->set_flashdata('flash_message', 'Data pekerjaan berhasil dihapus!');
			redirect('cont_master_pasien/pekerjaan', 'refresh');
		}
		
		$data['page_name']  = 'pekerjaan';
		$data['page_title'] = 'Pekerjaan';
		//$data['pekerjaan']	= $this->m_crud->get_all_pekerjaan();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Pekerjaan','Pekerjaan','Aksi');
			
		$this->template->display('pekerjaan', $data);
		
	}
	
	
	
}
?>