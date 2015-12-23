<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<script>

$(document).ready(function() {
  	$('#summernote').summernote({height: 300});
  	$(".select2-list").select2({allowClear: true});
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
function searchForId($id, $array) {
	$asn = 0;
	foreach ($array as $val) {
		if ($val->cat_id == $id) {
			$asn ++;
		}
	}
	return $asn;
}

$man_cat=array();
if($query_air_man_cat_link->num_rows() != 0) : 
	$man_cat=$query_air_man_cat_link->result();
endif;	


		
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
									<label for="title">Company Title</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="col-lg-3">
                                <img class="img-responsive img-thumbnail" src="<?=base_url()?>/_images/profile_images/thumb/<?=$row->logo?>" alt="">
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <input type="file" class="form-control dirty" name="logo" id="logo">
                                        <label for="logo">Company Logo</label>
                                    </div>
                                </div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="website" id="website" required value="<?=stripslashes($row->website)?>">
									<label for="website">Company Website</label
								</div>
							</div>
						</div>
                        
                        <div class="row">
							<div class="col-lg-12">
                            	<div class="form-group">
                                	<input type="text" class="form-control" name="address" id="address" required value="<?=stripslashes($row->address)?>">
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
											foreach($query_countries->result() as $row_countries):?>
                                    			<option value="<?=$row_countries->id?>" <? if($row_countries->id==$row->country):?>selected="selected"<? endif;?>><?= stripslashes($row_countries->title);?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
                                    </select>
									<label for="country">Company Country</label>
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
									<label for="state">Company State</label>
                                </div>
                            </div> 
                            <div class="col-lg-4">
                            	<div class="form-group city_wrap">
									<select class="form-control" id="city" name="city">
                                    	<option value=""></option>
                                    	<?   if($query_cities->num_rows() != 0) : 
											foreach($query_cities->result() as $row_cities):?>
                                    			<option value="<?=$row_cities->id?>" <? if($row_cities->id==$row->city):?>selected="selected"<? endif;?>><?= stripslashes($row_cities->title);?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
                                    </select>
									<label for="city">Company City</label>
                                </div>
                            </div> 
                        </div>

						
                        <div class="row">
                        	<div class="col-lg-12">
                            	<div class="form-group">

                            		<select class="form-control select2-list"  multiple required id="air_cat" name="air_cat[]">
                                    	<?   if($query_air_cat->num_rows() != 0) : 
											foreach($query_air_cat->result() as $air_cat):?>
                                    	<option value="<?=$air_cat->id?>" <? echo searchForId($air_cat->id, $man_cat);  if(searchForId($air_cat->id, $man_cat)==1):?> selected="selected"<? endif;?>><?= stripslashes($air_cat->title);?></option>
 
                                        	<? endforeach; ?>
                                        <? endif; ?>
														
									</select>
									<label for="air_cat">Company category </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="pobox" id="pobox" value="<?=stripslashes($row->pobox)?>">
									<label for="pobox">Company P.O.Box</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="zipcode" id="zipcode" value="<?=stripslashes($row->zipcode)?>">
									<label for="zipcode">Company Zipcode / Postal Code</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="tel" id="tel" value="<?=stripslashes($row->tel)?>">
									<label for="tel">Company Contact Number</label>
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