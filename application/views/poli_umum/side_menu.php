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
                <li class="<?php if($page_name == 'dashboard')echo 'active';?>"><a href="<?php echo base_url(); ?>poli_umum/dashboard"><span class="icon-align-justify"></span> Dashboard</a></li>
				
				<li class="<?php if($page_name == 'pelayanan')echo 'active';?>"><a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan_today"><span class="icon-align-justify"></span>Menu Pelayanan</a></li>
				
				<li class="<?php if($page_name == 'harian1' || $page_name== 'harian2'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span>Laporan Tambahan</a>
                	<ul style="<?php if($page_name == 'harian1' || $page_name== 'harian2'  )echo 'display: block'; ?>">
				<!--		<li><a href="<?php echo base_url(); ?>cont_cetak_lap_harian/register_harian">Register Pasien Harian</a></li>
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_harian/rekap_pasien">Rekap Pasien per Jenis Pembayaran</a></li>	-->
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_mingguan/rekap_penyakit">Rekap Penyakit Mingguan</a></li>
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_mingguan/rekap_pasien_penyakit">Rekap Pasien per Penyakit </a></li>
						<li><a href="<?php echo base_url(); ?>c_form_monitoring/monitor">Form Monitoring Indikator Peresepan</a></li>
						
                	</ul>
                </li>
			<!--	
				<li class="<?php if($page_name == 'pendaftaran' || $page_name== 'pelayanan'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span> Menu Utama</a>
                	<ul style="<?php if($page_name == 'pendaftaran' || $page_name== 'pelayanan'  )echo 'display: block'; ?>">
						<li><a href="<?php echo base_url(); ?>cont_transaksi_pendaftaran/pendaftaran">Daftar Antrian Pasien</a></li>
						<li><a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan_today">Pelayanan</a></li>
					</ul>
                </li>	-->
            </ul>
        </div><!--leftmenu-->
        
    </div><!--mainleft-->