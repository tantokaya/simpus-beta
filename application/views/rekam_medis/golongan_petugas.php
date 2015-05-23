<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Golongan Petugas</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data golongan petugas</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_golongan_petugas)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Golongan Petugas</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_golongan_petugas))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Golongan Petugas</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Golongan Petugas</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_golongan_petugas)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Golongan Petugas</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_golongan_petugas as $row): ?>
                            	<?php echo form_open('cont_master_petugas/golongan_petugas/ubah/do_update/'.$row['kd_gol'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Golongan Petugas (harus unik)</label> </p>
                                            <span class="field"><input type="text" name="kd_gol" id="kd_gol" value="<?php echo $row['kd_gol']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Golongan</label>
                                            <span class="field"><input type="text" name="nama_gol" id="nama_gol" value="<?php echo $row['nama_gol']; ?>" class="input-xxlarge" /></span>
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
                        
                        <!---- DAFTAR GOLONGAN PETUGAS START ---->
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
							<script type="text/javascript">
                                jQuery(document).ready(function () {
                                    var oTable = jQuery('#dyntable').dataTable({
                                        "bProcessing": true,
                                        "bServerSide": true,
                                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/golongan_petugas',
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
                         <!---- END DAFTAR GOLONGAN PETUGAS---->
                        
                        <!---- TAMBAH GOLONGAN PETUGAS START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Golongan Petugas</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_petugas/golongan_petugas/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Kode Golongan Petugas  (harus unik)</label>
                                            <span class="field"><input type="text" name="kd_gol" id="kd_gol" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Golongan</label>
                                            <span class="field"><input type="text" name="nama_gol" id="nama_gol" class="input-xxlarge" /></span>
                                        </p>
                                                           
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH GOLONGAN PETUGAS---->
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
			kd_gol: "required",
			nama_gol: "required",
			
		},
		messages: {
			kd_gol: "Kode golongan petugas harus diisi dan unik!",
			nama_gol: "Nama golongan petugas harus diisi!",
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
			kd_gol: "required",
			nama_gol: "required",
			
		},
		messages: {
			kd_gol: "Kode golongan petugas harus diisi dan unik!",
			nama_gol: "Nama golongan petugas harus diisi!",
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