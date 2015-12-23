<?php

class Cms extends Controller 
{
	function __construct()
	{
		parent::Controller();
	}
	function index($row=1)
	{
		$data['keyword'] = '';
		$data['filter'] = '';
		$data['query1']=$this->db->query("SELECT * FROM tblpages WHERE parent = '0' and isActive='1'");
		$data['headingtop'] = 'CMS';
		$data['title'] = 'Manage Pages';
		$data['curpage'] = $row;
		$data['range'] = 5;
		$data['trows']=$this->db->count_all('tblpages');
		$perpage = 20;
		$data['tpages'] = ceil($this->db->count_all('tblpages') / $perpage);
		// store data for being displayed on view file
		$offset = ($row - 1) * $perpage;
		$data['query']=$this->db->query("SELECT
			tblpages.title,
			tblpages.id,
			tblpages.seqno,
			tblpages.pagename,
			tblpages.isActive
			FROM
			tblpages");

// load 'testview' view
		$data['jsFilesArray'] =  array("libs/DataTables/jquery.dataTables.min.js","libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js","core/demo/DemoTableDynamic.js");
		$data['main_content'] = 'admin/cms/cms';
		$this->load->view('admin/template', $data); 
	}

	
	function page($row=1){
		$data['keyword'] = '';
		$data['filter'] = '';
		$data['query1']=$this->db->query("SELECT * FROM tblpages WHERE parent = '0' and isActive='1'");
		$data['headingtop'] = 'CMS';
		$data['title'] = 'Manage Pages';
		$data['curpage'] = $row;
		$data['range'] = 5;
		$data['trows']=$this->db->count_all('tblpages');
		$perpage = 20;
		$data['tpages'] = ceil($this->db->count_all('tblpages') / $perpage);
		// store data for being displayed on view file
		$offset = ($row - 1) * $perpage;
		$data['query']=$this->db->query("SELECT * FROM tblpages LIMIT ".$offset.", ".$perpage);

// load 'testview' view
		$data['main_content'] = 'admin/cms/cms';
		$this->load->view('admin/template', $data);

	}
	
	function delpage($editid)
	{   
		$table = array('tblpages');
		$this->db->where('id', $editid);
		$this->db->delete($table);
		
		redirect(base_url().'admin/cms/', 'refresh');
	}
	
	
	
	function addpage()
	{   
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['headingtop'] = 'CMS > Manage Pages > Add Page';
		$data['title'] = 'Add Page';
		$data['errormess'] = '';
		$data['query1']=$this->db->query("SELECT * FROM tblpages WHERE parent = '0' and isActive='1'");
		$data['main_content'] = 'admin/cms/addpage';
		$this->load->view('admin/template', $data);
	}
	function addpage_()
	{   
		$data['headingtop'] = 'CMS > Manage Pages > Add Page';
		$data['title'] = 'Add Page';
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required');	
		if($this->form_validation->run() == FALSE)
		{
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['errormess'] = '1';
		$data['main_content'] = 'admin/cms/addpage';
		$this->load->view('admin/template', $data);
		} else {
			$title = addslashes($this->input->post('title'));
			$content = addslashes($this->input->post('editor1'));
			$url = url_title($title);
			$query=$this->db->query("Select * From tblpages WHERE pagename = '$url'");
			if($query->num_rows() != 0){
				$hash = rand(1,1000);
				$url = $url.$hash;
			}
			
			
		$data['errormess'] = '';
		$data = array(
               'title' => $title ,
			   'parent' => $this->input->post('parent') ,
               'position' => $this->input->post('position') ,
               'isActive' => $this->input->post('isactive') ,
			   'ispublic' => $this->input->post('ispublic') ,
			   'seqno' => $this->input->post('seqno') ,
			   'content' => $content,
			   'pagename' => $url,
			  'meta_title' => addslashes($this->input->post('meta_title')),
			  'meta_keywords' => addslashes($this->input->post('meta_keywords')),
			  'meta_decrip' => addslashes($this->input->post('meta_decrip'))
        );
		$this->db->insert('tblpages', $data); 
		
		redirect(base_url().'admin/cms/', 'refresh');
		}
		

	}
	
	function editpage($editid)
	{   
		$data['query'] = $this->db->query("Select * From tblpages WHERE id = '$editid'");
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		
		$data['headingtop'] = 'CMS > Manage Pages > Edit Page';
		$data['title'] = 'Edit Page';
		$data['errormess'] = '';
		$data['main_content'] = 'admin/cms/editpage';
		$this->load->view('admin/template', $data);
	}
	
	function editpage_($editid)
	{   
		$data['headingtop'] = 'CMS > Manage Pages > Edit Page';
		$data['title'] = 'Edit Page';
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required');	
		if($this->form_validation->run() == FALSE)
		{
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['errormess'] = '1';
		$data['main_content'] = 'admin/cms/addpage';
		$this->load->view('admin/template', $data);
		} else {
			$data['errormess'] = '';
			$title = addslashes($this->input->post('title'));
			$content = addslashes(html_entity_decode($this->input->post('editor1')));
			$url =str_replace(' ', "-", strtolower($title));
			$query=$this->db->query("Select * From tblpages WHERE pagename = '$url' AND id != '$editid'");
			if($query->num_rows() != 0){
			$hash = rand(1,1000);
			$url = $url.$hash;
			}
		
		$data = array(
              'title' => $title ,
			  'parent' => $this->input->post('parent') ,
              'position' => $this->input->post('position') ,
              'isActive' => $this->input->post('isactive') ,
			  'ispublic' => $this->input->post('ispublic') ,
			  'seqno' => $this->input->post('seqno') ,
			  'content' => $content,
			  'pagename' => $url,
			  'meta_title' => addslashes($this->input->post('meta_title')),
			  'meta_keywords' => addslashes($this->input->post('meta_keywords')),
			  'meta_decrip' => addslashes($this->input->post('meta_decrip'))
        );

		$this->db->where('id', $editid);
		$this->db->update('tblpages', $data); 

	
		redirect(base_url().'admin/cms/', 'refresh');
		}
	}

	function update_status($id, $status){
	$data = array(
              'isActive' =>  $status
            );

$this->db->where('id', $id);
$this->db->update('tblpages', $data); 
redirect(base_url().'admin/cms/', 'refresh');
	}


	function bulk_actions($keyword=0)
	{
		
		
		//Bulk Actions Start
		$count = $this->input->post('count');
		$upop = $this->input->post('baction');
		if($upop == 'seq'){
	for($i=1;$i<=$count;$i++)
		{
		if($this->input->post('ch'.$i)) 
{
$ch = $this->input->post('ch'.$i);
$data = array(
              'seqno' => $this->input->post('seq'.$i)
            );

$this->db->where('id', $ch);
$this->db->update('tblpages', $data); 
		}								
		}
		}
		
		
		if($upop == 'sta'){
	for($i=1;$i<=$count;$i++)
		{
		if($this->input->post('ch'.$i)) 
{
$ch = $this->input->post('ch'.$i);
$data = array(
              'isActive' => $this->input->post('isactive'.$i)
            );

$this->db->where('id', $ch);
$this->db->update('tblpages', $data); 
		}								
		}
		}
		
		
		if($upop == 'ispub'){
	for($i=1;$i<=$count;$i++)
		{
		if($this->input->post('ch'.$i)) 
{
$ch = $this->input->post('ch'.$i);
$data = array(
              'ispublic' => $this->input->post('ispublic'.$i)
            );

$this->db->where('id', $ch);
$this->db->update('tblpages', $data); 
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
$this->db->delete('tblpages'); 
		}								
		}
		}
		//Bulk Actions END
		
		
		
		
		
		
			//Seacrh Start
		$issearch = $this->input->post('issearch');
		$row=1;
		$keyword = $this->input->post('search');
		$filter = $this->input->post('filter');
		$data['keyword'] = $this->input->post('search');
		$data['filter'] = $filter;
		$data['query1']=$this->db->query("SELECT * FROM tblpages WHERE parent = '0' and isActive='1'");
		$data['headingtop'] = 'CMS';
		$data['title'] = 'Manage Pages';
		$data['curpage'] = $row;
		$data['range'] = 5;
		$data['trows']=$this->db->count_all('tblpages');
		$perpage = 20;
		$data['tpages'] = ceil($this->db->count_all('tblpages') / $perpage);
		// store data for being displayed on view file
		$offset = ($row - 1) * $perpage;
		if($filter == '') {
		$data['query']=$this->db->query("SELECT * FROM tblpages WHERE title LIKE '%{$keyword}%' LIMIT ".$offset.", ".$perpage);
		} else {
		$data['query']=$this->db->query("SELECT * FROM tblpages WHERE title LIKE '%{$keyword}%' AND parent = '$filter' LIMIT ".$offset.", ".$perpage);	
		}
		// load 'testview' view
		$data['main_content'] = 'admin/cms/cms';
		$this->load->view('admin/template', $data);
		
		//Search End
			
		
		
	}	
}
