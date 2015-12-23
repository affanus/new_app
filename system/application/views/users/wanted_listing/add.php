<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<script>

$(document).ready(function() {
  	$('#summernote').summernote({height: 300});
	$("#country_contacts").select2({allowClear: true});
	$("#contact_info").select2({
		allowClear: true,
		minimumInputLength: 2,
		ajax: {
			url: '<?php echo base_url();?>user/engine_listings/get_contacts',
			dataType: 'json',
			type: "post",
			quietMillis: 50,
			data: function (term) {
				return {
					term: term
				};
			},
			results: function (data) {
				return {
					results: $.map(data, function (item) {
						return {
							text: item.completeName,
							slug: item.slug,
							id: item.id
						}
					})
				};
			}
		}
	
	});

	
	$("#country_contacts").on("change", function (e) { 
		var currentValue = $(this).val();
		$('.states_wrap_contacts').html('Loading States....');
		$('.city_wrap_contacts').html('');
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/get_options_contacts',
			type:'post',
			data:{editid:currentValue,level:'RE'}
		});
		request.done(function( msg ) {
		  $('.states_wrap_contacts').html(msg);
		  $("#state_contacts").select2({allowClear: true});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	
	
	$("#state_contacts").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.city_wrap_contacts').html('Loading Cities....');
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/get_options_contacts',
			type:'post',
			data:{editid:currentValue,level:'CI'}
		});
		request.done(function( msg ) {
		  $('.city_wrap_contacts').html(msg);
		  $("#city_contacts").select2({allowClear: true});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	
	

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
	var validator = $( "#addNewContact" ).validate();
	$(this).data('validator', validator);
	$( "#addNewContact" ).live('submit',function(event){
		event.preventDefault();
		var card = $('.addcontactcard');
		materialadmin.AppCard.addCardLoader(card);
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/addContact',
			type:'post',
			data:{
				title:$('#title').val(),
				fname:$('#fname').val(),
				lname:$('#lname').val(),
				bday:$('#bday').val(),
				email:$('#email').val(),
				jobtitle:$('#jobtitle').val(),
				department:$('#department').val(),
				company_name:$('#company_name').val(),
				bphone:$('#bphone').val(),
				pphone:$('#pphone').val(),
				mphone:$('#mphone').val(),
				address:$('#address').val(),
				city:$('#city_contacts').val(),
				country:$('#country_contacts').val(),
				state:$('#state_contacts').val(),
				website:$('#website').val(),
				fax:$('#fax').val(),
				pobox:$('#pobox').val(),
				pmc:$('#pmc').val()
			}
		});
		request.done(function( msg ) {
		  materialadmin.AppCard.removeCardLoader(card);
		  var offCan=$('#offcanvas-demo-size4');
		  materialadmin.AppOffcanvas.closeOffcanvas(offCan);
		   materialadmin.AppOffcanvas.toggleBackdropState(offCan);
		  
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
});
</script>
<div id="content">
	<section class="style-default">
    	<div class="section-header" style="position: relative;">
			<ol class="breadcrumb">
				<li><a href="<?= base_url().'user/'.$controler_name?>">Your Listed Spare Parts</a></li>
				<li class="active"><?= $title ?></li>
			</ol>
		</div>
        <div class="section-body">
        	<? 
$attributes = array('id' => 'format','name' => 'form','class' => 'form floating-label form-validate');
echo form_open_multipart('user/'.$controler_name.'/add_action/'.$this->uri->segment(4), $attributes);
 	
?>
				<div class="card">
					<div class="card-head style-primary">
						<header><?= $title ?></header>
					</div>
					<div class="card-body floating-label ">

						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<select class="form-control" id="wanted_type" name="wanted_type" required>
                                   		<option value=""></option>
                                    	<option value="1">Aircraft</option>
										<option value="2">Engine</option>
                                        <option value="3">APU</option>
                                        <option value="4">Spare Part</option>
                                        <option value="5">Airlines c of c</option>
									</select>
									<label for="wanted_type">Type</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<select class="form-control" id="wanted_terms" name="wanted_terms" required>
                                   		<option value=""></option>
                                    	<option value="1">Acmi</option>
										<option value="2">Lease</option>
                                        <option value="3">Exchange</option>
                                        <option value="4">Cash</option>
									</select>
									<label for="p_number">Wanted terms</label>
								</div>
							</div>
                            
						</div>
                        
                        <div class="row">
							<div class="col-lg-4">
                            	<div class="form-group">
                                	<select class="form-control" required id="condition" name="condition">
                                   		<option value=""></option>
                                    	<?   if($query_condition_set->num_rows() != 0) : 
											foreach($query_condition_set->result() as $row):?>
                                    			<option value="<?=$row->id?>"><?= stripslashes($row->title);?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
														
									</select>
									<label for="condition">Condition </label>
                                </div>
                            </div>  
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="quantity" id="quantity">
									<label for="quantity">Quantity</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<select class="form-control" id="release" name="release">
                                   		<option value=""></option>
                                    	<option value="1">EASA Form 1</option>
										<option value="2">FAA 8130-3 Form</option>
                                        <option value="3">C of C</option>
                                        <option value="4">Manufacturer Cert</option>
                                        <option value="5">Airlines c of c</option>
									</select>
									<label for="release">Release</label>
								</div>
							</div>
                        </div>
                        
                        
                        
                        <div class="row">
							
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" required id="contact_info" name="contact_info">
                                   		
									<label for="contact_info">Contact Info </label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
                                	<a class="btn btn-raised ink-reaction btn-primary" href="#offcanvas-demo-size4" data-toggle="offcanvas"><i class="fa fa-plus fa-fw"></i> Add New Contact</a>
                                </div>
                            </div>
						</div>
                        
                        
                            

                        <div class="row">
                        	<div class="col-lg-12">
                            	<div class="form-group">
                                    <div id="summernote">
                                    </div>
                                </div>
                            </div>
                            <textarea id="editor1" name="editor1" style="display:none"></textarea>
                        </div>
                        <br/>


					</div><!--end .card-body -->
					<div class="card-actionbar">
						<div class="card-actionbar-row">
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Create Wanted Listing</button>
						</div>
					</div>
				</div><!--end .card -->

			<? echo form_close();?>
        </div>
    </section>
    
</div>
<div class="offcanvas">
	<div id="offcanvas-demo-size4" class="offcanvas-pane width-12" style="width:800px">
		<div class="offcanvas-head">
			<header class="text-primary">Add New Contact</header>
			<div class="offcanvas-tools">
				<a class="btn btn-icon-toggle btn-default-light pull-right" data-dismiss="offcanvas">
					<i class="md md-close"></i>
				</a>
			</div>
		</div>
		<div class="offcanvas-body">
			<div class="card addcontactcard" style="box-shadow: none;">
				
				<div class="card-body">
                	<form id="addNewContact" class="form floating-label form-validation" role="form" novalidate="novalidate"  method="post" enctype="multipart/form-data">
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
                            <div class="col-lg-4">
                                <div class="form-group has-feedback">
                                    <input type="email" name="email" id="email" class="form-control" data-rule-email="true" required>
                                    <span class="glyphicon form-control-feedback" id="email-feedback" style="display:none"></span>
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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="website" id="website" class="form-control" >
                                    <label for="website" class="control-label">Website</label>
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
                                    <input type="text" class="form-control" name="address" id="address" >
                                    <label for="address">Address</label>
                                </div>
                            </div>  
                        </div>										
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <select class="form-control" id="country_contacts" name="country">
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
                                <div class="form-group states_wrap_contacts">

                                </div>
                            </div> 
                            <div class="col-lg-4">
                                <div class="form-group city_wrap_contacts">

                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="bphone" id="bphone" class="form-control" data-rule-number="true">
                                    <label for="bphone" class="control-label">Business Phone</label>
                                </div>
                                
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="pphone" id="pphone" class="form-control" data-rule-number="true">
                                    <label for="pphone" class="control-label">Phone Personal</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="mphone" id="mphone" class="form-control" data-rule-number="true">
                                    <label for="mphone" class="control-label">Mobile Phone</label>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" name="fax" id="fax" class="form-control" data-rule-number="true">
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
                                        <option value="6">Email</option>
                                    </select>
                                    <label for="pmc" class="control-label">Preferred Method of Contact</label>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                        	<button type="submit" class="btn ink-reaction btn-primary style-primary" id="addNewContactSubmitButton">Add Contact</button>
                        </div>               
                    </form>                   
			
				</div>
			</div>
		</div>
					
	</div>
</div>