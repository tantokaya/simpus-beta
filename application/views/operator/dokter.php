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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data dokter</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_dokter)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data dokter</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_dokter))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar dokter</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah dokter</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_dokter)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle">Ubah Data dokter</h4>
                            <div class="row-fluid">
                                <div class="span6">
                                <?php foreach ($edit_dokter as $row): ?>
                            	<?php echo form_open('cont_master_pelayanan/dokter/ubah/do_update/'.$row['kd_dokter'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                    <table class="table table-bordered table-invoice">
                                        <tr>
                                            <td>NIP</td>
                                            <td><input type="text" name="nip_dokter" id="nip_dokter" value="<?php echo $row['nip_dokter']; ?>" class="input-medium" /></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Lengkap *</td>
                                            <td><input type="text" name="nm_dokter" id="nm_dokter" value="<?php echo $row['nm_dokter']; ?>" class="input-large" /></td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan Kesehatan</td>
                                            <td>
                                                <select name="kd_pendidikan" id="kd_pendidikan" class="uniformselect" >
                                                    <option value="">Pilih Pendidikan Kesehatan</option>
                                                    <?php foreach($list_pendidikan_kesehatan as $pk) : ?>
                                                        <?php
                                                        if ($pk['kd_pendidikan'] === $row['kd_pendidikan'])
                                                            echo '<option value="'.$pk['kd_pendidikan'].'" selected>'.$pk['pendidikan'].'</option>';
                                                        else
                                                            echo '<option value="'.$pk['kd_pendidikan'].'">'.$pk['pendidikan'].'</option>';
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
                                        <tr>
                                            <td>Jabatan</td>
                                            <td><input type="text" name="jabatan_dokter" id="jabatan_dokter" value="<?php echo $row['jabatan_dokter']; ?>" class="input-medium" /></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td><input type="text" name="status_dokter" id="status_dokter" value="<?php echo $row['status_dokter']; ?>" class="input-small" /></td>
                                        </tr>
                                        <tr>
                                            <td>Bertugas di Unit Pelayanan *</td>
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
                                    </table>

								<p> <label> * Field harus diisi </label> </p>

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
                        
                        <!---- DAFTAR PROPINSI START ---->
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
							<script type="text/javascript">
                                jQuery(document).ready(function () {
                                    var oTable = jQuery('#dyntable').dataTable({
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/dokter',
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
                         <!---- END DAFTAR PROPINSI ---->
                        
                        <!---- TAMBAH PROPINSI START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle">Data Jenis dokter</h4>
                            <div class="row-fluid">
                                <div class="span6">
                                <?php echo form_open('cont_master_pelayanan/dokter/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                    <table class="table table-bordered table-invoice">
                                        <tr>
                                            <td>NIP</td>
                                            <td><input type="text" name="nip_dokter" id="nip_dokter" class="input-medium" /></td>
                                        </tr>
                                        <tr>
                                            <td>Nama Lengkap *</td>
                                            <td><input type="text" name="nm_dokter" id="nm_dokter" class="input-large" /></td>
                                        </tr>
                                        <tr>
                                            <td>Pendidikan Kesehatan</td>
                                            <td>
                                                <select name="kd_pendidikan" id="kd_pendidikan" class="chzn-select" tabindex="2" >
                                                    <option value=""></option>
                                                    <?php foreach($list_pendidikan_kesehatan as $pk) : ?>
                                                        <option value="<?php echo $pk['kd_pendidikan']; ?>"><?php echo $pk['pendidikan']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Spesialisasi</td>
                                            <td>
                                                <select name="kd_spesialisasi" id="kd_spesialisasi" class="chzn-select" tabindex="2" >
                                                    <option value=""></option>
                                                    <?php foreach($list_spesialisasi as $sp) : ?>
                                                        <option value="<?php echo $sp['kd_spesialisasi']; ?>"><?php echo $sp['spesialisasi']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td><input type="text" name="jabatan_dokter" id="jabatan_dokter" class="input-medium" /></td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td><input type="text" name="status_dokter" id="status_dokter" class="input-small" /></td>
                                        </tr>
                                        <tr>
                                            <td>Bertugas di Unit Pelayanan *</td>
                                            <td>
                                                <select name="kd_unit_pelayanan" id="kd_unit_pelayanan" class="chzn-select" tabindex="2" >
                                                    <option value="">Pilih Unit Pelayanan</option>
                                                    <?php foreach($list_unit_pelayanan as $up) : ?>
                                                        <option value="<?php echo $up['kd_unit_pelayanan']; ?>"><?php echo $up['nm_unit']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <p class="stdformbutton">
                                        <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Simpan</button>
                                        <button type="reset" class="btn btn-success btn-circle"><i class="icon-refresh icon-white"></i> B a t a l</button>
                                    </p>
                                    <div class="clearfix" style="margin-bottom:100px"></div>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                                </div>
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
			kd_dokter: "required",
			nm_dokter: "required",
			//nip_dokter: "required",
			//jabatan_dokter: "required",
			//status_dokter: "required",
			//kd_puskesmas: "required"
		},
		messages: {
			kd_dokter: "Kode dokter harus diisi!",
			nm_dokter: "Nama harus diisi!",
			//nip_dokter: "NIP harus diisi!",
			//jabatan_dokter: "Jabatan harus diisi!",
			//status_dokter: "Status harus diisi!",
			//kd_puskesmas: "Kode Puskesmas harus diisi!"
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
			kd_dokter: "required",
			nm_dokter: "required",
			//nip_dokter: "required",
			//jabatan_dokter: "required",
			//status_dokter: "required",
			
		},
		messages: {
			kd_dokter: "Kode dokter harus diisi!",
			nm_dokter: "Nama harus diisi!",
			//nip_dokter: "NIP harus diisi!",
			//jabatan_dokter: "Jabatan harus diisi!",
			//status_dokter: "Status harus diisi!",
			
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