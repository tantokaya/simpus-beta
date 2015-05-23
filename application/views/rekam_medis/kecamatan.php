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
            <li><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kota/<?php if(isset($edit_kecamatan)) echo substr($this->uri->segment(4),0,2); else echo substr($this->uri->segment(3),0,2); ?>">Kota / Kabupaten</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data kecamatan</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_kecamatan)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Kecamatan</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_kecamatan))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Kecamatan</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Kecamatan</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_kecamatan)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Kecamatan</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_kecamatan as $row): ?>
                            	<?php echo form_open('cont_master_wil_puskesmas/kecamatan/ubah/do_update/'.$row['kd_kecamatan'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Kecamatan</label>
                                            <span class="field"><input type="text" name="kd_kecamatan" id="kd_kecamatan" value="<?php echo $row['kd_kecamatan']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Kecamatan</label>
                                            <span class="field"><input type="text" name="nm_kecamatan" id="nm_kecamatan" value="<?php echo $row['nm_kecamatan']; ?>" class="input-xxlarge" /></span>
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
                        
                        <!---- DAFTAR KECAMATAN START ---->
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
                                    <th class="head0">Kode Kecamatan</th>
                                    <th class="head1">Nama Kecamatan</th>
                                    <th class="head0">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php foreach ($kecamatan as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_kecamatan']; ?></td>
                                    <td><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kelurahan/<?php echo $r['kd_kecamatan']; ?>"><?php echo $r['nm_kecamatan']; ?></a></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kecamatan/ubah/<?php echo $r['kd_kecamatan']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kecamatan/hapus/<?php echo $r['kd_kecamatan']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR KECAMATAN ---->
                        
                        <!---- TAMBAH KECAMATAN START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Kecamatan</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_wil_puskesmas/kecamatan/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                <?php if(isset($edit_kecamatan)){
									echo  '<input type="hidden" name="kd_kota" value="'.substr($this->uri->segment(4),0,4).'" />';
								} else {
									echo  '<input type="hidden" name="kd_kota" value="'.$this->uri->segment(3).'" />';
								}
								?>
                                        <p>
                                            <label>Kode Kecamatan</label>
                                            <span class="field"><input type="text" name="kd_kecamatan" id="kd_kecamatan" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Kecamatan</label>
                                            <span class="field"><input type="text" name="nm_kecamatan" id="nm_kecamatan" class="input-xxlarge" /></span>
                                        </p>
                                                          
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH KECAMATAN ---->
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
			kd_kecamatan: "required",
			nm_kecamatan: "required"
			
		},
		messages: {
			kd_kecamatan: "Kode kecamatan harus diisi!",
			nm_kecamatan: "Nama kecamatan harus diisi!"
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
			kd_kecamatan: "required",
			nm_kecamatan: "required"
			
		},
		messages: {
			kd_kecamatan: "Kode kecamatan harus diisi!",
			nm_kecamatan: "Nama kecamatan harus diisi!"
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