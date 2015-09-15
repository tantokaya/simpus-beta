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
width:15cm ;
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
border:1px solid #000;
padding:7px;
}
table.grid tr td{
padding-top:0.5mm;
padding-bottom:0.5mm;
padding-left:2mm;
padding-right:2mm;
border-bottom:0.2mm solid #000;
border:1px solid #000;
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
	width:15cm ;
}
.kop h2{
	font-size:22px;
}
.header{
display: block;
width:15cm ;
margin-bottom: 0.3cm;
text-align: center;
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
width:15cm ;
page-break-after: always;
margin-bottom:10px;
}
.akhir {
width:15cm ;
}
.page {
width:15cm ;
font-size:12px;
}

</style>
<?php

if($data->num_rows()>0){

    $kop 	= "<h2>$nm_puskesmas</h2>";
    $kop 	.= "<p>$alamat, $nm_kecamatan</p>";
    $kop 	.= "<p>$nm_kota - $nm_propinsi</p>";


$kop_kanan= '';

$judul_H = "LAPORAN SUMMARY BARANG MASUK - APOTEK";
$judul_H .= "<p> Tanggal ".$tgl1." s/d ".$tgl2."</p>";

function myheader($kop,$kop_kanan,$judul_H){
?>
<div class="kop">
	<table width="100%">
    <tr>
    	<td><?php echo $kop;?></td>
        <td><?php echo $kop_kanan;?></td>
   	</tr>
    </table>
</div>
<div class="header">
	<h2><?php echo $judul_H;?></h2>
</div>
<table class="grid">
<tr>
	<tr>
      <th>No.</th>
      <th>No Terima</th>
      <th>Tanggal</th>
      <th>Jml Item</th>
      <th>Total Jml</th>
    </tr>
</tr>
<?php	
}
function myfooter(){	
?>
	</table>
<?php
}
	$no=1;
	$page =1;
	$total=0;
	$g_total = 0;
	foreach($data->result_array() as $dp){
	$item = $this->m_crud->ItemInApotek($dp['kd_masuk']);
	$jmlIn = $this->m_crud->JmlInApotekSum($dp['kd_masuk']);
	$tgl = $this->m_crud->tgl_indo($dp['tgl_terima']);
	
	if(($no%25) == 1){
   	if($no > 1){
        myfooter();
        echo "<div class=\"pagebreak\" align='right'>
		<div class='page' align='center'>Hal - $page</div>
		</div>";
        $page++;
  	}
   	myheader($kop,$kop_kanan,$judul_H);
	}
	?>
    <tr>
	  <td style="text-align: center; width: 20px;"><?php echo $no; ?></td>
      <td style="text-align: center; width: 80px;"><?php echo $dp['kd_masuk']; ?></td>
      <td style="text-align: center; width: 90px;"><?php echo $tgl; ?></td>
      <td ><?php echo number_format($item); ?></td>
      <td ><?php echo number_format($jmlIn); ?></td>
     
	</tr>    
    <?php
	$g_total = $g_total+$total;
	$no++;
	}
?>
	<tr>
    	<!--<td colspan="3" align="right">Jumlah</td>
        <td align="right"><?php echo number_format($g_total);?></td>-->
    </tr>
<?php    
myfooter();	
?>   
    </table>
    <div class="page" align="center">Hal - <?php echo $page;?></div>
<?php
}else{
	echo "Tidak Ada Data";
}
?>