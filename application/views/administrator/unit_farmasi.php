<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Unit Farmasi</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data unit farmasi / apotik</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_unit_farmasi)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Unit Farmasi /Apotik</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_unit_farmasi))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Unit Farmasi / Apotik</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Unit Farmasi / Apotik</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_unit_farmasi)):?>
                        <div id="ubah">
                       	<h4 class="widgettitle">Ubah Data Unit Farmasi / Apotik</h4>
                        <div class="row-fluid">
			<div class="span6">
			<?php foreach ($edit_unit_farmasi as $row): ?>
                        <?php echo form_open('cont_master_farmasi/unit_farmasi/ubah/do_update/'.$row['kd_unit_farmasi'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                        <table class="table table-bordered table-invoice">
				<tr>
					<td>Kode Unit Farmasi</td>
					<td><input type="text" name="kd_unit_farmasi" id="kd_unit_farmasi" value="<?php echo $row['kd_unit_farmasi']; ?>" class="input-small"  /></td>
				</tr>
				<tr>
					<td>Nama Unit Farmasi</td>
					<td><input type="text" name="nama_unit_farmasi" id="nama_unit_farmasi" value="<?php echo $row['nama_unit_farmasi']; ?>" class="input-medium" /></td>
				</tr>
				<tr>
					<td>Farmasi Utama</td>
					<td><input type="text" name="farmasi_utama" id="farmasi_utama" value="<?php echo $row['farmasi_utama']; ?>" class="input-medium" /></td>
				</tr>
			</table>
			<p class="stdformbutton">
                                <button class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Perbaharui</button>
                            <!--<button type="reset" class="btn btn-inverse"><i class="icon-refresh icon-white"></i> Reset</button>-->
                        </p>
			<?php echo form_close(); ?>
                            <?php endforeach; ?>
                        </div></div></div>
                        <?php endif;?>
                        <!---- END EDITING FORM ---->
                        
                        <!---- DAFTAR UNIT FARMASI START ---->
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
							<script type="text/javascript">
                                jQuery(document).ready(function () {
                                    var oTable = jQuery('#dyntable').dataTable({
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/unit_farmasi',
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
                         <!---- END DAFTAR UNIT FARMASI---->
                        
                        <!---- TAMBAH UNIT FARMASI START ---->
                        <div id="tambah">
                       	<h4 class="widgettitle">Data Unit Farmasi</h4>
                        <div class="row-fluid">
			<div class="span6">
			<?php echo form_open('cont_master_farmasi/unit_farmasi/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                        <table class="table table-bordered table-invoice">
				<tr>
					<td>Kode Unit Farmasi</td>
					<td>
                    <input type="text" name="kd_unit_farmasi" id="kd_unit_farmasi" class="input-small" />
                    </td>
				</tr>
				<tr>
					<td>Nama Unit Farmasi</td>
					<td><input type="text" name="nama_unit_farmasi" id="nama_unit_farmasi" class="input-medium" /></td>
				</tr>
				<tr>
					<td>Farmasi Utama</td>
					<td><input type="text" name="farmasi_utama" id="farmasi_utama" class="input-medium" /></td>
				</tr>
			</table>
			<p class="stdformbutton">
				<button class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Simpan</button>
				<button type="reset" class="btn btn-inverse"><i class="icon-refresh icon-white"></i> Reset</button>
                        </p>
                               	<?php echo form_close();  ?>
                        </div></div>
                        <!---- END TAMBAH UNIT FARMASI---->
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
			kd_unit_farmasi: "required",
			nama_unit_farmasi: "required",
			farmasi_utama: "required",
			
		},
		messages: {
			kd_unit_farmasi: "Kode unit farmasi harus diisi!",
			nama_unit_farmasi: "Nama unit farmasi harus diisi!",
			farmasi_utama: "Farmasi utama harus diisi!",
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
			kd_unit_farmasi: "required",
			nama_unit_farmasi: "required",
			farmasi_utama: "required",
			
		},
		messages: {
			kd_unit_farmasi: "Kode unit farmasi harus diisi!",
			nama_unit_farmasi: "Nama unit farmasi harus diisi!",
			farmasi_utama: "Farmasi utama harus diisi!",
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