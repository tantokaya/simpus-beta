<div class="rightpanel">
    	
        <div class="breadcrumbwidget">
        	<ul class="breadcrumb">
                <li>Master Transaksi <span class="divider">/</span></li>
                <li class="active">Apotek</li>
            </ul>
        </div><!--breadcrumbwidget-->
      <div class="pagetitle">
        	<h1>Transaksi Apotek</h1> <span></span>
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner content-dashboard">
            	<div class="alert alert-info">
                	<button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Menu Transaksi Apotek</strong> <br/>
					Pilihlah Jenis Transaksi yang ada dibawah ini :
                </div><!--alert-->
				
				             		
    <div class="row-fluid">
        <div class="span12">
            <h4 class="widgettitle">Menu Transaksi Apotek</h4>
            <ul class="widgeticons row-fluid">
                <li class="one_fifth"><a href="<?php echo base_url(); ?>barang/apotek_masuk"><img src="<?php echo base_url(); ?>assets/img/gemicon/apotek_plus.png" alt="" /><span>Barang Masuk <br>APOTEK</span></a></li>
                <li class="one_fifth"><a href="<?php echo base_url(); ?>barang/apotek_keluar"><img src="<?php echo base_url(); ?>assets/img/gemicon/apotek_minus.png" alt="" /><span>Barang Keluar <br>APOTEK</span></a></li>
                <li class="one_fifth">
                    <a href="<?php echo base_url(); ?>barang/stok_apotek"><img src="<?php echo base_url(); ?>assets/img/gemicon/stok_gudang.png" alt="" /><span>Stok Obat<br>APOTEK</span></a>
                </li>
                <li class="one_fifth">
                    <a href="<?php echo base_url(); ?>barang/stok_apotek_expired" >
                        <img src="<?php echo base_url(); ?>assets/img/gemicon/notify.png" alt="" />
                        <span style="color: red"> Stok Obat EXPIRED<br />APOTEK ( <?php echo $jumlah; ?> ) </span>
                    </a>
                </li>
                <li class="one_fifth"><a href="<?php
                    echo base_url(); ?>barang/sopname_apotek"><img src="<?php
                        echo base_url(); ?>assets/img/gemicon/reports.png" alt="" /><span>Stok Opname<br />APOTEK</span></a>
                </li>
            </ul>
	    </div>
    </div>
	<div class="row-fluid">
         <div class="span12"> <br />
			 <h4 class="widgettitle">Menu Laporan Transaksi Apotek</h4>
             <ul class="widgeticons row-fluid">
				<li class="one_fifth"><a href="<?php echo base_url(); ?>barang/lap_apotek_per_tgl"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Lap Detail Masuk<br/>Transaksi / Tanggal</span></a></li>
				<li class="one_fifth"><a href="<?php echo base_url(); ?>barang/lap_sum_per_tgl_apotek_in"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Lap Summary Masuk<br/>Transaksi / Tanggal</span></a></li>
				<li class="one_fifth"><a href="<?php echo base_url(); ?>barang/lap_apotek_out_per_tgl"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Lap Detail Keluar<br/>Transaksi / Tanggal</span></a></li>
				<li class="one_fifth"><a href="<?php echo base_url(); ?>barang/lap_sum_per_tgl_apotek_out"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Lap Summary Keluar<br/>Transaksi / Tanggal</span></a></li>
				<li class="one_fifth"><!--<a href="<?php echo base_url(); ?>barang/download_stok_apotek"><img src="<?php echo base_url(); ?>assets/img/gemicon/lap_per_tgl.png" alt="" /><span>Laporan Stok <br>Apotek</span></a>--></li>
				<li class="one_fifth"></li>
			</ul>
                        
	     </div><!--span12-->
                    
    </div><!--row-fluid-->
            </div><!--contentinner-->
        </div><!--maincontent-->
        
    </div><!--mainright-->