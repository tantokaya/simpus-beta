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
        
        <!--
        <div class="plainwidget">
        	<small>Using 16.8 GB of your 51.7 GB </small>
        	<div class="progress progress-info">
                <div class="bar" style="width: 20%"></div>
            </div>
            <small><strong>38% full</strong></small>
        </div><!--plainwidget-->
        
        <div class="leftmenu">        
            <ul class="nav nav-tabs nav-stacked">
            	<li class="nav-header">Main Navigation</li>
                <li class="<?php if($page_name == 'dashboard')echo 'active';?>"><a href="<?php echo base_url(); ?>pendaftaran/dashboard"><span class="icon-align-justify"></span> Dashboard</a></li>
				
                <li class="<?php if($page_name == 'pendaftaran')echo 'active';?>"><a href="<?php echo base_url(); ?>cont_transaksi_pendaftaran/pendaftaran"><span class="icon-align-justify"></span>Pendaftaran Pasien Baru</a></li>
                <li class="<?php if($page_name == 'pelayanan')echo 'active';?>"><a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan_today"><span class="icon-align-justify"></span>Daftar Pasien Hari ini</a></li>
				
				<li class="<?php if($page_name == 'harian1' || $page_name== 'harian2'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span>Download Laporan</a>
                	<ul style="<?php if($page_name == 'harian1' || $page_name== 'harian2'  )echo 'display: block'; ?>">
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_harian/register_harian">Register Pasien Harian</a></li>
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_harian/rekap_pasien">Rekap Pasien per Jenis Pembayaran</a></li>			
                	</ul>
                </li>
                
        
                	</ul>
                </li>
            </ul>
        </div><!--leftmenu-->
        
    </div><!--mainleft-->