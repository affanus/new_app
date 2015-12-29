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
echo ($this->session->userdata('user_id'));
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
                                <a href="<?=base_url()?>users/profile"><img  class="img-circle border-white border-xl img-responsive auto-width" src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($row_user_query->profile_pic)?>" alt="" /></a>
                                <? else:?>
                                    <a href="<?=base_url()?>users/profile"><img class="img-circle border-white border-xl img-responsive auto-width" src="<?=base_url()?>assets/img/no-user-image-square.jpg" /></a>
                                <? endif;?>

								<h3 style="text-transform:uppercase;">                                    <?=stripslashes($this->session->userdata('fname'))?> <?=stripslashes($this->session->userdata('lname'))?>
<br><small>Consultant at CodeCovers</small></h3>
							</div><!--end .col -->
							<div class="col-md-9 col-xs-7">
								<div class="width-3 text-center pull-right">
									<strong class="text-xl">643</strong><br>
									<span class="text-light opacity-75">followers</span>
								</div>
								<div class="width-3 text-center pull-right">
									<strong class="text-xl">108</strong><br>
									<span class="text-light opacity-75">following</span>
								</div>
							</div><!--end .col -->
						</div><!--end .row -->
						<div class="overlay overlay-shade-bottom stick-bottom-left force-padding text-right">
							<a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Contact me"><i class="fa fa-envelope"></i></a>
							<a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Follow me"><i class="fa fa-twitter"></i></a>
							<a class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Personal info"><i class="fa fa-facebook"></i></a>
						</div>
					</div><!--end .section-body -->
				</section>
				<!-- END PROFILE HEADER  -->

				<section>
					<div class="section-body no-margin">
						<div class="row">
							<div class="col-md-8">
								<h2>Timeline</h2>

								<!-- BEGIN ENTER MESSAGE -->
								<form class="form">
									<div class="card no-margin">
										<div class="card-body">
											<div class="form-group floating-label">
												<textarea name="status" id="status" class="form-control autosize" rows="1"></textarea>
												<label for="status">What's on your mind?</label>
											</div>
										</div><!--end .card-body -->
										<div class="card-actionbar">
											<div class="card-actionbar-row">
												<div class="pull-left">
													<a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-camera-alt"></i></a>
													<a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-location-on"></i></a>
													<a class="btn btn-icon-toggle ink-reaction btn-default"><i class="md md-attach-file"></i></a>
												</div>
												<a href="javascript:void(0);" class="btn btn-flat btn-accent ink-reaction">Post</a>
											</div><!--end .card-actionbar-row -->
										</div><!--end .card-actionbar -->
									</div><!--end .card -->
								</form>

								<!-- BEGIN ENTER MESSAGE -->

								<!-- BEGIN MESSAGE ACTIVITY -->
								<div class="tab-pane" id="activity">
									<ul class="timeline collapse-lg timeline-hairline">
										<li class="timeline-inverted">
											<div class="timeline-circ circ-xl style-primary"><i class="md md-event"></i></div>
											<div class="timeline-entry">
												<div class="card style-default-light">
													<div class="card-body small-padding">
														<span class="text-medium">Received a <a class="text-primary" href="../../html/mail/inbox.html">message</a> from <span class="text-primary">Ann Lauren</span></span><br>
														<span class="opacity-50">
															Saturday, Oktober 18, 2014
														</span>
													</div>
												</div>
											</div><!--end .timeline-entry -->
										</li>
										<li>
											<div class="timeline-circ circ-xl style-primary-dark"><i class="md md-access-time"></i></div>
											<div class="timeline-entry">
												<div class="card style-default-light">
													<div class="card-body small-padding">
														<p>
															<span class="text-medium">User login at <span class="text-primary">8:15 pm</span></span><br>
															<span class="opacity-50">
																Saturday, August 2, 2014
															</span>
														</p>
														Check out my new location.
													</div>
												</div>
											</div><!--end .timeline-entry -->
										</li>
									</ul>
								</div><!--end #activity -->
							</div><!--end .col -->
							<!-- END MESSAGE ACTIVITY -->

							<!-- BEGIN PROFILE MENUBAR -->
							<div class="col-lg-offset-1 col-lg-3 col-md-4">
								<div class="card card-underline style-default-dark">
									<div class="card-head">
										<header class="opacity-75"><small>Friends</small></header>
										<div class="tools">
											<form class="navbar-search" role="search" method="post" action="<?=base_url()?>users/friend_request">
												<div class="form-group">
													<input type="text" class="form-control" name="friendSearch" placeholder="Enter your keyword">
												</div>
												<button type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>
											</form>
										</div><!--end .tools -->
									</div><!--end .card-head -->
									<div class="card-body no-padding">
										<ul class="list">
                                        <?php 
										$where1 = "u_id = '".$this->session->userdata('user_id')."' OR f_id = '".$this->session->userdata('user_id')."' AND count = '0'";
										$show_friends = $this->db->select('*')->from('following_list')->where($where1)->get()->result_array(); 
										foreach($show_friends as $show_friendss): ?>
											<li class="tile">
												<a class="tile-content ink-reaction" href="#2">
													<div class="tile-icon">
														<img src="<?=base_url()?>assets/img/avatar2.jpg?1404026449" alt="">
													</div>
                                                    <?php if($show_friendss['u_id'] == $this->session->userdata('user_id')){ 
													$fname = $this->db->get_where('users',array("id"=>$show_friendss['f_id']))->row()->fname; 
													}else { 
													$fname = $this->db->get_where('users',array("id"=>$show_friendss['u_id']))->row()->fname;
													}
													 ?>
													<div class="tile-text"><?=$fname?><small></small></div>
												</a>
											</li>
                                          <?php endforeach; ?>
											<!--<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon">
														<img src="<?=base_url()?>assets/img/avatar4.jpg?1404026791" alt="">
													</div>
													<div class="tile-text">Alex Nelson<small>Proin nonummy, lacus eget pulvinar lacinia</small></div>
												</a>
											</li>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon">
														<img src="<?=base_url()?>assets/img/avatar11.jpg?1404026774" alt="">
													</div>
													<div class="tile-text">Mary Peterson<small>Nulla gravida orci a odio</small></div>
												</a>
											</li>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon">
														<img src="<?=base_url()?>assets/img/avatar7.jpg?1404026721" alt="">
													</div>
													<div class="tile-text">Trevor Hanson<small>Nullam varius, turpis et commodo pharetra</small></div>
												</a>
											</li>-->
										</ul>
									</div><!--end .card-body -->
								</div><!--end .card -->
								<div class="card card-underline style-default-dark">
									<div class="card-head">
										<header class="opacity-75"><small>Personal info</small></header>
										<div class="tools">
											<a class="btn btn-icon-toggle ink-reaction"><i class="md md-edit"></i></a>
										</div><!--end .tools -->
									</div><!--end .card-head -->
									<div class="card-body no-padding">
										<ul class="list">
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon">
														<i class="md md-location-on"></i>
													</div>
													<div class="tile-text">
														621 Johnson Ave, Suite 600
														<small>Street</small>
													</div>
												</a>
											</li>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon"></div>
													<div class="tile-text">
														San Francisco, CA 54321
														<small>City</small>
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
														(123) 456-7890
														<small>Mobile</small>
													</div>
												</a>
											</li>
											<li class="tile">
												<a class="tile-content ink-reaction">
													<div class="tile-icon"></div>
													<div class="tile-text">
														(323) 555-6789
														<small>Work</small>
													</div>
												</a>
											</li>
										</ul>
									</div><!--end .card-body -->
								</div><!--end .card -->
                                
                                <div class="card card-underline style-default-dark">
									<div class="card-head">
										<header class="opacity-75"><small>Approval Request</small></header>
									</div><!--end .card-head -->
									<div class="card-body no-padding">
										<ul class="list">
                                        <?php 
										$where = "request_receiver_id = '".$this->session->userdata('user_id')."' AND isactive = '0' AND type = '' OR request_receiver_id ='".$this->session->userdata('email')."'";
										$users = $this->db->select('*')->from('request')->where($where)->get()->result_array(); 
										foreach($users as $userss):
										?>
											<li class="tile">
												<div class="tile-content ink-reaction">
													<div class="tile-text"><?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->fname;?>
                                                    <small>             
                                                    	<? if($userss['isactive'] == '1') { ?>
														<a href="<?php echo base_url();?>users/update_status/<?= $userss['request_id'];?>/0/<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Published" onclick="return confirm('Are You Sure To Un Publish?')"><i class="md md-cloud-done"></i></a>
                                        				<? }else{?>
                                        				<a href="<?php echo base_url();?>users/update_status/<?= $userss['request_id'];?>/1/<?=$this->db->get_where('users', array('id' => $userss['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Un Published" onclick="return confirm('Are You Sure To Publish?')"><i class="md md-cloud-off"></i></a>
                                        				<? }?>
                                        			</small>
                                        		</div>
												</div>
											</li>
                                        <?php endforeach;?>
										</ul>
									</div><!--end .card-body -->
								</div>
                                <div class="clearfix"></div>
                                <div class="card card-underline style-default-dark">
									<div class="card-head">
										<header class="opacity-75"><small>Friends Request Approval</small></header>
									</div><!--end .card-head -->
									<div class="card-body no-padding">
										<ul class="list">
                                        <?php 
										$where1 = "isactive = '0' AND type = 'f' AND parent_id ='".$this->session->userdata('user_id')."'";
										$friend = $this->db->select('*')->from('request')->where($where1)->get()->result_array(); 
										foreach($friend as $friends):
										?>
											<li class="tile">
												<div class="tile-content ink-reaction">
													<div class="tile-text"><?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->fname;?>
                                                    <small>             
                                                    	<? if($friends['isactive'] == '1') { ?>
														<a href="<?php echo base_url();?>users/accept_request/<?= $friends['request_id'];?>/0/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Published" onclick="return confirm('Are You Sure To Un Publish?')"><i class="md md-cloud-done"></i></a>
                                        				<? }else{?>
                                        				<a href="<?php echo base_url();?>users/accept_request/<?= $friends['request_id'];?>/1/<?=$this->db->get_where('users', array('id' => $friends['request_sender_id']))->row()->id; ?>" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Un Published" onclick="return confirm('Are You Sure To Publish?')"><i class="md md-cloud-off"></i></a>
                                        				<? }?>
                                        			</small>
                                        		</div>
												</div>
											</li>
                                        <?php endforeach;?>
										</ul>
									</div><!--end .card-body -->
								</div>
							</div><!--end .col -->
							<!-- END PROFILE MENUBAR -->

						</div><!--end .row -->
					</div><!--end .section-body -->
				</section>
			</div>