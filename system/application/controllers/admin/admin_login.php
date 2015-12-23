<?php

class Admin_login extends Controller {
	
	function index()
	{	
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
		$data['main_content'] = 'admin/admin_login_form';
		$data['errormess'] = '';
		$this->load->view('admin/login_template', $data);
		}else {
		redirect(base_url().'admin/admin_main/dashboard');	
		}
	
			
	}
	function validate_credentials()
	{		
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('username', 'User Name', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');		
		if($this->form_validation->run() == FALSE)
		{
			$data['main_content'] = 'admin/admin_login_form';
			$data['errormess'] = '1';
			$this->load->view('admin/login_template', $data);
		}else {	
		$this->load->model('admin_login_model');
		$query = $this->admin_login_model->validate();
		
		if($query) // if the user's credentials validated...
		{
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			redirect(base_url().'admin/admin_main/dashboard');
		}
		else // incorrect username or password
		{
			
			$data['main_content'] = 'admin/admin_login_form';
			$data['errormess'] = '1';
			$this->load->view('admin/login_template', $data);
			//redirect('admin/admin_login/');
			//$this->index();
		}
		}
	}	
	

	
	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url().'admin/');
	}
	
	

}
?>