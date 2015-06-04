<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class C_form_monitoring extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		// cek session
		if ($this->session->userdata('logged_in') == false) {
			$this->session->unset_userdata();
			$this->session->sess_destroy();
			redirect('login');
		}		
		$this->load->model('m_monitor_resep');	
		$this->load->library('template');
		
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	
	function monitor($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/form_monitoring_resep.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_lap_mingguan->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);			

			$bln	= $this->input->post('bulan');
			$thn	= $this->input->post('tahun');
			$kd_penyakit = $this->input->post('kd_penyakit');
			
			//$icd = $this->m_lap_mingguan->get_pelayanan_penyakit_by_date($this->functions->convert_date_sql($tgl_mulai),$this->functions->convert_date_sql($tgl_akhir), $kd_unit_pelayanan);
			
			//echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			
			$objPHPExcel->getActiveSheet()->setCellValue('D3', $puskesmas);	
			$objPHPExcel->getActiveSheet()->setCellValue('J3', $bulan);
			$objPHPExcel->getActiveSheet()->setCellValue('J4', $thn);


          $i=10;
			$no=1;
			foreach($hasil as $a){
				$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $a['tgl_pelayanan']);	
				//$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $no);	
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $a['nm_lengkap']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $a['umur']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $a['anamnesa']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $a['produk']);	//tindakan
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $a['nama_obat']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $a['dosis']);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $a['qty']);
				
				//$b = $this->m_monitor_resep->get_jml_obat_per_pasien($bln, $thn, $kd_penyakit);
			//	$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $b);
				$i++;
				$no++;
			}	
	
			$filename='monitoring_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');		
		
		}
		$data['page_name']  = 'monitoring';
		$data['page_title'] = 'Monitoring Resep';
		$this->template->display('form_monitoring', $data);

	}
	

}
?>