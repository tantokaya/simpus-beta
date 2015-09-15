<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_transaksi_pendaftaran extends CI_Controller
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

        $this->load->model('m_rujukan');
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
			//$data['kd_rekam_medis'] = $this->m_crud->generate_rekam_medis($this->input->post('kd_puskesmas'));
			$data['kd_rekam_medis'] = $this->m_crud->generate_rekam_medis($this->session->userdata('kd_puskesmas'));
			$data['no_reg'] = $this->input->post('no_reg');
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
			$data['idkartu_medical'] = $this->input->post('no_kk');
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
			//$data['kd_puskesmas'] = $this->input->post('kd_puskesmas');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			
			$this->m_crud->simpan('pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data Pendaftaran berhasil disimpan!');
			redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			//$data['kd_rekam_medis'] = $this->m_crud->generate_rekam_medis($this->input->post('kd_puskesmas'));
			//$data['kd_rekam_medis'] = $this->m_crud->generate_rekam_medis($this->session->userdata('kd_puskesmas'));
			$data['no_reg'] = $this->input->post('no_reg');
			$data['nm_lengkap'] = $this->input->post('nm_lengkap');
			$data['tanggal_daftar'] = $this->functions->convert_date_sql($this->input->post('tanggal_daftar'));
			$data['tempat_lahir'] = $this->input->post('tempat_lahir');
			$data['tanggal_lahir'] = $this->functions->convert_date_sql($this->input->post('tanggal_lahir'));
			$data['kd_jenis_kelamin'] = $this->input->post('kd_jenis_kelamin');
			$data['kd_jenis_pasien'] = $this->input->post('kd_jenis_pasien');
			$data['kd_bayar'] = $this->input->post('kd_bayar');
			$data['no_kk'] = $this->input->post('no_kk');
			$data['idkartu_medical'] = $this->input->post('no_kk');
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
			//$data['kd_puskesmas'] = $this->input->post('kd_puskesmas');
			$data['kd_puskesmas'] = $this->session->userdata('kd_puskesmas');
			
			$this->m_crud->perbaharui('kd_rekam_medis', $par3, 'pasien', $data);
			$this->session->set_flashdata('flash_message', 'Data Pendaftaran berhasil diperbaharui!');
			redirect('cont_transaksi_pendaftaran/pendaftaran', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_pendaftaran'] = $this->m_crud->get_pendaftaran_by_id($par2);
			$data['edit_kota'] = $this->m_crud->get_kota_by_propinsi_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,2));
			$data['edit_kecamatan'] = $this->m_crud->get_kecamatan_by_kota_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,4));
			$data['edit_kelurahan'] = $this->m_crud->get_kelurahan_by_kec_id(substr($data['edit_pendaftaran'][0]['kd_kecamatan'],0,7));
			
			#echo '<pre>'; print_r($data); exit;
			
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
 		$this->table->set_heading('No. Rekam Medis','No KK','Nama Pasien','Alamat','Umur (Tahun)','Metode Pembayaran','Aksi');
		
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

    function cekEktp(){

        $data = json_decode(trim(file_get_contents("http://localhost/simpus-bogortimur/assets/ektp.json")), true);
        // print_r($data);
        //echo $data['Nik'];
        $validasi = $this->m_crud->cek_nik($data['Nik']);
        if($validasi !== null){
            $result['status'] = "Pasien sudah terdaftar!";
            $result['kd_rekam_medis'] = $validasi['kd_rekam_medis'];
        } else {
            $result['status'] = "Pasien belum terdaftar!";
            $result['kd_rekam_medis'] = "";
        }

        $result['nm_lengkap']       = $data['Nama'];
        $result['nik']              = $data['Nik'];
        $result['tempat_lahir']     = $data['TempatLahir'];
        $result['tanggal_lahir']    = $data['TglLahir'];
        $result['jenis_kelamin']    = $data['JenisKelamin'];
        $result['alamat']           = $data['Alamat'].' RT. '.$data['Rt'].' / RW. '.$data['Rw'];
        $result['propinsi']         = $data['Provinsi'];
        $result['kota']             = $data['Kota'];
        $result['kecamatan']        = $data['Kecamatan'];
        $result['kelurahan']                 = $data['KelDesa'];
        $result['agama']                 = $data['Agama'];
        $result['status_kawin']                 = $data['StatusPerkawinan'];
        $result['pekerjaan']                 = $data['Pekerjaan'];
        $result['gol_darah']                 = $data['GolDarah'];
        $result['kewarganegaraan']                 = $data['Kewarganegaraan'];
        $result['foto']                 = $data['Photo'];
        $result['ttd']                 = $data['Signature'];



        echo json_encode($result);
    }

    public function cetak_rm() {
        $no_rm = $this->uri->segment(3);

        $view_rekam_medis = $this->m_crud->get_list_pasien($no_rm);
        $view_trans_pelayanan = $this->m_crud->get_pasien_rekam_medis($no_rm);

        $this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'F4', true, 'UTF-8', false);
        // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetPageOrientation('P');
        $pdf->SetAuthor('Pemerintah Kota Bogor');
        $pdf->SetTitle('Rekam Medis');
        $pdf->SetSubject('Rekam Medis Pasien');
        $pdf->SetKeywords('Medical Record');
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__).'/lang/eng.php'))
        {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('helvetica', '', 9, '', true);
        $pdf->SetTopMargin(10);
        $pdf->AddPage();
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

        $puskesmas = $this->m_rujukan->get_puskesmas_info($this->session->userdata('kd_puskesmas'));
        #echo $this->session->userdata('kd_puskesmas');
        #echo $this->db->last_query(); exit;

        $html     = '<table width="100%" align="center" border="0">';
        $html    .= '<tr>
                        <td width="20%" style="text-align: center;"><img src="'.base_url().'assets/img/'.$puskesmas["logo"].'" width="80" height="80"/></td>
                        <td width="80%" align="center"><h2>PEMERINTAH PROPINSI '.$puskesmas["nm_propinsi"].'<br>DINAS KESEHATAN KOTA '.$puskesmas["nm_kota"].'</h2>
                        <h1>UPTD '.$puskesmas["nm_puskesmas"].'</h1>
						<h3>'.$puskesmas["alamat"].' Telp. '.$puskesmas["telp"].'</h3>
                        </td>
                    </tr>
					<tr>
              <td colspan="" bordercolordark="#0A0A0A" style="text-align: center;">____________________________________________________________________________________________________</td>
              </tr>';
        $html    .= '</table><p></p>';

        $html    .= '<div id="rekam-medis">
                        	<h4 class="widgettitle nomargin">Rekam Medis Pasien</h4>
                            <div class="widgetcontent bordered">
                            	<div class="row-fluid">
                                	<div class="span6">
                                    	<table class="table table-bordered table-invoice">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">No. Rekam Medis</td>
                                                    <td width="70%">'.$view_rekam_medis['kd_rekam_medis'].'</td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Pasien</td>
                                                    <td>'.$view_rekam_medis['nm_lengkap'].'</td>
                                                </tr>
                                                <tr>
                                                    <td>Tempat, Tgl Lahir</td>
                                                    <td>'.$view_rekam_medis['tempat_lahir'].' / '.$this->functions->format_tgl_cetak2($view_rekam_medis['tanggal_lahir']).'</td>
                                                </tr>';
        $hitung = $this->functions->CalcAge($view_rekam_medis['tanggal_lahir'], date('Y-m-d'));
        //$hitung = $this->functions->dateDifference($view_rekam_medis['tanggal_lahir'], date('Y-m-d'));
        $umurku=$hitung[0].' Tahun '.$hitung[1].' Bulan '.$hitung[2].' Hari';
        // echo $umurku;
        $html   .='
                                                <tr>
                                                    <td>Umur</td>
                                                    <td>'.$umurku.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td>'.ucwords(strtolower($view_rekam_medis['jenis_kelamin'])).'</td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat</td>
                                                    <td>'.$view_rekam_medis['alamat'].'</td>
                                                </tr>
                                                <tr>
                                                    <td>Puskesmas</td>
                                                    <td>'.$view_rekam_medis['nm_puskesmas'].'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>';

        $html       .='
                        </div> <!-- </row-fluid> -->
                        <div class="clearfix"><br/></div>';

        $html   .='
            <h4 class="widgettitle">Kunjungan Pasien</h4>
            <div class="row-fluid">
                <div class="span12">
                    <table class="table table-bordered table-stripped table-hover" border="1">
                        <thead>
                        <tr align="center">
                            <th><b>No.</b></th>
                            <th><b>Tanggal</b></th>
                            <th><b>Puskesmas</b></th>
                            <th><b>Poli</b></th>
                            <th><b>Dokter</b></th>
                            <th><b>Anamnesa</b></th>
                            <th><b>Cat.Fisik</b></th>
                            <th><b>Penyakit</b></th>
                            <th><b>Tindakan</b></th>
                            <th><b>Obat (Dosis) (Jml)</b></th>
                        </tr>
                        </thead>
                        <tbody>';

        if(isset($view_trans_pelayanan) && !empty($view_trans_pelayanan)):
            $i=1; foreach($view_trans_pelayanan as $rs):
            if ($rs['anamnesa'] == '0') { $rs['anamnesa']="-";}
            if ($rs['catatan_fisik'] == '0') { $rs['catatan_fisik']="-";}
            if ($rs['tindakan'] == '') { $rs['tindakan']="-";}
            if ($rs['dokter'] == '') { $rs['dokter']="-";}

            $html   .= '<tr>
                                    <td>'.$i.'</td>
                                    <td>'.$this->functions->convert_date_indo(array("datetime" => $rs['tgl_pelayanan'])).'</td>
                                    <td>'.$rs['nm_puskesmas'].'</td> <!-- jenis layanan diganti poli mana -->
                                    <td>'.$rs['unit_layanan'].'</td>
                                    <td>'.$rs['dokter'].'</td>
                                    <td>'.$rs['anamnesa'].'</td>
                                    <td>'.$rs['catatan_fisik'].'</td>
                                    <td>'.$rs['kd_icd'].' - '.$rs['penyakit'].'</td>
                                    <td>'.$rs['tindakan'].'</td>';



            $pecahObat = explode(';', $rs['obat']);
            $pecahDosis = explode(';', $rs['dosis']);
            $pecahJml = explode(';', $rs['jml_obat']);
            $obatku = '';
            for($z=0; $z < count($pecahObat); $z++){
                $obatku .= $pecahObat[$z] . " (" . $pecahDosis[$z] . ") (" . $pecahJml[$z].")";
                if($z != (count($pecahObat)-1))
                    $obatku .= " \n- ";
            }
            $html   .= '


                                    <td>'. $obatku.'</td>

                                </tr>';
            $i++;
        endforeach;
        else:

            $html   .= '

                            <tr>
                                <td colspan="11"><center>Tidak ada riwayat kunjungan</center></td>
                            </tr>';

        endif;
        $html   .='
                        </tbody>
                    </table>
                </div>
            </div>
            </div> <!-- </widgetcontent> -->
            </div>';


        $pdf->SetTitle('Judul');
        $pdf->SetHeaderMargin(30);
        $pdf->SetTopMargin(20);
        $pdf->setFooterMargin(20);
        $pdf->SetAutoPageBreak(true);
        $pdf->SetAuthor('Pengarang');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        $pdf->Output('Rekam Medis.pdf', 'I');
    }
	
}
?>