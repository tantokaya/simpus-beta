<script type="text/javascript">
function pilih(id){
	$("#DataBarangApotek").dialog('close');
	$("#kd_obat").val(id);
	$("#kd_obat").focus();
	
}
</script>
<div id="list">
                        	<table class="table table-bordered" id="dyntable">
                    		<colgroup>
                        		<col style="align: center; width: 4%"  />
                        		<col class="con1" />
                        		<col class="con0" />
                        		<col class="con1" />
                        		<col class="con0" />
                        		<col class="con1" />
                    		</colgroup>
                    		<thead>
                                <tr>
								  <th>No.</th>
								  <th>Kode Barang</th>
								  <th>Nama Barang</th>
								  <th>Stok Apotek</th>
								  <th>Pilih</th>
								</tr>
                   			</thead>
                            <tbody>
                            <?php
							  $no=1;
							  foreach($data->result_array() as $dp){

							?>
                            	<tr class="gradeX">
                                <td width="50" class="center"><?php echo $no; ?></td>
								  <td class="center"><?php echo $dp['kd_obat']; ?></td>
								  <td><?php echo $dp['nama_obat']; ?></td>
								  <!--<td><center><?php echo $stok; ?></center></td>-->
								  <td class="center"><?php echo $dp['apotek_stok']; ?></td>
								  <td >
								  <div class="btn-group">
									<a class="btn btn-small btn-info" href="javascript:pilih('<?php echo $dp['kd_obat'];?>')" >
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