<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/* ------------------------------
	// Konversi tanggal sql ke tgl indo
	// Y-m-d => d/m/Y
	// Usage :  convert_date_indo(array("datetime" => "2014-12-31")) return 21/12/2014
	-------------------------------*/
	function convert_date_indo($id)
	{
		$ci = & get_instance();
		
		$y=substr($id,2,2);
		$m=substr($id,5,2);
		$d=substr($id,8,2);
		
		return $d.'/'.$m.'/'.$y;
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
                        
            //return $years.'y '.$months.'m '.$days.'d';
			return $years.'y '.$months.'m'; 
        } 