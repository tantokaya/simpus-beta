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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data dokter</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_dokter)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data dokter</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_dokter))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar dokter</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah dokter</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_dokter)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data dokter</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_dokter as $row): ?>
                            	<?php echo form_open('cont_master_pelayanan/dokter/ubah/do_update/'.$row['kd_dokter'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                 <!--        <p>
                                           <label>Kode Dokter *</label>
                                            <span class="field"><input type="text" name="kd_dokter" id="kd_dokter" value="<?php echo $row['kd_dokter']; ?>" class="input-xxlarge" /></span>
                                        </p>	-->
                                        
                                        <p>
                                            <label>Nama Lengkap *</label>
                                            <span class="field"><input type="text" name="nm_dokter" id="nm_dokter" value="<?php echo $row['nm_dokter']; ?>" class="input-xxlarge" /></span>
                                        </p>
										
										<p>
                                            <label>NIP</label>
                                            <span class="field"><input type="text" name="nip_dokter" id="nip_dokter" value="<?php echo $row['nip_dokter']; ?>" class="input-xxlarge" /></span>
                                        </p>
										<p><label>Pendidikan Kesehatan</label>
                                            <span class="field">
                                            <select name="kd_pendidikan" id="kd_pendidikan" class="uniformselect" >
                                                <option value="">Pilih Pendidikan Kesehatan</option>
                                                <?php foreach($list_pendidikan_kesehatan as $pk) : ?>
                                            	<?php
                                                	if($pk['kd_pendidikan'] === $row['kd_pendidikan'])
														echo '<option value="'.$pk['kd_pendidikan'].'" selected="selected">'.$pk['pendidikan'].'</option>';
													else
														echo '<option value="'.$pk['kd_pendidikan'].'">'.$pk['pendidikan'].'</option>';
												?>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>
										 <p>
                                            <label>Spesialisasi</label>
                                            <span class="field">
                                            <select name="kd_spesialisasi" id="kd_spesialisasi" class="uniformselect">
                                                <option value="">Pilih Spesialisasi</option>
                                                <?php foreach($list_spesialisasi as $sp) : ?>
                                            	<?php
                                                	if($sp['kd_spesialisasi'] === $row['kd_spesialisasi'])
														echo '<option value="'.$sp['kd_spesialisasi'].'" selected="selected">'.$sp['spesialisasi'].'</option>';
													else
														echo '<option value="'.$sp['kd_spesialisasi'].'">'.$sp['spesialisasi'].'</option>';
												?>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>
                                       
										<p>
                                            <label>Jabatan</label>
                                            <span class="field"><input type="text" name="jabatan_dokter" id="jabatan_dokter" value="<?php echo $row['jabatan_dokter']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                               
										<p>
                                            <label>Status</label>
                                            <span class="field"><input type="text" name="status_dokter" id="status_dokter" value="<?php echo $row['status_dokter']; ?>" class="input-xxlarge" /></span>
                                        </p>	
											<p>
                                            <label>Bertugas di Unit Pelayanan *</label>
                                            <span class="field">
                                            <select name="kd_unit_pelayanan" id="kd_unit_pelayanan" class="uniform-select">
                                                <option value="">Pilih Unit Pelayanan</option>
                                                <?php foreach($list_unit_pelayanan as $up) : ?>
                                            	<?php
                                                	if($up['kd_unit_pelayanan'] === $row['kd_unit_pelayanan'])
														echo '<option value="'.$up['kd_unit_pelayanan'].'" selected="selected">'.$up['nm_unit'].'</option>';
													else
														echo '<option value="'.$up['kd_unit_pelayanan'].'">'.$up['nm_unit'].'</option>';
												?>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>										

							<!--			<p>
                                            <label>Nama Puskesmas</label>
                                            <span class="field">
											<select name="kd_puskesmas" id="kd_puskesmas" class="uniform-select" required>
                                                <option value="">Pilih Nama Puskesmas</option>
                                                <?php foreach($list_puskesmas as $lk) : ?>
                                            	<?php
                                                	if($lk['kd_puskesmas'] === $row['kd_puskesmas'])
														echo '<option value="'.$lk['kd_puskesmas'].'" selected="selected">'.$lk['nm_puskesmas'].'</option>';
													else
														echo '<option value="'.$lk['kd_puskesmas'].'">'.$lk['nm_puskesmas'].'</option>';
												?>
											<?php endforeach; ?>
											</select>
											</span>
                                        </p>	-->
								<p> <label> * Field harus diisi </label> </p>
									
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
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/dokter',
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
                       		<h4 class="widgettitle nomargin shadowed">Data Jenis dokter</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_pelayanan/dokter/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                              <!--           <p>
                                          <label>Kode Dokter *</label>
                                            <span class="field"><input type="text" name="kd_dokter" id="kd_dokter" class="input-xxlarge" /></span>
                                        </p>	-->
                                        
                                        <p>
                                            <label>NamaLengkap * </label>
                                            <span class="field"><input type="text" name="nm_dokter" id="nm_dokter" class="input-xxlarge" /></span>
                                        </p>
										
										<p>
                                            <label>NIP</label>
                                            <span class="field"><input type="text" name="nip_dokter" id="nip_dokter" class="input-xxlarge" /></span>
                                        </p>
										<p>
                                            <label>Pendidikan Kesehatan</label>
                                            <span class="field">
                                            <select name="kd_pendidikan" id="kd_pendidikan" data-placeholder="Pilih Pendidikan Kesehatan" style="width:350px" class="uniform-select" tabindex="2" >
                                            <option value=""></option>
                                            <?php foreach($list_pendidikan_kesehatan as $pk) : ?>
                                            	<option value="<?php echo $pk['kd_pendidikan']; ?>"><?php echo $pk['pendidikan']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>
										<p>
                                            <label>Spesialisasi</label>
                                            <span class="field">
                                            <select name="kd_spesialisasi" id="kd_spesialisasi" data-placeholder="Pilih Spesialisasi" style="width:350px" class="uniform-select" tabindex="2" >
                                            <option value=""></option>
                                            <?php foreach($list_spesialisasi as $sp) : ?>
                                            	<option value="<?php echo $sp['kd_spesialisasi']; ?>"><?php echo $sp['spesialisasi']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>
										<p>
                                            <label>Jabatan</label>
									    <span class="field"><input type="text" name="jabatan_dokter" id="jabatan_dokter" class="input-xxlarge" /></span> 
									<!--		<span class="field">
                                            <select name="jabatan_dokter" id="jabatan_dokter" data-placeholder="Pilih Posisi" style="width:350px" class="uniform-select" tabindex="2" >
                                            <option value=""></option>
                                            <?php foreach($list_posisi as $ps) : ?>
                                            	<option value="<?php echo $ps['kd_posisi']; ?>"><?php echo $ps['posisi']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            </span>	-->
                                        </p>
                                               
										<p>
                                            <label>Status</label>
                                            <span class="field"><input type="text" name="status_dokter" id="status_dokter" class="input-xxlarge" /></span>
                                        </p>		
										<p>
                                            <label>Bertugas di Unit Pelayanan *</label>
                                            <span class="field">
                                            <select name="kd_unit_pelayanan" id="kd_unit_pelayanan" data-placeholder="Pilih Unit Pelayanan" style="width:350px" class="uniform-select" tabindex="2" >
                                            <option value="">Pilih Unit Pelayanan</option>
                                            <?php foreach($list_unit_pelayanan as $up) : ?>
                                            	<option value="<?php echo $up['kd_unit_pelayanan']; ?>"><?php echo $up['nm_unit']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>
					<!--					<p>
                                            <label>Nama Puskesmas</label>
                                            <span class="field">
												<select name="kd_puskesmas" id="kd_puskesmas" data-placeholder="Pilih Nama Puskesmas" style="width:350px" class="uniform-select" tabindex="2" required >
												<option value=""></option>
													<?php foreach($list_puskesmas as $lk) : ?>
														<option value="<?php echo $lk['kd_puskesmas']; ?>"><?php echo $lk['nm_puskesmas']; ?></option>
													<?php endforeach; ?>
                                            </select>
											</span>
                                        </p>		-->
										<p> <label> * Field harus diisi </label> </p>
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
			kd_dokter: "required",
			nm_dokter: "required",
			//nip_dokter: "required",
			//jabatan_dokter: "required",
			//status_dokter: "required",
			//kd_puskesmas: "required"
		},
		messages: {
			kd_dokter: "Kode dokter harus diisi!",
			nm_dokter: "Nama harus diisi!",
			//nip_dokter: "NIP harus diisi!",
			//jabatan_dokter: "Jabatan harus diisi!",
			//status_dokter: "Status harus diisi!",
			//kd_puskesmas: "Kode Puskesmas harus diisi!"
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
			kd_dokter: "required",
			nm_dokter: "required",
			//nip_dokter: "required",
			//jabatan_dokter: "required",
			//status_dokter: "required",
			
		},
		messages: {
			kd_dokter: "Kode dokter harus diisi!",
			nm_dokter: "Nama harus diisi!",
			//nip_dokter: "NIP harus diisi!",
			//jabatan_dokter: "Jabatan harus diisi!",
			//status_dokter: "Status harus diisi!",
			
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