<div id="content">
	<section>
		<h1 class="page-header text-default-light">Dashboard</h1>
    </section>
    <section class="section-account">  

   <div class="col-lg-offset-1 col-md-9">
								<div class="card">
									<div class="card-body">
										 <form class="form floating-label form-validate" role="form" action="<?=base_url()?>users/adult_ask_parents" method="post" id="userRegistration" enctype="multipart/form-data">
											<!--end .form-group -->
											<div class="form-group">
												<div class="col-sm-9">
													<label class="radio-inline radio-styled">
														<input type="radio" name="inlineRadioOptions" value="option1" onclick="member_list()">
                                                        <span>Choose from members List</span>
													</label>
													<label class="radio-inline radio-styled">
														<input type="radio" name="inlineRadioOptions" value="option2">
                                                        <span>Dollar Transection</span>
													</label>
													<label class="radio-inline radio-styled">
														<input type="radio" name="inlineRadioOptions" value="option3" onclick="admin_verify()">
                                                        <span>Ask Admin to Verify</span>
													</label>
												</div><!--end .col -->
											</div><!--end .form-group -->
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group" id="search" style="display:none;">
                                                    <select id="title" name="request_receiver_id" class="form-control" required>
                                                    	<option value="">--Select One--</option>
                                                        <?php $users = $this->db->select('*')->from('users')->where('isactive','1')->get()->result_array();
														foreach($users as $userss):
														?>
                                                        <option value="<?=$userss['id']?>"><?=$userss['fname']?><?=" ".$userss['lname']?></option>
                                                        <?php endforeach;?>
                                                        
                                                    </select>
                                                    <label for="title" class="control-label">Choose from members List</label>
                                                    </div>
                                            	</div>
                                            </div>
                                             <div class="row">
                                                <div class="col-sm-12 sumbit_verify" style="display:none;">
                                                    <button type="submit" class="btn ink-reaction btn-primary style-accent">Verify</button>
                                                </div>    
                                            </div>
										</form>
									</div><!--end .card-body -->
								</div><!--end .card -->
							</div>
</section>

</div>
<script>
function member_list()
{
	$("#search").show();
	$(".sumbit_verify").show();
}
function admin_verify()
{
	$("#search").hide();
	$(".sumbit_verify").show();
}
</script>