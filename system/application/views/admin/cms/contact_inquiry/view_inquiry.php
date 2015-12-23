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
    <td width="71%">
	 <?
   $row = $query->row();
	 ?>
	<?= $headingtop?></td>
    <td width="29%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="55%" align="right"><select name="baction" id="baction">
              <option value="">Bulk Actions</option>
              <option value="seq">Sequence</option>
              <option value="del">Delete</option>
              </select></td>
            <td width="45%" style="padding-left:10px;"><a href="#" onclick="javascript:goSubmit();" >
              <div class="smbutton" style=" float:left;">Apply</div>
              </a></td>
            </tr>
        </table></td>
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
    <td width="78%"><div id="settings_heading"><?= $title;?><?= $row->txtfname;?></div></td>
    <td width="22%" align="right" style="padding-right:20px;">
    </td>
  </tr>
</table>

	<div id="settings_content5" style="padding:10px; padding-left:15px;" >
    <span class="formtxt">Rec Date:</span> <?= $row->date;?><br />
    <span class="formtxt">First Name:</span> <?= $row->txtfname;?><br />
    <span class="formtxt">Last Name:</span> <?= $row->txtlname;?><br />
    <span class="formtxt">Email:</span> <?= $row->txtemail;?><br />
    <span class="formtxt">Phone:</span> <?= $row->txtphone;?><br /><br />
    <span class="formtxt">Message:</span><br /> <?= $row->txtmsg;?>
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

</div></td>
  </tr>
</table>



</div>
</div>
</div><!-- main_content Ends -->


</div>