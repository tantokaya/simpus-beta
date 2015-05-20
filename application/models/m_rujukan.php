<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_rujukan extends CI_Model {
	
	function __construct()
    {
        parent::__construct();

    }

    function get_puskesmas_info($kd_puskesmas){
        $this->db->select('nm_puskesmas,alamat');
        $this->db->from('puskesmas');
        $this->db->where('kd_puskesmas', $kd_puskesmas);

        $query = $this->db->get();
        return $query->row_array();
    }

}