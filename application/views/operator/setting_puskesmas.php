<?php if($this->session->flashdata('flash_message') != ""):?>
    <script>
        jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
    </script>
<?php endif;?>
<div class="rightpanel">
    <div class="breadcrumbwidget">
        <ul class="breadcrumb">
            <li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Wilayah dan Puskesmas</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
    </div><!--breadcrumbwidget-->
    <div class="pagetitle">
        <h1><?php echo $page_title; ?></h1> <span>Halaman manajemen data puskesmas</span>
    </div><!--pagetitle-->

    <div class="maincontent">
        <div class="contentinner content-editprofile">
            <h4 class="widgettitle nomargin">..:: Profile Puskesmas ::..</h4>
            <div class="widgetcontent bordered">
                <div class="row-fluid">
                    <div class="span3 profile-left">

                        <h4>Logo</h4>

                        <div class="profilethumb">
                            <a href="">Change Thumbnail</a>
                            <img src="<?php echo base_url(); ?>assets/img/logo.png" alt="" class="img-polaroid" width="141" height="147" />
                        </div><!--profilethumb-->



                    </div><!--span3-->
                    <div class="span9">
                        <form action="editprofile.html" class="editprofileform" method="post">

                            <h4>Informasi Puskesmas</h4>
                            <p>
                                <label  style="width: 125px">Kode PUSKESMAS  :</label>
                                <input type="text" name="firstname" class="input-xlarge" style="font-weight: bold" value="<?php echo $kd_puskesmas; ?>"  readonly/>
                            </p>
                            <p>
                                <label style="width: 125px">NIP KAPUS :</label>
                                <input type="text" name="lastname" class="input-xlarge" style="font-weight: bold" value="<?php echo $nip_kpl; ?>" readonly />
                            </p>
                            <p>
                                <label style="width: 125px">Nama KAPUS :</label>
                                <input type="text" name="location" class="input-xlarge" style="font-weight: bold" value="<?php echo $kpl_puskesmas; ?>" readonly/>
                            </p>
                            <p>
                                <label style="width: 125px">Nama Puskesmas :</label>
                                <input type="text" name="website" class="input-xlarge" style="font-weight: bold" value="<?php echo $nm_puskesmas; ?>" readonly/>
                            </p>
                            <p>
                                <label style="width: 125px">Alamat :</label>
                                <textarea name="about" class="span8" style="font-weight: bold" readonly><?php echo $alamat .', '. $nm_kelurahan .', '. $nm_kecamatan;  echo $nm_kota .'- '. $nm_propinsi; ?></textarea>
                            </p>

                            <br />

                            <h4></h4>
                            <p>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </p>
                        </form>
                    </div><!--span9-->
                </div><!--row-fluid-->
            </div><!--widgetcontent-->
        </div><!--contentinner-->
    </div><!--maincontent-->
</div><!--mainright-->

<script type="text/javascript">
    jQuery(document).ready(function(){
        // jQuery Chosen
        jQuery("#kd_propinsi").chosen().change(function(){
            var kd_propinsi = jQuery("#kd_propinsi").val();
            console.log(kd_propinsi);
            jQuery("#kd_kecamatan").html('').trigger("liszt:updated");

            var html = '';
            jQuery.ajax({
                type: "POST",
                url: '<?php echo base_url().'cont_master_setting/getKota'; ?>',
                data: 'kd_propinsi=' + kd_propinsi,
                success: function(data) {
                    jQuery('#kd_kota').html(data).trigger("liszt:updated");
                },
                error: function(e){
                    alert('Error: ' + e);
                }
            });
        });

        jQuery("#kd_kota").chosen().change(function(){
            var kd_kota = jQuery("#kd_kota").val();
            var html = '';
            jQuery.ajax({
                type: "POST",
                url: '<?php echo base_url().'cont_master_setting/getKecamatan'; ?>',
                data: 'kd_kota=' + kd_kota,
                success: function(data) {
                    jQuery('#kd_kecamatan').html(data).trigger("liszt:updated");
                },
                error: function(e){
                    alert('Error: ' + e);
                }
            });
        });

        jQuery("#kd_kecamatan").chosen().change(function(){
            var kd_kecamatan = jQuery("#kd_kecamatan").val();
            var html = '';
            jQuery.ajax({
                type: "POST",
                url: '<?php echo base_url().'cont_master_setting/getKelurahan'; ?>',
                data: 'kd_kecamatan=' + kd_kecamatan,
                success: function(data) {
                    jQuery('#kd_kelurahan').html(data).trigger("liszt:updated");
                },
                error: function(e){
                    alert('Error: ' + e);
                }
            });
        });

        jQuery("#kd_propinsi2").chosen().change(function(){
            var kd_propinsi = jQuery("#kd_propinsi2").val();
            console.log(kd_propinsi);
            jQuery("#kd_kecamatan2").html('').trigger("liszt:updated");

            var html = '';
            jQuery.ajax({
                type: "POST",
                url: '<?php echo base_url().'cont_master_setting/getKota'; ?>',
                data: 'kd_propinsi=' + kd_propinsi,
                success: function(data) {
                    jQuery('#kd_kota2').html(data).trigger("liszt:updated");
                },
                error: function(e){
                    alert('Error: ' + e);
                }
            });
        });

        jQuery("#kd_kota2").chosen().change(function(){
            var kd_kota = jQuery("#kd_kota2").val();
            console.log(kd_propinsi);
            var html = '';
            jQuery.ajax({
                type: "POST",
                url: '<?php echo base_url().'cont_master_setting/getKecamatan'; ?>',
                data: 'kd_kota=' + kd_kota,
                success: function(data) {
                    jQuery('#kd_kecamatan2').html(data).trigger("liszt:updated");
                },
                error: function(e){
                    alert('Error: ' + e);
                }
            });
        });
        // With Form Validation
        jQuery("#form_edit").validate({
            rules: {
                kd_puskesmas: "required",
                nm_puskesmas: "required",
                alamat: "required",
                kd_kecamatan: "required",
                id_jenis_puskesmas: "required",
            },
            messages: {
                kd_puskesmas: "Kode puskesmas harus diisi!",
                nm_puskesmas: "Nama puskesmas harus diisi!",
                alamat: "Alamat puskesmas harus diisi!",
                kd_kecamatan: "Pilih kecamatan terlebih dahulu!",
                id_jenis_puskesmas: "Pilih jenis puskesmas terlebih dahulu!",
            },
            highlight: function(label) {
                jQuery(label).closest('p').addClass('error');
            },
            success: function(label) {
                label
                    .text('Ok!').addClass('valid')
                    .closest('p').addClass('success');
            }
        });

        jQuery("#form_input").validate({
            rules: {
                kd_puskesmas: "required",
                nm_puskesmas: "required",
                alamat: "required",
                kd_kecamatan: "required",
                id_jenis_puskesmas: "required",

            },
            messages: {
                kd_puskesmas: "Kode puskesmas harus diisi!",
                nm_puskesmas: "Nama puskesmas harus diisi!",
                alamat: "Alamat puskesmas harus diisi!",
                kd_kecamatan: "Pilih kecamatan terlebih dahulu!",
                id_jenis_puskesmas: "Pilih jenis puskesmas terlebih dahulu!",
            },
            highlight: function(label) {
                jQuery(label).closest('p').addClass('error');
            },
            success: function(label) {
                label
                    .text('Ok!').addClass('valid')
                    .closest('p').addClass('success');
            }
        });
    });

</script>