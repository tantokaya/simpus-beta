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
      <th>Kode Masuk</th>
      <th>Tanggal</th>
      <th>Kode Produk</th>
      <th>Nama Produk</th>
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
		  $tgl = $this->m_crud->tgl_indo($dp['tgl_terima']);
  ?>
          <tr>
              <td style="text-align: center; width: 20px;"><?php echo $no; ?></td>
              <td style="text-align: center; width: 50px;"><?php echo $dp['kd_masuk']; ?></td>
              <td style="text-align: center; width: 75px;"><?php echo $tgl; ?></td>
              <td style="text-align: left; width: 100px;"><?php echo $dp['kd_obat']; ?></td>
              <td style="text-align: left; width: 400px;"><?php echo $dp['nama_obat']; ?></td>
              <td style="text-align: center; width: 50px;"><?php echo number_format($total); ?></td>
              <td style="text-align: center; width: 50px;"><?php echo $dp['sat_kecil_obat']; ?></td>
          </tr>
   <?php
          $g_total = $g_total+$total;
		  $no++;
      }
   ?>
  </tbody>
<tr>
<td colspan="6" align="center"><b>Total</b></td>
<td align="right"><?php echo number_format($g_total);?></td>
<input type="hidden" id="g_total" value="<?php echo $g_total;?>" />
</tr>
</table>
</section>