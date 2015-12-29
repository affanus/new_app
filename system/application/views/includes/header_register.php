<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Chypms- User Signup</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/theme-5/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/theme-5/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/theme-5/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/theme-5/material-design-iconic-font.min.css?1421434286" />
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="<?=base_url()?>/assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="<?=base_url()?>/assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
        <script src="<?=base_url()?>assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="<?=base_url()?>assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	</head>
	<body class="menubar-hoverable">
    	<header id="header" style="height:auto; position:relative;">
        	<div class="headerbar">
            	<? if($this->session->userdata('user_id')):
				
					$user_query = $this->db->query("SELECT
						email,
						fname,
						lname,
						profile_pic,
						isactive
						FROM
						users
						WHERE
						users.id  = '".$this->session->userdata('user_id')."'");
						$row_user_query = $user_query->row(); 	
						$status = $user_query->row('isactive');
					
						
						
				?>
                	<div class="headerbar-left">
                        <ul class="header-nav header-nav-options">
                            <li class="header-nav-brand" >
                                <div class="brand-holder">
                                    <a href="<?=base_url()?>/users">
                                        <img class="" src="<?=base_url()?>assets/img/logo_chpmps_header.png" />
                                    </a>
                                </div>
                            </li>
                            
                        </ul>
					</div>
                    <?php if($status == '1') { ?>
                    <div class="headerbar-right">
                        <ul class="header-nav header-nav-profile">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                                    <? if($row_user_query->profile_pic!=''):?>
                                    <img src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($row_user_query->profile_pic)?>" alt="" />
                                    <? else:?>
                                        <img class="" src="<?=base_url()?>assets/img/no-user-image-square.jpg" />
                                    <? endif;?>
                                    <span class="profile-info">
                                        <?=stripslashes($this->session->userdata('fname'))?> <?=stripslashes($this->session->userdata('lname'))?>
                                        <small></small>
                                    </span>
                                </a>
                                <ul class="dropdown-menu animation-dock">
                                    <li class="dropdown-header">Config</li>
                                    <li><a href="<?=base_url()?>users/edit_profile/">My profile</a></li>
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Settings</a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?=base_url()?>users/logout"><i class="fa fa-fw fa-power-off text-danger"></i> Logout</a></li>
                                </ul><!--end .dropdown-menu -->
                            </li><!--end .dropdown -->
                        </ul><!--end .header-nav-profile -->
                    </div>
                    <?php }  ?>
				</div>
				
                <? else:?>
            		<img class="" src="<?=base_url()?>assets/img/logo_CHYMPS.png"  style="display:block; margin:15px auto;"/>
                <? endif; ?>
            </div>
        </header>