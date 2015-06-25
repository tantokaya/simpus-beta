<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_cetak_lap_kasir extends CI_Controller
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
		
		$this->load->model('m_lap_kasir');		
		$this->load->library('template');

		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	
	function rekap_pembayaran($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
		
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/rekap_pembayaran1.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_lap_kasir->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);			

			$tgl_mulai	= $this->input->post('tgl_mulai');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			//$kd_unit_pelayanan = $this->input->post('kd_unit_pelayanan');
			//$unit = $this->m_lap_mingguan->get_unit_pelayanan_info($kd_unit_pelayanan);
			$uang = $this->m_lap_kasir->get_total_uang($this->functions->convert_date_sql($tgl_mulai),$this->functions->convert_date_sql($tgl_akhir));
			$rekap_uang = $this->m_lap_kasir->get_total_uang_rekap($this->functions->convert_date_sql($tgl_mulai),$this->functions->convert_date_sql($tgl_akhir));
			
			#echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			
			$periode = $tgl_mulai.' sd '. $tgl_akhir;
			$objPHPExcel->getActiveSheet()->setCellValue('C3', $puskesmas['nm_puskesmas']);
            $objPHPExcel->getActiveSheet()->setCellValue('C4', $periode);

            $i=7;
            $no=1;

            foreach($uang as $rs){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['jenis_tindakan']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $rs['produk']);				
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $rs['total_uang']);
				$i++;
                $no++;
            }
			$j=7;
            $nmr=1;
			 foreach($rekap_uang as $rsr) {	
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$j, $nmr);
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$j, $rsr['jenis_tindakan']);			
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$j, $rsr['total_uang']);
                $j++;
                $nmr++;
            }

			
			$filename='Rekap_Total_Pembayaran_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		$data['page_name']  = 'RekapTotalPembayaran';
		$data['page_title'] = 'Rekap Total Pembayaran';
		$this->template->display('form_rekap_total_kasir', $data);
		
	}
	
	function detail_pembayaran($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
		
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/rekap_pembayaran_detail.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_lap_kasir->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);			

			$tgl_mulai	= $this->input->post('tgl_mulai');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			$kd_jenis_tindakan = $this->input->post('kd_jenis_tindakan');
			$jenis_tindakan = $this->m_lap_kasir->get_jenis_tindakan_info($kd_jenis_tindakan);
			$detail_uang = $this->m_lap_kasir->get_detail_uang($this->functions->convert_date_sql($tgl_mulai),$this->functions->convert_date_sql($tgl_akhir), $kd_jenis_tindakan);
			$total_uang = $this->m_lap_kasir->get_jml_total_uang($this->functions->convert_date_sql($tgl_mulai),$this->functions->convert_date_sql($tgl_akhir), $kd_jenis_tindakan);
			#echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			if ($kd_jenis_tindakan =='') {
				$jenisnya = "Semua Jenis Tindakan";
			} else {$jenisnya = $jenis_tindakan['jenis_tindakan'];}
			
			$periode = $tgl_mulai.' sd '. $tgl_akhir;
			$objPHPExcel->getActiveSheet()->setCellValue('C2', $puskesmas['nm_puskesmas']);
            $objPHPExcel->getActiveSheet()->setCellValue('C3', $jenisnya);
			$objPHPExcel->getActiveSheet()->setCellValue('C4', $periode);
			$objPHPExcel->getActiveSheet()->setCellValue('H5', $total_uang['total']);

            $i=9;
            $no=1;

            foreach($detail_uang as $rs){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['jenis_tindakan']);				
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $rs['kd_bayar']);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $rs['tgl_bayar']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $rs['nama_pasien']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $rs['produk']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $rs['harga']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $rs['jml']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $rs['sub_total']);
					
                $i++;
                $no++;
            }

			
			$filename='Rekap_Total_Pembayaran_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		$data['list_jenis_tindakan'] = $this->m_lap_kasir->get_list_jenis_tindakan('1');
		$data['page_name']  = 'RekapDetailPembayaran';
		$data['page_title'] = 'Rekap Detail Pembayaran';
		$this->template->display('form_detail_pembayaran', $data);
		
	}

}
?>