<div class="rightpanel">
        <div class="breadcrumbwidget">
         <ul class="breadcrumb">
                <li>Master Transaksi <span class="divider">/</span></li>
                <li class="active">Gudang</li>
            </ul>
        </div><!--breadcrumbwidget-->
      <div class="pagetitle">
         <h1>Transaksi Gudang</h1> <span></span>
        </div><!--pagetitle-->
        <div class="maincontent">
         <div class="contentinner content-dashboard">
             <div class="alert alert-info">
                 <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Menu Transaksi Gudang</strong> <br/>
Pilihlah Jenis Transaksi yang ada dibawah ini :
                </div><!--alert-->
                <div class="row-fluid">
            <div class="span12">
            <h4 class="widgettitle">Menu Transaksi Gudang</h4>
                <ul class="widgeticons row-fluid">
                    <li class="one_fifth"><a href="<?php
                        echo base_url(); ?>barang/masuk/tambah"><img src="<?php
                        echo base_url(); ?>assets/img/gemicon/apotek_plus.png" alt="" /><span>Barang Masuk <br />GUDANG</span></a></li>
                    <li class="one_fifth"><a href="<?php
                        echo base_url(); ?>barang/keluar/tambah"><img src="<?php
                        echo base_url(); ?>assets/img/gemicon/apotek_minus.png" alt="" /><span>Barang Keluar <br />GUDANG</span></a>
                    </li>
                    <li class="one_fifth"><a href="<?php
                        echo base_url(); ?>barang/stok_gudang"><img src="<?php
                        echo base_url(); ?>assets/img/gemicon/stok_gudang.png" alt="" /><span>Stok Obat<br />GUDANG</span></a>
                    </li>
                    <li class="one_fifth">
                        <a href="<?php echo base_url(); ?>barang/stok_gudang_expired" >
                            <img src="<?php echo base_url(); ?>assets/img/gemicon/notify.png" alt="" />
                            <span style="color: red"> Stok Obat EXPIRED<br />GUDANG ( <?php echo $jumlah; ?> ) </span>
                        </a>
                    </li>
                    <li class="one_fifth"><a href="<?php
                        echo base_url(); ?>barang/sopname"><img src="<?php
                            echo base_url(); ?>assets/img/gemicon/reports.png" alt="" /><span>Stok Opname<br />GUDANG</span></a>
                    </li>
                </ul>
            </div>
                 </div>
<div class="row-fluid">
                 <div class="span12">
                        <br />
                    <h4 class="widgettitle">Menu Laporan Transaksi Gudang</h4>
                       <ul class="widgeticons row-fluid">
                        <li class="one_fifth"><a href="<?php echo base_url(); ?>barang/lap_gudang_per_tgl"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Lap Detail Masuk<br/>Transaksi / Tanggal</span></a></li>
                        <li class="one_fifth"><a href="<?php echo base_url(); ?>barang/lap_sum_per_tgl_gudang_in"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Lap Summary Masuk<br/>Transaksi / Tanggal</span></a></li>
                        <li class="one_fifth"><a href="<?php echo base_url(); ?>barang/lap_gudang_out_per_tgl"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Lap Detail Keluar<br/>Transaksi / Tanggal</span></a></li>
                        <li class="one_fifth"><a href="<?php echo base_url(); ?>barang/lap_sum_per_tgl_gudang_out"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Lap Summary Keluar<br/>Transaksi / Tanggal</span></a></li>
                        <li class="one_fifth"><!--<a href="<?php echo base_url(); ?>barang/download_stok_gudang"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Laporan Stok <br />Gudang</span></a>--></li>
                       </ul>
 </div><!--span12-->
                </div><!--row-fluid-->
            </div><!--contentinner-->
        </div><!--maincontent-->
    </div><!--mainright-->