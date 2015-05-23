<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Master Transaksi</a> <span class="divider">/</span></li>
            <li><a href="#">Transaksi Pembayaran</a> <span class="divider"></span></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman Transaksi Pembayaran</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner">
        	<div class="row-fluid">
			<div class="span12">
					<div id="tabs">
  	 				
						<ul>
							<?php if(isset($edit_bayar_tindakan)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Transaksi Pembayaran</a></li>
            				<?php endif;?>
							
                        	<?php if(isset($pembayaran_tindakan)):?>
            				<li class=""><a href="#tambah"><i class="icon-edit"></i> Transaksi Pembayaran</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($pembayaran_tindakan))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Pembayaran</a></li>
                        </ul>
						<!---- EDITING TRANSAKSI TINDAKAN ---->
						<?php if(isset($edit_bayar_tindakan)):?>
                        <div id="ubah">
						<h4 class="widgettitle">Transaksi Pembayaran</h4>
						<div class="row-fluid">
						<?php foreach ($edit_bayar_tindakan as $row): ?>
                        <?php echo form_open('admin/c_bayar_tindakan/ubah/do_update/'.$row['kd_bayar'], array('class' => 'stdform stdform2', 'id' => 'form')); ?>
                                
						<div class="span6">
						<form id="form">
						  <table class="table table-bordered table-invoice">
							<tr>
								  <td class="width30">Kode Pembayaran</td>
								  <td class="width70"><input type="text" id="kodebayar" name="kodebayar" value="<?php echo $row['kd_bayar']; ?>" style="width:100px; font-size: 13px; " readonly></td>
							  </tr>
							  <tr>
								<td>Tgl Transaksi</td>
								<td><strong><input type="text" name="tglbayar"  id="tgl_bayar" value="<?php echo $this->m_crud->tgl_sql($row['tgl_bayar']); ?>"  style="width:100px; font-size: 13px; " /></strong></td>
							</tr>
								
							
									
						  </table>
						  </div>
						  <div class="span6">
						   <table class="table table-bordered table-invoice">
							<tr>
								<td>Kode Layanan</td>
								<td><strong><input type="text" name="nopelayanan"  id="nopelayanan" value="<?php echo $nopelayanan; ?>"  style="width:100px; font-size: 13px; " readonly/></strong></td>
							</tr>
							
							
							<tr>
								<td>Nama Pasien</td>
								<td><input type="text" name="bio_nama" id="bio_nama" style="width:300px; font-size: 13px; " value="<?php echo $bio_nama; ?>" placeholder="Nama Pasien..." readonly>
								</td>
							  </tr>
							</table>
						  </div>
						    
						</div><!--row-fluid-->
						<div class="clearfix"><br /></div>
						<button type="button" name="list_tind" id="list_tind" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> Panggil Tindakan</button>
						
                <div class="widgetcontent">
               
						<div class="row-fluid">
						
						<div class="span6">
									
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Produk</td>
								  <td class="width70">
									<input type="text" style="width:100px; font-size: 15px; " name="kd_produk" id="kd_produk" value="" placeholder="..." />
								 </tr>
							  <tr>
								<td>Nama Produk</td>
								<td><input type="text" name="produk" id="produk" style="width:300px; font-size: 15px; " value="" placeholder="..." readonly>
								</td>
							  </tr>
							 <tr>
								  <td>Harga Rp.</td>
								  <td><input type="text" name="harga" id="harga" style="width:100px; font-size: 15px; " value="" placeholder="..." readonly ></td>
							 </tr>
							 <tr>
								  <td>QTY</td>
								  <td><input type="text" name="jml" id="jml" style="width:60px; font-size: 20px; " value="" placeholder="..."></td>
							</tr>
							<tr>
								<td>Total</td>
								<td>
									<strong><input type="text" name="total" id="total" style="width:100px; font-size: 15px; " placeholder="0" readonly /></strong>
									<button type="button"  name="simpan" id="simpan" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Go</button>
								</td>
							</tr>	
							
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
							<tr>
								<td class="width30">Kode Obat</td>
								<td class="width70">
								<input type="text" style="width:100px; font-size: 15px; " name="kd_obat" id="kd_obat" value="" placeholder="..." />
								<button type="button" name="list_obat" id="list_obat" class="btn btn-danger btn-small" title="Cari Obat"><i class="icon-list-alt icon-white"></i> Obat</button>
							</tr>
							<tr>
								<td>Nama Obat</td>
								<td><input type="text" name="nama_obat" id="nama_obat" style="width:300px; font-size: 15px; " value="" placeholder="..." readonly></td>
							</tr>
							<tr>
								<td>Harga Rp.</td>
								<td><input type="text" name="harga_obat" id="harga_obat" style="width:100px; font-size: 15px; " value="" placeholder=" ..." readonly ></td>
							</tr>
							<tr>
								<td>QTY</td>
								<td><input type="text" name="jml_obat" id="jml_obat" style="width:60px; font-size: 20px; " value="" placeholder="..."></td>
							</tr>
							<tr>
								<td>Total</td>
								<td><strong><input type="text" name="total_obat" id="total_obat"  style="width:100px; font-size: 15px; " placeholder="0" readonly  /></strong>
									<button type="button"  name="simpan_obat" id="simpan_obat" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Go</button>
								</td>
							</tr>
						</table>
						</div><!--span6-->
						</div><!--row-fluid-->
                </div><!--widgetcontent-->	
						<table width="100%">
						<tr>
						<td align="center">
							<button type="button" class="btn-success btn-small" href="#myModal" data-toggle="modal"><i class="icon-ok-circle icon-white"></i> Bayar & Cetak</button>
							<a href="<?php echo base_url(); ?>c_bayar_tindakan/bayar_tindakan"> 
							<button class="btn-primary btn-small" title="Perbarui Data"><i class="icon-ok-circle icon-white"></i> Baru !</button></a> 
							<a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan_today">
							<button type="button" class="btn btn-inverse"><i class="icon-off icon-white"></i> Tutup</button></a>
						</td>
                        </tr>
						</table>
						
						<div class="clearfix"><br /></div>
                        
					<div class="row-fluid">
						<!--<div class="span6">
						  <table class="table table-bordered table-invoice">
							<tr>
								<td>BAYAR</td>
								<td><input type="text" name="bayar" id="bayar" style="width:150px; font-size: 20px; "  value="" placeholder="..."></td>
							</tr>
						  </table>
						</div>
						<div class="span6">
							<table class="table table-bordered table-invoice">
							<tr>
								<td>KEMBALIAN</td>
								<td><input type="text" name="kembalian" id="kembalian" style="width:150px; font-size: 20px; " value="" placeholder="..."></td>
							</tr>
							</table>
						</div>-->
					</div>	
						
						<div class="clearfix"><br /> </div>
							<div id="tampil_data"></div>
							<div id="DataBarang" title="Data Barang">
							Cari Kata <input type="text" id="caritindakan" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarbarang"></div>
							</div>
							
							<div id="DataObat" title="Data Obat">
							Cari Kata <input type="text" id="cariobat" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutupobat" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarobat"></div>
							</div>
                            
                            <div id="DataBayarTindakan" title="Data Bayar Tindakan">
							Pilih Tindakan dibawah ini :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<button type="button" name="tutup2" id="tutup2" class="btn btn-small btn-danger"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftartind"></div>
							</div>
                            
			<!--///////////////////* MODAL *///////////////////////////////////////////////////////////-->		
							<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
							<div class="modal-header">
							  <h3 id="myModalLabel">Masukan Jumlah Pembayaran !</h3>
							</div>
							<div class="modal-body">
							<table class="table table-bordered table-invoice">	
							  <tr>
								<td>BAYAR</td>
								<td>
								     <input type="text" name="bayar" id="bayar" style="width:150px; font-size: 20px; "  value="" placeholder="...">
								     
								</td>
							</tr>
							<tr>
								<td>KEMBALIAN</td>
								<td><input type="text" name="kembalian" id="kembalian" style="width:150px; font-size: 20px; " value="" placeholder="..."></td>
							</tr>
							</table>
							</div>
							<div class="modal-footer">
							  <button type="button"  name="simpan_bayar" id="simpan_bayar" class="btn btn-primary"><i class="icon-ok-circle icon-white"></i> Simpan</button>
							  <button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-print icon-white"></i> Cetak</button>
							  <button data-dismiss="modal" class="btn btn-inverse"><i class="icon-off icon-white"></i> Tutup</button>
							</div>
						</div><!--#myModal-->
							
						<?php echo form_close(); ?>
                            <?php endforeach; ?>
						</div>		
                       	<?php endif;?>
						</form>
						<!---- END EDITING FORM ---->
						
						<!---- DAFTAR OBAT START ---->
   						<div id="list">
                        	<a href="<?php echo base_url(); ?>c_bayar_tindakan/bayar_tindakan/tambah"> 
							<button class="btn btn-warning btn-rounded" title="Tambah Stok Obat"><i class="icon-plus icon-white"></i> Tambah </button></a> 
							<a href="<?php echo base_url(); ?>c_bayar_tindakan/bayar_tindakan"> 
							<button class="btn btn-success btn-rounded" title="Perbarui Data"><i class="icon-refresh icon-white"></i> Refresh </button></a> 
							
							<div class="clearfix"><br /></div>
							<table class="table table-bordered" id="dyntable">
                    		<colgroup>
                        		<col class="con0" style="align: center; width: 4%" />
                        		<col class="con1" style="align: center; width: 4%"  />
                        		<col class="con0" />
                        		<col class="con1" />
                                <col class="con0" />
                        		<col class="con1" />
								<col class="con0" />
								<col class="con1" />
								<col class="con0" />
							</colgroup>
                    		<thead>
                                <tr>
                                    <th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                                    <th class="head1 center">No</th>
                                    <th class="head0 center" >Kode Transaksi</th>
                                    <th class="head1 center">Tanggal</th>
                                    <th class="head0 center">NIK</th>
                                    <th class="head1 center">Pasien</th>
                                    <th class="head0 center">Item</th>
                                    <th class="head1 center">Jumlah</th>
                                    <th class="head0 center">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php 
							$no=1;
							foreach ($bayar_tindakan as $r):
							$item = $this->m_crud->ItemTindakan($r['kd_bayar']);
							$jmlBayarTindakan = $this->m_crud->JmlTindakan($r['kd_bayar']);
							?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
	                                    <td class="center"><?php echo $no; ?></td>
	                                    <td class="center" width="13%"><?php echo $r['kd_bayar']; ?></td>
	                                    <td class="center" width="10%"><?php echo $this->m_crud->tgl_sql($r['tgl_bayar']); ?></td>
	                                    <td class="center"><?php echo $r['nik']; ?></td>
	                                    <td class="center"><?php echo $r['nama_pasien']; ?></td>
	                                    <td class="center"><?php echo $item; ?></td>
										<td class="center" width="10%"><?php echo number_format($jmlBayarTindakan); ?></td>
									<td class="center" width="15%">
                                    	<a href="<?php echo base_url(); ?>c_bayar_tindakan/bayar_tindakan/ubah/<?php echo $r['kd_bayar']; ?>" class="btn btn-primary btn-circle" title="Edit"><i class="iconsweets-create iconsweets-white"></i></a>
                                        <a href="<?php echo base_url(); ?>c_bayar_tindakan/bayar_tindakan/hapus/<?php echo $r['kd_bayar']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php 
							  $no++;
							  endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR OBAT---->
						 
						 
            		    <!---- TRANSAKSI TINDAKAN ---->
						<?php if(isset($pembayaran_tindakan)):?>
                        <div id="tambah">
						
						<h4 class="widgettitle">Transaksi Pembayaran</h4>
						<div class="row-fluid">
						
						<div class="span6">
						<form id="form">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Pembayaran</td>
								  <td class="width70"><input type="text" id="kodebayar" name="kodebayar" value="<?php echo $kodebayar; ?>" style="width:100px; font-size: 13px; " readonly></td>
							  </tr>
							  <tr>
								<td>Tgl Transaksi</td>
								<td><strong><input type="text" name="tglbayar"  id="tgl_bayar" value="<?php echo $tgl_bayar; ?>"  style="width:100px; font-size: 13px; " /></strong></td>
							</tr>
									
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
							<tr>
								<td>Kode Layanan</td>
								<td><strong><input type="text" name="nopelayanan"  id="nopelayanan" value="<?php echo $nopelayanan; ?>"  style="width:100px; font-size: 13px; " readonly/></strong></td>
							</tr>
							
							
							<tr>
								<td>Nama Pasien</td>
								<td><input type="text" name="bio_nama" id="bio_nama" style="width:300px; font-size: 13px; " value="<?php echo $bio_nama; ?>" placeholder="Nama Pasien..." readonly>
								</td>
							  </tr>
							</table>
						</div><!--span6-->
						</div><!--row-fluid-->
						<div class="clearfix"><br /></div>
						<button type="button" name="list_tind" id="list_tind" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> Panggil Tindakan</button>
						
                <div class="widgetcontent">
                	<div class="row-fluid">
						
						<div class="span6">
						  <table class="table table-bordered table-invoice">
							 <tr>
								<td class="width30">Kode Produk</td>
								<td class="width70">
								<input type="text" style="width:100px; font-size: 15px; " name="kd_produk" id="kd_produk" value="<?php echo $kd_produk; ?>" placeholder="..." />
								<button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Tindakan"><i class="icon-list-alt icon-white"></i> Tindakan</button>
							</tr>
							<tr>
								<td>Nama Produk</td>
								<td><input type="text" name="produk" id="produk" style="width:300px; font-size: 15px; " value="<?php echo $produk; ?>" placeholder="..." readonly></td>
							</tr>
							<tr>
								<td>Harga Rp.</td>
								<td><input type="text" name="harga" id="harga" style="width:100px; font-size: 15px; " value="" placeholder=" ..." readonly ></td>
							</tr>
							<tr>
								<td>QTY</td>
								<td><input type="text" name="jml" id="jml" style="width:60px; font-size: 20px; " value="<?php echo $jml; ?>" placeholder="..."></td>
							</tr>
							<tr>
								<td>Total</td>
								<td><strong><input type="text" name="total" id="total"  style="width:100px; font-size: 15px; " placeholder="0" readonly  /></strong>
								    <button type="button"  name="simpan" id="simpan" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Go</button>
								</td>
							</tr>
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
							<tr>
								<td class="width30">Kode Obat</td>
								<td class="width70">
								<input type="text" style="width:100px; font-size: 15px; " name="kd_obat" id="kd_obat" value="<?php echo $kd_obat; ?>" placeholder="..." />
							<button type="button" name="list_obat" id="list_obat" class="btn btn-danger btn-small" title="Cari Obat"><i class="icon-list-alt icon-white"></i> Obat</button>
							
							</tr>
							<tr>
								<td>Nama Obat</td>
								<td><input type="text" name="nama_obat" id="nama_obat" style="width:300px; font-size: 15px; " value="<?php echo $nama_obat; ?>" placeholder="..." readonly></td>
							</tr>
							<tr>
								<td>Harga Rp.</td>
								<td><input type="text" name="harga_obat" id="harga_obat" style="width:100px; font-size: 15px; " value="" placeholder=" ..." readonly ></td>
							</tr>
							<tr>
								<td>QTY</td>
								<td><input type="text" name="jml_obat" id="jml_obat" style="width:60px; font-size: 20px; " value="<?php echo $jml_obat; ?>" placeholder="..."></td>
							</tr>
							<tr>
								<td>Total</td>
								<td><strong><input type="text" name="total_obat" id="total_obat"  style="width:100px; font-size: 15px; " placeholder="0" readonly  /></strong>
									<button type="button"  name="simpan_obat" id="simpan_obat" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Go</button>
								</td>
							</tr>
						</table>
						</div><!--span6-->
						</div><!--row-fluid-->
                </div><!--widgetcontent-->	
							
						<table width="100%">
						<tr>
							<td align="center">
								<button type="button" class="btn-success btn-small" href="#myModal" data-toggle="modal"><i class="icon-ok-circle icon-white"></i> Bayar & Cetak</button>
								<a href="<?php echo base_url(); ?>c_bayar_tindakan/bayar_tindakan"> 
									<button class="btn-primary btn-small" title="Perbarui Data"><i class="icon-ok-circle icon-white"></i> Baru !</button></a> 
								<a href="<?php echo base_url(); ?>cont_transaksi_pelayanan/pelayanan_today">
									<button type="button" class="btn btn-inverse"><i class="icon-off icon-white"></i> Tutup</button>
								</a>
							</td>
                        </tr>
						</table>
						<div class="clearfix"><br /></div>
				<div class="row-fluid">
					
				</div>	
						<div class="clearfix"><br /> </div>
							<div id="tampil_data"></div>
							<div id="DataBarang" title="Data Barang">
							Cari Kata <input type="text" id="caritindakan" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarbarang"></div>
							</div>
							
							
							<div id="DataObat" title="Data Obat">
							Cari Kata <input type="text" id="cariobat" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutupobat" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarobat"></div>
							</div>
							<div id="DataBayarTindakan" title="Data Bayar Tindakan">
							Pilih Tindakan dibawah ini :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<button type="button" name="tutup2" id="tutup2" class="btn btn-small btn-danger"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftartind"></div>
							</div>
							
					<!--///////////////////* MODAL *///////////////////////////////////////////////////////////-->		
							<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
							<div class="modal-header">
							  <h3 id="myModalLabel">Masukan Jumlah Pembayaran !</h3>
							</div>
							<div class="modal-body">
							<table class="table table-bordered table-invoice">	
							  <tr>
								<td>BAYAR</td>
								<td>
								     <input type="text" name="bayar" id="bayar" style="width:150px; font-size: 20px; "  value="" placeholder="...">
								     
								</td>
							</tr>
							<tr>
								<td>KEMBALIAN</td>
								<td><input type="text" name="kembalian" id="kembalian" style="width:150px; font-size: 20px; " value="" placeholder="..."></td>
							</tr>
							</table>
							</div>
							<div class="modal-footer">
							  <button type="button"  name="simpan_bayar" id="simpan_bayar" class="btn btn-primary"><i class="icon-ok-circle icon-white"></i> Simpan</button>
							  <button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-print icon-white"></i> Cetak</button>
							  <button data-dismiss="modal" class="btn btn-inverse"><i class="icon-off icon-white"></i> Tutup</button>
							</div>
						</div><!--#myModal-->
							
						</form>
						<!---- END TRANSAKSI PEMBAYARAN OBAT ----> 
						</div><?php endif;?></div><!--tabs-->
					
					</div><!--span12-->
                 </div><!--row-fluid-->
			
        </div><!--contentinner-->
    </div><!--maincontent-->
</div><!--mainright-->

<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function(){

	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
		$("#nopelayanan").val('<?php echo $this->uri->segment(5); ?>');
		CariKodePelayananPasien()
	});	
	
/////////////// LOAD DATATABLE //////////////////////////
// dynamic table
	if(jQuery('#dyntable').length > 0) {
		jQuery('#dyntable').dataTable({
			"sPaginationType": "full_numbers",
			"aaSortingFixed": [[0,'asc']],
			"fnDrawCallback": function(oSettings) {
				jQuery.uniform.update();
			}
		});
	}

// Cari pasien berdasar no. transaksi pelayanan
	$("#nopelayanan").autocomplete({
		source: function(request,response) {
			$.ajax({ 
				url: "<?php echo site_url('ref_json/ListPasienbyPelayanan'); ?>",
				data: { plyn: $("#nopelayanan").val()},
				dataType: "json",
				type: "POST",
				success: function(data){
					response(data);
				}    
			});
		},
	});
	
	
	function CariKodePelayananPasien(){
		var plyn = $("#nopelayanan").val();
		  $.ajax({ 
			  url	: "<?php echo site_url('ref_json/CariPelayananPasien'); ?>",
			  data	: "plyn="+plyn,
			  cache	: false,
			  dataType: "json",
			  type	: "POST",
			  success: function(data){
				  $("#nik").val(data.nik);
				  $("#bio_nama").val(data.nm_lengkap);
			}    
		  });
	}
	
	$("#nopelayanan").focus();
	$("#nopelayanan").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	
	
	$("#nopelayanan").keyup(function(){
		CariKodePelayananPasien();
		
	});
		

/////////////////////* SCRIPT PENCARIAN KODE BARANG *//////////////////////////////////	
	
	
	$("#kd_produk").autocomplete({
		source: function(request,response) {
			$.ajax({ 
				url: "<?php echo site_url('ref_json/ListTindakan'); ?>",
				data: { kode: $("#kd_produk").val()},
				dataType: "json",
				type: "POST",
				success: function(data){
					response(data);
				}    
			});
		},
	});
	
	
	function CariKodeBarang(){
		var kode = $("#kd_produk").val();
		  $.ajax({ 
			  url	: "<?php echo site_url('ref_json/CariTindakan'); ?>",
			  data	: "kode="+kode,
			  cache	: false,
			  dataType: "json",
			  type	: "POST",
			  success: function(data){
				  $("#produk").val(data.produk);
				  $("#harga").val(data.harga);
				  
			  }    
		  });
	}
	
	$("#kd_produk").focus();
	$("#kd_produk").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#kd_produk").focus(function(e){
		var isi = $(e.target).val();
		CariKodeBarang();
		$("#jml").val('');
		$("#total").val('');
		//$("#jml").focus();
	});
	
	$("#kd_produk").keyup(function(){
		CariKodeBarang();
		
	});
	
	detailBarang();
	DataBarang();
	DataPasien();
	DataObat();
	
	function detailBarang(){
		var kode = $("#kodebayar").val();
		var string = "kode="+kode;
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_bayar_tindakan/DataDetailTindakan",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				
			}
		});
		
	}
			
////////////////////////////////* HITUNG JUMLAH TINDAKAN */////////////////////////////////
	var sum = 0;
	function hitung(){
		var jml = $("#jml").val();
		var hrg = $("#harga").val();
		var harga = hrg.replace(",","");
		if(jml.length>0  && harga.length>0){ 
			var total = parseInt(jml)*parseInt(harga);
			//var total = total.toCurrency();
			$("#total").val(total);
			
			/*sum += parseFloat($("#tbeli").val());
			console.log(sum);
			$("#g_total").val(sum); */
			
		}else{
			$("#total").val(0);
		}
			
	}
	$("#jml").keyup(function(){
		hitung();
	});
	$("#harga").keyup(function(){
		hitung();
	});
	
	
////////////////////////////////* HITUNG JUMLAH OBAT */////////////////////////////////
	var sum = 0;
	function hitung_obat(){
		var jml_obat = $("#jml_obat").val();
		var hrg_obat = $("#harga_obat").val();
		var harga_obat = hrg_obat.replace(",","");
		if(jml_obat.length>0  && harga_obat.length>0){ 
			var total_obat = parseInt(jml_obat)*parseInt(harga_obat);
			$("#total_obat").val(total_obat);
			
		}else{
			$("#total_obat").val(0);
		}
			
	}
	$("#jml_obat").keyup(function(){
		hitung_obat();
	});
	$("#harga_obat").keyup(function(){
		hitung_obat();
	});

////////////////////////////////* HITUNG KEMBALIAN */////////////////////////////////
	function hitung_kembalian(){
		var bayar 		= $("#bayar").val();
		var ttl 		= $("#tbayar").val();
		var tbayar		= ttl.replace(",","");
		
		
		if(bayar.length>0  && tbayar.length>0){ 
			var kembalian = parseInt(bayar)-parseInt(tbayar);
			$("#kembalian").val(kembalian);
		}else{
			$("#kembalian").val(0);
		}
			
	}
	$("#bayar").keyup(function(){
		hitung_kembalian();
	});
	$("#tbayar").keyup(function(){
		hitung_kembalian();
	});		


//////////////////////////* SCRIPT OPEN DIALOGUE  BARANG *////////////////////////////
function DataBarang(){
		var caritindakan = $("#caritindakan").val();
		var string = "caritindakan="+caritindakan;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/Datatindakan",
			data	: string,
			cache	: false,
			success	: function(data){
				//console.log(data);
				$("#daftarbarang").html(data);
			}
		});
	}
	

	$("#DataBarang").dialog({
      autoOpen: false,
	  height:400,
	  width:700,
      show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "explode",
        duration: 700
      }
    }); 	
	
	
	
	$("#list_barang").click(function() {
      $("#DataBarang").dialog("open");
    });
	$("#tutup").click(function() {
      $("#DataBarang").dialog("close");
    });
	
	$("#caritindakan").keyup(function(){
		DataBarang();
	});
	
//////////////////////////* SCRIPT OPEN DIALOGUE  OBAT *////////////////////////////
function DataObat(){
		var cariobat = $("#cariobat").val();
		var string = "cariobat="+cariobat;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/DataObat",
			data	: string,
			cache	: false,
			success	: function(data){
				//console.log(data);
				$("#daftarobat").html(data);
			}
		});
	}
	

	$("#DataObat").dialog({
      autoOpen: false,
	  height:400,
	  width:700,
      show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "explode",
        duration: 700
      }
    }); 	
	
	
	
	$("#list_obat").click(function() {
      $("#DataObat").dialog("open");
    });
	$("#tutupobat").click(function() {
      $("#DataObat").dialog("close");
    });
	
	$("#cariobat").keyup(function(){
		DataObat();
	});
	
////////////////* CARI OBAT *//////////////////////
	
	$("#kd_obat").autocomplete({
		source: function(request,response) {
			$.ajax({ 
				url: "<?php echo site_url('ref_json/ListBarang'); ?>",
				data: { kode: $("#kd_obat").val()},
				dataType: "json",
				type: "POST",
				success: function(data){
					response(data);
				}    
			});
		},
	});
	
	function CariKodeObat(){
		var kodeobat = $("#kd_obat").val();
		  $.ajax({ 
			  url	: "<?php echo site_url('ref_json/CariObat'); ?>",
			  data	: "kodeobat="+kodeobat,
			  cache	: false,
			  dataType: "json",
			  type	: "POST",
			  success: function(data){
				  $("#nama_obat").val(data.nama_obat);
				  $("#harga_obat").val(data.harga_obat); 
			  }    		
		  });
	}
	
	$("#kd_obat").focus();
	$("#kd_obat").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#kd_obat").focus(function(e){
		var isi = $(e.target).val();
		CariKodeObat();
	});
	
	$("#kd_obat").keyup(function(){
		CariKodeObat();
		
	});
	
//////////////////////////* SCRIPT OPEN DIALOGUE  PASIEN *////////////////////////////
	function DataPasien(){
		var caripasien = $("#caripasien").val();
		var string = "caripasien="+caripasien;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/DataPasien",
			data	: string,
			cache	: false,
			success	: function(data){
				//console.log(data);
				$("#daftarpasien").html(data);
			}
		});
	}
	

	$("#DataPasien").dialog({
      autoOpen: false,
	  height:400,
	  width:1000,
      show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "explode",
        duration: 700
      }
    }); 	
	
	
	
	$("#list_pasien").click(function() {
      $("#DataPasien").dialog("open");
    });
	$("#tutuppasien").click(function() {
      $("#DataPasien").dialog("close");
    });
	
	$("#caripasien").keyup(function(){
		DataPasien();
	});
	
////////////////* CARI PASIEN *//////////////////////
	
	$("#nik").autocomplete({
		source: function(request,response) {
			$.ajax({ 
				url: "<?php echo site_url('ref_json/ListPasien'); ?>",
				data: { kodenik: $("#nik").val()},
				dataType: "json",
				type: "POST",
				success: function(data){
					response(data);
				}    
			});
		},
	});
	
	
	function CariKodePasien(){
		var kodenik = $("#nik").val();
		  $.ajax({ 
			  url	: "<?php echo site_url('ref_json/CariPasien'); ?>",
			  data	: "kodenik="+kodenik,
			  cache	: false,
			  dataType: "json",
			  type	: "POST",
			  success: function(data){
				  $("#bio_nama").val(data.bio_nama);
				  $("#bio_tgl_lahir").val(data.bio_tgl_lahir);
			  }    
		  });
	}
	
	$("#nik").focus();
	$("#nik").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	$("#nik").focus(function(e){
		var isi = $(e.target).val();
		CariKodePasien();
	});
	
	$("#nik").keyup(function(){
		CariKodePasien();
		
	});
	

	
/////////////////////////* SIMPAN TINDAKAN *////////////////////////////
	$("#simpan").click(function(){
	
	var string = $("#form").serialize();
	
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_bayar_tindakan/simpan_tindakan",
			data	: string,
			cache	: false,
			success	: function(data){
				detailBarang();
				$("#kd_produk").val('');
				$("#produk").val('');
				$("#jml").val('');
				$("#harga").val('');
				$("#total").val('0');
						
				$("#kd_produk").focus();
			}
		});
		
		return false();		
	});
	
	
	$("#baru").click(function(){
		$("#kd_produk").val('');
		$("#produk").val('');
		$("#jml").val('');
		$("#harga").val('');
		$("#total").val('0');
				
		$("#kd_produk").focus();
		
	});
	
	$("#cetak").click(function(){
		var kode	= $("#kodebayar").val();
		window.open('<?php echo site_url();?>c_bayar_tindakan/cetak/'+kode);
		return false();
	});
	
/////////////////////////* SIMPAN OBAT *////////////////////////////
	$("#simpan_obat").click(function(){
	
		//var kode	= $("#kd_produk").val();
		//var nama	= $("#produk").val();
		var pasien	= $("#nik").val();
		
		var string = $("#form").serialize();
		
		/*if(kode.length==0){
			$("#kd_produk").focus();
			return false();
		}
		/*if(nama.length==0){
			$("#kd_produk").focus();
			return false();
		}*/
		
		if(pasien.length==0){
			$("#nik").focus();
			return false();
		}
		
		
			
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_bayar_tindakan/simpan_obat",
			data	: string,
			cache	: false,
			success	: function(data){
				detailBarang();
				$("#kd_obat").val('');
				$("#nama_obat").val('');
				$("#jml_obat").val('');
				$("#harga_obat").val('');
				$("#total_obat").val('0');
						
				$("#kd_obat").focus();
			}
		});
		
		return false();		
	});
	
	
////////////////////    Call Tindakan      //////////////////////////////////////////////////

	function DataBayarTindakan(){
		var s = $("#nopelayanan").val();
		var t = $("#kodebayar").val();
		var u = $("#tgl_bayar").val();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/DataBayarTindakan",
			data	: {s:s, t:t, u:u},
			cache	: false,
			success	: function(data){
				$("#daftartind").html(data);
			}
		});
	}
	

	$("#DataBayarTindakan").dialog({
      autoOpen: false,
	  height:400,
	  width:1000,
      show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "explode",
        duration: 500
      }
    }); 	
	
	$("#list_tind").click(function() {
      $("#DataBayarTindakan").dialog("open");
    });
	$("#tutup2").click(function() {
      $("#DataBayarTindakan").dialog("close");
    });
	
	$("#caritind").keyup(function(){
		DataBayarTindakan();
	});
	
	//detailResep();
	DataBayarTindakan();


/////////////////////////* SIMPAN TINDAKAN *////////////////////////////
	$("#simpan_bayar").click(function(){
	
		
		var string = $("#form").serialize();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_bayar_tindakan/simpan_bayar",
			data	: string,
			cache	: false,
			success	: function(data){
				detailBarang();
					
			}
		});
		
		return false();		
	});
	
});	
	
	
	
</script>
<style type="text/css">
#DataBarang {
	font-size:12px;
}
#DataPasien {
	font-size:12px;
}
#DataObat {
	font-size:12px;
}
</style>