<div class="rightpanel">
    	
        <div class="breadcrumbwidget">
        	<!--
            <ul class="info">
            	<li class="active"><?php echo ucwords($this->session->userdata('akses')); ?></li>
            </ul>
            -->
        	<ul class="breadcrumb">
                <li>Home <span class="divider">/</span></li>
                <li class="active">Dashboard</li>
            </ul>
        </div><!--breadcrumbwidget-->
      <div class="pagetitle">
        	<h1>Dashboard</h1> <span></span>
        </div><!--pagetitle-->
        
        <div class="maincontent">
        	<div class="contentinner content-dashboard">
            	<div class="alert alert-info">
                	<button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Selamat Datang di Dashboard Puskesmas Kota Bogor</strong> <br/>
					Berikut ini adalah data-data kesehatan dari Kota Bogor. Data diambil dari Sistem Informasi untuk Puskesmas yang ada di 
					wilayah kerja Dinas Kesehatan kota Bogor.
                </div><!--alert-->
				
				<div class="row-fluid">
				<div class="span4">
				<h4 class="widgettitle nomargin">Statistik Hari ini</h4>
                <div class="widgetcontent bordered">
					<center><h1><?php echo $total_kunjungan_date['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>
				<div class="span4">
				<h4 class="widgettitle nomargin">Statistik Minggu ini</h4>
                <div class="widgetcontent bordered">
                   <center><h1><?php echo $total_kunjungan_week['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>
				<div class="span4">
				<h4 class="widgettitle nomargin">Statistik Bulan ini</h4>
                <div class="widgetcontent bordered">
                   <center><h1><?php echo $total_kunjungan_month['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>
				</div>
                
                <div class="row-fluid">
                	<div class="span8">
                    	<ul class="widgeticons row-fluid">
                        	<li class="one_fifth"><a href="<?php echo base_url(); ?>admin/obat"><img src="<?php echo base_url(); ?>assets/img/gemicon/location.png" alt="" /><span>Obat</span></a></li>
                            <li class="one_fifth"><a href="<?php echo base_url(); ?>admin/petugas"><img src="<?php echo base_url(); ?>assets/img/gemicon/image.png" alt="" /><span>Petugas</span></a></li>
                            <li class="one_fifth"><a href=""><img src="<?php echo base_url(); ?>assets/img/gemicon/reports.png" alt="" /><span>Laporan</span></a></li>
                            <li class="one_fifth"><a href="<?php echo base_url(); ?>admin/pelayanan"><img src="<?php echo base_url(); ?>assets/img/gemicon/edit.png" alt="" /><span>Pelayanan</span></a></li>
                            <li class="one_fifth last"><a href="<?php echo base_url(); ?>admin/pendaftaran"><img src="<?php echo base_url(); ?>assets/img/gemicon/mail.png" alt="" /><span>Registrasi</span></a></li>
                        	<li class="one_fifth"><a href=""><img src="<?php echo base_url(); ?>assets/img/gemicon/calendar.png" alt="" /><span>Acara</span></a></li>
                            <li class="one_fifth"><a href="<?php echo base_url(); ?>admin/pengguna"><img src="<?php echo base_url(); ?>assets/img/gemicon/users.png" alt="" /><span>Pengguna</span></a></li>
                            <li class="one_fifth"><a href=""><img src="<?php echo base_url(); ?>assets/img/gemicon/settings.png" alt="" /><span>Settings</span></a></li>
                            <li class="one_fifth"><a href=""><img src="<?php echo base_url(); ?>assets/img/gemicon/archive.png" alt="" /><span>Tindakan</span></a></li>
                            <li class="one_fifth last"><a href="<?php echo base_url(); ?>admin/tindakan"><img src="<?php echo base_url(); ?>assets/img/gemicon/notify.png" alt="" /><span>Perbarui Data</span></a></li>
                        </ul>
                        
                        <br />
                        
                        <h4 class="widgettitle">Jumlah Pasien Berdasarkan Jenis Kelamin</h4>
                        <div class="widgetcontent">
						<script type="text/javascript">
							jQuery(function () {
							jQuery('#container1').highcharts({
								chart: {
									type: 'column'
								},
								title: {
									text: 'Grafik Jumlah Pasien Berdasarkan Jenis Kelamin'
								},
								subtitle: {
									text: 'Tahun <?php echo date('Y'); ?>'
								},
								xAxis: {
									categories: [
										'Jan',
										'Feb',
										'Mar',
										'Apr',
										'May',
										'Jun',
										'Jul',
										'Aug',
										'Sep',
										'Oct',
										'Nov',
										'Dec'
									]
								},
								yAxis: {
									min: 0,
									title: {
										text: 'Jumlah Pasien'
									}
								},
								tooltip: {
									headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
									pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
										'<td style="padding:0"><b>{point.y:.f} Orang</b></td></tr>',
									footerFormat: '</table>',
									shared: true,
									useHTML: true
								},
								plotOptions: {
									column: {
										pointPadding: 0,
										borderWidth: 0
									}
								},
								series: [{
									name: 'Pasien Pria',
									data: 
									[
										<?php foreach($pria as $pr): ?>
											<?php echo $pr['jumlah'].', '; ?>
										<?php endforeach; ?>
									]
									//[0, 0, 0, 0, 92, 2, 0, 0, 0, 0, 0, 3,]
									}, {
									name: 'Pasien Wanita',
									data: 
									[
										<?php foreach($wanita as $wn): ?>
											<?php echo $wn['jumlah'].', '; ?>
										<?php endforeach; ?>
									]
									//[0, 0, 0, 0, 103, 8, 0, 0, 0, 0, 0, 4,]
									
								}]
							});
						});
    
						</script>
						<div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div> 
                          						
                        </div><!--widgetcontent-->
                        
						<h4 class="widgettitle">Jumlah Kunjungan Pasien / Bulan</h4>
						<script type="text/javascript">
						jQuery(function () {
								jQuery('#container').highcharts({
									chart: {
										type: 'line'
									},
									title: {
										text: 'Jumlah Kunjungan Pasien per Bulan'
									},
									subtitle: {
										text: 'Tahun <?php echo date('Y'); ?>'
									},
									xAxis: {
										categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
									},
									yAxis: {
										title: {
											text: 'Jumlah Kunjungan'
										}
									},
									plotOptions: {
										line: {
											dataLabels: {
												enabled: true
											},
											enableMouseTracking: false
										}
									},
									series: [{
										name: 'Kunjungan',
										data: 
										[
											<?php foreach($kunjungan as $k): ?>
												<?php echo $k['total_kunjungan'].', '; ?>
											<?php endforeach; ?>	
										]
									}]
								});
							});
					</script>
                 <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>    
                           
                    </div><!--span8-->
                    <div class="span4">
                    	<h4 class="widgettitle nomargin">Variable Unit Kerja</h4>
                        <div class="widgetcontent bordered">
							Kepala 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: DKK <br/>
							Alamat 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Jl  <br/>
							Kelurahan 	&nbsp;&nbsp;:  <br/>
							Kecamatan 	&nbsp;&nbsp;:  <br/>
							Last Update &nbsp;&nbsp;:
                        </div><!--widgetcontent-->
						
						<h4 class="widgettitle nomargin">Variable Dinas Kesehatan</h4>
                        <div class="widgetcontent bordered">
							Jumlah Penduduk 		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  <br/>
							Jumlah SDM Kesehatan 		&nbsp;:  <br/>
						</div><!--widgetcontent-->
                        
                        <h4 class="widgettitle nomargin">Penyakit Terbanyak</h4>
                        <div class="widgetcontent">
                        	<script type="text/javascript">
jQuery(function () {
    jQuery('#container3').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Tren Penyakit Terbanyak'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Persentase Jumlah Penyakit',
            data: [
			<?php $i=1; foreach($top_desease['data'] as $td): ?>
				<?php $persen = ($td['total'] / $top_desease['total_data']) * 100; ?>
				<?php if($i == 1): ?>
					{
						name: '<?php echo $td['penyakit']; ?>',
						y: <?php echo $persen; ?>,
						sliced: true,
						selected: true
					},
				<?php else: ?>
					['<?php echo $td['penyakit']; ?>',  <?php echo $persen; ?>],
				<?php endif; ?>
            	<?php $i++; ?>
            <?php endforeach; ?>
			/*
           		{
                    name: 'DBD',
                    y: 12.8,
                    sliced: true,
                    selected: true
                },
			*/
            ]
        }]
    });
});
    

		</script>
		<div id="container3" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
                        </div><!--widgetcontent-->
                        
                        
                        
                        
                    </div><!--span4-->
                </div><!--row-fluid-->
            </div><!--contentinner-->
        </div><!--maincontent-->
        
    </div><!--mainright-->