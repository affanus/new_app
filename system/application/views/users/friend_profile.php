<?php
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
								

								<!-- BEGIN ENTER MESSAGE -->

								<!-- BEGIN MESSAGE ACTIVITY -->
								<div class="tab-pane" id="activity">
									<ul class="timeline collapse-lg timeline-hairline">
                                                 <?php 
										$where = "u_id = '".$user_id."' AND isactive = '1' AND parent_isactive = '1'";
										$users1 = $this->db->select('*')->from('events')->where($where)->get()->result_array(); 
										foreach($users1 as $userss1):
										?>
										<li class="timeline-inverted">
											<div class="timeline-circ circ-xl style-primary"><i class="md md-event"></i></div>

											<div class="timeline-entry">
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
										</div><!--end .tools -->
									</div><!--end .card-head -->
									<div class="card-body no-padding">
										<ul class="list">
                                        <?php 
										//$where1 = "u_id = '".$this->session->userdata('user_id')."' OR f_id = '".$this->session->userdata('user_id')."' AND count = '0'";
										$where1 = "count = '0' AND (u_id = '".$this->session->userdata('user_id')."' OR f_id = '".$this->session->userdata('user_id')."')";
										$show_friends = $this->db->select('*')->from('following_list')->where($where1)->get()->result_array(); 
										foreach($show_friends as $show_friendss): ?>
                                        <?php if($show_friendss['u_id'] == $user_id){ 
													$fname = $this->db->get_where('users',array("id"=>$show_friendss['f_id']))->row()->fname; 
													$user_show_id = $show_friendss['f_id'];
													}else { 
													$fname = $this->db->get_where('users',array("id"=>$show_friendss['u_id']))->row()->fname;
													$user_show_id = $show_friendss['u_id'];
													}
													 ?>
											<li class="tile">
												<a class="tile-content ink-reaction" href="<?=base_url()?>users/friend_profile/<?=$user_show_id?>">
													<div class="tile-icon">
														<img src="<?=base_url()?>assets/img/avatar2.jpg?1404026449" alt="">
													</div>
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
                                
							</div><!--end .col -->
							<!-- END PROFILE MENUBAR -->

						</div><!--end .row -->
					</div><!--end .section-body -->
				</section>
			</div>