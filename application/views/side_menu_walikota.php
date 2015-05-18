<div class="leftpanel">

    <div class="datewidget">
        <?php echo $this->
            functions->
            format_tgl_cetak(date('Y-m-d')); ?>
    </div>


    <div class="leftmenu">

        <ul class="nav nav-tabs nav-stacked">
            <li class="nav-header">
                Main Navigation
            </li>

            <li class="active"><a href="<?php echo base_url(); ?>dash_walikota"><span class="icon-signal"></span> Walikota</a></li>
            <li><a href="<?php echo base_url(); ?>dash_walikota/kecamatan_botim"><span class="iconsweets-home2"></span> Kecamatan Bogor Timur</a>
            <li><a href="<?php echo base_url(); ?>dash_walikota/kecamatan_bogut"><span class="iconsweets-home2"></span> Kecamatan Bogor Utara</a>
            <li><a href="<?php echo base_url(); ?>dash_walikota/kecamatan_tanahsareal"><span class="iconsweets-home2"></span> Kecamatan Bogor Tanah Sareal</a>
            <li><a href="<?php echo base_url(); ?>dash_walikota/kecamatan_bobar"><span class="iconsweets-home2"></span> Kecamatan Bogor Barat</a>
            <li><a href="<?php echo base_url(); ?>dash_walikota/kecamatan_bosel"><span class="iconsweets-home2"></span> Kecamatan Bogor Selatan</a>
        </ul>
    </div><!--leftmenu-->

</div><!--mainleft-->