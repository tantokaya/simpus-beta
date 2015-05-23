<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Master Transaksi</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman sinkronisasi data</span>
    </div><!--pagetitle-->
     
    <div class="maincontent">
    	<div class="contentinner content-dashboard">
        	<div class="row-fluid">
            	<div class="span12">
					<div id="tabs">
  	 					<ul>
            				<li class="ui-tabs-active"><a href="#backup"><i class="icon-edit"></i> Backup</a></li>
                            <li class="ui-tabs-active"><a href="#restore"><i class="icon-align-justify"></i> Restore</a></li>
                            <li class=""><a href="#sync"><i class="icon-plus"></i> Sinkronisasi Server</a></li>
                          
                        </ul>
                        
                        <!----BACKUP---->
                        <div id="backup">
                       	    
                      
                        </div>
                        <!---- END BACKUP ---->
                       
                        <!---- RESTORE ---->
   						<div id="restore">
                        
                        </div>
                        <!---- END RESTORE ---->
                        
                        <!---- SINKRONISASI SERVER START ---->
                        <div id="sync">
                       	
                        </div>
                        
                	</div><!--tabs-->
                </div><!--span12-->
            </div><!--row-fluid-->
        </div><!--contentinner-->
    </div><!--maincontent-->
</div><!--mainright-->