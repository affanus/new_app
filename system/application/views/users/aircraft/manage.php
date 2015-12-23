<?php
$burl = base_url();
?>
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/theme-5/libs/DataTables/jquery.dataTables.css?1423553989" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/theme-5/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
		<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/css/theme-5/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
        
<div id="content">
	<section class="">
    	<div class="section-header" style="position: relative;">
			<h2 class="text-primary"><?= $headingtop?> <?= $title?></h2>
            <div style="position: absolute; right: 213px; bottom: -34px; z-index: 100;"><a class="btn ink-reaction btn-raised btn-default-bright" href="<?php echo base_url();?>user/<?=$controler_name;?>/add/<?= $this->uri->segment(4);?>"><i class="fa fa-plus fa-fw"></i> <?=$add_link?> </a></div>
		</div>
		<div class="section-body ">
			<?   if($query->num_rows() != 0) : ?>
			<table id="datatable1" class="table table-hover">
							<thead>
								<tr>
									<th>Sr#</th>
                                    <th>Pic</th>
                                    <th>MSN</th>
                                    <th>Aircraft</th>
                                    <th>Primary Contact</th>
									<th class="text-right">Actions</th>
								</tr>
							</thead>
							<tbody>
                            <?
   $c = 1;
	 foreach($query->result() as $row): ?>
								<tr>
									<td><?=$c?></td>
                                    <td><? if($row->path!=''):?><img class="img-circle width-1" src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($row->path)?>" alt=""><? else:?><img class="img-circle width-1" src="<?=base_url()?>assets/img/no-user-image-square.jpg" /><? endif;?></td>
                                    <td><?= $row->msn;?></td>
                                    <td><?= $row->man_title;?> <?= $row->type_title;?> <?= $row->model_title;?></td>
									<td><?= $row->title;?> <?= $row->fname;?> <?= $row->lname;?></td>
									<td class="text-right">
										<a href="<?php echo base_url();?>user/<?=$controler_name;?>/edit/<?= $row->id;?>" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Edit <?= $row->man_title;?> <?= $row->type_title;?> <?= $row->model_title;?>"><i class="fa fa-pencil"></i></a>
                                        <? if($row->isactive == '1') { ?>
											<a href="<?php echo base_url();?>user/<?=$controler_name;?>/update_status/<?= $row->id;?>/0" class="btn btn-icon-toggle style-success " data-toggle="tooltip" data-placement="top" data-original-title="Status: Published" onclick="return confirm('Are You Sure To Un Publish <?= $row->man_title;?> <?= $row->type_title;?> <?= $row->model_title;?>?')"><i class="md md-cloud-done"></i></a>
                                        <? }else{?>
                                        	<a href="<?php echo base_url();?>user/<?=$controler_name;?>/update_status/<?= $row->id;?>/1" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Un Published" onclick="return confirm('Are You Sure To Publish <?= $row->man_title;?> <?= $row->type_title;?> <?= $row->model_title;?>?')"><i class="md md-cloud-off"></i></a>
                                        <? }?>
										<a href="<?php echo base_url();?>user/<?=$controler_name;?>/del/<?= $row->id;?>"  class="btn btn-icon-toggle " data-toggle="tooltip" data-placement="top" data-original-title="Delete <?= $row->man_title;?> <?= $row->type_title;?> <?= $row->model_title;?>" onclick="return confirm('Are You Sure To Delete <?= $row->man_title;?> <?= $row->type_title;?> <?= $row->model_title;?>?')"><i class="fa fa-trash-o"></i></a>
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