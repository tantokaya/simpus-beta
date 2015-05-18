<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Harga Obat</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data harga obat</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_harga_obat)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Harga Obat</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_harga_obat))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Harga Obat</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Harga Obat</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_harga_obat)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Harga Obat</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_harga_obat as $row): ?>
                            	<?php echo form_open('admin/harga_obat/ubah/do_update/'.$row['kd_tarif'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Tarif</label>
                                            <span class="field"><input type="text" name="kd_tarif" id="kd_tarif" value="<?php echo $row['kd_tarif']; ?>" class="input-medium" /></span>
                                        </p>
                                        
										<p>
                                            <label>Nama Obat</label>
                                            <span class="field">
                                            <select name="kd_obat" id="kd_obat" class="uniformselect" required>
                                                <option value="">Pilih Nama Obat</option>
                                                <?php foreach($list_obat as $lo) : ?>
                                            	<?php
                                                	if($lo['kd_obat'] === $row['kd_obat'])
														echo '<option value="'.$lo['kd_obat'].'" selected="selected">'.$lo['nama_obat'].'</option>';
													else
														echo '<option value="'.$lo['kd_obat'].'">'.$lo['nama_obat'].'</option>';
												?>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>
										
                                        <p>
                                            <label>Harga Beli</label>
                                            <span class="field"><input type="text" name="harga_beli" id="harga_beli" value="<?php echo $row['harga_beli']; ?>" class="input-medium" /></span>
                                        </p>                                        
                                                                
                                        <p>
                                            <label>Harga Jual</label>
                                            <span class="field"><input type="text" name="harga_jual" id="harga_jual" value="<?php echo $row['harga_jual']; ?>" class="input-medium" /></span>
                                        </p>       
										
										<p>
                                            <label>Kode Milik Obat</label>
                                            <span class="field">
                                            <select name="kd_sat_kecil_obat" id="kd_sat_kecil_obat" class="uniformselect" required>
                                                <option value="">Pilih Kode Milik Obat</option>
												<option value="Kode 1">Kode 1</option>
                                                <option value="Kode 2">Kode 2</option>
                                            </select>
                                            </span>
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
                        
                        <!---- DAFTAR HARGA OBAT START ---->
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
                                    <th class="head0">Kode Harga Obat</th>
                                    <th class="head1">Nama Obat</th>
                                    <th class="head1">Harga Beli</th>
                                    <th class="head1">Harga Jual</th>
                                    <th class="head1">Kode Milik Obat</th>
									<th class="head1">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php foreach ($harga_obat as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_tarif']; ?></td>
                                    <td><?php echo $r['nama_obat']; ?></td>
                                    <td><?php echo $r['harga_beli']; ?></td>
                                    <td><?php echo $r['harga_jual']; ?></td>
									<td><?php echo $r['kd_milik_obat']; ?></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>admin/harga_obat/ubah/<?php echo $r['kd_tarif']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>admin/harga_obat/hapus/<?php echo $r['kd_tarif']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR HARGA OBAT---->
                        
                        <!---- TAMBAH HARGA OBAT START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Harga Obat</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('admin/harga_obat/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Tarif</label>
                                            <span class="field"><input type="text" name="kd_tarif" id="kd_tarif" class="input-medium" /></span>
                                        </p>
										
										<p>
                                            <label>Nama Obat</label>
                                            <span class="field">
                                            <select name="kd_obat" id="kd_obat" data-placeholder="Pilih Nama Obat" style="width:350px" class="chzn-select" tabindex="2" required>
                                            <option value=""></option>
                                            <?php foreach($list_obat as $lo) : ?>
                                            	<option value="<?php echo $lo['kd_obat']; ?>"><?php echo $lo['nama_obat']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>
                                        
                                        <p>
                                            <label>Harga Beli</label>
                                            <span class="field"><input type="text" name="harga_beli" id="harga_beli" class="input-medium" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Harga Jual</label>
                                            <span class="field"><input type="text" name="harga_jual" id="harga_jual" class="input-medium" /></span>
                                       </p>
									   
                                        <p>
                                            <label>Kode Milik Obat</label>
                                            <span class="field">
                                            <select name="kd_milik_obat" id="kd_milik_obat" class="chzn-select" tabindex="2" required>
                                            <option value=""></option>
                                            <?php foreach($list_milik_obat as $mlo) : ?>
                                            	<option value="<?php echo $mlo['kd_milik_obat']; ?>"><?php echo $mlo['kepemilikan']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            </span>
                                        </p>                                           
                                                           
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH HARGA OBAT ---->
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
			kd_tarif: "required",
			kd_obat: "required",
			harga_beli: "required",
			harga_jual: "required",
			kd_milik_obat: "required",
		},
		messages: {
			kd_tarif: "Kode harga obat harus diisi!",
			kd_obat: "Kode obat harus diisi!",
			harga_beli: "Harga beli harus diisi!",
			harga_jual: "Harga jual harus diisi!",
			kd_milik_obat: "Kode milik obat harus diisi!",		
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
			kd_tarif: "required",
			kd_obat: "required",
			harga_beli: "required",
			harga_jual: "required",
			kd_milik_obat: "required",
		},
		messages: {
			kd_tarif: "Kode harga obat harus diisi!",
			kd_obat: "Kode obat harus diisi!",
			harga_beli: "Harga beli harus diisi!",
			harga_jual: "Harga jual harus diisi!",
			kd_milik_obat: "Kode milik obat harus diisi!",		
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