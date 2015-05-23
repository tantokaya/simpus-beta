
Share on facebook Share on twitter Share on email Share on print More Sharing Services
The Prettifier - HTML
Enter your HTML via direct input or URL to have it formatted and syntax highlighted.

    Home
    JSON
    CSS
    JavaScript
    HTML
    SQL
    XML
    PHP
    Perl
    Apache
    Code Bin


<!--?php if($this--->
<html>
 <head></head>
 <body>
  session-&gt;flashdata('flash_message') != &quot;&quot;):?&gt; 
  <script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script> 
  <!--?php endif;?--> 
  <div class="rightpanel"> 
   <div class="breadcrumbwidget"> 
    <ul class="breadcrumb"> 
     <li><a href="#">Home</a> <span class="divider">/</span></li> 
     <li><a href="#">Master Obat</a> <span class="divider">/</span></li> 
     <li class="active">
      <!--?php echo $page_title; ?--></li> 
    </ul> 
   </div>
   <!--breadcrumbwidget--> 
   <div class="pagetitle"> 
    <h1>
     <!--?php echo $page_title; ?--></h1> 
    <span>Halaman manajemen data obat</span> 
   </div>
   <!--pagetitle--> 
   <div class="maincontent"> 
    <div class="contentinner content-dashboard"> 
     <div class="row-fluid"> 
      <div class="span12"> 
       <div id="tabs"> 
        <ul> 
         <!--?php if(isset($edit_barang_masuk)):?--> 
         <li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Pembelian Obat</a></li> 
         <!--?php endif;?--> 
         <!--?php if(isset($tambah_barang_masuk)):?--> 
         <li class=""><a href="#tambah"><i class="icon-edit"></i> Obat Masuk</a></li> 
         <!--?php endif;?--> 
         <li class="&lt;?php if(!isset($tambah_barang_masuk))echo 'ui-tabs-active';?&gt;"><a href="#list"><i class="icon-align-justify"></i> Daftar Obat Masuk</a></li> 
        </ul> 
        <!--EDITING FORM STARTS----> 
        <!--?php if(isset($edit_barang_masuk)):?--> 
        <div id="ubah"> 
         <h4 class="widgettitle nomargin shadowed">Ubah Data Golongan Obat</h4> 
         <div class="row-fluid"> 
          <!--?php foreach ($edit_barang_masuk as $row): ?--> 
          <!--?php echo form_open('barang/masuk/ubah/do_update/'.$row['kd_masuk'], array('class' =--> 'stdform stdform2', 'id' =&gt; 'form')); ?&gt; 
          <div class="span6"> 
           <div class="clearfix">
            <br />
           </div> 
           <form id="form"> 
            <table class="table table-bordered table-invoice"> 
             <tbody>
              <tr> 
               <td class="width30">Kode Penerimaan:</td> 
               <td class="width70"><input type="text" id="kodemasuk" name="kodemasuk" value="&lt;?php echo $row['kd_masuk']; ?&gt;" style="width:100px; font-size: 13px;" readonly="" /></td> 
              </tr> 
              <tr> 
               <td>Diterima dari</td> 
               <td> 
                <!--<span class="field">--> <select name="kd_milik_obat" id="kd_milik_obat" data-placeholder="Pilih Pengirim Obat..." style="width:230px" class="chzn-select" tabindex="2"></select> <option value=""></option> 
                <!--?php foreach($list_milik_obat as $lmo) : ?--> 
                <!--?php
                                            	if($lmo['kd_milik_obat'] === $row['kd_milik_obat'])
														echo '<option value="'.$lmo['kd_milik_obat'].'" selected="selected"-->'.$lmo['kepemilikan'].''; else echo '<option value="'.$lmo['kd_milik_obat'].'">'.$lmo['kepemilikan'].'</option>'; ?&gt; 
                <!--?php endforeach; ?-->  </td> 
              </tr>  
             </tbody>
            </table> 
           </form>
          </div> 
          <div class="span6"> 
           <div class="clearfix">
            <br />
           </div> 
           <table class="table table-bordered table-invoice"> 
            <tbody>
             <tr> 
              <td>Tgl Penerimaan</td> 
              <td><strong><input type="text" name="tglterima" id="tgl_terima" value="&lt;?php echo $this-&gt;m_crud-&gt;tgl_sql($row['tgl_terima']); ?&gt;" style="width:100px; font-size: 13px;" /></strong></td> 
             </tr> 
             <tr> 
              <td>Nomor SBBK</td> 
              <td><input type="text" name="nosbbk" id="nosbbk" value="&lt;?php echo $row['no_sbbk']; ?&gt;" placeholder="..." style="width:150px; font-size: 13px;" /></td> 
             </tr> 
            </tbody>
           </table> 
          </div>
         </div>
         <!--span6--> 
         <div class="clearfix">
          <br />
         </div> 
         <div class="row-fluid"> 
          <div class="span6"> 
           <table class="table table-bordered table-invoice"> 
            <tbody>
             <tr> 
              <td class="width30">Kode Obat</td> 
              <td class="width70"> <input type="text" name="kd_obat" id="kd_obat" value="" placeholder="..." style="width:100px; font-size: 13px;" /> <button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Barang"><i class="icon-list-alt icon-white"></i></button> </td>
             </tr> 
             <tr> 
              <td>Nama Obat</td> 
              <td><input type="text" name="nama_obat" id="nama_obat" value="" placeholder="..." style="width:300px; font-size: 13px;" readonly="" /> </td> 
             </tr> 
             <tr> 
              <td>Harga Beli</td> 
              <td><input type="text" name="harga_beli" id="harga_beli" value="" placeholder="..." style="width:100px; font-size: 13px;" readonly="" /></td> 
             </tr> 
             <tr> 
              <td>Jumlah</td> 
              <td><input type="text" name="jml" id="jml" value="" placeholder="..." style="width:60px; font-size: 13px;" /> <input type="text" name="sat_kecil_obat" id="sat_kecil_obat" value="&lt;?php echo $sat_kecil_obat; ?&gt;" placeholder="..." style="border:0px; width:80px; font-size: 13px;" readonly="" /> <button type="button" name="simpan" id="simpan" class="btn btn-primary"><i class="icon-ok icon-white"></i> </button> </td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <div class="span6"> 
           <table class="table table-bordered table-invoice"> 
            <tbody>
             <tr> 
              <td>Nomor Batch</td> 
              <td><input type="text" id="no_batch" name="no_batch" value="" placeholder="..." style="width:150px; font-size: 13px;" /></td> 
             </tr> 
             <tr> 
              <td>Tgl Kadaluarsa</td> 
              <td><strong><input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa" value="" style="width:100px; font-size: 13px;" /></strong></td> 
             </tr>  
             <tr> 
              <td>Total</td> 
              <td><strong><input type="text" name="total" id="total" value="" style="width:100px; font-size: 13px;" readonly="" /></strong></td> 
             </tr> 
            </tbody>
           </table> 
          </div>
         </div>
         <!--span6--> 
         <div class="clearfix">
          <br /> 
         </div> 
         <table width="100%"> 
          <tbody>
           <tr> 
            <td align="center"> <a href="&lt;?php echo base_url(); ?&gt;barang/masuk/tambah"> <button type="button" name="baru" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a> <button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button> <a href="&lt;?php echo base_url(); ?&gt;barang/masuk"> <button type="button" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Tutup</button> </a> </td> 
           </tr> 
          </tbody>
         </table> 
         <div class="clearfix">
          <br /> 
         </div> 
         <div id="tampil_data"></div> 
         <div id="DataBarang" title="Data Barang">
           Cari Kata 
          <input type="text" id="caribarang" class="input-large search-query" placeholder="pencarian" /> 
          <button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button> 
          <div id="daftarbarang"></div> 
         </div> 
         <!--?php echo form_close(); ?--> 
         <!--?php endforeach; ?--> 
        </div> 
        <!--?php endif;?--> 
        <!-- END EDITING FORM ----> 
        <!-- DAFTAR OBAT START ----> 
        <div id="list"> 
         <a href="&lt;?php echo base_url(); ?&gt;barang/masuk/tambah"> <button class="btn btn-warning btn-rounded" title="Tambah Stok Obat"><i class="icon-plus icon-white"></i> Tambah </button></a> 
         <a href="&lt;?php echo base_url(); ?&gt;barang/masuk"> <button class="btn btn-primary btn-rounded" title="Perbarui Data"><i class="icon-refresh icon-white"></i> Refresh </button></a> 
         <div class="clearfix">
          <br />
         </div> 
         <table class="table table-bordered" id="dyntable"> 
          <colgroup> 
           <col class="con0" style="align: center; width: 4%" /> 
           <col class="con1" style="align: center; width: 4%" /> 
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
            <th class="head1 center">Kode Pembelian</th> 
            <th class="head0 center">Tanggal</th> 
            <th class="head1 center">Nama Pengirim</th> 
            <th class="head0 center">Item</th> 
            <th class="head1 center">Jumlah</th> 
            <th class="head0 center">Aksi</th> 
           </tr> 
          </thead> 
          <tbody> 
           <!--?php 
							$no=1;
							foreach ($barang_masuk as $r):
							$item = $this--->m_crud-&gt;ItemIn($r['kd_masuk']); $jmlIn = $this-&gt;m_crud-&gt;JmlIn($r['kd_masuk']); ?&gt; 
           <tr class="gradeX"> 
            <td class="aligncenter"> <span class="center"><input type="checkbox" /></span> </td> 
            <td class="center">
             <!--?php echo $no; ?--></td> 
            <td class="center" width="15%">
             <!--?php echo $r['kd_masuk']; ?--></td> 
            <td class="center" width="13%">
             <!--?php echo $this--->m_crud-&gt;tgl_sql($r['tgl_terima']); ?&gt;</td> 
            <td>
             <!--?php echo $r['kepemilikan']; ?--></td> 
            <td class="center">
             <!--?php echo $item; ?--></td> 
            <td class="center" width="20%">
             <!--?php echo number_format($jmlIn); ?--></td> 
            <td class="center" width="15%"> <a href="&lt;?php echo base_url(); ?&gt;barang/masuk/ubah/&lt;?php echo $r['kd_masuk']; ?&gt;" class="btn btn-primary btn-circle" title="Edit"><i class="iconsweets-create iconsweets-white"></i></a> <a href="&lt;?php echo base_url(); ?&gt;barang/masuk/hapus/&lt;?php echo $r['kd_masuk']; ?&gt;" class="btn btn-danger btn-circle" onclick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !"><i class="iconsweets-trashcan iconsweets-white"></i></a> </td> 
           </tr> 
           <!--?php 
							  $no++;
							  endforeach; ?--> 
          </tbody> 
         </table> 
        </div> 
        <!-- END DAFTAR OBAT----> 
        <!-- TAMBAH OBAT MASUK START ----> 
        <!--?php if(isset($tambah_barang_masuk)):?--> 
        <div id="tambah"> 
         <h4 class="widgettitle">Tambah Stok Data Obat</h4> 
         <div class="row-fluid"> 
          <div class="span6">  
           <table class="table table-bordered table-invoice"> 
            <tbody>
             <tr> 
              <td class="width30">Kode Penerimaan :</td> 
              <td class="width70"><input type="text" id="kodemasuk" name="kodemasuk" readonly="" value="&lt;?php echo $kodemasuk; ?&gt;" style="width:100px; font-size: 13px;" /></td> 
             </tr> 
             <tr> 
              <td>Diterima dari</td> 
              <td> <span class="field"> <select name="kd_milik_obat" id="kd_milik_obat" data-placeholder="Pilih Pengirim Obat..." style="width:230px" class="chzn-select" tabindex="2"></select> <option value=""></option> 
                <!--?php foreach($list_milik_obat as $lmo) : ?--> <option value="&lt;?php echo $lmo['kd_milik_obat']; ?&gt;">
                 <!--?php echo $lmo['kepemilikan']; ?--></option> 
                <!--?php endforeach; ?-->  </span> </td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <div class="span6"> 
           <table class="table table-bordered table-invoice"> 
            <tbody>
             <tr> 
              <td>Tgl Penerimaan</td> 
              <td><strong><input type="text" name="tglterima" id="tgl_terima" value="&lt;?php echo $tgl_terima; ?&gt;" style="width:100px; font-size: 13px;" /></strong></td> 
             </tr> 
             <tr> 
              <td>Nomor SBBK</td> 
              <td><input type="text" name="nosbbk" id="nosbbk" style="width:150px; font-size: 13px;" placeholder="..." /></td> 
             </tr> 
            </tbody>
           </table> 
          </div>
          <!--span6--> 
         </div>
         <!--row-fluid--> 
         <div class="clearfix">
          <br />
         </div> 
         <div class="row-fluid"> 
          <div class="span6"> 
           <table class="table table-bordered table-invoice"> 
            <tbody>
             <tr> 
              <td class="width30">Kode Obat</td> 
              <td class="width70"> <input type="text" name="kd_obat" id="kd_obat" value="&lt;?php echo $kd_obat; ?&gt;" placeholder="..." style="width:100px; font-size: 13px;" /> <button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Barang"><i class="icon-list-alt icon-white"></i></button> </td>
             </tr> 
             <tr> 
              <td>Nama Obat</td> 
              <td><input type="text" name="nama_obat" id="nama_obat" value="&lt;?php echo $nama_obat; ?&gt;" placeholder="..." style="width:300px; font-size: 13px;" readonly="" /> </td> 
             </tr> 
             <tr> 
              <td>Harga Beli</td> 
              <td><input type="text" name="harga_beli" id="harga_beli" value="&lt;?php echo $harga_beli; ?&gt;" placeholder="..." style="width:150px; font-size: 13px;" readonly="" /></td> 
             </tr>  
             <tr> 
              <td>Jumlah</td> 
              <td><input type="text" name="jml" id="jml" value="&lt;?php echo $jml; ?&gt;" placeholder="..." style="width:50px; font-size: 13px;" /> <input type="text" name="sat_kecil_obat" id="sat_kecil_obat" value="&lt;?php echo $sat_kecil_obat; ?&gt;" placeholder="..." style="border:0px; width:80px; font-size: 13px;" readonly="" /> <button type="button" name="simpan" id="simpan" class="btn btn-primary"><i class="icon-ok icon-white"></i> </button> </td> 
             </tr> 
            </tbody>
           </table> 
          </div> 
          <div class="span6"> 
           <table class="table table-bordered table-invoice"> 
            <tbody>
             <tr> 
              <td>Nomor Batch</td> 
              <td><input type="text" id="no_batch" name="no_batch" value="&lt;?php echo $no_batch; ?&gt;" placeholder="..." style="width:150px; font-size: 13px;" /></td> 
             </tr> 
             <tr> 
              <td>Tgl Kadaluarsa</td> 
              <td><strong><input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa" value="&lt;?php echo $tgl_kadaluarsa; ?&gt;" style="width:100px; font-size: 13px;" /></strong></td> 
             </tr>  
             <tr> 
              <td>Total</td> 
              <td><strong><input type="text" name="total" id="total" value="&lt;?php echo $total; ?&gt;" style="width:100px; font-size: 13px;" readonly="" /></strong></td> 
             </tr> 
            </tbody>
           </table> 
          </div>
          <!--span6--> 
         </div>
         <!--row-fluid--> 
         <div class="clearfix">
          <br />
         </div> 
         <table width="100%"> 
          <tbody>
           <tr> 
            <td align="center"> <a href="&lt;?php echo base_url(); ?&gt;barang/masuk/tambah"> <button type="button" name="baru" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a> <button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-print icon-white"></i> Cetak</button> <a href="&lt;?php echo base_url(); ?&gt;barang/masuk"> <button type="button" class="btn btn-inverse"><i class="icon-off icon-white"></i> Tutup</button> </a> </td> 
           </tr> 
          </tbody>
         </table> 
         <div class="clearfix">
          <br /> 
         </div> 
         <div id="tampil_data"></div> 
         <div id="DataBarang" title="Data Barang">
           Cari Kata 
          <input type="text" id="caribarang" class="input-large search-query" placeholder="pencarian" /> 
          <button type="button" name="tutup" id="tutup" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button> 
          <div id="daftarbarang"></div> 
         </div>  
         <!-- END TAMBAH OBAT MASUK ----> 
        </div>
        <!--?php endif;?-->
       </div>
       <!--tabs--> 
      </div>
      <!--span12--> 
     </div>
     <!--row-fluid--> 
    </div>
    <!--contentinner--> 
   </div>
   <!--maincontent--> 
  </div>
  <!--mainright--> 
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
				  $("#harga_beli").val(data.harga_beli);
				  $("#sat_kecil_obat").val(data.sat_kecil_obat);
				  $("#tgl_kadaluarsa").val(data.tgl_kadaluarsa);
				  $("#no_batch").val(data.no_batch);
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
		var kode = $("#kodemasuk").val();
		var string = "kode="+kode;
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/DataDetail",
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
			url		: "<?php echo site_url(); ?>barang/simpan_barang_masuk",
			data	: string,
			cache	: false,
			success	: function(data){
					detailBarang();
					$("#kd_obat").val('');
					$("#nama_obat").val('');
					$("#no_batch").val('');
					$("#jml").val('');
					$("#harga_beli").val('');
					$("#jml").val('');
					$("#total").val('0');
							
					$("#kd_obat").focus();
		
			}
		});
		
		return false();		
	});
	
	
	
	$("#cetak").click(function(){
		var kode	= $("#kodemasuk").val();
		window.open('<?php echo site_url();?>barang/cetak/'+kode);
		return false();
	});
	
	
	
});
</script> 
  <style type="text/css">
#DataBarang {
	font-size:12px;
}
</style>
 </body>
</html>

© 2014 Prettifier.net
Contact | Change Log | Privacy Policy
