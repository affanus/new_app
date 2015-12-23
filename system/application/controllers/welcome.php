<?php

class Welcome extends Controller {
	
	function Welcome()
	{
		parent::Controller();
		
		
		
		
	}
	
	function index()
	{
		
		
		$data['main_content'] = 'welcome_message';
		
		$this->load->view('includes/template', $data);	
		
		
	}
	
	function register(){
		
		
		
	}
	
	function test(){

	}

	
}

