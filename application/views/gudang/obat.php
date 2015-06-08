<?php if($this->session->flashdata('flash_message') != ""):?>
    <script>
        jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
    </script>
<?php endif;?>
<div class="rightpanel">
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a><span class="divider">/</span>
        </li>
        <li>
            <a href="#">Master Obat</a><span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo $page_title; ?>
        </li>
    </ul>
</div>
<!--breadcrumbwidget-->
<div class="pagetitle">
    <h1><?php echo $page_title; ?></h1>

    <span>Halaman data obat</span>
</div>
<!--pagetitle-->

<div class="maincontent">
<div class="contentinner content-dashboard">
<div class="row-fluid">
<div class="span12">
<div id="tabs">
<ul>
    <?php if(isset($edit_obat)):?>
        <li class="ui-tabs-active">
            <a href="#ubah"><i class="icon-edit"></i>Ubah Data Obat</a>
        </li>
    <?php endif;?>

    <li class="<?php if(!isset($edit_obat))echo 'ui-tabs-active';?>">
        <a href="#list"><i class="icon-align-justify"></i>
            Daftar Obat
        </a>
    </li>
    <li class="">
        <a href="#tambah"><i class="icon-plus"></i>
            Tambah Obat
        </a>
    </li>
</ul>

<!----EDITING FORM STARTS---->
<?php if(isset($edit_obat)):?>
    <div id="ubah">

    <h4 class="widgettitle">Ubah Data Obat</h4>
    <div class="row-fluid">
    <div class="span6">
        <?php foreach ($edit_obat as $row): ?>
        <?php echo form_open('cont_master_farmasi/obat/ubah/do_update/'.$row['kd_obat'], array('class' =>'stdform stdform2', 'id' =>'form_edit')); ?>
        <table class="table table-bordered table-invoice">
            <tr>
                <td>Kode Obat</td>
                <td>
                    <input type="text" name="kd_obat" id="kd_obat" class="input-medium" value="<?php echo $row['kd_obat']; ?>" readonly />
                </td>
            </tr>
            <tr>
                <td>Nama Obat</td>
                <td>
                    <input type="text" name="nama_obat" id="nama_obat" class="input-xlarge" value="<?php echo $row['nama_obat']; ?>" autofocus="true"/>
                </td>
            </tr>
            <tr>
                <td>Tgl. Expired</td>
                <td>
                    <strong>
                        <input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa"  style="width:100px; font-size: 13px;" value="<?php echo $this->m_crud->tgl_sql($row['tgl_kadaluarsa']); ?>"/>
                    </strong>
                </td>
            </tr>
            <tr>
                <td>Golongan Obat</td>
                <td>
                    <select name="kd_gol_obat" id="kd_gol_obat" style="width:250px" class="uniformselect" required>
                        <option value="">
                            Pilih Golongan Obat
                        </option>
                        <?php foreach($list_golongan_obat as $lgo) : ?>
                            <?php
                            if($lgo['kd_gol_obat'] === $row['kd_gol_obat'])
                                echo '<option value="'.$lgo['kd_gol_obat'].'" selected="selected">
                            '.$lgo['gol_obat'].'</option>';
                            else
                                echo '<option value="'.$lgo['kd_gol_obat'].'">'.$lgo['gol_obat'].'</option>';
                            ?>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Satuan Obat</td>
                <td>
                    <select name="kd_sat_kecil_obat" id="kd_sat_kecil_obat" style="width:250px"  class="uniformselect" required>
                        <option value="">
                            Pilih Satuan Kecil Obat
                        </option>
                        <?php foreach($list_satuan_kecil as $lsk) : ?>
                            <?php
                            if($lsk['kd_sat_kecil_obat'] === $row['kd_sat_kecil_obat'])
                                echo '<option value="'.$lsk['kd_sat_kecil_obat'].'" selected="selected">'.$lsk['sat_kecil_obat'].'</option>';
                            else
                                echo '<option value="'.$lsk['kd_sat_kecil_obat'].'">'.$lsk['sat_kecil_obat'].'</option>';
                            ?>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Terapi Obat</td>
                <td>
                    <select name="kd_terapi_obat" id="kd_terapi_obat" style="width:250px" class="uniformselect" required>
                        <option value="">
                            Pilih Terapi Obat
                        </option>
                        <?php foreach($list_terapi_obat as $lto) : ?>
                            <?php
                            if($lto['kd_terapi_obat'] === $row['kd_terapi_obat'])
                                echo '<option value="'.$lto['kd_terapi_obat'].'" selected="selected">'.$lto['terapi_obat'].'</option>';
                            else
                                echo '<option value="'.$lto['kd_terapi_obat'].'">'.$lto['terapi_obat'].'</option>';
                            ?>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Pemilik</td>
                <td>
                    <select name="kd_milik_obat" id="kd_milik_obat" style="width:250px"  class="uniformselect" required>
                        <option value="">Pilih Pemilik Obat</option>
                        <?php foreach($list_milik_obat as $lmo) : ?>
                            <?php
                            if($lmo['kd_milik_obat'] === $row['kd_milik_obat'])
                                echo '<option value="'.$lmo['kd_milik_obat'].'" selected="selected">'.$lmo['kepemilikan'].'</option>';
                            else
                                echo '<option value="'.$lmo['kd_milik_obat'].'">'.$lmo['kepemilikan'].'</option>';
                            ?>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        </table>
    </div>

    <div class="span6">
        <table class="table table-bordered table-invoice">

            <tr>
                <td>Harga Beli</td>
                <td>
                    <input type="text" name="harga_beli" id="harga_beli" class="input-small" value="<?php echo $row['harga_beli']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Harga Jual</td>
                <td>
                    <input type="text" name="harga_jual" id="harga_jual" class="input-small" value="<?php echo $row['harga_jual']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Pabrik</td>
                <td>
                    <input type="text" name="pabrik" id="pabrik" class="input-small" value="<?php echo $row['pabrik']; ?>"/>
                </td>
            </tr>
            <tr>
                <td>Singkatan</td>
                <td>
                    <input type="text" name="singkatan" id="singkatan" class="input-medium" value="<?php echo $row['singkatan']; ?>"/>
                </td>
            </tr>

        </table>
    </div>
    <!--span6-->
    </div>
    <!--row-fluid-->
        <p class="stdformbutton">
            <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Perbaharui</button>
        </p>
    <?php echo form_close(); ?>
    <?php endforeach; ?>
    </div>
    <!--widgetcontent-->

<?php endif;?>
<!---- END EDITING FORM ---->

<!---- DAFTAR OBAT START ---->
<div id="list">
    <?php echo $this->table->generate(); ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
                var oTable = jQuery('#dyntable').dataTable({
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/obat',
                        "bJQueryUI": false,
                        "sPaginationType": "full_numbers",
                        //"aaSortingFixed": [[0,'asc']],
                        "fnDrawCallback": function(oSettings) {
                            jQuery.uniform.update();
                        }
                        ,
                        "iDisplayStart ": 10,
                        "oLanguage": {
                            "sProcessing": "<center><img src='<?php echo base_url(); ?>assets/img/loaders/loader_blue.gif' /></center>"
                        }
                        ,
                        "fnInitComplete": function () {
                            //oTable.fnAdjustColumnSizing();
                        }
                        ,
                        'fnServerData': function (sSource, aoData, fnCallback) {
                            jQuery.ajax
                            ({
                                    'dataType': 'json',
                                    'type': 'POST',
                                    'url': sSource,
                                    'data': aoData,
                                    'success': fnCallback
                                }
                            );
                        }
                    }
                );
            }
        );
    </script>
</div>
<!---- END DAFTAR OBAT---->

<!---- TAMBAH OBAT START ---->
<div id="tambah">
    <h4 class="widgettitle">Data Master Obat</h4>
    <div class="row-fluid">
        <div class="span6">
            <?php echo form_open('cont_master_farmasi/obat/tambah', array('class' =>'tdform stdform2', 'id' =>'form_input')); ?>
            <table class="table table-bordered table-invoice">
                <tr>
                    <td>Kode Obat</td>
                    <td>
                        <input type="text" name="kd_obat" id="kd_obat" class="input-medium" />
                    </td>
                </tr>
                <tr>
                    <td>Nama Obat</td>
                    <td>
                        <input type="text" name="nama_obat" id="nama_obat" class="input-xlarge" />
                    </td>
                </tr>
                <tr>
                    <td>Tgl. Expired</td>
                    <td>
                        <strong>
                            <input type="text" name="tgl_kadaluarsa" id="tgl_kadaluarsa"  style="width:100px; font-size: 13px;" />
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>Golongan Obat</td>
                    <td>
                        <select name="kd_gol_obat" id="kd_gol_obat" style="width:250px" class="chzn-select" tabindex="2" required>
                            <option value="">
                            </option>
                            <?php foreach($list_golongan_obat as $lgo) : ?>
                                <option value="<?php echo $lgo['kd_gol_obat']; ?>">
                                    <?php echo $lgo['gol_obat']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Satuan Obat</td>
                    <td>
                        <select name="kd_sat_kecil_obat" id="kd_sat_kecil_obat" style="width:250px" class="chzn-select" tabindex="2" required>
                            <option value="">
                            </option>
                            <?php foreach($list_satuan_kecil as $lsk) : ?>
                                <option value="<?php echo $lsk['kd_sat_kecil_obat']; ?>">
                                    <?php echo $lsk['sat_kecil_obat']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>Terapi Obat</td>
                    <td>
                        <select name="kd_terapi_obat" id="kd_terapi_obat"  style="width:250px" class="chzn-select" tabindex="2" required>
                            <option value="">
                            </option>
                            <?php foreach($list_terapi_obat as $lto) : ?>
                                <option value="<?php echo $lto['kd_terapi_obat']; ?>">
                                    <?php echo $lto['terapi_obat']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>

        <div class="span6">
            <table class="table table-bordered table-invoice">
                <tr>
                    <td>Harga Beli</td>
                    <td>
                        <input type="text" name="harga_beli" id="generik" class="input-small" />
                    </td>
                </tr>
                <tr>
                    <td>Harga Jual</td>
                    <td>
                        <input type="text" name="harga_jual" id="generik" class="input-small" />
                    </td>
                </tr>
                <tr>
                    <td>Pabrik</td>
                    <td>
                        <input type="text" name="pabrik" id="pabrik" class="input-small" />
                    </td>
                </tr>
                <tr>
                    <td>Singkatan</td>
                    <td>
                        <input type="text" name="singkatan" id="singkatan" class="input-medium" />
                    </td>
                </tr>
                <tr>
                    <td>Pemilik</td>
                    <td>
                        <select name="kd_milik_obat" id="kd_milik_obat" style="width:250px" class="chzn-select" tabindex="2" required>
                            <option value="">
                            </option>
                            <?php foreach($list_milik_obat as $lmo) : ?>
                                <option value="<?php echo $lmo['kd_milik_obat']; ?>">
                                    <?php echo $lmo['kepemilikan']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <!--span6-->

    </div>
    <!--row-fluid-->


    <p class="stdformbutton">
        <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Simpan</button>
        <button type="reset" class="btn btn-success btn-circle"><i class="icon-refresh icon-white"></i> B a t a l</button>
    </p>

    <div class="clearfix" style="margin-bottom: 100px"><br/></div>
    <?php echo form_close();  ?>

    <!---- END TAMBAH OBAT ---->
</div>
<!--tabs-->
</div>
<!--row-fluid-->

</div>
<!--contentinner-->
</div>
<!--maincontent-->
</div>
<!--mainright-->
</div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function(){
            // With Form Validation
            jQuery("#form_edit").validate({
                    rules: {
                        kd_obat: "required",
                        nama_obat: "required",
                        kd_gol_obat: "required",
                        kd_sat_kecil_obat: "required",
                        kd_terapi_obat: "required",

                    }
                    ,
                    messages: {
                        kd_obat: "Kode obat harus diisi!",
                        nama_obat: "Nama obat harus diisi!",
                        kd_gol_obat: "Kode golongan obat harus diisi!",
                        kd_sat_kecil_obat: "Kode satuan kecil obat harus diisi!",
                    }
                    ,
                    highlight: function(label) {
                        jQuery(label).closest('p').addClass('error');
                    }
                    ,
                    success: function(label) {
                        label
                            .text('Ok!').addClass('valid')
                            .closest('p').addClass('success');
                    }
                }
            );

            jQuery("#form_input").validate({
                    rules: {
                        kd_obat: "required",
                        nama_obat: "required",
                        kd_gol_obat: "required",
                        kd_sat_kecil_obat: "required",

                    }
                    ,
                    messages: {
                        kd_obat: "Kode obat harus diisi!",
                        nama_obat: "Nama obat harus diisi!",
                        kd_gol_obat: "Kode golongan obat harus diisi!",
                        kd_sat_kecil_obat: "Kode satuan kecil obat harus diisi!",

                    }
                    ,
                    highlight: function(label) {
                        jQuery(label).closest('p').addClass('error');
                    }
                    ,
                    success: function(label) {
                        label
                            .text('Ok!').addClass('valid')
                            .closest('p').addClass('success');
                    }
                }
            );

        }
    );
</script>