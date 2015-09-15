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
                <a href="#">Profile Puskesmas</a><span class="divider">/</span>
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
      Halaman manajemen profile puskesmas
    </span>
    </div>
    <!--pagetitle-->

    <div class="maincontent">
        <div class="contentinner content-dashboard">
            <div class="row-fluid">
                <div class="span12">
                    <div id="tabs">
                        <ul>
                            <?php if(isset($edit_profil_puskesmas)):?>
                                <li class="ui-tabs-active">
                                    <a href="#ubah"><i class="icon-edit"></i>Ubah Data Profil Puskesmas</a>
                                </li>
                            <?php endif;?>

                            <li class="<?php if(!isset($edit_profil_puskesmas))echo 'ui-tabs-active';?>">
                                <a href="#list"><i class="icon-align-justify"></i>Profil</a>
                            </li>
                        </ul>

                        <!----EDITING FORM STARTS---->
                        <?php if(isset($edit_profil_puskesmas)):?>
                            <div id="ubah">
                                <h4 class="widgettitle">Ubah Data Profil Puskesmas</h4>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <?php foreach ($edit_profil_puskesmas as $row_edit): ?>
                                            <?php echo form_open('cont_master_setting/setting_puskesmas/ubah/do_update/'.$row_edit['kd_puskesmas'], array('class' =>'stdform stdform2', 'id' =>'form_edit', 'enctype' =>'multipart/form-data')); ?>
                                            <table class="table table-bordered table-invoice">
                                                <tr>
                                                    <td>Kode Puskesmas</td>
                                                    <td>
                                                        <input type="text" name="kd_puskesmas" id="kd_puskesmas" value="<?php echo $row_edit['kd_puskesmas']; ?>" class="input-medium" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Nama Puskesmas</td>
                                                    <td>
                                                        <input type="text" name="nm_puskesmas" id="nm_puskesmas" value="<?php echo $row_edit['nm_puskesmas']; ?>" class="input-medium" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Propinsi</td>
                                                    <td>
                                                        <select name="kd_propinsi" id="kd_propinsi" class="uniformselect" >
                                                            <option value="">Pilih Propinsi</option>
                                                            <?php foreach($list_propinsi as $lp) : ?>
                                                                <?php
                                                                if ($lp['kd_propinsi'] === $row_edit['kd_propinsi'])
                                                                    echo '<option value="'.$lp['kd_propinsi'].'" selected>'.$lp['nm_propinsi'].'</option>';
                                                                else
                                                                    echo '<option value="'.$lp['kd_propinsi'].'">'.$lp['nm_propinsi'].'</option>';
                                                                ?>
                                                            <?php endforeach; ?>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kota</td>
                                                    <td>
                                                        <select name="kd_kota" id="kd_kota" class="uniformselect" >
                                                            <option value="">Pilih Kota</option>
                                                            <?php foreach($list_kota as $lko) : ?>
                                                                <?php
                                                                if ($lko['kd_kota'] === $row_edit['kd_kota'])
                                                                    echo '<option value="'.$lko['kd_kota'].'" selected>'.$lko['nm_kota'].'</option>';
                                                                else
                                                                    echo '<option value="'.$lko['kd_kota'].'">'.$lko['nm_kota'].'</option>';
                                                                ?>
                                                            <?php endforeach; ?>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kecamatan</td>
                                                    <td>
                                                        <select name="kd_kecamatan" id="kd_kecamatan" class="uniformselect" >
                                                            <option value="">Pilih Kecamatan</option>
                                                            <?php foreach($list_kecamatan as $lke) : ?>
                                                                <?php
                                                                if ($lke['kd_kecamatan'] === $row_edit['kd_kecamatan'])
                                                                    echo '<option value="'.$lke['kd_kecamatan'].'" selected>'.$lke['nm_kecamatan'].'</option>';
                                                                else
                                                                    echo '<option value="'.$lke['kd_kecamatan'].'">'.$lke['nm_kecamatan'].'</option>';
                                                                ?>
                                                            <?php endforeach; ?>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kelurahan</td>
                                                    <td>
                                                        <select name="kd_kelurahan" id="kd_kelurahan" class="uniformselect" >
                                                            <option value="">Pilih Kelurahan</option>
                                                            <?php foreach($list_kelurahan as $lk) : ?>
                                                                <?php
                                                                if ($lk['kd_kelurahan'] === $row_edit['kd_kelurahan'])
                                                                    echo '<option value="'.$lk['kd_kelurahan'].'" selected>'.$lk['nm_kelurahan'].'</option>';
                                                                else
                                                                    echo '<option value="'.$lk['kd_kelurahan'].'">'.$lk['nm_kelurahan'].'</option>';
                                                                ?>
                                                            <?php endforeach; ?>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Alamat Puskesmas</td>
                                                    <td>
                                                        <textarea name="alamat" class="span8" cols="30"><?php echo $row_edit['alamat']; ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Upload Logo</td>
                                                    <td>
                                                        <img src="<?php echo base_url(); ?>assets/img/thumbs/<?php echo $row_edit['logo']; ?>" alt="" class="img-polaroid" width="141" height="147" />
                                                        <input type="file" class="uniform-file" name="userfile">
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

                        <!---- SETTING PROFIL PUSKESMAS START ---->
                        <div id="list">
                            <h4 class="widgettitle nomargin">..:: Profile Puskesmas ::..</h4>
                            <div class="widgetcontent bordered">
                                <div class="row-fluid">
                                    <div class="span3 profile-left">
                                        <?php foreach ($data_profile as $row_prof): ?>
                                        <h4>Logo</h4>

                                        <div class="profilethumb">
                                            <a href="">Change Thumbnail</a>
                                            <img src="<?php echo base_url(); ?>assets/img/thumbs/<?php echo $row_prof['logo']; ?>" alt="" class="img-polaroid" width="141" height="147" />
                                        </div><!--profilethumb-->

                                    </div><!--span3-->
                                    <div class="span9">
<!--                                        --><?php //foreach ($data_profile as $row_prof): ?>
                                        <h4>Informasi Puskesmas</h4>
                                            <p>
                                                <label  style="width: 125px">Kode PUSKESMAS  :</label>
                                                <input type="text" name="kd_puskesmas" class="input-xlarge" style="font-weight: bold" value="<?php echo $row_prof['kd_puskesmas']; ?>"  readonly/>
                                            </p>
                                            <p>
                                                <label style="width: 125px">NIP KAPUS :</label>
                                                <input type="text" name="nip" class="input-xlarge" style="font-weight: bold" value="<?php echo $row_prof['nip_kpl']; ?>" readonly />
                                            </p>
                                            <p>
                                                <label style="width: 125px">Nama KAPUS :</label>
                                                <input type="text" name="kpl_puskesmas" class="input-xlarge" style="font-weight: bold" value="<?php echo $row_prof['kpl_puskesmas']; ?>" readonly/>
                                            </p>
                                            <p>
                                                <label style="width: 125px">Nama Puskesmas :</label>
                                                <input type="text" name="nm_puskesmas" class="input-xlarge" style="font-weight: bold" value="<?php echo $row_prof['nm_puskesmas']; ?>" readonly/>
                                            </p>
                                            <p>
                                                <label style="width: 125px">Alamat :</label>
                                                <textarea name="about" class="span8" style="font-weight: bold" readonly><?php echo $row_prof['alamat'] .', '. $row_prof['nm_kelurahan'] .', '. $row_prof['nm_kecamatan'];  echo ', '. $row_prof['nm_kota'] .'- '. $row_prof['nm_propinsi']; ?></textarea>
                                            </p>

                                            <br />

                                            <h4></h4>
                                               <a href="<?php echo base_url(); ?>cont_master_setting/setting_puskesmas/ubah/<?php echo $row_prof['kd_puskesmas']; ?>"> <button class="btn btn-primary btn-circle"><i class="icon-ok icon-white"></i>  Perbaharui</button></a>
                                        <?php endforeach; ?>
                                    </div><!--span9-->
                                </div><!--row-fluid-->
                            </div><!--widgetcontent-->
<!--                        </div>-->
                        <!---- END SETTING PROFIL PUSKESMAS ---->


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
