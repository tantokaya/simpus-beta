<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_laporan extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// cek session
		if ($this->session->userdata('logged_in') == false && $this->session->userdata('id_akses') !== 2) {
			$this->session->unset_userdata();
			$this->session->sess_destroy();
			redirect('login');
		}
		
		$this->load->library('template');
		
		$this->load->library('Datatables');
        $this->load->library('table');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	/***Default function, redirects to login page if no admin logged in yet***/
	public function index()
	{
		if ($this->session->userdata('logged_in') == true)
			redirect('op_pendaftaran/dashboard');
		else
			redirect('login');	
	}
	
	function lb1($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/format_lb1.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
			
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);
			
			//get puskesmas info from session
			$data['puskesmas'] = $this->m_crud->get_info_puskesmas($kd_puskesmas);
			switch($this->input->post('bulan'))
			{
				case 1:
					$bulan = "JANUARI"; break;
				case 2:
					$bulan = "FEBRUARI"; break;
				case 3:
					$bulan = "MARET"; break;
				case 4:
					$bulan = "APRIL"; break;
				case 5:
					$bulan = "MEI"; break;
				case 6:
					$bulan = "JUNI"; break;
				case 7:
					$bulan = "JULI"; break;
				case 8:
					$bulan = "AGUSTUS"; break;
				case 9:
					$bulan = "SEPTEMBER"; break;
				case 10:
					$bulan = "OKTOBER"; break;
				case 11:
					$bulan = "NOVEMBER"; break;
				case 12:
					$bulan = "DESEMBER"; break;
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue('F1', $data['puskesmas'][0]['kd_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('F3', $data['puskesmas'][0]['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('F4', $data['puskesmas'][0]['nm_kecamatan']);
			$objPHPExcel->getActiveSheet()->setCellValue('AH5', $bulan);
			$objPHPExcel->getActiveSheet()->setCellValue('AH6', $this->input->post('tahun'));
			
			
			
			
			$filename='LB1_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		
		$data['page_name']  = 'lb1';
		$data['page_title'] = 'LB1';
		$this->template->display('form_lb1', $data);
	}
	
}
?>
	