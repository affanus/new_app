<?php
$burl = base_url();
?><!-- end login_form-->
 <script type="text/javascript">
function goSubmit()
{
  document.form.submit();
  
}
</script>
<div id="content_wrapper"><!-- content_wrapper Starts -->
<div id="main_content"><!-- main_content Starts -->
<div id="content">
<div id="dashboard_head"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="71%"><?= $headingtop?></td>
    <td width="29%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</div>
<div id="settings_main">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="12%" align="left" valign="top"><?php $this->load->view('admin/includes/left_menu'); ?></td>
    <td width="88%" align="left" valign="top"><div id="settings_content">
    <? 
$attributes = array('id' => 'form','name' => 'form');
echo form_open('admin/canned_emails/bulk_actions/', $attributes);?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="background-image:url(<?php echo base_url();?>img/admin/settings10_05.png); background-repeat:repeat-x;">
	<div id="settings_content1"><img src="<?php echo base_url();?>img/admin/settings01_03.png" /></div>
	<div id="settings_content2"><img src="<?php echo base_url();?>img/admin/1_03.png" /></div>
	</td>
  </tr>
  <tr>
    <td>
	<div id="settings_content5" style="border-left:#e7e6e6 solid 2px;border-right:#e7e6e6 solid 2px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="78%"><div id="settings_heading"><?= $title?></div></td>
    <td width="22%" align="right" style="padding-right:20px;"></td>
  </tr>
</table>

	<div id="settings_content5" style="padding:10px; padding-left:15px;" >
    <table width="97%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="grid_hd">Sr#</td>
    <td class="grid_hd">Mail Type</td>
    <td class="grid_hd">Edit</td>
    </tr>
   <?
   $c = 1;
	 foreach($query->result() as $row): ?>
  <tr>
    <td width="5%" class="grid_row"><b><?=$c?></b></td>
    <td width="19%" class="grid_row"><a href="<?php echo base_url();?>admin/canned_emails/edit/<?= $row->pkey;?>" class="show-tooltip" title="<strong>EDIT</strong><br><?= $row->MessageType;?>"><b><?= $row->MessageType;?></b></a></td>
    <td width="76%" class="grid_row"><a href="<?php echo base_url();?>admin/canned_emails/edit/<?= $row->pkey;?>" style="font-size:10px;" class="show-tooltip" title="<strong>EDIT</strong><br><?= $row->MessageType;?>">EDIT</a></td>
    </tr>
  <? 
  $c++;
  endforeach;
	 ?>
</table>
	<input type="hidden" value="<?=$c?>" name="count" id="count" />


	</div>
	</div>
      </td>
  </tr>
  <tr>
    <td style="background-image:url(<?php echo base_url();?>img/admin/settings10_05.png); background-repeat:repeat-x; background-position: bottom;">
	<div id="settings_content3"><img src="<?php echo base_url();?>img/admin/settings01_15.png" /></div>
	<div id="settings_content4"><img src="<?php echo base_url();?>img/admin/2_06.png" /></div>
	</td>
  </tr>
</table>
<? echo form_close();?>
</div></td>
  </tr>
</table>



</div>
</div>
</div><!-- main_content Ends -->


</div>