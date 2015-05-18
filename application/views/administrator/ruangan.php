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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data ruangan</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_ruangan)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data ruangan</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_ruangan))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar ruangan</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah ruangan</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_ruangan)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data ruangan</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_ruangan as $row): ?>
                            	<?php echo form_open('cont_master_pelayanan/ruangan/ubah/do_update/'.$row['kd_ruangan'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Ruangan</label>
                                            <span class="field"><input type="text" name="kd_ruangan" id="kd_ruangan" value="<?php echo $row['kd_ruangan']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Puskesmas</label>
                                            <span class="field">
											<select name="kd_puskesmas" id="kd_puskesmas" class="chzn-select" required>
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
                                        </p>
										
										<p>
                                            <label>Nama Ruangan</label>
                                            <span class="field"><input type="text" name="nm_ruangan" id="nm_ruangan" value="<?php echo $row['nm_ruangan']; ?>" class="input-xxlarge" /></span>
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
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/ruangan',
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
                       		<h4 class="widgettitle nomargin shadowed">Data Jenis ruangan</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_pelayanan/ruangan/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Ruangan</label>
                                            <span class="field"><input type="text" name="kd_ruangan" id="kd_ruangan" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Puskesmas</label>
                                            <span class="field">
												<select name="kd_puskesmas" id="kd_puskesmas" data-placeholder="Pilih Nama Puskesmas" style="width:350px" class="chzn-select" tabindex="2" required>
												<option value=""></option>
													<?php foreach($list_puskesmas as $lk) : ?>
														<option value="<?php echo $lk['kd_puskesmas']; ?>"><?php echo $lk['nm_puskesmas']; ?></option>
													<?php endforeach; ?>
                                            </select>
											</span>
                                        </p>
										
										<p>
                                            <label>Nama Ruangan</label>
                                            <span class="field"><input type="text" name="nm_ruangan" id="nm_ruangan" class="input-xxlarge" /></span>
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
			kd_ruangan: "required",
			kd_puskesmas: "required",
			nm_ruangan: "required"
		},
		messages: {
			kd_ruangan: "Kode ruangan harus diisi!",
			kd_puskesmas: "Kode puskesmas harus diisi!",
			nm_ruangan: "Nama ruangan harus diisi!"
			
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
			kd_ruangan: "required",
			kd_puskesmas: "required",
			nm_ruangan: "required"
		},
		messages: {
			kd_ruangan: "Kode ruangan harus diisi!",
			kd_puskesmas: "Kode puskesmas harus diisi!",
			nm_ruangan: "Nama ruangan harus diisi!"
			
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