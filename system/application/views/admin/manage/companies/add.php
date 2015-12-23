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
  	$('#format').submit(function( event ) {
	  	var sHTML = $('#summernote').code();
	  	$("textarea#editor1").val(sHTML);
  	});
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
									<label for="title">Company Title</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="file" class="form-control dirty" name="logo" id="logo" required>
									<label for="logo">Company Logo</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="website" id="website" required>
									<label for="website">Company Website</label>
								</div>
							</div>
						</div>
                        
                        <div class="row">
							<div class="col-lg-12">
                            	<div class="form-group">
                                	<input type="text" class="form-control" name="address" id="address" required>
									<label for="address">Company Address</label>
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
									<label for="country">Company Country</label>
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
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="pobox" id="pobox" >
									<label for="pobox">Company P.O.Box</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="zipcode" id="zipcode" >
									<label for="zipcode">Company Zipcode / Postal Code</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="tel" id="tel" required>
									<label for="tel">Company Contact Number</label>
								</div>
							</div>
						</div>
                        
                        <div class="row">
                        	<div class="col-lg-12">
                            	<div class="form-group">
                            		<select class="form-control select2-list"  multiple required id="company_specialties" name="company_specialties[]">
                                    	<?   if($query_air_cat->num_rows() != 0) : 
											foreach($query_air_cat->result() as $row):?>
                                    			<option value="<?=$row->id?>"><?= stripslashes($row->title);?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
														
									</select>
									<label for="air_cat">Company Specialties / Category </label>
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
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Create Company</button>
						</div>
					</div>
				</div><!--end .card -->

			<? echo form_close();?>
        </div>
    </section>
    
</div>