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
            <a href="#">Master Terapi Obat</a><span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo $page_title; ?>
        </li>
    </ul>
</div>
<!--breadcrumbwidget-->
<div class="pagetitle">
    <h1><?php echo $page_title; ?></h1>

    <span>Halaman manajemen data terapi obat</span>
</div>
<!--pagetitle-->

<div class="maincontent">
    <div class="contentinner content-dashboard">
        <div class="row-fluid">
            <div class="span12">
                <div id="tabs">
                    <ul>
                        <?php if(isset($edit_terapi_obat)):?>
                            <li class="ui-tabs-active">
                                <a href="#ubah"><i class="icon-edit"></i>Ubah Data Terapi Obat</a>
                            </li>
                        <?php endif;?>

                        <li class="<?php if(!isset($edit_terapi_obat))echo 'ui-tabs-active';?>">
                            <a href="#list"><i class="icon-align-justify"></i>Daftar Terapi Obat</a>
                        </li>
                        <li class="">
                            <a href="#tambah"><i class="icon-plus"></i>Tambah Terapi Obat</a>
                        </li>
                    </ul>

                    <!----EDITING FORM STARTS---->
                    <?php if(isset($edit_terapi_obat)):?>
                        <div id="ubah">
                            <h4 class="widgettitle">
                                Ubah Data Terapi Obat
                            </h4>
                            <div class="row-fluid">
                                <div class="span6">
                                    <?php foreach ($edit_terapi_obat as $row): ?>
                                        <?php echo form_open('cont_master_farmasi/terapi_obat/ubah/do_update/'.$row['kd_terapi_obat'], array('class' =>'stdform stdform2', 'id' =>'form_edit')); ?>
                                        <table class="table table-bordered table-invoice">
                                            <tr>
                                                <td>Kode Terapi Obat</td>
                                                <td>
                                                    <input type="text" name="kd_terapi_obat" id="kd_terapi_obat" value="<?php echo $row['kd_terapi_obat']; ?>" class="input-small" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Terapi Obat</td>
                                                <td>
                                                    <input type="text" name="terapi_obat" id="terapi_obat" value="<?php echo $row['terapi_obat']; ?>" class="input-large" />
                                                </td>
                                            </tr>
                                        </table>
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Perbaharui</button>
                                        </p>
                                        <?php echo form_close(); ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <!---- END EDITING FORM ---->

                    <!---- DAFTAR TERAPI OBAT START ---->
                    <div id="list">
                        <?php echo $this->table->generate(); ?>
                        <script type="text/javascript">
                            jQuery(document).ready(function () {
                                    var oTable = jQuery('#dyntable').dataTable({
                                            "bProcessing": true,
                                            "bServerSide": true,
                                            "sAjaxSource": '<?php echo base_url(); ?>datatable_master/terapi_obat',
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
                    <!---- END DAFTAR TERAPI OBAT---->

                    <!---- TAMBAH TERAPI OBAT START ---->
                    <div id="tambah">
                        <h4 class="widgettitle">
                            Data Terapi Obat
                        </h4>
                        <div class="row-fluid">
                            <div class="span6">
                                <?php echo form_open('cont_master_farmasi/terapi_obat/tambah', array('class' =>'stdform stdform2', 'id' =>'form_input')); ?>
                                <table class="table table-bordered table-invoice">
                                    <tr>
                                        <td>Kode Terapi Obat</td>
                                        <td>
                                            <input type="text" name="kd_terapi_obat" id="kd_terapi_obat" class="input-small" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Terapi Obat</td>
                                        <td>
                                            <input type="text" name="terapi_obat" id="terapi_obat" class="input-large" />
                                        </td>
                                    </tr>
                                </table>
                                <p class="stdformbutton">
                                    <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i> Simpan</button>
                                    <button type="reset" class="btn btn-success btn-circle"><i class="icon-refresh icon-white"></i> B a t a l</button>
                                </p>
                                <?php echo form_close();  ?>
                            </div>
                        </div>

                        <!---- END TAMBAH TERAPI OBAT---->
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
                        kd_terapi_obat: "required",
                        terapi_obat: "required",

                    }
                    ,
                    messages: {
                        kd_terapi_obat: "Kode terapi obat harus diisi!",
                        terapi_obat: "Nama terapi obat harus diisi!",
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
                        kd_terapi_obat: "required",
                        terapi_obat: "required",

                    }
                    ,
                    messages: {
                        kd_terapi_obat: "Kode terapi obat harus diisi!",
                        terapi_obat: "Nama terapi obat harus diisi!",
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