<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_lap_summary_bayar_tindakan extends CI_Controller
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
			$data['page_title'] = 'Laporan Summary Tindakan per tgl';
			
			$this->template->display('../cetak/lap_bayar_summary_tindakan_tgl', $data);
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
			$text = "SELECT a.kd_bayar,a.tgl_bayar,a.nama_pasien,Sum(b.harga_jual) AS total_harga,a.kd_rekam_medis,c.nm_lengkap
                    FROM btindakan_header AS a JOIN btindakan_detail AS b ON a.kd_bayar = b.kd_bayar
                    INNER JOIN pasien AS c ON c.kd_rekam_medis = a.kd_rekam_medis $where GROUP BY a.kd_bayar";

			$d['data'] = $this->db->query($text);
			
			$this->template->tampil_lap_summary_bayar_tindakan('daftar_lap_summary_bayar_tindakan',$d);
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

            $where = " WHERE btindakan_header.tgl_bayar BETWEEN '$tgl1' AND '$tgl2'";
            $text = "SELECT
                    btindakan_header.id_bayar,
                    btindakan_header.tgl_bayar,
                    btindakan_header.kd_bayar,
                    btindakan_header.kd_rekam_medis,
                    btindakan_header.bayar,
                    btindakan_header.kembalian,
                    btindakan_header.nopelayanan,
                    pasien.nm_lengkap,
                    pasien.alamat,
                    pasien.kd_kecamatan,
                    kecamatan.nm_kecamatan
                    FROM
                    btindakan_header
                    LEFT JOIN pasien ON btindakan_header.kd_rekam_medis = pasien.kd_rekam_medis
                    LEFT JOIN kecamatan ON pasien.kd_kecamatan = kecamatan.kd_kecamatan
      			    $where ORDER BY btindakan_header.kd_bayar";

			$d['data'] = $this->db->query($text);
			$d['tgl1'] = $this->uri->segment(3);
			$d['tgl2'] = $this->uri->segment(4);

            $text = "SELECT set_puskesmas.`status`,set_puskesmas.kd_puskesmas,set_puskesmas.nm_puskesmas,set_puskesmas.alamat,
                    set_puskesmas.puskesmas_induk,set_puskesmas.jns_puskesmas,set_puskesmas.nip_kpl,set_puskesmas.kpl_puskesmas,
                    set_puskesmas.kd_propinsi,set_puskesmas.kd_kota,set_puskesmas.kd_kecamatan,set_puskesmas.kd_kelurahan,
                    set_puskesmas.telp,set_puskesmas.logo,kecamatan.nm_kecamatan,kota.nm_kota,kelurahan.nm_kelurahan,propinsi.nm_propinsi
                    FROM set_puskesmas
                    INNER JOIN kecamatan ON kecamatan.kd_kecamatan = set_puskesmas.kd_kecamatan
                    INNER JOIN kota ON kota.kd_kota = set_puskesmas.kd_kota
                    INNER JOIN kelurahan ON kelurahan.kd_kelurahan = set_puskesmas.kd_kelurahan
                    INNER JOIN propinsi ON propinsi.kd_propinsi = set_puskesmas.kd_propinsi";
            $hasil = $this->m_crud->manualQuery($text);
            foreach($hasil ->result() as $t){
                $d['nm_puskesmas']  = $t->nm_puskesmas;
                $d['alamat']	    = $t->alamat;
                $d['nm_kelurahan']  = $t->nm_kelurahan;
                $d['nm_kecamatan']  = $t->nm_kecamatan;
                $d['nm_kota']       = $t->nm_kota;
                $d['nm_propinsi']   = $t->nm_propinsi;
                $d['logo']	        = $t->logo;
                $d['telp']	        = $t->telp;
            }
			

			$this->template->tampil_cetak_lap_summary_bayar_tindakan('cetak_lap_summary_bayar_tindakan',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
}
