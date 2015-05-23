<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Master Transaksi</a> <span class="divider">/</span></li>
           <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman Transaksi Pembayaran PENDAFTARAN</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner">
        	<div class="row-fluid">
            		    <!---- TRANSAKSI PENDAFTARAN PASIEN ---->
						<h4 class="widgettitle">Transaksi Pendaftaran</h4>
						<div class="row-fluid">
						
						<div class="span6">
						<form id="form">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Transaksi</td>
								  <td class="width70"><input type="text" id="kodebayar" name="kodebayar" value="<?php echo $kodebayar; ?>"  class="input-small" ></td>
							  </tr>
							  <tr>
								<td>Tgl Transaksi</td>
								<td><strong><input type="text" name="tglbayar"  id="tgl_bayar" value="<?php echo $tgl_bayar; ?>"  class="input-small"  /></strong></td>
							</tr>
									
						  </table>
						  </div>
						  
						</div><!--row-fluid-->
						<div class="clearfix"><br /></div>
						
                <div class="widgetcontent">
                	
                    <h4 >Data Pasien</h4>
                
						<div class="row-fluid">
						<div class="span6">
						  <table class="table table-bordered table-invoice">
                      
							  
							<tr>
								  <td>NIK Pasien</td>
								  <td>
									<span class="field">
										<input type="text" class="input-medium" name="nik" id="nik" value="<?php echo $nik; ?>" placeholder="Pasien..." />
										<button type="button" name="list_pasien" id="list_pasien" class="btn btn-danger btn-small" title="Cari Pasien"><i class="icon-list-alt icon-white"></i></button>
									</span>
								  </td>
							</tr>
							<tr>
								<td>Nama Pasien</td>
								<td><input type="text" name="bio_nama" id="bio_nama" class="input-large" value="<?php echo $bio_nama; ?>" placeholder="Nama Pasien..." readonly>
								</td>
							  </tr>
							 
							</table>
						</div><!--span6-->
						<div class="span6">
						  <table class="table table-bordered table-invoice">
							<tr>
								  <td>Tanggal Lahir</td>
								  <td><input type="text" name="bio_tgl_lahir" id="bio_tgl_lahir"class="input-small" value="" placeholder="Tanggal Lahir ..." readonly ></td>
							</tr>
							<tr>
								<td>Alamat</td>
								<td><strong><input type="text" name="bio_alamat" id="bio_alamat" placeholder="Alamat..." class="input-xlarge" value="" readonly /></strong></td>
							</tr>
						</table>
					</div><!--span6-->
						  
						</div><!--row-fluid-->
                </div><!--widgetcontent-->	
					<div class="row-fluid">
					<div class="span6">
						  <h4> Biaya PENDAFTARAN </h4>
						  <table class="table table-bordered table-invoice">
						  
							<tr>
								<td>Total</td>
								<td><strong><input type="text" name="b_pendaftaran" id="total" placeholder="0" class="input-small" value="" /></strong></td>
							</tr>
						</table>
					</div><!--span6-->
					</div><!--row-fluid-->
						
						<div class="clearfix"><br /></div>
						
						<table width="100%">
						<tr>
							<td align="center">
									<button type="button"  name="simpan_pendaftaran" id="simpan_pendaftaran" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Simpan</button>
									<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
								<a href="<?php echo base_url(); ?>c_pembayaran/pembayaran">
									<button type="button" id="tutup_daftar" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Tutup</button>
								</a>
							</td>
                        </tr>
						</table>
						
						
						<div class="clearfix"><br /> </div>
					<a href="<?php echo base_url(); ?>c_pembayaran/bayar_pendaftaran"> 
					<button class="btn btn-warning btn-rounded" title="Tambah Stok Obat"><i class="icon-plus icon-white"></i> Tambah </button></a> 
					<a href="<?php echo base_url(); ?>c_pembayaran/bayar_pendaftaran"> 
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
							</colgroup>
							<thead>
							<tr>
								<th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
								<th class="head1 center">No</th>
								<th class="head1 center">Kode Bayar</th>
								<th class="head0 center">Tanggal</th>
								<th class="head0 center">NIK</th>
								<th class="head1 center">Nama</th>
								<th class="head0 center">Total</th>
								<th class="head1 center">Aksi</th>
							</tr>
							</thead>
							<tbody>
								<?php 
								$no=1;
								foreach ($bayar_pendaftaran as $r):
								?>
							<tr class="gradeX">
							<td class="aligncenter">
								<span class="center"><input type="checkbox" /></span>
							</td>
							<td class="center"><?php echo $no; ?></td>
							<td class="center" width="15%"><?php echo $r['kd_bayar']; ?></td>
							<td class="center" width="13%"><?php echo $r['tgl_bayar']; ?></td>
							<td class="center" width="13%"><?php echo $r['nik']; ?></td>
							<td class="left" width="25%"><?php echo $r['nama']; ?></td>
							<td class="" ><?php echo number_format($r['b_pendaftaran']); ?></td>
							<td class="center" width="15%">
								<a href="<?php echo base_url(); ?>c_pembayaran/bayar_pendaftaran/ubah/<?php echo $r['kd_bayar']; ?>" class="btn btn-primary btn-circle" title="Edit"><i class="iconsweets-create iconsweets-white"></i></a>
								<a href="<?php echo base_url(); ?>c_pembayaran/bayar_pendaftaran/hapus/<?php echo $r['kd_bayar']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
							</td>
							</tr>
								<?php 
								$no++;
								endforeach; ?>
							</tbody>
						</table>
							<!--<div id="tampil_data"></div>-->
							<div id="DataPasien" title="Data Pasien">
							Cari Kata <input type="text" id="caripasien" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutuppasien" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarpasien"></div>
							</div>
						<!---- END TRANSAKSI PENDAFTARAN PASIEN ----> 
						</form>
						
					
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
	});	

	
/////////////////////* SCRIPT PENCARIAN KODE BARANG *//////////////////////////////////	
	DataBarang();
	DataPasien();
	
			
//////////////////////////* SCRIPT OPEN DIALOGUE  BARANG *////////////////////////////
function DataBarang(){
		var cari = $("#caribarang").val();
		var string = "cari="+cari;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/Databarang",
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
	
	$("#tutup_daftar").click(function() {
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
				  $("#bio_alamat").val(data.bio_alamat);
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
	$("#simpan_pendaftaran").click(function(){
		
		var string = $("#form").serialize();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_pembayaran/simpan_pendaftaran",
			data	: string,
			cache	: false,
			success	: function(data){
			
			}
		});
		
		return false();		
	});
	
	
	
	$("#simpan_edit").click(function(){
		
		var string = $("#form_edit").serialize();
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_pembayaran/simpan",
			data	: string,
			cache	: false,
			success	: function(data){
				/*$('.bottom-right').notify({
		  			message: {text:data},type:'info'
	 			 }).show();*/
				detailBarang();
				$("#kd_produk").val('');
				$("#nama_produk").val('');
				$("#jml").val('');
				$("#harga_jual").val('');
				$("#sat_kecil_obat").val('');
				$("#total").val('0');
				
		
			}
		});
		
		return false();		
	});
	
	
	$("#cetak").click(function(){
		var kode	= $("#kodebayar").val();
		window.open('<?php echo site_url();?>c_pembayaran/cetak/'+kode);
		return false();
	});
	
	
		// Smart Wizard 	
  		jQuery('#wizard').smartWizard({onFinish: onFinishCallback});
      	jQuery('#wizard2').smartWizard({onFinish: onFinishCallback});
		jQuery('#wizard3').smartWizard({onFinish: onFinishCallback});
		jQuery('#wizard4').smartWizard({onFinish: onFinishCallback});
		
		function onFinishCallback(){
			alert('Finish Clicked');
		} 
		
		jQuery(".inline").colorbox({inline:true, width: '60%', height: '500px'});
		
		jQuery('select, input:checkbox').uniform();

	
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