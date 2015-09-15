<script type="text/javascript">
    var $ = jQuery.noConflict();

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


</script>
<style type="text/css">
    .stripe1 {
        background-color:#FBEC88;
    }
    .stripe2 {
        background-color:#FFF;
    }
    .highlight {
        -moz-box-shadow: 1px 1px 2px #fff inset;
        -webkit-box-shadow: 1px 1px 2px #fff inset;
        box-shadow: 1px 1px 2px #fff inset;
        border:             #aaa solid 1px;
        background-color: #fece2f;
    }
</style>
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
        <th class="head0 center">Kode Keluar</th>
        <th class="head1 center">Tanggal</th>
        <th class="head0 center">Item</th>
        <th class="head1 center">Pasien</th>
        <!--            <th class="head0 center">Sta</th>-->
        <th class="head1 center">Aksi</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no=1;
    foreach ($apotek_keluar as $r):
        $item = $this->m_crud->ItemOutApotek($r['kd_keluar']);
        $jmlOutApotek = $this->m_crud->JmlOutApotek($r['kd_keluar']);
        ?>
        <tr class="gradeX">
            <td class="aligncenter">
                <span class="center"><input type="checkbox" /></span>
            </td>
            <td class="center"><?php echo $no; ?></td>
            <td class="center" width="15%"><?php echo $r['kd_keluar']; ?></td>
            <td class="center" width="13%"><?php echo $r['tgl_keluar']; ?></td>
            <td class="center"><?php echo $item; ?></td>
            <td class="center"><?php echo $r['nm_lengkap']; ?></td>
            <!--<td class="left" ><?php echo $r['nama_unit_farmasi']; ?></td>-->
            <td class="center" width="15%">
                <a href="<?php echo site_url();?>barang/cetak_keluar_apotek/<?php echo $r['kd_keluar']; ?>" class="btn btn-warning btn-circle" title="Cetak" target="_blank"><i class="iconsweets-printer iconsweets-white"></i></a>
                <a href="<?php echo base_url(); ?>barang/apotek_keluar/ubah/<?php echo $r['kd_keluar']; ?>" class="btn btn-primary btn-circle" title="Edit"><i class="iconsweets-create iconsweets-white"></i></a>
                <a href="<?php echo base_url(); ?>barang/apotek_keluar/hapus/<?php echo $r['kd_keluar']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
            </td>
        </tr>
        <?php
        $no++;
    endforeach; ?>
    </tbody>
</table>