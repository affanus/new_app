<?php

class Admin_main extends Controller 
{
	function __construct()
	{
		parent::Controller();
		//$this->is_logged_in();
	}

	function dashboard()
	{
		$date_now = date ('Y-m-j');
		$data['date_now'] = $date_now;
		$newdate = strtotime ( '-1 month' , strtotime ( $date_now ) ) ;
		$newdate = date ( 'Y-m-j' , $newdate );
		$data['newdate'] = $newdate;
		/*$total_graph=$this->db->query("SELECT
							SUM(hits) AS hits,
							reports_total.date_r
							FROM
							reports_total
							WHERE
							reports_total.date_r >= '$newdate' AND
							reports_total.date_r <= '$date_now' 
							GROUP BY
							reports_total.date_r
							ORDER BY
							reports_total.date_r ASC");
							
		$top_products=$this->db->query("SELECT
							SUM(hits) AS hits, master_products.prod_name
							FROM
							reports_total
							INNER JOIN master_products ON reports_total.cat_id = master_products.prod_id
							WHERE
							reports_total.`level` = '5' 
							GROUP BY
							reports_total.date_r
							ORDER BY
							SUM(hits) DESC
							LIMIT 0 , 5
							");
		$data['top_products']=$top_products;
		
		
		$data['mall_count']=$this->db->count_all('mall');
		$data['stores_count']=$this->db->count_all('stores');
		$data['misc_count']=$this->db->count_all('misc');
		$data['kisoks_count']=$this->db->count_all('map_floor_kisoks');
		$data['mall_stories']=$this->db->count_all('mall_stories');
		
		$data['departments_count']=$this->db->count_all('master_departments');
		$data['categories_count']=$this->db->count_all('master_categories');
		$data['sub_categories_count']=$this->db->count_all('master_sub_categories');
		$data['sub_sub_categories_count']=$this->db->count_all('master_sub_sub_categories');
		$data['brands_count']=$this->db->count_all('master_brands');
		$data['master_products']=$this->db->count_all('master_products');
		
		$data['total_hits']=$this->db->count_all('reports_total');
		$data['subscriber_count']=$this->db->count_all('tblsubscribers');
		$data['admin_query']=$this->db->query("SELECT * FROM tbladmin LIMIT 0 , 3");
		
		$data['total_graph']=$total_graph;*/
		$data['jsFilesArray'] =  array("libs/moment/moment.min.js","libs/flot/jquery.flot.min.js","libs/flot/jquery.flot.time.min.js","libs/flot/jquery.flot.resize.min.js","libs/flot/jquery.flot.orderBars.js","libs/flot/jquery.flot.pie.js","libs/flot/curvedLines.js","libs/jquery-knob/jquery.knob.min.js","libs/sparkline/jquery.sparkline.min.js","libs/d3/d3.min.js","libs/d3/d3.v3.js","libs/rickshaw/rickshaw.min.js","core/demo/DemoDashboard.js");
		$data['main_content'] = 'admin/dashboard';
		$this->load->view('admin/template', $data);
	}
	
	function another_page() // just for sample
	{
		echo 'good. you\'re logged in.';
	}
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	
			die();		
			//$this->load->view('login_form');
		}		
	}	

}
