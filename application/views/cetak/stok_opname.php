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
    	<h1><?php echo $page_title; ?></h1> <span>Halaman manajemen Stok Opname Gudang</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
							<?php if(isset($edit_stok_opname)):?>
            				<li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Stok Opname Gudang</a></li>
            				<?php endif;?>
							
                        	<?php if(isset($tambah_stok_opname)):?>
            				<li class=""><a href="#tambah"><i class="icon-edit"></i> Stok Opname Gudang</a></li>
            				<?php endif;?>
      						
                            <li class="<?php if(!isset($tambah_stok_opname))echo 'ui-tabs-active';?>">
                                <a href="#list"><i class="icon-align-justify"></i> Daftar Stok Opname Gudang</a>
                            </li>
                        </ul>
                        
                        <!----EDITING FORM STARTS---->
						<?php if(isset($edit_stok_opname)):?>
                        <div id="ubah">
                       		<h4 class="widgettitle nomargin shadowed">..:: Form Ubah Data Stok Opname Gudang ::..</h4>
                            <div class="row-fluid">
							<?php foreach ($edit_stok_opname as $row): ?>
                            	<?php echo form_open('barang/sopname/ubah/do_update/'.$row['opname_code'], array('class' => 'stdform stdform2', 'id' => 'form')); ?>
                                <div class="span6">
								<div class="clearfix"><br /></div>
								
						<form id="form">
						  <table class="table table-bordered table-invoice">
							  <tr>
                                  <td class="width30">Kode Opname :</td>
                                  <td class="width70"><input type="text" id="code" name="code" readonly value="<?php echo $row['opname_code']; ?>"  style="width:100px; font-size: 13px;" ></td>
                              </tr>
								
						  </table>
						  </div>
						  <div class="span6">
						  <div class="clearfix"><br /></div>
						<table class="table table-bordered table-invoice">
							<tr>
                                <td>Tgl Stok Opname</td>
                                <td><strong><input type="text" name="opname_tgl"  id="opname_tgl" value="<?php echo $this->m_crud->tgl_sql($row['opname_tgl']); ?>"  style="width:100px; font-size: 13px;"  /></strong></td>
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
                                      <input type="text" name="kd_obat" id="kd_obat"  placeholder="..." style="width:100px; font-size: 13px;"/>
                                      <button type="button" name="list_barang" id="list_barang" class="btn btn-danger btn-small" title="Cari Barang"><i class="icon-list-alt icon-white"></i></button>
                              </tr>
                              <tr>
                                  <td>On Hand</td>
                                  <td>
                                      <input type="text" name="onhand" id="onhand" value="<?php echo $onhand; ?>" style="width:50px; font-size: 13px;">
                                      <input type="text" name="sat_kecil_obat2" id="sat_kecil_obat2"  style="border:0px; width:80px; font-size: 13px;" readonly>
                                  </td>
                              </tr>
                              <tr>
                                  <td>Jml Fisik</td>
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
                                  <td>Nama Obat</td>
                                  <td><input type="text" name="nama_obat" id="nama_obat" value="<?php echo $nama_obat; ?>"  style="width:300px; font-size: 13px;" readonly></td>
                              </tr>
                              <tr>
                                  <td>Tgl Kadaluarsa</td>
                                  <td><strong><input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa"  value="<?php echo $tgl_kadaluarsa; ?>" style="width:100px; font-size: 13px;" /></strong></td>
                              </tr>
							  
						</table>
						</div>
                        </div><!--span6-->
						
							<div class="clearfix"><br /> </div>
                                <table width="100%">
								    <tr>
										<td align="center">
											<a href="<?php echo base_url(); ?>barang/sopname/tambah">	<button type="button"  name="baru"  class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a>
											<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
											<a href="<?php echo base_url(); ?>barang/sopname">
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

                        <!---- DAFTAR OBAT OPNAME GUDANG START ---->
                        <div id="list">
                            <a href="<?php  echo base_url(); ?>barang/sopname/tambah">
                                <button class="btn btn-warning btn-rounded" title="Tambah Stok Obat">
                                    <i class="icon-plus icon-white"></i> Tambah </button>
                            </a>
                            <a href="<?php  echo base_url(); ?>barang/sopname">
                                <button class="btn btn-success btn-rounded" title="Perbarui Data">
                                    <i class="icon-refresh icon-white"></i> Refresh </button>
                            </a>
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
                                    <th class="head1 center">Kode Opname</th>
                                    <th class="head0 center">Tgl Opname</th>
                                    <th class="head0 center">Jumlah Item</th>
                                    <th class="head0 center">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no=1;
                                foreach ($opname_gudang as $r):
                                    $itemOpname = $this->m_crud->OpnameRec($r['opname_code']);
                                    ?>
                                    <tr class="gradeX">
                                        <td class="aligncenter">
                                            <span class="center"><input type="checkbox" /></span>
                                        </td>
                                        <td class="center"><?php  echo $no; ?></td>
                                        <td class="center" width="15%"><?php  echo $r['opname_code']; ?></td>
                                        <td class="center" width="13%"><?php  echo $this->m_crud->tgl_sql($r['opname_tgl']); ?></td>
                                        <td class="center"><?php  echo $itemOpname; ?></td>
                                        <td class="center" width="15%">
                                            <a href="<?php  echo base_url(); ?>barang/sopname/ubah/<?php  echo $r['opname_code']; ?>" class="btn btn-primary btn-circle" title="Edit">
                                                <i class="iconsweets-create iconsweets-white"></i>
                                            </a>
                                            <a href="<?php  echo base_url(); ?>barang/sopname/hapus/<?php  echo $r['opname_code']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !">
                                                <i class="iconsweets-trashcan iconsweets-white" ></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    $no++;
                                endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!---- END DAFTAR OBAT---->
                        
                        <!---- TAMBAH OBAT OPNAME GUDANG START ---->
						<?php if(isset($tambah_stok_opname)):?>
                        <div id="tambah">
						<h4 class="widgettitle">..:: Form Tambah Stok Opname Gudang ::..</h4>
						<div class="row-fluid">
						
						<div class="span6">
						<form id="form">
						  <table class="table table-bordered table-invoice">
							  <tr>
								  <td class="width30">Kode Opname :</td>
								  <td class="width70"><input type="text" id="code" name="code" readonly value="<?php echo $code; ?>"  style="width:100px; font-size: 13px;" ></td>
							  </tr>
								
						  </table>
						  </div>
						  <div class="span6">
						  <table class="table table-bordered table-invoice">
							<tr>
								<td>Tgl Stok Opname</td>
								<td><strong><input type="text" name="opname_tgl"  id="opname_tgl" value="<?php echo $opname_tgl; ?>"  style="width:100px; font-size: 13px;"  /></strong></td>
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
                                <td>On Hand</td>
                                <td>
                                    <input type="text" name="onhand" id="onhand" value="<?php echo $onhand; ?>" style="width:50px; font-size: 13px;">
                                    <input type="text" name="sat_kecil_obat2" id="sat_kecil_obat2"  style="border:0px; width:80px; font-size: 13px;" readonly>
                                </td>
                            </tr>
                            <tr>
							    <td>Jml Fisik</td>
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
                                <td>Nama Obat</td>
                                <td><input type="text" name="nama_obat" id="nama_obat" value="<?php echo $nama_obat; ?>"  style="width:300px; font-size: 13px;" readonly></td>
                            </tr>
						    <tr>
								<td>Tgl Kadaluarsa</td>
								<td><strong><input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa"  value="<?php echo $tgl_kadaluarsa; ?>" style="width:100px; font-size: 13px;" /></strong></td>
							</tr>
                            <tr>
                                <td>Selisih</td>
                                <td>
                                    <input type="text" name="selisih" id="selisih" value="<?php echo $selisih; ?>" style="width:50px; font-size: 13px;" readonly>
                                    <input type="text" name="sat_kecil_obat3" id="sat_kecil_obat3" value="<?php echo $sat_kecil_obat; ?>" placeholder="..." style="border:0px; width:80px; font-size: 13px;" readonly>
                                </td>
                            </tr>
						</table>
						</div><!--span6-->
						</div><!--row-fluid-->
						<div class="clearfix"><br /></div>
						<table width="100%">
						<tr>
							<td align="center">
                                <a href="<?php echo base_url(); ?>barang/sopname/tambah">	<button type="button"  name="baru"  class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a>
									<button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
								<a href="<?php echo base_url(); ?>barang/sopname">
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



/* ------------------------------- HITUNG SELISIH ------------------------- */
    function hitung(){
        var jml         = $("#jml").val();
        var selisih     = $("#selisih").val();
        var onhand      = $("#onhand").val();

        if(jml.length > 0  && selisih.length>0){
            var selisih = parseInt(onhand)-parseInt(jml);

            $("#selisih").val(selisih);
        }else{
            $("#selisih").val(0);
        }

    }
    $("#jml").keyup(function(){
        hitung();
    });
    $("#selisih").keyup(function(){
        hitung();
    });

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
                $("#onhand").val(data.onhand);
                $("#sat_kecil_obat").val(data.sat_kecil_obat);
                $("#sat_kecil_obat2").val(data.sat_kecil_obat);
                $("#sat_kecil_obat3").val(data.sat_kecil_obat);
                $("#onhand").val(data.obat_stok);

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

    detailBarang();
    DataBarang();

    function detailBarang(){
        var kode = $("#code").val();
        var string = "code="+kode;
        //alert(kode);
        $.ajax({
            type	: 'POST',
            url		: "<?php echo site_url(); ?>barang/DataDetailOpname",
            data	: string,
            cache	: false,
            success	: function(data){
                $("#tampil_data").html(data);

            }
        });

    }

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

        var string = $("#form").serialize();

        if(kode.length==0){
            // alert box
            jAlert('Maaf, Kode Obat Masih Kosong.', 'Informasi !');

            $("#kd_obat").focus();
            return false();
        }

        $.ajax({
            type	: 'POST',
            url		: "<?php echo site_url(); ?>barang/simpan_stok_opname",
            data	: string,
            cache	: false,
            success	: function(data){
                jQuery.jGrowl('<span style="color: yellow;"> INFORMASI !</span><span style="color: #ffffff; "> <br/> Data sudah di Simpan ! </span>');
                detailBarang();
            }
        });

        return false();
    });
	
	$("#baru").click(function(){
		$("#kd_obat").val('');
		$("#nama_obat").val('');
		$("#jml").val('');

		$("#kd_obat").focus();
		
	});
	
	$("#cetak").click(function(){
		var kode	= $("#code").val();
		window.open('<?php echo site_url();?>barang/cetak_stok_opname/'+kode);
		return false();
	});


	
});
</script>
<style type="text/css">
#DataBarangApotek {
	font-size:12px;
}
</style>