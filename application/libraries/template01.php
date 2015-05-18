<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Template Codeigniter Custom Library
|--------------------------------------------------------------------------
|
| Custom template library system based on content
|
|
*/

class Template {
	
	protected $_ci;
	
	function __construct()
	{
		$this->_ci =&get_instance();
	}
	
	function display($template,$data=null)
	{
		$akses = url_title($this->_ci->session->userdata('akses'),'_', TRUE);
		$data['_content'] = $this->_ci->load->view($akses.'/'.$template ,$data, TRUE);
			
		
		$data['_includes'] = $this->_ci->load->view('includes' ,$data, TRUE);
		$data['_header'] = $this->_ci->load->view('header', $data, TRUE);
		$data['_side_menu'] = $this->_ci->load->view($akses.'/side_menu' ,$data, TRUE);
		$data['_footer'] = $this->_ci->load->view('footer' ,$data, TRUE);
		
		
		$this->_ci->load->view('/index.php', $data);
	}
	
/////////*  TAMPIL INPUTAN PENJUALAN *////////////////
	
	function tampil_masuk($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_pembelian.php', $data);
	}
	function tampil_apotek($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_apotek_masuk.php', $data);
	}
	function tampil_keluar($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_keluar.php', $data);
	}
	
	function tampil_keluar_apotek($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_keluar_apotek.php', $data);
	}
	function tampil_bayar_obat($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_bayar_obat.php', $data);
	}
	
	function tampil_bayar_tindakan($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_bayar_tindakan.php', $data);
	}
	
	function tampil_bayar_pendaftaran($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_bayar_pendaftaran.php', $data);
	}
	
	function tampil_jual($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_penjualan.php', $data);
	}
	
	function tampil_lap_bayar_obat($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_lap_bayar_obat.php', $data);
	}
	
	function tampil_lap_bayar_tindakan($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_lap_bayar_tindakan.php', $data);
	}
	
	
	function tampil_lap_brg_masuk($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_lap_brg_masuk.php', $data);
	}
	
	function tampil_lap_brg_keluar($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_lap_brg_keluar.php', $data);
	}
/* ------------------- TAMPIL STOK OPNAME -----------------------------*/
    function tampil_opname($template,$data=null)
    {

        $this->_ci->load->view('/daftar_opname.php', $data);
    }

    function tampil_opname_apotek($template,$data=null)
    {

        $this->_ci->load->view('/daftar_opname_apotek.php', $data);
    }

///////////////////* LAPORAN SUMMARY APOTEK KELUAR */////////////////////////
	function tampil_lap_apotek_keluar($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_lap_apotek_keluar.php', $data);
	}
	
///////////////// LAPORAN DETAIL APOTEK MASUK  ////////////////////

	function tampil_lap_apotek_masuk($template,$data=null)
	{
		
		$this->_ci->load->view('/daftar_lap_apotek_masuk.php', $data);
	}
	
	function tampil_cetak_lap_apotek_masuk($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_lap_apotek_masuk.php', $data);
	}
	
/////////////* LAPORAN SUMMARY APOTEK MASUK */////////////////
    function tampil_lap_summary_apotek_in($template,$data=null)
    {
       
        $this->_ci->load->view('/daftar_lap_summary_apotek_in.php', $data);
    }
    function tampil_cetak_lap_summary_apotek_in($template,$data=null)
    {
       
        $this->_ci->load->view('cetak/cetak_lap_summary_apotek_in.php', $data);
    }
    
    
/////////////* LAPORAN SUMMARY GUDANG MASUK */////////////////
    function tampil_lap_summary_gudang_in($template,$data=null)
    {
       
        $this->_ci->load->view('/daftar_lap_summary_gudang_in.php', $data);
    }
    function tampil_cetak_lap_summary_gudang_in($template,$data=null)
    {
       
        $this->_ci->load->view('cetak/cetak_lap_summary_gudang_in.php', $data);
    }
    
/////////////* LAPORAN SUMMARY GUDANG KELUAR */////////////////
    function tampil_lap_summary_gudang_out($template,$data=null)
    {
       
        $this->_ci->load->view('/daftar_lap_summary_gudang_out.php', $data);
    }
    function tampil_cetak_lap_summary_gudang_out($template,$data=null)
    {
       
        $this->_ci->load->view('cetak/cetak_lap_summary_gudang_out.php', $data);
    }

/////////////* LAPORAN SUMMARY APOTEK KELUAR */////////////////
    function tampil_lap_summary_apotek_out($template,$data=null)
    {
       
        $this->_ci->load->view('/daftar_lap_summary_apotek_out.php', $data);
    }
    function tampil_cetak_lap_summary_apotek_out($template,$data=null)
    {
       
        $this->_ci->load->view('cetak/cetak_lap_summary_apotek_out.php', $data);
    }
 
    
/////////////* LAPORAN SUMMARY OBAT */////////////////
    function tampil_lap_summary_bayar_obat($template,$data=null)
    {
       
        $this->_ci->load->view('/daftar_lap_summary_bayar_obat.php', $data);
    }
    function tampil_cetak_lap_summary_bayar_obat($template,$data=null)
    {
       
        $this->_ci->load->view('cetak/cetak_lap_summary_bayar_obat.php', $data);
    }
    
/////////////* LAPORAN SUMMARY BAYAR TINDAKAN*/////////////////
    function tampil_lap_summary_bayar_tindakan($template,$data=null)
    {
       
        $this->_ci->load->view('/daftar_lap_summary_bayar_tindakan.php', $data);
    }
    function tampil_cetak_lap_summary_bayar_tindakan($template,$data=null)
    {
       
        $this->_ci->load->view('cetak/cetak_lap_summary_bayar_tindakan.php', $data);
    }
////////////////*  CARI BARANG *//////////////////	
	function tampilbarang($template,$data=null)
	{
		
		$this->_ci->load->view('ListBarang.php', $data);
	}

////////////////*  CARI BARANG APOTEK *//////////////////	
	function tampilbarangApotek($template,$data=null)
	{
		
		$this->_ci->load->view('ListBarangApotek.php', $data);
	}
	
////////////////*  CARI PASIEN *//////////////////	
	function tampilpasien($template,$data=null)
	{
		
		$this->_ci->load->view('ListPasien.php', $data);
	}

////////////////*  CARI TINDAKAN *//////////////////	
	function tampiltindakan($template,$data=null)
	{
		
		$this->_ci->load->view('ListTindakan.php', $data);
	}

////////////////*  CARI Obat *//////////////////	
	function tampilobat($template,$data=null)
	{
		
		$this->_ci->load->view('ListObat.php', $data);
	}

////////////////*  CARI RESEP *//////////////////	
	function tampilresep($template,$data=null)
	{
		
		$this->_ci->load->view('ListResep.php', $data);
	}
	
////////////////*  CARI NOMOR REKAM MEDIS *//////////////////	
	function tampilrekammedis($template,$data=null)
	{
		
		$this->_ci->load->view('ListRekamMedis.php', $data);
	}
	
///////////*  CETAK NOTA  *//////////////
	function tampil_cetak_barang_masuk($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_barang_masuk.php', $data);
	}
	function tampil_cetak_Apotek($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_nota_apotek.php', $data);
	}
	function tampil_cetak_apotek_keluar($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_nota_apotek_keluar.php', $data);
	}
	function tampil_cetak_tindakan($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_nota_tindakan.php', $data);
	}
	
	
	function tampil_cetak_obat($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_nota_obat.php', $data);
	}
	
	function tampil_cetak_lap_bayar_obat($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_lap_bayar_obat.php', $data);
	}
	
	function tampil_cetak_lap_bayar_tindakan($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_lap_bayar_tindakan.php', $data);
	}
	
	function tampil_cetak_lap_brg_masuk($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_lap_brg_masuk.php', $data);
	}
	
	function tampil_cetak_lap_brg_keluar($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_lap_brg_keluar.php', $data);
	}
	
	function tampil_cetak_lap_apotek_keluar($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_lap_apotek_keluar.php', $data);
	}
	
	function tampil_cetak_resep($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_resep.php', $data);
	}

	function tampil_cetak_stok_opname_gudang($template,$data=null)
    	{

        $this->_ci->load->view('cetak/cetak_stok_opname_gudang.php', $data);
    	}
    	function tampil_cetak_stok_opname_apotek($template,$data=null)
    	{

        	this->_ci->load->view('cetak/cetak_stok_opname_apotek.php', $data);
   	 }

///////////*  CETAK SURAT KELUAR  *//////////////
	function tampil_cetak_keluar($template,$data=null)
	{
		
		$this->_ci->load->view('cetak/cetak_barang_keluar.php', $data);
	}
	
	
/////////////* LOGIN */////////////////
	
	function display_login()
	{	
		$this->_ci->load->view('/login.php');
	}
}

/* End of file template.php */
/* Location: ./application/libraries/template.php */