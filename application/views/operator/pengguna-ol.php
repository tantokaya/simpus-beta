<?php if($this->session->flashdata('flash_message') != ""):?>
    <script>
        jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
    </script>
<?php endif;?>
<div class="rightpanel">
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>

        <span class="divider">/</span>
        </li>
        <li>
            <a href="#">Setting Aplikasi</a>

        <span class="divider">/</span>
        </li>
        <li class="active">
            <?php echo $page_title; ?>
        </li>
    </ul>
</div>
<!--breadcrumbwidget-->
<div class="pagetitle">
    <h1>
        <?php echo $page_title; ?>
    </h1>

    <span>
      Halaman manajemen data pengguna
    </span>
</div>
<!--pagetitle-->

<div class="maincontent">
<div class="contentinner content-dashboard">
<div class="row-fluid">
<div class="span12">
<div id="tabs">
<ul>
    <?php if(isset($edit_pengguna)):?>
        <li class="ui-tabs-active">
            <a href="#ubah">
                <i class="icon-edit"></i>
                Ubah Data Pengguna
            </a>
        </li>
    <?php endif;?>

    <li class="<?php if(!isset($edit_pengguna))echo 'ui-tabs-active';?>">
        <a href="#list">
            <i class="icon-align-justify"></i>
            Daftar Pengguna
        </a>
    </li>
    <li class="">
        <a href="#tambah">
            <i class="icon-plus"></i>
            Tambah Pengguna
        </a>
    </li>
</ul>

<!----EDITING FORM STARTS---->
<?php if(isset($edit_pengguna)):?>
    <div id="ubah">
        <h4 class="widgettitle nomargin shadowed">
            Ubah Data Pengguna
        </h4>
        <div class="widgetcontent bordered shadowed nopadding">
            <?php foreach ($edit_pengguna as $row): ?>
                <?php echo form_open('cont_master_setting/pengguna/ubah/do_update/'.$row['id_user'], array('class' =>'stdform stdform2', 'id' =>'form_edit')); ?>
                <p>
                    <label>Nama Lengkap</label>
                            <span class="field">
                              <input type="text" name="nama" id="nama2" value="<?php echo $row['nama'] ?>" class="input-xxlarge" />
                            </span>
                </p>
                <p>
                    <label>
                        NIP
                    </label>
                            <span class="field">
                              <input type="text" name="nip" id="nip2" value="<?php echo $row['nip'] ?>" maxlength="18" size="18" class="input-xxlarge" />
                            </span>
                </p>
                <p>
                    <label>
                        Email
                    </label>
                            <span class="field">
                              <input type="text" name="email" id="email2" value="<?php echo $row['email'] ?>" class="input-xxlarge" />
                            </span>
                </p>
                <p>
                    <label>
                        Group
                    </label>
                            <span class="field">
                              <select name="id_akses" id="id_akses2" data-placeholder="Pilih Grup Pengguna" style="width:350px" class="uniform-select" required>
                                  <option value="">
                                  </option>
                                  <?php foreach($list_grup as $lg) : ?>
                                      <?php echo '<option value="'.$lg['id_akses'].'">'.$lg['akses'].'</option>'; ?>
                                  <?php endforeach; ?>
                              </select>
                                  <script type="text/javascript">
                                      jQuery("#id_akses2").val(<?php echo $row['id_akses'] ?>).trigger("liszt:updated");
                                  </script>
                                </span>
                </p>

<?php foreach($list_puskesmas as $lp) : ?>
<?php
                    if($lp['kd_puskesmas'] === $row['kd_puskesmas'])
                        echo '
<option value="'.$lp['kd_puskesmas'].'" selected="selected">
'.$lp['nm_puskesmas'].'
</option>
';
                    else
                        echo '
<option value="'.$lp['kd_puskesmas'].'">
'.$lp['nm_puskesmas'].'
</option>
';
                    ?>
<?php endforeach; ?>
</select>
</span>
</p>
-->

                <p class="stdformbutton">
                    <button class="btn btn-primary">
                        Perbaharui
                    </button>
                    <button type="reset" class="btn">
                        Reset
                    </button>
                </p>
                <?php echo form_close(); ?>
            <?php endforeach; ?>
        </div>
        <!--widgetcontent-->
    </div>
<?php endif;?>
<!---- END EDITING FORM ---->

<!---- DAFTAR PENGGUNA START ---->
<div id="list">

    <?php echo $this->
        table->
        generate(); ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
                var oTable = jQuery('#dyntable').dataTable({
                        "bProcessing": true,
                        "bServerSide": true,
                        "sAjaxSource": '<?php echo base_url(); ?>datatable_master/pengguna',
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
<!---- END DAFTAR PENGGUNA ---->

<!---- TAMBAH PENGGUNA START ---->
<div id="tambah">
    <h4 class="widgettitle">
        Data Pengguna
    </h4>
    <div class="row-fluid">
        <div class="span12">
            <?php echo form_open('cont_master_setting/pengguna/tambah', array('class' =>'stdform stdform2', 'id' =>'form_input')); ?>
            <table class="table table-bordered table-invoice">
                <tr>
                    <td>N I P</td>
                    <td>
                        <input type="text" name="nip" id="nip" maxlength="18" size="18" class="input-large" />
                    </td>
                </tr>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>
                        <input type="text" name="nama" id="nama" class="input-large" />
                    </td>
                </tr>

                <tr>
                    <td>Group</td>
                    <td>
                        <select name="id_akses" id="id_akses" data-placeholder="Pilih Grup Pengguna" class="chzn-select" required>
                            <option value="">
                            </option>
                            <?php foreach($list_grup as $lg) : ?>
                                <option value="<?php echo $lg['id_akses']; ?>">
                                    <?php echo $lg['akses']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" id="username" class="input-medium"></td>
                </tr>
                <tr>
                    <td>E-mail</td>
                    <td>
                        <input type="text" name="email" id="email" class="input-large" />
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" id="password" class="input-small" />
                    </td>
                </tr>
                <tr>
                    <td>Re-Password</td>
                    <td>
                        <input type="password" name="re_pass" id="re_pass" class="input-small" />
                    </td>
                </tr>

            </table>

            <p class="stdformbutton">
                <button class="btn btn-primary btn-rounded">
                    <i class="icon-ok icon-white"></i>Simpan</button>
                <button type="reset" class="btn btn-success btn-rounded">
                    <i class="icon-repeat icon-white"></i>Reset</button>
            </p>
            <?php echo form_close();  ?>
        </div>
        <!--widgetcontent-->
    </div>
    <div class="clearfix" style="margin-bottom:100px">
    </div>
</div>
<!---- END TAMBAH PENGGUNA ---->
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
    jQuery(document).ready(function(){
            // With Form Validation
            jQuery("#form_edit").validate({
                    rules: {
                        nama: {
                            required: true,
                            minlength: 4
                        }
                        ,
                        nip: {
                            required: true,
                            minlength: 9
                        }
                        ,
                        username: {
                            required: true,
                            minlength: 3
                        }
                        ,
//                        email: {
//                            required: true,
//                            email: true
//                        }
//                        ,
                        password: {
                            required: true,
                            minlength: 5
                        }
                        ,
                        re_pass: {
                            required: true,
                            minlength: 5,
                            equalTo: "#password"
                        }
                        ,
                        id_akses: {
                            required: true
                        }
                        ,
                        kd_puskesmas: {
                            required: true
                        }
                    }
                    ,
                    messages: {
                        nama: "Nama harus diisi!",
                        nip: "NIP harus diisi minimal 9 digit!",
                        username: "Username harus diisi !",
//                        email: "Email harus diisi dan valid!",
                        password: "Password harus diisi!",
                        re_pass: "Re-Password harus diisi dan sesuai dengan isian password!",
                        id_akses: "Pilih Grup Pengguna!",
                        kd_puskesmas: "Pilih Puskesmas!",
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
                        nama: {
                            required: true,
                            minlength: 4
                        }
                        ,
                        nip: {
                            required: true,
                            minlength: 9
                        }
                        ,
                        username: {
                            required: true,
                            minlength: 3
                        }
                        ,
//                        email: {
//                            required: true,
//                            email: true
//                        }
//                        ,
                        password: {
                            required: true,
                            minlength: 5
                        }
                        ,
                        re_pass: {
                            required: true,
                            minlength: 5,
                            equalTo: "#password"
                        }
                        ,
                        id_akses: {
                            required: true
                        }
                        ,
                        kd_puskesmas: {
                            required: true
                        }
                    }
                    ,
                    messages: {
                        nama: "Nama harus diisi!",
                        nip: "NIP harus diisi minimal 9 digit!",
                        username: "Username harus diisi !",
//                        email: "Email harus diisi dan valid!",
                        password: "Password harus diisi!",
                        re_pass: "Re-Password harus diisi dan sesuai dengan isian password!",
                        id_akses: "Pilih Grup Pengguna!",
                        kd_puskesmas: "Pilih Puskesmas!",
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
