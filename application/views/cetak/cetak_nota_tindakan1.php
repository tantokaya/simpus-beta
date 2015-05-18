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
width:15.2cm ;
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
	width:21.59cm ;
}
.kop h2{
	font-size:22px;
}
.header{
display: block;
width:21.59cm ;
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
width:21.59cm ;
page-break-after: always;
margin-bottom:10px;
}
.akhir {
width:21.59cm ;
}
.page {
width:15.2cm ;
font-size:12px;
}

</style>
<?php

if($data->num_rows()>0){

$kop 	= "<h2>PUSKESMAS</h2>";	
$kop 	.= "<p>BOGOR TIMUR</p>";
$kop 	.= "<p>Jl.........</p>";
$kop 	.= "<p>021- 999999</p>";
//$kop	.= "<p>".$tanggal."</p>";

$kop_kanan  = "<p> Bogor, ".$tgl_bayar."</p>";
$kop_kanan  .= "<p><center> </center></p>";
$kop_kanan  .= "<p>Pengirim</p>";
$kop_kanan  .= "<p>Jl.......</p>";

$judul_H = "NOTA NO. : ".$id;

function myheader($kop,$kop_kanan,$judul_H){
?>
<div class="kop">
	<table width="100%">
    <tr>
    	<td><?php echo $kop;?></td>
        <td><?php echo $kop_kanan;?></td>
   	</tr>
    </table>
</div><br/><br/>
<div class="header">
	<h2><?php echo $judul_H;?></h2>
</div>
<table class="grid">
<tr>
	<th width="5%">No</th>
    <th>Kode</th>
    <th width="40%">Keterangan</th>
	<th>Jml</th>
    <th width="15%">Harga </th>       
    <th>Jumlah</th>
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
   	myheader($kop,$kop_kanan,$judul_H);
	}
	?>
    <tr>
    	<td align="center"><?php echo $no;?></td>
        <td align="center"><?php echo $db['kd_produk'];?></td>
        <td><?php echo $db['produk'];?></td>
        <td align="center"><?php echo $db['jml'];?></td>
        <td align="right"><?php echo number_format($db['harga_jual']);?></td>
        <td align="right"><?php echo number_format($saldo);?></td>
	</tr>    
    <?php
	$no++;
	}
?>
	<tr>
    	<td colspan="5" align="right">Jumlah</td>
        <td align="right"><?php echo number_format($jml);?></td>
    </tr>
<?php    
myfooter();	
?>   
    </table>
	<div class="page" align="right">
	<br /><br />
    <p>Hormat Kami,</p>
    <br />
    <br />
    <br />
	<p>(......................................................)</p>
    </div>
<?php
}else{
	echo "Tidak Ada Data";
}
?>