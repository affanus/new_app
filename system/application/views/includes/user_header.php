<?php
$CI =& get_instance();
$CI->load->model('security');
$CI->security->validate_user_session();
$user_query = $this->db->query("SELECT
						users.email,
						fname,
						lname,
						profile_pic
						FROM
						users
						WHERE
						id  = '".$this->session->userdata('user_id')."'");
$row_user_query = $user_query->row();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>CHYMPS</title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/theme-5/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/theme-5/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/theme-5/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>/assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="<?=base_url()?>/assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="<?=base_url()?>/assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
        <script src="<?=base_url()?>assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="<?=base_url()?>assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	</head>
	<body class="menubar-hoverable header-fixed menubar-pin ">

		<!-- BEGIN HEADER-->
		<header id="header" >
			<div class="headerbar">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="headerbar-left">
                    <ul class="header-nav header-nav-options">
                        <li class="header-nav-brand" >
                            <div class="brand-holder">
<h2>CHYMPS</h2>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="headerbar-right">
                	<ul class="header-nav header-nav-options">
                    	<li class="dropdown hidden-xs">
							<a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
								<i class="fa fa-bell"></i><sup class="badge style-danger">4</sup>
							</a>
							<ul class="dropdown-menu animation-expand">
								<li class="dropdown-header">Requests</li>
								<li>
									<a class="alert alert-callout alert-warning" href="javascript:void(0);">
										<img class="pull-right img-circle dropdown-avatar" src="<?=base_url()?>/assets/img/avatar2.jpg?1404026449" alt="" />
										<strong>Name name</strong><br/>
										<small>Testing functionality...</small>
									</a>
								</li>
								<li>
									<a class="alert alert-callout alert-info" href="javascript:void(0);">
										<img class="pull-right img-circle dropdown-avatar" src="<?=base_url()?>/assets/img/avatar3.jpg?1404026799" alt="" />
										<strong>Name name</strong><br/>
										<small>Reviewing last changes...</small>
									</a>
								</li>
								<li class="dropdown-header">Options</li>
								<li><a href="<?=base_url()?>users/show_request">View all Requests <span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li>
								
							</ul><!--end .dropdown-menu -->
						</li>
                    </ul>
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
                                    <small>CHYMPSER</small>
                                </span>
                            </a>
                            <ul class="dropdown-menu animation-dock">
                                <li class="dropdown-header">Config</li>
                                <li><a href="<?=base_url()?>users/profile/">My profile</a></li>
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="#">Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="<?=base_url()?>users/logout"><i class="fa fa-fw fa-power-off text-danger"></i> Logout</a></li>
                            </ul><!--end .dropdown-menu -->
                        </li><!--end .dropdown -->
                    </ul><!--end .header-nav-profile -->
                </div>
			</div>
		</header>
		<!-- END HEADER-->

		<!-- BEGIN BASE-->
		<div id="base" style="padding-left:0px;">

			<!-- BEGIN OFFCANVAS LEFT -->
			<div class="offcanvas">
			</div><!--end .offcanvas-->
			<!-- END OFFCANVAS LEFT -->
        
        