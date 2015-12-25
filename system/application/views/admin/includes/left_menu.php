			<!-- BEGIN MENUBAR-->
			<div id="menubar" class="menubar-inverse ">
				<div class="menubar-fixed-panel">
					<div>
						<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="expanded">
						<a href="<?=base_url()?>/admin">
							<span class="text-lg text-bold text-primary ">Chymps&nbsp;ADMIN</span>
						</a>
					</div>
				</div>
				<div class="menubar-scroll-panel">

					<!-- BEGIN MAIN MENU -->
					<ul id="main-menu" class="gui-controls">
<? $current_controller = $this->router->fetch_class(); 
	$current_method = $this->router->fetch_method(); 
	$adminid = $this->session->userdata('username');
?>

<?	
$query = $this->db->query("Select
tbltabs.alt,
tbltabs.link,
tbltabs.tabid as tid,
tbltabs.seqno,
tbltabs.dl,
tbltabs.tabimage,
tbladminrights.id,
tbladminrights.adminid,
tbladminrights.tabid,
tbladminrights.isactive
From
tbltabs,tbladminrights
where tbltabs.tabid = tbladminrights.tabid and tbladminrights.adminid = '".$adminid."' and tbladminrights.isactive = '1' order by tbltabs.seqno asc");
foreach ($query->result_array() as $row)
{
	
	$pmenu = $row['tabid'];
$query2 = $this->db->query("Select
tbltabdetails.tabdetailid,
tbltabdetails.tabid as tid,
tbltabdetails.linktitle,
tbltabdetails.linkurl,
tbltabdetails.image,
tbltabdetails.seqno,
tbltabdetails.isactive as active,
tbladminrightdetails.adminid,
tbladminrightdetails.tabid,
tbladminrightdetails.isactive,
tbladminrightdetails.tabdetailid
From
tbltabdetails,tbladminrightdetails
where tbltabdetails.tabdetailid = tbladminrightdetails.tabdetailid and tbltabdetails.tabid = '".$pmenu."' and tbltabdetails.tabid = tbladminrightdetails.tabid and tbltabdetails.isactive = '1' and tbladminrightdetails.isactive = '1' and tbladminrightdetails.adminid = '".$adminid."' order by tbltabdetails.seqno asc");
?>

						<li <? if ($query2->num_rows() > 0) {?>class="gui-folder" <? }?>>
							<a href="<? if($row['dl']==1){ echo $row['link']; } else {?><?= base_url();?>admin/<?= $row['link'];?><? }?>" class="<? if($row['link']==$current_controller.'/' || ($row['tabid']==1 && $current_controller.'/'.$current_method=='admin_main/dashboard')){?>active<? }?>">
								<div class="gui-icon"><i class="<?= $row['tabimage'];?>"></i></div>
								<span class="title"><?= $row['alt'];?></span>
							</a>
                            <?

					if ($query2->num_rows() > 0)
{
?>
 							<ul>
                            <?
							foreach ($query2->result_array() as $row2)
							{
							?>
								<li><a href="<?php echo base_url();?>admin/<?= $row2['linkurl'];?>" class="<? if($row2['linkurl']==$current_controller.'/'){?>active<? }?>"><span class="title"><?= $row2['linktitle'];?></span></a></li>
							<? } ?>
								
							</ul><!--end /submenu -->
<? } ?>                           
						</li><!--end /menu-li -->

<? } ?>


					</ul><!--end .main-menu -->
					<!-- END MAIN MENU -->

					<div class="menubar-foot-panel">
						<small class="no-linebreak hidden-folded">
							<span class="opacity-75">Copyright &copy; 2015</span> <strong>Chymps</strong>
						</small>
					</div>
				</div><!--end .menubar-scroll-panel-->
			</div><!--end #menubar-->
			<!-- END MENUBAR -->