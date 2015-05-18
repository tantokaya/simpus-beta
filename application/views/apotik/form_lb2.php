<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Laporan Bulanan</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman laporan bulanan 2 (LB1)</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
      						<li class="ui-tabs-active"><a href="#list"><i class="icon-align-justify"></i> Cetak LB2</a></li>
                        </ul>
                        
                        <!---- CETAK LB2 START ---->
   						<div id="list">
                        	<h4 class="widgettitle nomargin shadowed">Generate Laporan</h4>
                            <div class="widgetcontent bordered shadowed nopadding">
                                <?php echo form_open('c_lb_2/lb2/cetak', array('class' => 'stdform stdform2', 'id' => 'form_input')); ?>
                                        <p>
                                            <label>Bulan Laporan</label>
                                            <span class="field">
                                            	<select name="bulan" id="bulan">
                                                	<option value="--">--Pilih Bulan Laporan--</option>
                                                    <option value="1">Januari</option>
                                                    <option value="2">Februari</option>
                                                    <option value="3">Maret</option>
                                                    <option value="4">April</option>
                                                    <option value="5">Mei</option>
                                                    <option value="6">Juni</option>
                                                    <option value="7">Juli</option>
                                                    <option value="8">Agustus</option>
                                                    <option value="9">September</option>
                                                    <option value="10">Oktober</option>
                                                    <option value="11">November</option>
                                                    <option value="12">Desember</option>
                                                </select>
                                            </span>
                                        </p>
                                        
                                        <p>
                                            <label>Tahun Laporan</label>
                                            <span class="field">
                                            <select name="tahun" id="tahun">
                                            	<option value="--">--Pilih Tahun Laporan--</option>
                                            	<?php 
													//$current = date('Y'); 
													$current = '2014';
													$start = $current; 
													for($i=$start;$i<=($current+3);$i++){
														echo '<option value="'.$i.'">'.$i.'</option>';
													}
												?>
                                             </select> 
                                            </span>
                                        </p>
                                                           
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