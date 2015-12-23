<?php

class Website_settings extends Controller 
{
	var $controler_name;
	function __construct()
	{
		parent::Controller();
		$this->controler_name='website_settings';
		
	}
	function index($row=1)
	{
$data['headingtop'] = 'Settings > Manage Settings';
$data['title'] = 'Manage Settings';

$data['query']=$this->db->query("SELECT * FROM tblsettings");
$data['controler_name']=$this->controler_name;
// load 'testview' view

$data['errormess'] = '';
		$data['main_content'] = 'admin/settings/website_settings/website_settings';
		$this->load->view('admin/template', $data); 
	}

	


	function add()
	{   
		$this->load->library('ckeditor',base_url() . 'system/plugins/ckeditor/');
        $this->ckeditor->basePath = base_url(). 'system/plugins/ckeditor/';
        $this->ckeditor->ToolbarSet = 'Basic';
		$data['headingtop'] = 'Settings > Website Settings > Add';
		$data['title'] = 'Add';
		$data['errormess'] = '';
		$data['main_content'] = 'admin/settings/website_settings/add';
		$this->load->view('admin/template', $data);
	}
	function add_action()
	{   
		
		$this->load->library('form_validation');
		// field name, error message, validation rules
			
		
		$data['errormess'] = '';
		
		$data = array(
               'supportemail' => $this->input->post('supportemail') ,
               'salesemail' => $this->input->post('salesemail') ,
			   'contact' => $this->input->post('contact') ,
			   'advert' => $this->input->post('advert') ,
			   'coupons_status' => $this->input->post('coupons_status') ,
			   'saleitem_status' => $this->input->post('saleitem_status') ,
			   'happy_status' => $this->input->post('happy_status') 
            );
		$this->db->where('id', '1');
		$this->db->update('tblsettings', $data); 
		
		if($_FILES['coupons_icon']['name']!=''):
		
		$path=realpath(APPPATH . '../../_images/icons');
		$newimgname=rand().$_FILES['coupons_icon']['name'];
		$img_path=$path. '/' . $newimgname;
		//echo $img_path;
		move_uploaded_file($_FILES['coupons_icon']["tmp_name"],$img_path);
		$data = array(
				'coupons_icon' => $newimgname				
 
            );
		$this->db->where('id', '1');
		$this->db->update('tblsettings', $data); 
		
		endif;
		
		
		if($_FILES['saleitem_icon']['name']!=''):
		
		$path=realpath(APPPATH . '../../_images/icons');
		$newimgname=rand().$_FILES['saleitem_icon']['name'];
		$img_path=$path. '/' . $newimgname;
		//echo $img_path;
		move_uploaded_file($_FILES['saleitem_icon']["tmp_name"],$img_path);
		$data = array(
				'saleitem_icon' => $newimgname				
 
            );
		$this->db->where('id', '1');
		$this->db->update('tblsettings', $data); 
		
		endif;
		
		
		if($_FILES['happy_icon']['name']!=''):
		
		$path=realpath(APPPATH . '../../_images/icons');
		$newimgname=rand().$_FILES['happy_icon']['name'];
		$img_path=$path. '/' . $newimgname;
		//echo $img_path;
		move_uploaded_file($_FILES['happy_icon']["tmp_name"],$img_path);
		$data = array(
				'happy_icon' => $newimgname				
 
            );
		$this->db->where('id', '1');
		$this->db->update('tblsettings', $data); 
		
		endif;
		
		

		redirect(base_url().'admin/website_settings/', 'refresh');
		
		

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
              'status' => $this->input->post('isactive'.$i)
            );

$this->db->where('id', $ch);
$this->db->update('tblsettings', $data); 
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
$this->db->delete('tblsettings'); 
		}								
		}
		}
		
		
		
		redirect(base_url().'admin/website_settings/', 'refresh');
	}	
	
	
}
