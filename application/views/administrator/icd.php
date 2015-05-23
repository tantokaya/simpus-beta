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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data ICD</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_icd)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data ICD</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_icd))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar ICD</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah ICD</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_icd)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data ICD</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_icd as $row): ?>
                            	<?php echo form_open('cont_master_pelayanan/icd/ubah/do_update/'.$row['kd_penyakit'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Penyakit</label>
                                            <span class="field"><input type="text" name="kd_penyakit" id="kd_penyakit" value="<?php echo $row['kd_penyakit']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        <p>
                                            <label>Nama ICD Induk</label>
                                            <span class="field">
											<select name="kd_icd_induk" id="kd_icd_induk" class="chzn-select" required>
                                                <option value="">Pilih Nama Induk</option>
                                                <?php foreach($list_icd_induk as $lk) : ?>
                                            	<?php
                                                	if($lk['kd_icd_induk'] === $row['kd_icd_induk'])
														echo '<option value="'.$lk['kd_icd_induk'].'" selected="selected">'.$lk['nm_icd_induk'].'</option>';
													else
														echo '<option value="'.$lk['kd_icd_induk'].'">'.$lk['nm_icd_induk'].'</option>';
												?>
											<?php endforeach; ?>
											</select>
											</span>
                                        </p>
                                        <p>
                                            <label>Penyakit</label>
                                            <span class="field"><input type="text" name="penyakit" id="penyakit" value="<?php echo $row['penyakit']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        <p>
                                            <label>Deskripsi</label>
                                            <span class="field"><input type="text" name="deskripsi" id="deskripsi" value="<?php echo $row['deskripsi']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
										<!--
                                        <p>
                                            <label>Includes</label>
                                            <span class="field"><input type="text" name="includes" id="includes" value="<?php echo $row['includes'];?>" class="input-xxlarge" /></span>
                                        </p>
										<p>
                                            <label>Excludes</label>
                                            <span class="field"><input type="text" name="excludes" id="excludes" value="<?php echo $row['excludes'];?>" class="input-xxlarge" /></span>
                                        </p>
										<p>
                                            <label>Notes</label>
                                            <span class="field"><input type="text" name="notes" id="notes" value="<?php echo $row['notes'];?>" class="input-xxlarge" /></span>
                                        </p>
										<p>
                                            <label>Status APP</label>
                                            <span class="field"><input type="text" name="statusapp" id="statusapp" value="<?php echo $row['statusapp'];?>" class="input-xxlarge" /></span>
                                        </p>
                                        -->
                                                           
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
										"bAutoWidth": false,
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/icd',
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
                         <!---- END DAFTAR ICD ---->
                        
                        <!---- TAMBAH ICD START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data ICD</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_pelayanan/icd/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Penyakit</label>
                                            <span class="field"><input type="text" name="kd_penyakit" id="kd_penyakit" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama ICD Induk</label>
                                            <span class="field">
												<select name="kd_icd_induk" id="kd_icd_induk" data-placeholder="Pilih Nama ICD" style="width:350px" class="chzn-select" tabindex="2" required>
												<option value=""></option>
													<?php foreach($list_icd_induk as $lk) : ?>
														<option value="<?php echo $lk['kd_icd_induk']; ?>"><?php echo $lk['nm_icd_induk']; ?></option>
													<?php endforeach; ?>
                                            </select>
											</span>
                                        </p>
										
										<p>
                                            <label>Penyakit</label>
                                            <span class="field"><input type="text" name="penyakit" id="penyakit" class="input-xxlarge" /></span>
                                        </p>
                                        <!--
										<p>
                                            <label>Includes</label>
                                            <span class="field"><input type="text" name="includes" id="includes" class="input-xxlarge" /></span>
                                        </p>
										<p>
                                            <label>Excludes</label>
                                            <span class="field"><input type="text" name="excludes" id="excludes" class="input-xxlarge" /></span>
                                        </p>
										<p>
                                            <label>Notes</label>
                                            <span class="field"><input type="text" name="notes" id="notes" class="input-xxlarge" /></span>
                                        </p>
										<p>
                                            <label>Status APP</label>
                                            <span class="field"><input type="text" name="statusapp" id="statusapp" class="input-xxlarge" /></span>
                                        </p>
                                        -->
										<p>
                                            <label>Deskripsi</label>
                                            <span class="field"><input type="text" name="deskripsi" id="deskripsi" class="input-xxlarge" /></span>
                                        </p>
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH ICD ---->
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
			kd_penyakit: "required",
			kd_icd_induk: "required",
			penyakit: "required"
			
		},
		messages: {
			kd_penyakit: "Kode penyakit harus diisi!",
			kd_icd_induk: "kode ICD induk harus diisi!",
			penyakit: "Penyakit harus diisi!"
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
			kd_penyakit: "required",
			kd_icd_induk: "required",
			penyakit: "required"
			
		},
		messages: {
			kd_penyakit: "Kode penyakit harus diisi!",
			kd_icd_induk: "kode ICD induk harus diisi!",
			penyakit: "Penyakit harus diisi!"
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