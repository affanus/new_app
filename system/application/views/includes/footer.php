

		<!-- BEGIN JAVASCRIPT -->

		<script src="<?=base_url()?>assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="<?=base_url()?>assets/js/libs/spin.js/spin.min.js"></script>
		<script src="<?=base_url()?>assets/js/libs/autosize/jquery.autosize.min.js"></script>        
		<script src="<?=base_url()?>assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
        <script src="<?=base_url()?>assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="<?=base_url()?>assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
        <script src="<?=base_url()?>assets/js/libs/summernote/summernote.min.js"></script>
		<script src="<?=base_url()?>assets/js/core/source/App.js"></script>
		<script src="<?=base_url()?>assets/js/core/source/AppNavigation.js"></script>
		<script src="<?=base_url()?>assets/js/core/source/AppOffcanvas.js"></script>
		<script src="<?=base_url()?>assets/js/core/source/AppCard.js"></script>
		<script src="<?=base_url()?>assets/js/core/source/AppForm.js"></script>
		<script src="<?=base_url()?>assets/js/core/source/AppNavSearch.js"></script>
		<script src="<?=base_url()?>assets/js/core/source/AppVendor.js"></script>
		<? if (isset($jsFilesArray) && count($jsFilesArray)>0):
			foreach ($jsFilesArray as $file_path):
		?>
 		<script src="<?=base_url()?>assets/js/<?=$file_path?>"></script>
		<? endforeach;	
		endif; ?>
        
		<script src="<?=base_url()?>assets/js/core/demo/Demo.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
</html>