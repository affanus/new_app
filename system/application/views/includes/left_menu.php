			<!-- BEGIN MENUBAR-->
			<div id="menubar" class=" ">
				<div class="menubar-fixed-panel">
					<div>
						<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="expanded">
						<a href="<?=base_url()?>/admin">
							<span class="text-lg text-bold text-primary ">CHYMPS&nbsp;ADMIN</span>
						</a>
					</div>
				</div>
				<div class="menubar-scroll-panel">

					<!-- BEGIN MAIN MENU -->
					<ul id="main-menu" class="gui-controls gui-controls-tree">
	<!-- Menu Getting started -->
    <? $current_method = $this->router->fetch_method(); 
		$current_controller = $this->router->fetch_class(); 
	?>
	<li >
		<a href="<?= base_url();?>users/dashboard" <? if($current_method =='dashboard'):?>class="active"<? endif;?>>
			<div class="gui-icon"><i class="md md-home"></i></div>
			<span class="title">Dashboard</span>
		</a>
		<ul>
		</ul>
	</li>
	<!-- Menu CSS -->
	<li >
		<a href="<?= base_url();?>user/contacts" <? if($current_controller =='contacts'):?>class="active"<? endif;?>>
			<div class="gui-icon"><i class="md md-perm-contact-cal"></i></div>
			<span class="title">Contacts</span>
		</a>
        <a href="<?= base_url();?>user/contacts/add/" class="addnew"><div class="gui-icon"><i class="md md-add"></i></div></a>
		<ul>
		</ul>
	</li>
	<!-- Menu Components -->
	<li>
		<a href="<?= base_url();?>user/aircraft_listings" <? if($current_controller =='aircraft_listings'):?>class="active"<? endif;?>>
			<div class="gui-icon"><i class="md md-airplanemode-on"></i></div>
			<span class="title">Aircraft Listings</span>
		</a>
        <a href="<?= base_url();?>user/aircraft_listings/add/" class="addnew"><div class="gui-icon"><i class="md md-add"></i></div></a>
		<ul>
		</ul>
	</li>
	<!-- Menu Javascript -->
	<li>
        <a href="<?= base_url();?>user/engine_listings" <? if($current_controller =='engine_listings'):?>class="active"<? endif;?>>
			<div class="gui-icon"><i class="md md-blur-circular"></i></div>
			<span class="title">Engine Listings</span>
		</a>
        <a href="<?= base_url();?>user/engine_listings/add/" class="addnew"><div class="gui-icon"><i class="md md-add"></i></div></a>
		<ul>
		</ul>
	</li>
	<!-- Menu Javascript-forms -->
	<li>
        <a href="<?= base_url();?>user/spare_part_listings" <? if($current_controller =='spare_part_listings'):?>class="active"<? endif;?>>
			<div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
			<span class="title">Spare Parts Listings</span>
		</a>
        <a href="<?= base_url();?>user/spare_part_listings/add/" class="addnew"><div class="gui-icon"><i class="md md-add"></i></div></a>
		<ul>
		</ul>
	</li>
    
    <li>

        <a href="<?= base_url();?>user/apu_listings" <? if($current_controller =='apu_listings'):?>class="active"<? endif;?>>
			<div class="gui-icon"><i class="md md-battery-charging-full"></i></div>
			<span class="title">APU Listings</span>
		</a>
        <a href="<?= base_url();?>user/apu_listings/add/" class="addnew"><div class="gui-icon"><i class="md md-add"></i></div></a>
		<ul>
		</ul>
	</li>
      <li>

        <a href="<?= base_url();?>user/wanted_listing" <? if($current_controller =='wanted_listing'):?>class="active"<? endif;?>>
			<div class="gui-icon"><i class="md md-gamepad"></i></div>
			<span class="title">Wanted Listings</span>
		</a>
        <a href="<?= base_url();?>user/wanted_listing/add/" class="addnew"><div class="gui-icon"><i class="md md-add"></i></div></a>
		<ul>
		</ul>
	</li>

</ul><!--end .main-menu -->
					<!-- END MAIN MENU -->

					<div class="menubar-foot-panel">
						<small class="no-linebreak hidden-folded">
							<span class="opacity-75">Copyright &copy; 2015</span> <strong>CHYMPS</strong>
						</small>
					</div>
				</div><!--end .menubar-scroll-panel-->
			</div><!--end #menubar-->
			<!-- END MENUBAR -->