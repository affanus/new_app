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
  <? 
$attributes = array('id' => 'form','name' => 'form');
echo form_open('admin/subscribers/bulk_actions/', $attributes);?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="71%"><?= $headingtop?></td>
    <td width="29%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="55%" align="right"><select name="baction" id="baction">
              <option value="">Bulk Actions</option>
              <option value="sta">Status</option>
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
    <td width="63%"><div id="settings_heading"><?= $title?></div></td>
    <td width="17%" align="right" style="padding-right:20px;"><a href="<?php echo base_url();?>admin/subscribers/download_csv/" target="_blank">Download Csv</a></td>
    <td width="20%" align="right" style="padding-right:20px;"><a href="<?php echo base_url();?>admin/subscribers/add/"><img src="<?php echo base_url();?>img/admin/plus.png" align="absmiddle"/> Add Subscriber</a></td>
  </tr>
</table>

	<div id="settings_content5" style="padding:10px; padding-left:15px;" >
    <?
//echo $this->pagination->create_links();
	?>
    <table width="97%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="grid_hd">Sr#</td>
    <td class="grid_hd">Title</td>
    <td class="grid_hd">Email</td>
    <td class="grid_hd">Status</td>
    <td class="grid_hd">Delete</td>
  </tr>
   <?
   $c = 1;
	 foreach($query->result() as $row): ?>
  <tr>
    <td width="5%" class="grid_row"><input type="checkbox" name="ch<?= $c;?>" id="ch<?= $c;?>" align="absmiddle" value="<?= $row->id;?>"/> <b><?=$c?></b></td>
    <td width="30%" class="grid_row"><b><?= $row->name;?></b></td>
    <td width="35%" class="grid_row">
      <?= $row->email;?>
   </td>
    <td width="17%" class="grid_row">
      <select name="isactive<?= $c;?>" id="isactive<?= $c;?>">
        <option value="1" <? if($row->isactive == '1') { ?>selected="selected"<? } ?>>Active</option>
        <option value="0" <? if($row->isactive == '0') { ?>selected="selected"<? } ?>>InActive</option>
      </select></td>
    <td width="13%" class="grid_row"><a href="<?php echo base_url();?>admin/subscribers/del/<?= $row->id;?>" style="font-size:10px;" onclick="return confirm('Are You Sure To Delete?')" class="show-tooltip" title="<strong>DELETE</strong><br><?= $row->name;?>">DELETE</a></td>
  </tr>
  <? 
  $c++;
  endforeach;
	 ?>
</table>
	<input type="hidden" value="<?=$c?>" name="count" id="count" />

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">
	  <tr>
	    <td>&nbsp;</td>
	    </tr>
	  <tr>
	    <td align="center" valign="top"><? 
 if ($curpage > 1) {  ?>
	      <a href='<?php echo base_url();?>admin/subscribers/page/1' class="pagclass">&lt;&lt;</a>
	      <? 

    // get previous page num  
$prevpage = $curpage - 1;
    ?>
	      <a href='<?php echo base_url();?>admin/subscribers/page/<? echo $prevpage; ?>' class="pagclass">&lt;</a>
	      <?  

 } // end if   

   

 // loop to show links to range of pages around current page  

 for ($x = (($curpage - $range) - 1); $x < (($curpage + $range) + 1); $x++) {  

   // if it's a valid page number...  

    if (($x > 0) && ($x <= $tpages)) {  

      // if we're on current page...  

      if ($x == $curpage) {  ?>
	      <span class="pagclass" style=" font-weight:bold;">Page <? echo $x; ?> of <? echo $tpages; ?></span>
	      <?  

     // if not current page...  

     } else { ?>
	      <a href='<?php echo base_url();?>admin/subscribers/page/<? echo $x; ?>/' class="pagclass"><? echo $x; ?></a>
	      <?  

 } // end else  

 } // end if   

} // end for  

        

// if not on last page, show forward and last page links      

if ($curpage != $tpages) {  

// get next page  

$nextpage = $curpage + 1; 

// echo forward link for next page  ?>
	      <a href='<?php echo base_url();?>admin/subscribers/page/<?= $nextpage;?>' class="pagclass">&gt;</a> <a href='<?php echo base_url();?>admin/subscribers/page/<?= $tpages;?>' class="pagclass">&gt;&gt;</a>
	      <?

} // end if  

/****** end build pagination links ******/  

?></td>
	    </tr>
	  </table>
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