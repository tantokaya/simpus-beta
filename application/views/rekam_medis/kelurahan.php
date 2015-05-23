<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Wilayah dan Puskesmas</a> <span class="divider">/</span></li>
            <li><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/propinsi">Propinsi</a> <span class="divider">/</span></li>
            <li><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kota/<?php if(isset($edit_kelurahan)) echo substr($this->uri->segment(4),0,2); else echo substr($this->uri->segment(3),0,2); ?>">Kota / Kabupaten</a> <span class="divider">/</span></li>
            <li><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kecamatan/<?php if(isset($edit_kelurahan)) echo substr($this->uri->segment(4),0,4); else echo substr($this->uri->segment(3),0,4); ?>">Kecamatan</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data kelurahan</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_kelurahan)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Kelurahan</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_kelurahan))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Kelurahan</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Kelurahan</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_kelurahan)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Kelurahan</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_kelurahan as $row): ?>
                            	<?php echo form_open('cont_master_wil_puskesmas/kelurahan/ubah/do_update/'.$row['kd_kelurahan'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Kelurahan</label>
                                            <span class="field"><input type="text" name="kd_kelurahan" id="kd_kelurahan" value="<?php echo $row['kd_kelurahan']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Kelurahan</label>
                                            <span class="field"><input type="text" name="nm_kelurahan" id="nm_kelurahan" value="<?php echo $row['nm_kelurahan']; ?>" class="input-xxlarge" /></span>
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
                        
                        <!---- DAFTAR KELURAHAN START ---->
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
                                    <th class="head0">Kode Kelurahan</th>
                                    <th class="head1">Nama Kelurahan</th>
                                    <th class="head0">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php foreach ($kelurahan as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_kelurahan']; ?></td>
                                    <td><?php echo $r['nm_kelurahan']; ?></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kelurahan/ubah/<?php echo $r['kd_kelurahan']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kelurahan/hapus/<?php echo $r['kd_kelurahan']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR KELURAHAN ---->
                        
                        <!---- TAMBAH KELURAHAN START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Kelurahan</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_wil_puskesmas/kelurahan/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                <?php if(isset($edit_kelurahan)){
									echo  '<input type="hidden" name="kd_kecamatan" value="'.substr($this->uri->segment(4),0,7).'" />';
								} else {
									echo  '<input type="hidden" name="kd_kecamatan" value="'.$this->uri->segment(3).'" />';
								}
								?>
                                        <p>
                                            <label>Kode Kelurahan</label>
                                            <span class="field"><input type="text" name="kd_kelurahan" id="kd_kelurahan" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Kelurahan</label>
                                            <span class="field"><input type="text" name="nm_kelurahan" id="nm_kelurahan" class="input-xxlarge" /></span>
                                        </p>
                                                          
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH KELURAHAN ---->
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
			kd_kelurahan: "required",
			nm_kelurahan: "required"
			
		},
		messages: {
			kd_kelurahan: "Kode kelurahan harus diisi!",
			nm_kelurahan: "Nama kelurahan harus diisi!"
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
			kd_kelurahan: "required",
			nm_kelurahan: "required"
			
		},
		messages: {
			kd_kelurahan: "Kode kelurahan harus diisi!",
			nm_kelurahan: "Nama kelurahan harus diisi!"
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