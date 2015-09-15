<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		//$this->load->library('access');
		$this->load->library('template');
		$this->load->helper('download');
		$this->load->helper('url');
		$this->load->library('encrypt');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	/***Default function, redirects to login page if no admin logged in yet***/
	public function index()
	{
		if ($this->session->userdata('logged_in') == true)
			redirect('barang/gudang');
		else
			redirect('login');
			
	}
	public function download_stok_gudang(){
		$this->load->helper('download');
		$name = 'LapStokGudang.xls';
		$data = file_get_contents("uploads/LapStokGudang.xls"); // letak file pada aplikasi kita
 
		
		force_download($name, $data);
	}
	
	public function download_stok_apotek(){
		$this->load->helper('download');
		$name = 'LapStokApotek.xls';
		$data = file_get_contents("uploads/LapStokApotek.xls"); // letak file pada aplikasi kita

		force_download($name, $data);
	}
	
	
	/***Barang Masuk Dan Keluar Gudang***/
	
	function gudang()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'gudang';
			$data['page_title'] = 'Gudang';
			
			$pusk=$this->session->userdata('kd_puskesmas');
			$text = "SELECT * FROM puskesmas Where kd_puskesmas='$pusk' ";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$data['nm_puskesmas'] = $t->nm_puskesmas;
				
			}

            $textjml = "SELECT
                COUNT(obat.obat_stok) AS jumlah,
                current_date() as tgl_sekarang, datediff(tgl_kadaluarsa, CURRENT_DATE()) as selisih
                FROM
                obat
                INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                WHERE obat.obat_stok <> 0";
            $hasiljml =$this->m_crud->manualQuery($textjml);
            foreach($hasiljml->result() as $t){
                $data['jumlah'] = $t->jumlah;
            }

            $data['all_new_resep']	= $this->m_crud->get_all_new_resep();

            $this->template->display('gudang', $data);
		} else {
			redirect('login');
		}
		
	} 
	
	
	
	/***Barang Masuk Gudang***/
	
	
	function masuk($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah' && $par2 == 'do_update') {
			
			
			redirect('barang/masuk', 'refresh');
			
		} else if ($par1 == 'tambah') {
			
			$data['tambah_barang_masuk'] = $this->m_crud->get_obat_by_id($par2);
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kodemasuk'] = $this->input->post('kodemasuk');
			$data['tgl_terima'] = $this->input->post('tgl_terima');
			$data['no_sbbk'] = $this->input->post('nosbbk');
			$data['no_batch'] = $this->input->post('no_batch');
			
			$this->m_crud->perbaharui('kd_in', $par3, 'in', $data);
			$this->session->set_flashdata('flash_message', 'Data Barang Masuk berhasil diperbaharui!');
			redirect('barang/tambah', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_barang_masuk'] = $this->m_crud->get_masuk_by_id($par2);
		}
		
		if ($par1 == 'hapus') {
			$id = $this->uri->segment(4); // $this->input->post('id');
			
			$text = "SELECT * FROM brg_masuk_header WHERE kd_masuk='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM brg_masuk_detail
						WHERE kd_masuk='$id'";
				$this->m_crud->manualQuery($text);
				$text = "DELETE FROM brg_masuk_header WHERE kd_masuk='$id'";
				$this->m_crud->manualQuery($text);
				$this->session->set_flashdata('flash_message', 'Data Barang Masuk berhasil dihapus!');
				redirect('barang/masuk', 'refresh');
			}
		}
		
		
		$data['tgl_terima']			= date('d-m-Y');
		//$data['tgl_tempo']			= date('d-m-Y');
		$data['kodemasuk']			= $this->m_crud->MaxKodeMasuk(); 
		$data['page_name']  			= 'in';
		$data['page_title']	 		= 'Barang Masuk';
		$data['kd_obat']	 		= '';
		//$data['kd_sat_kecil_obat']	 	= '';
		$data['sat_kecil_obat']			= '';
		$data['no_sbbk']	 		= '';
		$data['nama_obat']	 		= '';
		$data['harga_beli']	 		= '';
		$data['no_batch']	 		= '';
		$data['tgl_kadaluarsa']	    = '';
		$data['jml']	 			= '';
		$data['total']	 			= '';
		
		
		$data['list_milik_obat'] 	= $this->m_crud->get_list_milik_obat('1');
		$data['barang_masuk']		= $this->m_crud->get_all_masuk();
		$data['list_obat']		    = $this->m_crud->get_list_obat('1');
		$data['list_satuan_kecil']	= $this->m_crud->get_list_sat_kecil();
		$data['masuk']			    = $this->m_crud->get_all_barang_masuk();
		
			
		$this->template->display('masuk', $data);
		
	}
	
	function detailbarang($par1 = '', $par2 = '', $par3 = '')
	{
		if($this->session->userdata('logged_in')!="")
			
			$id = $this->input->post('nomor');
			
			$text = "SELECT * FROM brg_masuk_detail WHERE kd_masuk='$id'";
			$d['data'] = $this->db->query($text);
			
			$data['page_name']  = 'detailbarang';
			$data['page_title'] = 'Barang';
			
			$this->template->tampil('daftar_pembelian',$d);
		
		
	}

	public function HapusDetail()
	{
			$nomor = $this->uri->segment(3);//$exp[0];
			$kode = $this->uri->segment(4); //$exp[1];
			
			$id_usaha = $this->session->userdata('id');
			
			$text = "SELECT * FROM brg_masuk_detail,brg_masuk_header 
					WHERE brg_masuk_detail.kd_masuk= brg_masuk_header.kd_masuk AND
					brg_masuk_detail.kd_masuk='$nomor' AND brg_masuk_detail.kd_obat='$kode'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM brg_masuk_detail
					 WHERE 	kd_masuk='$nomor' AND kd_obat='$kode'";
				$this->m_crud->manualQuery($text);
			//echo "Data Sukses dihapus";
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/masuk/ubah/$nomor'>";			
			}else{
				echo "Tidak Ada data yang dapat dihapus";
			}
	}
	
	public function DataDetail($id=NULL)
	{
			if (!$this->session->userdata('logged_in') == true)
			{
				redirect('login');
			}
			
			$id = $this->input->post('kode');

			$text = "SELECT * FROM brg_masuk_detail WHERE kd_masuk='$id'";
			$d['data'] = $this->db->query($text);


			$this->template->tampil_masuk('daftar_pembelian',$d);
	
	}
	
	public function simpan_barang_masuk()
	{
			///////* simpan ke table header * ///////////////
			$tgl_terima 			= $this->input->post('tgl_terima');
			$tgl_tempo 				= $this->input->post('tgl_tempo');
			$tgl_kadaluarsa 		= $this->input->post('tgl_kadaluarsa');
		
			$up['kd_masuk'] 		= $this->input->post('kodemasuk');
			$up['no_sbbk'] 		    = $this->input->post('no_sbbk');
            $up['no_batch']         = $this->input->post('no_batch');
			$up['tgl_terima'] 		= $this->m_crud->tgl_sql($this->input->post('tglterima'));
			$up['tgl_kadaluarsa']	= $this->m_crud->tgl_sql($this->input->post('tgl_kadaluarsa'));
			$up['kd_milik_obat'] 	= $this->input->post('kd_milik_obat');

			/////* simpan ke table detail *//////////////
			
			$ud['kd_masuk'] 		= $this->input->post('kodemasuk');
			$ud['kd_obat']			= $this->input->post('kd_obat');
			$ud['nama_obat']		= $this->input->post('nama_obat');
			$ud['jml'] 			= $this->input->post('jml');	
			$ud['harga_beli'] 		= str_replace(",","",$this->input->post('harga_beli'));
			$ud['sat_kecil_obat']		= $this->input->post('sat_kecil_obat');
			$ud['no_faktur'] 		= $this->input->post('nofaktur');
			$ud['tgl_terima'] 		= $this->m_crud->tgl_sql($this->input->post('tglterima'));
			$ud['tgl_kadaluarsa']		= $this->m_crud->tgl_sql($this->input->post('tgl_kadaluarsa')); 
			$ud['kd_milik_obat'] 		= $this->input->post('kd_milik_obat');
			
			
			$kd_masuk 			= $this->input->post('kodemasuk');
			$kd_obat 			= $this->input->post('kd_obat');
			
			$id['kd_masuk'] 		= $this->input->post('kodemasuk');
			
			$id_d['kodemasuk'] 		= $this->input->post('kd_masuk');
			$id_d['kd_obat'] 		= $this->input->post('kd_obat');
			
			///////////////////*  Update data Obat *//////////////////////
			$id_t['no_batch']		= $this->input->post('no_batch');
			$id_t['tgl_kadaluarsa']		= $this->m_crud->tgl_sql($this->input->post('tgl_kadaluarsa'));
			
			$id_e['kd_obat'] 		= $this->input->post('kd_obat');
			
			$hasil = $this->m_crud->getSelectedData("brg_masuk_header",$id);
			$row = $hasil->num_rows();
			if($row>0){
				$this->m_crud->updateData("brg_masuk_header",$up,$id);
				$text = "SELECT * FROM brg_masuk_detail WHERE kd_masuk='$kd_masuk' AND kd_obat='$kd_obat'";
				$hasil = $this->m_crud->manualQuery($text);
				if($hasil->num_rows()>0){
					$this->m_crud->updateData("brg_masuk_detail",$ud,$id_d);
				}else{
					$this->m_crud->insertData("brg_masuk_detail",$ud);
				}
				echo "Data sukses diubah";
			}else{
				$this->m_crud->insertData("brg_masuk_header",$up);
				$this->m_crud->insertData("brg_masuk_detail",$ud);
				echo "Data sukses disimpan";
				
				$this->m_crud->updateData("obat",$id_t,$id_e);
				
			}
			
		
	}
	
	
	public function cetak()
	{
			$id = $this->uri->segment(3); //$this->session->userdata('id');
			$id_p = $this->session->userdata('id');
			
			$d['id'] = $id;
			
				
			$text = "SELECT *
					FROM brg_masuk_header 
					WHERE kd_masuk='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['tgl_terima'] = $this->m_crud->tgl_indo($t->tgl_terima);
				$d['tgl_tempo'] = $this->m_crud->tgl_indo($t->tgl_tempo);
				$d['kepemilikan'] = $t->kd_milik_obat;
				$d['kd_masuk'] = $t->kd_masuk;
			}
			
			$text = "SELECT sum(jml*harga_beli) as total
					FROM brg_masuk_detail 
					WHERE kd_masuk='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['total'] = $t->total;
			}
			
			$text = "SELECT *
					FROM brg_masuk_detail
					WHERE kd_masuk='$id'";

			$d['data'] = $this->m_crud->manualQuery($text);

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
        }
			
			
			$this->template->tampil_cetak_barang_masuk('cetak_barang_masuk',$d);
							
			
	}
	
	
	
	
	/***MASTER BARANG KELUAR ***/
	function keluar($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah' && $par2 == 'do_update') {
			
			
			redirect('barang/keluar', 'refresh');
			
		} else if ($par1 == 'tambah') {
			
			$data['keluar_stok_obat'] = $this->m_crud->get_obat_by_id($par2);
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kodekeluar'] = $this->input->post('kodekeluar');
			$data['tgl_keluar'] = $this->input->post('tgl_keluar');
			$data['keterangan'] = $this->input->post('keterangan');
			
			$this->m_crud->perbaharui('kd_keluar', $par3, 'barang_keluar', $data);
			$this->session->set_flashdata('flash_message', 'Data obat keluar berhasil diperbaharui!');
			redirect('barang/keluar', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_keluar_obat'] = $this->m_crud->get_keluar_by_id($par2);
		}
		
		if ($par1 == 'hapus') {
			$id = $this->uri->segment(4); // $this->input->post('id');
			
			$text = "SELECT * FROM barang_keluar_header WHERE kd_keluar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM barang_keluar_detail
						WHERE kd_keluar='$id'";
				$this->m_crud->manualQuery($text);
				$text = "DELETE FROM barang_keluar_header WHERE kd_keluar='$id'";
				$this->m_crud->manualQuery($text);
				//echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/gudang'>";
				$this->session->set_flashdata('flash_message', 'Data obat keluar berhasil dihapus!');
				redirect('barang/keluar', 'refresh');
			}
		}
		
		
		
		$data['tgl_keluar']			= date('d-m-Y');
		$data['kodekeluar']			= $this->m_crud->MaxKodeKeluar(); 
		$data['page_name']  			= 'barang_keluar';
		$data['page_title']	 		= 'Barang Keluar';
		$data['kd_obat']	 		= '';
		$data['sat_kecil_obat']			= '';
		$data['keterangan']	 		= '';
		$data['nama_obat']	 		= '';
		$data['jml']	 			= '';
		$data['total']	 			= '';
		
		
		//$data['list_milik_obat'] 	= $this->m_crud->get_list_milik_obat('1');
		$data['list_unit_farmasi'] 	= $this->m_crud->get_list_unit_farmasi('1');
		$data['obat_keluar']		= $this->m_crud->get_all_keluar();
		$data['list_obat']			= $this->m_crud->get_list_obat('1');
		$data['list_satuan_kecil']	= $this->m_crud->get_list_sat_kecil();
				
		$this->template->display('keluar', $data);
		
	}
	
	
	
	function detailbarangkeluar($par1 = '', $par2 = '', $par3 = '')
	{
		if($this->session->userdata('logged_in')!="")
			
			$id = $this->input->post('nomor');
			
			$text = "SELECT * FROM barang_keluar_detail WHERE kd_jual='$id'";
			$d['data'] = $this->db->query($text);
			
			$data['page_name']  = 'detailbarang';
			$data['page_title'] = 'Barang';
			
			$this->template->tampil('barang_keluar',$d);
		
		
	}
	
	public function DataDetailKeluar()
	{
			if (!$this->session->userdata('logged_in') == true)
			{
				redirect('login');
			}
			
			$id = $this->input->post('kode');
			
			$text = "SELECT * FROM barang_keluar_detail WHERE kd_keluar='$id'";
			$d['data'] = $this->db->query($text);
				
			$this->template->tampil_keluar('daftar_keluar',$d);
	
	}
	
	public function simpankeluar()
	{
			///////* simpan ke table header * ///////////////
			$tgl_keluar 			= $this->input->post('tgl_keluar');
			
			$up['kd_keluar'] 		= $this->input->post('kodekeluar');
			$up['tgl_keluar'] 		= $this->m_crud->tgl_sql($this->input->post('tglkeluar'));
			$up['kd_unit_farmasi'] 		= $this->input->post('kd_unit_farmasi');
			$up['keterangan'] 		= $this->input->post('keterangan');
			
			/////* simpan ke table detail *//////////////
			
			$ud['kd_keluar'] 		= $this->input->post('kodekeluar');
			$ud['kd_obat']			= $this->input->post('kd_obat');
			$ud['nama_obat']		= $this->input->post('nama_obat');
			$ud['jml'] 				= $this->input->post('jml');	
			$ud['harga_beli'] 		= str_replace(",","",$this->input->post('harga_beli'));	
			$ud['sat_kecil_obat']	= $this->input->post('sat_kecil_obat');
			$ud['tgl_keluar'] 		= $this->m_crud->tgl_sql($this->input->post('tglkeluar'));
			$ud['kd_milik_obat'] 	= $this->input->post('kd_milik_obat');
			
			
			$kd_keluar 				= $this->input->post('kodekeluar');
			$kd_obat 				= $this->input->post('kd_obat');
			
			$id['kd_keluar'] 			= $this->input->post('kodekeluar');
			
			$id_d['kodekeluar'] 	= $this->input->post('kd_keluar');
			$id_d['kd_obat'] 		= $this->input->post('kd_obat');
			
			$hasil = $this->m_crud->getSelectedData("barang_keluar_header",$id);
			$row = $hasil->num_rows();
			if($row>0){
				$this->m_crud->updateData("barang_keluar_header",$up,$id);
				$text = "SELECT * FROM barang_keluar_detail WHERE kd_keluar='$kd_keluar' AND kd_obat='$kd_obat'";
				$hasil = $this->m_crud->manualQuery($text);
				if($hasil->num_rows()>0){
					$this->m_crud->updateData("barang_keluar_detail",$ud,$id_d);
				}else{
					$this->m_crud->insertData("barang_keluar_detail",$ud);
				}
				echo "Data sukses diubah";
			}else{
				$this->m_crud->insertData("barang_keluar_header",$up);
				$this->m_crud->insertData("barang_keluar_detail",$ud);
				echo "Data sukses disimpan";
				
			}
			
		
	}
	
	public function HapusDetailKeluar()
	{
			$nomor = $this->uri->segment(3);//$exp[0];
			$kode = $this->uri->segment(4); //$exp[1];
			
			$id_usaha = $this->session->userdata('id');
			
			$text = "SELECT * FROM barang_keluar_detail,barang_keluar_header 
					WHERE barang_keluar_detail.kd_keluar=barang_keluar_header.kd_keluar AND
					barang_keluar_detail.kd_keluar='$nomor' AND barang_keluar_detail.kd_obat='$kode'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM barang_keluar_detail
					 WHERE 	kd_keluar='$nomor' AND kd_obat='$kode'";
				$this->m_crud->manualQuery($text);
			//echo "Data Sukses dihapus";
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/keluar/ubah/$nomor'>";			
			}else{
				echo "Tidak Ada data yang dapat dihapus";
			}
	}
	
	public function cetakkeluar()
	{
			$id = $this->uri->segment(3); //$this->session->userdata('id');
			$id_p = $this->session->userdata('id');
			
			$d['id'] = $id;
				
			$text = "SELECT *
					FROM barang_keluar_header 
					WHERE kd_keluar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['tgl_keluar'] = $this->m_crud->tgl_indo($t->tgl_keluar);
				
			}
			
			$text = "SELECT sum(jml*harga_beli) as total
					FROM barang_keluar_detail 
					WHERE kd_keluar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['total'] = $t->total;
			}
			
			$text = "SELECT *
					FROM barang_keluar_detail
					WHERE kd_keluar='$id'";

			$d['data'] = $this->m_crud->manualQuery($text);

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
            $d['logo']          = $t->logo;
        }
			
			
			$this->template->tampil_cetak_keluar('cetak_barang_keluar',$d);
							
			
	}
	
	
	// fungsi insert barang keluar dari resep
	function simpanResep()
	{
		$trans_id = $this->input->post('trans_id');
		
		$data['kd_keluar']			= $this->m_crud->MaxKodeKeluarApotek();
		$data['tgl_keluar']			= date('Y-m-d');
        $data['kd_trans_pelayanan'] = $trans_id;

		$this->m_crud->simpan('brg_apotek_keluar_header', $data);

        $this->db->select('pelayanan_obat.kd_trans_obat,pelayanan_obat.kd_obat,pelayanan_obat.dosis,pelayanan_obat.kd_sat_kecil_obat,
            pelayanan_obat.qty,pelayanan_obat.racikan,pelayanan_obat.sta_resep,obat.nama_obat,obat.harga_beli,satuan_kecil.sat_kecil_obat,
            obat.kd_sat_kecil_obat,pelayanan_obat.kd_trans_pelayanan,pelayanan.kd_rekam_medis,pasien.nm_lengkap,pasien.alamat');
		$this->db->from('pelayanan_obat');
		$this->db->join('obat', 'pelayanan_obat.kd_obat = obat.kd_obat');
		$this->db->join('pelayanan','pelayanan_obat.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan');
		$this->db->join('satuan_kecil', 'obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat');
		$this->db->join('pasien', 'pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		$this->db->where('pelayanan_obat.kd_trans_pelayanan', $trans_id);
		
		$list_obat = $this->db->get()->result_array();
		
		foreach($list_obat as $lo):
			$data2['kd_trans_pelayanan']    = $data['kd_trans_pelayanan'];
			$data2['kd_keluar'] 	        = $data['kd_keluar'];
			$data2['kd_obat'] 		        = $lo['kd_obat'];
			$data2['nama_obat'] 	        = $lo['nama_obat'];
			$data2['jml'] 			        = $lo['qty'];
			$data2['sat_kecil_obat']        = $lo['sat_kecil_obat'];
			$data2['racikan'] 		        = $lo['racikan'];
			$data2['tgl_keluar'] 	        = date('Y-m-d');
			$data2['nm_lengkap'] 	        = $lo['nm_lengkap'];

			
			$this->m_crud->simpan('brg_apotek_keluar_detail', $data2);

            $text = "UPDATE brg_apotek_keluar_header SET nm_lengkap= '$lo[nm_lengkap]' WHERE kd_trans_pelayanan = '$trans_id'";
            $d['sta_nama'] = $this->m_crud->manualQuery($text);

		endforeach;

        $text = "UPDATE pelayanan SET status='1' WHERE kd_trans_pelayanan = '$trans_id'";
        $d['sta'] = $this->m_crud->manualQuery($text);

        $text = "UPDATE pelayanan_obat SET sta_resep='Y' WHERE kd_trans_pelayanan = '$trans_id'";
        $d['sta_r'] = $this->m_crud->manualQuery($text);


    }	
	function simpanBayarTindakan()
	{
		$trans_id = $this->input->post('trans_id');
		
		$data['tgl_bayar']			= date('Y-m-d');
		$data['kd_bayar']			= $this->m_crud->MaxKodeBayarTindakan();
		
		//$data['nik']				= $lt['nik'];
		$data['nama_pasien']		= $this->input->post('bio_nama');
		
		$data['bayar']				= $this->input->post('bayar');
		$data['kembalian']			= $this->input->post('kembalian');
		$data['nopelayanan']		= $trans_id;
		$this->m_crud->simpan('btindakan_header', $data);
		
		
		
		$this->db->select('pelayanan_tindakan.*,tindakan.produk,tindakan.harga');
		$this->db->from('pelayanan_tindakan');
		$this->db->join('tindakan', 'pelayanan_tindakan.kd_produk = tindakan.kd_produk');
		$this->db->join('pelayanan','pelayanan_tindakan.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan');
		$this->db->where('pelayanan_tindakan.kd_trans_pelayanan', $trans_id);
		
		$list_obat = $this->db->get()->result_array();
		
		foreach($list_obat as $lo):
			$data2['tgl_bayar']		= date('Y-m-d');
			$data2['kd_bayar'] 		= $this->m_crud->MaxKodeBayarTindakan();
			$data2['kd_produk']		= $lo['kd_produk'];
			$data2['produk']		= $lo['produk'];
			$data2['jml'] 			= $lo['qty'];
			$data2['harga_jual'] 	= $lo['harga'];
			//$data2['nik']	 		= $lo[''];

			$this->m_crud->simpan('btindakan_detail', $data2);
		endforeach;
		
	}
	function simpanlisttindakan(){
		$ud['tgl_bayar'] 		= $this->m_crud->tgl_sql($this->input->post('tgl_bayar'));
		$ud['kd_bayar'] 		= $this->input->post('kd_bayar');
		$kd_trans	 		= $this->input->post('kd_pelayanan');
		$kd_pro		 		= $this->input->post('id');
		
		$tind = "SELECT
				pelayanan_tindakan.kd_trans_tindakan,
				pelayanan_tindakan.kd_trans_pelayanan,
				pelayanan_tindakan.qty,
				pelayanan_tindakan.kd_produk,
				tindakan.produk,
				tindakan.harga,
				pelayanan_tindakan.sta_bayar
				FROM
				pelayanan_tindakan
				INNER JOIN tindakan
				ON pelayanan_tindakan.kd_produk = tindakan.kd_produk
				WHERE pelayanan_tindakan.kd_trans_pelayanan='$kd_trans' AND pelayanan_tindakan.kd_produk = '$kd_pro'";
				
		$s = $this->m_crud->manualQuery($tind)->result();
		foreach( $s as $sa):
				$kd_produk = $sa->kd_produk;
				$jml = $sa->qty;
				$harga = $sa->harga;
				$produk = $sa->produk;
				$kd_trans_tindakan = $sa->kd_trans_tindakan;
		endforeach;
		
		$ud['kd_produk']		= $kd_produk;
		$ud['produk']			= $produk;
		$ud['jml'] 				= $jml;	
		$ud['harga_jual'] 		= str_replace(",","",$harga);			
		$ud['nik'] 				= $this->input->post('nik');
		
		$kd_bayar 			= $this->input->post('kd_bayar');
		$kd_produk			= $this->input->post('kd_produk');
		
		$text = "SELECT * FROM btindakan_detail WHERE kd_bayar='$kd_bayar' AND kd_produk='$kd_produk'";
		$hasil = $this->m_crud->manualQuery($text);
		if($hasil->num_rows()>0){
			$this->m_crud->updateData("btindakan_detail",$ud,$id_d);
		}else{
			$this->m_crud->insertData("btindakan_detail",$ud);
		}
		
		$update = "UPDATE pelayanan_tindakan SET sta_bayar = '1' WHERE kd_trans_tindakan = '$kd_trans_tindakan'";
		$this->m_crud->manualQuery($update);
	}
	
	/***Apotek Barang Masuk ***/
	
	function apotek()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'apotek';
			$data['page_title'] = 'Apotek';

			$pusk=$this->session->userdata('kd_puskesmas');
			$text = "SELECT * FROM puskesmas Where kd_puskesmas='$pusk' ";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$data['nm_puskesmas'] = $t->nm_puskesmas;
				
			}

            $textjml = "SELECT
                COUNT(obat.apotek_stok) AS jumlah,
                current_date() as tgl_sekarang, datediff(tgl_kadaluarsa, CURRENT_DATE()) as selisih
                FROM
                obat
                INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                WHERE obat.apotek_stok <> 0";

            $hasiljml =$this->m_crud->manualQuery($textjml);
            foreach($hasiljml->result() as $t){
                $data['jumlah'] = $t->jumlah;
            }
            $data['all_new_resep']	= $this->m_crud->get_all_new_resep();

			$this->template->display('apotek', $data);
		} else {
			redirect('login');
		}
		
	} 
	
	function apotek_masuk($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah' && $par2 == 'do_update') {
			
			
			redirect('barang/apotek_masuk', 'refresh');
			
		} else if ($par1 == 'tambah') {
			
			$data['tambah_barang_masuk_apotek'] = $this->m_crud->get_obat_by_id($par2);
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kodemasuk'] = $this->input->post('kodemasuk');
			$data['tgl_terima'] = $this->input->post('tgl_terima');
			$data['no_sbbk'] = $this->input->post('no_sbbk');
			
			$this->m_crud->perbaharui('kd_in', $par3, 'in', $data);
			$this->session->set_flashdata('flash_message', 'Data Barang Masuk berhasil diperbaharui!');
			redirect('barang/tambah', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_barang_masuk_apotek'] = $this->m_crud->get_apotek_masuk_by_id($par2);
		}
		
		if ($par1 == 'hapus') {
			$id = $this->uri->segment(4); // $this->input->post('id');
			
			$text = "SELECT * FROM brg_masuk_apotek_header WHERE kd_masuk='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM brg_masuk_apotek_detail
						WHERE kd_masuk='$id'";
				$this->m_crud->manualQuery($text);
				$text = "DELETE FROM brg_masuk_apotek_header WHERE kd_masuk='$id'";
				$this->m_crud->manualQuery($text);
				$this->session->set_flashdata('flash_message', 'Data Barang Masuk berhasil dihapus!');
				redirect('barang/apotek_masuk', 'refresh');
			}
		}
		
		
		$data['tgl_terima']			= date('d-m-Y');
		$data['kodemasuk']			= $this->m_crud->MaxKodeMasukApotek(); 
		$data['page_name']  			= 'inapotik';
		$data['page_title']	 		= 'Barang Masuk Apotek';
		$data['kd_obat']	 		= '';
		$data['sat_kecil_obat']			= '';
		$data['no_sbbk']	 		= '';
		$data['nama_obat']	 		= '';
		$data['no_batch']	 		= '';
		$data['tgl_kadaluarsa']	 		= date('d-m-Y');
		$data['jml']	 			= '';
		$data['total']	 			= '';
		
		
		$data['barang_masuk_apotek']		= $this->m_crud->get_all_masuk_apotek();
		$data['list_obat']			= $this->m_crud->get_list_obat('1');
		$data['list_satuan_kecil']		= $this->m_crud->get_list_sat_kecil();
		$data['masuk_apotek']			= $this->m_crud->get_all_barang_masuk_apotek();
		
		
			
		$this->template->display('apotek_masuk', $data);
		
	}
	
	function detailbarangapotek($par1 = '', $par2 = '', $par3 = '')
	{
		if($this->session->userdata('logged_in')!="")
			
			$id = $this->input->post('nomor');
			
			$text = "SELECT * FROM brg_masuk_apotek_detail WHERE kd_masuk='$id'";
			$d['data'] = $this->db->query($text);
			
			$data['page_name']  = 'detailbarangapotek';
			$data['page_title'] = 'Barang Apotek';
			
			$this->template->tampil('daftar_apotek_masuk',$d);
		
		
	}

	public function HapusDetailApotek()
	{
			$nomor = $this->uri->segment(3);//$exp[0];
			$kode = $this->uri->segment(4); //$exp[1];
			
			$id_usaha = $this->session->userdata('id');
			
			$text = "SELECT * FROM brg_masuk_apotek_detail,brg_masuk_apotek_header 
					WHERE brg_masuk_apotek_detail.kd_masuk= brg_masuk_apotek_header.kd_masuk AND
					brg_masuk_apotek_detail.kd_masuk='$nomor' AND brg_masuk_apotek_detail.kd_obat='$kode'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM brg_masuk_apotek_detail
					 WHERE 	kd_masuk='$nomor' AND kd_obat='$kode'";
				$this->m_crud->manualQuery($text);
			//echo "Data Sukses dihapus";
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/apotek_masuk/ubah/$nomor'>";			
			}else{
				echo "Tidak Ada data yang dapat dihapus";
			}
	}
	
	public function DataDetailApotek()
	{
			if (!$this->session->userdata('logged_in') == true)
			{
				redirect('login');
			}
			
			$id = $this->input->post('kode');
			
			$text = "SELECT * FROM brg_masuk_apotek_detail WHERE kd_masuk='$id'";
			$d['data'] = $this->db->query($text);
				
			$this->template->tampil_apotek('daftar_apotek_masuk',$d);
	
	}
	
	public function simpan_barang_masuk_apotek()
	{
			///////* simpan ke table header * ///////////////
			$tgl_terima 			= $this->input->post('tgl_terima');
			$tgl_tempo 			= $this->input->post('tgl_tempo');
			$tgl_kadaluarsa 		= $this->input->post('tgl_kadaluarsa');
		
			$up['kd_masuk'] 		= $this->input->post('kodemasuk');
			$up['no_sbbk'] 			= $this->input->post('nofaktur');
			$up['tgl_terima'] 		= $this->m_crud->tgl_sql($this->input->post('tglterima'));
			$up['tgl_kadaluarsa']		= $this->m_crud->tgl_sql($this->input->post('tgl_kadaluarsa')); 
			
			/////* simpan ke table detail *//////////////
			
			$ud['kd_masuk'] 		= $this->input->post('kodemasuk');
			$ud['kd_obat']			= $this->input->post('kd_obat');
			$ud['nama_obat']		= $this->input->post('nama_obat');
			$ud['jml'] 			= $this->input->post('jml');	
			$ud['sat_kecil_obat']		= $this->input->post('sat_kecil_obat');
			$ud['tgl_terima'] 		= $this->m_crud->tgl_sql($this->input->post('tglterima'));
			$ud['tgl_kadaluarsa']		= $this->m_crud->tgl_sql($this->input->post('tgl_kadaluarsa')); 
			
			
			$kd_masuk 			= $this->input->post('kodemasuk');
			$kd_obat 			= $this->input->post('kd_obat');
			
			$id['kd_masuk'] 		= $this->input->post('kodemasuk');
			
			$id_d['kodemasuk'] 		= $this->input->post('kd_masuk');
			$id_d['kd_obat'] 		= $this->input->post('kd_obat');
			
			///////////////////*  Update data Obat *//////////////////////
			$id_t['no_batch']		= $this->input->post('no_batch');
			$id_t['tgl_kadaluarsa']		= $this->m_crud->tgl_sql($this->input->post('tgl_kadaluarsa'));
			
			$hasil = $this->m_crud->getSelectedData("brg_masuk_apotek_header",$id);
			$row = $hasil->num_rows();
			if($row>0){
				$this->m_crud->updateData("brg_masuk_apotek_header",$up,$id);
				$text = "SELECT * FROM brg_masuk_apotek_detail WHERE kd_masuk='$kd_masuk' AND kd_obat='$kd_obat'";
				$hasil = $this->m_crud->manualQuery($text);
				if($hasil->num_rows()>0){
					$this->m_crud->updateData("brg_masuk_apotek_detail",$ud,$id_d);
				}else{
					$this->m_crud->insertData("brg_masuk_apotek_detail",$ud);
				}
				echo "Data sukses diubah";
				
				$text2 = "SELECT * FROM obat WHERE kd_obat='$kd_obat'";
				$hasil2 = $this->m_crud->manualQuery($text2);
				if($hasil2->num_rows()>0){
					$this->m_crud->updateData("obat",$id_t);
				}
				echo "Data sukses diubah";
				
				
			}else{
				$this->m_crud->insertData("brg_masuk_apotek_header",$up);
				$this->m_crud->insertData("brg_masuk_apotek_detail",$ud);
				echo "Data sukses disimpan";
				
				$text2 = "SELECT * FROM obat WHERE kd_obat='$kd_obat'";
				$hasil2 = $this->m_crud->manualQuery($text2);
				$this->m_crud->updateData("obat",$id_t);
				
			}
			
		
	}
	
	
	
	public function cetak_apotek()
	{
			$id = $this->uri->segment(3); //$this->session->userdata('id');
			$id_p = $this->session->userdata('id');
			
			$d['id'] = $id;
			
				
			$text = "SELECT *
					FROM brg_masuk_apotek_header 
					WHERE kd_masuk='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['tgl_terima'] = $this->m_crud->tgl_indo($t->tgl_terima);
				$d['kd_masuk'] = $t->kd_masuk;
			}
			
			$text = "SELECT sum(jml) as total
					FROM brg_masuk_apotek_detail 
					WHERE kd_masuk='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['total'] = $t->total;
			}
			
			$text = "SELECT *
					FROM brg_masuk_apotek_detail
					WHERE kd_masuk='$id'";

			$d['data'] = $this->m_crud->manualQuery($text);

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
        }


        $this->template->tampil_cetak_apotek('cetak_nota_apotek',$d);
							
			
	}
	
	
	
	/***MASTER BARANG APOTEK KELUAR ***/
	function apotek_keluar($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah' && $par2 == 'do_update') {
			
			
			redirect('barang/apotek_keluar', 'refresh');
			
		} else if ($par1 == 'tambah') {
			
			$data['keluar_stok_apotek'] = $this->m_crud->get_obat_by_id($par2);
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kodekeluar'] = $this->input->post('kodekeluar');
			$data['tgl_keluar'] = $this->input->post('tgl_keluar');
			$data['keterangan'] = $this->input->post('keterangan');
			
			$this->m_crud->perbaharui('kd_keluar', $par3, 'barang_apotek_keluar', $data);
			$this->session->set_flashdata('flash_message', 'Data obat keluar berhasil diperbaharui!');
			redirect('barang/apotek_keluar', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_keluar_apotek'] = $this->m_crud->get_apotek_keluar_by_id($par2);
		}
		
		if ($par1 == 'hapus') {
			$id = $this->uri->segment(4); // $this->input->post('id');
			
			$text = "SELECT * FROM brg_apotek_keluar_header WHERE kd_keluar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM brg_apotek_keluar_detail
						WHERE kd_keluar='$id'";
				$this->m_crud->manualQuery($text);
				$text = "DELETE FROM brg_apotek_keluar_header WHERE kd_keluar='$id'";
				$this->m_crud->manualQuery($text);
				//echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/gudang'>";
				$this->session->set_flashdata('flash_message', 'Data obat keluar berhasil dihapus!');
				redirect('barang/apotek_keluar', 'refresh');
			}
		}
		
		if ($par1 == 'cetak_resep'){
			$id = $this->uri->segment(4);
			redirect('cont_transaksi_pelayanan/cetak_resep/'.$id);
		}
		
		
		$data['tgl_keluar']			= date('d-m-Y');
		$data['kodekeluar']			= $this->m_crud->MaxKodeKeluarApotek(); 
		$data['page_name']  		= 'barang_keluar_apotek';
		$data['page_title']	 		= 'Barang Keluar Apotek';
		$data['kd_obat']	 		= '';
		$data['kd_resep']	 		= '';
		$data['sat_kecil_obat']		= '';
		$data['keterangan']	 		= '';
		$data['nama_obat']	 		= '';
		$data['nm_lengkap']			= '';
		$data['jml']	 			= '';
		$data['total']	 			= '';
		
		
		//$data['list_milik_obat'] 	= $this->m_crud->get_list_milik_obat('1');
		$data['list_unit_farmasi'] 	= $this->m_crud->get_list_unit_farmasi('1');
		$data['apotek_keluar']		= $this->m_crud->get_all_apotek_keluar();
		$data['list_obat']		= $this->m_crud->get_list_obat('1');
		$data['list_satuan_kecil']	= $this->m_crud->get_list_sat_kecil();
        $data['all_new_resep']	= $this->m_crud->get_all_new_resep();
				
		$this->template->display('apotek_keluar', $data);
		
	}
	
	
	
	function detailobatkeluar($par1 = '', $par2 = '', $par3 = '')
	{
		if($this->session->userdata('logged_in')!="")
			
			$id = $this->input->post('nomor');
			
			$text = "SELECT * FROM brg_apotek_keluar_detail WHERE kd_jual='$id'";
			$d['data'] = $this->db->query($text);
			
			$data['page_name']  = 'detailapotek';
			$data['page_title'] = 'Barang Apotek';
			
			$this->template->tampil('apotek_keluar',$d);
		
		
	}
	
	public function DataDetailApotekKeluar()
	{
			if (!$this->session->userdata('logged_in') == true)
			{
				redirect('login');
			}
			
			$id = $this->input->post('kode');
			
			$text = "SELECT * FROM brg_apotek_keluar_detail WHERE kd_keluar='$id'";
			$d['data'] = $this->db->query($text);
				
			$this->template->tampil_keluar_apotek('daftar_keluar_apotek',$d);
	
	}
	
	public function SimpanKeluarApotek()
	{
			///////* simpan ke table header * ///////////////
			$tgl_keluar 			= $this->input->post('tgl_keluar');
			
			$up['kd_keluar'] 		= $this->input->post('kodekeluar');
			$up['tgl_keluar'] 		= $this->m_crud->tgl_sql($this->input->post('tglkeluar'));
			$up['kd_unit_farmasi'] 		= $this->input->post('kd_unit_farmasi');
			$up['keterangan'] 		= $this->input->post('keterangan');
			
			/////* simpan ke table detail *//////////////
			
			$ud['kd_keluar'] 		= $this->input->post('kodekeluar');
			$ud['kd_obat']			= $this->input->post('kd_obat');
			$ud['nama_obat']		= $this->input->post('nama_obat');
			$ud['jml'] 			= $this->input->post('jml');	
			$ud['sat_kecil_obat']		= $this->input->post('sat_kecil_obat');
			$ud['tgl_keluar'] 		= $this->m_crud->tgl_sql($this->input->post('tglkeluar'));
			
			
			$kd_keluar 			= $this->input->post('kodekeluar');
			$kd_obat 			= $this->input->post('kd_obat');
			
			$id['kd_keluar'] 		= $this->input->post('kodekeluar');
			
			$id_d['kd_keluar'] 		= $this->input->post('kodekeluar');
			$id_d['kd_obat'] 		= $this->input->post('kd_obat');
			
			$hasil = $this->m_crud->getSelectedData("brg_apotek_keluar_header",$id);
			$row = $hasil->num_rows();
			if($row>0){
				$this->m_crud->updateData("brg_apotek_keluar_header",$up,$id);
				$text = "SELECT * FROM brg_apotek_keluar_detail WHERE kd_keluar='$kd_keluar' AND kd_obat='$kd_obat'";
				$hasil = $this->m_crud->manualQuery($text);
				if($hasil->num_rows()>0){
					$this->m_crud->updateData("brg_apotek_keluar_detail",$ud,$id_d);
				}else{
					$this->m_crud->insertData("brg_apotek_keluar_detail",$ud);
				}
				echo "Data sukses diubah";
			}else{
				$this->m_crud->insertData("brg_apotek_keluar_header",$up);
				$this->m_crud->insertData("brg_apotek_keluar_detail",$ud);
				echo "Data sukses disimpan";
				
			}
			
		
	}	
	public function HapusDetailKeluarApotek()
	{
			$nomor = $this->uri->segment(3);//$exp[0];
			$kode = $this->uri->segment(4); //$exp[1];
			
			$id_usaha = $this->session->userdata('id');
			
			$text = "SELECT * FROM brg_apotek_keluar_detail,brg_apotek_keluar_header 
					WHERE brg_apotek_keluar_detail.kd_keluar=brg_apotek_keluar_header.kd_keluar AND
					brg_apotek_keluar_detail.kd_keluar='$nomor' AND brg_apotek_keluar_detail.kd_obat='$kode'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM brg_apotek_keluar_detail
					 WHERE 	kd_keluar='$nomor' AND kd_obat='$kode'";
				$this->m_crud->manualQuery($text);
			//echo "Data Sukses dihapus";
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/apotek_keluar/ubah/$nomor'>";			
			}else{
				echo "Tidak Ada data yang dapat dihapus";
			}
	}
	
	public function cetak_keluar_apotek()
	{
			$id = $this->uri->segment(3); //$this->session->userdata('id');
			$id_p = $this->session->userdata('id');
			
			$d['id'] = $id;
            $d['operator'] = $this->session->userdata('nama');
				
			$text = "SELECT
                    brg_apotek_keluar_header.id_keluar,
                    brg_apotek_keluar_header.kd_keluar,
                    brg_apotek_keluar_header.tgl_keluar,
                    brg_apotek_keluar_header.keterangan,
                    brg_apotek_keluar_header.kd_unit_farmasi,
                    brg_apotek_keluar_header.kd_trans_pelayanan,
                    pasien.nm_lengkap,
                    pasien.alamat,
                    pasien.no_hp,
		    pasien.umur,
		    pasien.kd_bayar,
		    pasien.no_reg,
                    kecamatan.nm_kecamatan,
                    kota.nm_kota,
                    pasien.kd_pos
                    FROM brg_apotek_keluar_header
                    LEFT JOIN pelayanan ON brg_apotek_keluar_header.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan
                    LEFT JOIN pasien ON pelayanan.kd_rekam_medis = pasien.kd_rekam_medis
                    LEFT JOIN kecamatan ON pasien.kd_kecamatan = kecamatan.kd_kecamatan
                    LEFT JOIN kota ON pasien.kd_kota = kota.kd_kota
                    WHERE brg_apotek_keluar_header.kd_keluar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['tgl_keluar'] = $this->m_crud->tgl_indo($t->tgl_keluar);
                $d['nm_lengkap'] = $t->nm_lengkap;
                $d['alamat_pasien']     = $t->alamat;
                $d['no_hp']      = $t->no_hp;
		$d['umur']	= $t->umur;
		$d['no_reg']	= $t->no_reg;
		$d['kd_bayar']  = $t->kd_bayar;
                $d['nm_kecamatan']= $t->nm_kecamatan;
                $d['nm_kota']    = $t->nm_kota;
                $d['kd_pos']     = $t->kd_pos;
			}
			
			$text = "SELECT sum(jml*harga_beli) as total
					FROM brg_apotek_keluar_detail 
					WHERE kd_keluar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['total'] = $t->total;
			}
			
			$text = "SELECT brg_apotek_keluar_detail.id_keluar,brg_apotek_keluar_detail.kd_keluar,brg_apotek_keluar_detail.kd_obat,brg_apotek_keluar_detail.nama_obat,
            brg_apotek_keluar_detail.jml,brg_apotek_keluar_detail.harga_beli,brg_apotek_keluar_detail.sat_kecil_obat,brg_apotek_keluar_detail.tgl_keluar,
            brg_apotek_keluar_detail.kd_milik_obat,brg_apotek_keluar_detail.racikan,brg_apotek_keluar_detail.kd_trans_pelayanan,pelayanan_obat.dosis
          FROM brg_apotek_keluar_detail LEFT JOIN pelayanan_obat ON brg_apotek_keluar_detail.kd_trans_pelayanan = pelayanan_obat.kd_trans_pelayanan
					WHERE brg_apotek_keluar_detail.kd_keluar='$id'";
			
			$d['data'] = $this->m_crud->manualQuery($text);

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
            $d['logo']          = $t->logo;
            $d['telp']          = $t->telp;
        }
			
			
			$this->template->tampil_cetak_apotek_keluar('cetak_nota_apotek_keluar',$d);
							
			
	}	
/////////////////////// LAPORAN DETAIL GUDANG IN  ////////////////////////
	
	function lap_gudang_per_tgl()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Transaksi Barang Masuk Per Tanggal';
			
			$this->template->display('../cetak/lap_brg_masuk_tgl', $data);
		} else {
			redirect('login');
		}
		
	}
	
	public function lihat_gudang()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));
			
			$where = " WHERE a.tgl_terima BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
			$text = "select a.kd_masuk,a.tgl_terima,a.kd_milik_obat,
			b.kd_obat,b.nama_obat,b.jml
			FROM brg_masuk_header as a
			JOIN brg_masuk_detail as b
			ON a.kd_masuk=b.kd_masuk
			$where ORDER BY a.kd_masuk,b.kd_masuk";
			$d['data'] = $this->db->query($text);
			
			
			$this->template->tampil_lap_brg_masuk('daftar_lap_brg_masuk',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_lap_gudang()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));
			
			$where = " WHERE a.tgl_terima BETWEEN '$tgl1' AND '$tgl2'";
			$text = "select a.kd_masuk,a.tgl_terima, 
			b.kd_obat,b.nama_obat,b.jml, b.kd_milik_obat
			FROM brg_masuk_header as a
			JOIN brg_masuk_detail as b
			ON a.kd_masuk=b.kd_masuk
			$where ORDER BY a.kd_masuk";
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
                $d['logo']          = $t->logo;
			}

			$this->template->tampil_cetak_lap_brg_masuk('cetak_lap_brg_masuk',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
////////////////  LAPORAN SUMMARY GUDANG IN PER TANGGAL ////////////////////////////////////////

	function lap_sum_per_tgl_gudang_in()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Summary Gudang Masuk Per Tanggal';
			
			$this->template->display('../cetak/lap_summary_gudang_tgl_in', $data);
		} else {
			redirect('login');
		}
		
	} 
	
	public function lihat_sum_gudang_in()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));
			
			$where = " WHERE a.tgl_terima BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
			$text = "select a.kd_masuk,a.tgl_terima,a.kd_milik_obat
			FROM brg_masuk_header as a
			JOIN brg_masuk_detail as b
			ON a.kd_masuk=b.kd_masuk
			$where GROUP BY a.kd_masuk";
			$d['data'] = $this->db->query($text);
			
			$this->template->tampil_lap_summary_gudang_in('daftar_lap_summary_gudang_in',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_sum_gudang_in()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));
			
			$where = " WHERE a.tgl_terima BETWEEN '$tgl1' AND '$tgl2'";
			$text = "select a.kd_masuk,a.tgl_terima,a.kd_milik_obat, b.jml
			FROM brg_masuk_header as a
			JOIN brg_masuk_detail as b
			ON a.kd_masuk=b.kd_masuk
			$where GROUP BY a.kd_masuk";
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
                $d['logo']          = $t->logo;
            }

			$this->template->tampil_cetak_lap_summary_gudang_in('cetak_lap_summary_gudang_in',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}

/////////////////////// LAPORAN DETAIL GUDANG OUT  ////////////////////////
	
	function lap_gudang_out_per_tgl()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Transaksi Gudang Keluar Per Tanggal';
			
			$this->template->display('../cetak/lap_brg_keluar_tgl', $data);
		} else {
			redirect('login');
		}
		
	}
	
	public function lihat_gudang_out()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));
			
			$where = " WHERE a.tgl_keluar BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
			$text = "select a.kd_keluar,a.tgl_keluar,a.kd_unit_farmasi,
			b.kd_obat,b.nama_obat,b.jml
			FROM barang_keluar_header as a
			JOIN barang_keluar_detail as b
			ON a.kd_keluar=b.kd_keluar
			$where ORDER BY a.kd_keluar,b.kd_keluar";
			$d['data'] = $this->db->query($text);
			
			
			$this->template->tampil_lap_brg_keluar('daftar_lap_brg_keluar',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_lap_gudang_out()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));

            $where = " WHERE barang_keluar_header.tgl_keluar BETWEEN '$tgl1' AND '$tgl2'";
            $text = "SELECT barang_keluar_header.kd_keluar,barang_keluar_header.tgl_keluar,barang_keluar_header.kd_unit_farmasi,
                barang_keluar_detail.jml,unit_farmasi.nama_unit_farmasi,barang_keluar_detail.kd_obat,barang_keluar_detail.nama_obat
                FROM barang_keluar_header
                LEFT JOIN barang_keluar_detail ON barang_keluar_detail.kd_keluar = barang_keluar_header.kd_keluar
                INNER JOIN unit_farmasi ON unit_farmasi.kd_unit_farmasi = barang_keluar_header.kd_unit_farmasi
			$where";
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
            }

			$this->template->tampil_cetak_lap_brg_keluar('cetak_lap_brg_keluar',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	

	
////////////////  LAPORAN SUMMARY GUDANG OUT PER TANGGAL ////////////////////////////////////////

	function lap_sum_per_tgl_gudang_out()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Summary Gudang Keluar Per Tanggal';
			
			$this->template->display('../cetak/lap_summary_gudang_tgl_out', $data);
		} else {
			redirect('login');
		}
		
	} 
	
	public function lihat_sum_gudang_out()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));
			
			$where = " WHERE a.tgl_keluar BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
			$text = "select a.kd_keluar,a.tgl_keluar,a.kd_unit_farmasi
			FROM barang_keluar_header as a
			JOIN barang_keluar_detail as b
			ON a.kd_keluar=b.kd_keluar
			$where GROUP BY a.kd_keluar";
			$d['data'] = $this->db->query($text);
			
			$this->template->tampil_lap_summary_gudang_out('daftar_lap_summary_gudang_keluar',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_sum_gudang_out()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));
			
			$where = " WHERE barang_keluar_header.tgl_keluar BETWEEN '$tgl1' AND '$tgl2'";
			$text = "SELECT barang_keluar_header.kd_keluar,barang_keluar_header.tgl_keluar,barang_keluar_header.kd_unit_farmasi,
                barang_keluar_detail.jml,unit_farmasi.nama_unit_farmasi FROM barang_keluar_header
                LEFT JOIN barang_keluar_detail ON barang_keluar_detail.kd_keluar = barang_keluar_header.kd_keluar
                INNER JOIN unit_farmasi ON unit_farmasi.kd_unit_farmasi = barang_keluar_header.kd_unit_farmasi
			$where GROUP BY barang_keluar_header.kd_keluar";
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
            }

			$this->template->tampil_cetak_lap_summary_gudang_out('cetak_lap_summary_gudang_out',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
/////////////////////// LAPORAN DETAIL APOTEK IN  ////////////////////////
	
	function lap_apotek_per_tgl()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Transaksi Apotek Masuk Per Tanggal';
			
			$this->template->display('../cetak/lap_apotek_masuk_detail_tgl', $data);
		} else {
			redirect('login');
		}
		
	}
	
	public function lihat_apotek()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));
			
			$where = " WHERE brg_masuk_apotek_header.tgl_terima BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
                    $text = "SELECT
                    brg_masuk_apotek_header.tgl_terima,
                    brg_masuk_apotek_header.kd_masuk,
                    brg_masuk_apotek_header.no_sbbk,
                    brg_masuk_apotek_header.tgl_kadaluarsa,
                    brg_masuk_apotek_detail.kd_obat,
                    brg_masuk_apotek_detail.jml,
                    obat.nama_obat,
                    obat.kd_sat_kecil_obat,
                    obat.tgl_kadaluarsa,
                    obat.apotek_stok,
                    satuan_kecil.sat_kecil_obat
                    FROM
                    brg_masuk_apotek_header
                    INNER JOIN brg_masuk_apotek_detail ON brg_masuk_apotek_header.kd_masuk = brg_masuk_apotek_detail.kd_masuk
                    INNER JOIN obat ON brg_masuk_apotek_detail.kd_obat = obat.kd_obat
                    INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                    $where ORDER BY brg_masuk_apotek_header.kd_masuk";	

	            $d['data'] = $this->db->query($text);
			
			
			$this->template->tampil_lap_apotek_masuk('daftar_lap_apotek_masuk',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_lap_apotek()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));

            $where = " WHERE brg_masuk_apotek_header.tgl_terima BETWEEN '$tgl1' AND '$tgl2'";
            $text = "SELECT
                    brg_masuk_apotek_header.tgl_terima,
                    brg_masuk_apotek_header.kd_masuk,
                    brg_masuk_apotek_header.no_sbbk,
                    brg_masuk_apotek_header.tgl_kadaluarsa,
                    brg_masuk_apotek_detail.kd_obat,
                    brg_masuk_apotek_detail.jml,
                    obat.nama_obat,
                    obat.kd_sat_kecil_obat,
                    obat.tgl_kadaluarsa,
                    obat.apotek_stok,
                    satuan_kecil.sat_kecil_obat
                    FROM
                    brg_masuk_apotek_header
                    INNER JOIN brg_masuk_apotek_detail ON brg_masuk_apotek_header.kd_masuk = brg_masuk_apotek_detail.kd_masuk
                    INNER JOIN obat ON brg_masuk_apotek_detail.kd_obat = obat.kd_obat
                    INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
			$where ORDER BY brg_masuk_apotek_header.kd_masuk";

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
            }

			$this->template->tampil_cetak_lap_apotek_masuk('cetak_lap_apotek_masuk',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	
	public function lihat_apotek_keluar()
    {
        $cek = $this->session->userdata('logged_in');
        if(!empty($cek)){

            $data['apotek_keluar']		= $this->m_crud->get_all_apotek_keluar();

            $this->load->view('laporan/view_apotek_keluar',$data);
        }else{
            header('location:'.base_url());
        }
    }
////////////////  LAPORAN SUMMARY APOTEK IN PER TANGGAL ////////////////////////////////////////

	function lap_sum_per_tgl_apotek_in()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Summary Gudang Masuk Per Tanggal';
			
			$this->template->display('../cetak/lap_summary_apotek_tgl_in', $data);
		} else {
			redirect('login');
		}
		
	} 
	
	public function lihat_sum_apotek_in()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));
			
			$where = " WHERE a.tgl_terima BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
			$text = "select a.kd_masuk,a.tgl_terima
			FROM brg_masuk_apotek_header as a
			JOIN brg_masuk_apotek_detail as b
			ON a.kd_masuk=b.kd_masuk
			$where GROUP BY a.kd_masuk";
			$d['data'] = $this->db->query($text);
			
			$this->template->tampil_lap_summary_apotek_in('daftar_lap_summary_apotek_in',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_sum_apotek_in()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));

            $where = " WHERE brg_masuk_apotek_header.tgl_terima BETWEEN '$tgl1' AND '$tgl2'";
            $text = "SELECT
                    brg_masuk_apotek_header.tgl_terima,
                    brg_masuk_apotek_header.kd_masuk,
                    brg_masuk_apotek_header.no_sbbk,
                    brg_masuk_apotek_header.tgl_kadaluarsa,
                    brg_masuk_apotek_detail.kd_obat,
                    brg_masuk_apotek_detail.jml,
                    obat.nama_obat,
                    obat.kd_sat_kecil_obat,
                    obat.tgl_kadaluarsa,
                    obat.apotek_stok,
                    satuan_kecil.sat_kecil_obat
                    FROM
                    brg_masuk_apotek_header
                    INNER JOIN brg_masuk_apotek_detail ON brg_masuk_apotek_header.kd_masuk = brg_masuk_apotek_detail.kd_masuk
                    INNER JOIN obat ON brg_masuk_apotek_detail.kd_obat = obat.kd_obat
                    INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
			$where GROUP BY brg_masuk_apotek_header.kd_masuk";

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
            }
			$this->template->tampil_cetak_lap_summary_apotek_in('cetak_lap_summary_apotek_in',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
		
/////////////////////// LAPORAN DETAIL APOTEK OUT  ////////////////////////
	
	function lap_apotek_out_per_tgl()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Transaksi Apotek Keluar Per Tanggal';
			
			$this->template->display('../cetak/lap_apotek_keluar_tgl', $data);
		} else {
			redirect('login');
		}
		
	}
	
	public function lihat_apotek_out()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));
			
			$where = " WHERE brg_apotek_keluar_header.tgl_keluar BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
            $text = "SELECT
                    brg_apotek_keluar_header.id_keluar,
                    brg_apotek_keluar_header.kd_keluar,
                    brg_apotek_keluar_header.tgl_keluar,
                    brg_apotek_keluar_detail.kd_obat,
                    brg_apotek_keluar_detail.jml,
                    obat.nama_obat,
                    obat.kd_sat_kecil_obat,
                    satuan_kecil.sat_kecil_obat
                    FROM
                    brg_apotek_keluar_header
                    LEFT JOIN brg_apotek_keluar_detail ON brg_apotek_keluar_header.kd_keluar = brg_apotek_keluar_detail.kd_keluar
                    LEFT JOIN obat ON brg_apotek_keluar_detail.kd_obat = obat.kd_obat
                    LEFT JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                    $where ORDER BY brg_apotek_keluar_header.kd_keluar";			
			$d['data'] = $this->db->query($text);
			
			
			$this->template->tampil_lap_apotek_keluar('daftar_lap_apotek_keluar',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_lap_apotek_out()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));
			
			$where = " WHERE brg_apotek_keluar_header.tgl_keluar BETWEEN '$tgl1' AND '$tgl2'";
            	    $text = "SELECT
                    brg_apotek_keluar_header.id_keluar,
                    brg_apotek_keluar_header.kd_keluar,
                    brg_apotek_keluar_header.tgl_keluar,
                    brg_apotek_keluar_detail.kd_obat,
                    brg_apotek_keluar_detail.jml,
                    obat.nama_obat,
                    obat.kd_sat_kecil_obat,
                    satuan_kecil.sat_kecil_obat
                    FROM
                    brg_apotek_keluar_header
                    LEFT JOIN brg_apotek_keluar_detail ON brg_apotek_keluar_header.kd_keluar = brg_apotek_keluar_detail.kd_keluar
                    LEFT JOIN obat ON brg_apotek_keluar_detail.kd_obat = obat.kd_obat
                    LEFT JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                    $where ORDER BY brg_apotek_keluar_header.kd_keluar";			
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
            }
			$this->template->tampil_cetak_lap_apotek_keluar('cetak_lap_apotek_keluar',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
////////////////  LAPORAN SUMMARY APOTEK OUT PER TANGGAL ////////////////////////////////////////

	function lap_sum_per_tgl_apotek_out()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'Laporan';
			$data['page_title'] = 'Laporan Summary Apotek Keluar Per Tanggal';
			
			$this->template->display('../cetak/lap_summary_apotek_tgl_out', $data);
		} else {
			redirect('login');
		}
		
	} 
	
	public function lihat_sum_apotek_out()
	{
		if($this->session->userdata('logged_in')!="")
		{
			$tgl_mulai= $this->m_crud->tgl_sql($this->input->post('tgl_mulai'));
			$tgl_akhir = $this->m_crud->tgl_sql($this->input->post('tgl_akhir'));

            $where = " WHERE a.tgl_keluar BETWEEN '$tgl_mulai' AND '$tgl_akhir'";
            $text = "select a.kd_keluar,a.tgl_keluar,a.kd_unit_farmasi
			FROM brg_apotek_keluar_header as a
			JOIN brg_apotek_keluar_detail as b
			ON a.kd_keluar=b.kd_keluar
			$where GROUP BY a.kd_keluar";
		    $d['data'] = $this->db->query($text);
			
			
			$this->template->tampil_lap_summary_apotek_out('daftar_lap_summary_apotek_keluar',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_sum_apotek_out()
	{
		if($this->session->userdata('logged_in')!="")
		{
			
			$tgl1 = $this->m_crud->tgl_sql($this->uri->segment(3));
			$tgl2 = $this->m_crud->tgl_sql($this->uri->segment(4));
			
			$where = " WHERE brg_apotek_keluar_header.tgl_keluar BETWEEN '$tgl1' AND '$tgl2'";
            	    $text = "SELECT brg_apotek_keluar_header.kd_keluar,brg_apotek_keluar_header.tgl_keluar,brg_apotek_keluar_detail.jml
                      FROM brg_apotek_keluar_header
                      INNER JOIN brg_apotek_keluar_detail ON brg_apotek_keluar_header.kd_keluar = brg_apotek_keluar_detail.kd_keluar
                      $where GROUP BY brg_apotek_keluar_header.kd_keluar";

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
            }

			$this->template->tampil_cetak_lap_summary_apotek_out('cetak_lap_summary_apotek_out',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}

//////////////////////////*  STOK OBAT DI GUDANG  *//////////////////////////////////	
	function stok_gudang()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'stok';
			$data['page_title'] = 'Stok Obat Gudang';
			
			$data['list_obat']		= $this->m_crud->get_list_obat('1');
			
			$this->template->display('stok_obat_gudang', $data);
		} else {
			redirect('login');
		}
		
	}
	
	public function lihat()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

			$text = "SELECT
                        obat.kd_obat,
                        obat.nama_obat,
                        golongan_obat.gol_obat,
                        satuan_kecil.sat_kecil_obat,
                        obat.obat_stok,
                        obat.tgl_kadaluarsa
                        FROM
                        obat
                        INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                        INNER JOIN golongan_obat ON obat.kd_gol_obat = golongan_obat.kd_gol_obat
                        ORDER BY kd_obat ASC";

			$data['obat'] = $this->m_crud->manualQuery($text);

			$this->load->view('laporan/view_gudang',$data);
		}else{
			header('location:'.base_url());
		}
	}
	
	public function cetak_obat_gudang()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$pilih = $this->uri->segment(3);
			
			if($pilih=='all'){
				$where = ' ';
				$d['filter']="Semua Data";
			
			}

			$d['judul']="Laporan Data OBAT";
			
			$text = "SELECT * FROM obat
					ORDER BY kd_obat ASC ";
			$d['data'] = $this->m_crud->manualQuery($text);
			$d['obat']	= $this->m_crud->get_all_obat();
			
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
			}
			
			$this->load->view('laporan/cetak',$d);
		}else{
			header('location:'.base_url());
		}
	}

//////////////////////////*  STOK OBAT EXPIRED DI GUDANG  *//////////////////////////////////	
	
	function stok_gudang_expired()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  = 'stok';
			$data['page_title'] = 'Stok Obat Gudang Expired';
			
			$data['list_obat']		= $this->m_crud->get_list_obat('1');
			
			$this->template->display('stok_obat_gudang_expired', $data);
		} else {
			redirect('login');
		}
		
	}
	public function lihat_expired()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$text = "SELECT
                    obat.kd_obat,
                    obat.nama_obat,
                    obat.kd_gol_obat,
                    obat.kd_sat_kecil_obat,
                    obat.kd_milik_obat,
                    obat.obat_stok,
                    satuan_kecil.sat_kecil_obat,
                    obat.tgl_kadaluarsa, current_date() as tgl_sekarang, datediff(tgl_kadaluarsa, CURRENT_DATE()) as selisih
                    FROM
                    obat
                    INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                    WHERE obat.obat_stok <> 0 ORDER BY selisih";

			$d['data'] = $this->m_crud->manualQuery($text);
			
			
			$this->load->view('laporan/view-expired',$d);
		}
		else
		{
			header('location:'.base_url().'index.php/login');
		}
	}
	
	public function cetak_obat_gudang_expired()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$pilih = $this->uri->segment(3);
			
			if($pilih=='all'){
				$where = ' ';
				$d['filter']="Semua Data";
			
			}

			$d['judul']="Laporan Data OBAT";
			
			$text = "SELECT
                    obat.kd_obat,
                    obat.nama_obat,
                    obat.kd_gol_obat,
                    obat.kd_sat_kecil_obat,
                    obat.kd_milik_obat,
                    obat.obat_stok,
                    satuan_kecil.sat_kecil_obat,
                    obat.tgl_kadaluarsa, current_date() as tgl_sekarang, datediff(tgl_kadaluarsa, CURRENT_DATE()) as selisih
                    FROM
                    obat
                    INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                    WHERE obat.obat_stok <> 0 ORDER BY selisih";
			$d['data'] = $this->m_crud->manualQuery($text);

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
				$d['logo']          = $t->logo;
			}
			
			$this->load->view('laporan/cetak_gudang_expired',$d);
		}else{
			header('location:'.base_url());
		}
	}

    //////////////////////////*  STOK OBAT EXPIRED DI APOTEK  *//////////////////////////////////

    function stok_apotek_expired()
    {
        if ($this->session->userdata('logged_in') == true)
        {
            $data['page_name']  = 'stok';
            $data['page_title'] = 'Stok Obat Gudang Apotek';

            $data['list_obat']		= $this->m_crud->get_list_obat('1');

            $this->template->display('stok_obat_apotek_expired', $data);
        } else {
            redirect('login');
        }

    }
    public function lihat_expired_apotek()
    {
        if ($this->session->userdata('logged_in') == true)
        {
            $text = "SELECT
                    obat.kd_obat,
                    obat.nama_obat,
                    obat.kd_gol_obat,
                    obat.kd_sat_kecil_obat,
                    obat.kd_milik_obat,
                    obat.apotek_stok,
                    satuan_kecil.sat_kecil_obat,
                    obat.tgl_kadaluarsa, current_date() as tgl_sekarang, datediff(tgl_kadaluarsa, CURRENT_DATE()) as selisih
                    FROM
                    obat
                    INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                    WHERE obat.apotek_stok <> 0 ORDER BY selisih";

            $d['data'] = $this->m_crud->manualQuery($text);


            $this->load->view('laporan/view_apotek_expired',$d);
        }
        else
        {
            header('location:'.base_url().'index.php/login');
        }
    }

    public function cetak_obat_apotek_expired()
    {
        $cek = $this->session->userdata('logged_in');
        if(!empty($cek)){
            $pilih = $this->uri->segment(3);

            if($pilih=='all'){
                $where = ' ';
                $d['filter']="Semua Data";

            }

            $d['judul']="Laporan Data OBAT";

            $text = "SELECT
                    obat.kd_obat,
                    obat.nama_obat,
                    obat.kd_gol_obat,
                    obat.kd_sat_kecil_obat,
                    obat.kd_milik_obat,
                    obat.apotek_stok,
                    satuan_kecil.sat_kecil_obat,
                    obat.tgl_kadaluarsa, current_date() as tgl_sekarang, datediff(tgl_kadaluarsa, CURRENT_DATE()) as selisih
                    FROM
                    obat
                    INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                    WHERE obat.apotek_stok <> 0 ORDER BY selisih";
            $d['data'] = $this->m_crud->manualQuery($text);

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
            }

            $this->load->view('laporan/cetak_apotek_expired',$d);
        }else{
            header('location:'.base_url());
        }
    }


//////////////////////////*  STOK OBAT DI APOTEK  *//////////////////////////////////	
	function stok_apotek()
	{
		if ($this->session->userdata('logged_in') == true)
		{
			$data['page_name']  	= 'stok';
			$data['page_title'] 	= 'Stok Obat Apotek';
			
			$data['list_obat']	= $this->m_crud->get_list_obat('1');
			
			$this->template->display('stok_obat_apotek', $data);
		} else {
			redirect('login');
		}
		
	}
	
	public function lihat_stok_apotek()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){

            $text = "SELECT
                        obat.kd_obat,
                        obat.nama_obat,
                        golongan_obat.gol_obat,
                        satuan_kecil.sat_kecil_obat,
                        obat.apotek_stok,
                        obat.tgl_kadaluarsa
                        FROM
                        obat
                        INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
                        INNER JOIN golongan_obat ON obat.kd_gol_obat = golongan_obat.kd_gol_obat
                        ORDER BY kd_obat ASC";

            $data['obat'] = $this->m_crud->manualQuery($text);
			
			$this->load->view('laporan/view_apotek',$data);
		}else{
			header('location:'.base_url());
		}
	}

	public function cetak_obat_apotek()
	{
		$cek = $this->session->userdata('logged_in');
		if(!empty($cek)){
			$pilih = $this->uri->segment(3);
			
			if($pilih=='all'){
				$where = ' ';
				$d['filter']="Semua Data";
			
			}

			$d['judul']="Laporan Data OBAT";
			
			$text = "SELECT * FROM obat  
					ORDER BY kd_obat ASC ";
			$d['data'] = $this->m_crud->manualQuery($text);
			$d['obat']	= $this->m_crud->get_all_obat();

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
            }


            $this->load->view('laporan/cetak_apotek',$d);
		}else{
			header('location:'.base_url());
		}
	}

    /* ----------------- Stock Opname GUDANG --------------------------*/

    function sopname($par1 = '', $par2 = '', $par3 = '')
    {
        if (!$this->session->userdata('logged_in') == true)
        {
            redirect('login');
        }

        if ($par1 == 'tambah' && $par2 == 'do_update') {


            redirect('barang/sopname', 'refresh');

        } else if ($par1 == 'tambah') {

            $data['tambah_stok_opname'] = $this->m_crud->get_obat_by_id($par2);
        }
        if ($par1 == 'ubah' && $par2 == 'do_update') {
            $data['opname_code']    = $this->input->post('code');
            $data['opname_tgl']     = $this->input->post('opname_tgl');

            $this->session->set_flashdata('flash_message', 'Data Stok Opname berhasil diperbaharui!');
            redirect('barang/sopname', 'refresh');

        } else if ($par1 == 'ubah') {
            $data['edit_stok_opname'] = $this->m_crud->get_opname_by_id($par2);
        }

        if ($par1 == 'hapus') {
            $id = $this->uri->segment(4); // $this->input->post('id');

            $text = "SELECT * FROM opname_header WHERE opname_code='$id'";
            $hasil = $this->m_crud->manualQuery($text);
            if($hasil->num_rows()>0){
                $text = "DELETE FROM opname_detail
						WHERE opname_code='$id'";
                $this->m_crud->manualQuery($text);
                $text = "DELETE FROM opname_header WHERE opname_code='$id'";
                $this->m_crud->manualQuery($text);
                $this->session->set_flashdata('flash_message', 'Data Stok Opname Gudang berhasil dihapus!');
                redirect('barang/sopname', 'refresh');
            }
        }


        $data['opname_tgl']			= date('d-m-Y');
        $data['code']		        = $this->m_crud->MaxKodeOpnameGudang();
        $data['page_name']  		= 'opname';
        $data['page_title']	 		= 'Stok Opname';
        $data['kd_obat']	 		= '';
        $data['sat_kecil_obat']		= '';
        $data['onhand']	 		    = '';
        $data['nama_obat']	 		= '';
        $data['tgl_kadaluarsa']	 	= date('d-m-Y');
        $data['jml']	 			= '';
        $data['selisih']	 			= '';

        $data['opname_gudang']	        = $this->m_crud->get_all_opname();
        $data['list_obat']			    = $this->m_crud->get_list_obat('1');
        $data['list_satuan_kecil']		= $this->m_crud->get_list_sat_kecil();


        $this->template->display('stok_opname', $data);

    }

    public function simpan_stok_opname()
    {
        ///////* simpan ke table header * ///////////////
        $opname_tgl 			= $this->input->post('opname_tgl');

        $up['opname_code'] 		= $this->input->post('code');
        $up['opname_tgl'] 		= $this->m_crud->tgl_sql($this->input->post('opname_tgl'));

        /////* simpan ke table detail *//////////////

        $ud['opname_code'] 		= $this->input->post('code');
        $ud['kd_obat']			= $this->input->post('kd_obat');
        $ud['nama_obat']		= $this->input->post('nama_obat');
        $ud['jml'] 			    = $this->input->post('jml');
        $ud['sat_kecil_obat']	= $this->input->post('sat_kecil_obat');
        $ud['opname_tgl'] 		= $this->m_crud->tgl_sql($this->input->post('opname_tgl'));
        $ud['opname_selisih']   = $this->input->post('selisih');

        $opname_code		    = $this->input->post('code');
        $kd_obat 			    = $this->input->post('kd_obat');

        $id['opname_code'] 		= $this->input->post('code');

        $id_d['opname_code'] 	= $this->input->post('code');
        $id_d['kd_obat'] 		= $this->input->post('kd_obat');

        ///////////////////*  Update data Obat *//////////////////////
        // $id_t['obat_stok']      =$this->input->post('jml');

        //$id_e['kd_obat'] 		= $this->input->post('kd_obat');

        $hasil = $this->m_crud->getSelectedData("opname_header",$id);
        $row = $hasil->num_rows();
        if($row>0){
            $this->m_crud->updateData("opname_header",$up,$id);
            $text = "SELECT * FROM opname_detail WHERE opname_code='$opname_code' AND kd_obat='$kd_obat'";
            $hasil = $this->m_crud->manualQuery($text);
            if($hasil->num_rows()>0){
                $this->m_crud->updateData("opname_detail",$ud,$id_d);
            }else{
                $this->m_crud->insertData("opname_detail",$ud);
            }

        }else{
            $this->m_crud->insertData("opname_header",$up);
            $this->m_crud->insertData("opname_detail",$ud);

            //$this->m_crud->updateData("obat",$id_t,$id_e);

        }


    }

    public function DataDetailOpname()
    {
        if (!$this->session->userdata('logged_in') == true)
        {
            redirect('login');
        }

        $id = $this->input->post('code');

        $text = "SELECT * FROM opname_detail WHERE opname_code='$id'";
        $d['data'] = $this->db->query($text);

        $this->template->tampil_opname('daftar_opname',$d);

    }

    public function HapusDetailOpnameGudang()
    {
        $nomor = $this->uri->segment(3);//$exp[0];
        $kode = $this->uri->segment(4); //$exp[1];

        $id_usaha = $this->session->userdata('id');

        $text = "SELECT * FROM opname_detail,opname_header
					WHERE opname_detail.opname_code= opname_header.opname_code AND
					opname_detail.opname_code='$nomor' AND opname_detail.kd_obat='$kode'";
        $hasil = $this->m_crud->manualQuery($text);
        if($hasil->num_rows()>0){
            $text = "DELETE FROM opname_detail
					 WHERE 	opname_code='$nomor' AND kd_obat='$kode'";
            $this->m_crud->manualQuery($text);
            //echo "Data Sukses dihapus";
            echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/sopname/ubah/$nomor'>";
        }else{
            echo "Tidak Ada data yang dapat dihapus";
        }
    }


    public function cetak_stok_opname()
    {
        $id = $this->uri->segment(3); //$this->session->userdata('id');
        $id_p = $this->session->userdata('id');

        $d['id'] = $id;

        $text = "SELECT * FROM opname_header
					WHERE opname_code='$id'";
        $hasil = $this->m_crud->manualQuery($text);

        foreach($hasil ->result() as $t){
            $d['opname_tgl'] = $this->m_crud->tgl_indo($t->opname_tgl);
            $d['opname_code'] = $t->opname_code;
        }

        $text = "SELECT sum(jml) as total
					FROM opname_detail
					WHERE opname_code='$id'";
        $hasil = $this->m_crud->manualQuery($text);

        foreach($hasil ->result() as $t){
            $d['total'] = $t->total;
        }

        $text = "SELECT * FROM opname_detail
					WHERE opname_code='$id'";

        $d['data'] = $this->m_crud->manualQuery($text);

        $text = "SELECT * FROM puskesmas";
        $hasil = $this->m_crud->manualQuery($text);

        foreach($hasil ->result() as $t){
            $d['nm_puskesmas'] = $t->nm_puskesmas;
            $d['alamat']	   = $t->alamat;
        }


        $this->template->tampil_cetak_stok_opname_gudang('cetak_stok_opname_gudang',$d);


    }

/* --------------------- Stok Awal Gudang ------------------------*/

    function sawal_gudang($par1 = '', $par2 = '', $par3 = '')
    {
        if (!$this->session->userdata('logged_in') == true)
        {
            redirect('login');
        }

        if ($par1 == 'tambah' && $par2 == 'do_update') {


            redirect('barang/sawal_gudang', 'refresh');

        } else if ($par1 == 'tambah') {

            $data['tambah_stok_awal'] = $this->m_crud->get_obat_by_id($par2);
        }

        if ($par1 == 'ubah' && $par2 == 'do_update') {
            $data['sawal_code']    = $this->input->post('code');
            $data['sawal_tgl']     = $this->input->post('sawal_tgl');

            $this->session->set_flashdata('flash_message', 'Data Stok Awal Gudang berhasil diperbaharui!');
            redirect('barang/sawal_gudang', 'refresh');

        } else if ($par1 == 'ubah') {
            $data['edit_stok_awal_gudang'] = $this->m_crud->get_awal_gudang_by_id($par2);
        }

        if ($par1 == 'hapus') {
            $id = $this->uri->segment(4); // $this->input->post('id');

            $text = "SELECT * FROM sawal_gudang_header WHERE sawal_code='$id'";
            $hasil = $this->m_crud->manualQuery($text);
            if($hasil->num_rows()>0){
                $text = "DELETE FROM sawal_gudang_detail
						WHERE sawal_code='$id'";
                $this->m_crud->manualQuery($text);
                $text = "DELETE FROM sawal_gudang_header WHERE sawal_code='$id'";
                $this->m_crud->manualQuery($text);
                $this->session->set_flashdata('flash_message', 'Data Stok Awal Gudang berhasil dihapus!');
                redirect('barang/sawal_gudang', 'refresh');
            }
        }


        $data['sawal_tgl']			    = date('d-m-Y');
        $data['code']		            = $this->m_crud->MaxKodeSawalGudang();
        $data['page_name']  		    = 'sawal_gudang';
        $data['page_title']	 		    = 'Stok Awal Gudang';
        $data['kd_obat']	 		    = '';
        $data['sat_kecil_obat']		    = '';
        $data['onhand']	 		        = '';
        $data['nama_obat']	 		    = '';
        $data['tgl_kadaluarsa']	 	    = '';
        $data['jml']	 			    = '';
        $data['stok_awal']	 			= '';

        $data['stok_awal_gudang']	    = $this->m_crud->get_all_awal_gudang();
        $data['list_obat']			    = $this->m_crud->get_list_obat('1');
        $data['list_satuan_kecil']		= $this->m_crud->get_list_sat_kecil();


        $this->template->display('sawal_gudang', $data);

    }

    public function simpan_sawal_gudang()
    {
        ///////* simpan ke table header * ///////////////
        $sawal_tgl 			= $this->input->post('sawal_tgl');

        $up['sawal_code'] 		= $this->input->post('code');
        $up['sawal_tgl'] 		= $this->m_crud->tgl_sql($this->input->post('sawal_tgl'));

        /////* simpan ke table detail *//////////////

        $ud['sawal_code'] 		= $this->input->post('code');
        $ud['kd_obat']			= $this->input->post('kd_obat');
        $ud['nama_obat']		= $this->input->post('nama_obat');
        $ud['jml'] 			    = $this->input->post('jml');
        $ud['sat_kecil_obat']	= $this->input->post('sat_kecil_obat');
        $ud['sawal_tgl'] 		= $this->m_crud->tgl_sql($this->input->post('opname_tgl'));
        $ud['obat_stok']        = $this->input->post('onhand');

        $opname_code		    = $this->input->post('code');
        $kd_obat 			    = $this->input->post('kd_obat');

        $id['sawal_code'] 		= $this->input->post('code');

        $id_d['sawal_code'] 	= $this->input->post('code');
        $id_d['kd_obat'] 		= $this->input->post('kd_obat');


        $hasil = $this->m_crud->getSelectedData("sawal_gudang_header",$id);
        $row = $hasil->num_rows();
        if($row>0){
            $this->m_crud->updateData("sawal_gudang_header",$up,$id);
            $text = "SELECT * FROM sawal_gudang_detail WHERE sawal_code='$sawal_code' AND kd_obat='$kd_obat'";
            $hasil = $this->m_crud->manualQuery($text);
            if($hasil->num_rows()>0){
                $this->m_crud->updateData("sawal_gudang_detail",$ud,$id_d);
            }else{
                $this->m_crud->insertData("sawal_gudang_detail",$ud);
            }

        }else{
            $this->m_crud->insertData("sawal_gudang_header",$up);
            $this->m_crud->insertData("sawal_gudang_detail",$ud);

        }


    }

    public function DataDetailSawalGudang()
    {
        if (!$this->session->userdata('logged_in') == true)
        {
            redirect('login');
        }

        $id = $this->input->post('code');

        $text = "SELECT * FROM sawal_gudang_detail WHERE sawal_code='$id'";
        $d['data'] = $this->db->query($text);

        $this->template->tampil_sawal_gudang('daftar_sawal_gudang',$d);

    }

    public function HapusDetailSawalGudang()
    {
        $nomor = $this->uri->segment(3);//$exp[0];
        $kode = $this->uri->segment(4); //$exp[1];

        $id_usaha = $this->session->userdata('id');

        $text = "SELECT * FROM sawal_gudang_detail,sawal_gudang_header
					WHERE sawal_gudang_detail.opname_code= sawal_gudang_header.sawal_code AND
					sawal_gudang_detail.sawal_code='$nomor' AND sawal_gudang_detail.kd_obat='$kode'";
        $hasil = $this->m_crud->manualQuery($text);
        if($hasil->num_rows()>0){
            $text = "DELETE FROM sawal_gudang_detail
					 WHERE 	sawal_code='$nomor' AND kd_obat='$kode'";
            $this->m_crud->manualQuery($text);
            //echo "Data Sukses dihapus";
            echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/sawal_gudang/ubah/$nomor'>";
        }else{
            echo "Tidak Ada data yang dapat dihapus";
        }
    }

    /* ----------------- Stock Opname APOTEK --------------------------*/

    function sopname_apotek($par1 = '', $par2 = '', $par3 = '')
    {
        if (!$this->session->userdata('logged_in') == true)
        {
            redirect('login');
        }

        if ($par1 == 'tambah' && $par2 == 'do_update') {


            redirect('barang/sopname_apotek', 'refresh');

        } else if ($par1 == 'tambah') {

            $data['tambah_stok_opname'] = $this->m_crud->get_obat_by_id($par2);
        }
        if ($par1 == 'ubah' && $par2 == 'do_update') {
            $data['opname_code']    = $this->input->post('code');
            $data['opname_tgl']     = $this->input->post('opname_tgl');

            $this->session->set_flashdata('flash_message', 'Data Stok Opname berhasil diperbaharui!');
            redirect('barang/sopname_apotek', 'refresh');

        } else if ($par1 == 'ubah') {
            $data['edit_stok_opname'] = $this->m_crud->get_opname_apotek_by_id($par2);
        }

        if ($par1 == 'hapus') {
            $id = $this->uri->segment(4); // $this->input->post('id');

            $text = "SELECT * FROM opname_apotek_header WHERE opname_code='$id'";
            $hasil = $this->m_crud->manualQuery($text);
            if($hasil->num_rows()>0){
                $text = "DELETE FROM opname_apotek_detail
						WHERE opname_code='$id'";
                $this->m_crud->manualQuery($text);
                $text = "DELETE FROM opname_apotek_header WHERE opname_code='$id'";
                $this->m_crud->manualQuery($text);
                $this->session->set_flashdata('flash_message', 'Data Stok Opname Apotek berhasil dihapus!');
                redirect('barang/sopname_apotek', 'refresh');
            }
        }


        $data['opname_tgl']			    = date('d-m-Y');
        $data['code']		            = $this->m_crud->MaxKodeOpnameApotek();
        $data['page_name']  		    = 'opname_apotek';
        $data['page_title']	 		    = 'Stok Opname Apotek';
        $data['kd_obat']	 		    = '';
        $data['sat_kecil_obat']		    = '';
        $data['onhand']	 		        = '';
        $data['nama_obat']	 		    = '';
        $data['tgl_kadaluarsa']	 	    = date('d-m-Y');
        $data['jml']	 			    = '';
        $data['total']	 			    = '';

        $data['opname_apotek']	        = $this->m_crud->get_all_opname_apotek();
        $data['list_obat']			    = $this->m_crud->get_list_obat('1');
        $data['list_satuan_kecil']		= $this->m_crud->get_list_sat_kecil();


        $this->template->display('stok_opname_apotek', $data);

    }

    public function simpan_stok_opname_apotek()
    {
        ///////* simpan ke table header * ///////////////
        $opname_tgl 			= $this->input->post('opname_tgl');

        $up['opname_code'] 		= $this->input->post('code');
        $up['opname_tgl'] 		= $this->m_crud->tgl_sql($this->input->post('opname_tgl'));

        /////* simpan ke table detail *//////////////

        $ud['opname_code'] 		= $this->input->post('code');
        $ud['kd_obat']			= $this->input->post('kd_obat');
        $ud['nama_obat']		= $this->input->post('nama_obat');
        $ud['jml'] 			    = $this->input->post('jml');
        $ud['sat_kecil_obat']	= $this->input->post('sat_kecil_obat');
        $ud['opname_tgl'] 		= $this->m_crud->tgl_sql($this->input->post('opname_tgl'));
        $ud['opname_selisih']   = $this->input->post('selisih');

        $opname_code		    = $this->input->post('code');
        $kd_obat 			    = $this->input->post('kd_obat');

        $id['opname_code'] 		= $this->input->post('code');

        $id_d['opname_code'] 	= $this->input->post('code');
        $id_d['kd_obat'] 		= $this->input->post('kd_obat');

        ///////////////////*  Update data Obat *//////////////////////
        //$id_t['apotek_stok']      =$this->input->post('jml');

        //$id_e['kd_obat'] 		= $this->input->post('kd_obat');

        $hasil = $this->m_crud->getSelectedData("opname_apotek_header",$id);
        $row = $hasil->num_rows();
        if($row>0){
            $this->m_crud->updateData("opname_apotek_header",$up,$id);
            $text = "SELECT * FROM opname_apotek_detail WHERE opname_code='$opname_code' AND kd_obat='$kd_obat'";
            $hasil = $this->m_crud->manualQuery($text);
            if($hasil->num_rows()>0){
                $this->m_crud->updateData("opname_apotek_detail",$ud,$id_d);
            }else{
                $this->m_crud->insertData("opname_apotek_detail",$ud);
            }

        }else{
            $this->m_crud->insertData("opname_apotek_header",$up);
            $this->m_crud->insertData("opname_apotek_detail",$ud);

           // $this->m_crud->updateData("obat",$id_t,$id_e);

        }


    }

    public function DataDetailOpnameApotek()
    {
        if (!$this->session->userdata('logged_in') == true)
        {
            redirect('login');
        }

        $id = $this->input->post('code');

        $text = "SELECT * FROM opname_apotek_detail WHERE opname_code='$id'";
        $d['data'] = $this->db->query($text);

        $this->template->tampil_opname_apotek('daftar_opname_apotek',$d);

    }

    public function HapusDetailOpnameApotek()
    {
        $nomor = $this->uri->segment(3);//$exp[0];
        $kode = $this->uri->segment(4); //$exp[1];

        $id_usaha = $this->session->userdata('id');

        $text = "SELECT * FROM opname_apotek_detail,opname_apotek_header
					WHERE opname_apotek_detail.opname_code= opname_apotek_header.opname_code AND
					opname_apotek_detail.opname_code='$nomor' AND opname_apotek_detail.kd_obat='$kode'";
        $hasil = $this->m_crud->manualQuery($text);
        if($hasil->num_rows()>0){
            $text = "DELETE FROM opname_apotek_detail
					 WHERE 	opname_code='$nomor' AND kd_obat='$kode'";
            $this->m_crud->manualQuery($text);
            //echo "Data Sukses dihapus";
            echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/sopname_apotek/ubah/$nomor'>";
        }else{
            echo "Tidak Ada data yang dapat dihapus";
        }
    }
	

    public function cetak_stok_opname_apotek()
    {
        $id = $this->uri->segment(3); //$this->session->userdata('id');
        $id_p = $this->session->userdata('id');

        $d['id'] = $id;

        $text = "SELECT * FROM opname_apotek_header
					WHERE opname_code='$id'";
        $hasil = $this->m_crud->manualQuery($text);

        foreach($hasil ->result() as $t){
            $d['opname_tgl'] = $this->m_crud->tgl_indo($t->opname_tgl);
            $d['opname_code'] = $t->opname_code;
        }

        $text = "SELECT sum(jml) as total
					FROM opname_apotek_detail
					WHERE opname_code='$id'";
        $hasil = $this->m_crud->manualQuery($text);

        foreach($hasil ->result() as $t){
            $d['total'] = $t->total;
        }

        $text = "SELECT * FROM opname_apotek_detail
					WHERE opname_code='$id'";

        $d['data'] = $this->m_crud->manualQuery($text);

        $text = "SELECT * FROM puskesmas";
        $hasil = $this->m_crud->manualQuery($text);

        foreach($hasil ->result() as $t){
            $d['nm_puskesmas'] = $t->nm_puskesmas;
            $d['alamat']	   = $t->alamat;
        }


        $this->template->tampil_cetak_stok_opname_apotek('cetak_stok_opname_apotek',$d);


    }

     /* --------------------- Stok Awal Apotek ------------------------*/

    function sawal_apotek($par1 = '', $par2 = '', $par3 = '')
    {
        if (!$this->session->userdata('logged_in') == true)
        {
            redirect('login');
        }

        if ($par1 == 'tambah' && $par2 == 'do_update') {


            redirect('barang/sawal_apotek', 'refresh');

        } else if ($par1 == 'tambah') {

            $data['tambah_stok_awal'] = $this->m_crud->get_obat_by_id($par2);
        }

        if ($par1 == 'ubah' && $par2 == 'do_update') {
            $data['sawal_code']    = $this->input->post('code');
            $data['sawal_tgl']     = $this->input->post('sawal_tgl');

            $this->session->set_flashdata('flash_message', 'Data Stok Awal Apotek berhasil diperbaharui!');
            redirect('barang/sawal_apotek', 'refresh');

        } else if ($par1 == 'ubah') {
            $data['edit_stok_awal_apotek'] = $this->m_crud->get_awal_apotek_by_id($par2);
        }

        if ($par1 == 'hapus') {
            $id = $this->uri->segment(4); // $this->input->post('id');

            $text = "SELECT * FROM sawal_apotek_header WHERE sawal_code='$id'";
            $hasil = $this->m_crud->manualQuery($text);
            if($hasil->num_rows()>0){
                $text = "DELETE FROM sawal_apotek_detail
						WHERE sawal_code='$id'";
                $this->m_crud->manualQuery($text);
                $text = "DELETE FROM sawal_apotek_header WHERE sawal_code='$id'";
                $this->m_crud->manualQuery($text);
                $this->session->set_flashdata('flash_message', 'Data Stok Awal Apotek berhasil dihapus!');
                redirect('barang/sawal_apotek', 'refresh');
            }
        }


        $data['sawal_tgl']			    = date('d-m-Y');
        $data['code']		            = $this->m_crud->MaxKodeSawalApotek();
        $data['page_name']  		    = 'sawal_apotek';
        $data['page_title']	 		    = 'Stok Awal Apotek';
        $data['kd_obat']	 		    = '';
        $data['sat_kecil_obat']		    = '';
        $data['onhand']	 		        = '';
        $data['nama_obat']	 		    = '';
        $data['tgl_kadaluarsa']	 	    = '';
        $data['jml']	 			    = '';
        $data['stok_awal']	 			= '';

        $data['stok_awal_apotek']	    = $this->m_crud->get_all_awal_apotek();
        $data['list_obat']			    = $this->m_crud->get_list_obat('1');
        $data['list_satuan_kecil']		= $this->m_crud->get_list_sat_kecil();


        $this->template->display('sawal_apotek', $data);

    }

    public function simpan_sawal_apotek()
    {
        ///////* simpan ke table header * ///////////////
        $sawal_tgl 			= $this->input->post('sawal_tgl');

        $up['sawal_code'] 		= $this->input->post('code');
        $up['sawal_tgl'] 		= $this->m_crud->tgl_sql($this->input->post('sawal_tgl'));

        /////* simpan ke table detail *//////////////

        $ud['sawal_code'] 		= $this->input->post('code');
        $ud['kd_obat']			= $this->input->post('kd_obat');
        $ud['nama_obat']		= $this->input->post('nama_obat');
        $ud['jml'] 			    = $this->input->post('jml');
        $ud['sat_kecil_obat']	= $this->input->post('sat_kecil_obat');
        $ud['sawal_tgl'] 		= $this->m_crud->tgl_sql($this->input->post('opname_tgl'));
        $ud['obat_stok']        = $this->input->post('onhand');

        $sawal_code		        = $this->input->post('code');
        $kd_obat 			    = $this->input->post('kd_obat');

        $id['sawal_code'] 		= $this->input->post('code');

        $id_d['sawal_code'] 	= $this->input->post('code');
        $id_d['kd_obat'] 		= $this->input->post('kd_obat');


        $hasil = $this->m_crud->getSelectedData("sawal_apotek_header",$id);
        $row = $hasil->num_rows();
        if($row>0){
            $this->m_crud->updateData("sawal_apotek_header",$up,$id);
            $text = "SELECT * FROM sawal_apotek_detail WHERE sawal_code='$sawal_code' AND kd_obat='$kd_obat'";
            $hasil = $this->m_crud->manualQuery($text);
            if($hasil->num_rows()>0){
                $this->m_crud->updateData("sawal_apotek_detail",$ud,$id_d);
            }else{
                $this->m_crud->insertData("sawal_apotek_detail",$ud);
            }

        }else{
            $this->m_crud->insertData("sawal_apotek_header",$up);
            $this->m_crud->insertData("sawal_apotek_detail",$ud);

        }


    }

    public function DataDetailSawalApotek()
    {
        if (!$this->session->userdata('logged_in') == true)
        {
            redirect('login');
        }

        $id = $this->input->post('code');

        $text = "SELECT * FROM sawal_apotek_detail WHERE sawal_code='$id'";
        $d['data'] = $this->db->query($text);

        $this->template->tampil_sawal_gudang('daftar_sawal_apotek',$d);

    }

    public function HapusDetailSawalApotek()
    {
        $nomor = $this->uri->segment(3);//$exp[0];
        $kode = $this->uri->segment(4); //$exp[1];

        $id_usaha = $this->session->userdata('id');

        $text = "SELECT * FROM sawal_apotek_detail,sawal_apotek_header
					WHERE sawal_apotek_detail.opname_code= sawal_apotek_header.sawal_code AND
					sawal_apotek_detail.sawal_code='$nomor' AND sawal_apotek_detail.kd_obat='$kode'";
        $hasil = $this->m_crud->manualQuery($text);
        if($hasil->num_rows()>0){
            $text = "DELETE FROM sawal_apotek_detail
					 WHERE 	sawal_code='$nomor' AND kd_obat='$kode'";
            $this->m_crud->manualQuery($text);
            //echo "Data Sukses dihapus";
            echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/barang/sawal_apotek/ubah/$nomor'>";
        }else{
            echo "Tidak Ada data yang dapat dihapus";
        }
    }
}