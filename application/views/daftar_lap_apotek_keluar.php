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
      <th>No Surat Keluar</th>
      <th>Tanggal</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
      <!--<th>Jumlah</th>-->
      <!--<th>Harga</th>-->
      <th>Jml</th>
      <th>Satuan</th>
    </tr>
  </thead>
  <tbody>
  <?php
      $g_total=0;
	  $no=1;
      foreach($data->result_array() as $dp){
		  $total = $dp['jml'];
		  $tgl = $this->m_crud->tgl_indo($dp['tgl_keluar']);
  ?>
    <tr>
      <td style="width: 50px; text-align: center;"><?php echo $no; ?></td>
      <td style="text-align: center;"><?php echo $dp['kd_keluar']; ?></td>
      <td style="text-align: center;"><?php echo $tgl; ?></td>
      <td style="text-align: center;"><?php echo $dp['kd_obat']; ?></td>
      <td><?php echo $dp['nama_obat']; ?></td>
      <!--<td><center><?php echo $dp['jml']; ?></center></td>-->
      <!--<td><center><?php echo number_format($dp['harga_jual']); ?></center></td>-->
      <td style="text-align: center;"><?php echo number_format($total); ?></td>
      <td style="width: 80px; text-align: center;"><?php echo $dp['sat_kecil_obat']; ?></td>
    </tr>
   <?php
          $g_total = $g_total+$total;
		  $no++;
      }
   ?>
  </tbody>
<tr>
<td colspan="7" align="center"><b>Total</b></td>
<td align="right"><?php echo number_format($g_total);?></td>
<input type="hidden" id="g_total" value="<?php echo $g_total;?>" />
</tr>
</table>
</section>