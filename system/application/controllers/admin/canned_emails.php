<?php

class Canned_emails extends Controller 
{
	function __construct()
	{
		parent::Controller();
	}
	function index()
	{
		$data['headingtop'] = 'Manage > Canned Emails';
		$data['title'] = 'Manage Canned Emails';
		$data['main_content'] = 'admin/manage/canned_emails/canned_emails';
		$data['query'] = $this->db->query("Select * From tblcannedemails");
		$this->load->view('admin/template', $data);
	}
	function edit($vid)
	{   $data['errormess'] = '';
		$data['headingtop'] = 'Manage > Canned Emails > Edit';
		$data['title'] = 'Edit >';
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['main_content'] = 'admin/manage/canned_emails/edit';
		$data['query'] = $this->db->query("Select * From tblcannedemails WHERE pkey ='$vid'");
		$this->load->view('admin/template', $data);
	}
	
	function edit_($editid)
	{   
		$data['headingtop'] = 'Manage > Canned Emails > Edit';
		$data['title'] = 'Edit >';
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('MessageType', 'Message Type', 'trim|required');
		$this->form_validation->set_rules('mailsubject', 'Mail Subject', 'trim|required');
		$this->form_validation->set_rules('mailemail', 'Mail Email', 'trim|required');	
		if($this->form_validation->run() == FALSE)
		{
		$data['errormess'] = '1';
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['main_content'] = 'admin/manage/canned_emails/edit';
		$data['query'] = $this->db->query("Select * From tblcannedemails WHERE pkey ='$editid'");
		$this->load->view('admin/template', $data);
		} else {
		$data['errormess'] = '';
		$title = addslashes($this->input->post('MessageType'));
		$content = addslashes($this->input->post('editor1'));
		
		$data = array(
              'MessageType' => $title ,
               'mailsubject' => $this->input->post('mailsubject') ,
               'isActive' => $this->input->post('isactive') ,
			   'mailemail' => $this->input->post('mailemail') ,
			   'MessageContents' => $content
            );

$this->db->where('pkey', $editid);
$this->db->update('tblcannedemails', $data); 

		redirect(base_url().'admin/canned_emails/', 'refresh');
		}
}
	
	
	function bulk_actions()
	{
		$count = $_REQUEST['count'];

		$upop = $this->input->post('baction');
	for($i=1;$i<=$count;$i++)
		{
		if($this->input->post('ch'.$i)) 
{
$ch = $this->input->post('ch'.$i);
$this->db->where('id', $ch);
$this->db->delete('tblcontacts'); 
		}								
		}
		redirect(base_url().'admin/contact_inquiry/', 'refresh');
	}		
}
