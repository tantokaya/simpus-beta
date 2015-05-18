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
                <li class="<?php if($page_name == 'dashboard')echo 'active';?>"><a href="<?php echo base_url(); ?>poli_gigi/dashboard"><span class="icon-align-justify"></span> Dashboard</a></li>
				
				<li class="<?php if($page_name == 'pelayanan')echo 'active';?>"><a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan_today"><span class="icon-align-justify"></span>Menu Pelayanan</a></li>
			<!--	
				<li class="<?php if($page_name == 'pendaftaran' || $page_name== 'pelayanan'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span> Menu Utama</a>
                	<ul style="<?php if($page_name == 'pendaftaran' || $page_name== 'pelayanan'  )echo 'display: block'; ?>">
						<li><a href="<?php echo base_url(); ?>cont_transaksi_pendaftaran/pendaftaran">Daftar Antrian Pasien</a></li>
						<li><a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan">Pelayanan</a></li>
					</ul>
                </li>	-->
            </ul>
        </div><!--leftmenu-->
        
    </div><!--mainleft-->