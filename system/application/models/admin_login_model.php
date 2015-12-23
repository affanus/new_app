<?php

class Admin_login_model extends Model {

	function validate()
	{
		$this->db->where('adminid', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$this->db->where('isactive', '1');
		$query = $this->db->get('tbladmin');
		
		if($query->num_rows == 1)
		{
			return true;
		}
		
	}
	
	function create_member()
	{
		
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),			
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))						
		);
		
		$insert = $this->db->insert('tbladmin', $new_member_insert_data);
		return $insert;
	}
}