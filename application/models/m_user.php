<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_user extends CI_Model {
	
	public function get_login_info($email)
	{
		$hasil = $this->db
					->where('email',$email)
					->where('password',$password)
					->where('id_akses',$id_akses)
					->get('user');
		
		if($hasil->num_rows() > 0){
			return $hasil->row_array();
		} else {
			return FALSE;
		}
	}
	
}

/* End of file m_user.php */
/* Location: ./application/models/m_user.php */