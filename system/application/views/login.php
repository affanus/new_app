<script>
$(document).ready(function() {
			$.validator.setDefaults({
			highlight: function (element) {
				$(element).closest('.form-group').addClass('has-error');
			},
			unhighlight: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
			},
			errorElement: 'span',
			errorClass: 'help-block',
			errorPlacement: function (error, element) {
				if (element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				}
				else if (element.parent('label').length) {
					error.insertAfter(element.parent());
				}
				else {
					error.insertAfter(element);
				}
			}
		});
	var validator = $( "#userRegistration" ).validate();
	$(this).data('validator', validator);
});
</script>
<section class="section-account">  

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
							<span class="text-lg text-bold text-primary">USER LOGIN</span>
							<br/><br/>
								<? 
                                $attributes = array('id' => 'loginform','name' => 'loginform','class' => 'form floating-label form-validate');
                                echo form_open('users/login_confirmation', $attributes);?>
								<div class="form-group">
									<input type="text" class="form-control" id="email" name="email" data-rule-email="true" required>
									<label for="email">Email Address</label>
								</div>
								<div class="form-group">
									<input type="password" class="form-control" id="password" name="password"  required>
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
			</div>
</section>