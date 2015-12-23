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
		$('.media').append('<div class="col-lg-12"><div class="form-group"><input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage"><label for="galleryImage">Engine Gallery Image</label></div></div>');
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
	$('#lsv_date').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});

	$('#availability_date').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$('#bday').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
	$("#offered_for").live("change", function (e) { 
		var currentValue = $(this).val();
		$('.offered_for_options').hide();
		if(currentValue==1){
			$('.offered_for_options.sale').fadeIn();
		}else if(currentValue==2 ){
			$('.offered_for_options.lease').fadeIn();
		}else if(currentValue==3){
			$('.offered_for_options.exchange').fadeIn();
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
										<li class="active "><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">Engine Type</span></a></li>
										<li><a href="#step2" data-toggle="tab"><span class="step">2</span> <span class="title">Engine Details</span></a></li>
                                        <li><a href="#step3" data-toggle="tab"><span class="step">3</span> <span class="title">Engine Maintenance INFO</span></a></li>
										<li><a href="#step4" data-toggle="tab"><span class="step">3</span> <span class="title">Listing INFO</span></a></li>
										
									</ul>
								</div><!--end .form-wizard-nav -->
                                <br/>
								<div class="tab-content clearfix">
									<div class="tab-pane active" id="step1">
                                        <div class="row">
                                        	<div class="col-sm-12">
                                            	<div class="form-group">
                                                    <input type="text" name="esn" id="esn" class="form-control"  required>
													<label for="esn" class="control-label">Engine ESN</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                        	
                                            <div class="col-sm-4">
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
                                            <div class="col-sm-4">
                                            	<div class="form-group etype_wrap">
                                                   <select id="e_type_id" name="e_type_id" class="form-control" required>
                                                        <option value="">&nbsp;</option>
             
                                                    </select>
                                                    <label for="e_type_id" class="control-label">Engine Type</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-4">
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
                                                    <input type="text" name="qec_kit" id="qec_kit" class="form-control" required>
                                                    <label for="qec_kit" class="control-label">QEC Kit</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="ttso" id="ttso" class="form-control">
                                                    <label for="ttso" class="control-label">TTSO (Hours)</label>
                                                </div>
                                                
                                            </div>
                                            
                                            
                                        </div>
                                        
                                        <div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="thrust_rating" id="thrust_rating" class="form-control">
                                                    <label for="thrust_rating" class="control-label">Thrust Rating</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="egt_margin" id="egt_margin" class="form-control">
                                                    <label for="egt_margin" class="control-label">EGT Margin</label>
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
                                                    <select id="status" name="status" class="form-control" required>
                                                        <option value="">&nbsp;</option>
                                                        <option value="1">Storage</option>
                                                        <option value="3">Operational</option>
                                                        <option value="4">For Tear Down</option>
                                                    </select>
                                                    <label for="status" class="control-label">Status</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                	<select id="lsv_d" name="lsv_d" class="form-control">
                                                        <option value="">&nbsp;</option>
                                                        <option value="1">REPAIRED </option>
                                                        <option value="2">OVERHAULD</option>
                                                        <option value="3">NEW</option>
                                                        <option value="4">TESTED</option>
                                                        <option value="5">SERVICEABLE</option>
                                                        <option value="6">AS REMOVED</option>
                                                        <option value="7">MODIFIED</option>
                                                    </select>
                                                    <label for="lsv_d" class="control-label">LSV Description</label>
                                                    

                                                </div>
                                                
                                            </div>
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                   	<input type="text" class="form-control" name="lsv_date" id="lsv_date" >
                                                    <label for="lsv_date">LSV Date</label>
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
                                                        <header>Media Section (Engine Images)</header>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control dirty" name="featuredImage" id="featuredImage" required>
                                                                    <label for="featuredImage">Engine Main Image</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control dirty" name="coverImage" id="coverImage" required>
                                                                    <label for="coverImage">Engine Cover Image</label>
                                                                </div>
                                                            </div>
                                                        </div>
     
                                                        <div class="row media">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage" >
                                                                    <label for="galleryImage">Engine Gallery Image</label>
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
                                                    <input type="text" class="form-control" name="llp_f_l" id="llp_f_l" >
                                                    <label for="llp_f_l">LLP First Limiter</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group states_wrap">
                									<input type="text" class="form-control" name="llp_d" id="llp_d" >
                                                    <label for="llp_d">LLP Description</label>
                                                </div>
                                            </div> 
                                            <div class="col-lg-4">
                                                <div class="form-group city_wrap">
                									<input type="text" class="form-control" name="tsn" id="tsn" data-rule-number="true">
                                                    <label for="tsn">Time Since New (TSN)</label>
                                                </div>
                                            </div> 
                                        </div>
                        				<div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="csn" id="csn" class="form-control" data-rule-number="true">
                                                    <label for="csn" class="control-label">Cycle Since New (CSN)</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="tslsv" id="tslsv" class="form-control" data-rule-number="true">
                                                    <label for="tslsv" class="control-label">TSLSV</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="cslsv" id="cslsv" class="form-control" data-rule-number="true">
                                                    <label for="cslsv" class="control-label">CSLSV</label>
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
                                                        <option value="3">Exchange</option>
                                                    </select>
                                                    <label for="offered_for" class="control-label">Offered for</label>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="row offered_for_options exchange" style="display:none">
                                        	<div class="col-sm-12">
                                            	<div class="form-group">
                                                    <textarea name="exchange_terms" id="exchange_terms" class="form-control" rows="3" placeholder=""></textarea>
                                                    <label for="exchange_terms" class="control-label">Exchange Terms</label>
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
                                    <li class="submit"><button type="submit" class="btn ink-reaction btn-primary style-accent" disabled="disabled" id="submit_button">Create Engine Listing</button></li>
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