<?php

class Admin_rights extends Controller 
{
	function __construct()
	{
		parent::Controller();
	}
	function index($row=1)
	{
		$data['headingtop'] = 'Rights > Manage Admin Users Rights';
		$data['title'] = 'Manage Admin Users';
		$data['curpage'] = $row;
		$data['range'] = 20;
		$data['trows']=$this->db->count_all('tbladmin');
		$perpage = 10;
		$data['tpages'] = ceil($this->db->count_all('tbladmin') / $perpage);
		// store data for being displayed on view file
		$offset = ($row - 1) * $perpage;
		$data['query']=$this->db->query("SELECT * FROM tbladmin");
		$data['jsFilesArray'] =  array("libs/DataTables/jquery.dataTables.min.js","libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js","core/demo/DemoTableDynamic.js");
		$data['main_content'] = 'admin/rights/admin_rights/admin_rights';
		$this->load->view('admin/template', $data); 
	}

	
function page($row=1){
$data['headingtop'] = 'Rights > Manage Admin Users Rights';
$data['title'] = 'Manage Admin Users Rights';
$data['curpage'] = $row;
$data['range'] = 20;
$data['trows']=$this->db->count_all('tbladmin');
$perpage = 10;
$data['tpages'] = ceil($this->db->count_all('tbladmin') / $perpage);
// store data for being displayed on view file
$offset = ($row - 1) * $perpage;
$data['query']=$this->db->query("SELECT * FROM tbladmin LIMIT ".$offset.", ".$perpage);

// load 'testview' view
		$data['main_content'] = 'admin/rights/admin_rights/admin_rights';
		$this->load->view('admin/template', $data); 

}

	function update_status($id, $status){
		$data = array(
              'isActive' =>  $status
            );

		$this->db->where('adminid', $id);
		$this->db->update('tbladmin', $data); 
		redirect(base_url().'admin/admin_rights', 'refresh');
	}
	

	function add()
	{   
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['headingtop'] = 'Rights > Admin User Rights > Add';
		$data['title'] = 'Add';
		$data['errormess'] = '';
		$data['main_content'] = 'admin/rights/admin_rights/add';
		$this->load->view('admin/template', $data);
	}
	function add_()
	{   
		$data['headingtop'] = 'Rights > Admin User Rights > Add';
		$data['title'] = 'Add';
		$this->load->library('form_validation');
		// field name, error message, validation rules
		$this->form_validation->set_rules('adminid', 'Admin ID', 'trim|required');	
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');	
		if($this->form_validation->run() == FALSE)
		{
			$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
			$this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
			$this->ckeditor->ToolbarSet = 'Basic';
			$data['errormess'] = '1';
			$data['main_content'] = 'admin/rights/admin_rights/add';
			$this->load->view('admin/template', $data);
		} else {
			
			$this->db->where('adminid', $this->input->post('adminid'));
			$query = $this->db->get('tbladmin');
			if($query->num_rows == 1)
			{
				$data['main_content'] = 'admin/rights/admin_rights/add';
				$data['errormess'] = '1';
				$this->load->view('admin/template', $data);
				
			}else {
				$data['errormess'] = '';
				$title = addslashes($this->input->post('adminid'));
				$this->load->model('Logo_upload');
				$profilepic = $this->Logo_upload->do_upload('profilepic');
				$data = array(
					   'adminid' => $title ,
					   'email' => $this->input->post('email') ,
					   'fname' => $this->input->post('fname') ,
					   'lname' => $this->input->post('lname') ,
					   'password' => md5($this->input->post('password')),
					   'isactive' => $this->input->post('isactive'),
					   'image' => $profilepic
					);
				$this->db->insert('tbladmin', $data);
				
				$inid = $this->db->insert_id();
				$adminid = $title;
				$query = $this->db->query("SELECT * FROM tbltabs");
				if ($query->num_rows() > 0)
				{
					foreach ($query->result() as $row){
						$data = array(
						   'adminid' => $adminid ,
						   'tabid' => $row->tabid ,
						   'isactive' => '1'
						);
						$this->db->insert('tbladminrights', $data);
					} 	
				}
	   
	   
	  //tbltabsdetails insert START
				$query = $this->db->query("SELECT * FROM tbltabdetails");
				if ($query->num_rows() > 0) {
					foreach ($query->result() as $row) {
						$data = array(
						   'adminid' => $adminid ,
						   'tabdetailid' => $row->tabdetailid ,
						   'tabid' => $row->tabid ,
						   'isactive' => '1'
						);
						$this->db->insert('tbladminrightdetails', $data);
					}//tbltabsdetails insert END 
				} 
 
			redirect(base_url().'admin/admin_rights/assign_rights/'.$adminid, 'refresh');	
			}	
		}
	}
	
	function del($editid)
	{  
		$table = array('tbladminrightdetails');
		$this->db->where('adminid', $editid);
		$this->db->delete($table);
	
		$table = array('tbladminrights');
		$this->db->where('adminid', $editid);
		$this->db->delete($table);
		
		$query = $this->db->query("Select image From tbladmin WHERE adminid = '$editid'");
		$row = $query->row();	
		unlink(realpath(APPPATH . '../../_images/profile_images/thumb/'.$row->image));
		unlink(realpath(APPPATH . '../../_images/profile_images/orignal/'.$row->image));
		
		$table = array('tbladmin');
		$this->db->where('adminid', $editid);
		$this->db->delete($table);
	
		redirect(base_url().'admin/admin_rights/', 'refresh');
	}
	
	function edit($editid) {
		$data['headingtop'] = 'Rights > Admin User Rights > Add';
		$data['title'] = 'Add';
		$data['errormess'] = '';
		$data['query'] = $this->db->query("Select * From tbladmin WHERE adminid = '$editid'");
		$data['query_rights'] = $this->db->query("SELECT * FROM tbladminrights, tbltabs WHERE tbladminrights.tabid = tbltabs.tabid AND tbladminrights.adminid =  '$editid'  order by tbltabs.seqno asc");
		$data['main_content'] = 'admin/rights/admin_rights/edit';
		$data['adminid'] = $editid;
		$this->load->view('admin/template', $data);	
	}
	
	function edit_($editid) {
		$title = addslashes($this->input->post('adminid'));
		$data_admin = array(
			'adminid' => $title ,
			'email' => $this->input->post('email') ,
			'fname' => $this->input->post('fname') ,
			'lname' => $this->input->post('lname') ,
			'isactive' => $this->input->post('isactive')
		);
		
		if($this->input->post('password')!=''):
			$data_admin['password']=md5($this->input->post('password'));
		endif;
		
		if($_FILES["profilepic"]["tmp_name"]!=''):
			unlink(realpath(APPPATH . '../../_images/profile_images/thumb/'.$this->input->post('ppold')));
			unlink(realpath(APPPATH . '../../_images/profile_images/orignal/'.$this->input->post('ppold')));
			$this->load->model('Logo_upload');
			$profilepic = $this->Logo_upload->do_upload('profilepic');
			$data_admin['image']=$profilepic;
		endif;

		
		$this->db->where('adminid', $editid);
		$this->db->update('tbladmin', $data_admin); 
		
		$tc = $this->input->post('tc');
		for($i=1;$i<=$tc;$i++)
		{
			$tab = $this->input->post($i);
			if($this->input->post('ch'.$i) == TRUE){
				$isset = 1; 
			} else {
				$isset = 0;	
			}
			
			$data = array('isactive' => $isset);
			$this->db->where('id', $tab);
			$this->db->update('tbladminrights', $data); 
			
//echo '<br>'.$this->input->post($i);

	
			$stc = $this->input->post('stc'.$i);
			$stc = $stc - 1;
			
			for($j=1;$j<=$stc;$j++)
			{
				$tab2 = $this->input->post($i.'bc'.$j);
				if($this->input->post('ch'.$i.'bc'.$j) == TRUE){
					$isset2 = 1; 
				} else {
					$isset2 = 0;	
				}
				
				$data2 = array('isactive' => $isset2);
				$this->db->where('tabdetailid', $tab2);
				$this->db->where('adminid', $editid);
				$this->db->update('tbladminrightdetails', $data2); 
//echo '^'.$this->input->post($i.'bc'.$j);										
			}//Second for loop									
		}//first for loop
		redirect(base_url().'admin/admin_rights/', 'refresh');
	}
	
function assign_rights($editid)
	{   
		$data['query'] = $this->db->query("SELECT * FROM tbladminrights, tbltabs WHERE tbladminrights.tabid = tbltabs.tabid AND tbladminrights.adminid =  '$editid'  order by tbltabs.seqno asc");
		$data['adminid'] = $editid;
		$data['headingtop'] = 'Rights > Manage Admin User Rights > Assign Rights';
		$data['title'] = 'Assign Rights';
		$data['errormess'] = '';
		$data['main_content'] = 'admin/rights/admin_rights/assign_rights';
		$this->load->view('admin/template', $data);
	}
	
		function assign_rights_action($editid)
	{
		$tc = $this->input->post('tc');
	for($i=1;$i<=$tc;$i++)
		{
$tab = $this->input->post($i);
if($this->input->post('ch'.$i) == TRUE){
$isset = 1; } else {
$isset = 0;	
}
$data = array(
              'isactive' => $isset
            );
$this->db->where('id', $tab);
$this->db->update('tbladminrights', $data); 
//echo '<br>'.$this->input->post($i);

	
		$stc = $this->input->post('stc'.$i);
		$stc = $stc -1;
		for($j=1;$j<=$stc;$j++)
		{
$tab2 = $this->input->post($i.'bc'.$j);
if($this->input->post('ch'.$i.'bc'.$j) == TRUE){
$isset2 = 1; } else {
$isset2 = 0;	
}
$data2 = array(
              'isactive' => $isset2
            );
$this->db->where('tabdetailid', $tab2);
$this->db->where('adminid', $editid);
$this->db->update('tbladminrightdetails', $data2); 
//echo '^'.$this->input->post($i.'bc'.$j);										
		}//Second for loop									
		}//first for loop
	redirect(base_url().'admin/admin_rights/', 'refresh');		
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
$this->db->update('tbladmin', $data); 
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
$this->db->delete('tbladmin'); 
		}								
		}
		}
		
		
		
		redirect(base_url().'admin/admin_rights/', 'refresh');
	}	
	
	
}
