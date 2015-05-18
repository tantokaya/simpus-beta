<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Obat</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data obat apotek</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
							<?php if(isset($edit_barang_masuk_apotek)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Masuk Obat Apotek</a></li>
            				<?php endif;?>
							
                        	<?php if(isset($tambah_barang_masuk_apotek)):?>
            				<li class=""><a href="#tambah"><i class="icon-edit"></i> Obat Masuk</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($tambah_barang_masuk_apotek))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Obat Masuk Apotek</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
						<?php if(isset($edit_barang_masuk_apotek)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">Ubah Data Golongan Obat</h4>
                            <div class="row-fluid">
							<?php foreach ($edit_barang_masuk_apotek as $row): ?>
                            	<?php echo form_open('barang/apotek_masuk/ubah/do_update/'.$row['kd_masuk'], array('class' => 'stdform stdform2', 'id' => 'form')); ?>
                                <div class="span6">
								<div class="clearfix"><br /></div>
								
						<form id="form">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Penerimaan:</td>
								  <td class="width70"><input type="text" id="kodemasuk" name="kodemasuk" value="<?php echo $row['kd_masuk']; ?>"  style="width:100px; font-size: 13px;" readonly></td>
							  </tr>
							  
								
						  </table>
						  </div>
						  <div class="span6">
						  <div class="clearfix"><br /></div>
						  <table class="table table-bordered table-invoice">
							<tr>
								<td>Tgl Penerimaan</td>
								<td><strong><input type="text" name="tglterima"  id="tgl_terima" value="<?php echo $this->m_crud->tgl_sql($row['tgl_terima']); ?>"  style="width:100px; font-size: 13px;" /></strong></td>
							</tr>
							<tr>
								<td>Nomor SBBK</td>
								<td><input type="text" name="nosbbk" id="nosbbk" value="<?php echo $row['no_sbbk']; ?>"  placeholder="..." style="width:150px; font-size: 13px;" ></td>
							</tr>
								
						  </table>
						</div></div><!--span6-->
						
						<div class="clearfix"><br /></div>
						<div class="row-fluid">
						
						<div class="span6">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Obat</td>
								  <td class="width70">
									<input type="text" name="kd_obat" id="kd_obat" value="" placeholder="..." style="width:100px; font-size: 13px;"/>
								  <button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Barang"><i class="icon-list-alt icon-white"></i></button>
								</tr>
							  <tr>
								<td>Nama Obat</td>
								<td><input type="text" name="nama_obat" id="nama_obat"  value="" placeholder="..." style="width:300px; font-size: 13px;" readonly>
								</td>
							  </tr>
							  </tr>
								<tr>
								  <td>Jumlah</td>
								  <td><input type="text" name="jml" id="jml"   value="" placeholder="..." style="width:60px; font-size: 13px;"/>
								  <input type="text" name="sat_kecil_obat" id="sat_kecil_obat" value="<?php echo $sat_kecil_obat; ?>" placeholder="..." style="border:0px; width:80px; font-size: 13px;" readonly>
								  <button type="button"  name="simpan" id="simpan" class="btn btn-primary"><i class="icon-ok icon-white"></i> </button>
								  </td>
							</tr>
							
						  </table>
						  </div>
						
						<div class="span6">
						  <table class="table table-bordered table-invoice">
								
								<tr>
									<td>Nomor Batch</td>
									<td><input type="text" id="no_batch" name="no_batch"  value="" placeholder="..." style="width:150px; font-size: 13px;"/></td>
								</tr>
							  <tr>
								<td>Tgl Kadaluarsa</td>
								<td><strong><input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa"  value="" style="width:100px; font-size: 13px;"/></strong></td>
							  </tr>
							  </tr>
								 
							  
						</table>
						</div></div><!--span6-->
						
							<div class="clearfix"><br /> </div>
                                <table width="100%">
								    <tr>
										<td align="center">
											<a href="<?php echo base_url(); ?>barang/apotek_masuk/tambah">	<button type="button"  name="baru"  class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a>
											<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
											<a href="<?php echo base_url(); ?>barang/apotek_masuk">
												<button type="button" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Tutup</button>
											</a>
										</td>
									</tr>
									
								</table>
							
							
						<div class="clearfix"><br /> </div>
							<div id="tampil_data"></div>
							<div id="DataBarangApotek" title="Data Barang">
							Cari Kata <input type="text" id="caribarang" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarbarang"></div>
							</div>
						
						<?php echo form_close(); ?>
                            <?php endforeach; ?>
					</div>		
                       	<?php endif;?>
        				<!---- END EDITING FORM ---->
                        
                        <!---- DAFTAR OBAT APOTEK START ---->
   						<div id="list">
                        	<a href="<?php echo base_url(); ?>barang/apotek_masuk/tambah"> 
							<button class="btn btn-warning btn-rounded" title="Tambah Stok Obat"><i class="icon-plus icon-white"></i> Tambah </button></a> 
							<a href="<?php echo base_url(); ?>barang/apotek_masuk"> 
							<button class="btn btn-success btn-rounded" title="Perbarui Data"><i class="icon-refresh icon-white"></i> Refresh </button></a> ||
                            <a href="<?php echo base_url(); ?>barang/sawal_apotek/tambah">
                                <button class="btn btn-info btn-rounded" title="Tambah Stok Obat"><i class="icon-tint icon-white"></i> Stok Awal </button></a>
							
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
                        	</colgroup>
                    		<thead>
                                <tr>
                                    <th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                                    <th class="head1 center">No</th>
                                    <th class="head1 center">Kode Masuk</th>
                                    <th class="head0 center">Tanggal</th>
                                    <th class="head0 center">Item</th>
                                    <th class="head1 center">Jumlah</th>
									<th class="head0 center">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php 
							$no=1;
							foreach ($barang_masuk_apotek as $r):
							$itemApotek = $this->m_crud->ItemInApotek($r['kd_masuk']);
							$jmlInApotek = $this->m_crud->JmlInApotek($r['kd_masuk']);
							?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
	                                    <td class="center"><?php echo $no; ?></td>
	                                    <td class="center" width="15%"><?php echo $r['kd_masuk']; ?></td>
	                                    <td class="center" width="13%"><?php echo $this->m_crud->tgl_sql($r['tgl_terima']); ?></td>
	                                    <td class="center"><?php echo $itemApotek; ?></td>
										<td class="center" width="20%"><?php echo number_format($jmlInApotek); ?></td>
									<td class="center" width="15%">
                                    	<a href="<?php echo base_url(); ?>barang/apotek_masuk/ubah/<?php echo $r['kd_masuk']; ?>" class="btn btn-primary btn-circle" title="Edit"><i class="iconsweets-create iconsweets-white"></i></a>
                                        <a href="<?php echo base_url(); ?>barang/apotek_masuk/hapus/<?php echo $r['kd_masuk']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
                                    </td>
                                </tr>
                              <?php 
							  $no++;
							  endforeach; ?>
                   	 		</tbody>
                			</table>
							
                        </div>
                         <!---- END DAFTAR OBAT---->
                        
                        <!---- TAMBAH OBAT MASUK START ---->
						<?php if(isset($tambah_barang_masuk_apotek)):?>
                        <div id="tambah">
						<h4 class="widgettitle">Tambah Stok Data Obat</h4>
						<div class="row-fluid">
						
						<div class="span6">
						<form id="form">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Penerimaan :</td>
								  <td class="width70"><input type="text" id="kodemasuk" name="kodemasuk" readonly value="<?php echo $kodemasuk; ?>"  style="width:100px; font-size: 13px;" ></td>
							  </tr>
								
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
							<tr>
								<td>Tgl Penerimaan</td>
								<td><strong><input type="text" name="tglterima"  id="tgl_terima" value="<?php echo $tgl_terima; ?>"  style="width:100px; font-size: 13px;"  /></strong></td>
							</tr>
							<tr>
								<td>Nomor SBBK</td>
								<td><input type="text" name="nosbbk" id="nosbbk" style="width:150px; font-size: 13px;" placeholder="..." ></td>
							</tr>
							  
						 </table>
						</div><!--span6-->
						</div><!--row-fluid-->
						
						<div class="clearfix"><br /></div>
					
						<div class="row-fluid">
						
						<div class="span6">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Obat</td>
								  <td class="width70">
									<input type="text" name="kd_obat" id="kd_obat" value="<?php echo $kd_obat; ?>" placeholder="..." style="width:100px; font-size: 13px;"/>
								  <button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Barang"><i class="icon-list-alt icon-white"></i></button>
								</tr>
							  <tr>
								<td>Nama Obat</td>
								<td><input type="text" name="nama_obat" id="nama_obat" value="<?php echo $nama_obat; ?>" placeholder="..." style="width:300px; font-size: 13px;" readonly>
								</td>
							  </tr>
							  </tr>
								<tr>
								  <td>Jumlah</td>
								  <td><input type="text" name="jml" id="jml"   value="<?php echo $jml; ?>" placeholder="..." style="width:50px; font-size: 13px;">
								  <input type="text" name="sat_kecil_obat" id="sat_kecil_obat" value="<?php echo $sat_kecil_obat; ?>" placeholder="..." style="border:0px; width:80px; font-size: 13px;" readonly>
								  <button type="button"  name="simpan" id="simpan" class="btn btn-primary"><i class="icon-ok icon-white"></i> </button>
								  </td>
							</tr>
							
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
								
								<tr>
									<td>Nomor Batch</td>
									<td><input type="text" id="no_batch" name="no_batch"  value="<?php echo $no_batch; ?>" placeholder="..." style="width:150px; font-size: 13px;"></td>
								</tr>
							  <tr>
								<td>Tgl Kadaluarsa</td>
								<td><strong><input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa"  value="<?php echo $tgl_kadaluarsa; ?>" style="width:100px; font-size: 13px;" /></strong></td>
							  </tr>
							  </tr>
								 
							  
						</table>
						</div><!--span6-->
						</div><!--row-fluid-->
						<div class="clearfix"><br /></div>
						<table width="100%">
						<tr>
							<td align="center">
									<a href="<?php echo base_url(); ?>barang/apotek_masuk/tambah">	<button type="button"  name="baru"  class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a>
									<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
								<a href="<?php echo base_url(); ?>barang/apotek_masuk">
									<button type="button" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Tutup</button>
								</a>
							</td>
                        </tr>
						</table>
						
						
						<div class="clearfix"><br /> </div>
							<div id="tampil_data"></div>
							<div id="DataBarangApotek" title="Data Barang">
							Cari Kata <input type="text" id="caribarang" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarbarang"></div>
							</div>
						</form>	
						<!---- END TAMBAH OBAT MASUK ----> 
                	</div><?php endif;?></div><!--tabs-->
						  
					
                </div><!--span12-->
            </div><!--row-fluid-->
        </div><!--contentinner-->
    </div><!--maincontent-->
</div><!--mainright-->

<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function(){


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
	
	$("#nosbbk").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	
	$("#no_batch").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
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
				  $("#sat_kecil_obat").val(data.sat_kecil_obat);

                  $("#jml").val('');
                  $("#jml").focus();
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
	
	detailBarangApotek();
	DataBarangApotek();
	
	function detailBarangApotek(){
		var kode = $("#kodemasuk").val();
		var string = "kode="+kode;
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/DataDetailApotek",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				
			}
		});
		
	}
			
	


//////////////////////////* SCRIPT OPEN DIALOGUE *////////////////////////////
function DataBarangApotek(){
		var cari = $("#caribarang").val();
		var string = "cari="+cari;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/DatabarangApotek",
			data	: string,
			cache	: false,
			success	: function(data){
				//console.log(data);
				$("#daftarbarang").html(data);
			}
		});
	}
	

	$("#DataBarangApotek").dialog({
      autoOpen: false,
	  height:400,
	  width:700,
      show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "explode",
        duration: 500
      }
    });
	
	
	$("#list_barang").click(function() {
      $("#DataBarangApotek").dialog("open");
    });
	$("#tutup").click(function() {
      $("#DataBarangApotek").dialog("close");
    });
	
	$("#caribarang").keyup(function(){
		DataBarangApotek();
	});
	
	
/////////////////////////* SIMPAN *////////////////////////////
	$("#simpan").click(function(){
        var kode	= $("#kd_obat").val();

        var string = $("#form").serialize();

        if(kode.length==0){
            // alert box
            jAlert('Maaf, Kode Obat Masih Kosong.', 'Informasi !');

            $("#kd_obat").focus();
            return false();
        }
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/simpan_barang_masuk_apotek",
			data	: string,
			cache	: false,
			success	: function(data){
                jQuery.jGrowl('<span style="color: yellow;"> INFORMASI !</span><span style="color: #ffffff; "> <br/> Data Obat sudah di Simpan ! </span>');
					detailBarangApotek();

						}
					});
					
		return false();		
	});
	

	$("#cetak").click(function(){
		var kode	= $("#kodemasuk").val();
		window.open('<?php echo site_url();?>barang/cetak_apotek/'+kode);
		return false();
	});
	
	
	
});
</script>
<style type="text/css">
#DataBarangApotek {
	font-size:12px;
}
</style>