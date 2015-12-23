<?php
$burl = base_url();
?>
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/theme-5/libs/DataTables/jquery.dataTables.css?1423553989" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/theme-5/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/theme-5/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
        
<div id="content">
	<section class="style-default-bright">
    	<div class="section-header" style="position: relative;">
			<h2 class="text-primary"><?= $title?></h2>
            <div style="position: absolute; right: 213px; bottom: -34px; z-index: 100;"><a class="btn ink-reaction btn-raised btn-default-light" href="<?php echo base_url();?>admin/admin_rights/add/"><i class="fa fa-plus fa-fw"></i> Add Admin User </a></div>
		</div>
		<div class="section-body">
			<?   if($query->num_rows() != 0) : ?>
			<table id="datatable1" class="table table-hover">
							<thead>
								<tr>
									<th>Pic</th>
									<th>Title</th>
									<th>Email</th>
									<th class="">Super Admin</th>
									<th class="text-right">Actions</th>
								</tr>
							</thead>
							<tbody>
                            <?
   $c = 1;
	 foreach($query->result() as $row): ?>
								<tr>
									<td><img class="img-circle width-1" src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($row->image)?>" alt=""></td>
									<td><?= stripslashes($row->fname.' '.$row->lname);?></td>
									<td><?= $row->email;?></td>
									<td><? if($row->issuper==1):?>True<? else: ?>False<? endif; ?></td>
									<td class="text-right">
										<a href="<?php echo base_url();?>admin/admin_rights/edit/<?= $row->adminid;?>" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Edit <?= stripslashes($row->fname.''.$row->lname);?>"><i class="fa fa-pencil"></i></a>
                                        <? if($row->isactive == '1') { ?>
											<a href="<?php echo base_url();?>admin/admin_rights/update_status/<?= $row->adminid;?>/0" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Published" onclick="return confirm('Are You Sure To Un Publish <?= stripslashes($row->fname.''.$row->lname);?>?')"><i class="md md-cloud-done"></i></a>
                                        <? }else{?>
                                        	<a href="<?php echo base_url();?>admin/admin_rights/update_status/<?= $row->adminid;?>/1" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Un Published" onclick="return confirm('Are You Sure To Publish <?= stripslashes($row->fname.''.$row->lname);?>?')"><i class="md md-cloud-off"></i></a>
                                        <? }?>
										<a href="<?php echo base_url();?>admin/admin_rights/del/<?= $row->adminid;?>"  class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete <?= stripslashes($row->fname.''.$row->lname);?>" onclick="return confirm('Are You Sure To Delete <?= stripslashes($row->fname.''.$row->lname);?>?')"><i class="fa fa-trash-o"></i></a>
									</td>
								</tr>
  <? 
  $c++;
  endforeach;
	 ?>
							</tbody>
						</table>
            <? else: ?>
           	<div class="alert alert-info" role="alert">
				<strong>Heads up!</strong> No Records Found!
			</div>         
            <? endif; ?>            
		</div><!--end .section-body -->
	</section>
</div>