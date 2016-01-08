<?php

class Users extends Controller {
	
	var $user_id;
	var $user_name;
	var $controler_name;
	
	function __construct()
	{
		parent::Controller();
		$this->controler_name='events';
		if($this->session->userdata('fbuid')):
			$this->user_id=$this->session->userdata('fbuid');	
			$query_user=$this->db->query("SELECT * FROM users where fbuid='".$this->user_id."'");
			$user_data = $query_user->row(); 
			$this->user_name=$user_data->first_name.' '.$user_data->last_name;
		else:
			#redirect(base_url());
		endif;
	}
	
	function index()
	{
				
	}
	
	function get_email_status(){
		if($this->input->post('email')){
			$query=$this->db->query("SELECT id From users where email='".$this->input->post('email')."'");
			if($query->num_rows() == 0) :
				echo "true";
			else:
				echo "false";
			endif;
		}
	}
	
	function register(){
		
		$data['main_content'] = 'register';
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		$this->load->view('includes/register', $data);	
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
	
	function register_step2(){
		$data['query_countries']=$this->db->query("SELECT id,title From meta_location where type='CO'");
		$data['main_content'] = 'register';
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		$this->load->view('includes/register', $data);	
	}
	
	function register_action(){
		$query=$this->db->query("SELECT id From users where email='".$this->input->post('email')."'");
		if($query->num_rows() == 0) :
			$fname=addslashes($this->input->post('fname'));
			$lname=addslashes($this->input->post('lname'));
			$emailAddress = $this->input->post('email');
			$verificationcode = rand (1000 , 9999 );
			
			/*if($this->input->post('title')=='Mr'):
				$gender=1;
			else:
				$gender=2;
			endif;*/
			$data = array(
					'email' => $this->input->post('email'),
					'fname' => $fname,
					'lname' => $lname,
					'password' => md5($this->input->post('password1')) ,
					'isactive' => 0,
					'bday' => addslashes($this->input->post('bday')),
					'created_date' => date("Y-m-d"),
					'activation_code' => $verificationcode
				);
			$this->db->insert('users', $data);
			$user_id = $this->db->insert_id();
			$parent_email = $this->db->query("SELECT request_id,request_sender_id From request where request_receiver_id='".$this->input->post('email')."'")->result_array();
			if(!empty($parent_email))
			{
				$request_id = $parent_email[0]['request_id'];
				$request_sender_id = $parent_email[0]['request_sender_id'];
				$this->db->where('request_id',$request_id)->update('request',array("request_receiver_id"=>$user_id));
				$this->db->where('u_id',$request_sender_id)->update('following_list',array("f_id"=>$user_id));
			}
			$session_data = array(
					'user_id' => $user_id,
					'fname' => $fname,
					'lname' => $lname
				);
			$this->session->set_userdata($session_data);
			
			
			/*$data2 = array(
				'user_id' => $user_id ,
				'title' => $this->input->post('title') ,
				'fname' => $fname,
				'lname' => $lname,
				'gender' => $gender,
				'email' => $this->db->escape($this->input->post('email')),
				'isactive' => 0,
				'primary' => 1,
				'bday' => addslashes($this->input->post('bday'))
			);
			$this->db->insert("contacts", $data2);*/
			$this->load->library('email');
			
			$this->email->from('info@chymps.com', 'Chymps');
			$this->email->to($emailAddress,$fname); 
			$this->email->subject('Account Verification Code');
			$this->email->message('Thank you for joing Chypms.Your Activation Code is '.$verificationcode); 
			
			$this->email->send();
			redirect(base_url().'users/account_active/'.$user_id.'/');
		else:
			redirect(base_url().'users/register/');
		endif;
	}
	function account_active($user_id){
		$data['user_id'] = $user_id;
		$data['main_content'] = 'signup_successful';
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		$this->load->view('includes/register', $data);	
	}
	
	function register_ss_action(){
		$user_id = $this->session->userdata('user_id');
		$data2 = array(
				'education' => addslashes($this->input->post('education')),
				'bio' => addslashes($this->input->post('bio')),
				'gender' => addslashes($this->input->post('gender')),
				'pphone' => addslashes($this->input->post('pphone')),
				'mphone' => addslashes($this->input->post('mphone')),
				'address' => addslashes($this->input->post('address')),
				'city' => $this->input->post('city'),
				'country' => $this->input->post('country'),
		);
		if($_FILES["profile_pic"]["tmp_name"]!=''):
			$this->load->model('Logo_upload');
			$featuredImage = $this->Logo_upload->do_upload('profile_pic');
			$data2['profile_pic']=$featuredImage;
		endif;
		$this->db->where('id', $user_id);
			
		$this->db->update("users", $data2);
		redirect(base_url().'users/profile');
		
	}
	

	function login(){
		$data['main_content'] = 'login';
		$data['errormess'] = '';
		$this->load->view('includes/register', $data);
	}
	
	function login_confirmation(){
		if($this->input->post('email') && $this->input->post('password')){
			//echo md5($this->input->post('password'));
			//exit;
			$query=$this->db->query("SELECT
				id,
				email,
				fname,
				lname,
				isactive,
				user_verify,
				bday
				FROM
				users
				WHERE
				email = '".addslashes($this->input->post('email'))."' AND
				password = '".md5($this->input->post('password'))."' AND
				isactive = 1");
			if($query->num_rows() == 0) :
				//echo "no login";
				//exit;
				$data['main_content'] = 'login';
				$data['errormess'] = '1';
				$this->load->view('includes/register', $data);
			else:
				//echo "Login";
				//exit;
				$row_user_query = $query->row();
				 $birthDate = $query->row('bday');
			  //explode the date to get month, day and year
			  $birthDate = explode("/", $birthDate);
			  //get age from date or birthdate
			  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				? ((date("Y") - $birthDate[2]) - 1)
				: (date("Y") - $birthDate[2]));

				$session_data = array(
					'user_id' => $row_user_query->id,
					'fname' => stripslashes($row_user_query->fname),
					'lname' => stripslashes($row_user_query->lname),
					'email' => stripslashes($row_user_query->email),
				);
				$this->session->set_userdata($session_data);
				if($row_user_query->user_verify){
					redirect(base_url().'users/profile');
				}
				else{
					if ($age > 14){
						redirect(base_url().'users/adult_auth');
					}
					else {
						redirect(base_url().'users/child_auth');
					}
				}
			endif;
		}
	}
	
	function adult_auth(){
		if($this->session->userdata('user_id')):
			$data['main_content'] = 'users/adult_auth';
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js");
			$this->load->view('includes/user_adult', $data);
			
		else:
			redirect(base_url().'users/login');
		endif;
		
	}
	function child_auth(){
		if($this->session->userdata('user_id')):
			$data['main_content'] = 'users/child_auth';
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js");
			$this->load->view('includes/user_adult', $data);
		else:
			redirect(base_url().'users/login');
		endif;		
	}
	function child_ask_parents()
	{
		if($_POST['request_receiver_email'] !=""):
		$data['request_receiver_id'] = $_POST['request_receiver_email'];
		else:
		$data['request_receiver_id'] = $_POST['request_receiver_id'];
		endif;
		$data['request_sender_id'] 	 = $this->session->userdata('user_id');
		$data['parent_id'] = "P";
		$this->db->insert('request',$data);
		
		$folling['u_id'] = $this->session->userdata('user_id');
		$folling['f_id'] = $_POST['request_receiver_id'];
		$folling['family_member'] = $_POST['member_type'];
		$folling['count'] = 1;
		$this->db->insert('following_list',$folling);
		
		$data['main_content'] = 'users/child_auth';
		$this->load->view('includes/user_adult', $data);
		
	}
	function profile($id='')
	{
		$data['u_id'] = $id;
		if($this->session->userdata('user_id')):
		$data['main_content'] = 'users/profile';
		$this->load->view('includes/user_adult', $data);
		else:
			redirect(base_url().'users/login');
		endif;		
	}
	/*function friend_profile($id)
	{
		$data['user_id'] = $id;
		if($this->session->userdata('user_id')):
		$data['main_content'] = 'users/friend_profile';
		$this->load->view('includes/user_adult', $data);
		else:
			redirect(base_url().'users/login');
		endif;
	}*/
	function friend_request()
	{
		//print_r($_POST['friendSearch']);
		//exit;
		@$data['friendSearch'] = @$_POST['friendSearch'];
		if($this->session->userdata('user_id')):
		$data['main_content'] = 'users/friend_request';
		$this->load->view('includes/user_adult', $data);
		else:
			redirect(base_url().'users/login');
		endif;
	}
		function send_request($id)
	{
		
			$query = $this->db->query("SELECT * FROM users where id = '".$id."'");
				$birthDate = $query->row('bday');
			  //explode the date to get month, day and year
			  $birthDate = explode("/", $birthDate);
			  //get age from date or birthdate Receiver
			  $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				? ((date("Y") - $birthDate[2]) - 1)
				: (date("Y") - $birthDate[2]));
				
				
				$query1 = $this->db->query("SELECT * FROM users where id = '".$this->session->userdata('user_id')."'");
				$birthDate1 = $query1->row('bday');
			  //explode the date to get month, day and year
			  $birthDate1 = explode("/", $birthDate1);
			  //get age from date or birthdate Sender
			  $age1 = (date("md", date("U", mktime(0, 0, 0, $birthDate1[0], $birthDate1[1], $birthDate1[2]))) > date("md")
				? ((date("Y") - $birthDate1[2]) - 1)
				: (date("Y") - $birthDate1[2]));
				
		if ($age > 14 && $age1 > 14){
			$insert['request_sender_id'] = $this->session->userdata('user_id');
			$insert['request_receiver_id'] = $query->row('id');
			$insert['type'] = "f"; 
			$insert['parent_id'] = $query->row('id');
			$this->db->insert('request',$insert);
			/*Follwing*/
			$following['u_id']  = $this->session->userdata('user_id');
			$following['f_id']  =  $query->row('id');
			$following['count'] = "1";
			$this->db->insert('following_list',$following);
			
			$data['main_content'] = 'users/profile';
			$this->load->view('includes/user_adult', $data);
		}
		elseif($age > 14 && $age1 < 14)
		{
			$insert['request_sender_id'] = $this->session->userdata('user_id');
			$insert['request_receiver_id'] = $query->row('id');
			$insert['type'] = "f";
			$insert['parent_id'] = $query->row('id');
			$this->db->insert('request',$insert);
			$insert['parent_id'] = $query1->row('approved_by');
			$this->db->insert('request',$insert);
			/*Follwing*/
			$following['u_id']  = $this->session->userdata('user_id');
			$following['f_id']  =  $query->row('id');
			$following['count'] = "2";
			$this->db->insert('following_list',$following);
		}
		elseif($age1 > 14 && $age < 14)
		{
			$insert['request_sender_id'] = $this->session->userdata('user_id');
			$insert['request_receiver_id'] = $query->row('id');
			$insert['type'] = "f";
			$insert['parent_id'] = $query->row('id');
			$this->db->insert('request',$insert);
			$insert['parent_id'] = $query->row('approved_by');
			$this->db->insert('request',$insert);
			/*Follwing*/
			$following['u_id']  = $this->session->userdata('user_id');
			$following['f_id']  =  $query->row('id');
			$following['count'] = "2";
			$this->db->insert('following_list',$following);
		}
		else {
			$insert['request_sender_id'] = $this->session->userdata('user_id');
			$insert['request_receiver_id'] = $query->row('id');
			$insert['type'] = "f";
			$insert['parent_id'] = $query->row('id');
			$this->db->insert('request',$insert);
			$insert['parent_id'] = $query->row('approved_by');
			$this->db->insert('request',$insert);
			$query11 = $this->db->query("SELECT * FROM users where id = '".$this->session->userdata('user_id')."'");
			$insert['parent_id'] = $query11->row('approved_by');
			$this->db->insert('request',$insert);
			/*Follwing*/
			$following['u_id']  = $this->session->userdata('user_id');
			$following['f_id']  =  $query->row('id');
			$following['count'] = "3";
			$this->db->insert('following_list',$following);
		}
		//$data['main_content'] = 'users/profile';
		//$this->load->view('includes/user_adult', $data);
		redirect(base_url().'users/profile');
	}
	function accept_request($id, $status,$user_id)
	{
		$data = array('isactive' =>  $status);
		$this->db->where('request_id', $id);
		$this->db->update('request', $data);
		$this->db->query("UPDATE following_list SET count = count - 1 WHERE u_id = '".$user_id."'");
		redirect(base_url().'users/profile');
	}
	function event_request($id, $status)
	{
		$data = array('isactive' =>  $status);
		$this->db->where('request_id', $id);
		$this->db->update('events_request', $data);
		redirect(base_url().'users/profile');
	}
	function event_request_all($id, $status)
	{
		$data = array('isactive' =>  $status);
		$this->db->where('request_id', $id);
		$this->db->update('events_request', $data);
		redirect(base_url().'users/show_request');
	}
	function accept_request_all($id, $status,$user_id)
	{
		$data = array('isactive' =>  $status);
		$this->db->where('request_id', $id);
		$this->db->update('request', $data);
		$this->db->query("UPDATE following_list SET count = count - 1 WHERE u_id = '".$user_id."'");
		redirect(base_url().'users/show_request');
	}
	
	function adult_ask_parents()
	{
		$data['request_sender_id'] 	 = $this->session->userdata('user_id');
		if($_POST['request_receiver_id'] !=""):
		$data['request_receiver_id'] = $_POST['request_receiver_id'];
		//$data['type'] = $_POST['member_type'];
		else:
		$data['type'] = "admin";
		endif;
		
		$this->db->insert('request',$data);
/*		$folling['u_id'] = $this->session->userdata('user_id');
		$folling['f_id'] = $_POST['request_receiver_id'];
		$folling['family_member'] = $_POST['member_type'];
		$folling['count'] = 1;
		$this->db->insert('following_list',$folling);*/
		$data['main_content'] = 'users/adult_auth';
		$this->load->view('includes/user_adult', $data);
	}
	function dashboard(){
		if($this->session->userdata('user_id')):
			$data['main_content'] = 'users/user_dashboard';
			$this->load->view('includes/user_template', $data);
		else:
			redirect(base_url().'users/login');
		endif;
		
	}
	function update_status($id, $status,$user_id){
		
		$data = array('isactive' =>  $status);
		$admin = array('user_verify' =>  $status,"approved_by"=>$this->session->userdata('user_id'));
		$this->db->where('request_id', $id);
		$this->db->update('request', $data); 
		$this->db->where('id', $user_id);
		$this->db->update('users', $admin); 
		$this->db->query("UPDATE following_list SET count = count - 1 WHERE u_id = '".$user_id."' and f_id='".$this->session->userdata('user_id')."'");
		
		$this->db->where('request_id', $id);
		$this->db->delete('request');	
		
		redirect(base_url().'users/profile');
	}
	function update_status_all($id, $status,$user_id){
		
		$data = array('isactive' =>  $status);
		$admin = array('user_verify' =>  $status,"approved_by"=>$this->session->userdata('user_id'));
		$this->db->where('request_id', $id);
		$this->db->update('request', $data); 
		$this->db->where('id', $user_id);
		$this->db->update('users', $admin); 
		$this->db->query("UPDATE following_list SET count = count - 1 WHERE u_id = '".$user_id."'");
		redirect(base_url().'users/show_request');
	}
	function show_request()
	{
		if($this->session->userdata('user_id')):
		$data['main_content'] = 'users/show_all_request';
		$this->load->view('includes/user_adult', $data);
		else:
			redirect(base_url().'users/login');
		endif;
	}
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
	function edit_profile(){
		$user_id = $this->session->userdata('user_id');
		$query=$this->db->query("SELECT * From users where id ='".$user_id."'");
		
	  $data['main_content'] = 'register_second_step';
	  $data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
	  $this->load->view('includes/register', $data); 
 }
 

 
 function account_verify(){
	$id = $_POST['id'];
	$activation_code = $_POST['activation_code'];
	$result  = $this->db->select('activation_code,bday')->from('users')->where('id',$id)->get()->result_array();
	$activation_code_db = $result[0]['activation_code'];
	$birthDate = $result[0]['bday'];
	$birthDate = explode("/", $birthDate);
	 $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
				? ((date("Y") - $birthDate[2]) - 1)
				: (date("Y") - $birthDate[2]));
	if($activation_code_db == $activation_code)
	{
		$this->db->where('id',$id)->update('users',array("isactive"=>1));
		if ($age > 14){
						redirect(base_url().'users/adult_auth');
					}
					else {
						redirect(base_url().'users/child_auth');
					}
	}
	else
	{
		$data['user_id'] = $id;
		$data['main_content'] = 'signup_successful';
  		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
  		$this->load->view('includes/register', $data); 
	} 

 }
 function event_detail($editid) {
	 
	 	 if($this->session->userdata('user_id')):
		
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");

		$data['e_id']= $editid;
		$data['query_media_gallery'] = $this->db->query("Select path,id  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'events' and type!='featuredImage'");
		$data['query_media_featuredImage'] = $this->db->query("Select path  From media WHERE belogs_to_id = '$editid' and belogs_to_type = 'events' and type='featuredImage'");
		$data['main_content'] = 'event_detail';
		$this->load->view('includes/user_adult', $data);
		else:
			redirect(base_url().'users/login');
		endif;
	 
	 }
 function create_event(){
	 	if($this->session->userdata('user_id')):
		$data['controler_name']= $this->controler_name;
		$data['query_air_cat']=$this->db->query("SELECT id,title From event_cat");
		$data['query_users']=$this->db->query("SELECT id,fname From users");
		
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");

	
		$data['main_content'] = 'add_event';
		$this->load->view('includes/user_adult', $data);
		else:
			redirect(base_url().'users/login');
		endif;
	 
 }
function add_action()

	{   
		$data['controler_name']=$this->controler_name;

		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		

		if($this->form_validation->run() == FALSE)

		{

			$data['errormess'] = '1';
			$data['main_content'] = $this->main_content_add;
			$data['query_air_cat']=$this->db->query("SELECT id,title From engine_cat");
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
			
			$this->load->view('admin/template', $data);

		} else {
			
			$data = array(
				'title' => addslashes($this->input->post('title')) ,
				'details' => addslashes($this->input->post('editor1')),
				'e_date' => addslashes($this->input->post('e_date')),
				'address' => addslashes($this->input->post('address')),
				'city' => addslashes($this->input->post('city')),
				'country' => addslashes($this->input->post('country')),
				'sponsor' => addslashes($this->input->post('sponsor')),
				'state' => addslashes($this->input->post('state')),
				'u_id' => $this->session->userdata('user_id'),
				'isactive' => 1
			);
			
			$this->db->insert('events', $data); 
			
			$inid = $this->db->insert_id();
			
			
			foreach ($_POST['event_cat'] as $event_cat):
				$data2 = array(
					'event_id' => $inid ,
					'cat_id' => $event_cat ,
				);
				$this->db->insert('event_cat_link', $data2); 
			endforeach;
			
			foreach ($_POST['users_cat'] as $user_cat):
				$data3 = array(
					'event_id' => $inid ,
					's_id'=> $this->session->userdata('user_id'),
					'r_id' => $user_cat ,
				);
				$this->db->insert('events_request', $data3); 
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
	

		
			
			
			
			
			
			redirect('users/profile/', 'refresh');
		}

	}

	function add_comments()
	{
		$data = array(
				'event_id' => addslashes($this->input->post('event_id')) ,
				'comment' => addslashes($this->input->post('comment')),
				'user_id' => $this->session->userdata('user_id')
			);
		$this->db->insert('comments',$data);
		redirect('users/event_detail/'.$_POST['event_id'], 'refresh');
	}
	function add_todo()
	{
		$data = array(
				'event_id' => addslashes($this->input->post('event_id')) ,
				'todo' => addslashes($this->input->post('todo'))
			);
		$this->db->insert('todo',$data);
		redirect('users/event_detail/'.$_POST['event_id'], 'refresh');
	}
	
function event_calender(){
	 	if($this->session->userdata('user_id')):
		
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");

	
		$data['main_content'] = 'calender_view';
		$this->load->view('includes/user_adult', $data);
		else:
			redirect(base_url().'users/login');
		endif;
	
}

}