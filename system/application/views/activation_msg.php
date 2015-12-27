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
	var validator = $( "#userRegistration" ).validate({
	  rules: {
		email: {
		  required: true,
		  email: true,
		  remote: {
			url: "<?php echo base_url();?>users/get_email_status",
			type: "post",
			data: {
			  username: function() {
				return $( "#email" ).val();
			  }
			}
		  }
		}
	  }
	});
	$(this).data('validator', validator);
});
</script>
<section class="section-account">  

    <div class="card contain-sm style-accent ">
        <div class="card-head">
                                            
            <header>Join CHYMPS for Free</header>
        </div>
        <div class="card-body style-default-bright">
        	<form class="form floating-label form-validate" role="form" action="<?= base_url();?>users/register_action" method="post" id="userRegistration" enctype="multipart/form-data">
            	<div class="row">
                	<div class="col-sm-4">
                    	<div class="form-group">
                        	<select id="title" name="title" class="form-control" required>
                            	<option value="">&nbsp;</option>
                                <option value="Mr">Mr.</option>
                                <option value="Mrs">Mrs.</option>
                                <option value="Miss">Miss.</option>
                            </select>
                            <label for="title" class="control-label">Title</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                   		<div class="form-group">
                        	<input type="text" name="fname" id="fname" class="form-control" data-rule-minlength="2" required>
                            <label for="fname" class="control-label">First name</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                        	<input type="text" name="lname" id="lname" class="form-control" data-rule-minlength="2" required>
                            <label for="lname" class="control-label">Last name</label>
                        </div>
                    </div>
				</div>
                <div class="row">
                	<div class="col-sm-8">
                    	<div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" data-rule-email="true" required>
                            <span class="glyphicon form-control-feedback" style="display:none"></span>
                            <span id="email-error-va" class="help-block" style="display: none;"></span>
                            <label for="email" class="control-label">Email</label>
                        </div>
                    </div>
                	<div class="col-sm-4">
                    	<div class="form-group">
                        	<input type="text" name="bday" id="bday" class="form-control">
                            <label for="bday" class="control-label">Birthday</label>
                        </div>
                    </div>
                    
                    
                </div>
                <div class="row">
                	<div class="col-sm-12">
                    	<div class="form-group">
                            <input type="password" name="password1" id="password1" class="form-control" required="" data-rule-minlength="5">
                            <label for="password1" class="control-label">Password</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-12">
                		<button type="submit" class="btn ink-reaction btn-primary style-accent">Join</button>
                    </div>    
                </div>
            </form>
        </div>
        
    </div>
 </section>