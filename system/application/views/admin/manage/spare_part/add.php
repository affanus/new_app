<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<script>

$(document).ready(function() {
  	$('#summernote').summernote({height: 300});
	$("#country").select2({allowClear: true});
	$("#contact_info").select2({allowClear: true});
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
	$('#addmorefields').live('click',function(event){
		event.preventDefault();	
		$('.media').append('<div class="col-lg-12"><div class="form-group"><input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage"><label for="galleryImage">Gallery Image</label></div></div>');
	});
  	$('#format').submit(function( event ) {
	  	var sHTML = $('#summernote').code();
	  	$("textarea#editor1").val(sHTML);
  	});
	$('#tag_date').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
});
</script>
<div id="content">
	<section class="style-default-bright">
    	<div class="section-header" style="position: relative;">
			<h2 class="text-primary"></h2>
		</div>
        <div class="section-body">
        	<? 
$attributes = array('id' => 'format','name' => 'form','class' => 'form floating-label form-validate');
echo form_open_multipart('admin/'.$controler_name.'/add_action/'.$this->uri->segment(4), $attributes);
 	
?>
				<div class="card">
					<div class="card-head style-accent">
						<header><?= $title ?></header>
					</div>
					<div class="card-body floating-label ">

						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="title" id="title" required>
									<label for="title">Spare Part Title</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="p_number" id="p_number" required>
									<label for="p_number">Part Number</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="nsn" id="nsn" required>
									<label for="nsn">NSN</label>
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
									<input type="text" class="form-control" name="trace" id="trace" >
									<label for="trace">Trace</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="tag_date" id="tag_date" >
									<label for="tag_date">Tag Date</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="app_to" id="app_to" >
									<label for="app_to">Applicable to</label>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="uprice" id="uprice" >
									<label for="uprice">Unit Price</label>
								</div>
							</div>
                            <div class="col-lg-8">
								<div class="form-group">
									<select class="form-control" required id="contact_info" name="contact_info">
                                   		<option value=""></option>
                                    	<?   if($query_contacts->num_rows() != 0) : 
											foreach($query_contacts->result() as $row):?>
                                    			<option value="<?=$row->id?>"><?= stripslashes($row->fname)." ".stripslashes($row->lname)." ".stripslashes($row->email)."";?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
														
									</select>
									<label for="contact_info">Contact Info </label>
								</div>
							</div>
                            
						</div>
                        <div class="row">
                        	<div class="col-lg-4">
                            	<div class="form-group">
                                	<select class="form-control" required id="country" name="country">
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
                                        <header>Media Section (Spare Part Images)</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                        	<div class="col-lg-12">
                                            	<div class="form-group">
                                                    <input type="file" class="form-control dirty" name="featuredImage" id="featuredImage" required>
                                                    <label for="featuredImage">Spare Part Image</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row media">
                                        	<div class="col-lg-12">
                                            	<div class="form-group">
                                                    <input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage" >
                                                    <label for="galleryImage">Gallery Image</label>
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
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Create Spare Part</button>
						</div>
					</div>
				</div><!--end .card -->

			<? echo form_close();?>
        </div>
    </section>
    
</div>