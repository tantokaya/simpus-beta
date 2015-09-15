<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
	
	/***default functin, redirects to login page if no admin logged in yet***/
	public function index()
	{
		if ($this->session->userdata('logged_in') == true) {
			//redirect('admin/dashboard');
			$data['page_name'] = 'dashboard';
			$data['page_title'] = 'Dashboard';
			$this->template->display('dashboard', $data);
		}
		
		
		$config = array(
			array(
//				'field' => 'email',
//				'label' => 'Email',
//				'rules' => 'required|xss_clean|valid_email'
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|xss_clean'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|xss_clean|callback__validate_login'
			)
		);


        $this->form_validation->set_rules($config);
		$this->form_validation->set_message('_validate_login', ' Login failed!');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
		
		if ($this->form_validation->run() == FALSE) {
			//$this->load->view('login');
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
                $data['nip_kpl']    = $t->nip_kpl;
                $data['kpl_puskesmas']  = $t->kpl_puskesmas;
                $data['nm_kota']        = $t->nm_kota;
                $data['nm_kecamatan']   = $t->nm_kecamatan;
                $data['nm_kelurahan']   = $t->nm_kelurahan;
                $data['nm_propinsi']    = $t->nm_propinsi;
                $data['alamat']         = $t->alamat;
                $data['logo']           = $t->logo;
            }
//            $this->template->display_login();
            $this->load->view('login',$data);
        } else {
			//redirect('admin/dashboard');
			
			switch($this->session->userdata('id_akses')){
				case 1:
					redirect('admin/dashboard');
					break;
				case 2:
					redirect('pendaftaran/dashboard');
					break;
				case 3:
					redirect('dokter/dashboard');
					break;
				case 4:
					redirect('rekam_medis/dashboard');
					break;
				case 5:
					redirect('laboratorium/dashboard');
					break;
				case 6:
					redirect('barang/apotek');
					break;
				case 7:
					redirect('operator/dashboard');
					break;
				case 8:
					redirect('barang/gudang');
					break;
				case 9: 
					redirect('kasir/dashboard');
					break;
				case 10:
					redirect('poli_gigi/dashboard');
					break;
				case 11:
					redirect('poli_kia/dashboard');
					break;
				case 12:
					redirect('poli_umum/dashboard');
					break;
				case 13:
					redirect('ugd/dashboard');
					break;
				case 14:
					redirect('ptrm/dashboard');
					break;
				
			}
			
			$data['page_name'] = 'dashboard';
			$data['page_title'] = 'Dashboard';
			$this->template->display('dashboard', $data);
			
		}
		
	}
	
	/***validate login****/
	function _validate_login($str)
	{
		$query = $this->db->get_where('user', array(
//			'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
			'password' =>  md5($this->input->post('password'))
		));
		
		if ($query->num_rows() > 0) {
			$row = $query->row();

			if ($row ->id_akses == 1) {
			
				$this->session->set_userdata('akses', 'administrator');
			
			} else if ($row ->id_akses == 2) {
			
				$this->session->set_userdata('akses', 'pendaftaran');
			
			} else if ($row ->id_akses == 3) {
			
				$this->session->set_userdata('akses', 'dokter');
			
			} else if ($row ->id_akses == 4) {
			
				$this->session->set_userdata('akses', 'rekam medis');
			
			} else if ($row ->id_akses == 5) {
			
				$this->session->set_userdata('akses', 'laboratorium');
				$this->session->set_userdata('kd_unit_pelayanan', '5');
				
			} else if ($row ->id_akses == 6) {
			
				$this->session->set_userdata('akses', 'apotik');
			
			}	 else if ($row ->id_akses == 7) {
			
				$this->session->set_userdata('akses', 'operator');
			
			} else if ($row ->id_akses == 8) {
			
				$this->session->set_userdata('akses', 'gudang');
			
			} else if ($row ->id_akses == 9) {
			
				$this->session->set_userdata('akses', 'kasir');
			
			} else if ($row ->id_akses == 10) {
			
				$this->session->set_userdata('akses', 'poli_gigi');
				$this->session->set_userdata('kd_unit_pelayanan', '3');
			} 
			 else if ($row ->id_akses == 11) {
			
				$this->session->set_userdata('akses', 'poli_kia');
				$this->session->set_userdata('kd_unit_pelayanan', '4');
			}	
			 else if ($row ->id_akses == 12) {
			
				$this->session->set_userdata('akses', 'poli_umum');
				$this->session->set_userdata('kd_unit_pelayanan', '2');
			}	
			else if ($row ->id_akses == 13) {
			
				$this->session->set_userdata('akses', 'ugd');
				$this->session->set_userdata('kd_unit_pelayanan', '23');
			}																
			else if ($row ->id_akses == 14) {
			
				$this->session->set_userdata('akses', 'ptrm');
				$this->session->set_userdata('kd_unit_pelayanan', '17');
			}	
			
			$this->session->set_userdata('id_user', $row->id_user);
			$this->session->set_userdata('nama', $row->nama);
			$this->session->set_userdata('id_akses', $row->id_akses);
			$this->session->set_userdata('kd_puskesmas', $row->kd_puskesmas);
			
			$query2 = $this->db->get_where('puskesmas', array(
					'kd_puskesmas' => $row->kd_puskesmas
			));
			
			if ($query2->num_rows() > 0) {
				$row2 = $query2->row();
				$this->session->set_userdata('obat_pref', $row2->obat_prev);
			}
			
			$this->session->set_userdata('logged_in', true);
			
			return TRUE;
		} else {
			$this->session->set_flashdata('flash_message', 'Login gagal');
			return FALSE;
		}
	}
	
	/*******LOGOUT FUNCTION *******/
	function logout()
	{
		$this->session->unset_userdata();
		$this->session->sess_destroy();
		redirect('login');
	}
	
	/***DEFAULT NOR FOUND PAGE*****/
	function four_zero_four()
	{
		$this->load->view('four_zero_four');
	}
	
	
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */