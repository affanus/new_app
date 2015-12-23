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
<div id="dashboard_head">
 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="71%"><?= $headingtop?></td>
    <td width="29%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="55%" align="right">&nbsp;</td>
            <td width="45%" style="padding-left:10px;"></td>
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
    <td width="78%"><div id="settings_heading"><?= $title?></div></td>
    <td width="22%" align="right" style="padding-right:20px;">&nbsp;</td>
  </tr>
</table>

	<div id="settings_content5" style="padding:10px; padding-left:15px;" >
    
    <? 

$attributes = array('id' => 'form','name' => 'form','enctype'=>'multipart/form-data');

echo form_open('admin/'.$controler_name.'/add_action/'.$this->uri->segment(4), $attributes);?>

	<div id="settings_content5" style="padding:10px; padding-left:15px;" >

<? if($errormess == '1'){ ?>

<div class="error" style="width:270px; margin-bottom:30px;">

<?php echo validation_errors('<p style="margin:0px;">'); ?>

</div>

<? } else {?>

<? } 

$row = $query->row(); 	
?>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="27%"><span class="formtxt upcl">Support Email</span><br />

      <input type="text" name="supportemail" id="supportemail" class="txtfield" onKeyPress="if (event.keyCode == 13) {document.form.submit();}" value="<?=$row->supportemail?>"/></td>

    <td width="33%" class="pleft_20"><span class="formtxt upcl">Sales Email</span><br />

      <input type="text" name="salesemail" id="salesemail" class="txtfield" onKeyPress="if (event.keyCode == 13) {document.form.submit();}" value="<?=$row->salesemail?>"/></td>
    <td width="40%" class="pleft_20"><span class="formtxt upcl">Contact No.</span><br />

       <input type="text" name="contact" id="contact" class="txtfield" onKeyPress="if (event.keyCode == 13) {document.form.submit();}" value="<?=$row->contact?>"/></td>
    </tr>

  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="formtxt upcl">Screen Idle Time</span><br />
    <input type="text" name="advert" id="advert" class="txtfield" onKeyPress="if (event.keyCode == 13) {document.form.submit();}" value="<?=$row->advert?>"/></td>
    <td class="pleft_20">&nbsp;</td>
    <td class="pleft_20">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="formtxt upcl">Coupons Menu Icon</span><br />
    <input type="file" name="coupons_icon" id="coupons_icon" /></td>
    <td class="pleft_20"><? if($row->coupons_icon!=''):?><img src="<?=base_url()?>_images/icons/<?=$row->coupons_icon?>" /><? endif;?></td>
    <td class="pleft_20"><span class="formtxt upcl">Coupons Menu Status</span><br /><select name="coupons_status" id="coupons_status" class="selmenu">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="formtxt upcl">Saleitems Menu Icon</span><br />
    <input type="file" name="saleitem_icon" id="saleitem_icon" /></td>
    <td class="pleft_20"><? if($row->saleitem_icon!=''):?><img src="<?=base_url()?>_images/icons/<?=$row->saleitem_icon?>" /><? endif;?></td>
    <td class="pleft_20"><span class="formtxt upcl">Saleitems Menu Status</span><br /><select name="saleitem_status" id="saleitem_status" class="selmenu">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="formtxt upcl">Happy Hr Menu Icon</span><br />
    <input type="file" name="happy_icon" id="happy_icon" /></td>
    <td class="pleft_20"><? if($row->happy_icon!=''):?><img src="<?=base_url()?>_images/icons/<?=$row->happy_icon?>" /><? endif;?></td>
    <td class="pleft_20"><span class="formtxt upcl">Happy Hr Menu Status</span><br /><select name="happy_status" id="happy_status" class="selmenu">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select></td>
  </tr>
  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  <tr>

    <td colspan="3"><div style="width:97%;"></div></td>
  </tr>

   <tr>

     <td colspan="3">&nbsp;</td>
   </tr>

   <tr>

    <td colspan="3"><a href="#" onClick="javascript:goSubmit();" >

              <div id="bigbutton" style=" float:left;">Save</div>

              </a></td>
  </tr>
  </table>



    </div><? echo form_close();?>
    
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
<? echo form_close();?>
</div><!-- main_content Ends -->


</div>