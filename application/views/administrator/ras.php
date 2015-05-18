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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data ras / suku</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_ras)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Ras / Suku</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_ras))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Ras / Suku</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Ras / Suku</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_ras)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Ras / Suku</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_ras as $row): ?>
                            	<?php echo form_open('admin/ras/ubah/do_update/'.$row['kd_ras'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Ras</label>
                                            <span class="field"><input type="text" name="kd_ras" id="kd_ras" value="<?php echo $row['kd_ras']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Ras / Suku</label>
                                            <span class="field"><input type="text" name="ras" id="ras" value="<?php echo $row['ras']; ?>" class="input-xxlarge" /></span>
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
                        
                        <!---- DAFTAR RAS START ---->
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
                                    <th class="head0">Kode Ras</th>
                                    <th class="head1">Nama Ras / Suku</th>
                                    <th class="head0">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php foreach ($ras as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_ras']; ?></td>
                                   	 <td><?php echo $r['ras']; ?></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>admin/ras/ubah/<?php echo $r['kd_ras']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>admin/ras/hapus/<?php echo $r['kd_ras']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR RAS ---->
                        
                        <!---- TAMBAH RAS START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Ras / Suku</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('admin/ras/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Ras</label>
                                            <span class="field"><input type="text" name="kd_ras" id="kd_ras" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Ras</label>
                                            <span class="field"><input type="text" name="ras" id="ras" class="input-xxlarge" /></span>
                                        </p>
                                                           
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH RAS ---->
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
			kd_ras: "required",
			ras: "required"
			
		},
		messages: {
			kd_ras: "Kode ras / suku harus diisi!",
			ras: "Nama ras / suku harus diisi!"
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
			kd_ras: "required",
			ras: "required"
			
		},
		messages: {
			kd_ras: "Kode ras / suku harus diisi!",
			ras: "Nama ras / suku harus diisi!"
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