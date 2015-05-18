<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dash_walikota extends CI_Controller {

    /**
     Powered by : Hartanto Kurniawan, S.KOM
     */

    function __construct()
    {
        parent::__construct();

        $this->load->library('template');

        $this->load->library('Datatables');
        $this->load->library('table');

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    }
    public function index()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'WALIKOTA BOGOR';

        $data['total_pasien_date'] 	    = $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
        $data['total_pasien_month']	    = $this->m_dashboard->get_total_pasien_monthly(date('m'));
        $data['total_pasien_year']	    = $this->m_dashboard->get_total_pasien_yearly(date('Y'));

        $data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today();
        $data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
        $data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
        $data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));

        $data['top_desease']			= $this->m_dashboard->get_top5_desease();
        $data['top_medicine']           = $this->m_dashboard->get_top10_medicine();

        for ($i=1; $i <= 12; $i++){
            $data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i);
            $data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i);
            $data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i);
        }

        //echo '<pre>'; print_r($data['kunjungan']); exit;


        $this->template->display_dash_walikota('dashboard_walikota', $data);

//        $this->template->display_dashboard('dashboard_dinkes', $data);
    }

    public function kecamatan_botim()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Dashboard Kecamatan Bogor Timur';


       	$data['total_pasien_date'] 	    = $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
        $data['total_pasien_month']	    = $this->m_dashboard->get_total_pasien_monthly(date('m'));
        $data['total_pasien_year']	    = $this->m_dashboard->get_total_pasien_yearly(date('Y'));

        $data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today();
        $data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
        $data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
        $data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));

        $data['top_desease']			= $this->m_dashboard->get_top5_desease();

        for ($i=1; $i <= 12; $i++){
            $data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i);
            $data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i);
            $data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i);
			$data['rawat_inap'][$i] = $this->m_dashboard->get_kunjungan_rawat_inap($i);
	    	$data['rawat_jalan'][$i] = $this->m_dashboard->get_kunjungan_rawat_jalan($i);
			$data['kasus_lama'][$i] = $this->m_dashboard->get_kunjungan_kasus_lama($i);
			$data['kasus_baru'][$i] = $this->m_dashboard->get_kunjungan_kasus_baru($i);
        }
		
		$poli = $this->m_dashboard->get_all_poli();
		
		$i=0;
		foreach($poli as $p){
			#echo $p['kd_unit_pelayanan'].'<br>';	
			$data['poli']['jumlah'][$i] = $this->m_dashboard->get_kunjungan_per_poli(date('m'),$p['kd_unit_pelayanan']);
			$data['poli']['nm_unit'][$i] = $p['singkatan'];
			$i++;
		}

        #echo '<pre>'; print_r($data); exit;

        $this->template->display_dash_walikota('dashboard_walikota/kecamatan_botim', $data);

//        $this->template->display_dashboard('dashboard_dinkes', $data);
    }
	
	public function kecamatan_bosel()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Dashboard Kecamatan Bogor Selatan';


       	$data['total_pasien_date'] 	    = $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
        $data['total_pasien_month']	    = $this->m_dashboard->get_total_pasien_monthly(date('m'));
        $data['total_pasien_year']	    = $this->m_dashboard->get_total_pasien_yearly(date('Y'));

        $data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today();
        $data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
        $data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
        $data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));

        $data['top_desease']			= $this->m_dashboard->get_top5_desease();

        for ($i=1; $i <= 12; $i++){
            $data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i);
            $data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i);
            $data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i);
			$data['rawat_inap'][$i] = $this->m_dashboard->get_kunjungan_rawat_inap($i);
	    	$data['rawat_jalan'][$i] = $this->m_dashboard->get_kunjungan_rawat_jalan($i);
			$data['kasus_lama'][$i] = $this->m_dashboard->get_kunjungan_kasus_lama($i);
			$data['kasus_baru'][$i] = $this->m_dashboard->get_kunjungan_kasus_baru($i);
        }
		
		$poli = $this->m_dashboard->get_all_poli();
		
		$i=0;
		foreach($poli as $p){
			#echo $p['kd_unit_pelayanan'].'<br>';	
			$data['poli']['jumlah'][$i] = $this->m_dashboard->get_kunjungan_per_poli(date('m'),$p['kd_unit_pelayanan']);
			$data['poli']['nm_unit'][$i] = $p['singkatan'];
			$i++;
		}

        #echo '<pre>'; print_r($data); exit;

        $this->template->display_dash_walikota('dashboard_walikota/kecamatan_bosel', $data);

//        $this->template->display_dashboard('dashboard_dinkes', $data);
    }
	
	public function kecamatan_bogut()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Dashboard Kecamatan Bogor Utara';


       	$data['total_pasien_date'] 	    = $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
        $data['total_pasien_month']	    = $this->m_dashboard->get_total_pasien_monthly(date('m'));
        $data['total_pasien_year']	    = $this->m_dashboard->get_total_pasien_yearly(date('Y'));

        $data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today();
        $data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
        $data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
        $data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));

        $data['top_desease']			= $this->m_dashboard->get_top5_desease();

        for ($i=1; $i <= 12; $i++){
            $data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i);
            $data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i);
            $data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i);
			$data['rawat_inap'][$i] = $this->m_dashboard->get_kunjungan_rawat_inap($i);
	    	$data['rawat_jalan'][$i] = $this->m_dashboard->get_kunjungan_rawat_jalan($i);
			$data['kasus_lama'][$i] = $this->m_dashboard->get_kunjungan_kasus_lama($i);
			$data['kasus_baru'][$i] = $this->m_dashboard->get_kunjungan_kasus_baru($i);
        }
		
		$poli = $this->m_dashboard->get_all_poli();
		
		$i=0;
		foreach($poli as $p){
			#echo $p['kd_unit_pelayanan'].'<br>';	
			$data['poli']['jumlah'][$i] = $this->m_dashboard->get_kunjungan_per_poli(date('m'),$p['kd_unit_pelayanan']);
			$data['poli']['nm_unit'][$i] = $p['singkatan'];
			$i++;
		}

        #echo '<pre>'; print_r($data); exit;

        $this->template->display_dash_walikota('dashboard_walikota/kecamatan_bogut', $data);

//        $this->template->display_dashboard('dashboard_dinkes', $data);
    }
	
	public function kecamatan_bobar()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Dashboard Kecamatan Bogor Barat';


       	$data['total_pasien_date'] 	    = $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
        $data['total_pasien_month']	    = $this->m_dashboard->get_total_pasien_monthly(date('m'));
        $data['total_pasien_year']	    = $this->m_dashboard->get_total_pasien_yearly(date('Y'));

        $data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today();
        $data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
        $data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
        $data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));

        $data['top_desease']			= $this->m_dashboard->get_top5_desease();

        for ($i=1; $i <= 12; $i++){
            $data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i);
            $data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i);
            $data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i);
			$data['rawat_inap'][$i] = $this->m_dashboard->get_kunjungan_rawat_inap($i);
	    	$data['rawat_jalan'][$i] = $this->m_dashboard->get_kunjungan_rawat_jalan($i);
			$data['kasus_lama'][$i] = $this->m_dashboard->get_kunjungan_kasus_lama($i);
			$data['kasus_baru'][$i] = $this->m_dashboard->get_kunjungan_kasus_baru($i);
        }
		
		$poli = $this->m_dashboard->get_all_poli();
		
		$i=0;
		foreach($poli as $p){
			#echo $p['kd_unit_pelayanan'].'<br>';	
			$data['poli']['jumlah'][$i] = $this->m_dashboard->get_kunjungan_per_poli(date('m'),$p['kd_unit_pelayanan']);
			$data['poli']['nm_unit'][$i] = $p['singkatan'];
			$i++;
		}

        #echo '<pre>'; print_r($data); exit;

        $this->template->display_dash_walikota('dashboard_walikota/kecamatan_bobar', $data);

//        $this->template->display_dashboard('dashboard_dinkes', $data);
    }
	
	public function kecamatan_tanahsareal()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Dashboard Kecamatan Tanah Sareal';


       	$data['total_pasien_date'] 	    = $this->m_dashboard->get_total_pasien_today(date('Y-m-d'));
        $data['total_pasien_month']	    = $this->m_dashboard->get_total_pasien_monthly(date('m'));
        $data['total_pasien_year']	    = $this->m_dashboard->get_total_pasien_yearly(date('Y'));

        $data['total_kunjungan_date'] 	= $this->m_dashboard->get_total_kunjungan_today();
        $data['total_kunjungan_month']	= $this->m_dashboard->get_total_kunjungan_monthly(date('m'));
        $data['total_kunjungan_week']	= $this->m_dashboard->get_total_kunjungan_weekly();
        $data['total_kunjungan_year']	= $this->m_dashboard->get_total_kunjungan_yearly(date('Y'));

        $data['top_desease']			= $this->m_dashboard->get_top5_desease();

        for ($i=1; $i <= 12; $i++){
            $data['pria'][$i] = $this->m_dashboard->get_pasien_laki($i);
            $data['wanita'][$i] = $this->m_dashboard->get_pasien_perempuan($i);
            $data['kunjungan'][$i] = $this->m_dashboard->get_total_kunjungan_monthly($i);
			$data['rawat_inap'][$i] = $this->m_dashboard->get_kunjungan_rawat_inap($i);
	    	$data['rawat_jalan'][$i] = $this->m_dashboard->get_kunjungan_rawat_jalan($i);
			$data['kasus_lama'][$i] = $this->m_dashboard->get_kunjungan_kasus_lama($i);
			$data['kasus_baru'][$i] = $this->m_dashboard->get_kunjungan_kasus_baru($i);
        }
		
		$poli = $this->m_dashboard->get_all_poli();
		
		$i=0;
		foreach($poli as $p){
			#echo $p['kd_unit_pelayanan'].'<br>';	
			$data['poli']['jumlah'][$i] = $this->m_dashboard->get_kunjungan_per_poli(date('m'),$p['kd_unit_pelayanan']);
			$data['poli']['nm_unit'][$i] = $p['singkatan'];
			$i++;
		}

        #echo '<pre>'; print_r($data); exit;

        $this->template->display_dash_walikota('dashboard_walikota/kecamatan_tanahsareal', $data);

//        $this->template->display_dashboard('dashboard_dinkes', $data);
    }
	
}

/* End of file dash_walikota.php */
/* Location: ./application/controllers/dash_walikota.php */
