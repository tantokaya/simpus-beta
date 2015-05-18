<script type="text/javascript">
function pilih(id){
	$("#DataRekamMedis").dialog('close');
	$("#kd_rekam_medis").val(id);
	$("#kd_rekam_medis").focus();
	
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
								  <th>Kode Rekam Medis</th>
								  <th>Nama Pasien</th>
								  <th>Tgl Lahir</th>
								  <th>Alamat</th>
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
								  <td><center><?php echo $dp['kd_rekam_medis']; ?></center></td>
								  <td><?php echo $dp['nm_lengkap']; ?></td>
								  <td><?php echo $this->m_crud->tgl_sql($dp['tanggal_lahir']); ?></td>
								  <td><center><?php echo $dp['alamat']; ?></center></td>
								  <td >
								  <div class="btn-group">
									<a class="btn btn-small btn-info" href="javascript:pilih('<?php echo $dp['kd_rekam_medis'];?>')" >
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