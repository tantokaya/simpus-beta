<div class="stickyheader">
	<div class="stickyheaderinner">
	    <div class="leftpanel">
		<div class="logopanel">
		    <h1><a href="<?php echo base_url(); ?>">E-Puskesmas <span>v1.0</span></a></h1>
		</div><!--logopanel-->
	    </div>
	    <div class="rightpanel">
		<div class="headerpanel">
		    <a href="" class="showmenu"></a>
		
		<div class="headerright">
            <div class="dropdown notification">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="/page.html">
                    <span class="iconsweets-megaphone iconsweets-white"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="nav-header">Resep yang masuk dari Poli</li>
                    <?php foreach($all_new_resep as $db): ?>
                    <li>
                        <a href="">
                            <span class="icon-envelope"></span> No Trans <strong><?php echo $db['nm_lengkap']; ?></strong> <small class="muted"> - <?php echo $db['kd_trans_pelayanan']; ?></small>
                        </a>
                    </li>
                    <?php endforeach; ?>
                    <li><a href="JavaScript:window.location.reload()"><span class="icon-refresh"></span> REFRESH PESAN !!!</a></li>
                </ul>
            </div><!--dropdown-->
		    <div class="dropdown userinfo">
			<a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="/page.html"><?php echo "Hi, ".$this->session->userdata('nama')." !"; ?> <b class="caret"></b></a>
			<ul class="dropdown-menu">
			    <li><a href="<?php echo base_url(); ?>edit_profile"><span class="icon-edit"></span> Edit Profile</a></li>
			    <li><a href=""><span class="icon-wrench"></span> Account Settings</a></li>
			    <li><a href=""><span class="icon-eye-open"></span> Privacy Settings</a></li>
			    <li class="divider"></li>
			    <li><?php echo anchor('logout', '<span class="icon-off"></span> Sign Out'); ?></li>
			</ul>
		    </div><!--dropdown-->
		    
		</div><!--headerright-->
		
	    </div><!--headerpanel-->
	    </div><!--rightpanel-->
	</div><!--stickyheaderinner-->
    </div><!--stickyheader-->