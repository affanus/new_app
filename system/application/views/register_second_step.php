<?php $CI =& get_instance();
$CI->load->model('security');
$CI->security->validate_user_session();
$user_query = $this->db->query("SELECT *
						FROM
						users
						WHERE
						id  = '".$this->session->userdata('user_id')."'");
$row_user_query = $user_query->row();
?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<script>
$(document).ready(function() {
	$('#bday').datepicker({autoclose: true, todayHighlight: true, format: "mm/dd/yyyy"});
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
                            <input type="text" name="education" id="education" class="form-control" value="<?=stripslashes($row_user_query->education)?>">
                            <label for="jobtitle" class="control-label">Education</label>
                        </div>
                          
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="bio" id="bio" class="form-control" value="<?=stripslashes($row_user_query->bio)?>">
                            <label for="department" class="control-label">Bio</label>
                        </div>
                    </div>
                  
                </div>
            	<div class="row">
                    <div class="col-sm-5">
                   		<div class="form-group">
                        	<input type="text" name="gender" id="gender" class="form-control" value="<?=stripslashes($row_user_query->gender)?>">
                            <label for="website" class="control-label">Gender</label>
                        </div>
                    </div>
                    <div class="col-sm-5">
                    	<div class="form-group">
                            <input type="file" class="form-control dirty" name="profile_pic" id="profile_pic" value="<?=stripslashes($row_user_query->profile_pic)?>">
                            <label for="profile_pic">Profile Picture</label>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" id="address" required value="<?=stripslashes($row_user_query->address)?>">
                            <label for="address">Address</label>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
							<input type="text" class="form-control" name="country" id="country" required value="<?=stripslashes($row_user_query->country)?>">
                            <label for="country">Country</label>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
							<input type="text" class="form-control" name="city" id="city" required value="<?=stripslashes($row_user_query->city)?>">
                            <label for="city">City</label>
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="pphone" id="pphone" class="form-control" value="<?=stripslashes($row_user_query->pphone)?>">
                            <label for="pphone" class="control-label">Phone Personal</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input type="text" name="mphone" id="mphone" class="form-control" value="<?=stripslashes($row_user_query->mphone)?>">
                            <label for="mphone" class="control-label">Mobile Phone</label>
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