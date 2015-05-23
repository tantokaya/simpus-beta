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
      <th>Kode </th>
      <th>Nama Tindakan</th>
      <th><center>Jumlah</center></th>
      <th>H.Total</center></th>
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
      <td  width="50" class="center" ><?php echo $no; ?></td>
      <td class="center"><?php echo $dp['kd_produk']; ?></td>
      <td><?php echo $dp['produk']; ?></td>
      <td><center><?php echo $dp['jml']; ?></center></td>
      <td class="center"><?php echo number_format($total); ?></td>
      <td width="30">
      <div class="btn-group">
        <a class="btn btn-danger" href="<?php echo base_url();?>index.php/c_bayar_tindakan/HapusDetail/<?php echo $dp['kd_bayar'];?>/<?php echo $dp['kd_produk'];?>" onClick="return confirm('Anda yakin ingin menghapus data ini?')"><i class="icon-trash icon-white"></i></a>
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
	<td colspan="4" align="center">Total</td>
	<td align="right" ><input type="text" id="tbayar" style="font-size:15px; width:130px; text-align:right; "  name="tbayar" value="<?php echo number_format($g_total);?>" readonly></td>
	<td></td>
  </tr>
 </table>
	