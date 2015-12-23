<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<script>

$(document).ready(function() {
  	$('#summernote').summernote({height: 300});
  	$(".select2-list").select2({allowClear: true});
	$("#country").select2({allowClear: true});
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
		$('.media').append('<div class="col-lg-12"><div class="form-group"><input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage"><label for="galleryImage">Event Gallery Image</label></div></div>');
	});
  	$('#format').submit(function( event ) {
	  	var sHTML = $('#summernote').code();
	  	$("textarea#editor1").val(sHTML);
  	});
	$('#e_date').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
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
									<label for="title">Event Title</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="e_date" id="e_date" required>
									<label for="e_date">Event Date</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="sponsor" id="sponsor" required>
									<label for="sponsor">Event Sponsor</label>
								</div>
							</div>
						</div>
                        
                        <div class="row">
							<div class="col-lg-12">
                            	<div class="form-group">
                                	<input type="text" class="form-control" name="address" id="address" required>
									<label for="address">Event Address</label>
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
									<label for="country">Event Country</label>
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
                            		<select class="form-control select2-list"  multiple required id="event_cat" name="event_cat[]">
                                    	<?   if($query_air_cat->num_rows() != 0) : 
											foreach($query_air_cat->result() as $row):?>
                                    			<option value="<?=$row->id?>"><?= stripslashes($row->title);?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
														
									</select>
									<label for="air_cat">Event category </label>
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
                                        <header>Media Section (Event Images)</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                        	<div class="col-lg-12">
                                            	<div class="form-group">
                                                    <input type="file" class="form-control dirty" name="featuredImage" id="featuredImage" required>
                                                    <label for="featuredImage">Event Main Image</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row media">
                                        	<div class="col-lg-12">
                                            	<div class="form-group">
                                                    <input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage" >
                                                    <label for="galleryImage">Event Gallery Image</label>
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
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Create Event</button>
						</div>
					</div>
				</div><!--end .card -->

			<? echo form_close();?>
        </div>
    </section>
    
</div>