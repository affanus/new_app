<?php
class Users extends Controller 
{

	function __construct()
	{
		parent::Controller();
		$this->heading_top='Manage';
		$this->title='Users';
		$this->main_content_mange='admin/users/normal_users/normal_users';
		$this->main_content_add='admin/users/normal_users/add';
		$this->main_content_edit='admin/users/normal_users/edit';
		$this->add_title='Add User';
		$this->edit_title='Edit User';
		$this->controler_name='users';
		$this->tablename='users';
		
	}
	function index($row=1)
	{
	
		// store data for being displayed on view file
		$data['headingtop'] = $this->heading_top;
		$data['title'] = $this->title;
		$data['controler_name']=$this->controler_name;
		$data['curpage'] = $row;

		$data['range'] = 5;
		
		$data['trows']=$this->db->count_all($this->tablename);
		
		$perpage = 10;
		
		$data['tpages'] = ceil($this->db->count_all($this->tablename) / $perpage);
		
		
		
		$offset = ($row - 1) * $perpage;
		$data['jsFilesArray'] =  array("libs/DataTables/jquery.dataTables.min.js","libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js","core/demo/DemoTableDynamic.js");
		$data['query']=$this->db->query("SELECT
		users.id,
		users.email,
		users.isactive,
		contacts.fname,
		contacts.title,
		contacts.lname,
		users.created_date,
		contacts.profile_pic
		FROM
		users
		INNER JOIN contacts ON users.id = contacts.user_id
		");

		

		// load 'testview' view

		$data['main_content'] = $this->main_content_mange;
		$data['add_link']=$this->add_title;
		$this->load->view('admin/template', $data); 
	}
	
	function update_status($id, $status){
		
		$data = array('isactive' =>  $status);
		
		$this->db->where('id', $id);
		$this->db->update($this->tablename, $data); 
		redirect('admin/'.$this->controler_name.'/', 'refresh');
	}
	
	function page($row=1){
		if($this->uri->segment(4)!=''){
		$row = $this->uri->segment(4);}
		
		
		
		
		$data['headingtop'] = $this->heading_top;
		$data['title'] = $this->title;
		
		$data['curpage'] = $row;

		$data['range'] = 5;
		
		$data['trows']=$this->db->count_all($this->tablename);
		
		$perpage = 10;
		
		$data['tpages'] = ceil($this->db->count_all($this->tablename) / $perpage);
		
		
		
		$offset = ($row - 1) * $perpage;
		
				
		$data['query']=$this->db->query("SELECT
			users.first_name,
			users.id,
			users.last_name,
			users.gender,
			users.email,
			users.is_active
			FROM
			users  LIMIT ".$offset.", ".$perpage);


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
	
	function get_email_status(){
		if($this->input->post('email')){
			$query=$this->db->query("SELECT id From users where email='".$this->input->post('email')."'");
			if($query->num_rows() == 0) :
				echo "1";
			else:
				echo "0";
			endif;
		}
	}
	
	
	
	function add(){
		$data['controler_name']=$this->controler_name;

		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;
		$data['title'] = $this->add_title;
		$data['errormess'] = '';
		$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
		$data['query_companies']=$this->db->query("SELECT id,title From companies where isactive=1");
		
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/wizard/jquery.bootstrap.wizard.min.js","core/demo/DemoFormWizard.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		
		$data['main_content'] = $this->main_content_add;

		$this->load->view('admin/template', $data);
	}
	
	function add_action(){
		$data['controler_name']=$this->controler_name;
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;

		$data['title'] = $this->add_title;

		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('email', 'Email address', 'trim|required');
		$this->form_validation->set_rules('password1', 'Password', 'trim|required');
		if($this->form_validation->run() == FALSE)

		{
			$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
			$data['query_companies']=$this->db->query("SELECT id,title From companies where isactive=1");
			
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/wizard/jquery.bootstrap.wizard.min.js","core/demo/DemoFormWizard.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
			
			$data['main_content'] = $this->main_content_add;
	
			$this->load->view('admin/template', $data);

		} else {
			$data = array(
				'email' => $this->input->post('email') ,
				'password' => md5($this->input->post('password1')) ,
				'isactive' => 1,
				'remail' => $this->input->post('email'),
				'created_date' => date("Y-m-d")
			);
			$this->db->insert($this->tablename, $data); 
			$user_id = $this->db->insert_id();
			
			$data2 = array(
				'user_id' => $user_id ,
				'title' => $this->input->post('title') ,
				'fname' => addslashes($this->input->post('fname')),
				'lname' => addslashes($this->input->post('lname')),
				'gender' => addslashes($this->input->post('gender')),
				'bday' => addslashes($this->input->post('bday')),
				'email' => addslashes($this->input->post('email')),
				'jobtitle' => addslashes($this->input->post('jobtitle')),
				'department' => addslashes($this->input->post('department')),
				'company_name' => addslashes($this->input->post('company_name')),
				'bphone' => addslashes($this->input->post('bphone')),
				'pphone' => addslashes($this->input->post('pphone')),
				'mphone' => addslashes($this->input->post('mphone')),
				'address' => addslashes($this->input->post('address')),
				'city' => $this->input->post('city'),
				'country' => $this->input->post('country'),
				'state' => addslashes($this->input->post('state')),
				'website' => addslashes($this->input->post('website')),
				'fax' => addslashes($this->input->post('fax')),
				'pobox' => addslashes($this->input->post('pobox')),
				'pmc' => addslashes($this->input->post('pmc')),
				'isactive' => 1,
				'primary' => 1
			);
			
			if($_FILES["profile_pic"]["tmp_name"]!=''):
				$this->load->model('Logo_upload');
				$featuredImage = $this->Logo_upload->do_upload('profile_pic');
				$data2['profile_pic']=$featuredImage;
			endif;
			
			
			$this->db->insert("contacts", $data2); 
			
			$data['errormess'] = '';
			
			redirect('admin/'.$this->controler_name.'/', 'refresh');
		}
	}
	
	function edit($editid){
		$data['controler_name']=$this->controler_name;
		$data['query'] = $this->db->query("SELECT
			users.id,
			users.email,
			users.isactive,
			contacts.fname,
			contacts.title,
			contacts.lname,
			users.`password`,
			contacts.gender,
			contacts.bday,
			contacts.jobtitle,
			contacts.department,
			contacts.company_name,
			contacts.bphone,
			contacts.pphone,
			contacts.mphone,
			contacts.address,
			contacts.city,
			contacts.country,
			contacts.state,
			contacts.fax,
			contacts.pobox,
			contacts.website,
			contacts.pmc,
			contacts.profile_pic
			FROM
			users
			INNER JOIN contacts ON users.id = contacts.user_id
			WHERE
			users.id  = '$editid'");
		$query_event_location = $this->db->query("SELECT
			contacts.country,
			contacts.state
			FROM
			users
			INNER JOIN contacts ON users.id = contacts.user_id
			WHERE
			users.id  = '$editid'");;
		$row_event_location = $query_event_location->row();
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/wizard/jquery.bootstrap.wizard.min.js","core/demo/DemoFormWizard.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		
		$data['query_companies']=$this->db->query("SELECT id,title From companies where isactive=1");
		$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
		$data['query_states']=$this->db->query("SELECT id,title From meta_location where type='RE' and parent_id=".$row_event_location->country);
		$data['query_cities']=$this->db->query("SELECT id,title From meta_location where type='CI' and parent_id=".$row_event_location->state);
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->edit_title;

		$data['title'] = $this->edit_title;

		$data['errormess'] = '';

		$data['main_content'] = $this->main_content_edit;

		$this->load->view('admin/template', $data);
	}
	
	function edit_action($editid) {
		$data['controler_name']=$this->controler_name;
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;

		$data['title'] = $this->add_title;

		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
		if($this->form_validation->run() == FALSE)
		{
			$data['query'] = $this->db->query("SELECT
				users.id,
				users.email,
				users.isactive,
				contacts.fname,
				contacts.title,
				contacts.lname,
				users.`password`,
				contacts.gender,
				contacts.bday,
				contacts.jobtitle,
				contacts.department,
				contacts.company_name,
				contacts.bphone,
				contacts.pphone,
				contacts.mphone,
				contacts.address,
				contacts.city,
				contacts.country,
				contacts.state,
				contacts.fax,
				contacts.pobox,
				contacts.website,
				contacts.pmc,
				contacts.profile_pic
				FROM
				users
				INNER JOIN contacts ON users.id = contacts.user_id
				WHERE
				users.id  = '$editid' and contacts.`primary`='1'");
			$query_event_location = $this->db->query("SELECT
				contacts.country,
				contacts.state
				FROM
				users
				INNER JOIN contacts ON users.id = contacts.user_id
				WHERE
				users.id  = '$editid' and contacts.`primary`='1'");
			$row_event_location = $query_event_location->row();
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/wizard/jquery.bootstrap.wizard.min.js","core/demo/DemoFormWizard.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
			
			$data['query_companies']=$this->db->query("SELECT id,title From companies where isactive=1");
			$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
			$data['query_states']=$this->db->query("SELECT id,title From meta_location where type='RE' and parent_id=".$row_event_location->country);
			$data['query_cities']=$this->db->query("SELECT id,title From meta_location where type='CI' and parent_id=".$row_event_location->state);
			$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->edit_title;
	
			$data['title'] = $this->edit_title;
	
			$data['errormess'] = '';
	
			$data['main_content'] = $this->main_content_edit;
	
			$this->load->view('admin/template', $data);
			$data['errormess'] = '1';
		} else {
			if($this->input->post('password1')!=''):
				$data = array(
					'password' => md5($this->input->post('password1')) ,
				);
				$this->db->where('id', $editid);
	
				$this->db->update($this->tablename, $data); 
			endif;
			
			$data2 = array(
				'title' => $this->input->post('title') ,
				'fname' => addslashes($this->input->post('fname')),
				'lname' => addslashes($this->input->post('lname')),
				'gender' => addslashes($this->input->post('gender')),
				'bday' => addslashes($this->input->post('bday')),
				'jobtitle' => addslashes($this->input->post('jobtitle')),
				'department' => addslashes($this->input->post('department')),
				'company_name' => addslashes($this->input->post('company_name')),
				'bphone' => addslashes($this->input->post('bphone')),
				'pphone' => addslashes($this->input->post('pphone')),
				'mphone' => addslashes($this->input->post('mphone')),
				'address' => addslashes($this->input->post('address')),
				'city' => $this->input->post('city'),
				'country' => $this->input->post('country'),
				'state' => addslashes($this->input->post('state')),
				'website' => addslashes($this->input->post('website')),
				'fax' => addslashes($this->input->post('fax')),
				'pobox' => addslashes($this->input->post('pobox')),
				'pmc' => addslashes($this->input->post('pmc'))
			);
			
			if($_FILES["profile_pic"]["tmp_name"]!=''):
				$this->load->model('Logo_upload');
				$featuredImage = $this->Logo_upload->do_upload('profile_pic');
				$query_profile_pic = $this->db->query("SELECT
				contacts.profile_pic
				FROM
				users
				INNER JOIN contacts ON users.id = contacts.user_id
				WHERE
				users.id  = '$editid' and contacts.`primary`='1'");
				if($query_profile_pic->num_rows() != 0) :
					$query_media = $query_profile_pic->row();
					$folderName='profile_images';
					unlink(realpath(APPPATH . '../../_images/'.$folderName.'/thumb/'.$query_media->path));
					unlink(realpath(APPPATH . '../../_images/'.$folderName.'/orignal/'.$query_media->path));
				endif;
				$data2['profile_pic']=$featuredImage;
			endif;
			
			$this->db->where('user_id', $editid);
			$this->db->where('primary', '1');
			
			$this->db->update("contacts", $data2); 
			redirect('admin/'.$this->controler_name.'/', 'refresh');
		}
	}
	
	function del($editid)

	{   
		$query_profile_pic = $this->db->query("SELECT
				contacts.profile_pic
				FROM
				users
				INNER JOIN contacts ON users.id = contacts.user_id
				WHERE
				users.id  = '$editid' and contacts.`primary`='1'");
		if($query_profile_pic->num_rows() != 0) :
			$query_media = $query_profile_pic->row();
			$folderName='profile_images';
			unlink(realpath(APPPATH . '../../_images/'.$folderName.'/thumb/'.$query_media->profile_pic));
			unlink(realpath(APPPATH . '../../_images/'.$folderName.'/orignal/'.$query_media->profile_pic));
		endif;	
		
		$table = array('contacts');

		$this->db->where('user_id', $editid);

		$this->db->delete($table);	
		
		$table = array($this->tablename);

		$this->db->where('id', $editid);

		$this->db->delete($table);
		
		redirect('admin/'.$this->controler_name.'/', 'refresh');
		
	}

}
