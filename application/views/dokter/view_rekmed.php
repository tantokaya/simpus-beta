<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Transaksi</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Daftar Pasien</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<li class="<?php if(!isset($view_rekam_medis))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Pasien Hari Ini</a></li>
							
							<?php if(isset($view_rekam_medis)):?>
            				<li class="ui-tabs-active"><a href="#rekam-medis"><i class="icon-file"></i> Rekam Medis</a></li>
            				<?php endif;?>
                        </ul>
                                     
                        <!---- DAFTAR PASIEN START ---->
   						<div id="list">
                        <?php echo $this->table->generate(); ?>
                        <script type="text/javascript">
												
							jQuery(document).ready(function () {
								var oTable = jQuery('#dyntable').dataTable({
									"bProcessing": true,
									"bServerSide": true,
									"bAutoWidth": false,
									"sAjaxSource": '<?php echo base_url(); ?>datatable_master/view_rekmed',
									"bJQueryUI": false,
									"sPaginationType": "full_numbers",
									/*
									"columnDefs": [
       									{ type: 'date-uk', targets: 4 }
     								],
									*/
									
									"aoColumns": [
										null,
										null,
										null,
										{ "fnRender": format_ddmmyyyy },
										null,
										null 
									],
									//"aaSortingFixed": [[0,'asc']],
									"fnDrawCallback": function(oSettings) {
										jQuery.uniform.update();
									},
									"iDisplayStart ": 10,
									"oLanguage": {
										"sProcessing": "<center><img src='<?php echo base_url(); ?>assets/img/loaders/loader_blue.gif' /></center>"
									},
									"fnInitComplete": function () {
										//oTable.fnAdjustColumnSizing();
									},
									'fnServerData': function (sSource, aoData, fnCallback) {
										jQuery.ajax
										({
											'dataType': 'json',
											'type': 'POST',
											'url': sSource,
											'data': aoData,
											'success': fnCallback
										});
									}
								});
							});
							
							function format_ddmmyyyy(oObj) {
							  var sValue = oObj.aData[oObj.iDataColumn]; 
							  var aDate = sValue.split('-');
							 
							  return aDate[2] + "/" + aDate[1] + "/" + aDate[0];
							}
						</script>
                        </div>
                         <!---- END DAFTAR pasien ---->
                        
                       
                        <!---- VIEW REKAM MEDIS STARTS---->
        				<?php if(isset($view_rekam_medis)):?>
                        <div id="rekam-medis">
                        	<h4 class="widgettitle nomargin">Rekam Medis Pasien</h4>
                            <div class="widgetcontent bordered">
                            	<div class="row-fluid">
                                	<div class="span6">
                                    	<table class="table table-bordered table-invoice">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">No. Rekam Medis</td>
                                                    <td width="70%"><?php echo $view_rekam_medis['kd_rekam_medis']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Pasien</td>
                                                    <td><?php echo $view_rekam_medis['nm_lengkap']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>TTL</td>
                                                    <td><?php echo $view_rekam_medis['tempat_lahir'].' / '.$this->functions->format_tgl_cetak2($view_rekam_medis['tanggal_lahir']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td><?php echo ucwords(strtolower($view_rekam_medis['jenis_kelamin'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Umur</td>
                                                    <td>
													<?php 
														$hitung = $this->functions->dateDifference($view_rekam_medis['tanggal_lahir'], date('Y-m-d'));
	    												echo $hitung[0].' Tahun '.$hitung[1].' Bulan'; 
													?> 
                                                   	</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="span6">
                                    	<table class="table table-bordered table-invoice">
                                            <tbody>
                                            <!--
                                                <tr>
                                                    <td width="30%">Golongan Darah</td>
                                                    <td width="70%"><?php echo $view_rekam_medis['gol_darah']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Marital</td>
                                                    <td><?php echo $view_rekam_medis['status_marital']; ?></td>
                                                </tr>
                                            !-->
                                                <tr>
                                                    <td>Nama Ibu</td>
                                                    <td><?php echo $view_rekam_medis['nm_ibu']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Kode Puskesmas</td>
                                                    <td><?php echo $view_rekam_medis['kd_puskesmas']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Puskesmas</td>
                                                    <td><?php echo $view_rekam_medis['nm_puskesmas']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- </span6> --> 
                                </div> <!-- </row-fluid> -->
                               <div class="clearfix"><br/></div>
                               <h4 class="widgettitle">Kunjungan Pasien</h4>
                                <div class="row-fluid">
                                	<div class="span12">
                                   		<table class="table table-bordered table-stripped table-hover">
                                        	<thead>
                                            	<tr>
                                                	<th>No.</th>
                                                    <th>Tanggal</th>
                                                    <th>Jenis</th>
                                                    <!--<th>Poli</th>-->
                                                    <th>Dokter</th>
                                                    <th>Anamnesa</th>
                                                    <th>Penyakit</th>
                                                    <th>Tindakan</th>
                                                    <th>Obat</th>
                                                    <!--
                                                    <th>Catatan Fisik</th>
                                                    <th>Catatan Dokter</th>
                                                    -->
                                                 </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(isset($view_trans_pelayanan) && !empty($view_trans_pelayanan)): ?>
                                            	<?php $i=1; foreach($view_trans_pelayanan as $rs): ?>
                                            	<tr>
                                                	<td><?php echo $i; ?></td>
                                                    <td><?php echo $this->functions->convert_date_indo(array("datetime" => $rs['tgl_pelayanan'])); ?></td>
                                                    <td><?php echo $rs['jenis_layanan']; ?></td> 
                                                    <!--<td><?php echo $rs['unit_layanan']; ?></td>-->
                                                    <td><?php echo $rs['dokter']; ?></td>
                                                    <td><?php echo $rs['anamnesa']; ?></td>
                                                    <td><?php echo $rs['kd_icd']; ?> - <?php echo $rs['penyakit']; ?></td>
                                                    <td><?php echo $rs['tindakan']; ?></td>
                                                    <td><?php echo $rs['obat']; ?></td>
                                                    <!--
                                                    <td><?php echo $rs['catatan_fisik']; ?></td>
                                                    <td><?php echo $rs['catatan_dokter']; ?></td>
                                                    -->
                                                </tr>
                                                <?php $i++; ?>
                                            	<?php endforeach; ?>
                                            <?php else: ?>
                                            	<tr>
                                                	<td colspan="11"><center>Tidak ada riwayat kunjungan</center></td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- </widgetcontent> -->
                        </div> <!-- <./rekam medis>
                        <?php endif; ?>
                        <!---- END VIEW REKAM MEDIS ---->
                	</div><!--tabs-->
                </div><!--span12-->
            </div><!--row-fluid-->
        </div><!--contentinner-->
    </div><!--maincontent-->
</div><!--mainright-->
<script type="text/javascript">
jQuery(document).ready(function(){
	// With Form Validation
	jQuery("#form_edit").validate({
		rules: {
			//nik: "required",
			nm_lengkap: "required",
			tempat_lahir: "required",
			tanggal_lahir: "required",
			kd_jenis_kelamin: "required",
			//kd_jenis_pasien: "required",
			//kd_bayar: "required",
			//nm_kk: "required",
			alamat: "required",
			kd_propinsi: "required",
			kd_kota: "required",
			kd_kecamatan: "required",
			kd_kelurahan: "required",
			//kd_agama: "required",
			//kd_gol_darah: "required",
			//kd_pendidikan: "required",
			//kd_pekerjaan: "required",
			//kd_status_marital: "required",
			//nm_ayah: "required",
			//nm_ibu: "required",
			kd_puskesmas: "required"
			
			
		},
		messages: {
			nik: "NIK harus diisi!",
			nm_lengkap: "Nama lengkap harus diisi!",
			tempat_lahir: "Tempat lahir harus diisi",
			tanggal_lahir: "Tanggal lahir harus diisi!",
			kd_jenis_kelamin: "Pilih jenis kelamin!",
			kd_jenis_pasien: "Pilih jenis pasien!",
			kd_bayar: "Pilih kode bayar!",
			nm_kk: "Nama KK harus diisi!",
			alamat: "Alamat harus diisi!",
			kd_propinsi: "Pilih propinsi!",
			kd_kota: "Pilih kota!",
			kd_kecamatan: "Pilih kecamatan!",
			kd_kelurahan: "Pilih kelurahan!",
			kd_agama: "Pilih agama!",
			kd_gol_darah: "Pilih golongan darah!",
			kd_pendidikan: "Pilih pendidikan!",
			kd_pekerjaan: "Pilih pekerjaan!",
			kd_status_marital: "Pilih status marital!",
			nm_ayah: "Nama ayah kandung harus diisi!",
			nm_ibu: "Nama ibu harus diisi!",
			kd_puskesmas: "Pilih puskesmas!"
		},
		highlight: function(label) {
			jQuery(label).closest('p').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('Ok!').addClass('valid')
	    		.closest('p').addClass('success');
	    }
	});
	
	jQuery("#form_input").validate({
		rules: {
			//nik: "required",
			nm_lengkap: "required",
			tempat_lahir: "required",
			tanggal_lahir: "required",
			kd_jenis_kelamin: "required",
			//kd_jenis_pasien: "required",
			//kd_bayar: "required",
			//nm_kk: "required",
			alamat: "required",
			kd_propinsi: "required",
			kd_kota: "required",
			kd_kecamatan: "required",
			kd_kelurahan: "required",
			//kd_agama: "required",
			//kd_gol_darah: "required",
			//kd_pendidikan: "required",
			//kd_pekerjaan: "required",
			//kd_status_marital: "required",
			//nm_ayah: "required",
			//nm_ibu: "required",
			kd_puskesmas: "required"
		},
		messages: {
			nik: "NIK harus diisi!",
			nm_lengkap: "Nama lengkap harus diisi!",
			tempat_lahir: "Tempat lahir harus diisi",
			tanggal_lahir: "Tanggal lahir harus diisi!",
			kd_jenis_kelamin: "Pilih jenis kelamin!",
			kd_jenis_pasien: "Pilih jenis pasien!",
			kd_bayar: "Pilih kode bayar!",
			nm_kk: "Nama KK harus diisi!",
			alamat: "Alamat harus diisi!",
			kd_propinsi: "Pilih propinsi!",
			kd_kota: "Pilih kota!",
			kd_kecamatan: "Pilih kecamatan!",
			kd_kelurahan: "Pilih kelurahan!",
			kd_agama: "Pilih agama!",
			kd_gol_darah: "Pilih golongan darah!",
			kd_pendidikan: "Pilih pendidikan!",
			kd_pekerjaan: "Pilih pekerjaan!",
			kd_status_marital: "Pilih status marital!",
			nm_ayah: "Nama ayah kandung harus diisi!",
			nm_ibu: "Nama ibu harus diisi!",
			kd_puskesmas: "Pilih puskesmas!"
		},
		highlight: function(label) {
			jQuery(label).closest('p').addClass('error');
	    },
	    success: function(label) {
	    	label
	    		.text('Ok!').addClass('valid')
	    		.closest('p').addClass('success');
	    }
	});
	
	// jQuery Chosen
	jQuery("#kd_propinsi").chosen().change(function(){
		var kd_propinsi = jQuery("#kd_propinsi").val();
		console.log(kd_propinsi);
		jQuery("#kd_kecamatan").html('').trigger("liszt:updated");
		
		var html = '';
		jQuery.ajax({
			type: "POST",
			url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKota'; ?>',
			data: 'kd_propinsi=' + kd_propinsi,
			success: function(data) {
				jQuery('#kd_kota').html(data).trigger("liszt:updated");
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		 });
     });
	 
	 jQuery("#kd_kota").chosen().change(function(){
		var kd_kota = jQuery("#kd_kota").val();
			var html = '';
			jQuery.ajax({
			type: "POST",
				url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKecamatan'; ?>',
				data: 'kd_kota=' + kd_kota,
				success: function(data) {
				jQuery('#kd_kecamatan').html(data).trigger("liszt:updated");
				},  
		   error: function(e){  
				alert('Error: ' + e);  
				}  
		 });
     });
	 
	 jQuery("#kd_kecamatan").chosen().change(function(){
		var kd_kecamatan = jQuery("#kd_kecamatan").val();
			var html = '';
			jQuery.ajax({
			type: "POST",
				url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKelurahan'; ?>',
				data: 'kd_kecamatan=' + kd_kecamatan,
				success: function(data) {
				jQuery('#kd_kelurahan').html(data).trigger("liszt:updated");
				},  
		   error: function(e){  
				alert('Error: ' + e);  
				}  
		 });
     });
	 
	 jQuery("#kd_propinsi2").chosen().change(function(){
		var kd_propinsi = jQuery("#kd_propinsi2").val();
		console.log(kd_propinsi);
		jQuery("#kd_kecamatan2").html('').trigger("liszt:updated");
		
		var html = '';
		jQuery.ajax({
			type: "POST",
			url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKota'; ?>',
			data: 'kd_propinsi=' + kd_propinsi,
			success: function(data) {
				jQuery('#kd_kota2').html(data).trigger("liszt:updated");
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		 });
     });
	 
	 jQuery("#kd_kota2").chosen().change(function(){
		var kd_kota = jQuery("#kd_kota2").val();
		console.log(kd_propinsi);
			var html = '';
			jQuery.ajax({
				type: "POST",
				url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKecamatan'; ?>',
				data: 'kd_kota=' + kd_kota,
				success: function(data) {
					jQuery('#kd_kecamatan2').html(data).trigger("liszt:updated");
				},  
		   error: function(e){  
				alert('Error: ' + e);  
			}  
		 });
     });
	 
	 jQuery("#tanggal_lahir").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "-150:+0",
		dayNamesMin: ['M', 'S', 'S', 'R', 'K', 'J', 'S'],
		monthNamesShort: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
	});
	
	jQuery("#tanggal_lahir2").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "-150:+0",
		dayNamesMin: ['M', 'S', 'S', 'R', 'K', 'J', 'S'],
		monthNamesShort: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
	});
	
});

</script>