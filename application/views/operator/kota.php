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
            <li><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/propinsi">Propinsi</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data kota / kabupaten</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_kota)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Kota</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_kota))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Kota</a></li>
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Tambah Kota</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_kota)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Kota</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                            <?php foreach ($edit_kota as $row): ?>
                            	<?php echo form_open('cont_master_wil_puskesmas/kota/ubah/do_update/'.$row['kd_kota'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                                        <p>
                                            <label>Kode Kota</label>
                                            <span class="field"><input type="text" name="kd_kota" id="kd_kota" value="<?php echo $row['kd_kota']; ?>" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Kota</label>
                                            <span class="field"><input type="text" name="nm_kota" id="nm_kota" value="<?php echo $row['nm_kota']; ?>" class="input-xxlarge" /></span>
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
                        
                        <!---- DAFTAR KOTA START ---->
   						<div id="list">
                        <!--
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
                                    <th class="head0">Kode Kota</th>
                                    <th class="head1">Nama Kota</th>
                                    <th class="head0">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            
                            <?php foreach ($kota as $r): ?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
                                    <td><?php echo $r['kd_kota']; ?></td>
                                    <td><a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kecamatan/<?php echo $r['kd_kota']; ?>"><?php echo $r['nm_kota']; ?></a></td>
                                    <td class="center">
                                    	<a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kota/ubah/<?php echo $r['kd_kota']; ?>" class="btn btn-primary btn-circle"><i class="iconsweets-create iconsweets-white"></i></a> 
                                        <a href="<?php echo base_url(); ?>cont_master_wil_puskesmas/kota/hapus/<?php echo $r['kd_kota']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php endforeach; ?>
                   	 		</tbody>
                			</table>
                            !-->
                            
                            <?php echo $this->table->generate(); ?>
                        <script type="text/javascript">
							jQuery(document).ready(function () {
								var oTable = jQuery('#dyntable').dataTable({
									"bProcessing": true,
									"bServerSide": true,
									"bAutoWidth": false,
									"sAjaxSource": '<?php echo base_url(); ?>datatable_master/kota',
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
                         <!---- END DAFTAR KOTA ---->
                        
                        <!---- TAMBAH KOTA START ---->
                        <div id="tambah">
                       		<h4 class="widgettitle nomargin shadowed">Data Kota</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_master_wil_puskesmas/kota/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                <?php if(isset($edit_kota)){
									echo  '<input type="hidden" name="kd_propinsi" value="'.substr($this->uri->segment(4),0,2).'" />';
								} else {
									echo  '<input type="hidden" name="kd_propinsi" value="'.$this->uri->segment(3).'" />';
								}
								?>
                               
                                        <p>
                                            <label>Kode Kota</label>
                                            <span class="field"><input type="text" name="kd_kota" id="kd_kota" class="input-xxlarge" /></span>
                                        </p>
                                        
                                        <p>
                                            <label>Nama Kota</label>
                                            <span class="field"><input type="text" name="nm_kota" id="nm_kota" class="input-xxlarge" /></span>
                                        </p>              
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END TAMBAH KOTA ---->
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
			kd_kota: "required",
			nm_kota: "required"
			
		},
		messages: {
			kd_kota: "Kode kota harus diisi!",
			nm_kota: "Nama kota harus diisi!"
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
			kd_kota: "required",
			nm_kota: "required"
			
		},
		messages: {
			kd_kota: "Kode kota harus diisi!",
			nm_kota: "Nama kota harus diisi!"
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