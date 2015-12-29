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
						<div class="img-backdrop" style="background-image: url('../../assets/img/img16.jpg')"></div>
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
								<h2>Friend Request</h2>
								<div class="tab-pane" id="activity">
									<ul class="timeline collapse-lg timeline-hairline">
                                    <?php $data = $this->db->select('*')->from('users')->where('fname',$friendSearch)->get()->result_array();
									//print_r($data);
									foreach($data as $datas):
									 ?>
										<li class="timeline-inverted">
											<div class="timeline-entry">
												<div class="card style-default-light">
													<div class="card-body small-padding">
														<span class="text-medium"><?=$datas['fname']?><a class="text-primary" href="<?=base_url()?>users/send_request/<?=$datas['id']?>" style="padding-left:10px;">Add Friend</a></span>
													</div>
												</div>
											</div><!--end .timeline-entry -->
										</li>
                                     <?php endforeach; ?>
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