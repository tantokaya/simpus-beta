<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ref_json extends CI_Controller 
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
	
	
	public function CariNoSJ(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kodebeli) as no FROM h_beli";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,5,5))+1;
				$hasil = 'BL'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = 'BL'.'00001';
		}
		return $hasil;
	}
	

	public function ListBarang()
	{
		if($this->session->userdata('logged_in')!="")
			
			$kode = $this->input->post('kode');
			if(empty($kode)){	
				echo json_encode(array());
			}else{
				$text = "SELECT kd_obat FROM obat WHERE kd_obat LIKE '%$kode%' GROUP BY kd_obat LIMIT 1,10";
				$rows = $this->m_crud->manualQuery($text);
				$data = array();
				foreach ($rows->result() as $t)
					$data[] = $t->kd_obat; 
				echo json_encode($data);
			}
		
	}
	
	public function ListPasien()
	{
		if($this->session->userdata('logged_in')!="")
			
			$kodenik = $this->input->post('kodenik');
			if(empty($kodenik)){	
				echo json_encode(array());
			}else{
				$text = "SELECT nik FROM pasien WHERE kd_rekam_medis LIKE '%$kodenik%' GROUP BY nik LIMIT 1,10";
				$rows = $this->m_crud->manualQuery($text);
				$data = array();
				foreach ($rows->result() as $p)
					$data[] = $p->nik; 
				echo json_encode($data);
			}
		
	}
	
	public function ListTindakan()
	{
		if($this->session->userdata('logged_in')!="")
			
			$kode = $this->input->post('kode');
			if(empty($kode)){	
				echo json_encode(array());
			}else{
				$text = "SELECT kd_produk FROM tindakan WHERE kd_produk LIKE '%$kode%' GROUP BY kd_produk LIMIT 1,10";
				$rows = $this->m_crud->manualQuery($text);
				$data = array();
				foreach ($rows->result() as $p)
					$data[] = $p->kd_produk; 
				echo json_encode($data);
			}
		
	}
	

	public function CariBarang()
	{
		if($this->session->userdata('logged_in')!="")
		
			$kode = $this->input->post('kode',true);
			
			$text = "SELECT obat.*, satuan_kecil.sat_kecil_obat FROM obat
			INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat
			WHERE obat.kd_obat='$kode' GROUP BY kd_obat LIMIT 25";
			$d = $this->m_crud->manualQuery($text);
			$row = $d->num_rows();
			if($row>0){
				foreach($d->result() as $t){
					$data['kd_obat'] 	    = $t->kd_obat;
					$data['nama_obat'] 	    = $t->nama_obat;
					$data['harga_beli'] 	= number_format($t->harga_beli);
					$data['harga_jual']	    = number_format($t->harga_jual);
					$data['tgl_kadaluarsa'] = $this->m_crud->tgl_sql($t->tgl_kadaluarsa);
					$data['sat_kecil_obat'] = $t->sat_kecil_obat;
					$data['obat_stok']	    = $t->obat_stok;
                    $data['apotek_stok']    = $t->apotek_stok;

					echo json_encode($data);
				}
			}else{
				$data['kd_obat'] 	        = '';
				$data['nama_obat'] 	        = '';
				$data['harga_beli'] 	    = '';
				$data['harga_jual'] 	    = '';
				$data['sat_kecil_obat']     = '';
				$data['obat_stok']	        = '';
                $data['apotek_stok']        = '';

				echo json_encode($data);
			}
		
	}
	
	public function CariObat()
	{
		if($this->session->userdata('logged_in')!="")
		
			$kode = $this->input->post('kodeobat',true);
			
			$text = "SELECT obat.*, satuan_kecil.sat_kecil_obat FROM obat INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat WHERE obat.kd_obat='$kode' GROUP BY kd_obat LIMIT 25";
			$d = $this->m_crud->manualQuery($text);
			$row = $d->num_rows();
			if($row>0){
				foreach($d->result() as $t){
					$data['nama_obat'] 	= $t->nama_obat;
					$data['harga_obat']	= number_format($t->harga_jual);
					echo json_encode($data);
				}
			}else{
				$data['nama_obat'] 	= '';
				$data['harga_obat']	= '';		
				echo json_encode($data);
			}
		
	}
	
	public function CariTindakan()
	{
		if($this->session->userdata('logged_in')!="")
		
			$kode = $this->input->post('kode',true);
			
			$text = "SELECT * FROM tindakan WHERE kd_produk='$kode' GROUP BY kd_produk LIMIT 25";
			$d = $this->m_crud->manualQuery($text);
			$row = $d->num_rows();
			if($row>0){
				foreach($d->result() as $t){
					$data['produk'] 	= $t->produk;
					$data['harga']		= number_format($t->harga);
					$data['keterangan_tindakan']	= $t->keterangan_tindakan;
					echo json_encode($data);
				}
			}else{
				$data['produk']		= '';
				$data['harga'] 		= '';
				$data['keterangan_tindakan']	= '';
				echo json_encode($data);
			}
		
	}

    public function InfoUnitFarmasi()
    {
        if($this->session->userdata('logged_in')!="")

            $kode = $this->input->post('kd_unit_farmasi',true);

        $text = "SELECT unit_farmasi.kd_unit_farmasi,unit_farmasi.nama_unit_farmasi, unit_farmasi.farmasi_utama
        FROM unit_farmasi WHERE unit_farmasi.kd_unit_farmasi = '$kode' GROUP BY unit_farmasi.kd_unit_farmasi LIMIT 25";
        $d = $this->m_crud->manualQuery($text);
        $row = $d->num_rows();
        if($row>0){
            foreach($d->result() as $t){
                $data['nama_unit_farmasi'] 	= $t->nama_unit_farmasi;
                $data['farmasi_utama'] 	= $t->nama_unit_farmasi;
                echo json_encode($data);
            }
        }else{
            $data['nama_unit_farmasi'] 	= '';
            echo json_encode($data);
        }

    }
	///////////////////////////////* CARI PASIEN BERDASARKAN PELAYANAN */////////////////////////////////////

	public function CariPelayananPasien()
	{
		if($this->session->userdata('logged_in')!="")
		
			$plyn = $this->input->post('plyn',true);
			
			$text = "SELECT pelayanan.kd_rekam_medis,pasien.kd_rekam_medis,pasien.nik,pasien.nm_lengkap,pelayanan.kd_trans_pelayanan FROM pelayanan
				INNER JOIN pasien ON pelayanan.kd_rekam_medis = pasien.kd_rekam_medis
				WHERE pelayanan.kd_trans_pelayanan = '$plyn'";
			$d = $this->m_crud->manualQuery($text);
			$row = $d->num_rows();
			if($row>0){
				foreach($d->result() as $t){
					$data['nm_lengkap'] 	= $t->nm_lengkap;
					$data['nik'] 		= $t->nik;
					echo json_encode($data);
				}
			}else{
				$data['nik'] 	= '';
				$data['nm_lengkap'] 	= '';
				echo json_encode($data);
			}
		
	}
	
	public function CariPasien()
	{
		if($this->session->userdata('logged_in')!="")
		
			$koderek = $this->input->post('kode',true);
			
			$text = "SELECT * FROM pasien WHERE kd_rekam_medis='$koderek' GROUP BY kd_rekam_medis LIMIT 25";
			$d = $this->m_crud->manualQuery($text);
			$row = $d->num_rows();
			if($row>0){
				foreach($d->result() as $t){
					$data['bio_nama'] 		= $t->nm_lengkap;
					$data['bio_tgl_lahir'] 	= $this->m_crud->tgl_sql($t->tanggal_lahir);
					$data['bio_alamat'] 	= $this->m_crud->tgl_sql($t->alamat);
					echo json_encode($data);
				}
			}else{
				$data['bio_nama'] 		= '';
				$data['bio_tgl_lahir'] 	= '';
				$data['bio_alamat'] 	= '';
				echo json_encode($data);
			}
		
	}
//////////////////////////////////////* MENAMPILKAN DATA BARANG *///////////////////////////////////////	
	public function DataBarang()
	{
		if($this->session->userdata('logged_in')!="")
		
					
			
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT * FROM obat LIMIT 25";
			}else{
				$text = "SELECT * FROM obat WHERE kd_obat LIKE '%$cari%' OR nama_obat LIKE '%$cari%' LIMIT 25";
			}
			$d['data'] = $this->m_crud->manualQuery($text);
		
			
			$this->template->tampilbarang('ListBarang',$d);
		
	}

//////////////////////////////////////* MENAMPILKAN DATA BARANG APOTEK *///////////////////////////////////////	
	public function DataBarangApotek()
	{
		if($this->session->userdata('logged_in')!="")
		
					
			
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT * FROM obat LIMIT 25";
			}else{
				$text = "SELECT * FROM obat WHERE kd_obat LIKE '%$cari%' OR nama_obat LIKE '%$cari%' LIMIT 25";
			}
			$d['data'] = $this->m_crud->manualQuery($text);
		
			
			$this->template->tampilbarangApotek('ListBarangApotek',$d);
		
	}
	
	
//////////////////////////////////////* MENAMPILKAN DATA PASIEN *///////////////////////////////////////		
	public function DataPasien()
	{
		if($this->session->userdata('logged_in')!="")
		
					
			
			$caripasien= $this->input->post('caripasien');
			if(empty($caripasien)){
				$text = "SELECT * FROM pasien LIMIT 25";
			}else{
				$text = "SELECT * FROM pasien WHERE kd_rekam_medis LIKE '%$caripasien%' OR nm_lengkap LIKE '%$caripasien%' LIMIT 25";
			}
			$d['data'] = $this->m_crud->manualQuery($text);
		
			
			$this->template->tampilpasien('ListPasien',$d);
		
	}
	
//////////////////////////////////////* MENAMPILKAN DATA TINDAKAN *///////////////////////////////////////		
	public function DataTindakan()
	{
		if($this->session->userdata('logged_in')!="")


			
			$caritindakan= $this->input->post('caritindakan');
			if(empty($caritindakan)){
				$text = "SELECT * FROM tindakan LIMIT 25";
			}else{
				$text = "SELECT * FROM tindakan WHERE kd_produk LIKE '%$caritindakan%' OR produk LIKE '%$caritindakan%' LIMIT 25";
			}
			$d['data'] = $this->m_crud->manualQuery($text);
		
			
			$this->template->tampiltindakan('ListTindakan',$d);
		
	}

//////////////////////////////////////* MENAMPILKAN DATA RESEP *///////////////////////////////////////	
	public function DataResep()
	{
		if($this->session->userdata('logged_in')!="")
		

			
			$cari= $this->input->post('s');
			if(empty($cari)){
                $text = "SELECT
                        pelayanan.kd_trans_pelayanan,
                        pelayanan.tgl_pelayanan,
                        jenis_layanan.jenis_layanan,
                        pasien.nm_lengkap,
                        unit_pelayanan.nm_unit,
                        pasien.tanggal_daftar,
                        pasien.tempat_lahir,
                        pasien.tanggal_lahir
                FROM
                pelayanan
                INNER JOIN pasien ON pelayanan.kd_rekam_medis = pasien.kd_rekam_medis
                INNER JOIN jenis_layanan ON pelayanan.kd_jenis_layanan = jenis_layanan.kd_jenis_layanan
                INNER JOIN unit_pelayanan ON pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan
                WHERE  DATE_FORMAT(pelayanan.tgl_pelayanan,'%y-%b-%d') = DATE_FORMAT(NOW(),'%y-%b-%d')
                AND pelayanan.status <> '1' ORDER BY pelayanan.kd_trans_pelayanan DESC LIMIT 25";
			}else{
				$text = "SELECT
                        pelayanan.kd_trans_pelayanan,
                        pelayanan.tgl_pelayanan,
                        jenis_layanan.jenis_layanan,
                        pasien.nm_lengkap,
                        unit_pelayanan.nm_unit,
                        pasien.tanggal_daftar,
                        pasien.tempat_lahir,
                        pasien.tanggal_lahir
                        FROM
                        pelayanan
                        INNER JOIN pasien ON pelayanan.kd_rekam_medis = pasien.kd_rekam_medis
                        INNER JOIN jenis_layanan ON pelayanan.kd_jenis_layanan = jenis_layanan.kd_jenis_layanan
                        INNER JOIN unit_pelayanan ON pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan
                        WHERE pelayanan.kd_trans_pelayanan
				LIKE '%$cari%'
				AND pelayanan.kd_rekam_medis = pasien.kd_rekam_medis
				AND pelayanan.kd_jenis_layanan = jenis_layanan.kd_jenis_layanan
				AND pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan
				AND DATE_FORMAT(pelayanan.tgl_pelayanan,'%y-%b-%d') = DATE_FORMAT(NOW(),'%y-%b-%d')
				AND pelayanan.status <> '1'

				OR pasien.nm_lengkap like '%$cari%' 
				AND pelayanan.kd_rekam_medis = pasien.kd_rekam_medis
				AND pelayanan.kd_jenis_layanan = jenis_layanan.kd_jenis_layanan
				AND pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan
				AND DATE_FORMAT(pelayanan.tgl_pelayanan,'%y-%b-%d') = DATE_FORMAT(NOW(),'%y-%b-%d')
				AND pelayanan.status <> '1' 
                ORDER BY pelayanan.kd_trans_pelayanan DESC
				 LIMIT 25";
				
			}
			$d['data'] = $this->m_crud->manualQuery($text);
			
			
			$this->template->tampilresep('ListResep',$d);
		
	}	
	
	//////////////////////////////////////* MENAMPILKAN DATA TINDAKAN *///////////////////////////////////////	
	public function DataBayarTindakan()
	{if($this->session->userdata('logged_in')!="")
	
		
		$cari= $this->input->post('s'); 

			if(empty($cari)){
				$text = "SELECT
                            pelayanan_tindakan.kd_trans_tindakan,
							pelayanan_tindakan.kd_trans_pelayanan,
                            pelayanan_tindakan.qty,
                            pelayanan_tindakan.kd_produk,
                            tindakan.produk,
                            tindakan.harga,
                            pelayanan_tindakan.sta_bayar
                            FROM
                            pelayanan_tindakan
                            INNER JOIN tindakan ON pelayanan_tindakan.kd_produk = tindakan.kd_produk
                         LIMIT 25";
			}else{
				$text = "SELECT
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
                        WHERE pelayanan_tindakan.kd_trans_pelayanan LIKE '%$cari%' AND pelayanan_tindakan.kd_produk = tindakan.kd_produk
                      LIMIT 25";

			}
			$d['kd_bayar'] = $this->input->post('t'); // Kode Bayar
			$d['tgl_bayar'] = $this->input->post('u'); // Tanggal Bayar
			$d['data'] = $this->m_crud->manualQuery($text);
			
			
			$this->template->tampilbayartindakan('ListBayarTindakan',$d);
		
	}  
//////////////////////////////////////* MENAMPILKAN DATA OBAT *///////////////////////////////////////		
	public function DataObat()
	{
		if($this->session->userdata('logged_in')!="")
		
					
			
			$cariobat= $this->input->post('cariobat');
			if(empty($cariobat)){
				$text = "SELECT * FROM obat LIMIT 25";
			}else{
				$text = "SELECT * FROM obat WHERE kd_obat LIKE '%$cariobat%' OR nama_obat LIKE '%$cariobat%' LIMIT 25";
			}
			$d['data'] = $this->m_crud->manualQuery($text);
		
			
			$this->template->tampilobat('ListObat',$d);
		
	}
	
//////////////////////////////////////* MENAMPILKAN DATA NOMOR REKAM MEDIS *///////////////////////////////////////	
	public function DataRekamMedis()
	{
		if($this->session->userdata('logged_in')!="")
		
					
			
			$cari= $this->input->post('cari');
			if(empty($cari)){
				$text = "SELECT * FROM pasien LIMIT 25";
			}else{
				$text = "SELECT * FROM pasien WHERE kd_rekam_medis LIKE '%$cari%' OR nm_lengkap LIKE '%$cari%' LIMIT 25";
			}
			$d['data'] = $this->m_crud->manualQuery($text);
		
			
			$this->template->tampilrekammedis('ListRekamMedis',$d);
		
	}
	
}


/* End of file profil.php */
/* Location: ./application/controllers/profil.php */
