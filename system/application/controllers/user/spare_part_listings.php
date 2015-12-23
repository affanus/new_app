<?

class Spare_part_listings extends Controller 
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
		$this->heading_top='Your Listed';
		$this->title='Spare Parts';
		$this->main_content_mange='users/spare_parts/manage';
		$this->main_content_add='users/spare_parts/add';
		$this->main_content_edit='users/spare_parts/edit';
		$this->add_title='Add Spare Part';
		$this->edit_title='Edit Spare Part';
		$this->controler_name='spare_part_listings';
		$this->tablename='spare_part';
		$this->template='includes/user_template';
		if(!$this->session->userdata('user_id')):
			redirect(base_url().'users/login');
		endif;
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
		
		$data['query']=$this->db->query("SELECT
			listings.id,
			listings.created_date,
			listings.isactive,
			spare_part.title,
			spare_part.p_number,
			spare_part.nsn,
			contacts.fname,
			contacts.lname,
			media.path
			FROM
			listings
			INNER JOIN spare_part ON listings.ref_id = spare_part.id
			INNER JOIN contacts ON spare_part.contact_info = contacts.id
			INNER JOIN media ON spare_part.id = media.belogs_to_id
			WHERE
			listings.type = 3 AND
			media.type = 'featuredImage' AND
			media.belogs_to_type = 'spare_part' AND
			spare_part.listed_by='".$this->session->userdata('user_id')."'");

		

		$data['jsFilesArray'] =  array("libs/DataTables/jquery.dataTables.min.js","libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js","core/demo/DemoTableDynamic.js");

		$data['main_content'] = $this->main_content_mange;
		$data['add_link']=$this->add_title;
		$this->load->view($this->template, $data); 
	}
	
	
	
	function get_options(){
		if($this->input->post('editid') && $this->input->post('level')){
			$query=$this->db->query("SELECT id,title From meta_location where type='".$this->input->post('level')."' and parent_id=".$this->input->post('editid'));
			if($this->input->post('level')=='RE'):
				$select_id='state';
				$select_title='State';
			else:
				$select_id='city';
				$select_title='City';
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
	
	function get_options_contacts(){
		if($this->input->post('editid') && $this->input->post('level')){
			$query=$this->db->query("SELECT id,title From meta_location where type='".$this->input->post('level')."' and parent_id=".$this->input->post('editid'));
			if($this->input->post('level')=='RE'):
				$select_id='state_contacts';
				$select_title='State';
			else:
				$select_id='city_contacts';
				$select_title='City';
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
		$data['query_condition_set']=$this->db->query("SELECT id,title From condition_set");
		$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
		$data['query_companies']=$this->db->query("SELECT id,title From companies where isactive=1");
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		
		$data['main_content'] = $this->main_content_add;

		$this->load->view($this->template, $data);

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
			$data['query_condition_set']=$this->db->query("SELECT id,title From condition_set");
			$data['query_contacts']=$this->db->query("SELECT id,fname,lname,email From contacts where isactive=1");
			$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
			
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
			
			$this->load->view($this->template, $data);

		} else {
			$user_id = $this->session->userdata('user_id');
			$data = array(
				'listed_by' => $user_id ,
				'title' => addslashes($this->input->post('title')) ,
				'isactive' => $this->input->post('isactive') ,
				'details' => addslashes($this->input->post('editor1')),
				'p_number' => addslashes($this->input->post('p_number')),
				'nsn' => addslashes($this->input->post('nsn')),
				'condition' => addslashes($this->input->post('condition')),
				'quantity' => addslashes($this->input->post('quantity')),
				'release' => addslashes($this->input->post('release')),
				'trace' => addslashes($this->input->post('trace')),
				'tag_date' => addslashes($this->input->post('tag_date')),
				'city' => addslashes($this->input->post('city')),
				'state' => addslashes($this->input->post('state')),
				'country' => addslashes($this->input->post('country')),
				'app_to' => addslashes($this->input->post('app_to')),
				'uprice' => addslashes($this->input->post('uprice')),
				'contact_info' => addslashes($this->input->post('contact_info'))
			);
			
			$this->db->insert($this->tablename, $data); 
			
			$inid = $this->db->insert_id();
			
			
			if($_FILES["featuredImage"]["tmp_name"]!=''):
				$this->load->model('Logo_upload');
				$featuredImage = $this->Logo_upload->do_upload('featuredImage');
				$data3 = array(
					'belogs_to_id' => $inid ,
					'belogs_to_type' => 'spare_part',
					'type' => 'featuredImage',
					'path' => $featuredImage ,
				);
				$this->db->insert('media', $data3);
				
			endif;
			
			if(isset($_FILES["galleryImage"]) && $_FILES["galleryImage"]["tmp_name"][0]!=''):
				
				$this->load->model('Media_image');
				$galleryImages = $this->Media_image->do_upload('galleryImage',400,400);
				print_r($galleryImages);
				foreach($galleryImages as $galleryImg):
					echo $galleryImg;
					$data4 = array(
						'belogs_to_id' => $inid ,
						'belogs_to_type' => 'spare_part',
						'type' => 'galleryImage',
						'path' => $galleryImg
					);
					$this->db->insert('media', $data4);
				endforeach;

			endif;

			$data5 = array(
						'type' => 3 ,
						'keywords' => $keywords,
						'created_date' => date("Y-m-d"),
						'ref_id' => $inid,
						'isactive' => 1
					);
			$this->db->insert('listings', $data5);
			
			$data['errormess'] = '';
	

		
			
			
			
			
			
			redirect('admin/'.$this->controler_name.'/', 'refresh');
		}

		



	}
	
	function del_gal() {
		$editid	= $this->input->post('editid');
		$query = $this->db->query("Select path,type  From media WHERE id = '$editid' and belogs_to_type = 'spare_part'");
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

		
		$query = $this->db->query("Select path,type  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'spare_part'");
		
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
		$this->db->where('belogs_to_type', 'spare_part');

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
		$query_event_location = $this->db->query("Select country,state From ".$this->tablename." WHERE id = '$editid'");;
		$row_event_location = $query_event_location->row();
		
		$data['query_condition_set']=$this->db->query("SELECT id,title From condition_set");
		$data['query_contacts']=$this->db->query("SELECT id,fname,lname,email From contacts where isactive=1");
		$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
		$data['query_states']=$this->db->query("SELECT id,title From meta_location where type='RE' and parent_id=".$row_event_location->country);
		$data['query_cities']=$this->db->query("SELECT id,title From meta_location where type='CI' and parent_id=".$row_event_location->state);

		$data['query_media_gallery'] = $this->db->query("Select path,id  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'spare_part' and type!='featuredImage'");
		$data['query_media_featuredImage'] = $this->db->query("Select path  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'spare_part' and type='featuredImage'");
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->edit_title;

		$data['title'] = $this->edit_title;

		$data['errormess'] = '';

		$data['main_content'] = $this->main_content_edit;

		$this->load->view($this->template, $data);

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
			
			$data['query_condition_set']=$this->db->query("SELECT id,title From condition_set");
			$data['query_contacts']=$this->db->query("SELECT id,fname,lname,email From contacts where isactive=1");
			$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
			$data['query_states']=$this->db->query("SELECT id,title From meta_location where type='RE' and parent_id=".$row_event_location->country);
			$data['query_cities']=$this->db->query("SELECT id,title From meta_location where type='CI' and parent_id=".$row_event_location->state);
	
			$data['query_media_gallery'] = $this->db->query("Select path,id  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'spare_part' and type!='featuredImage'");
			$data['query_media_featuredImage'] = $this->db->query("Select path  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'spare_part' and type='featuredImage'");
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
			$data['main_content'] = $this->main_content_edit;
	
			$this->load->view($this->template, $data);

		} else {

		$data['errormess'] = '';

		$data = array(
				'title' => addslashes($this->input->post('title')) ,
				'isactive' => $this->input->post('isactive') ,
				'details' => addslashes($this->input->post('editor1')),
				'p_number' => addslashes($this->input->post('p_number')),
				'nsn' => addslashes($this->input->post('nsn')),
				'condition' => addslashes($this->input->post('condition')),
				'quantity' => addslashes($this->input->post('quantity')),
				'release' => addslashes($this->input->post('release')),
				'trace' => addslashes($this->input->post('trace')),
				'tag_date' => addslashes($this->input->post('tag_date')),
				'city' => addslashes($this->input->post('city')),
				'state' => addslashes($this->input->post('state')),
				'country' => addslashes($this->input->post('country')),
				'app_to' => addslashes($this->input->post('app_to')),
				'uprice' => addslashes($this->input->post('uprice')),
				'contact_info' => addslashes($this->input->post('contact_info'))
			);
	
		

		$this->db->where('id', $editid);

		$this->db->update($this->tablename, $data); 
		
		
		if($_FILES["featuredImage"]["tmp_name"]!=''):
				$query_media_featuredImage=$this->db->query("Select path  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'spare_part' and type='featuredImage'");
				if($query_media_featuredImage->num_rows() != 0) :
					$query_media = $query_media_featuredImage->row();
					$folderName='profile_images';
					unlink(realpath(APPPATH . '../../_images/'.$folderName.'/thumb/'.$query_media->path));
					unlink(realpath(APPPATH . '../../_images/'.$folderName.'/orignal/'.$query_media->path));
				endif;	
				$this->load->model('Logo_upload');
				$featuredImage = $this->Logo_upload->do_upload('featuredImage');
				$data3 = array(
					'belogs_to_id' => $editid ,
					'belogs_to_type' => 'spare_part',
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
						'belogs_to_type' => 'spare_part',
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