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
            	<li class="nav-header">Main Navigation</li>
                <li class="<?php if($page_name == 'dashboard')echo 'active';?>"><a href="<?php echo base_url(); ?>dokter/dashboard"><span class="icon-align-justify"></span> Dashboard</a></li>
                
               
               
				<li class="<?php if($page_name== 'pelayanan'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span> Database Rekam Medis</a>
                	<ul style="<?php if($page_name == 'view_rekmed' )echo 'display: block'; ?>">
					<li><a href="<?php echo base_url(); ?>cont_view_rekmed/view_rekmed">Lihat Rekam Medis</a></li>
                    <li><a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan_today">Daftar Pasien Hari Ini</a></li>
	           	</ul>
                </li>
		<li class="<?php if($page_name == 'lb1' || $page_name== 'lb2'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span>Laporan Bulanan</a>
                	<ul style="<?php if($page_name == 'lb1' || $page_name== 'lb2'  )echo 'display: block'; ?>">
						<li><a href="<?php echo base_url(); ?>c_lb_1/lb1">LB 1</a></li>
						<li><a href="<?php echo base_url(); ?>c_lb_2/lb2">LB 2</a></li>
					<!--	<li><a href="<?php echo base_url(); ?>c_lb_1/lb1">LB 3</a></li>
						<li><a href="<?php echo base_url(); ?>c_lb_1/lb1">LB 4</a></li> -->
						
                	</ul>
                </li>


            </ul>
        </div><!--leftmenu-->
        
    </div><!--mainleft-->