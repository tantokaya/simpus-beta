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
width:21.59cm ;
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
width:21cm ;
font-size:12px;
}

</style>
<?php

if($data->num_rows()>0){

    $kop 	= "<h2>$nm_puskesmas</h2>";
    $kop 	.= "<p>$alamat, $nm_kelurahan, $nm_kecamatan, <br> $nm_kota - $nm_propinsi</p>";
    $logo_pus	.= "$logo";

$judul_H = "SURAT BARANG KELUAR NO. : ".$id;

function myheader($kop,$logo_pus,$judul_H){
?>
<div class="kop">
	<table width="100%">
    <tr>
        <td style="width:85;"><img src='<?php echo base_url();?>assets/img/thumbs/<?php echo $logo_pus; ?>' width="75" height="91"> </td>
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
    <th>Banyaknya</th>
	<th>Keterangan</th>
    <!--<th>Harga satuan</th>       
    <th>Jumlah</th>-->
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

	$saldo = $db['jml'];
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
   	myheader($kop,$logo_pus,$judul_H);
	}
	?>
    <tr>
    	<td align="center"><?php echo $no;?></td>
        <td align="center"><?php echo $db['jml']." ".$db['sat_kecil_obat'];?></td>
        <td><?php echo $db['nama_obat'];?></td>
        <!--<td align="right"><?php echo number_format($db['harga_beli']);?></td>
        <td align="right"><?php echo number_format($saldo);?></td>-->
	</tr>    
    <?php
	$no++;
	}
?>
	<tr>
    	<td colspan="2" align="right">Jumlah <?php echo number_format($jml);?></td>
	<td></td>
        <!--<td align="right"><?php echo number_format($jml);?></td>-->
    </tr>
<?php    
myfooter();	
?>   
    </table>
	<div class="page" align="right">
	<br />
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