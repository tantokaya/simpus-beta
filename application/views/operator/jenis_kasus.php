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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data Jenis Kasus</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_jenis_kasus)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Jenis Kasus</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_jenis_kasus))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Jenis Kasus</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Jenis Kasus</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_jenis_kasus)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Jenis Kasus</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_jenis_kasus as $row): ?>
                            	<?php echo form_open('cont_master_pelayanan/jenis_kasus/ubah/do_update/'.$row['kd_jenis_kasus'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Jenis Kasus</label>
                                            <span class="field"><input type="text" name="kd_jenis_kasus" id="kd_jenis_kasus" value="<?php echo $row['kd_jenis_kasus']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Jenis Kasus</label>
                                            <span class="field">
											<input type="text" name="jns_kasus" id="jns_kasus" value="<?php echo $row['jns_kasus']; ?>" class="input-xxlarge" /></span>
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
                                            <label>Kode Jenis</label>
                                            <span class="field"><input type="text" name="kd_jenis" id="kd_jenis" value="<?php echo $row['kd_jenis']; ?>" class="input-xxlarge" /></span>
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
                        	<table class="table table-bordered" id="dyntable">
                    		<colgroup>
                        		<col class="con0" style="align: center; width: 4%" />
                        		<col class="con1" />
                        		<col class="con0" />
                        		<col class="con1" />
								<col class="con0" />
								<col class="con1" />
                    		</colgroup>
                    		<thead>
                                <tr>
                                    <th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                                    <th class="head0">Kode Jenis Kasus</th>
                                    <th class="head1">Jenis Kasus</th>
                                    <th class="head0">Kode ICD Induk</th>
					 <th class="head0">Kode Jenis</th>
					 <th class="head0">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php foreach ($jenis_kasus as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_jenis_kasus']; ?></td>
                                    <td><?php echo $r['jns_kasus']; ?></td>
									<td><?php echo $r['kd_icd_induk']; ?></td>
                                    <td><?php echo $r['kd_jenis']; ?></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>cont_master_pelayanan/jenis_kasus/ubah/<?php echo $r['kd_jenis_kasus']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>cont_master_pelayanan/jenis_kasus/hapus/<?php echo $r['kd_jenis_kasus']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR PROPINSI ---->
                        
                        <!---- TAMBAH PROPINSI START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Jenis Kasus</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_pelayanan/jenis_kasus/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Jenis Kasus</label>
                                            <span class="field"><input type="text" name="kd_jenis_kasus" id="kd_jenis_kasus" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Jenis Kasus</label>
                                            <span class="field">
											<input type="text" name="jns_kasus" id="jns_kasus" class="input-xxlarge" /></span>
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
                                            <label>Kode Jenis</label>
                                            <span class="field"><input type="text" name="kd_jenis" id="kd_jenis" class="input-xxlarge" /></span>
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
			kd_jenis_kasus: "required",
			jns_kasus: "required",
			kd_icd_induk: "required",
			kd_jenis: "required"
			
		},
		messages: {
			kd_jenis_kasus: "Kode Jenis Kasus harus diisi!",
			jns_kasus: "Jenis Kasus harus diisi!",
			kd_icd_induk: "Nama ICD Induk harus diisi!",
			kd_jenis: "Kode Jenis harus diisi!"
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
			kd_jenis_kasus: "required",
			jns_kasus: "required",
			kd_icd_induk: "required",
			kd_jenis: "required"
			
		},
		messages: {
			kd_jenis_kasus: "Kode Jenis Kasus harus diisi!",
			jns_kasus: "Jenis Kasus harus diisi!",
			kd_icd_induk: "Nama ICD Induk harus diisi!",
			kd_jenis: "Kode Jenis harus diisi!"
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