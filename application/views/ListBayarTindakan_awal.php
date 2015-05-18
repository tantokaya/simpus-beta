<script type="text/javascript">
function pilih2(id){
	var tgl_bayar = $("#tgl_bayar").val();
	var kd_bayar = $("#kd_bayar").val();
	var kd_pelayanan = $("#kd_pelayanan").val();
	
	$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/simpanlisttindakan",
			data	: {tgl_bayar:tgl_bayar, kd_bayar:kd_bayar, id:id, kd_pelayanan:kd_pelayanan},
			cache	: false,
			success	: function(data){
			detailBarang();
			}
		});
	$("#DataBayarTindakan").dialog('close');
	
	function detailBarang(){
		var kode = $("#kd_bayar").val();
		var string = "kode="+kode;
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>c_bayar_tindakan/DataDetailTindakan",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				
			}
		});
		
	}
}
</script>
<div id="list">
                        	<table class="table table-bordered" id="dyntable">
                    		<colgroup>
                        		<col class="con0" style="align: center; width: 4%" />
                        		<col class="con1" />
                        		<col class="con0" />
                        		<col class="con1" />
                        		<col class="con0" />
                        		<col class="con1" />
					<col class="con0" />
                                <col class="con0" />
                    		</colgroup>
                    		<thead>
                                <tr>
								  <th>No.</th>
								  <th>No Layanan</th>
                                  <th>Kode Produk</th>
								  <th>Nama Produk</th>
								  <th>Jumlah</th>
								  <th>Status Bayar</th>
								  <th>Harga</th>
								  <th>Pilih</th>
								</tr>
                   			</thead>
                            <tbody>
                            <?php
							  $no=1;
							  foreach($data->result_array() as $dp){
							?>
                            	<tr class="gradeX">
                                <td width="50"><center><?php echo $no; ?></center></td>
                                <td><?php echo $dp['kd_trans_pelayanan']; ?></td>
								  <td><center><?php echo $dp['kd_produk']; ?></center></td>
                                  <td><?php echo $dp['produk']; ?></td>
								  <td><?php echo $dp['qty']; ?></td>
								  <td><center><?php echo $dp['sta_bayar']; ?></center></td>
								  <td > <?php echo $dp['harga']; ?>
								  
								  </td>
								  <td >
								  <div class="btn-group">
									<?php if ($dp['sta_bayar']=='0') { ?>
									<a class="btn btn-danger btn-small" title="Pilih" href="javascript:pilih2('<?php echo $dp['kd_produk'];?>')" >
									<?php } else { ?>
									<a class="btn btn-primary btn-small" title="Pilih" href="javascript:window.stop();" >		
									<?php } ?>
									<i class="icon-ok icon-white"></i></a>
								  </div><!-- /btn-group -->
								  </td>
                                </tr>
                              <?php
								$no++;
								}
							  ?>
                   	 		</tbody>
                			</table>
							<div>							
							<input type="hidden" name="tgl_bayar" id="tgl_bayar" value="<?php echo $tgl_bayar; ?>">
							<input type="hidden" name="kd_bayar" id="kd_bayar" value="<?php echo $kd_bayar; ?>">	
							<input type="hidden" name="kd_pelayanan" id="kd_pelayanan" value="<?php echo $dp['kd_trans_pelayanan']; ?>">
							</div>
                        </div>