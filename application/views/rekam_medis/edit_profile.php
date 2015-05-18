<?php if($this->session->flashdata('flash_message') != ""):?>
 		<script>
			jAlert('<?php echo $this->session->flashdata('flash_message'); ?>', 'Informasi');
		</script>
<?php endif;?>
<div class="rightpanel">
	<div class="breadcrumbwidget">
    	<ul class="breadcrumb">
        	<li><a href="#">Home</a> <span class="divider">/</span></li>
            <li><a href="#">Edit Profile</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $page_title; ?></li>
        </ul>
	</div><!--breadcrumbwidget-->
    <div class="pagetitle">
    	<h1><?php echo $page_title; ?></h1> <span>Halaman edit profil pengguna</span>
    </div><!--pagetitle-->
    
<div class="maincontent">
        	<div class="contentinner content-editprofile">
            	<h4 class="widgettitle nomargin">Edit Profile</h4>
                <div class="widgetcontent bordered">
                	<div class="row-fluid">
                    	<div class="span12 profile-left">
                        	<?php echo form_open('admin/edit_profile/ubah/do_update/'.$user['id_user'], array('class' => 'editprofileform', 'id' => 'form_edit')); ?>
                            <!--<form action="editprofile.html" class="editprofileform" method="post">-->
                            	<h4>Login Information</h4>
                                <p>
                                	<label>Email:</label>
                                    <input type="text" name="email" id="email" class="input-xlarge" value="<?php echo $user['email']; ?>" />
                                </p>
                                <p>
                                	<label style="padding:0">Password</label>
                                    <a href="#chgPass" data-toggle="modal">Ubah Password?</a>
                                </p>
                                
                                <br />
                                
                                <h4>Personal Information</h4>
                                <p>
                                	<label>Nama Lengkap:</label>
                                	<input type="text" name="nama" id="nama" class="input-xlarge" value="<?php echo $user['nama']; ?>" />
                                </p>
                                <p>
                                	<label>NIP:</label>
                                    <input type="text" name="nip" id="nip" class="input-xlarge" value="<?php echo $user['nip']; ?>" />
                                </p>
                                <p>
                                	<label>Hak Akses:</label>
                                    <input type="text" name="hak_akses" id="hak_akses" class="input-xlarge" value="<?php echo ucwords($this->session->userdata('akses')); ?>" readonly />
                                    
                                </p>
                                <p>
                                	<label>Puskesmas:</label>
                                    <?php 
										if(!empty($puskesmas)){
											//echo $puskesmas['nm_puskesmas'];
											echo '<input type="text" name="nm_puskesmas" id="nm_puskesmas" class="input-xlarge" value="'.$puskesmas['nm_puskesmas'].'" readonly />';	
										}
									?>
                                    
                                </p>
                                
                                <br />
                                <p>
                                	<button type="submit" class="btn btn-primary">Update Profile</button>
                                </p>
                            <?php echo form_close(); ?>
                        </div><!--span12-->
                    </div><!--row-fluid-->
                </div><!--widgetcontent-->
            </div><!--contentinner-->
        </div><!--maincontent-->
        
      	<div aria-hidden="false" aria-labelledby="chgPassLabel" tabindex="-1" role="dialog" class="modal hide fade in" id="chgPass">
        	<?php echo form_open('admin/edit_profile/ubah_password'); ?>
            <div class="modal-header">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h3 id="chgPassLabel">Ubah Password</h3>
            </div>
            <div class="modal-body">
              <!-- <h4>Text in a modal</h4> -->
              
              <p>
              	<label>Password lama:</label>
                <input type="password" name="old_pass" id="old_pass" class="input-xlarge"  />
                
              </p>
              <p>
              	<label>Password baru:</label>
                <input type="password" name="password" id="password" class="input-xlarge" />
                
              </p>
              <p>
              	<label>Re-password baru:</label>
                <input type="password" name="re_pass" id="re_pass" class="input-xlarge" />
                
              </p>
             
            </div>
            <div class="modal-footer">
              <button data-dismiss="modal" class="btn">Close</button>
              <button class="btn btn-primary">Save changes</button>
            </div>
            <?php echo form_close(); ?>
    	</div><!--#chgPass-->
</div>