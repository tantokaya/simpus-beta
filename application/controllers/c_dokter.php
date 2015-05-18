<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_dokter extends CI_Controller
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
	
	/***TRANSAKSI PENDAFTARAN PASIEN***/
	function pendaftaran($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_rekam_medis'] = $this->m_crud->generate_rekam_medis($this->input->post('kd_puskesmas'));
			$data['nm_lengkap'] = $this->input->post('nm_lengkap');
			$data['tanggal_daftar'] = $this->functions->convert_date_sql($this->input->post('tanggal_daftar'));
			$data['tempat_lahir'] = $this->input->post('tempat_lahir');
			$data['tanggal_lahir'] = $this->functions->convert_date_sql($this->input->post('tanggal_lahir'));
	
			$hitung = $this->functions->dateDifference($data['tanggal_lahir'],$data['tanggal_daftar']);
			$data['umur'] = $hitung[0];
			
			$data['kd_jenis_kelamin'] = $this->input->post('kd_jenis_kelamin');
			$data['kd_jenis_pasien'] = $this->input->post('kd_jenis_pasien');
			$data['kd_bayar'] = $this->input->post('kd_bayar');
			$data['no_kk'] = $this->input->post('no_kk');
			$data['nm_kk'] = $this->input->post('nm_kk');
			$data['asuransi'] = $this->input->post('asuransi');
			$data['no_asuransi'] = $this->input->post('no_asuransi');
			//$data['ket_wilayah'] = $this->input->post('wilayah');
			$data['nik'] = $this->input->post('nik');
			$data['alamat'] = $this->input->post('alamat');
			$data['kd_propinsi'] = $this->input->post('kd_propinsi');
			$data['kd_kota'] = $this->input->post('kd_kota');
			$data['kd_kecamatan'] = $this->input->post('kd_kecamatan');
			$data['kd_kelurahan'] = $this->input->post('kd_kelurahan');
			$data['kd_pos'] = $this->input->post('kd_pos');
			$data['no_telepon'] = $this->input->post('no_telepon');
			$data['no_hp'] = $this->input->post('no_hp');
			$data['kd_agama'] = $this->input->post('kd_agama');
			$data['kd_gol_darah'] = $this->input->post('kd_gol_darah');
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['kd_pekerjaan'] = $this->input->post('kd_pekerjaan');
			$data['kd_status_marital'] = $this->input->post('kd_status_marital');
			$data['nm_ayah'] = $this->input->post('nm_ayah');
			$data['nm_ibu'] = $this->input->post('nm_ibu');
			$data['nm_orang'] = $this->input->post('nm_orang');
			$data['rincian_penanggung'] = $this->input->post('rincian_penanggung');
			$data['kd_puskesmas'] = $this->input->post('kd_puskesmas');
			
			$this->m_crud->simpan('pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data Pendaftaran berhasil disimpan!');
			redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_rekam_medis'] = $this->m_crud->generate_rekam_medis($this->input->post('kd_puskesmas'));
			$data['nm_lengkap'] = $this->input->post('nm_lengkap');
			$data['tanggal_daftar'] = $this->functions->convert_date_sql($this->input->post('tanggal_daftar'));
			$data['tempat_lahir'] = $this->input->post('tempat_lahir');
			$data['tanggal_lahir'] = $this->functions->convert_date_sql($this->input->post('tanggal_lahir'));
			$data['kd_jenis_kelamin'] = $this->input->post('kd_jenis_kelamin');
			$data['kd_jenis_pasien'] = $this->input->post('kd_jenis_pasien');
			$data['kd_bayar'] = $this->input->post('kd_bayar');
			$data['no_kk'] = $this->input->post('no_kk');
			$data['nm_kk'] = $this->input->post('nm_kk');
			$data['asuransi'] = $this->input->post('asuransi');
			$data['no_asuransi'] = $this->input->post('no_asuransi');
			//$data['ket_wilayah'] = $this->input->post('wilayah');
			$data['nik'] = $this->input->post('nik');
			$data['alamat'] = $this->input->post('alamat');
			$data['kd_propinsi'] = $this->input->post('kd_propinsi');
			$data['kd_kota'] = $this->input->post('kd_kota');
			$data['kd_kecamatan'] = $this->input->post('kd_kecamatan');
			$data['kd_kelurahan'] = $this->input->post('kd_kelurahan');
			$data['kd_pos'] = $this->input->post('kd_pos');
			$data['no_telepon'] = $this->input->post('no_telepon');
			$data['no_hp'] = $this->input->post('no_hp');
			$data['kd_agama'] = $this->input->post('kd_agama');
			$data['kd_gol_darah'] = $this->input->post('kd_gol_darah');
			$data['kd_pendidikan'] = $this->input->post('kd_pendidikan');
			$data['kd_pekerjaan'] = $this->input->post('kd_pekerjaan');
			$data['kd_status_marital'] = $this->input->post('kd_status_marital');
			$data['nm_ayah'] = $this->input->post('nm_ayah');
			$data['nm_ibu'] = $this->input->post('nm_ibu');
			$data['nm_orang'] = $this->input->post('nm_orang');
			$data['rincian_penanggung'] = $this->input->post('rincian_penanggung');
			$data['kd_puskesmas'] = $this->input->post('kd_puskesmas');
			
			$this->m_crud->perbaharui('kd_rekam_medis', $par3, 'pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data Pendaftaran berhasil diperbaharui!');
			redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pendaftaran'] = $this->m_crud->get_pendaftaran_by_id($par2);
			$data['edit_kota'] = $this->m_crud->get_kota_by_propinsi_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,2));
			$data['edit_kecamatan'] = $this->m_crud->get_kecamatan_by_kota_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,4));
			$data['edit_kelurahan'] = $this->m_crud->get_kelurahan_by_kec_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,7));
		}
		
		if ($par1 == 'hapus') {
			$this->db->where('kd_rekam_medis', $par2);
			$this->db->delete('pasien');
			$this->session->set_flashdata('flash_message', 'Data pendaftaran berhasil dihapus!');
			redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
		}
		
		if ($par1 == 'view') {
			$data['view_rekam_medis'] = $this->m_crud->get_list_pasien($par2);
			$data['view_trans_pelayanan'] = $this->m_crud->get_pasien_rekam_medis($par2);
		}
		
		$data['page_name']  = 'pendaftaran';
		$data['page_title'] = 'Pendaftaran' ;
		//$data['pendaftaran']	= $this->m_crud->get_all_pendaftaran();
		$tmpl = array('table_open' => '<table id="dyntable" class="table table-bordered" width="100%">');
        $this->table->set_template($tmpl);
 		$this->table->set_heading('No. Rekam Medis','Nama Pasien','NIK','Tanggal Lahir','Umur','Aksi');
		
		$data['list_jenis_kelamin'] = $this->m_crud->get_list_jenis_kelamin('1');
		$data['list_jp'] = $this->m_crud->get_list_jp('1');
		$data['list_cb'] = $this->m_crud->get_list_cb('1');
		$data['list_agama'] = $this->m_crud->get_list_agama('1');
		$data['list_golongan_darah'] = $this->m_crud->get_list_golongan_darah('1');
		$data['list_pendidikan'] = $this->m_crud->get_list_pendidikan('1');
		$data['list_pekerjaan'] = $this->m_crud->get_list_pekerjaan('1');
		//$data['list_ras'] = $this->m_crud->get_list_ras('1');
		//$data['list_asal_pasien'] = $this->m_crud->get_list_asal_pasien('1');
		$data['list_status_marital'] = $this->m_crud->get_list_status_marital('1');
		$data['list_provinsi'] = $this->m_crud->get_list_provinsi('1');
		$data['list_spesialisasi'] = $this->m_crud->get_list_spesialisasi('1');
		
		$data['list_ruangan'] = $this->m_crud->get_list_ruangan('1');
		$data['list_kamar'] = $this->m_crud->get_list_kamar('1');
		$data['list_petugas'] = $this->m_crud->get_list_petugas('1');
		$data['list_unit_pelayanan'] = $this->m_crud->get_list_unit_pelayanan('1');
		$data['list_kota'] = $this->m_crud->get_list_kota('1');
		$data['list_kecamatan'] = $this->m_crud->get_list_kcmt('1');
		//$data['list_kelurahan'] = $this->m_crud->get_list_kelurahan('1');
		$data['list_puskesmas']	= $this->m_crud->get_list_puskesmas();
		
		$this->template->display('pendaftaran', $data);
	}	
	
	/***MASTER JENIS IMUNISASI***/
	function jenis_imunisasi($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah') {
			$data['kd_jenis_imunisasi'] = $this->input->post('kd_jenis_imunisasi');
			$data['jns_imunisasi'] = $this->input->post('jns_imunisasi');
						
			$this->m_crud->simpan('jenis_imunisasi', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis imunisasi berhasil disimpan!');
			redirect('cont_transaksi_pendaftaran/jenis_imunisasi', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kd_jenis_imunisasi'] = $this->input->post('kd_jenis_imunisasi');
			$data['jns_imunisasi'] = $this->input->post('jns_imunisasi');
						
			$this->m_crud->perbaharui('kd_jenis_imunisasi', $par3, 'jenis_imunisasi', $data);
			$this->session->set_flashdata('flash_message', 'Data jenis imunisasi berhasil diperbaharui!');
			redirect('cont_transaksi_pendaftaran/jenis_imunisasi', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_jenis_imunisasi'] = $this->m_crud->get_jenis_imunisasi_by_id($par2);
		}
		if ($par1 == 'hapus') {
			$this->db->where('kd_jenis_imunisasi', $par2);
			$this->db->delete('jenis_imunisasi');
			$this->session->set_flashdata('flash_message', 'Data jenis imunisasi berhasil dihapus!');
			redirect('cont_transaksi_pendaftaran/jenis_imunisasi', 'refresh');
		}
		
		$data['page_name']  = 'jenis_imunisasi';
		$data['page_title'] = 'Jenis Imunisasi' ;
		$data['jenis_imunisasi']	= $this->m_crud->get_all_jenis_imunisasi();
			
		$this->template->display('jenis_imunisasi', $data);
	}
	/***Get Kota***/
	
	function getKota()
	{
		$kd_propinsi = $this->input->post('kd_propinsi');
		$kota = $this->m_crud->get_kota_by_propinsi_id($kd_propinsi);
		
		$data = "<option value=''></option>\n";
		foreach($kota as $v){
			$data .= "<option value='$v[kd_kota]'>$v[nm_kota]</option>\n";
		}
		
		echo $data;
	}
	
	function getListKota() {
		$kd_propinsi = $this->input->post('kd_propinsi');
		$kota = $this->m_crud->get_list_kota($kd_propinsi);
		$data .= "<option value=''>--Pilih Kota--</option>";
		foreach ($kota as $k) {
			$data .= "<option value='$k[kd_kota]'>$k[nm_kota]</option>";
		}
		echo $data;
	}
	
	function getKecamatan()
	{
		$kd_kota = $this->input->post('kd_kota');
		$kecamatan = $this->m_crud->get_kecamatan_by_kota_id($kd_kota);
		
		$data = "<option value=''></option>\n";
		foreach($kecamatan as $v){
			$data .= "<option value='$v[kd_kecamatan]'>$v[nm_kecamatan]</option>\n";
		}
		
		echo $data;
	}
	
	function getKelurahan()
	{
		$kd_kecamatan = $this->input->post('kd_kecamatan');
		$kelurahan = $this->m_crud->get_kelurahan_by_kec_id($kd_kecamatan);
		
		$data = "<option value=''></option>\n";
		foreach($kelurahan as $v){
			$data .= "<option value='$v[kd_kelurahan]'>$v[nm_kelurahan]</option>\n";
		}
		
		echo $data;
	}
	
	
	
}
?>