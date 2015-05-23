<script type="text/javascript">
function pilihtindakan(id){
	$("#DataBarang").dialog('close');
	$("#kd_produk").val(id);
	$("#kd_produk").focus();
	
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
                    		</colgroup>
                    		<thead>
                                <tr>
								  <th>No.</th>
								  <th>Kode </th>
								  <th>Nama Tindakan</th>
								  <th>Harga</th>
								  <th>Keterangan</th>
								  <th>Pilih</th>
								</tr>
                   			</thead>
                            <tbody>
                            <?php
							  $no=1;
							  foreach($data->result_array() as $dp){
							?>
                            	<tr class="gradeX">
								  <td width="20"><center><?php echo $no; ?></center></td>
								  <td><center><?php echo $dp['kd_produk']; ?></center></td>
								  <td><?php echo $dp['produk']; ?></td>
								  <td><?php echo $dp['harga']; ?></td>
								  <td><?php echo $dp['keterangan_tindakan']; ?></td>
								<td >
								  <div class="btn-group">
									<a class="btn btn-small btn-info" href="javascript:pilihtindakan('<?php echo $dp['kd_produk'];?>')" >
									<i class="icon-check icon-white"></i></a>
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