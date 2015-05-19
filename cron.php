<?php
ob_start();

$host	= 'localhost';
$user	= 'root';
$pass	= 'admin2013';
$db	= 'pus_bogortimur';

$conn = mysql_connect($host,$user,$pass) or die('gagal koneksi');
mysql_select_db($db, $conn);

# sample cron taken 1 jan 2015 form dec 2014 
# $cron_date = '2015-05-01';
$cron_date = date('Y-m-d');

$x = explode('-', $cron_date);

if($x[1] == 1){
	$bln = 12;
	$thn = $x[0]-1;
}else {
	$bln = $x[1]-1;
	$thn = $x[0];
}

$table_name = 'lb2_'.$bln;


#echo "<h3 align='center'>LB 2 BULAN ".$bln." ".$thn."</h3>";

$table = "<table border='1' width='100%' align='center' cellpadding='2' cellspacing='2'>";
$table .= "<thead>";
$table .= "<tr>";
$table .= "<th>KODE OBAT</th>";
$table .= "<th>NAMA OBAT</th>";
$table .= "<th>NO BATCH</th>";
$table .= "<th>TGL KADALUARSA</th>";

$table .= "<th>STOK AWAL</th>";
$table .= "<th>TERIMA</th>";
$table .= "<th>KELUAR</th>";
$table .= "<th>KELUAR KE PUSTU</th>";
$table .= "<th>KELUAR KE APOTIK</th>";
$table .= "<th>KELUAR KE UNIT LAIN</th>";
$table .= "<th>KELUAR APOTEK KE PASIEN</th>";
$table .= "<th>STOK AKHIR</th>";
$table .= "</tr>";
$table .= "</thead>";
$table .= "<tbody>";

// loop table obat
$obt = mysql_query("select kd_obat, nama_obat, obat_stok, apotek_stok, no_batch from obat");
while($rs_obat = mysql_fetch_array($obt)){

	// loop table barang masuk detail
	$sql = "select sum(jml) as terima from brg_masuk_detail where kd_obat='".$rs_obat[0]."' and (month(tgl_terima) = $bln and year(tgl_terima) = $thn)";
	$bmd = mysql_query($sql);
	# print $sql; exit;
	$rs_terima = mysql_fetch_array($bmd);
	mysql_free_result($bmd);
	
	// loop table barang keluar detail
	$sql2 = "select sum(jml) as keluar from barang_keluar_detail where kd_obat='".$rs_obat[0]."' and (month(tgl_keluar) = $bln and year(tgl_keluar) = $thn)";
	$bkd = mysql_query($sql2);
	# print $sql2; exit;
	$rs_keluar = mysql_fetch_array($bkd);
	mysql_free_result($bkd);
	
	// hitung stok awal
	$stok_awal = ($rs_obat[2] + $rs_keluar[0]) - $rs_terima[0];
	
	// tgl kadaluarsa
	$exp = mysql_query("select tgl_kadaluarsa from brg_masuk_detail where kd_obat = '".$rs_obat[0]."' order by tgl_kadaluarsa DESC LIMIT 1");
	$rs_exp = mysql_fetch_array($exp);
	mysql_free_result($exp);
	
	// keluar ke apotik
	$apt = mysql_query("select sum(bkd.jml) from barang_keluar_detail bkd left join barang_keluar_header bkh on bkd.kd_keluar = bkh.kd_keluar where bkd.kd_obat = '".$rs_obat[0]."' and (month(bkd.tgl_keluar) = $bln and year(bkd.tgl_keluar) = $thn) and bkh.kd_unit_farmasi='APT'");
	$rs_apt = mysql_fetch_array($apt);
	mysql_free_result($apt);
	
	// keluar ke pustu
	$pustu = mysql_query("select sum(bkd.jml) from barang_keluar_detail bkd left join barang_keluar_header bkh on bkd.kd_keluar = bkh.kd_keluar where bkd.kd_obat = '".$rs_obat[0]."' and (month(bkd.tgl_keluar) = $bln and year(bkd.tgl_keluar) = $thn) and bkh.kd_unit_farmasi like 'PUSTU%'");
	$rs_pustu = mysql_fetch_array($pustu);
	mysql_free_result($pustu);
	
	// keluar unit lain
	$rs_unit_lain = $rs_keluar[0] - ($rs_apt[0] + $rs_pustu[0]);

	// keluar apotek ke pasien
	$pas = mysql_query("select sum(jml) as klr_ke_pasien from brg_apotek_keluar_detail where kd_obat='".$rs_obat[0]."' and (month(tgl_keluar) = $bln and year(tgl_keluar) = $thn)");
	$rs_pas = mysql_fetch_array($pas);
	mysql_free_result($pas);

	$table .= "<tr>";
	$table .= "<td>$rs_obat[0]</td>";
	$table .= "<td>$rs_obat[1]</td>";
	$table .= "<td>$rs_obat[4]</td>";
	$table .= "<td>$rs_exp[0]</td>";
	$table .= "<td>$stok_awal</td>";
	$table .= "<td>$rs_terima[0]</td>";
	$table .= "<td>$rs_keluar[0]</td>";
	$table .= "<td>$rs_apt[0]</td>";
	$table .= "<td>$rs_pustu[0]</td>";
	$table .= "<td>$rs_unit_lain</td>";
	$table .= "<td>$rs_pas[0]</td>";
	$table .= "<td>$rs_obat[2]</td>";
	
	$table .= "</tr>";
	
	// inserting to db
	$sql3 = "INSERT INTO $table_name VALUES('$thn', '$rs_obat[0]', '$rs_obat[4]', '$rs_exp[0]', '$stok_awal', '$rs_terima[0]', '$rs_keluar[0]', '$rs_apt[0]', '$rs_pustu[0]', '$rs_unit_lain', '$rs_pas[0]', '$rs_obat[2]', '".date('Y-m-d h:i:s')."')";
	
	$insert = mysql_query($sql3) or die ("error insert");
	
	
	//echo $insert . '<br>';
	
}

mysql_free_result($obt);
mysql_close($conn);


$table .= "</tbody>";
$table .= "</table>";

#echo $table;
echo "LB 2 BULAN ".$bln." ".$thn." - ".date('Y-m-d h:i:s').", ";

ob_end_flush(); 
?>