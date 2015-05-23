<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_email extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function password_reset_email($account_type = '' , $email = '')
	{
		$query			=	$this->db->get_where($account_type , array('email' => $email));
		if($query->num_rows() > 0)
		{
			$password	=	$query->row()->password;
			$email_msg	=	"Your account type is : ".$account_type."<br />";
			$email_msg	.=	"Your password is : ".$password."<br />";
			
			$email_sub	=	"Password reset request";
			$email_to	=	$email;
			$this->do_email($email_msg , $email_sub , $email_to);
			return true;
		}
		else
		{	
			return false;
		}
	}
	
	/***custom email sender****/
	function do_email($msg=NULL, $sub=NULL, $to=NULL, $from=NULL)
	{
		
		$config = array();
        $config['useragent']	= "CodeIgniter";
        $config['mailpath']		= "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol']		= "smtp";
        $config['smtp_host']	= "localhost";
        $config['smtp_port']	= "25";
        $config['mailtype']		= 'html';
        $config['charset']		= 'utf-8';
        $config['newline']		= "\r\n";
        $config['wordwrap']		= TRUE;

        $this->load->library('email');

        $this->email->initialize($config);

		$system_name	=	'Sistem Informasi Puskesmas Pemerintah Kota Bogor';
		if($from == NULL)
			$from		=	'simpus.bogor@gmail.com';
		
		$this->email->from($from, $system_name);
		//$this->email->from($from, $system_name);
		$this->email->to($to);
		$this->email->subject($sub);
		
		$msg	=	$msg;
		$this->email->message($msg);
		
		$this->email->send();
		
		echo $this->email->print_debugger();
	}
}

