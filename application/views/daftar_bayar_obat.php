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
      <th>H.Total</th>
      <th>Aksi</th>
    </tr>
</thead>
	<?php
	if($data->num_rows()>0){
		$g_total=0;
		$no =1;
		
		foreach($data->result_array() as $dp) {  
		$total = $dp['jml']*$dp['harga_jual'];
		
	?>    
	
    
<tbody>    
  <tr>
      <td width="50" class="center"><?php echo $no; ?></td>
      <td  class="center"><?php echo $dp['kd_obat']; ?></td>
      <td ><?php echo $dp['nama_obat']; ?></td>
      <td  class="center"><?php echo $dp['jml']; ?></td>
      <td  class="center"><?php echo $dp['sat_kecil_obat']; ?></td>
      <td  class="center"><?php echo number_format($total); ?></td>
      <td width="30" class="center">
      <div class="btn-group">
        <a class="btn btn-danger" href="<?php echo base_url();?>index.php/c_bayar_obat/HapusDetail/<?php echo $dp['kd_bayar'];?>/<?php echo $dp['kd_obat'];?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="icon-trash icon-white"></i></a>
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
        	<td colspan="7" align="center" >Tidak Ada Data</td>
        </tr>
    <?php	
	}
	?>
	
	
   </tbody>
  <tr>
	<td colspan="5" align="center">Total</td>
	<td align="right" ><input type="text" id="tbeli" style="font-size:15px; width:130px; text-align:right; "  name="tbeli" value="<?php echo number_format($g_total);?>" readonly></td>
	<td></td>
  </tr>
 </table>
