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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data obat</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
							<?php if(isset($edit_keluar_obat)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Obat Keluar</a></li>
            				<?php endif;?>
							
                        	<?php if(isset($keluar_stok_obat)):?>
            				<li class=""><a href="#tambah"><i class="icon-edit"></i> Obat Keluar</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($keluar_stok_obat))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Obat Keluar</a></li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
						<?php if(isset($edit_keluar_obat)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle ">Ubah Data Obat Keluar</h4>
                            <div class="row-fluid">
							<?php foreach ($edit_keluar_obat as $row): ?>
                            	<?php echo form_open('barang/keluar/ubah/do_update/'.$row['kd_keluar'], array('class' => 'stdform stdform2', 'id' => 'form')); ?>
                                
							<div class="span6">
							<table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Keluar :</td>
								  <td class="width70"><input type="text" id="kodekeluar" name="kodekeluar" value="<?php echo $row['kd_keluar']; ?>"  style="width:100px; font-size: 13px; "  ></td>
							  </tr>
							  <tr>
								<td>Tgl Keluar</td>
								<td><strong><input type="text" name="tglkeluar"  id="tgl_keluar" value="<?php echo $this->m_crud->tgl_sql($row['tgl_keluar']); ?>" style="width:100px; font-size: 13px; "   /></strong></td>
							</tr>
								
							  </table>
							  </div>
							<div class="span6">
						   <table class="table table-bordered table-invoice">
							<tr>
							<td>Dikirim ke</td>
								  <td>
							
								  <!--<span class="field">-->
                                            <select name="kd_unit_farmasi" id="kd_unit_farmasi" data-placeholder="Pilih Unit..." style="width:230px" class="chzn-select" tabindex="2"  />
                                            <option value=""></option>
                                            <?php foreach($list_unit_farmasi as $luf) : ?>
											<?php
                                            	if($luf['kd_unit_farmasi'] === $row['kd_unit_farmasi'])
														echo '<option value="'.$luf['kd_unit_farmasi'].'" selected="selected">'.$luf['nama_unit_farmasi'].'</option>';
													else
														echo '<option value="'.$luf['kd_unit_farmasi'].'">'.$luf['nama_unit_farmasi'].'</option>';
											?>
											<?php endforeach; ?>
                                            </select>
                                  <!--</span>-->
								  </td>
							  </tr>
							</tr>
							<tr>
								<td>Keterangan</td>
								<td><strong><input type="text" name="keterangan"  id="keterangan" value="<?php echo $row['keterangan']; ?>"  class="input-xlarge"  /></strong></td>
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
									<input type="text" style="width:100px; font-size: 15px; "  name="kd_obat" id="kd_obat" value="" placeholder="..." />
								  <button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Barang"><i class="icon-list-alt icon-white"></i></button>
								</tr>
							  <tr>
								  <td>Jumlah</td>
								  <td><input type="text" name="jml" id="jml" style="width:60px; font-size: 15px; "   value="" placeholder="...">
								  <input type="text" name="sat_kecil_obat" id="sat_kecil_obat" value="<?php echo $sat_kecil_obat; ?>" placeholder="..." style="border:0px; width:80px; font-size: 13px;" readonly>
								  <button type="button"  name="simpan" id="simpan" class="btn btn-primary"><i class="icon-ok icon-white"></i> </button>
								  </td>
							</tr>	
							  
							 
							
						  </table>
						  </div>
						
						<div class="span6">
						  <table class="table table-bordered table-invoice">
							<tr>
								<td>Nama Obat</td>
								<td><input type="text" name="nama_obat" id="nama_obat" style="width:300px; font-size: 15px; "  value="" placeholder="..." readonly>
								</td>
							  </tr>							
							</table>
						</div></div><!--span6-->
						
							<div class="clearfix"><br /> </div>
                                <table width="100%">
								    <tr>
										<td align="center">
											<a href="<?php echo base_url(); ?>barang/keluar/tambah">	<button type="button"  name="baru"  class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a>
											<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
											<a href="<?php echo base_url(); ?>barang/keluar">
												<button type="button" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Tutup</button>
											</a>
										</td>
									</tr>
									
								</table>
							
							
						<div class="clearfix"><br /> </div>
							<div id="tampil_data"></div>
							<div id="DataBarang" title="Data Barang">
							Cari Kata <input type="text" id="caribarang" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarbarang"></div>
							</div>
						
						<?php echo form_close(); ?>
                            <?php endforeach; ?>
					</div>		
                       	<?php endif;?>
        				<!---- END EDITING FORM ---->
                        
                        <!---- DAFTAR OBAT START ---->
   						<div id="list">
                        	<a href="<?php echo base_url(); ?>barang/keluar/tambah"> 
							<button class="btn btn-warning btn-rounded" title="Tambah Stok Obat"><i class="icon-plus icon-white"></i> Tambah </button></a> 
							<a href="<?php echo base_url(); ?>barang/keluar"> 
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
                                    <th class="head1 center">Kode Keluar</th>
                                    <th class="head0 center">Tanggal</th>
                                    <th class="head0 center">Item Keluar</th>
                                    <th class="head0 center">Unit Penerima</th>
									<th class="head1 center">Aksi</th>
                                </tr>
                   			</thead>
                            <tbody>
                            <?php 
							$no=1;
							foreach ($obat_keluar as $r):
							$item = $this->m_crud->ItemOut($r['kd_keluar']);
							$jmlBeli = $this->m_crud->JmlKeluar($r['kd_keluar']);
							?>
                            	<tr class="gradeX">
                                	<td class="aligncenter">
                                  		<span class="center"><input type="checkbox" /></span>
                                  	</td>
	                                    <td class="center"><?php echo $no; ?></td>
	                                    <td class="center" width="15%"><?php echo $r['kd_keluar']; ?></td>
	                                    <td class="center" width="13%"><?php echo $r['tgl_keluar']; ?></td>
	                                    <td class="center"><?php echo $item; ?></td>
									<td class="left" ><?php echo $r['nama_unit_farmasi']; ?></td>
									<td class="center" width="15%">
                                    	<a href="<?php echo base_url(); ?>barang/keluar/ubah/<?php echo $r['kd_keluar']; ?>" class="btn btn-primary btn-circle" title="Edit"><i class="iconsweets-create iconsweets-white"></i></a>
                                        <a href="<?php echo base_url(); ?>barang/keluar/hapus/<?php echo $r['kd_keluar']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
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
						<?php if(isset($keluar_stok_obat)):?>
                        <div id="tambah">
						<h4 class="widgettitle">Stok Data Obat Keluar ( - )</h4>
						<div class="row-fluid">
						
						<div class="span6">
						<form id="form">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Keluar :</td>
								  <td class="width70"><input type="text" id="kodekeluar" name="kodekeluar" readonly value="<?php echo $kodekeluar; ?>"  style="width:100px; font-size: 13px; " ></td>
							  </tr>
							  <tr>
								<td>Tgl Keluar</td>
								<td><strong><input type="text" name="tglkeluar"  id="tgl_keluar" value="<?php echo $tgl_keluar; ?>"  style="width:100px; font-size: 13px; "  /></strong></td>
							</tr>
									
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
                      
							  
							<tr>
								  <td>Dikirim ke</td>
								  <td>
								  <span class="field">
                                            <select name="kd_unit_farmasi" id="kd_unit_farmasi" data-placeholder="Pilih Unit..." style="width:230px" class="chzn-select" tabindex="2"  />
                                            <option value=""></option>
                                            <?php foreach($list_unit_farmasi as $lmo) : ?>
                                            	<option value="<?php echo $lmo['kd_unit_farmasi']; ?>"><?php echo $lmo['nama_unit_farmasi']; ?></option>
											<?php endforeach; ?>
                                            </select>
                                  </span>
								  </td>
							  </tr>
							</tr>
								<tr>
									<td>Keterangan</td>
									<td><strong><input type="text" name="keterangan"  id="keterangan" data-placeholder="Pilih Keterangan..." value="<?php echo $keterangan; ?>"  class="input-xlarge"  /></strong></td>
								</tr>
							  </table>
						</div><!--span6-->
						</div><!--row-fluid-->
						
						<div class="clearfix"><br /></div>
						<!--<button type="button" name="list_resep" id="list_resep" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> Panggil Resep</button>-->
						 
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
								  <td>Jumlah</td>
								  <td><input type="text" name="jml" id="jml" style="width:60px; font-size: 15px; "   value="<?php echo $jml; ?>" placeholder="...">
								  <input type="text" name="sat_kecil_obat" id="sat_kecil_obat" value="<?php echo $sat_kecil_obat; ?>" placeholder="..." style="border:0px; width:80px; font-size: 13px;" readonly>
								  <button type="button"  name="simpan" id="simpan" class="btn btn-primary"><i class="icon-ok icon-white"></i> </button>
								  </td>
							</tr>
							 
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
								<tr>
								<td>Nama Obat</td>
								<td><input type="text" name="nama_obat" id="nama_obat" style="width:200px; font-size: 12px; " value="<?php echo $nama_obat; ?>" placeholder="..." readonly>
								</td>
							  </tr> 
								
						</table>
						</div><!--span6-->
						</div><!--row-fluid-->
						<div class="clearfix"><br /></div>
						<table width="100%">
						<tr>
							<td align="center">
									<a href="<?php echo base_url(); ?>barang/keluar/tambah">	<button type="button"  name="baru"  class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a>
									<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
								<a href="<?php echo base_url(); ?>barang/keluar">
									<button type="button" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Tutup</button>
								</a>
							</td>
                        </tr>
						</table>
						
						
						<div class="clearfix"><br /> </div>
							<div id="tampil_data"></div>
							<div id="DataBarang" title="Data Barang">
							Cari Kata <input type="text" id="caribarang" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarbarang"></div>
							</div>
							
                       
                       	 <div id="tampil_data2"></div>
							<div id="DataResep" title="Data Resep">
							No. Transaksi Pelayanan<input type="text" id="cariresep" class="input-large search-query" placeholder="pencarian">
							<button type="button" name="tutup2" id="tutup2" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
								<div id="daftarresep"></div>
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
	
		
	/*$("#kd_obat").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});*/
	
		$("#keterangan").keyup(function(e){
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
	
	function detailBarang(){
		var kode = $("#kodekeluar").val();
		var string = "kode="+kode;
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/DataDetailKeluar",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				
			}
		});
		
	}
			
////////////////////////////////* HITUNG JUMLAH */////////////////////////////////
	function hitung(){
		var jml = $("#jml").val();
		var hrg = $("#harga_beli").val();
		var harga = hrg.replace(",","");
		if(jml.length>0  && harga.length>0){ 
			var total = parseInt(jml)*parseInt(harga);
			//var total = total.toCurrency();
			$("#total").val(total);
		}else{
			$("#total").val(0);
		}
			
	}
	$("#jml").keyup(function(){
		hitung();
	});
	$("#harga_beli").keyup(function(){
		hitung();
	});		


//////////////////////////* SCRIPT OPEN DIALOGUE *////////////////////////////
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
        duration: 500
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
	
	
/////////////////////////* SIMPAN *////////////////////////////
	$("#simpan").click(function(){
        var kode	= $("#kd_obat").val();
        var unit    = $("#kd_unit_farmasi").val();

        var string = $("#form").serialize();

        if(kode.length==0){
            // alert box
            jAlert('Maaf, Kode Obat Masih Kosong.', 'Informasi !');

            $("#kd_obat").focus();
            return false();
        }
        if(unit.length==0){
            // alert box
            jAlert('Maaf, Kode Unit Farmasi Masih Kosong.', 'Informasi !');

            $("#kd_unit_farmasi").focus();
            return false();
        }		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/simpankeluar",
			data	: string,
			cache	: false,
			success	: function(data){
                jQuery.jGrowl('<span style="color: yellow;"> INFORMASI !</span><span style="color: #ffffff; "> <br/> Data Obat sudah di Simpan ! </span>');
					detailBarang();

			}
		});
		
		return false();		
	});


	$("#cetak").click(function(){
		var kode	= $("#kodekeluar").val();
		window.open('<?php echo site_url();?>barang/cetakkeluar/'+kode);
		return false();
	});
	
	
	// Call resep
	function DataResep(){
		var s = $("#cariresep").val();
		var string = "s="+s;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>ref_json/Dataresep",
			data	: string,
			cache	: false,
			success	: function(data){
				//console.log(data);
				$("#daftarresep").html(data);
			}
		});
	}
	

	$("#DataResep").dialog({
      autoOpen: false,
	  height:400,
	  width:800,
      show: {
        effect: "fade",
        duration: 300
      },
      hide: {
        effect: "explode",
        duration: 500
      }
    }); 	
	
	$("#list_resep").click(function() {
      $("#DataResep").dialog("open");
    });
	$("#tutup2").click(function() {
      $("#DataResep").dialog("close");
    });
	
	$("#cariresep").keyup(function(){
		DataResep();
	});
	
	//detailResep();
	DataResep();
		
});
</script>
<style type="text/css">
#DataBarang, #DataBarang {
	font-size:12px;
}
</style>