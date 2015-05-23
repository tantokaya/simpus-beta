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
width:29.70cm ;
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
	width:29.70cm ;
}
.kop h2{
	font-size:22px;
}
.header{
display: block;
width:29.70cm ;
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
width:29.70cm ;
page-break-after: always;
margin-bottom:10px;
}
.akhir {
width:29.70cm ;
}
.page {
width:29.70cm ;
font-size:12px;
}

</style>
<?php

if($data->num_rows()>0){

$kop 	= "<h2>$nm_puskesmas</h2>";	
$kop 	.= "<p>$alamat</p>";


$kop_kanan= '';

$judul_H = "LAPORAN BARANG KELUAR DETAIL - GUDANG";
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
      <th>No Jual</th>
      <th>Tanggal</th>
      <th>Penerima</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <!--<th>Jumlah</th>-->
      <!--<th>Harga</th>-->
      <th>Total</th>
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
	$total = $dp['jml'];
	$tgl = $this->m_crud->tgl_indo($dp['tgl_keluar']);
	
	if(($no%25) == 1){
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
      <td width="20" align="center"><?php echo $no; ?></td>
      <td width="70" align="center"><?php echo $dp['kd_keluar']; ?></td>
      <td width="130" align="center"><?php echo $tgl; ?></td>
      <td width="80"><?php echo $dp['kd_unit_farmasi']; ?></td>
      <td width="60"><?php echo $dp['kd_obat']; ?></td>
      <td><?php echo $dp['nama_obat']; ?></td>
      <!--<td><center><?php echo $dp['jml']; ?></center></td>-->
      <!--<td align="right"><?php echo number_format($dp['harga_jual']); ?></td>-->
      <td align="right"><?php echo number_format($total); ?></td>
	</tr>    
    <?php
	$g_total = $g_total+$total;
	$no++;
	}
?>
	<tr>
    	<td colspan="6" align="right">Jumlah</td>
        <td align="right"><?php echo number_format($g_total);?></td>
    </tr>
<?php    
myfooter();	
?>   
    </table>
<?php
}else{
	echo "Tidak Ada Data";
}
?>