<?php

class Rights extends Controller 
{
	function __construct()
	{
		parent::Controller();
	}
	function index($pmenuid)
	{
		$data['pmenuid'] = $pmenuid;
		$data['headingtop'] = 'Rights';
		$data['title'] = 'Manage Admin Rights';
		$data['main_content'] = 'admin/rights/rights';
		$this->load->view('admin/template', $data);
	}
	function manage_rights($pmenuid)
	{
		$data['pmenuid'] = $pmenuid;
		$data['headingtop'] = 'Rights';
		$data['title'] = 'Manage Admin Rights';
		$data['main_content'] = 'admin/rights/rights';
		$this->load->view('admin/template', $data);
	}
	
	
}
