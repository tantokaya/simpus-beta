<style type="text/css">
    *{
        font-family: Sans-Serif;
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

    $kop 	= "<h3>DINAS KESEHATAN</3>";
    $kop 	.= "<h3>UPTD PUSKESMAS $nm_puskesmas</h3>";
    $kop 	.= "<p>$alamat $nm_kota </p>";
    $kop    .="<p>TELP. $telp </p>";

    $kop_kanan  =$tgl_bayar;
    $kop_kanan  .= "<p><center> </center></p>";

    $kop_pasien	 = $nm_lengkap;
    $kop_umur	 = $umur;
    $kop_alamat	 = $alamat_p;
    $kop_rkm	 = $rkm;
    $judul_H = $id;


    function myheader($kop,$kop_kanan,$judul_H,$kop_pasien,$kop_umur,$kop_alamat,$kop_rkm){
        ?>
        <div class="kop">
            <table width="100%">
                <tr>
                    <td align="center"><?php echo $kop;?></td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td colspan="2">==========================================</td>
            </tr>
            <tr>
                <td style="width: 60px;">No</td><td>:&nbsp;<?php echo $judul_H; ?>, <?php echo $kop_kanan; ?></td>
            </tr>
            <tr>
                <td style="text-align: center; height: 20px;" colspan="2"><a href="#" id="not-print" onClick="window.print();return false" ><h2><u>TANDA BUKTI BAYAR</u></h2></a></td>
            </tr>
            <tr>
                <td>No.RM</td><td>:&nbsp;<?php echo $kop_rkm; ?></td>
            </tr>
            <tr>
                <td>Nama</td><td>:&nbsp; <?php  echo $kop_pasien;?></td>
            </tr>
            <tr>
                <td>Umur</td><td>:&nbsp; <?php echo $kop_umur; ?> Thn</td>
            </tr>
            <tr>
                <td>Alamat</td><td>:&nbsp; <?php echo $kop_alamat; ?></td>
            </tr>
            <tr>
                <td colspan="2">==========================================</td>
            </tr>
        </table>

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
                echo "<div class=\"pagebreak\" align='right'>
                <div class='page' align='center'>Hal - $page</div>
                </div>";
                $page++;
//                ?>
<!--                <div class="pagebreak" align="right">-->
<!--                    <div class="page" align="center">--><?php ////hal ?><!--</div>-->
<!--                </div>-->
<!--                --><?php
//                $page++;
            }
            myheader($kop,$kop_kanan,$judul_H,$kop_pasien,$kop_umur,$kop_alamat,$kop_rkm);
        }
        ?>
        <tr>
            <td colspan="3" ><?php echo $db['produk'];?> ( <?php echo $db['jml'];?> x <?php echo number_format($db['harga_jual']);?> )</td>
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
        <td colspan="3" align="right" style="font-size:12px;">Total Bayar :</td>
        <td align="right" style="font-size:12px;"><?php echo number_format($jml);?></td>
    </tr>
    <tr>
        <td colspan="3" align="right" style="font-size:12px;">Bayar :</td>
        <td align="right" style="font-size:12px;"><?php echo  number_format($db['bayar']);?></td>
    </tr>
    <tr>
        <td colspan="3" align="right" style="font-size:12px;">Kembalian :</td>
        <td align="right" style="font-size:12px;"><?php echo  number_format($db['kembalian']);?></td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right; height: 60px;">Yang Menerima,</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
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