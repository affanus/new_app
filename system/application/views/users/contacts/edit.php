<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/wizard/wizard.css?1425466601" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<script>
var email_validation=1;
$(document).ready(function() {
  	$('#summernote').summernote({height: 300});
  	$("#company_name").select2({allowClear: true});
	$("#country").select2({allowClear: true});
	$("#state").select2({allowClear: true});
	$("#city").select2({allowClear: true});
	
	
	$("#country").on("change", function (e) { 
		var currentValue = $(this).val();
		$('.states_wrap').html('Loading States....');
		$('.city_wrap').html('');
		var request =  $.ajax({
			url:'<?php echo base_url();?>admin/<?=$controler_name?>/get_options',
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
			url:'<?php echo base_url();?>admin/<?=$controler_name?>/get_options',
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
  	$('#format').submit(function( event ) {
	  	var sHTML = $('#summernote').code();
	  	$("textarea#editor1").val(sHTML);
  	});
	$('#bday').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
});
</script>
<div id="content">
	<section class="">
    	<div class="section-header" style="position: relative;">
			<ol class="breadcrumb">
				<li><a href="<?= base_url().'user/'.$controler_name?>">Your Contacts</a></li>
				<li class="active"><?= $title ?></li>
			</ol>
		</div>
        <div class="section-body">
        	<? 
//$attributes = array('id' => 'format','name' => 'form','class' => 'form floating-label form-validate');
//echo form_open_multipart('admin/'.$controler_name.'/add_action/'.$this->uri->segment(4), $attributes);
 	
?>            <?
	$row = $query->row();	

	?>
				<div class="card">
					<div class="card-head style-primary">
						<header><?= $title ?></header>
					</div>
					<div class="card-body floating-label ">
						<div id="rootwizard2" class="form-wizard form-wizard-horizontal">
							<form class="form floating-label form-validation" role="form" novalidate="novalidate" action="<?= base_url().'user/'.$controler_name.'/edit_action/'.$row->id;?>" method="post" enctype="multipart/form-data">
								<div class="form-wizard-nav">
									<div class="progress"><div class="progress-bar progress-bar-primary"></div></div>
									<ul class="nav nav-justified">
										<li class="active"><a href="#step1" data-toggle="tab"><span class="step">1</span> <span class="title">PERSONAL INFO</span></a></li>
										<li><a href="#step2" data-toggle="tab"><span class="step">2</span> <span class="title">COMPANY INFO</span></a></li>
										<li><a href="#step3" data-toggle="tab"><span class="step">3</span> <span class="title">CONTACT INFO</span></a></li>
									</ul>
								</div><!--end .form-wizard-nav -->
								<div class="tab-content clearfix">
									<div class="tab-pane active" id="step1">
                                    	<br /><br />
										<div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <select id="title" name="title" class="form-control" required>
                                                        <option value="">&nbsp;</option>
                                                        <option value="Mr" <? if($row->title == 'Mr') { ?> selected="selected"<? } ?>>Mr.</option>
                                                        <option value="Mrs" <? if($row->title == 'Mrs') { ?> selected="selected"<? } ?>>Mrs.</option>
                                                        <option value="Miss" <? if($row->title == 'Miss') { ?> selected="selected"<? } ?>>Miss.</option>
                                                    </select>
                                                    <label for="title" class="control-label">Title</label>
                                               </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="fname" id="fname" class="form-control" data-rule-minlength="2" required value="<?= stripslashes($row->fname)?>">
                                                    <label for="fname" class="control-label">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" value="<?= stripslashes($row->lname)?>" name="lname" id="lname" class="form-control" data-rule-minlength="2" required>
                                                    <label for="lname" class="control-label">Last name</label>
                                                </div>
                                            </div>
										</div>
                                        <div class="row">
                                        	<div class="col-lg-4">
                                                <div class="form-group has-feedback">
                                                    <input type="email" name="email" id="email" class="form-control" data-rule-email="true" required value="<?= stripslashes($row->email)?>">
                                                    <span class="glyphicon form-control-feedback" id="email-feedback" style="display:none"></span>
                                                    <span id="email-error-va" class="help-block" style="display: none;"></span>
													<label for="email" class="control-label">Email</label>
                                                </div>
                                            </div>
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="bday" id="bday" class="form-control" value="<?= stripslashes($row->bday)?>">
                                                    <label for="bday" class="control-label">Birthday</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="website" id="website" value="<?= stripslashes($row->website)?>" class="form-control" data-rule-url="true">
                                                    <label for="website" class="control-label">Website</label>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="col-sm-3">
                                                <? if($row->profile_pic!=''):?><img class="img-circle width-1" src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($row->profile_pic)?>" alt=""><? else:?><img class="img-circle width-1" src="<?=base_url()?>assets/img/no-user-image-square.jpg" /><? endif;?>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="form-group">
                                                        <input type="file" class="form-control dirty" name="profile_pic" id="profile_pic">
                                                        <label for="profile_pic">Profile Picture</label>
                                                    </div>
                                            	</div>
                                            </div>
                                        	<div class="col-sm-4" style="    padding-top: 16px;">
                                            	<div class="btn-group" data-toggle="buttons">
                                                    <label class="btn ink-reaction btn-primary">
                                                        <input type="radio" name="gender" id="option1" value="1" <? if($row->gender == '1') { ?>checked="checked"<? } ?>><i class="fa fa-male fa-fw"></i> Male
                                                    </label>
                                                    <label class="btn ink-reaction btn-primary">
                                                        <input type="radio" name="gender" id="option3" value="2" <? if($row->gender == '2') { ?>checked="checked"<? } ?>><i class="fa fa-female fa-fw"></i> Female
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
														
									</div><!--end #step1 -->
									<div class="tab-pane" id="step2">
										<div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="jobtitle" id="jobtitle" class="form-control" value="<?= stripslashes($row->jobtitle)?>">
                                                    <label for="jobtitle" class="control-label">Job Title</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="department" id="department" class="form-control" value="<?= stripslashes($row->department)?>">
                                                    <label for="department" class="control-label">Department</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <select class="form-control" id="company_name" name="company_name" required>
                                                     	<option value=""></option>
														<?   if($query_companies->num_rows() != 0) : 
                                                            foreach($query_companies->result() as $row_companies):?>
                                                                <option value="<?=$row_companies->id?>" <? if($row->company_name == $row_companies->id) { ?> selected="selected"<? } ?>><?= stripslashes($row_companies->title);?></option>
                                                            <? endforeach; ?>
                                                        <? endif; ?>
                                                    </select>
													<label for="company_name">Company Name</label>
                                                </div>
                                            	
                                            </div>
                                        </div>
									</div><!--end #step2 -->
									<div class="tab-pane" id="step3">
										<div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="address" id="address" value="<?= stripslashes($row->address)?>">
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
                                                            foreach($query_countries->result() as $row_countries):?>
                                                                <option value="<?=$row_countries->id?>" <? if($row->country == $row_countries->id) { ?> selected="selected"<? } ?>><?= stripslashes($row_countries->title);?></option>
                                                            <? endforeach; ?>
                                                        <? endif; ?>
                                                    </select>
                                                    <label for="country">Country</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group states_wrap">
                									<select class="form-control" required id="state" name="state">
                                                    <option value=""></option>
                                                    <?   if($query_states->num_rows() != 0) : 
                                                        foreach($query_states->result() as $row_states):?>
                                                            <option value="<?=$row_states->id?>" <? if($row_states->id==$row->state):?>selected="selected"<? endif;?>><?= stripslashes($row_states->title);?></option>
                                                        <? endforeach; ?>
                                                    <? endif; ?>
                                                </select>
                                                <label for="state">State</label>
                                                </div>
                                            </div> 
                                            <div class="col-lg-4">
                                                <div class="form-group city_wrap">
                									<select class="form-control" required id="city" name="city">
                                                        <option value=""></option>
                                                        <?   if($query_cities->num_rows() != 0) : 
                                                            foreach($query_cities->result() as $row_cities):?>
                                                                <option value="<?=$row_cities->id?>" <? if($row_cities->id==$row->city):?>selected="selected"<? endif;?>><?= stripslashes($row_cities->title);?></option>
                                                            <? endforeach; ?>
                                                        <? endif; ?>
                                                    </select>
                                                    <label for="city">City</label>
                                                </div>

                                            </div> 
                                        </div>
                        				<div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="bphone" id="bphone" class="form-control" value="<?= stripslashes($row->bphone)?>">
                                                    <label for="bphone" class="control-label">Business Phone</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="pphone" id="pphone" class="form-control" value="<?= stripslashes($row->pphone)?>">
                                                    <label for="pphone" class="control-label">Phone Personal</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="mphone" id="mphone" class="form-control" value="<?= stripslashes($row->mphone)?>">
                                                    <label for="mphone" class="control-label">Mobile Phone</label>
                                                </div>
                                            	
                                            </div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="fax" id="fax" class="form-control" value="<?= stripslashes($row->fax)?>"> 
                                                    <label for="fax" class="control-label">Fax</label>
                                                </div>
                                                
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <input type="text" name="pobox" id="pobox" class="form-control" value="<?= stripslashes($row->pobox)?>">
                                                    <label for="pobox" class="control-label">P.O.Box</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            	<div class="form-group">
                                                    <select id="pmc" name="pmc" class="form-control">
                                                        <option value="">&nbsp;</option>
                                                        <option value="1" <? if($row->pmc == '1') { ?> selected="selected"<? } ?>>Business Phone</option>
                                                        <option value="2" <? if($row->pmc == '2') { ?> selected="selected"<? } ?>>Phone Personal</option>
                                                        <option value="3" <? if($row->pmc == '3') { ?> selected="selected"<? } ?>>Mobile Phone</option>
                                                        <option value="4" <? if($row->pmc == '4') { ?> selected="selected"<? } ?>>Fax</option>
                                                        <option value="5" <? if($row->pmc == '5') { ?> selected="selected"<? } ?>>P.O.Box</option>
                                                        <option value="6" <? if($row->pmc == '6') { ?> selected="selected"<? } ?>>Email</option>
                                                    </select>
                                                    <label for="pmc" class="control-label">Preferred Method of Contact</label>
                                                </div>
                                            	
                                            </div>
                                        </div>
									</div><!--end #step3 -->

								</div><!--end .tab-content -->
								<ul class="pager wizard">
													
									<li class="previous"><a class="btn-raised" href="javascript:void(0);">Previous</a></li>
													
									<li class="next"><a class="btn-raised" href="javascript:void(0);">Next</a></li>
                                    <li class="submit"><button type="submit" class="btn ink-reaction btn-primary style-primary" disabled="disabled" id="submit_button">Submit</button></li>
								</ul>
							</form>
						</div>


					</div><!--end .card-body -->
				</div><!--end .card -->

			<? //echo form_close();?>
        </div>
    </section>
    
</div>