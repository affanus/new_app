<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/bootstrap-datepicker/datepicker3.css?1424887858" />
<script>

$(document).ready(function() {
  	$('#summernote').summernote({height: 300});
  	$(".select2-list").select2({allowClear: true});
	$('#addmorefields').live('click',function(event){
		event.preventDefault();	
		$('.media').append('<div class="col-lg-12"><div class="form-group"><input type="file" class="form-control dirty" name="galleryImage[]" id="galleryImage"><label for="galleryImage">News Gallery Image</label></div></div>');
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
	$('#n_date').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
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
									<label for="title">News Title</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="n_date" id="n_date" required value="<?=$row->n_date?>">
									<label for="e_date">News Date</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="source" id="source"  value="<?=stripslashes($row->source)?>">
									<label for="sponsor">News Source</label>
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
									<label for="air_cat">News category </label>
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
                                        <header>Media Section (News Images)</header>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                        	<div class="col-lg-12">
                                        		<div class="no-border holder">
                                                	<h4 class="text-accent">News Main Image</h4>     
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