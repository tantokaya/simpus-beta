<script type="text/javascript">
function pilihpasien(id){
	$("#DataPasien").dialog('close');
	$("#nik").val(id);

	$("#nik").focus();
	
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
								  <th>Kode NIK</th>
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
								  <td style="width: 20px; text-align: center;"><?php echo $no; ?></td>
								  <td style="text-align: center;"><?php echo $dp['kd_rekam_medis']; ?></td>
								  <td><?php echo $dp['nm_lengkap']; ?></td>
								  <td><?php echo $this->m_crud->tgl_sql($dp['tanggal_lahir']); ?></td>
								  <td><?php echo $dp['alamat']; ?></td>
								<td >
								  <div class="btn-group">
									<a class="btn btn-small btn-info" href="javascript:pilihpasien('<?php echo $dp['kd_rekam_medis'];?>')" >
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