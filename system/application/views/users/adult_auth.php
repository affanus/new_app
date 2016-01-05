<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<script>
$(document).ready(function() {
	$(".request_receiver_id").select2({allowClear: true});
});
</script>
<div id="content">
	<section>
		
    </section>
    <section class="section-account">  

   <div class="col-lg-offset-1 col-md-9">
								<div class="card">
									<div class="card-body">
									<h3>Approval Request</h3>
									<p>We need to Verify you creditenials that you are human not Robot. You can use any of the following option to verify yourself</p>
									
										 <form class="form form-validate" role="form" action="<?=base_url()?>users/adult_ask_parents" method="post" id="userRegistration" enctype="multipart/form-data">
											<!--end .form-group -->
                                            <?php $result = $this->db->select('request_sender_id')->from('request')->where('request_sender_id',$this->session->userdata('user_id'))->get()->result_array(); ?>
                                           <?php 
											if(!empty($result)){ ?>
                                            <div style="color:red;">

                                            	Your Approval Request is Still Pending !
                                            </div>
                                            <?php } else { ?>
											<div class="form-group">
												<div class="col-sm-9">
													<label class="radio-inline radio-styled">
														<input type="radio" name="inlineRadioOptions" value="option1" onclick="member_list()">
                                                        <span>Choose from members List</span>
													</label>
													<label class="radio-inline radio-styled">
														<input type="radio" name="inlineRadioOptions" value="option2">
                                                        <span>Dollar Transaction </span>
													</label>
													<label class="radio-inline radio-styled">
														<input type="radio" name="inlineRadioOptions" value="option3" onclick="admin_verify()">
                                                        <span>Ask Admin to Verify</span>
													</label>
												</div><!--end .col -->
											</div><!--end .form-group -->
                                            <div class="row">
                                            	<div id="search" style="display:none;">
                                                    <div class="col-sm-5">
                                                        <div class="form-group">
                                                        <select id="title" name="request_receiver_id" class="form-control request_receiver_id" required>
                                                            <option value="">--Select One--</option>
                                                            <?php $users = $this->db->select('*')->from('users')->where('isactive','1')->where('user_verify','1')->where('id !=',$this->session->userdata('user_id'))->get()->result_array();
                                                            foreach($users as $userss):
                                                            $birthDate = $userss['bday'];
                                                            $birthDate = explode("/", $birthDate);
                                                             $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                                                                        ? ((date("Y") - $birthDate[2]) - 1)
                                                                        : (date("Y") - $birthDate[2]));
                                                            if($age>14){
                                                            ?>
                                                            <option value="<?=$userss['id']?>"><?=$userss['fname']?><?=" ".$userss['lname']?></option>
                                                            <?php }  endforeach;?>
                                                            
                                                        </select>
                                                        <label for="title" class="control-label">Choose from members List</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                            <div class="form-group">
                                                            <select id="title" name="member_type" class="form-control" required>
                                                                <option value="">--Select One--</option>
                                                                <option value="F">Family</option>
                                                                <option value="O">Other</option>
                                                            </select>
                                                            <label for="title" class="control-label">Select Type</label>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            <? } ?>
											<br/><br/>
                                            <!--<?php if(!empty($result)){ ?>
                                          	 <div class="row" style="margin-left:10px;">
                                                <div class="col-sm-12">
                                                    <a href="<?=base_url()?>users/profile" class="btn ink-reaction btn-primary style-accent" >Skip</a>
                                                </div>    
                                            </div>
                                            <?php } ?>-->
                                             <div class="row">
                                             	<?php if(empty($result)){ ?>
                                                <div class="col-sm-1 sumbit_verify" style="display:none;">
                                                    <button type="submit" class="btn ink-reaction btn-primary style-accent">Verify</button>
                                                </div>  
                                                 <?php } ?>
                                                <div class="col-sm-6">
                                                    <a href="<?=base_url()?>users/profile" class="btn ink-reaction btn-primary style-accent" >Skip</a>
                                                </div>

                                                </div>  
                                                     <?php 
											if(!empty($result)){ ?>
													<br/>
<div class="col-sm-12">
                                                    You can skip this step and go to your profile but you wont be able to perform any task untill you verified yourself untill you choose any of the option below.
                                                <?php } ?>
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