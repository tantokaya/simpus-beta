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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data cara masuk pasien</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_cara_masuk)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Cara Masuk Pasien</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_cara_masuk))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Cara Masuk Pasien</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Cara Masuk Pasien</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_cara_masuk)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Cara Masuk Pasien</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_cara_masuk as $row): ?>
                            	<?php echo form_open('cont_master_pasien/cara_masuk/ubah/do_update/'.$row['kd_cara_masuk'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Bayar</label>
                                            <span class="field"><input type="text" name="kd_cara_masuk" id="kd_cara_masuk" value="<?php echo $row['kd_cara_masuk']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Cara Masuk Pasien</label>
                                            <span class="field"><input type="text" name="cara_masuk" id="cara_masuk" value="<?php echo $row['cara_masuk']; ?>" class="input-xxlarge" /></span>
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
                        
                        <!---- DAFTAR CARA MASUK PASIEN START ---->
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
                                    <th class="head0">Kode Cara Masuk</th>
                                    <th class="head1">Cara Masuk Pasien</th>
                                    <th class="head0">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php foreach ($cara_masuk as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_cara_masuk']; ?></td>
                                    <td><?php echo $r['cara_masuk']; ?></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>admin/cara_masuk/ubah/<?php echo $r['kd_cara_masuk']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>admin/cara_masuk/hapus/<?php echo $r['kd_cara_masuk']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR CARA MASUK PASIEN ---->
                        
                        <!---- TAMBAH CARA MASUK PASIEN START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Cara Masuk Pasien</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('admin/cara_masuk/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Bayar</label>
                                            <span class="field"><input type="text" name="kd_cara_masuk" id="kd_cara_masuk" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Cara Masuk Pasien</label>
                                            <span class="field"><input type="text" name="cara_masuk" id="cara_masuk" class="input-xxlarge" /></span>
                                        </p>
                                                           
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH CARA MASUK PASIEN ---->
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
			kd_cara_masuk: "required",
			cara_masuk: "required"
		},
		messages: {
			kd_cara_masuk: "Kode cara masuk pasien harus diisi!",
			cara_masuk: "Cara masuk pasien harus diisi!"
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
			kd_cara_masuk: "required",
			cara_masuk: "required"
		},
		messages: {
			kd_cara_masuk: "Kode cara masuk pasien harus diisi!",
			cara_masuk: "Cara masuk pasien harus diisi!"
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