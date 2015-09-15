<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cont_cetak_lap_mingguan extends CI_Controller
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
	
	
	function rekap_penyakit($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
		
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/rekap_penyakit.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_lap_mingguan->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);			

			$tgl_mulai	= $this->input->post('tgl_mulai');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			$kd_unit_pelayanan = $this->input->post('kd_unit_pelayanan');
			$unit = $this->m_lap_mingguan->get_unit_pelayanan_info($kd_unit_pelayanan);
			$icd = $this->m_lap_mingguan->get_pelayanan_penyakit_by_date($this->functions->convert_date_sql($tgl_mulai),$this->functions->convert_date_sql($tgl_akhir), $kd_unit_pelayanan);
			
			//echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			if ($kd_unit_pelayanan =='') {
				$unitnya = "SEMUA UNIT PELAYANAN";
			} else {$unitnya = $unit['nm_unit'];}
			
			$periode = $tgl_mulai.' sd '. $tgl_akhir;
			$objPHPExcel->getActiveSheet()->setCellValue('C2', $puskesmas['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('C3', $unitnya);
            $objPHPExcel->getActiveSheet()->setCellValue('C4', $periode);
			//$objPHPExcel->getActiveSheet()->setCellValue('C5', $tgl_akhir);

            $i=9;
            $no=1;

            foreach($icd as $rs){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['kd_penyakit']);
 
				if ($rs['jml']=='') {$rs['jml']= "-";}
				if ($rs['nm_kelurahan']=='') {$rs['nm_kelurahan']= "-";}
				if ($rs['penyakit']=='') {$rs['penyakit']= "-";}
				if ($rs['gol_umur']=='') {$rs['gol_umur']= "-";}
								
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $rs['penyakit']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $rs['nm_kelurahan']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $rs['gol_umur']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $rs['jml']);
     
                $i++;
                $no++;
            }

			
			$filename='Rekap_Penyakit_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['page_name']  = 'RekapPenyakitPerMinggu';
		$data['page_title'] = 'Rekap Penyakit';
		$this->template->display('form_rekap_penyakit', $data);
		
	}
	
	function rekap_pasien_penyakit($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
		
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/rekap_pasien_penyakit.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_lap_mingguan->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);			

			$tgl_mulai	= $this->input->post('tgl_mulai');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			$kd_penyakit = $this->input->post('kd_penyakit');
			$penyakit = $this->m_lap_mingguan->get_penyakit_info($kd_penyakit);
			$icd = $this->m_lap_mingguan->get_pelayanan_penyakit_by_icd($this->functions->convert_date_sql($tgl_mulai),$this->functions->convert_date_sql($tgl_akhir), $kd_penyakit);
			
			#echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			$periode = $tgl_mulai.' sd '. $tgl_akhir;
			if ($kd_penyakit =='') {
				$penyakitnya = "SEMUA JENIS PENYAKIT";
			} else {$penyakitnya = $penyakit['penyakit'];}
			
			$objPHPExcel->getActiveSheet()->setCellValue('C2', $puskesmas['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('C3', $penyakitnya);
            $objPHPExcel->getActiveSheet()->setCellValue('C4', $periode);
			//$objPHPExcel->getActiveSheet()->setCellValue('C5', $tgl_akhir);

            $i=9;
            $no=1;

            foreach($icd as $rs){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['nm_lengkap']);
				
				 switch($rs['kd_jenis_kelamin']){
                    case 1: $jk = "L"; break;
                    case 2: $jk = "P"; break;

                }
				
				if ($rs['idkartu_medical']=='') {$rs['idkartu_medical']= "-";}
				if ($rs['nm_kelurahan']=='') {$rs['nm_kelurahan']= "-";}
				if ($rs['alamat']=='') {$rs['alamat']= "-";}
								
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $jk);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $rs['umur']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $rs['nama_kk']);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $rs['alamat']);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $rs['nm_kelurahan']);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $rs['nm_kecamatan']);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $rs['penyakit']);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $rs['jenis_kasus']);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $rs['tgl_pelayanan']);
                $i++;
                $no++;
            }

			
			$filename='Rekap_Pasien_per_Penyakit_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		$data['list_penyakit']		= $this->m_crud->get_list_penyakit('1');
		$data['page_name']  = 'RekapPasienPerPenyakit';
		$data['page_title'] = 'Rekap Pasien per Penyakit';
		$this->template->display('form_rekap_penyakit_bydate', $data);
		
	}
	
	function rekap_obat_out_apotek($par1 = '', $par2 = '', $par3 = '')
	{
		if (!$this->session->userdata('logged_in') == true)
		{
			redirect('login');
		}
		
		if ($par1 == 'cetak') {
		
			$this->load->library('excel');
			require APPPATH."libraries/PHPExcel/IOFactory.php";
	
			$fileType		='Excel5';
			$inputFileName	= APPPATH . "libraries/rekap_obat_keluar_apotek.xls";
			
			$kd_puskesmas = $this->session->userdata('kd_puskesmas');
            $puskesmas = $this->m_lap_mingguan->get_puskesmas_info($kd_puskesmas);
						
			$objReader = PHPExcel_IOFactory::createReader($fileType); 
			$objReader->setIncludeCharts(TRUE);
			$objPHPExcel = $objReader->load($inputFileName); 
			$objPHPExcel->setActiveSheetIndex(0);			

			$tgl_mulai	= $this->input->post('tgl_mulai');
			$tgl_akhir	= $this->input->post('tgl_akhir');
			//$kd_unit_pelayanan = $this->input->post('kd_unit_pelayanan');
			//$unit = $this->m_lap_mingguan->get_unit_pelayanan_info($kd_unit_pelayanan);
			$apotek_out = $this->m_lap_mingguan->get_apotek_out_by_date($this->functions->convert_date_sql($tgl_mulai),$this->functions->convert_date_sql($tgl_akhir));
			
			#echo $this->db->last_query(); exit;  //untuk menampilkan sintaks query trakir
			
			#echo '<pre>'; print_r($data); exit;
			
			#echo('<pre>'); print_r($pasien); exit;
			
			/****************************************************************************************/
			/* HEADER DATA EXCEL
			/****************************************************************************************/
			$periode = $tgl_mulai.' sd '. $tgl_akhir;
			$objPHPExcel->getActiveSheet()->setCellValue('C2', $puskesmas['nm_puskesmas']);
			$objPHPExcel->getActiveSheet()->setCellValue('C3', $periode);

            $i = 7;
            $no = 1;

            foreach($apotek_out as $rs){
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $no);
                 
				if ($rs['total']=='') {$rs['total']= "-";}
				if ($rs['sat_kecil_obat']=='') {$rs['sat_kecil_obat']= "-";}
								
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $rs['kd_obat']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $rs['nama_obat']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $rs['total']);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $rs['sat_kecil_obat']);
				  
                $i++;
                $no++;
            }

			
			$filename='Rekap_Apotek_Keluar_'.date("d/m/Y H-i-s").'.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		
		}
		//$data['list_unit_pelayanan']		= $this->m_crud->get_list_unit_pelayanan('1');
		$data['page_name']  = 'RekapObatKeluarApotekPerMinggu';
		$data['page_title'] = 'Rekap Obat Keluar Apotek';
		$this->template->display('form_rekap_apotek_out', $data);
		
	}

}
?>