<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Transaksi</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data pendaftaran pasien</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
                        	<?php if(isset($edit_pendaftaran)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Pendaftaran</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($edit_pendaftaran) && !isset($view_rekam_medis))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Semua Pasien</a></li>
                            
                            <li class=""><a href="#tambah"><i class="icon-plus"></i> Pendaftaran Pasien Baru</a></li>
                            
							<?php if(isset($view_rekam_medis)):?>
            				<li class="ui-tabs-active"><a href="#rekam-medis"><i class="icon-file"></i> Rekam Medis</a></li>
            				<?php endif;?>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
        				<?php if(isset($edit_pendaftaran)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle">Ubah Data Pendaftaran</h4>
                            
                            <?php foreach ($edit_pendaftaran as $row): ?>
                            	<?php echo form_open('cont_transaksi_pendaftaran/pendaftaran/ubah/do_update/'.$row['kd_rekam_medis'], array('class' => 'stdform stdform2', 'id' => 'form_edit')); ?>
                            <div class="row-fluid">
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	<!--
                                    <tr>
                                    	<td class="width30">No. Rekam Medis</td>
                                        <td class="width70"><input type="text" name="kd_rekam_medis" id="kd_rekam_medis" class="input-large" /></td>
                                    </tr>
                                    -->
									<tr>
                                        <td class="width30">Tanggal Daftar *</td>
                                        <td class="width70"><input type="text" name="tanggal_daftar" id="tanggal_daftar" readonly class="input-large" value="<?php echo date('d-m-Y'); ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>No Registrasi</td>
                                        <td><input type="text" name="no_reg" id="no_reg" class="input-large" value="<?php echo $row['no_reg']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Nama Lengkap *</td>
                                        <td><input type="text" name="nm_lengkap" id="nm_lengkap" class="input-large" value="<?php echo $row['nm_lengkap']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Tempat Lahir *</td>
                                        <td><input type="text" name="tempat_lahir" id="tempat_lahir" class="input-large" value="<?php echo $row['tempat_lahir']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir *</td>
                                        <td><input type="text" name="tanggal_lahir" id="tanggal_lahir2" class="input-small" value="<?php echo $this->functions->convert_date_indo(array("datetime" => $row['tanggal_lahir'])); ?>" /> <i>dd-mm-yyyy</i></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin *</td>
                                        <td>
                                        	<select name="kd_jenis_kelamin" id="kd_jenis_kelamin2" class="uniformselect">
                                                <option value="-">Pilih Jenis Kelamin</option>
                                                <?php foreach($list_jenis_kelamin as $jk) : ?>
                                                	<?php 
													if ($jk['kd_jenis_kelamin'] === $row['kd_jenis_kelamin']) 
                                                		echo '<option value="'.$jk['kd_jenis_kelamin'].'" selected>'.$jk['jenis_kelamin'].'</option>';
                                                    else
                                                    	echo '<option value="'.$jk['kd_jenis_kelamin'].'">'.$jk['jenis_kelamin'].'</option>';
                                                    ?>
                                                <?php endforeach; ?>
                            				</select>
                                       </td>
                                    </tr>
									<tr>
                                  <!--  	<td>Puskesmas *</td>
                                        <td>
                                        	<select name="kd_puskesmas" id="kd_puskesmas2" data-placeholder="Pilih Puskesmas" style="width:250px" class="chzn-select" required>
                                            	<option value=""></option>
                                            	<?php foreach($list_puskesmas as $pus) : ?>
                                            	<option value="<?php echo $pus['kd_puskesmas']; ?>"><?php echo $pus['nm_puskesmas']; ?></option>
												<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_puskesmas2").val("<?php echo $row['kd_puskesmas']; ?>").trigger("liszt:updated");
                                            </script>
                                    	</td>
                                    </tr>
                                    <tr>
                                    	<td>Kel / Jenis Pasien</td>
                                        <td>
                                        	<select name="kd_jenis_pasien" id="kd_jenis_pasien" class="uniformselect">
                                            <option value="-">Pilih Jenis Pasien</option>
                                            <?php foreach($list_jp as $ljp) : ?>
                                            		<?php 
													if ($ljp['kd_jenis_pasien'] === $row['kd_jenis_pasien']) 
                                                		echo '<option value="'.$ljp['kd_jenis_pasien'].'" selected>'.$ljp['jenis_pasien'].'</option>';
                                                    else
                                                    	echo '<option value="'.$ljp['kd_jenis_pasien'].'">'.$ljp['jenis_pasien'].'</option>';
                                                    ?>
                                            <?php endforeach; ?>
                                        </select>
                                        </td>
                                    </tr> 
									-->
                                </table>
                            </div>
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
									<tr>
                                    	<td>NIK / No KTP</td>
                                        <td><input type="text" name="nik" id="nik" class="input-large" maxlength="16" size="16" value="<?php echo $row['nik']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>No. KK</td>
                                        <td><input type="text" name="no_kk" id="no_kk" class="input-large" value="<?php echo $row['no_kk']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                    	<td>Nama KK</td>
                                        <td><input type="text" name="nm_kk" id="nm_kk" class="input-large" value="<?php echo $row['nm_kk']; ?>" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Nama Asuransi</td>
                                        <td><input type="text" name="asuransi" id="asuransi" class="input-large" value="<?php echo $row['asuransi']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td>No. Asuransi</td>
                                        <td><input type="text" name="no_asuransi" id="no_asuransi" class="input-large" value="<?php echo $row['no_asuransi']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Cara Bayar</td>
                                        <td>
                                        	<select name="kd_bayar" id="kd_bayar2" data-placeholder="Pilih Cara Bayar" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                            <?php foreach($list_cb as $lcb) : ?>
                                            	<option value="<?php echo $lcb['kd_bayar']; ?>"><?php echo $lcb['cara_bayar']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_bayar2").val("<?php echo $row['kd_bayar']; ?>").trigger("liszt:updated");
                                            </script>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <h4 class="widgettitle">Data Alamat</h4>
                           
                            <div class="row-fluid">
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	
                                    <tr>
                                    	<td>Propinsi *</td>
                                        <td>
                                        	<select name="kd_propinsi" id="kd_propinsi2" data-placeholder="Pilih Propinsi" style="width:250px" class="chzn-select" required>
                                            	<option value=""></option>
                                            	<?php foreach($list_provinsi as $lp) : ?>
                                            	<option value="<?php echo $lp['kd_propinsi']; ?>"><?php echo $lp['nm_propinsi']; ?></option>
												<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_propinsi2").val("<?php echo $row['kd_propinsi']; ?>").trigger("liszt:updated");
                                            </script>
                                    	</td>
                                    </tr>
                                    <tr>
                                    	<td>Kota / Kabupaten *</td>
                                        <td>
                                        	<select name="kd_kota" id="kd_kota2" data-placeholder="Pilih Kota" style="width:250px" class="chzn-select" required>
                                            	<option value=""></option>
                                                <?php foreach($edit_kota as $ek) : ?>
                                            	<option value="<?php echo $ek['kd_kota']; ?>"><?php echo $ek['nm_kota']; ?></option>
												<?php endforeach; ?>
                                   			</select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_kota2").val("<?php echo $row['kd_kota']; ?>").trigger("liszt:updated");
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan *</td>
                                        <td>
                                        	<select name="kd_kecamatan" id="kd_kecamatan2" data-placeholder="Pilih Kecamatan" style="width:250px" class="chzn-select" required>
                                            	<option value=""></option>
                                                <?php foreach($edit_kecamatan as $kec) : ?>
                                            	<option value="<?php echo $kec['kd_kecamatan']; ?>"><?php echo $kec['nm_kecamatan']; ?></option>
												<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_kecamatan2").val("<?php echo $row['kd_kecamatan']; ?>").trigger("liszt:updated");
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kelurahan *</td>
                                        <td>
                                        	<select name="kd_kelurahan" id="kd_kelurahan2" data-placeholder="Pilih Kelurahan" style="width:250px" class="chzn-select" required>
                                            	<option value=""></option>
                                                <?php foreach($edit_kelurahan as $kel) : ?>
                                            	<option value="<?php echo $kel['kd_kelurahan']; ?>"><?php echo $kel['nm_kelurahan']; ?></option>
												<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_kelurahan2").val("<?php echo $row['kd_kelurahan']; ?>").trigger("liszt:updated");
                                            </script>
                                        </td>
                                    </tr>
                                  
                                </table>
                            </div>
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	<tr>
                                        <td class="width30">Alamat *</td>
                                        <td class="width70"><input type="text" name="alamat" id="alamat" class="input-large" value="<?php echo $row['alamat']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Kode Pos</td>
                                        <td><input type="text" name="kd_pos" id="kd_pos" class="input-large" value="<?php echo $row['kd_pos']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>No. Telp Rumah</td>
                                        <td><input type="text" name="no_telepon" id="no_telepon" class="input-large" value="<?php echo $row['no_telepon']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                    	<td>No. HP</td>
                                        <td><input type="text" name="no_hp" id="no_hp" class="input-large" value="<?php echo $row['no_hp']; ?>" /></td>
                                    </tr>
                                    
                                </table>
                            </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <h4 class="widgettitle">Data Pribadi</h4>
                           
                            <div class="row-fluid">
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	
                                    <tr>
                                    	<td>Agama</td>
                                        <td>
                                        	<select name="kd_agama" id="kd_agama2" data-placeholder="Pilih Agama" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                            <?php foreach($list_agama as $la) : ?>
                                            	<option value="<?php echo $la['kd_agama']; ?>"><?php echo $la['nm_agama']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_agama2").val("<?php echo $row['kd_agama']; ?>").trigger("liszt:updated");
                                            </script>
                                    	</td>
                                    </tr>
                                    <tr>
                                    	<td>Golongan Darah</td>
                                        <td>
                                        	<select name="kd_gol_darah" id="kd_gol_darah2" data-placeholder="Pilih Golongan Darah" style="width:250px" class="chzn-select" required>
                                           	<option value=""></option>
                                            <?php foreach($list_golongan_darah as $lgd) : ?>
                                            	<option value="<?php echo $lgd['kd_gol_darah']; ?>"><?php echo $lgd['gol_darah']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_gol_darah2").val("<?php echo $row['kd_gol_darah']; ?>").trigger("liszt:updated");
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan</td>
                                        <td>
                                        	 <select name="kd_pekerjaan" id="kd_pekerjaan2" data-placeholder="Pilih Pekerjaan" style="width:250px" class="chzn-select" required>
                                             	<option value=""></option>
                                            	<?php foreach($list_pekerjaan as $lpk) : ?>
                                            	<option value="<?php echo $lpk['kd_pekerjaan']; ?>"><?php echo $lpk['pekerjaan']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_pekerjaan2").val("<?php echo $row['kd_pekerjaan']; ?>").trigger("liszt:updated");
                                            </script>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	<tr>
                                        <td class="width30">Status Nikah</td>
                                        <td class="width70"><select name="kd_status_marital" id="kd_status_marital2" data-placeholder="Pilih Status Pernikahan" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                            <?php foreach($list_status_marital as $lsm) : ?>
                                            	<option value="<?php echo $lsm['kd_status_marital']; ?>"><?php echo $lsm['status_marital']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                       		<script type="text/javascript">
                                            	jQuery("#kd_status_marital2").val("<?php echo $row['kd_status_marital']; ?>").trigger("liszt:updated");
                                            </script>
                                       </td>
                                    </tr>
                                    <tr>
                                    	<td>Pendidikan Akhir</td>
                                        <td>
                                        	<select name="kd_pendidikan" id="kd_pendidikan2" data-placeholder="Pilih Jenjang Pendidikan" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                            <?php foreach($list_pendidikan as $lp) : ?>
                                            	<option value="<?php echo $lp['kd_pendidikan']; ?>"><?php echo $lp['pendidikan']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                            <script type="text/javascript">
                                            	jQuery("#kd_pendidikan2").val("<?php echo $row['kd_pendidikan']; ?>").trigger("liszt:updated");
                                            </script>
                                        </td>
                                    </tr>
                                    
                                </table>
                            </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <h4 class="widgettitle">Keluarga</h4>
                           
                            <div class="row-fluid">
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	
                                    <tr>
                                    	<td>Nama Ayah</td>
                                        <td><input type="text" name="nm_ayah" id="nm_ayah" class="input-large" value="<?php echo $row['nm_ayah']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Nama Ibu</td>
                                        <td><input type="text" name="nm_ibu" id="nm_ibu" class="input-large" value="<?php echo $row['nm_ibu']; ?>" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	<tr>
                                        <td class="width30">Orang yang Dapat di Hubungi</td>
                                        <td class="width70"><input type="text" name="nm_orang" id="nm_orang" class="input-large" value="<?php echo $row['nm_orang']; ?>" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Rincian Penanggung</td>
                                        <td><input type="text" name="rincian_penanggung" id="rincian_penanggung" class="input-large" value="<?php echo $row['rincian_penanggung']; ?>" /></td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <div class="clearfix"><br/></div>
                           <p><em>	Catatan: * wajib diisi</em></p>
                           
                            	<button class="btn btn-primary">Perbaharui</button>
                                <button type="reset" class="btn">Reset</button>
                       			<br/>
                        	</div><!--widgetcontent-->
                            <?php echo form_close(); ?>
                            <?php endforeach; ?>
                      
                        <?php endif;?>
                        <!---- END EDITING PENDAFTARAN FORM ---->
                        
                        <!---- DAFTAR PENDAFTARAN START ---->
   				
   						<div id="list">
                        	<?php echo $this->table->generate(); ?>
                        <script type="text/javascript">
							jQuery(document).ready(function () {
								var oTable = jQuery('#dyntable').dataTable({
									"bProcessing": true,
									"bServerSide": true,
									"bAutoWidth": false,
									"sAjaxSource": '<?php echo base_url(); ?>datatable_master/pendaftaran',
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
                        
                         <!---- END DAFTAR PENDAFTARAN ---->
                        
                        <!---- TAMBAH PENDAFTARAN START ---->
                        <div id="tambah">
                        <?php echo form_open('cont_transaksi_pendaftaran/pendaftaran/tambah', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                       		<h4 class="widgettitle">Pendaftaran Pasien Baru</h4>
                           
                            <div class="row-fluid">
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	<!--
                                    <tr>
                                    	<td class="width30">No. Rekam Medis</td>
                                        <td class="width70"><input type="text" name="kd_rekam_medis" id="kd_rekam_medis" class="input-large" /></td>
                                    </tr>
                                    -->
									<tr>
                                        <td class="width30">Tanggal Daftar</td>
                                        <td class="width70"><input type="text" name="tanggal_daftar" id="tanggal_daftar" readonly class="input-large" value="<?php echo date('d-m-Y'); ?>" /></td>
                                    </tr>
								 	 <tr>
                                    	<td>No Registrasi</td>
                                        <td><input type="text" name="no_reg" id="no_reg" class="input-large" maxlength="16" size="16" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Nama Lengkap *</td>
                                        <td><input type="text" name="nm_lengkap" id="nm_lengkap" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                        <td>Tempat Lahir *</td>
                                        <td><input type="text" name="tempat_lahir" id="tempat_lahir" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir *</td>
                                        <td><input type="text" name="tanggal_lahir" id="tanggal_lahir" class="input-small" /> <i>dd-mm-yyyy</i></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin *</td>
                                        <td>
                                        	<select name="kd_jenis_kelamin" id="kd_jenis_kelamin" class="uniformselect">
                                                <option value="-">Pilih Jenis Kelamin</option>
                                                <?php foreach($list_jenis_kelamin as $jk) : ?>
                                                <option value="<?php echo $jk['kd_jenis_kelamin']; ?>"><?php echo $jk['jenis_kelamin']; ?></option>
                                                <?php endforeach; ?>
                            				</select>
                                       </td>
                                    </tr>
								<!--	<tr>
                          	<td>Puskesmas *</td>
                                        <td>
                                        	<select name="kd_puskesmas" id="kd_puskesmas" data-placeholder="Pilih Puskesmas" style="width:250px" class="chzn-select" required>
                                            	<?php foreach($list_puskesmas as $pus) : ?>
                                            	<option value="<?php echo $pus['kd_puskesmas']; ?>"><?php echo $pus['nm_puskesmas']; ?></option>
												<?php endforeach; ?>
                                            </select>
                                    	</td>
                                        </tr>	-->
                                <!--   <tr>
                                    	<td>Kel / Jenis Pasien</td>
                                        <td>
                                        	<select name="kd_jenis_pasien" id="kd_jenis_pasien" data-placeholder="Pilih Jenis Pasien" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                            <?php foreach($list_jp as $ljp) : ?>
                                            	<option value="<?php echo $ljp['kd_jenis_pasien']; ?>"><?php echo $ljp['jenis_pasien']; ?></option>
											<?php endforeach; ?>
                                        </select>
                                        </td>
                                    </tr> -->
                                </table>
                            </div>
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	 <tr>
                                    	<td>NIK / No KTP</td>
                                        <td><input type="text" name="nik" id="nik" class="input-large" maxlength="16" size="16" /></td>
                                    </tr>
                                    </tr>
                                    <tr>
                                    	<td>No. KK</td>
                                        <td><input type="text" name="no_kk" id="no_kk" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                    	<td>Nama KK</td>
                                        <td><input type="text" name="nm_kk" id="nm_kk" class="input-large" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Asuransi (jika ada)</td>
                                        <td><input type="text" name="asuransi" id="asuransi" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                        <td>No. Asuransi</td>
                                        <td><input type="text" name="no_asuransi" id="no_asuransi" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Cara Bayar</td>
                                        <td>
                                        	<select name="kd_bayar" id="kd_bayar" data-placeholder="Pilih Cara Bayar" style="width:250px" class="chzn-select" tabindex="2" required>
                                            <option value=""></option>
                                            <?php foreach($list_cb as $lcb) : ?>
                                            	<option value="<?php echo $lcb['kd_bayar']; ?>"><?php echo $lcb['cara_bayar']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <h4 class="widgettitle">Data Alamat</h4>
                           
                            <div class="row-fluid">
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	
                                    <tr>
                                    	<td>Propinsi *</td>
                                        <td>
                                        	<select name="kd_propinsi" id="kd_propinsi" data-placeholder="Pilih Propinsi" style="width:250px" class="chzn-select" tabindex="2" required>
                                            	<option value=""></option>
                                            	<?php foreach($list_provinsi as $lp) : ?>
												<option value="<?php echo $lp['kd_propinsi']; ?>"><?php echo $lp['nm_propinsi']; ?></option>
												
                                            	
												<?php endforeach; ?>
                                            </select>
                                    	</td>
                                    </tr>
                                    <tr>
                                    	<td>Kota / Kabupaten *</td>
                                        <td>
                                        	<select name="kd_kota" id="kd_kota" data-placeholder="Pilih Kota" style="width:250px" class="chzn-select" required>
                                            	<option value=""></option>
												
                                   			</select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kecamatan *</td>
                                        <td>
                                        	<select name="kd_kecamatan" id="kd_kecamatan" data-placeholder="Pilih Kecamatan" style="width:250px" class="chzn-select" required>
                                            	<option value=""></option>
												
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kelurahan *</td>
                                        <td>
                                        	<select name="kd_kelurahan" id="kd_kelurahan" data-placeholder="Pilih Kelurahan" style="width:250px" class="chzn-select" required>
                                            	<option value=""></option>
                                            </select>
                                        </td>
                                    </tr>
                                  
                                </table>
                            </div>
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	<tr>
                                        <td class="width30">Alamat *</td>
                                        <td class="width70"><input type="text" name="alamat" id="alamat" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Kode Pos</td>
                                        <td><input type="text" name="kd_pos" id="kd_pos" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                    	<td>No. Telp Rumah</td>
                                        <td><input type="text" name="no_telepon" id="no_telepon" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                    <tr>
                                    	<td>No. HP</td>
                                        <td><input type="text" name="no_hp" id="no_hp" class="input-large" /></td>
                                    </tr>
                                    
                                </table>
                            </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <h4 class="widgettitle">Data Pribadi</h4>
                           
                            <div class="row-fluid">
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	
                                    <tr>
                                    	<td>Agama</td>
                                        <td>
                                        	<select name="kd_agama" id="kd_agama" data-placeholder="Pilih Agama" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                            <?php foreach($list_agama as $la) : ?>
                                            	<option value="<?php echo $la['kd_agama']; ?>"><?php echo $la['nm_agama']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                    	</td>
                                    </tr>
                                    <tr>
                                    	<td>Golongan Darah</td>
                                        <td>
                                        	<select name="kd_gol_darah" id="kd_gol_darah" data-placeholder="Pilih Golongan Darah" style="width:250px" class="chzn-select" required>
                                           	<option value=""></option>
                                            <?php foreach($list_golongan_darah as $lgd) : ?>
                                            	<option value="<?php echo $lgd['kd_gol_darah']; ?>"><?php echo $lgd['gol_darah']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan</td>
                                        <td>
                                        	 <select name="kd_pekerjaan" id="kd_pekerjaan" data-placeholder="Pilih Pekerjaan" style="width:250px" class="chzn-select" required>
                                             	<option value=""></option>
                                            	<?php foreach($list_pekerjaan as $lpk) : ?>
                                            	<option value="<?php echo $lpk['kd_pekerjaan']; ?>"><?php echo $lpk['pekerjaan']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	<tr>
                                        <td class="width30">Status Nikah</td>
                                        <td class="width70"><select name="kd_status_marital" id="kd_status_marital" data-placeholder="Pilih Status Pernikahan" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                            <?php foreach($list_status_marital as $lsm) : ?>
                                            	<option value="<?php echo $lsm['kd_status_marital']; ?>"><?php echo $lsm['status_marital']; ?></option>
											<?php endforeach; ?>
                                            </select></td>
                                    </tr>
                                    <tr>
                                    	<td>Pendidikan Akhir</td>
                                        <td>
                                        	<select name="kd_pendidikan" id="kd_pendidikan" data-placeholder="Pilih Jenjang Pendidikan" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                            <?php foreach($list_pendidikan as $lp) : ?>
                                            	<option value="<?php echo $lp['kd_pendidikan']; ?>"><?php echo $lp['pendidikan']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                </table>
                            </div>
                            </div>
                            <div class="clearfix"><br/></div>
                            <h4 class="widgettitle">Keluarga</h4>
                           
                            <div class="row-fluid">
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	
                                    <tr>
                                    	<td>Nama Ayah</td>
                                        <td><input type="text" name="nm_ayah" id="nm_ayah" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Nama Ibu</td>
                                        <td><input type="text" name="nm_ibu" id="nm_ibu" class="input-large" /></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="span6">
                            	<table class="table table-bordered table-invoice">
                                	<tr>
                                        <td class="width30">Orang yang Dapat Dihubungi</td>
                                        <td class="width70"><input type="text" name="nm_orang" id="nm_orang" class="input-large" /></td>
                                    </tr>
                                    <tr>
                                    	<td>Rincian Penanggung (Hubungan)</td>
                                        <td><input type="text" name="rincian_penanggung" id="rincian_penanggung" class="input-large" /></td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <div class="clearfix">
                            <p><em>	Catatan: * wajib diisi</em></p>
                              <p>&nbsp;</p>
                            </div>
                           
                            	<button class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn">Reset</button>
                          
                        </div>
                        <?php echo form_close();  ?>
                        <!---- END TAMBAH PENDAFTARAN ---->
                        <!---- VIEW REKAM MEDIS STARTS---->
        				<?php if(isset($view_rekam_medis)):?>
                        <div id="rekam-medis">
                        	<h4 class="widgettitle nomargin">Rekam Medis Pasien</h4>
                            <div class="widgetcontent bordered">
                            	<div class="row-fluid">
                                	<div class="span6">
                                    	<table class="table table-bordered table-invoice">
                                            <tbody>
                                                <tr>
                                                    <td width="30%">No. Rekam Medis</td>
                                                    <td width="70%"><?php echo $view_rekam_medis['kd_rekam_medis']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Pasien</td>
                                                    <td><?php echo $view_rekam_medis['nm_lengkap']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>TTL</td>
                                                    <td><?php echo $view_rekam_medis['tempat_lahir'].' / '.$this->functions->format_tgl_cetak2($view_rekam_medis['tanggal_lahir']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Kelamin</td>
                                                    <td><?php echo ucwords(strtolower($view_rekam_medis['jenis_kelamin'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Umur</td>
                                                    <td>
													<?php 
														$hitung = $this->functions->dateDifference($view_rekam_medis['tanggal_lahir'], date('Y-m-d'));
	    												echo $hitung[0].' Tahun '.$hitung[1].' Bulan'; 
													?> 
                                                   	</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="span6">
                                    	<table class="table table-bordered table-invoice">
                                            <tbody>
                                            <!--
                                                <tr>
                                                    <td width="30%">Golongan Darah</td>
                                                    <td width="70%"><?php echo $view_rekam_medis['gol_darah']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Status Marital</td>
                                                    <td><?php echo $view_rekam_medis['status_marital']; ?></td>
                                                </tr>
                                            !-->
                                                <tr>
                                                    <td>Nama Ibu</td>
                                                    <td><?php echo $view_rekam_medis['nm_ibu']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Kode Puskesmas</td>
                                                    <td><?php echo $view_rekam_medis['kd_puskesmas']; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Puskesmas</td>
                                                    <td><?php echo $view_rekam_medis['nm_puskesmas']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- </span6> --> 
                                </div> <!-- </row-fluid> -->
                               <div class="clearfix"><br/></div>
                               <h4 class="widgettitle">Kunjungan Pasien</h4>
                                <div class="row-fluid">
                                	<div class="span12">
                                   		<table class="table table-bordered table-stripped table-hover">
                                        	<thead>
                                            	<tr>
                                                	<th>No.</th>
                                                    <th>Tanggal</th>
                                                    <th>Jenis</th>
                                                    <!--<th>Poli</th>-->
                                                    <th>Dokter</th>
                                                    <th>Anamnesa</th>
                                                    <th>Penyakit</th>
                                                    <th>Tindakan</th>
                                                    <th>Obat</th>
                                                    <!--
                                                    <th>Catatan Fisik</th>
                                                    <th>Catatan Dokter</th>
                                                    -->
                                                 </tr>
                                            </thead>
                                            <tbody>
                                            <?php if(isset($view_trans_pelayanan) && !empty($view_trans_pelayanan)): ?>
                                            	<?php $i=1; foreach($view_trans_pelayanan as $rs): ?>
                                            	<tr>
                                                	<td><?php echo $i; ?></td>
                                                    <td><?php echo $this->functions->convert_date_indo(array("datetime" => $rs['tgl_pelayanan'])); ?></td>
                                                    <td><?php echo $rs['jenis_layanan']; ?></td> 
                                                    <!--<td><?php echo $rs['unit_layanan']; ?></td>-->
                                                    <td><?php echo $rs['dokter']; ?></td>
                                                    <td><?php echo $rs['anamnesa']; ?></td>
                                                    <td><?php echo $rs['kd_icd']; ?> - <?php echo $rs['penyakit']; ?></td>
                                                    <td><?php echo $rs['tindakan']; ?></td>
                                                    <td><?php echo $rs['obat']; ?></td>
                                                    <!--
                                                    <td><?php echo $rs['catatan_fisik']; ?></td>
                                                    <td><?php echo $rs['catatan_dokter']; ?></td>
                                                    -->
                                                </tr>
                                                <?php $i++; ?>
                                            	<?php endforeach; ?>
                                            <?php else: ?>
                                            	<tr>
                                                	<td colspan="11"><center>Tidak ada riwayat kunjungan</center></td>
                                                </tr>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- </widgetcontent> -->
                        </div> <!-- <./rekam medis>
                        <?php endif; ?>
                        <!---- END VIEW REKAM MEDIS ---->
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
			//nik: "required",
			nm_lengkap: "required",
			tempat_lahir: "required",
			tanggal_lahir: "required",
			kd_jenis_kelamin: "required",
			//kd_jenis_pasien: "required",
			//kd_bayar: "required",
			//nm_kk: "required",
			alamat: "required",
			kd_propinsi: "required",
			kd_kota: "required",
			kd_kecamatan: "required",
			kd_kelurahan: "required",
			//kd_agama: "required",
			//kd_gol_darah: "required",
			//kd_pendidikan: "required",
			//kd_pekerjaan: "required",
			//kd_status_marital: "required",
			//nm_ayah: "required",
			//nm_ibu: "required",
			//kd_puskesmas: "required"
			
			
		},
		messages: {
			nik: "NIK harus diisi!",
			nm_lengkap: "Nama lengkap harus diisi!",
			tempat_lahir: "Tempat lahir harus diisi",
			tanggal_lahir: "Tanggal lahir harus diisi!",
			kd_jenis_kelamin: "Pilih jenis kelamin!",
			kd_jenis_pasien: "Pilih jenis pasien!",
			kd_bayar: "Pilih kode bayar!",
			nm_kk: "Nama KK harus diisi!",
			alamat: "Alamat harus diisi!",
			kd_propinsi: "Pilih propinsi!",
			kd_kota: "Pilih kota!",
			kd_kecamatan: "Pilih kecamatan!",
			kd_kelurahan: "Pilih kelurahan!",
			kd_agama: "Pilih agama!",
			kd_gol_darah: "Pilih golongan darah!",
			kd_pendidikan: "Pilih pendidikan!",
			kd_pekerjaan: "Pilih pekerjaan!",
			kd_status_marital: "Pilih status marital!",
			nm_ayah: "Nama ayah kandung harus diisi!",
			nm_ibu: "Nama ibu harus diisi!",
			//kd_puskesmas: "Pilih puskesmas!"
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
			//nik: "required",
			nm_lengkap: "required",
			tempat_lahir: "required",
			tanggal_lahir: "required",
			kd_jenis_kelamin: "required",
			//kd_jenis_pasien: "required",
			//kd_bayar: "required",
			//nm_kk: "required",
			alamat: "required",
			kd_propinsi: "required",
			kd_kota: "required",
			kd_kecamatan: "required",
			kd_kelurahan: "required",
			//kd_agama: "required",
			//kd_gol_darah: "required",
			//kd_pendidikan: "required",
			//kd_pekerjaan: "required",
			//kd_status_marital: "required",
			//nm_ayah: "required",
			//nm_ibu: "required",
			//kd_puskesmas: "required"
		},
		messages: {
			//nik: "NIK harus diisi!",
			nm_lengkap: "Nama lengkap harus diisi!",
			tempat_lahir: "Tempat lahir harus diisi",
			tanggal_lahir: "Tanggal lahir harus diisi!",
			kd_jenis_kelamin: "Pilih jenis kelamin!",
			//kd_jenis_pasien: "Pilih jenis pasien!",
			//kd_bayar: "Pilih kode bayar!",
			//nm_kk: "Nama KK harus diisi!",
			alamat: "Alamat harus diisi!",
			kd_propinsi: "Pilih propinsi!",
			kd_kota: "Pilih kota!",
			kd_kecamatan: "Pilih kecamatan!",
			kd_kelurahan: "Pilih kelurahan!",
			//kd_agama: "Pilih agama!",
			//kd_gol_darah: "Pilih golongan darah!",
			//kd_pendidikan: "Pilih pendidikan!",
			//kd_pekerjaan: "Pilih pekerjaan!",
			//kd_status_marital: "Pilih status marital!",
			//nm_ayah: "Nama ayah kandung harus diisi!",
			//nm_ibu: "Nama ibu harus diisi!",
			//kd_puskesmas: "Pilih puskesmas!"
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
	
	// jQuery Chosen
	jQuery("#kd_propinsi").chosen().change(function(){
		var kd_propinsi = jQuery("#kd_propinsi").val();
		console.log(kd_propinsi);
		jQuery("#kd_kecamatan").html('').trigger("liszt:updated");
		
		var html = '';
		jQuery.ajax({
			type: "POST",
			url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKota'; ?>',
			data: 'kd_propinsi=' + kd_propinsi,
			success: function(data) {
				jQuery('#kd_kota').html(data).trigger("liszt:updated");
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		 });
     });
	 
	 jQuery("#kd_kota").chosen().change(function(){
		var kd_kota = jQuery("#kd_kota").val();
			var html = '';
			jQuery.ajax({
			type: "POST",
				url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKecamatan'; ?>',
				data: 'kd_kota=' + kd_kota,
				success: function(data) {
				jQuery('#kd_kecamatan').html(data).trigger("liszt:updated");
				},  
		   error: function(e){  
				alert('Error: ' + e);  
				}  
		 });
     });
	 
	 jQuery("#kd_kecamatan").chosen().change(function(){
		var kd_kecamatan = jQuery("#kd_kecamatan").val();
			var html = '';
			jQuery.ajax({
			type: "POST",
				url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKelurahan'; ?>',
				data: 'kd_kecamatan=' + kd_kecamatan,
				success: function(data) {
				jQuery('#kd_kelurahan').html(data).trigger("liszt:updated");
				},  
		   error: function(e){  
				alert('Error: ' + e);  
				}  
		 });
     });
	 
	 jQuery("#kd_propinsi2").chosen().change(function(){
		var kd_propinsi = jQuery("#kd_propinsi2").val();
		console.log(kd_propinsi);
		jQuery("#kd_kecamatan2").html('').trigger("liszt:updated");
		
		var html = '';
		jQuery.ajax({
			type: "POST",
			url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKota'; ?>',
			data: 'kd_propinsi=' + kd_propinsi,
			success: function(data) {
				jQuery('#kd_kota2').html(data).trigger("liszt:updated");
			},  
		   	error: function(e){  
				alert('Error: ' + e);  
			}  
		 });
     });
	 
	 jQuery("#kd_kota2").chosen().change(function(){
		var kd_kota = jQuery("#kd_kota2").val();
		console.log(kd_propinsi);
			var html = '';
			jQuery.ajax({
				type: "POST",
				url: '<?php echo base_url().'cont_transaksi_pendaftaran/getKecamatan'; ?>',
				data: 'kd_kota=' + kd_kota,
				success: function(data) {
					jQuery('#kd_kecamatan2').html(data).trigger("liszt:updated");
				},  
		   error: function(e){  
				alert('Error: ' + e);  
			}  
		 });
     });
	 
	 jQuery("#tanggal_lahir").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "-150:+0",
		dayNamesMin: ['M', 'S', 'S', 'R', 'K', 'J', 'S'],
		monthNamesShort: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
	});
	
	jQuery("#tanggal_lahir2").datepicker({ 
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "-150:+0",
		dayNamesMin: ['M', 'S', 'S', 'R', 'K', 'J', 'S'],
		monthNamesShort: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ],
	});
	
});

</script>