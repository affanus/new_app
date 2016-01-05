<?

class Events extends Controller 
{
	
	var $heading_top;
	var $title;
	var $main_content_mange;
	var $main_content_add;
	var $main_content_edit;
	var $add_title;
	var $edit_title;
	var $controler_name;
	var $tablename;
	
	
	function __construct()
	{
		parent::Controller();
		$this->heading_top='Manage';
		$this->title='Manage Events';
		$this->main_content_mange='admin/manage/events/mange';
		$this->main_content_add='admin/manage/events/add';
		$this->main_content_edit='admin/manage/events/edit';
		$this->add_title='Add An Event';
		$this->edit_title='Edit Event';
		$this->controler_name='events';
		$this->tablename='events';
		
	}
	function index($row=1)
	{
	
		// store data for being displayed on view file
		$data['headingtop'] = $this->heading_top;
		$data['title'] = $this->title;
		$data['controler_name']=$this->controler_name;
		$data['curpage'] = $row;

		$data['range'] = 50;
		
		$data['trows']=$this->db->count_all($this->tablename);
		
		$perpage = 500;
		
		$data['tpages'] = ceil($this->db->count_all($this->tablename) / $perpage);
		
		
		
		$offset = ($row - 1) * $perpage;
		
		$data['query']=$this->db->query("SELECT * From ".$this->tablename);

		

		$data['jsFilesArray'] =  array("libs/DataTables/jquery.dataTables.min.js","libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js","core/demo/DemoTableDynamic.js");

		$data['main_content'] = $this->main_content_mange;
		$data['add_link']=$this->add_title;
		$this->load->view('admin/template', $data); 
	}
	
	
	function page($row=1){
		if($this->uri->segment(4)!=''){
		$row = $this->uri->segment(4);}
		
		
		
		
		$data['headingtop'] = $this->heading_top;
		$data['title'] = $this->title;
		
		$data['curpage'] = $row;

		$data['range'] = 50;
		
		$data['trows']=$this->db->count_all($this->tablename);
		
		$perpage = 50;
		
		$data['tpages'] = ceil($this->db->count_all($this->tablename) / $perpage);
		
		
		
		$offset = ($row - 1) * $perpage;
		
		$data['query']=$this->db->query("SELECT * From ".$this->tablename."  LIMIT ".$offset.", ".$perpage);



		// load 'testview' view

		$data['main_content'] = $this->main_content_mange;
		$data['add_link']=$this->add_title;
		$data['controler_name']=$this->controler_name;
		$this->load->view('admin/template', $data); 
	
	}
	function get_options(){
		if($this->input->post('editid') && $this->input->post('level')){
			$query=$this->db->query("SELECT id,title From meta_location where type='".$this->input->post('level')."' and parent_id=".$this->input->post('editid'));
			if($this->input->post('level')=='RE'):
				$select_id='state';
				$select_title='Event State';
			else:
				$select_id='city';
				$select_title='Event City';
			endif;	
			if($query->num_rows() != 0) :
				echo '<select class="form-control" required id="'.$select_id.'" name="'.$select_id.'" >';
				echo '<option value=""></option>';
				foreach($query->result() as $row):
					echo '<option value="'.$row->id.'">'.stripslashes($row->title).'</option>';
				endforeach;
				echo '</select><label for="'.$select_id.'">'.$select_title.'</label>';
			endif;
		}
	}

	function add()

	{   
		$data['controler_name']=$this->controler_name;

		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;
		$data['title'] = $this->add_title;
		$data['errormess'] = '';
		$data['query_air_cat']=$this->db->query("SELECT id,title From event_cat");
		$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
		
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		
		$data['main_content'] = $this->main_content_add;

		$this->load->view('admin/template', $data);

	}
	
	
	function add_action()

	{   
		$data['controler_name']=$this->controler_name;
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;

		$data['title'] = $this->add_title;

		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		

		if($this->form_validation->run() == FALSE)

		{

			$data['errormess'] = '1';
			$data['main_content'] = $this->main_content_add;
			$data['query_air_cat']=$this->db->query("SELECT id,title From engine_cat");
			$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
			
			$this->load->view('admin/template', $data);

		} else {
			
			$data = array(
				'title' => addslashes($this->input->post('title')) ,
				'isactive' => $this->input->post('isactive') ,
				'details' => addslashes($this->input->post('editor1')),
				'e_date' => addslashes($this->input->post('e_date')),
				'address' => addslashes($this->input->post('address')),
				'city' => addslashes($this->input->post('city')),
				'country' => addslashes($this->input->post('country')),
				'sponsor' => addslashes($this->input->post('sponsor')),
				'state' => addslashes($this->input->post('state'))
			);
			
			$this->db->insert($this->tablename, $data); 
			
			$inid = $this->db->insert_id();
			
			
			foreach ($_POST['event_cat'] as $event_cat):
				$data2 = array(
					'event_id' => $inid ,
					'cat_id' => $event_cat ,
				);
				$this->db->insert('event_cat_link', $data2); 
			endforeach;
			
			if($_FILES["featuredImage"]["tmp_name"]!=''):
				$this->load->model('Logo_upload');
				$featuredImage = $this->Logo_upload->do_upload('featuredImage');
				$data3 = array(
					'belogs_to_id' => $inid ,
					'belogs_to_type' => 'events',
					'type' => 'featuredImage',
					'path' => $featuredImage ,
				);
				$this->db->insert('media', $data3);
				
			endif;
			
			if(isset($_FILES["galleryImage"]) && $_FILES["galleryImage"]["tmp_name"][0]!=''):
				
				$this->load->model('Media_image');
				$galleryImages = $this->Media_image->do_upload('galleryImage',400,400);
				foreach($galleryImages as $galleryImg):
					$data4 = array(
						'belogs_to_id' => $inid ,
						'belogs_to_type' => 'events',
						'type' => 'galleryImage',
						'path' => $galleryImg
					);
					$this->db->insert('media', $data4);
				endforeach;

			endif;


			$data['errormess'] = '';
	

		
			
			
			
			
			
			redirect('admin/'.$this->controler_name.'/', 'refresh');
		}

		



	}
	
	function del_gal() {
		$editid	= $this->input->post('editid');
		$query = $this->db->query("Select path,type  From media WHERE id = '$editid' and belogs_to_type = 'events'");
		if($query->num_rows() != 0) :
			$query_media = $query->row();
			$folderName='media_images';
			unlink(realpath(APPPATH . '../../_images/'.$folderName.'/thumb/'.$query_media->path));
			unlink(realpath(APPPATH . '../../_images/'.$folderName.'/orignal/'.$query_media->path));
		endif;
		$table = array('media');

		$this->db->where('id', $editid);

		$this->db->delete($table);
	}
	
	
	
	function del($editid)

	{   
	
		
		$table = array($this->tablename);

		$this->db->where('id', $editid);

		$this->db->delete($table);

		$table = array('event_cat_link');

		$this->db->where('event_id', $editid);

		$this->db->delete($table);
		
		$query = $this->db->query("Select path,type  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'events'");
		
		if($query->num_rows() != 0) :
		
			foreach($query->result() as $row):
				if($row->type=='featuredImage'):
					$folderName='profile_images';
				else:
					$folderName='media_images';
				endif;
				unlink(realpath(APPPATH . '../../_images/'.$folderName.'/thumb/'.$row->path));
				unlink(realpath(APPPATH . '../../_images/'.$folderName.'/orignal/'.$row->path));
			endforeach;
		
		endif;
		
		$table = array('media');

		$this->db->where('belogs_to_id', $editid);
		$this->db->where('belogs_to_type', 'events');

		$this->db->delete($table);

		redirect('admin/'.$this->controler_name.'/', 'refresh');

	}
	
	function update_status($id, $status){
		
		$data = array('isactive' =>  $status);
		
		$this->db->where('id', $id);
		$this->db->update($this->tablename, $data); 
		redirect('admin/'.$this->controler_name.'/', 'refresh');
	}
	
	
	
	function edit($editid)

	{   
		$data['controler_name']=$this->controler_name;
		$data['query'] = $this->db->query("Select * From ".$this->tablename." WHERE id = '$editid'");
		//$query_event_location = $this->db->query("Select country,state From ".$this->tablename." WHERE id = '$editid'");;
		//$row_event_location = $query_event_location->row();
		
		$data['query_air_cat']=$this->db->query("SELECT id,title From event_cat");
		//$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
		//$data['query_states']=$this->db->query("SELECT id,title From meta_location where type='RE' and parent_id=".$row_event_location->country);
		//$data['query_cities']=$this->db->query("SELECT id,title From meta_location where type='CI' and parent_id=".$row_event_location->state);
		$data['query_air_man_cat_link']=$this->db->query("SELECT * From event_cat_link where event_id = '$editid'");
		$data['query_media_gallery'] = $this->db->query("Select path,id  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'events' and type!='featuredImage'");
		$data['query_media_featuredImage'] = $this->db->query("Select path  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'events' and type='featuredImage'");
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->edit_title;

		$data['title'] = $this->edit_title;

		$data['errormess'] = '';

		$data['main_content'] = $this->main_content_edit;

		$this->load->view('admin/template', $data);

	}
	
	
	
	function edit_action($editid)

	{   
		$data['controler_name']=$this->controler_name;
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->edit_title;

		$data['title'] = $this->edit_title;
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required');

		// field name, error message, validation rules


		if($this->form_validation->run() == FALSE)

		{
	
			$data['errormess'] = '1';
			$data['controler_name']=$this->controler_name;
			$data['query'] = $this->db->query("Select * From ".$this->tablename." WHERE id = '$editid'");
			$query_event_location = $this->db->query("Select country,state From ".$this->tablename." WHERE id = '$editid'");;
			$row_event_location = $query_event_location->row();
			
			$data['query_air_cat']=$this->db->query("SELECT id,title From event_cat");
			$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
			$data['query_states']=$this->db->query("SELECT id,title From meta_location where type='RE' and parent_id=".$row_event_location->country);
			$data['query_cities']=$this->db->query("SELECT id,title From meta_location where type='CI' and parent_id=".$row_event_location->state);
			$data['query_air_man_cat_link']=$this->db->query("SELECT * From event_cat_link where event_id = '$editid'");
			$data['query_media_gallery'] = $this->db->query("Select path,id  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'events' and type!='featuredImage'");
			$data['query_media_featuredImage'] = $this->db->query("Select path  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'events' and type='featuredImage'");
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
			$data['main_content'] = $this->main_content_edit;
	
			$this->load->view('admin/template', $data);

		} else {

		$data['errormess'] = '';

		$data = array(
				'title' => addslashes($this->input->post('title')) ,
				'isactive' => '1' ,
				'details' => addslashes($this->input->post('editor1')),
				'e_date' => addslashes($this->input->post('e_date')),
				'address' => addslashes($this->input->post('address')),
				'city' => addslashes($this->input->post('city')),
				'country' => addslashes($this->input->post('country')),
				'sponsor' => addslashes($this->input->post('sponsor')),
				'state' => addslashes($this->input->post('state'))
		);
	
		

		$this->db->where('id', $editid);

		$this->db->update($this->tablename, $data); 
		
		$table = array('event_cat_link');

		$this->db->where('event_id', $editid);

		$this->db->delete($table);
		
		foreach ($_POST['air_cat'] as $air_cats):
			$data2 = array(
				'event_id' => $editid ,
				'cat_id' => $air_cats ,
			);
			$this->db->insert('event_cat_link', $data2); 
		endforeach;
		
		if($_FILES["featuredImage"]["tmp_name"]!=''):
				$this->load->model('Logo_upload');
				$featuredImage = $this->Logo_upload->do_upload('featuredImage');
				$data3 = array(
					'belogs_to_id' => $editid ,
					'belogs_to_type' => 'events',
					'type' => 'featuredImage',
					'path' => $featuredImage ,
				);
				$this->db->insert('media', $data3);
				
			endif;
			
			if(isset($_FILES["galleryImage"]) && $_FILES["galleryImage"]["tmp_name"][0]!=''):
				
				$this->load->model('Media_image');
				$galleryImages = $this->Media_image->do_upload('galleryImage',400,400);
				foreach($galleryImages as $galleryImg):
					echo $galleryImg;
					$data4 = array(
						'belogs_to_id' => $editid ,
						'belogs_to_type' => 'events',
						'type' => 'galleryImage',
						'path' => $galleryImg
					);
					$this->db->insert('media', $data4);
				endforeach;
			endif;
		
		
		redirect('admin/'.$this->controler_name.'/', 'refresh');

		}

	}

	


}	


?>