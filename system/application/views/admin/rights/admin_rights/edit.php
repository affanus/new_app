<link type="text/css" rel="stylesheet" href="<?php echo base_url();?>assets/css/theme-5/nestable/nestable.css" />
<div id="content">
	<section class="style-default-bright">
    	<div class="section-header" style="position: relative;">
			<h2 class="text-primary"></h2>
		</div>
        <div class="section-body">
 <? 
				$attributes = array('name' => 'form1','class' => 'form floating-label form-validate');
				echo form_open_multipart('admin/admin_rights/edit_/'.$adminid, $attributes);?>
            <?
	$row = $query->row();	
	?>
            	<div class="card">
					<div class="card-head style-accent">
						<header>Edit Admin User > <?= stripslashes($row->fname.' '.$row->lname);?></header>
					</div>
					<div class="card-body floating-label ">
                    	<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="adminid" id="adminid" required value="<?= stripslashes($row->adminid)?>" readonly>
									<label for="adminid">Username</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input type="password" class="form-control" name="password" id="password" >
									<label for="password">Password</label>                   
								</div>
							</div>
                            <div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="email" id="email" required value="<?= stripslashes($row->email)?>">
									<label for="email">Email</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="fname" id="fname" required value="<?= stripslashes($row->fname)?>">
									<label for="fname">First Name</label>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input type="text" class="form-control" name="lname" id="lname" required value="<?= stripslashes($row->lname)?>">
									<label for="lname">Last Name</label>
								</div>
							</div>
                            <div class="col-lg-4">
                            	<div class="col-lg-2">
                                	<img class="img-circle width-1" src="<?=base_url()?>/_images/profile_images/thumb/<?=stripslashes($row->image)?>" alt="">
                                    <input name="ppold" type="hidden" value="<?=stripslashes($row->image)?>"/>
                                </div>
                                <div class="col-lg-10">
                                	<div class="form-group">
										<input name="profilepic" type="file" id="profilepic" />
									</div>
                                </div>

							</div>
						</div>
                        <div class="row">
                            <div class="col-lg-4">
                            	<div >
    								<label class="radio-inline radio-styled">
                                    	<input type="radio" name="isactive" value="1"  <? if($row->isactive == '1') { ?>checked<? } ?>><span>Active</span>
                                    </label>
                                    <label class="radio-inline radio-styled">
                                    	<input type="radio" name="isactive" value="0" <? if($row->isactive == '0') { ?>checked<? } ?>><span>Inactive</span>
                                	</label>
                            	</div>
                        	</div>
                        </div>
                    	<div class="row">
                        	<div class="col-lg-12">                   	
                                <h2 style="border-bottom: 1px solid rgba(150, 156, 156, 0.4);" class="text-accent-dark">Admin Rights</h2>
                                <ul class="dd-list" data-sortable="true" style="list-style:none">
                                
                                 <?
   $c = 1;
   $c2 = 0;
    
	 foreach($query_rights->result() as $row): 
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