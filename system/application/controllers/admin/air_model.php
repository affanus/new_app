<?

class Air_model extends Controller 
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
		$this->title='Aircraft Model';
		$this->main_content_mange='admin/manage/air_model/mange';
		$this->main_content_add='admin/manage/air_model/add';
		$this->main_content_edit='admin/manage/air_model/edit';
		$this->add_title='Add Aircraft Model';
		$this->edit_title='Edit Aircraft Model';
		$this->controler_name='air_model';
		$this->tablename='aircraft_model';
		
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
		
		$data['query']=$this->db->query("SELECT
				aircraft_model.id,
				aircraft_model.title,
				aircraft_model.isactive,
				aircraft_type.title AS type_title,
				aircraft_manufacturer.title AS man_title
				FROM
				aircraft_model
				INNER JOIN aircraft_type ON aircraft_model.type_id = aircraft_type.id
				INNER JOIN aircraft_manufacturer ON aircraft_type.man_id = aircraft_manufacturer.id");

		

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
		$data['query_aircraft_man']=$this->db->query("SELECT
			aircraft_type.id,
			aircraft_type.title,
			aircraft_manufacturer.title AS man_title
			FROM
			aircraft_type
			INNER JOIN aircraft_manufacturer ON aircraft_type.man_id = aircraft_manufacturer.id where aircraft_type.isactive=1");
			
		$data['headingtop'] = $this->heading_top.' > '.$this->title.' > '. $this->add_title;
		$data['title'] = $this->add_title;
		$data['errormess'] = '';
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js");
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
		$this->form_validation->set_rules('title', 'Aircraft Category', 'trim|required');
		

		if($this->form_validation->run() == FALSE)

		{
			$data['query_aircraft_man']=$this->db->query("SELECT
			aircraft_type.id,
			aircraft_type.title,
			aircraft_manufacturer.title AS man_title
			FROM
			aircraft_type
			INNER JOIN aircraft_manufacturer ON aircraft_type.man_id = aircraft_manufacturer.id where aircraft_type.isactive=1");
			$data['jsFilesArray'] =  array("libs/select2/select2.min.js");
			$data['errormess'] = '1';
			$data['main_content'] = $this->main_content_add;
	
			$this->load->view('admin/template', $data);

		} else {

			$data['errormess'] = '';
	
			
			$data = array(
				'title' => addslashes($this->input->post('title')) ,
				'isactive' => $this->input->post('isactive') ,
				'details' => addslashes($this->input->post('editor1')),
				'type_id' => $this->input->post('type_id') 
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
		$data['query_aircraft_man']=$this->db->query("SELECT
			aircraft_type.id,
			aircraft_type.title,
			aircraft_manufacturer.title AS man_title
			FROM
			aircraft_type
			INNER JOIN aircraft_manufacturer ON aircraft_type.man_id = aircraft_manufacturer.id where aircraft_type.isactive=1");
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js");
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
		$data['query_aircraft_man']=$this->db->query("SELECT
			aircraft_type.id,
			aircraft_type.title,
			aircraft_manufacturer.title AS man_title
			FROM
			aircraft_type
			INNER JOIN aircraft_manufacturer ON aircraft_type.man_id = aircraft_manufacturer.id where aircraft_type.isactive=1");
		$data['query'] = $this->db->query("Select * From ".$this->tablename." WHERE id = '$editid'");
		$data['jsFilesArray'] =  array("libs/select2/select2.min.js");



		$data['errormess'] = '1';
		
		$data['main_content'] = $this->main_content_edit;

		$this->load->view('admin/template', $data);

		} else {

		$data['errormess'] = '';

		
		$data = array(
				'title' => addslashes($this->input->post('title')) ,
				'isactive' => $this->input->post('isactive') ,
				'details' => addslashes($this->input->post('editor1')),
				'type_id' => $this->input->post('type_id') 
			);
		



		$this->db->where('id', $editid);

		$this->db->update($this->tablename, $data); 

		
		
		redirect('admin/'.$this->controler_name.'/', 'refresh');

		}

	}

	


}	


?>