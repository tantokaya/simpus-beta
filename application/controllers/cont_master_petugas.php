<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_master_petugas extends CI_Controller
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
	
	
	/***MASTER GOLONGAN PETUGAS***/
	function golongan_petugas($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_gol'] = $this->input->post('kd_gol');
			$data['nama_gol'] = $this->input->post('nama_gol');
			
			$this->m_crud->simpan('golongan_petugas', $data);
			$this->session->set_flashdata('flash_message', 'Data golongan petugas berhasil disimpan!');
			redirect('cont_master_petugas/golongan_petugas', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_gol'] = $this->input->post('kd_gol');
			$data['nama_gol'] = $this->input->post('nama_gol');
			
			$this->m_crud->perbaharui('kd_gol', $par3, 'golongan_petugas', $data);
			$this->session->set_flashdata('flash_message', 'Data golongan petugas berhasil diperbaharui!');
			redirect('cont_master_petugas/golongan_petugas', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_golongan_petugas'] = $this->m_crud->get_golongan_petugas_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_gol', $par2);
			$this->db->delete('golongan_petugas');
			$this->session->set_flashdata('flash_message', 'Data golongan petugas berhasil dihapus!');
			redirect('cont_master_petugas/golongan_petugas', 'refresh');
		}
		
		$data['page_name']  = 'golongan_petugas';
		$data['page_title'] = 'Golongan Petugas';
		//$data['golongan_petugas']	= $this->m_crud->get_all_golongan_petugas();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Golongan Petugas','Golongan Petugas','Aksi');
		
		$this->template->display('golongan_petugas', $data);
		
	}
	
	
	/***MASTER POSISI***/
	function posisi($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_posisi'] = $this->input->post('kd_posisi');
			$data['posisi'] = $this->input->post('posisi');
			
			$this->m_crud->simpan('posisi', $data);
			$this->session->set_flashdata('flash_message', 'Data posisi berhasil disimpan!');
			redirect('cont_master_petugas/posisi', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_posisi'] = $this->input->post('kd_posisi');
			$data['posisi'] = $this->input->post('posisi');
			
			$this->m_crud->perbaharui('kd_posisi', $par3, 'posisi', $data);
			$this->session->set_flashdata('flash_message', 'Data posisi berhasil diperbaharui!');
			redirect('cont_master_petugas/posisi', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_posisi'] = $this->m_crud->get_posisi_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_posisi', $par2);
			$this->db->delete('posisi');
			$this->session->set_flashdata('flash_message', 'Data posisi berhasil dihapus!');
			redirect('cont_master_petugas/posisi', 'refresh');
		}
		
		$data['page_name']  = 'posisi';
		$data['page_title'] = 'Posisi';
		//$data['posisi']	= $this->m_crud->get_all_posisi();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Posisi','Posisi','Aksi');
		
		$this->template->display('posisi', $data);
		
	}
	
	/***MASTER SPESIALISASI***/
	function spesialisasi($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_spesialisasi'] = $this->input->post('kd_spesialisasi');
			$data['spesialisasi'] = $this->input->post('spesialisasi');
			
			$this->m_crud->simpan('spesialisasi', $data);
			$this->session->set_flashdata('flash_message', 'Data spesialisasi berhasil disimpan!');
			redirect('cont_master_petugas/spesialisasi', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_spesialisasi'] = $this->input->post('kd_spesialisasi');
			$data['spesialisasi'] = $this->input->post('spesialisasi');
			
			$this->m_crud->perbaharui('kd_spesialisasi', $par3, 'spesialisasi', $data);
			$this->session->set_flashdata('flash_message', 'Data spesialisasi berhasil diperbaharui!');
			redirect('cont_master_petugas/spesialisasi', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_spesialisasi'] = $this->m_crud->get_spesialisasi_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_spesialisasi', $par2);
			$this->db->delete('spesialisasi');
			$this->session->set_flashdata('flash_message', 'Data spesialisasi berhasil dihapus!');
			redirect('cont_master_petugas/spesialisasi', 'refresh');
		}
		
		$data['page_name']  = 'spesialisasi';
		$data['page_title'] = 'Spesialisasi';
		$data['spesialisasi']	= $this->m_crud->get_all_spesialisasi();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Spesialisasi','Spesialisasi','Aksi');
		
		$this->template->display('spesialisasi', $data);
		
	}
	
	/***MASTER PENDIDIKAN KESEHATAN***/
	function pendidikan_kesehatan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['pendidikan'] = $this->input->post('pendidikan');
			
			$this->m_crud->simpan('pendidikan_kesehatan', $data);
			$this->session->set_flashdata('flash_message', 'Data pendidikan kesehatan berhasil disimpan!');
			redirect('cont_master_petugas/pendidikan_kesehatan', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['pendidikan'] = $this->input->post('pendidikan');
			
			$this->m_crud->perbaharui('kd_pendidikan', $par3, 'pendidikan_kesehatan', $data);
			$this->session->set_flashdata('flash_message', 'Data pendidikan kesehatan berhasil diperbaharui!');
			redirect('cont_master_petugas/pendidikan_kesehatan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pendidikan_kesehatan'] = $this->m_crud->get_pendidikan_kesehatan_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_pendidikan', $par2);
			$this->db->delete('pendidikan_kesehatan');
			$this->session->set_flashdata('flash_message', 'Data pendidikan kesehatan berhasil dihapus!');
			redirect('cont_master_petugas/pendidikan_kesehatan', 'refresh');
		}
		
		$data['page_name']  = 'pendidikan_kesehatan';
		$data['page_title'] = 'Pendidikan Kesehatan';
		//$data['pendidikan_kesehatan']	= $this->m_crud->get_all_pendidikan_kesehatan();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Pendidikan','Pendidikan','Aksi');
			
		$this->template->display('pendidikan_kesehatan', $data);
		
	}
	
	
}
?>