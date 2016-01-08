<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/libs/select2/select2.css?1424887856" />
<script>
$(document).ready(function() {
	$(".request_receiver_id").select2({allowClear: true});
});
</script>

<div id="content">
	
    <section class="section-account">  

   <div class="col-lg-offset-1 col-md-6">
								<div class="card">
									<div class="card-body">
                                    <h3>Identify Your Parents</h3>
									<p>Aur system has identified you as a child by your age. We need you to identify your parents by using followin options.</p>
                                        <form class="form form-validate" role="form" action="<?=base_url()?>users/child_ask_parents" method="post" id="userRegistration" enctype="multipart/form-data">
                                            <?php $result = $this->db->select('request_sender_id')->from('request')->where('request_sender_id',$this->session->userdata('user_id'))->get()->result_array(); ?>
                                            <?php 
											if(!empty($result)){ ?>
                                            <div style="color:red;">
                                            	Your Approval Request is Still Pending !
                                            </div>
                                            <?php } else {?>
                                            <div class="row">
                                                <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label class="radio-inline radio-styled">
                                                        <input type="radio" name="inlineRadioOptions" value="option1" onclick="member_list()">
                                                        <span>Choose from members List</span>
                                                    </label>
                                                    <label class="radio-inline radio-styled">
                                                        <input type="radio" name="inlineRadioOptions" value="option3" onclick="ask_parents()">
                                                        <span>Can't find them in our system sed request via email.</span>
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
                                                            <?php } endforeach;?>
                                                            
                                                        </select>
                                                        <label for="title" class="control-label">Choose from members List</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4" style="display:none;">
                                                        <div class="form-group">
                                                        <select id="title" name="member_type" class="form-control" required>
                                                            
                                                            <option value="F">Family</option>
                                                            <option value="O">Other</option>
                                                        </select>
                                                        <label for="title" class="control-label">Select Type</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <? } ?>
                                            <!--<?php if(!empty($result)){ ?>
                                          	 <div class="row">
                                                <div class="col-sm-12">
                                                    <a href="<?=base_url()?>users/profile" class="btn ink-reaction btn-primary style-accent" >Skip</a>
                                                </div>    
                                            </div>
                                            <?php } ?>-->
                                           
                                             <div class="row">
                                             	 <?php if(empty($result)){ ?>
                                                <div class="col-sm-6 sumbit_verify" style="display:none;">
                                                    <button type="submit" class="btn ink-reaction btn-primary style-accent">Verify</button>
                                                </div> 
                                                <?php } ?>
                                                <div class="col-sm-6">
                                                    <a href="<?=base_url()?>users/profile" class="btn ink-reaction btn-primary style-accent" >Skip</a>
                                                    <br /><br />
                                                 </div>
                                                    <?php 
											if(!empty($result)){ ?>
                                            		<div class="col-md-12">
                                                    You can skip this step and go to your profile but you wont be able to perform any task untill you verified yourself untill you choose any of the option below.
                                                	</div>
												<?php } ?>
                                                
                                                   
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