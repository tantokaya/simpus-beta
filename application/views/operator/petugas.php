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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data petugas</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_petugas)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Petugas</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_petugas))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Petugas</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Data Petugas</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_petugas)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle">Ubah Data Petugas</h4>
                            <div class="row-fluid">
                                <div class="span12">
                                <?php foreach ($edit_petugas as $row): ?>
                            	<?php echo form_open('cont_master_pelayanan/petugas/ubah/do_update/'.$row['kd_petugas'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                    <table class="table table-bordered table-invoice">
                                        <tr>
                                            <td>Kode Petugas *</td>
                                            <td><input type="text" name="kd_petugas" id="kd_petugas" value="<?php echo $row['kd_petugas']; ?>" class="input-small" /></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Petugas *</td>
                                            <td><input type="text" name="nama_petugas" id="nama_petugas" value="<?php echo $row['nama_petugas']; ?>" class="input-large" /></td>
                                        </tr>
                                        <tr>
                                            <td>Unit Petugas *</td>
                                            <td>
                                                <select name="kd_unit_pelayanan" id="kd_unit_pelayanan" class="uniformselect">
                                                    <option value="">Pilih Unit Pelayanan</option>
                                                    <?php foreach($list_unit_pelayanan as $up) : ?>
                                                        <?php
                                                        if($up['kd_unit_pelayanan'] === $row['kd_unit_pelayanan'])
                                                            echo '<option value="'.$up['kd_unit_pelayanan'].'" selected="selected">'.$up['nm_unit'].'</option>';
                                                        else
                                                            echo '<option value="'.$up['kd_unit_pelayanan'].'">'.$up['nm_unit'].'</option>';
                                                        ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Posisi *</td>
                                            <td>
                                                <select name="kd_posisi" id="kd_posisi" class="uniformselect" >
                                                    <option value="">Pilih Posisi</option>
                                                    <?php foreach($list_posisi as $ps) : ?>
                                                        <?php
                                                        if($ps['kd_posisi'] === $row['kd_posisi'])
                                                            echo '<option value="'.$ps['kd_posisi'].'" selected="selected">'.$ps['posisi'].'</option>';
                                                        else
                                                            echo '<option value="'.$ps['kd_posisi'].'">'.$ps['posisi'].'</option>';
                                                        ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan Kesehatan</td>
                                            <td>
                                                <select name="kd_pendidikan" id="kd_pendidikan" class="uniformselect" >
                                                    <option value="">Pilih Pendidikan Kesehatan</option>
                                                    <?php foreach($list_pendidikan_kesehatan as $pk) : ?>
                                                        <?php
                                                        if($pk['kd_pendidikan'] === $row['kd_pendidikan'])
                                                            echo '<option value="'.$pk['kd_pendidikan'].'" selected="selected">'.$pk['pendidikan'].'</option>';
                                                        else
                                                            echo '<option value="'.$pk['kd_pendidikan'].'">'.$pk['pendidikan'].'</option>';
                                                        ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Golongan Petugas</td>
                                            <td>
                                                <select name="kd_gol" id="kd_gol" class="uniformselect">
                                                    <option value="">Pilih Golongan Petugas</option>
                                                    <?php foreach($list_golongan_petugas as $gp) : ?>
                                                        <?php
                                                        if($gp['kd_gol'] === $row['kd_gol'])
                                                            echo '<option value="'.$gp['kd_gol'].'" selected="selected">'.$gp['nama_gol'].'</option>';
                                                        else
                                                            echo '<option value="'.$gp['kd_gol'].'">'.$gp['nama_gol'].'</option>';
                                                        ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Spesialisasi</td>
                                            <td>
                                                <select name="kd_spesialisasi" id="kd_spesialisasi" class="uniformselect">
                                                    <option value="">Pilih Spesialisasi</option>
                                                    <?php foreach($list_spesialisasi as $sp) : ?>
                                                        <?php
                                                        if($sp['kd_spesialisasi'] === $row['kd_spesialisasi'])
                                                            echo '<option value="'.$sp['kd_spesialisasi'].'" selected="selected">'.$sp['spesialisasi'].'</option>';
                                                        else
                                                            echo '<option value="'.$sp['kd_spesialisasi'].'">'.$sp['spesialisasi'].'</option>';
                                                        ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>

                                        <p> <label> * Field harus diisi </label></p>
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Perbaharui</button>
                                    </p>
                            	<?php echo form_close(); ?>
                            <?php endforeach; ?>
                        	</div><!--widgetcontent-->
                            </div>
                        </div>
                        <?php endif;?>
                        <!---- END EDITING FORM ---->
                        
                        <!---- DAFTAR PETUGAS START ---->
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
                        <script type="text/javascript">
							jQuery(document).ready(function () {
								var oTable = jQuery('#dyntable').dataTable({
									"bProcessing": true,
									"bServerSide": true,
									"bAutoWidth": false,
									"sAjaxSource": '<?php echo base_url(); ?>datatable_master/petugas',
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
                         <!---- END DAFTAR PETUGAS---->
                        
                        <!---- TAMBAH PETUGAS START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle">Data Petugas</h4>
                            <div class="row-fluid">
                                <div class="span12">
                                <?php echo form_open('cont_master_pelayanan/petugas/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                    <table class="table table-bordered table-invoice">
                                        <tr>
                                            <td>Kode Petugas *</td>
                                            <td><input type="text" name="kd_petugas" id="kd_petugas" class="input-small" /></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Petugas *</td>
                                            <td><input type="text" name="nama_petugas" id="nama_petugas" class="input-large"/></td>
                                        </tr>
                                        <tr>
                                            <td>Unit Pelayanan *</td>
                                            <td>
                                                <select name="kd_unit_pelayanan" id="kd_unit_pelayanan" data-placeholder="Pilih Unit Pelayanan" style="width:350px" class="chzn-select" tabindex="2" >
                                                    <option value=""></option>
                                                    <?php foreach($list_unit_pelayanan as $up) : ?>
                                                        <option value="<?php echo $up['kd_unit_pelayanan']; ?>"><?php echo $up['nm_unit']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Posisi *</td>
                                            <td>
                                                <select name="kd_posisi" id="kd_posisi" data-placeholder="Pilih Posisi" style="width:350px" class="chzn-select" tabindex="2" >
                                                    <option value=""></option>
                                                    <?php foreach($list_posisi as $ps) : ?>
                                                        <option value="<?php echo $ps['kd_posisi']; ?>"><?php echo $ps['posisi']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan Kesehatan</td>
                                            <td>
                                                <select name="kd_pendidikan" id="kd_pendidikan" data-placeholder="Pilih Pendidikan Kesehatan" style="width:350px" class="chzn-select" tabindex="2" >
                                                    <option value=""></option>
                                                    <?php foreach($list_pendidikan_kesehatan as $pk) : ?>
                                                        <option value="<?php echo $pk['kd_pendidikan']; ?>"><?php echo $pk['pendidikan']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Golongan Petugas</td>
                                            <td>
                                                <select name="kd_gol" id="kd_gol" data-placeholder="Pilih Golongan Petugas" style="width:350px" class="chzn-select" tabindex="2" >
                                                    <option value=""></option>
                                                    <?php foreach($list_golongan_petugas as $gp) : ?>
                                                        <option value="<?php echo $gp['kd_gol']; ?>"><?php echo $gp['nama_gol']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Spesialisasi</td>
                                            <td>
                                                <select name="kd_spesialisasi" id="kd_spesialisasi" data-placeholder="Pilih Spesialisasi" style="width:350px" class="chzn-select" tabindex="2" >
                                                    <option value=""></option>
                                                    <?php foreach($list_spesialisasi as $sp) : ?>
                                                        <option value="<?php echo $sp['kd_spesialisasi']; ?>"><?php echo $sp['spesialisasi']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>

                                        <p> <label> * Field harus diisi </label></p>
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Simpan</button>
                                        <button type="reset" class="btn btn-success btn-circle"><i class="icon-refresh icon-white"></i> B a t a l</button>
                                    </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                                </div>
                        </div>
                        <!---- END TAMBAH PETUGAS---->
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
			kd_petugas: "required",
			nama_petugas: "required",
			unit_pelayanan: "required",
			posisi: "required",
		},
		messages: {
			kd_petugas: "Kode petugas harus diisi!",
			nama_petugas: "Nama petugas harus diisi!",
			unit_pelayanan: "Unit Pelayanan harus diisi",
			posisi: "Posisi harus diisi",
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
			kd_petugas: "required",
			nama_petugas: "required",
			unit_pelayanan: "required",
			posisi: "required",
		},
		messages: {
			kd_petugas: "Kode petugas harus diisi!",
			nama_petugas: "Nama petugas harus diisi!",
			unit_pelayanan: "Unit Pelayanan harus diisi",
			posisi: "Posisi harus diisi",
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