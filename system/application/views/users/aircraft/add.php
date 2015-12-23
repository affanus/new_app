<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/wizard/wizard.css?1425466601" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<script>
var email_validation=1;
$(document).ready(function() {
  	$('#summernote').summernote({height: 300});
  	$("#e_man_id").select2({allowClear: true});
	$("#e_man_id").css({position:'absolute',top:0,left:0,zIndex:'-1',display:'block'});
	$("#reg_in").select2({allowClear: true});
	$("#company_name").select2({allowClear: true});
	
	$("#current_location").select2({
		allowClear: true,
		minimumInputLength: 3,
		ajax: {
			url: '<?php echo base_url();?>user/<?=$controler_name?>/load_airports',
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
	
	$("#owner, #seller, #primary_contact").select2({
		allowClear: true,
		minimumInputLength: 2,
		ajax: {
			url: '<?php echo base_url();?>user/<?=$controler_name?>/get_contacts',
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
	$("#cat_id").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.man_wrap').html('Loading Aircraft Manufacturer ....');
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/load_aircraft_options',
			type:'post',
			data:{editid:currentValue,type:'man'}
		});
		request.done(function( msg ) {
		  $('.man_wrap').html(msg);
		  $("#man_id").select2({allowClear: true});
		  $("#man_id").css({position:'absolute',top:0,left:0,zIndex:'-1',display:'block'});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	
	$("#man_id").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.type_wrap').html('Loading Aircraft Type ....');
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/load_aircraft_options',
			type:'post',
			data:{editid:currentValue,type:'airtype'}
		});
		request.done(function( msg ) {
		  $('.type_wrap').html(msg);
		  $("#type_id").select2({allowClear: true});
		  $("#type_id").css({position:'absolute',top:0,left:0,zIndex:'-1',display:'block'});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	
	$("#type_id").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.model_wrap').html('Loading Aircraft Model ....');
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/load_aircraft_options',
			type:'post',
			data:{editid:currentValue,type:'model'}
		});
		request.done(function( msg ) {
		  $('.model_wrap').html(msg);
		  $("#model_id").select2({allowClear: true});
		  $("#model_id").css({position:'absolute',top:0,left:0,zIndex:'-1',display:'block'});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	
	$("#e_man_id").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.etype_wrap').html('Loading Engine Type ....');
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/load_aircraft_options',
			type:'post',
			data:{editid:currentValue,type:'etype'}
		});
		request.done(function( msg ) {
		  $('.etype_wrap').html(msg);
		  $("#e_type_id").select2({allowClear: true});
		  $("#e_type_id").css({position:'absolute',top:0,left:0,zIndex:'-1',display:'block'});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	
	$("#e_type_id").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.emodel_wrap').html('Loading Engine Model ....');
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/load_aircraft_options',
			type:'post',
			data:{editid:currentValue,type:'emodel'}
		});
		request.done(function( msg ) {
		  $('.emodel_wrap').html(msg);
		  $("#e_model_id").select2({allowClear: true});
		  $("#e_model_id").css({position:'absolute',top:0,left:0,zIndex:'-1',display:'block'});
		});
		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});
	});
	$('#addmorefields').live('click',function(event){
		event.preventDefault();	
		$('.media').append('<div class="col-lg-12"><div class="form-group"><input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage"><label for="galleryImage">Aircraft Gallery Image</label></div></div>');
	});
  	$('#format').submit(function( event ) {
	  	var sHTML = $('#summernote').code();
	  	$("textarea#editor1").val(sHTML);
  	});
	$("#country").select2({allowClear: true});
	
	$("#country").on("change", function (e) { 
		var currentValue = $(this).val();
		$('.states_wrap').html('Loading States....');
		$('.city_wrap').html('');
		var request =  $.ajax({
			url:'<?php echo base_url();?>user/<?=$controler_name?>/get_options',
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
			url:'<?php echo base_url();?>user/<?=$controler_name?>/get_options',
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
	$('#yom').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$('#last_c_check').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$('#last_d_check').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$('#lh_main_landing_g_oh').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$('#rh_main_landing_g_oh').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$('#n_landing_g_oh').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$('#availability_date').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$('#bday').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$("#offered_for").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.offered_for_options').hide();
		if(currentValue==1){
			$('.offered_for_options.sale').fadeIn();
		}else if(currentValue==2 || currentValue==4 || currentValue==5){
			$('.offered_for_options.lease').fadeIn();
		}else if(currentValue==3){
			$('.offered_for_options.acmi').fadeIn();
		}
	});
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
				city:$('#city').val(),
				country:$('#country').val(),
				state:$('#state').val(),
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
				<li><a href="<?= base_url().'user/'.$controler_name?>">Your Listed Aircraft</a></li>
				<li class="active"><?= $title ?></li>
			</ol>
		</div>
        <div class="section-body">
        	<? 
//$attributes = array('id' => 'format','name' => 'form','class' => 'form floating-label form-validate');
//echo form_open_multipart('user/'.$controler_name.'/add_action/'.$this->uri->segment(4), $attributes);
 	
?>
				<div class="card">
					<div class="card-head style-primary">
						<header><?= $title ?></header>
					</div>
					<div class="card-body floating-label ">
						<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
							<form id="format" class="form floating-label form-validation" role="form" novalidate="novalidate" action="<?= base_url().'user/'.$controler_name.'/add_action/';?>" method="post" enctype="multipart/form-data">
								<div class="form-wizard-nav ">
									<div class="progress"><div class="progress-bar progress-bar-primary"></div></div>
									<ul class="nav nav-justified">
										<li class="active "><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">Aircraft Type & Engine</span></a></li>
										<li><a href="#step2" data-toggle="tab"><span class="step">2</span> <span class="title">Aircraft Details</span></a></li>
                                        <li><a href="#step3" data-toggle="tab"><span class="step">3</span> <span class="title">Aircraft Maintenance INFO</span></a></li>
										<li><a href="#step4" data-toggle="tab"><span class="step">3</span> <span class="title">Listing INFO</span></a></li>
										
									</ul>
								</div><!--end .form-wizard-nav -->
                                <br/>
								<div class="tab-content clearfix">
									<div class="tab-pane active" id="step1">
                                        
                                        <div class="row">
                                        	<div class="col-sm-3">
                                            	<div class="form-group">
                                                    <select class="form-control" id="cat_id" name="cat_id" required>
                                                     	<option value=""></option>
														<?   if($query_aircat->num_rows() != 0) : 
                                                            foreach($query_aircat->result() as $row_aircat):?>
                                                                <option value="<?=$row_aircat->id?>"><?= stripslashes($row_aircat->title);?></option>
                                                            <? endforeach; ?>
                                                        <? endif; ?>
                                                    </select>
													<label for="cat_id">Aircraft Category </label>
                                               </div>
                                            </div>
                                            <div class="col-sm-3">
                                            	<div class="form-group man_wrap">
                                                    <select class="form-control" id="man_id" name="man_id" required>
                                                    	<option value=""></option>
                                                    </select>
                                                    <label for="man_id" class="control-label">Aircraft Manufacturer</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                            	<div class="form-group type_wrap">
                                                    <select class="form-control" id="type_id" name="type_id" required>
                                                    	<option value=""></option>
                                                    </select>
                                                    <label for="type_id" class="control-label">Aircraft Type</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                            	<div class="form-group model_wrap">
                                                    <select class="form-control" id="model_id" name="model_id" required>
                                                    	<option value=""></option>
                                                    </select>
                                                    <label for="model_id" class="control-label">Aircraft Model</label>
                                                </div>
                                            </div>
										</div>
                                        <div class="row">
                                        	<div class="col-lg-3">
                                                <div class="form-group has-feedback">
                                                    <input type="text" name="msn" id="msn" class="form-control"  required>
													<label for="msn" class="control-label">MSN</label>
                                                </div>
                                            </div>
                                        	<div class="col-sm-3">
                                            	<div class="form-group">
                                                    <select class="form-control" id="e_man_id" name="e_man_id" required>
                                                     	<option value=""></option>
														<?   if($query_e_man->num_rows() != 0) : 
                                                            foreach($query_e_man->result() as $row_e_man):?>
                                                                <option value="<?=$row_e_man->id?>"><?= stripslashes($row_e_man->title);?></option>
                                                            <? endforeach; ?>
                                                        <? endif; ?>
                                                    </select>
													<label for="e_man_id">Engine Manufacturer </label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-3">
                                            	<div class="form-group etype_wrap">
                                                   <select id="e_type_id" name="e_type_id" class="form-control" required>
                                                        <option value="">&nbsp;</option>
             
                                                    </select>
                                                    <label for="e_type_id" class="control-label">Engine Type</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                            	<div class="form-group emodel_wrap">
                                                   <select id="e_model_id" name="e_model_id" class="form-control" required>
                                                        <option value="">&nbsp;</option>
             
                                                    </select>
                                                    <label for="e_model_id" class="control-label">Engine Model</label>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
														
									</div><!--end #step1 -->
									<div class="tab-pane" id="step2">
										<div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="yom" id="yom" class="form-control" required>
                                                    <label for="yom" class="control-label">YOM</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="total_time" id="total_time" class="form-control" required>
                                                    <label for="total_time" class="control-label">Total Time</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="total_cycles" id="total_cycles" class="form-control">
                                                    <label for="total_time" class="control-label">Total Cycles</label>
                                                </div>
                                                
                                            </div>
                                            
                                            
                                        </div>
                                        
                                        <div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="mtow" id="mtow" class="form-control">
                                                    <label for="mtow" class="control-label">MTOW</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="mlgw" id="mlgw" class="form-control">
                                                    <label for="mlgw" class="control-label">MLGW</label>
                                                </div>
                                                
                                            </div>
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                   <select id="stage" name="stage" class="form-control">
                                                        <option value="">&nbsp;</option>
                                                        <option value="1">Stage 1</option>
                                                        <option value="2">Stage 2</option>
                                                        <option value="3">Stage 3</option>
                                                    </select>
                                                    <label for="stage" class="control-label">Stage</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <select id="aircraft_config" name="aircraft_config" class="form-control">
                                                        <option value="">&nbsp;</option>
                                                        <option value="1">Freighter </option>
                                                        <option value="2">Pax</option>
                                                    </select>
                                                    <label for="aircraft_config" class="control-label">Aircraft Configuration</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <select id="status" name="status" class="form-control" required>
                                                        <option value="">&nbsp;</option>
                                                        <option value="1">Storage</option>
                                                        <option value="2">Parking</option>
                                                        <option value="3">Operational</option>
                                                        <option value="4">For Tear Down</option>
                                                    </select>
                                                    <label for="status" class="control-label">Status</label>

                                                </div>
                                                
                                            </div>
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                   <select class="form-control" id="reg_in" name="reg_in">
                                                                <option value=""></option>
                                                        <?   if($query_countries->num_rows() != 0) : 
                                                            foreach($query_countries->result() as $row):?>
                                                                <option value="<?=$row->id?>"><?= stripslashes($row->title);?></option>
                                                            <? endforeach; ?>
                                                        <? endif; ?>
                                                    </select>
                                                    <label for="reg_in">Registered in</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                        	<div class="col-lg-12"><h4 class="text-default">Comments</h4></div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div id="summernote">
                                                    </div>
                                                </div>
                                            </div>
                                            <textarea id="editor1" name="editor1" style="display:none"></textarea>
                                        </div>
                                        <br/>
                                        
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-head style-accent">
                                                        <header>Media Section (Aircraft Images)</header>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control dirty" name="featuredImage" id="featuredImage" required>
                                                                    <label for="featuredImage">Aircraft Main Image</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control dirty" name="coverImage" id="coverImage" required>
                                                                    <label for="coverImage">Aircraft Cover Image</label>
                                                                </div>
                                                            </div>
                                                        </div>
     
                                                        <div class="row media">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage" >
                                                                    <label for="galleryImage">Aircraft Gallery Image</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <a class="btn ink-reaction btn-raised btn-default-light" id="addmorefields"><i class="fa fa-plus fa-fw"></i> Add More Gallery Images</a>
                                                            </div>
                                                        </div>
                                                       
                                                        
                                                    </div>
                                                </div>
                                            </div>
                        				</div>
									</div><!--end #step2 -->
									<div class="tab-pane" id="step3">								
                                        <div class="row">
                                            <div class="col-lg-4">
                                                 <div class="form-group">
                                                    <input type="text" class="form-control" name="last_c_check" id="last_c_check" >
                                                    <label for="last_c_check">Last C-Check</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group states_wrap">
                									<input type="text" class="form-control" name="tfh_c_check" id="tfh_c_check" data-rule-number="true">
                                                    <label for="tfh_c_check">TFH at Last C-Check</label>
                                                </div>
                                            </div> 
                                            <div class="col-lg-4">
                                                <div class="form-group city_wrap">
                									<input type="text" class="form-control" name="time_remaining_c" id="time_remaining_c" data-rule-number="true">
                                                    <label for="time_remaining_c">Time Remaining</label>
                                                </div>
                                            </div> 
                                        </div>
                        				<div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="last_d_check" id="last_d_check" class="form-control">
                                                    <label for="last_d_check" class="control-label">Last D-Check (Heavy Check)</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="last_d_check" id="last_d_check" class="form-control" data-rule-number="true">
                                                    <label for="last_d_check" class="control-label">TFH at Last D-Check</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="time_remaining_d" id="time_remaining_d" class="form-control" data-rule-number="true">
                                                    <label for="time_remaining_d" class="control-label">Time Remaining</label>
                                                </div>
                                            	
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="lh_main_landing_g_oh" id="lh_main_landing_g_oh" class="form-control" >
                                                    <label for="lh_main_landing_g_oh" class="control-label">L/H Main Landing Gear Last Overhaul</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="lh_main_landing_g_tcslsv" id="lh_main_landing_g_tcslsv" class="form-control" data-rule-number="true">
                                                    <label for="lh_main_landing_g_tcslsv" class="control-label">L/H Main Landing Gear TCSLSV</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="rh_main_landing_g_oh" id="rh_main_landing_g_oh" class="form-control" >
                                                    <label for="rh_main_landing_g_oh" class="control-label">R/H Main Landing Gear Last Overhaul</label>
                                                </div>
                                            	
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="rh_main_landing_g_tcslsv" id="rh_main_landing_g_tcslsv" class="form-control" data-rule-number="true">
                                                    <label for="rh_main_landing_g_tcslsv" class="control-label">R/H Main Landing Gear TCSLSV</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="n_landing_g_oh" id="n_landing_g_oh" class="form-control">
                                                    <label for="n_landing_g_oh" class="control-label">Nose Landing Gear Last Overhaul</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="n_main_landing_g_tcslsv" id="n_main_landing_g_tcslsv" class="form-control" data-rule-number="true">
                                                    <label for="n_main_landing_g_tcslsv" class="control-label">Nose Landing Gear TCSLSV</label>
                                                </div>
                                            	
                                            </div>
                                        </div>
									</div><!--end #step3 -->
									<div class="tab-pane" id="step4">
																				
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                     <input type="text" name="availability_date" id="availability_date" class="form-control" required>
                                                     <label for="availability_date" class="control-label">Availability Date</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                									<input type='text' id="current_location" name="current_location" class="form-control">
                                                       
                                                    <label for="current_location" class="control-label">Current Location</label>
                                                </div>
                                            </div> 
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <input type="file" class="form-control dirty" name="specs_file" id="specs_file" accept="application/pdf">
                                                    <label for="specs_file">Specs File </label>
                                                </div>
                                            </div> 
                                        </div>
                        				<div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" class="form-control" id="owner" name="owner">
                                                    <label for="owner">Owner</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" class="form-control" id="seller" name="seller">
                                                    <label for="seller">Seller</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" class="form-control" id="primary_contact" name="primary_contact" required>
                                                    <label for="primary_contact">Primary Contact</label>
                                                </div>
                                            	
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-sm-12"><p class="text-lg">If haven't added the required yet you can add it by clicking on this button</p><a class="btn btn-raised ink-reaction btn-primary" href="#offcanvas-demo-size4" data-toggle="offcanvas"><i class="fa fa-plus fa-fw"></i> Add New Contact</a></div>
                                            
                                        </div>
                                        <br />
                                        <div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <select id="offered_for" name="offered_for" class="form-control" required>
                                                        <option value="">&nbsp;</option>
                                                        <option value="1">Sale</option>
                                                        <option value="2">Lease</option>
                                                        <option value="3">ACMI</option>
                                                        <option value="4">Dry Lease</option>
                                                        <option value="5">Wet Lease</option>
                                                    </select>
                                                    <label for="offered_for" class="control-label">Offered for</label>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="row offered_for_options acmi" style="display:none">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    
                                                    <div class="input-group">
                                                        
                                                        <div class="input-group-content">
                                                            <input type="text" name="mgh_acmi" id="mgh_acmi" class="form-control" data-rule-number="true">
                                                    		<label for="mgh_acmi" class="control-label">MGH</label>
                                                        </div>
                                                        <span class="input-group-addon">/m</span>
                                                    </div>
                                                </div>
                                            	
                                            </div>
                                            
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                              
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-usd fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" name="p_b_h" id="p_b_h" class="form-control" data-rule-number="true">
                                                    		<label for="p_b_h" class="control-label">Price per block hour</label>
                                                        </div>
                                                        <span class="input-group-addon">/BH</span>
                                                    </div>
                                                </div>
                                            	
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="cpd" id="cpd" class="form-control" data-rule-number="true">
                                                    <label for="cpd" class="control-label">CPD – Crew Per Diem</label>
                                                </div>
                                            	
                                            </div>
                                            
                                        </div>
                                        <div class="row offered_for_options sale" style="display:none">
                                        	<div class="col-sm-12">
                                            	<div class="form-group">
                                                    
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-usd fa-lg"></i></span>
                                                        <div class="input-group-content">
                                                            <input type="text" name="asking_price" id="asking_price" class="form-control" data-rule-number="true">
                                                            <label for="asking_price" class="control-label">Asking price</label>
                                                        </div>
                                                        <span class="input-group-addon">.00</span>
                                                    </div>
                                                </div>
                                            	
                                            </div>
                                        </div>
                                        <div class="row offered_for_options lease" style="display:none">
                                        	<div class="col-sm-12">
                                            	<div class="form-group">
                                                    <textarea name="lease_terms" id="lease_terms" class="form-control" rows="3" placeholder=""></textarea>
                                                    <label for="lease_terms" class="control-label">Lease Terms</label>
                                                </div>
                                            	
                                            </div>
                                        </div>
									</div>
								</div><!--end .tab-content -->
								<ul class="pager wizard">
													
									<li class="previous"><a class="btn-raised" href="javascript:void(0);">Previous</a></li>
													
									<li class="next"><a class="btn-raised" href="javascript:void(0);">Next</a></li>
                                    <li class="submit"><button type="submit" class="btn ink-reaction btn-primary style-accent" disabled="disabled" id="submit_button">Create Aircraft Listing</button></li>
								</ul>
							</form>
						</div>


					</div><!--end .card-body -->
				</div><!--end .card -->

			<? //echo form_close();?>
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