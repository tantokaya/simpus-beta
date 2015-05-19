<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_cetak_lap_harian extends CI_Controller
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
		
		$this->load->model('m_register_harian');		
		$this->load->library('template');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	
	function register_harian($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/register_harian.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_register_harian->get_puskesmas_info($kd_puskesmas);
			
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);

			$tgl	= $this->input->post('tgl');
			$pasien = $this->m_register_harian->get_pasien_rawat_umum_by_date($this->functions->convert_date_sql($tgl));


         #  echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			$objPHPExcel->getActiveSheet()->setCellValue('C3', $puskesmas['nm_puskesmas']);
            $objPHPExcel->getActiveSheet()->setCellValue('H3', $tgl);



            $i=7;
            $no=1;

            foreach($pasien as $rs){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['nm_lengkap']);

                switch($rs['kd_jenis_kelamin']){
                    case 1: $jk = "L"; break;
                    case 2: $jk = "P"; break;

                }

                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $jk);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $rs['alamat']);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $rs['umur']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $rs['cara_bayar']);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $rs['keterangan']);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $rs['nm_dokter']);

                /*
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $a['jml_terima']);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $a['kluar_k_pustu']);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $a['kluar_k_unit_lain']);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $a['kluar_k_apt']);

                $b = $this->m_lb2->get_stok_opname($bln, $thn, $a['kd_obat']);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $b);
                */
                $i++;
                $no++;
            }




			$filename='Register_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		
		$data['page_name']  = 'Register Harian';
		$data['page_title'] = 'Register Harian';
		$this->template->display('form_register', $data);
	}
	

}
?>