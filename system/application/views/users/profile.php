<?php
if($u_id>0)
{
	$user_id = $u_id;
	if($user_id == $this->session->userdata('user_id'))
	{
		$user_check = "U";
	}
	else
	{
		$user_check = "F";
	}
}
else
{
	$user_id = $this->session->userdata('user_id');
	$user_check = "U";
}
$varified_user = $this->db->select('*')->from('users')->where('id',$this->session->userdata('user_id'))->where('isactive','1')->where('user_verify','1')->get()->result_array();
$CI =& get_instance();
$CI->load->model('security');
$CI->security->validate_user_session();
$user_query = $this->db->query("SELECT *
						FROM
						users
						WHERE
						id  = '".$user_id."'");
$row_user_query = $user_query->row();

?>
<div id="content">

				<!-- BEGIN PROFILE HEADER -->
				<section class="full-bleed">
					<div class="section-body style-default-dark force-padding text-shadow">
						<div class="img-backdrop" style="background-image: url('<?=base_url()?>assets/img/img16.jpg')"></div>
						<div class="overlay overlay-shade-top stick-top-left height-3"></div>
						<div class="row">
							<div class="col-md-2 col-xs-5">
                                                            <? if($row_user_query->profile_pic!=''):?>
                                <img  class="img-circle border-white border-xl img-responsive auto-width" src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($row_user_query->profile_pic)?>" alt="" />
                                <? else:?>
                                    <img class="img-circle border-white border-xl img-responsive auto-width" src="<?=base_url()?>assets/img/no-user-image-square.jpg" />
                                <? endif;?>

								<h3 style="text-transform:uppercase;">                                    <?=stripslashes($row_user_query->fname)?> <?=stripslashes($row_user_query->lname)?>
<br><small><?=stripslashes($row_user_query->bio)?></small></h3>
							</div><!--end .col -->
							<div class="col-md-9 col-xs-7">
								<div class="width-3 text-center pull-right">
                                	<?php $where2 = "count = '0' AND (u_id = '".$user_id."' OR f_id = '".$user_id."') AND family_member !='F'";
										$total_friends = $this->db->select('count(*) as frend')->from('following_list')->where($where2)->get()->result_array(); 
										
										$where3 = "count = '0' AND (u_id = '".$user_id."' OR f_id = '".$user_id."') AND family_member ='F'";
										$total_famaily = $this->db->select('count(*) as family')->from('following_list')->where($where3)->get()->result_array();
										
										?>
									<strong class="text-xl"><?=@$total_friends[0]['frend']?></strong><br>
									<span class="text-light opacity-75">Friends</span>
								</div>
								<div class="width-3 text-center pull-right">
									<strong class="text-xl"><?=$total_famaily[0]['family']?></strong><br>
									<span class="text-light opacity-75">Family</span>
								</div>
							</div><!--end .col -->
						</div><!--end .row -->
						<!--div class="overlay overlay-shade-bottom stick-bottom-left force-padding text-right">
							<a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Contact me"><i class="fa fa-envelope"></i></a>
							<a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Follow me"><i class="fa fa-twitter"></i></a>
							<a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Personal info"><i class="fa fa-facebook"></i></a>
						</div-->
					</div><!--end .section-body -->
				</section>
				<!-- END PROFILE HEADER  -->

				<section>
					<div class="section-body no-margin">
						<div class="row">
                        <?php if(!empty($varified_user)){ ?>
							<div class="col-md-8">
								<h2>Events</h2>
								<?php if($user_check =='U'){ ?>
								<!-- BEGIN ENTER MESSAGE -->
								<!-- BEGIN ENTER MESSAGE -->

								<!-- BEGIN MESSAGE ACTIVITY -->
								<div class="tab-pane" id="activity" style="background: #fff;padding: 100px 10px 0 20px;">
								<div class="pull-right" style="margin-top: -76px;">
								<form class="form" action="">
									<div class="no-margin">
										<div>
											<div class="form-groups">
												<a  href="<?=base_url()?>users/create_event/" class="btn ink-reaction btn-raised btn-primary">Create Event</a>
												<a  href="<?=base_url()?>users/create_event/" class="btn ink-reaction btn-raised btn-primary">View Event Calender</a>
											</div>
										</div><!--end .card-body -->
										<!--end .card-actionbar -->
									</div><!--end .card -->
								</form>
</div>
								<?php } ?>
									<ul class="timeline collapse-lg timeline-hairline">
                                                 <?php 
										$where = "u_id = '".$user_id."' AND isactive = '1'";
										$users1 = $this->db->select('*')->from('events')->where($where)->get()->result_array(); 
										foreach($users1 as $userss1):
										?>
										<li class="timeline-inverted">
											<div class="timeline-circ circ-xl style-primary"><i class="md md-event"></i></div>

											<div class="timeline-entry" style="width:95%;">
												<div class="card style-default-light">
													<div class="card-body small-padding">
														<span class="text-medium"><a class="text-primary" href="<?=base_url()?>users/event_detail/<?= stripslashes($userss1['id']);?>"><?= stripslashes($userss1['title']);?></a> at <span class="text-primary"><?= stripslashes($userss1['city']);?></span></span><br>
														<span class="opacity-50">
															<?= stripslashes($userss1['e_date']);?>
														</span>
													</div>
                                                    
												</div>
											</div><!--end .timeline-entry -->
                                            
										</li>
                                        <?php endforeach;?>
                                         <?php 
										$where = "r_id = '".$user_id."' AND isactive = '1'";
										$request_events = $this->db->select('*')->from('events_request')->where($where)->get()->result_array(); 
										foreach($request_events as $request_eventss):
										$dtaa = $this->db->get_where('events',array("id"=>$request_eventss['event_id']))->result_array();
										?>
                                        <!--Event Show By request-->
                                        <li class="timeline-inverted">
											<div class="timeline-circ circ-xl style-primary"><i class="md md-event"></i></div>
											<div class="timeline-entry">
												<div class="card style-default-light">
													<div class="card-body small-padding">
														<span class="text-medium"><a class="text-primary" href="<?=base_url()?>users/event_detail/<?= stripslashes($dtaa[0]['id']);?>"><?= stripslashes($dtaa[0]['title']);?></a> at <span class="text-primary"><?= stripslashes($dtaa[0]['city']);?></span></span><br>
														<span class="opacity-50">
															<?= stripslashes($dtaa[0]['e_date']);?>
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
						<?php }else{?>
						<div class="col-md-8">
                        </div>
						<?php } ?>
							<!-- BEGIN PROFILE MENUBAR -->
							<div class="col-lg-offset-1 col-lg-3 col-md-4">
                            	<?php if(!empty($varified_user)){ ?>
								<div class="card card-underline style-default-dark">
									<div class="card-head">
										<header class="opacity-75"><small>Friends</small></header>
										<div class="tools">
                                        <?php if($user_check =='U'){ ?>
											<form class="navbar-search" role="search" method="post" action="<?=base_url()?>users/friend_request">
												<div class="form-group">
													<input type="text" class="form-control" name="friendSearch" placeholder="Enter your keyword">
												</div>
												<button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
											</form>
                                         <?php } ?>
										</div><!--end .tools -->
									</div><!--end .card-head -->
									<div class="card-body no-padding">
										<ul class="list">
                                        <?php 
										$where1 = "count = '0' AND (u_id = '".$user_id."' OR f_id = '".$user_id."') AND family_member !='F' AND family_member !='O'";
										$show_friends = $this->db->select('*')->from('following_list')->where($where1)->get()->result_array(); 
										foreach($show_friends as $show_friendss): ?>
                                        	<?php if($show_friendss['u_id'] == $user_id){ 
													$fname = $this->db->get_where('users',array("id"=>$show_friendss['f_id']))->row()->fname; 
 
													$lname = $this->db->get_where('users',array("id"=>$show_friendss['f_id']))->row()->lname;
													$profile_pic = $this->db->get_where('users',array("id"=>$show_friendss['f_id']))->row()->profile_pic;
													$user_show_id = $show_friendss['f_id'];
													
													}else { 
													$fname = $this->db->get_where('users',array("id"=>$show_friendss['u_id']))->row()->fname;
													$lname = $this->db->get_where('users',array("id"=>$show_friendss['u_id']))->row()->lname; 
													$profile_pic = $this->db->get_where('users',array("id"=>$show_friendss['u_id']))->row()->profile_pic;
													$user_show_id = $show_friendss['u_id'];
													}
													 ?>
											<li class="tile">
												<a class="tile-content ink-reaction" href="<?=base_url()?>users/profile/<?=$user_show_id?>">
													<div class="tile-icon">
											<? if($profile_pic !=''):?>
                                <img src="<?=base_url()?>/_images/profile_images/thumb/<?=$profile_pic?>" alt="" />
                                <? else:?>
                                    <img src="<?=base_url()?>assets/img/no-user-image-square.jpg" />
                                <? endif;?>
													</div>
													<div class="tile-text"><?=$fname?>&nbsp;<?=$lname?><small></small></div>
												</a>
											</li>
                                          <?php endforeach; ?>
										</ul>
									</div><!--end .card-body -->
								</div><!--end .card -->
                                
                                
                                <div class="card card-underline style-default-dark">
									<div class="card-head">
										<header class="opacity-75"><small>Family Member</small></header>
										<!--end .tools -->
									</div><!--end .card-head -->
									<div class="card-body no-padding">
										<ul class="list">
                                        <?php 
										$where1 = "count = '0' AND (u_id = '".$user_id."' OR f_id = '".$user_id."') AND family_member ='F'";
										$show_friends = $this->db->select('*')->from('following_list')->where($where1)->get()->result_array(); 
										foreach($show_friends as $show_friendss): ?>
                                        	<?php if($show_friendss['u_id'] == $user_id){ 
													$fname = @$this->db->get_where('users',array("id"=>$show_friendss['f_id']))->row()->fname;
													$lname = @$this->db->get_where('users',array("id"=>$show_friendss['f_id']))->row()->lname; 
													$profile_pic = @$this->db->get_where('users',array("id"=>$show_friendss['f_id']))->row()->profile_pic;  
													$user_show_id = $show_friendss['f_id'];
													}else { 
													$fname = $this->db->get_where('users',array("id"=>$show_friendss['u_id']))->row()->fname;
													$lname = @$this->db->get_where('users',array("id"=>$show_friendss['u_id']))->row()->lname; 
													$profile_pic = @$this->db->get_where('users',array("id"=>$show_friendss['u_id']))->row()->profile_pic; 
													
													$user_show_id = $show_friendss['u_id'];
													}
													 ?>
											<li class="tile">
												<a class="tile-content ink-reaction" href="<?=base_url()?>users/profile/<?=$user_show_id?>">
													<div class="tile-icon">
													<? if($profile_pic !=''):?>
						                                <img src="<?=base_url()?>/_images/profile_images/thumb/<?=$profile_pic?>" alt="" />
						                                <? else:?>
						                                    <img src="<?=base_url()?>assets/img/no-user-image-square.jpg" />
						                                <? endif;?>
													</div>
													<div class="tile-text"><?=$fname?>&nbsp;<?=$lname?><small></small></div>
												</a>
											</li>
                                          <?php endforeach; ?>
										</ul>
									</div><!--end .card-body -->
								</div>
                                <?php } ?>
								<div class="card card-underline style-default-dark">
									<div class="card-head">
										<header class="opacity-75"><small>Personal info</small></header>
                                        <?php if($user_check =='U'){ ?>
										<div class="tools">
											<a href="<?=base_url()?>users/edit_profile/" class="btn btn-icon-toggle ink-reaction"><i class="md md-edit"></i></a>
										</div><!--end .tools -->
                                        <?php } ?>
									</div><!--end .card-head -->
									<div class="card-body no-padding">
										<ul class="list">
                                         <li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon"></div>
													<div class="tile-text">
														<?=stripslashes($row_user_query->gender)?>
														<small>Gender</small>
													</div>
												</a>
											</li>
                                            <li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon"></div>
													<div class="tile-text">
														<?=stripslashes($row_user_query->bday)?>
														<small>Date of Birth</small>
													</div>
												</a>
											</li>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon">
														<i class="md md-location-on"></i>
													</div>
													<div class="tile-text">
														<?=stripslashes($row_user_query->address)?>
														<small>Street</small>
													</div>
												</a>
											</li>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon"></div>
													<div class="tile-text">
														<?=stripslashes($row_user_query->city)?>
														<small>City</small>
													</div>
                                                   	<div class="tile-text">
														<?=stripslashes($row_user_query->country)?>
														<small>Country</small>
													</div>
												</a>
											</li>
											<li class="divider-inset"></li>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon">
														<i class="fa fa-phone"></i>
													</div>
													<div class="tile-text">
														<?=stripslashes($row_user_query->mphone)?>
														<small>Mobile</small>
													</div>
												</a>
											</li>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon"></div>
													<div class="tile-text">
														<?=stripslashes($row_user_query->pphone)?>
														<small>Home</small>
													</div>
												</a>
											</li>
                                            											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon"></div>
													<div class="tile-text">
														<?=stripslashes($row_user_query->education)?>
														<small>Education</small>
													</div>
												</a>
											</li>
										</ul>
									</div><!--end .card-body -->
								</div><!--end .card -->
                                <?php if($user_check =='U' && (!empty($varified_user))){ ?>
                                <div class="card card-underline style-default-dark">
									<div class="card-head">
										<header class="opacity-75"><small>Request</small></header>
									</div><!--end .card-head -->
									<div class="card-body no-padding">
                                    <?php $where = "isactive = '0' AND type = '' AND (request_receiver_id = '".$this->session->userdata('user_id')."' OR request_receiver_id ='".$this->session->userdata('email')."')";
										$users = $this->db->select('*')->from('request')->where($where)->limit(2)->get()->result_array(); 
										 $users_count =  $this->db->select('count(*) as cont')->from('request')->where($where)->get()->row()->cont;
										 ?>
                                        <?php if(!empty($users)){ ?>
                                        <header class="opacity-75"><small style="padding-left:15px;">Approval Request</small></header>
                                        <?php } ?>
										<ul class="list">
                                        <?php 
										foreach($users as $userss):
										?>
											<li class="tile">
												<div class="tile-content ink-reaction">
                                                	<div class="tile-icon">
													<? if($this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->profile_pic !=''):?>
						                                <img src="<?=base_url()?>/_images/profile_images/thumb/<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->profile_pic;?>" alt="" />
						                                <? else:?>
						                                    <img src="<?=base_url()?>assets/img/no-user-image-square.jpg" />
						                                <? endif;?>
													</div>
													<div class="tile-text"><?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->fname;?>&nbsp;<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->lname;?>
                                                    <small style="display:inline;">             
                                                    	
														<a href="<?php echo base_url();?>users/update_status/<?= $userss['request_id'];?>/1/<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Approve" onclick="return confirm('Are You Sure To Approve?')"><i class="md md-done"></i></a>
                                        				
                                        				<a href="<?php echo base_url();?>users/update_status/<?= $userss['request_id'];?>/0/<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Reject" onclick="return confirm('Are You Sure To Reject?')"><i class="md md-clear"></i></a>
                                        				
                                        			</small>
                                        		</div>
												</div>
											</li>
                                        <?php endforeach;?>
										</ul>
                                        <?php $where1 = "isactive = '0' AND type = 'f' AND parent_id ='".$this->session->userdata('user_id')."'";
										$friend = $this->db->select('*')->from('request')->where($where1)->limit(2)->get()->result_array(); 
										$friend_count =  $this->db->select('count(*) as cont')->from('request')->where($where1)->get()->row()->cont;
										 ?>
                                        <?php if(!empty($friend)){ ?>
                                        <header class="opacity-75"><small style="padding-left:15px;">Friend Request</small></header>
                                        <?php } ?>
                                        <ul class="list">
                                        <?php 
										foreach($friend as $friends):
										?>
											<li class="tile">
												<div class="tile-content ink-reaction">
                                                	<div class="tile-icon">
													<? if($this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->profile_pic !=''):?>
						                                <img src="<?=base_url()?>/_images/profile_images/thumb/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->profile_pic?>" alt="" />
						                                <? else:?>
						                                    <img src="<?=base_url()?>assets/img/no-user-image-square.jpg" />
						                                <? endif;?>
													</div>
													<div class="tile-text">
													<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->fname;?>
                                                    &nbsp;<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->lname;?>
														<small style="display:inline;">             
                                                    	
														<a href="<?php echo base_url();?>users/accept_request/<?= $friends['request_id'];?>/1/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Accept" onclick="return confirm('Are You Sure To Accept?')"><i class="md md-done"></i></a>
                                        				
                                        				<a href="<?php echo base_url();?>users/accept_request/<?= $friends['request_id'];?>/0/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Reject" onclick="return confirm('Are You Sure To Reject?')"><i class="md md-clear"></i></a>
                                        				
                                        			</small>
                                        		</div>
												</div>
											</li>
                                        <?php endforeach;?>
										</ul>
                                        
                                        <!--Events-->
                                        <?php 
										$where1 = "events_request.isactive = '0' AND r_id = '".$this->session->userdata('user_id')."' AND events.isactive = '1'";
										$events = $this->db->select('*,events_request.isactive as isactive1')->from('events_request')->join('events','events.id=events_request.event_id')->where($where1)->limit(2)->get()->result_array(); 
										$event_count =  $this->db->select('count(*) as cont')->from('events_request')->join('events','events.id=events_request.event_id')->where($where1)->get()->row()->cont;
										 ?>
                                        <?php if(!empty($event_count)){ ?>
                                        <header class="opacity-75"><small style="padding-left:15px;">Event Request</small></header>
                                        <?php } ?>
                                        <ul class="list">
                                        <?php 
										foreach($events as $eventss):
										?>
											<li class="tile">
												<div class="tile-content ink-reaction">
													<div class="tile-text"><?=$this->db->get_where('events', array('id' => $eventss['event_id']))->row()->title;?>
                                                    <small style="display:inline;">             
                                                    	
														<a href="<?php echo base_url();?>users/event_request/<?= $eventss['request_id'];?>/1" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Accept" onclick="return confirm('Are You Sure To Approve?')"><i class="md md-done"></i></a>
                                        				
                                        				<a href="<?php echo base_url();?>users/event_request/<?= $eventss['request_id'];?>/0" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Reject" onclick="return confirm('Are You Sure To Reject?')"><i class="md md-clear"></i></a>
                                        			
                                        			</small>
                                        		</div>
												</div>
											</li>
                                        <?php endforeach;?>
										</ul>
                                        
									</div><!--end .card-body -->
                                    <?php if($friend_count>2 || $users_count>2 || $event_count>2){ ?>
                                    <a href="<?=base_url()?>users/show_request"><h3 align="center">View All</h3></a>
                                    <?php } ?>
								</div>
                                <div class="clearfix"></div>
                                <?php } ?>
							</div><!--end .col -->
							<!-- END PROFILE MENUBAR -->

						</div><!--end .row -->
					</div><!--end .section-body -->
				</section>
			</div>