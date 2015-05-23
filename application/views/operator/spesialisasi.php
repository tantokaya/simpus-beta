<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Spesialisasi</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data spesialisasi</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_spesialisasi)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Spesialisasi</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_spesialisasi))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Spesialisasi</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Spesialisasi</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_spesialisasi)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle">Ubah Data Spesialisasi</h4>
                            <div class="row-fluid">
                                <div class="span6">
                                <?php foreach ($edit_spesialisasi as $row): ?>
                                    <?php echo form_open('cont_master_petugas/spesialisasi/ubah/do_update/'.$row['kd_spesialisasi'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                    <table class="table table-bordered table-invoice">
                                       <tr>
                                           <td>Kode Spesialisasi</td>
                                           <td><input type="text" name="kd_spesialisasi" id="kd_spesialisasi" value="<?php echo $row['kd_spesialisasi']; ?>" class="input-small" /></td>
                                       </tr>
                                       <tr>
                                           <td>Spesialisasi</td>
                                           <td><input type="text" name="kd_spesialisasi" id="kd_spesialisasi" value="<?php echo $row['kd_spesialisasi']; ?>" class="input-medium" /></td>
                                       </tr>
                                    </table>
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Perbaharui</button>
                                    </p>
                                    <?php echo form_close(); ?>
                                <?php endforeach; ?>
                                </div>
                        	</div><!--widgetcontent-->
                        </div>
                        <?php endif;?>
                        <!---- END EDITING FORM ---->
                        
                        <!---- DAFTAR SPESIALISASI START ---->
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
                                    <th class="head0">Kode spesialisasi</th>
                                    <th class="head1">Spesialisasi</th>
                                    <th class="head0">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php foreach ($spesialisasi as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_spesialisasi']; ?></td>
                                    <td><?php echo $r['spesialisasi']; ?></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>cont_master_petugas/spesialisasi/ubah/<?php echo $r['kd_spesialisasi']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>cont_master_petugas/spesialisasi/hapus/<?php echo $r['kd_spesialisasi']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR SPESIALISASI---->
                        
                        <!---- TAMBAH SPESIALISASI START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle">Data Spesialisasi</h4>
                            <div class="row-fluid">
                                <div class="span6">
                                <?php echo form_open('cont_master_petugas/spesialisasi/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                    <table class="table table-bordered table-invoice">
                                        <tr>
                                            <td>Kode Spesialisasi</td>
                                            <td><input type="text" name="kd_spesialisasi" id="kd_spesialisasi" class="input-small" /></td>
                                        </tr>
                                        <tr>
                                            <td>Spesialisasi</td>
                                            <td><input type="text" name="spesialisasi" id="spesialisasi" class="input-medium" /></td>
                                        </tr>
                                    </table>
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Simpan</button>
                                        <button type="reset" class="btn btn-success btn-circle"><i class="icon-refresh icon-white"></i> B a t a l</button>
                                    </p>
                               	<?php echo form_close();  ?>
                                </div>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH SPESIALISASI---->
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
			kd_spesialisasi: "required",
			spesialisasi: "required",
			
		},
		messages: {
			kd_spesialisasi: "Kode spesialisasi harus diisi dan unik!",
			spesialisasi: "Nama spesialisasi harus diisi!",
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
			kd_spesialisasi: "required",
			spesialisasi: "required",
			
		},
		messages: {
			kd_spesialisasi: "Kode spesialisasi harus diisi dan unik!",
			spesialisasi: "Nama spesialisasi harus diisi!",
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