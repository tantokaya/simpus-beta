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
		
		$this->load->model('m_lap_mingguan');		
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
								
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);			
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_lap_mingguan->get_puskesmas_info($kd_puskesmas);
			
			$bln	= $this->input->post('bulan');
			$thn	= $this->input->post('tahun');
			$kd_penyakit = $this->input->post('kd_penyakit');
			$diagnosa = $this->m_lap_mingguan->get_icd($kd_penyakit);
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
			
			$icd = $this->m_lap_mingguan->get_mon_resep_by_icd($bln, $thn, $kd_penyakit);
			
			
			#echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
						
			$objPHPExcel->getActiveSheet()->setCellValue('D3', $puskesmas['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('J3', $bulan);
            $objPHPExcel->getActiveSheet()->setCellValue('J4', $thn);
			$objPHPExcel->getActiveSheet()->setCellValue('D5', $diagnosa['penyakit']);
			
            $i=9;
            $no=1;

            foreach($icd as $a){
				$tgl_kunjungan=$this->functions->convert_date_indo(array("datetime" => $a['tgl_pelayanan']));
               $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);	
			   $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $tgl_kunjungan);	
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $a['nm_lengkap']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $a['umur']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $a['anamnesa']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $a['tindakan']);	//tindakan
				
				$pecahObat = explode(';', $a['obat']);
				$pecahDosis = explode(';', $a['dosis_obat']);
				$pecahJml = explode(';', $a['jml_obat']);
				
				$obatku = '';
				for($z=0; $z < count($pecahObat); $z++){
					$obatku .= $pecahObat[$z] . " (" . $pecahDosis[$z] . ") (" . $pecahJml[$z].")";
					
					if($z != (count($pecahObat)-1))
						$obatku .= "\n";
				}

				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $obatku);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $a['jml_obat']);
				$i++;
				$no++;
            }

			
			$filename='Form_Monitoring_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		$data['page_name']  = 'RekapPenyakitPerMinggu';
		$data['page_title'] = 'Rekap Penyakit';
		$this->template->display('form_monitoring', $data);
		
	}
	

}
?>