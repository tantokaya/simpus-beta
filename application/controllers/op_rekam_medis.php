<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Op_rekam_medis extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// cek session
		if ($this->session->userdata('logged_in') == false && $this->session->userdata('id_akses') !== 4) {
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
			redirect('op_rekam_medis/dashboard');
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
			//print_r ($data['info_login'][0]['kd_kecamatan']); exit;
			$data['info_kecamatan'] = $this->m_crud->get_kecamatan_by_id($data['info_login'][0]['kd_kecamatan']);
			
			$this->template->display('dashboard', $data);
		} else {
			redirect('login');
		}	
	}
	
	
	

}
?>