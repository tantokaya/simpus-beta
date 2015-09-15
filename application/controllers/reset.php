<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reset extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
				
		// cek session
		if (!$this->session->userdata('logged_in')) {
			$this->session->unset_userdata();
			$this->session->sess_destroy();
			redirect('login');
		}

		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	function resetDokter(){
		$this->db->truncate('dokter');	
		$data['info'] = 'Data master dokter berhasil di reset!';
		
		echo json_encode($data);
	}
	
	function resetPetugas(){
		$this->db->truncate('petugas');	
		$data['info'] = 'Data master petugas berhasil di reset!';
		
		echo json_encode($data);
	}
	
	function resetPasien(){
		$this->db->truncate('pasien');	
		$data['info'] = 'Data master pasien berhasil di reset!';
		
		echo json_encode($data);
	}

    function resetBarangMasukGudang(){
        $this->db->truncate('brg_masuk_header');
        $this->db->truncate('brg_masuk_detail');
        $data['info'] = 'Data master barang masuk gudang berhasil di reset!';

        echo json_encode($data);
    }

    function resetBarangKeluarGudang(){
        $this->db->truncate('barang_keluar_header');
        $this->db->truncate('barang_keluar_detail');
        $data['info'] = 'Data master barang keluar gudang berhasil di reset!';

        echo json_encode($data);
    }

    function resetStokGudang()
    {
        $this->db->update('obat', array('obat_stok' => 0));

        $data['info'] = 'Data master stok gudang berhasil di reset!';

        echo json_encode($data);
    }

    function resetStokOpnameGudang()
    {
        $this->db->truncate('opname_header');
        $this->db->truncate('opname_detail');

        $data['info'] = 'Data master stok opname gudang berhasil di reset!';

        echo json_encode($data);
    }

    function resetExpObatGudang()
    {
        $this->db->update('brg_masuk_detail', array('tgl_kadaluarsa' => '00-00-000'));

        $data['info'] = 'Data master tanggal expired obat gudang berhasil di reset!';

        echo json_encode($data);
    }


    function resetBarangMasukApotek(){
        $this->db->truncate('brg_masuk_apotek_header');
        $this->db->truncate('brg_masuk_apotek_detail');

        $data['info'] = 'Data master barang masuk apotek berhasil di reset!';

        echo json_encode($data);
    }

    function resetBarangKeluarApotek(){
        $this->db->truncate('brg_apotek_keluar_header');
        $this->db->truncate('brg_apotek_keluar_detail');
        $data['info'] = 'Data master barang keluar apotek berhasil di reset!';

        echo json_encode($data);
    }

    function resetStokApotek()
    {
        $this->db->update('obat', array('apotek_stok' => 0));

        $data['info'] = 'Data master stok apotek berhasil di reset!';

        echo json_encode($data);
    }

    function resetStokOpnameApotek()
    {
        $this->db->truncate('opname_apotek_header');
        $this->db->truncate('opname_apotek_detail');

        $data['info'] = 'Data master stok opname apotek berhasil di reset!';

        echo json_encode($data);
    }

    function resetExpObatApotek()
    {
        $this->db->update('brg_masuk_apotek_detail', array('tgl_kadaluarsa' => '00-00-000'));

        $data['info'] = 'Data master tanggal expired obat apotek berhasil di reset!';

        echo json_encode($data);
    }

    function resetTransBayarKasir()
    {
        $this->db->truncate('btindakan_header');
        $this->db->truncate('btindakan_detail');
        $this->db->truncate('bobat_header');
        $this->db->truncate('bobat_detail');

        $data['info'] = 'Data master transaksi pembayaran kasir (obat dan tindakan) berhasil di reset!';

        echo json_encode($data);
    }

}