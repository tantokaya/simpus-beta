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
                        set_puskesmas.logo,
                        propinsi.nm_propinsi,
                        kecamatan.nm_kecamatan,
                        kelurahan.nm_kelurahan,
                        kota.nm_kota
                        FROM
                        set_puskesmas
                        LEFT JOIN propinsi ON set_puskesmas.kd_propinsi = propinsi.kd_propinsi
                        LEFT JOIN kecamatan ON set_puskesmas.kd_kecamatan = kecamatan.kd_kecamatan
                        LEFT JOIN kelurahan ON set_puskesmas.kd_kelurahan = kelurahan.kd_kelurahan
                        LEFT JOIN kota ON set_puskesmas.kd_kota = kota.kd_kota ";
            $hasil = $this->m_crud->manualQuery($text);
            foreach($hasil->result() as $t){
                $data['nm_puskesmas']   = $t->nm_puskesmas;
                $data['nip_kpl']        = $t->nip_kpl;
                $data['kpl_puskesmas']  = $t->kpl_puskesmas;
                $data['nm_kota']        = $t->nm_kota;
                $data['nm_kecamatan']   = $t->nm_kecamatan;
                $data['nm_kelurahan']   = $t->nm_kelurahan;
                $data['nm_propinsi']    = $t->nm_propinsi;
                $data['alamat']         = $t->alamat;
                $data['logo']           = $t->logo;
            }
			
            $data['total_pasien_date'] 	= $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
            $data['total_pasien_month']	= $this->m_dashboard->get_total_pasien_monthly(date('m'));
            $data['total_pasien_year']	= $this->m_dashboard->get_total_pasien_yearly(date('Y'));

            $data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today();
            $data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
            $data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
            $data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));
			
			$data['total_kunjungan_date_dlm_wil'] 	= $this->m_dashboard->get_total_kunjungan_today_dlm_wil();
			$data['total_kunjungan_date_luar_wil'] 	= $this->m_dashboard->get_total_kunjungan_today_luar_wil();
			$data['total_kunjungan_date_luar_kota'] = $this->m_dashboard->get_total_kunjungan_today_luar_kota();
			$data['total_kunjungan_week_dlm_wil']	= $this->m_dashboard->get_total_kunjungan_weekly_dlm_wil();
			$data['total_kunjungan_week_luar_wil']	= $this->m_dashboard->get_total_kunjungan_weekly_luar_wil();
			$data['total_kunjungan_week_luar_kota']	= $this->m_dashboard->get_total_kunjungan_weekly_luar_kota();
			
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