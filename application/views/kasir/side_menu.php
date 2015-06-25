<div class="leftpanel">
        
        <div class="datewidget"><?php echo $this->functions->format_tgl_cetak(date('Y-m-d')); ?></div>
    
    	<div class="searchwidget">
        	<form action="results.html" method="post">
            	<div class="input-append">
                    <input type="text" class="span2 search-query" placeholder="Search here...">
                    <button type="submit" class="btn"><span class="icon-search"></span></button>
                </div>
            </form>
        </div><!--searchwidget-->
        
       
        <div class="leftmenu">        
            <ul class="nav nav-tabs nav-stacked">
            	<li class="nav-header">Menu Utama</li>
                <li class="<?php if($page_name == 'dashboard')echo 'active';?>"><a href="<?php echo base_url(); ?>kasir/dashboard"><span class="icon-align-justify"></span> Dashboard</a></li>
				
		<li class="<?php if($page_name == 'pelayanan')echo 'active';?>"><a href="<?php echo base_url(); ?>kasir/laporan"><span class="icon-align-justify"></span>Menu Kasir</a></li>
        
        <li class="<?php if($page_name == 'pelayanan_today')echo 'active';?>"><a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan_today"><span class="icon-align-justify"></span>Daftar Pasien Hari Ini</a></li>
		
		<li class="<?php if($page_name == 'harian1' || $page_name== 'harian2'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span>Laporan Tambahan</a>
                	<ul style="<?php if($page_name == 'harian1' || $page_name== 'harian2'  )echo 'display: block'; ?>">
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_kasir/rekap_pembayaran">Rekap Pembayaran per Jenis Layanan</a></li>
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_kasir/detail_pembayaran">Daftar Transaksi Pembayaran</a></li>
						
				<!--	<li><a href="<?php echo base_url(); ?>cont_cetak_lap_mingguan/rekap_penyakit">Rekap Penyakit Mingguan</a></li>
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_mingguan/rekap_pasien_penyakit">Rekap Pasien per Penyakit </a></li>
						<li><a href="<?php echo base_url(); ?>c_form_monitoring/monitor">Form Monitoring Indikator Peresepan</a></li>
						-->
                	</ul>
                </li>
			
            </ul>
        </div><!--leftmenu-->
        
    </div><!--mainleft-->