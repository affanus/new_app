<html lang="en">
	<head>
		<title><?=SITE_TITLE_ADMIN?></title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/assets/css/theme-5/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/assets/css/theme-5/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/assets/css/theme-5/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo base_url();?>/assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="<?php echo base_url();?>/assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed ">

		<!-- BEGIN LOGIN SECTION -->
		<section class="section-account">
			<div class="img-backdrop" style="background-image: url('<?php echo base_url();?>/assets/img/login-header.jpg')"></div>
			<div class="spacer"></div>
			<div class="card contain-sm style-transparent">
				<div class="card-body">
					<div class="row">
						<? if($errormess == '1'){ ?>
                        <div class="card style-danger text-lg">
                        	<div class="card-body" style="text-align:center">
								<?php echo validation_errors('<p>'); ?>
                                <? 
                                echo 'There is a Problem in login'; ?>
                        	</div>
                        </div>
                        <? } ?>
						<div class="col-md-6 col-md-offset-3">
							<br/>
							<span class="text-lg text-bold text-primary">AIRBOOK ADMIN</span>
							<br/><br/>
								<? 
                                $attributes = array('id' => 'loginform','name' => 'loginform','class' => 'form floating-label form-validate');
                                echo form_open('admin/admin_login/validate_credentials', $attributes);?>
								<div class="form-group">
									<input type="text" class="form-control" id="username" name="username" onKeyPress="if (event.keyCode == 13) {document.loginform.submit();}" required>
									<label for="username">Username</label>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" name="password" onKeyPress="if (event.keyCode == 13) {document.loginform.submit();}" required>
									<label for="password">Password</label>
									
								</div>
								<br/>
								<div class="row">
									<div class="col-xs-6 text-left">
										<div class="checkbox checkbox-inline checkbox-styled">
											<label>
												<input type="checkbox"> <span>Remember me</span>
											</label>
										</div>
									</div><!--end .col -->
									<div class="col-xs-6 text-right">
										<button class="btn btn-primary btn-raised" type="submit">Login</button>
									</div><!--end .col -->
								</div><!--end .row -->
							<? echo form_close();?>
						</div><!--end .col -->

					</div><!--end .row -->
				</div><!--end .card-body -->
			</div><!--end .card -->
		</section>
				<!-- END LOGIN SECTION -->

				<!-- BEGIN JAVASCRIPT -->
				<script src="<?php echo base_url();?>/assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
				<script src="<?php echo base_url();?>/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
				<script src="<?php echo base_url();?>/assets/js/libs/bootstrap/bootstrap.min.js"></script>
				<script src="<?php echo base_url();?>/assets/js/libs/spin.js/spin.min.js"></script>
				<script src="<?php echo base_url();?>/assets/js/libs/autosize/jquery.autosize.min.js"></script>
				<script src="<?php echo base_url();?>/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
                <script src="<?php echo base_url();?>/assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
				<script src="<?php echo base_url();?>/assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
				<script src="<?php echo base_url();?>/assets/js/core/source/App.js"></script>
				<script src="<?php echo base_url();?>/assets/js/core/source/AppNavigation.js"></script>
				<script src="<?php echo base_url();?>/assets/js/core/source/AppOffcanvas.js"></script>
				<script src="<?php echo base_url();?>/assets/js/core/source/AppCard.js"></script>
				<script src="<?php echo base_url();?>/assets/js/core/source/AppForm.js"></script>
				<script src="<?php echo base_url();?>/assets/js/core/source/AppNavSearch.js"></script>
				<script src="<?php echo base_url();?>/assets/js/core/source/AppVendor.js"></script>
				<script src="<?php echo base_url();?>/assets/js/core/demo/Demo.js"></script>
				<!-- END JAVASCRIPT -->

			</body>
		</html>