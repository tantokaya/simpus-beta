<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_register_harian extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    function get_puskesmas_info($kd_puskesmas){
        $this->db->select('nm_puskesmas');
        $this->db->from('puskesmas');
        $this->db->where('kd_puskesmas', $kd_puskesmas);

        $query = $this->db->get();
        return $query->row_array();
    }

	function get_pasien_rawat_umum_by_date($tgl){

        $this->db->select('dokter.nm_dokter,pelayanan.kd_trans_pelayanan, pelayanan.tgl_pelayanan, pasien.no_reg, pelayanan.kd_rekam_medis, pasien.nm_lengkap, pasien.kd_jenis_kelamin, pelayanan.umur, cara_bayar.cara_bayar, unit_pelayanan.nm_unit, pasien.alamat, status_keluar_pasien.style, status_keluar_pasien.keterangan');
        $this->db->from('pelayanan');
        $this->db->join('pasien','pelayanan.kd_rekam_medis = pasien.kd_rekam_medis','left');
        $this->db->join('cara_bayar','pelayanan.kd_bayar = cara_bayar.kd_bayar','left');
        $this->db->join('unit_pelayanan','pelayanan.kd_unit_pelayanan = unit_pelayanan.kd_unit_pelayanan','left');
        $this->db->join('status_keluar_pasien','pelayanan.kd_status_pasien = status_keluar_pasien.kd_status_pasien','left');
        $this->db->join('dokter','pelayanan.kd_dokter=dokter.kd_dokter','left');
        $this->db->where('pelayanan.tgl_pelayanan', $tgl);
        $this->db->order_by('dokter.nm_dokter, pelayanan.kd_trans_pelayanan','ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}