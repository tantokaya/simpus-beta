<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Function Library
|--------------------------------------------------------------------------
|
| Custom functions
|
|
*/

class Functions {
	/* ------------------------------
	// Konversi tanggal sql ke tgl indo
	// Y-m-d => d/m/Y
	// Usage :  convert_date_indo(array("datetime" => "2014-12-31")) return 21-12-2014
	-------------------------------*/
	function convert_date_indo($array)
	{
		$datetime=$array['datetime'];
		$y=substr($datetime,0,4);
		$m=substr($datetime,5,2);
		$d=substr($datetime,8,2);
		$conv_datetime=date("j-m-Y",mktime(1,0,0,$m,$d,$y));#"$d / $m / $y";
		return($conv_datetime);
	}
	
	/* ------------------------------
	// Konversi tanggal tgl indo ke sql
	// 
	// Usage :  convert_date_sql("31/12/2014") return 2014-12-31
	-------------------------------*/
	function convert_date_sql($date){
		// list($day, $month, $year) = split('[/.-]', $date); => DEPRECATED
		list($day, $month, $year) = preg_split('/[\/\.\-]/', $date);
		return "$year-".sprintf("%02d", $month)."-".sprintf("%02d", $day);
	}
	
	function check_bulan($tanggal){
		$bulan_array=array(
		"1"=>"Januari",
		"2"=>"Februari",
		"3"=>"Maret",
		"4"=>"April",
		"5"=>"Mei",
		"6"=>"Juni",
		"7"=>"Juli",
        "8"=>"Agustus",
        "9"=>"September",
        "10"=>"Oktober",
        "11"=>"November",
        "12"=>"Desember");
		// $tanggal_array=split('[/.-]', $tanggal); => DEPRECATED
		$tanggal_array = preg_split('/[\/\.\-]/', $tanggal);
		$bulan_n=date("n",mktime("1","1","1",$tanggal_array[1],$tanggal_array[2],$tanggal_array[0]));
		return $bulan_array[$bulan_n];
	}
    
    function format_tgl_cetak($tanggal) {
        list($year, $month, $day) = preg_split('/[\/\.\-]/', $tanggal);
		return $this->check_hari($tanggal).", ".intval($day)." ".$this->check_bulan($tanggal)." ".$year;        
    }
	
	function format_tgl_cetak2($tanggal) {
        list($year, $month, $day) = preg_split('/[\/\.\-]/', $tanggal);
		return intval($day)." ".$this->check_bulan($tanggal)." ".$year;        
    }
	
	function check_hari($tanggal){
        $hari_array=array(
		"1"=>"Senin",
		"2"=>"Selasa",
		"3"=>"Rabu",
		"4"=>"Kamis",
		"5"=>"Jumat",
		"6"=>"Sabtu",
		"7"=>"Minggu");
        
		$tanggal_array=preg_split('/-/', $tanggal); //Y-m-d
		// 1 Desember 2013 -> $tanggal_array[0] = 1, $tanggal_array[1] = Desember, $tanggal_array[2] = 2013
        $hari_n=date("N",mktime(0,0,0,$tanggal_array[1],$tanggal_array[2],$tanggal_array[0]));
		// 12, 1, 2013 -> mm-dd-yyyy
		return $hari_array[$hari_n];
	}
	
	function dateDifference($startDate, $endDate) 
        { 
            $startDate = strtotime($startDate); 
            $endDate = strtotime($endDate); 
            if ($startDate === false || $startDate < 0 || $endDate === false || $endDate < 0 || $startDate > $endDate) 
                return false; 
                
            $years = date('Y', $endDate) - date('Y', $startDate); 
            
            $endMonth = date('m', $endDate); 
            $startMonth = date('m', $startDate); 
            
            // Calculate months 
            $months = $endMonth - $startMonth; 
            if ($months <= 0)  { 
                $months += 12; 
                $years--; 
            } 
            if ($years < 0) 
                return false; 
            
            // Calculate the days 
             $offsets = array(); 
                        if ($years > 0) 
                            $offsets[] = $years . (($years == 1) ? ' year' : ' years'); 
                        if ($months > 0) 
                            $offsets[] = $months . (($months == 1) ? ' month' : ' months'); 
                        $offsets = count($offsets) > 0 ? '+' . implode(' ', $offsets) : 'now'; 

                        $days = $endDate - strtotime($offsets, $startDate); 
                        $days = date('z', $days);    
                        
            return array($years, $months, $days); 
        } 
	
	//fungsi buat hitung selisih hari
	function daysBetween($awal, $akhir)
		{
			$awal  = strtotime($awal);
			$akhir = strtotime($akhir);
			
			//hitung selisih
			return ($awal - $akhir) / (24 * 3600);
		}
	
}

/* End of file template.php */
/* Location: ./application/libraries/template.php */