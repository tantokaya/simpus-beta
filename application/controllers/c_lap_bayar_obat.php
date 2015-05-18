<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_lap_bayar_obat extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//$this->load->library('access');
		$this->load->library('template');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	/***Default function, redirects to login page if no admin logged in yet***/
	public function index()
	{
	
		//if ($this->session->userdata('logged_in') == false)
			//redirect('login');
		//else
		//	redirect('admin/dashboard');
		if ($this->session->userdata('logged_in') == true)
			redirect('admin/dashboard');
		else
			redirect('login');
			
	}
	
	function lap_per_tgl()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Transaksi Obat per tanggal';
			
			$this->template->display('../cetak/lap_bayar_obat_tgl', $data);
		} else {
			redirect('login');
		}
		
	} 
	
	public function lihat()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));
			
			$where = " WHERE a.tgl_bayar BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
			$text = "select a.kd_bayar,a.tgl_bayar,a.nama_pasien,
			b.kd_obat,b.nama_obat,b.sat_kecil_obat,b.jml,b.harga_jual
			FROM bobat_header as a
			JOIN bobat_detail as b
			ON a.kd_bayar=b.kd_bayar
			$where ORDER BY a.kd_bayar,b.kd_bayar";
			$d['data'] = $this->db->query($text);
			
			
			$this->template->tampil_lap_bayar_obat('daftar_lap_bayar_obat',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));
			
			$where = " WHERE a.tgl_bayar BETWEEN '$tgl1' AND '$tgl2'";
			$text = "select a.kd_bayar,a.tgl_bayar,a.nama_pasien,
			b.kd_obat,b.nama_obat,b.sat_kecil_obat,b.jml,b.harga_jual
			FROM bobat_header as a
			JOIN bobat_detail as b
			ON a.kd_bayar=b.kd_bayar
			$where ORDER BY a.kd_bayar,b.kd_obat";
			$d['data'] = $this->db->query($text);
			$d['tgl1'] = $this->uri->segment(3);
			$d['tgl2'] = $this->uri->segment(4);

			$this->template->tampil_cetak_lap_bayar_obat('cetak_lap_bayar_obat',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	

	
	
	
}
