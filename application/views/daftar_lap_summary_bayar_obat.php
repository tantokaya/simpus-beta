<style type="text/css">
table {
	margin-top:5px;
	font-size:100%;
}
.table tr th {
	text-align:center;
	background-color:#000;
	color:#fff;
}
.table tr td {
	color:#000;
}
</style>
<section>
<table class="table table-hover table-striped" width="100%">
  <thead>
    <tr>
      <th>No.</th>
      <th>No Pembayaran</th>
      <th>Tanggal</th>
      <th>Nama Pasien</th>
      <th>Total Harga Obat</th>
    </tr>
  </thead>
  <tbody>
  <?php
      $g_total=0;
	  $no=1;
      foreach($data->result_array() as $dp){
		  $total = $dp['total'];
		  $tgl = $this->m_crud->tgl_indo($dp['tgl_bayar']);
  ?>
    <tr>
      <td width="50"><center><?php echo $no; ?></center></td>
      <td><center><?php echo $dp['kd_bayar']; ?></center></td>
      <td><center><?php echo $tgl; ?></center></td>
      <td><?php echo $dp['nama_pasien']; ?></td>
      <td align="right"><?php echo number_format($dp['total']); ?></td>
      
    </tr>
   <?php
          $g_total = $g_total+$total;
		  $no++;
      }
   ?>
  </tbody>
<tr>
<td colspan="4" align="center"><b>Total</b></td>
<td align="right"><?php echo number_format($g_total);?></td>
<input type="hidden" id="g_total" value="<?php echo $g_total;?>" />
</tr>
</table>
</section>