<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<script>
$(document).ready(function() {
	$('#bday').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
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
	$("#company_name").select2({allowClear: true});
	$("#country").select2({allowClear: true});
	$("#country").on("change", function (e) { 
		var currentValue = $(this).val();
		$('.states_wrap').html('Loading States....');
		$('.city_wrap').html('');
		var request =  $.ajax({
			url:'<?php echo base_url();?>users/get_options',
			type:'post',
			data:{editid:currentValue,level:'RE'}
		});
		request.done(function( msg ) {
		  $('.states_wrap').html(msg);
		  $("#state").select2({allowClear: true});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	$("#state").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.city_wrap').html('Loading Cities....');
		var request =  $.ajax({
			url:'<?php echo base_url();?>users/get_options',
			type:'post',
			data:{editid:currentValue,level:'CI'}
		});
		request.done(function( msg ) {
		  $('.city_wrap').html(msg);
		  $("#city").select2({allowClear: true});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	$(this).data('validator', validator);
});
</script>

<section class="section-account">  

    <div class="card contain-sm style-accent ">
        <div class="card-head">                        
            <header>You are alomost done...</header>
        </div>
        <div class="card-body style-default-bright">
        	<form class="form floating-label form-validate" role="form" action="<?= base_url();?>users/register_ss_action" method="post" id="userRegistration" enctype="multipart/form-data">
            	<h1 class="page-header" style="font-size: 24px; margin-top: 0;">Personal & Contact Informantion</h1>
            	<div class="row">
                	<div class="col-sm-4">
                    	<div class="form-group">
                        	<input type="text" name="bday" id="bday" class="form-control">
                            <label for="bday" class="control-label">Birthday</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                   		<div class="form-group">
                        	<input type="text" name="website" id="website" class="form-control" >
                            <label for="website" class="control-label">Website</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                            <input type="file" class="form-control dirty" name="profile_pic" id="profile_pic">
                            <label for="profile_pic">Profile Picture</label>
                        </div>
                    </div>
				</div>
                <div class="row">
                	<div class="col-sm-4">
                    	<div class="form-group">
                            <input type="text" name="jobtitle" id="jobtitle" class="form-control">
                            <label for="jobtitle" class="control-label">Job Title</label>
                        </div>
                          
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="department" id="department" class="form-control">
                            <label for="department" class="control-label">Department</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="form-control" id="company_name" name="company_name" required>
                                <option value=""></option>
                                <?   if($query_companies->num_rows() != 0) : 
                                    foreach($query_companies->result() as $row):?>
                                        <option value="<?=$row->id?>"><?= stripslashes($row->title);?></option>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </select>
                            <label for="company_name">Company Name</label>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" id="address" required>
                            <label for="address">Address</label>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select class="form-control" id="country" name="country">
                                        <option value=""></option>
                                <?   if($query_countries->num_rows() != 0) : 
                                    foreach($query_countries->result() as $row):?>
                                        <option value="<?=$row->id?>"><?= stripslashes($row->title);?></option>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </select>
                            <label for="country">Country</label>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group states_wrap">

                        </div>
                    </div> 
                    <div class="col-lg-4">
                        <div class="form-group city_wrap">

                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="bphone" id="bphone" class="form-control" required>
                            <label for="bphone" class="control-label">Business Phone</label>
                        </div>
                        
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="pphone" id="pphone" class="form-control">
                            <label for="pphone" class="control-label">Phone Personal</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="mphone" id="mphone" class="form-control">
                            <label for="mphone" class="control-label">Mobile Phone</label>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="fax" id="fax" class="form-control">
                            <label for="fax" class="control-label">Fax</label>
                        </div>
                        
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="pobox" id="pobox" class="form-control">
                            <label for="pobox" class="control-label">P.O.Box</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select id="pmc" name="pmc" class="form-control" required>
                                <option value="">&nbsp;</option>
                                <option value="1">Business Phone</option>
                                <option value="2">Phone Personal</option>
                                <option value="3">Mobile Phone</option>
                                <option value="4">Fax</option>
                                <option value="5">P.O.Box</option>
                            </select>
                            <label for="pmc" class="control-label">Preferred Method of Contact</label>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                	<div class="col-sm-12">
                		<button type="submit" class="btn ink-reaction btn-primary style-accent">Finish</button>
                    </div>    
                </div>
            </form>
        </div>
        
    </div>
</section>