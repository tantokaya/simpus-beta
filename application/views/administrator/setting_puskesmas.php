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
			
<h4 class="widgettitle">Data Puskesmas</h4>
			<div class="row-fluid">
			<div class="span6">
                        <?php echo form_open('cont_master_setting/simpan', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                        <table class="table table-bordered table-invoice">
				<tr>
					<td>Kode Puskesmas</td>
					<td><input type="text" name="kd_puskesmas" id="kd_puskesmas" class="input-medium" value="<?php echo $kd_puskesmas; ?>"/></td>
				</tr>
				<tr>
					<td>Nama Puskesmas</td>
					<td><input type="text" name="nm_puskesmas" id="nm_puskesmas" class="input-xlarge" value="<?php echo $nm_puskesmas; ?>"/></td>
				</tr>
				
				<tr>
					<td>Alamat Puskesmas</td>
					<td><textarea name="alamat" id="alamat" class="input-xlarge" rows="3"><?php echo $alamat; ?></textarea></td>
				</tr>
				
			</table>
			<p class="stdformbutton">
				<button class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Simpan</button>
				
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