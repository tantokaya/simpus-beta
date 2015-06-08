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
        <!--        <li class="<?php if($page_name == 'dashboard')echo 'active';?>"><a href="<?php echo base_url(); ?>gudang/dashboard"><span class="icon-align-justify"></span>Dashboard</a></li>	-->
				
				<li class="<?php if($page_name == 'gudang')echo 'active';?>"><a href="<?php echo base_url(); ?>barang/gudang"><span class="icon-align-justify"></span>Halaman Depan</a></li>
				<li class="<?php if($page_name == 'obat')echo 'active';?>"><a href="<?php echo base_url(); ?>cont_master_farmasi/obat"><span class="icon-align-justify"></span>Ubah Tanggal Kadaluwarsa</a></li>
				
				 <li class="<?php if($page_name == 'gudang')echo 'active'; ?> dropdown"><a href=""><span class="icon-th-list"></span> Gudang Obat</a>
                	<ul style=" <?php if($page_name == 'apotek')echo 'display: block'; ?>">
                        <li><a href="<?php echo base_url(); ?>barang/masuk">Obat Masuk Gudang</a></li>
                        <li><a href="<?php echo base_url(); ?>barang/keluar">Obat Keluar Gudang</a></li>
						<li><a href="<?php echo base_url(); ?>cont_master_farmasi/obat_gudang_stok">Stok Obat Gudang</a></li>
						<li><a href="<?php echo base_url(); ?>barang/stok_gudang_expired">Stok Obat Expired di Gudang</a></li>
						<li><a href="<?php echo base_url(); ?>barang/sopname">Stok Opname Obat di Gudang</a></li>
						
                    </ul>
                </li>
                
                <li class="<?php if($page_name == 'apotek')echo 'active'; ?> dropdown"><a href=""><span class="icon-th-list"></span> Apotek</a>
                	<ul style=" <?php if($page_name == 'apotek')echo 'display: block'; ?>">
                        <li><a href="<?php echo base_url(); ?>barang/apotek_masuk">Obat Masuk Apotek</a></li>
                        <li><a href="<?php echo base_url(); ?>barang/apotek_keluar">Obat Keluar Apotek</a></li>
						<li><a href="<?php echo base_url(); ?>barang/stok_apotek">Stok Obat Apotek</a></li>
						<li><a href="<?php echo base_url(); ?>barang/stok_apotek_expired">Stok Obat Expired di Apotek</a></li>
						<li><a href="<?php echo base_url(); ?>barang/sopname_apotek">Stok Opname Obat di Apotek</a></li>

						
                    </ul>
                </li>
				<li class="<?php if($page_name == 'lb1' || $page_name== 'lb2'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span>Laporan Bulanan</a>
                	<ul style="<?php if($page_name == 'lb1' || $page_name== 'lb2'  )echo 'display: block'; ?>">
						<li><a href="<?php echo base_url(); ?>c_lb_1/lb1">LB 1</a></li>
						<li><a href="<?php echo base_url(); ?>c_lb_2/lb2">LB 2</a></li>			
                	</ul>
                </li>
				<li class="<?php if($page_name == 'RegisterHarian' || $page_name == 'RekapHarian' || $page_name== 'RekapPenyakitPerMinggu' || $page_name== 'RekapPasienPerPenyakit' || $page_name == 'RekapObatKeluarApotekPerMinggu' || $page_name == 'monitoring')echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span>Laporan Tambahan</a>
                	<ul style="<?php if($page_name == 'RegisterHarian' || $page_name== 'RekapHarian' || $page_name== 'RekapPenyakitPerMinggu' || $page_name== 'RekapPasienPerPenyakit' || $page_name== 'RekapObatKeluarApotekPerMinggu' || $page_name == 'monitoring') echo 'display: block'; ?>">
						
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_mingguan/rekap_obat_out_apotek">Rekap Pengeluaran Obat Di Apotek</a></li>
						<li><a href="<?php echo base_url(); ?>cont_cetak_lap_harian/rekap_stok_obat">Rekap Stok Obat</a></li>
                	</ul>
                </li>
			</ul>
        </div><!--leftmenu-->
        
        
    </div><!--mainleft-->