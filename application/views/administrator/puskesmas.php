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
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data puskesmas</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_puskesmas)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Puskesmas</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_puskesmas))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Puskesmas</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Puskesmas</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_puskesmas)):?>
                        <div id="ubah">
                       	<h4 class="widgettitle">Ubah Data Puskesmas</h4>
                        <div class="row-fluid">
			<div class="span6">
			<?php foreach ($edit_puskesmas as $row): ?>
                        <?php echo form_open('cont_master_wil_puskesmas/puskesmas/ubah/do_update/'.$row['kd_puskesmas'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                        <table class="table table-bordered table-invoice">
				<tr>
					<td>Kode Puskesmas</td>
					<td><input type="text" name="kd_puskesmas" id="kd_puskesmas" value="<?php echo $row['kd_puskesmas']; ?>" class="input-xxlarge" /></td>
				</tr>
				<tr>
					<td>Nama Puekesmas</td>
					<td><input type="text" name="nm_puskesmas" id="nm_puskesmas" value="<?php echo $row['nm_puskesmas']; ?>" class="input-xxlarge" /></td>
				</tr>
				<tr>
					<td>Alamat Puskesmas</td>
					<td><textarea name="alamat" id="alamat" class="input-xxlarge"><?php echo $row['alamat']; ?></textarea></td>
				</tr>
				<tr>
					<td>Jenis Puskesmas</td>
					<td>
					<select name="id_jenis_puskesmas" id="id_jenis_puskesmas" class="uniformselect" required>
                                        <option value="">Pilih Jenis Puskesmas</option>
                                                <?php foreach($list_jenis_puskesmas as $jp) : ?>
                                            	<?php
                                                	if($jp['id_jenis_puskesmas'] === $row['id_jenis_puskesmas'])
						echo '<option value="'.$jp['id_jenis_puskesmas'].'" selected="selected">'.$jp['jenis_puskesmas'].'</option>';
							else
						echo '<option value="'.$jp['id_jenis_puskesmas'].'">'.$jp['jenis_puskesmas'].'</option>';
						?>
						<?php endforeach; ?>
                                        </select>	
					</td>
				</tr>
				<tr>
					<td>Kecamatan</td>
					<td>
					<select name="kd_kecamatan" id="kd_kecamatan" class="uniformselect" required>
                                        <option value="">Pilih Kecamatan</option>
                                                <?php foreach($list_kecamatan as $lk) : ?>
                                            	<?php
                                                	if($lk['kd_kecamatan'] === $row['kd_kecamatan'])
						echo '<option value="'.$lk['kd_kecamatan'].'" selected="selected">'.$lk['nm_kecamatan'].'</option>';
							else
						echo '<option value="'.$lk['kd_kecamatan'].'">'.$lk['nm_kecamatan'].'</option>';
						?>
						<?php endforeach; ?>
                                            </select>	
					</td>
				</tr>
			</table>
			                <p class="stdformbutton">
                                            <button class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Perbaharui</button>
                                        </p>
                            	<?php echo form_close(); ?>
                            <?php endforeach; ?>
                        	</div><!--widgetcontent-->
                        </div>
                        <?php endif;?>
                        <!---- END EDITING FORM ---->
                        
                        <!---- DAFTAR PUSKESMAS START ---->
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
							<script type="text/javascript">
                                jQuery(document).ready(function () {
                                    var oTable = jQuery('#dyntable').dataTable({
                                        "bProcessing": true,
                                        "bServerSide": true,
										"bAutoWidth": false,
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/puskesmas',
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
                         <!---- END DAFTAR PUSKESMAS ---->
                        
                        <!---- TAMBAH PUSKESMAS START ---->
                        <div id="tambah">
                       	<h4 class="widgettitle">Data Puskesmas</h4>
			<div class="row-fluid">
			<div class="span6">
                        <?php echo form_open('cont_master_wil_puskesmas/puskesmas/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                        <table class="table table-bordered table-invoice">
				<tr>
					<td>Kode Puskesmas</td>
					<td><input type="text" name="kd_puskesmas" id="kd_puskesmas" class="input-medium" /></td>
				</tr>
				<tr>
					<td>Nama Puskesmas</td>
					<td><input type="text" name="nm_puskesmas" id="nm_puskesmas" class="input-medium" /></td>
				</tr>
				<tr>
					<td>Kecamatan</td>
					<td>
						<select name="kd_kecamatan" id="kd_kecamatan" data-placeholder="Pilih Kecamatan" style="width:200px" class="chzn-select" tabindex="2" required>
						<option value=""></option>
						<?php foreach($list_kecamatan as $lk) : ?>
                                            	<option value="<?php echo $lk['kd_kecamatan']; ?>"><?php echo $lk['nm_kecamatan']; ?></option>
						<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td>Alamat Puskesmas</td>
					<td><textarea name="alamat" id="alamat" class="input-xlarge" rows="3"></textarea></td>
				</tr>
				<tr>
					<td>Jenis Puskesmas</td>
					<td>
						<select name="id_jenis_puskesmas" id="id_jenis_puskesmas" data-placeholder="Pilih Jenis Puskesmas" style="width:200px" class="chzn-select" tabindex="2" required>
						<option value=""></option>
						<?php foreach($list_jenis_puskesmas as $jp) : ?>
                                            	<option value="<?php echo $jp['id_jenis_puskesmas']; ?>"><?php echo $jp['jenis_puskesmas']; ?></option>
						<?php endforeach; ?>
						</select>
					</td>
				</tr>
			</table>
			<p class="stdformbutton">
				<button class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Simpan</button>
				<button type="reset" class="btn btn-inverse"><i class="icon-refresh icon-white"></i> Reset</button>
                        </p>
			               
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH PUSKESMAS---->
                	</div><!--tabs-->
                </div><!--row-fluid-->
        </div><!--contentinner-->
    </div><!--maincontent-->
</div><!--mainright-->
</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	// With Form Validation
	jQuery("#form_edit").validate({
		rules: {
			kd_puskesmas: "required",
			nm_puskesmas: "required",
			alamat: "required",
			kd_kecamatan: "required",
			id_jenis_puskesmas: "required",
		},
		messages: {
			kd_puskesmas: "Kode puskesmas harus diisi!",
			nm_puskesmas: "Nama puskesmas harus diisi!",
			alamat: "Alamat puskesmas harus diisi!",
			kd_kecamatan: "Pilih kecamatan terlebih dahulu!",
			id_jenis_puskesmas: "Pilih jenis puskesmas terlebih dahulu!",
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
			kd_puskesmas: "required",
			nm_puskesmas: "required",
			alamat: "required",
			kd_kecamatan: "required",
			id_jenis_puskesmas: "required",
			
		},
		messages: {
			kd_puskesmas: "Kode puskesmas harus diisi!",
			nm_puskesmas: "Nama puskesmas harus diisi!",
			alamat: "Alamat puskesmas harus diisi!",
			kd_kecamatan: "Pilih kecamatan terlebih dahulu!",
			id_jenis_puskesmas: "Pilih jenis puskesmas terlebih dahulu!",
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