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
    </tr>
</table>
<? 
$attributes = array('id' => 'form','name' => 'form');
echo form_open('admin/subscribers/add_/', $attributes);?>
	<div id="settings_content5" style="padding:10px; padding-left:15px;" >
<? if($errormess == '1'){ ?>
<div class="error" style="width:270px; margin-bottom:30px;">
<?php echo validation_errors('<p style="margin:0px;">'); ?>
</div>
<? } else {?>
<? } ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="17%"><span class="formtxt upcl">Name</span><br />
      <input type="text" name="title" id="title" class="txtfield" onkeypress="if (event.keyCode == 13) {document.form.submit();}"/></td>
    </tr>
  <tr>
    <td width="17%" style="padding-top:10px;"><span class="formtxt upcl">Email</span><br />
      <input type="text" name="email" id="email" class="txtfield" onkeypress="if (event.keyCode == 13) {document.form.submit();}"/></td>
    </tr>
  <tr>
    <td width="61%" style="padding-top:10px;"><span class="formtxt upcl">Isactive</span><br />
      <select name="isactive" id="isactive" class="selmenu" style="width:210px;">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td><a href="#" onclick="javascript:goSubmit();" >
              <div id="bigbutton" style=" float:left;">Save</div>
              </a></td>
  </tr>
  </table>

    </div><? echo form_close();?>
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