<?php

class Pages extends Controller {
	
	function __construct()
	{
		parent::Controller();
		$this->locale = $this->session->userdata('locale');
		if($this->locale==''){
			$this->locale='en';
			$this->session->set_userdata('locale','en');
		}	
		$this->footer_query=$this->db->query("SELECT * FROM manage_footer WHERE id ='1'");
		if($this->locale=='ru'){
			$this->footer_news_query=$this->db->query("SELECT
			news.image,
			news.posting_date,
			news_translations.title,
			news.page_name,
			news_translations.content
			FROM
			news
			INNER JOIN news_translations ON news.id = news_translations.news_id
			WHERE
			news.isactive = 1 AND
			news_translations.tr_key = 'ru'
			ORDER BY
			news.posting_date DESC
			LIMIT 0, 2");
			$this->hearder_query=$this->db->query("SELECT
			tblpages.id,
			tblpages.pagename,
			tblpages.icon_class,
			tblpages_tranlations.title
			FROM
			tblpages
			INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
			WHERE
			tblpages.parent = '0' AND
			tblpages.isActive = '1' AND
			tblpages_tranlations.tr_key = 'ru' AND
			(tblpages.position = 'handf' OR
			tblpages.position = 'header') 
			order by seqno asc");
			$this->footer_links_query=$this->db->query("SELECT tblpages.id,
			tblpages.pagename, tblpages_tranlations.title FROM tblpages INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id WHERE tblpages.isActive='1' and tblpages_tranlations.tr_key = 'ru' AND (tblpages.position='handf' OR tblpages.position = 'footer') order by seqno asc");
		}else if($this->locale=='go'){
			$this->footer_news_query=$this->db->query("SELECT
			news.image,
			news.posting_date,
			news.page_name,
			news_translations.title,
			news_translations.content
			FROM
			news
			INNER JOIN news_translations ON news.id = news_translations.news_id
			WHERE
			news.isactive = 1 AND
			news_translations.tr_key = 'go'
			ORDER BY
			news.posting_date DESC
			LIMIT 0, 2");
			$this->hearder_query=$this->db->query("SELECT
			tblpages.id,
			tblpages.pagename,
			tblpages.icon_class,
			tblpages_tranlations.title
			FROM
			tblpages
			INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
			WHERE
			tblpages.parent = '0' AND
			tblpages.isActive = '1' AND
			tblpages_tranlations.tr_key = 'go' AND
			(tblpages.position = 'handf' OR
			tblpages.position = 'header') 
			order by seqno asc");
			$this->footer_links_query=$this->db->query("SELECT tblpages.id,
			tblpages.pagename, tblpages_tranlations.title FROM tblpages INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id WHERE tblpages.isActive='1' and tblpages_tranlations.tr_key = 'go' AND (tblpages.position='handf' OR tblpages.position = 'footer') order by seqno asc");
		}else{
			$this->footer_news_query=$this->db->query("SELECT
			news.title,
			news.content,
			news.image,
			news.page_name,
			news.posting_date
			FROM
			news
			WHERE
			news.isactive = 1
			ORDER BY
			news.posting_date DESC
			LIMIT 0, 2");
			$this->hearder_query=$this->db->query("SELECT id, title, pagename, icon_class FROM tblpages WHERE parent = '0' and isActive='1' and (position='handf' OR position = 'header') order by seqno asc");
			$this->footer_links_query=$this->db->query("SELECT id, title, pagename FROM tblpages WHERE isActive='1' and (position='handf' OR position = 'footer') order by seqno asc");
		}
		
	}
	
	function index($pagename)
	{

		
		if($this->locale=='ru'){
			$page_query=$this->db->query("SELECT
				tblpages_tranlations.title,
				tblpages_tranlations.content,
				tblpages_tranlations.meta_decrip,
				tblpages_tranlations.meta_keywords,
				tblpages_tranlations.meta_title
				FROM
				tblpages
				INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
				WHERE
				tblpages.pagename = '$pagename' AND
				tblpages_tranlations.tr_key = 'ru'
			");			
			
		}else if($this->locale=='go'){
			$page_query=$this->db->query("SELECT
				tblpages_tranlations.title,
				tblpages_tranlations.content,
				tblpages_tranlations.meta_decrip,
				tblpages_tranlations.meta_keywords,
				tblpages_tranlations.meta_title
				FROM
				tblpages
				INNER JOIN tblpages_tranlations ON tblpages.id = tblpages_tranlations.page_id
				WHERE
				tblpages.pagename = '$pagename' AND
				tblpages_tranlations.tr_key = 'go'
			");	
		}else{
			$page_query=$this->db->query("SELECT
			tblpages.id,
			tblpages.title,
			tblpages.content,
			tblpages.meta_decrip,
			tblpages.meta_keywords,
			tblpages.meta_title
			FROM
			tblpages
			WHERE
			tblpages.pagename = '$pagename'
			");	
		}
		$row = $page_query->row(); 
		$data['meta_tilte']=stripslashes($row->meta_title);
		$data['meta_keywords']=stripslashes($row->meta_keywords);
		$data['meta_decription']=stripslashes($row->meta_decrip);	
		$data['pagecontent'] = stripslashes($row->content);
		$data['pageheading'] =  stripslashes($row->title);
		$data['pagename']= $pagename;
		$data['main_content'] = 'content';
		$data['locale']=$this->locale;
		$data['footer_query']=$this->footer_query;
		$data['footer_news_query']=$this->footer_news_query;
		$data['header_query']=$this->hearder_query;
		$data['footer_links_query'] = $this->footer_links_query;
		$this->load->view('includes/template', $data);	
		
		
	}
	
	


}

