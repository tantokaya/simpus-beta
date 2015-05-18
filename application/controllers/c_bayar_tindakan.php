<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_bayar_tindakan extends CI_Controller
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
	
	
	
//////////////////////////////*  PEMBAYARAN TINDAKAN  */////////////////////////////////
	function bayar_tindakan($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'tambah' && $par2 == 'do_update') {
		
			redirect('c_bayar_tindakan/bayar_tindakan', 'refresh');
			
		} else if ($par1 == 'tambah') {
			
			$data['pembayaran_tindakan'] = $this->m_crud->get_tindakan_by_id($par2);
		}
		if ($par1 == 'ubah' && $par2 == 'do_update') {
			$data['kodebayar'] = $this->input->post('kodebayar');
			$data['tgl_bayar'] = $this->input->post('tgl_bayar');
			
			$this->m_crud->perbaharui('kd_bayar', $par3, 'bayar_tindakan', $data);
			$this->session->set_flashdata('flash_message', 'Data Tindakan berhasil diperbaharui!');
			redirect('c_bayar_tindakan/bayar_tindakan', 'refresh');
			
		} else if ($par1 == 'ubah') {
			$data['edit_bayar_tindakan'] = $this->m_crud->get_bayar_tindakan_by_id($par2);
		}
		
		if ($par1 == 'hapus') {
			$id = $this->uri->segment(4); // $this->input->post('id');
			
			$text = "SELECT * FROM btindakan_header WHERE kd_bayar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM btindakan_detail
						WHERE kd_bayar='$id'";
				$this->m_crud->manualQuery($text);
				$text = "DELETE FROM btindakan_header WHERE kd_bayar='$id'";
				$this->m_crud->manualQuery($text);
				$this->session->set_flashdata('flash_message', 'Data Pembayaran berhasil dihapus!');
				redirect('c_bayar_tindakan/bayar_tindakan', 'refresh');
			}
		}
		
		
		
		$data['tgl_bayar']			= date('d-m-Y');
		$data['kodebayar']			= $this->m_crud->MaxKodeBayarTindakan(); 
		$data['page_name']  			= 'pembayaran';
		$data['page_title']	 		= 'Transaksi Pembayaran';
		$data['kd_produk']	 		= '';
		$data['nopelayanan']		= '';
		$data['keterangan']	 		= '';
		$data['produk']	 			= '';
		$data['kd_obat']			= '';
		$data['nama_obat']			= '';
		$data['jml_obat']			= '';
		$data['nik']	 			= '';
		$data['nm_lengkap']	 		= '';
		$data['jml']	 			= '';
		$data['total']	 			= '';
		
		
		$data['bayar_tindakan']		= $this->m_crud->get_all_bayar_tindakan();
				
		$this->template->display('bayar_tindakan', $data);
		
	}

	
	
	function detailbarang($par1 = '', $par2 = '', $par3 = '')
	{
		if($this->session->userdata('logged_in')!="")
			
			$id = $this->input->post('nomor');
			
			$text = "SELECT * FROM barang_keluar_detail WHERE kd_jual='$id'";
			$d['data'] = $this->db->query($text);
			
			$data['page_name']  = 'detailbarang';
			$data['page_title'] = 'Barang';
			
			$this->template->tampil('barang_keluar',$d);
		
		
	}
	
//////////////////////* TAMPIL DATA PEMBAYARAN TINDAKAN *////////////////////////////////////////////	
	public function DataDetailTindakan()
	{
			if (!$this->session->userdata('logged_in') == true)
			{
				redirect('login');
			}
			
			$id = $this->input->post('kode');
			
			$text = "SELECT * FROM btindakan_detail WHERE kd_bayar='$id'";
			$d['data'] = $this->db->query($text);
				
			$this->template->tampil_bayar_tindakan('daftar_bayar_tindakan',$d);
	
	}

/////////////////////* SIMPAN PEMBAYARAN TINDAKAN */////////////////////////////////////////////////	
	public function simpan_tindakan()
	{
			///////* simpan ke table header * ///////////////
			$tgl_bayar 			= $this->input->post('tgl_bayar');
			
			$up['kd_bayar'] 		= $this->input->post('kodebayar');
			$up['tgl_bayar'] 		= $this->m_crud->tgl_sql($this->input->post('tglbayar'));
            $up['bayar'] 			= $this->input->post('bayar');
			$up['kembalian'] 		= $this->input->post('kembalian');
			$up['nopelayanan'] 		= $this->input->post('nopelayanan');
			$up['kd_rekam_medis'] 		= $this->input->post('nik');

			/////* simpan ke table detail *//////////////
			
			$ud['kd_bayar'] 		= $this->input->post('kodebayar');
			$ud['kd_produk']		= $this->input->post('kd_produk');
			$ud['produk']			= $this->input->post('produk');
			$ud['jml'] 			= $this->input->post('jml');	
			$ud['harga_jual'] 		= str_replace(",","",$this->input->post('harga'));	
			$ud['tgl_bayar'] 		= $this->m_crud->tgl_sql($this->input->post('tglbayar'));
			$ud['nik'] 			= $this->input->post('nik');
			
			
			$kd_bayar 			= $this->input->post('kodebayar');
			$kd_produk			= $this->input->post('kd_produk');
			
			$id['kd_bayar'] 		= $this->input->post('kodebayar');
			
			$id_d['kodebayar'] 		= $this->input->post('kd_bayar');
			$id_d['kd_produk'] 		= $this->input->post('kd_produk');
			
			$hasil = $this->m_crud->getSelectedData("btindakan_header",$id);
			$row = $hasil->num_rows();
			if($row>0){
				$this->m_crud->updateData("btindakan_header",$up,$id);
				$text = "SELECT * FROM btindakan_detail WHERE kd_bayar='$kd_bayar' AND kd_produk='$kd_produk'";
				$hasil = $this->m_crud->manualQuery($text);
				if($hasil->num_rows()>0){
					$this->m_crud->updateData("btindakan_detail",$ud,$id_d);
				}else{
					$this->m_crud->insertData("btindakan_detail",$ud);
				}
				echo "Data sukses diubah";
			}else{
				$this->m_crud->insertData("btindakan_header",$up);
				$this->m_crud->insertData("btindakan_detail",$ud);
				echo "Data sukses disimpan";
				
			}
			
	}
/////////////////////* SIMPAN PEMBAYARAN OBAT */////////////////////////////////////////////////	
	public function simpan_obat()
	{
			
			/////* simpan ke table detail *//////////////
			
			$ud['kd_bayar'] 		= $this->input->post('kodebayar');
			$ud['kd_produk']		= $this->input->post('kd_obat');
			$ud['produk']			= $this->input->post('nama_obat');
			$ud['jml'] 			= $this->input->post('jml_obat');	
			$ud['harga_jual'] 			= str_replace(",","",$this->input->post('harga_obat'));	
			$ud['tgl_bayar'] 		= $this->m_crud->tgl_sql($this->input->post('tglbayar'));
			$ud['nik'] 			= $this->input->post('nik');
			
			
			$kd_bayar 				= $this->input->post('kodebayar');
			$kd_produk				= $this->input->post('kd_obat');
			
			$id['kd_bayar'] 			= $this->input->post('kodebayar');
			
			$id_d['kodebayar'] 		= $this->input->post('kd_bayar');
			$id_d['kd_produk'] 		= $this->input->post('kd_obat');
			
			$hasil = $this->m_crud->getSelectedData("btindakan_header",$id);
			$row = $hasil->num_rows();
			if($row>0){
				//$this->m_crud->updateData("btindakan_header",$up,$id);
				$text = "SELECT * FROM btindakan_detail WHERE kd_bayar='$kd_bayar' AND kd_produk='$kd_produk'";
				$hasil = $this->m_crud->manualQuery($text);
				if($hasil->num_rows()>0){
					$this->m_crud->updateData("btindakan_detail",$ud,$id_d);
				}else{
					$this->m_crud->insertData("btindakan_detail",$ud);
				}
				echo "Data sukses diubah";
			}else{
				//$this->m_crud->insertData("btindakan_header",$up);
				$this->m_crud->insertData("btindakan_detail",$ud);
				echo "Data sukses disimpan";
				
			}
			
		
	}	
	
/////////////////////* END OF PEMBAYARAN OBAT *///////////////////////////////////
	
/////////////////////* SIMPAN PEMBAYARAN */////////////////////////////////////////////////	
	
	public function simpan_bayar()
	{
			///////* simpan ke table header * ///////////////
			$tgl_bayar 			= $this->input->post('tgl_bayar');
			
			$up['kd_bayar'] 		= $this->input->post('kodebayar');
			$up['tgl_bayar'] 		= $this->m_crud->tgl_sql($this->input->post('tglbayar'));
			$up['kd_rekam_medis']   = $this->input->post('nik');
			$up['bayar'] 			= $this->input->post('bayar');
			$up['kembalian'] 		= $this->input->post('kembalian');
			
			/////* simpan ke table detail *//////////////
			
			$ud['kd_bayar'] 		= $this->input->post('kodebayar');
			$ud['kd_produk']			= $this->input->post('kd_produk');
			$ud['nama_obat']		= $this->input->post('nama_obat');
			$ud['jml'] 			= $this->input->post('jml');	
			$ud['harga_jual'] 		= str_replace(",","",$this->input->post('harga'));	
			$ud['tgl_bayar'] 		= $this->m_crud->tgl_sql($this->input->post('tglbayar'));
			$ud['kd_rekam_medis'] 				= $this->input->post('nik');
			
			
			$kd_bayar 			= $this->input->post('kodebayar');
			$kd_produk 			= $this->input->post('kd_produk');
			
			$id['kd_bayar'] 		= $this->input->post('kodebayar');
			
			$id_d['kodebayar'] 		= $this->input->post('kd_bayar');
			$id_d['kd_produk'] 		= $this->input->post('kd_produk');
			
			$hasil = $this->m_crud->getSelectedData("btindakan_header",$id);
			$row = $hasil->num_rows();
			if($row>0){
				$this->m_crud->updateData("btindakan_header",$up,$id);
				$text = "SELECT * FROM btindakan_detail WHERE kd_bayar='$kd_bayar' AND kd_produk='$kd_produk'";
				$hasil = $this->m_crud->manualQuery($text);
				if($hasil->num_rows()>0){
					$this->m_crud->updateData("btindakan_detail",$ud,$id_d);
				}else{
					$this->m_crud->insertData("btindakan_detail",$ud);
				}
				echo "Data sukses diubah";
			}else{
				$this->m_crud->insertData("btindakan_header",$up);
				$this->m_crud->insertData("btindakan_detail",$ud);
				echo "Data sukses disimpan";
				
			}
			
		
	}	
//////////////////////////* END OF PEMBAYARAN */////////////////////////////////////////
	
	public function HapusDetail()
	{
			$nomor = $this->uri->segment(3);//$exp[0];
			$kode = $this->uri->segment(4); //$exp[1];
			
			$id_usaha = $this->session->userdata('id');
			
			$text = "SELECT * FROM btindakan_detail,btindakan_header 
					WHERE btindakan_detail.kd_bayar=btindakan_header.kd_bayar AND
					btindakan_detail.kd_bayar='$nomor' AND btindakan_detail.kd_produk='$kode'";
			$hasil = $this->m_crud->manualQuery($text);
			if($hasil->num_rows()>0){
				$text = "DELETE FROM btindakan_detail
					 WHERE 	kd_bayar='$nomor' AND kd_produk='$kode'";
				$this->m_crud->manualQuery($text);
			//echo "Data Sukses dihapus";
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/c_bayar_tindakan/bayar_tindakan/ubah/$nomor'>";			
			}else{
				echo "Tidak Ada data yang dapat dihapus";
			}
	}
	
	public function cetak()
	{
			$id = $this->uri->segment(3); //$this->session->userdata('id');
			$id_p = $this->session->userdata('id');
			
			$d['id'] = $id;
				
			$text = "SELECT
                    btindakan_header.id_bayar,
                    btindakan_header.tgl_bayar,
                    btindakan_header.kd_bayar,
                    btindakan_header.kd_rekam_medis,
                    btindakan_header.bayar,
                    btindakan_header.kembalian,
                    btindakan_header.nopelayanan,
                    pasien.nm_lengkap,
                    pasien.no_reg,
                    pasien.alamat,
                    pasien.kd_kota,
                    pelayanan.umur
                    FROM
                    pasien
                    LEFT JOIN btindakan_header ON btindakan_header.kd_rekam_medis = pasien.kd_rekam_medis
					LEFT JOIN pelayanan ON pelayanan.kd_rekam_medis = pasien.kd_rekam_medis	
					WHERE btindakan_header.kd_bayar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['tgl_bayar'] = $this->m_crud->tgl_indo($t->tgl_bayar);
				$d['nm_lengkap'] = $t->nm_lengkap;
				$d['umur']      = $t->umur;
				$d['alamat_p'] = $t->alamat;
				$d['rkm'] = $t->kd_rekam_medis;
			}			
			$text = "SELECT sum(jml*harga_jual) as total
					FROM btindakan_detail 
					WHERE kd_bayar='$id'";
			$hasil = $this->m_crud->manualQuery($text);
			foreach($hasil ->result() as $t){
				$d['total'] = $t->total;
			}

			$text = "SELECT * FROM btindakan_detail, btindakan_header
					WHERE btindakan_detail.kd_bayar=btindakan_header.kd_bayar AND btindakan_detail.kd_bayar='$id'";

			$d['data'] = $this->m_crud->manualQuery($text);
			
			$text = "SELECT
                    set_puskesmas.`status`,
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
                    set_puskesmas.telp,
                    set_puskesmas.telp,
                    set_puskesmas.kd_kelurahan,
                    kecamatan.nm_kecamatan,
                    propinsi.nm_propinsi,
                    kota.nm_kota,
                    kelurahan.nm_kelurahan
                    FROM set_puskesmas
                    LEFT JOIN propinsi ON set_puskesmas.kd_propinsi = propinsi.kd_propinsi
                    LEFT JOIN kecamatan ON set_puskesmas.kd_kecamatan = kecamatan.kd_kecamatan
                    LEFT JOIN kota ON set_puskesmas.kd_kota = kota.kd_kota
                    LEFT JOIN kelurahan ON set_puskesmas.kd_kelurahan = kelurahan.kd_kelurahan";
        $hasil = $this->m_crud->manualQuery($text);
        foreach($hasil ->result() as $t){
            $d['nm_puskesmas']  = $t->nm_puskesmas;
            $d['alamat']	    = $t->alamat;
            $d['nm_propinsi']   = $t->nm_propinsi;
            $d['nm_kota']       = $t->nm_kota;
            $d['nm_kecamatan']  = $t->nm_kecamatan;
            $d['telp']          = $t->telp;
        }
						
			
			$this->template->tampil_cetak_tindakan('cetak_nota_tindakan',$d);
							
			
	}
	
	
	
}
