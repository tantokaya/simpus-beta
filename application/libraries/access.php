<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Access {
	public $user;
	
	/************************
	* Constructor
	************************/
	function __construct()
	{
		$this->CI =& get_instance();
		$auth = $this->CI->config->item('auth');
		
		$this->CI->load->helper('cookie');
		$this->m_user =& $this->CI->m_user;
	}
	
	/************************
	* Cek Login User
	************************/
	function login($email, $password)
	{
		$result = $this->m_user->get_login_info($email);
		
		if($hasil) { // jika user ketemu
			
			$password = md5($password);
			if($password === $result->password){
				// start session
				$this->CI->session->set_userdata('email', $result->email);
				return TRUE;	
			}
		}
		return FALSE;	
	}
	
	/************************
	* Cek Apakah sudah Login
	************************/
	function is_login()
	{
		return(($this->CI->session->userdata('email')) ? TRUE : FALSE);	
	}
	
	/************************
	* Logout
	************************/
	function logout()
	{
		$this->CI->session->unset_userdata('email');
	}
	
}

/* End of file access.php */
/* Location: ./application/libraries/access.php */