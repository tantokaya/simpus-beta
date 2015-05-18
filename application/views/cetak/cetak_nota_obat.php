<style type="text/css">
*{
font-family: Arial;
font-size:12px;
margin:0px;
padding:0px;
}
@page {
 margin-left:3cm 2cm 2cm 2cm;
}
table.grid{
width:80mm;
font-size: 12pt;
border-collapse:collapse;
}
table.grid th{
padding-top:1mm;
padding-bottom:1mm;
}
table.grid th{
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
text-align:center;
padding:7px;
}
table.grid tr td{
padding-top:0.5mm;
padding-bottom:0.5mm;
padding-left:2mm;
padding-right:2mm;
}
h1{
font-size: 18pt;
}
h2{
font-size: 14pt;
}
h3{
font-size: 10pt;
}
.kop{
	font-size:12px;
	margin-bottom:5px;
	width:80mm ;
}
.kop h2{
	font-size:22px;
}
.header{
display: block;
width:80mm ;
margin-bottom: 0.3cm;
text-align: left;
}
.attr{
font-size:9pt;
width: 100%;
padding-top:2pt;
padding-bottom:2pt;
border-top: 0.2mm solid #000;
border-bottom: 0.2mm solid #000;
}
.pagebreak {
width:80mm ;
page-break-after: always;
margin-bottom:10px;
}
.akhir {
width:80mm ;
}
.page {
width:80mm ;
font-size:12px;
}

</style>
<?php

if($data->num_rows()>0){

$kop 	= "<h2>PUSKESMAS</h2>";	
$kop 	.= "<p>BOGOR TIMUR</p>";
$kop 	.= "<p>Jl.........</p>";
$kop 	.= "<p>Telp. 0251- 999999</p>";
//$kop	.= "<p>".$tanggal."</p>";

$kop_kanan  =$tgl_bayar;
$kop_kanan  .= "<p><center> </center></p>";

$pasien	 = $nama_pasien;
$judul_H = $id;


function myheader($kop,$kop_kanan,$judul_H,$pasien){
?>
<div class="kop">
	<table width="100%">
    <tr>
    	<td align="center"><?php echo $kop;?></td>
    </tr>
	<br/><br/>
	<tr></tr>
	<tr></tr>
	<tr></tr>
	<tr>
		<td>==========================================</td>
	</tr>
	<tr>
		<td>Nomor  : <?php echo $judul_H; ?></td>
	</tr>
	<tr>
		<td>Tanggal : <?php echo $kop_kanan; ?></td>
	</tr>
	<tr>
		<td>Operator : </td>
	</tr>
	<tr>
		<td>Pasien : <?php  echo $pasien;?></td>
	</tr>
	<tr>
		<td>==========================================</td>
	</tr>
  </table>
</div>

<table class="grid">
<?php	
}
function myfooter(){	
?>
	</table>
<?php
}	
	$no=1;
	$page =1;
	$saldo=0;
	$jml = 0;
	foreach($data->result_array() as $db){

	$saldo = $db['jml']*$db['harga_jual'];
	$jml = $jml+$saldo;
	
	if(($no%40) == 1){
   	if($no > 1){
        myfooter();
	?>
    	<div class="pagebreak" align="right">
        <div class="page" align="center"><?php //hal ?></div>
        </div>
    <?php
		$page++;
  	}
   	myheader($kop,$kop_kanan,$judul_H,$pasien);
	}
	?>
    <tr>
        <td colspan="3" ><?php echo $db['nama_obat'];?><br/><?php echo $db['jml'];?> x <?php echo number_format($db['harga_jual']);?></td>
        <td align="right"><?php echo number_format($saldo);?></td>
	</tr>
	 <?php
	$no++;
	}
?>
	<tr>
		<td colspan="4">-----------------------------------------------------------------------</td>
	</tr>
	<tr>
    	<td colspan="3" align="right" style="font-size:15px;">Total Bayar :</td>
        <td align="right" style="font-size:16px;"><?php echo number_format($jml);?></td>
    </tr>
	<tr>
    	<td colspan="3" align="right" style="font-size:15px;">Bayar :</td>
        <td align="right" style="font-size:16px;"><?php echo  number_format($db['bayar']);?></td>
    </tr>
	<tr>
    	<td colspan="3" align="right" style="font-size:15px;">Kembalian :</td>
        <td align="right" style="font-size:16px;"><?php echo  number_format($db['kembalian']);?></td>
    </tr>
<?php    
myfooter();	
?>   
    </table>
	<div class="page" align="center">
	<br /><br /><br />
    <p>Terima Kasih <br />"Semoga Lekas Sembuh"</p>
	</div>
<?php
}else{
	echo "Tidak Ada Data";
}
?>