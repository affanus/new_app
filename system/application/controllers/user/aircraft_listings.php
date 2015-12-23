<?php
class Aircraft_listings extends Controller 
{

	function __construct()
	{
		parent::Controller();
		$this->heading_top='Your Listed';
		$this->title='Aircraft';
		$this->main_content_mange='users/aircraft/manage';
		$this->main_content_add='users/aircraft/add';
		$this->main_content_edit='users/aircraft/edit';
		$this->add_title='Add Aircraft Listing';
		$this->edit_title='Edit Aircraft Listing';
		$this->controler_name='aircraft_listings';
		$this->tablename='aircraft';
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

		$data['range'] = 5;
		
		$data['trows']=$this->db->count_all($this->tablename);
		
		$perpage = 10;
		
		$data['tpages'] = ceil($this->db->count_all($this->tablename) / $perpage);
		
		
		
		$offset = ($row - 1) * $perpage;
		$data['jsFilesArray'] =  array("libs/DataTables/jquery.dataTables.min.js","libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js","core/demo/DemoTableDynamic.js");
		$data['query']=$this->db->query("SELECT
		listings.id,
		listings.created_date,
		aircraft.msn,
		listings.isactive,
		aircraft_manufacturer.title AS man_title,
		aircraft_model.title AS model_title,
		aircraft_type.title AS type_title,
		contacts.title,
		contacts.fname,
		contacts.lname,
		media.path
		FROM
		listings
		INNER JOIN aircraft ON listings.ref_id = aircraft.id
		INNER JOIN aircraft_manufacturer ON aircraft.man_id = aircraft_manufacturer.id
		INNER JOIN aircraft_model ON aircraft.model_id = aircraft_model.id
		INNER JOIN aircraft_type ON aircraft.type_id = aircraft_type.id
		INNER JOIN contacts ON aircraft.primary_contact = contacts.id
		INNER JOIN media ON aircraft.id = media.belogs_to_id
		WHERE
		listings.type = 1 AND
		media.belogs_to_type = 'aircraft' AND
		media.type = 'featuredImage' AND
		aircraft.listed_by = '".$this->session->userdata('user_id')."'");

		

		// load 'testview' view

		$data['main_content'] = $this->main_content_mange;
		$data['add_link']=$this->add_title;
		$this->load->view($this->template, $data); 
	}
	
	function update_status($id, $status){
		
		$data = array('isactive' =>  $status);
		
		$this->db->where('id', $id);
		$this->db->update('listings', $data); 
		redirect('user/'.$this->controler_name.'/', 'refresh');
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
	
	function load_aircraft_options(){
		if($this->input->post('editid') && $this->input->post('type')){
			if($this->input->post('type')=='man'):
				$query=$this->db->query("SELECT
					aircraft_manufacturer.title,
					aircraft_manufacturer.id
					FROM
					air_man_cat_link
					INNER JOIN aircraft_manufacturer ON air_man_cat_link.man_id = aircraft_manufacturer.id
					WHERE
					air_man_cat_link.cat_id = '".$this->input->post('editid')."' AND
					aircraft_manufacturer.isactive = 1");
				if($query->num_rows() != 0) :
					echo '<select class="form-control" id="man_id" name="man_id" required><option value=""></option>';
					foreach($query->result() as $row):
						echo '<option value="'.$row->id.'">'.stripslashes($row->title).'</option>';
					endforeach;
					echo '</select><label for="man_id" class="control-label">Aircraft Manufacturer</label>';
				endif;
			elseif($this->input->post('type')=='airtype'):
				$query=$this->db->query("SELECT id,title From aircraft_type where isactive = 1 and man_id=".$this->input->post('editid'));
				if($query->num_rows() != 0) :
					echo '<select class="form-control" id="type_id" name="type_id" required><option value=""></option>';
					foreach($query->result() as $row):
						echo '<option value="'.$row->id.'">'.stripslashes($row->title).'</option>';
					endforeach;
					echo '</select><label for="type_id" class="control-label">Aircraft Type</label>';
				endif;
				
			elseif($this->input->post('type')=='model'):
				$query=$this->db->query("SELECT id,title From aircraft_model where isactive = 1 and type_id=".$this->input->post('editid'));
				if($query->num_rows() != 0) :
					echo '<select class="form-control" id="model_id" name="model_id" required><option value=""></option>';
					foreach($query->result() as $row):
						echo '<option value="'.$row->id.'">'.stripslashes($row->title).'</option>';
					endforeach;
					echo '</select><label for="model_id" class="control-label">Aircraft Model</label>';
				endif;
			elseif($this->input->post('type')=='etype'):
				$query=$this->db->query("SELECT id,title From engine_type where isactive = 1 and man_id=".$this->input->post('editid'));
				if($query->num_rows() != 0) :
					echo '<select class="form-control" id="e_type_id" name="e_type_id" required><option value=""></option>';
					foreach($query->result() as $row):
						echo '<option value="'.$row->id.'">'.stripslashes($row->title).'</option>';
					endforeach;
					echo '</select><label for="e_type_id" class="control-label">Engine Type</label>';
				endif;
				
			elseif($this->input->post('type')=='emodel'):
				$query=$this->db->query("SELECT id,title From engine_model where isactive = 1 and type_id=".$this->input->post('editid'));
				if($query->num_rows() != 0) :
					echo '<select class="form-control" id="e_model_id" name="e_model_id" required><option value=""></option>';
					foreach($query->result() as $row):
						echo '<option value="'.$row->id.'">'.stripslashes($row->title).'</option>';
					endforeach;
					echo '</select><label for="e_model_id" class="control-label">Engine Model</label>';
				endif;	
						
			endif;
		}
	}
	
	function load_airports(){
		if($this->input->post('term')){
			$airports=array();
			$query=$this->db->query("SELECT
			airports.id,
			airports.title,
			airports.city,
			airports.country,
			airports.iata
			FROM
			airports
			WHERE
			airports.title LIKE '%".$this->input->post('term')."%' OR
			airports.city LIKE '%".$this->input->post('term')."%' OR
			airports.country LIKE '%".$this->input->post('term')."%' OR
			airports.iata LIKE '%".$this->input->post('term')."%'");
			if($query->num_rows() != 0) :
				foreach($query->result() as $row):
					$airports[]=array("id"=>$row->id,"completeName"=>$row->title." ".$row->city.", ".$row->country.", ".$row->iata,'slug'=>$row->iata);
				endforeach;
			endif;	
			echo json_encode($airports);
		}
	}
	
	function get_contacts(){
		if($this->input->post('term')){
			$airports=array();
			$query=$this->db->query("SELECT
			contacts.id,
			contacts.title,
			contacts.fname,
			contacts.lname,
			contacts.email
			FROM
			contacts
			WHERE
			contacts.user_id = '".$this->session->userdata('user_id')."' AND
			contacts.isactive = '1' AND
			(contacts.fname LIKE '%".$this->input->post('term')."%' OR
			contacts.lname LIKE '%".$this->input->post('term')."%' OR
			contacts.email LIKE '%".$this->input->post('term')."%')");
			if($query->num_rows() != 0) :
				foreach($query->result() as $row):
					$airports[]=array("id"=>$row->id,"completeName"=>$row->title." ".$row->fname." ".$row->lname.", ".$row->email);
				endforeach;
			endif;	
			echo json_encode($airports);
		}
	}
	
	function addContact(){
		if($this->input->post('fname') && $this->input->post('lname') && $this->input->post('email') && $this->input->post('pmc')){
			$user_id = $this->session->userdata('user_id');
			$data2 = array(
				'user_id' => $user_id ,
				'title' => $this->input->post('title') ,
				'fname' => addslashes($this->input->post('fname')),
				'lname' => addslashes($this->input->post('lname')),
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
				'isactive' => 1
			);
			
			$this->db->insert("contacts", $data2); 
			echo 'true';
		}
	}
	
	function add(){
		$data['controler_name']=$this->controler_name;

		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;
		$data['title'] = $this->add_title;
		$data['errormess'] = '';
		$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
		$data['query_aircat']=$this->db->query("SELECT id,title From aircraft_cat where isactive=1");
		$data['query_e_man']=$this->db->query("SELECT id,title From engine_man where isactive=1");
		$data['query_companies']=$this->db->query("SELECT id,title From companies where isactive=1");
		$data['query_contacts']=$this->db->query("SELECT
			contacts.id,
			contacts.fname,
			contacts.lname,
			contacts.title,
			contacts.email
			FROM
			contacts
			WHERE
			contacts.user_id = '".$this->session->userdata('user_id')."' AND
			contacts.isactive = '1'");
		
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/wizard/jquery.bootstrap.wizard.min.js","core/demo/DemoFormWizard.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		
		$data['main_content'] = $this->main_content_add;

		$this->load->view($this->template, $data);
	}
	
	function add_action(){


		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('cat_id', 'Aricraft Cat', 'trim|required');
		if($this->form_validation->run() == FALSE)

		{
			$data['controler_name']=$this->controler_name;

			$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;
			$data['title'] = $this->add_title;
			$data['errormess'] = '';
			$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
			$data['query_aircat']=$this->db->query("SELECT id,title From aircraft_cat where isactive=1");
			$data['query_e_man']=$this->db->query("SELECT id,title From engine_man where isactive=1");
			$data['query_companies']=$this->db->query("SELECT id,title From companies where isactive=1");
			$data['query_contacts']=$this->db->query("SELECT
				contacts.id,
				contacts.fname,
				contacts.lname,
				contacts.title,
				contacts.email
				FROM
				contacts
				WHERE
				contacts.user_id = '".$this->session->userdata('user_id')."' AND
				contacts.isactive = '1'");
			
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/wizard/jquery.bootstrap.wizard.min.js","core/demo/DemoFormWizard.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
			
			$data['main_content'] = $this->main_content_add;
	
			$this->load->view($this->template, $data);

		} else {
			$keywords = "";
			$query_aircat=$this->db->query("SELECT title From aircraft_cat where id='".$this->input->post('cat_id')."'");
			$row_aircat = $query_aircat->row();
			$keywords .= $row_aircat->title.", ";
			$query_aircraft_manufacturer=$this->db->query("SELECT title From aircraft_manufacturer where id='".$this->input->post('man_id')."'");
			$row_aircraft_manufacturer = $query_aircraft_manufacturer->row();
			$keywords .= $row_aircraft_manufacturer->title.", ";
			
			$query_air_model=$this->db->query("SELECT title From aircraft_model where id='".$this->input->post('model_id')."'");
			$row_air_model = $query_air_model->row();
			$keywords .= $row_air_model->title.", ";
			
			$query_air_type=$this->db->query("SELECT title From aircraft_type where id='".$this->input->post('type_id')."'");
			$row_air_type = $query_air_type->row();
			$keywords .= $row_air_type->title.", ";
			
			$keywords .= $row_aircraft_manufacturer->title." ".$row_air_type->title." ".$row_air_model->title;
			
			$user_id = $this->session->userdata('user_id');
			$data2 = array(
				'listed_by' => $user_id ,
				'cat_id' => $this->input->post('cat_id') ,
				'man_id' => addslashes($this->input->post('man_id')),
				'type_id' => addslashes($this->input->post('type_id')),
				'model_id' => addslashes($this->input->post('model_id')),
				'msn' => addslashes($this->input->post('msn')),
				'yom' => addslashes($this->input->post('yom')),
				'total_time' => addslashes($this->input->post('total_time')),
				'total_cycles' => addslashes($this->input->post('total_cycles')),
				'mtow' => addslashes($this->input->post('mtow')),
				'mlgw' => addslashes($this->input->post('mlgw')),
				'stage' => addslashes($this->input->post('stage')),
				'aircraft_config' => $this->input->post('aircraft_config'),
				'last_c_check' => $this->input->post('last_c_check'),
				'tfh_c_check' => addslashes($this->input->post('tfh_c_check')),
				'time_remaining_c' => addslashes($this->input->post('time_remaining_c')),
				'last_d_check' => addslashes($this->input->post('last_d_check')),
				'tfh_d_check' => addslashes($this->input->post('tfh_d_check')),
				'time_remaining_d' => addslashes($this->input->post('time_remaining_d')),
				'lh_main_landing_g_oh' => addslashes($this->input->post('lh_main_landing_g_oh')),
				'lh_main_landing_g_tcslsv' => addslashes($this->input->post('lh_main_landing_g_tcslsv')),
				'rh_main_landing_g_oh' => addslashes($this->input->post('rh_main_landing_g_oh')),
				'rh_main_landing_g_tcslsv' => addslashes($this->input->post('rh_main_landing_g_tcslsv')),
				'n_landing_g_oh' => addslashes($this->input->post('n_landing_g_oh')),
				'n_main_landing_g_tcslsv' => addslashes($this->input->post('n_main_landing_g_tcslsv')),
				'e_man_id' => addslashes($this->input->post('e_man_id')),
				'e_type_id' => addslashes($this->input->post('e_type_id')),
				'e_model_id' => addslashes($this->input->post('e_model_id')),
				'status' => addslashes($this->input->post('status')),
				'current_location' => addslashes($this->input->post('current_location')),
				'reg_in' => addslashes($this->input->post('reg_in')),
				'comments' => addslashes($this->input->post('editor1')),
				'availability_date' => addslashes($this->input->post('availability_date')),
				'owner' => addslashes($this->input->post('owner')),
				'seller' => addslashes($this->input->post('seller')),
				'primary_contact' => addslashes($this->input->post('primary_contact')),
				'offered_for' => addslashes($this->input->post('offered_for')),
				'mgh_acmi' => addslashes($this->input->post('mgh_acmi')),
				'p_b_h' => addslashes($this->input->post('p_b_h')),
				'cpd' => addslashes($this->input->post('cpd')),
				'asking_price' => addslashes($this->input->post('asking_price')),
				'lease_terms' => addslashes($this->input->post('lease_terms'))
			);
			
			if($_FILES["specs_file"]["tmp_name"]!=''):
				$newspecs_file=rand().$_FILES["specs_file"]['name'];
				$specs_file_path=realpath(APPPATH . '../../specs_files/') . $newimgname;
				move_uploaded_file($_FILES["specs_file"]["tmp_name"], $specs_file_path);
				$data2['specs_file']=$newspecs_file;
			endif;
			
			
			$this->db->insert("aircraft", $data2); 
			$inid = $this->db->insert_id();
			
			if($_FILES["featuredImage"]["tmp_name"]!=''):
				$this->load->model('Logo_upload');
				$featuredImage = $this->Logo_upload->do_upload('featuredImage');
				$data3 = array(
					'belogs_to_id' => $inid ,
					'belogs_to_type' => 'aircraft',
					'type' => 'featuredImage',
					'path' => $featuredImage ,
				);
				$this->db->insert('media', $data3);
				
			endif;
			
			if($_FILES["coverImage"]["tmp_name"]!=''):
				$this->load->model('Logo_upload');
				$coverImage = $this->Logo_upload->do_upload('coverImage');
				$data3 = array(
					'belogs_to_id' => $inid ,
					'belogs_to_type' => 'aircraft',
					'type' => 'coverImage',
					'path' => $coverImage ,
				);
				$this->db->insert('media', $data3);
				
			endif;
			
			if(isset($_FILES["galleryImage"]) && $_FILES["galleryImage"]["tmp_name"][0]!=''):
				
				$this->load->model('Media_image');
				$galleryImages = $this->Media_image->do_upload('galleryImage',400,400);
				foreach($galleryImages as $galleryImg):
					$data4 = array(
						'belogs_to_id' => $inid ,
						'belogs_to_type' => 'aircraft',
						'type' => 'galleryImage',
						'path' => $galleryImg
					);
					$this->db->insert('media', $data4);
				endforeach;

			endif;
			
			$data5 = array(
						'type' => 1 ,
						'keywords' => $keywords,
						'created_date' => date("Y-m-d"),
						'ref_id' => $inid,
						'isactive' => 1
					);
			$this->db->insert('listings', $data5);
			
			
			$data['errormess'] = '';
			
			redirect('user/'.$this->controler_name.'/', 'refresh');
		}
	}
	
	function edit($editid){
		$data['controler_name']=$this->controler_name;
		$data['query'] = $this->db->query("SELECT
			contacts.id,
			contacts.title,
			contacts.fname,
			contacts.lname,
			contacts.profile_pic,
			contacts.email,
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
			users.email AS useremail
			FROM
			contacts
			INNER JOIN users ON contacts.user_id = users.id
			WHERE contacts.id  = '$editid'");

		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/wizard/jquery.bootstrap.wizard.min.js","core/demo/DemoFormWizard.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		
		$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
			$data['query_aircat']=$this->db->query("SELECT id,title From aircraft_cat where isactive=1");
			$data['query_e_man']=$this->db->query("SELECT id,title From engine_man where isactive=1");
			$data['query_companies']=$this->db->query("SELECT id,title From companies where isactive=1");
			$data['query_contacts']=$this->db->query("SELECT
				contacts.id,
				contacts.fname,
				contacts.lname,
				contacts.title,
				contacts.email
				FROM
				contacts
				WHERE
				contacts.user_id = '".$this->session->userdata('user_id')."' AND
				contacts.isactive = '1'");
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->edit_title;

		$data['title'] = $this->edit_title;

		$data['errormess'] = '';

		$data['main_content'] = $this->main_content_edit;

		$this->load->view($this->template, $data);
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
			contacts.id,
			contacts.title,
			contacts.fname,
			contacts.lname,
			contacts.profile_pic,
			contacts.email,
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
			users.email AS useremail
			FROM
			contacts
			INNER JOIN users ON contacts.user_id = users.id
			WHERE contacts.id  = '$editid'");
			$query_event_location = $this->db->query("SELECT
			contacts.country,
			contacts.state
			FROM
			contacts
			WHERE contacts.id  = '$editid'");
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
	
			$this->load->view($this->template, $data);
			$data['errormess'] = '1';
		} else {

			
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
				$query_profile_pic = $this->db->query("SELECT
				contacts.profile_pic,
				FROM
				contacts
				WHERE contacts.id  = '$editid'");
				if($query_profile_pic->num_rows() != 0) :
					$query_media = $query_profile_pic->row();
					$folderName='profile_images';
					unlink(realpath(APPPATH . '../../_images/'.$folderName.'/thumb/'.$query_media->profile_pic));
					unlink(realpath(APPPATH . '../../_images/'.$folderName.'/orignal/'.$query_media->profile_pic));
				endif;	
				$this->load->model('Logo_upload');
				$featuredImage = $this->Logo_upload->do_upload('profile_pic');
				$data2['profile_pic']=$featuredImage;
			endif;
			
			$this->db->where('id', $editid);
			
			$this->db->update("contacts", $data2); 
			redirect('user/'.$this->controler_name.'/', 'refresh');
		}
	}

}
