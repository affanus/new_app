<?php

class security extends Model {
	
function __construct() {
        parent::Model();
        $this->load->database();
    }

	function validate_session()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You Session is Expired Please Login Again!. <a href="'.base_url().'admin">Login</a>';	
			die();		
			//$this->load->view('login_form');
		}
	}
	
	function validate_user_session() {
		$user_id = $this->session->userdata('user_id');
		if(!isset($user_id))
		{
			redirect(base_url().'users/login');
		}
	}
	
function validate_rights($rightch)
	{
		if($rightch == 'admin_main'){
		$rightch = 	'admin_main/dashboard';
		}
		$rightch = $rightch.'/';
		
		$this->db->where('link', $rightch);
		$query = $this->db->get('tbltabs');
		$row = $query->row();
		$adminid = $this->session->userdata('username');
		if($query->num_rows != '')
		{
		$tabid = $row->tabid;
		$this->db->where('adminid', $adminid);
		$this->db->where('tabid', $tabid);
		$this->db->where('isactive', '1');
		$query = $this->db->get('tbladminrights');
		$row = $query->row();
		if($query->num_rows == '')
		{
			echo 'You don\'t have permission to access this PARENT page. <a href="'.base_url().'admin">Login</a>';	
		die();		
		}
		}
		
		
		$this->db->where('linkurl', $rightch);
		$query2 = $this->db->get('tbltabdetails');
		$row2 = $query2->row();
		if($query2->num_rows != '')
		{
		$tabdetailid = $row2->tabdetailid;
		$this->db->where('adminid', $adminid);
		$this->db->where('tabdetailid', $tabdetailid);
		$this->db->where('isactive', '1');
		$query3 = $this->db->get('tbladminrightdetails');
		$row3 = $query3->row();
		if($query3->num_rows == '')
		{
			echo 'You don\'t have permission to access this page. <a href="'.base_url().'admin">Login</a>';	
		die();		
		}
		}
		
//$nrow = $query->num_rows();

	}



}