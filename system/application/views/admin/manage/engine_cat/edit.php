<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-default/libs/summernote/summernote.css?1425218701" />

<script>

$(document).ready(function() {
  $('#summernote').summernote({height: 300});
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
echo form_open_multipart('admin/'.$controler_name.'/edit_action/'.$this->uri->segment(4), $attributes);
$row = $query->row();
?>
				<div class="card">
					<div class="card-head style-accent">
						<header><?= $title ?></header>
					</div>
					<div class="card-body floating-label ">

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<input type="text" class="form-control" name="title" id="title" required value="<?=stripslashes($row->title)?>">
									<label for="title">Engine Category Name</label>
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