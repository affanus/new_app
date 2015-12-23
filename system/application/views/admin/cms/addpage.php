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
echo form_open('admin/cms/addpage_/'.$this->uri->segment(4), $attributes);?>
				<div class="card">
					<div class="card-head style-accent">
						<header>Create New Page</header>
					</div>
					<div class="card-body floating-label ">

						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="title" id="title" required>
									<label for="title">Title</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<select name="position" id="position" class="form-control" required>
                                        <option value="">&nbsp;</option>
                                        <option value="header">Header</option>
                                        <option value="leftmenu">Left menu</option>
                                        <option value="footer">Footer</option>
                                        <option value="handf">Header and Footer</option>
                                    </select>
									<label for="position">Position</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<select name="parent" id="parent" class="form-control dirty" required>
                                        <option value="0">None</option>
											 <?
                                 foreach($query1->result() as $row1): ?>
                                            <option value="<?= $row1->id;?>"><?= $row1->title;?></option>
                                            <?
                                            endforeach;
                                            ?>
                                    </select>
									<label for="parent">Parent Page</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="seqno" id="seqno" required>
									<label for="seqno">Seq. No</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="meta_title" id="meta_title" required>
									<label for="meta_title">Meta Title</label>
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="meta_keywords" id="meta_keywords">
									<label for="meta_keywords">Meta Keywords</label>
								</div>
							</div>
						</div>
                        <div class="row">
                        	<div class="col-lg-12">
                            	<div class="form-group">
                                	<input type="text" class="form-control" name="meta_decrip" id="meta_decrip">
									<label for="meta_decrip">Meta Decription</label>
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
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Create Page</button>
						</div>
					</div>
				</div><!--end .card -->

			<? echo form_close();?>
        </div>
    </section>
    
</div>