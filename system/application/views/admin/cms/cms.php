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
            <div style="position: absolute; right: 213px; bottom: -34px; z-index: 100;"><a class="btn ink-reaction btn-raised btn-default-light" href="<?php echo base_url();?>admin/cms/addpage/<?= $this->uri->segment(4);?>"><i class="fa fa-plus fa-fw"></i> Add New Page </a></div>
		</div>
		<div class="section-body">
			<?   if($query->num_rows() != 0) : ?>
			<table id="datatable1" class="table table-hover">
							<thead>
								<tr>
									<th>Sr#</th>
									<th>Title</th>
									<th>Url</th>
									<th class="sort-numeric">Seq. no</th>
									<th class="text-right">Actions</th>
								</tr>
							</thead>
							<tbody>
                            <?
   $c = 1;
	 foreach($query->result() as $row): ?>
								<tr>
									<td><?=$c?></td>
									<td><?= stripslashes($row->title);?></td>
									<td><?php echo base_url();?><?= $row->pagename;?></td>
									<td><?= $row->seqno;?></td>
									<td class="text-right">
										<a href="<?php echo base_url();?>admin/cms/editpage/<?= $row->id;?>" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Edit <?= stripslashes($row->title);?>"><i class="fa fa-pencil"></i></a>
                                        <? if($row->isActive == '1') { ?>
											<a href="<?php echo base_url();?>admin/cms/update_status/<?= $row->id;?>/0" class="btn btn-icon-toggle style-success" data-toggle="tooltip" data-placement="top" data-original-title="Status: Published" onclick="return confirm('Are You Sure To Un Publish <?= stripslashes($row->title);?>?')"><i class="md md-cloud-done"></i></a>
                                        <? }else{?>
                                        	<a href="<?php echo base_url();?>admin/cms/update_status/<?= $row->id;?>/1" class="btn btn-icon-toggle style-danger " data-toggle="tooltip" data-placement="top" data-original-title="Status: Un Published" onclick="return confirm('Are You Sure To Publish <?= stripslashes($row->title);?>?')"><i class="md md-cloud-off"></i></a>
                                        <? }?>
										<a href="<?php echo base_url();?>admin/cms/delpage/<?= $row->id;?>"  class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Delete <?= stripslashes($row->title);?>" onclick="return confirm('Are You Sure To Delete <?= stripslashes($row->title);?>?')"><i class="fa fa-trash-o"></i></a>
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