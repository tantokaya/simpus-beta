<style type="text/css">
	.kd_penyakit {
		border-radius: 0px;
		background: #4a4a4a;
		color: #96f226;
		border: 1px solid #454545;
		height: 0 0 30px;
	}
	
	.ui-tooltip {
		background: #4a4a4a;
		color: #96f226;
		border: 2px solid #454545;
		border-radius: 0px;
		box-shadow: 0 0 
	}
	.ui-autocomplete {
		background: #4a4a4a;
		border-radius: 1px;
	}
	.ui-autocomplete.source:hover {
		background: #454545;
	}
	
	.ui-menu .ui-menu-item a{
		color: #ffffff;
		border-radius: 0px;
		border: 1px solid #454545;
	}
	
	.ui-menu .ui-menu-item a:hover{
		color: #96f226;
		border-radius: 0px;
		border: 1px solid #454545;
	}
	
	#rawat-inap { display: none;}
	#rawat-inap2 { display: none;}
</style>
<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Pelayanan</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data pelayanan pasien</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>	
                            <li class="<?php if(!isset($edit_pelayanan) && strlen($this->uri->segment(3)) < 17)echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Transaksi Pelayanan</a></li>
                      
                        </ul>
                        
                       
                       <!---- DAFTAR pelayanan START ---->
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
                        <script type="text/javascript">
							jQuery(document).ready(function () {
								var oTable = jQuery('#dyntable').dataTable({
									"bProcessing": true,
									"bServerSide": true,
									"bAutoWidth": false,
									"sAjaxSource": '<?php echo base_url(); ?>datatable_master/pelayanan',
									"bJQueryUI": false,
									"sPaginationType": "full_numbers",
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
						</script>
                        </div>
                         <!---- END daftar pelayanan---->
                        
                       
                	</div><!--tabs-->
                </div><!--span12-->
            </div><!--row-fluid-->
        </div><!--contentinner-->
    </div><!--maincontent-->
</div><!--mainright-->

<script type="text/javascript">
	var $ = jQuery.noConflict();
jQuery(document).ready(function(){

	// Cari pasien berdasar no. rekam medis
	jQuery("#kd_rekam_medis").keyup(function(e){
		var isi = jQuery(e.target).val();
		jQuery(e.target).val(isi.toUpperCase());
		CariPasien();
	});
	
	jQuery("#kd_rekam_medis").blur(function(e){
		var isi = jQuery(e.target).val();
		CariPasien();
	});
	
	jQuery("#kd_rekam_medis").focus(function(e){
		var isi = jQuery(e.target).val();
		CariPasien();
	});
	
	jQuery("#kd_rekam_medis").keyup(function(){
		CariPasien();
	});
	
	function CariPasien(){
		var rekam_medis = jQuery("#kd_rekam_medis").val();
		jQuery.ajax({
			type	: 'POST',
			url		: "<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_pasien",
			data	: "rekam_medis="+rekam_medis,
			cache	: false,
			dataType : "json",
			success	: function(data){
				jQuery("#nm_lengkap").val(data.nm_lengkap);
				jQuery("#nik").val(data.nik);
				jQuery("#tempat_lahir").val(data.tempat_lahir);
				jQuery("#tanggal_lahir").val(data.tanggal_lahir);
				jQuery("#jenis_kelamin").val(data.jenis_kelamin);
				//jQuery("#gol_darah").val(data.gol_darah);
				jQuery("#no_kk").val(data.no_kk);
				jQuery("#nm_kk").val(data.nm_kk);
				//jQuery("#cara_bayar").val(data.cara_bayar);
				
				//jQuery( "#lihat-rm" ).attr( "href", "http://facebook.com" );
				
			}
		});
	};
	
	<?php if(strlen($this->uri->segment(3)) >= 17): ?>
		jQuery("#kd_rekam_medis").val('<?php echo $this->uri->segment(3); ?>');
		jQuery("#kd_rekam_medis").attr('readonly','readonly');
		jQuery("#kd_rekam_medis").blur();
	<?php endif; ?>

	// Validasi
	jQuery("#form_input").validate({
		rules: {
			nm_ibu: "required",
			kd_puskesmas: "required"
		},
		messages: {
			
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
	 
	// Smart Wizard (step) 	
	jQuery('#wizard1').smartWizard();
  	jQuery('#wizard2').smartWizard();
	
	// Chaining form rawat inap
	jQuery('#kd_jenis_layanan').change(function () {
		if (jQuery(this).val() == '3')  // Rawat Inap 
		{
			jQuery('#rawat-inap').show();
		} else {
			jQuery('#rawat-inap').hide();
		}
	});
	
	jQuery('#kd_jenis_layanan2').change(function () {
		if (jQuery(this).val() == '3')  // Rawat Inap 
		{
			jQuery('#rawat-inap2').show();
		} else {
			jQuery('#rawat-inap2').hide();
		}
	});
	
	// Firing kamar rawat inap
	jQuery('#kd_ruangan').change(function () {
		var kd_ruangan = jQuery(this).val();
		var kelas = jQuery('#kelas').val();
		
		jQuery.ajax({
			type	: 'POST',
			url		: '<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_kamar',
			data	: 'kd_ruangan='+kd_ruangan+'&kelas='+kelas,
			cache	: false,
			success: function(data) {
				//console.log(data);
				jQuery('#kd_bed').html(data);
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		});
		
	});
	
	jQuery('#kd_ruangan').focus(function () {
		var kd_ruangan = jQuery(this).val();
		//console.log(kd_ruangan);
		var kelas = jQuery('#kelas').val();
		//console.log(kelas);
		
		jQuery.ajax({
			type	: 'POST',
			url		: '<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_kamar',
			data	: 'kd_ruangan='+kd_ruangan+'&kelas='+kelas,
			cache	: false,
			success: function(data) {
				//console.log(data);
				jQuery('#kd_bed').html(data);
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		});
		
	});
	
	jQuery('#kelas').change(function () {
		var kelas = jQuery(this).val();
		var kd_ruangan = jQuery('#kd_ruangan').val();
		
		jQuery.ajax({
			type	: 'POST',
			url		: '<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_kamar',
			data	: 'kd_ruangan='+kd_ruangan+'&kelas='+kelas,
			cache	: false,
			success: function(data) {
				//console.log(data);
				jQuery('#kd_bed').html(data);
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		});
		
	});
	
	jQuery('#kelas').focus(function () {
		var kelas = jQuery(this).val();
		var kd_ruangan = jQuery('#kd_ruangan').val();
		
		jQuery.ajax({
			type	: 'POST',
			url		: '<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_kamar',
			data	: 'kd_ruangan='+kd_ruangan+'&kelas='+kelas,
			cache	: false,
			success: function(data) {
				//console.log(data);
				jQuery('#kd_bed').html(data);
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		});
		
	});
	
	// edit
	jQuery('#kd_ruangan2').change(function () {
		var kd_ruangan = jQuery(this).val();
		var kelas = jQuery('#kelas2').val();
		
		jQuery.ajax({
			type	: 'POST',
			url		: '<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_kamar',
			data	: 'kd_ruangan='+kd_ruangan+'&kelas='+kelas,
			cache	: false,
			success: function(data) {
				//console.log(data);
				jQuery('#kd_bed2').html(data);
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		});
		
	});
	
	jQuery('#kd_ruangan2').focus(function () {
		var kd_ruangan = jQuery(this).val();
		//console.log(kd_ruangan);
		var kelas = jQuery('#kelas2').val();
		//console.log(kelas);
		
		jQuery.ajax({
			type	: 'POST',
			url		: '<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_kamar',
			data	: 'kd_ruangan='+kd_ruangan+'&kelas='+kelas,
			cache	: false,
			success: function(data) {
				//console.log(data);
				jQuery('#kd_bed2').html(data);
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		});
		
	});
	
	jQuery('#kelas2').change(function () {
		var kelas = jQuery(this).val();
		var kd_ruangan = jQuery('#kd_ruangan2').val();
		
		jQuery.ajax({
			type	: 'POST',
			url		: '<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_kamar',
			data	: 'kd_ruangan='+kd_ruangan+'&kelas='+kelas,
			cache	: false,
			success: function(data) {
				//console.log(data);
				jQuery('#kd_bed2').html(data);
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		});
		
	});
	
	jQuery('#kelas2').focus(function () {
		var kelas = jQuery(this).val();
		var kd_ruangan = jQuery('#kd_ruangan2').val();
		
		jQuery.ajax({
			type	: 'POST',
			url		: '<?php echo base_url(); ?>cont_transaksi_pelayanan/cari_kamar',
			data	: 'kd_ruangan='+kd_ruangan+'&kelas='+kelas,
			cache	: false,
			success: function(data) {
				//console.log(data);
				jQuery('#kd_bed2').html(data);
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		});
	});
	
	<?php if(isset($edit_bed)): ?>
   		jQuery('#rawat-inap2').show();
    <?php endif; ?>
	
	// flag form rujukan disabled or not
	jQuery('#no_rujukan').attr('readonly','readonly');
	jQuery('#tempat_rujukan').attr('readonly','readonly');
	
	<?php if(!isset($row['no_rujukan']) or $row['no_rujukan'] == ''): ?>
   		jQuery('#no_rujukan2').attr('readonly','readonly');
		jQuery('#tempat_rujukan2').attr('readonly','readonly');
    <?php endif; ?>
	
	jQuery('#kd_status_pasien').change(function () {
		if (jQuery(this).val() == 'SKP-1' || jQuery(this).val() == 'SKP-2')  // Tidak di rujuk 
		{
			jQuery('#no_rujukan').attr('readonly','readonly');
			jQuery('#tempat_rujukan').attr('readonly','readonly');
		} 
		else if(jQuery(this).val() == 'SKP-3' || jQuery(this).val() == 'SKP-4') // Di rujuk
		{
			jQuery('#no_rujukan').removeAttr('readonly');
			jQuery('#tempat_rujukan').removeAttr('readonly');
		}
		else
		{
			jQuery('#no_rujukan').attr('readonly','readonly');
			jQuery('#tempat_rujukan').attr('readonly','readonly');
		}
	});
	
	jQuery('#kd_status_pasien2').change(function () {
		if (jQuery(this).val() == 'SKP-1' || jQuery(this).val() == 'SKP-2')  // Tidak di rujuk 
		{
			jQuery('#no_rujukan2').attr('readonly','readonly');
			jQuery('#tempat_rujukan2').attr('readonly','readonly');
		} 
		else if(jQuery(this).val() == 'SKP-3' || jQuery(this).val() == 'SKP-4') // Di rujuk
		{
			jQuery('#no_rujukan2').removeAttr('readonly');
			jQuery('#tempat_rujukan2').removeAttr('readonly');
		}
		else
		{
			jQuery('#no_rujukan2').attr('readonly','readonly');
			jQuery('#tempat_rujukan2').attr('readonly','readonly');
		}
	});
	
	
	// lihat rekam medis
	jQuery("#DataRM").dialog({
      autoOpen: false,
	  height:400,
	  width:800,
      show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "explode",
        duration: 500
      }
    }); 	
	
	jQuery("#lihat-rm").click(function() {
      jQuery("#DataRM").dialog("open");
    });
	jQuery("#tutup").click(function() {
      jQuery("#DataRM").dialog("close");
    });
	
});

// Autocomplete Kode ICD
jQuery(function() {
	var counter = 1;
	var options = {
		source: '<?php echo base_url(); ?>cont_transaksi_pelayanan/autoCompleteICD',
		minLength: 2,
		focus: function( event, ui ) {
        			jQuery('#kd_penyakit_'+counter).val(ui.item.value);
					jQuery(this).closest('tr').find('input.penyakit').val(ui.item.penyakit);  
					//console.log(ui.item.alamat);
        },
        select: function( event, ui ) {
					//event.preventDefault();
                    jQuery('#kd_penyakit_'+counter).val(ui.item.value);
					jQuery(this).closest('tr').find('input.penyakit').val(ui.item.penyakit);                        
               		//console.log(ui.item.penyakit);
                   //return false;
        },
		messages: {
		   		noResults:	''
		}
	};
		
	jQuery('input.kd_penyakit').live("keydown.autocomplete", function() {
		jQuery(this).autocomplete(options);
	});
	
	var addInput = function() {
		if (counter > 1){
			jQuery('a#removePenyakit').removeAttr('disabled');
		}
			
		var inputHTML = '<tr><td><div id="'+counter+'">'+counter+'</div></td><td><input type="text" name="kd_penyakit_'+counter+'" id="kd_penyakit_'+counter+'" class="kd_penyakit input-large" /></td><td><input type="text" name="penyakit_'+counter+'" id="penyakit_'+counter+'" class="penyakit input-large" /></td><td><select name="kd_jenis_kasus_'+counter+'" id="kd_jenis_kasus_'+counter+'" class="kd_jenis_kasus uniformselect" style="width:150px"><option value="-">Pilih Jenis Kasus</option><?php foreach($list_jenis_kasus as $ljk) : ?><option value="<?php echo $ljk['kd_jenis_kasus']; ?>"><?php echo $ljk['jenis_kasus']; ?></option><?php endforeach; ?></select></td><td><select name="kd_jenis_diagnosa_'+counter+'" id="kd_jenis_diagnosa_'+counter+'" class="kd_jenis_diagnosa uniformselect" style="width:150px"><option value="-">Pilih Jenis Diagnosa</option><?php foreach($list_jenis_diagnosa as $ljd) : ?><option value="<?php echo $ljd['kd_jenis_diagnosa']; ?>"><?php echo $ljd['jenis_diagnosa']; ?></option><?php endforeach; ?></select></td></tr>';
		
		jQuery(inputHTML).appendTo("table#tbl-penyakit tbody");
		counter++;
	};
		
	var removeInput = function() {
		counter--;
		if(counter == 1){
			jQuery('a#removePenyakit').attr('disabled','disabled');
			//alert("Minimal sisa 1!");
			counter++;
			//console.log('Jika Counter == 1 :' + counter);
		}else{
			jQuery("table#tbl-penyakit tbody tr:last").remove();
			//console.log('Jika Counter != 1 :' + counter);
		}
	};
	
	if (!jQuery("table#tbl-penyakit tbody").find("input.kd_penyakit").length) {
		addInput();
	}
	
	var refreshFocus = function() {
		jQuery("input.kd_penyakit:last").focus();
		jQuery('html, body').animate({
       		scrollTop: jQuery("input.kd_penyakit:last").offset().top
    	}, 2000);
	};
	
	//jQuery("a#addPenyakit").click(addInput);
	jQuery("a#addPenyakit").click(function() {
		addInput();
		refreshFocus();
	});
	//jQuery("a#removePenyakit").click(removeInput);
	jQuery("a#removePenyakit").click(function() {
		removeInput();
		refreshFocus();
	});
});	

jQuery(function() {
	var counter = <?php if(isset($counter)) echo $counter; else echo 1; ?>;
	var options = {
		source: '<?php echo base_url(); ?>cont_transaksi_pelayanan/autoCompleteICD',
		minLength: 2,
		focus: function( event, ui ) {
        			jQuery('#kd_penyakit2_'+counter).val(ui.item.value);
					jQuery(this).closest('tr').find('input.penyakit2').val(ui.item.penyakit);  
					//console.log(ui.item.alamat);
        },
        select: function( event, ui ) {
					//event.preventDefault();
                    jQuery('#kd_penyakit2_'+counter).val(ui.item.value);
					jQuery(this).closest('tr').find('input.penyakit2').val(ui.item.penyakit);                        
               		//console.log(ui.item.penyakit);
                   //return false;
        },
		messages: {
		   		noResults:	''
		}
	};
		
	jQuery('input.kd_penyakit2').live("keydown.autocomplete", function() {
		jQuery(this).autocomplete(options);
	});
	
	var addInput = function() {
		if (counter > 1){
			jQuery('a#removePenyakit2').removeAttr('disabled');
		}
			
		var inputHTML = '<tr><td><div id="'+counter+'">'+counter+'</div></td><td><input type="text" name="kd_penyakit_'+counter+'" id="kd_penyakit2_'+counter+'" class="kd_penyakit2 input-large" /></td><td><input type="text" name="penyakit_'+counter+'" id="penyakit2_'+counter+'" class="penyakit2 input-large" /></td><td><select name="kd_jenis_kasus_'+counter+'" id="kd_jenis_kasus2_'+counter+'" class="kd_jenis_kasus2 uniformselect" style="width:150px"><option value="-">Pilih Jenis Kasus</option><?php foreach($list_jenis_kasus as $ljk) : ?><option value="<?php echo $ljk['kd_jenis_kasus']; ?>"><?php echo $ljk['jenis_kasus']; ?></option><?php endforeach; ?></select></td><td><select name="kd_jenis_diagnosa_'+counter+'" id="kd_jenis_diagnosa2_'+counter+'" class="kd_jenis_diagnosa2 uniformselect" style="width:150px"><option value="-">Pilih Jenis Diagnosa</option><?php foreach($list_jenis_diagnosa as $ljd) : ?><option value="<?php echo $ljd['kd_jenis_diagnosa']; ?>"><?php echo $ljd['jenis_diagnosa']; ?></option><?php endforeach; ?></select></td></tr>';
		
		jQuery(inputHTML).appendTo("table#tbl-penyakit2 tbody");
		counter++;
	};
		
	var removeInput = function() {
		counter--;
		if(counter == 1){
			jQuery('a#removePenyakit2').attr('disabled','disabled');
			//alert("Minimal sisa 1!");
			counter++;
			//console.log('Jika Counter == 1 :' + counter);
		}else{
			jQuery("table#tbl-penyakit2 tbody tr:last").remove();
			//console.log('Jika Counter != 1 :' + counter);
		}
	};
	
	if (!jQuery("table#tbl-penyakit2 tbody").find("input.kd_penyakit2").length) {
		addInput();
	}
	
	var refreshFocus = function() {
		jQuery("input.kd_penyakit2:last").focus();
		jQuery('html, body').animate({
       		scrollTop: jQuery("input.kd_penyakit2:last").offset().top
    	}, 2000);
	};
	
	//jQuery("a#addPenyakit").click(addInput);
	jQuery("a#addPenyakit2").click(function() {
		addInput();
		refreshFocus();
	});
	//jQuery("a#removePenyakit").click(removeInput);
	jQuery("a#removePenyakit2").click(function() {
		removeInput();
		refreshFocus();
	});
});

// Autocomplete Tindakan
jQuery(function() {
	var counter2 = 1;
	var options = {
		source: '<?php echo base_url(); ?>cont_transaksi_pelayanan/autoCompleteTindakan',
		minLength: 2,
		focus: function( event, ui ) {
        			jQuery('#produk_'+counter2).val(ui.item.value);
					jQuery(this).closest('tr').find('input.kd_produk').val(ui.item.kd_produk);
					jQuery(this).closest('tr').find('input.harga').val(ui.item.harga);  
					//console.log(ui.item.alamat);
        },
        select: function( event, ui ) {
					//event.preventDefault();
                    jQuery('#produk_'+counter2).val(ui.item.value);
					jQuery(this).closest('tr').find('input.kd_produk').val(ui.item.kd_produk);
					jQuery(this).closest('tr').find('input.harga').val(ui.item.harga);                        
               		//console.log(ui.item.penyakit);
                   //return false;
        },
		messages: {
		   		noResults:	''
		}
	};
		
	jQuery('input.produk').live("keydown.autocomplete", function() {
		jQuery(this).autocomplete(options);
	});
	
	var addInput = function() {
		if (counter2 > 1){
			jQuery('a#removeTindakan').removeAttr('disabled');
		}
			
		var inputHTML = '<tr><td><div id="'+counter2+'">'+counter2+'</div><input type="hidden" name="kd_produk_'+counter2+'" id="kd_produk_'+counter2+'" class="kd_produk" /></td><td><input type="text" name="produk_'+counter2+'" id="produk_'+counter2+'" class="produk input-large" /></td><td><input type="text" name="harga_'+counter2+'" id="harga_'+counter2+'" class="harga input-small" readonly /></td><td><input type="text" name="qty_'+counter2+'" id="qty_'+counter2+'" class="qty input-small" /></td><td><input type="text" name="ket_tindakan_'+counter2+'" id="ket_tindakan_'+counter2+'" class="ket_tindakan input-large" /></td></tr>';
		
		jQuery(inputHTML).appendTo("table#tbl-tindakan tbody");
		counter2++;
	};
		
	var removeInput = function() {
		counter2--;
		if(counter2 == 1){
			jQuery('a#removeTindakan').attr('disabled','disabled');
			counter2++;
			//console.log('Jika Counter == 1 :' + counter2);
		}else{
			jQuery("table#tbl-tindakan tbody tr:last").remove();
			//console.log('Jika Counter != 1 :' + counter2);
		}
	};
	
	if (!jQuery("table#tbl-tindakan tbody").find("input.produk").length) {
		addInput();
	}
	
	var refreshFocus = function() {
		jQuery("input.produk:last").focus();
		jQuery('html, body').animate({
       		scrollTop: jQuery("input.produk:last").offset().top
    	}, 2000);
	};
	
	//jQuery("a#addTindakan").click(addInput);
	jQuery("a#addTindakan").click(function() {
		addInput();
		refreshFocus();
	});
	//jQuery("a#removeTindakan").click(removeInput);
	jQuery("a#removeTindakan").click(function() {
		removeInput();
		refreshFocus();
	});
});

jQuery(function() {
	var counter2 = <?php if(isset($counter2)) echo $counter2; else echo 1; ?>;
	var options = {
		source: '<?php echo base_url(); ?>cont_transaksi_pelayanan/autoCompleteTindakan',
		minLength: 2,
		focus: function( event, ui ) {
        			jQuery('#produk2_'+counter2).val(ui.item.value);
					jQuery(this).closest('tr').find('input.kd_produk2').val(ui.item.kd_produk);
					jQuery(this).closest('tr').find('input.harga2').val(ui.item.harga);  
					//console.log(ui.item.alamat);
        },
        select: function( event, ui ) {
					//event.preventDefault();
                    jQuery('#produk_'+counter2).val(ui.item.value);
					jQuery(this).closest('tr').find('input.kd_produk2').val(ui.item.kd_produk);
					jQuery(this).closest('tr').find('input.harga2').val(ui.item.harga);                        
               		//console.log(ui.item.penyakit);
                   //return false;
        },
		messages: {
		   		noResults:	''
		}
	};
		
	jQuery('input.produk2').live("keydown.autocomplete", function() {
		jQuery(this).autocomplete(options);
	});
	
	var addInput = function() {
		if (counter2 > 1){
			jQuery('a#removeTindakan2').removeAttr('disabled');
		}
			
		var inputHTML = '<tr><td><div id="'+counter2+'">'+counter2+'</div><input type="hidden" name="kd_produk_'+counter2+'" id="kd_produk2_'+counter2+'" class="kd_produk2" /></td><td><input type="text" name="produk_'+counter2+'" id="produk2_'+counter2+'" class="produk2 input-large" /></td><td><input type="text" name="harga_'+counter2+'" id="harga2_'+counter2+'" class="harga2 input-small" /></td><td><input type="text" name="qty_'+counter2+'" id="qty2_'+counter2+'" class="qty2 input-small" /></td><td><input type="text" name="ket_tindakan_'+counter2+'" id="ket_tindakan2_'+counter2+'" class="ket_tindakan2 input-large" /></td></tr>';
		
		jQuery(inputHTML).appendTo("table#tbl-tindakan2 tbody");
		counter2++;
	};
		
	var removeInput = function() {
		counter2--;
		if(counter2 == 1){
			jQuery('a#removeTindakan2').attr('disabled','disabled');
			//alert("Minimal sisa 1!");
			counter2++;
			//console.log('Jika Counter == 1 :' + counter2);
		}else{
			jQuery("table#tbl-tindakan2 tbody tr:last").remove();
			//console.log('Jika Counter != 1 :' + counter2);
		}
	};
	
	if (!jQuery("table#tbl-tindakan2 tbody").find("input.produk2").length) {
		addInput();
	}
	
	var refreshFocus = function() {
		jQuery("input.produk2:last").focus();
		jQuery('html, body').animate({
       		scrollTop: jQuery("input.produk2:last").offset().top
    	}, 2000);
	};
	
	//jQuery("a#addTindakan").click(addInput);
	jQuery("a#addTindakan2").click(function() {
		addInput();
		refreshFocus();
	});
	//jQuery("a#removeTindakan").click(removeInput);
	jQuery("a#removeTindakan2").click(function() {
		removeInput();
		refreshFocus();
	});
});		

// Autocomplete Obat
jQuery(function() {
	var counter3 = 1;
	var options = {
		source: '<?php echo base_url(); ?>cont_transaksi_pelayanan/autoCompleteObat',
		minLength: 2,
		focus: function( event, ui ) {
        			jQuery('#nama_obat_'+counter3).val(ui.item.value);
					jQuery(this).closest('tr').find('input.kd_obat').val(ui.item.kd_obat);
					//console.log(ui.item.kd_obat);
        },
        select: function( event, ui ) {
					//event.preventDefault();
                    jQuery('#nama_obat_'+counter3).val(ui.item.value);
					jQuery(this).closest('tr').find('input.kd_obat').val(ui.item.kd_obat);                      
               		//console.log(ui.item.penyakit);
                   //return false;
        },
		messages: {
		   		noResults:	''
		}
	};
		
	jQuery('input.nama_obat').live("keydown.autocomplete", function() {
		jQuery(this).autocomplete(options);
	});
	
	var addInput = function() {
		if (counter3 > 1){
			jQuery('a#removeObat').removeAttr('disabled');
		}
			
		var inputHTML = '<tr><td><div id="'+counter3+'">'+counter3+'</div><input type="hidden" name="kd_obat_'+counter3+'" id="kd_obat_'+counter3+'" class="kd_obat" /></td><td><input type="text" name="nama_obat_'+counter3+'" id="nama_obat_'+counter3+'" class="nama_obat input-large" /></td><td><input type="text" name="dosis_'+counter3+'" id="dosis_'+counter3+'" class="dosis input-small" /></td><td><select name="satuan_'+counter3+'" id="satuan_'+counter3+'" class="satuan uniformselect" style="width:100px;"><option name="-">Pilih Satuan</option><?php foreach($list_satuan_kecil as $lsk) : ?><option value="<?php echo $lsk['kd_sat_kecil_obat']; ?>"><?php echo $lsk['sat_kecil_obat']; ?></option><?php endforeach; ?></select></td><td><input type="text" name="jumlah_'+counter3+'" id="jumlah_'+counter3+'" class="jumlah input-large" /></td></tr>';
		
		jQuery(inputHTML).appendTo("table#tbl-obat tbody");
		counter3++;
	};
		
	var removeInput = function() {
		counter3--;
		if(counter3 == 1){
			jQuery('a#removeObat').attr('disabled','disabled');
			//alert("Minimal sisa 1!");
			counter3++;
			//console.log('Jika Counter == 1 :' + counter3);
		}else{
			jQuery("table#tbl-obat tbody tr:last").remove();
			//console.log('Jika Counter != 1 :' + counter3);
		}
	};
	
	if (!jQuery("table#tbl-obat tbody").find("input.nama_obat").length) {
		addInput();
	}
	
	var refreshFocus = function() {
		jQuery("input.nama_obat:last").focus();
		jQuery('html, body').animate({
       		scrollTop: jQuery("input.nama_obat:last").offset().top
    	}, 2000);
	};
	
	//jQuery("a#addObat").click(addInput);
	jQuery("a#addObat").click(function() {
		addInput();
		refreshFocus();
	});
	//jQuery("a#removeObat").click(removeInput);
	jQuery("a#removeObat").click(function() {
		removeInput();
		refreshFocus();
	});
});

jQuery(function() {
	var counter3 = <?php if(isset($counter3)) echo $counter3; else echo 1; ?>;
	var options = {
		source: '<?php echo base_url(); ?>cont_transaksi_pelayanan/autoCompleteObat',
		minLength: 2,
		focus: function( event, ui ) {
        			jQuery('#nama_obat2_'+counter3).val(ui.item.value);
					jQuery(this).closest('tr').find('input.kd_obat2').val(ui.item.kd_obat);
					//console.log(ui.item.kd_obat);
        },
        select: function( event, ui ) {
					//event.preventDefault();
                    jQuery('#nama_obat2_'+counter3).val(ui.item.value);
					jQuery(this).closest('tr').find('input.kd_obat2').val(ui.item.kd_obat);                      
               		//console.log(ui.item.penyakit);
                   //return false;
        },
		messages: {
		   		noResults:	''
		}
	};
		
	jQuery('input.nama_obat2').live("keydown.autocomplete", function() {
		jQuery(this).autocomplete(options);
	});
	
	var addInput = function() {
		if (counter3 > 1){
			jQuery('a#removeObat2').removeAttr('disabled');
		}
			
		var inputHTML = '<tr><td><div id="'+counter3+'">'+counter3+'</div><input type="hidden" name="kd_obat_'+counter3+'" id="kd_obat2_'+counter3+'" class="kd_obat2" /></td><td><input type="text" name="nama_obat_'+counter3+'" id="nama_obat2_'+counter3+'" class="nama_obat2 input-large" /></td><td><input type="text" name="dosis_'+counter3+'" id="dosis2_'+counter3+'" class="dosis2 input-small" /></td><td><select name="satuan_'+counter3+'" id="satuan2_'+counter3+'" class="satuan2 uniformselect" style="width:100px;"><option name="-">Pilih Satuan</option><?php foreach($list_satuan_kecil as $lsk) : ?><option value="<?php echo $lsk['kd_sat_kecil_obat']; ?>"><?php echo $lsk['sat_kecil_obat']; ?></option><?php endforeach; ?></select></td><td><input type="text" name="jumlah_'+counter3+'" id="jumlah2_'+counter3+'" class="jumlah2 input-large" /></td></tr>';
		
		jQuery(inputHTML).appendTo("table#tbl-obat2 tbody");
		counter3++;
	};
		
	var removeInput = function() {
		counter3--;
		if(counter3 == 1){
			jQuery('a#removeObat2').attr('disabled','disabled');
			//alert("Minimal sisa 1!");
			counter3++;
			//console.log('Jika Counter == 1 :' + counter3);
		}else{
			jQuery("table#tbl-obat2 tbody tr:last").remove();
			//console.log('Jika Counter != 1 :' + counter3);
		}
	};
	
	if (!jQuery("table#tbl-obat2 tbody").find("input.nama_obat2").length) {
		addInput();
	}
	
	var refreshFocus = function() {
		jQuery("input.nama_obat2:last").focus();
		jQuery('html, body').animate({
       		scrollTop: jQuery("input.nama_obat2:last").offset().top
    	}, 2000);
	};
	
	//jQuery("a#addObat").click(addInput);
	jQuery("a#addObat2").click(function() {
		addInput();
		refreshFocus();
	});
	//jQuery("a#removeObat").click(removeInput);
	jQuery("a#removeObat2").click(function() {
		removeInput();
		refreshFocus();
	});
});

/////////////////////* SCRIPT PENCARIAN NOMOR REKAM MEDIS *//////////////////////////////////	
	
	
	DataRekamMedis();
	
	
	
//////////////////////////* SCRIPT OPEN DIALOGUE *////////////////////////////
function DataRekamMedis(){
		var cari = $("#carimedis").val();
		var string = "cari="+cari;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/DataRekamMedis",
			data	: string,
			cache	: false,
			success	: function(data){
				//console.log(data);
				$("#daftarrekammedis").html(data);
			}
		});
	}
	

	$("#DataRekamMedis").dialog({
      autoOpen: false,
	  height:400,
	  width:700,
      show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "explode",
        duration: 500
      }
    });
	
	
	$("#list_medis").click(function() {
      $("#DataRekamMedis").dialog("open");
    });
	$("#tutup").click(function() {
      $("#DataRekamMedis").dialog("close");
    });
	
	$("#carimedis").keyup(function(){
		DataRekamMedis();
	});
	
	$("#cetak").click(function(){
		var kode	= $("#kodepelayanan").val();
		window.open('<?php echo site_url();?>cont_transaksi_pelayanan/cetak_resep/'+kode);
		return false();
	});
	
	
</script>
<style type="text/css">
#DataRekamMedis {
	font-size:12px;
}
</style>