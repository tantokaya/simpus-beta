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
                    <script language="JavaScript">
        var text="Selamat Datang di <?php echo $nm_puskesmas; ?>";
        var delay=30;
        var currentChar=1;
        var destination="[none]";
        function type()
        {
//if (document.all)
            {
                var dest=document.getElementById(destination);
                if (dest)// && dest.innerHTML)
                {
                    dest.innerHTML=text.substr(0, currentChar)+"<blink>_</blink>";
                    currentChar++;
                    if (currentChar>text.length)
                    {
                        currentChar=1;
                        setTimeout("type()", 5000);
                    }
                    else
                    {
                        setTimeout("type()", delay);
                    }
                }
            }
        }
        function startTyping(textParam, delayParam, destinationParam)
        {
            text=textParam;
            delay=delayParam;
            currentChar=1;
            destination=destinationParam;
            type();
        }
    </script>
    <b><div id="textDestination" style="font-size: 14px;" ></div></b>

    <script language="JavaScript">
        javascript:startTyping(text, 50, "textDestination");
    </script>
    Berikut ini adalah data-data Pelayanan Kesehatan Masyarakat dari <?php echo $nm_puskesmas; ?> <b><?php echo $nm_kota; ?></b>.                </div><!--alert-->
			<!-- Barisan statistik hari ini-->	
				<div class="row-fluid">
				
				<div class="span4">
				<h4 class="widgettitle nomargin">Kunjungan Pasien Dalam Wilayah Hari ini</h4>
                <div class="widgetcontent bordered">
					<center><h1><?php echo $total_kunjungan_date_dlm_wil['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>

				<div class="span4">
				<h4 class="widgettitle nomargin">Kunjungan Pasien Luar Wilayah Hari ini</h4>
                <div class="widgetcontent bordered">
                   <center><h1><?php echo $total_kunjungan_date_luar_wil['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>
				
				<div class="span4">
				<h4 class="widgettitle nomargin">Kunjungan Pasien Luar Kota Hari ini</h4>
                <div class="widgetcontent bordered">
                   <center><h1><?php echo $total_kunjungan_date_luar_kota['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>
								
				</div>
           
	<!-- Barisan statistik MINGGU ini-->	
				<div class="row-fluid">
				
				<div class="span4">
				<h4 class="widgettitle nomargin">Pasien Dalam Wilayah Minggu ini</h4>
                <div class="widgetcontent bordered">
					<center><h1><?php echo $total_kunjungan_week_dlm_wil['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>

				<div class="span4">
				<h4 class="widgettitle nomargin">Pasien Luar Wilayah Minggu ini</h4>
                <div class="widgetcontent bordered">
                   <center><h1><?php echo $total_kunjungan_week_luar_wil['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>
				
				<div class="span4">
				<h4 class="widgettitle nomargin">Pasien Luar Kota Minggu ini</h4>
                <div class="widgetcontent bordered">
                   <center><h1><?php echo $total_kunjungan_week_luar_kota['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div><!--widgetcontent-->
				</div>
								
				</div>

<!-- Barisan statistik BULAN ini-->	


<!--	Total			<div class="span4">
				<h4 class="widgettitle nomargin">Total Kunjungan Hari ini</h4>
                <div class="widgetcontent bordered">
					<center><h1><?php echo $total_kunjungan_date['total_kunjungan']; ?></h1><br/>
					Kunjungan loket</center>
                </div>
				</div>	-->

				
                <div class="row-fluid">
                	<div class="span8">
                    	<!--<ul class="widgeticons row-fluid">
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
                        </ul>-->
                        
                        <br />
                        
                        
                        
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
        <table>
            <tr>
                <td><img src="<?php echo base_url(); ?>assets/img/thumbs/<?php echo $logo; ?>"><br/></td>
            </tr>
            <tr>
                <td>N I P</td><td>&nbsp;:</td><td>&nbsp;<b><?php echo $nip_kpl; ?></b></td>
            </tr>
            <tr>
                <td>Kepala Puskesmas</td><td>&nbsp;:</td><td>&nbsp;<b><?php echo $kpl_puskesmas; ?></b></td>
            </tr>
            <tr>
                <td>Propinsi</td><td>&nbsp;:</td><td>&nbsp;<?php echo $nm_propinsi; ?></td>
            </tr>
            <tr>
                <td>Kota/Kab</td><td>&nbsp;:</td><td>&nbsp;<?php echo $nm_kota; ?></td>
            </tr>
            <tr>
                <td>Kecamatan</td><td>&nbsp;:</td><td>&nbsp;<?php echo $nm_kecamatan; ?></td>
            </tr>
            <tr>
                <td>Kelurahan</td><td>&nbsp;:</td><td>&nbsp;<?php echo $nm_kelurahan; ?></td>
            </tr>
            <tr>
                <td>Alamat</td><td>&nbsp;:</td><td>&nbsp;<?php echo $alamat; ?></td>
            </tr>
        </table>
    </div><!--widgetcontent-->
						
						
                        
                        
                        
                    </div><!--span4-->
                </div><!--row-fluid-->
            </div><!--contentinner-->
        </div><!--maincontent-->
        
    </div><!--mainright-->

<!--highcharts-->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>