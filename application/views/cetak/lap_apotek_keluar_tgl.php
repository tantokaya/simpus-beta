<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>

<div class="rightpanel">

 <div class="breadcrumbwidget">
        	<ul class="breadcrumb">
                <li>Master Transaksi <span class="divider">/</span></li>
                <li class="active">Laporan Apotek Detail Keluar per tgl</li>
            </ul>
        </div><!--breadcrumbwidget-->
      <div class="pagetitle">
        	<h1><?php echo $page_title; ?></h1> <span></span>
        </div><!--pagetitle-->
     
	 <div class="maincontent">
	 <div class="contentinner content-dashboard">
            
      <h4 class="widgettitle" >Laporan Transaksi Detail Apotek Keluar</h4>
    <div class="wizard" >
    <form name="my-form" >
	  <table style="border:1px solid grey; background-color:#9932CC; color:white; font-size:10pt;" width="67.5%">
		<tr>
		  <td width="90" style="padding:15px;"><strong>Dari Tanggal</strong></td>
		  <td width="120" >: <input type="text" name="tgl_mulai" id="tgl_mulai"  style="width:80px; font-size: 13px; background-color:#FFFFE0; font-weight: bold; text-align:center;"></td>
		  <td width="30"><strong>s/d</strong></td>
		  <td width="130"><input type="text"  name="tgl_akhir" id="tgl_akhir" style="width:80px; font-size: 13px; background-color:#FFFFE0; font-weight: bold; text-align:center;"></td>
		  <td width="100"><button type="button" id="cari" class="btn btn-inverse"><i class="icon-search icon-white"></i> Cari Data</button></td>
		  <td width="80"><button type="button" id="cetak" class="btn btn-inverse"><i class="icon-print icon-white"></i> Cetak</button></td>
		  <td>
		  <a href="<?php echo base_url(); ?>barang/apotek">
			<button type="button" class="btn btn-inverse"><i class="icon-off icon-white"></i> Tutup</button>
		  </a>
		  </td>
		</tr>
	  </table>
	  <div class="clearfix"><br /></div>
	  <div id="tampil_data"></div>
	 </form>
    </div>
    </div>
</div>	
</div><!-- rightpanel -->


<script type="text/javascript">
var $ = jQuery.noConflict();
$(document).ready(function(){
	
	$("#cari").click(function(){
		var tgl_mulai = $("#tgl_mulai").val();
		var tgl_akhir = $("#tgl_akhir").val();
		
		var string = "tgl_mulai="+tgl_mulai+"&tgl_akhir="+tgl_akhir; //$("#my-form").serialize();
		
		if(tgl_mulai.length==0){
			$("#tgl_mulai").focus();
			return false();
		}
		if(tgl_akhir.length==0){
			$("#tgl_akhir").focus();
			return false();
		}
		
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/lihat_apotek_out",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				$('.bottom-right').notify({
		  			message: {text:'Data sukses ditampilkan..!!'},type:'info'
	 		 	}).show();
			}
		});
		return false();
	});
	$("#cetak").click(function(){
		var tgl_mulai = $("#tgl_mulai").val();
		var tgl_akhir = $("#tgl_akhir").val();
		
		var string = tgl_mulai+"/"+tgl_akhir;
		
		if(tgl_mulai.length==0){
			$("#tgl_mulai").focus();
			return false();
		}
		if(tgl_akhir.length==0){
			$("#tgl_akhir").focus();
			return false();
		}
		
		window.open('<?php echo site_url();?>barang/cetak_lap_apotek_out/'+string);	
	});
	
});
</script>