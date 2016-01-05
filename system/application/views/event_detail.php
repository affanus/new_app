<?php
$CI =& get_instance();
$CI->load->model('security');
$CI->security->validate_user_session();
$user_query = $this->db->query("SELECT *
						FROM
						users
						WHERE
						id  = '".$this->session->userdata('user_id')."'");
$row_user_query = $user_query->row();
?>

<div id="content">
 		 <?php 
		 
		 $user_query = $this->db->query("SELECT *
						FROM
						events
						WHERE
						id  = '".$e_id."'");
$row_user_query = $user_query->row();
										?>
				<section>
               
					<div class="section-body contain-lg">
						<div class="row">
							<div class="col-lg-12">
								<div class="card card-tiles style-default-light">

									<!-- BEGIN BLOG POST HEADER -->
									<div class="row style-primary">
										<div class="col-sm-9">
											<div class="card-body style-default-dark">
												<h2><?= stripslashes($row_user_query->title);?></h2>
												<div class="text-default-light" style="padding: 11px;"> <a href="#"></a></div>
											</div>
										</div><!--end .col -->
										<div class="col-sm-3">
											<div class="card-body">
												<div class="hidden-xs">
													<h3 class="text-light"><?= stripslashes($row_user_query->e_date);?></h3>

													<?= stripslashes($row_user_query->address);?>&nbsp;<?= stripslashes($row_user_query->city);?>&nbsp;<?= stripslashes($row_user_query->country);?>
												</div>
												<div class="visible-xs">
													<strong>15</strong> Jan <a href="#">2 comments <i class="fa fa-comment-o"></i></a>
												</div>
											</div>
										</div><!--end .col -->
									</div><!--end .row -->
									<!-- END BLOG POST HEADER -->

									<div class="row">

										<!-- BEGIN BLOG POST TEXT -->
										<div class="col-md-9">
											<article class="style-default-bright">
												<div>
                                                <? 
											if($query_media_featuredImage->num_rows() != 0) :
											$row_media_featuredImage = $query_media_featuredImage->row();?>
                                        	
                                            	<img style="width:100%;max-height:300px;" src="<?=base_url()?>_images/profile_images/thumb/<?=$row_media_featuredImage->path?>" class="img-responsive img-thumbnail" alt="featuredImage">
                                         
                                            <? endif;?>
												</div>
												<div class="card-body">
													<p><?= stripslashes($row_user_query->details);?></p>
												</div><!--end .card-body -->
											</article>
										</div><!--end .col -->
										<!-- END BLOG POST TEXT -->

										<!-- BEGIN BLOG POST MENUBAR -->
										<div class="col-md-3">
											<div class="card-body">
												<h3 class="text-light">Attendees</h3>
												<ul class="nav nav-pills nav-stacked nav-transparent">
                                            <?php $query_air_cat = $this->db->get_where('events_request',array("event_id"=>$row_user_query->id))->result_array(); ?>
                                    	<?
											foreach($query_air_cat as $row):?>
                                    			<li><a href="#"><?= stripslashes($fname = $this->db->get_where('users',array("id"=>$row['r_id']))->row()->fname);?>&nbsp;<?= stripslashes($fname = $this->db->get_where('users',array("id"=>$row['r_id']))->row()->lname);?></a></li>
                                        	<? endforeach; ?>	
												</ul>
												<h3 class="text-light">To Do List</h3>
                                                <?php $todos = $this->db->get_where('todo',array("event_id"=>$row_user_query->id))->result_array(); ?>
												<div class="list-tags">
                                                	<?php foreach($todos as $todoss): ?>
													<a class="btn btn-xs btn-primary"><?=$todoss['todo']?></a>
                                                    <?php endforeach; ?>
												</div>
											</div><!--end .card-body -->
                                            <form method="post" action="<?=base_url()?>users/add_todo" >
                                            	<input type="hidden" name="event_id" value="<?=$row_user_query->id?>"  />
                                                <div style="width:100%;float:left;">
                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="todo" id="title" required>
                                                            <label for="title">Add TODO</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-footer">
                                                        <button type="submit" class="btn btn-primary">Add TODO</button>
                                                    </div>
                                                </div>
                                            </form>
										</div><!--end .col -->
										<!-- END BLOG POST MENUBAR -->

									</div><!--end .row -->
								</div><!--end .card -->
							</div><!--end .col -->
						</div><!--end .row -->
				
						<!-- BEGIN COMMENTS -->
						<div class="row">
							<div class="col-md-9">
								<h4>Comments</h4>
                                <?php $comments = $this->db->get_where('comments',array("event_id"=>$row_user_query->id))->result_array(); ?>
								<ul class="list-comments">
                                <?php foreach($comments as $commentss):
									 $user_detail = $this->db->get_where('users',array("id"=>$commentss['user_id']))->result_array();
									 ?>
									<li>
										<div class="card">
											<div class="comment-avatar"><? if($user_detail[0]['profile_pic'] !=''):?>
                                                        <a href="<?=base_url()?>users/profile"><img style="border-radius: 50%;" src="<?=base_url()?>_images/profile_images/thumb/<?=$user_detail[0]['profile_pic']?>" alt="" /></a>
                                                        <? else:?>
                                                            <a href="<?=base_url()?>users/profile"><img style="border-radius: 50%;" src="<?=base_url()?>assets/img/no-user-image-square.jpg" /></a>
                                                        <? endif;?></div>
											<div class="card-body">
												<h4 class="comment-title"><?=$user_detail[0]['fname']?>&nbsp;<?=$user_detail[0]['lname']?><small><?=$commentss['date']?></small></h4>
												
												<p><?=$commentss['comment']?></p>
											</div>
										</div><!--end .card -->
									</li><!-- end comment -->
                                    <?php endforeach; ?>
									
								</ul>
							</div><!--end .col -->
						</div><!--end .row -->
						<!-- END COMMENTS -->

						<!-- BEGIN LEAVE COMMENT -->
						<div class="row">
							<div class="col-md-9">
								<h4>Leave a comment</h4>
								<form class="form-horizontal" action="<?=base_url()?>users/add_comments" method="post">
                                <input type="hidden" name="event_id" value="<?=$row_user_query->id?>"  />
									<div class="form-group">
										<div class="col-md-2">
											<label for="textarea1" class="control-label">Comment</label>
										</div>
										<div class="col-md-10">
											<textarea name="comment" id="comment" class="form-control" rows="1" placeholder="Leave a comment"></textarea>
										</div>
									</div>
									<div class="form-footer col-md-offset-2">
										<button type="submit" class="btn btn-primary">Post comment</button>
									</div>
								</form>
							</div><!--end .col -->
						</div><!--end .row -->
						<!-- END LEAVE COMMENT -->

					</div><!--end .section-body -->
				</section>
                <? echo form_close();?>
			</div>