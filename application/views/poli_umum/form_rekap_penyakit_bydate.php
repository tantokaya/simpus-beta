<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Laporan Mingguan</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman laporan rekap pasien per penyakit</span>
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
                        	<h4 class="widgettitle nomargin shadowed">Rekap Pasien Per Penyakit</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('cont_cetak_lap_mingguan/rekap_pasien_penyakit/cetak', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
               
       <table style="border:0px solid grey; color:black; font-size:10pt;" width="100%">
		<tr>
		  <td width="141" style="padding:15px;"><strong>Dari Tanggal</strong></td>
		  <td width="32" align="center" style="padding:15px;"><strong>:</strong></td>
		  <td width="108" style="padding:15px;"><input type="text" name="tgl_mulai" id="tgl_mulai"  style="width:80px; font-size: 13px; background-color:#FFFFE0; font-weight: bold; text-align:center;"></td>
		  <td width="44" style="padding:15px;"><strong>s/d</strong></td>
		  <td width="530" ><input type="text"  name="tgl_akhir" id="tgl_akhir" style="width:80px; font-size: 13px; background-color:#FFFFE0; font-weight: bold; text-align:center;"></td>
		  
	    </tr>
		<tr>
		  <td width="141" style="padding:15px;"><strong>Jenis Penyakit</strong></td>
		  <td width="32" align="center" style="padding:15px;"><strong>:</strong></td>
		  <td colspan="3" style="padding:15px;"><select name="kd_penyakit" id="kd_penyakit" class="uniformselect">
		    <option value="">Semua Jenis Penyakit</option>
		    <?php foreach($list_penyakit as $lup) : ?>
		    <option value="<?php echo $lup['kd_penyakit']; ?>"><?php echo $lup['penyakit']; ?></option>
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