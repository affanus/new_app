<?php

class Subscribers extends Controller 
{
	function __construct()
	{
		parent::Controller();
	}
	function index($row=1)
	{
$data['headingtop'] = 'Newsletters > Manage Subscribers';
$data['title'] = 'Manage Subscribers';
$data['curpage'] = $row;
$data['range'] = 20;
$data['trows']=$this->db->count_all('tblsubscribers');
$perpage = 10;
$data['tpages'] = ceil($this->db->count_all('tblsubscribers') / $perpage);
// store data for being displayed on view file
$offset = ($row - 1) * $perpage;
$data['query']=$this->db->query("SELECT * FROM tblsubscribers LIMIT ".$offset.", ".$perpage);

// load 'testview' view
		$data['main_content'] = 'admin/newsletters/subscribers/subscribers';
		$this->load->view('admin/template', $data); 
	}

	
function page($row=1){
$data['headingtop'] = 'Newsletters > Manage Subscribers';
$data['title'] = 'Manage Subscribers';
$data['curpage'] = $row;
$data['range'] = 20;
$data['trows']=$this->db->count_all('tblsubscribers');
$perpage = 10;
$data['tpages'] = ceil($this->db->count_all('tblsubscribers') / $perpage);
// store data for being displayed on view file
$offset = ($row - 1) * $perpage;
$data['query']=$this->db->query("SELECT * FROM tblsubscribers LIMIT ".$offset.", ".$perpage);

// load 'testview' view
		$data['main_content'] = 'admin/newsletters/subscribers/subscribers';
		$this->load->view('admin/template', $data);

}

	function download_csv(){
		$this->load->helper('url');
        $this->load->helper('csv');
		$trows=$this->db->count_all('tblsubscribers');
		$query=$this->db->query("SELECT name, email FROM tblsubscribers ");
		query_to_csv($query,TRUE,realpath(APPPATH . '../../csv').'/subscribers_'.date('dMy').'.csv');
	}
	
	function del($editid)
	{   
	$table = array('tblsubscribers');
$this->db->where('id', $editid);
$this->db->delete($table);

redirect(base_url().'admin/subscribers/', 'refresh');
	}

	function add()
	{   
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['headingtop'] = 'Newsletter > Manage Subscribers > Add';
		$data['title'] = 'Add';
		$data['errormess'] = '';
		$data['main_content'] = 'admin/newsletters/subscribers/add';
		$this->load->view('admin/template', $data);
	}
	function add_()
	{   
		$data['headingtop'] = 'Newsletter > Manage Subscribers > Add';
		$data['title'] = 'Add';
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Name', 'trim|required');	
		$this->form_validation->set_rules('email', 'Email', 'trim|required');	
		if($this->form_validation->run() == FALSE)
		{
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['errormess'] = '1';
		$data['main_content'] = 'admin/newsletters/subscribers/add';
		$this->load->view('admin/template', $data);
		} else {
		$data['errormess'] = '';
		$name = addslashes($this->input->post('title'));
		$data = array(
               'name' => $name ,
               'isactive' => $this->input->post('isactive') ,
			   'email' => $this->input->post('email') ,
            );
		$this->db->insert('tblsubscribers', $data); 
		redirect(base_url().'admin/subscribers/', 'refresh');
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
$this->db->update('tblsubscribers', $data); 
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
$this->db->delete('tblsubscribers'); 
		}								
		}
		}
		
		
		
		redirect(base_url().'admin/subscribers/', 'refresh');
	}	
	
	
}
