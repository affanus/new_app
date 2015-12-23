<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<script>

$(document).ready(function() {
  $('#summernote').summernote({height: 300});
  $(".select2-list").select2({allowClear: true});
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
                        	<div class="col-lg-6">
                        		<div class="form-group">
                            		<select class="form-control select2-list"  required id="man_id" name="man_id">
                                    	<option value=""></option>
                                    	<?   if($query_aircraft_man->num_rows() != 0) : 
											foreach($query_aircraft_man->result() as $row):?>
                                    	<option value="<?=$row->id?>"><?= stripslashes($row->title);?></option>
                                        	<? endforeach; ?>
                                        <? endif; ?>
														
									</select>
									<label for="man_id">Aircraft Manufacturer </label>
                                </div>
                            </div>    
							<div class="col-lg-6">
								<div class="form-group">
									<input type="text" class="form-control" name="title" id="title" required>
									<label for="title">Aircraft Type</label>
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
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Create Aircraft Type</button>
						</div>
					</div>
				</div><!--end .card -->

			<? echo form_close();?>
        </div>
    </section>
    
</div>