<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dash_dinkes extends CI_Controller {

    /**
     Powered by : Hartanto Kurniawan, S.KOM
     */

    function __construct()
    {
        parent::__construct();
        $simkes=$this->load->database('default', TRUE);
        //$simobat=$this->load->database('obat', TRUE);

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
        $data['page_title'] = 'DINKES KOTA BOGOR';

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
                $data['nip_kpl']    = $t->nip_kpl;
                $data['kpl_puskesmas']  = $t->kpl_puskesmas;
                $data['nm_kota']        = $t->nm_kota;
                $data['nm_kecamatan']   = $t->nm_kecamatan;
                $data['nm_kelurahan']   = $t->nm_kelurahan;
                $data['nm_propinsi']    = $t->nm_propinsi;
                $data['alamat']         = $t->alamat;
            }	

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



        $this->template->display_dashboard('dashboard_dinkes', $data);

//        $this->template->display_dashboard('dashboard_dinkes', $data);
    }

    public function puskesmas_botim()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Dashboard Bogor Timur';

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
            foreach($hasil ->result() as $t){
                $data['nm_puskesmas']   = $t->nm_puskesmas;
                $data['nip_kpl']    = $t->nip_kpl;
                $data['kpl_puskesmas']  = $t->kpl_puskesmas;
                $data['nm_kota']        = $t->nm_kota;
                $data['nm_kecamatan']   = $t->nm_kecamatan;
                $data['nm_kelurahan']   = $t->nm_kelurahan;
                $data['nm_propinsi']    = $t->nm_propinsi;
                $data['alamat']         = $t->alamat;
            }	


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

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_botim', $data);

//        $this->template->display_dashboard('dashboard_dinkes', $data);
    }

     public function puskesmas_tegal_gundil()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Tegal Gundil';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_tegal_gundil', $data);

    }

     public function puskesmas_ceger()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Ceger';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_ceger', $data);

    }
    public function puskesmas_bogut()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Bogor Utara';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_bogut', $data);

    }
    public function puskesmas_vila_duta()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Vila Duta';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_vila_duta', $data);

    }
    public function puskesmas_cimahpar()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Cimahpar';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_cimahpar', $data);

    }
    public function puskesmas_warung_jambu()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Warung Jambu';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_warung_jambu', $data);

    }
    public function puskesmas_ciluar()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Ciluar';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_ciluar', $data);

    }
    public function puskesmas_ciparigi()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Ciparigi';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_ciparigi', $data);

    }
public function puskesmas_bosel()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Bogor Selatan';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_bosel', $data);

    }
    public function puskesmas_cipaku()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Cipaku';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_cipaku', $data);

    }
    public function puskesmas_rangga_mekar()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Rangga Mekar';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_rangga_mekar', $data);

    }
    public function puskesmas_mulyaharja()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Muyaharja';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_mulyaharja', $data);

    }
    public function puskesmas_lawang_gintung()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Lawang Gintung';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_lawang_gintung', $data);

    }
    public function puskesmas_bojongkerta()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Bojong Kerta';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_bojongkerta', $data);

    }
    public function puskesmas_genteng()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Genteng';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_genteng', $data);

    }
    public function puskesmas_bondongan()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Bondongan';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_bondongan', $data);

    }
    public function puskesmas_muarasari()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Muarasari';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_muarasari', $data);

    }
public function puskesmas_semplak()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Semplak';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_semplak', $data);

    }
    public function puskesmas_gangkelor()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Gang Kelor';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_gangkelor', $data);

    }
    public function puskesmas_cilendek()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Cilendek Timur';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_cilendek', $data);

    }
    public function puskesmas_pancasan()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Pancasan';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_pancasan', $data);

    }
    public function puskesmas_pasir_mulya()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Pasir Mulya';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_pasirmulya', $data);

    }
    public function puskesmas_gunung_batu()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Gunung Batu';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_gunungbatu', $data);

    }
    public function puskesmas_sindangbarang()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Sindang Barang';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_sindangbarang', $data);

    }
    public function puskesmas_balumbang()
    {
        $this->load->model('m_dashboard');

        $data['page_name']  = 'dashboard';
        $data['page_title'] = 'Balumbang';

        $this->template->display_dashboard('dashboard_puskesmas/puskesmas_balumbang', $data);

    }
}

/* End of file dash_dinkes.php */
/* Location: ./application/controllers/dash_dinkes.php */
