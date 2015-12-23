<?php

class Contact_inquiry extends Controller 
{
	function __construct()
	{
		parent::Controller();
	}
	function index($row=1)
	{
		$data['headingtop'] = 'CMS > Contact Inquiry';
		$data['title'] = 'Manage Contacts';
		$data['curpage'] = $row;
		$data['range'] = 20;
		$data['trows']=$this->db->count_all('tblcontacts');
		$perpage = 20;
		$data['tpages'] = ceil($this->db->count_all('tblcontacts') / $perpage);
		// store data for being displayed on view file
		$offset = ($row - 1) * $perpage;
		$data['query']=$this->db->query("SELECT * FROM tblcontacts ORDER BY tblcontacts.id DESC LIMIT ".$offset.", ".$perpage);
		
		// load 'testview' view
		$data['keyword'] = $this->input->post('search');
		$data['main_content'] = 'admin/cms/contact_inquiry/contact_inquiry';
		$this->load->view('admin/template', $data); 
	}
	function page($row=1)
	{
		$data['headingtop'] = 'CMS > Contact Inquiry';
		$data['title'] = 'Manage Contacts';
		$data['curpage'] = $row;
		$data['range'] = 20;
		$data['trows']=$this->db->count_all('tblcontacts');
		$perpage = 20;
		$data['tpages'] = ceil($this->db->count_all('tblcontacts') / $perpage);
		// store data for being displayed on view file
		$offset = ($row - 1) * $perpage;
		$data['query']=$this->db->query("SELECT * FROM tblcontacts ORDER BY tblcontacts.id DESC LIMIT ".$offset.", ".$perpage);
		
		// load 'testview' view
		$data['keyword'] = $this->input->post('search');
		$data['main_content'] = 'admin/cms/contact_inquiry/contact_inquiry';
		$this->load->view('admin/template', $data); 
	}
	function view_inquiry($vid)
	{
		
		$data = array(
              'status' => 1
            );

$this->db->where('id', $vid);
$this->db->update('tblcontacts', $data);
		
		$data['headingtop'] = 'CMS > Contact Inquiry > View';
		$data['title'] = 'View Contact > ';
		$data['main_content'] = 'admin/cms/contact_inquiry/view_inquiry';
		$data['query'] = $this->db->query("Select * From tblcontacts WHERE id ='$vid'");
		$this->load->view('admin/template', $data);
	}
	
	function del($ch){
		$this->db->where('id', $ch);
		$this->db->delete('tblcontacts'); 
		redirect('admin/contact_inquiry/', 'refresh');
	}
	
	
	function bulk_actions($keyword=0)
	{
		
		$count = $this->input->post('count');
		$upop = $this->input->post('baction');
		
if($upop == 'mar'){
	for($i=1;$i<=$count;$i++)
		{
		if($this->input->post('ch'.$i)) 
{
$ch = $this->input->post('ch'.$i);
$data = array(
              'status' => 1
            );

$this->db->where('id', $ch);
$this->db->update('tblcontacts', $data); 
		}								
		}
		}
		
		if($upop == 'maur'){
	for($i=1;$i<=$count;$i++)
		{
		if($this->input->post('ch'.$i)) 
{
$ch = $this->input->post('ch'.$i);
$data = array(
              'status' => 0
            );

$this->db->where('id', $ch);
$this->db->update('tblcontacts', $data); 
		}								
		}
		}
		
		
		if($upop == 'del'){
	for($i=1;$i<=$count;$i++)
		{
		if($this->input->post('ch'.$i)) 
{
$ch = $this->input->post('ch'.$i);
$this->db->where('id', $ch);
$this->db->delete('tblcontacts'); 
		}								
		}
		}
		
		
		
		
		
		
		//Seacrh Start
		$issearch = $this->input->post('issearch');
		$row=1;
		$keyword = $this->input->post('search');
		$data['keyword'] = $this->input->post('search');
		$data['headingtop'] = 'CMS > Contact Inquiry > Search';
		$data['title'] = 'Manage Contacts > Search';
		$data['curpage'] = $row;
		$data['range'] = 20;
		$data['trows']=$this->db->count_all('tblcontacts');
		$perpage = 20;
		$data['tpages'] = ceil($this->db->count_all('tblcontacts') / $perpage);
		// store data for being displayed on view file
		$offset = ($row - 1) * $perpage;
		$data['query']=$this->db->query("SELECT * FROM tblcontacts WHERE txtfname LIKE '%{$keyword}%' OR txtemail LIKE '%{$keyword}%' LIMIT ".$offset.", ".$perpage);
		// load 'testview' view
		$data['main_content'] = 'admin/cms/contact_inquiry/contact_inquiry';
		$this->load->view('admin/template', $data);
		
		//Search End
		

	}		
}
