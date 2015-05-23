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
                <li class="<?php if($page_name == 'dashboard')echo 'active';?>"><a href="<?php echo base_url(); ?>admin/dashboard"><span class="icon-align-justify"></span> Dashboard</a></li>
                <li class="<?php if($page_name == 'setting_wilayah_kerja' || $page_name == 'setting_aplikasi' || $page_name == 'group_pengguna' || $page_name == 'pengguna')echo 'active'; ?> dropdown"><a href=""><span class="icon-th-list"></span> Setting Aplikasi</a>
                	<ul style=" <?php if($page_name == 'setting_wilayah_kerja' || $page_name == 'setting_aplikasi' || $page_name == 'group_pengguna' || $page_name == 'pengguna')echo 'display: block'; ?>">
                    
                    <li><a href="<?php echo base_url(); ?>cont_master_setting/setting_puskesmas">Setting Puskesmas</a></li>
                    <li><a href="<?php echo base_url(); ?>cont_master_setting/sinkronisasi">Sinkronisasi Data</a></li>					
			<li><a href="<?php echo base_url(); ?>cont_master_setting/group_pengguna">Group Pengguna</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_setting/pengguna">Pengguna</a></li>
                        
                    </ul>
                </li>
                <li class="<?php if($page_name == 'propinsi' || $page_name == 'puskesmas')echo 'active';?> dropdown"><a href=""><span class="icon-briefcase"></span> Master Wilayah dan Puskesmas</a>
                	<ul style=" <?php if($page_name == 'propinsi' || $page_name == 'puskesmas')echo 'display : block'; ?>">
                    	<li><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/propinsi">Wilayah Administrasi</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/puskesmas">Puskesmas</a></li>
                    </ul>
                </li>
                <li class="<?php if($page_name == 'agama' || $page_name == 'cara_bayar' || $page_name == 'cara_masuk' || $page_name == 'jenis_kelamin' || $page_name == 'ras' || $page_name == 'status_marital' || $page_name == 'golongan_darah' || $page_name == 'pendidikan' || $page_name == 'pekerjaan')echo 'active'; ?> dropdown"><a href=""><span class="icon-th-list"></span> Master Biodata Pasien</a>
                	<ul style=" <?php if($page_name == 'agama' || $page_name == 'cara_bayar' || $page_name == 'cara_masuk' || $page_name == 'jenis_kelamin' || $page_name == 'ras' || $page_name == 'status_marital' || $page_name == 'golongan_darah' || $page_name == 'pendidikan' || $page_name == 'pekerjaan')echo 'display: block'; ?>">
                    	<li><a href="<?php echo base_url(); ?>cont_master_pasien/agama">Agama</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pasien/cara_bayar">Cara Bayar</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pasien/jenis_kelamin">Jenis Kelamin</a></li>
                        <!-- <li><a href="<?php echo base_url(); ?>cont_master_pasien/ras">Ras / Suku</a></li> -->
                        <li><a href="<?php echo base_url(); ?>cont_master_pasien/status_marital">Status Pernikahan</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pasien/golongan_darah">Golongan Darah</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pasien/pendidikan">Pendidikan</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pasien/pekerjaan">Pekerjaan</a></li>
                    </ul>
                </li>
                <li class="<?php if($page_name == 'obat' || $page_name == 'golongan_obat' || $page_name== 'harga_obat' || $page_name == 'jenis_obat' || $page_name == 'milik_obat' || $page_name == 'satuan_besar' || $page_name == 'satuan_kecil' || $page_name == 'terapi_obat' || $page_name == 'unit_farmasi')echo 'active'; ?>dropdown"><a href=""><span class="icon-book"></span> Master Farmasi</a>
                	<ul style=" <?php if($page_name == 'obat' || $page_name == 'golongan_obat' || $page_name== 'harga_obat' || $page_name == 'jenis_obat' || $page_name == 'milik_obat' || $page_name == 'satuan_besar' || $page_name == 'satuan_kecil' || $page_name == 'terapi_obat' || $page_name == 'unit_farmasi')echo 'display: block'; ?>">
                    	<li><a href="<?php echo base_url(); ?>cont_master_farmasi/obat">Daftar Obat</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_farmasi/golongan_obat">Daftar Golongan Obat</a></li>
                    <li><a href="<?php echo base_url(); ?>cont_master_farmasi/harga_obat">Daftar Harga Obat</a></li>
                    <li><a href="<?php echo base_url(); ?>cont_master_farmasi/milik_obat">Daftar Supplier Obat</a></li>
                    <li><a href="<?php echo base_url(); ?>cont_master_farmasi/unit_farmasi">Data Unit Farmasi / Apotik / Poli</a></li>
                    <li><a href="<?php echo base_url(); ?>cont_master_farmasi/satuan_besar">Daftar Satuan Besar</a></li>
                    
                        <li><a href="<?php echo base_url(); ?>cont_master_farmasi/jenis_obat">Daftar Jenis Obat</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_farmasi/satuan_kecil">Daftar Satuan Kecil</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_farmasi/terapi_obat">Data Obat Terapi</a></li>
                    </ul>
                </li>
               <li class="<?php if($page_name == 'golongan_petugas' || $page_name == 'posisi' || $page_name == 'spesialisasi' || $page_name == 'pendidikan_kesehatan')echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span> Master Petugas</a>
                	<ul style=" <?php if($page_name == 'golongan_petugas' || $page_name == 'posisi' || $page_name == 'spesialisasi' || $page_name == 'pendidikan_kesehatan')echo 'display: block'; ?>">
                    <li><a href="<?php echo base_url(); ?>cont_master_petugas/golongan_petugas">Golongan Petugas</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_petugas/posisi">Posisi</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_petugas/spesialisasi">Spesialisasi</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_petugas/pendidikan_kesehatan">Pendidikan Kesehatan</a></li>
                    </ul>
                </li>
                <li class="<?php if($page_name == 'sarana_posyandu' || $page_name== 'tindakan' || $page_name == 'asal_pasien' || $page_name == 'unit_pelayanan' || $page_name == 'icd_induk' || $page_name == 'icd' || $page_name == 'jenis_kasus' || $page_name == 'kasus' || $page_name == 'dokter' || $page_name== 'petugas' || $page_name == 'kamar' || $page_name == 'status_keluar_pasien' || $page_name == 'ruangan' || $page_name == 'kelompok_pasien' || $page_name == 'kategori_imunisasi' || $page_name == 'jenis_pasien' || $page_name == 'jenis_imunisasi' )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span> Master Pelayanan</a>
                <ul style=" <?php if($page_name == 'sarana_posyandu' || $page_name== 'tindakan' || $page_name == 'asal_pasien' || $page_name == 'unit_pelayanan' || $page_name == 'icd_induk' || $page_name == 'icd' || $page_name == 'jenis_kasus' || $page_name == 'kasus' || $page_name == 'dokter' || $page_name== 'petugas' || $page_name == 'kamar' || $page_name == 'status_keluar_pasien' || $page_name == 'ruangan' || $page_name == 'kelompok_pasien' || $page_name == 'kategori_imunisasi' || $page_name == 'jenis_pasien' || $page_name == 'jenis_imunisasi' )echo 'display: block'; ?>">
                    	<!-- <li><a href="<?php echo base_url(); ?>admin/sarana_posyandu">Sarana Posyandu</a></li> -->
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/tindakan">Daftar Tindakan</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/asal_pasien">Asal Pasien</a></li>
                  <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/unit_pelayanan">Daftar Unit Pelayanan</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/icd_induk">Daftar ICD Induk</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/icd">Daftar ICD</a></li>
                        <!-- 
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/jenis_kasus">Jenis Kasus</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/kasus">Kasus</a></li>
                        -->
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/dokter">Daftar Dokter</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/petugas">Daftar Petugas</a></li>
                       <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/status_keluar_pasien">Jenis Status Keluar Pasien</a></li>
                        
                        
                         <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/kamar">Daftar Kamar</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/ruangan">Daftar Ruangan</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/kelompok_pasien">Kelompok Pasien</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/kategori_imunisasi">Kategori Imunisasi</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/jenis_pasien">Jenis Pasien</a></li>
                        <li><a href="<?php echo base_url(); ?>cont_master_pelayanan/jenis_imunis	asi">Jenis Imunisasi</a></li>
                        
                	</ul>
                </li>
             
				<li class="<?php if($page_name == 'pendaftaran' || $page_name== 'pelayanan' || $page_name== 'gudang' || $page_name== 'apotek' )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span> Master Transaksi</a>
                	<ul style="<?php if($page_name == 'pendaftaran' || $page_name== 'pelayanan' || $page_name== 'gudang' || $page_name== 'apotek' )echo 'display: block'; ?>">
						<li><a href="<?php echo base_url(); ?>cont_transaksi_pendaftaran/pendaftaran">Pendaftaran</a></li>
						<li><a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan">Pelayanan</a></li>
						<li><a href="<?php echo base_url(); ?>barang/gudang">Gudang</a></li>
						<li><a href="<?php echo base_url(); ?>barang/apotek">Apotek</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/laporan">Pembayaran</a></li>
                	</ul>
                </li>
				
		<li class="<?php if($page_name == 'lb1' || $page_name== 'lb2'  )echo 'active'; ?>dropdown"><a href=""><span class="icon-briefcase"></span>Laporan Bulanan</a>
                	<ul style="<?php if($page_name == 'lb1' || $page_name== 'lb2'  )echo 'display: block'; ?>">
						<li><a href="<?php echo base_url(); ?>c_lb_1/lb1">LB 1</a></li>
						<li><a href="<?php echo base_url(); ?>c_lb_2/lb2">LB 2</a></li>
						
                	</ul>
                </li>


            </ul>
        </div><!--leftmenu-->
        
    </div><!--mainleft-->