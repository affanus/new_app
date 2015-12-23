<div id="content">
	<section class="style-default-bright">
    	<div class="section-header" style="position: relative;">
			<h2 class="text-primary"></h2>
		</div>
        <div class="section-body">
        	<? 
				$attributes = array('name' => 'form1','class' => 'form floating-label form-validate');
				echo form_open_multipart('admin/admin_rights/add_/', $attributes);?>
				<? if($errormess == '1'){ ?>
				<div class="error" style="width:465px; margin-bottom:30px;">
				<?php echo validation_errors('<p style="margin:0px;">'); ?>
				<? 
				echo 'The Admin ID is already taken'; ?>
				</div>
				<? } else {?>
				<? } ?>
				<div class="card">
					<div class="card-head style-accent">
						<header>Create Admin User</header>
					</div>
					<div class="card-body floating-label ">

						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="adminid" id="adminid" required>
									<label for="adminid">Username</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input type="password" class="form-control" name="password" id="password" required>
									<label for="password">Password</label>                   
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="email" id="email" required>
									<label for="email">Email</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="fname" id="fname" required>
									<label for="fname">First Name</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="lname" id="lname" required>
									<label for="lname">Last Name</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input name="profilepic" type="file" id="profilepic" />
								</div>
							</div>
						</div>
                        <div class="row">
                        	<div class="col-lg-12">
                            	<div class="form-group">

                                </div>
                            </div>
                        </div>
                        
                        <br/>
						<div class="row">
                            <div class="col-lg-4">
                            	<div >
    								<label class="radio-inline radio-styled">
                                    	<input type="radio" name="isactive" value="1"><span>Publish</span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                    	<input type="radio" name="isactive" value="0" checked><span>Inactive</span>
                                	</label>
                            	</div>
                        	</div>
                        </div>

					</div><!--end .card-body -->
					<div class="card-actionbar">
						<div class="card-actionbar-row">
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Create Admin User</button>
						</div>
					</div>
				</div><!--end .card -->

			<? echo form_close();?>
        </div>
    </section>
    
</div>