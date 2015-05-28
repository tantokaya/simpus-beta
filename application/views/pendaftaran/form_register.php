<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Laporan Harian</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman laporan register harian</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
      						<li class="ui-tabs-active"><a href="#list"><i class="icon-align-justify"></i> Download Laporan</a></li>
                        </ul>
                        
                        <!---- CETAK register START ---->
   						<div id="list">
                        	<h4 class="widgettitle nomargin shadowed">Rekap Penyakit Per Minggu</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_cetak_lap_harian/register_harian/cetak', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                       
 <table style="border:0px solid grey; color:black; font-size:10pt;" width="100%">
    <tr>
      <td width="168" style="padding:15px;"><strong>Dari Tanggal</strong></td>
      <td width="32" align="center" style="padding:15px;"><strong>:</strong></td>
      <td width="108" style="padding:15px;"><input type="text" name="tgl_mulai" id="tgl_mulai"  style="width:80px; font-size: 13px; background-color:#FFFFE0; font-weight: bold; text-align:center;"></td>
      <td width="44" style="padding:15px;"><strong>s/d</strong></td>
      <td width="495" ><input type="text"  name="tgl_akhir" id="tgl_akhir" style="width:80px; font-size: 13px; background-color:#FFFFE0; font-weight: bold; text-align:center;"></td>
    </tr>
    <tr>
      <td width="168" style="padding:15px;"><strong>Unit Pelayanan</strong></td>
      <td width="32" align="center" style="padding:15px;"><strong>:</strong></td>
      <td colspan="3"><select name="kd_unit_pelayanan" id="kd_unit_pelayanan" class="uniformselect">
        
        <option value="">SEMUA UNIT PELAYANAN</option>
        <?php foreach($list_unit_pelayanan as $lup) : ?>
        <option value="<?php echo $lup['kd_unit_pelayanan']; ?>"><?php echo $lup['nm_unit']; ?></option>
        <?php endforeach; ?>
      </select></td>
       </tr>
  </table>  
                                       
                                                           
                                        <p class="stdformbutton">
                                            <button class="btn btn-primary">Proses</button>
                                            <button type="reset" class="btn">Reset</button>
                                        </p>
                               	<?php echo form_close();  ?>
                                </div><!--widgetcontent-->
                        </div>
                        <!---- END CETAK LB2 ---->
                        
                	</div><!--tabs-->
                </div><!--span12-->
            </div><!--row-fluid-->
        </div><!--contentinner-->
    </div><!--maincontent-->
</div><!--mainright-->
<script>
    jQuery("#tgl").datepicker({
        dateFormat:"dd-mm-yy"
    });
</script>