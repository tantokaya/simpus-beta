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
        <div class="contentinner content-dashboard">
            <div class="row-fluid">
                <div class="span12">

                    <h4 class="widgettitle">Data Puskesmas</h4>
                    <div class="row-fluid">
                        <div class="span6">
                            <?php echo form_open('cont_master_setting/simpan', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                            <table class="table table-bordered table-invoice">
                                <tr>
                                    <td>Kode Puskesmas</td>
                                    <td><input type="text" name="kd_puskesmas" id="kd_puskesmas" class="input-medium" value="<?php echo $kd_puskesmas; ?>"/></td>
                                </tr>
				<tr>
                                    <td>N I P</td>
                                    <td><input type="text" name="nip_kpl" id="nip_kpl" class="input-xlarge" value="<?php echo $nip_kpl; ?>"/></td>
                                </tr>
                                
                                <tr>
                                    <td>Kepala Puskesmas</td>
                                    <td><input type="text" name="kpl_puskesmas" id="kpl_puskesmas" class="input-xlarge" value="<?php echo $kpl_puskesmas; ?>"/></td>
                                </tr>
                                <tr>
                                    <td>Nama Puskesmas</td>
                                    <td><input type="text" name="nm_puskesmas" id="nm_puskesmas" class="input-xlarge" value="<?php echo $nm_puskesmas; ?>"/></td>
                                </tr>
                                <tr>
                                    <td>Propinsi *</td>
                                    <td>
                                        <select name="kd_propinsi" id="kd_propinsi" data-placeholder="Pilih Propinsi" style="width:250px" class="chzn-select" tabindex="2" required>
                                            <option value=""></option>
                                            <?php foreach($list_provinsi as $lp) : ?>
                                                <option value="<?php echo $lp['kd_propinsi']; ?>"><?php echo $lp['nm_propinsi']; ?></option>


                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kota / Kabupaten *</td>
                                    <td>
                                        <select name="kd_kota" id="kd_kota" data-placeholder="Pilih Kota" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kecamatan *</td>
                                    <td>
                                        <select name="kd_kecamatan" id="kd_kecamatan" data-placeholder="Pilih Kecamatan" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kelurahan *</td>
                                    <td>
                                        <select name="kd_kelurahan" id="kd_kelurahan" data-placeholder="Pilih Kelurahan" style="width:250px" class="chzn-select" required>
                                            <option value=""></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Alamat Puskesmas</td>
                                    <td><textarea name="alamat" id="alamat" class="input-xlarge" rows="3"><?php echo $alamat; ?></textarea></td>
                                </tr>

                            </table>
                            <p class="stdformbutton">
                                <button class="btn btn-inverse"><i class="icon-ok-circle icon-white"></i> Simpan</button>

                            </p>

                            <?php echo form_close();  ?>
                        </div><!--widgetcontent-->
                    </div>
                    <!---- END TAMBAH PUSKESMAS---->
                </div><!--tabs-->
            </div><!--row-fluid-->
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