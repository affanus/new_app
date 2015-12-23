<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />

<script>

$(document).ready(function() {
  $('#summernote').summernote({height: 300});
  $(".select2-list").select2({
			allowClear: true
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
									<label for="title">Manufacturer Company Name</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="estb_in" id="estb_in" value="<?=stripslashes($row->estb_in)?>" required data-rule-number="true">
									<label for="title">Established in</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
                                	<label for="profilepic">Logo</label>
                                    <div class="col-lg-3">
                                    	<img class="img-circle width-1" src="<?=base_url()?>_images/profile_images/thumb/<?=stripslashes($row->logo)?>" alt="">
                                    </div>
                                    <div class="col-lg-9">
										<input name="profilepic" type="file" id="profilepic" />
                                    </div>
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
									<label for="air_cat">Engine category </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                        	<div class="col-lg-12">
                            	<div class="form-group">
                                    <div id="summernote">
                                    	<?=stripslashes($row->company_profile)?>
                                    </div>
                                </div>
                            </div>
                            <textarea id="editor1" name="editor1" style="display:none"><?=stripslashes($row->company_profile)?></textarea>
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