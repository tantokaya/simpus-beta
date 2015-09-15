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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data obat Expired</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
	<div id="tabs">
  	<ul>
		<li class="ui-tabs-active"><a href="#daftar"><i class="icon-align-justify"></i> Daftar Stok Obat Apotek Expired</a></li>
	</ul>
	
	<div id="daftar">
		<h4 class="widgettitle">..:: Tampil Stok Data Obat Apotek Expired ::..</h4>
        <div class="row-fluid">
	<!--<div class="span6">-->
	<form id="form">
		
	
	
	<table>
	<tr>
		<td colspan="3" align="center">
	    <button type="button" name="cari" id="cari" class="btn btn-inverse btn-rounded" ><i class="icon-zoom-in icon-white"></i> Tampil</button>
	    <button type="button" name="cetak" id="cetak" class="btn btn-inverse btn-rounded"><i class="icon-print icon-white"></i> Cetak</button>
	    <a href="<?php echo base_url();?>barang/apotek">
	    <button type="button" name="kembali" id="kembali" class="btn btn-inverse btn-rounded"><i class="icon-off icon-white"></i> Tutup</button>
	    </a>
	    </td>
	</tr>
	</table>  
	
	<div class="clearfix"><br /></div>
	<div id="tampil_data"></div>
	
	</form>
	
	
	</div></div></div></div></div></div></div></div>
	
		
<script type="text/javascript">
var $ = jQuery.noConflict();

$(document).ready(function(){
	$(':input:not([type="submit"])').each(function() {
		$(this).focus(function() {
			$(this).addClass('hilite');
		}).blur(function() {
			$(this).removeClass('hilite');});
	});	
	$("#kd_obat").keyup(function(e){
		var isi = $(e.target).val();
		$(e.target).val(isi.toUpperCase());
	});
	
	$("#cari").click(function(){
		
	 
	DetailBarang ();
	
	function DetailBarang(){
		var kode = $("#kd_obat").val();
		var string = "kode="+kode;
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/lihat_expired_apotek",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				
			}
		});
		
		
	} });
		
	
	
	$("#cetak").click(function(){
		var	pilih	= $(".pilih:checked").val();
		
		if(pilih=='all'){
			var string = pilih;
		}
		
		 
		window.open('<?php echo site_url();?>barang/cetak_obat_apotek_expired/'+string);
		return false();
	});
});	
</script>