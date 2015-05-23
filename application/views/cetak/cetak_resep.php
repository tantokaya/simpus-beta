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

    $kop 	= "<h3>PEMERINTAH KOTA BOGOR</3>";
    $kop 	.= "<h3>DINAS KESEHATAN</h3>";
    $kop 	.= "<h3>UPTD PUSKESMAS $nm_puskesmas</h3>";
    $kop 	.= "<p>$alamat,  $nm_kota </p>";
    $kop    .="<p>TELP. $telp </p>";

    $kop_kanan  =$tgl_pelayanan;
    $kop_kanan  .= "<p></p>";
    $kop_noreg = $no_reg;


//    $kop_operator = $operator;

    $judul_H = $id;


    function myheader($kop,$kop_kanan,$judul_H,$kop_noreg){
        ?>
        <div class="page">
            <table width="100%">
                <tr>
                    <td align="center" colspan="3"><?php echo $kop;?></td>
                </tr>
                <tr>
                    <td colspan="3">==========================================</td>
                </tr>
                <tr>
                    <td>No. Pelayanan </td><td>:</td><td><?php echo $judul_H; ?></td>
                </tr>
                <tr>
                    <td>Tanggal <td>:</td><td><?php echo $kop_kanan; ?></td>
                </tr>
		<tr>
                    <td>Nomor Kartu Keluarga</td><td>:</td><td><?php echo $kop_noreg; ?></td>
                </tr>
         <!--      	 <tr>
               <td>Nama</td><td>:</td><td><?php echo $nm_lengkap; ?></td>
            	</tr>
           		 <tr>
                <td>Umur</td><td>:</td><td><?php echo $umur; ?></td>
            	</tr>
           		 <tr>
                <td>Alamat</td><td>:</td><td><?php echo $alamat_pasien; ?></td>
           		 </tr>	-->
                <tr>
                    <td colspan="3">==========================================</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center;"><a href="#" id="not-print" onClick="window.print();return false" >CETAK RESEP</a></td>
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

//        $saldo = $db['jml']*$db['harga_beli'];
//        $jml = $jml;

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
            myheader($kop,$kop_kanan,$judul_H,$kop_noreg);
        }
        ?>
        <tr>
            <td colspan="3" ><?php if($db['racikan']==1) echo '(r)'.$db['nama_obat']; else echo $db['nama_obat']; ?> (<?php echo $db['dosis']; ?>)</td>
            <td align="right"><?php echo $db['qty']; ?>  <?php echo $db['sat_kecil_obat'];?></td>
        </tr>
        <?php
        $no++;
    }
    ?>

    <?php
    myfooter();
    ?>
    </table>
    <div class="page" >
        <br />
        <table>
            <tr>
                <td colspan="3" style="text-align: right; height: 80px">Apoteker</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right;">-----------------------</td>
            </tr>
           
            <tr>
                <td>Nama</td><td>:</td><td><?php echo $nm_lengkap; ?></td>
            </tr>
            <tr>
                <td>Umur</td><td>:</td><td><?php echo $umur; ?></td>
            </tr>
            <tr>
                <td>Alamat</td><td>:</td><td><?php echo $alamat_pasien; ?></td>
            </tr>
          
        </table>
        
    </div>
<?php
}else{
    echo "Tidak Ada Data";
}
?>