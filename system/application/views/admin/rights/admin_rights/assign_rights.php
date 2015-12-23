<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/nestable/nestable.css" />
<div id="content">
	<section class="style-default-bright">
    	<div class="section-header" style="position: relative;">
			<h2 class="text-primary"></h2>
		</div>
        <div class="section-body">
        	<form action="<?php echo base_url();?>admin/admin_rights/assign_rights_action/<?= $this->uri->segment(4) ?>/" method="post" id="form" name="form">
            	<div class="card">
					<div class="card-head style-accent">
						<header>Assign Admin Rights</header>
					</div>
					<div class="card-body floating-label ">

						<div class="row">
                        	<div class="col-lg-12">                   	
                                
                                <ul class="dd-list" data-sortable="true" style="list-style:none">
                                
                                 <?
   $c = 1;
   $c2 = 0;
    
	 foreach($query->result() as $row): 
		 if($row->isactive == 1) {
			 $tabchecked = 'checked="checked"';
		 } else {
			 $tabchecked = '';
		 }
	 ?>    
                                    <li class="dd-item list-group">
                                    	<input name="<?= $c?>" type="hidden" value="<?= $row->id?>"/>
                                        <div class="checkbox checkbox-styled tile-text">
                                            <label>
                                                <input name="ch<?= $c?>" type="checkbox" <?= $tabchecked?>>
                                                <span class="text-lg"><?= $row->alt?></span>
                                            </label>
                                        </div>
                                        
   <?
$tabid = $row->tabid;
$query = $this->db->query("SELECT `tbladminrightdetails`.`adminid`, `tbladminrightdetails`.`tabdetailid` as rdetailid, `tbladminrightdetails`.`tabid`, `tbladminrightdetails`.`isactive` as ractive, `tbladminrightdetails`.`dl`, `tbltabdetails`.`tabdetailid`, `tbltabdetails`.`tabid` , `tbltabdetails`.`linktitle`, `tbltabdetails`.`linkurl`, `tbltabdetails`.`linktooltip`, `tbltabdetails`.`seqno` from tbladminrightdetails,tbltabdetails where tbladminrightdetails.adminid = '$adminid' and tbladminrightdetails.tabid = '$tabid' and  tbltabdetails.tabid = '$tabid' and tbladminrightdetails.tabdetailid = tbltabdetails.tabdetailid");
if ($query->num_rows() > 0)
{
	$c2 = 1;
	foreach ($query->result_array() as $row2)
	{
		if($row2['ractive'] == 1) {
		 	$stabchecked = 'checked="checked"';
	 	} else {
		 	$stabchecked = '';
	 	}
?>                                     
                                        <ul class="dd-list" data-sortable="true" style="list-style:none">
                                            <li>
                                             	<input name="<?= $c?>bc<?= $c2?>" type="hidden" value="<?= $row2['rdetailid']?>"/>
                                                <div class="checkbox checkbox-styled tile-text">
                                                    <label>
                                                        <input type="checkbox" name="ch<?= $c?>bc<?= $c2?>" <?= $stabchecked?>>
                                                        <span><?= $row2['linktitle']?></span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
 <? $c2++; 
 
	}?> 
    <input type="hidden" name="stc<?= $c?>" value="<?= $c2?>" />
 <?
}?>                                       
                                        
                                    </li>
       <?
$c++;
endforeach;
?>
<input type="hidden" name="tc" value="<?= $c?>" />
                                </ul>
                            </div>
                            
                        </div>

                    </div>
                    <div class="card-actionbar">
						<div class="card-actionbar-row">
							<button type="submit" class="btn ink-reaction btn-primary style-accent">Submit</button>
						</div>
					</div>
                </div>
            </form>
        </div>
    </section>
    
</div>