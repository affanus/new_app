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
								<h2>Search</h2>
								<div class="tab-pane" id="activity">
									<ul class="timeline collapse-lg timeline-hairline">
                                    <?php 
									$where5 = "family_member !='O' AND (u_id = '".$this->session->userdata('user_id')."' OR f_id = '".$this->session->userdata('user_id')."')";
									$before_friends = $this->db->select('*')->from('following_list')->where($where5)->get()->result_array();
									foreach($before_friends as $before_friendss):
										if($before_friendss['u_id'] == $this->session->userdata('user_id'))
										{
											@$friend_list[] =$before_friendss['f_id'];
										}
										else
										{
											@$friend_list[] =$before_friendss['u_id'];
										}
 									endforeach;
									//AND approved_by !='".$this->session->userdata('user_id')."' AND id !='".$approved_by."' AND approved_by !=''
									$approved_by = $this->db->get_where('users',array("id"=>$this->session->userdata('user_id')))->row()->approved_by;
									$where1 = "fname LIKE '%$friendSearch%' AND id != '".$this->session->userdata('user_id')."' AND approved_by !=''";
									$data = $this->db->select('*')->from('users')->where($where1)->get()->result_array();
									foreach($data as $datas):
									if(@!in_array($datas['id'],$friend_list)){
									 ?>
										<li class="timeline-inverted">
											<div class="timeline-entry">
												<div class="card style-default-light">
													<div class="card-body small-padding">
														<span class="text-medium">

														 <? if($datas['profile_pic'] !=''):?>
                                                        <a href="<?=base_url()?>users/profile"><img style="width:50px; height:50px;" src="<?=base_url()?>_images/profile_images/thumb/<?=$datas['profile_pic']?>" alt="" /></a>
                                                        <? else:?>
                                                            <a href="<?=base_url()?>users/profile"><img style="width:50px; height:50px;" src="<?=base_url()?>assets/img/no-user-image-square.jpg" /></a>
                                                        <? endif;?>
<?=$datas['fname']?>&nbsp;<?=$datas['lname']?><a class="text-primary pull-right" href="<?=base_url()?>users/send_request/<?=$datas['id']?>" style="padding-left:10px;padding-top:15px;">Add Friend</a></span>
													</div>
												</div>
											</div><!--end .timeline-entry -->
										</li>
                                     <?php } endforeach; ?>
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