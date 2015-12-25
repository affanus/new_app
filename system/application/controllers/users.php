<?php

class Users extends Controller {
	
	var $user_id;
	var $user_name;
	
	function __construct()
	{
		parent::Controller();
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
			$verificationcode = md5($emailAddress.$fname.date('Y-m-d H:i:s'));
			
			if($this->input->post('title')=='Mr'):
				$gender=1;
			else:
				$gender=2;
			endif;
			$data = array(
					'email' => $this->input->post('email'),
					'fname' => $fname,
					'lname' => $lname,
					'password' => md5($this->db->escape($this->input->post('password1'))) ,
					'isactive' => 0,
					'bday' => addslashes($this->input->post('bday')),
					'created_date' => date("Y-m-d"),
					'activation_code' => $verificationcode
				);
			$this->db->insert('users', $data); 
			$user_id = $this->db->insert_id();
			$session_data = array(
					'user_id' => $user_id,
					'fname' => $fname,
					'lname' => $lname
				);
			$this->session->set_userdata($session_data);
			$data2 = array(
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
			$this->db->insert("contacts", $data2);
			/*$this->load->plugin('phpmailer');	
			$query = $this->db->query("SELECT * from tblcannedemails where MessageType='85'");
			$row = $query->row();
			$body = stripslashes($row->MessageContents);
			$bsurl = base_url();
			$full_name = $this->input->post('fname')." ".$this->input->post('lname');
			$login_details = '';
			$user_email = $this->input->post('email');
			$trans = array("#VERIFICATIONCODE#" => "$verificationcode","#BASEURL#" => "$bsurl","#USERNAME#" => "$full_name","#LOGINDETAILS#" => "$login_details");
			$emaildata['email_content'] = strtr($body, $trans);
			$msg = $this->load->view('email_template/email_template', $emaildata, true);
			//smtpmailer($this->input->post('emailAddress'), $row->mailemail, $row->mailemail, $row->mailsubject, $msg);
			smtpmailer_dyn($this->input->post('emailAddress'), $row->mailemail, $row->mailemail, $row->mailsubject, $msg, '123456');*/
			redirect(base_url().'users/account_active/'.$user_id.'/');
		else:
			redirect(base_url().'users/register/');
		endif;
	}
	function account_active($user_id){
		$data['main_content'] = 'signup_successful';
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js","libs/bootstrap-datepicker/bootstrap-datepicker.js");
		$this->load->view('includes/register', $data);	
	}
	
	function register_ss_action(){
		$user_id = $this->session->userdata('user_id');
		$data2 = array(
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
			$data2['profile_pic']=$featuredImage;
		endif;
		$this->db->where('user_id', $user_id);
		$this->db->where('primary', '1');
			
		$this->db->update("contacts", $data2);
		redirect(base_url().'users/dashboard');
		
	}
	

	function login(){
		$data['main_content'] = 'login';
		$data['errormess'] = '';
		$this->load->view('includes/register', $data);
	}
	
	function login_confirmation(){
		if($this->input->post('email') && $this->input->post('password')){
			$query=$this->db->query("SELECT
				id,
				email,
				fname,
				lname,
				isactive
				FROM
				users
				WHERE
				email = '".addslashes($this->input->post('email'))."' AND
				password = '".md5($this->input->post('password'))."' AND
				isactive = 1");
			if($query->num_rows() == 0) :
				$data['main_content'] = 'login';
				$data['errormess'] = '1';
				$this->load->view('includes/register', $data);
			else:
				$row_user_query = $query->row();
				$session_data = array(
					'user_id' => $row_user_query->id,
					'fname' => stripslashes($row_user_query->fname),
					'lname' => stripslashes($row_user_query->lname)
				);
				$this->session->set_userdata($session_data);
				redirect(base_url().'users/dashboard');
			endif;
		}
	}
	
	function dashboard(){
		if($this->session->userdata('user_id')):
			$data['main_content'] = 'users/user_dashboard';
			$this->load->view('includes/user_template', $data);
		else:
			redirect(base_url().'users/login');
		endif;
		
	}
	
	
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

}