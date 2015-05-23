<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Master Transaksi</a> <span class="divider">/</span></li>
            <li><a href="#">Transaksi Obat</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman Transaksi Pembayaran OBAT</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner">
        	<div class="row-fluid">
			<div class="span12">
					<div id="tabs">
  	 				
						<ul>
							<?php if(isset($edit_bayar_obat)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Transaksi Obat</a></li>
            				<?php endif;?>
							
                        	<?php if(isset($pembayaran_obat)):?>
            				<li class=""><a href="#tambah"><i class="icon-edit"></i> Transaksi Pembayaran Obat</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($pembayaran_obat))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Pembayaran Obat</a></li>
                        </ul>
						<!---- EDITING TRANSAKSI BAYAR OBAT ---->
						<?php if(isset($edit_bayar_obat)):?>
                        <div id="ubah">
						<h4 class="widgettitle">Transaksi Pembayaran Obat</h4>
						<div class="row-fluid">
						<?php foreach ($edit_bayar_obat as $row): ?>
                        <?php echo form_open('admin/c_bayar_obat/ubah/do_update/'.$row['kd_bayar'], array('class' => 'stdform stdform2', 'id' => 'form')); ?>
                        
						<div class="span6">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Transaksi</td>
								  <td class="width70"><input type="text" id="kodebayar" name="kodebayar" value="<?php echo $row['kd_bayar']; ?>"  style="width:100px; font-size: 13px; " readonly></td>
							  </tr>
							  <tr>
								<td>Tgl Transaksi</td>
								<td><strong><input type="text" name="tglbayar"  id="tgl_bayar" value="<?php echo $row['tgl_bayar']; ?>"  style="width:100px; font-size: 13px; "  /></strong></td>
							</tr>
									
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">NIK</td>
								  <td class="width70">
									<input type="text" style="width:150px; font-size: 13px; " name="nik" id="nik" value="<?php echo $row['nik']; ?>" placeholder="Produk..." />
								  <button type="button" name="list_pasien" id="list_pasien" class="btn btn-danger btn-small" title="Cari Pasien"><i class="icon-list-alt icon-white"></i></button>
								</tr>
							<tr>
								<td>Nama Pasien</td>
								<td><input type="text" name="bio_nama" id="bio_nama" style="width:300px; font-size: 13px; " value="<?php echo $row['nama_pasien']; ?>" placeholder="Nama Pasien..." readonly>
								</td>
							  </tr>
						  </table>
						</div><!--span6-->
						</div><!--row-fluid-->
						<div class="clearfix"><br /></div>
					<button type="button" name="baru" id="baru" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> Tambah Obat</button>
							
                <div class="widgetcontent">
                <div class="row-fluid">
						
						<div class="span6">
									
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Obat</td>
								  <td class="width70">
									<input type="text" style="width:100px; font-size: 15px; " name="kd_obat" id="kd_obat" value="" placeholder="..." />
								  <button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Barang"><i class="icon-list-alt icon-white"></i></button>
								</tr>
							  <tr>
								<td>Nama Obat</td>
								<td><input type="text" name="nama_obat" id="nama_obat" style="width:300px; font-size: 15px; " value="" placeholder="..." readonly>
								</td>
							  </tr>
							 <tr>
								  <td>Harga Jual</td>
								  <td><input type="text" name="harga_jual" id="harga_jual" style="width:100px; font-size: 15px; " value="" placeholder="..." readonly ></td>
							</tr>
						</table>
						  </div>
						<div class="span6">
						   <table class="table table-bordered table-invoice">
								<tr>
								  <td>Satuan</td>
								  <td>
								  <span class="field">
                                            <select name="sat_kecil_obat" id="sat_kecil_obat" data-placeholder="Pilih Satuan..." style="width:230px;" class="chzn-select" tabindex="2" required>
                                            <option value=""></option>
                                            <?php foreach($list_satuan_kecil as $lsko) : ?>
                                            	<option value="<?php echo $lsko['sat_kecil_obat']; ?>"><?php echo $lsko['sat_kecil_obat']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                  </span>
								  </td>
								</tr> 
								<tr>
								  <td>QTY</td>
								  <td><input type="text" name="jml" id="jml" style="width:60px; font-size: 15px; "  value="" placeholder="..."></td>
								</tr>
								<tr>
									<td>Total</td>
									<td><strong><input type="text" name="total" id="total" style="width:100px; font-size: 15px; " value="" placeholder="..." readonly /></strong></td>
								</tr>
						</table>
						</div><!--span6-->
						</div><!--row-fluid-->
                </div><!--widgetcontent-->	
						
				<table width="100%">
						<tr>
							<td align="center">
									<button type="button"  name="simpan" id="simpan" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Simpan</button>
									<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-print icon-white"></i> Cetak</button>
								<a href="<?php echo base_url(); ?>admin/laporan">
									<button type="button" class="btn btn-inverse"><i class="icon-off icon-white"></i> Selesai</button>
								</a>
							</td>
                        </tr>
				</table>
				<div class="clearfix"><br /></div>
						 
				<div class="row-fluid">
						 <div class="span6">
						   <table class="table table-bordered table-invoice">
							<tr>
								<td>Bayar</td>
								<td><input type="text" name="bayar" id="bayar" style="width:150px; font-size: 15px; "  value="" placeholder="..."></td>
							</tr>
						  </table>
						</div><!--span6-->
						
						<div class="span6">
						   <table class="table table-bordered table-invoice">
							<tr>
								<td>Kembalian</td>
								<td><input type="text" name="kembalian" id="kembalian" style="width:150px; font-size: 20px; " value="" placeholder="..."></td>
							</tr>
						   </table>
						</div><!--span6-->
				</div><!--row-fluid-->
						
				<div class="clearfix"><br /> </div>
							<div id="tampil_data"></div>
							<div id="DataBarang" title="Data Barang">
							Cari Kata <input type="text" id="caribarang" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarbarang"></div>
							</div>
							
							<div id="DataPasien" title="Data Pasien">
							Cari Kata <input type="text" id="caripasien" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutuppasien" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarpasien"></div>
							</div>
							
							<?php echo form_close(); ?>
                            <?php endforeach; ?>
						</div>		
                       	<?php endif;?>
						<!---- END EDITING FORM ---->
					
						<!---- DAFTAR OBAT START ---->
   						<div id="list">
                        	<a href="<?php echo base_url(); ?>c_bayar_obat/bayar_obat/tambah"> 
							<button class="btn btn-warning btn-rounded" title="Tambah bayar Obat"><i class="icon-plus icon-white"></i> Tambah </button></a> 
							<a href="<?php echo base_url(); ?>c_bayar_obat/bayar_obat"> 
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
                                    <th class="head0 center" >Kode Obat</th>
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
							foreach ($bayar_obat as $r):
							$item = $this->m_crud->ItemBayarObat($r['kd_bayar']);
							$jmlBayarObat = $this->m_crud->JmlBayarObat($r['kd_bayar']);
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
										<td class="center" width="10%"><?php echo number_format($jmlBayarObat); ?></td>
									<td class="center" width="15%">
                                    	<a href="<?php echo base_url(); ?>c_bayar_obat/bayar_obat/ubah/<?php echo $r['kd_bayar']; ?>" class="btn btn-primary btn-circle" title="Edit"><i class="iconsweets-create iconsweets-white"></i></a>
                                        <a href="<?php echo base_url(); ?>c_bayar_obat/bayar_obat/hapus/<?php echo $r['kd_bayar']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php 
							  $no++;
							  endforeach; ?>
                   	 		</tbody>
                			</table>
                        </div>
                         <!---- END DAFTAR OBAT---->
						 
            		    <!---- TRANSAKSI PEMBAYARAN OBAT ---->
						<?php if(isset($pembayaran_obat)):?>
                        <div id="tambah">
						
						<h4 class="widgettitle">Transaksi Pembayaran Obat</h4>
						<div class="row-fluid">
						
						<div class="span6">
						<form id="form">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Transaksi</td>
								  <td class="width70"><input type="text" id="kodebayar" name="kodebayar" value="<?php echo $kodebayar; ?>"  style="width:100px; font-size: 13px;" readonly></td>
							  </tr>
							  <tr>
								<td>Tgl Transaksi</td>
								<td><strong><input type="text" name="tglbayar"  id="tgl_bayar" value="<?php echo $tgl_bayar; ?>"  style="width:100px; font-size: 13px; "  /></strong></td>
							</tr>
									
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
                      
							  
							<tr>
								  <td>NIK Pasien</td>
								  <td>
									<span class="field">
										<input type="text" style="width:150px; font-size: 13px; " name="nik" id="nik" value="<?php echo $nik; ?>" placeholder="..." />
										<button type="button" name="list_pasien" id="list_pasien" class="btn btn-danger btn-small" title="Cari Pasien"><i class="icon-list-alt icon-white"></i></button>
									</span>
								  </td>
							</tr>
							<tr>
								<td>Nama Pasien</td>
								<td><input type="text" name="bio_nama" id="bio_nama" style="width:300px; font-size: 13px; " value="<?php echo $bio_nama; ?>" placeholder="..." readonly>
								</td>
							  </tr>
						</table>
						</div><!--span6-->
						</div><!--row-fluid-->
						<div class="clearfix"><br /></div>
						<button type="button" name="baru" id="baru" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> Tambah Obat</button>
						 
                <div class="widgetcontent">
                <div class="row-fluid">
						
						<div class="span6">
						 <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Obat</td>
								  <td class="width70">
									<input type="text" style="width:100px; font-size: 15px; " name="kd_obat" id="kd_obat" value="<?php echo $kd_obat; ?>" placeholder="..." />
								  <button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Barang"><i class="icon-list-alt icon-white"></i></button>
								</tr>
							  <tr>
								<td>Nama Obat</td>
								<td><input type="text" name="nama_obat" id="nama_obat" style="width:300px; font-size: 15px; " value="<?php echo $nama_obat; ?>" placeholder="..." readonly>
								</td>
							  </tr>
							 <tr>
								  <td>Harga Jual</td>
								  <td><input type="text" name="harga_jual" id="harga_jual" style="width:100px; font-size: 15px; " value="" placeholder="..." readonly ></td>
							</tr>
						  </table>
						  </div>
						  
						  <div class="span6">
						    <table class="table table-bordered table-invoice">
								<tr>
								  <td>Satuan</td>
								  <td>
								  <span class="field">
                                            <select name="sat_kecil_obat" id="sat_kecil_obat" data-placeholder="Pilih Satuan..." style="width:230px;" class="chzn-select" tabindex="2" required>
                                            <option value=""></option>
                                            <?php foreach($list_satuan_kecil as $lsko) : ?>
                                            	<option value="<?php echo $lsko['sat_kecil_obat']; ?>"><?php echo $lsko['sat_kecil_obat']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                  </span>
								  </td>
								</tr> 
								<tr>
								  <td>QTY</td>
								  <td><input type="text" name="jml" id="jml" style="width:60px; font-size: 15px; "  value="<?php echo $jml; ?>" placeholder="..."></td>
								</tr>
								<tr>
									<td>Total</td>
									<td><strong><input type="text" name="total" id="total" style="width:100px; font-size: 15px; " value="" placeholder="..." readonly /></strong></td>
								</tr>
						</table>
						</div><!--span6-->
						</div><!--row-fluid-->
                </div><!--widgetcontent-->	
						
				<table width="100%">
						<tr>
							<td align="center">
									<button type="button"  name="simpan" id="simpan" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Simpan</button>
									<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-print icon-white"></i> Cetak</button>
								<a href="<?php echo base_url(); ?>admin/laporan">
									<button type="button" class="btn btn-inverse"><i class="icon-off icon-white"></i> Selesai</button>
								</a>
							</td>
                        </tr>
				</table>
				<div class="clearfix"><br /> </div>
				<div class="row-fluid">
						
						<div class="span6">
						 <table class="table table-bordered table-invoice">
							<tr>
								<td>Bayar</td>
								<td><input type="text" name="bayar" id="bayar" style="width:150px; font-size: 20px; "  value="" placeholder="..."></td>
							</tr>
						</table>
						</div><!--span6-->
						<div class="span6">
						 <table class="table table-bordered table-invoice">
							<tr>
								<td>Kembalian</td>
								<td><input type="text" name="kembalian" id="kembalian" style="width:150px; font-size: 20px; " value="" placeholder="..."></td>
							</tr>
						</table>
						</div><!--span6-->
				</div><!--row-fluid-->
						
				<div class="clearfix"><br /> </div>
							<div id="tampil_data"></div>
							<div id="DataBarang" title="Data Barang">
							Cari Kata <input type="text" id="caribarang" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarbarang"></div>
							</div>
							
							<div id="DataPasien" title="Data Pasien">
							Cari Kata <input type="text" id="caripasien" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutuppasien" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarpasien"></div>
							</div>
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

/////////////////////* SCRIPT PENCARIAN KODE BARANG *//////////////////////////////////	
	
	
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
	
	
	function CariKodeBarang(){
		var kode = $("#kd_obat").val();
		  $.ajax({ 
			  url	: "<?php echo site_url('ref_json/CariBarang'); ?>",
			  data	: "kode="+kode,
			  cache	: false,
			  dataType: "json",
			  type	: "POST",
			  success: function(data){
				  $("#nama_obat").val(data.nama_obat);
				  $("#harga_jual").val(data.harga_jual);
				  
				  
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
		CariKodeBarang();
	});
	
	$("#kd_obat").keyup(function(){
		CariKodeBarang();
		
	});
	
	detailBarang();
	DataBarang();
	DataPasien();
	
	function detailBarang(){
		var kode = $("#kodebayar").val();
		var string = "kode="+kode;
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_bayar_obat/DataDetailObat",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				
			}
		});
		
	}
			
////////////////////////////////* HITUNG JUMLAH */////////////////////////////////
	var sum = 0;
	function hitung(){
		var jml = $("#jml").val();
		var hrg = $("#harga_jual").val();
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
	$("#harga_jual").keyup(function(){
		hitung();
	});		

////////////////////////////////* HITUNG KEMBALIAN */////////////////////////////////
	function hitung_kembalian(){
		var bayar 		= $("#bayar").val();
		var ttl 		= $("#tbeli").val();
		var tbeli		= ttl.replace(",","");
		
		
		if(bayar.length>0  && tbeli.length>0){ 
			var kembalian = parseInt(bayar)-parseInt(tbeli);
			$("#kembalian").val(kembalian);
		}else{
			$("#kembalian").val(0);
		}
			
	}
	$("#bayar").keyup(function(){
		hitung_kembalian();
	});
	$("#tbeli").keyup(function(){
		hitung_kembalian();
	});		


//////////////////////////* SCRIPT OPEN DIALOGUE  BARANG *////////////////////////////
function DataBarang(){
		var cari = $("#caribarang").val();
		var string = "cari="+cari;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/DataBarang",
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
	
	$("#caribarang").keyup(function(){
		DataBarang();
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
	
/////////////////////////* SIMPAN *////////////////////////////
	$("#simpan").click(function(){
	
		var kode	= $("#kd_obat").val();
		var nama	= $("#nama_obat").val();
		
		var string = $("#form").serialize();
		
		if(kode.length==0){
			$("#kd_obat").focus();
			return false();
		}
		if(nama.length==0){
			$("#kd_obat").focus();
			return false();
		}
		
			
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_bayar_obat/simpan_obat",
			data	: string,
			cache	: false,
			success	: function(data){
				detailBarang();
				$("#jml").val('');
				$("#bayar").focus();	
			}
		});
		
		return false();		
	});
	
	
	$("#baru").click(function(){
		$("#kd_obat").val('');
		$("#nama_nama_obat").val('');
		$("#jml").val('');
		$("#harga").val('');
		$("#total").val('0');
				
		$("#kd_obat").focus();
		
	});
	
	$("#cetak").click(function(){
		var kode	= $("#kodebayar").val();
		window.open('<?php echo site_url();?>c_bayar_obat/cetak/'+kode);
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
</style>
	`