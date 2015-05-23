<script type="text/javascript">
function pilih2(id){
	$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/simpanResep",
			data	: { trans_id : id},
			cache	: false,
			success	: function(data){
					detailBarang();
					$("#jml").val('');
					
			}
		});
	$("#DataResep").dialog('close');
	//$("#kd_trans_pelayanan").val(id);
	//$("#kd_trans_pelayanan").focus();
	
	function detailBarang(){
		var kode = $("#kodekeluar").val();
		var string = "kode="+kode;
		//alert(kode);
		$.ajax({
			type	: 'POST',
			url		: "<?php echo site_url(); ?>barang/DataDetailApotekKeluar",
			data	: string,
			cache	: false,
			success	: function(data){
				$("#tampil_data").html(data);
				//$("#nm_lengkap").val('nm_lengkap');
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
                                  <th>Nama Pasien</th>
								  <th>Tgl Layanan</th>
								  <th>Unit Layanan</th>
								  <th>Jenis Layanan</th>
								  <th>View</th>
								  <th>Pilih</th>
								</tr>
                   			</thead>
                            <tbody>
                            <?php
							  $no=1;
							  foreach($data->result_array() as $dp){
							  //$stok = $this->m_crud->CariStokAkhir($dp['kd_obat']);
							?>
                            	<tr class="gradeX">
                                <td width="50"><center><?php echo $no; ?></center></td>
                                <td><?php echo $dp['kd_trans_pelayanan']; ?></td>
								  <td><center><?php echo $dp['nm_lengkap']; ?></center></td>
                                  <td><?php echo $this->m_crud->tgl_sql($dp['tgl_pelayanan']); ?></td>
								  <td><?php echo $dp['nm_unit']; ?></td>
								  <td><center><?php echo $dp['jenis_layanan']; ?></center></td>
								  <td >
								  <div class="btn-group">
									<a class="btn btn-small btn-primary" title="Lihat Resep" href="cetak_resep/<?php echo $dp['kd_trans_pelayanan'];?>" target="blank">
									<i class="icon-share icon-white"></i></a>
								  </div><!-- /btn-group -->
								  </td>
								  <td >
								  <div class="btn-group">
									<a class="btn btn-danger btn-small" title="Pilih" href="javascript:pilih2('<?php echo $dp['kd_trans_pelayanan'];?>')" >
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
                        </div>