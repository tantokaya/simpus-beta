<a href="<?php echo base_url(); ?>c_pembayaran/bayar_pendaftaran"> 
<button class="btn btn-warning btn-rounded" title="Tambah Stok Obat"><i class="icon-plus icon-white"></i> Tambah </button></a> 
<a href="<?php echo base_url(); ?>c_pembayaran/bayar_pendaftaran"> 
<button class="btn btn-success btn-rounded" title="Perbarui Data"><i class="icon-refresh icon-white"></i> Refresh </button></a> 
							
<div class="clearfix"><br /></div>
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
            <th class="head1 center">Kode Bayar</th>
            <th class="head0 center">Tanggal</th>
            <th class="head0 center">NIK</th>
            <th class="head1 center">Nama</th>
            <th class="head0 center">Total</th>
			<th class="head1 center">Aksi</th>
        </tr>
        </thead>
        <tbody>
            <?php 
			$no=1;
			foreach ($bayar_pendaftaran as $r):
			?>
        <tr class="gradeX">
        <td class="aligncenter">
            <span class="center"><input type="checkbox" /></span>
        </td>
	    <td class="center"><?php echo $no; ?></td>
	    <td class="center" width="15%"><?php echo $r['kd_bayar']; ?></td>
	    <td class="center" width="13%"><?php echo $r['tgl_bayar']; ?></td>
	    <td class="center"><?php echo $r['nik']; ?></td>
		<td class="center" width="10%"><?php echo $r['nama']; ?></td>
		<td class="left" ><?php echo number_format($r['b_pendaftaran']); ?></td>
		<td class="center" width="15%">
            <a href="<?php echo base_url(); ?>c_pembayaran/bayar_pendaftaran/ubah/<?php echo $r['kd_bayar']; ?>" class="btn btn-primary btn-circle" title="Edit"><i class="iconsweets-create iconsweets-white"></i></a>
            <a href="<?php echo base_url(); ?>c_pembayaran/bayar_pendaftaran/hapus/<?php echo $r['kd_bayar']; ?>" class="btn btn-danger btn-circle" onClick="return confirm('Anda yakin ingin mengurangi data ini?')" title="Hapus !"><i class="iconsweets-trashcan iconsweets-white" ></i></a>
        </td>
        </tr>
            <?php 
			$no++;
			endforeach; ?>
        </tbody>
    </table>