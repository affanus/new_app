<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<script>

$(document).ready(function() {
  	$('#summernote').summernote({height: 300});
  	$("#contact_info").select2({allowClear: true});;
	$("#country").select2({allowClear: true});
	$("#state").select2({allowClear: true});
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
	$('.delete_gal_image').live('click',function(){
		var gal_id=$(this).data("id");
		var parent = $(this).closest('.galleryImageContainer');
		var request =  $.ajax({
			url:'<?php echo base_url();?>admin/<?=$controler_name?>/del_gal',
			type:'post',
			data:{editid:gal_id}
		});
		request.done(function( msg ) {
		  parent.remove();
		});
		
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
echo form_open_multipart('admin/'.$controler_name.'/edit_action/'.$this->uri->segment(4), $attributes);
$row = $query->row();
?>
				<div class="card">
					<div class="card-head style-accent">
						<header><?= $title ?></header>
					</div>
					<div class="card-body floating-label ">
                    
                    	<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="title" id="title" required value="<?=stripslashes($row->title)?>">
									<label for="title">Spare Part Title</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="p_number" id="p_number" required value="<?=stripslashes($row->p_number)?>">
									<label for="p_number">Part Number</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="nsn" id="nsn" required value="<?=stripslashes($row->nsn)?>">
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
											foreach($query_condition_set->result() as $row_condition_set):?>
                                    			<option value="<?=$row_condition_set->id?>" <? if($row_condition_set->id==$row->condition):?> selected="selected"<? endif;?>><?= stripslashes($row_condition_set->title);?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
														
									</select>
									<label for="condition">Condition </label>
                                </div>
                            </div>  
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="quantity" id="quantity" value="<?=stripslashes($row->quantity)?>">
									<label for="quantity">Quantity</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<select class="form-control" id="release" name="release">
                                   		<option value=""></option>
                                    	<option value="1" <? if($row->release==1):?> selected="selected"<? endif;?>>EASA Form 1</option>
										<option value="2" <? if($row->release==2):?> selected="selected"<? endif;?>>FAA 8130-3 Form</option>
                                        <option value="3" <? if($row->release==3):?> selected="selected"<? endif;?>>C of C</option>
                                        <option value="4" <? if($row->release==4):?> selected="selected"<? endif;?>>Manufacturer Cert</option>
                                        <option value="5" <? if($row->release==5):?> selected="selected"<? endif;?>>Airlines c of c</option>
									</select>
									<label for="release">Release</label>
								</div>
							</div>
                        </div>
                        
                        <div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="trace" id="trace" value="<?=stripslashes($row->trace)?>">
									<label for="trace">Trace</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="tag_date" id="tag_date" value="<?=stripslashes($row->tag_date)?>">
									<label for="tag_date">Tag Date</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="app_to" id="app_to" value="<?=stripslashes($row->app_to)?>">
<label for="app_to">Applicable to</label>
								</div>
							</div>
						</div>
                        
                        <div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="uprice" id="uprice" value="<?=stripslashes($row->uprice)?>">
									<label for="uprice">Unit Price</label>
								</div>
							</div>
                            <div class="col-lg-8">
								<div class="form-group">
									<select class="form-control" required id="contact_info" name="contact_info">
                                   		<option value=""></option>
                                    	<?   if($query_contacts->num_rows() != 0) : 
											foreach($query_contacts->result() as $row_contacts):?>
                                    			<option value="<?=$row_contacts->id?>" <? if($row_contacts->id==$row->contact_info):?> selected="selected"<? endif;?>><?= stripslashes($row_contacts->fname)." ".stripslashes($row_contacts->lname)." ".stripslashes($row_contacts->email)."";?></option>
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
											foreach($query_countries->result() as $row_countries):?>
                                    			<option value="<?=$row_countries->id?>" <? if($row_countries->id==$row->country):?>selected="selected"<? endif;?>><?= stripslashes($row_countries->title);?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
                                    </select>
									<label for="country">Event Country</label>
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
									<label for="state">Event State</label>
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
									<label for="city">Event City</label>
                                </div>
                            </div> 
                        </div>

						
                        
                        
                        <div class="row">
                        	<div class="col-lg-12">
                            	<div class="form-group">
                                    <div id="summernote">
                                    	<?=stripslashes($row->details)?>
                                    </div>
                                </div>
                            </div>
                            <textarea id="editor1" name="editor1" style="display:none"><?=stripslashes($row->details)?></textarea>
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
                                        		<div class="no-border holder">
                                                	<h4 class="text-accent">Event Main Image</h4>     
                                                </div>
                                            </div>
                                        	<? 
											if($query_media_featuredImage->num_rows() != 0) :
											$row_media_featuredImage = $query_media_featuredImage->row();?>
                                        	<div class="col-lg-4">
                                            	<img src="<?=base_url()?>_images/profile_images/thumb/<?=$row_media_featuredImage->path?>" class="img-responsive img-thumbnail" alt="featuredImage">
                                            </div>
                                            <? endif;?>
                                        	<div class="col-lg-8">
                                            	<div class="form-group">
                                                    <input type="file" class="form-control dirty" name="featuredImage" id="featuredImage">
                                                </div>
                                            </div>
                                        </div>
                                        <? if($query_media_gallery->num_rows() != 0) :?>
                                        <div class="row">
                                        	<div class="col-lg-12">
                                        		<div class="no-border holder">
                                                	<h4 class="text-accent">Gallery Images</h4>     
                                                </div>
                                            </div>
                                            <? $image_count=1; ?>
                                            

                                            <? foreach($query_media_gallery->result() as $row_media_galler):?>
                                            	<div class="col-lg-2 galleryImageContainer">
                                                	<a class="btn ink-reaction btn-floating-action btn-primary btn-xs stick-top-right delete_gal_image" data-id="<?=$row_media_galler->id?>"><span class="md md-delete"></span></a>
                                                	<img src="<?=base_url()?>_images/media_images/thumb/<?=$row_media_galler->path?>" class="img-responsive img-thumbnail" alt="media_images">
                                                </div>
                                            <? $image_count++; ?>
                                            <? endforeach;?>

                                            
                                        </div>
                                        <? endif;?>
                                        <div class="row media">
                                        	
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
                                    	<input type="radio" name="isactive" value="1"  <? if($row->isactive == '1') { ?>checked<? } ?>><span>Publish</span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                    	<input type="radio" name="isactive" value="0" <? if($row->isactive == '0') { ?>checked<? } ?>><span>Inactive</span>
                                	</label>
                            	</div>
                        	</div>
                        </div>

					</div><!--end .card-body -->
					<div class="card-actionbar">
						<div class="card-actionbar-row">
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Submit</button>
						</div>
					</div>
				</div><!--end .card -->

			<? echo form_close();?>
        </div>
    </section>
    
</div>