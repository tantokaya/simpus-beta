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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data kamar</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_kamar)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data kamar</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_kamar))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar kamar</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah kamar</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_kamar)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data kamar</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_kamar as $row): ?>
                            	<?php echo form_open('cont_master_pelayanan/kamar/ubah/do_update/'.$row['kd_kamar'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Kamar</label>
                                            <span class="field"><input type="text" name="kd_kamar" id="kd_kamar" value="<?php echo $row['kd_kamar']; ?>" class="input-small" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>No Kamar</label>
                                            <span class="field"><input type="text" name="no_kamar" id="no_kamar" value="<?php echo $row['no_kamar']; ?>" class="input-small" /></span>
                                        </p>
										
										<p>
                                            <label>Nama Ruangan</label>
                                            <span class="field">
											<select name="kd_ruangan" id="kd_ruangan" class="uniformselect">
                                                <option value="">Pilih Ruangan</option>
                                                <?php foreach($list_ruang as $lr) : ?>
                                            	<?php
                                                	if($lr['kd_ruangan'] == $row['kd_ruangan'])
														echo '<option value="'.$lr['kd_ruangan'].'" selected="selected">'.$lr['nm_ruangan'].'</option>';
													else
														echo '<option value="'.$lr['kd_ruangan'].'">'.$lr['nm_ruangan'].'</option>';
												?>
												<?php endforeach; ?>
											</select>
											</span>
                                        </p>
										
										<p class="stdformbutton">
                                            <button class="btn btn-primary">Perbaharui</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                            	<?php echo form_close(); ?>
                            <?php endforeach; ?>
                        	</div><!--widgetcontent-->
                        </div>
                        <?php endif;?>
                        <!---- END EDITING FORM ---->
                        
                        <!---- DAFTAR PROPINSI START ---->
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
							<script type="text/javascript">
                                jQuery(document).ready(function () {
                                    var oTable = jQuery('#dyntable').dataTable({
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/kamar',
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
                         <!---- END DAFTAR PROPINSI ---->
                        
                        <!---- TAMBAH PROPINSI START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Jenis kamar</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_pelayanan/kamar/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                       <p>
                                            <label>Kode Kamar</label>
                                            <span class="field"><input type="text" name="kd_kamar" id="kd_kamar" class="input-small" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>No Kamar</label>
                                            <span class="field"><input type="text" name="no_kamar" id="no_kamar"  class="input-small" /></span>
                                        </p>
										
										<p>
                                            <label>Nama Ruangan</label>
                                            <span class="field">
											<select name="kd_ruangan" id="kd_ruangan" class="uniformselect" required>
                                                <option value="">Pilih Ruangan</option>
													<?php foreach($list_ruang as $lr) : ?>
														<option value="<?php echo $lr['kd_ruangan']; ?>"><?php echo $lr['nm_ruangan']; ?></option>
													<?php endforeach; ?>
											</select>
											</span>
                                        </p>
																					
										<p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH PROPINSI ---->
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
			kd_unit: "required",
			no_kamar: "required",
			nm_kamar: "required",
			jumlah_bed: "required",
			digunakan: "required"
		},
		messages: {
			kd_unit: "Kode Unit harus diisi!",
			no_kamar: "Nomor kamar harus diisi!",
			nm_kamar: "Nama Kamar harus diisi!",
			jumlah_bed: "Jumlah Bed harus diisi!",
			digunakan: "Digunakan(kali) harus diisi!"
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
			kd_unit: "required",
			no_kamar: "required",
			nm_kamar: "required",
			jumlah_bed: "required",
			digunakan: "required"
		},
		messages: {
			kd_unit: "Kode Unit harus diisi!",
			no_kamar: "Nomor kamar harus diisi!",
			nm_kamar: "Nama Kamar harus diisi!",
			jumlah_bed: "Jumlah Bed harus diisi!",
			digunakan: "Digunakan(kali) harus diisi!"
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
});

</script>