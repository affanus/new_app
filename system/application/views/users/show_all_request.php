<?php
$CI =& get_instance();
$CI->load->model('security');
$CI->security->validate_user_session();
$user_query = $this->db->query("SELECT
						users.email,
						fname,
						lname,
						profile_pic
						FROM
						users
						WHERE
						id  = '".$this->session->userdata('user_id')."'");
$row_user_query = $user_query->row();	
?>
<div id="content">

				<!-- BEGIN PROFILE HEADER -->


				<section>
					<div class="section-body no-margin">
						<div class="row">
							<div class="col-md-8">
                            <?php $where = "isactive = '0' AND type = '' AND (request_receiver_id = '".$this->session->userdata('user_id')."' OR request_receiver_id ='".$this->session->userdata('email')."')";
										$users = $this->db->select('*')->from('request')->where($where)->get()->result_array(); ?>
                                <?php if(!empty($users)){ ?>
								<h2 style="margin-left: 40px;">Approval Request</h2>
                                <?php } ?>
								<div class="tab-pane" id="activity">
									<ul class="timeline collapse-lg timeline-hairline">
                                   <?php foreach($users as $userss): ?>
                                         
										<li class="timeline-inverted">
												<div class="timeline-entry">
													<div class="card style-default-light">
													<div class="card-body small-padding">
                                                     <? if($this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->profile_pic !=''):?>
                                <img style="width:50px; height:50px;"  src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->profile_pic)?>" alt="" />
                                <? else:?>
                                    <img style="width:50px; height:50px;" src="<?=base_url()?>assets/img/no-user-image-square.jpg" />
                                <? endif;?>
													<span class="text-medium">
													<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->fname;?>
													&nbsp;<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->lname;?>
                                                    <small>
      
                                                    
														<a href="<?php echo base_url();?>users/update_status_all/<?= $userss['request_id'];?>/1/<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Approve" onclick="return confirm('Are You Sure To Approve?')"><i class="md md-done" style="margin-right: 0px;"></i></a>
                                        				
                                        				<a href="<?php echo base_url();?>users/update_status_all/<?= $userss['request_id'];?>/0/<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Reject" onclick="return confirm('Are You Sure To Reject?')"><i class="md md-clear" style="margin-right: 0px;"></i></a>
                                        				
                                        			</small>
                                        		</span>
					
												</div>
                                        		</div>
					
												</div>
											</li>
                                     <?php endforeach; ?>
                                    <?php $where1 = "isactive = '0' AND type = 'f' AND parent_id ='".$this->session->userdata('user_id')."'";
										$friend = $this->db->select('*')->from('request')->where($where1)->get()->result_array(); ?>
                                     <?php if(!empty($friend)){ ?>
                                    <h2 style="margin-left: 40px;">Friend Request</h2>
                                    <?php } ?>
                                        <?php foreach($friend as $friends): ?>
                                        <li class="timeline-inverted">
                                            <div class="timeline-entry">
                                                <div class="card style-default-light">
                                                    <div class="card-body small-padding">
                                                    <? if($this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->profile_pic !=''):?>
                                <img style="width:50px; height:50px;"  src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->profile_pic)?>" alt="" />
                                <? else:?>
                                    <img style="width:50px; height:50px;" src="<?=base_url()?>assets/img/no-user-image-square.jpg" />
                                <? endif;?>
                                                        <span class="text-medium">
                                                            <?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->fname;?>&nbsp;<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->lname;?>
                                                            <small>             
                                                               
                                                                <a href="<?php echo base_url();?>users/accept_request_all/<?= $friends['request_id'];?>/1/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Accept" onclick="return confirm('Are You Sure To Accept?')"><i style="margin-left: 6px;" class="md md-done"></i></a>
                                                                
                                                                <a href="<?php echo base_url();?>users/accept_request_all/<?= $friends['request_id'];?>/0/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Reject" onclick="return confirm('Are You Sure To Reject?')"><i style="margin-left: 10px;" class="md md-clear"></i></a>
                                                
                                                            </small>
                                                       </span>
                                                    </div>
                                            	</div>
                                              </div>
                                        	</li>
                                        <?php endforeach;?>
                                        <!--Show Events-->
                                        
                                         <?php 
										 $where1 = "isactive = '0' AND r_id = '".$this->session->userdata('user_id')."'";
										 $events = $this->db->select('*')->from('events_request')->where($where1)->get()->result_array(); 
										 $event_count =  $this->db->select('count(*) as cont')->from('events_request')->where($where1)->get()->row()->cont; 
										 ?>
                                     <?php if(!empty($events)){ ?>
                                    <h2 style="margin-left: 40px;">Event Request</h2>
                                    <?php } ?>
                                        <?php foreach($events as $eventss): ?>
                                        <li class="timeline-inverted">
                                            <div class="timeline-entry">
                                                <div class="card style-default-light">
                                                    <div class="card-body small-padding">
                                                        <span class="text-medium">
                                                            <?=$this->db->get_where('events', array('id' => $eventss['event_id']))->row()->title;?>
                                                            <small>             
                                                                
                                                                <a href="<?php echo base_url();?>users/event_request_all/<?= $eventss['request_id'];?>/1/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Accept" onclick="return confirm('Are You Sure To Accept?')"><i class="md md-done"></i></a>
                                                                
                                                                <a href="<?php echo base_url();?>users/event_request_all/<?= $eventss['request_id'];?>/0/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Reject" onclick="return confirm('Are You Sure To Reject?')"><i class="md md-cloud-off"></i></a>
                                                                
                                                            </small>
                                                       </span>
                                                    </div>
                                            	</div>
                                              </div>
                                        	</li>
                                        <?php endforeach;?>
                                        
                                        </ul>
								</div><!--end #activity -->
							</div><!--end .col -->
							<!-- END MESSAGE ACTIVITY -->

							<!-- BEGIN PROFILE MENUBAR -->
							<!--end .col -->
							<!-- END PROFILE MENUBAR -->

						</div><!--end .row -->
					</div><!--end .section-body -->
				</section>
			</div>