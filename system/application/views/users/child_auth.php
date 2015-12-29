<div id="content">
	<section>
		<h1 class="page-header text-default-light">Dashboard</h1>
    </section>
    <section class="section-account">  

   <div class="col-lg-offset-1 col-md-6">
								<div class="card">
									<div class="card-body">
                                        <form class="form floating-label form-validate" role="form" action="<?=base_url()?>users/child_ask_parents" method="post" id="userRegistration" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label class="radio-inline radio-styled">
                                                        <input type="radio" name="inlineRadioOptions" value="option1" onclick="member_list()">
                                                        <span>Choose from members List</span>
                                                    </label>
                                                    <label class="radio-inline radio-styled">
                                                        <input type="radio" name="inlineRadioOptions" value="option3" onclick="ask_parents()">
                                                        <span>Ask Parents to Verify</span>
                                                    </label>
                                                </div><!--end .col -->
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group" id="ask_parents" style="display:none;">
                                                        <input type="email" name="request_receiver_email" id="email" class="form-control" data-rule-email="true" required>
                                                        <label for="email" class="control-label">Email</label>
                                                    </div>
                                                </div>
                                            </div>
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
function ask_parents()
{
	$("#search").hide();
	$("#ask_parents").show();
	$(".sumbit_verify").show();
}
function member_list()
{
	$("#ask_parents").hide();
	$("#search").show();
	$(".sumbit_verify").show();
}
</script>