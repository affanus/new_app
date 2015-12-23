<?php

class Newsletters extends Controller 
{
	function __construct()
	{
		parent::Controller();
	}
	function index($row=1)
	{
$data['headingtop'] = 'Newsletters > Manage Newsletters';
$data['title'] = 'Manage Newsletters';
$data['curpage'] = $row;
$data['range'] = 20;
$data['trows']=$this->db->count_all('tblnewsletter');
$perpage = 10;
$data['tpages'] = ceil($this->db->count_all('tblnewsletter') / $perpage);
// store data for being displayed on view file
$offset = ($row - 1) * $perpage;
$data['query']=$this->db->query("SELECT * FROM tblnewsletter LIMIT ".$offset.", ".$perpage);

// load 'testview' view
		$data['main_content'] = 'admin/newsletters/newsletters/newsletters';
		$this->load->view('admin/template', $data); 
	}

	
function page($row=1){
$data['headingtop'] = 'Newsletters > Manage Newsletters';
$data['title'] = 'Manage Newsletters';
$data['curpage'] = $row;
$data['range'] = 20;
$data['trows']=$this->db->count_all('tblnewsletter');
$perpage = 10;
$data['tpages'] = ceil($this->db->count_all('tblnewsletter') / $perpage);
// store data for being displayed on view file
$offset = ($row - 1) * $perpage;
$data['query']=$this->db->query("SELECT * FROM tblnewsletter LIMIT ".$offset.", ".$perpage);

// load 'testview' view
		$data['main_content'] = 'admin/newsletters/newsletters/newsletters';
		$this->load->view('admin/template', $data); 

}
	
	function del($editid)
	{   
	$table = array('tblnewsletter');
$this->db->where('id', $editid);
$this->db->delete($table);

redirect(base_url().'admin/newsletters/', 'refresh');
	}

	function add()
	{   
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['headingtop'] = 'Newsletter > Manage Newsletters > Add';
		$data['title'] = 'Add';
		$data['errormess'] = '';
		$data['main_content'] = 'admin/newsletters/newsletters/add';
		$this->load->view('admin/template', $data);
	}
	function add_()
	{   
		$data['headingtop'] = 'Newsletter > Manage Newsletters > Add';
		$data['title'] = 'Add';
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required');	
		if($this->form_validation->run() == FALSE)
		{
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['errormess'] = '1';
		$data['main_content'] = 'admin/newsletters/newsletters/add';
		$this->load->view('admin/template', $data);
		} else {
		$data['errormess'] = '';
		$title = addslashes($this->input->post('title'));
		$content = addslashes($this->input->post('editor1'));
		$data = array(
               'title' => $title ,
               'isActive' => $this->input->post('isactive') ,
			   'content' => $content,
            );
		$this->db->insert('tblnewsletter', $data); 
		redirect(base_url().'admin/newsletters/', 'refresh');
		}
		

	}
	
	function edit($editid)
	{   
		$data['query'] = $this->db->query("Select * From tblnewsletter WHERE id = '$editid'");
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		
		$data['headingtop'] = 'CMS > Manage Newsletters > Edit';
		$data['title'] = 'Edit > ';
		$data['errormess'] = '';
		$data['main_content'] = 'admin/newsletters/newsletters/edit';
		$this->load->view('admin/template', $data);
	}
	
	function edit_($editid)
	{   
		$data['headingtop'] = 'CMS > Manage Newsletters > Edit';
		$data['title'] = 'Edit > ';
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required');	
		if($this->form_validation->run() == FALSE)
		{
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['errormess'] = '1';
		$data['main_content'] = 'admin/newsletters/nesletters/edit';
		$this->load->view('admin/template', $data);
		} else {
		$data['errormess'] = '';
		$title = addslashes($this->input->post('title'));
		$content = addslashes($this->input->post('editor1'));
		
		$data = array(
              'title' => $title ,
               'isactive' => $this->input->post('isactive') ,
			   'content' => $content,
            );

$this->db->where('id', $editid);
$this->db->update('tblnewsletter', $data); 

		redirect(base_url().'admin/newsletters/', 'refresh');
		}
}


	function bulk_actions()
	{
		$count = $_REQUEST['count'];

		$upop = $this->input->post('baction');
		
		
		if($upop == 'sta'){
	for($i=1;$i<=$count;$i++)
		{
		if($this->input->post('ch'.$i)) 
{
$ch = $this->input->post('ch'.$i);
$data = array(
              'isactive' => $this->input->post('isactive'.$i)
            );

$this->db->where('id', $ch);
$this->db->update('tblnewsletter', $data); 
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
$this->db->delete('tblnewsletter'); 
		}								
		}
		}
		
		
		
		redirect(base_url().'admin/newsletters/', 'refresh');
	}	
	
	
}
