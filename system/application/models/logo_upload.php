<?php
class Logo_upload extends Model {
	
	
	var $upload_path;
	
	function Logo_upload() {
		parent::Model();
		
		$this->upload_path = realpath(APPPATH . '../../_images/profile_images');
		
	}
	
	function do_upload($fieldname) {
		
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->upload_path. '/orignal',
			'max_size' => 500000
		);
		
		$this->load->library('upload', $config);
		$this->upload->do_upload($fieldname);
		$image_data = $this->upload->data();
	
		$config = array(
			'source_image' => $image_data['full_path'],
			'new_image' => $this->upload_path . '/thumb',
			'maintain_ration' => true,
			'width' => 400,
			'height' => 400
		);
		
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
		$img =$image_data['file_name'];
		$this->image_lib->clear();
		return $img;
	}
	
	
	
}



