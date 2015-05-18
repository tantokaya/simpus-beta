<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Kebutuhan Pasien</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data status marital</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_status_marital)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Status Marital</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_status_marital))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Status Marital</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Status Marital</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_status_marital)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Status Marital</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_status_marital as $row): ?>
                            	<?php echo form_open('cont_master_pasien/status_marital/ubah/do_update/'.$row['kd_status_marital'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Status Marital</label>
                                            <span class="field"><input type="text" name="kd_status_marital" id="kd_status_marital" value="<?php echo $row['kd_status_marital']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Status Marital</label>
                                            <span class="field"><input type="text" name="status_marital" id="status_marital" value="<?php echo $row['status_marital']; ?>" class="input-xxlarge" /></span>
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
                        
                        <!---- DAFTAR STATUS MARITAL START ---->
   						<div id="list">
                        	<table class="table table-bordered" id="dyntable">
                    		<colgroup>
                        		<col class="con0" style="align: center; width: 4%" />
                        		<col class="con1" />
                        		<col class="con0" />
                        		<col class="con1" />
                    		</colgroup>
                    		<thead>
                                <tr>
                                    <th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                                    <th class="head0">Kode Status Marital</th>
                                    <th class="head1">Status Marital</th>
                                    <th class="head0">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php foreach ($status_marital as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_status_marital']; ?></td>
                                    <td><?php echo $r['status_marital']; ?></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>cont_master_pasien/status_marital/ubah/<?php echo $r['kd_status_marital']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>cont_master_pasien/status_marital/hapus/<?php echo $r['kd_status_marital']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR STATUS MARITAL ---->
                        
                        <!---- TAMBAH STATUS MARITAL START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Status Marital</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_pasien/status_marital/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Status Marital</label>
                                            <span class="field"><input type="text" name="kd_status_marital" id="kd_status_marital" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Status Marital</label>
                                            <span class="field"><input type="text" name="status_marital" id="status_marital" class="input-xxlarge" /></span>
                                        </p>
                                                           
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH STATUS MARITAL ---->
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
			kd_status_marital: "required",
			status_marital: "required"
			
		},
		messages: {
			kd_status_marital: "Kode status marital harus diisi!",
			status_marital: "Status marital harus diisi!"
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
			kd_status_marital: "required",
			status_marital: "required"
			
		},
		messages: {
			kd_status_marital: "Kode status marital harus diisi!",
			status_marital: "Status marital harus diisi!"
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