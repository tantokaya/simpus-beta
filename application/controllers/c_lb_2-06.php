<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_lb_2 extends CI_Controller
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
		
		$this->load->model('m_lb2');		
		$this->load->library('template');		
		$this->load->library('Datatables');
        $this->load->library('table');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	
	function lb2($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/format_lb2_puskesmas.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
			
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);
			
			//get puskesmas info from session
			$data['puskesmas'] = $this->m_crud->get_info_puskesmas($kd_puskesmas);
			$bln	= $this->input->post('bulan');
			$thn	= $this->input->post('tahun');
			
			switch($bln)
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
			
			
			/****************************************************************************************/
			/* FILLING DATA EXCEL
			/****************************************************************************************/
			
			$objPHPExcel->getActiveSheet()->setCellValue('C4', ': '. $data['puskesmas'][0]['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('C5', ': '. $data['puskesmas'][0]['nm_kecamatan']);
			$objPHPExcel->getActiveSheet()->setCellValue('J4', $bulan);
			$objPHPExcel->getActiveSheet()->setCellValue('J5', $thn);
				
			/* DATA SET */
			
			// Param get_stok(bulan, tahun, kode obat)
			//------------------------------------------------------------------------------------------------
			
			$stok_all = $this->m_lb2->get_stok_all($bln, $thn);
			$i=13;
			$no=1;
			foreach($stok_all as $a){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);	
				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $a['nama_obat']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $a['sat_kecil_obat']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $a['stok_awal']);	
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $a['jml_terima']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $a['kluar_k_pustu']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $a['kluar_k_unit_lain']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $a['kluar_k_apt']);
				
				$b = $this->m_lb2->get_stok_opname($bln, $thn, $a['kd_obat']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $b);
				$i++;
				$no++;
			}

			$filename='LB2_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		
		$data['page_name']  = 'lb2';
		$data['page_title'] = 'LB2';
		$this->template->display('form_lb2', $data);
	}
	

}
?>