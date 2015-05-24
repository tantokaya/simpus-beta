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
    <?php if(isset($edit_keluar_apotek)):?>
        <li class="ui-tabs-active"><a href="#ubah"><i class="icon-edit"></i> Ubah Data Obat Apotek Keluar</a></li>
    <?php endif;?>

    <?php if(isset($keluar_stok_apotek)):?>
        <li class=""><a href="#tambah"><i class="icon-edit"></i> Obat Apotek Keluar</a></li>
    <?php endif;?>

    <li class="<?php if(!isset($keluar_stok_apotek))echo 'ui-tabs-active';?>"><a href="#list"><i class="icon-align-justify"></i> Daftar Obat Keluar Apotek</a></li>
</ul>

<!----EDITING FORM STARTS---->
<?php if(isset($edit_keluar_apotek)):?>
    <div id="ubah">
        <h4 class="widgettitle ">Ubah Data Obat Keluar</h4>
        <div class="row-fluid">
            <?php foreach ($edit_keluar_apotek as $row): ?>
            <?php echo form_open('barang/apotek/keluar/ubah/do_update/'.$row['kd_keluar'], array('class' => 'stdform stdform2', 'id' => 'form')); ?>

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
                        <td>No Trans Pelayanan</td>
                        <td><input type="text" name="no_tr" id="no_tr" style="width:200px; font-size: 12px; " value="<?php echo $no_tr; ?>" placeholder="..." readonly/></td>
                    </tr>
                    <tr>
                        <td>Nama Pasien</td>
                        <td><input type="text" name="nm_lengkap" id="nm_lengkap" style="width:200px; font-size: 12px; " value="<?php echo $nm_lengkap; ?>" placeholder="..." readonly></td>
                    </tr>
                </table>
            </div><!--span6-->
        </div><!--row-fluid-->
        <div class="clearfix"><br /></div>
        <!--<button type="button" name="baru" id="baru" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> Tambah Obat</button>-->
        <button type="button" name="list_resep" id="list_resep" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> Panggil Resep</button>
        <!--<input type="text" style="width:100px; font-size: 15px; " name="kd_resep" id="kd_obat" value="" placeholder="..." />	-->
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
                    <a href="<?php echo base_url(); ?>barang/apotek_keluar/tambah">	<button type="button"  name="baru"  class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a>
                    <button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
                    <a href="<?php echo base_url(); ?>barang/apotek">
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

<!---- DAFTAR OBAT START ---->
<div id="list">
    <table>
        <tr>
            <td colspan="3" align="center">
                <button type="button" name="cari_keluar" id="cari_keluar" class="btn btn-inverse btn-rounded" ><i class="icon-zoom-in icon-white"></i> Tampil</button>
            </td>
        </tr>
    </table>

    <div class="clearfix"><br /></div>
    <div id="tampil_data_keluar"></div>
</div>
<!---- END DAFTAR OBAT---->

<!---- TAMBAH OBAT MASUK START ---->
<?php if(isset($keluar_stok_apotek)):?>
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
                    <td>No Trans Pelayanan</td>
                    <td><input type="text" name="no_tr" id="no_tr" style="width:200px; font-size: 12px; " value="<?php echo $no_tr; ?>" placeholder="..." readonly/></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td><input type="text" name="nm_lengkap" id="nm_lengkap" style="width:200px; font-size: 12px; " value="<?php echo $nm_lengkap; ?>" placeholder="..." readonly></td>
                </tr>
            </table>
        </div><!--span6-->
    </div><!--row-fluid-->

    <div class="clearfix"><br /></div>
    <!--<button type="button" name="baru" id="baru" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i> Tambah Obat</button>-->
    <button type="button" name="list_resep" id="list_resep" class="btn btn-success"><i class="icon-plus-sign icon-white"></i> Panggil Resep</button>
    <!--<input type="text" style="width:100px; font-size: 15px; " name="kd_resep" id="kd_obat" value="<?php echo $kd_resep; ?>" placeholder="..." />			 -->
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
                <tr>
                    <td>Keterangan</td>
                    <td>
                        <!--                                    <input type="text" name="keterangan"  id="keterangan" data-placeholder="Pilih Keterangan..." value="--><?php //echo $keterangan; ?><!--"  class="input-xlarge"  />-->
                        <select name="keterangan" id="keterangan" >
                            <option value="Normal" selected>Normal</option>
                            <option value="Sisa">Sisa</option>
                        </select>
                    </td>
                </tr>

            </table>
        </div><!--span6-->
    </div><!--row-fluid-->
    <div class="clearfix"><br /></div>
    <table width="100%">
        <tr>
            <td align="center">

                <a href="<?php echo base_url(); ?>barang/apotek_keluar/tambah">	<button type="button"  name="baru"  class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Baru</button> </a>
                <button type="button" name="cetak" id="cetak" class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Cetak</button>
                <a href="<?php echo base_url(); ?>barang/apotek">
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


    <!--                       	    <div id="tampil_data2"></div>-->
    <div id="DataResep" title="Data Resep">
        Nomor Layanan &nbsp;<input type="text" id="cariresep" class="input-large search-query" placeholder="pencarian">
        <button type="button" name="tutup2" id="tutup2" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
        <div id="daftarresep"></div>
    </div>

    <div id="DataPasien" title="Data Pasien">
        Nomor Layanan &nbsp;<input type="text" id="caripasien" class="input-large search-query" placeholder="pencarian">
        <button type="button" name="tutup_pasien" id="tutup_pasien" class="btn btn-small btn-info"><i class="icon-off icon-white"></i> Tutup</button>
        <div id="daftarpasien"></div>
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
    DataBarangApotek();
    DataResep();
    DataPasien();

    function detailBarang(){
        var kode = $("#kodekeluar").val();
        var string = "kode="+kode;
        //alert(kode);
        $.ajax({
            type	: 'POST',
            url		: "<?php echo site_url(); ?>barang/DataDetailApotekKeluar",
            data	: string,
            cache	: false,
            success	: function(data){
                $("#tampil_data").html(data);

            }
        });

    }

//////////////////////////////* AUTOCOMPLETE KODE PASIEN */////////////////////////

    $("#no_tr").focus(function(e){
        var isi = $(e.target).val();
        CariKodeTRPasien();
    });

    $("#no_tr").keyup(function(){
        CariKodeTRPasien();
    });

    function CariKodeTRPasien(){
        var kodetr = $("#no_tr").val();
        $.ajax({
            url	: "<?php echo site_url('ref_json/CariTRPasien'); ?>",
            data	: "kode="+kodetr,
            cache	: false,
            dataType: "json",
            type	: "POST",
            success: function(data){
                $("#nm_lengkap").val(data.bio_nama);
            }
        });
    }


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

//////////////////////////* SCRIPT OPEN DIALOGUE CARI PASIEN *////////////////////////////
    function DataPasien(){
        var cari = $("#caripasien").val();
        var string = "cari="+cari;
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

    $("#list_pasien").click(function() {
        $("#DataPasien").dialog("open");
    });
    $("#tutup_pasien").click(function() {
        $("#DataPasien").dialog("close");
    });

    $("#caripasien").keyup(function(){
        DataPasien();
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
            url		: "<?php echo site_url(); ?>barang/simpankeluarApotek",
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
        window.open('<?php echo site_url();?>barang/cetak_keluar_apotek/'+kode);
        return false();
    });


////////////////////    Call resep      //////////////////////////////////////////////////

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

/////////////*  Data Apotek Keluar  *//////////////////////////////
    $("#cari_keluar").click(function(){

        DetailBarang_keluar ();

        function DetailBarang_keluar(){
            var kode = $("#kd_obat").val();
            var string = "kode="+kode;
            //alert(kode);
            $.ajax({
                type	: 'POST',
                url		: "<?php echo site_url(); ?>barang/lihat_apotek_keluar",
                data	: string,
                cache	: false,
                success	: function(data){
                    $("#tampil_data_keluar").html(data);

                }
            });


        } });

});
</script>
<style type="text/css">
    #DataBarangApotek, #DataBarangApotek {
        font-size:12px;
    }
</style>