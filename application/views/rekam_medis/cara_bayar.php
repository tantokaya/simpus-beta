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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data cara bayar</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_cara_bayar)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Cara Bayar</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_cara_bayar))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Cara Bayar</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Cara Bayar</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_cara_bayar)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Cara Bayar</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_cara_bayar as $row): ?>
                            	<?php echo form_open('cont_master_pasien/cara_bayar/ubah/do_update/'.$row['kd_bayar'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Bayar</label>
                                            <span class="field"><input type="text" name="kd_bayar" id="kd_bayar" value="<?php echo $row['kd_bayar']; ?>" class="input-medium" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Cara Bayar</label>
                                            <span class="field"><input type="text" name="cara_bayar" id="cara_bayar" value="<?php echo $row['cara_bayar']; ?>" class="input-xlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Kode Customer</label>
                                            <span class="field"><input type="text" name="kd_customer" id="kd_customer" value="<?php echo $row['kd_customer']; ?>" class="input-medium" /></span>
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
                        
                        <!---- DAFTAR CARA BAYAR START ---->
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
							<script type="text/javascript">
                                jQuery(document).ready(function () {
                                    var oTable = jQuery('#dyntable').dataTable({
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/cara_bayar',
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
                         <!---- END DAFTAR CARA BAYAR ---->
                        
                        <!---- TAMBAH CARA BAYAR START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Cara Bayar</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_pasien/cara_bayar/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Bayar</label>
                                            <span class="field"><input type="text" name="kd_bayar" id="kd_bayar" class="input-medium" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Cara Bayar</label>
                                            <span class="field"><input type="text" name="cara_bayar" id="cara_bayar" class="input-xlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Kode Customer</label>
                                            <span class="field"><input type="text" name="kd_customer" id="kd_customer" class="input-medium" /></span>
                                        </p>
                                                           
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH CARA BAYAR ---->
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
			kd_bayar: "required",
			cara_bayar: "required",
			kd_customer: "required",
		},
		messages: {
			kd_bayar: "Kode bayar harus diisi!",
			cara_bayar: "Cara bayar harus diisi!",
			kd_customer: "Kode customer harus diisi!"
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
			kd_bayar: "required",
			cara_bayar: "required",
			kd_customer: "required",
		},
		messages: {
			kd_bayar: "Kode bayar harus diisi!",
			cara_bayar: "Cara bayar harus diisi!",
			kd_customer: "Kode customer harus diisi!"
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