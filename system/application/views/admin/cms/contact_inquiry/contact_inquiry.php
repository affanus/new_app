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
echo form_open('admin/contact_inquiry/bulk_actions/', $attributes);?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="53%"><?= $headingtop?></td>
    <td width="47%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="47%" align="right" style="padding-right:10px;"><input type="text" name="search" id="search" class="smtxtfield" onkeypress="if (event.keyCode == 13) {goSubmit();}" value="<?= $keyword?>"/></td>
            <td width="11%" align="right" style="padding-right:10px;"><a href="javascript:void();" onclick="javascript:goSubmit();" >
              <div class="smbutton" style=" float:left;">Search</div>
            </a></td>
            <td width="23%" align="right" style="padding-right:10px;"><select name="baction" id="baction">
              <option value="">Bulk Actions</option>
              <option value="mar">Mark As Read</option>
              <option value="maur">Mark As UnRead</option>
              <option value="del">Delete</option>
            </select></td>
            <td width="19%" style="padding-right:10px;"><a href="javascript:void();" onclick="javascript:goSubmit();" >
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
    <td width="78%"><div id="settings_heading"><?= $title?></div></td>
    <td width="22%" align="right" style="padding-right:20px;"></td>
  </tr>
</table>
	<div id="settings_content5" style="padding:10px; padding-left:15px;" >
    <?   if($query->num_rows() != 0) { ?>
    <table width="97%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="grid_hd">Sr#</td>
    <td class="grid_hd">Name</td>
    <td class="grid_hd">Date</td>
    <td class="grid_hd">Phone</td>
    <td class="grid_hd">Email</td>
    <td class="grid_hd">Country</td>
    <td class="grid_hd">Status</td>
    <td class="grid_hd">Delete</td>
  </tr>
   <?
   $c = 1;
	 foreach($query->result() as $row): ?>
  <tr <? if($row->status == 0) { echo 'style="background-color:#eef8fc;"'; } ?>>
    <td width="5%" class="grid_row"><input type="checkbox" name="ch<?= $c;?>" id="ch<?= $c;?>" align="absmiddle" value="<?= $row->id;?>"/> <b><?=$c?></b></td>
    <td width="22%" class="grid_row"><a href="<?php echo base_url();?>admin/contact_inquiry/view_inquiry/<?= $row->id;?>"><b><?= $row->txtfname;?>&nbsp;<?= $row->txtlname;?></b></a></td>
    <td width="11%" class="grid_row"><?= $row->date;?></td>
    <td width="12%" class="grid_row"><?= $row->txtphone;?></td>
    <td width="22%" class="grid_row"><?= $row->txtemail;?></td>
    <td width="11%" class="grid_row"><?= $row->txtcountry;?></td>
    <td width="9%" class="grid_row" style="font-size:10px;"><?
	
	 if($row->status == 0) {
		echo 'UN READ'; 
	 } else if($row->status == 1) {
		 echo 'READ'; 
	 } 
		 ?> 
         </td>
    <td width="8%" class="grid_row"><a href="<?php echo base_url();?>admin/contact_inquiry/del/<?= $row->id;?>" style="font-size:10px;" onclick="return confirm('Are You Sure To Delete?')">DELETE</a></td>
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
	      <a href='<?php echo base_url();?>admin/contact_inquiry/page/1' class="pagclass">&lt;&lt;</a>
	      <? 

    // get previous page num  
$prevpage = $curpage - 1;
    ?>
	      <a href='<?php echo base_url();?>admin/contact_inquiry/page/<? echo $prevpage; ?>' class="pagclass">&lt;</a>
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
	      <a href='<?php echo base_url();?>admin/contact_inquiry/page/<? echo $x; ?>/' class="pagclass"><? echo $x; ?></a>
	      <?  

 } // end else  

 } // end if   

} // end for  

        

// if not on last page, show forward and last page links      

if ($curpage != $tpages) {  

// get next page  

$nextpage = $curpage + 1; 

// echo forward link for next page  ?>
	      <a href='<?php echo base_url();?>admin/contact_inquiry/page/<?= $nextpage;?>' class="pagclass">&gt;</a> <a href='<?php echo base_url();?>admin/contact_inquiry/page/<?= $tpages;?>' class="pagclass">&gt;&gt;</a>
	      <?

} // end if  

/****** end build pagination links ******/  

?></td>
	    </tr>
	  </table>
 <? } else {
	   echo 'No Records Found!';
   }?>
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
<? echo form_close();?>


</div>
</div>
</div><!-- main_content Ends -->


</div>