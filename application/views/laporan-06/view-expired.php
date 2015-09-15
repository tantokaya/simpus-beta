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
	<!--<table id="dataTable" width="100%">-->
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
            <th class="head0 center">Kode Obat</th>
            <th class="head1 center">Nama Obat</th>
            <th class="head1 center">Stok Akhir</th>
            <th class="head1 center">Expired</th>
            <th class="head0 center">Status Exp.</th>
        </tr>
        </thead>
	<tbody>
            <?php
                foreach($data->result_array() as $r){
			?>
        <tr class="gradeX">
			<td class="aligncenter">
                <span class="center"><input type="checkbox" /></span>
            </td>
			<td class="center"><?php echo $r['kd_obat']; ?></td>
			<td><?php echo $r['nama_obat']; ?></td>
			<td class="center"><?php echo $r['obat_stok']." ".$r['sat_kecil_obat']; ?></td>
			<td class="center"><?php echo $this->m_crud->tgl_sql($r['tgl_kadaluarsa']); ?></td>
            <td class="center">
                <?php
                if($r['selisih'] < 0){
                    echo '<span style="color: red">'. 'Lewat'.' '.'( '.$r['selisih']*'-1'.' )'.' '.'hari'.'</span>';
                }elseif($r['selisih'] == 0) {
                    echo '<span style="color: blue"> Hari ini </span>';
                } else {
                echo $r['selisih']." hari lagi";
                }
                ?>
            </td>
        </tr>
             <?php } ?>
        </tbody>
    	
	
</table>

