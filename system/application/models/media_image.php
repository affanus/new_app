<?php
class Media_image extends Model {
	
	
	var $upload_path_media;
	
	function Media_image() {
		parent::Model();
		
		$this->upload_path_media = realpath(APPPATH . '../../_images/media_images');
		
	}
	
	function do_upload($fieldname,$width,$height) {
		
		$config = array(
			'allowed_types' => 'jpg|jpeg|gif|png',
			'upload_path' => $this->upload_path_media. '/orignal',
			'max_size' => 500000
		);
		$this->load->library('upload');
		$this->upload->initialize($config);
		$this->load->library('multi_upload');
		$images_data = $this->multi_upload->go_upload($fieldname);
		echo $this->upload->display_errors();
print_r($images_data);
		$imgs = array();
		foreach ($images_data as $image_data):
			$config = array(
				'source_image' => $image_data['file'],
				'new_image' => $this->upload_path_media . '/thumb',
				'maintain_ration' => true,
				'width' => $width,
				'height' => $height
			);
			
			$this->load->library('image_lib');
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$imgs[] = $image_data['name'];
		endforeach;	
		$this->image_lib->clear();
		print_r($imgs);
		return $imgs;
	}
	
	
	
}



