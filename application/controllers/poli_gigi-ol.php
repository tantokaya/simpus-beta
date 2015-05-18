<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Poli_gigi extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$simkes=$this->load->database('default', TRUE);
		
		// cek session
		if ($this->session->userdata('logged_in') == false && $this->session->userdata('id_akses') !== 10) {
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
			redirect('poli_gigi/dashboard');
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
			
			$pusk=$this->session->userdata('kd_puskesmas');
			$text = "SELECT * FROM puskesmas WHERE kd_puskesmas='$pusk'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$data['nm_puskesmas'] = $t->nm_puskesmas;
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
?>