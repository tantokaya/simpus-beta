<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_master_wil_puskesmas extends CI_Controller
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

/***MASTER PROPINSI***/
	function propinsi($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_propinsi'] = $this->input->post('kd_propinsi');
			$data['nm_propinsi'] = $this->input->post('nm_propinsi');
			
			$this->m_crud->simpan('propinsi', $data);
			$this->session->set_flashdata('flash_message', 'Data propinsi berhasil disimpan!');
			redirect('cont_master_wil_puskesmas/propinsi', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_propinsi'] = $this->input->post('kd_propinsi');
			$data['nm_propinsi'] = $this->input->post('nm_propinsi');
			
			$this->m_crud->perbaharui('kd_propinsi', $par3, 'propinsi', $data);
			$this->session->set_flashdata('flash_message', 'Data propinsi berhasil diperbaharui!');
			redirect('cont_master_wil_puskesmas/propinsi', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_propinsi'] = $this->m_crud->get_propinsi_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_propinsi', $par2);
			$this->db->delete('propinsi');
			$this->session->set_flashdata('flash_message', 'Data propinsi berhasil dihapus!');
			redirect('cont_master_wil_puskesmas/propinsi', 'refresh');
		}
		
		$data['page_name']  = 'propinsi';
		$data['page_title'] = 'Propinsi';
		//$data['propinsi']	= $this->m_crud->get_all_propinsi();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
       		 $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Propinsi','Nama Propinsi','Aksi');	
		$this->template->display('propinsi', $data);
		
	}
	
	/***MASTER KOTA***/
	function kota($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_kota'] = $this->input->post('kd_kota');
			$data['nm_kota'] = $this->input->post('nm_kota');
			$kd_propinsi 	 = $this->input->post('kd_propinsi');
			
			$this->m_crud->simpan('kota', $data);
			$this->session->set_flashdata('flash_message', 'Data kota berhasil disimpan!');
			redirect('cont_master_wil_puskesmas/kota/'.$kd_propinsi, 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_kota'] = $this->input->post('kd_kota');
			$data['nm_kota'] = $this->input->post('nm_kota');
			//$data['kd_propinsi'] = $this->input->post('kd_propinsi');
			
			$this->m_crud->perbaharui('kd_kota', $par3, 'kota', $data);
			$this->session->set_flashdata('flash_message', 'Data kota berhasil diperbaharui!');
			redirect('cont_master_wil_puskesmas/kota/'.substr($par3,0,2), 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_kota'] = $this->m_crud->get_kota_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_kota', $par2);
			$this->db->delete('kota');
			$this->session->set_flashdata('flash_message', 'Data kota/kabupaten berhasil dihapus!');
			redirect('cont_master_wil_puskesmas/kota/'.substr($par2,0,2), 'refresh');
		}
		
		$data['page_name']  = 'kota';
		$data['page_title'] = 'Kota / Kabupaten';
				
		if($par1 == 'ubah')
			$data['kota']		= $this->m_crud->get_kota_by_propinsi_id(substr($par2,0,2));
		else
			$data['kota']		= $this->m_crud->get_kota_by_propinsi_id($par1);
		//$data['propinsi'] = $this->m_crud->get_all_propinsi();
			
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
       		 $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Kota','Nama Kota','Aksi');	
		
		$this->template->display('kota', $data);
		
	}
	
	/***MASTER kecamatan***/
	function kecamatan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_kecamatan'] = $this->input->post('kd_kecamatan');
			$data['nm_kecamatan'] = $this->input->post('nm_kecamatan');
			$kd_kota 	 	  = $this->input->post('kd_kota');
			
			$this->m_crud->simpan('kecamatan', $data);
			$this->session->set_flashdata('flash_message', 'Data kecamatan berhasil disimpan!');
			redirect('cont_master_wil_puskesmas/kecamatan/'.$kd_kota, 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_kecamatan'] = $this->input->post('kd_kecamatan');
			$data['nm_kecamatan'] = $this->input->post('nm_kecamatan');
			
			$this->m_crud->perbaharui('kd_kecamatan', $par3, 'kecamatan', $data);
			$this->session->set_flashdata('flash_message', 'Data kecamatan berhasil diperbaharui!');
			redirect('cont_master_wil_puskesmas/kecamatan/'.substr($par3,0,4), 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_kecamatan'] = $this->m_crud->get_kecamatan_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_kecamatan', $par2);
			$this->db->delete('kecamatan');
			$this->session->set_flashdata('flash_message', 'Data kecamatan berhasil dihapus!');
			redirect('cont_master_wil_puskesmas/kecamatan/'.substr($par2,0,4), 'refresh');
		}
		
		$data['page_name']  = 'kecamatan';
		$data['page_title'] = 'Kecamatan';
		
		if($par1 == 'ubah')
			$data['kecamatan']		= $this->m_crud->get_kecamatan_by_kota_id(substr($par2,0,4));
		else
			$data['kecamatan']		= $this->m_crud->get_kecamatan_by_kota_id($par1);
			
		$this->template->display('kecamatan', $data);
		
	}
	
	/***MASTER kelurahan***/
	function kelurahan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_kelurahan'] = $this->input->post('kd_kelurahan');
			$data['nm_kelurahan'] = $this->input->post('nm_kelurahan');
			$kd_kecamatan		  = $this->input->post('kd_kecamatan');
			
			$this->m_crud->simpan('kelurahan', $data);
			$this->session->set_flashdata('flash_message', 'Data kelurahan berhasil disimpan!');
			redirect('cont_master_wil_puskesmas/kelurahan/'.$kd_kecamatan, 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_kelurahan'] = $this->input->post('kd_kelurahan');
			$data['nm_kelurahan'] = $this->input->post('nm_kelurahan');
			
			$this->m_crud->perbaharui('kd_kelurahan', $par3, 'kelurahan', $data);
			$this->session->set_flashdata('flash_message', 'Data kelurahan berhasil diperbaharui!');
			redirect('cont_master_wil_puskesmas/kelurahan/'.substr($par3,0,7), 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_kelurahan'] = $this->m_crud->get_kelurahan_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_kelurahan', $par2);
			$this->db->delete('kelurahan');
			$this->session->set_flashdata('flash_message', 'Data kelurahan berhasil dihapus!');
			redirect('cont_master_wil_puskesmas/kelurahan/'.substr($par2,0,7), 'refresh');
		}
		
		$data['page_name']  = 'kelurahan';
		$data['page_title'] = 'Kelurahan';
		
		if($par1 == 'ubah')
			$data['kelurahan']		= $this->m_crud->get_kelurahan_by_kec_id(substr($par2,0,7));
		else
			$data['kelurahan']		= $this->m_crud->get_kelurahan_by_kec_id($par1);
			
		$this->template->display('kelurahan', $data);
		
	}
	
	/***MASTER PUSKESMAS***/
	function puskesmas($par1 = '', $par2 = '', $par3 = '')
	{	
		
		
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_puskesmas'] = $this->input->post('kd_puskesmas');
			$data['nm_puskesmas'] = $this->input->post('nm_puskesmas');
			$data['alamat'] = $this->input->post('alamat');
			$data['kd_kecamatan'] = $this->input->post('kd_kecamatan');
			$data['id_jenis_puskesmas'] = $this->input->post('id_jenis_puskesmas');
			
			$this->m_crud->simpan('puskesmas', $data);
			$this->session->set_flashdata('flash_message', 'Data puskesmas berhasil disimpan!');
			redirect('cont_master_wil_puskesmas/puskesmas', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_puskesmas'] = $this->input->post('kd_puskesmas');
			$data['nm_puskesmas'] = $this->input->post('nm_puskesmas');
			$data['alamat'] = $this->input->post('alamat');
			$data['id_jenis_puskesmas'] = $this->input->post('id_jenis_puskesmas');
			
			$this->m_crud->perbaharui('kd_puskesmas', $par3, 'puskesmas', $data);
			$this->session->set_flashdata('flash_message', 'Data puskesmas berhasil diperbaharui!');
			redirect('cont_master_wil_puskesmas/puskesmas', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_puskesmas'] = $this->m_crud->get_puskesmas_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_puskesmas', $par2);
			$this->db->delete('puskesmas');
			$this->session->set_flashdata('flash_message', 'Data puskesmas berhasil dihapus!');
			redirect('cont_master_wil_puskesmas/puskesmas', 'refresh');
		}
		
		$data['page_name']  = 'puskesmas';
		$data['page_title'] = 'Puskesmas';
		//$data['puskesmas']	= $this->m_crud->get_all_puskesmas();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('Kode Puskesmas','Nama Puskesmas','Alamat','Kecamatan','Puskesmas Induk','Aksi');
		
		$data['list_kecamatan'] = $this->m_crud->get_list_kecamatan('3573'); // KOTA BOGOR
		$data['list_jenis_puskesmas']	= $this->m_crud->get_all_jenis_puskesmas();
			
		$this->template->display('puskesmas', $data);
		
	}

	
}
?>
	