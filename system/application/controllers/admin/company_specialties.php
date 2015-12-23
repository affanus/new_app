<?

class Company_specialties extends Controller 
{
	
	var $heading_top;
	var $title;
	var $main_content_mange;
	var $main_content_add;
	var $main_content_edit;
	var $add_title;
	var $edit_title;
	var $controler_name;
	var $tablename;
	
	
	function __construct()
	{
		parent::Controller();
		$this->heading_top='Manage';
		$this->title='Company Specialties';
		$this->main_content_mange='admin/manage/company_specialties/mange';
		$this->main_content_add='admin/manage/company_specialties/add';
		$this->main_content_edit='admin/manage/company_specialties/edit';
		$this->add_title='Add Company Specialty';
		$this->edit_title='Edit Company Specialty';
		$this->controler_name='company_specialties';
		$this->tablename='company_specialties';
		
	}
	function index($row=1)
	{
	
		// store data for being displayed on view file
		$data['headingtop'] = $this->heading_top;
		$data['title'] = $this->title;
		$data['controler_name']=$this->controler_name;
		$data['curpage'] = $row;

		$data['range'] = 50;
		
		$data['trows']=$this->db->count_all($this->tablename);
		
		$perpage = 500;
		
		$data['tpages'] = ceil($this->db->count_all($this->tablename) / $perpage);
		
		
		
		$offset = ($row - 1) * $perpage;
		
		$data['query']=$this->db->query("SELECT * From ".$this->tablename);

		

		$data['jsFilesArray'] =  array("libs/DataTables/jquery.dataTables.min.js","libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js","core/demo/DemoTableDynamic.js");

		$data['main_content'] = $this->main_content_mange;
		$data['add_link']=$this->add_title;
		$this->load->view('admin/template', $data); 
	}
	
	
	function page($row=1){
		if($this->uri->segment(4)!=''){
		$row = $this->uri->segment(4);}
		
		
		
		
		$data['headingtop'] = $this->heading_top;
		$data['title'] = $this->title;
		
		$data['curpage'] = $row;

		$data['range'] = 50;
		
		$data['trows']=$this->db->count_all($this->tablename);
		
		$perpage = 50;
		
		$data['tpages'] = ceil($this->db->count_all($this->tablename) / $perpage);
		
		
		
		$offset = ($row - 1) * $perpage;
		
		$data['query']=$this->db->query("SELECT * From ".$this->tablename."  LIMIT ".$offset.", ".$perpage);



		// load 'testview' view

		$data['main_content'] = $this->main_content_mange;
		$data['add_link']=$this->add_title;
		$data['controler_name']=$this->controler_name;
		$this->load->view('admin/template', $data); 
	
	}

	function add()

	{   
		$data['controler_name']=$this->controler_name;
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');

        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';

        $this->ckeditor->ToolbarSet = 'Basic';
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;
		$data['title'] = $this->add_title;
		$data['errormess'] = '';
		
		$data['main_content'] = $this->main_content_add;

		$this->load->view('admin/template', $data);

	}
	
	
	function add_action()

	{   
		$data['controler_name']=$this->controler_name;
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;

		$data['title'] = $this->add_title;

		$this->load->library('form_validation');

		// field name, error message, validation rules
		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		

		if($this->form_validation->run() == FALSE)

		{

		$data['errormess'] = '1';
		$data['main_content'] = $this->main_content_add;

		$this->load->view('admin/template', $data);

		} else {

		$data['errormess'] = '';

		
		$data = array(
			'title' => addslashes($this->input->post('title')) ,
			'isactive' => $this->input->post('isactive') ,
           	'details' => addslashes($this->input->post('editor1'))
        );
		
		$this->db->insert($this->tablename, $data); 
		
		
		
		
		redirect('admin/'.$this->controler_name.'/', 'refresh');

		}

		



	}
	
	
	
	function del($editid)

	{   
	
		
		$table = array($this->tablename);

		$this->db->where('id', $editid);

		$this->db->delete($table);



		redirect('admin/'.$this->controler_name.'/', 'refresh');

	}
	
	function update_status($id, $status){
		
		$data = array('isactive' =>  $status);
		
		$this->db->where('id', $id);
		$this->db->update($this->tablename, $data); 
		redirect('admin/'.$this->controler_name.'/', 'refresh');
	}
	
	
	
	function edit($editid)

	{   
		$data['controler_name']=$this->controler_name;
		$data['query'] = $this->db->query("Select * From ".$this->tablename." WHERE id = '$editid'");
		

		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->edit_title;

		$data['title'] = $this->edit_title;

		$data['errormess'] = '';

		$data['main_content'] = $this->main_content_edit;

		$this->load->view('admin/template', $data);

	}
	
	
	
	function edit_action($editid)

	{   
		$data['controler_name']=$this->controler_name;
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->edit_title;

		$data['title'] = $this->edit_title;
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('title', 'Title', 'trim|required');

		// field name, error message, validation rules


		if($this->form_validation->run() == FALSE)

		{
		
		$data['query'] = $this->db->query("Select * From ".$this->tablename." WHERE id = '$editid'");
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
		
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';

        $this->ckeditor->ToolbarSet = 'Basic';

		$data['errormess'] = '1';
		
		$data['main_content'] = $this->main_content_edit;

		$this->load->view('admin/template', $data);

		} else {

		$data['errormess'] = '';

		$title = addslashes($this->input->post('title'));
		
		$data = array(
			'title' => addslashes($this->input->post('title')) ,
			'isactive' => $this->input->post('isactive') ,
           	'details' => addslashes($this->input->post('editor1'))
        );
		



		$this->db->where('id', $editid);

		$this->db->update($this->tablename, $data); 

		
		
		redirect('admin/'.$this->controler_name.'/', 'refresh');

		}

	}

	


}	


?>