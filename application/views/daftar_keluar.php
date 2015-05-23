<style type="text/css">
table {
	margin-top:5px;
}
.table tr th {
	text-align:center;
	background-color:#000;
	color:#fff;
}
</style>
<table class="table table-hover table-striped ">
<thead>    
	<tr>
      <th>No.</th>
      <th>Kode Barang</th>
      <th>Nama Barang</th>
      <th>Jumlah</th>
      <th>Satuan</th>
      <th>Aksi</th>
    </tr>
</thead>
	<?php
	if($data->num_rows()>0){
		$g_total=0;
		$no =1;
		
		foreach($data->result_array() as $dp) {  
		$total = $dp['jml'];
		
	?>    
	
    
<tbody>    
  <tr>
      <td width="50"><center><?php echo $no; ?></center></td>
      <td width="80"><center><?php echo $dp['kd_obat']; ?></center></td>
      <td><?php echo $dp['nama_obat']; ?></td>
      <td><center><?php echo $dp['jml']; ?></center></td>
      <td><center><?php echo $dp['sat_kecil_obat']; ?></center></td>
      <td width="100">
      <div class="btn-group">
        <a class="btn btn-danger" href="<?php echo base_url();?>index.php/barang/HapusDetailKeluar/<?php echo $dp['kd_keluar'];?>/<?php echo $dp['kd_obat'];?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="icon-trash icon-white"></i></a>
      </div><!-- /btn-group -->
	  </td>
  </tr>
  
	<?php
		$no++;
		$g_total=$g_total+$total;
		}
	}else{
		$g_total=0;
	?>
    	<tr>
        	<td colspan="6" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
	?>
	
	
   </tbody>
  <tr>
	<td colspan="4" align="center">Jumlah Total</td>
	<td align="right" name="total_beli" id="total_beli"><?php echo number_format($g_total);?></td>
  </tr>
 </table>
