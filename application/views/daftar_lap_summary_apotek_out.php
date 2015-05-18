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
      <th>Nama Pasien</th>
      <th>Umur</th>
      <th>Alamat</th>
    </tr>
  </thead>
  <tbody>
  <?php
      $g_total=0;
	  $no=1;
      foreach($data->result_array() as $dp){
		  //$total = $dp['total_harga'];
		  $tgl = $this->m_crud->tgl_indo($dp['tgl_keluar']);
  ?>
    <tr>
      <td style="width: 50;"><?php echo $no; ?></td>
      <td style="text-align: center;"><?php echo $dp['kd_keluar']; ?></td>
      <td style="text-align: center;"><?php echo $tgl; ?></td>
      <td><?php echo $dp['nm_lengkap']; ?></td>
      <td><?php echo $dp['umur'].' Thn'; ?></td>      
      <td><?php echo 'Jl.'.$dp['alamat'].', '.$dp['nm_kecamatan']; ?></td>
    </tr>
   <?php
          //$g_total = $g_total+$total;
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