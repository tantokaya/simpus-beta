<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_crud extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	
	function get_settings()
	{
		$query	=	$this->db->get('settings' );
		return $query->result_array();
	}
	
	//////////  TABLE /////////////////
	public function getAllData($table)
	{
		return $this->db->get($table);
	}
	
	public function getAllDataLimited($table,$limit,$offset)
	{
		return $this->db->get($table, $limit, $offset);
	}
	
	public function getSelectedDataLimited($table,$data,$limit,$offset)
	{
		return $this->db->get_where($table, $data, $limit, $offset);
	}
	
	//////////// SIMPAN /////////////
	function simpan($table, $data)
	{
		$this->db->insert($table, $data);
	}
	
	function perbaharui($pk, $val, $table, $data)
	{
		$this->db->where($pk, $val);
		$this->db->update($table, $data);
	}
	
	function manualQuery($q)
	{
		return $this->db->query($q);
	}

	
	/////  SELECT   /////////////
	public function getSelectedData($table,$data)
	{
		return $this->db->get_where($table, $data);
	}
	
	/////// UPDATE DATA /////////////
	function updateData($table,$data,$field_key)
	{
		$this->db->update($table,$data,$field_key);
	}
	function deleteData($table,$data)
	{
		$this->db->delete($table,$data);
	}
	
	function insertData($table,$data)
	{
		$this->db->insert($table,$data);
	}
	
	public function MaxKodeMasuk(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kd_masuk) as no FROM brg_masuk_header";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,3,8))+1;
				$hasil = 'MSK'.sprintf("%08s", $tmp);
			}
		}else{
			$hasil = 'MSK'.'00000001';
		}
		return $hasil;
	}

    public function MaxKodeOpnameGudang(){
        $bln = date('m');
        $th = date('y');
        $text = "SELECT max(opname_code) as no FROM opname_header";
        $data = $this->m_crud->manualQuery($text);
        if($data->num_rows() > 0 ){
            foreach($data->result() as $t){
                $no = $t->no;
                $tmp = ((int) substr($no,3,8))+1;
                $hasil = 'OPG'.sprintf("%08s", $tmp);
            }
        }else{
            $hasil = 'OPG'.'00000001';
        }
        return $hasil;
    }

    public function MaxKodeSawalGudang(){
    $text = "SELECT max(sawal_code) as no FROM sawal_gudang_header";
    $data = $this->m_crud->manualQuery($text);
    if($data->num_rows() > 0 ){
        foreach($data->result() as $t){
            $no = $t->no;
            $tmp = ((int) substr($no,3,8))+1;
            $hasil = 'AWL'.sprintf("%08s", $tmp);
        }
    }else{
        $hasil = 'AWL'.'00000001';
    }
    return $hasil;
    }

    public function MaxKodeSawalApotek(){
        $text = "SELECT max(sawal_code) as no FROM sawal_apotek_header";
        $data = $this->m_crud->manualQuery($text);
        if($data->num_rows() > 0 ){
            foreach($data->result() as $t){
                $no = $t->no;
                $tmp = ((int) substr($no,3,8))+1;
                $hasil = 'AWP'.sprintf("%08s", $tmp);
            }
        }else{
            $hasil = 'AWP'.'00000001';
        }
        return $hasil;
    }

    public function MaxKodeOpnameApotek(){
        $bln = date('m');
        $th = date('y');
        $text = "SELECT max(opname_code) as no FROM opname_apotek_header";
        $data = $this->m_crud->manualQuery($text);
        if($data->num_rows() > 0 ){
            foreach($data->result() as $t){
                $no = $t->no;
                $tmp = ((int) substr($no,3,8))+1;
                $hasil = 'OPA'.sprintf("%08s", $tmp);
            }
        }else{
            $hasil = 'OPA'.'00000001';
        }
        return $hasil;
    }

	public function MaxKodeMasukApotek(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kd_masuk) as no FROM brg_masuk_apotek_header";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no = $t->no; 
				$tmp = ((int) substr($no,3,8))+1;
				$hasil = 'APT'.sprintf("%08s", $tmp);
			}
		}else{
			$hasil = 'APT'.'00000001';
		}
		return $hasil;
	}	

	public function MaxKodeKeluar(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kd_keluar) as no_keluar FROM barang_keluar_header";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no_keluar = $t->no_keluar; 
				$tmp = ((int) substr($no_keluar,3,8))+1;
				$hasil = 'KLR'.sprintf("%08s", $tmp);
			}
		}else{
			$hasil = 'KLR'.'00000001';
		}
		return $hasil;
	}
	public function MaxKodeKeluarApotek(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kd_keluar) as no_keluar FROM brg_apotek_keluar_header";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no_keluar = $t->no_keluar; 
				$tmp = ((int) substr($no_keluar,3,8))+1;
				$hasil = 'APO'.sprintf("%08s", $tmp);
			}
		}else{
			$hasil = 'APO'.'00000001';
		}
		return $hasil;
	}
	
	public function MaxKodeBayarObat(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kd_bayar) as no_bayar FROM bobat_header";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no_bayar = $t->no_bayar; 
				$tmp = ((int) substr($no_bayar,3,8))+1;
				$hasil = 'BYR'.sprintf("%08s", $tmp);
			}
		}else{
			$hasil = 'BYR'.'00000001';
		}
		return $hasil;
	}
	
	public function MaxKodeBayarPendaftaran(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kd_bayar) as no_bayar FROM bayar_pendaftaran";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no_bayar = $t->no_bayar; 
				$tmp = ((int) substr($no_bayar,2,7))+1;
				$hasil = 'DF'.sprintf("%07s", $tmp);
			}
		}else{
			$hasil = 'DF'.'0000001';
		}
		return $hasil;
	}
	
	public function MaxKodeBayarTindakan(){
		$bln = date('m');
		$th = date('y');
		$text = "SELECT max(kd_bayar) as no_bayar FROM btindakan_header";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$no_bayar = $t->no_bayar; 
				$tmp = ((int) substr($no_bayar,3,8))+1;
				$hasil = 'TDK'.sprintf("%08s", $tmp);
			}
		}else{
			$hasil = 'TDK'.'00000001';
		}
		return $hasil;
	}
	
	
	public function MaxKodeRujukan($date,$kd_pus){
		$pecah = explode('-',$date);		
		$text = "SELECT max(no_rujukan) as rjk FROM pelayanan WHERE MONTH(tgl_pelayanan)='$pecah[1]'";
		$data = $this->m_crud->manualQuery($text);
		if($data->num_rows() > 0 ){
			foreach($data->result() as $t){
				$rjk = $t->rjk; 
				$tmp = ((int) substr($rjk,4,4))+1;
				//$hasil = 'RJK-'.sprintf("%04s", $tmp).'/'.$kd_pus.'/'.$this->generate_romawi($pecah[1]).'/'.$pecah[0];	
				$hasil = '440'.'/'.sprintf("%04s", $tmp).'/'.$this->generate_romawi($pecah[1]).'/ PkmBotim-'.$pecah[0];			
			} 
		}else{
			//$hasil = 'RJK-'.'0001/'.$kd_pus.'/'.$this->generate_romawi($pecah[1]).'/'.$pecah[0];
			$hasil = '440'.'/'.'0001/'.$kd_pus.'/'.$this->generate_romawi($pecah[1]).'/'.$pecah[0];
		} 
		
		return $hasil;
	}
	
	public function generate_romawi($bulan){
		switch($bulan){
			case 1: $romawi = "I"; break;
			case 2: $romawi = "II"; break;
			case 3: $romawi = "III"; break;
			case 4: $romawi = "IV"; break;
			case 5: $romawi = "V"; break;
			case 6: $romawi = "VI"; break;
			case 7: $romawi = "VII"; break;
			case 8: $romawi = "VIII"; break;
			case 9: $romawi = "IX"; break;
			case 10: $romawi = "X"; break;
			case 11: $romawi = "XI"; break;
			case 12: $romawi = "XII"; break;	
		}	
		
		return $romawi;
	}
	
/////////////////////*  KONVERSI TANGGAL  *//////////////////////////////////
	public function tgl_sql($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}
	public function tgl_str($date){
		$exp = explode('-',$date);
		if(count($exp) == 3) {
			$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
		}
		return $date;
	}

	
	/* Tanggal dan Jam */
	public function Jam_Now(){
		date_default_timezone_set("Asia/Jakarta");
   		$jam = date("H:i:s"); 
   		
		return $jam;
		//echo "$jam WIB";
	}
	
	/**********************************************************************************************************/
	/* PROPINSI																							  */
	/**********************************************************************************************************/
	function get_all_propinsi()
	{
		$query	=	$this->db->get('propinsi' );
		return $query->result_array();
	}
	
	function get_propinsi_by_id($id)
	{
		$query	=	$this->db->get_where('propinsi', array(
						'kd_propinsi' => $id
					));

		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* KOTA																							  */
	/**********************************************************************************************************/
	function get_all_kota()
	{
		$this->db->select('*');
		$this->db->from('kota');
		$this->db->join('propinsi', 'substr(1,2,kota.kd_kota) = propinsi.kd_propinsi');

		$query = $this->db->get();
		
		//$query	=	$this->db->get('kota' );
		return $query->result_array();
	}
	
	function get_kota_by_propinsi_id($id)
	{
		$result	=	$this->db->get_where('kota', array(
						'substr(kd_kota,1,2)' => $id
					));

		if($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return array();
		}
	}
	
	function get_kota_by_id($id)
	{
		$query	=	$this->db->get_where('kota', array(
						'kd_kota' => $id
					));

		return $query->result_array();
	}
	
	
	/**********************************************************************************************************/
	/* KECAMATAN																							  */
	/**********************************************************************************************************/
	function get_all_kecamatan()
	{
		$this->db->select('*');
		$this->db->from('kecamatan');
		$this->db->join('kota', 'kecamatan.kd_kota = kota.kd_kota');
		$query = $this->db->get();
		
		//$query	=	$this->db->get('kota' );
		return $query->result_array();
	}
	
	function get_kecamatan_by_id($id)
	{
		$query	=	$this->db->get_where('kecamatan', array(
						'kd_kecamatan' => $id
					));
		return $query->result_array();
	}
	
	function get_kecamatan_by_kota_id($id)
	{
		$result	=	$this->db->get_where('kecamatan', array(
						'substr(kd_kecamatan,1,4)' => $id
					));

		if($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return array();
		}
	}
	
	/**********************************************************************************************************/
	/* KELURAHAN																							  */
	/**********************************************************************************************************/
	function get_all_kelurahan()
	{
		$this->db->select('*');
		$this->db->from('kelurahan');
		//$this->db->join('kecamatan', 'kelurahan.kd_kota = kota.kd_kota');
		$query = $this->db->get();
		
		//$query	=	$this->db->get('kota' );
		return $query->result_array();
	}
	
	function get_kelurahan_by_id($id)
	{
		$query	=	$this->db->get_where('kelurahan', array(
						'kd_kelurahan' => $id
					));
		return $query->result_array();
	}
	
	function get_kelurahan_by_kec_id($id)
	{
		$result	=	$this->db->get_where('kelurahan', array(
						'substr(kd_kelurahan,1,7)' => $id
					));

		if($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return array();
		}
	}
	
	/**********************************************************************************************************/
	/* PUSKESMAS																							  */
	/**********************************************************************************************************/
	function get_all_puskesmas()
	{
		$this->db->select('puskesmas.*, kecamatan.nm_kecamatan, jenis_puskesmas.jenis_puskesmas');
		$this->db->from('puskesmas');
		$this->db->join('kecamatan', 'puskesmas.kd_kecamatan = kecamatan.kd_kecamatan');
		$this->db->join('jenis_puskesmas', 'puskesmas.id_jenis_puskesmas = jenis_puskesmas.id_jenis_puskesmas');
		$query = $this->db->get();
		
		//$query	=	$this->db->get('kota' );
		return $query->result_array();
	}
	
	function get_puskesmas_by_id($id)
	{
		$query	=	$this->db->get_where('puskesmas', array(
						'kd_puskesmas' => $id
					));
		return $query->result_array();
	}
	
	function get_list_kecamatan($id)
	{
		$this->db->like('kd_kecamatan', $id, 'after');
		$result	= $this->db->get('kecamatan');	

		if($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return array();
		}
	}


	function get_all_jenis_puskesmas()
	{
		$result	= $this->db->get('jenis_puskesmas');	

		if($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return array();
		}
	}
	
	function get_list_puskesmas()
	{
		$this->db->select('*');
		$this->db->from('puskesmas');
		$query = $this->db->get();
		return $query->result_array();
	}

    function get_list_kelurahan()
    {
        $this->db->select('*');
        $this->db->from('kelurahan');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_list_all_kecamatan()
    {
        $this->db->select('*');
        $this->db->from('kecamatan');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_profile_puskesmas()
    {
        $this->db->select('propinsi.nm_propinsi,set_puskesmas.telp,set_puskesmas.nip_kpl,set_puskesmas.kpl_puskesmas,
                    set_puskesmas.alamat,set_puskesmas.nm_puskesmas,set_puskesmas.kd_puskesmas,set_puskesmas.`status`,
                    set_puskesmas.logo, kecamatan.nm_kecamatan,kota.nm_kota,kelurahan.nm_kelurahan');
        $this->db->from('set_puskesmas');
        $this->db->join('propinsi','propinsi.kd_propinsi = set_puskesmas.kd_propinsi');
        $this->db->join('kota','kota.kd_kota = set_puskesmas.kd_kota');
        $this->db->join('kelurahan','kelurahan.kd_kelurahan = set_puskesmas.kd_kelurahan');
        $this->db->join('kecamatan','kecamatan.kd_kecamatan = set_puskesmas.kd_kecamatan');
        $this->db->where('set_puskesmas.status','1');

        $query = $this->db->get();
        return $query->result_array();
    }
	/**********************************************************************************************************/
	/* AGAMA																							  */
	/**********************************************************************************************************/
	function get_all_agama()
	{
		$this->db->select('*');
		$this->db->from('agama');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_agama_by_id($id)
	{
		$query	=	$this->db->get_where('agama', array(
						'kd_agama' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* CARA BAYAR																							  */
	/**********************************************************************************************************/
	function get_all_cara_bayar()
	{
		$this->db->select('*');
		$this->db->from('cara_bayar');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_cara_bayar_by_id($id)
	{
		$query	=	$this->db->get_where('cara_bayar', array(
						'kd_bayar' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* CARA MASUK PASIEN																							  */
	/**********************************************************************************************************/
	function get_all_cara_masuk()
	{
		$this->db->select('*');
		$this->db->from('cara_masuk');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_cara_masuk_by_id($id)
	{
		$query	=	$this->db->get_where('cara_masuk', array(
						'kd_cara_masuk' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* JENIS KELAMIN																							  */
	/**********************************************************************************************************/
	function get_all_jenis_kelamin()
	{
		$this->db->select('*');
		$this->db->from('jenis_kelamin');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_jenis_kelamin_by_id($id)
	{
		$query	=	$this->db->get_where('jenis_kelamin', array(
						'kd_jenis_kelamin' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* RAS / SUKU																						  */
	/**********************************************************************************************************/
	function get_all_ras()
	{
		$this->db->select('*');
		$this->db->from('ras');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_ras_by_id($id)
	{
		$query	=	$this->db->get_where('ras', array(
						'kd_ras' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* STATUS MARITAL																						  */
	/**********************************************************************************************************/
	function get_all_status_marital()
	{
		$this->db->select('*');
		$this->db->from('status_marital');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_status_marital_by_id($id)
	{
		$query	=	$this->db->get_where('status_marital', array(
						'kd_status_marital' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* GOLONGAN DARAH																						  */
	/**********************************************************************************************************/
	function get_all_gol_darah()
	{
		$this->db->select('*');
		$this->db->from('golongan_darah');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_gol_darah_by_id($id)
	{
		$query	=	$this->db->get_where('golongan_darah', array(
						'kd_gol_darah' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* PENDIDIKAN																						  */
	/**********************************************************************************************************/
	function get_all_pendidikan()
	{
		$this->db->select('*');
		$this->db->from('pendidikan');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_pendidikan_by_id($id)
	{
		$query	=	$this->db->get_where('pendidikan', array(
						'kd_pendidikan' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* PEKERJAAN																						  */
	/**********************************************************************************************************/
	function get_all_pekerjaan()
	{
		$this->db->select('*');
		$this->db->from('pekerjaan');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_pekerjaan_by_id($id)
	{
		$query	=	$this->db->get_where('pekerjaan', array(
						'kd_pekerjaan' => $id
					));
		return $query->result_array();
	}

	/**********************************************************************************************************/
	/* STOK OBAT */
	/**********************************************************************************************************/
	function get_all_masuk() {
		$this->db->select('brg_masuk_header.*, milik_obat.kepemilikan');
		$this->db->from('brg_masuk_header');
		$this->db->order_by('kd_masuk', 'desc');
		$this->db->join('milik_obat', 'brg_masuk_header.kd_milik_obat = milik_obat.kd_milik_obat');

        $query = $this->db->get();
		return $query->result_array();
	
	}
/* --------- OPNAME GUDANG ---------------------*/

    function get_all_opname() {
        $this->db->select('opname_header.*');
        $this->db->from('opname_header');
        $this->db->order_by('opname_code', 'desc');

        $query = $this->db->get();
        return $query->result_array();

    }

    function get_opname_by_id($id)
    {
        $query	=	$this->db->get_where('opname_header', array(
            'opname_code' => $id
        ));
        return $query->result_array();
    }
/* -------------------- END -------------------------*/

/* --------- STOK AWAL GUDANG ---------------------*/

    function get_all_awal_gudang() {
        $this->db->select('sawal_gudang_header.*');
        $this->db->from('sawal_gudang_header');
        $this->db->order_by('sawal_code', 'desc');

        $query = $this->db->get();
        return $query->result_array();

    }

    function get_awal_gudang_by_id($id)
    {
        $query	=	$this->db->get_where('sawal_gudang_header', array(
            'sawal_code' => $id
        ));
        return $query->result_array();
    }
    /* -------------------- END -------------------------*/

/* --------- STOK AWAL APOTEK ---------------------*/

    function get_all_awal_apotek() {
        $this->db->select('sawal_apotek_header.*');
        $this->db->from('sawal_apotek_header');
        $this->db->order_by('sawal_code', 'desc');

        $query = $this->db->get();
        return $query->result_array();

    }

    function get_awal_apotek_by_id($id)
    {
        $query	=	$this->db->get_where('sawal_apotek_header', array(
            'sawal_code' => $id
        ));
        return $query->result_array();
    }
    /* -------------------- END -------------------------*/

/* -------------- OPNAME APOTEK ----------------------*/

    function get_all_opname_apotek() {
        $this->db->select('opname_apotek_header.*');
        $this->db->from('opname_apotek_header');
        $this->db->order_by('opname_code', 'desc');

        $query = $this->db->get();
        return $query->result_array();

    }

    function get_opname_apotek_by_id($id)
    {
        $query	=	$this->db->get_where('opname_apotek_header', array(
            'opname_code' => $id
        ));
        return $query->result_array();
    }

/* -------------------- END -------------------------*/

	function get_all_masuk_apotek() {
		$this->db->select('*');
		$this->db->from('brg_masuk_apotek_header');
		$this->db->order_by('kd_masuk', 'desc');
		//$this->db->join('milik_obat', 'brg_masuk_apotek_header.kd_milik_obat = milik_obat.kd_milik_obat');
		//$this->db->join('unit_farmasi', 'brg_masuk_header.kd_unit_farmasi = unit_farmasi.kd_unit_farmasi');
		$query = $this->db->get();
		return $query->result_array();
	
	}
	
	public function ItemIn($id){
		$t = "SELECT kd_masuk FROM brg_masuk_detail WHERE kd_masuk='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}

 public function ItemAwal($id){
        $t = "SELECT sawal_code FROM sawal_gudang_detail WHERE sawal_code='$id'";
        $d = $this->m_crud->manualQuery($t);
        $r = $d->num_rows();
        if($r>0){
            $hasil = $r;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }
public function ItemAwalApotek($id){
        $t = "SELECT sawal_code FROM sawal_apotek_detail WHERE sawal_code='$id'";
        $d = $this->m_crud->manualQuery($t);
        $r = $d->num_rows();
        if($r>0){
            $hasil = $r;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }

    /* -------------- Hitung Record Opname ---------------- */
    public function OpnameRec($id){
        $t = "SELECT opname_code FROM opname_detail WHERE opname_code='$id'";
        $d = $this->m_crud->manualQuery($t);
        $r = $d->num_rows();
        if($r>0){
            $hasil = $r;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }

    public function OpnameApotekRec($id){
        $t = "SELECT opname_code FROM opname_apotek_detail WHERE opname_code='$id'";
        $d = $this->m_crud->manualQuery($t);
        $r = $d->num_rows();
        if($r>0){
            $hasil = $r;
        }else{
            $hasil = 0;
        }
        return $hasil;
    }


	public function ItemInApotek($id){
		$t = "SELECT kd_masuk FROM brg_masuk_apotek_detail WHERE kd_masuk='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlIn($id){
		$t = "SELECT sum(jml * harga_beli) as jml FROM brg_masuk_detail WHERE kd_masuk='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlInSum($id){
		$t = "SELECT sum(jml * 1) as jml FROM brg_masuk_detail WHERE kd_masuk='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlInApotek($id){
		$t = "SELECT sum(jml) as jml FROM brg_masuk_apotek_detail WHERE kd_masuk='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlInApotekSum($id){
		$t = "SELECT sum(jml * 1) as jml FROM brg_masuk_apotek_detail WHERE kd_masuk='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function ItemOut($id){
		$t = "SELECT kd_keluar FROM barang_keluar_detail WHERE kd_keluar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlOutSum($id){
		$t = "SELECT sum(jml * 1) as jml FROM barang_keluar_detail WHERE kd_keluar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlOutApotek($id){
		$t = "SELECT sum(jml) as jml FROM brg_apotek_keluar_detail WHERE kd_keluar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}

	public function JmlOutApotekSum($id){
		$t = "SELECT sum(jml * 1) as jml FROM brg_apotek_keluar_detail WHERE kd_keluar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function ItemOutApotek($id){
		$t = "SELECT kd_keluar FROM brg_apotek_keluar_detail WHERE kd_keluar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function ItemBayarObat($id){
		$t = "SELECT kd_bayar FROM bobat_detail WHERE kd_bayar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function ItemTindakan($id){
		$t = "SELECT kd_bayar FROM btindakan_detail WHERE kd_bayar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			$hasil = $r;
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function JmlKeluar($id){
		$t = "SELECT sum(jml * harga_beli) as jml FROM barang_keluar_detail WHERE kd_keluar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function JmlBayarObat($id){
		$t = "SELECT sum(jml * harga_jual) as jml FROM bobat_detail WHERE kd_bayar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	public function JmlTindakan($id){
		$t = "SELECT sum(jml * harga_jual) as jml FROM btindakan_detail WHERE kd_bayar='$id'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	
	/**********************************************************************************************************/
	/* OBAT KELUAR */
	/**********************************************************************************************************/
	
	function get_all_keluar() {
		$this->db->select('barang_keluar_header.*, unit_farmasi.nama_unit_farmasi');
		$this->db->from('barang_keluar_header');
		$this->db->order_by('kd_keluar', 'desc');
		$this->db->join('unit_farmasi', 'barang_keluar_header.kd_unit_farmasi = unit_farmasi.kd_unit_farmasi');
		$query = $this->db->get();
		return $query->result_array();
	
	}

	function get_all_apotek_keluar() {
		$this->db->select('brg_apotek_keluar_header.id_keluar,brg_apotek_keluar_header.kd_keluar,brg_apotek_keluar_header.tgl_keluar,
                    brg_apotek_keluar_header.keterangan,brg_apotek_keluar_header.kd_unit_farmasi,brg_apotek_keluar_header.kd_trans_pelayanan,
                    pasien.nm_lengkap');
		$this->db->from('brg_apotek_keluar_header');
		$this->db->order_by('kd_keluar', 'desc');
        	$this->db->join('pelayanan','brg_apotek_keluar_header.kd_trans_pelayanan = pelayanan.kd_trans_pelayanan','left');
        	$this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
		$query = $this->db->get();
		return $query->result_array();
    	}
	function get_keluar_by_id($id)
	{
		$query	=	$this->db->get_where('barang_keluar_header', array(
						'kd_keluar' => $id
					));
		return $query->result_array();
	}
	function get_apotek_keluar_by_id($id)
	{
		$query	=	$this->db->get_where('brg_apotek_keluar_header', array(
						'kd_keluar' => $id
					));
		return $query->result_array();
	}
	
	
	
	/**********************************************************************************************************/
	/* PEMBAYARAN OBAT DAN TINDAKAN */
	/**********************************************************************************************************/
	function get_all_bayar_tindakan() {
		$this->db->select('btindakan_header.id_bayar,btindakan_header.tgl_bayar,btindakan_header.kd_bayar,btindakan_header.kd_rekam_medis,
                        btindakan_header.bayar,btindakan_header.kembalian,btindakan_header.nopelayanan,pasien.nm_lengkap,pasien.no_reg');
		$this->db->from('btindakan_header');
		$this->db->order_by('kd_bayar', 'desc');
        $this->db->join('pasien','btindakan_header.kd_rekam_medis = pasien.kd_rekam_medis','left');
		$query = $this->db->get();
		return $query->result_array();
	
	}
		
	function get_bayar_tindakan_by_id($id)
	{
		$query	=	$this->db->get_where('btindakan_header', array(
						'kd_bayar' => $id
					));
		return $query->result_array();
	}
	
	function get_all_bayar_obat() {
		$this->db->select('*');
		$this->db->from('bobat_header');
		$this->db->order_by('kd_bayar', 'desc');
		$query = $this->db->get();
		return $query->result_array();
	
	}
	
	function get_bayar_obat_by_id($id)
	{
		$query	=	$this->db->get_where('bobat_header', array(
						'kd_bayar' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* OBAT */
	/**********************************************************************************************************/
	function get_all_obat()
	{
		$this->db->select('obat.*, golongan_obat.gol_obat, satuan_kecil.sat_kecil_obat, terapi_obat.terapi_obat');
		$this->db->from('obat');
		$this->db->join('golongan_obat', 'obat.kd_gol_obat = golongan_obat.kd_gol_obat');
		$this->db->join('satuan_kecil', 'obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat');
		$this->db->join('terapi_obat', 'obat.kd_terapi_obat = terapi_obat.kd_terapi_obat');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_obat_by_id($id)
	{
		$query	=	$this->db->get_where('obat', array(
						'kd_obat' => $id
					));
		return $query->result_array();
	}
	
	function get_list_golongan_obat($id)
	{
		$this->db->select('*');
		$this->db->from('golongan_obat');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_satuan_kecil($id)
	{
		$this->db->select('*');
		$this->db->from('satuan_kecil');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	
	
	function get_list_terapi_obat($id)
	{
		$this->db->select('*');
		$this->db->from('terapi_obat');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_obat($q){
		$this->db->select('kd_obat,nama_obat,apotek_stok');
		$this->db->like('nama_obat', $q);
		$this->db->or_like('kd_obat', $q);
		
		$query = $this->db->get('obat');
		$results = array();
		if($query->num_rows > 0){
			$i = 1;
			foreach ($query->result_array() as $row){
				$results[$i]['label'] = $row['kd_obat'].' - '.$row['nama_obat']; //build an array
				$results[$i]['value'] = htmlentities(stripslashes($row['nama_obat']));
				$results[$i]['kd_obat'] = htmlentities(stripslashes($row['kd_obat']));
				$results[$i]['apotek_stok'] = htmlentities(stripslashes($row['apotek_stok']));
				$i++;
		  	}
		}
		return $results;
	}
	function get_dosis($q){
		$this->db->select('takaran_dosis');
		$this->db->like('takaran_dosis', $q);
		
		$query = $this->db->get('dosis');
		$results = array();
		if($query->num_rows > 0){
			$i = 1;
			foreach ($query->result_array() as $row){
				$results[$i]['label'] = $row['takaran_dosis']; //build an array
				$results[$i]['value'] = htmlentities(stripslashes($row['takaran_dosis']));
				$results[$i]['takaran_dosis'] = htmlentities(stripslashes($row['takaran_dosis']));
			
				$i++;
		  	}
		}
		return $results;
	}
	function get_list_sat_kecil()
	{
		$this->db->select('*');
		$this->db->from('satuan_kecil');
		$query = $this->db->get();
		
		return $query->result_array();
	}	

	/**********************************************************************************************************/
	/* SETINGAN TANGGAL INDONESIA */
	/**********************************************************************************************************/
		
	
	
	public function ambilTgl($tgl){
		$exp = explode('-',$tgl);
		$tgl = $exp[2];
		return $tgl;
	}
	
	public function ambilBln($tgl){
		$exp = explode('-',$tgl);
		$tgl = $exp[1];
		$bln = $this->m_crud->getBulan($tgl);
		$hasil = substr($bln,0,3);
		return $hasil;
	}
	
	public function tgl_indo($tgl){
			$jam = substr($tgl,11,10);
			$tgl = substr($tgl,0,10);
			$tanggal = substr($tgl,8,2);
			$bulan = $this->m_crud->getBulan(substr($tgl,5,2));
			$tahun = substr($tgl,0,4);
			return $tanggal.' '.$bulan.' '.$tahun.' '.$jam;		 
	}	

	public function getBulan($bln){
		switch ($bln){
			case 1: 
				return "Januari";
				break;
			case 2:
				return "Februari";
				break;
			case 3:
				return "Maret";
				break;
			case 4:
				return "April";
				break;
			case 5:
				return "Mei";
				break;
			case 6:
				return "Juni";
				break;
			case 7:
				return "Juli";
				break;
			case 8:
				return "Agustus";
				break;
			case 9:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	} 
	
	
	/**********************************************************************************************************/
	/* GUDANG STOK OBAT */
	/**********************************************************************************************************/
		
	function get_all_barang_masuk()
	{
		$this->db->select('brg_masuk_header.*, brg_masuk_detail.kd_masuk ');
		$this->db->from('brg_masuk_header');
		$this->db->join('brg_masuk_detail','brg_masuk_header.kd_masuk = brg_masuk_detail.kd_masuk');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_masuk_by_id($id)
	{
		$query	=	$this->db->get_where('brg_masuk_header', array(
						'kd_masuk' => $id
					));
		return $query->result_array();
	}
	
	function get_all_barang_masuk_apotek()
	{
		$this->db->select('brg_masuk_apotek_header.*, brg_masuk_apotek_detail.kd_masuk ');
		$this->db->from('brg_masuk_apotek_header');
		$this->db->join('brg_masuk_apotek_detail','brg_masuk_apotek_header.kd_masuk = brg_masuk_apotek_detail.kd_masuk');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_apotek_masuk_by_id($id)
	{
		$query	=	$this->db->get_where('brg_masuk_apotek_header', array(
						'kd_masuk' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* GOLONGAN OBAT*/
	/**********************************************************************************************************/
	function get_all_golongan_obat()
	{
		$this->db->select('*');
		$this->db->from('golongan_obat');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_golongan_obat_by_id($id)
	{
		$query	=	$this->db->get_where('golongan_obat', array(
						'kd_gol_obat' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* HARGA OBAT */
	/**********************************************************************************************************/
	function get_all_harga_obat()
	{
		$this->db->select('harga_obat.*, obat.nama_obat');
		$this->db->from('harga_obat');
		$this->db->join('obat', 'harga_obat.kd_obat = obat.kd_obat');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_harga_obat_by_id($id)
	{
		$query	=	$this->db->get_where('harga_obat', array(
						'kd_tarif' => $id
					));
		return $query->result_array();
	}
	

	function get_list_obat() {
		$this->db->select('obat.*, satuan_kecil.sat_kecil_obat ');
		$this->db->from('obat');
		$this->db->join('satuan_kecil', 'obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat');
		$query = $this->db->get();
		
		return $query->result_array();
	}



	function get_list_milik_obat()
	{
		$this->db->select('*');
		$this->db->from('milik_obat');
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_list_unit_farmasi()
	{
		$this->db->select('*');
		$this->db->from('unit_farmasi');
		$query = $this->db->get();
		return $query->result_array();
	}

		
	
	
	/**********************************************************************************************************/
	/* JENIS OBAT*/
	/**********************************************************************************************************/
	function get_all_jenis_obat()
	{
		$this->db->select('*');
		$this->db->from('jenis_obat');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_jenis_obat_by_id($id)
	{
		$query	=	$this->db->get_where('jenis_obat', array(
						'kd_jenis_obat' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* MILIK OBAT*/
	/**********************************************************************************************************/
	function get_all_milik_obat()
	{
		$this->db->select('*');
		$this->db->from('milik_obat');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_milik_obat_by_id($id)
	{
		$query	=	$this->db->get_where('milik_obat', array(
						'kd_milik_obat' => $id
					));
		return $query->result_array();
	}

    function get_setting_puskesmas_id($id)
    {
        $query	=	$this->db->get_where('set_puskesmas', array(
            'kd_puskesmas' => $id
        ));
        return $query->result_array();
    }
	/**********************************************************************************************************/
	/* STOK OBAT*/
	/**********************************************************************************************************/
	
	public function CariJmlBeli($kode){
		$t = "SELECT kd_obat,sum(jml) as jml FROM brg_masuk_detail WHERE kd_obat='$kode' GROUP BY kd_obat";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlKeluar($kode){
		$t = "SELECT kd_obat,sum(jml) as jml FROM barang_keluar_detail WHERE kd_obat='$kode' GROUP BY kd_obat";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariJmlJualObat($kode){
		$t = "SELECT kd_obat,sum(jml) as jml FROM bobat_detail WHERE kd_obat='$kode' GROUP BY kd_obat";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->jml;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariStokAwal($kode){
		//$t = "SELECT kd_obat.obat,stok_awal.obat FROM obat INNER JOIN satuan_kecil ON obat.kd_sat_kecil_obat = satuan_kecil.kd_sat_kecil_obat WHERE kd_obat.obat='$kode'";
		$t = "SELECT kd_obat, stok_awal FROM obat WHERE kd_obat='$kode'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->stok_awal;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function CariStokAkhir($kode){
		$awal	 = $this->m_crud->CariStokAwal($kode);
		$beli	 = $this->m_crud->CariJmlBeli($kode);
		$keluar	 = $this->m_crud->CariJmlKeluar($kode);
		$jual 	 = $this->m_crud->CariJmlJualObat($kode);
		$hasil	 = ($awal+$beli)-$keluar-$jual;
		return $hasil;
	}
	
	public function StokAkhir($kode){
		$t = "SELECT kd_obat, obat_stok FROM obat WHERE kd_obat='$kode'";
		$d = $this->m_crud->manualQuery($t);
		$r = $d->num_rows();
		if($r>0){
			foreach($d->result() as $h){
				$hasil = $h->obat_stok;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
	}
	
	public function StokAwal($kode){
		$akhir	 = $this->m_crud->StokAkhir($kode);
		$beli	 = $this->m_crud->CariJmlBeli($kode);
		$keluar	 = $this->m_crud->CariJmlKeluar($kode);
		$jual 	 = $this->m_crud->CariJmlJualObat($kode);
		$hasil	 = ($akhir-$beli)+$keluar+$jual;
		return $hasil;
	}
	
	
	/**********************************************************************************************************/
	/* SATUAN KECIL OBAT*/
	/**********************************************************************************************************/
	function get_all_satuan_kecil()
	{
		$this->db->select('*');
		$this->db->from('satuan_kecil');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_satuan_kecil_by_id($id)
	{
		$query	=	$this->db->get_where('satuan_kecil', array(
						'kd_sat_kecil_obat' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* TERAPI OBAT*/
	/**********************************************************************************************************/
	function get_all_terapi_obat()
	{
		$this->db->select('*');
		$this->db->from('terapi_obat');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_terapi_obat_by_id($id)
	{
		$query	=	$this->db->get_where('terapi_obat', array(
						'kd_terapi_obat' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* UNIT FARMASI*/
	/**********************************************************************************************************/
	function get_all_unit_farmasi()
	{
		$this->db->select('*');
		$this->db->from('unit_farmasi');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_unit_farmasi_by_id($id)
	{
		$query	=	$this->db->get_where('unit_farmasi', array(
						'kd_unit_farmasi' => $id
					));
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* TAKARAN DOSIS*/
	/**********************************************************************************************************/
	function get_dosis_by_id($id)
	{
		$query	=	$this->db->get_where('dosis', array(
						'kd_dosis' => $id
					));
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* GOLONGAN PETUGAS */
	/**********************************************************************************************************/
	function get_all_golongan_petugas()
	{
		$this->db->select('*');
		$this->db->from('golongan_petugas');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_golongan_petugas_by_id($id)
	{
		$query	=	$this->db->get_where('golongan_petugas', array(
						'kd_gol' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* PETUGAS */
	/**********************************************************************************************************/
	function get_all_petugas()
	{
		$this->db->select('petugas.*,unit_pelayanan.nm_unit, golongan_petugas.nama_gol, posisi.posisi, spesialisasi.spesialisasi, pendidikan_kesehatan.pendidikan');
		$this->db->from('petugas');
		$this->db->join('unit_pelayanan', 'petugas.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');
		$this->db->join('golongan_petugas', 'petugas.kd_gol = golongan_petugas.kd_gol');
		$this->db->join('posisi', 'petugas.kd_posisi = posisi.kd_posisi');
		$this->db->join('spesialisasi', 'petugas.kd_spesialisasi = spesialisasi.kd_spesialisasi');
		$this->db->join('pendidikan_kesehatan', 'petugas.kd_pendidikan = pendidikan_kesehatan.kd_pendidikan');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_petugas_by_id($id)
	{
		$query	=	$this->db->get_where('petugas', array(
						'kd_petugas' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* POSISI*/
	/**********************************************************************************************************/
	function get_all_posisi()
	{
		$this->db->select('*');
		$this->db->from('posisi');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_posisi_by_id($id)
	{
		$query	=	$this->db->get_where('posisi', array(
						'kd_posisi' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* SPESIALISASI*/
	/**********************************************************************************************************/
	function get_all_spesialisasi()
	{
		$this->db->select('*');
		$this->db->from('spesialisasi');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_spesialisasi_by_id($id)
	{
		$query	=	$this->db->get_where('spesialisasi', array(
						'kd_spesialisasi' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* PENDIDIKAN KESEHATAN*/
	/**********************************************************************************************************/
	function get_all_pendidikan_kesehatan()
	{
		$this->db->select('*');
		$this->db->from('pendidikan_kesehatan');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_pendidikan_kesehatan_by_id($id)
	{
		$query	=	$this->db->get_where('pendidikan_kesehatan', array(
						'kd_pendidikan' => $id
					));
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* SARANA POSYANDU																							  */
	/**********************************************************************************************************/
	function get_all_sarana_posyandu()
	{
		$this->db->select('*');
		$this->db->from('sarana_posyandu');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_sarana_posyandu_by_id($id)
	{
		$query	=	$this->db->get_where('sarana_posyandu', array(
						'kd_sarana_posyandu' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* LABORATORIUM																							  */
	/**********************************************************************************************************/
	function get_tindakan_lab($q){
		$this->db->select('kd_produk,produk,harga');
		$this->db->like('produk', $q);
		$this->db->where('kriteria', 'laboratorium');
		
		$query = $this->db->get('tindakan');
		$results = array();
		if($query->num_rows > 0){
			$i = 1;
			foreach ($query->result_array() as $row){
				$results[$i]['label'] = htmlentities(stripslashes($row['produk'])); //build an array
				$results[$i]['value'] = htmlentities(stripslashes($row['produk']));
				$results[$i]['kd_produk'] = htmlentities(stripslashes($row['kd_produk']));
				$results[$i]['harga'] = htmlentities(stripslashes($row['harga']));
				$i++;
		  	}
		}
		return $results;
	}
	
	/**********************************************************************************************************/
	/* TINDAKAN																							  */
	/**********************************************************************************************************/
	function get_tindakan($q){
		$this->db->select('kd_produk,produk,harga');
		$this->db->like('produk', $q);
		$this->db->where('kriteria', 'tindakan');
		
		$query = $this->db->get('tindakan');
		$results = array();
		if($query->num_rows > 0){
			$i = 1;
			foreach ($query->result_array() as $row){
				$results[$i]['label'] = htmlentities(stripslashes($row['produk'])); //build an array
				$results[$i]['value'] = htmlentities(stripslashes($row['produk']));
				$results[$i]['kd_produk'] = htmlentities(stripslashes($row['kd_produk']));
				$results[$i]['harga'] = htmlentities(stripslashes($row['harga']));
				$i++;
		  	}
		}
		return $results;
	}
	
	
	function get_all_tindakan()
	{
		$this->db->select('*');
		$this->db->from('tindakan');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	function get_tindakan_by_id($id)
	{
		$query	=	$this->db->get_where('tindakan', array(
						'kd_produk' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* ASAL PASIEN																						  */
	/**********************************************************************************************************/
	function get_all_asal_pasien()
	{
		$this->db->select('*');
		$this->db->from('asal_pasien');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_asal_pasien_by_id($id)
	{
		$query	=	$this->db->get_where('asal_pasien', array(
						'kd_asal' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* UNIT PELAYANAN																					  */
	/**********************************************************************************************************/
	function get_all_unit_pelayanan()
	{
		$this->db->select('*');
		$this->db->from('unit_pelayanan');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_unit_pelayanan_by_id($id)
	{
		$query	=	$this->db->get_where('unit_pelayanan', array(
						'kd_unit_pelayanan' => $id
					));
		return $query->result_array();
	}
	
	function get_pelayanan_by_date() {
		$query	=	$this->db->get_where('pelayanan', array(
						'tgl_pelayanan' => date ('Y-m-d')
					));
		return $query->result_array();
	
	}
	
	/**********************************************************************************************************/
	/* ICD INDUK																					  */
	/**********************************************************************************************************/
	function get_all_icd_induk()
	{
		$this->db->select('*');
		$this->db->from('icd_induk');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_icd_induk_by_id($id)
	{
		$query	=	$this->db->get_where('icd_induk', array(
						'kd_icd_induk' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* ICD 																			  */
	/**********************************************************************************************************/
	
	function get_list_penyakit($id)
	{
		$this->db->select('*');
		$this->db->from('icd');
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_all_icd()
	{
		$this->db->select('*');
		$this->db->from('icd');
		$this->db->join('icd_induk', 'icd.kd_icd_induk = icd_induk.kd_icd_induk');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_icd_by_id($id)
	{
		$query	=	$this->db->get_where('icd', array(
						'kd_penyakit' => $id
					));
		return $query->result_array();
	}
	function get_list_icd_induk()
	{
		$this->db->select('*');
		$this->db->from('icd_induk');
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_icd($q){
		$this->db->select('kd_penyakit,penyakit');
		$this->db->like('kd_penyakit', $q);
		$this->db->or_like('penyakit', $q);
		
		
		$query = $this->db->get('icd');
		$results = array();
		if($query->num_rows > 0){
			$i = 1;
			foreach ($query->result_array() as $row){
				$results[$i]['label'] = $row['kd_penyakit'].' - '.$row['penyakit']; //build an array
				$results[$i]['value'] = htmlentities(stripslashes($row['kd_penyakit']));
				$results[$i]['penyakit'] = htmlentities(stripslashes($row['penyakit']));
				$i++;
		  	}
		}
		return $results;
	}
	/**********************************************************************************************************/
	/* Jenis Kasus																			  */
	/**********************************************************************************************************/
	function get_all_jenis_kasus()
	{
		$this->db->select('*');
		$this->db->from('jenis_kasus');
		$this->db->join('icd_induk', 'jenis_kasus.kd_icd_induk = icd_induk.kd_icd_induk');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_jenis_kasus_by_id($id)
	{
		$query	=	$this->db->get_where('jenis_kasus', array(
						'index_kasus' => $id
					));
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* Kasus																			  */
	/**********************************************************************************************************/
	function get_all_kasus()
	{
		$this->db->select('*');
		$this->db->from('kasus');
		$this->db->join('jenis_kasus', 'kasus.kd_jenis_kasus = jenis_kasus.kd_jenis_kasus');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_kasus_by_id($id)
	{
		$query	=	$this->db->get_where('kasus', array(
						'kd_jenis_kasus' => $id
					));
		return $query->result_array();
	}
	function get_list_jenis_kasus()
	{
		$this->db->select('*');
		$this->db->from('jenis_kasus');
		$query = $this->db->get();
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* Dokter																			  */
	/**********************************************************************************************************/
	function get_all_dokter()
	{
		$this->db->select('*');
		$this->db->from('dokter');
		//$this->db->join('puskesmas', 'dokter.kd_puskesmas = puskesmas.kd_puskesmas');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_dokter_by_id($id)
	{
		$query	=	$this->db->get_where('dokter', array(
						'kd_dokter' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* Kamar																	  */
	/**********************************************************************************************************/
	function get_all_kamar()
	{
		$this->db->select('*');
		$this->db->from('kamar');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_kamar_by_id($id)
	{
		$query	=	$this->db->get_where('kamar', array(
						'kd_kamar' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* Status Keluar Pasien																	  */
	/**********************************************************************************************************/
	function get_all_status_keluar_pasien()
	{
		$this->db->select('*');
		$this->db->from('status_keluar_pasien');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_status_keluar_pasien_by_id($id)
	{
		$query	=	$this->db->get_where('status_keluar_pasien', array(
						'kd_status_pasien' => $id
					));
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* Ruangan																  */
	/**********************************************************************************************************/
	function get_all_ruangan()
	{
		$this->db->select('*');
		$this->db->from('ruangan');
		$this->db->join('puskesmas', 'ruangan.kd_puskesmas = puskesmas.kd_puskesmas');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_ruangan_by_id($id)
	{
		$query	=	$this->db->get_where('ruangan', array(
						'kd_ruangan' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* Kelompok Pasien														  */
	/**********************************************************************************************************/
	function get_all_kelompok_pasien()
	{
		$this->db->select('*');
		$this->db->from('kelompok_pasien');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_kelompok_pasien_by_id($id)
	{
		$query	=	$this->db->get_where('kelompok_pasien', array(
						'kd_kelompok_pasien' => $id
					));
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* Kategori Imunisasi													  */
	/**********************************************************************************************************/
	function get_all_kategori_imunisasi()
	{
		$this->db->select('*');
		$this->db->from('kategori_imunisasi');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_kategori_imunisasi_by_id($id)
	{
		$query	=	$this->db->get_where('kategori_imunisasi', array(
						'kd_kategori_imunisasi' => $id
					));
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* Jenis Pasien												  */
	/**********************************************************************************************************/
	function get_all_jenis_pasien()
	{
		$this->db->select('*');
		$this->db->from('jenis_pasien');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_jenis_pasien_by_id($id)
	{
		$query	=	$this->db->get_where('jenis_pasien', array(
						'kd_jenis_pasien' => $id
					));
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* Jenis Imunisasi												  */
	/**********************************************************************************************************/
	function get_all_jenis_imunisasi()
	{
		$this->db->select('*');
		$this->db->from('jenis_imunisasi');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_jenis_imunisasi_by_id($id)
	{
		$query	=	$this->db->get_where('jenis_imunisasi', array(
						'kd_jenis_imunisasi' => $id
					));
		return $query->result_array();
	}
	/**********************************************************************************************************/
	/* Pendaftaran											  */
	/**********************************************************************************************************/
	function get_all_pendaftaran()
	{
		$this->db->select('*');
		$this->db->from('pasien');
		$this->db->order_by('kd_rekam_medis', 'desc');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_pendaftaran_by_id($id)
	{
		$query	=	$this->db->get_where('pasien', array(
						'kd_rekam_medis' => $id
					));
		return $query->result_array();
	}
	
	function get_list_jenis_kelamin($id)
	{
		$this->db->select('*');
		$this->db->from('jenis_kelamin');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_jp($id)
	{
		$this->db->select('*');
		$this->db->from('jenis_pasien');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_cb($id)
	{
		$this->db->select('*');
		$this->db->from('cara_bayar');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_agama($id)
	{
		$this->db->select('*');
		$this->db->from('agama');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_golongan_darah($id)
	{
		$this->db->select('*');
		$this->db->from('golongan_darah');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_pendidikan($id)
	{
		$this->db->select('*');
		$this->db->from('pendidikan');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_pekerjaan($id)
	{
		$this->db->select('*');
		$this->db->from('pekerjaan');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_ras($id)
	{
		$this->db->select('*');
		$this->db->from('ras');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_status_marital($id)
	{
		$this->db->select('*');
		$this->db->from('status_marital');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_provinsi($id)
	{
		$this->db->select('*');
		$this->db->from('propinsi');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_kota()
	{
		$this->db->select('*');
		$this->db->from('kota');
		//$this->db->join('propinsi', 'substr(1,2,kota.kd_kota) = propinsi.kd_propinsi');

		$query = $this->db->get();
		
		//$query	=	$this->db->get('kota' );
		return $query->result_array();
	}
	
	function get_list_kcmt()
	{
		$this->db->select('*');
		$this->db->from('kecamatan');
		//$this->db->join('propinsi', 'substr(1,2,kota.kd_kota) = propinsi.kd_propinsi');

		$query = $this->db->get();
		
		//$query	=	$this->db->get('kota' );
		return $query->result_array();
	}
	/*
	function get_list_kelurahan()
	{
		$this->db->select('*');
		$this->db->from('kelurahan');
		//$this->db->join('propinsi', 'substr(1,2,kota.kd_kota) = propinsi.kd_propinsi');

		$query = $this->db->get();
		
		//$query	=	$this->db->get('kota' );
		return $query->result_array();
	}*/
	
	function get_list_spesialisasi($id)
	{
		$this->db->select('*');
		$this->db->from('spesialisasi');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_ruangan($id)
	{
		$this->db->select('*');
		$this->db->from('ruangan');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_kamar()
	{
		$this->db->select('*');
		$this->db->from('kamar');
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_list_kamar_by_id($kd_ruangan)
	{
		$query	=	$this->db->get_where('kamar', array(
						'kd_ruangan' => $kd_ruangan
					));
		return $query->result_array();
	}
	function get_list_petugas($id)
	{
		$this->db->select('*');
		$this->db->from('petugas');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_unit_pelayanan($id)
	{
		$this->db->select('*');
		$this->db->from('unit_pelayanan');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* PELAYANAN*/
	/**********************************************************************************************************/
	function get_all_pelayanan()
	{
		$this->db->select('*');
		$this->db->from('pasien');
		$this->db->order_by('kd_rekam_medis', 'desc');
		//$query = $this->db->get();
		//$this->db->join('unit_pelayanan', 'pasien.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan');
		//$this->db->join('pasien', 'pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
		//$this->db->join('cara_bayar', 'pelayanan.kd_bayar = cara_bayar.kd_bayar');
		//$this->db->join('jenis_kasus', 'pelayanan.kd_jenis_kasus = jenis_kasus.kd_jenis_kasus');
		//$this->db->join('tindakan', 'pelayanan.kd_produk = tindakan.kd_produk');
		//$this->db->join('obat', 'pelayanan.kd_obat = obat.kd_obat');
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function get_pelayanan_by_id($id)
	{
		$query	=	$this->db->get_where('pelayanan', array(
						'kd_trans_pelayanan' => $id
					));

		return $query->result_array();
	}	
	
		
	function get_list_jenis_pasien()
	{
		$this->db->select('*');
		$this->db->from('jenis_pasien');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_pendaftaran()
	{
		$this->db->select('*');
		$this->db->from('pasien');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_cara_bayar()
	{
		$this->db->select('*');
		$this->db->from('cara_bayar');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_tindakan()
	{
		$this->db->select('*');
		$this->db->from('tindakan');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_obat1()
	{
		$this->db->select('*');
		$this->db->from('obat');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_sk()
	{
		$this->db->select('*');
		$this->db->from('satuan_kecil');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_dokter()
	{
		$this->db->select('*');
		$this->db->from('dokter');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_sp()
	{
		$this->db->select('*');
		$this->db->from('status_keluar_pasien');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	/**********************************************************************************************************/
	/* GROUP PENGGUNA */
	/**********************************************************************************************************/
	function get_all_group_pengguna()
	{
		$query	=	$this->db->get('akses' );
		return $query->result_array();
	}
	
	function get_group_pengguna_by_id($id)
	{
		$query	=	$this->db->get_where('akses', array(
						'id_akses' => $id
					));

		return $query->result_array();
	}

/**********************************************************************************************************/
	/* JENIS LAYANAN																						  */
	/**********************************************************************************************************/
	function get_list_jenis_layanan()
	{
		$this->db->select('*');
		$this->db->from('jenis_layanan');
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_list_jenis_diagnosa()
	{
		$this->db->select('*');
		$this->db->from('jenis_diagnosa');
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_list_ruangan_by_id($pkm_id)
	{
		$query	=	$this->db->get_where('ruangan', array(
						'kd_puskesmas' => $pkm_id
					));
		return $query->result_array();
	}
	
	function get_list_status_keluar($id)
	{
		$this->db->select('*');
		$this->db->from('status_keluar_pasien');
		$query = $this->db->get();
		return $query->result_array();
	}

	// Tambahan module
	function get_list_pasien($rm) // untuk view rekam medis
	{
		/*
		$this->db->select('pasien.nm_lengkap,pasien.nik,pasien.tempat_lahir,pasien.tanggal_lahir,golongan_darah.gol_darah,jenis_kelamin.jenis_kelamin,pasien.no_kk,pasien.nm_kk,cara_bayar.cara_bayar,pasien.kd_rekam_medis,status_marital.status_marital,pasien.nm_ibu,pasien.kd_puskesmas,puskesmas.nm_puskesmas');
		$this->db->from('pasien');
		$this->db->join('golongan_darah', 'pasien.kd_gol_darah = golongan_darah.kd_gol_darah');
		$this->db->join('jenis_kelamin', 'pasien.kd_jenis_kelamin = jenis_kelamin.kd_jenis_kelamin');
		$this->db->join('cara_bayar', 'pasien.kd_bayar = cara_bayar.kd_bayar');
		$this->db->join('status_marital', 'pasien.kd_status_marital = status_marital.kd_status_marital');
		$this->db->join('puskesmas', 'pasien.kd_puskesmas = puskesmas.kd_puskesmas');
		$this->db->where('pasien.kd_rekam_medis', $rm);
		*/
		
		$this->db->select('pasien.nm_lengkap,pasien.no_reg,pasien.nik,pasien.tempat_lahir,pasien.tanggal_lahir,pasien.alamat, jenis_kelamin.jenis_kelamin,pasien.no_kk,pasien.nm_kk,pasien.kd_rekam_medis,pasien.nm_ibu,pasien.kd_puskesmas,puskesmas.nm_puskesmas');
		$this->db->from('pasien');
		$this->db->join('jenis_kelamin', 'pasien.kd_jenis_kelamin = jenis_kelamin.kd_jenis_kelamin');
		
		//$this->db->join('golongan_darah', 'pasien.kd_gol_darah = golongan_darah.kd_gol_darah');
		//$this->db->join('cara_bayar', 'pasien.kd_bayar = cara_bayar.kd_bayar');
		//$this->db->join('status_marital', 'pasien.kd_status_marital = status_marital.kd_status_marital');
		
		$this->db->join('puskesmas', 'pasien.kd_puskesmas = puskesmas.kd_puskesmas');
		$this->db->where('pasien.kd_rekam_medis', $rm);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return array();
		
	}
	
	function get_list_pelayanan_penyakit_by_id($id)
	{
		$this->db->select('pelayanan_penyakit.*,icd.penyakit');
		$this->db->from('pelayanan_penyakit');
		$this->db->join('icd', 'pelayanan_penyakit.kd_penyakit = icd.kd_penyakit');
		$this->db->where('pelayanan_penyakit.kd_trans_pelayanan', $id);
		
		$query = $this->db->get();

		return $query->result_array();
	}
	
	function get_total_pelayanan_penyakit_by_id($id)
	{
		$this->db->select('pelayanan_penyakit.*,icd.penyakit');
		$this->db->from('pelayanan_penyakit');
		$this->db->join('icd', 'pelayanan_penyakit.kd_penyakit = icd.kd_penyakit');
		$this->db->where('pelayanan_penyakit.kd_trans_pelayanan', $id);
		
		$query = $this->db->get();
		return $query->num_rows() +1 ;
	}
	
	function get_list_pelayanan_tindakan_by_id($id)
	{
		$this->db->select('pelayanan_tindakan.*,tindakan.produk,tindakan.harga, tindakan.kriteria');
		$this->db->from('pelayanan_tindakan');
		$this->db->join('tindakan', 'pelayanan_tindakan.kd_produk = tindakan.kd_produk');
		$this->db->where('pelayanan_tindakan.kd_trans_pelayanan', $id);
		$this->db->where('tindakan.kriteria', 'tindakan');
		
		$query = $this->db->get();

		return $query->result_array();
	}
	
	function get_list_pelayanan_lab_by_id($id)
	{
		$this->db->select('pelayanan_tindakan.*,tindakan.produk,tindakan.harga, tindakan.kriteria');
		$this->db->from('pelayanan_tindakan');
		$this->db->join('tindakan', 'pelayanan_tindakan.kd_produk = tindakan.kd_produk');
		$this->db->where('pelayanan_tindakan.kd_trans_pelayanan', $id);
		$this->db->where('tindakan.kriteria', 'laboratorium');
		
		$query = $this->db->get();

		return $query->result_array();
	}
	
	function get_total_pelayanan_tindakan_by_id($id)
	{
		$this->db->select('pelayanan_tindakan.*,tindakan.produk,tindakan.harga, tindakan.kriteria');
		$this->db->from('pelayanan_tindakan');
		$this->db->join('tindakan', 'pelayanan_tindakan.kd_produk = tindakan.kd_produk');
		$this->db->where('pelayanan_tindakan.kd_trans_pelayanan', $id);
		$this->db->where('tindakan.kriteria', 'tindakan');
		
		$query = $this->db->get();
		return $query->num_rows() +1 ;
	}
	
	function get_total_pelayanan_lab_by_id($id)
	{
		$this->db->select('pelayanan_tindakan.*,tindakan.produk,tindakan.harga, tindakan.kriteria');
		$this->db->from('pelayanan_tindakan');
		$this->db->join('tindakan', 'pelayanan_tindakan.kd_produk = tindakan.kd_produk');
		$this->db->where('pelayanan_tindakan.kd_trans_pelayanan', $id);
		$this->db->where('tindakan.kriteria', 'laboratorium');
		
		$query = $this->db->get();
		return $query->num_rows() +1 ;
	}
	function get_list_pelayanan_obat_by_id($id)
	{
		$this->db->select('pelayanan_obat.*,obat.nama_obat');
		$this->db->from('pelayanan_obat');
		$this->db->join('obat', 'pelayanan_obat.kd_obat = obat.kd_obat');
		$this->db->where('pelayanan_obat.kd_trans_pelayanan', $id);
		
		$query = $this->db->get();

		return $query->result_array();
	}
	
	function get_total_pelayanan_obat_by_id($id)
	{
		$this->db->select('pelayanan_obat.*,obat.nama_obat');
		$this->db->from('pelayanan_obat');
		$this->db->join('obat', 'pelayanan_obat.kd_obat = obat.kd_obat');
		$this->db->where('pelayanan_obat.kd_trans_pelayanan', $id);
		
		$query = $this->db->get();
		return $query->num_rows() +1 ;
	}
	
	function get_list_grup()
	{
		$result	= $this->db->query('SELECT * FROM akses WHERE id_akses <> 1');	

		if($result->num_rows() > 0) {
			return $result->result_array();
		} else {
			return array();
		}
	}
	function get_user_by_id($id)
	{
		$query	=	$this->db->get_where('user', array(
						'id_user' => $id
					));
		return $query->result_array();
	}
	function get_list_ruang()
	{
		$this->db->select('*');
		$this->db->from('ruangan');
		$query = $this->db->get();
		return $query->result_array();
	}
	/* Generate rekam medis (admin) */
	function generate_rekam_medis($id)
	{
		$this->db->select('MAX(kd_rekam_medis) as no_rm');
		$this->db->from('pasien');
		$this->db->where('kd_puskesmas', $id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0 ){
			foreach($query->result() as $t){
				$rm = $t->no_rm; 
				$tmp = ((int) substr($rm,-5,5))+1;
				$hasil = $id.'-'.sprintf("%05s", $tmp);
			}
		}else{
			$hasil = $id.'-'.'00001';
		}
		
		return $hasil;
	}
	function get_pasien_rekam_medis($rm) // untuk view rekam medis
	{
		$this->db->select('*');
		$this->db->from('v_trans_pelayanan');
		$this->db->where('kd_rekam_medis', $rm);
		$this->db->order_by('tgl_pelayanan', 'desc');
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return array();
	}

	

	function generate_transaksi()
	{
		$this->db->select('MAX(kd_trans_pelayanan) as kd_trans_pelayanan');
		$this->db->from('pelayanan');

		$query = $this->db->get();
		
		if($query->num_rows() > 0 ){
			foreach($query->result() as $t){
				$ktp = $t->kd_trans_pelayanan; 
				$tmp = ((int) substr($ktp,-10,10))+1;
				$hasil = 'TR-'.sprintf("%010s", $tmp);
			}
		}else{
			$hasil = 'TR-'.'0000000001';
		}
		
		return $hasil;
	}
	
	function get_list_bed_by_id($kd_bed)
	{
		$this->db->select('kamar.kd_bed, kamar.kd_ruangan, ruangan.nm_ruangan');
		//$this->db->from('bed');$this->db->join('kamar', 'bed.kd_kamar = kamar.kd_kamar');
		$this->db->from('kamar');
		$this->db->join('ruangan', 'kamar.kd_ruangan = ruangan.kd_ruangan');
		$this->db->where('kamar.kd_bed', $kd_bed);
	
		$query = $this->db->get();
		
		if($query->num_rows() > 0 )
			return $query->row_array();
		else
			return array();
	}
	function get_pasien_by_id($rm, $sess = NULL)
	{
		$this->db->select('pasien.nm_lengkap,pasien.nik,pasien.tempat_lahir,pasien.tanggal_lahir,pasien.alamat,jenis_kelamin.jenis_kelamin,pasien.no_kk,pasien.nm_kk');
		$this->db->from('pasien');
		//$this->db->join('golongan_darah', 'pasien.kd_gol_darah = golongan_darah.kd_gol_darah');
		$this->db->join('jenis_kelamin', 'pasien.kd_jenis_kelamin = jenis_kelamin.kd_jenis_kelamin');
		//$this->db->join('cara_bayar', 'pasien.kd_bayar = cara_bayar.kd_bayar');
		$this->db->where('pasien.kd_rekam_medis', $rm);
		
		if ($sess !== NULL){
			$this->db->where('pasien.kd_puskesmas', $sess);
		}
		$query = $this->db->get();
		
		if($query->num_rows() > 0 ){
			foreach($query->result() as $t){
				$data['nm_lengkap'] 	= $t->nm_lengkap;
				$data['nik']			= $t->nik;
				$data['tempat_lahir']	= $t->tempat_lahir;
				$data['tanggal_lahir']	= convert_date_indo($t->tanggal_lahir);
				//$data['tanggal_lahir']	= $t->tanggal_lahir;
				$data['jenis_kelamin']	= $t->jenis_kelamin;
				$data['alamat']		= $t->alamat;	
				$data['no_kk']			= $t->no_kk;
				$data['nm_kk']			= $t->nm_kk;
				//$data['cara_bayar']		= $t->cara_bayar;
			}
		} else {
			$data['nm_lengkap'] 	= '';
			$data['nik']			= '';
			$data['tempat_lahir']	= '';
			$data['tanggal_lahir']	= '';
			$data['alamat']		= '';
			$data['no_kk']			= '';
			$data['nm_kk']			= '';
			//$data['cara_bayar']		= '';
		}
		
		return json_encode($data);
	}

	function get_list_golongan_petugas($id)
	{
		$this->db->select('*');
		$this->db->from('golongan_petugas');
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_list_pendidikan_kesehatan($id)
	{
		$this->db->select('*');
		$this->db->from('pendidikan_kesehatan');
		$query = $this->db->get();
		return $query->result_array();
	}
	function get_list_posisi($id)
	{
		$this->db->select('*');
		$this->db->from('posisi');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function get_list_golongan_umur()
	{
		$this->db->select('*');
		$this->db->from('golongan_umur');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function calculate_age_in_days($curr_date, $dob)
	{
		$sql = "SELECT DATEDIFF('".$curr_date."','".$dob."') as umur_in_days";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}
	
	function get_info_puskesmas($id)
	{
		$this->db->select('puskesmas.*, kecamatan.nm_kecamatan, jenis_puskesmas.jenis_puskesmas');
		$this->db->from('puskesmas');
		$this->db->where('kd_puskesmas', $id);
		$this->db->join('kecamatan', 'puskesmas.kd_kecamatan = kecamatan.kd_kecamatan');
		$this->db->join('jenis_puskesmas', 'puskesmas.id_jenis_puskesmas = jenis_puskesmas.id_jenis_puskesmas');
		$query = $this->db->get();
		
		return $query->result_array();
	}

    function get_all_new_resep()
    {
        $this->db->distinct();
        $this->db->select('pelayanan.kd_trans_pelayanan,pelayanan.kd_rekam_medis,pelayanan.tgl_pelayanan,pelayanan_obat.sta_resep,
                        pasien.nm_lengkap');
        $this->db->from('pelayanan');
        $this->db->where('pelayanan_obat.sta_resep','N');
        $this->db->join('pelayanan_obat', 'pelayanan.kd_trans_pelayanan = pelayanan_obat.kd_trans_pelayanan');
        $this->db->join('pasien', 'pelayanan.kd_rekam_medis = pasien.kd_rekam_medis');
        $this->db->order_by('pelayanan.kd_trans_pelayanan','DESC');
        $this->db->limit(10);

        $query = $this->db->get();

        return $query->result_array();
    }
	
	
	function generate_queue($kd_unit){	//auto generate nomor antrian
		$curr_date = date("Y-m-d");
		$this->db->select('MAX(pelayanan.no_antrian) as no, unit_pelayanan.kd_antrian as kd_antrian');
		$this->db->from('pelayanan');
		$this->db->join('unit_pelayanan', 'unit_pelayanan.kd_unit_pelayanan=pelayanan.kd_unit_pelayanan');
		$this->db->where('pelayanan.tgl_pelayanan', $curr_date);
		$this->db->where('unit_pelayanan.kd_unit_pelayanan', $kd_unit);

		$sql = $this->db->get();

		if($sql->num_rows() > 0 ){
			foreach($sql->result() as $d){
				$no = $d->no;
				$kode = $d->kd_antrian;
				$tmp = ((int) substr($no, -3,3))+1;
				$hasil = $kode.'-'.sprintf("%03s", $tmp);
			}
		}else{
			foreach($sql->result() as $d){
				$kode = $d->kd_antrian;
				$hasil = $kode.'-'.'001';
			}
		}
		return $hasil;
	}


	
}

/* End of file m_crud.php */
/* Location: ./application/models/m_crud.php */