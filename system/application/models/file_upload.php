<?php
class File_upload extends Model {
	
	
	var $upload_path;
	
	function File_upload() {
		parent::Model();
		
		$this->upload_path = realpath(APPPATH . '../../_images/');
		
	}
	
	function do_upload($fieldname,$path) {
		$this->load->library('image_lib');
		if($_FILES[$fieldname]['name']!=''){
		$newimgname=rand().$_FILES[$fieldname]['name'];
		$img_path=$this->upload_path.$path. '/orignal/' . $newimgname;
		move_uploaded_file($_FILES[$fieldname]["tmp_name"],
      $img_path);
	  
	  //echo $img_path."<br/>";
		$config = array(
			'source_image' => $img_path,
			'new_image' => $this->upload_path .$path. '/thumb',
			'maintain_ration' => true,
			'width' => 100,
			'height' => 100
		);
		
		$this->image_lib->initialize($config);
		if ( ! $this->image_lib->resize())
{
    echo $this->image_lib->display_errors();
}
		$this->image_lib->clear();
		unset($config);
		//echo $newimgname."<br/>";
		return $newimgname;
		}
	}
	
	
	
}



